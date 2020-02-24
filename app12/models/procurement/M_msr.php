<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_Msr extends CI_Model {

  const module_kode = 'msr';
  protected $table = 't_msr';
  protected $table_budget = 'm_budget'; // TODO: move to budget model
  protected $table_t_approval = 't_approval';
  protected $table_m_approval = 'm_approval';
  protected $table_t_assignment = 't_assignment';

  public function __construct() {
      parent::__construct();
      $this->db = $this->load->database('default', true);
      $this->load->helper('date');
  }

  public function getTable()
  {
      return $this->table;
  }

  public function all()
  {
    return @$this->db->get($this->table)->result();
  }


  public function alldept($dept)
  {
    $assignment = $this->db->where('user_id',$this->input->get('user'))->get('t_assignment');

    $this->db->select('t_msr.*, m_currency.CURRENCY, m_company.ABBREVIATION');
    $this->db->join('m_currency', 'm_currency.ID = t_msr.id_currency');
    $this->db->join('m_company', 'm_company.ID_COMPANY = t_msr.id_company', 'left');
    if($this->input->get('user'))
    {
      $userMsr = [];
      foreach ($assignment->result() as $r) {
        $userMsr[] = $r->msr_no;
      }

      //$this->db->where_in('msr_no', $userMsr);
	  $this->db->where('msr_no in (select msr_no from t_assignment 
        where user_id = '.$this->input->get('user').' and t_assignment.msr_no not in (select msr_no from t_purchase_order where issued = 1)) ');
    }
    $this->db->order_by('t_msr.msr_no', 'desc');
    $roles = $this->session->userdata('ROLES');
    $roles =  explode(",", $roles);
    $roles = array_values(array_filter($roles));

    if(in_array(all_msr, $roles))
    {
      $rs =  @$this->db->get($this->table)->result();
    }
    else
    {
      if($dept == '101013800'){
        $rs =  @$this->db->get($this->table)->result();
      } else {
        $rs = @$this->db->get_where($this->table,array('id_department =' => $dept))->result();
      }
    }
        // echo  $this->db->last_query();
        // echo $this->session->userdata('ROLES');
    return $rs;
  }

  // do we need $company?
  public function find($id)
  {
    return @$this->db->where('msr_no', $id)
      ->get($this->table)
      ->result()[0];
  }

  public function add($data)
  {
    $data['create_on'] = today_sql();
    $data['create_by'] = $this->session->userdata('ID_USER');

    return $this->db->insert($this->table, $data);
  }

  public function update($msr_no, $data)
  {
    //if (isset($data['CREATE_ON'])) unset($data['CREATE_ON']);
    //if (isset($data['CREATE_BY'])) unset($data['CREATE_BY']);

    // $data['UPDATED_ON'] = today_sql();
    // $data['UPDATED_BY'] = @$_SESSION['NAME'];

    return $this->db->update($this->table, $data, array(
      'msr_no' => $data['msr_no'],
    ));
  }

  /**
   * TODO: add various dynamic parameters to filter data
   */
    public function inquirynew($dept)
    {
        if($dept == '101013800'){
            $dept = '%';
        }

        $sql = <<<SQL
select msr.msr_no
    , mapp.module_kode, mapp.id mapp_id, mapp.role_id
    , tapp.id tapp_id, tapp.m_approval_id, tapp.status, tapp.urutan
    , mapp_prev.module_kode prev_module_kode, mapp_prev.role_id prev_role_id
    , tapp_prev.id prev_tapp_id, tapp_prev.status prev_status, tapp_prev.urutan prev_urutan
    , case
        when
            (tapp.status = 0 and tapp_prev.status = 1)
        then 'WAITING_APPROVAL' -- in approval
        when
            (mapp.module_kode = 'msr' and tapp.status = 0 and tapp_prev.status is null)
        then 'NEW'  -- first approval
        when
            (tapp.status = 2)
            or (mapp.module_kode = 'msr_spa' and tapp.status = 3)
        then'REJECT'-- reject
        when
            (mapp.module_kode = 'msr_spa' and tapp.status = 1 and tapp.urutan = 1 and tapp_prev.status is null) -- verified
        then 'VERIFIED'
        when
            (mapp.module_kode = 'msr_spa' and tapp.status != 0 and tapp.urutan = 2 and tapp_prev.status = 1) -- assigned
        then 'ASSIGNED'
        when
            (mapp.module_kode = 'msr_spa' and tapp.status in (0, 1) and tapp_prev.status is null)
        then 'COMPLETE' -- complete
        else 'UNKNOWN'
    end as status_code
    , urole.DESCRIPTION as action_to_role_description
from t_msr msr
join t_approval tapp on tapp.data_id = msr.msr_no
join m_approval mapp on mapp.id = tapp.m_approval_id
left join t_approval tapp_prev on tapp_prev.data_id = tapp.data_id
    and tapp_prev.urutan = tapp.urutan - 1
left join m_approval mapp_prev on mapp_prev.module_kode = mapp.module_kode
    and tapp_prev.m_approval_id = mapp_prev.id
left join m_user_roles urole on case
  when
    (tapp.status = 2) -- reject
    or (mapp.module_kode = 'msr_spa' and tapp.status = 3)
    or (tapp.status = 0 and tapp_prev.status = 1) -- waiting approval
  then urole.ID_USER_ROLES = mapp.role_id
  when
    (tapp.status = 1 and tapp_prev.status is null)
  then urole.ID_USER_ROLES = ''
  when
    (tapp.status = 0 and tapp_prev.status is null) -- first approver
   then urole.ID_USER_ROLES = mapp.role_id
  else
    urole.ID_USER_ROLES = '' -- mapp.role_id
  end
where true
    and ( mapp.module_kode = 'msr' or (mapp.module_kode = 'msr_spa' and tapp.urutan in (1,2)))
    and if (mapp.module_kode = 'msr' and tapp.urutan != 1, mapp_prev.module_kode is not null and tapp_prev.id is not null, true)
    -- and msr.msr_no in ( '18000202-OR-10101' , '18000210-OR-10101' )
    and (
        -- (tapp.status is null)
        if (mapp.module_kode = 'msr',
            (mapp.module_kode = 'msr' and tapp.status = 0 and tapp_prev.status is null) -- first approval
            or (tapp.status = 0 and tapp_prev.status = 1) -- waiting approval
            -- or (tapp.status = 0 and tapp_prev.status = 2) -- reject
            or (tapp.status = 2 ) -- reject
            or (mapp.module_kode = 'msr_spa' and tapp.status in (0,1,2) and tapp_prev.status is null) -- complete
            ,
            (mapp.module_kode = 'msr_spa' and tapp.status = 0 and tapp_prev.status is null) -- complete
            or (mapp.module_kode = 'msr_spa' and tapp.status = 2 ) -- reject verified
            or (mapp.module_kode = 'msr_spa' and tapp.status = 3 ) -- reject assigned
            or (mapp.module_kode = 'msr_spa' and tapp.status = 1 and tapp.urutan = 1 and mapp_prev.module_kode is null and tapp_prev.status is null) -- verified
            or (mapp.module_kode = 'msr_spa' and mapp_prev.module_kode = 'msr_spa' and tapp.status != 0 and tapp.urutan = 2 and tapp_prev.status = 1) -- assigned
        )
    )
    and msr.id_department like '$dept'
order by msr.msr_no, mapp.module_kode, tapp.urutan
SQL;

        // TODO: refine above SQL to only get ASSIGNED data if exists
        // as workaround we do filter here out of Query
        $res = $this->db->query($sql);
        $result = array();
        $i = 0;
        $last_msr_no = '';

        while ($row = $res->unbuffered_row()) {
            if ($last_msr_no == $row->msr_no && ($row->status_code == 'ASSIGNED' || $row->status_code == 'REJECT')) {
                // find row before
                $key = $i - 1;
                if ($key >= 0 && $result[$key]->status_code == 'VERIFIED') {
                    // Replace prior (VERIFIED) data with this one
                    $result[$key] = $row;
                }
                $last_msr_no = $row->msr_no;
                continue;
            }

            $last_msr_no = $row->msr_no;
            $result[$i] = $row;
            $i++;
        }

        return $result;
    }
  public function inquiry($dept)
  {
    if($dept == '101013800'){
      $dept = '%';
    }

    $sql = <<<SQL
select msr.msr_no
    , mapp.module_kode, mapp.id mapp_id, mapp.role_id
    , tapp.id tapp_id, tapp.m_approval_id, tapp.status, tapp.urutan
    , mapp_prev.module_kode prev_module_kode, mapp_prev.role_id prev_role_id
    , tapp_prev.id prev_tapp_id, tapp_prev.status prev_status, tapp_prev.urutan prev_urutan
    , case
        when
            (tapp.status = 0 and tapp_prev.status = 1)
        then 'WAITING_APPROVAL' -- in approval
        when
            (mapp.module_kode = 'msr' and tapp.status = 0 and tapp_prev.status is null)
        then 'NEW'  -- first approval
        when
            (tapp.status = 2)
            or (mapp.module_kode = 'msr_spa' and tapp.status = 3)
        then'REJECT'-- reject
        when
            (mapp.module_kode = 'msr_spa' and tapp.status = 1 and tapp.urutan = 1 and tapp_prev.status is null) -- verified
        then 'VERIFIED'
        when
            (mapp.module_kode = 'msr_spa' and tapp.status != 0 and tapp.urutan = 2 and tapp_prev.status = 1) -- assigned
        then 'ASSIGNED'
        when
            (mapp.module_kode = 'msr_spa' and tapp.status in (0, 1) and tapp_prev.status is null)
        then 'COMPLETE' -- complete
        else 'UNKNOWN'
    end as status_code
    , urole.DESCRIPTION as action_to_role_description
from t_msr msr
join t_approval tapp on tapp.data_id = msr.msr_no
join m_approval mapp on mapp.id = tapp.m_approval_id
left join t_approval tapp_prev on tapp_prev.data_id = tapp.data_id
    and tapp_prev.urutan = tapp.urutan - 1
left join m_approval mapp_prev on mapp_prev.module_kode = mapp.module_kode
    and tapp_prev.m_approval_id = mapp_prev.id
left join m_user_roles urole on case
  when
    (tapp.status = 2) -- reject
    or (mapp.module_kode = 'msr_spa' and tapp.status = 3)
    or (tapp.status = 0 and tapp_prev.status = 1) -- waiting approval
  then urole.ID_USER_ROLES = mapp.role_id
  when
    (tapp.status = 1 and tapp_prev.status is null)
  then urole.ID_USER_ROLES = ''
  when
    (tapp.status = 0 and tapp_prev.status is null) -- first approver
   then urole.ID_USER_ROLES = mapp.role_id
  else
    urole.ID_USER_ROLES = '' -- mapp.role_id
  end
where true
    and ( mapp.module_kode = 'msr' or (mapp.module_kode = 'msr_spa' and tapp.urutan in (1,2)))
    and if (mapp.module_kode = 'msr' and tapp.urutan != 1, mapp_prev.module_kode is not null and tapp_prev.id is not null, true)
    -- and msr.msr_no in ( '18000202-OR-10101' , '18000210-OR-10101' )
    and (
        -- (tapp.status is null)
        if (mapp.module_kode = 'msr',
            (mapp.module_kode = 'msr' and tapp.status = 0 and tapp_prev.status is null) -- first approval
            or (tapp.status = 0 and tapp_prev.status = 1) -- waiting approval
            -- or (tapp.status = 0 and tapp_prev.status = 2) -- reject
            or (tapp.status = 2 ) -- reject
            or (mapp.module_kode = 'msr_spa' and tapp.status in (0,1) and tapp_prev.status is null) -- complete
            ,
            (mapp.module_kode = 'msr_spa' and tapp.status = 0 and tapp_prev.status is null) -- complete
            or (mapp.module_kode = 'msr_spa' and tapp.status = 2 ) -- reject verified
            or (mapp.module_kode = 'msr_spa' and tapp.status = 3 ) -- reject assigned
            or (mapp.module_kode = 'msr_spa' and tapp.status = 1 and tapp.urutan = 1 and mapp_prev.module_kode is null and tapp_prev.status is null) -- verified
            or (mapp.module_kode = 'msr_spa' and mapp_prev.module_kode = 'msr_spa' and tapp.status != 0 and tapp.urutan = 2 and tapp_prev.status = 1) -- assigned
        )
    )
    and msr.id_department like '$dept'
order by msr.msr_no, mapp.module_kode, tapp.urutan
SQL;

    // TODO: refine above SQL to only get ASSIGNED data if exists
    // as workaround we do filter here out of Query
    $res = $this->db->query($sql);
    $result = array();
    $i = 0;
    $last_msr_no = '';

    while ($row = $res->unbuffered_row()) {
        if ($last_msr_no == $row->msr_no && ($row->status_code == 'ASSIGNED' || $row->status_code == 'REJECT')) {
            // find row before
            $key = $i - 1;
            if ($key >= 0 && $result[$key]->status_code == 'VERIFIED') {
                // Replace prior (VERIFIED) data with this one
                $result[$key] = $row;
            }
            $last_msr_no = $row->msr_no;
            continue;
        }

        $last_msr_no = $row->msr_no;
        $result[$i] = $row;
        $i++;
    }

    return $result;
  }

  public function getLastDocNumber($year, $company)
  {
    $result = $this->db->from($this->table)
        ->select_max('msr_no', 'number')
        ->where('id_company', $company)
        ->where('left(msr_no, 2) = ', substr($year, -2))
        ->where($year, 'YEAR(create_on)', false)
        ->get()
        ->result();

    return count($result) > 0 ? $result[0]->number : 0;
  }

  public function isDocNumberExists($msr_no, $year, $company)
  {
      return $this->db->from($this->table)
          ->where('msr_no', $msr_no)
          ->where('id_company', $company)
          ->where($year, 'YEAR(create_on)', false)
          ->get()->num_rows() > 0;
  }

  public function getRejected()
  {
    /* SQL based on method $this->inquiry()
     * TODO: use inquiry method and add status as parameters, then call here
     */

    $t_approval = $this->table_t_approval;
    $m_approval = $this->table_m_approval;

    $this->db->from($this->table)
        ->join($t_approval, "{$t_approval}.data_id = {$this->table}.msr_no")
        ->join($m_approval, "{$m_approval}.id = {$t_approval}.m_approval_id")
        ->where("$m_approval.module_kode", $this::module_kode)
        ->where("$t_approval.status", 2);

    return $this->db->get()->result();
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

    return @$this->db->group_by($group_by)->get()->result()[0]->committedBudget;
  }

  public function getPlanBudget($cost_center, $account_subsidiary = '')
  {
    // get all budget in a costcenter
    $budget = $this->db->from($this->table_budget)
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
//    return 0; // dummy

    $this->load->model('procurement/M_msr_item')
        ->model('procurement/M_purchase_order_detail')
        ->model('procurement/M_purchase_order');

    $msr_item_table = $this->M_msr_item->getTable();
    $po_table = $this->M_purchase_order->getTable();
    $po_detail_table = $this->M_purchase_order_detail->getTable();

    $this->db->select("SUM(
          {$msr_item_table}.qty * {$msr_item_table}.priceunit_base
      ) as bookedBudget", false) // priceunit_base
      ->from($this->table)
      ->join($msr_item_table, $msr_item_table.'.msr_no = '.$this->table.'.msr_no')
      ->join($po_detail_table, "$po_detail_table.msr_item_id = {$msr_item_table}.line_item", 'left')
      ->where("{$po_detail_table}.id IS NULL") // where MSR has no PO yet
      ->where($msr_item_table.'.id_costcenter', $cost_center);

    $group_by = ["$msr_item_table.id_costcenter"];
    if ($account_subsidiary) {
      $this->db->where($msr_item_table.'.id_accsub', $account_subsidiary);
      $group_by[] = "$msr_item_table.id_accsub";
    }

    return @$this->db->group_by($group_by)->get()->result()[0]->bookedBudget;
  }

  public function getMsrBudgetStatus($msr_no)
  {
    $this->load->model('procurement/M_msr_budget_status');

    // TODO: Do real check, whether
    // 1. Planned before approved by BSD
    // 2. Booked after approved by BSD with Sufficient Budget
    // 3. Dummy Booked after approved by BSD with Insufficient Budget

    // dummy only
    return $this->M_msr_budget_status::PLANNED;
  }

  public function getWHCode($company) {
    $result = $this->db->from('m_warehouse')
        ->select('id_warehouse')
        ->where('id_company', $company)
        ->get()
        ->result();

    return $result;
  }

  // TODO: move to somewhere better (i.e: db, config)
  public function getAmountThreshold($name = NULL)
  {
      $threshold = [
        'DA'    => 10000, // USD
        'DS'    => 100000, // USD
      ];

      if ($name === NULL) {
          return $threshold;
      }


      return array_key_exists($name, $threshold) ? $threshold[$name] : NULL;
  }

  public function getThresholdBaseCurrency()
  {
      $this->load->helper("exchange_rate");

      return base_currency_code();
  }

  public function m_msr_inventory_type(){
    return $this->db->where('status', 1)
        ->get("m_msr_inventory_type")
        ->result();
  }

  public function getInsufficients($params = [])
  {
    $t_msr_budget = 't_msr_budget';
    $status_insufficient = 'Insufficient';

    if (isset($params['limit'])) {
      $this->db->limit($params['limit']);
    }

    if (isset($params['offset'])) {
      $this->db->offset($params['offset']);
    }

    if (isset($params['orderBy'])) {
      $this->db->order_by($params['orderBy']);
    }

    $this->db->group_by("{$this->table}.msr_no");
    $this->db->having("num_insufficient >", 0);

    $this->db->select([
        "{$this->table}.*",
        "count(1) as num_insufficient"
        ])
        ->from($this->table)
        ->join($t_msr_budget, "{$t_msr_budget}.msr_no = {$this->table}.msr_no")
        ->where("{$t_msr_budget}.status_budget", $status_insufficient);


    $res = $this->db->get();

    if (isset($params['resource']) && $params['resource'] === true) {
        return $res;
    }

    return $res->result();
  }

  public function getAssignment($msr_no = null)
  {
      $this->load->model('user/M_view_user');

      $m_user = $this->M_view_user->getTable();

      if ($msr_no) {
          if (!is_array($msr_no)) {
              $msr_no = array($msr_no);
          }

          if (count($msr_no) > 0) {
              $this->db->where_in('msr_no', $msr_no);
          }
      }

      return $this->db->select(["{$this->table_t_assignment}.*, {$m_user}.name"])
          ->from($this->table_t_assignment)
          ->join($m_user, "{$m_user}.id_user = {$this->table_t_assignment}.user_id", 'left')
          ->get()->result();
  }
  public function approval_list($msrNo='')
  {
    $query = $this->db->select('t_msr.*,m_currency.CURRENCY,m_msrtype.MSR_DESC,m_user.NAME,m_departement.DEPARTMENT_DESC,m_company.ABBREVIATION')
    ->join('m_currency','m_currency.ID = t_msr.id_currency')
    ->join('m_msrtype','m_msrtype.ID_MSR = t_msr.id_msr_type')
    ->join('m_user','m_user.ID_USER = t_msr.create_by')
    ->join('m_departement','m_departement.ID_DEPARTMENT = m_user.ID_DEPARTMENT')
    ->join('m_company','m_company.ID_COMPANY = t_msr.id_company')
    ->where(['t_msr.msr_no'=>$msrNo])
    ->get('t_msr');
    return $query;
  }
}



/* vim: set fen foldmethod=indent ts=4 sw=4 tw=0 et smartindent autoindent :*/