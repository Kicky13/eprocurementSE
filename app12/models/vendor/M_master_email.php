<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_master_email extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function menu_access($uri) {
        $data = $this->db->select('ID_MENU')->like('URL', $uri)->from('m_menu')->get();
        return $data->row();
    }

    public function show($idx = null) {
        if ($idx != null) {
            $this->db->where("CATEGORY_ID", $idx);
        }
        $this->db->where("IS_DEL", "1");
        $data = $this->db->from('m_notic')->order_by('ID DESC')->get();
        return $data->result();
    }

    public function show_temp_email($id) {
        $data = $this->db
                ->select('*')
                ->from('m_notic')
                ->where('ID', $id)
                ->get();
        return $data->row();
    }

    public function add($tabel, $data){
        return $this->db->insert($tabel, $data);
    }

    public function update($nama_id, $tabel, $id, $data){
        return $this->db->where($nama_id, $id)->update($tabel, $data);
    }

    public function show_email_category(){
      if( strpos($this->session->userdata['ROLES'], ',') !== false ) {
        $roles = substr($this->session->userdata['ROLES'], 1, -1);
      } else {
        $roles = $this->session->userdata['ROLES'];
      }
      $qq = $this->db->query("select * FROM m_notic_category WHERE roles IN (".$roles.") ");
      // $qq = $this->db->query("select * FROM m_notic_category");
      return $qq->result_array();
    }
}
