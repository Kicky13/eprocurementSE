<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Budget_holder extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('setting/M_budget_holder')->model('vendor/M_vendor');
        $this->load->helper(array('string', 'text'));
        $this->load->helper('helperx_helper');
    }


    public function index(){
      $get_menu = $this->M_vendor->menu();
      $get_costcenter = $this->M_budget_holder->m_costcenter();
      $get_user = $this->M_budget_holder->m_user();

      $dt = array();

      foreach ($get_menu as $k => $v) {
          $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
          $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
          $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
          $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
      }

      $data['menu'] = $dt;
      $data['get_costcenter'] = $get_costcenter;
      $data['get_user'] = $get_user;
      $this->template->display('setting/V_budget_holder', $data);
    }

    public function m_costcenter_exist(){
      $get_costcenter = $this->M_budget_holder->m_costcenter_exist();
      $result = array();
      foreach ($get_costcenter as $key => $value) {
        $result[] = array(
          'costcenter_exist' => $value
        );
      }
      $result['success'] = true;
      echo json_encode($result);
    }

    public function show() {
      $data = $this->M_budget_holder->show();
      $result = array();
      $no = 1;

      foreach ($data as $arr) {
        if ($arr['status'] == "1") {
          $status = "Enable";
        } else {
          $status = "Disable";
        }
        $result[] = array(
          0 => '<center>'.$no.'</center>',
          1 => '<center>'.$arr['cost_center'].'</center>',
          2 => '<center>'.$arr['COSTCENTER_DESC'].' </center>',
          3 => '<center>'.$arr['NAME'].' </center>',
          4 => '<center>'.$status.'</center>',
          5 => "<center><button class='btn btn-primary btn-sm' title='Update' href='javascript:void(0)' onclick=\"update('".$arr['cost_center']. "', '" . ($arr['id'] == null ? 0 : $arr['id']) . "')\"><i class='fa fa-edit'></i></button>",
        );
        $no++;
      }
      echo json_encode($result);
    }

    public function get() {
        $cc = $this->input->post('cc');
        $id = $this->input->post('id');
        echo json_encode($this->M_budget_holder->show($cc, $id));
    }

    public function add() {
      $idx = $this->input->post('idx');
      $id_user = $this->input->post('id_user');
      $costcenter = $this->input->post('costcenter');
      $status = $this->input->post('status');

      $data = array(
       'id_user' => $id_user,
       'active' => $status,
      );

      if ($idx != "" && $idx != 0) {
        $qq = $this->db->select('id')
                      ->from('m_budget_holder')
                      ->where('cost_center', $costcenter)
                      ->where('id_user', $id_user)
                      ->where('id != ', $idx)
                      ->get();
        $num = $qq->num_rows();
        if ($num > 0) {
          $respon['success'] = 2;
        } else {
          $data['update_by'] = $this->session->userdata['ID_USER'];
          $data['update_date'] = date("Y-m-d H:i:s");
          $query = $this->M_budget_holder->update($idx, $data);
          if ($query !== false) {
            $respon['success'] = 1;
          } else {
            $respon['success'] = 0;
          }
        }
      } else {
        $qq = $this->db->select('id')
                      ->from('m_budget_holder')
                      ->where('cost_center', $costcenter)
                      ->where('id_user', $id_user)
                      ->get();
        $num = $qq->num_rows();
        if ($num > 0) {
          $respon['success'] = 2;
        } else {
          $data['cost_center'] = $costcenter;
          $data['create_by'] = $this->session->userdata['ID_USER'];
          $data['create_date'] = date("Y-m-d H:i:s");
          $query = $this->M_budget_holder->simpan($data);
          if ($query !== false) {
            $respon['success'] = 1;
          } else {
            $respon['success'] = 0;
          }
        }
      }

      echo json_encode($respon);
    }

  }
