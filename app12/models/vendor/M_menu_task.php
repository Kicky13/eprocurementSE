<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_menu_task extends CI_Model {

    public function get() {
        return $this->db->where('key !=', null)
        ->order_by('sort', 'asc')
        ->order_by('parent', 'asc')
        ->get('m_menu_task')
        ->result();
    }
}