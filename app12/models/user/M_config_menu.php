<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_config_menu extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function menu() {
        $data = $this->db->from('m_menu')->where('STATUS', '1')->get();
        return $data->result();
    }

    public function show() {
        $data = $this->db
                ->select('*')
                ->from('m_menu')
                ->order_by("SORT", "ASC")
                ->get();
        return $data->result();
    }

    public function icon() {
        $data = $this->db
                ->select('ICON')
                ->from('m_icon')
                ->order_by("ID")
                ->get();
        return $data->result();
    }

    public function add($tbl, $data) {
        $this->db->insert($tbl, $data);
    }

    public function update_menu($data, $id){
      $this->db->where("ID_MENU", $id);
      $this->db->update("m_menu", $data);
    }

    public function show2($id) {
        $data = $this->db
                ->select('*')
                ->from('m_menu')
                ->where($id)
                ->get();
        return $data->result();
    }

}

?>
