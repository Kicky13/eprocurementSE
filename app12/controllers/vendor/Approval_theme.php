<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Approval_theme extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('vendor/M_approval_theme')->model('vendor/M_vendor')->model('vendor/M_send_invitation');
        $this->load->model('vendor/m_all_intern', 'mai');
    }

    public function index() {
        $cek = $this->mai->cek_session();
        //$temp = $this->M_approval_theme->show();
        //$data['total'] = count($temp);
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $this->template->display('vendor/V_approval_theme', $data);
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }
    
    
}