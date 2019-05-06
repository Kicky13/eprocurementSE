<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Page_404 extends CI_Controller {

    public function __construct() {
        parent::__construct();        
        $this->load->helper('url');
        $this->load->library('session');        
    }

    public function index() {             
        $data = array();
        $this->template->display_vendor('V_404', $data);
    }    
}
?>