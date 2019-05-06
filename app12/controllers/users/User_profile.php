<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user/M_view_user')->model('vendor/M_vendor');
    }

    public function index() {
        $id = $this->session->userdata['ID_USER'];
        $company = $this->session->userdata['COMPANY'];
        $get_menu = $this->M_vendor->menu();
        $get_user = $this->M_view_user->show_user($id);
        $dt = array();
        $data_user = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }

        $data['menu'] = $dt;
        $data['data_user'] = $get_user;
        $this->template->display('user/V_user_profile', $data);
    }

    public function show_company(){
      $id = $this->session->userdata['ID_USER'];
      $get_user = $this->M_view_user->show_user($id);
      $comp_id = explode(",", $get_user->COMPANY);
      $result = array();
      foreach ($comp_id as $key) {
        $query = $this->db->query("SELECT * FROM m_company WHERE ID_COMPANY = '".$key."'");
        $result[] = array(
          'COMPANY' => $query->row()
        );
      }
      echo json_encode($result);
    }

  }
