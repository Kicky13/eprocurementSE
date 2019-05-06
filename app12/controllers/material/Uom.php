<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Uom extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('material/M_uom')->model('vendor/M_vendor');
    }

    public function index() {
        $tamp = $this->M_uom->show();
        $data['total'] = count($tamp);
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $this->template->display('material/V_uom', $data);
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function filter_data() {
        $res = $this->M_uom->filter_data($_POST);
        $dt = array();
        foreach ($res as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->MATERIAL_UOM);
            $dt[$k][2] = stripslashes($v->DESCRIPTION);
            if ($v->STATUS == 1) {
                $dt[$k][3] = "Active";
            } else {
                $dt[$k][3] = "Nonactive";
            }
            if ($v->UOM_TYPE == 2) {
                $dt[$k][4] = "Yes";
            } else {
                $dt[$k][4] = "No";
            }
            $dt[$k][5] = "<a class='btn btn-primary btn-sm' title='Update' href='javascript:void(0)' onclick='update(" . $v->ID . ")'><i class='fa fa-edit'></i></a>";
        }
        $this->output($dt);
    }

    public function show() {
        $data = $this->M_uom->show();
        $dt = array();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->MATERIAL_UOM);
            $dt[$k][2] = stripslashes($v->DESCRIPTION);
            if ($v->STATUS == 1) {
                $dt[$k][3] = "Active";
            } else {
                $dt[$k][3] = "Nonactive";
            }
            if ($v->UOM_TYPE == 2) {
                $dt[$k][4] = "Yes";
            } else {
                $dt[$k][4] = "No";
            }
            $dt[$k][5] = "<a class='btn btn-primary btn-sm' title='Update' href='javascript:void(0)' onclick='update(" . $v->ID . ")'><i class='fa fa-edit'></i></a>";
        }
        echo json_encode($dt);
    }

    public function get($id) {
        echo json_encode($this->M_uom->show(array("ID" => $id)));
    }

    public function change() {
//        strtoupper($string)
        $data = array(
            'MATERIAL_UOM' => strtoupper(stripslashes($_POST['mat_UOM'])),
            'DESCRIPTION' => stripslashes($_POST['desc']),
            'STATUS' => $_POST['status'],
            'UOM_TYPE' => $this->input->post('UOM_TYPE') ? $this->input->post('UOM_TYPE') : 1,
            'UPDATE_BY' => 1,
            'UPDATE_TIME' => date('Y-m-d H:i:s')
        );
        if ($_POST['id'] == null) {//add data
            $data['CREATE_BY'] = 1;
            $cek = $this->M_uom->show(array("MATERIAL_UOM" => strtoupper(stripslashes($_POST['mat_UOM']))));
            if (count($cek) == 0) {//cek ketersediaan data
                $q = $this->M_uom->add($data);
            } else {
                echo "Materaial UOM Telah Digunakan";
                exit;
            }
        } else {//update data
            $q = $this->M_uom->update($_POST['id'], $data);
        }

        //CEK QUERY BERHASIL DIJALANKAN
        if ($q == 1) {
            echo "sukses";
        } else {
            echo "Gagal Menambah Data!";
        }
    }

}
