<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_arf_recommendation_preparation extends M_base {

    protected $table = 't_arf_recommendation_preparation';

    public function view_amendment_recommendation() {
        $this->db->select('
            t_arf_recommendation_preparation.*,
            t_arf_notification.id as notification_doc_id,
            t_arf_response.id as response_id, t_arf_response.responsed_at, t_arf_response.subtotal as response_subtotal, t_arf_response.subtotal_base as response_subtotal_base,
            CASE
                WHEN EXISTS (SELECT doc_no FROM t_arf_acceptance WHERE doc_no = t_arf_recommendation_preparation.doc_no) THEN \'1\'
                ELSE \'0\'
            END as acceptance,
            t_arf.id as doc_id, t_arf.po_no, t_arf.doc_date, t_arf.currency_id, t_arf.currency_base_id, t_arf.amount_po, t_arf.amount_po_base, t_arf.amount_po_arf, t_arf.amount_po_arf_base, t_arf.amended_date, t_arf.estimated_value, t_arf.estimated_value_base, t_arf.estimated_new_value, t_arf.estimated_new_value_base, t_purchase_order.title, t_msr.id_company, m_company.DESCRIPTION as company,m_vendor.NAMA as vendor, currency.CURRENCY as currency, currency_base.CURRENCY as currency_base')
        ->join('t_arf', 't_arf.doc_no = t_arf_recommendation_preparation.doc_no')
        ->join('t_arf_notification', 't_arf_notification.doc_no = t_arf_recommendation_preparation.doc_no')
        ->join('t_arf_response', 't_arf_response.doc_no = t_arf_recommendation_preparation.doc_no')
        ->join('t_purchase_order', 't_purchase_order.po_no = t_arf.po_no')
        ->join('t_msr', 't_msr.msr_no = t_purchase_order.msr_no')
        ->join('m_company', 'm_company.ID_COMPANY = t_msr.id_company')
        ->join('m_vendor', 'm_vendor.ID = t_purchase_order.id_vendor')
        ->join('m_currency currency', 'currency.ID = t_arf.currency_id')
        ->join('m_currency currency_base', 'currency_base.ID = t_arf.currency_base_id');
    }

    public function scope_auth_vendor() {
        $this->db->where('t_purchase_order.id_vendor', $this->session->userdata('ID'));
    }

    public function scope_unresponse() {
        $this->db->where('NOT EXISTS (
            SELECT doc_no FROM t_arf_acceptance
            WHERE doc_no = t_arf_recommendation_preparation.doc_no
        )');
    }

    public function scope_responsed() {
        $this->db->where('EXISTS (
            SELECT doc_no FROM t_arf_acceptance
            WHERE doc_no = t_arf_recommendation_preparation.doc_no
        )');
    }
}