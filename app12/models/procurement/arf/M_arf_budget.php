<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_arf_budget extends M_base {

    protected $table = 't_arf_budget';
    protected $fillable = array('doc_id', 'id_costcenter', 'costcenter', 'id_account_subsidiary', 'account_subsidiary', 'id_currency', 'booking_amount', 'costcenter_value', 'account_subsidiary_value', 'budget_value', 'status');

    public function enum_status() {
        return array(
            'insufficient' => 'Insufficient',
            'sufficient' => 'Sufficient'
        );
    }

    public function view_budget() {
        $this->db->select('t_arf_budget.*, m_currency.CURRENCY as currency')
        ->join('m_currency', 'm_currency.ID = t_arf_budget.id_currency');
    }
}