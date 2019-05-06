<?php
class Budget_spending extends CI_Controller
{
    protected $menu;
    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('dashboard', TRUE);
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('dashboard/M_home', 'mhm');
        $this->load->model('vendor/M_all_intern', 'mai');

        $this->load->model('dashboard/m_dashboard');
        $this->load->model('dashboard/M_budget_spending');

        $cek = $this->mai->cek_session();
        $get_menu = $this->mhm->menu();
        foreach($get_menu as $k => $v)
        {
            $this->menu[$v->PARENT][$v->ID_MENU]['DESCRIPTION_IND']=$v->DESCRIPTION_IND;
            $this->menu[$v->PARENT][$v->ID_MENU]['DESCRIPTION_ENG']=$v->DESCRIPTION_ENG;
            $this->menu[$v->PARENT][$v->ID_MENU]['URL']=$v->URL;
            $this->menu[$v->PARENT][$v->ID_MENU]['ICON']=$v->ICON;
        }
    }

    public function index() {
        $data = $this->config->item('dashboard')['bnf'];
        $data['filters'] = array(
            'company',
            'department',
            'costcenter',
            'subsidiary_account',
            'years',
            'months'
        );
        $this->template->display_dash('dashboard/V_budget_spending', $data);
    }

    public function get() {
        $filter = $this->input->post('filter');
        if (!isset($filter['years'])) {
            $filter['years'][] = date('Y');
        }
        $periode = array();
        if (isset($filter['months'])) {
            foreach ($filter['years'] as $y) {
                foreach ($filter['months'] as $month) {
                    $periode[] = $y.'-'.$month;
                }
            }
            $filter['periode'] = $periode;
        }
        $dt_budget = array();
        $lead_time_trend = array();
        $budget_spending_step = $this->M_budget_spending->get_budget_spending($filter);
        foreach ($budget_spending_step as $budget_spending) {
            $dt_budget[$budget_spending->status][$budget_spending->company] = $budget_spending;
        }
        $budget_spending_step_trend = $this->M_budget_spending->get_budget_spending_trend($filter);
        $bs_trend = array();
        foreach ($budget_spending_step_trend as $budget_spending_trend) {
            $bs_trend[$budget_spending_trend->status][$budget_spending_trend->company][$budget_spending_trend->periode] = $budget_spending_trend;
        }
        $rs_company = $this->m_dashboard->get_all_company();
        $dt_company = array();
        foreach ($rs_company as $key => $row_comp) {
          $dt_company[] = $row_comp->ABBREVIATION;
        }
        echo json_encode(array(
            'procurement_methods' => $dt_company,
            'periode' => $periode,
            'data' => array(
                'budget_spending' => $dt_budget,
                'budget_spending_trend' => $bs_trend
            )
        ));
    }

    protected function get_status() {
        $filter = $this->input->post('filter');
        if (!isset($filter['years'])) {
            $filter['years'][] = date('Y');
        }
        $periode = array();
        if (isset($filter['months'])) {
            foreach ($filter['years'] as $y) {
                foreach ($filter['months'] as $month) {
                    $periode[] = $y.'-'.$month;
                }
            }
            $filter['periode'] = $periode;
        }
        $status_result = $this->M_budget_spending->get_status($filter);
        $status = array();
        foreach ($status_result as $row) {
            $status[$row->status] = $row;
        }
        $status_trend_result = $this->M_budget_spending->get_status_trend($filter);
        $status_trend = array();
        foreach ($status_trend_result as $row) {
            $status_trend[$row->status][$row->periode] = $row;
        }
        return array(
            'periode' => $periode,
            'data' => array (
                'status' => $status,
                'status_trend' => $status_trend
            )
        );
    }

    public function get_details() {
        $filter = $this->input->get('filter');
        if (!isset($filter['years'])) {
            $filter['years'][] = date('Y');
        }
        $periode = array();
        if (isset($filter['months'])) {
            foreach ($filter['years'] as $y) {
                foreach ($filter['months'] as $month) {
                    $periode[] = $y.'-'.$month;
                }
            }
            $filter['periode'] = $periode;
        }
        $condition = array();
        if (isset($filter['periode'])) {
            $condition[] = 'LEFT(po.po_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'po.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'msr.id_department IN (\''.implode('\',\'', $filter['department']).'\')';
        }
        if (isset($filter['costcenter'])) {
            $condition[] = 'pod.id_costcenter IN (\''.implode('\',\'', $filter['costcenter']).'\')';
        }
        if (isset($filter['accsub'])) {
            $condition[] = 'pod.id_accsub IN (\''.implode('\',\'', $filter['accsub']).'\')';
        }
        if (count($condition) <> 0) {
            $condition_query = 'AND '.implode(' AND ', $condition);
        } else {
            $condition_query = '';
        }
        $this->load->library('datatable');
        $this->datatable->resource(" ( SELECT allocated.*, approved.value2, paid.paid, payable.payable, (COALESCE(approved.value2, 0) - COALESCE(allocated.value, 0)) as remaining FROM (SELECT status, SUM(total_price_base) as value, company, DEPARTMENT_DESC, id_costcenter, id_accsub, LEFT(po_date, 7) as periode
        FROM (SELECT 'Allocated' as status, c.ABBREVIATION as company, po.id, po.po_no, po.msr_no, po.id_company,
        po.po_date, pod.id_costcenter, pod.id_accsub, pod.total_price_base, msr.id_department, d.DEPARTMENT_DESC
        FROM t_purchase_order po
        JOIN t_purchase_order_detail pod ON pod.po_id=po.id
        JOIN m_company c ON c.ID_COMPANY=po.id_company
        JOIN t_msr msr ON msr.msr_no=po.msr_no
        JOIN m_departement d ON d.ID_DEPARTMENT=msr.id_department
        WHERE po.accept_completed = 1 ".$condition_query."
        ) t_po
        GROUP BY company, status,DEPARTMENT_DESC,id_costcenter, id_accsub,po_date ) allocated
        LEFT JOIN
        (SELECT status, SUM(bg.total_price_base) as value2, company FROM
        ( SELECT 'Approved' as status, b.amount, pod.total_price_base, com.ID_COMPANY, com.ABBREVIATION as company, cos.ID_COSTCENTER, cos.COSTCENTER_DESC, acc.ID_ACCSUB, LEFT(po.po_date, 7) as periode
        FROM m_company com
        JOIN m_costcenter cos ON cos.ID_COMPANY=com.ID_COMPANY
        JOIN m_accsub acc ON acc.COSTCENTER=cos.ID_COSTCENTER
        JOIN t_msr msr ON msr.id_department=cos.ID_COSTCENTER
        JOIN t_purchase_order po ON po.msr_no=msr.msr_no
        JOIN t_purchase_order_detail pod ON pod.po_id=po.id AND pod.id_accsub=acc.ID_ACCSUB
        LEFT JOIN m_budget b ON b.id_costcenter=cos.ID_COSTCENTER AND b.id_accsub=acc.ID_ACCSUB
        WHERE po.accept_completed = 1 ".$condition_query."
         ) bg
        GROUP BY company, status ) approved ON approved.company=allocated.company
        LEFT JOIN
        (SELECT SUM(amount_receipt) as paid, company
        FROM (SELECT c.ABBREVIATION as company, po.id, po.po_no, po.msr_no, po.id_company,
        po.po_date, pod.id_costcenter, pod.id_accsub, pod.total_price_base, msr.id_department, d.DEPARTMENT_DESC, agg.amount_receipt
        FROM t_purchase_order po
        JOIN t_purchase_order_detail pod ON pod.po_id=po.id
        JOIN m_company c ON c.ID_COMPANY=po.id_company
        JOIN t_msr msr ON msr.msr_no=po.msr_no
        JOIN m_departement d ON d.ID_DEPARTMENT=msr.id_department
        JOIN sync_agg_val agg ON agg.doc_no=po.po_no AND agg.line_no/1000=pod.line_no
        WHERE po.accept_completed = 1 AND agg.amount_open = 0 ".$condition_query."
        ) t_po
        GROUP BY company) paid ON paid.company=allocated.company
        LEFT JOIN
        (SELECT SUM(amount_open) as payable, company
        FROM (SELECT c.ABBREVIATION as company, po.id, po.po_no, po.msr_no, po.id_company,
        po.po_date, pod.id_costcenter, pod.id_accsub, pod.total_price_base, msr.id_department, d.DEPARTMENT_DESC, agg.amount_open
        FROM t_purchase_order po
        JOIN t_purchase_order_detail pod ON pod.po_id=po.id
        JOIN m_company c ON c.ID_COMPANY=po.id_company
        JOIN t_msr msr ON msr.msr_no=po.msr_no
        JOIN m_departement d ON d.ID_DEPARTMENT=msr.id_department
        JOIN sync_agg_val agg ON agg.doc_no=po.po_no AND agg.line_no/1000=pod.line_no
        WHERE po.accept_completed = 1 AND agg.amount_open != 0 ".$condition_query."
        ) t_po
        GROUP BY company) payable ON payable.company=allocated.company
         ) budget_spending ")
        ->generate();
    }

}
