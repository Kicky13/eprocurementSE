<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mail_server extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('setting/M_mail_server')->model('vendor/M_vendor');
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
      $this->template->display('setting/V_mail_server', $data);
    }

    public function show() {
      $data = $this->M_mail_server->show();
      $result = array();
      $no = 1;

      foreach ($data as $arr) {
        if ($arr['active'] == "1") {
          $status = "Active";
        } else {
          $status = "Non Active";
        }
        $result[] = array(
          0 => '<center>'.$no.'</center>',
          1 => '<center>'.$arr['email_address'].'</center>',
          2 => '<center>'.$arr['smtp'].'</center>',
          3 => '<center>'.$arr['port'].'</center>',
          4 => '<center>'.$arr['protocol'].'</center>',
          5 => '<center>'.$arr['crypto'].'</center>',
          6 => '<center>'.$status.'</center>',
          7 => "<center><button class='btn btn-primary btn-sm' title='Update' href='javascript:void(0)' onclick=\"update('" . $arr['id'] . "')\"><i class='fa fa-edit'></i></button>",
        );
        $no++;
      }
      echo json_encode($result);
    }

    public function get($id) {
        echo json_encode($this->M_mail_server->show($id));
    }

    public function add() {

      $idx = $this->input->post('idx');
      $email_address = $this->input->post('email_address');
      $smtp = $this->input->post('smtp');
      $port = $this->input->post('port');
      $protocol = $this->input->post('protocol');
      $crypto = $this->input->post('crypto');
      $email_password = $this->input->post('email_password');
      $status = $this->input->post('status');


      $data = array(
       'email_address' => $email_address,
       'smtp' => $smtp,
       'port' => $port,
       'protocol' => $protocol,
       'crypto' => $crypto,
       'email_password' => $email_password,
      );

      $qq = $this->db->query("select * FROM m_mail_setting WHERE email_address='".$email_address."'");
      $num = $qq->num_rows();
      $qq_active = $this->db->query("select * FROM m_mail_setting WHERE active='1' ");

      if ($idx != "") {
        $qq_act = $this->db->query("select * FROM m_mail_setting WHERE id='".$idx."' ");
        if ($qq_act->row()->active == 1) {
          $data['active'] = $status;
        } else {
          if ($qq_active->num_rows() > 0) { $data['active'] = 0; } else { $data['active'] = $status; }
        }

        $data['updated_by'] = $this->session->userdata['ID_USER'];
        $data['updated_date'] = date("Y-m-d H:i:s");
        $query = $this->M_mail_server->update($idx, $data);

        if ($query !== false) {
          $respon['success'] = 1;
        } else {
          $respon['success'] = 0;
        }
      } else {
        if ($num > 0) {
          $respon['success'] = 2;
        } else {
          if ($qq_active->num_rows() > 0) { $data['active'] = 0; } else { $data['active'] = $status; }
          $data['created_by'] = $this->session->userdata['ID_USER'];
          $data['created_date'] = date("Y-m-d H:i:s");
          $query = $this->M_mail_server->simpan($data);

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
