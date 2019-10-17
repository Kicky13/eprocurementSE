<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_arf_po extends M_base {

    protected $table = 't_purchase_order';

    public function view_po() {
        $this->db->select('t_purchase_order.*, t_msr.create_by AS id_requestor, m_user.NAME AS requestor, t_msr.id_company, m_company.DESCRIPTION as company, m_user.USERNAME AS username_requestor, m_user.NAME AS requestor, m_user.ID_DEPARTMENT AS id_department, m_departement.DEPARTMENT_DESC AS department, t_assignment.user_id as id_procurement_specialist, procurement_specialist.USERNAME as username_procurement_specialist, procurement_specialist.NAME as procurement_specialist, m_vendor.ID_EXTERNAL as id_external_vendor, m_vendor.NAMA as vendor, currency.CURRENCY as currency, currency_base.CURRENCY as currency_base, COALESCE(prev_arf.prev_value, 0) as prev_value, t_purchase_order.total_amount+COALESCE(prev_arf.prev_value, 0) as latest_value, CASE WHEN prev_arf.prev_date IS NOT NULL THEN prev_arf.prev_date ELSE t_purchase_order.delivery_date END as prev_date, COALESCE(spending.spending_value, 0) as spending_value,  COALESCE(t_purchase_order.total_amount, 0) - COALESCE(spending.spending_value, 0) as remaining_value', false)
        ->join('t_msr', 't_msr.msr_no = t_purchase_order.msr_no')
        ->join('m_company', 'm_company.ID_COMPANY = t_msr.id_company')
        ->join('m_user', 'm_user.ID_USER = t_msr.create_by')
        ->join('m_departement', 'm_departement.ID_DEPARTMENT = m_user.ID_DEPARTMENT')
        ->join('t_assignment', 't_assignment.msr_no = t_msr.msr_no')
        ->join('m_user procurement_specialist', 'procurement_specialist.ID_USER = t_assignment.user_id')
        ->join('m_vendor', 'm_vendor.ID = t_purchase_order.id_vendor')
        ->join('m_currency currency', 'currency.ID = t_purchase_order.id_currency')
        ->join('m_currency currency_base', 'currency_base.ID = t_purchase_order.id_currency_base')
        ->join('(
            SELECT t_arf.po_no, SUM(estimated_value) as prev_value, MAX(t_arf_detail_revision.value) as prev_date FROM t_arf
            JOIN t_arf_detail_revision ON t_arf_detail_revision.doc_id = t_arf.id AND t_arf_detail_revision.type = \'time\'
            WHERE t_arf.status = \'submitted\'
            GROUP BY t_arf.po_no
        ) prev_arf', 'prev_arf.po_no = t_purchase_order.po_no', 'left')
        ->join('(
            SELECT no_po, SUM(total) as spending_value FROM t_itp_detail
            JOIN t_itp ON t_itp.id_itp = t_itp_detail.id_itp
            GROUP BY t_itp.no_po
        ) spending', 'spending.no_po = t_purchase_order.po_no', 'left')
        ->where_not_in('t_purchase_order.po_no', "select po_no from t_arf where is_issued = 0", false);
    }

    public function view_po_without_join_prev_arf() {
        $this->db->select('t_purchase_order.*, t_msr.create_by AS id_requestor, m_user.NAME AS requestor, t_msr.id_company, m_company.DESCRIPTION as company, m_user.USERNAME AS username_requestor, m_user.NAME AS requestor, m_user.ID_DEPARTMENT AS id_department, m_departement.DEPARTMENT_DESC AS department, t_assignment.user_id as id_procurement_specialist, procurement_specialist.USERNAME as username_procurement_specialist, procurement_specialist.NAME as procurement_specialist, m_vendor.ID_EXTERNAL as id_external_vendor, m_vendor.NAMA as vendor, currency.CURRENCY as currency, currency_base.CURRENCY as currency_base, COALESCE(prev_arf.prev_value, 0) as prev_value, t_purchase_order.total_amount+COALESCE(prev_arf.prev_value, 0) as latest_value, CASE WHEN prev_arf.prev_date IS NOT NULL THEN prev_arf.prev_date ELSE t_purchase_order.delivery_date END as prev_date, COALESCE(spending.spending_value, 0) as spending_value,  COALESCE(t_purchase_order.total_amount, 0) - COALESCE(spending.spending_value, 0) as remaining_value', false)
        ->join('t_msr', 't_msr.msr_no = t_purchase_order.msr_no')
        ->join('m_company', 'm_company.ID_COMPANY = t_msr.id_company')
        ->join('m_user', 'm_user.ID_USER = t_msr.create_by')
        ->join('m_departement', 'm_departement.ID_DEPARTMENT = m_user.ID_DEPARTMENT')
        ->join('t_assignment', 't_assignment.msr_no = t_msr.msr_no')
        ->join('m_user procurement_specialist', 'procurement_specialist.ID_USER = t_assignment.user_id')
        ->join('m_vendor', 'm_vendor.ID = t_purchase_order.id_vendor')
        ->join('m_currency currency', 'currency.ID = t_purchase_order.id_currency')
        ->join('m_currency currency_base', 'currency_base.ID = t_purchase_order.id_currency_base')
        ->join('(
            SELECT no_po, SUM(total) as spending_value FROM t_itp_detail
            JOIN t_itp ON t_itp.id_itp = t_itp_detail.id_itp
            GROUP BY t_itp.no_po
        ) spending', 'spending.no_po = t_purchase_order.po_no', 'left');
    }

    public function enum_type() {
        return array(
            10 => 'PO',
            20 => 'SO',
            30 => 'Blanket',
            40 => 'Contracts'
        );
    }
    public function view_po_edit()
    {
        $this->db->select('t_purchase_order.*, t_msr.create_by AS id_requestor, m_user.NAME AS requestor, t_msr.id_company, m_company.DESCRIPTION as company, m_user.USERNAME AS username_requestor, m_user.NAME AS requestor, m_user.ID_DEPARTMENT AS id_department, m_departement.DEPARTMENT_DESC AS department, t_assignment.user_id as id_procurement_specialist, procurement_specialist.USERNAME as username_procurement_specialist, procurement_specialist.NAME as procurement_specialist, m_vendor.ID_EXTERNAL as id_external_vendor, m_vendor.NAMA as vendor, currency.CURRENCY as currency, currency_base.CURRENCY as currency_base, COALESCE(prev_arf.prev_value, 0) as prev_value, t_purchase_order.total_amount+COALESCE(prev_arf.prev_value, 0) as latest_value, CASE WHEN prev_arf.prev_date IS NOT NULL THEN prev_arf.prev_date ELSE t_purchase_order.delivery_date END as prev_date, COALESCE(spending.spending_value, 0) as spending_value,  COALESCE(t_purchase_order.total_amount, 0) - COALESCE(spending.spending_value, 0) as remaining_value', false)
        ->join('t_msr', 't_msr.msr_no = t_purchase_order.msr_no')
        ->join('m_company', 'm_company.ID_COMPANY = t_msr.id_company')
        ->join('m_user', 'm_user.ID_USER = t_msr.create_by')
        ->join('m_departement', 'm_departement.ID_DEPARTMENT = m_user.ID_DEPARTMENT')
        ->join('t_assignment', 't_assignment.msr_no = t_msr.msr_no')
        ->join('m_user procurement_specialist', 'procurement_specialist.ID_USER = t_assignment.user_id')
        ->join('m_vendor', 'm_vendor.ID = t_purchase_order.id_vendor')
        ->join('m_currency currency', 'currency.ID = t_purchase_order.id_currency')
        ->join('m_currency currency_base', 'currency_base.ID = t_purchase_order.id_currency_base')
        ->join('(
            SELECT t_arf.po_no, SUM(estimated_value) as prev_value, MAX((SELECT value FROM t_arf_detail_revision WHERE type=\'time\' AND doc_id = t_arf.id)) as prev_date FROM t_arf
            WHERE t_arf.status = \'submitted\'
            GROUP BY t_arf.po_no
        ) prev_arf', 'prev_arf.po_no = t_purchase_order.po_no', 'left')
        ->join('(
            SELECT no_po, SUM(total) as spending_value FROM t_itp_detail
            JOIN t_itp ON t_itp.id_itp = t_itp_detail.id_itp
            GROUP BY t_itp.no_po
        ) spending', 'spending.no_po = t_purchase_order.po_no', 'left');
    }
}