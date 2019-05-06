<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bank extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('other_master/M_bank')->model('vendor/M_vendor');
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
        $this->template->display('other_master/V_bank', $data);
    }

    public function show() {
        $where = array("STATUS" => 1);
        $data = $this->M_bank->show($where);
        $dt = array();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->NAMA_BANK);
            $dt[$k][2] = stripslashes($v->DESCRIPTION);
            $dt[$k][3] = "<a class='btn btn-primary btn-sm' title='Update' href='javascript:void(0)' onclick='update(" . $v->ID . ")'><i class='fa fa-edit'></i></a>&nbsp"
                    . "<a class='btn btn-danger btn-sm' title='Hapus User' href='javascript:void(0)' onclick='currency_delete(" . $v->ID . ",\"" . $v->NAMA_BANK . "\")'><i class='fa fa-trash'></i></a>";
        }
        echo json_encode($dt);
    }

    public function get_bank($id) {
        echo json_encode($this->M_bank->show(array("ID" => $id)));
    }

    public function change() {
        $data = array(
            'NAMA_BANK' => strtoupper(stripslashes($_POST['nama_bank'])),
            'DESCRIPTION' => strtoupper(stripslashes($_POST['deskripsi'])),
            'UPDATE_TIME' => date('Y-m-d H:i:s'),
            'UPDATE_BY' => $this->session->userdata("ID_USER"),
            'STATUS' => 1,
        );

        $cek = $this->M_bank->show(
                array("NAMA_BANK" => strtoupper(stripslashes($_POST['nama_bank'])),
                    "DESCRIPTION" => strtoupper(stripslashes($_POST['deskripsi'])))
        );
        if (count($cek) == 0) {//cek ketersediaan data
            if ($_POST['id'] == null) {//add data
                $data['CREATE_TIME'] = date('Y-m-d H:i:s');
                $data['CREATE_BY'] = $this->session->userdata("ID_USER");
                $q = $this->M_bank->add($data);
            } else {//update data
                $q = $this->M_bank->update($_POST['id'], $data);
            }
        } else {
            $dt['msg'] = "Data Sudah pernah dimasukkan";
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

        $data = array(
            'STATUS' => 0
        );
        $q = $this->M_bank->update($_POST['id'], $data);

        //CEK QUERY BERHASIL DIJALANKAN
        if ($q == 1) {
            echo "sukses";
        } else {
            echo "Gagal Menambah Data!";
        }
    }

}

?>