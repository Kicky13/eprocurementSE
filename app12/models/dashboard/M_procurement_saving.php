<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_procurement_saving extends CI_Model
{
    public function get_agreement_msr_procurement_saving($filter) {
        $condition = array();
        if (isset($filter['periode'])) {
            $condition[] = 'LEFT(agreement.po_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
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
            $condition[] = 'agreement.po_type IN (\''.implode('\',\'', $filter['type']).'\')';
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
        return $this->db->query('SELECT
            COUNT(1) AS agreement_number,
            currency,
            SUM(msr_value) AS msr_value,
            SUM(agreement_value) AS agreement_value,
            SUM(saving_value) AS saving_value
        FROM (
            SELECT
                t_msr.msr_no,
                m_currency.CURRENCY AS currency,
                SUM(t_msr_item.amount_base) AS msr_value,
                SUM(agreement.agreement_value) AS agreement_value,
                SUM(t_msr_item.amount_base - agreement.agreement_value) AS saving_value
            FROM t_msr
            JOIN t_msr_item ON t_msr_item.msr_no = t_msr.msr_no
            JOIN (
                SELECT a.msr_no, a.po_type, a.po_date, b.msr_item_id, SUM(b.total_price_base) agreement_value FROM t_purchase_order a
                JOIN t_purchase_order_detail b ON b.po_id = a.id
                WHERE a.issued = 1
                GROUP BY a.msr_no, a.po_type, a.po_date, b.msr_item_id
            ) agreement ON agreement.msr_no = t_msr_item.msr_no AND agreement.msr_item_id = t_msr_item.line_item
            JOIN m_currency ON m_currency.ID = t_msr.id_currency_base
            JOIN m_user ON m_user.ID_USER = t_msr.create_by
            LEFT JOIN t_assignment ON t_assignment.msr_no = t_msr.msr_no
            '.$condition_query.'
            GROUP BY t_msr.msr_no,m_currency.CURRENCY
        ) procurement_saving
        GROUP by currency')
        ->row();
    }

    public function get_agreement_msr_procurement_saving_trend($filter) {
        $condition = array();
        if (isset($filter['periode'])) {
            $condition[] = 'LEFT(agreement.po_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
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
            $condition[] = 'agreement.po_type IN (\''.implode('\',\'', $filter['type']).'\')';
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
        return $this->db->query('SELECT
            periode,
            COUNT(1) AS agreement_number,
            currency,
            SUM(msr_value) AS msr_value,
            SUM(agreement_value) AS agreement_value,
            SUM(saving_value) AS saving_value
        FROM (
            SELECT
                t_msr.msr_no,
                LEFT(t_msr.create_on, 7) as periode,
                m_currency.CURRENCY AS currency,
                SUM(t_msr_item.amount_base) AS msr_value,
                SUM(agreement.agreement_value) AS agreement_value,
                SUM(t_msr_item.amount_base - agreement.agreement_value) AS saving_value
            FROM t_msr
            JOIN t_msr_item ON t_msr_item.msr_no = t_msr.msr_no
            JOIN (
                SELECT a.msr_no, a.po_type, a.po_date, b.msr_item_id, SUM(b.total_price_base) agreement_value FROM t_purchase_order a
                JOIN t_purchase_order_detail b ON b.po_id = a.id
                WHERE a.issued = 1
                GROUP BY a.msr_no, a.po_type, a.po_date, b.msr_item_id
            ) agreement ON agreement.msr_no = t_msr_item.msr_no AND agreement.msr_item_id = t_msr_item.line_item
            JOIN m_currency ON m_currency.ID = t_msr.id_currency_base
            JOIN m_user ON m_user.ID_USER = t_msr.create_by
            LEFT JOIN t_assignment ON t_assignment.msr_no = t_msr.msr_no
            '.$condition_query.'
            GROUP BY t_msr.msr_no,m_currency.CURRENCY,LEFT(t_msr.create_on,7)
        ) procurement_saving
        GROUP BY periode,currency')
        ->result();
    }

    public function get_agreement_proposal_procurement_saving($filter) {
        $condition = array();
        if (isset($filter['periode']) <> 0) {
            $condition[] = 'LEFT(agreement.po_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
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
            $condition[] = 'agreement.po_type IN (\''.implode('\',\'', $filter['type']).'\')';
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
        return $this->db->query('SELECT
            COUNT(1) agreement_number,
            currency,
            SUM(proposal_value) AS proposal_value,
            SUM(agreement_value) AS agreement_value,
            SUM(saving_value) AS saving_value
        FROM (
            SELECT
                t_msr.msr_no,
                m_currency.CURRENCY AS currency,
                SUM(t_sop_bid.qty * t_sop_bid.unit_price_base) AS proposal_value,
                SUM(agreement.agreement_value) AS agreement_value,
                SUM((t_sop_bid.qty * t_sop_bid.unit_price_base) - agreement.agreement_value) AS saving_value
            FROM t_msr
            JOIN (
                SELECT a.msr_no, a.po_type, a.po_date, b.sop_bid_id, b.total_price_base AS agreement_value FROM t_purchase_order a
                JOIN t_purchase_order_detail b ON b.po_id = a.id
                WHERE a.issued = 1
            ) agreement ON agreement.msr_no = t_msr.msr_no
            JOIN t_sop_bid ON t_sop_bid.id = agreement.sop_bid_id
            JOIN m_currency ON m_currency.ID = t_msr.id_currency_base
            JOIN m_user ON m_user.ID_USER = t_msr.create_by
            LEFT JOIN t_assignment ON t_assignment.msr_no = t_msr.msr_no
            '.$condition_query.'
            GROUP BY t_msr.msr_no,m_currency.CURRENCY
        ) procurement_saving
        GROUP by currency')
        ->row();
    }

    public function get_agreement_proposal_procurement_saving_trend($filter) {
        $condition = array();
        if (isset($filter['periode']) <> 0) {
            $condition[] = 'LEFT(agreement.po_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
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
            $condition[] = 'agreement.po_type IN (\''.implode('\',\'', $filter['type']).'\')';
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
        return $this->db->query('SELECT
            periode,
            COUNT(1) agreement_number,
            currency,
            SUM(proposal_value) AS proposal_value,
            SUM(agreement_value) AS agreement_value,
            SUM(saving_value) AS saving_value
        FROM (
            SELECT
                t_msr.msr_no,
                LEFT(t_msr.create_on, 7) as periode,
                m_currency.CURRENCY AS currency,
                SUM(t_sop_bid.qty * t_sop_bid.unit_price_base) AS proposal_value,
                SUM(agreement.agreement_value) AS agreement_value,
                SUM((t_sop_bid.qty * t_sop_bid.unit_price_base) - agreement.agreement_value) AS saving_value
            FROM t_msr
            JOIN (
                SELECT a.msr_no, a.po_type, a.po_date, b.sop_bid_id, b.total_price_base AS agreement_value FROM t_purchase_order a
                JOIN t_purchase_order_detail b ON b.po_id = a.id
                WHERE a.issued = 1
            ) agreement ON agreement.msr_no = t_msr.msr_no
            JOIN t_sop_bid ON t_sop_bid.id = agreement.sop_bid_id
            JOIN m_currency ON m_currency.ID = t_msr.id_currency_base
            JOIN m_user ON m_user.ID_USER = t_msr.create_by
            LEFT JOIN t_assignment ON t_assignment.msr_no = t_msr.msr_no
            '.$condition_query.'
            GROUP BY t_msr.msr_no,m_currency.CURRENCY,LEFT(t_msr.create_on,7)
        ) procurement_saving
        GROUP BY periode,currency')
        ->result();
    }
}