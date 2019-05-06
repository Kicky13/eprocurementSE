<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class prefix extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('other_master/M_prefix')->model('vendor/M_vendor');
    }

    public function index() {
        if ($this->input->is_ajax_request()) { 
            $this->load->library('datatable'); 
            return $this->datatable->resource('m_prefix', 'm_prefix.*, parent.DESKRIPSI_ENG as PARENT_DESKRIPSI_ENG') 
            ->join('m_prefix parent', 'parent.ID_PREFIX = m_prefix.PARENT_ID', 'left') 
            ->where('m_prefix.status', 1) 
            ->generate(); 
        } 
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $data['rs_prefix'] = $this->M_prefix->show(); 
        $this->template->display('other_master/V_prefix', $data);
    }

    public function show() {
        $where = array("STATUS" => 1);
        $data = $this->M_prefix->show($where);
        $dt = array();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->DESKRIPSI_IND);
            $dt[$k][2] = stripslashes($v->DESKRIPSI_ENG);
            $dt[$k][3] = "<a class='btn btn-primary btn-sm' title='Update' href='javascript:void(0)' onclick='update(" . $v->ID_PREFIX . ")'><i class='fa fa-edit'></i></a>&nbsp"
                    . "<a class='btn btn-danger btn-sm' title='Hapus User' href='javascript:void(0)' onclick='prefix_delete(" . $v->ID_PREFIX . ")'><i class='fa fa-trash'></i></a>";
        }
        echo json_encode($dt);
    }

    public function get_prefix($id) {
        echo json_encode($this->M_prefix->show(array("ID_PREFIX" => $id)));
    }

    public function change() {
        $data = array(
            'DESKRIPSI_IND' => strtoupper(stripslashes($_POST['prefix_ind'])),
            'DESKRIPSI_ENG' => strtoupper(stripslashes($_POST['prefix_eng'])),
            'PARENT_ID' => $_POST['parent_id'],
            'UPDATE_TIME' => date('Y-m-d H:i:s'),
            'UPDATE_BY' => 1,
        );

        $cek = $this->M_prefix->show(
                array("DESKRIPSI_IND" => strtoupper(stripslashes($_POST['prefix_ind'])),
                    "DESKRIPSI_ENG" => strtoupper(stripslashes($_POST['prefix_eng'])),
                )
        );
        if (count($cek) == 0) {//cek ketersediaan data
            if ($_POST['id'] == null) {//add data
                $data['CREATE_TIME'] = date('Y-m-d H:i:s');
                $data['CREATE_BY'] = $this->session->userdata("ID_USER");
                $data['STATUS'] = 1;
                $q = $this->M_prefix->add($data);
            } else {//update data
                $q = $this->M_prefix->update($_POST['id'], $data);
            }
        } else {
            $dt['msg'] = "Data Sudah pernah dimasukkan sebelumnya";
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
        $q = $this->M_prefix->update($_POST['id'], $data);

        //CEK QUERY BERHASIL DIJALANKAN
        if ($q == 1) {
            echo "sukses";
        } else {
            echo "Gagal Menambah Data!";
        }
    }

}

?>