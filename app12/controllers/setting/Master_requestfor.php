<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Master_requestfor extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('setting/M_master_requestfor')->model('vendor/M_vendor');
        $this->load->helper(array('string', 'text'));
        $this->load->helper('helperx_helper');
    }

    public function index() {
        $get_menu = $this->M_vendor->menu();

        $dt_menu = array();

        foreach ($get_menu as $k => $v) {
          $dt_menu[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
          $dt_menu[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
          $dt_menu[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
          $dt_menu[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }

        $data['menu'] = $dt_menu;
        $this->template->display('setting/V_master_requestfor', $data);
    }

    public function show() {
        $data = $this->M_master_requestfor->show();
        $total = count($data);
        $result = array();
        $no = 1;

        foreach ($data as $arr) {
            $result[] = array(
                0 => '<center>'.$no.'</center>',
                1 => '<center>'.$arr['ID_REQUESTFOR'].'</center>',
                2 => '<center>'.$arr['REQUESTFOR_DESC'].'</center>',
                3 => '<center>'.($arr['STATUS'] == 1 ? 'Active' : 'Inactive').'</center>',
                4 => "<center><button class='btn btn-primary btn-sm' title='Update' href='javascript:void(0)' onclick=\"update('" . $arr['ID_REQUESTFOR'] . "')\"><i class='fa fa-edit'></i></button>",
                );
            $no++;
        }
        echo json_encode($result);
    }

    public function get($id) {
        $result = $this->M_master_requestfor->show($id);
        echo json_encode($result);
    }

    public function process() {
        $cur_user = $_SESSION['ID_USER'];
        $cur_date = date('Y-m-d H:i:s');
        $id = strtoupper($_POST['id']);
        $code = strtoupper($_POST['code']);

        $data = array(
            'ID_REQUESTFOR' => $code,
            'REQUESTFOR_DESC' => $_POST['description'],
            'STATUS' => $_POST['status'],
            'CHANGED_BY' => $cur_user,
            'CHANGED_ON' => $cur_date
        );

        if ($_POST['id'] == null) {
            $cek = $this->M_master_requestfor->check(array(
                'ID_REQUESTFOR' => $code
            ));
            if (count($cek) == 0) {
                $data['CREATE_BY'] = $cur_user;
                $data['CREATE_ON'] = $cur_date;
                $q = $this->M_master_requestfor->add($data);
            } else {
                echo "Code already exist!";
                exit();
            }
        } else {
            if (strcmp($id, $code) == 0) {
                $q = $this->M_master_requestfor->update($_POST['id'], $data);
            } else {
                $cek = $this->M_master_requestfor->check(array(
                    'ID_REQUESTFOR' => $code
                ));
                if (count($cek) == 0) {
                    $q = $this->M_master_requestfor->update($_POST['id'], $data);
                } else {
                    echo "Code already exist!";
                    exit();
                }
            }
        }

        if ($q == 1) {
            echo "Success!";
        } else {
            echo "Failed to process data!";
        }
    }
}
