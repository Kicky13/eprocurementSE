<?php
class Inventory_stock extends CI_Controller
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
        $this->load->model('dashboard/m_inventory_stock');

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
            'movement_type',
            'user',
            'material_group',
            'years',
            'months'
        );
        $data['rs_company'] = $this->m_dashboard->get_company();
        $this->template->display_dash('dashboard/V_inventory_stock', $data);
    }

    public function get_stock_moving() {
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
        $rs_company = $this->m_dashboard->get_company();
        $movement_types = $this->m_dashboard->get_movement_types();
        $rs_stock_moving = $this->m_inventory_stock->get_stock_moving($filter);

        //echopre($rs_stock_moving);
        $stock_moving = array();
        foreach ($rs_stock_moving as $r_stock_moving) {
            $stock_moving[$r_stock_moving->ID_COMPANY][$r_stock_moving->DOC] = $r_stock_moving;
        }
        $rs_stock_moving_trend = $this->m_inventory_stock->get_stock_moving_trend($filter);
        $stock_moving_trend = array();
        foreach ($rs_stock_moving_trend as $r_stock_moving_trend) {
            $stock_moving_trend[$r_stock_moving_trend->ID_COMPANY][$r_stock_moving_trend->DOC][$r_stock_moving_trend->PERIODE] = $r_stock_moving_trend;
        }
        echo json_encode(array(
            'periode' => $periode,
            'data' => array (
                'companies' => $rs_company,
                'movement_types' => $movement_types,
                'stock_moving' => $stock_moving,
                'stock_moving_trend' => $stock_moving_trend
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
        if (isset($filter['periode']) <> 0) {
            $condition[] = 'LEFT(sync_mutasi_stock.CREATED, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'm_company.ID_COMPANY IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'CASE
                WHEN ref_trans.ID_DEPARTMENT IS NULL AND CONCAT(m_company.ID_COMPANY, \'3800\') IN (\''.implode('\',\'', $filter['department']).'\') THEN TRUE
                ELSE  ref_trans.ID_DEPARTMENT IN (\''.implode('\',\'', $filter['department']).'\')
            END';
        }
        if (isset($filter['movement_type'])) {
            $condition[] = 'm_mutasi_doc_type.id IN (\''.implode('\',\'', $filter['movement_type']).'\')';
        }
        if (isset($filter['category'])) {
            $condition[] = 'CAST(LEFT(sync_mutasi_stock.SEMIC_NO, 2) AS SIGNED) IN (\''.implode('\',\'', $filter['category']).'\')';
        }
        if (count($condition) <> 0) {
            $condition_query = 'WHERE '.implode(' AND ', $condition);
        } else {
            $condition_query = '';
        }
        $sql = "SELECT
            moving_stock.SEMIC_NO,
            SUM(moving_stock.QTY) AS QTY,
            (SUM(moving_stock.TOTAL)/SUM(moving_stock.QTY)) AS UNIT_PRICE,
            SUM(moving_stock.TOTAL) AS TOTAL,
            moving_stock.MATERIAL_NAME,
            moving_stock.UOM,
            moving_stock.BPLANT_DESC,
            SUM(moving_stock.RECEIPT_QTY) AS RECEIPT_QTY,
            SUM(moving_stock.ISSUED_QTY) AS ISSUED_QTY,
            SUM(moving_stock.RETURN_QTY) AS RETURN_QTY
        FROM (
            SELECT
                LEFT(sync_mutasi_stock.CREATED, 7) AS PERIODE,
                sync_mutasi_stock.SEMIC_NO,
                sync_mutasi_stock.BRACH_PLANT,
                SUM(sync_mutasi_stock.QTY) AS QTY,
                (SUM(sync_mutasi_stock.TOTAL)/SUM(sync_mutasi_stock.QTY)) AS UNIT_PRICE,
                SUM(sync_mutasi_stock.TOTAL) as TOTAL,
                m_material.MATERIAL_NAME,
                m_material.UOM1 as UOM,
                m_bplant.BPLANT_DESC,
                COALESCE(rec.QTY,0) AS RECEIPT_QTY,
                COALESCE(iss.QTY,0) AS ISSUED_QTY,
                COALESCE(ret.QTY,0) AS RETURN_QTY
            FROM sync_mutasi_stock
            JOIN m_material ON m_material.MATERIAL_CODE = sync_mutasi_stock.SEMIC_NO
            JOIN m_bplant ON m_bplant.ID_BPLANT = TRIM(sync_mutasi_stock.BRACH_PLANT)
            JOIN m_company ON m_company.ID_COMPANY = LEFT(m_bplant.ID_BPLANT, 5)
            LEFT JOIN (
                SELECT
                    t_purchase_order.id AS DOC_NO,
                    t_purchase_order.id AS REF_NO,
                    'PO' AS DOC,
                    1 AS DOC_TYPE,
                    m_user.ID_DEPARTMENT,
                    t_msr.create_by AS REQUESTOR
                FROM t_purchase_order
                JOIN t_msr ON t_purchase_order.msr_no = t_msr.msr_no
                JOIN m_user ON m_user.ID_USER = t_msr.create_by
                UNION
                SELECT
                    t_material_request.request_no AS DOC_NO,
                    t_material_request.request_no AS REF_NO,
                    'MR' AS DOC,
                    document_type AS DOC_TYPE,
                    m_user.ID_DEPARTMENT,
                    t_material_request.create_by AS REQUESTOR
                FROM t_material_request
                JOIN m_material_request_type ON m_material_request_type.id = t_material_request.document_type
                JOIN m_user ON m_user.ID_USER = t_material_request.create_by
            ) ref_trans ON ref_trans.DOC_NO = sync_mutasi_stock.DOC_NO
            LEFT JOIN m_mutasi_doc_type_ref ON m_mutasi_doc_type_ref.ref_doc = ref_trans.DOC COLLATE 'utf8_unicode_ci' AND m_mutasi_doc_type_ref.ref_doc_type = ref_trans.DOC_TYPE
            LEFT JOIN m_mutasi_doc_type ON CASE
                WHEN m_mutasi_doc_type_ref.id_mutasi_doc_type IS NOT NULL THEN m_mutasi_doc_type.id = m_mutasi_doc_type_ref.id_mutasi_doc_type
                ELSE m_mutasi_doc_type.doc_type = sync_mutasi_stock.DOC
            END
            LEFT JOIN (
                SELECT LEFT(rec.CREATED, 7) PERIODE, rec.SEMIC_NO, SUM(rec.QTY) AS QTY FROM sync_mutasi_stock rec
                WHERE DOC = 'OV'
                GROUP BY LEFT(rec.CREATED, 7), rec.SEMIC_NO
            ) rec ON rec.PERIODE = LEFT(sync_mutasi_stock.CREATED, 7)  COLLATE 'utf8_unicode_ci' AND rec.SEMIC_NO COLLATE latin1_swedish_ci  = sync_mutasi_stock.SEMIC_NO
            LEFT JOIN (
                SELECT LEFT(iss.CREATED, 7) PERIODE, iss.SEMIC_NO, SUM(iss.QTY) AS QTY FROM sync_mutasi_stock iss
                WHERE DOC = 'II'
                GROUP BY LEFT(iss.CREATED, 7), iss.SEMIC_NO
            ) iss ON iss.PERIODE = LEFT(sync_mutasi_stock.CREATED, 7)  AND iss.SEMIC_NO  COLLATE latin1_swedish_ci = sync_mutasi_stock.SEMIC_NO
            LEFT JOIN (
                SELECT LEFT(ret.CREATED, 7) PERIODE, ret.SEMIC_NO, SUM(ret.QTY) AS QTY FROM sync_mutasi_stock ret
                WHERE DOC = 'II'
                GROUP BY LEFT(ret.CREATED, 7), ret.SEMIC_NO
            ) ret ON ret.PERIODE = LEFT(sync_mutasi_stock.CREATED, 7) AND ret.SEMIC_NO  COLLATE latin1_swedish_ci = sync_mutasi_stock.SEMIC_NO
            ".$condition_query."
            GROUP BY LEFT(CREATED, 7), sync_mutasi_stock.SEMIC_NO, sync_mutasi_stock.BRACH_PLANT, m_material.MATERIAL_NAME, m_material.UOM1, m_bplant.BPLANT_DESC, rec.QTY, iss.QTY, ret.QTY
        ) moving_stock
        GROUP BY moving_stock.SEMIC_NO,moving_stock.MATERIAL_NAME,moving_stock.UOM,moving_stock.BPLANT_DESC";
        $result = $this->db->query($sql)
        ->result();
        $response = array(
            'data' => $result
        );
        echo json_encode($response);
    }
}