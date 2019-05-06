<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Material_uom extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('vendor/M_vendor');
        $this->load->helper(array('string', 'text'));
    }
}
