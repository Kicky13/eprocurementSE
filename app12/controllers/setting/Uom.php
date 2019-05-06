<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Uom extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('setting/M_currency')->model('vendor/M_vendor')->model('other_master/M_exchange_rate');
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
      $this->template->display('setting/uom_material_list', $data);
    }

    public function show() {
      $data = $this->M_currency->show();
      $result = array();
      $no = 1;

      foreach ($data as $arr) {
        if ($arr['STATUS'] == "1") {
          $status = "Active";
        } else {
          $status = "Non Active";
        }
        $result[] = array(
          0 => '<center>'.$no.'</center>',
          1 => '<center>'.$arr['CURRENCY'].'</center>',
          2 => '<center>'.$arr['DESCRIPTION'].'</center>',
          3 => '<center>'.$status.'</center>',
          4 => "<center><button class='btn btn-primary btn-sm' title='Update' href='javascript:void(0)' onclick=\"update('" . $arr['ID'] . "')\"><i class='fa fa-edit'></i></button>",
        );
        $no++;
      }
      echo json_encode($result);
    }

    public function get($id) {
        echo json_encode($this->M_currency->show($id));
    }

    public function add() {

      $idaccsub = $this->input->post('idaccsub');
      $id_acc = $this->input->post('id_acc');
      $acc_desc = $this->input->post('acc_desc');
      $status = $this->input->post('status');

      $data = array(
       'CURRENCY' => strtoupper($id_acc),
       'DESCRIPTION' => $acc_desc,
       'STATUS' => $status,
      );

      $qq = $this->db->query("SELECT * FROM m_currency WHERE CURRENCY='".$id_acc."'");
      $num = $qq->num_rows();

      if ($idaccsub != "") {
        $data['UPDATE_BY'] = $this->session->userdata['ID_USER'];
        $data['UPDATE_TIME'] = date("Y-m-d H:i:s");
        $query = $this->M_currency->update($idaccsub, $data);

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
          $data['CREATE_TIME'] = date("Y-m-d H:i:s");
          $query = $this->M_currency->simpan($data);

          if ($query !== false) {
            $respon['success'] = 1;
          } else {
            $respon['success'] = 0;
          }
        }
      }

      echo json_encode($respon);
    }
    public function exchange_rate()
    {
      $get_menu = $this->M_vendor->menu();

      $dt = array();

      foreach ($get_menu as $k => $v) {
          $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
          $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
          $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
          $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
      }

      $data['menu'] = $dt;
      $data['m_currency'] = $this->M_currency->all();
      $this->template->display('setting/exchange_rate_list', $data);
    }
    public function exchange_rate_show($value='')
    {
      $data = $this->M_exchange_rate->show();
      $result = array();
      $no = 1;

      foreach ($data as $arr) {
        $result[] = array(
          0 => '<center>'.$no.'</center>',
          1 => '<center>'.$this->M_currency->find($arr['currency_from'])->CURRENCY.'</center>',
          2 => '<center>'.$this->M_currency->find($arr['currency_to'])->CURRENCY.'</center>',
          3 => '<center>'.numIndo($arr['amount_from'],2).'</center>',
          4 => '<center>'.numIndo($arr['amount_to'],2).'</center>',
          5 => '<center>'.dateToIndo($arr['valid_from']).'</center>',
          6 => '<center>'.dateToIndo($arr['valid_to']).'</center>',
          7 => "<center><button class='btn btn-primary btn-sm' title='Update' href='javascript:void(0)' onclick=\"update('" . $arr['id'] . "')\"><i class='fa fa-edit'></i></button>",
        );
        $no++;
      }
      echo json_encode($result);
    }
    public function get_exchange_rate($id) {
        echo json_encode($this->M_exchange_rate->show($id));
    }
    public function add_exchange_rate() {
      $respon = $this->M_exchange_rate->add($this->input->post());
      echo json_encode($respon);
    }
  }
