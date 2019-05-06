<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Msr extends CI_Controller
{
    protected $menu = array();
    public function __construct() {
        parent::__construct();
        ini_set('max_execution_time', 3000);
        $this->db = $this->load->database('dashboard', TRUE);
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('dashboard/M_home', 'mhm');
        $this->load->model('vendor/M_all_intern', 'mai');

        $this->load->model('dashboard/m_dashboard');
        $this->load->model('dashboard/m_msr');

        $cek = $this->mai->cek_session();
        $get_menu = $this->mhm->menu('scm');
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
            'method',
            'specialist',
            'msr_status',
            'msr_type',
            'years',
            'months'
        );
        $this->template->display_dash('dashboard/V_msr', $data);
    }

    public function get() {
        $status = $this->get_status();
        $type = $this->get_type();
        $method = $this->get_procurement_method();
        $specialist = $this->get_procurement_specialist();
        echo json_encode(array(
            'status' => $status,
            'type' => $type,
            'method' => $method,
            'specialist' => $specialist
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
        $status_result = $this->m_msr->get_status($filter);
        $status = array();
        foreach ($status_result as $row) {
            $status[$row->status] = $row;
        }
        $status_trend_result = $this->m_msr->get_status_trend($filter);
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

    protected function get_type() {
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
        $msr_type = $this->m_dashboard->get_msr_type();
        $type_result = $this->m_msr->get_type($filter);
        $type = array();
        foreach ($type_result as $row) {
            $type[$row->msr_type] = $row;
        }
        $type_trend_result = $this->m_msr->get_type_trend($filter);
        $type_trend = array();
        foreach ($type_trend_result as $row) {
            $type_trend[$row->msr_type][$row->periode] = $row;
        }
        return array(
            'msr_type' => $msr_type,
            'periode' => $periode,
            'data' => array(
                'type' => $type,
                'type_trend' => $type_trend
            )
        );
    }

    protected function get_procurement_method() {
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
        $procurement_method = $this->m_dashboard->get_procurement_method();
        $method_result = $this->m_msr->get_method($filter);
        $method = array();
        foreach ($method_result as $row) {
            $method[$row->method] = $row;
        }
        $method_trend_result = $this->m_msr->get_method_trend($filter);
        $method_trend = array();
        foreach ($method_trend_result as $row) {
            $method_trend[$row->method][$row->periode] = $row;
        }
        return array(
            'procurement_method' => $procurement_method,
            'periode' => $periode,
            'data' => array(
                'method' => $method,
                'method_trend' => $method_trend
            )
        );
    }

    protected function get_procurement_specialist() {
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
        $procurement_specialist = $this->m_dashboard->get_procurement_specialist();
        $specialist_result = $this->m_msr->get_specialist($filter);
        $specialist = array();
        foreach ($specialist_result as $row) {
            $specialist[$row->specialist] = $row;
        }
        $specialist_trend_result = $this->m_msr->get_specialist_trend($filter);
        $specialist_trend = array();
        foreach ($specialist_trend_result as $row) {
            $specialist_trend[$row->specialist][$row->periode] = $row;
        }
        return array(
            'procurement_specialist' => $procurement_specialist,
            'periode' => $periode,
            'data' => array(
                'specialist' => $specialist,
                'specialist_trend' => $specialist_trend
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
            $condition[] = 'LEFT(t_msr.req_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 't_msr.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'm_user.ID_DEPARTMENT IN (\''.implode('\',\'', $filter['department']).'\')';
        }
        if (isset($filter['status'])) {
            $condition[] = 't_msr.status IN (\''.implode('\',\'', $filter['status']).'\')';
        }
        if (isset($filter['type'])) {
            $condition[] = 't_msr.id_msr_type IN (\''.implode('\',\'', $filter['type']).'\')';
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
        $this->datatable->resource('(
            (SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Preparation\' AS status FROM t_msr
            JOIN t_approval ON t_approval.data_id = t_msr.msr_no
            JOIN m_approval ON m_approval.id = t_approval.m_approval_id
            WHERE m_approval.module_kode = \'msr\'
            AND t_approval.status = 0)
            UNION ALL
            (SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Selection\' AS status FROM t_msr
            JOIN t_approval ON t_approval.data_id = t_msr.msr_no
            JOIN m_approval ON m_approval.id = t_approval.m_approval_id
            WHERE m_approval.module_kode = \'msr_spa\'
            AND t_msr.msr_no NOT IN (SELECT msr_no FROM t_purchase_order))
            UNION ALL
            (SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Completed\' AS status FROM t_msr
            JOIN t_approval ON t_approval.data_id = t_msr.msr_no
            JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no
            WHERE t_purchase_order.issued = 0)
            UNION ALL
            (SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Signed\' AS status FROM t_msr
            JOIN t_approval ON t_approval.data_id = t_msr.msr_no
            JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no
            WHERE t_purchase_order.issued = 1)
            UNION ALL
            (SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Canceled\' AS status FROM t_msr
            WHERE t_msr.status = 1)
            UNION ALL
            (SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Rejected\' AS status FROM t_msr
            LEFT JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no
            JOIN t_approval ON t_approval.data_id = t_msr.msr_no
            AND (
                SELECT COUNT(*) FROM t_approval a
                WHERE (a.data_id = t_msr.msr_no OR a.data_id = t_purchase_order.id)
                AND a.status = 2
            ) <> 0)
        ) t_msr',
        't_msr.*,
        m_msrtype.MSR_DESC as type,
        m_pmethod.PMETHOD_DESC as method,
        m_currency.CURRENCY as currency,
        t_msr.importation_desc as importation,
        t_msr.costcenter_desc as costcenter,
        m_company.DESCRIPTION as company,
        m_departement.DEPARTMENT_DESC as department,
        t_msr_item.material_id,
        t_msr_item.qty,
        t_msr_item.priceunit_base,
        t_msr_item.amount_base,
        t_msr_item.importation_desc as item_importation,
        m_material.MATERIAL_NAME as material,
        clasification.DESCRIPTION as clasification,
        category.DESCRIPTION as category,
        m_accsub.ACCSUB_DESC as accsub')
        ->join('m_user', 'm_user.ID_USER = t_msr.create_by', 'left')
        ->join('m_msrtype', 'm_msrtype.ID_MSR = t_msr.id_msr_type', 'left')
        ->join('m_pmethod', 'm_pmethod.ID_PMETHOD = t_msr.id_pmethod', 'left')
        ->join('m_currency', 'm_currency.ID = t_msr.id_currency_base', 'left')
        ->join('m_company', 'm_company.ID_COMPANY = t_msr.id_company', 'left')
        ->join('m_departement', 'm_departement.ID_DEPARTMENT = m_user.ID_DEPARTMENT', 'left')
        ->join('t_msr_item', 't_msr_item.msr_no = t_msr.msr_no', 'left')
        ->join('m_material_group category', 'category.TYPE = t_msr_item.id_itemtype AND category.MATERIAL_GROUP = CASE WHEN t_msr_item.id_itemtype = \'GOODS\' THEN CAST(LEFT(semic_no, 2) AS SIGNED) ELSE SUBSTRING_INDEX(SUBSTRING_INDEX(semic_no,\'.\', 2), \'.\', -1) END', 'left')
        ->join('m_material_group clasification', 'clasification.TYPE = t_msr_item.id_itemtype AND clasification.MATERIAL_GROUP = category.PARENT', 'left')
        ->join('m_accsub', 'm_accsub.ID_ACCSUB = t_msr_item.id_accsub', 'left')
        ->join('t_assignment', 't_assignment.msr_no = t_msr.msr_no', 'left')
        ->join('m_material', 'm_material.MATERIAL = t_msr_item.material_id', 'left')
        ->generate();
    }
}