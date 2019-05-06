<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pmethod extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('setting/M_pmethod')->model('vendor/M_vendor');
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
      $this->template->display('setting/V_pmethod', $data);
    }

    public function show() {
      $data = $this->M_pmethod->show();
      $result = array();
      $no = 1;

      foreach ($data as $arr) {
        if ($arr['STATUS'] == "1") {
          $status = "Active";
        } else {
          $status = "Inactive";
        }
        $result[] = array(
          0 => '<center>'.$no.'</center>',
          1 => '<center>'.$arr['ID_PMETHOD'].'</center>',
          2 => '<center>'.$arr['PMETHOD_DESC'].'</center>',
          3 => '<center>'.$status.'</center>',
          4 => "<center><button class='btn btn-primary btn-sm' title='Update' href='javascript:void(0)' onclick=\"update('" . $arr['ID_PMETHOD'] . "')\"><i class='fa fa-edit'></i></button>",
        );
        $no++;
      }
      echo json_encode($result);
    }

    public function get($id) {
        echo json_encode($this->M_pmethod->show($id));
    }

    public function add() {

      $idaccsub = $this->input->post('idaccsub');
      $id_acc = $this->input->post('id_acc');
      $acc_desc = $this->input->post('acc_desc');
      $status = $this->input->post('status');

      $data = array(
       'ID_PMETHOD' => strtoupper($id_acc),
       'PMETHOD_DESC' => $acc_desc,
       'STATUS' => $status,
      );

      $qq = $this->db->query("SELECT * FROM m_pmethod WHERE ID_PMETHOD='".$id_acc."'");
      $num = $qq->num_rows();

      if ($idaccsub != "") {
        $data['CHANGED_BY'] = $this->session->userdata['ID_USER'];
        $data['CHANGED_ON'] = date("Y-m-d H:i:s");
        $query = $this->M_pmethod->update($idaccsub, $data);

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
          $query = $this->M_pmethod->simpan($data);

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
