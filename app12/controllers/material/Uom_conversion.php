<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Uom_conversion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('material/M_uom_conversion')->model('vendor/M_vendor');
    }

    public function index() {
        $tamp = $this->M_uom_conversion->show();
        $data['total']=count($tamp);
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $this->template->display('material/V_uom_conversion', $data);
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function filter_data() {
        $res = $this->M_uom_conversion->filter_data($_POST);
        $dt = array();
        foreach ($res as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->MATERIAL);
            $dt[$k][2] = stripslashes($v->DESCRIPTION);
            $dt[$k][3] = stripslashes($v->FROM_UOM);
            $dt[$k][4] = stripslashes($v->FROM_QTY);
            $dt[$k][5] = stripslashes($v->TO_UOM);
            $dt[$k][6] = stripslashes($v->TO_QTY);
            if ($v->STATUS == 1) {
                $dt[$k][7] = "Active";
            } else {
                $dt[$k][7] = "Nonactive";
            }
            $dt[$k][8] = "<a class='btn btn-primary btn-sm' title='Update' href='javascript:void(0)' onclick='update(" . $v->ID . ")'><i class='fa fa-edit'></i></a>";
        }
        $this->output($dt);
    }

    public function show() {
        $data = $this->M_uom_conversion->show();
        $dt = array();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->MATERIAL);
            $dt[$k][2] = stripslashes($v->DESCRIPTION);
            $dt[$k][3] = stripslashes($v->FROM_UOM);
            $dt[$k][4] = stripslashes($v->FROM_QTY);
            $dt[$k][5] = stripslashes($v->TO_UOM);
            $dt[$k][6] = stripslashes($v->TO_QTY);
            if ($v->STATUS == 1) {
                $dt[$k][7] = "Active";
            } else {
                $dt[$k][7] = "Nonactive";
            }
            $dt[$k][8] = "<a class='btn btn-primary btn-sm' title='Update' href='javascript:void(0)' onclick='update(" . $v->ID . ")'><i class='fa fa-edit'></i></a>";
        }
        echo json_encode($dt);
    }

    public function get($id) {
        echo json_encode($this->M_uom_conversion->show(array("ID" => $id)));
    }

    public function change() {
//        strtoupper($string)
        $data = array(
            'MATERIAL' => strtoupper(stripslashes($_POST['mat_material'])),
            'DESCRIPTION' => stripslashes($_POST['desc']),
            'FROM_UOM' => strtoupper(stripslashes($_POST['from_uom'])),
            'FROM_QTY' => stripslashes($_POST['from_qty']),
            'TO_UOM' => strtoupper(stripslashes($_POST['to_uom'])),
            'TO_QTY' => stripslashes($_POST['to_qty']),
            'STATUS' => $_POST['status'],
            'UPDATE_BY' => 1,
            'UPDATE_TIME' => date('Y-m-d H:i:s')
        );
        if ($_POST['id'] == null) {//add data
            $data['CREATE_BY'] = 1;
            $cek = $this->M_uom_conversion->show(array("MATERIAL" => strtoupper(stripslashes($_POST['mat_material']))));
            if (count($cek) == 0) {//cek ketersediaan data
                $q = $this->M_uom_conversion->add($data);
            } else {
                echo "Tipe Materaial Telah Digunakan";
                exit;
            }
        } else {//update data
            $q = $this->M_uom_conversion->update($_POST['id'], $data);
        }

        //CEK QUERY BERHASIL DIJALANKAN
        if ($q == 1) {
            echo "sukses";
        } else {
            echo "Gagal Menambah Data!";
        }
    }

}
