<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_eq_data extends M_base {

    protected $table = 't_eq_data';

    public function view_ed() {
        $this->db->select('t_eq_data.*, t_bl.bled_no, t_msr.total_amount, t_msr.id_company, t_msr.create_by as id_requestor, m_user.ID_DEPARTMENT, m_company.DESCRIPTION as company, m_departement.DEPARTMENT_DESC as department, m_user.NAME as requestor, m_currency.CURRENCY as currency_desc, t_msr.id_currency_base as currency_base, currency_base.CURRENCY as currency_base_desc')
        ->join('t_bl', 't_bl.msr_no = t_eq_data.msr_no')
        ->join('t_msr', 't_msr.msr_no = t_eq_data.msr_no')
        ->join('m_company', 'm_company.ID_COMPANY = t_msr.id_company')
        ->join('m_user', 'm_user.ID_USER = t_msr.create_by')
        ->join('m_departement', 'm_departement.ID_DEPARTMENT = m_user.ID_DEPARTMENT')
        ->join('t_assignment', 't_assignment.msr_no = t_eq_data.msr_no')
        ->join('m_currency', 'm_currency.ID = t_eq_data.currency')
        ->join('m_currency currency_base', 'currency_base.ID = t_msr.id_currency_base');
    }

    public function scope_negotiation() {
        $this->db->where('t_eq_data.administrative', 5)
        ->where('t_eq_data.technical', 5)
        ->where('t_eq_data.commercial', 0)
        ->where('t_eq_data.award', 0);
    }

    public function scope_procurement_specialist() {
        $this->db->where('t_assignment.user_id', $this->session->userdata('ID_USER'));
    }
    public function scope_time_edit_sop()
    {
        $this->db->where([
            't_eq_data.bid_opening' => 1,
            'administrative' => ' <= 4',
            'technical' => ' <= 4',
        ]);
    }
}