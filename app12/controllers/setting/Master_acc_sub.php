<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Master_acc_sub extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('setting/M_master_acc_sub')->model('vendor/M_vendor');
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
      $this->template->display('setting/V_master_acc_sub', $data);
    }

    public function show() {
      $data = $this->M_master_acc_sub->show();
      $result = array();
      $no = 1;

      foreach ($data as $arr) {
        if ($arr['STATUS'] == "1") {
          $status = "Enable";
        } else {
          $status = "Disable";
        }
        $result[] = array(
          0 => '<center>'.$no.'</center>',
          1 => '<center>'.$arr['COSTCENTER'].'</center>',
          2 => '<center>'.$arr['ID_ACCSUB'].'</center>',
          3 => '<center>'.$arr['ACCSUB_DESC'].'</center>',
          4 => '<center>'.$arr['POSTING'].'</center>',
          5 => '<center>'.$status.'</center>',
          6 => "<center><button class='btn btn-primary btn-sm' title='Update' href='javascript:void(0)' onclick=\"update('" . $arr['ID_ACCSUB'] . "')\"><i class='fa fa-edit'></i></button>",
        );
        $no++;
      }
      echo json_encode($result);
    }

    public function get($id) {
        echo json_encode($this->M_master_acc_sub->show($id));
    }

    public function add() {

      $idaccsub = $this->input->post('idaccsub');
      $id_acc = $this->input->post('id_acc');
      $acc_desc = $this->input->post('acc_desc');
      $status = $this->input->post('status');

      $data = array(
       'ID_ACCSUB' => $id_acc,
       'ACCSUB_DESC' => $acc_desc,
       'STATUS' => $status,
      );

      $qq = $this->db->query("SELECT * FROM m_accsub WHERE ID_ACCSUB='".$id_acc."'");
      $num = $qq->num_rows();

      if ($idaccsub != "") {
        $data['CHANGED_BY'] = $this->session->userdata['ID_USER'];
        $data['CHANGED_ON'] = date("Y-m-d H:i:s");
        $query = $this->M_master_acc_sub->update($idaccsub, $data);

        if ($query !== false) {
          $respon['success'] = 1;
        } else {
          $respon['success'] = 0;
        }
      } else {
        if ($num > 0) {
          $respon['success'] = 2;
        } else {
          $data['CREATE_BY'] = $this->session->userdata['ID_USER'];
          $data['CREATE_ON'] = date("Y-m-d H:i:s");
          $query = $this->M_master_acc_sub->simpan($data);

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
