<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_home extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function menu($group = null) {
        if ($group) {
            $this->db->where('GROUP', $group);
        }
        $data = $this->db->from('m_menu')
                ->where('STATUS', '1')
                ->where('ID_MENU !=', '5')
                ->order_by("SORT")
                ->get();
        return $data->result();
    }

    public function show() {
        $data = $this->db
                ->select('*')
                ->from('m_register_supplier')
                ->where('STATUS !=', '0')
                ->order_by("ID_SUPPLIER")
                ->get();
        return $data->result();
    }

    public function add($data) {
        return $this->db->insert('m_register_supplier', $data);
    }

    public function cek($post){
        $data = $this->db->from('m_register_supplier')
                ->where('ID', $post['id_vendor'])
                ->get();
        return $data->result();
    }
}
?>
