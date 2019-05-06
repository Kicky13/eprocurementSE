<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_job_position extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function show($where = null) {
        if ($where != null) {
            $this->db->where("id", $where);
        }
        $data = $this->db->select("*")->from('m_job_position')->order_by('description ASC')->get();
        return $data->result_array();
    }

    public function simpan($data){
      $insert = $this->db->insert('m_job_position', $data);
    }

    public function update($id, $data){
      return $this->db->where('id', $id)->update('m_job_position', $data);
    }
}
