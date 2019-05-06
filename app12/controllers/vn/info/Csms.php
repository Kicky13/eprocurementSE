<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Csms extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('vn/info/M_csms', 'mcs');
        $this->load->model('vn/info/M_vn', 'mvn');
        $this->load->model('vn/info/M_all_vendor', 'mav');
        $this->load->database();
    }

    public function check_status()
    {
        $res=$this->mcs->check_status();
        $this->output($res);
    }

    public function index() {
        $cek=$this->mav->cek_session();
        $get_menu = $this->mvn->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['DESKRIPSI_IND'] = $v->DESCRIPTION_IND;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['DESKRIPSI_ENG'] = $v->DESCRIPTION_ENG;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['ICON'] = $v->ICON;
        }
        $data['menu'] = $dt;
        $this->template->display_vendor('vn/info/V_csms', $data);
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function save_data()
    {
        $dt=array();
        $res=null;
        foreach($_POST as $k => $v)
        {
            $dt[$k]=stripslashes($v);
        }
        if($dt['update']=="finish")
        {
            unset($dt['update']);
            $dt['UPDATE_TIME']=date("Y-m-d H:m:s");
            $dt['STATUS']="1";
            $dt['UPDATE_BY']=$this->session->ID;
            $res=$this->mcs->update_data($dt);
        }
        else if($dt['update']=='false')
        {
            unset($dt['update']);
            $dt['ID_VENDOR']=$this->session->ID;
            $dt['STATUS']="2";
            $dt['CREATE_BY']=$this->session->ID;
            $res=$this->mcs->save_data($dt);
        }
        else{
            unset($dt['update']);
            $dt['UPDATE_TIME']=date("Y-m-d H:m:s");
            $dt['UPDATE_BY']=$this->session->ID;
            $dt['STATUS']="2";
            $res=$this->mcs->update_data($dt);
        }
        $this->output($res);
    }

    public function show()
    {
        $res=$this->mcs->show();
        $dt = array();
        foreach ($res as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->TYPE);
            $dt[$k][2] = stripslashes($v->DESCRIPTION);
            $dt[$k][3] = '<button onclick="review(\'' . base_url() . 'upload/CSMS/' . $v->FILE_URL . '\')" class="btn btn-sm btn-success"><i class="fa fa-file-o"></i></button>';
            $dt[$k][4] = '<button class="btn btn-sm btn-primary update-csms" id=' . $v->ID . '><span class="fa fa-edit"></span></button>'
            . '&nbsp<button class="btn btn-danger btn-sm delete" onclick=delete_attach(' . $v->ID .')><span class="fa fa-trash-o">'
            . '</span></button>';
        }
        $this->output($dt);
    }

    public function add_attch()
    {
        $result = false;
        $tmp = $this->cek_uploads("m_vendor_attch_csms", "upload/CSMS", "file_csms", "FILE_URL");
        $flag = $tmp['flag'];
        $res = $tmp['res'];
        if (!empty($this->input->post('id_csms'))) { $idx = $this->input->post('id_csms'); } else { $idx = ""; } ;
        $data = array(
            'ID_VENDOR' => $this->session->ID,
            'TYPE' => stripslashes($this->input->post('jenis_csms')),
            'DESCRIPTION' => stripslashes($this->input->post('description')),
            'CREATE_BY' => $this->session->ID,
            'STATUS' => "1"
        );
        if ($flag == 1) {
          $data = array_merge($data, $res);
        }
        if (!empty($idx)) {
            // echo "update";
            $result = $this->mcs->add_data_attch($data, "m_vendor_attch_csms", "FILE_URL", "CSMS/", null, $idx);
        } else {
          // echo "add";
            $result = $this->mcs->add_data_attch($data, "m_vendor_attch_csms", "FILE_URL", "CSMS/", true, null);
        }
        if ($result === true) {
            $this->output(array("status" => "Sukses", "msg" => "Data Berhasil disimpan"));
        } else if (res === false) {
            $this->output(array("status" => "Error", "msg" => "Data gagal disimpan"));
        }
    }

    public function cek_uploads($tbl, $dest, $file_n, $file_db) {
        $flag = 0;
        $res = 0;
        $key = $this->mcs->cek_data_attch($this->session->ID, $tbl);
        if ($key == false || ($_FILES[$file_n]['name'] != '')) {
            $res = $this->uploads($this->session->ID, $dest, $file_n, $file_db);
            $this->check_response($res);
            $flag = 1;
        }
        return array("flag" => $flag, "res" => $res);
    }

    public function check_response($res) {
        if ($res == false)
            $this->output(array('msg' => "Gagal upload File", 'status' => 'Error'));
        else if ($res == "failed")
            $this->output(array('msg' => "Hanya File PDF yang diijinkan", 'status' => 'Error'));
        else if ($res == "size")
            $this->output(array('msg' => "Ukuran File Maksimal 2MB", 'status' => 'Error'));
    }

    public function uploads($id, $Destination, $data_file, $db_name) {
        $NewImageName = '';
        $data = $_FILES;
        $ret = array();
        $counter = 0;
        foreach ($data as $k => $v) {
            $ImageExt = substr($v['name'], strrpos($v['name'], '.'));
            if ($ImageExt != ".pdf") {
                return "failed";
            }
            if ($_FILES[$k]['size'] > 2000000)
                return "size";
            if ($k == $data_file) {
                $NewImageName = $id . '_' . Date("Ymd_His") . $ImageExt;
                $ret[$db_name] = $NewImageName;
            }
            if (move_uploaded_file($_FILES[$k]['tmp_name'], "$Destination/$NewImageName"))
                $counter++;
        }
        if ($counter == 1)
            return $ret;
        else
            return false;
    }

    public function get_data()
    {
        $res=$this->mcs->get_data();
        if($res == false)
            $this->output(null);
        else
            $this->output($res[0]);
    }

    public function delete_attch()
    {
         if ($_POST["API"] == "delete") {
            $res = $this->mcs->delete_attch($_POST['ID']);
            if ($res == true) {
                $this->output(true);
            } else {
                $this->output(false);
            }
        }
        $this->output(false);
    }
}
