<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Office_category extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('other_master/M_office_category')->model('vendor/M_vendor');
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
        $this->template->display('other_master/V_office_category', $data);
    }

    public function show() {
        $where = array("STATUS" => 1);
        $data = $this->M_office_category->show($where);
        $dt = array();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->DESKRIPSI_IND);
            $dt[$k][2] = stripslashes($v->DESKRIPSI_ENG);
            $dt[$k][3] = "<a class='btn btn-primary btn-sm' title='Update' href='javascript:void(0)' onclick='update(" . $v->ID_OFFICE . ")'><i class='fa fa-edit'></i></a>&nbsp"
                    . "<a class='btn btn-danger btn-sm' title='Hapus User' href='javascript:void(0)' onclick='office_delete(" . $v->ID_OFFICE . ")'><i class='fa fa-trash'></i></a>";
        }
        echo json_encode($dt);
    }

    public function get_office_category($id) {
        echo json_encode($this->M_office_category->show(array("ID_OFFICE" => $id)));
    }

    public function change() {
        $data = array(
            'DESKRIPSI_IND' => strtoupper(stripslashes($_POST['office_ind'])),
            'DESKRIPSI_ENG' => strtoupper(stripslashes($_POST['office_eng'])),
            'UPDATE_TIME' => date('Y-m-d H:i:s'),
            'UPDATE_BY' => $this->session->userdata("ID_USER"),
            'STATUS' => 1,
        );

        $cek1 = $this->M_office_category->show(
                array("DESKRIPSI_IND" => strtoupper(stripslashes($_POST['office_ind'])),
                    'DESKRIPSI_ENG' => strtoupper(stripslashes($_POST['office_eng'])))
        );

        if (count($cek1) == 0) {//cek ketersediaan data
            if ($_POST['id'] == null) {//add data
                $data['CREATE_TIME'] = date('Y-m-d H:i:s');
                $data['CREATE_BY'] = $this->session->userdata("ID_USER");
            } else {//update data
                $q = $this->M_office_category->update($_POST['id'], $data);
            }
            $q = $this->M_office_category->add($data);
        } else {
            $dt['msg'] = "Data sudah pernah dimasukkan";
            echo json_encode($dt);
            exit;
        }

        //CEK QUERY BERHASIL DIJALANKAN
        if ($q == 1) {
            $dt['msg'] = "sukses";
        } else {
            $dt['msg'] = "Gagal Menambah Data!";
        }
        echo json_encode($dt);
    }

    public function delete() {
        $data = array('STATUS' => 0);

        $q = $this->M_office_category->update($_POST['id'], $data);
        //CEK QUERY BERHASIL DIJALANKAN
        if ($q == 1) {
            echo "sukses";
        } else {
            echo "Gagal Menambah Data!";
        }
    }

}

?>