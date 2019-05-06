<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_arf_acceptance extends M_base {

    protected $table = 't_arf_acceptance';
    protected $fillable = array('doc_no', 'accepted_at');

    public function view_arf_acceptance() {
        $this->db->join('t_arf',' t_arf.doc_no = t_arf_acceptance.doc_no')
        ->join('t_arf_assignment', 't_arf_assignment.doc_id = t_arf.id');
    }

    public function scope_procurement_specialist() {
        $this->db->where('t_arf_assignment.user_id', $this->session->userdata('ID_USER'));
    }
}