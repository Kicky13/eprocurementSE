<?php
class Procurement_saving extends CI_Controller
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
        $this->load->model('dashboard/m_procurement_saving');
        $this->load->helper('exchange_rate');

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
        $data = $this->config->item('dashboard')['scm'];
        $data['filters'] = array(
            'company',
            'method',
            'specialist',
            'po_item_type',
            'years',
            'months'
        );
        $this->template->display_dash('dashboard/V_proc_saving', $data);
    }

    public function get_agreement_msr_procurement_saving() {
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
        $procurement_saving = $this->m_procurement_saving->get_agreement_msr_procurement_saving($filter);
        if (!$procurement_saving) {
            $procurement_saving = array(
                'agreement_number' => 0,
                'currency' => base_currency_code(),
                'msr_value' => 0,
                'agreement_value' => 0,
                'saving_value' => 0
            );
        }
        $procurement_saving_trend_result = $this->m_procurement_saving->get_agreement_msr_procurement_saving_trend($filter);
        $procurement_saving_trend = array();
        foreach ($procurement_saving_trend_result as $procurement_saving_monthly) {
            $procurement_saving_trend[$procurement_saving_monthly->periode] = $procurement_saving_monthly;
        }
        $procurement_proposal_saving = $this->m_procurement_saving->get_agreement_proposal_procurement_saving($filter);
        if (!$procurement_proposal_saving) {
            $procurement_proposal_saving = array(
                'agreement_number' => 0,
                'currency' => base_currency_code(),
                'proposal_value' => 0,
                'agreement_value' => 0,
                'saving_value' => 0
            );
        }
        $procurement_proposal_saving_trend_result = $this->m_procurement_saving->get_agreement_proposal_procurement_saving_trend($filter);
        $procurement_proposal_saving_trend = array();
        foreach ($procurement_proposal_saving_trend_result as $procurement_proposal_saving_monthly) {
            $procurement_proposal_saving_trend[$procurement_proposal_saving_monthly->periode] = $procurement_proposal_saving_monthly;
        }
        echo json_encode(array(
            'periode' => $periode,
            'data' => array (
                'procurement_saving' => $procurement_saving,
                'procurement_saving_trend' => $procurement_saving_trend,
                'procurement_proposal_saving' => $procurement_proposal_saving,
                'procurement_proposal_saving_trend' => $procurement_proposal_saving_trend
            )
        ));
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
            $condition[] = 'LEFT(agreement.po_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 't_msr.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['type'])) {
            $condition[] = 'agreement.po_type IN (\''.implode('\',\'', $filter['type']).'\')';
        }
        if (isset($filter['method'])) {
            $condition[] = 't_msr.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
        }
        if (isset($filter['specialist'])) {
            $condition[] = 't_assignment.user_id IN (\''.implode('\',\'', $filter['specialist']).'\')';
        }
        if (count($condition) <> 0) {
            $condition_query = implode(' AND ', $condition);
        } else {
            $condition_query = '';
        }
        $this->load->library('datatable');
        if ($condition_query) {
            $this->datatable->where($condition_query, null, false);
        }
        $this->datatable->resource('t_msr', '
            t_msr.msr_no,
            agreement.po_no,
            LEFT(t_msr.create_on, 7) AS periode,
            m_currency.CURRENCY AS currency,
            SUM(t_msr_item.amount_base) AS msr_value,
            SUM(agreement.quotation_value) AS quotation_value,
            SUM(agreement.agreement_value) AS agreement_value,
            SUM(agreement.quotation_value - agreement.agreement_value) AS saving_quotation_value,
            SUM(t_msr_item.amount_base - agreement.agreement_value) AS saving_msr_value
        ')
        ->join('t_msr_item', 't_msr_item.msr_no = t_msr.msr_no')
        ->join('(SELECT a.po_no, a.msr_no, a.po_type, a.po_date, b.msr_item_id, SUM(b.total_price_base) AS agreement_value, SUM(c.qty * c.unit_price_base) AS quotation_value FROM t_purchase_order a
            JOIN t_purchase_order_detail b ON b.po_id = a.id
            JOIN t_sop_bid c ON c.id = b.sop_bid_id
            WHERE a.issued = 1
            GROUP BY a.po_no, a.msr_no, a.po_type, a.po_date, b.msr_item_id
        ) agreement', 'agreement.msr_no = t_msr_item.msr_no AND agreement.msr_item_id = t_msr_item.line_item')
        ->join('m_currency', 'm_currency.ID = t_msr.id_currency_base')
        ->join('t_assignment', 't_assignment.msr_no = t_msr.msr_no')
        ->join('m_user', 'm_user.ID_USER = t_msr.create_by')
        ->group_by(array('t_msr.msr_no', 'agreement.po_no', 'LEFT(t_msr.create_on, 7)', 'm_currency.CURRENCY'))
        ->generate();
    }
}