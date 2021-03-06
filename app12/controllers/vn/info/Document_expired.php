<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Document_expired extends CI_Controller {
  public function __construct() {
      parent::__construct();
      $this->load->helper('form');
      $this->load->helper('url');
      $this->load->model('vn/info/M_document_expired', 'mde');
      $this->load->model('vn/info/M_vn', 'mvn');
  }

  public function index() {
      $id = $this->session->ID_VENDOR;
      $get_menu = $this->mvn->menu();
      $data_expiriy = $this->mde->get_document_expired($this->session->ID);

      $dt = array();
      foreach ($get_menu as $k => $v) {
          $dt[$v->PARENT][$v->ID_MENU_VENDOR]['URL'] = $v->URL;
          $dt[$v->PARENT][$v->ID_MENU_VENDOR]['DESKRIPSI_IND'] = $v->DESCRIPTION_IND;
          $dt[$v->PARENT][$v->ID_MENU_VENDOR]['DESKRIPSI_ENG'] = $v->DESCRIPTION_ENG;
          $dt[$v->PARENT][$v->ID_MENU_VENDOR]['ICON'] = $v->ICON;
      }
      $data['menu'] = $dt;
      $data['data_expiriy'] = $data_expiriy;
      $this->template->display_vendor('vn/info/V_document_expired', $data);
  }

}
