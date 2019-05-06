<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class General_data extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('vendor/M_general_data', 'mgd')->model('vendor/M_vendor');;
        $this->load->model('vendor/m_all_intern', 'mai');
        $this->load->database();
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function index($id = "info@sisi.id") {
        $cek=$this->mai->cek_session();
        $res = $this->get_data($id);
        $data['id'] = $id;
        $data['all'] = null;
        if ($res != "failed")
            $data['all'] = $res;
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $this->template->display('vn/V_general_data', $data);
    }

}
