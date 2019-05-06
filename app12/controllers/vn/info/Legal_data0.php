<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Legal_data extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('vn/info/M_legal_data', 'mld');
        $this->load->model('vn/info/M_general_data', 'mgd');
        $this->load->model('vn/info/M_vn', 'mvn');
        $this->load->model('vn/info/M_all_vendor', 'mav');
    }

    public function index() {
        $cek = $this->mav->cek_session();
        $id = $this->session->ID;
        $vendor = $this->session->ID_VENDOR;
        $data['all'] = null;
        $data['stat'] = null;
        $get_menu = $this->mvn->menu();
        $res = $this->get_data($vendor);
        // ambil data npwp
        $all = $this->mld->get_alldata($id);

        //ambil data legal others
        $all2 = $this->mld->get_legal_others($id);
        if ($all2 != "") {
            foreach ($all2 as $k => $v) {
                $data[$v->CATEGORY][0] = [
                    "NO_DOC" => $v->NO_DOC,
                    "TYPE" => $v->TYPE,
                    "CREATOR" => $v->CREATOR,
                    "VALID_SINCE" => $v->VALID_SINCE,
                    "VALID_UNTIL" => $v->VALID_UNTIL,
                    "FILE_URL" => $v->FILE_URL,
                    "DESCRIPTION" => $v->DESCRIPTION,
                ];
            }
        }
        if ($all != false)
            $data['all'] = $all;
        if ($res != false)
            $data['stat'] = $res;

        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['DESKRIPSI_IND'] = $v->DESCRIPTION_IND;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['DESKRIPSI_ENG'] = $v->DESCRIPTION_ENG;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['ICON'] = $v->ICON;
        }
        $data['menu'] = $dt;
        $this->template->display_vendor('vn/info/V_legal_data', $data);
    }

    /* ===========================================-------- API START------- ====================================== */

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    /* ===========================================       Show data table START     ====================================== */

    public function show() {
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
        $result = $this->mld->shows($key, $id);

        $dt = array();
        foreach ($result as $k => $v) {
            $dt[$k]["NO"] = $k + 1;
            $dt[$k]["NO_AKTA"] = $v->NO_AKTA;
            $dt[$k]["AKTA_DATE"] = $v->AKTA_DATE;
            $dt[$k]["AKTA_TYPE"] = $v->AKTA_TYPE;
            $dt[$k]["NOTARIS"] = $v->NOTARIS;
            $dt[$k]["ADDRESS"] = $v->ADDRESS;
            $dt[$k]["VERIFICATION"] = $v->VERIFICATION;
            $dt[$k]["NEWS"] = $v->NEWS;
            $dt[$k]["AKSI"] = '<button class="btn btn-sm btn-primary update" id=' . $v->KEY_AKTA . '><span class="fa fa-edit"></span></button>'
                    . '&nbsp<button class="btn btn-danger btn-sm delete" onclick=delete_akta(' . $v->KEY_AKTA . ',"' . $v->ID_VENDOR . '")><span class="fa fa-trash-o">'
                    . '</span></button>';
            $dt[$k]['AKTA_FILE'] = '<button onclick="review_akta(\'' . base_url() . 'upload/LEGAL_DATA/AKTA/' . $v->AKTA_FILE . '\')" class="btn btn-sm btn-success"><i class="fa fa-file-o"></i></button>';
            $dt[$k]['VERIF_FILE'] = '<button onclick="review_akta(\'' . base_url() . 'upload/LEGAL_DATA/AKTA/' . $v->VERIFICATION_FILE . '\')" class="btn btn-sm btn-success"><i class="fa fa-file-o"></i></button>';
            $dt[$k]['NEWS_FILE'] = '<button onclick="review_akta(\'' . base_url() . 'upload/LEGAL_DATA/AKTA/' . $v->NEWS_FILE . '\')" class="btn btn-sm btn-success"><i class="fa fa-file-o"></i></button>';
        }
        $res = array(
            'data' => $dt,
            'recordsTotal' => count($dt),
            'recordsFiltered' => count($dt)
        );
        $this->output($res);
    }

    /* ===========================================       Add data START     ====================================== */

    public function add_akta() {
        $res = true;
        $flag = 0;
        if ($_POST["KEYS"] == 0 || ($_POST["KEYS"] != 0 && $_FILES['file_akta2']['name'] != '')) {
            $res = $this->upload_akta($this->session->ID);
            $this->check_response($res);
            $flag = 1;
        }
        $result = false;
        $data_akta = array(
            'ID_VENDOR' => $this->session->ID,
            'NO_AKTA' => stripslashes($this->input->post('no_akta')),
            'AKTA_DATE' => stripslashes($this->input->post('tanggal_akta')),
            'AKTA_TYPE' => stripslashes($this->input->post('jenis_akta')),
            'NOTARIS' => stripslashes($this->input->post('nama_notaris')),
            'ADDRESS' => stripslashes($this->input->post('alamat_notaris')),
            'VERIFICATION' => stripslashes($this->input->post('pengesahan')),
            'NEWS' => stripslashes($this->input->post('berita')),
            'CREATE_BY' => $this->session->ID,
            'STATUS' => "1"
        );
        if ($_POST["KEYS"] == 0) {
            $data_akta = array_merge($data_akta, $res);
            $result = $this->mld->add_data_akta($data_akta);
        } else {
            $data_akta['KEY_AKTA'] = stripslashes($this->input->post('KEYS'));
            $data_akta['UPDATE_BY'] = $this->session->ID;
            $data_akta['UPDATE_TIME'] = date('Y-m-d H:i:s');
            if ($flag == 1) {
                $data_akta = array_merge($data_akta, $res);
                $cek = $this->mld->get_doc($_POST['ID'], $_POST['KEYS'], 'AKTA_FILE,VERIFICATION_FILE,NEWS_FILE', 'm_vendor_akta');
                if ($cek != false)
                    $this->remove_doc_akta($cek);
            }
            $result = $this->mld->update_data_akta($data_akta);
        }
        if ($result === true) {
            $this->output(array("status" => "Sukses", "msg" => "Data Akta Berhasil disimpan"));
        } else if (res === false) {
            $this->output(array("status" => "Error", "msg" => "Data Akta gagal disimpan"));
        }
    }

    public function add_siup() {
        $result = false;
        $open= stripslashes($this->input->post('valid_from_siup'));
        $close= stripslashes($this->input->post('valid_to_siup'));
        $chk=$this->mav->check_date($open,$close);
        if($chk['status'] == "Error")
            $this->output($chk);

        $tmp = $this->cek_uploads("m_vendor_legal_other", "SIUP", "upload/LEGAL_DATA/SIUP", "file_siup", "FILE_URL");
        $flag = $tmp['flag'];
        $res = $tmp['res'];
        $data_siup = array(
            'ID_VENDOR' => $this->session->ID,
            'CREATOR' => stripslashes($this->input->post('created_by_siup')),
            'NO_DOC' => stripslashes($this->input->post('nomor_siup')),
            'TYPE' => stripslashes($this->input->post('tipe_siup')),
            'CATEGORY' => "SIUP",
            'VALID_SINCE' => $open,
            'VALID_UNTIL' => $close,
            'CREATE_BY' => $this->session->ID,
            'STATUS' => "1"
        );
        if ($flag == 1) {
            $data_siup = array_merge($data_siup, $res);
            $result = $this->mld->add_data_file($data_siup, "m_vendor_legal_other", "FILE_URL", "SIUP/");
        } else
            $result = $this->mld->add_data_file($data_siup, "m_vendor_legal_other", "FILE_URL", "SIUP/", true);
        if ($result === true) {
            $this->output(array("status" => "Sukses", "msg" => "Data SIUP Berhasil disimpan"));
        } else if (res === false) {
            $this->output(array("status" => "Error", "msg" => "Data SIUP gagal disimpan"));
        }
    }

    public function add_tdp() {
        $result = false;
        $open= stripslashes($this->input->post('valid_from_tdp'));
        $close= stripslashes($this->input->post('valid_to_tdp'));
        $chk=$this->mav->check_date($open,$close);
        if($chk['status'] == "Error")
            $this->output($chk);

        $tmp = $this->cek_uploads("m_vendor_legal_other", "TDP", "upload/LEGAL_DATA/TDP", "file_tdp", "FILE_URL");
        $flag = $tmp['flag'];
        $res = $tmp['res'];
        $data_tdp = array(
            'ID_VENDOR' => $this->session->ID,
            'CREATOR' => stripslashes($this->input->post('created_by_tdp')),
            'NO_DOC' => stripslashes($this->input->post('nomor_tdp')),
            'CATEGORY' => "TDP",
            'VALID_SINCE' => $open,
            'VALID_UNTIL' => $close,
            'CREATE_BY' => $this->session->ID,
            'STATUS' => "1"
        );
        if ($flag == 1) {
            $data_tdp = array_merge($data_tdp, $res);
            $result = $this->mld->add_data_file($data_tdp, "m_vendor_legal_other", "FILE_URL", "TDP/");
        } else
            $result = $this->mld->add_data_file($data_tdp, "m_vendor_legal_other", "FILE_URL", "TDP/", true);

        if ($result === true) {
            $this->output(array("status" => "Sukses", "msg" => "Data TDP Berhasil disimpan"));
        } else if (res === false) {
            $this->output(array("status" => "Error", "msg" => "Data TDP gagal disimpan"));
        }
    }

    public function add_npwp() {
        $result = false;
        $tmp = $this->cek_uploads("m_vendor_npwp", null, "upload/LEGAL_DATA/NPWP", "file_npwp", "NPWP_FILE");
        $flag = $tmp['flag'];
        $res = $tmp['res'];
        $data_npwp = array(
            'ID_VENDOR' => $this->session->ID,
            'NO_NPWP' => stripslashes($this->input->post('nomor_npwp')),
            'NOTARIS_ADDRESS' => stripslashes($this->input->post('npwp_addr')),
            'NPWP_PROVINCE' => stripslashes($this->input->post('npwp_province')),
            'NPWP_CITY' => stripslashes($this->input->post('npwp_city')),
            'POSTAL_CODE' => stripslashes($this->input->post('postal_code')),
            'CREATE_BY' => $this->session->ID,
            'STATUS' => "1"
        );
        if ($flag == 1) {
            $data_npwp = array_merge($data_npwp, $res);
            $result = $this->mld->add_data_file($data_npwp, "m_vendor_npwp", "NPWP_FILE", "NPWP/");
        } else {
            $result = $this->mld->add_data_file($data_npwp, "m_vendor_npwp", "NPWP_FILE", "NPWP/", true);
        }
        if ($result === true) {
            $this->output(array("status" => "Sukses", "msg" => "Data NPWP Berhasil disimpan"));
        } else if (res === false) {
            $this->output(array("status" => "Error", "msg" => "Data NPWP gagal disimpan"));
        }
    }

    public function add_ebtke() {
        $result = false;
        $open= stripslashes($this->input->post('valid_from_ebtke'));
        $close= stripslashes($this->input->post('valid_to_ebtke'));
        $chk=$this->mav->check_date($open,$close);
        if($chk['status'] == "Error")
            $this->output($chk);

        $tmp = $this->cek_uploads("m_vendor_legal_other", "SKT_EBTKE", "upload/LEGAL_DATA/EBTKE", "file_ebtke", "FILE_URL");
        $flag = $tmp['flag'];
        $res = $tmp['res'];
        $data_ebtke = array(
            'ID_VENDOR' => $this->session->ID,
            'CATEGORY' => "SKT_EBTKE",
            'NO_DOC' => stripslashes($this->input->post('nomor_ebtke')),
            'CREATOR' => stripslashes($this->input->post('issued_by_ebtke')),
            'VALID_SINCE' => $open,
            'VALID_UNTIL' => $close,
            'DESCRIPTION' => stripslashes($this->input->post('bidang_usaha_ebtke')),
            'CREATE_BY' => $this->session->ID,
            'STATUS' => "1"
        );
        if ($flag == 1) {
            $data_ebtke = array_merge($data_ebtke, $res);
            $result = $this->mld->add_data_file($data_ebtke, "m_vendor_legal_other", "FILE_URL", "EBTKE/");
        } else
            $result = $this->mld->add_data_file($data_ebtke, "m_vendor_legal_other", "FILE_URL", "EBTKE/", true);

        if ($result === true) {
            $this->output(array("status" => "Sukses", "msg" => "Data Direktorat Panas Bumi Berhasil disimpan"));
        } else if (res === false) {
            $this->output(array("status" => "Error", "msg" => "Data Direktorat Panas Bumi gagal disimpan"));
        }
    }

    public function add_migas() {
        $result = false;
        $open= stripslashes($this->input->post('valid_from_migas'));
        $close= stripslashes($this->input->post('valid_to_migas'));
        $chk=$this->mav->check_date($open,$close);
        if($chk['status'] == "Error")
            $this->output($chk);

        $tmp = $this->cek_uploads("m_vendor_legal_other", "SKT_MIGAS", "upload/LEGAL_DATA/MIGAS", "file_migas", "FILE_URL");
        $flag = $tmp['flag'];
        $res = $tmp['res'];
        $data_migas = array(
            'ID_VENDOR' => $this->session->ID,
            'CATEGORY' => "SKT_MIGAS",
            'NO_DOC' => stripslashes($this->input->post('no_migas')),
            'CREATOR' => stripslashes($this->input->post('issued_by_migas')),
            'VALID_SINCE' => $open,
            'VALID_UNTIL' => $close,
            'DESCRIPTION' => stripslashes($this->input->post('bidang_usaha_migas')),
            'CREATE_BY' => $this->session->ID,
            'STATUS' => "1"
        );
        if ($flag == 1) {
            $data_migas = array_merge($data_migas, $res);
            $result = $this->mld->add_data_file($data_migas, "m_vendor_legal_other", "FILE_URL", "MIGAS/");
        } else
            $result = $this->mld->add_data_file($data_migas, "m_vendor_legal_other", "FILE_URL", "MIGAS/", true);
        if ($result === true) {
            $this->output(array("status" => "Sukses", "msg" => "Data SKT Migas Berhasil disimpan"));
        } else if (res === false) {
            $this->output(array("status" => "Error", "msg" => "Data SKT Migas gagal disimpan"));
        }
    }

    public function add_sppkp() {
        $result = false;
        $open= stripslashes($this->input->post('valid_from_sppkp'));
        $close= stripslashes($this->input->post('valid_to_sppkp'));
        // $chk=$this->mav->check_date($open,$close);
        // if($chk['status'] == "Error")
        // $this->output($chk);

        $tmp = $this->cek_uploads("m_vendor_legal_other", "SPPKP", "upload/LEGAL_DATA/SPPKP", "file_sppkp", "FILE_URL");
        $flag = $tmp['flag'];
        $res = $tmp['res'];
        $data_ebtke = array(
            'ID_VENDOR' => $this->session->ID,
            'CATEGORY' => "SPPKP",
            'NO_DOC' => stripslashes($this->input->post('nomor_sppkp')),
            'CREATOR' => stripslashes($this->input->post('issued_by_sppkp')),
            'VALID_SINCE' => $open,
            'VALID_UNTIL' => $close,
            'DESCRIPTION' => stripslashes($this->input->post('bidang_usaha_sppkp')),
            'CREATE_BY' => $this->session->ID,
            'STATUS' => "1"
        );
        if ($flag == 1) {
            $data_ebtke = array_merge($data_ebtke, $res);
            $result = $this->mld->add_data_file($data_ebtke, "m_vendor_legal_other", "FILE_URL", "SPPKP/");
        } else
            $result = $this->mld->add_data_file($data_ebtke, "m_vendor_legal_other", "FILE_URL", "SPPKP/", true);

        if ($result === true) {
            $this->output(array("status" => "Sukses", "msg" => "Data SPPKP Berhasil disimpan"));
        } else if (res === false) {
            $this->output(array("status" => "Error", "msg" => "Data SPPKP gagal disimpan"));
        }
    }

    public function add_pajak() {
        $open= stripslashes($this->input->post('valid_from_pajak'));
        $close= stripslashes($this->input->post('valid_to_pajak'));
        // $chk=$this->mav->check_date($open,$close);
        // if($chk['status'] == "Error")
        //     $this->output($chk);

        $result = false;
        $tmp = $this->cek_uploads("m_vendor_legal_other", "SKT_PAJAK", "upload/LEGAL_DATA/PAJAK", "file_pajak", "FILE_URL");
        $flag = $tmp['flag'];
        $res = $tmp['res'];
        $data_pajak = array(
            'ID_VENDOR' => $this->session->ID,
            'CATEGORY' => "SKT_PAJAK",
            'NO_DOC' => stripslashes($this->input->post('nomor_pajak')),
            'CREATOR' => stripslashes($this->input->post('issued_by_pajak')),
            'VALID_SINCE' => $open,
            'VALID_UNTIL' => $close,
            'DESCRIPTION' => stripslashes($this->input->post('bidang_usaha_pajak')),
            'CREATE_BY' => $this->session->ID,
            'STATUS' => "1"
        );
        if ($flag == 1) {
            $data_pajak = array_merge($data_pajak, $res);
            $result = $this->mld->add_data_file($data_pajak, "m_vendor_legal_other", "FILE_URL", "PAJAK/");
        } else
            $result = $this->mld->add_data_file($data_pajak, "m_vendor_legal_other", "FILE_URL", "PAJAK/", true);

        if ($result === true) {
            $this->output(array("status" => "Sukses", "msg" => "Data SKT Pajak Berhasil disimpan"));
        } else if (res === false) {
            $this->output(array("status" => "Error", "msg" => "Data SKT Pajak gagal disimpan"));
        }
    }

    /* ===========================================       upload data START     ====================================== */

    public function upload_akta($id) {
        $NewImageName = '';
        $data = $_FILES;
        $Destination = 'upload/LEGAL_DATA/AKTA';
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
            if ($k == "file_akta" || $k == "file_akta2") {
                $NewImageName = 'AKTA_' . $id . '_' . Date("Ymd_His") . $ImageExt;
                $ret['AKTA_FILE'] = $NewImageName;
            } else if ($k == "file_pengesahan" || $k == "file_pengesahan2") {
                $NewImageName = 'VERIFICATION_' . $id . '_' . Date("Ymd_His") . $ImageExt;
                $ret['VERIFICATION_FILE'] = $NewImageName;
            } else if ($k == "file_berita" || $k == "file_berita2") {
                $NewImageName = 'NEWS_' . $id . '_' . Date("Ymd_His") . $ImageExt;
                $ret['NEWS_FILE'] = $NewImageName;
            }
            if (move_uploaded_file($_FILES[$k]['tmp_name'], "$Destination/$NewImageName"))
                $counter++;
        }

        if ($counter == 3)
            return $ret;
        else
            return false;
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

    public function remove_doc_akta($data) {
        $count = 0;
        foreach ($data as $k => $v) {
            if ($count == 0) {
                unlink("upload/LEGAL_DATA/AKTA/" . $v->AKTA_FILE);
                $count++;
            }
            if ($count == 1) {
                unlink("upload/LEGAL_DATA/AKTA/" . $v->VERIFICATION_FILE);
                $count++;
            }
            if ($count == 2) {
                unlink("upload/LEGAL_DATA/AKTA/" . $v->NEWS_FILE);
                $count++;
            }
        }
    }

    public function cek_uploads($tbl, $catg, $dest, $file_n, $file_db) {
        $flag = 0;
        $res = 0;
        $key = $this->mld->cek_data($this->session->ID, $tbl, $catg);
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
            $this->output(array('msg' => "Ukuran File Maksimal 2 MB", 'status' => 'Error'));
    }

    /* ===========================================       get data START     ====================================== */

    public function get_akta() {
        $id = $this->session->ID;
        $key = $_POST['KEYS'];
        $result = $this->mld->get_data_akta($key, $id);
        $this->output($result);
    }

    public function get_data($id) {
        $result = $this->mgd->get_data($id);
        if ($result)
            return $result;
        else
            return "failed";
    }

    public function get_file() {
        $val = "";
        $data=$_POST['file'];
        if ($_POST['file'] != "NPWP") {
            $res = $this->mld->get_file($_POST['file'], "m_vendor_legal_other");
            $val = $res[0]->FILE_URL;
        } else {
            $res = $this->mld->get_file($_POST['file'], "m_vendor_npwp");
            $val = $res[0]->NPWP_FILE;
        }
        if ($data == "SKT_EBTKE")
            $this->output(base_url() . ("upload/LEGAL_DATA/EBTKE/".$val));
        else if ($data === "SKT_MIGAS")
            $this->output(base_url() . ("upload/LEGAL_DATA/MIGAS/".$val));
        else if ($data === "AKTA")
            $this->output(base_url() . ("upload/LEGAL_DATA/AKTA/".$val));
        else if ($data === "SIUP")
            $this->output(base_url() . ("upload/LEGAL_DATA/SIUP/".$val));
        else if ($data === "TDP")
            $this->output(base_url() . ("upload/LEGAL_DATA/TDP/".$val));
        else if ($data === "NPWP")
            $this->output(base_url() . ("upload/LEGAL_DATA/NPWP/".$val));
        else if ($data === "SPPKP")
            $this->output(base_url() . ("upload/LEGAL_DATA/SPPKP/".$val));
        else if ($data === "PAJAK")
            $this->output(base_url() . ("upload/LEGAL_DATA/PAJAK/".$val));
    }

    /* ===========================================       delete data START     ====================================== */

    public function delete_akta() {
        $id = $_POST['ID'];
        $key = $_POST['KEYS'];
        $cek = $this->mld->get_doc($_POST['ID'], $_POST['KEYS'], 'AKTA_FILE,VERIFICATION_FILE,NEWS_FILE', 'm_vendor_akta', null);
        if ($cek != false)
            $this->remove_doc_akta($cek);
        $result = $this->mld->delete_data_akta($key, $id);
        $this->output($result);
    }


    public function show_data_pajak() {
      $data = $this->mld->show_data_pajak();
      $dt = array();
      foreach ($data as $k => $v) {
          $dt[$k][0] = $k + 1;
          $dt[$k][1] = stripslashes($v->NO_NPWP);
          $dt[$k][2] = stripslashes($v->DOC_CATEGORY);
          $dt[$k][3] = stripslashes($v->NPWP_FILE);
          $dt[$k][4] = "<a class='btn btn-danger btn-sm' title='Update' href='javascript:void(0)' onclick='delete_data_pajak(" . $v->ID_VENDOR. ", " . $v->NO_NPWP. ")'><i class='fa fa-trash-o'></i></a>";
      }
      echo json_encode($dt);
    }

    public function delete_pajak_doc(){
      $id_vendor = $this->input->post("id_vendor");
      $no_doc = $this->input->post("no_doc");

      $data = $this->mld->delete_pajak_doc($id_vendor, $no_doc);

      $result = array();
      if ($data == true) {
        $result['success'] = true;
      } else {
        $result['success'] = false;
      }
      echo json_encode($result);
    }

}
