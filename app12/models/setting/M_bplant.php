<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_bplant extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function show($where = null) {
        if ($where != null) {
            $this->db->where("ID_BPLANT", $where);
        }
        $data = $this->db->select("a.*, b.ID_COMPANY as ID_COMP, b.DESCRIPTION")->from('m_bplant a')->join('m_company b', 'a.ID_COMPANY=b.ID_COMPANY')->order_by('a.CREATE_ON DESC')->get();
        return $data->result_array();
    }

    public function simpan($data){
      $insert = $this->db->insert('m_bplant', $data);
    }

    public function update($id, $data){
      return $this->db->where('ID_BPLANT', $id)->update('m_bplant', $data);
    }

    public function company(){
      $query = $this->db->where('STATUS', '1')->get("m_company");
      return $query;
    }
}
