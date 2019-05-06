<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_user_guide extends CI_Model {

  public function __construct() {
      parent::__construct();
      $this->db = $this->load->database('default', true);
  }

  public function get_user_guide() {
      return $this->db->query("SELECT * FROM m_user_guide ORDER BY id ASC");
  }


}
