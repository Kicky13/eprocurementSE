<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_home extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function menu($group = null) {
        if ($group) {
            $this->db->where('GROUP', $group);
        }
        $res = $this->db->select("*")
                ->from('m_menu_dashboard')
                ->where('STATUS','1')
                ->order_by('SORT', 'ASC')
                ->get();
        if ($res->num_rows() != 0)
            return $res->result();
        else
            return false;
    }
}
?>