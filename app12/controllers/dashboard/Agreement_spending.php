<?php
class Agreement_spending extends CI_Controller
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
        $this->load->model('dashboard/m_agreement_spending');
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
            'department',
            'po_status',
            'po_type',
            'method',
            'specialist',
            'years',
            'months'
        );
        $this->template->display_dash('dashboard/V_agreement_spending', $data);
    }

    public function get_spending() {
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

        $spending = $this->m_agreement_spending->get_spending($filter);
        $rs_spending_trend = $this->m_agreement_spending->get_spending_trend($filter);
        $spending_trend = array();
        foreach ($rs_spending_trend as $r_spending_trend) {
            $spending_trend[$r_spending_trend->periode] = $r_spending_trend;
        }
        echo json_encode(array(
            'periode' => $periode,
            'data' => array (
                'spending' => $spending,
                'spending_trend' => $spending_trend
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
            $condition[] = 'LEFT(t_purchase_order.po_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 't_msr.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'm_user.ID_DEPARTMENT IN (\''.implode('\',\'', $filter['department']).'\')';
        }
        if (isset($filter['status'])) {
            $condition[] = 't_purchase_order.issued IN (\''.implode('\',\'', $filter['status']).'\')';
        }
        if (isset($filter['type'])) {
            $condition[] = 't_purchase_order.po_type IN (\''.implode('\',\'', $filter['type']).'\')';
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
        $this->datatable->resource('t_purchase_order', 't_purchase_order.id, t_purchase_order.po_no, t_purchase_order.po_date, m_vendor.NAMA as vendor, m_company.DESCRIPTION as company, m_departement.DEPARTMENT_DESC as department, SUM(COALESCE(t_purchase_order.total_amount_base,0)) as total, SUM(COALESCE(receipt.VALUE, 0)) as spending,  SUM(COALESCE(payable.VALUE, 0)) as payable,  SUM(COALESCE(paid.VALUE, 0)) as paid, SUM(COALESCE(t_purchase_order.total_amount_base,0)) - (SUM(COALESCE(receipt.VALUE,0)) + SUM(COALESCE(payable.VALUE,0)) + SUM(COALESCE(paid.VALUE,0))) as remaining')
        ->join('t_msr', 't_msr.msr_no = t_purchase_order.msr_no')
        ->join('t_bl_detail', 't_bl_detail.id = t_purchase_order.bl_detail_id')
        ->join('m_user', 'm_user.ID_USER = t_msr.create_by')
        ->join('m_vendor', 'm_vendor.ID = t_bl_detail.vendor_id')
        ->join('m_company', 'm_company.ID_COMPANY = t_msr.id_company')
        ->join('m_departement', 'm_departement.ID_DEPARTMENT = m_user.ID_DEPARTMENT')
        ->join('t_assignment', 't_assignment.msr_no = t_msr.msr_no')
        ->join('(
            SELECT
                AGG_NO,
                SUM(AMT_REC) AS VALUE
            FROM sync_receipt
            WHERE TYPE_MATCH = 1
            AND QTY_ORD <> 0
            AND DOC_TYPE = \'OV\'
            AND PAY_STATUS <> \'A\'
            AND PAY_STATUS <> \'P\'
            GROUP BY AGG_NO
        ) receipt', 'receipt.AGG_NO = t_purchase_order.id', 'left')
        ->join('(
            SELECT
                AGG_NO,
                SUM(AMT_REC) AS VALUE
            FROM sync_receipt
            WHERE TYPE_MATCH = 1
            AND QTY_ORD <> 0
            AND DOC_TYPE = \'OV\'
            AND PAY_STATUS = \'A\'
            GROUP BY AGG_NO
        ) payable', 'payable.AGG_NO = t_purchase_order.id', 'left')
        ->join('(
            SELECT
                AGG_NO,
                SUM(AMT_REC) AS VALUE
            FROM sync_receipt
            WHERE TYPE_MATCH = 1
            AND QTY_ORD <> 0
            AND DOC_TYPE = \'OV\'
            AND PAY_STATUS = \'P\'
            GROUP BY AGG_NO
        ) paid', 'paid.AGG_NO = t_purchase_order.id', 'left')
        ->group_by(array('t_purchase_order.id', 't_purchase_order.po_no', 't_purchase_order.po_date', 'm_vendor.NAMA', 'm_company.DESCRIPTION ', 'm_departement.DEPARTMENT_DESC'))
        ->generate();
    }
}