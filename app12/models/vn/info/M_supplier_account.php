<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_supplier_account extends CI_Model {

  public function __construct() {
      parent::__construct();
      $this->db = $this->load->database('default', true);
  }

  public function get_supplier_account($id) {
      return $this->db->query("SELECT v.*, p.DESKRIPSI_ENG as PREFIX, x.DESKRIPSI_ENG as SUFFIX
        FROM m_vendor v
        LEFT JOIN m_prefix p ON p.ID_PREFIX=SUBSTRING(v.PREFIX, 1, 1)
        LEFT JOIN m_prefix x ON x.ID_PREFIX=SUBSTRING(v.PREFIX, 3)
        WHERE v.ID = '".$id."'")->row();
  }

  public function update($data){
    $qry = $this->db->where("ID", $this->session->ID)->update("m_vendor", $data);
    return $qry;
  }


}
