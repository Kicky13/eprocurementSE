<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_msr extends CI_Model {

    public function get_status($filter) {
        $condition = array();
        if (isset($filter['periode'])) {
            $condition[] = 'LEFT(msr.req_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'msr.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'm_user.ID_DEPARTMENT IN (\''.implode('\',\'', $filter['department']).'\')';
        }
        if (isset($filter['status'])) {
            $condition[] = 'msr.status IN (\''.implode('\',\'', $filter['status']).'\')';
        }
        if (isset($filter['type'])) {
            $condition[] = 'msr.id_msr_type IN (\''.implode('\',\'', $filter['type']).'\')';
        }
        if (isset($filter['method'])) {
            $condition[] = 'msr.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
        }
        if (isset($filter['specialist'])) {
            $condition[] = 't_assignment.user_id IN (\''.implode('\',\'', $filter['specialist']).'\')';
        }
        if (count($condition) <> 0) {
            $condition_query = 'WHERE '.implode(' AND ', $condition);
        } else {
            $condition_query = '';
        }
        $sql = 'SELECT COUNT(1) AS number, SUM(value) AS value, status FROM (
            SELECT msr.*, SUM(total_amount_base) AS value FROM (
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Preparation\' AS status FROM t_msr
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                JOIN m_approval ON m_approval.id = t_approval.m_approval_id
                WHERE m_approval.module_kode = \'msr\'
                AND t_approval.status = 0
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Selection\' AS status FROM t_msr
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                JOIN m_approval ON m_approval.id = t_approval.m_approval_id
                WHERE m_approval.module_kode = \'msr_spa\'
                AND t_msr.msr_no NOT IN (SELECT msr_no FROM t_purchase_order)
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Completed\' AS status FROM t_msr
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no
                WHERE t_purchase_order.issued = 0
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Signed\' AS status FROM t_msr
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no
                WHERE t_purchase_order.issued = 1
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Canceled\' AS status FROM t_msr
                WHERE t_msr.status = 1
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Rejected\' AS status FROM t_msr
                LEFT JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                AND (
                    SELECT COUNT(*) FROM t_approval a
                    WHERE (a.data_id = t_msr.msr_no OR a.data_id = t_purchase_order.id)
                    AND a.status = 2
                ) <> 0
            ) msr
            JOIN m_user ON m_user.ID_USER = msr.create_by
            LEFT JOIN t_assignment ON t_assignment.msr_no = msr.msr_no
            '.$condition_query.'
            GROUP BY msr.msr_no,msr.id_company,msr.company_desc,msr.id_department,msr.department_desc,msr.id_msr_type,msr.msr_type_desc,msr.title,msr.blanket,msr.id_currency,msr.id_currency_base,msr.req_date,msr.lead_time,msr.id_ploc,msr.rloc_desc,msr.id_pmethod,msr.pmethod_desc,msr.scope_of_work,msr.create_by,msr.create_on,msr.id_dpoint,msr.dpoint_desc,msr.id_importation,msr.importation_desc,msr.id_requestfor,msr.requestfor_desc,msr.id_inspection,msr.inspection_desc,msr.id_deliveryterm,msr.deliveryterm_desc,msr.id_freight,msr.freight_desc,msr.total_amount,msr.total_amount_base,msr.procure_processing_time,msr.id_costcenter,msr.costcenter_desc,msr.status
        ) msr
        GROUP BY status';
        return $this->db->query($sql)->result();
    }

    public function get_status_trend($filter) {
        $condition = array();
        if (isset($filter['periode'])) {
            $condition[] = 'LEFT(msr.req_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'msr.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'm_user.ID_DEPARTMENT IN (\''.implode('\',\'', $filter['department']).'\')';
        }
        if (isset($filter['status'])) {
            $condition[] = 'msr.status IN (\''.implode('\',\'', $filter['status']).'\')';
        }
        if (isset($filter['type'])) {
            $condition[] = 'msr.id_msr_type IN (\''.implode('\',\'', $filter['type']).'\')';
        }
        if (isset($filter['method'])) {
            $condition[] = 'msr.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
        }
        if (isset($filter['specialist'])) {
            $condition[] = 't_assignment.user_id IN (\''.implode('\',\'', $filter['specialist']).'\')';
        }
        if (count($condition) <> 0) {
            $condition_query = 'WHERE '.implode(' AND ', $condition);
        } else {
            $condition_query = '';
        }
        $sql = 'SELECT COUNT(1) AS number, periode, SUM(value) AS value, status FROM (
            SELECT msr.*, LEFT(req_date,7) as periode, SUM(total_amount_base) AS value FROM (
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Preparation\' AS status FROM t_msr
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                JOIN m_approval ON m_approval.id = t_approval.m_approval_id
                WHERE m_approval.module_kode = \'msr\'
                AND t_approval.status = 0
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Selection\' AS status FROM t_msr
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                JOIN m_approval ON m_approval.id = t_approval.m_approval_id
                WHERE m_approval.module_kode = \'msr_spa\'
                AND t_msr.msr_no NOT IN (SELECT msr_no FROM t_purchase_order)
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Completed\' AS status FROM t_msr
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no
                WHERE t_purchase_order.issued = 0
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Signed\' AS status FROM t_msr
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no
                WHERE t_purchase_order.issued = 1
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Canceled\' AS status FROM t_msr
                WHERE t_msr.status = 1
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Rejected\' AS status FROM t_msr
                LEFT JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                AND (
                    SELECT COUNT(*) FROM t_approval a
                    WHERE (a.data_id = t_msr.msr_no OR a.data_id = t_purchase_order.id)
                    AND a.status = 2
                ) <> 0
            ) msr
            JOIN m_user ON m_user.ID_USER = msr.create_by
            LEFT JOIN t_assignment ON t_assignment.msr_no = msr.msr_no
            '.$condition_query.'
            GROUP BY msr.msr_no,msr.id_company,msr.company_desc,msr.id_department,msr.department_desc,msr.id_msr_type,msr.msr_type_desc,msr.title,msr.blanket,msr.id_currency,msr.id_currency_base,msr.req_date,msr.lead_time,msr.id_ploc,msr.rloc_desc,msr.id_pmethod,msr.pmethod_desc,msr.scope_of_work,msr.create_by,msr.create_on,msr.id_dpoint,msr.dpoint_desc,msr.id_importation,msr.importation_desc,msr.id_requestfor,msr.requestfor_desc,msr.id_inspection,msr.inspection_desc,msr.id_deliveryterm,msr.deliveryterm_desc,msr.id_freight,msr.freight_desc,msr.total_amount,msr.total_amount_base,msr.procure_processing_time,msr.id_costcenter,msr.costcenter_desc,msr.status,LEFT(req_date, 7)
        ) msr
        GROUP BY status, periode';
        return $this->db->query($sql)->result();
    }

    public function get_type($filter) {
        $condition = array();
        if (isset($filter['periode'])) {
            $condition[] = 'LEFT(msr.req_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'msr.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'm_user.ID_DEPARTMENT IN (\''.implode('\',\'', $filter['department']).'\')';
        }
        if (isset($filter['status'])) {
            $condition[] = 'msr.status IN (\''.implode('\',\'', $filter['status']).'\')';
        }
        if (isset($filter['type'])) {
            $condition[] = 'msr.id_msr_type IN (\''.implode('\',\'', $filter['type']).'\')';
        }
        if (isset($filter['method'])) {
            $condition[] = 'msr.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
        }
        if (isset($filter['specialist'])) {
            $condition[] = 't_assignment.user_id IN (\''.implode('\',\'', $filter['specialist']).'\')';
        }
        if (count($condition) <> 0) {
            $condition_query = 'WHERE '.implode(' AND ', $condition);
        } else {
            $condition_query = '';
        }
        $sql = 'SELECT COUNT(1) AS number, SUM(value) AS value, msr_type FROM (
            SELECT msr.*, m_msrtype.MSR_DESC as msr_type, SUM(total_amount_base) AS value FROM (
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Preparation\' AS status FROM t_msr
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                JOIN m_approval ON m_approval.id = t_approval.m_approval_id
                WHERE m_approval.module_kode = \'msr\'
                AND t_approval.status = 0
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Selection\' AS status FROM t_msr
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                JOIN m_approval ON m_approval.id = t_approval.m_approval_id
                WHERE m_approval.module_kode = \'msr_spa\'
                AND t_msr.msr_no NOT IN (SELECT msr_no FROM t_purchase_order)
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Completed\' AS status FROM t_msr
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no
                WHERE t_purchase_order.issued = 0
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Signed\' AS status FROM t_msr
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no
                WHERE t_purchase_order.issued = 1
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Canceled\' AS status FROM t_msr
                WHERE t_msr.status = 1
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Rejected\' AS status FROM t_msr
                LEFT JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                AND (
                    SELECT COUNT(*) FROM t_approval a
                    WHERE (a.data_id = t_msr.msr_no OR a.data_id = t_purchase_order.id)
                    AND a.status = 2
                ) <> 0
            ) msr
            JOIN m_msrtype on m_msrtype.ID_MSR = msr.id_msr_type
            JOIN m_user ON m_user.ID_USER = msr.create_by
            LEFT JOIN t_assignment ON t_assignment.msr_no = msr.msr_no
            '.$condition_query.'
            GROUP BY msr.msr_no,msr.id_company,msr.company_desc,msr.id_department,msr.department_desc,msr.id_msr_type,msr.msr_type_desc,msr.title,msr.blanket,msr.id_currency,msr.id_currency_base,msr.req_date,msr.lead_time,msr.id_ploc,msr.rloc_desc,msr.id_pmethod,msr.pmethod_desc,msr.scope_of_work,msr.create_by,msr.create_on,msr.id_dpoint,msr.dpoint_desc,msr.id_importation,msr.importation_desc,msr.id_requestfor,msr.requestfor_desc,msr.id_inspection,msr.inspection_desc,msr.id_deliveryterm,msr.deliveryterm_desc,msr.id_freight,msr.freight_desc,msr.total_amount,msr.total_amount_base,msr.procure_processing_time,msr.id_costcenter,msr.costcenter_desc,msr.status,m_msrtype.MSR_DESC
        ) msr
        GROUP BY msr_type';
        return $this->db->query($sql)->result();
    }

    public function get_type_trend($filter) {
        $condition = array();
        if (isset($filter['periode'])) {
            $condition[] = 'LEFT(msr.req_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'msr.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'm_user.ID_DEPARTMENT IN (\''.implode('\',\'', $filter['department']).'\')';
        }
        if (isset($filter['status'])) {
            $condition[] = 'msr.status IN (\''.implode('\',\'', $filter['status']).'\')';
        }
        if (isset($filter['type'])) {
            $condition[] = 'msr.id_msr_type IN (\''.implode('\',\'', $filter['type']).'\')';
        }
        if (isset($filter['method'])) {
            $condition[] = 'msr.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
        }
        if (isset($filter['specialist'])) {
            $condition[] = 't_assignment.user_id IN (\''.implode('\',\'', $filter['specialist']).'\')';
        }
        if (count($condition) <> 0) {
            $condition_query = 'WHERE '.implode(' AND ', $condition);
        } else {
            $condition_query = '';
        }
        $sql = 'SELECT COUNT(1) AS number, periode, SUM(value) AS value, msr_type FROM (
            SELECT msr.*, m_msrtype.MSR_DESC as msr_type, LEFT(req_date,7) as periode, SUM(total_amount_base) AS value FROM (
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Preparation\' AS status FROM t_msr
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                JOIN m_approval ON m_approval.id = t_approval.m_approval_id
                WHERE m_approval.module_kode = \'msr\'
                AND t_approval.status = 0
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Selection\' AS status FROM t_msr
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                JOIN m_approval ON m_approval.id = t_approval.m_approval_id
                WHERE m_approval.module_kode = \'msr_spa\'
                AND t_msr.msr_no NOT IN (SELECT msr_no FROM t_purchase_order)
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Completed\' AS status FROM t_msr
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no
                WHERE t_purchase_order.issued = 0
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Signed\' AS status FROM t_msr
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no
                WHERE t_purchase_order.issued = 1
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Canceled\' AS status FROM t_msr
                WHERE t_msr.status = 1
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Rejected\' AS status FROM t_msr
                LEFT JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                AND (
                    SELECT COUNT(*) FROM t_approval a
                    WHERE (a.data_id = t_msr.msr_no OR a.data_id = t_purchase_order.id)
                    AND a.status = 2
                ) <> 0
            ) msr
            JOIN m_msrtype on m_msrtype.ID_MSR = msr.id_msr_type
            JOIN m_user ON m_user.ID_USER = msr.create_by
            LEFT JOIN t_assignment ON t_assignment.msr_no = msr.msr_no
            '.$condition_query.'
            GROUP BY msr.msr_no,msr.id_company,msr.company_desc,msr.id_department,msr.department_desc,msr.id_msr_type,msr.msr_type_desc,msr.title,msr.blanket,msr.id_currency,msr.id_currency_base,msr.req_date,msr.lead_time,msr.id_ploc,msr.rloc_desc,msr.id_pmethod,msr.pmethod_desc,msr.scope_of_work,msr.create_by,msr.create_on,msr.id_dpoint,msr.dpoint_desc,msr.id_importation,msr.importation_desc,msr.id_requestfor,msr.requestfor_desc,msr.id_inspection,msr.inspection_desc,msr.id_deliveryterm,msr.deliveryterm_desc,msr.id_freight,msr.freight_desc,msr.total_amount,msr.total_amount_base,msr.procure_processing_time,msr.id_costcenter,msr.costcenter_desc,msr.status,LEFT(req_date, 7),m_msrtype.MSR_DESC
        ) msr
        GROUP BY msr_type, periode';
        return $this->db->query($sql)->result();
    }

    public function get_method($filter) {
        $condition = array();
        if (isset($filter['periode'])) {
            $condition[] = 'LEFT(msr.req_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'msr.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'm_user.ID_DEPARTMENT IN (\''.implode('\',\'', $filter['department']).'\')';
        }
        if (isset($filter['status'])) {
            $condition[] = 'msr.status IN (\''.implode('\',\'', $filter['status']).'\')';
        }
        if (isset($filter['type'])) {
            $condition[] = 'msr.id_msr_type IN (\''.implode('\',\'', $filter['type']).'\')';
        }
        if (isset($filter['method'])) {
            $condition[] = 'msr.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
        }
        if (isset($filter['specialist'])) {
            $condition[] = 't_assignment.user_id IN (\''.implode('\',\'', $filter['specialist']).'\')';
        }
        if (count($condition) <> 0) {
            $condition_query = 'WHERE '.implode(' AND ', $condition);
        } else {
            $condition_query = '';
        }
        $sql = 'SELECT COUNT(1) AS number, SUM(value) AS value, method FROM (
            SELECT msr.*, m_pmethod.PMETHOD_DESC as method, SUM(total_amount_base) AS value FROM (
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Preparation\' AS status FROM t_msr
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                JOIN m_approval ON m_approval.id = t_approval.m_approval_id
                WHERE m_approval.module_kode = \'msr\'
                AND t_approval.status = 0
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Selection\' AS status FROM t_msr
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                JOIN m_approval ON m_approval.id = t_approval.m_approval_id
                WHERE m_approval.module_kode = \'msr_spa\'
                AND t_msr.msr_no NOT IN (SELECT msr_no FROM t_purchase_order)
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Completed\' AS status FROM t_msr
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no
                WHERE t_purchase_order.issued = 0
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Signed\' AS status FROM t_msr
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no
                WHERE t_purchase_order.issued = 1
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Canceled\' AS status FROM t_msr
                WHERE t_msr.status = 1
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Rejected\' AS status FROM t_msr
                LEFT JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                AND (
                    SELECT COUNT(*) FROM t_approval a
                    WHERE (a.data_id = t_msr.msr_no OR a.data_id = t_purchase_order.id)
                    AND a.status = 2
                ) <> 0
            ) msr
            JOIN m_pmethod on m_pmethod.ID_PMETHOD = msr.id_pmethod
            JOIN m_user ON m_user.ID_USER = msr.create_by
            LEFT JOIN t_assignment ON t_assignment.msr_no = msr.msr_no
            '.$condition_query.'
            GROUP BY msr.msr_no,msr.id_company,msr.company_desc,msr.id_department,msr.department_desc,msr.id_msr_type,msr.msr_type_desc,msr.title,msr.blanket,msr.id_currency,msr.id_currency_base,msr.req_date,msr.lead_time,msr.id_ploc,msr.rloc_desc,msr.id_pmethod,msr.pmethod_desc,msr.scope_of_work,msr.create_by,msr.create_on,msr.id_dpoint,msr.dpoint_desc,msr.id_importation,msr.importation_desc,msr.id_requestfor,msr.requestfor_desc,msr.id_inspection,msr.inspection_desc,msr.id_deliveryterm,msr.deliveryterm_desc,msr.id_freight,msr.freight_desc,msr.total_amount,msr.total_amount_base,msr.procure_processing_time,msr.id_costcenter,msr.costcenter_desc,msr.status,m_pmethod.PMETHOD_DESC
        ) msr
        GROUP BY method';
        return $this->db->query($sql)->result();
    }

    public function get_method_trend($filter) {
        $condition = array();
        if (isset($filter['periode'])) {
            $condition[] = 'LEFT(msr.req_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'msr.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'm_user.ID_DEPARTMENT IN (\''.implode('\',\'', $filter['department']).'\')';
        }
        if (isset($filter['status'])) {
            $condition[] = 'msr.status IN (\''.implode('\',\'', $filter['status']).'\')';
        }
        if (isset($filter['type'])) {
            $condition[] = 'msr.id_msr_type IN (\''.implode('\',\'', $filter['type']).'\')';
        }
        if (isset($filter['method'])) {
            $condition[] = 'msr.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
        }
        if (isset($filter['specialist'])) {
            $condition[] = 't_assignment.user_id IN (\''.implode('\',\'', $filter['specialist']).'\')';
        }
        if (count($condition) <> 0) {
            $condition_query = 'WHERE '.implode(' AND ', $condition);
        } else {
            $condition_query = '';
        }
        $sql = 'SELECT COUNT(1) AS number, periode, SUM(value) AS value, method FROM (
            SELECT msr.*, m_pmethod.PMETHOD_DESC as method, LEFT(req_date,7) as periode, SUM(total_amount_base) AS value FROM (
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Preparation\' AS status FROM t_msr
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                JOIN m_approval ON m_approval.id = t_approval.m_approval_id
                WHERE m_approval.module_kode = \'msr\'
                AND t_approval.status = 0
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Selection\' AS status FROM t_msr
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                JOIN m_approval ON m_approval.id = t_approval.m_approval_id
                WHERE m_approval.module_kode = \'msr_spa\'
                AND t_msr.msr_no NOT IN (SELECT msr_no FROM t_purchase_order)
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Completed\' AS status FROM t_msr
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no
                WHERE t_purchase_order.issued = 0
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Signed\' AS status FROM t_msr
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no
                WHERE t_purchase_order.issued = 1
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Canceled\' AS status FROM t_msr
                WHERE t_msr.status = 1
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Rejected\' AS status FROM t_msr
                LEFT JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                AND (
                    SELECT COUNT(*) FROM t_approval a
                    WHERE (a.data_id = t_msr.msr_no OR a.data_id = t_purchase_order.id)
                    AND a.status = 2
                ) <> 0
            ) msr
            JOIN m_pmethod on m_pmethod.ID_PMETHOD = msr.id_pmethod
            JOIN m_user ON m_user.ID_USER = msr.create_by
            LEFT JOIN t_assignment ON t_assignment.msr_no = msr.msr_no
            '.$condition_query.'
            GROUP BY msr.msr_no,msr.id_company,msr.company_desc,msr.id_department,msr.department_desc,msr.id_msr_type,msr.msr_type_desc,msr.title,msr.blanket,msr.id_currency,msr.id_currency_base,msr.req_date,msr.lead_time,msr.id_ploc,msr.rloc_desc,msr.id_pmethod,msr.pmethod_desc,msr.scope_of_work,msr.create_by,msr.create_on,msr.id_dpoint,msr.dpoint_desc,msr.id_importation,msr.importation_desc,msr.id_requestfor,msr.requestfor_desc,msr.id_inspection,msr.inspection_desc,msr.id_deliveryterm,msr.deliveryterm_desc,msr.id_freight,msr.freight_desc,msr.total_amount,msr.total_amount_base,msr.procure_processing_time,msr.id_costcenter,msr.costcenter_desc,msr.status,LEFT(req_date, 7),m_pmethod.PMETHOD_DESC
        ) msr
        GROUP BY method, periode';
        return $this->db->query($sql)->result();
    }

    public function get_specialist($filter) {
        $condition = array();
        if (isset($filter['periode'])) {
            $condition[] = 'LEFT(msr.req_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'msr.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'm_user.ID_DEPARTMENT IN (\''.implode('\',\'', $filter['department']).'\')';
        }
        if (isset($filter['status'])) {
            $condition[] = 'msr.status IN (\''.implode('\',\'', $filter['status']).'\')';
        }
        if (isset($filter['type'])) {
            $condition[] = 'msr.id_msr_type IN (\''.implode('\',\'', $filter['type']).'\')';
        }
        if (isset($filter['method'])) {
            $condition[] = 'msr.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
        }
        if (isset($filter['specialist'])) {
            $condition[] = 't_assignment.user_id IN (\''.implode('\',\'', $filter['specialist']).'\')';
        }
        if (count($condition) <> 0) {
            $condition_query = 'WHERE '.implode(' AND ', $condition);
        } else {
            $condition_query = '';
        }
        $sql = 'SELECT COUNT(1) AS number, SUM(value) AS value, specialist FROM (
            SELECT msr.*,specialist.NAME as specialist, SUM(total_amount_base) AS value FROM (
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Preparation\' AS status FROM t_msr
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                JOIN m_approval ON m_approval.id = t_approval.m_approval_id
                WHERE m_approval.module_kode = \'msr\'
                AND t_approval.status = 0
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Selection\' AS status FROM t_msr
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                JOIN m_approval ON m_approval.id = t_approval.m_approval_id
                WHERE m_approval.module_kode = \'msr_spa\'
                AND t_msr.msr_no NOT IN (SELECT msr_no FROM t_purchase_order)
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Completed\' AS status FROM t_msr
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no
                WHERE t_purchase_order.issued = 0
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Signed\' AS status FROM t_msr
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no
                WHERE t_purchase_order.issued = 1
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Canceled\' AS status FROM t_msr
                WHERE t_msr.status = 1
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Rejected\' AS status FROM t_msr
                LEFT JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                AND (
                    SELECT COUNT(*) FROM t_approval a
                    WHERE (a.data_id = t_msr.msr_no OR a.data_id = t_purchase_order.id)
                    AND a.status = 2
                ) <> 0
            ) msr
            JOIN m_user ON m_user.ID_USER = msr.create_by
            LEFT JOIN t_assignment ON t_assignment.msr_no = msr.msr_no
            LEFT JOIN m_user specialist ON specialist.ID_USER = t_assignment.user_id
            '.$condition_query.'
            GROUP BY msr.msr_no,msr.id_company,msr.company_desc,msr.id_department,msr.department_desc,msr.id_msr_type,msr.msr_type_desc,msr.title,msr.blanket,msr.id_currency,msr.id_currency_base,msr.req_date,msr.lead_time,msr.id_ploc,msr.rloc_desc,msr.id_pmethod,msr.pmethod_desc,msr.scope_of_work,msr.create_by,msr.create_on,msr.id_dpoint,msr.dpoint_desc,msr.id_importation,msr.importation_desc,msr.id_requestfor,msr.requestfor_desc,msr.id_inspection,msr.inspection_desc,msr.id_deliveryterm,msr.deliveryterm_desc,msr.id_freight,msr.freight_desc,msr.total_amount,msr.total_amount_base,msr.procure_processing_time,msr.id_costcenter,msr.costcenter_desc,msr.status,specialist.NAME
        ) msr
        GROUP BY specialist';
        return $this->db->query($sql)->result();
    }

    public function get_specialist_trend($filter) {
        $condition = array();
        if (isset($filter['periode'])) {
            $condition[] = 'LEFT(msr.req_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'msr.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'm_user.ID_DEPARTMENT IN (\''.implode('\',\'', $filter['department']).'\')';
        }
        if (isset($filter['status'])) {
            $condition[] = 'msr.status IN (\''.implode('\',\'', $filter['status']).'\')';
        }
        if (isset($filter['type'])) {
            $condition[] = 'msr.id_msr_type IN (\''.implode('\',\'', $filter['type']).'\')';
        }
        if (isset($filter['method'])) {
            $condition[] = 'msr.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
        }
        if (isset($filter['specialist'])) {
            $condition[] = 't_assignment.user_id IN (\''.implode('\',\'', $filter['specialist']).'\')';
        }
        if (count($condition) <> 0) {
            $condition_query = 'WHERE '.implode(' AND ', $condition);
        } else {
            $condition_query = '';
        }
        $sql = 'SELECT COUNT(1) AS number, periode, SUM(value) AS value, specialist FROM (
            SELECT msr.*, specialist.NAME as specialist, LEFT(req_date,7) as periode, SUM(total_amount_base) AS value FROM (
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Preparation\' AS status FROM t_msr
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                JOIN m_approval ON m_approval.id = t_approval.m_approval_id
                WHERE m_approval.module_kode = \'msr\'
                AND t_approval.status = 0
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Selection\' AS status FROM t_msr
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                JOIN m_approval ON m_approval.id = t_approval.m_approval_id
                WHERE m_approval.module_kode = \'msr_spa\'
                AND t_msr.msr_no NOT IN (SELECT msr_no FROM t_purchase_order)
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Completed\' AS status FROM t_msr
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no
                WHERE t_purchase_order.issued = 0
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Signed\' AS status FROM t_msr
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no
                WHERE t_purchase_order.issued = 1
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Canceled\' AS status FROM t_msr
                WHERE t_msr.status = 1
                UNION ALL
                SELECT DISTINCT t_msr.msr_no,t_msr.id_company,t_msr.company_desc,t_msr.id_department,t_msr.department_desc,t_msr.id_msr_type,t_msr.msr_type_desc,t_msr.title,t_msr.blanket,t_msr.id_currency,t_msr.id_currency_base,t_msr.req_date,t_msr.lead_time,t_msr.id_ploc,t_msr.rloc_desc,t_msr.id_pmethod,t_msr.pmethod_desc,t_msr.scope_of_work,t_msr.create_by,t_msr.create_on,t_msr.id_dpoint,t_msr.dpoint_desc,t_msr.id_importation,t_msr.importation_desc,t_msr.id_requestfor,t_msr.requestfor_desc,t_msr.id_inspection,t_msr.inspection_desc,t_msr.id_deliveryterm,t_msr.deliveryterm_desc,t_msr.id_freight,t_msr.freight_desc,t_msr.total_amount,t_msr.total_amount_base,t_msr.procure_processing_time,t_msr.id_costcenter,t_msr.costcenter_desc, \'Rejected\' AS status FROM t_msr
                LEFT JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no
                JOIN t_approval ON t_approval.data_id = t_msr.msr_no
                AND (
                    SELECT COUNT(*) FROM t_approval a
                    WHERE (a.data_id = t_msr.msr_no OR a.data_id = t_purchase_order.id)
                    AND a.status = 2
                ) <> 0
            ) msr
            JOIN m_user ON m_user.ID_USER = msr.create_by
            LEFT JOIN t_assignment ON t_assignment.msr_no = msr.msr_no
            LEFT JOIN m_user specialist ON specialist.ID_USER = t_assignment.user_id
            '.$condition_query.'
            GROUP BY msr.msr_no,msr.id_company,msr.company_desc,msr.id_department,msr.department_desc,msr.id_msr_type,msr.msr_type_desc,msr.title,msr.blanket,msr.id_currency,msr.id_currency_base,msr.req_date,msr.lead_time,msr.id_ploc,msr.rloc_desc,msr.id_pmethod,msr.pmethod_desc,msr.scope_of_work,msr.create_by,msr.create_on,msr.id_dpoint,msr.dpoint_desc,msr.id_importation,msr.importation_desc,msr.id_requestfor,msr.requestfor_desc,msr.id_inspection,msr.inspection_desc,msr.id_deliveryterm,msr.deliveryterm_desc,msr.id_freight,msr.freight_desc,msr.total_amount,msr.total_amount_base,msr.procure_processing_time,msr.id_costcenter,msr.costcenter_desc,msr.status,LEFT(req_date, 7),specialist.NAME
        ) msr
        GROUP BY specialist, periode';
        return $this->db->query($sql)->result();
    }
}