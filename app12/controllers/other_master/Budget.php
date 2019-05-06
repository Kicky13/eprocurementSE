<?php defined('BASEPATH') or exit('No direct script access allowed');

class Budget extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('setting/M_master_costcenter')
            ->model('setting/M_currency')
            ->model('setting/M_master_acc_sub')
            ->model('other_master/M_budget')
            ->helper(['form', 'array']);
    }

    public function index()
    {
        $menu = get_main_menu();

        $opt_costcenter = array_map(function($data) {
            $data->COSTCENTER_DESC = $data->ID_COSTCENTER.' - '.$data->COSTCENTER_DESC;
            return $data;
        }, $this->M_master_costcenter->allActive());

        $opt_costcenter = array_pluck($opt_costcenter, 'COSTCENTER_DESC', 'ID_COSTCENTER');

        return $this->template->display('other_master/V_master_budget', compact(
          'menu', 'opt_costcenter'
        )); 
    }

    public function save()
    {
        $budget = $this->input->post('accsub_budget');
        $costcenter_id = $this->input->post('costcenter_id');
        $costcenter_budget_amount = $this->input->post('costcenter_budget_amount_value');

        $master_accsub_budget = $this->M_budget->findByCostCenter($costcenter_id, 'accsubsidiary_only');
        $master_accsub_budget = array_pluck($master_accsub_budget, 'id_accsub');

        $costcenter_budget = 0;
        $nonzero_accsub = [];
        foreach ($budget as $id_accsub => $amount) {
            if (in_array($id_accsub, $master_accsub_budget)) {
                $data = $this->makeSave([
                    'amount' => $amount
                ]);

                $this->M_budget->update([
                    'costcenter_id' => $costcenter_id,
                    'accsub_id' => $id_accsub
                ], $data);

                if ($amount > 0) {
                    $nonzero_accsub[] = $id_accsub;
                }


                $costcenter_budget += $amount;
            }
        }

        // if all acc. subsidiary is 0, use user input costcenter budget
        if (count($nonzero_accsub) == 0) {
            $costcenter_budget = $costcenter_budget_amount;
        }

        $data = $this->makeSave([
            'amount' => $costcenter_budget
        ]);

        $this->M_budget->update([
            'costcenter_id' => $costcenter_id,
            'accsub_id' => '' 
        ], $data);

        return $this->output->set_content_type('application/json')
            ->set_output(@json_encode(array(
                'status' => 'success'
            )));
    }

    public function makeSave($data)
    {
        return array(
            'amount' => @$data['amount'],
        );
    }

    public function dataBudget()
    {
        $costcenter_id = $this->input->get('costcenter_id');

        $accsub_budget = $this->M_budget->findByCostCenter($costcenter_id, 'accsubsidiary_only');
        $nonzero_accsub_budget = $this->M_budget->filterNonZeroAccSubBudget($accsub_budget);
        $costcenter_budget = @$this->M_budget->findByCostCenter($costcenter_id, 'costcenter_only')[0];

        return $this->output->set_content_type('application/json')
            ->set_output(@json_encode(array(
                'data' => $accsub_budget,
                'costcenter_budget' => $costcenter_budget,
                'is_accsub_maintained' => count($nonzero_accsub_budget) > 0
            )));
    }
}
