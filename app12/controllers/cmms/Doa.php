<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Doa extends CI_Controller {

  protected $view = 'cmms/doa';
  protected $menu;

  public function __construct() {
    parent::__construct();
    $this->load->model('vendor/M_vendor');
    $this->load->model('vendor/M_all_intern', 'mai');
    $this->load->model('cmms/M_doa', 'mod');

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

  public function index($param='') {
    $data['menu'] = $this->menu;
  	$data['title'] = 'Delegation of Authority';
    $data['row'] = $this->mod->findByCreator($this->session->userdata('ID_USER'));
    $data['assign_to'] = $this->mod->findAssingUsers()->result();
    $this->template->display($this->view .'/form', $data);
  }

  public function store()
  {
    $msg = 'Fail, Please Try Again';
    $data = $this->input->post();
    if(strtotime($data['start_date']) > strtotime($data['end_date']))
    {
      $msg = 'End date must > Start date';
      echo json_encode(['status'=>false, 'msg'=>$msg]);
    }
    else
    {
      $store = $this->mod->store($data);
      if($store)
      {
        echo json_encode(['status'=>true, 'msg'=>'Stored']);
      }
      else
      {
        echo json_encode(['status'=>false, 'msg'=>$msg]);
      }
    }
  }

  public function update()
  {
    $msg = 'Fail, Please Try Again';
    $data = $this->input->post();
    if(strtotime($data['start_date']) > strtotime($data['end_date']) or strtotime($data['start_date']) == strtotime($data['end_date']))
    {
      $msg = 'End date must > Start date';
      echo json_encode(['status'=>false, 'msg'=>$msg]);
    }
    else
    {
      $update = $this->mod->update($data);
      if($update)
      {
        echo json_encode(['status'=>true, 'msg'=>'Updated']);
      }
      else
      {
        echo json_encode(['status'=>false, 'msg'=>$msg]);
      }
    }
  }

  public function delete($id='')
  {
    $delete = $this->mod->delete($id);
    if($delete)
    {

      echo json_encode(['status'=>true, 'msg'=>'Reset']);
    }
    else
    {
      
      echo json_encode(['status'=>false, 'msg'=>'Fail, Please Try Again']);
    }
  }

}