<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Certification_experience extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation', 'session');
        $this->load->model('vn/info/M_Certification_experiece', 'mce');
        $this->load->model('vn/info/m_vn', 'mvn');
        $this->load->model('vn/info/m_all_vendor', 'mav');
        $this->load->database();
    }

    public function index() {
        $id = $_SESSION['ID'];
        $cek = $this->mav->cek_session();
        $get_menu = $this->mvn->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['DESKRIPSI_IND'] = $v->DESCRIPTION_IND;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['DESKRIPSI_ENG'] = $v->DESCRIPTION_ENG;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['ICON'] = $v->ICON;
        }
        $data['currency'] = $this->mce->get_currency();
        $data['certificate_type'] = $this->mce->get_cert();
        $data['BPJS'] = $this->mce->get_bpjs();
        $data['BPJSTK'] = $this->mce->get_bpjstk();
        $data['menu'] = $dt;
        $this->template->display_vendor('vn/info/V_certification_experience', $data);
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function get_experience() {
        # code...
        $data = $this->mce->show_experience();
        $dt = array();
        foreach ($data as $k => $v) {
            # code...
            $dt[$k]["NO"] = $k + 1;
            $dt[$k]["CUSTOMER_NAME"] = stripslashes($v->CUSTOMER_NAME);
            $dt[$k]["PROJECT_NAME"] = stripslashes($v->PROJECT_NAME);
            $dt[$k]["PROJECT_DESCRIPTION"] = stripslashes($v->PROJECT_DESCRIPTION);
            $dt[$k]["PROJECT_VALUE"] = stripslashes($v->PROJECT_VALUE);
            $dt[$k]["CONTRACT_NO"] = stripslashes($v->CONTRACT_NO);
            $dt[$k]["START_DATE"] = stripslashes($v->START_DATE);
            $dt[$k]["END_DATE"] = stripslashes($v->END_DATE);
            $dt[$k]["CONTACT_PERSON"] = stripslashes($v->CONTACT_PERSON);
            $dt[$k]["PHONE"] = stripslashes($v->PHONE);
            $dt[$k]["CURENCY"] = stripslashes($v->CURRENCY);
            $dt[$k]["AKSI"] = '<button class="btn btn-sm btn-primary update " id=' . $v->ID . '><span class="fa fa-edit"></span></button>'
                    . '&nbsp<button class="btn btn-danger btn-sm delete" onclick="hapus(' . $v->ID . ')"><span class="fa fa-trash-o">'
                    . '</span></button>';
        }

        echo json_encode($dt);
    }

    public function upload_file() {
        $NewImageName = '';
        $data = $_FILES;
        $Destination = 'upload/CE/CERTIFICATION';
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

            $NewImageName = 'certificate' . '_' . Date("Ymd_His") . $ImageExt;
            $ret['FILE_URL'] = $NewImageName;

            move_uploaded_file($_FILES[$k]['tmp_name'], "$Destination/$NewImageName");
        }
        return $ret;
    }

    public function check_response($res) {
        if ($res == false)
            $this->output(array('msg' => "Gagal upload file", 'status' => 'Error'));
        else if ($res == "failed")
            $this->output(array('msg' => "Hanya file pdf yang diijinkan", 'status' => 'Error'));
        else if ($res == "size")
            $this->output(array('msg' => "Maksimal file 2MB", 'status' => 'Error'));
    }

    public function remove_doc($dest, $data) {
        $count = 0;
        unlink($dest . $data);
    }

    public function get_certificate() {
        # code...
        $url = "upload/CERTIFICATION/";
        $data = $this->mce->get_certificate();
        $dt = array();
        $base = base_url();
        foreach ($data as $k => $v) {
            # code...
            $dt[$k]["NO"] = $k + 1;
            $dt[$k]["CREATOR"] = stripslashes($v->CREATOR);
            $dt[$k]["TYPE"] = stripslashes($v->TYPE);
            $dt[$k]["NO_DOC"] = stripslashes($v->NO_DOC);
            $dt[$k]["CREATE_BY"] = stripslashes($v->CREATE_BY);
            $dt[$k]["VALID_SINCE"] = stripslashes($v->VALID_SINCE);
            $dt[$k]["VALID_UNTIL"] = stripslashes($v->VALID_UNTIL);
            $dt[$k]["UPLOAD_CERTIFICATE"] = "<button class='btn btn-sm btn-success' onclick=review_file('" . $base . 'upload/CE/CERTIFICATION/' . $v->FILE_URL . "')><i class='fa fa-file-o'></i></button>";
            $dt[$k]["AKSI"] = '<button class="btn btn-sm btn-primary update " id=' . $v->ID . '><span class="fa fa-edit"></span></button>'
                    . '&nbsp<button class="btn btn-danger btn-sm delete" onclick="hapuscert(' . $v->ID . ')"><span class="fa fa-trash-o">'
                    . '</span></button>';
        }

        echo json_encode($dt);
    }

    public function add_certificate() {
        # code...
        $res=true;
        $flag=0;
        $open= stripslashes($this->input->post('start_apply'));
        $close= stripslashes($this->input->post('start_end'));
        $chk=$this->mav->check_date($open,$close);
        if($chk['status'] == "Error")
            $this->output($chk);

        if ($_POST['KEY'] == 0 || ($_POST['KEY'] != 0 && $_FILES['file_ebtke']['name'] != '')) {
            $res = $this->upload_file();
            $this->check_response($res);
            $flag = 1;
        }
        $id = $this->session->ID;
        $data = array(
            'CATEGORY' => "CERTIFICATION",
            'TYPE' => strtoupper(stripslashes($_POST['ftype_sertifikasi'])),
            'CREATOR' => stripslashes($_POST['name']),
            'NO_DOC' => stripslashes(($_POST['number'])),
            'CREATE_BY' => stripslashes($_POST['issued']),
            'VALID_SINCE' =>$open,
            'VALID_UNTIL' => $close,
            'ID_VENDOR' => $this->session->ID,
            'STATUS' => 1,
        );
        if ($_POST['KEY'] == 0) {
            $alldata = array_merge($data, $res);
            $q = $this->mce->add_data_certification($alldata);
        } else {
            $data['UPDATE_BY'] = $id;
            $data['UPDATE_TIME'] = date('Y-m-d H:i:s');
            $key = stripslashes($this->input->post('KEY'));
            if ($flag == 1) {
                $cek = $this->mce->get_doc($this->session->ID, $key, 'FILE_URL', 'm_vendor_certification');
                if ($cek != false)
                    $this->remove_doc("upload/GOODS/", $cek[0]->FILE_URL);
            }
            $q = $this->mce->update_cer($key, $data);
        }
        if ($q == false)
            $this->output(array("msg" => "Oops, Terjadi Kesalahan", "status" => "failed"));
        else
            $this->output(array("msg" => "Data sudah tersimpan", "status" => "success"));
    }

    public function add_experience() {
        # code...
        $res = true;
        $flag = 0;
        $id = $this->session->ID;
        $open= stripslashes($this->input->post('start'));
        $close= stripslashes($this->input->post('end'));
        $chk=$this->mav->check_date($open,$close);
        if($chk['status'] == "Error")
            $this->output($chk);

        $data = array(
            'CUSTOMER_NAME' => stripslashes($this->input->post('custumer')),
            'PROJECT_NAME' => stripslashes($this->input->post('project')),
            'CONTRACT_NO' => stripslashes($this->input->post('no_contract')),
            'PROJECT_VALUE' => stripslashes($this->input->post('project_value')),
            'CURRENCY' => stripslashes($this->input->post('currency')),
            'START_DATE' => $open,
            'END_DATE' => $close,
            'CONTACT_PERSON' => stripslashes($this->input->post('contact')),
            'PHONE' => stripslashes($this->input->post('no_contact')),
            'PROJECT_DESCRIPTION' => stripslashes($this->input->post('desc')),
            'CREATE_BY' => $id,
            'ID_VENDOR' => $id,
            'STATUS' => "1"
        );
        if ($_POST["KEY"] == 0) {
            # code...
            $result = $this->mce->add_exp($data);
            $this->output(true);
        } else {
            $key = stripslashes($this->input->post('KEY'));
            $data['UPDATE_BY'] = $id;
            $result = $this->mce->update_exp($key, $data);
            $this->output(true);
        }
    }

    public function delete_exp($id) {
        # code...
        $res = $this->mce->m_d_exp($id, $this->session->ID);

        $this->output($res);
    }

    public function delete_cert($id) {
        # code...
        $res = $this->mce->m_d_cert($id, $this->session->ID);

        $this->output($res);
    }

    public function add_bpjs() {
      $doc_id = $this->input->post("doc_id");
      $doc_type = $this->input->post("doc_type");
      $issued_by_doc = $this->input->post("issued_by_doc");
      $file_doc = $this->input->post("file_doc");
      $nomor_doc = $this->input->post("nomor_doc");
      $issued_date_doc = $this->input->post("issued_date_doc");
      $valid_to_doc = $this->input->post("valid_to_doc");
      // $file_doc = $this->input->post("file_doc");

      $dt_post = array(
        'ID_VENDOR' => $this->session->ID,
        'CATEGORY' => $doc_type,
        'NO_DOC' => $nomor_doc,
        'STATUS' => '1',
        'VALID_SINCE' => date("Y-m-d", strtotime(stripslashes($issued_date_doc))),
        // 'CREATOR' => $issued_by_doc,
        // 'VALID_UNTIL' => date("Y-m-d", strtotime(stripslashes($valid_to_doc))),
      );

      $file = true;

      if (!empty($_FILES['file_doc']['name'])) {
        $upload = $this->doc_upload('file_doc', $doc_type);
        $dt_files['dt_file'] = $upload;
        if ($dt_files['dt_file']['success'] == true) {
          $dt_post['FILE_URL'] = $dt_files['dt_file']['file_name'];
        } else {
          $file = false;
        }
      }

      if ($file == true) {
        if (empty($doc_id)) {
          $dt_post['CREATE_TIME'] = date('Y-m-d H:i:s');
          $dt_post['CREATE_BY'] = $this->session->ID;
          $result = $this->mce->add_bpjs($dt_post);
        } else {
          $dt_post['ID'] = $doc_id;
          $dt_post['UPDATE_TIME'] = date('Y-m-d H:i:s');
          $dt_post['UPDATE_BY'] = $this->session->ID;
          $result = $this->mce->upd_bpjs($dt_post);
        }
      } else {
        $result = false;
      }
      if ($result === true) {
          $this->output(array("status" => "Sukses", "msg" => "Data BPJS Successfuly Saved"));
      } else if ($res === false) {
          $this->output(array("status" => "Error", "msg" => "Data BPJS Failed"));
      }
    }

    public function doc_upload($files, $doc_type) {
        $config['upload_path']          = './upload/LEGAL_DATA/'.$doc_type;
        $config['allowed_types']        = 'pdf';
        $config['max_size']             = 10240;
        $config['encrypt_name']         = TRUE;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload($files)) {
            $data = $this->upload->data();
            $response = array(
                'success' => true,
                'file_name' => $data['file_name'],
            );
        } else {
            $response = array(
                'success' => false,
            );
        }
        return $response;
    }

}
