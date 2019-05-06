<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_arf_po_document extends M_base {

    protected $table = 't_purchase_order_document';

    public function view_document() {
        $this->db->select('t_purchase_order_document.*, t_upload.file_path, t_upload.file_name, m_currency.CURRENCY as currency')
        ->join('t_upload', 't_upload.id = t_purchase_order_document.upload_id')
        ->join('m_currency', 'm_currency.ID = t_purchase_order_document.id_currency');
    }

    public function scope_performance_bond() {
        $this->db->where('t_purchase_order_document.doc_type', 1);
    }

    public function scope_issurance() {
        $this->db->where('t_purchase_order_document.doc_type', 2);
    }

    public function scope_other() {
        $this->db->where('t_purchase_order_document.doc_type', 3);
    }
}