<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Position extends CI_Controller {

  protected $view = 'cmms/position';
  protected $menu;

  public function __construct() {
    parent::__construct();
    $this->load->model('vendor/M_vendor');
    $this->load->model('vendor/M_all_intern', 'mai');
    $this->load->model('cmms/M_position', 'M_position');

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
  public function index()
  {
    $data['menu'] = $this->menu;
    $data['title'] = 'Structure Organization CMMS';
    $data['data'] = $this->M_position->index_list();
    $this->template->display($this->view .'/index', $data);
  }
  public function form($value='')
  {
    $id = $this->input->post('id') ? $this->input->post('id') : 0;
    $row = '';
    $user = $this->M_position->form_user_1();
    if($id)
    {
      $row = $this->M_position->form_row($id);
      $user = $this->M_position->form_user($row->user_id);
    }
    $data = [
      'user' => $user,
      'parent' => $this->M_position->form_parent(),
      'id' => $id,
      'row' => $row
    ];
    $this->load->view($this->view.'/form', $data);
  }
  public function store($value='')
  {
    $p = $this->input->post();
    if($p['id'])
    {
      $id = $p['id'];
      unset($p['id']);
      $this->db->where('id',$id)->update('cmms_position', $p);
    }
    else
    {
      $this->db->insert('cmms_position', $p);
    }
  }
  public function delete($id)
  {
    $this->db->where('id',$id)->delete('cmms_position');
    $this->session->set_flashdata('message', array(
                'message' => 'Data Deleted',
                'type' => 'success'
            ));
    redirect(base_url('cmms/position'));
  }
}