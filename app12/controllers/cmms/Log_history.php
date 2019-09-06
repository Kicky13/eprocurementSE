<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Equipment extends CI_Controller {

  protected $view = 'cmms/equipment';
  protected $menu;

  public function __construct() {
    parent::__construct();
    $this->load->model('vendor/M_vendor');
    $this->load->model('vendor/M_all_intern', 'mai');
    $this->load->model('cmms/M_log','log');

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

  public function get_cmms_log_history()
  {
    $data_id = $this->input->post('data_id');
    $result = $this->log->daftar(['data_id'=>$data_id,'module_kode'=>'wr'])->result();
    $this->load->view('cmms/log_hisory_modal', ['rows'=>$result, 'modal'=>false]);
  }
}