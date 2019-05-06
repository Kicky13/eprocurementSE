<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_approval_theme extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }
    
}