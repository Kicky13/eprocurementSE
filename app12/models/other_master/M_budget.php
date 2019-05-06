<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_budget extends MY_Model
{
    protected $table = 'm_budget';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('setting/M_master_costcenter')
            ->model('setting/M_currency')
            ->helper(array('array'))
            ->model('setting/M_master_acc_sub');
    }

    public function update($condition, $data) {
        $this->db->where('id_costcenter', $condition['costcenter_id'])
            ->where('id_accsub', $condition['accsub_id'])
            ->update($this->table, $data);
    }

    public function findByCostCenter($costcenter_id, $with = null)
    {
        $m_costcenter = 'm_costcenter';
        $m_currency = $this->M_currency->getTable(); //'m_currency';
        $m_accsub = $this->M_master_acc_sub->getTable(); //'m_accsub';

        if ($with == 'costcenter_only') {
            $this->db->where("{$this->table}.id_accsub", '');
        } else if ($with == 'accsubsidiary_only') {
            $this->db->where("{$this->table}.id_accsub !=", '');
        }

        $res = $this->db->select([
                "{$this->table}.*",
                "{$m_costcenter}.COSTCENTER_DESC",
                "{$m_costcenter}.COSTCENTER_ABR",
                "{$m_accsub}.ACCSUB_DESC",
                "{$m_currency}.CURRENCY",
                "{$m_currency}.DESCRIPTION CURRENCY_DESC",
            ])
            ->where("{$this->table}.id_costcenter", $costcenter_id)
            ->join($m_costcenter, "{$m_costcenter}.ID_COSTCENTER = {$this->table}.id_costcenter")
            ->join($m_accsub, "{$m_accsub}.COSTCENTER = {$this->table}.id_costcenter
                AND {$m_accsub}.ID_ACCSUB = {$this->table}.id_accsub", 'left')
            ->join($m_currency, "{$m_currency}.ID = {$this->table}.id_currency")
            ->order_by("{$this->table}.id_costcenter, {$this->table}.id_accsub")
            ->get($this->table);

        return $res->result();
    }

    /**
    * If: E = Available budget
    *     A = Plan budget
    *     B = Booking budget, total transaksi di MSR yang belum jadi PO
    *     C = Commit budget, total transaksi PO yang belum di-GR / Invoice
    *     D = Actual, total actual GR / Invoice di JDE
    * then: E = A - ( B + C + D )
    * 
    * @param 
    */
    public function calculateAvailableBudget($planned, $booked, $committed, $actual)
    {
        return $planned - ( $booked + $committed + $actual );
    }

    /**
    * Get status of budget by comparing available budget to booking amount
    * 
    * @param float $available_budget
    * @param float $booking_amount
    * @return int -1 means insufficient
    */
    public function statusBudget($available_budget, $booking_amount)
    {
        $budget = (float) $available_budget - (float) $booking_amount;
        return ( $budget > 0 ? 1 : ( $budget < 0 ? -1 : 0 ) );
    }

    public function getActualBudget($cost_center, $account_subsidiary = '')
    {
        // ambil dari JDE. sementara dummy data
        return 0;  
    }

    /**
    * Committed budget, PO which is not GR'ed/Invoiced yet 
    * @param string $cost_center
    * @param string $account_subsidiary
    * @return float amount
    */
    public function getCommitBudget($cost_center, $account_subsidiary = '')
    {
        $this->load->model('procurement/M_msr_item')
            ->model('procurement/M_purchase_order')
            ->model('procurement/M_purchase_order_detail');

        $msr_item_table = $this->M_msr_item->getTable();
        $po_table = $this->M_purchase_order->getTable();
        $po_detail_table = $this->M_purchase_order_detail->getTable();
        /*
        SELECT pod.total_price_base, msr_item.id_costcenter, msr_item.id_accsub
        from t_purchase_order po
        join t_purchase_order_detail pod on pod.po_id = po.id
        join t_msr_item msr_item on msr_item.line_item = pod.msr_item_id
        */
        $this->db->select("SUM({$po_detail_table}.total_price_base) as committedBudget", false)
            ->from($po_table)
            ->join($po_detail_table, "{$po_detail_table}.po_id = {$po_table}.id")
            ->join($msr_item_table, "$msr_item_table.line_item = {$po_detail_table}.msr_item_id")
            ->where($msr_item_table.'.id_costcenter', $cost_center);

        $group_by = ["$msr_item_table.id_costcenter"];
        if ($account_subsidiary) {
            $this->db->where($msr_item_table.'.id_accsub', $account_subsidiary);
            $group_by[] = "$msr_item_table.id_accsub";
        }

        return @$this->db->group_by($group_by)->get()->result()[0]->committedBudget ?: 0;
    }

    public function getPlanBudget($cost_center, $account_subsidiary = '')
    {
        // get all budget in a costcenter
        $budget = $this->db->from($this->table)
            ->where('id_costcenter', $cost_center)
            ->get()
            ->result();

        // check whether all cost center is 0
        $budget_subsidiary = array_filter($budget, function($costcenter) {
            return $costcenter->id_accsub != '' && $costcenter->amount != 0;
        });

        $use_method = count($budget_subsidiary) > 0 ? 'accsub' : 'costcenter';

        // if we have account subsidiary set, then use it
        if ($use_method == 'accsub') {
            if ($account_subsidiary == '') { // find total per cost-center basis
                // total amount of all accounts in a cost center
                $total = array_reduce($budget, function($result, $costcenter) {
                    $result += $costcenter->id_accsub != '' ? $costcenter->amount : 0;

                    return $result;
                });
                
                return $total;
            }

            // find per cost-center per account
            $found = array_filter($budget, function($costcenter) use ($account_subsidiary) {
                return $costcenter->id_accsub == $account_subsidiary;
            });

            if (count($found) > 0) {
                return current($found)->amount;
            }
            // budget not found
            return 0;
        }

        // $use_method == 'costcenter'

        // impossible to get amount per cost center per account
        if ($account_subsidiary != '') {
            return 0;
        }

        // else, use costcenter (with id_accsub == '') value
        $found = array_filter($budget, function($costcenter) {
            return $costcenter->id_accsub == '';
        });

        if (count($found) > 0) {
            return current($found)->amount;
        }

        // budget not found
        return 0;
    }

    /**
    * Booking budget, total transaksi di MSR yang belum jadi PO
    * @param string $cost_center
    * @param string $account_subsidiary
    * @return float amount
    */
    public function getBookingBudget($cost_center, $account_subsidiary = '')
    {

        $this->load->model('procurement/M_msr')
            ->model('procurement/M_msr_item')
            ->model('procurement/M_purchase_order')
            ->model('procurement/M_purchase_order_detail');

        $msr_table = $this->M_msr->getTable();
        $msr_item_table = $this->M_msr_item->getTable();
        $po_table = $this->M_purchase_order->getTable();
        $po_detail_table = $this->M_purchase_order_detail->getTable();

        $rejected_msr = $this->M_msr->getRejected();
        $rejected_msr = array_pluck($rejected_msr, 'msr_no');

        $this->db->select("SUM(
              {$msr_item_table}.qty * {$msr_item_table}.priceunit_base
          ) as bookedBudget", false) // priceunit_base
          ->from($msr_table)
          ->join($msr_item_table, $msr_item_table.'.msr_no = '.$msr_table.'.msr_no')
          ->join($po_table, "$po_table.msr_no = {$msr_table}.msr_no", 'left')
          ->join($po_detail_table, "$po_detail_table.po_id = {$po_table}.id
            and {$po_detail_table}.msr_item_id = {$msr_item_table}.line_item", 'left')
          ->where("$po_detail_table.id IS NULL") // where MSR item has no PO yet
          ->where($msr_item_table.'.id_costcenter', $cost_center);
        
        if ($rejected_msr) {
          $this->db->where_not_in("$msr_table.msr_no", $rejected_msr);
        }

        $group_by = ["$msr_item_table.id_costcenter"];
        if ($account_subsidiary) {
          $this->db->where($msr_item_table.'.id_accsub', $account_subsidiary);
          $group_by[] = "$msr_item_table.id_accsub";
        }

        $this->db->group_by($group_by);
        $res = $this->db->get();
        return @$res->result()[0]->bookedBudget ?: 0;
    }

    public function filterNonZeroAccSubBudget($budget)
    {
        return array_filter($budget, function($b) {
            return $b->id_accsub != '' && $b->amount > 0;
        });
    }

    public function sumAccSubBudget($budget)
    {
        return array_reduce($budget, function($carrier, $b) {
            $carrier += $b->amount;
            return $carrier;
        }, 0);
    }

    public function filterOnlyAccSubsidiary($budget) {
        return array_filter($budget, function($b) {
            return $b->id_accsub != '';
        });
    }
}
