<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Print_sr extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('helperx_helper');
    }

    public function print_sr_priview($idx) {
        $id = $this->session->ID_VENDOR;
        // $idx = $this->uri->segment(5);
        $data['data'] = $idx;
        $this->load->view('vn/info/V_print_sr', $data);
    }

}
