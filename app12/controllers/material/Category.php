<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Category extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('material/M_category')->model('vendor/M_vendor');
        $this->load->helper(array('string', 'text'));
    }

    public function index() {
        $tamp = $this->M_category->show("STATUS = 1");
        $get_menu = $this->M_vendor->menu();

        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $data['total'] = count($tamp);
        $this->template->display('material/V_category', $data);
    }

    public function show() {
        $data = $this->M_category->show(array("CATEGORY" => "CATEGORY"));
        $class = array();
        foreach ($data as $k => $v) {
            $class[] = $v->PARENT;
        }
        
        if (count($class) != 0) {//saat ada data
//            $this->M_category->show(array())
        }
        echopre($class);
        exit;
        $dt = array();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->MATERIAL_GROUP);
            $dt[$k][2] = stripslashes($v->DESCRIPTION);
            $dt[$k][3] = $v->DESCRIPTION;
            if ($v->STATUS == 1) {
                $dt[$k][4] = "Active";
            } else {
                $dt[$k][4] = "Nonactive";
            }
            $dt[$k][5] = "<a class='btn btn-primary btn-sm' title='Update' href='javascript:void(0)' onclick='update(" . $v->ID . ")'><i class='fa fa-edit'></i></a>";
        }
        echo json_encode($dt);
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function get_group() {
        $res = $this->M_category->get_group($_POST);
        $dt = array();
        if ($res != null) {
            foreach ($res as $k => $v) {
                $dt[$k][0] = $k + 1;
                $dt[$k][1] = $v->MATERIAL_GROUP;
                $dt[$k][2] = $v->DESCRIPTION;
                $dt[$k][3] = $v->LONG_DESCRIPTION;
                if ($v->STATUS == 1) {
                    $dt[$k][4] = "Active";
                } else {
                    $dt[$k][4] = "Nonactive";
                }
                $dt[$k][5] = "<a class='btn btn-primary btn-sm' title='Update' href='javascript:void(0)' onclick='update(" . $v->ID . ")'><i class='fa fa-edit'></i></a>";
            }
        }
        $this->output($dt);
    }

    public function get($id) {
        echo json_encode($this->M_category->show(array("ID" => $id)));
    }

    public function change() {
//        strtoupper($string)
        $data = array(
            'MATERIAL_GROUP' => strtoupper(stripslashes($_POST['mat_group'])),
            'DESCRIPTION' => stripslashes($_POST['desc']),
            'LONG_DESCRIPTION' => stripslashes(($_POST['open_edit'])),
            'STATUS' => $_POST['status'],
            'UPDATE_BY' => 1,
            'UPDATE_TIME' => date('Y-m-d H:i:s')
        );
        if ($_POST['id'] == null) {//add data
            $data['CREATE_BY'] = 1;
            $cek = $this->M_category->show(array("MATERIAL_group" => strtoupper(stripslashes($_POST['mat_group']))));
            if (count($cek) == 0) {//cek ketersediaan data
                $q = $this->M_category->add($data);
            } else {
                echo "Grup Materaial Telah Digunakan";
                exit;
            }
        } else {//update data
            $q = $this->M_category->update($_POST['id'], $data);
        }

        //CEK QUERY BERHASIL DIJALANKAN
        if ($q == 1) {
            echo "sukses";
        } else {
            echo "Gagal Menambah Data!";
        }
    }

}
