<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Approval extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('material/M_approval')->model('vendor/M_vendor');
        $this->load->helper(array('string', 'text'));
    }

    public function index() {
        $tamp = $this->M_approval->show();
        $get_menu = $this->M_vendor->menu();
        $data['total'] = count($tamp);
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $this->template->display('material/V_approval', $data);
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function filter_data() {
        $res = $this->M_approval->filter_data($_POST);
        $dt = array();
        foreach ($res as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->MATERIAL);
            $dt[$k][2] = stripslashes($v->DESCRIPTION);
            $dt[$k][3] = stripslashes(word_limiter($v->LONG_DESCRIPTION, 2));
            $dt[$k][4] = stripslashes($v->MATERIAL_GROUP);
            $dt[$k][5] = stripslashes($v->MATERIAL_TYPE);
            $dt[$k][6] = stripslashes($v->MATERIAL_UOM);
            if ($v->STATUS == 1) {
                $dt[$k][7] = "Active";
            } else {
                $dt[$k][7] = "Nonactive";
            }
            $dt[$k][8] = "<a class='btn btn-info btn-sm' title='Update' href='javascript:void(0)' onclick='add()'><i class='fa fa-edit'></i></a>";
        }
        $this->output($dt);
    }

    public function show() {
        $data = $this->M_approval->show();
        $dt = array();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->DESCRIPTION);
            $dt[$k][2] = stripslashes(word_limiter($v->LONG_DESCRIPTION, 2));
            $dt[$k][3] = stripslashes($v->MATERIAL_GROUP);
            $dt[$k][4] = stripslashes($v->MATERIAL_TYPE);
            $dt[$k][5] = stripslashes($v->MATERIAL_UOM);
            if ($v->STATUS == 1) {
                $dt[$k][6] = "Active";
            } else {
                $dt[$k][6] = "Nonactive";
            }
//            $dt[$k][7] = "<a class='btn btn-info btn-sm' title='Update' href='javascript:void(0)' onclick='update(" . $v->ID . ")'><i class='fa fa-edit'></i></a>";
            $dt[$k][7] = "<a class='btn btn-primary btn-sm' title='Update' href='javascript:void(0)' onclick='add()'><i class='fa fa-check'></i></a>"
                    . "&nbsp<a class='btn btn-danger btn-sm' title='Update' href='javascript:void(0)' onclick='reject()'><i class='fa fa-ban'></i></a>";
        }
        echo json_encode($dt);
    }

    public function get($id) {
        echo json_encode($this->M_approval->show(array("ID" => $id)));
    }

    public function change() {
//        strtoupper($string)
        $data = array(
            'MATERIAL' => strtoupper(stripslashes($_POST['mat_material'])),
            'DESCRIPTION' => stripslashes($_POST['desc']),
            'LONG_DESCRIPTION' => stripslashes(($_POST['open_edit'])),
            'MATERAIL_GROUP' => stripslashes($_POST['group_material']),
            'MATERAIL_TYPE' => strtoupper(stripslashes($_POST['material_type'])),
            'MATERAIL_UOM' => stripslashes($_POST['material_uom']),
            'STATUS' => $_POST['status'],
            'UPDATE_BY' => 1,
            'UPDATE_TIME' => date('Y-m-d H:i:s')
        );
        if ($_POST['id'] == null) {//add data
            $data['CREATE_BY'] = 1;
            $cek = $this->M_approval->show(array("MATERIAL" => strtoupper(stripslashes($_POST['mat_material']))));
            if (count($cek) == 0) {//cek ketersediaan data
                $q = $this->M_approval->add($data);
            } else {
                echo "Tipe Materaial Telah Digunakan";
                exit;
            }
        } else {//update data
            $q = $this->M_approval->update($_POST['id'], $data);
        }

        //CEK QUERY BERHASIL DIJALANKAN
        if ($q == 1) {
            echo "sukses";
        } else {
            echo "Gagal Menambah Data!";
        }
    }

}
