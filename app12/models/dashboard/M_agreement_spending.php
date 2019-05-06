<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_agreement_spending extends CI_Model {

    public function get_spending($filter) {
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
            $condition_query = 'WHERE '.implode(' AND ', $condition);
        } else {
            $condition_query = '';
        }   
        $sql = 'SELECT 
            SUM(total) AS total,
            SUM(spending) AS spending,
            sum(remaining) AS remaining
        FROM t_purchase_order
        JOIN (
            SELECT 
                po_id, 
                COALESCE(t_purchase_order_detail.total_price_base,0) AS total,
                COALESCE(t_service_receipt_detail.total_base,0) AS spending,
                (COALESCE(t_purchase_order_detail.total_price_base,0) - COALESCE(t_service_receipt_detail.total_base,0)) as remaining
            FROM t_purchase_order_detail
            JOIN t_purchase_order ON t_purchase_order.id = t_purchase_order_detail.po_id
            LEFT JOIN t_itp ON t_itp.no_po = t_purchase_order.po_no 
            LEFT JOIN t_itp_detail ON t_itp_detail.id_itp = t_itp.id_itp AND t_itp_detail.material_id = t_purchase_order_detail.material_id
            LEFT JOIN t_service_receipt_detail ON t_service_receipt_detail.id_itp = t_itp.id_itp AND t_service_receipt_detail.id_material = t_itp_detail.material_id    
        ) agreement ON agreement.po_id = t_purchase_order.id
        JOIN t_msr ON t_msr.msr_no = t_purchase_order.msr_no
        JOIN m_user ON m_user.ID_USER = t_msr.create_by
        JOIN t_assignment ON t_assignment.msr_no = t_msr.msr_no '.$condition_query;
        return $this->db->query($sql)->row();
    }

    public function get_spending_trend($filter) {
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
            $condition_query = 'WHERE '.implode(' AND ', $condition);
        } else {
            $condition_query = '';
        }  
        $sql = 'SELECT 
            LEFT(po_date, 7) as periode,
            SUM(total) AS total,
            SUM(spending) AS spending,
            sum(remaining) AS remaining
        FROM t_purchase_order
        JOIN (
            SELECT 
                po_id, 
                COALESCE(t_purchase_order_detail.total_price_base,0) AS total,
                COALESCE(t_service_receipt_detail.total_base,0) AS spending,
                (COALESCE(t_purchase_order_detail.total_price_base,0) - COALESCE(t_service_receipt_detail.total_base,0)) as remaining
            FROM t_purchase_order_detail
            JOIN t_purchase_order ON t_purchase_order.id = t_purchase_order_detail.po_id            
            LEFT JOIN t_itp ON t_itp.no_po = t_purchase_order.po_no 
            LEFT JOIN t_itp_detail ON t_itp_detail.id_itp = t_itp.id_itp AND t_itp_detail.material_id = t_purchase_order_detail.material_id
            LEFT JOIN t_service_receipt_detail ON t_service_receipt_detail.id_itp = t_itp.id_itp AND t_service_receipt_detail.id_material = t_itp_detail.material_id    
        ) agreement ON agreement.po_id = t_purchase_order.id
        JOIN t_msr ON t_msr.msr_no = t_purchase_order.msr_no
        JOIN m_user ON m_user.ID_USER = t_msr.create_by
        JOIN t_assignment ON t_assignment.msr_no = t_msr.msr_no
        '.$condition_query.'
        GROUP BY LEFT(po_date, 7)';
        return $this->db->query($sql)->result();
    }
}