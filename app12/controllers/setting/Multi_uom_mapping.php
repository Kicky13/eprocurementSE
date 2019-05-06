<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Multi_uom_mapping extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('setting/M_multi_uom_mapping')->model('vendor/M_vendor');
        $this->load->helper(array('string', 'text'));
        $this->load->helper('helperx_helper');
    }


    public function index(){
      $get_menu = $this->M_vendor->menu();
      $get_uom = $this->M_multi_uom_mapping->m_material_uom();

      $dt = array();

      foreach ($get_menu as $k => $v) {
          $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
          $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
          $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
          $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
      }

      $data['menu'] = $dt;
      $data['get_uom'] = $get_uom;
      $this->template->display('setting/V_multi_uom_mapping', $data);
    }

    public function show() {
      $data = $this->M_multi_uom_mapping->show();
      $result = array();
      $no = 1;

      foreach ($data as $arr) {
        if ($arr['status'] == "1") {
          $status = "Active";
        } else {
          $status = "Non Active";
        }
        $result[] = array(
          0 => '<center>'.$no.'</center>',
          1 => '<center>'.$arr['uom1_desc']." (".$arr['uom1_code'].')</center>',
          2 => '<center>'.$arr['uom2_desc']." (".$arr['uom2_code'].')</center>',
          3 => '<center>'.$arr['uom_desc']." (".$arr['uom_code'].')</center>',
          4 => '<center>'.$status.'</center>',
          5 => "<center><button class='btn btn-primary btn-sm' title='Update' href='javascript:void(0)' onclick=\"update('" . $arr['uom'] . "')\"><i class='fa fa-edit'></i></button>",
        );
        $no++;
      }
      echo json_encode($result);
    }

    public function get($id) {
        echo json_encode($this->M_multi_uom_mapping->show($id));
    }

    public function add() {

      $uom_id = $this->input->post('uom_id');
      $uom = $this->input->post('uom');
      $uom_1 = $this->input->post('uom_1');
      $uom_2 = $this->input->post('uom_2');
      $status = $this->input->post('status');

      $data = array(
       'uom' => $uom,
       'uom1' => $uom_1,
       'uom2' => $uom_2,
       'status' => $status,
      );


      if ($uom_id != "") {
        $data['update_by'] = $this->session->userdata['ID_USER'];
        $data['update_date'] = date("Y-m-d H:i:s");
        $query = $this->M_multi_uom_mapping->update($uom_id, $data);

        if ($query !== false) {
          $respon['success'] = 1;
        } else {
          $respon['success'] = 0;
        }
      } else {
        $data['create_by'] = $this->session->userdata['ID_USER'];
        $data['create_date'] = date("Y-m-d H:i:s");
        $query = $this->M_multi_uom_mapping->simpan($data);

        if ($query !== false) {
          $respon['success'] = 1;
        } else {
          $respon['success'] = 0;
        }
      }

      echo json_encode($respon);
    }

  }
