<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wr extends CI_Controller {

  protected $view = 'cmms/wr';
  protected $menu;

  public function __construct() {
    parent::__construct();
    $this->load->model('vendor/M_vendor');
    $this->load->model('vendor/M_all_intern', 'mai');
    $this->load->model('cmms/M_equipment','mod');
    $this->load->model('cmms/M_equipment_picture','picture');

    $this->mai->cek_session();
    $get_menu = $this->M_vendor->menu();
    $this->menu = array();
    foreach ($get_menu as $k => $v) {
      $this->menu[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
      $this->menu[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
      $this->menu[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
      $this->menu[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
    }
  }

  public function create($FAAAID='')
  {
    $data['menu'] = $this->menu;
    $data['title'] = 'Create Work Request';
    $data['view'] = $this->view;
    $this->template->display($this->view .'/create', $data);
  }

}