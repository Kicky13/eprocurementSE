<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_arf_acceptance_document extends M_base {

    protected $table = 't_arf_acceptance_document';
    protected $fillable = array('doc_no', 'type', 'no', 'issuer', 'issued_date', 'currency_id', 'currency_base_id', 'value', 'value_base', 'effective_date', 'expired_date', 'description', 'file', 'active');

    public function view_document() {
        $this->db->select('t_arf_acceptance_document.*, m_currency.CURRENCY as currency')
        ->join('m_currency', 'm_currency.ID = t_arf_acceptance_document.currency_id');
    }

    public function set_value($value) {
        return number_value($value);
    }

    public function scope_performance_bond() {
        $this->db->where('t_arf_acceptance_document.type', 1);
    }

    public function scope_insurance() {
        $this->db->where('t_arf_acceptance_document.type', 2);
    }

    public function scope_other() {
        $this->db->where('t_arf_acceptance_document.type', 3);
    }
}