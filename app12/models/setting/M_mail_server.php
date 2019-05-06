<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_mail_server extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function show($where = null) {
        if ($where != null) {
            $this->db->where("id", $where);
        }
        $data = $this->db->select("*")->from('m_mail_setting')->order_by('active DESC')->get();
        return $data->result_array();
    }

    public function simpan($data){
      $insert = $this->db->insert('m_mail_setting', $data);
      return $insert;
    }

    public function update($id, $data){
      return $this->db->where('id', $id)->update('m_mail_setting', $data);
    }
}
