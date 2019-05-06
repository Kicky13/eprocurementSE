<?php
class Expediting extends CI_Controller
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
        $this->load->model('dashboard/m_expediting');

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
            'supplier_rating',
            'supplier_classification',
            'supplier',
            'years',
            'months'
        );
        $this->template->display_dash('dashboard/V_expediting', $data);
    }

     public function get_expediting() {
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

        $expediting = $this->m_expediting->get_expediting($filter);
        $rs_expediting_trend = $this->m_expediting->get_expediting_trend($filter);
        $expediting_trend = array();
        foreach ($rs_expediting_trend as $r_expediting_trend) {
            $expediting_trend[$r_expediting_trend->status][$r_expediting_trend->periode] = $r_expediting_trend;
        }
        echo json_encode(array(
            'periode' => $periode,
            'data' => array (
                'expediting' => $expediting,
                'expediting_trend' => $expediting_trend
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
        $this->datatable->resource('t_purchase_order', '
            t_purchase_order.po_no,
            t_purchase_order.title,
            t_purchase_order.po_date, m_vendor.NAMA as vendor,
            m_company.DESCRIPTION as company,
            specialist.NAME as specialist,
            m_departement.DEPARTMENT_DESC as department,
            m_deliverypoint.DPOINT_DESC as dpoint,
            t_purchase_order.delivery_date,
            MAX(expediting.expediting_date) as expediting_date,
            CASE
                WHEN MAX(expediting.expediting_date) IS NOT NULL AND MAX(expediting.expediting_date) > t_purchase_order.delivery_date THEN DATEDIFF(MAX(expediting.expediting_date), t_purchase_order.delivery_date)
                ELSE 0
            END days_late,
            CASE
                WHEN MAX(expediting.expediting_date) IS NULL AND NOW() > t_purchase_order.delivery_date THEN \'Delayed\'
                WHEN MAX(expediting.expediting_date) IS NOT NULL AND MAX(expediting.expediting_date) > t_purchase_order.delivery_date THEN \'Late\'
                ELSE \'On Time\'
            END status
        ')
        ->join('t_purchase_order_detail', 't_purchase_order_detail.po_id = t_purchase_order.id')
        ->join('t_msr', 't_msr.msr_no = t_purchase_order.msr_no')
        ->join('t_bl_detail', 't_bl_detail.id = t_purchase_order.bl_detail_id')
        ->join('m_user', 'm_user.ID_USER = t_msr.create_by')
        ->join('m_vendor', 'm_vendor.ID = t_bl_detail.vendor_id')
        ->join('m_company', 'm_company.ID_COMPANY = t_msr.id_company')
        ->join('m_departement', 'm_departement.ID_DEPARTMENT = m_user.ID_DEPARTMENT')
        ->join('t_assignment', 't_assignment.msr_no = t_msr.msr_no')
        ->join('m_user specialist', 'specialist.ID_USER = t_assignment.user_id')
        ->join('m_deliverypoint', 'm_deliverypoint.ID_DPOINT = t_purchase_order.id_dpoint')
        ->join('(
            SELECT
                t_itp.no_po, t_service_receipt_detail.id_material, MAX(receipt_date) AS expediting_date
            FROM t_service_receipt
            JOIN t_service_receipt_detail ON t_service_receipt_detail.id_service_receipt = t_service_receipt.id
            JOIN t_itp ON t_itp.id_itp = t_service_receipt.id_itp
            GROUP BY t_itp.no_po, t_service_receipt_detail.id_material
            UNION ALL
            SELECT
                sync_mutasi_stock.DOC_NO AS no_po, m_material.MATERIAL AS id_material, MAX(DATED)
            FROM sync_mutasi_stock
            JOIN m_material ON m_material.MATERIAL_CODE = sync_mutasi_stock.SEMIC_NO
            GROUP BY sync_mutasi_stock.DOC_NO, m_material.MATERIAL
        ) expediting', 't_purchase_order.po_no = expediting.no_po AND expediting.id_material = t_purchase_order_detail.material_id', 'left')
        ->group_by(array(
            't_purchase_order.po_no',
            't_purchase_order.title',
            't_purchase_order.po_date',
            'm_vendor.NAMA',
            'm_company.DESCRIPTION',
            'specialist.NAME',
            'm_departement.DEPARTMENT_DESC',
            'm_deliverypoint.DPOINT_DESC',
            't_purchase_order.delivery_date',
        ))
        ->generate();
    }
}
