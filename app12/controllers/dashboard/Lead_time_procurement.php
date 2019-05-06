<?php
class Lead_time_procurement extends CI_Controller
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
        $this->load->model('dashboard/m_lead_time_proc');

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
            'po_item_type',
            'method',
            'specialist',
            'years',
            'months'
        );
        $this->template->display_dash('dashboard/V_lead_time_proc', $data);
    }

    public function get_procurement_method() {
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
        $lead_time = array();
        $lead_time_trend = array();
        $procurement_method_steps = $this->m_lead_time_proc->get_procurement_method_steps($filter);
        foreach ($procurement_method_steps as $procurement_method_step) {
            $lead_time[$procurement_method_step->description][$procurement_method_step->id_pmethod] = $procurement_method_step;
        }
        $procurement_method_steps_trend = $this->m_lead_time_proc->get_procurement_method_steps_trend($filter);
        $lead_time_trend = array();
        foreach ($procurement_method_steps_trend as $procurement_method_step_trend) {
            $lead_time_trend[$procurement_method_step_trend->description][$procurement_method_step_trend->id_pmethod][$procurement_method_step_trend->periode] = $procurement_method_step_trend;
        }
        $rs_procurement_methods = $this->m_dashboard->get_procurement_method();
        $procurement_methods = array();
        foreach ($rs_procurement_methods as $procurement_method) {
            $procurement_methods[] = $procurement_method->ID_PMETHOD;
            $lead_time['KPI'][$procurement_method->ID_PMETHOD] = array(
                'description' => 'KPI',
                'step' => 10,
                'id_pmethod' => $procurement_method->ID_PMETHOD,
                'days' => $procurement_method->PROCESSING_TIME
            );
            foreach ($periode as $month) {
                $lead_time_trend['KPI'][$procurement_method->ID_PMETHOD][$month] = array(
                    'description' => 'KPI',
                    'step' => 10,
                    'id_pmethod' => $procurement_method->ID_PMETHOD,
                    'days' => $procurement_method->PROCESSING_TIME
                );
            }
        }
        echo json_encode(array(
            'procurement_methods' => $procurement_methods,
            'periode' => $periode,
            'data' => array(
                'lead_time' => $lead_time,
                'lead_time_trend' => $lead_time_trend
            )
        ));
    }

    public function get_procurement_specialists() {
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
            $condition_query = 'AND '.implode(' AND ', $condition);
        } else {
            $condition_query = '';
        }
        $this->load->library('datatable');
        $this->datatable->resource('m_user', 'm_user.ID_USER, m_user.USERNAME, m_user.NAME,
            COALESCE(CEIL(da.da), 0) AS da,
            COALESCE(CEIL(da.days), 0) AS da_days,
            COALESCE(CEIL(ds.ds), 0) AS ds,
            COALESCE(CEIL(ds.days), 0) as ds_days,
            COALESCE(CEIL(tender.tender), 0) AS tender,
            COALESCE(CEIL(tender.days), 0) as tender_days')
        ->JOIN('(
            SELECT DISTINCT
                t_assignment.user_id,
                COUNT(1) AS da,
                AVG(
                    DATEDIFF(
                        (
                        SELECT MAX(a.issued_date) FROM t_purchase_order a
                        WHERE a.msr_no = t_msr.msr_no
                        ),
                        (
                        SELECT a.created_at FROM t_approval a
                        JOIN m_approval b ON b.id = a.m_approval_id
                        WHERE a.data_id = t_msr.msr_no
                        AND b.module_kode = \'msr_spa\'
                        AND a.urutan = 2
                        )
                    )
                ) AS days
            FROM t_msr
            JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no AND t_purchase_order.issued = 1
            JOIN t_assignment ON t_assignment.msr_no = t_msr.msr_no
            JOIN m_user ON m_user.ID_USER = t_msr.create_by
            WHERE t_msr.id_pmethod = \'DA\'
            '.$condition_query.'
            GROUP BY t_assignment.user_id
        ) da', 'da.user_id = m_user.ID_USER', 'left')
        ->JOIN('(
            SELECT DISTINCT
                t_assignment.user_id,
                COUNT(1) AS ds,
                AVG(
                    DATEDIFF(
                        (
                        SELECT MAX(a.issued_date) FROM t_purchase_order a
                        WHERE a.msr_no = t_msr.msr_no
                        ),
                        (
                        SELECT a.created_at FROM t_approval a
                        JOIN m_approval b ON b.id = a.m_approval_id
                        WHERE a.data_id = t_msr.msr_no
                        AND b.module_kode = \'msr_spa\'
                        AND a.urutan = 2
                        )
                    )
                ) AS days
            FROM t_msr
            JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no AND t_purchase_order.issued = 1
            JOIN t_assignment ON t_assignment.msr_no = t_msr.msr_no
            JOIN m_user ON m_user.ID_USER = t_msr.create_by
            WHERE t_msr.id_pmethod = \'DS\'
            '.$condition_query.'
            GROUP BY t_assignment.user_id
        ) ds', 'ds.user_id = m_user.ID_USER', 'left')
        ->JOIN('(
            SELECT DISTINCT
                t_assignment.user_id,
                COUNT(1) AS tender,
                AVG(
                    DATEDIFF(
                        (
                        SELECT MAX(a.issued_date) FROM t_purchase_order a
                        WHERE a.msr_no = t_msr.msr_no
                        ),
                        (
                        SELECT a.created_at FROM t_approval a
                        JOIN m_approval b ON b.id = a.m_approval_id
                        WHERE a.data_id = t_msr.msr_no
                        AND b.module_kode = \'msr_spa\'
                        AND a.urutan = 2
                        )
                    )
                ) AS days
            FROM t_msr
            JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no AND t_purchase_order.issued = 1
            JOIN t_assignment ON t_assignment.msr_no = t_msr.msr_no
            JOIN m_user ON m_user.ID_USER = t_msr.create_by
            WHERE t_msr.id_pmethod = \'TN\'
            '.$condition_query.'
            GROUP BY t_assignment.user_id
        ) tender', 'tender.user_id = m_user.ID_USER', 'left')
        ->like('m_user.ROLES', '28')
        ->generate();
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
            $condition[] = 'LEFT(msr.po_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'msr.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'm_user.ID_DEPARTMENT IN (\''.implode('\',\'', $filter['department']).'\')';
        }
        if (isset($filter['type'])) {
            $condition[] = 'msr.po_type IN (\''.implode('\',\'', $filter['type']).'\')';
        }
        if (isset($filter['method'])) {
            $condition[] = 'msr.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
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
        $this->datatable->resource('(
            SELECT DISTINCT
                t_msr.*,
                t_purchase_order.po_no,
                t_purchase_order.po_date,
                t_purchase_order.po_type,
                t_msr.create_on AS create_date,
                (
                    SELECT a.created_at FROM t_approval a
                    JOIN m_approval b ON b.id = a.m_approval_id
                    WHERE a.data_id = t_msr.msr_no
                    AND b.module_kode = \'msr\'
                    AND a.urutan = 1
                ) AS approval_manager_date,
                (
                    SELECT a.created_at FROM t_approval a
                    JOIN m_approval b ON b.id = a.m_approval_id
                    WHERE a.data_id = t_msr.msr_no
                    AND b.module_kode = \'msr\'
                    AND b.role_id = 19
                ) AS inventory_control_date,
                (
                    SELECT a.created_at FROM t_approval a
                    JOIN m_approval b ON b.id = a.m_approval_id
                    WHERE a.data_id = t_msr.msr_no
                    AND b.module_kode = \'msr\'
                    AND b.role_id = 20
                ) AS approval_bsd_staff_date,
                (
                    SELECT a.created_at FROM t_approval a
                    JOIN m_approval b ON b.id = a.m_approval_id
                    WHERE a.data_id = t_msr.msr_no
                    AND b.module_kode = \'msr\'
                    AND b.role_id = 21
                ) AS approval_vp_bsd_date,
                (
                    SELECT a.created_at FROM t_approval a
                    JOIN m_approval b ON b.id = a.m_approval_id
                    WHERE a.data_id = t_msr.msr_no
                    AND b.module_kode = \'msr\'
                    ORDER BY a.urutan DESC
                    LIMIT 1
                ) AS approval_aas_date,
                (
                    SELECT a.created_at FROM t_approval a
                    JOIN m_approval b ON b.id = a.m_approval_id
                    WHERE a.data_id = t_msr.msr_no
                    AND b.module_kode = \'msr_spa\'
                    AND a.urutan = 1
                ) AS verification_date,
                (
                    SELECT a.created_at FROM t_approval a
                    JOIN m_approval b ON b.id = a.m_approval_id
                    WHERE a.data_id = t_msr.msr_no
                    AND b.module_kode = \'msr_spa\'
                    AND a.urutan = 2
                ) AS assignment_date,
                (
                    SELECT a.created_at FROM t_approval a
                    JOIN m_approval b ON b.id = a.m_approval_id
                    WHERE a.data_id = t_msr.msr_no
                    AND b.module_kode = \'msr_spa\'
                    ORDER BY a.urutan DESC
                    LIMIT 1
                ) AS ed_issuance_date,
                t_eq_data.closing_date AS bid_opening_date,
                (
                    SELECT MAX(a.accept_award_date) FROM t_bl_detail a
                    WHERE a.msr_no = t_msr.msr_no
                ) AS awarding_date,
                (
                    SELECT MAX(a.issued_date) FROM t_purchase_order a
                    WHERE a.msr_no = t_msr.msr_no
                ) AS agreement_date
            FROM t_msr
            JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no AND t_purchase_order.issued = 1
            JOIN t_eq_data ON t_eq_data.msr_no = t_msr.msr_no
        ) msr', 'msr.*')
        ->join('t_assignment', 't_assignment.msr_no = msr.msr_no')
        ->join('m_user', 'm_user.ID_USER = msr.create_by')
        ->join('m_msrtype', 'm_msrtype.ID_MSR = msr.id_msr_type')
        ->join('m_pmethod', 'm_pmethod.ID_PMETHOD = msr.id_pmethod')
        ->join('m_company', 'm_company.ID_COMPANY = msr.id_company')
        ->generate();
    }
}