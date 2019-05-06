<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_arf_assignment extends M_base {

    protected $table = 't_arf_assignment';
    protected $fillable = array('doc_id', 'po_no', 'user_id');
    protected $authors = true;
    protected $timestamps = true;
    protected $procurement_specialist_id = 28;

    public function get_user_assigned() {
        return $this->db->select('m_user.ID_USER as user_id, m_user.USERNAME as username, m_user.NAME as name, COALESCE(assigned.num_of_assigned, 0) as num_of_assigned')
        ->join('(SELECT user_id, COUNT(1) as num_of_assigned FROM t_arf_assignment GROUP BY user_id) assigned', 'assigned.user_id = m_user.ID_USER', 'left')
        ->like('m_user.ROLES',','.$this->procurement_specialist_id.',')
        ->get('m_user')
        ->result();
    }
}