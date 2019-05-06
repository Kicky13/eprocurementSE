<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_arf_notification extends M_base {

    protected $table = 't_arf_notification';
    protected $fillable = array('response_date');

    public function view_arf_notification() {
        $this->db->select('t_arf_notification.*, t_arf.id as doc_id, t_arf.po_no, t_arf.currency_id, t_arf.currency_base_id, t_arf.amount_po, t_arf.amount_po_base, t_arf.estimated_value, t_arf.estimated_value_base, t_purchase_order.title, t_msr.id_company, m_company.DESCRIPTION as company,m_vendor.NAMA as vendor, currency.CURRENCY as currency, currency_base.CURRENCY as currency_base, m_user.USERNAME as username_creator, m_user.NAME as creator,CASE WHEN LEFT(response_date, 10) >= CURDATE() THEN \'1\' ELSE 0 END as open')
        ->join('t_arf', 't_arf.doc_no = t_arf_notification.doc_no')
        ->join('t_purchase_order', 't_purchase_order.po_no = t_arf.po_no')
        ->join('t_msr', 't_msr.msr_no = t_purchase_order.msr_no')
        ->join('m_company', 'm_company.ID_COMPANY = t_msr.id_company')
        ->join('m_vendor', 'm_vendor.ID = t_purchase_order.id_vendor')
        ->join('m_currency currency', 'currency.ID = t_arf.currency_id')
        ->join('m_currency currency_base', 'currency_base.ID = t_arf.currency_base_id')
        ->join('m_user', 'm_user.ID_USER = t_arf_notification.created_by');
    }

    public function view_arf_responsed() {
        $this->db->select('t_arf_notification.*, t_arf_response.id as response_id, t_arf_response.responsed_at, t_arf_response.subtotal as response_subtotal, t_arf_response.subtotal_base as response_subtotal_base, t_arf_response.confirm, t_arf_response.note, t_arf.id as doc_id, t_arf.po_no, t_arf.currency_id, t_arf.currency_base_id, t_arf.amount_po, t_arf.amount_po_base, t_arf.estimated_value, t_arf.estimated_value_base, t_purchase_order.title, t_msr.id_company, m_company.DESCRIPTION as company,m_vendor.NAMA as vendor, currency.CURRENCY as currency, currency_base.CURRENCY as currency_base, m_user.USERNAME as username_creator, m_user.NAME as creator, CASE WHEN LEFT(response_date, 10) >= CURDATE() THEN \'1\' ELSE 0 END as open')
        ->join('t_arf_response', 't_arf_response.doc_no = t_arf_notification.doc_no')
        ->join('t_arf', 't_arf.doc_no = t_arf_notification.doc_no')
        ->join('t_purchase_order', 't_purchase_order.po_no = t_arf.po_no')
        ->join('t_msr', 't_msr.msr_no = t_purchase_order.msr_no')
        ->join('m_company', 'm_company.ID_COMPANY = t_msr.id_company')
        ->join('m_vendor', 'm_vendor.ID = t_purchase_order.id_vendor')
        ->join('m_currency currency', 'currency.ID = t_arf.currency_id')
        ->join('m_currency currency_base', 'currency_base.ID = t_arf.currency_base_id')
        ->join('m_user', 'm_user.ID_USER = t_arf_notification.created_by');
    }

    public function scope_auth_vendor() {
        $this->db->where('t_purchase_order.id_vendor', $this->session->userdata('ID'));
    }

    public function scope_unresponse() {
        $this->db->where('NOT EXISTS (
            SELECT doc_no FROM t_arf_response
            WHERE doc_no = t_arf_notification.doc_no
        )');
    }

    public function scope_responsed() {
        $this->db->where('EXISTS (
            SELECT doc_no FROM t_arf_response
            WHERE doc_no = t_arf_notification.doc_no
        )');
    }

    public function scope_open() {
        $this->db->where('LEFT(t_arf_notification.response_date, 10) >=', date('Y-m-d'));
    }

    public function scope_close() {
        $this->db->where('LEFT(t_arf_notification.response_date, 10) <', date('Y-m-d'));
    }
}