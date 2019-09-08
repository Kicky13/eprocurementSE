<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wo extends CI_Controller {
  /*Note : Rule Work Order Approval Status:
  Status 01 WO Created by User
  Status 05 WO approval by supervisor
  Status 10, 20, 30, 40, 50, 60, review by Maintenance Planner
  Status 70, 80, update by PIC
  Status 90 review by supervisor
  f4801.WASHNO is not null cara ambil wo yang ada task instructionnya untuk bahan maintenance task list
  */
  protected $view = 'cmms/wo';
  protected $menu;

  public function __construct() {
    parent::__construct();
    $this->load->model('vendor/M_vendor');
    $this->load->model('vendor/M_all_intern', 'mai');
    $this->load->model('cmms/M_wo_jde', 'wo');
    $this->load->helper(array('permission'));
    $this->mai->cek_session();
    $get_menu = $this->M_vendor->menu();
    $this->menu = array();
    foreach ($get_menu as $k => $v) {
      $this->menu[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
      $this->menu[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
      $this->menu[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
      $this->menu[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
    }
    $user = user();
    $this->user = $user;
    if (isset($user->ROLES)) {
        $roles = explode(",", $user->ROLES);
    } else {
        $roles = array();
    }
    $this->roles      = array_values(array_filter($roles));
  }

  public function index()
  {
    $thead = cmms_settings('woe_list')->get()->result();
    $filter = cmms_settings('woe_list')->where('desc2',1)->get()->result();
    $data['thead'] = $thead;
    $data['filter'] = $filter;
    $data['menu'] = $this->menu;
    $data['title'] = 'Maintenance Task List - CMMSXX';
    $this->template->display($this->view .'/index', $data);
  }

  public function ajax_list()
  {
    $list = $this->wo->dt_get_datatables();
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $rows) {
      $no++;
      $row = array();
      $row[] = $no;
      $woNo = $rows->WADOCO;
      $woDesc = $rows->WADL01;
      $eqNo = $rows->EQNO;
      $eqDesc = $rows->EQDESC;
      $labor = $rows->LABOR;
      $actHour = $rows->ACTHOUR;
	  $laba = substr($actHour, 0, 2);
	  $labb = substr($actHour, 2, 2);
	  $actHour = $laba.'.'.$labb;
      $actFinishDate = $rows->ACTFINISHDATE;
      $analysisDesc = $rows->ANALYSISDESC;
      $resDesc = $rows->RESDESC;
      $link = "<a href='".base_url('wo/show/'.$woNo)."'>$woNo</a>";
      $row[] = $link;
      $row[] = $woDesc;
      $row[] = $eqNo;
      $row[] = $eqDesc;
      $row[] = $labor;
      $row[] = $actHour;
      $row[] = $actFinishDate;
      $row[] = $analysisDesc;
      $row[] = $resDesc;
      $data[] = $row;
    }
    // print_r($data);
    $output = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->wo->dt_count_all(),
            'recordsFiltered' => $this->wo->dt_count_filtered(),
            'data' => $data,
        );
    echo json_encode($output);
  }
  public function optWoType($wo_type_selected = '', $name='wo_type_id', $search=false)
  {
    $wotype = $this->wo_type->all();
    $s = "<select name='$name' id='$name' class='form-control'>";
    if($search)
      $s .= "<option value=''>--All--</option>";

    foreach ($wotype as $r) {
      $selected = $wo_type_selected == $r->id ? "selected=''":"";
      $s .= "<option $selected value='$r->id'>$r->code_alpha - $r->notation</option>";
    }
    $s .= "</select>";
    return $s;
  }
  public function optWoStatus($wo_type_selected = '', $name='status', $search=false)
  {
    $wotype = $this->db->get('cmms_wo_status')->result();
    $s = "<select name='$name' id='$name' class='form-control'>";
    if($search)
      $s .= "<option value=''>--All--</option>";

    foreach ($wotype as $r) {
      $selected = $wo_type_selected == $r->wo_status ? "selected=''":"";
      $s .= "<option $selected value='$r->wo_status'>$r->wo_status - $r->wo_status_desc</option>";
    }
    $s .= "</select>";
    return $s;
  }
}