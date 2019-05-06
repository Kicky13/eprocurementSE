<?php
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
class Arf extends CI_Controller
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

        $this->load->model('dashboard/M_msr_old', 'msr');
        $this->load->model('dashboard/M_arf', 'm_arf');
        $this->load->model('vendor/M_all_intern', 'mai');
        $this->load->model('dashboard/m_msr');


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
            'arf_status',
            'arf_type',
            'method',
            'specialist',
            'years',
            'months'
        );
        $this->template->display_dash('dashboard/V_arf', $data);
    }

    public function get() {
        $status = $this->get_status();
        $type = $this->get_type();
        $specialist = $this->get_procurement_specialist();
        echo json_encode(array(
            'status' => $status,
            'type' => $type,
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
        $status_result = $this->m_arf->get_status($filter);
        $status = array();
        foreach ($status_result as $row) {
            $status[$row->status] = $row;
        }
        $status_trend_result = $this->m_arf->get_status_trend($filter);
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
        $type_result = $this->m_arf->get_type($filter);
        $type = array();
        foreach ($type_result as $row) {
            $type[$row->arf_type] = $row;
        }
        $type_trend_result = $this->m_arf->get_type_trend($filter);
        $type_trend = array();
        foreach ($type_trend_result as $row) {
            $type_trend[$row->arf_type][$row->periode] = $row;
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
        $specialist_result = $this->m_arf->get_specialist($filter);
        $specialist = array();
        foreach ($specialist_result as $row) {
            $specialist[$row->specialist] = $row;
        }
        $specialist_trend_result = $this->m_arf->get_specialist_trend($filter);
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
            $condition[] = 'LEFT(arf_t.created_at, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'msr.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'm_user.ID_DEPARTMENT IN (\''.implode('\',\'', $filter['department']).'\')';
        }
        if (isset($filter['status'])) {
            $condition[] = 'arf_t.status IN (\''.implode('\',\'', $filter['status']).'\')';
        }
        if (isset($filter['type'])) {
            $condition[] = 'arf_t.arf_type IN (\''.implode('\',\'', $filter['type']).'\')';
        }
        if (isset($filter['method'])) {
            $condition[] = 'msr.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
        }
        if (isset($filter['specialist'])) {
            $condition[] = 'arf_t.created_by IN (\''.implode('\',\'', $filter['specialist']).'\')';
        }
        if (count($condition) <> 0) {
            $condition_query = 'WHERE '.implode(' AND ', $condition);
        } else {
            $condition_query = '';
        }
        $this->load->library('datatable');
        $this->datatable->resource(" ( SELECT DISTINCT arf_t.*, det.material_desc, det.qty, det.uom, det.unit_price_base, det.total_price_base FROM (	SELECT 'Preparation' as status, CASE WHEN po.po_type = 10 THEN 'Goods' WHEN po.po_type = 20 THEN 'Services' ELSE 'Blanked' END as arf_type, f.po_no, f.created_by, f.created_at, f.total_base, mu.NAME as specialist, f.id, f.po_title, f.doc_no
    		FROM t_arf as f
    		JOIN t_purchase_order po ON po.po_no=f.po_no
    		JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf GROUP BY id_ref) a ON a.id_ref=f.id
    		JOIN t_approval_arf b ON b.id_ref=a.id_ref AND b.sequence=a.sequence AND b.status=0
    		LEFT JOIN m_user mu ON mu.ID_USER=f.created_by AND mu.ROLES LIKE '%,28,%'
    		WHERE 1=1
    		UNION
    		SELECT 'Preparation' as status, CASE WHEN po.po_type = 10 THEN 'Goods' WHEN po.po_type = 20 THEN 'Services' ELSE 'Blanked' END as arf_type, n.po_no, f.created_by, f.created_at, f.total_base, mu.NAME as specialist, f.id, f.po_title, f.doc_no
    		FROM t_arf as f
    		JOIN t_purchase_order po ON po.po_no=f.po_no
    		JOIN t_arf_notification n ON n.po_no=f.po_no
    		JOIN (SELECT max(sequence) as sequence, doc_id FROM t_approval_arf_notification GROUP BY doc_id) a ON a.doc_id=n.id
    		JOIN t_approval_arf_notification b ON b.doc_id=a.doc_id AND b.sequence=a.sequence AND b.status_approve=0
    		LEFT JOIN m_user mu ON mu.ID_USER=f.created_by AND mu.ROLES LIKE '%,28,%'
    		WHERE 1=1
    		UNION
    		SELECT 'Preparation' as status, CASE WHEN po.po_type = 10 THEN 'Goods' WHEN po.po_type = 20 THEN 'Services' ELSE 'Blanked' END as arf_type, n.po_no, f.created_by, f.created_at, f.total_base, mu.NAME as specialist, f.id, f.po_title, f.doc_no
    		FROM t_arf as f
    		JOIN t_purchase_order po ON po.po_no=f.po_no
    		JOIN t_arf_recommendation_preparation n ON n.po_no=f.po_no
    		JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf_recom GROUP BY id_ref) a ON a.id_ref=n.id
    		JOIN t_approval_arf_recom b ON b.id_ref=a.id_ref AND b.sequence=a.sequence AND b.status=0
    		LEFT JOIN m_user mu ON mu.ID_USER=f.created_by AND mu.ROLES LIKE '%,28,%'
    		WHERE 1=1

    		UNION ALL

    		SELECT 'Completed' as status, CASE WHEN po.po_type = 10 THEN 'Goods' WHEN po.po_type = 20 THEN 'Services' ELSE 'Blanked' END as arf_type, f.po_no, f.created_by, f.created_at, f.total_base, mu.NAME as specialist, f.id, f.po_title, f.doc_no
    		FROM t_arf as f
    		JOIN t_purchase_order po ON po.po_no=f.po_no
    		JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf GROUP BY id_ref) a ON a.id_ref=f.id
    		JOIN t_approval_arf b ON b.id_ref=a.id_ref AND b.sequence=a.sequence AND b.status=1
    		JOIN t_arf_notification n ON n.doc_no=f.doc_no
    		JOIN (SELECT max(sequence) as sequence, doc_id FROM t_approval_arf_notification GROUP BY doc_id) aa ON aa.doc_id=f.id
    		JOIN t_approval_arf_notification taan ON taan.sequence=aa.sequence AND taan.status_approve = 1
    		JOIN t_arf_recommendation_preparation r ON r.doc_no=f.doc_no
    		JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf_recom GROUP BY id_ref) aaa ON aaa.id_ref=f.id
    		JOIN t_approval_arf_recom taar ON taar.sequence=aaa.sequence AND taar.status=1
    		LEFT JOIN m_user mu ON mu.ID_USER=f.created_by AND mu.ROLES LIKE '%,28,%'
    		WHERE f.doc_no NOT IN (SELECT doc_no FROM t_arf_acceptance)

    		UNION ALL

    		SELECT DISTINCT 'Signed' as status, CASE WHEN po.po_type = 10 THEN 'Goods' WHEN po.po_type = 20 THEN 'Services' ELSE 'Blanked' END as arf_type, f.po_no, f.created_by, f.created_at, f.total_base, mu.NAME as specialist, f.id, f.po_title, f.doc_no
    		FROM t_arf as f
    		JOIN t_purchase_order po ON po.po_no=f.po_no
    		JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf GROUP BY id_ref) a ON a.id_ref=f.id
    		JOIN t_approval_arf b ON b.id_ref=a.id_ref AND b.sequence=a.sequence AND b.status=1
    		JOIN t_arf_notification n ON n.doc_no=f.doc_no
    		JOIN (SELECT max(sequence) as sequence, doc_id FROM t_approval_arf_notification GROUP BY doc_id) aa ON aa.doc_id=f.id
    		JOIN t_approval_arf_notification taan ON taan.sequence=aa.sequence AND taan.status_approve = 1
    		JOIN t_arf_recommendation_preparation r ON r.doc_no=f.doc_no
    		JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf_recom GROUP BY id_ref) aaa ON aaa.id_ref=f.id
    		JOIN t_approval_arf_recom taar ON taar.sequence=aaa.sequence AND taar.status=1
    		LEFT JOIN m_user mu ON mu.ID_USER=f.created_by AND mu.ROLES LIKE '%,28,%'
    		WHERE f.doc_no IN (SELECT doc_no FROM t_arf_acceptance) ) arf_t
        JOIN t_arf_detail det ON det.doc_id=arf_t.id
    		LEFT JOIN t_purchase_order ON t_purchase_order.po_no=arf_t.po_no
    		LEFT JOIN t_msr msr ON msr.msr_no=t_purchase_order.msr_no
    		LEFT JOIN m_user ON m_user.ID_USER=arf_t.created_by
    		LEFT JOIN t_assignment ON t_assignment.msr_no = msr.msr_no
        ".$condition_query." ) tabel_arf ")
        ->generate();
    }
}
