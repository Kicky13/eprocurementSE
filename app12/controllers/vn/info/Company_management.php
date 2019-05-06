<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Company_management extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('vn/info/M_company_management', 'mcm');
        $this->load->model('vn/info/M_vn', 'mvn');
        $this->load->model('vn/info/M_all_vendor', 'mav');
        $this->load->database();
    }

    public function index() {
        $id = $this->session->ID;
        $cek = $this->mav->cek_session();
        $get_menu = $this->mvn->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['DESKRIPSI_IND'] = $v->DESCRIPTION_IND;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['DESKRIPSI_ENG'] = $v->DESCRIPTION_ENG;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['ICON'] = $v->ICON;
        }
        $data['menu'] = $dt;
        $this->template->display_vendor('vn/info/V_company_management', $data);
    }

    public function show_company_management() {
        $data = $this->mcm->show_company_management();
        $dt = array();
        foreach ($data as $k => $v) {
          if ($v->FILE_NPWP == '' || $v->FILE_NPWP == 'failed') {
            $file_npwp = '-';
          } else {
            $file_npwp = '<button onclick="review_gambar(\'' . base_url() . 'upload/COMPANY_MANAGEMENT/DAFTAR_DEWAN_DIREKSI/' . $v->FILE_NPWP . '\')" class="btn btn-sm btn-success"><i class="fa fa-file-o"></i></button>';
          }

          if ($v->FILE_NO_ID) {
            $file_ektp = '<button onclick="review_gambar(\'' . base_url() . 'upload/COMPANY_MANAGEMENT/DAFTAR_DEWAN_DIREKSI/' . $v->FILE_NO_ID . '\')" class="btn btn-sm btn-success"><i class="fa fa-file-o"></i></button>';
          } else {
            $file_ektp = '-';
          }


            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->NAME);
            $dt[$k][2] = stripslashes($v->POSITION);
            $dt[$k][3] = stripslashes($v->PHONE);
            $dt[$k][4] = stripslashes($v->EMAIL);
            $dt[$k][5] = stripslashes($v->NO_ID);
            $dt[$k][6] = $file_ektp;
            $dt[$k][7] = stripslashes($v->NPWP);
            $dt[$k][8] = $file_npwp;
            $dt[$k][9] = "<button class='btn btn-primary btn-sm' title='Update' onclick='update1(" . $v->ID . ")'><i class='fa fa-edit'></i></button>&nbsp"
                    . "<button class='btn btn-danger btn-sm' title='Delete' onclick='delete_data(" . $v->ID . ")'><i class='fa fa-trash'></i></button>";
        }
        echo json_encode($dt);
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function check_response($res) {
        if ($res == false)
            $this->output(array('msg' => "Upload file error", 'status' => 'Error'));
        else if ($res == "failed")
            $this->output(array('msg' => "Only pdf file allowed", 'status' => 'Error', 'data'=> $res));
        else if ($res == "size")
            $this->output(array('msg' => "Max file 2MB", 'status' => 'Error'));
    }

    public function upload_file() {
        $NewImageName = '';
        $data = $_FILES;
        $Destination = 'upload/COMPANY_MANAGEMENT/DAFTAR_DEWAN_DIREKSI';
        $ret = array();
        $counter = 0;
        foreach ($data as $k => $v) {
            if ($_FILES[$k]['error'] == 4)
                return "failed";
            $ImageExt = substr($v['name'], strrpos($v['name'], '.'));
            if ($ImageExt != ".pdf")
                return "failed";
            if ($_FILES[$k]['size'] > 2000000)
                return "size";
            if ($k == "scan_ktp") {
                $NewImageName = 'Scan_KTP' . '_' . Date("Ymd_His") . $ImageExt;
                move_uploaded_file($_FILES[$k]['tmp_name'], "$Destination/$NewImageName");
                return $NewImageName;
            } if ($k == "datanpwp") {
                $NewImageName = 'Scan_NPWP' . '_' . Date("Ymd_His") . $ImageExt;
                move_uploaded_file($_FILES[$k]['tmp_name'], "$Destination/$NewImageName");
                return $NewImageName;
            }
            if (move_uploaded_file($_FILES[$k]['tmp_name'], "$Destination/$NewImageName"))
                $counter++;
        }

        if ($counter == 2)
            return $ret;
        else
            return false;
    }

    public function upload_file_npwp() {
        $NewImageName = '';
        $data = $_FILES;
        $Destination = 'upload/COMPANY_MANAGEMENT/DAFTAR_DEWAN_DIREKSI';
        $ret = array();
        $counter = 0;
        foreach ($data as $k => $v) {
            if ($_FILES[$k]['error'] == 4)
                return "failed";
            $ImageExt = substr($v['name'], strrpos($v['name'], '.'));
            if ($ImageExt != ".pdf")
                return "failed";
            if ($_FILES[$k]['size'] > 2000000)
                return "size";
            if ($k == "datanpwp") {
                $NewImageName = 'Scan_NPWP' . '_' . Date("Ymd_His") . $ImageExt;
                move_uploaded_file($_FILES[$k]['tmp_name'], "$Destination/$NewImageName");
                return $NewImageName;
            }
            if (move_uploaded_file($_FILES[$k]['tmp_name'], "$Destination/$NewImageName"))
                $counter++;
        }

        if ($counter == 2)
            return $ret;
        else
            return false;
    }

    public function change_company_management() {
        //echopre($_POST);exit;
        $res = true;
        $flag = 0;

        $data = array(
            'NAME' => strtoupper(stripslashes($_POST['full_name'])),
            'POSITION' => stripslashes($_POST['jabatan']),
            'PHONE' => stripslashes(($_POST['no_tlpn'])),
            'EMAIL' => stripslashes($_POST['email']),
            'NO_ID' => strtoupper(stripslashes($_POST['no_ktp'])),
            'VALID_UNTIL' => date("Y-m-d", strtotime($_POST['berlaku_sampai'])),
            'NPWP' => strtoupper(stripslashes($_POST['npwp'])),
            'UPDATE_BY' => $this->session->ID,
            'ID_VENDOR' => $this->session->ID,
            'STATUS' => 1,
            'UPDATE_TIME' => date('Y-m-d H:i:s'),
        );

        if ($_FILES['scan_ktp']['name'] != '') {
            $res = $this->upload_file();
            //print_r($res);
            // $this->check_response($res);
            $flag = 1;
            $data['FILE_NO_ID'] = $res;
            // $data = array_merge($data, $this->upload_file());
        }

        if ($flag == 1) {
          if ($_FILES['datanpwp']['name'] != ''){
            $res2 = $this->upload_file_npwp();
            //print_r($res2);
            // $this->check_response($res2);
            $flag = 1;
            $data['FILE_NPWP'] = $res2;
          }
        }

        $data['ID'] = $_POST['id'];
        $data_akta = null;
        $result = false;


        // echopre($res);
        if ($_POST['id'] == null) {//add data
            $data['CREATE_BY'] = $this->session->ID;

            $cek = $this->mcm->show_company_management(array("NAME" => strtoupper(stripslashes($_POST['full_name']))));
            if (count($cek) == 0) {//cek ketersediaan data
                // $data = array_merge($data, $res);
                $q = $this->mcm->add_company_management($data);
            } else {
                $this->output(array('msg' => "Nama Telah Digunakan", 'status' => 'Error'));
            }
        } else {//update data
            //$data = array_merge($data, $res);
            $q = $this->mcm->update_company_management($_POST['id'], $data);
        }

        //CEK QUERY BERHASIL DIJALANKAN
        if ($q == 1) {
            $this->output(array('msg' => "Successfuly Saved", 'status' => 'Sukses'));
        } else {
            $this->output(array('msg' => "Error upload data", 'status' => 'Error'));
        }
        // echo json_encode($data);
    }

    public function get_company_management($id) {
        echo json_encode($this->mcm->show_company_management(array("ID" => $id)));
    }

    public function delete_data($id) {
        $result = $this->mcm->delete_data($id);
        $this->output($result);
    }

//--------------------------------------------------------------------------------------------------------//

    public function show_vendor_shareholders() {
        $data = $this->mcm->show_vendor_shareholders();
        $dt = array();
        foreach ($data as $k => $v) {
          if ($v->FILE_NPWP == "" || $v->FILE_NPWP == 'failed') {
            $file_npwp = '-';
          } else {
            $file_npwp = '<button onclick="review_gambar(\'' . base_url() . 'upload/COMPANY_MANAGEMENT/DAFTAR_PEMILIK_SAHAM/' . $v->FILE_NPWP . '\')" class="btn btn-sm btn-success"><i class="fa fa-file-o"></i></button>';
          }

            $dt[$k][0] = $k + 1;
            /*$dt[$k][1] = stripslashes($v->TYPE);*/
            $dt[$k][1] = stripslashes($v->NAME);
            $dt[$k][2] = stripslashes($v->PHONE);
            $dt[$k][3] = stripslashes($v->EMAIL);
            // $dt[$k][5] = date("d-m-Y", strtotime($v->VALID_UNTIL));
            $dt[$k][4] = stripslashes($v->NPWP);
            $dt[$k][5] = $file_npwp;
            $btn_edit = "<button class='btn btn-primary btn-sm' title='Update' href='javascript:void(0)' onclick='update_shareholders(" . $v->ID . ")'><i class='fa fa-edit'></i></button>";
            $btn_delete = "<button class='btn btn-danger btn-sm' title='Delete' href='javascript:void(0)' onclick='hapus_data(" . $v->ID . ")'><i class='fa fa-trash'></i></button>";
            $dt[$k][6] = "$btn_edit $btn_delete";
        }
        echo json_encode($dt);
    }

    public function upload_vendor() {
        $NewImageName = '';
        $data = $_FILES;
        $Destination = 'upload/COMPANY_MANAGEMENT/DAFTAR_PEMILIK_SAHAM';
        $ret = array();
        $counter = 0;
        foreach ($data as $k => $v) {
            if ($_FILES[$k]['error'] == 4)
                return "failed";
            $ImageExt = substr($v['name'], strrpos($v['name'], '.'));
            if ($ImageExt != ".pdf")
                return "failed";
            if ($_FILES[$k]['size'] > 2000000)
                return "size";
            if ($k == "npwpfile") {
                $NewImageName = 'Scan_NPWP' . '_' . Date("Ymd_His") . $ImageExt;
                move_uploaded_file($_FILES[$k]['tmp_name'], "$Destination/$NewImageName");
                return $NewImageName;
            }
            if (move_uploaded_file($_FILES[$k]['tmp_name'], "$Destination/$NewImageName"))
                $counter++;
        }

        if ($counter == 1)
            return $ret;
        else
            return false;
    }

    public function change_vendor_shareholders() {

        $res = true;
        $flag = 0;

        $data = array(
            'NAME' => strtoupper(stripslashes($_POST['nama_lengkap'])),
            'TYPE' => stripslashes($_POST['saham']),
            'PHONE' => stripslashes(($_POST['tlpn'])),
            'EMAIL' => stripslashes($_POST['alamatemail']),
            'VALID_UNTIL' => date("Y-m-d", strtotime($_POST['berlaku_sampai'])),
            'NPWP' => $_POST['nonpwp'],
            'UPDATE_BY' => $this->session->ID,
            'STATUS' => 1,
            'ID_VENDOR' => $this->session->ID,
            'UPDATE_TIME' => date('Y-m-d H:i:s')
        );

        if ($_FILES['npwpfile']['name'] != "" ) {
            $res = $this->upload_vendor();
            // $this->check_response($res);
            $data['FILE_NPWP'] = $res;
            $flag = 1;
        }

        $data_akta = null;
        $result = false;


        if ($_POST['id'] == null) {//add data
            $data['CREATE_BY'] = $this->session->ID;
            $cek = $this->mcm->show_vendor_shareholders(array("NAME" => strtoupper(stripslashes($_POST['nama_lengkap']))));
            if (count($cek) == 0) {//cek ketersediaan data
                // $data = array_merge($data, $res);
                $q = $this->mcm->add_vendor_shareholders($data);
            } else {
                $this->output(array('msg' => "Name already used", 'status' => 'Error'));
            }
        } else {//update data
            if ($flag == 1) {
                // $data = array_merge($data, $res);
                $cek = $this->mcm->get_doc($this->session->ID,$_POST['id'],'FILE_NPWP', 'm_vendor_shareholders');
                if ($cek != false)
                    $this->remove_doc("upload/COMPANY_MANAGEMENT/DAFTAR_PEMILIK_SAHAM/", $cek[0]->FILE_NPWP);
            }
            $q = $this->mcm->update_vendor_shareholders($_POST['id'], $data);
        }

        //CEK QUERY BERHASIL DIJALANKAN
        if ($q == 1) {
            $this->output(array('msg' => "Successfuly Save", 'status' => 'Sukses', 'data' => $res));
        } else {
            $this->output(array('msg' => "Error upload data", 'status' => 'Error', 'data' => $res));
        }
    }

    public function get_vendor_shareholders($id) {
        echo json_encode($this->mcm->show_vendor_shareholders(array("ID" => $id)));
    }

    public function hapus_data($id) {
        $result = $this->mcm->hapus_data($id);
        $this->output($result);
    }

    public function remove_doc($dest, $data) {
        $count = 0;
        unlink($dest . $data);
    }

}
