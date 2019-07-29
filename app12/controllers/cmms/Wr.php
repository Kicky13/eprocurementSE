<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wr extends CI_Controller {

  protected $view = 'cmms/wr';
  protected $menu;

  public function __construct() {
    parent::__construct();
    $this->load->model('vendor/M_vendor');
    $this->load->model('vendor/M_all_intern', 'mai');
    // $this->load->model('cmms/M_equipment','mod');
    // $this->load->model('cmms/M_equipment_picture','picture');

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
    $data['title'] = 'Work Request Create/Edit Form - CMMS10';
    $data['view'] = $this->view;
    $data['optWoType'] = $this->optWoType();
    $data['optFailureDescription'] = $this->optFailureDescription();
    $data['optPriority'] = $this->optPriority();
    $this->template->display($this->view .'/create', $data);
  }
  public function optWoType()
  {
    $s = "<select name='wo_type_id' id='wo_type_id' class='form-control'>";
    $s .= "</select>";
    return $s;
  }
  public function optFailureDescription()
  {
    $s = "<select name='failure_description' id='failure_description' class='form-control'>";
    $s .= "</select>";
    return $s;
  }
  public function optPriority($row=0)
  {
    $list = 
    [
      1 => 'Uregent Immediate',
      2 => 'Within 24 Hours',
      3 => 'Within 3 - 7 Days',
      4 => 'Requirment Shutdown Work',
      5 => 'Preventive Maintenance',
      6 => 'Outage Work',
    ];
    $s = "<select name='priority' id='priority' class='form-control'>";
    foreach ($list as $key => $value) {
      // $selected = $row == $key ? "selected=''":"";
      $s .= "<option value='$key'>$value</option>";
    }
    $s .= "</select>";
    return $s;
  }
}