<?php
if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_expired_doc_reminder extends CI_Model {

  public function __construct() {
      parent::__construct();
      $this->db = $this->load->database('default', true);
  }

  public function show_document(){
    $query = $this->db->select("*")->from("m_document")->get();
    return $query->result();
  }

  public function show_edit($id){
    $query = $this->db->select("*")->from("m_document")->where("id", $id)->get();
    return $query->result();
  }

  public function add_doc_type($data){
    $this->db->insert("m_document", $data);
  }

  public function update_type_doc($id, $data){
    $this->db->where("id", $id);
    $this->db->update("m_document", $data);
  }




}
