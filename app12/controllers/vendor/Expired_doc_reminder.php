<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Expired_doc_reminder extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model('vendor/M_expired_doc_reminder', 'edr')->model('vendor/M_vendor');
        $this->load->database();
    }

    public function index() {
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $this->template->display('vendor/V_expired_doc_reminder', $data);
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function show_document() {
        $result = $this->edr->show_document();
        $dt = array();
        if ($result != false) {
            foreach ($result as $k => $v) {
                $dt[$k][0] = $k + 1;
                $dt[$k][1] = $v->document_type;
                $dt[$k][2] = $v->reminder_day.' Day';
                $dt[$k][3] = $v->reminder_day2.' Day';
                $dt[$k][4] = $v->reminder_day3.' Day';
                if ($v->active == 1) {
                    $dt[$k][5] = "Active";
                } else {
                    $dt[$k][5] = "Nonactive";
                }
               $dt[$k][6] = "<a class='btn btn-primary btn-sm' title='Update' href='javascript:void(0)' onclick='update(" . $v->id . ")'><i class='fa fa-edit'></i></a>";
            }
        }
        $this->output($dt);
    }

    public function show_edit($id){
      $result = $this->edr->show_edit($id);
      echo json_encode($result, JSON_PRETTY_PRINT);
    }

    public function add_doc_type() {

      $iddoc = $this->input->post('iddoc');
      $type_doc = $this->input->post('type_doc');
      $reminder_day = $this->input->post('reminder_day');
      $reminder_day2 = $this->input->post('reminder_day2');
      $reminder_day3 = $this->input->post('reminder_day3');
      $status = $this->input->post('status');

      $data = array(
       'document_type' => $type_doc,
       'reminder_day' => $reminder_day,
       'reminder_day2' => $reminder_day2,
       'reminder_day3' => $reminder_day3,
       'active' => $status
      );

      if ($reminder_day2 > $reminder_day) {
        $respon['success'] = false;
        $respon['message'] = 'Reminder Day 2 is more than Reminder Day 1';

      } elseif ($reminder_day3 > $reminder_day2) {
        $respon['success'] = false;
        $respon['message'] = 'Reminder Day 3 is more than Reminder Day 2';
      } else {
        if ($iddoc != "") {
          $query = $this->edr->update_type_doc($iddoc, $data);
        } else {
          $query = $this->edr->add_doc_type($data);
        }

        if ($query !== false) {
          $respon['success'] = true;
          $respon['message'] = '';
        } else {
          $respon['success'] = false;
          $respon['message'] = 'Oops, Something wrong';

        }
      }

      echo json_encode($respon);
    }


}
