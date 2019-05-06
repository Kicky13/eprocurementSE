<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class General_data extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('vn/info/M_general_data', 'mgd');
        $this->load->model('vn/info/M_vn', 'mvn');
        $this->load->model('vn/info/M_all_vendor', 'mav');
    }

    public function index() {
        $id = $this->session->ID_VENDOR;
        $cek = $this->mav->cek_session();
        $res = $this->get_data($id);
        $get_info_ktp = $this->mgd->get_info_ktp();
        $supp = $this->mgd->get_klasifikasi();
        $data['supp'] = $supp;
        $act = array();
        $cnt = 0;
        $pil = explode(",", $res[0]->CLASSIFICATION);
        $dt1 = array();
        $dt2 = array();
        foreach ($supp as $k => $v) {
            //$dt1[$k] = $v->DESKRIPSI_IND;
            $dt1[$k] = $v->DESKRIPSI_ENG;
            $cek = 0;
            foreach ($pil as $kk => $vv) {
                //if ($vv == $v->DESKRIPSI_IND) {
                if ($vv == $v->DESKRIPSI_ENG) {
                    $cek++;
                }
            }
            if ($cek > 0) {
                //$dt2[$k]['value'] = $v->DESKRIPSI_IND;
                $dt2[$k]['value'] = $v->DESKRIPSI_ENG;
                $dt2[$k]['tambahan'] = 'checked';
            } else {
                //$dt2[$k]['value'] = $v->DESKRIPSI_IND;
                $dt2[$k]['value'] = $v->DESKRIPSI_ENG;
                $dt2[$k]['tambahan'] = 'none';
            }
        }
        $data['act'] = $dt2;
        $data['all'] = null;
        // $data['ktp'] = null;
        if ($res != "failed") {
          $data['all'] = $res;
        }
        $data['KTP'] = $get_info_ktp;
        $get_menu = $this->mvn->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['DESKRIPSI_IND'] = $v->DESCRIPTION_IND;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['DESKRIPSI_ENG'] = $v->DESCRIPTION_ENG;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['ICON'] = $v->ICON;
        }
        $data['menu'] = $dt;
        $prefix = array();
        $rs_prefix = $this->db->get('m_prefix')->result();
        foreach ($rs_prefix as $r_prefix) {
            $prefix[$r_prefix->PARENT_ID][]= $r_prefix;
        }
        $data['prefix'] = $prefix;
        $this->template->display_vendor('vn/info/V_general_data', $data);
    }
/* ===========================================-------- API START------- ====================================== */
    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

/* ===========================================       Add data START     ====================================== */
    public function add_info() {
       if (!empty($_POST['SUB_PREFIX'])) { $sub_prefix = $_POST['SUB_PREFIX']; } else { $sub_prefix = ""; }
        $data_addr = array(
            "NAMA" => stripslashes($_POST['NAMA']),
            "PREFIX" => stripslashes($_POST['PREFIX']).".".$sub_prefix,
            "CLASSIFICATION" => stripslashes($_POST['klasifikasi']),
            "CUALIFICATION" => stripslashes($_POST['kualifikasi'])
        );
        $result = $this->mgd->add_data_info($data_addr);
        $this->output($result);
    }

    public function get_info_perusahaan(){
      $result = array();
      $data = $this->mgd->get_info_perusahaan();
      foreach ($data as $arr) {
        $result = array(
          'data' => $arr
        );
      }
      echo json_encode($result);
    }

    public function add_kontak() {
        $result = false;
        if ($this->input->post('api') == 'insert') {
            $data_kontak = array(
                'ID_VENDOR' => $this->session->ID,
                'NAMA' => stripslashes($this->input->post('NAMA')),
                'JABATAN' => stripslashes($this->input->post('JABATAN')),
                'TELP' => stripslashes($this->input->post('TELP')),
                'EXTENTION'=> stripslashes($this->input->post('EXTENTION')),
                'HP' => stripslashes($this->input->post('HP')),
                'EMAIL' => stripslashes($this->input->post('EMAIL')),
                'CREATE_BY' => $this->session->ID,
                'STATUS' => "1"
            );
            if ($this->input->post('KEYS') == 0) {
                $result = $this->mgd->add_data_kontak($data_kontak);
            } else {
                $data_kontak['UPDATE_TIME'] = date('Y-m-d H:i:s');
                $data_kontak['KEYS'] = $this->input->post('KEYS');
                $result = $this->mgd->update_data_kontak($data_kontak);
            }
            $this->output($result);
        } else {
            $this->output("failed");
        }
    }

    public function add_address() {
        $data_addr = ($_POST);
        $data_addr['ID_VENDOR'] = $this->session->ID;
        $data_addr['CREATE_BY'] = $this->session->ID;
        $data_addr['STATUS'] = "1";
        if ($_POST['KEYS'] == "0") {
            $result = $this->mgd->add_data_alamat($data_addr);
        } else {
            $data_addr['UPDATE_TIME'] = date('Y-m-d H:i:s');
            $result = $this->mgd->update_data_alamat($data_addr);
        }
        $this->output($result);
    }

/* ===========================================       Show data table START     ====================================== */
    public function show() {
        $id = $this->session->ID;
        $search = $this->input->post('search');
        $order = $this->input->post('order');

        $key = array(
            'search' => $search['value'],
            'ordCol' => $order[0]['column'],
            'ordDir' => $order[0]['dir'],
            'length' => $this->input->post('length'),
            'start' => $this->input->post('start')
        );
        $data = $this->mgd->show($key, $id);
        $dt = array();
        foreach ($data as $k => $v) {
            $dt[$k]["NO"] = $k + 1;
            $dt[$k]["NAMA"] = $v->NAMA;
            $dt[$k]["JABATAN"] = $v->JABATAN;
            $dt[$k]["TELP"] = $v->TELP;
            $dt[$k]["EXTENTION"] = $v->EXTENTION;
            $dt[$k]["EMAIL"] = $v->EMAIL;
            $dt[$k]["HP"] = $v->HP;
            $dt[$k]["AKSI"] = '<button class="btn btn-sm btn-primary update"id=' . $v->KEYS . '><span class="fa fa-edit"></span></button>'
                    . ' <button class="btn btn-danger btn-sm delete" onclick=delete_kontak(' . $v->KEYS . ',"' . $v->ID_VENDOR . '")><span class="fa fa-trash-o">'
                    . '</span></button>';
        }
        $return = array(
            'data' => $dt,
            'recordsTotal' => count($dt),
            'recordsFiltered' => count($dt)
        );
        $this->output($return);
    }

    public function show_address() {
        $search = $this->input->post('search');
        $order = $this->input->post('order');
        $id = $this->session->ID;
        $key = array(
            'search' => $search['value'],
            'ordCol' => $order[0]['column'],
            'ordDir' => $order[0]['dir'],
            'length' => $this->input->post('length'),
            'start' => $this->input->post('start')
        );

        $data = $this->mgd->show_address($key, $id);
        $dt = array();
        foreach ($data as $k => $v) {
            $dt[$k]["NO"] = $k + 1;
            $dt[$k]["BRANCH_TYPE"] = $v->BRANCH_TYPE;
            $dt[$k]["ADDRESS"] = $v->ADDRESS;
            $dt[$k]["ADDRESS2"] = $v->ADDRESS2;
            $dt[$k]["ADDRESS3"] = $v->ADDRESS3;
            $dt[$k]["ADDRESS4"] = $v->ADDRESS4;
            $dt[$k]["COUNTRY"] = $v->COUNTRY;
            $dt[$k]["PROVINCE"] = $v->name;
            $dt[$k]["CITY"] = $v->CITY;
            $dt[$k]["POSTAL_CODE"] = $v->POSTAL_CODE;
            $dt[$k]["TELP"] = $v->TELP;
            $dt[$k]["FAX"] = $v->FAX;
            $dt[$k]["WEBSITE"] = $v->WEBSITE;
            $dt[$k]["AKSI"] = '<button class="btn btn-sm btn-primary update-alamat" id=' . $v->KEYS . '><span class="fa fa-edit"></span></button>'
                    . '&nbsp<button class="btn btn-danger btn-sm delete" onclick=delete_addr(' . $v->KEYS . ',"' . $v->ID_VENDOR . '")><span class="fa fa-trash-o">'
                    . '</span></button>';
        }
        $return = array(
            'data' => $dt,
            'recordsTotal' => count($dt),
            'recordsFiltered' => count($dt)
        );
        $this->output($return);
    }

/* ===========================================     Get data START     ====================================== */
    public function get_data($id) {
        $result = $this->mgd->get_data($id);
        if ($result)
            return $result;
        else
            return "failed";
    }

    public function get_contact() {
        $result = $this->mgd->get_data_kontak($_POST["ID"], $_POST["KEYS"]);
        if ($result != false)
            $this->output($result);
        else
            return false;
    }

    public function get_addr() {
        $result = $this->mgd->get_data_alamat($_POST["ID"], $_POST["KEYS"]);
        if ($result != false)
            $this->output($result);
        else
            return false;
    }

    public function get_province() {
        $state = $_POST['COUNTRY'];
        $st = $this->mgd->get_state($state);
        $prov = $this->mgd->get_province($st->id);
        foreach ($prov as $k => $v) {
            echo '<option value=' . $v->id . '>' . $v->name . '</option>';
        }
    }

    public function get_city() {
        $id = $_POST['PROVINCE'];
        $st = $this->mgd->get_city($id);
        foreach ($st as $k => $v) {
            echo '<option value=' . $v->name . '>' . $v->name . '</option>';
        }
    }
/* ===========================================      Delete data START     ====================================== */

    public function delete_address() {
        $id = $_POST['ID'];
        $key = $_POST['KEYS'];
        $result = $this->mgd->delete_data_address($key, $id);
        $this->output($result);
    }

    public function delete_contact() {
        $id = $_POST['ID'];
        $key = $_POST['KEYS'];
        $result = $this->mgd->delete_data_contact($key, $id);
        $this->output($result);
    }

    public function get_dt_wparam()
    {
        $id=stripslashes($this->input->post('id'));

        $dt=null;
        $res = $this->mgd->get_dt_wparam($id);

        echo json_encode($res);
        // if($res != false)
        //     $this->output($res[0]->id);
        // else
        //     return null;
    }

    public function add_info_ktp() {
      $ktp_id = $this->input->post("ktp_id");
      $issued_by_ktp = $this->input->post("issued_by_ktp");
      $file_ktp = $this->input->post("file_ktp");
      $nomor_ktp = $this->input->post("nomor_ktp");
      $city = $this->input->post("city");
      $valid_to_ktp = $this->input->post("valid_to_ktp");
      // $file_ktp = $this->input->post("file_ktp");

      $dt_post = array(
        'id_vendor' => $this->session->ID,
        'name' => $issued_by_ktp,
        'nik' => $nomor_ktp,
        'city' => $city,
        'expired_date' => date("Y-m-d", strtotime(stripslashes($valid_to_ktp))),
      );

      $file = true;

      if (!empty($_FILES['file_ktp']['name'])) {
        $upload = $this->doc_upload('file_ktp');
        $dt_files['dt_file'] = $upload;
        if ($dt_files['dt_file']['success'] == true) {
          $dt_post['file_url'] = $dt_files['dt_file']['file_name'];
        } else {
          $file = false;
        }
      }

      if ($file == true) {
        if (empty($ktp_id)) {
          $dt_post['create_date'] = date('Y-m-d H:i:s');
          $dt_post['create_by'] = $this->session->ID;
          $result['success'] = $this->mgd->add_info_ktp($dt_post);
        } else {
          $dt_post['id'] = $ktp_id;
          $dt_post['update_date'] = date('Y-m-d H:i:s');
          $dt_post['update_by'] = $this->session->ID;
          $result['success'] = $this->mgd->upd_info_ktp($dt_post);
        }
      } else {
        $result['success'] = false;
      }

      $result['file'] = $file;
      // echo json_encode($dt_post, JSON_PRETTY_PRINT);
      $this->output($result);
    }

    public function doc_upload($files) {
        $config['upload_path']          = './upload/LEGAL_DATA/KTP';
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

    public function get_file(){
      $val = "";
      $data = $_POST['file'];
      if ($data == "KTP"){
        $dt_ktp = $this->db->select("file_url")->from("m_vendor_ktp")->where("id_vendor", $this->session->ID)->get();
        if ($dt_ktp->num_rows() > 0) {
		      $val = $dt_ktp->row()->file_url;
          $this->output(base_url() . ("upload/LEGAL_DATA/KTP/".$val ));
        }
      }
    }

}
