<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prebidlocation extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('other_master/M_pre_bid_location')->model('vendor/M_vendor');
        $this->load->helper(array('string', 'text'));
        $this->load->helper('helperx_helper');
    }


    public function index(){
      $get_menu = $this->M_vendor->menu();

      $dt = array();

      foreach ($get_menu as $k => $v) {
          $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
          $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
          $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
          $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
      }

      $data['menu'] = $dt;
      $this->template->display('setting/V_prebidlocation', $data);
    }

    public function show() {
      $data = $this->M_pre_bid_location->show();
      $result = array();
      $no = 1;

      foreach ($data as $arr) {
        $result[] = array(
          '<center>'.$no.'</center>',
          '<center>'.$arr['nama'].'</center>',
          '<center>'.$arr['alamat'].'</center>',
          "<center><button class='btn btn-primary btn-sm' title='Update' href='javascript:void(0)' onclick=\"update('" . $arr['id'] . "')\"><i class='fa fa-edit'></i></button>",
        );
        $no++;
      }
      echo json_encode($result);
    }

    public function get($id) {
      echo json_encode($this->M_pre_bid_location->show($id));
    }

    public function add() {
      $respon = $this->M_pre_bid_location->add($this->input->post());
      echo json_encode($respon);
    }
    public function delete($value='')
    {
      $respon = $this->M_pre_bid_location->destroy($this->input->post('id'));
      echo json_encode($respon);
    }
  }
