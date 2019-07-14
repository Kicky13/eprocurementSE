<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Equipment extends CI_Controller {

  protected $view = 'cmms/equipment';
  protected $menu;

  public function __construct() {
    parent::__construct();
    $this->load->model('vendor/M_vendor');
    $this->load->model('vendor/M_all_intern', 'mai');
    $this->load->model('cmms/equipment_model','mod');

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

  public function settings($value='')
  {
    $head = [
      'FAASID' => 'Equipment Number',
      'FADL01' => 'Equipment Description',
      'LOCT' => 'Location',
      'CIT' => 'Criticality',
      'PARENTS' => 'Parent EQ Number',
      'DSPARENTS' => 'Parent Description',
      'EQCLAS' => 'Equipment Class',
      'EQTYPE' => 'Equipment Type',
    ];
    $data['thead'] = $head;
    return $data[$value];
  }
  public function index() {
    $data['menu'] = $this->menu;
    $data['title'] = 'Equipment List';
    $data['thead'] = $this->settings('thead');
    $this->template->display($this->view .'/index', $data);
  }
  public function detail($id='')
  {
    $data['menu'] = $this->menu;
    $data['title'] = 'Equipment Information';
    $data['view'] = $this->view;
    $this->template->display($this->view .'/detail', $data);
  }
  public function ajax_list()
  {
    $list = $this->mod->dt_get_datatables();
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $rows) {
      $no++;
      $row = array();
      $row[] = $no;
      foreach ($this->settings('thead') as $key => $value) {
        $row[] = $rows->$key;
      }
      
      $row[] = "<a href='".base_url('cmms/equipment/detail/'.$rows->FAAAID)."' class='btn btn-info btn-sm'>Detail</a>";
      $data[] = $row;
    }
 
    $output = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->mod->dt_count_all(),
            'recordsFiltered' => $this->mod->dt_count_filtered(),
            'data' => $data,
        );
    echo json_encode($output);
  }
}