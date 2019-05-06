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
        $get_sdkp = $this->mld->get_sdkp();
        $data['all'] = null;
        $data['stat'] = null;
        $data['SDKP'] = $get_sdkp;
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

    public function tax_data() {
        $cek = $this->mav->cek_session();
        $id = $this->session->ID;
        $vendor = $this->session->ID_VENDOR;
        $get_sdkp = $this->mld->get_sdkp();
        $data['all'] = null;
        $data['stat'] = null;
        $data['SDKP'] = $get_sdkp;
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
        $this->template->display_vendor('vn/info/V_tax_data', $data);
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
          if ($v->AKTA_FILE != '') {
            $akta_file = '<button onclick="review_akta(\'' . base_url() . 'upload/LEGAL_DATA/AKTA/' . $v->AKTA_FILE . '\')" class="btn btn-sm btn-success"><i class="fa fa-file-o"></i></button>';
          } else {
            $akta_file = '-';
          }

          if ($v->VERIFICATION_FILE != '') {
            $verif_file = '<button onclick="review_akta(\'' . base_url() . 'upload/LEGAL_DATA/AKTA/' . $v->VERIFICATION_FILE . '\')" class="btn btn-sm btn-success"><i class="fa fa-file-o"></i></button>';
          } else {
            $verif_file = '-';
          }

          if ($v->NEWS_FILE != '') {
            $news_file = '<button onclick="review_akta(\'' . base_url() . 'upload/LEGAL_DATA/AKTA/' . $v->NEWS_FILE . '\')" class="btn btn-sm btn-success"><i class="fa fa-file-o"></i></button>';
          } else {
            $news_file = '-';
          }

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
            $dt[$k]['AKTA_FILE'] = $akta_file;
            $dt[$k]['VERIF_FILE'] = $verif_file;
            $dt[$k]['NEWS_FILE'] = $news_file;
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
        if ($_POST["KEYS"] == 0 && $_FILES['file_akta']['size'] != 0) {
            $res = $this->upload_akta($this->session->ID, $_POST["KEYS"]);
            $this->check_response($res);
        } else if ($_POST["KEYS"] != 0) {
            $res = $this->upload_akta($this->session->ID, $_POST["KEYS"]);
            if ($res != false) {
                $this->check_response($res);
                $flag = 1;
            }
        }
        $result = false;
        if (!empty($this->input->post('pengesahan'))) {
          $verif_date = date("Y-m-d", strtotime(stripslashes($this->input->post('pengesahan'))));
        } else {
          $verif_date = '0000-00-00';
        }

        if (!empty($this->input->post('berita'))) {
          $news_date = date("Y-m-d", strtotime(stripslashes($this->input->post('berita'))));
        } else {
          $news_date = '0000-00-00';
        }

        $data_akta = array(
            'ID_VENDOR' => $this->session->ID,
            'NO_AKTA' => stripslashes($this->input->post('no_akta')),
            'AKTA_DATE' => date("Y-m-d", strtotime(stripslashes($this->input->post('tanggal_akta')))),
            'AKTA_TYPE' => stripslashes($this->input->post('jenis_akta')),
            'NOTARIS' => stripslashes($this->input->post('nama_notaris')),
            'ADDRESS' => stripslashes($this->input->post('alamat_notaris')),
            'VERIFICATION' => $verif_date,
            'NEWS' => $news_date,
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
                $cek = $this->mld->get_doc($this->session->ID, $_POST['KEYS'], 'AKTA_FILE,VERIFICATION_FILE,NEWS_FILE', 'm_vendor_akta');
                if ($cek != false)
                    $this->remove_doc_akta($cek[0], $res);
            }
            $result = $this->mld->update_data_akta($data_akta);
        }
        if ($result === true) {
            $this->output(array("status" => "Sukses", "msg" => "Data Akta Successfuly Saved"));
        } else if ($res === false) {
            $this->output(array("status" => "Error", "msg" => "Data Akta Failed"));
        }
    }

    public function add_siup() {
        $result = false;
        // echopre($_POST);
        // echopre($_FILES);
        // exit;
        $cek_data=$this->mld->get_data_siup();
        $sel=stripslashes($this->input->post('pilih_izin'));
        $open= date("Y-m-d", strtotime(stripslashes($this->input->post('valid_from_siup'))));
        $close= date("Y-m-d", strtotime(stripslashes($this->input->post('valid_to_siup'))));
        $data_siup = array(
            'ID_VENDOR' => $this->session->ID,
            'CREATOR' => stripslashes($this->input->post('created_by_siup')),
            'NO_DOC' => stripslashes($this->input->post('nomor_siup')),
            'CREATE_BY' => $this->session->ID,
            'STATUS' => "1"
        );
        $pil="SIUP";
        $fl=0;
        if($sel == 2)
        {
            if($cek_data != false)
            {
                foreach($cek_data as $k => $v)
                {
                    if($v->CATEGORY == 'SIUP')
                        $fl=1;
                }
            }
            $pil="BKPM";
            $data_siup['CATEGORY'] = "BKPM";
            $tmp = $this->cek_uploads("m_vendor_legal_other", "BKPM", "upload/LEGAL_DATA/BKPM", "file_siup", "FILE_URL");
        }
        else
        {
            if($cek_data != false)
            {
                foreach($cek_data as $k => $v)
                {
                    if($v->CATEGORY == 'BKPM')
                        $fl=1;
                }
            }
            $chk=$this->mav->check_date($open,$close);
            if($chk['status'] == "Error")
                $this->output($chk);
            $data_siup['VALID_SINCE'] = $open;
            $data_siup['VALID_UNTIL'] = $close;
            $data_siup['TYPE'] = stripslashes($this->input->post('tipe_siup'));
            $data_siup['CATEGORY'] = "SIUP";
            $tmp = $this->cek_uploads("m_vendor_legal_other", "SIUP", "upload/LEGAL_DATA/SIUP", "file_siup", "FILE_URL");
        }

        $flag = $tmp['flag'];
        $res = $tmp['res'];

        if($fl == 1)
        {
            $hsl=$this->mld->delete_dt($pil);
        }
        if ($flag == 1) {
            $data_siup = array_merge($data_siup, $res);
            $result = $this->mld->add_data_file($data_siup, "m_vendor_legal_other", "FILE_URL", $pil.'/');
        } else
            $result = $this->mld->add_data_file($data_siup, "m_vendor_legal_other", "FILE_URL",$pil.'/', true);
        if ($result === true) {
            $this->output(array("status" => "Sukses", "msg" => "Data ".$pil." Successfuly Saved"));
        } else if (res === false) {
            $this->output(array("status" => "Error", "msg" => "Data ".$pil." Failed"));
        }
    }

    public function add_tdp() {
        $result = false;
        $open= date("Y-m-d", strtotime(stripslashes($this->input->post('valid_from_tdp'))));
        $close= date("Y-m-d", strtotime(stripslashes($this->input->post('valid_to_tdp'))));
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
            $this->output(array("status" => "Sukses", "msg" => "Data TDP Successfuly Saved"));
        } else if (res === false) {
            $this->output(array("status" => "Error", "msg" => "Data TDP Failed"));
        }
    }

    public function add_npwp() {
        $cek_data = $this->db->query("select NO_NPWP FROM m_vendor_npwp WHERE NO_NPWP = '".stripslashes($this->input->post('nomor_npwp'))."' ");
        if ($cek_data->num_rows() > 0) {
          $this->output(array("status" => "Exist", "msg" => "Data NPWP already exist"));
        } else {
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
            $this->output(array("status" => "Sukses", "msg" => "Data NPWP Successfuly Saved"));
          } else if (res === false) {
            $this->output(array("status" => "Error", "msg" => "Data NPWP Failed"));
          }
        }
    }

    public function add_ebtke() {
        $result = false;
        $open= date("Y-m-d", strtotime(stripslashes($this->input->post('valid_from_ebtke'))));
        $close= date("Y-m-d", strtotime(stripslashes($this->input->post('valid_to_ebtke'))));
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
            $this->output(array("status" => "Sukses", "msg" => "Data Direktorat Panas Bumi Successfuly Saved"));
        } else if (res === false) {
            $this->output(array("status" => "Error", "msg" => "Data Direktorat Panas Bumi Failed"));
        }
    }

    public function add_migas() {
        $result = false;
        $open= date("Y-m-d", strtotime(stripslashes($this->input->post('valid_from_migas'))));
        $close= date("Y-m-d", strtotime(stripslashes($this->input->post('valid_to_migas'))));
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
            $this->output(array("status" => "Sukses", "msg" => "Data Oil and Gas Certificate Successfuly Save"));
        } else if (res === false) {
            $this->output(array("status" => "Error", "msg" => "Data Oil and Gas Certificate Failed"));
        }
    }

    public function add_sppkp() {
        $result = false;
        $open= date("Y-m-d", strtotime(stripslashes($this->input->post('valid_from_sppkp'))));
        $close= date("Y-m-d", strtotime(stripslashes($this->input->post('valid_to_sppkp'))));
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
            $this->output(array("status" => "Sukses", "msg" => "Data SPPKP Successfuly Saved"));
        } else if (res === false) {
            $this->output(array("status" => "Error", "msg" => "Data SPPKP Failed"));
        }
    }

    public function add_pajak() {
        $open= date("Y-m-d", strtotime(stripslashes($this->input->post('valid_from_pajak'))));
        $close= date("Y-m-d", strtotime(stripslashes($this->input->post('valid_to_pajak'))));
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
            'VALID_SINCE' => date("Y-m-d", strtotime(stripslashes($this->input->post('issued_by_pajak')))),
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
            $this->output(array("status" => "Sukses", "msg" => "Data SKT Pajak Successfuly Saved"));
        } else if (res === false) {
            $this->output(array("status" => "Error", "msg" => "Data SKT Pajak Failed"));
        }
    }

    /* ===========================================       upload data START     ====================================== */

    public function upload_akta($id, $key = 0) {
        $NewImageName = '';
        $data = $_FILES;
        $Destination = 'upload/LEGAL_DATA/AKTA';
        $counter = 3;
        $ret = array();
        $dump = array();
        foreach ($data as $k => $v) {
            if ($_FILES[$k]['error'] == 4)
                if ((strcmp($k, 'file_akta') == 0 || strcmp($k, 'file_akta2') == 0) && $key == 0) {
                    return "fnf";
                } else {
                    continue;
                }
            $ImageExt = substr($v['name'], strrpos($v['name'], '.'));
            if ($ImageExt != ".pdf") {
                return "type";
            }
            if ($_FILES[$k]['size'] > 15000000) {
                return "size";
            }
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
            $dump[$k] = "$Destination/$NewImageName";
        }

        foreach ($dump as $k => $v) {
            if (!move_uploaded_file($_FILES[$k]['tmp_name'], $dump[$k]))
                $counter--;
        }

        if ($counter == 3) {
            return $ret;
        } else {
            foreach ($dump as $value) {
                if (file_exists($value))
                    unlink($value);
            }
            return false;
        }
    }

    public function uploads($id, $Destination, $data_file, $db_name) {
        $NewImageName = '';
        $data = $_FILES;
        $ret = array();
        $counter = 0;
        foreach ($data as $k => $v) {
            $ImageExt = substr($v['name'], strrpos($v['name'], '.'));
            if ($ImageExt != ".pdf") {
                return "type";
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

    public function remove_doc_akta($data, $old) {
        if (strcmp($data->AKTA_FILE, '') != 0 && file_exists("upload/LEGAL_DATA/AKTA/" . $data->AKTA_FILE) && array_key_exists('AKTA_FILE', $old)) {
            unlink("upload/LEGAL_DATA/AKTA/" . $data->AKTA_FILE);
        }
        if (strcmp($data->VERIFICATION_FILE, '') != 0 && file_exists("upload/LEGAL_DATA/AKTA/" . $data->VERIFICATION_FILE) && array_key_exists('VERIFICATION_FILE', $old)) {
            unlink("upload/LEGAL_DATA/AKTA/" . $data->VERIFICATION_FILE);
        }
        if (strcmp($data->NEWS_FILE, '') != 0 && file_exists("upload/LEGAL_DATA/AKTA/" . $data->NEWS_FILE) && array_key_exists('NEWS_FILE', $old)) {
            unlink("upload/LEGAL_DATA/AKTA/" . $data->NEWS_FILE);
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
            $this->output(array('msg' => "Can't upload File", 'status' => 'Error'));
        else if ($res == "fnf")
            $this->output(array('msg' => "Empty data uploaded", 'status' => 'Error'));
        else if ($res == "type")
            $this->output(array('msg' => "Only PDF file allowed", 'status' => 'Error'));
        else if ($res == "size")
            $this->output(array('msg' => "File size Max 15 MB", 'status' => 'Error'));
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
        // echopre($res);
        if ($data == "SKT_EBTKE")
            $this->output(base_url() . ("upload/LEGAL_DATA/EBTKE/".$val));
        else if ($data === "SKT_MIGAS")
            $this->output(base_url() . ("upload/LEGAL_DATA/MIGAS/".$val));
        else if ($data === "AKTA")
            $this->output(base_url() . ("upload/LEGAL_DATA/AKTA/".$val));
        else if ($data === "SIUP")
            $this->output(base_url() . ("upload/LEGAL_DATA/SIUP/".$val));
        else if ($data === "BKPM")
            $this->output(base_url() . ("upload/LEGAL_DATA/BKPM/".$val));
        else if ($data === "TDP")
            $this->output(base_url() . ("upload/LEGAL_DATA/TDP/".$val));
        else if ($data === "NPWP")
            $this->output(base_url() . ("upload/LEGAL_DATA/NPWP/".$val));
        else if ($data === "SPPKP")
            $this->output(base_url() . ("upload/LEGAL_DATA/SPPKP/".$val));
        else if ($data === "PAJAK")
            $this->output(base_url() . ("upload/LEGAL_DATA/PAJAK/".$val));
        else if ($data === "SDKP")
            $this->output(base_url() . ("upload/LEGAL_DATA/SDKP/".$val));
        else if ($data === "BPJS")
            $this->output(base_url() . ("upload/LEGAL_DATA/BPJS/".$val));
        else if ($data === "BPJSTK")
            $this->output(base_url() . ("upload/LEGAL_DATA/BPJSTK/".$val));
    }

    /* ===========================================       delete data START     ====================================== */

    public function delete_akta() {
        $id = $_POST['ID'];
        $key = $_POST['KEYS'];
        $cek = $this->mld->get_doc($_POST['ID'], $_POST['KEYS'], 'AKTA_FILE,VERIFICATION_FILE,NEWS_FILE', 'm_vendor_akta', null);
        if ($cek != false)
            $this->remove_doc_akta($cek[0], array('AKTA_FILE' => '', 'VERIFICATION_FILE' => '', 'NEWS_FILE' => ''));
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
          $dt[$k][4] = "<a class='btn btn-primary btn-sm' title='Update' href='javascript:void(0)' onclick='edit_docType(" . $v->ID_VENDOR. ", \"".$v->DOC_CATEGORY."\" )'><i class='fa fa-edit'></i></a> <a class='btn btn-danger btn-sm' title='Delete' href='javascript:void(0)' onclick='delete_data_pajak(" . $v->ID_VENDOR. ", " . $v->NO_NPWP. ")'><i class='fa fa-trash-o'></i></a>";
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

    public function add_sdkp() {
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
        'CREATOR' => $issued_by_doc,
        'CATEGORY' => $doc_type,
        'NO_DOC' => $nomor_doc,
        'STATUS' => '1',
        'VALID_SINCE' => date("Y-m-d", strtotime(stripslashes($issued_date_doc))),
        'VALID_UNTIL' => date("Y-m-d", strtotime(stripslashes($valid_to_doc))),
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
          $result = $this->mld->add_sdkp($dt_post);
        } else {
          $dt_post['ID'] = $doc_id;
          $dt_post['UPDATE_TIME'] = date('Y-m-d H:i:s');
          $dt_post['UPDATE_BY'] = $this->session->ID;
          $result = $this->mld->upd_sdkp($dt_post);
        }
      } else {
        $result = false;
      }
      if ($result === true) {
          $this->output(array("status" => "Sukses", "msg" => "Data SKDP Successfuly Saved"));
      } else if ($result === false) {
          $this->output(array("status" => "Error", "msg" => "Data SKDP Failed"));
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
