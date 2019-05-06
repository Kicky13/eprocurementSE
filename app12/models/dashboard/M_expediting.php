<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_expediting extends CI_Model {

    public function get_expediting($filter) {
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
            $condition_query = 'WHERE '.implode(' AND ', $condition);
        } else {
            $condition_query = '';
        }  
        $sql = 'SELECT expediting.status, COUNT(1) as count FROM (
            SELECT 
                t_purchase_order.po_no, 
                t_purchase_order.delivery_date,
                t_purchase_order_detail.material_id, 
                expediting.expediting_date,
                CASE
                    WHEN expediting.expediting_date IS NOT NULL AND expediting.expediting_date > t_purchase_order.delivery_date THEN DATEDIFF(expediting.expediting_date, t_purchase_order.delivery_date)
                    ELSE 0
                END days_late,
                CASE
                    WHEN expediting.expediting_date IS NULL AND NOW() > t_purchase_order.delivery_date THEN \'Delayed\'
                    WHEN expediting.expediting_date IS NOT NULL AND expediting.expediting_date > t_purchase_order.delivery_date THEN \'Late\'
                    ELSE \'On Time\'
                END status
            FROM t_purchase_order
            JOIN t_msr ON t_msr.msr_no = t_purchase_order.msr_no
            JOIN m_user ON m_user.ID_USER = t_msr.create_by
            JOIN t_purchase_order_detail ON t_purchase_order_detail.po_id = t_purchase_order.id
            LEFT JOIN (
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
            ) expediting ON t_purchase_order.po_no = expediting.no_po AND expediting.id_material = t_purchase_order_detail.material_id
            '.$condition_query.'
        ) expediting
        GROUP BY expediting.status';
        return $this->db->query($sql)->result();
    }

    public function get_expediting_trend($filter) {
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
            $condition_query = 'WHERE '.implode(' AND ', $condition);
        } else {
            $condition_query = '';
        }  
        $sql = 'SELECT LEFT(expediting.po_date, 7) as periode, expediting.status, COUNT(1) as count FROM (
            SELECT 
                t_purchase_order.po_no, 
                t_purchase_order.po_date, 
                t_purchase_order.delivery_date,
                t_purchase_order_detail.material_id, 
                expediting.expediting_date,
                CASE
                    WHEN expediting.expediting_date IS NOT NULL AND expediting.expediting_date > t_purchase_order.delivery_date THEN DATEDIFF(expediting.expediting_date, t_purchase_order.delivery_date)
                    ELSE 0
                END days_late,
                CASE
                    WHEN expediting.expediting_date IS NULL AND NOW() > t_purchase_order.delivery_date THEN \'Delayed\'
                    WHEN expediting.expediting_date IS NOT NULL AND expediting.expediting_date > t_purchase_order.delivery_date THEN \'Late\'
                    ELSE \'On Time\'
                END status
            FROM t_purchase_order
            JOIN t_msr ON t_msr.msr_no = t_purchase_order.msr_no
            JOIN m_user ON m_user.ID_USER = t_msr.create_by
            JOIN t_purchase_order_detail ON t_purchase_order_detail.po_id = t_purchase_order.id
            LEFT JOIN (
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
            ) expediting ON t_purchase_order.po_no = expediting.no_po AND expediting.id_material = t_purchase_order_detail.material_id            
            '.$condition_query.'
        ) expediting
        GROUP BY LEFT(expediting.po_date, 7), expediting.status';
        return $this->db->query($sql)->result();
    }
}