<?php defined('BASEPATH') or exit('No direct script access allowed');

class Budget extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('other_master/M_budget')
            ->model('setting/M_currency')
            ->model('setting/M_master_acc_sub')
            ->model('setting/M_master_costcenter')
            ->helper(['form', 'exchange_rate']);
    }

    public function accSubsidiary()
    {
        $menu = get_main_menu();

        $costcenter_id = $this->input->get('costcenter_id');

        $costcenter = $this->M_master_costcenter->find($costcenter_id);

        $budget = $this->M_budget->getPlanBudget($costcenter_id);

        $base_currency_code = base_currency_code();

        $this->template->display('report/V_budget_acc_subsidiary', compact(
            'menu', 'costcenter_id', 'costcenter', 'budget', 'base_currency_code'
        ));
    }

    public function dataAccSubsidiary()
    {
        $costcenter_id = $this->input->get('costcenter_id');
        $costcenter = $this->M_master_costcenter->find($costcenter_id);

        $budget = $this->M_budget->findByCostCenter($costcenter_id);

        $result = $costcenter_budget = array();
        $total_budget = 0; 

        foreach($budget as $b) {

            if ($b->id_accsub != '') {
                $accsub_id = $b->id_accsub;
                $total_budget = @$total_budget + $b->amount; 
            } else {
                $accsub_id = '';
            }

            // $planned_budget = $this->M_budget->getPlanBudget($costcenter_id, $accsub_id);
            $planned_budget = $b->amount;

            $booked_budget = $this->M_budget->getBookingBudget($b->id_costcenter, $accsub_id);
            $booked_budget = calculate_amount_with_vat($booked_budget);

            $committed_budget = $this->M_budget->getCommitBudget($b->id_costcenter, $accsub_id);
            $committed_budget = calculate_amount_with_vat($committed_budget);
            
            $actual_budget = $this->M_budget->getActualBudget($b->id_costcenter, $accsub_id);

            $available_budget = $this->M_budget->calculateAvailableBudget($planned_budget,
                $booked_budget, $committed_budget, $actual_budget);

            $_result = array(
                'costcenter_id' => $b->id_costcenter,
                'costcenter_desc' => $b->COSTCENTER_DESC, 
                'accsub_id' => $b->id_accsub,
                'accsub_desc' => $b->ACCSUB_DESC,
                'currency_id' => $b->id_currency,
                'currency_desc' => $b->CURRENCY,
                'planned_budget' => $planned_budget,
                'booked_budget' => $booked_budget,
                'committed_budget' => $committed_budget,
                'actual_budget' => $actual_budget,
                'available_budget' => $available_budget
            );

            if ($b->id_accsub != '') {
                $result[] = $_result; 
            } else {
                $costcenter_budget = $_result;
            }
        }

        // 
        // if ($costcenter_budget) {
        //    array_unshift($result, $costcenter_budget);
        // }

        /*
        $planned_budget = $this->M_budget->getPlanBudget($costcenter_id, '');
        $booked_budget = $this->M_budget->getBookingBudget($costcenter_id, '');
        $committed_budget = $this->M_budget->getCommitBudget($costcenter_id, '');
        $actual_budget = $this->M_budget->getActualBudget($costcenter_id, '');
        $available_budget = $this->M_budget->calculateAvailableBudget($planned_budget,
            $booked_budget, $committed_budget, $actual_budget);
        
        $budgetCostCenter = array(
            'costcenter_id' => @$costcenter->ID_COSTCENTER,
            'costcenter_desc' => @$costcenter->COSTCENTER_DESC, 
            'currency_id' => @$b->id_currency,
            'currency_desc' => @$b->CURRENCY,
            'planned_budget' => $planned_budget,
            'booked_budget' => $booked_budget,
            'committed_budget' => $committed_budget,
            'actual_budget' => $actual_budget,
            'available_budget' => $available_budget
        );
        */

        return $this->output->set_content_type('application/json')
            ->set_output(@json_encode(array(
                'data' => $result,
        //        'budgetCostCenter' => $budgetCostCenter
            )));
    }

    public function costCenter()
    {
        $menu = get_main_menu();

        $base_currency = $this->M_currency->getBaseCurrency();
        $base_currency_code = $base_currency->CURRENCY;

        $budget = 0;

        $this->template->display('report/V_budget_costcenter', compact(
            'menu', 'budget', 'base_currency_code'
        ));
    }

    /* TODO: speed up by using join selection technique */
    public function dataCostCenter()
    {

        $costcenters = $this->M_master_costcenter->all();
        $base_currency = $this->M_currency->getBaseCurrency();

        $result = array();

        foreach($costcenters as $b) {
            $planned_budget = $this->M_budget->getPlanBudget($b->ID_COSTCENTER, '');

            $booked_budget = $this->M_budget->getBookingBudget($b->ID_COSTCENTER, '');
            $booked_budget = calculate_amount_with_vat($booked_budget);

            $committed_budget = $this->M_budget->getCommitBudget($b->ID_COSTCENTER, '');
            $committed_budget = calculate_amount_with_vat($committed_budget);

            $actual_budget = $this->M_budget->getActualBudget($b->ID_COSTCENTER, '');

            $available_budget = $this->M_budget->calculateAvailableBudget($planned_budget,
                $booked_budget, $committed_budget, $actual_budget);

            $result[] = array(
                'costcenter_id' => $b->ID_COSTCENTER,
                'costcenter_desc' => $b->COSTCENTER_DESC, 
                'currency_id' => $base_currency->ID,
                'currency_desc' => $base_currency->CURRENCY,
                'planned_budget' => $planned_budget,
                'booked_budget' => $booked_budget,
                'committed_budget' => $committed_budget,
                'actual_budget' => $actual_budget,
                'available_budget' => $available_budget
            );
        }

        return $this->output->set_content_type('application/json')
            ->set_output(@json_encode(array(
                'data' => $result
            )));
    }
}
