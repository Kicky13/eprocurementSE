<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Financial_bank_data extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('exchange_rate_helper');
        $this->load->library('form_validation');
        $this->load->model('vn/info/M_financial_bank', 'mfb');
        $this->load->model('vn/info/M_vn', 'mvn');
        $this->load->model('vn/info/M_all_vendor', 'mav');
        $this->load->model('vn/info/M_Certification_experiece', 'mce');
        $this->load->database();

    }

    public function index() {
        $cek = $this->mav->cek_session();
        $crn = $this->mfb->get_currency();
        $lpn =$this->mfb->get_report();
        $data['crn']=$crn;
        $data['lpn']=$lpn;
        $get_menu = $this->mvn->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['DESKRIPSI_IND'] = $v->DESCRIPTION_IND;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['DESKRIPSI_ENG'] = $v->DESCRIPTION_ENG;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['ICON'] = $v->ICON;
        }
        $data['currency'] = $this->mce->get_currency();
        $data['menu'] = $dt;
        $this->template->display_vendor('vn/info/V_financial_bank', $data);
    }
/*===========================================-------- API START------- ======================================*/
    public function change_vendor_bank_account()
    {
        $data = array(
            'NAMA_BANK' => $_POST['tahun_laporan'],
            'CABANG' => $_POST['jenis_laporan'],
            'ALAMAT' => $_POST['valuta'],
            'NOREK' => stripslashes($_POST['nilai_aset']),
            'ATAS_NAMA' => strtoupper(stripslashes($_POST['hutang'])),
            'CURRENCY' => $_POST['pend_kotor'],
            //'FILE_URL' => strtoupper(stripslashes($_POST['file_ebtke'])),
            'UPDATE_BY' => 1,
            'UPDATE_TIME' => date('Y-m-d H:i:s')
        );
        if ($_POST['id'] == null) {//add data
            $data['CREATE_BY'] = 1;
            $cek = $this->mfb->show_vendor_bank_account(array("NOREK" => strtoupper(stripslashes($_POST['nilai_aset']))));
            if (count($cek) == 0) {//cek ketersediaan data
                $q = $this->mfb->add_vendor_bank_account($data);
            } else {
                echo "Nomor Rekening Telah Digunakan";
                exit;
            }
        } else {//update data
            $q = $this->mfb->update_vendor_bank_account($this->session->ID, $data);
        }

        //CEK QUERY BERHASIL DIJALANKAN
        if ($q == 1) {
            echo "sukses";
        } else {
            echo "Gagal Menambah Data!";
        }
    }

    public function uploads($id, $Destination, $data_file, $db_name)
    {
        $NewImageName = '';
        $data = $_FILES;
        $ret = array();
        $counter = 0;
        foreach ($data as $k => $v) {
            $ImageExt = substr($v['name'], strrpos($v['name'], '.'));
            if ($ImageExt != ".pdf") {
                return "failed";
            }
            if ($_FILES[$k]['size'] > 20000000)
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

    public function remove_doc($data,$dest,$pil=null)
    {
        foreach ($data as $k => $v) {
            if($pil == null)
                unlink($dest.$v->FILE_URL);
            else
                unlink($dest.$data['FILE_URL']);
        }
    }

    public function output($return = array())
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }
/*================================================    Cek Data    =========================================*/
    public function cek_uploads($tbl,$catg,$dest,$file_n,$file_db)
    {
        $flag=0;
        $res=0;
        $key = $this->mfb->cek_data($this->session->ID,$tbl,$catg);
        if ($key == false || ($_FILES[$file_n]['name'] != '')) {
            $res = $this->uploads($this->session->ID,$dest, $file_n,$file_db);
            $this->check_response($res);
            $flag=1;
        }
        return array("flag"=>$flag,"res"=>$res);
    }

    public function check_response($res)
    {
        if ($res == false)
            $this->output(array('msg' => "Gagal upload file", 'status' => 'Error'));
        else if ($res == "failed")
            $this->output(array('msg' => "Hanya file pdf yang diijinkan", 'status' => 'Error'));
        else if ($res == "size")
            $this->output(array('msg' => "Maksimal file 15MB", 'status' => 'Error'));
    }
/*================================================    Add Data     ========================================*/
    public function add_data_bank()
    {
        $res = true;
        $flag = 0;
        $key=0;

        if(isset($_POST['keys_update']))
            $key=$_POST['keys_update'];

        if ($key == 0 || ($key != 0 && $_FILES['file_bank']['name'] != ''))
        {
            $res = $this->uploads($this->session->ID,"upload/FINANCIAL_BANK/NERACA","file_bank","FILE_URL");
            $this->check_response($res);
            $flag = 1;
        }

        $data = array
        (
            'ID_VENDOR' => $this->session->ID,
            'YEAR' => stripslashes($_POST['tahun_laporan']),
            'TYPE' => stripslashes($_POST['jenis_laporan']),
            'CURRENCY' => stripslashes($_POST['valuta']),
            'ASSET_VALUE' => stripslashes($_POST['nilai_aset']),
            'DEBT' => strtoupper(stripslashes($_POST['hutang'])),
            'BRUTO' => stripslashes($_POST['pend_kotor']),
            'NETTO' => stripslashes($_POST['laba_bersih']),
            'STATUS' => "1"
        );

        if ($key == 0)
        {
            $dt_cek=array("TYPE" => strtoupper(stripslashes($_POST['jenis_laporan'])), "YEAR" => stripslashes($_POST['tahun_laporan']), );
            $cek = $this->mfb->check_financial_bank_data($dt_cek);

            // echo json_encode($cek);
            if (count($cek) == 0)
            {
                $data = array_merge($data, $res);
                $data['CREATE_BY'] = $this->session->ID;
                $res = $this->mfb->add_financial_bank_data($data);
            }
            else
            {
                if($flag==1)
                    $this->remove_doc($res,"upload/FINANCIAL_BANK/NERACA/",true);
                $this->output(array("msg"=>"Tipe laporan sudah ada","status"=>"Error"));
            }
        }
        else
        {
            $data['UPDATE_BY'] = $this->session->ID;
            $data['UPDATE_TIME']= date('Y-m-d H:i:s');
            if ($flag == 1) {
                $data = array_merge($data, $res);
                $cek = $this->mfb->get_doc($this->session->ID, $key, 'FILE_URL', 'm_vendor_balance_sheet');
                if ($cek != false)
                    $this->remove_doc($cek,"upload/FINANCIAL_BANK/NERACA/");
            }
            $res = $this->mfb->update_financial_bank_data($this->session->ID, $key, $data);
        }
        // if($res==false)
        //     $this->output(array("msg"=>"Oops, terjadi kesalahan","status"=>"Error"));
        // else
        //     $this->output(array("msg"=>"Data telah tersimpan","status"=>"success"));


    }

    public function add_data_account()
    {
        $res = true;
        $flag = 0;
        $key=0;

        if(isset($_POST['update_keys1']))
            $key=$_POST['update_keys1'];

        if ($key == 0 || ($key != 0 && $_FILES['file_scan']['name'] != ''))
        {
            $res = $this->uploads($this->session->ID,"upload/FINANCIAL_BANK/BANK","file_scan","FILE_URL");
            $this->check_response($res);
            $flag = 1;
        }

        $data = array
        (
            'ID_VENDOR' => $this->session->ID,
            'BANK_NAME' => stripslashes($_POST['bank_name']),
            'BRANCH' => stripslashes($_POST['address']),
            'ADDRESS' => stripslashes($_POST['branch']),
            'NO_REC' => stripslashes($_POST['acc_num']),
            'NAME' => strtoupper(stripslashes($_POST['name'])),
            'CURRENCY' => stripslashes($_POST['currency']),
            'STATUS' => "1"
        );

        if ($key == 0)
        {
                $data = array_merge($data, $res);
                $data['CREATE_BY'] = $this->session->ID;
                $res = $this->mfb->add_data_account($data);
        }
        else
        {
            $data['UPDATE_BY'] = $this->session->ID;
            $data['UPDATE_TIME']= date('Y-m-d H:i:s');
            if ($flag == 1) {
                $data = array_merge($data, $res);
                $cek = $this->mfb->get_doc($this->session->ID, $key, 'FILE_URL', 'm_vendor_bank_account');
                if ($cek != false)
                    $this->remove_doc($cek,"upload/FINANCIAL_BANK/BANK/");
            }
            $res = $this->mfb->update_data_account($this->session->ID, $key, $data);
        }
        if($res==false)
            $this->output(array("msg"=>"Oops, Terjadi kesalahan","status"=>"Error"));
        else
            $this->output(array("msg"=>"Data telah tersimpan","status"=>"success"));
    }
/*============================================       Get Data         =======================================*/

    public function get_vendor_bank_account($id)
    {
        echo json_encode($this->mfb->show_vendor_bank_account(array("ID" => $id)));
    }

    public function get_financial_bank_data($id)
    {
        echo json_encode($this->mfb->show_financial_bank_data(array("ID" => $id)));
    }

    public function show_financial_bank_data()
    {
        $data = $this->mfb->show_bank_data();
        $dt = array();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->YEAR);
            $dt[$k][2] = stripslashes($v->TYPE);
            $dt[$k][3] = stripslashes($v->CURRENCY);
            $dt[$k][4] = numIndo($v->ASSET_VALUE);
            $dt[$k][5] = numIndo($v->DEBT);
            $dt[$k][6] = numIndo($v->BRUTO);
            $dt[$k][7] = numIndo($v->NETTO);
            $dt[$k][8] = stripslashes($v->FILE_URL);
            $dt[$k][8] = '<button onclick="review_akta(\'' . base_url() . 'upload/FINANCIAL_BANK/NERACA/' . $v->FILE_URL . '\')" class="btn btn-sm btn-success"><i class="fa fa-file-o"></i></button>';
            $dt[$k][] = '<button class="btn btn-sm btn-primary update-finance" id=' . $v->KEYS . '><span class="fa fa-edit"></span></button>'
            . '&nbsp<button class="btn btn-danger btn-sm delete" onclick=delete_bank(' . $v->KEYS .')><span class="fa fa-trash-o">'
            . '</span></button>';
        }
        echo json_encode($dt);
    }

    public function show_vendor_bank_account()
    {
        $data = $this->mfb->show_vendor_bank_account();
        $dt = array();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->BANK_NAME);
            $dt[$k][2] = stripslashes($v->BRANCH);
            $dt[$k][3] = stripslashes($v->ADDRESS);
            $dt[$k][4] = stripslashes($v->NO_REC);
            $dt[$k][5] = stripslashes($v->NAME);
            $dt[$k][6] = stripslashes($v->CURRENCY);
            $dt[$k][7] = '<button onclick="review_akta(\'' . base_url() . 'upload/FINANCIAL_BANK/BANK/' . $v->FILE_URL . '\')" class="btn btn-sm btn-success"><i class="fa fa-file-o"></i></button>';
            $dt[$k][8] = '<button class="btn btn-sm btn-primary update" id=' . $v->KEYS . '><span class="fa fa-edit"></span></button>'
            . '&nbsp<button class="btn btn-danger btn-sm delete" onclick=delete_acc('. $v->KEYS .')><span class="fa fa-trash-o">'
            . '</span></button>';
        }
        echo json_encode($dt);
    }

    public function delete_data_acc()
    {
            $key = stripslashes($this->input->post('KEYS'));
            $result = $this->mfb->delete_data($key,"m_vendor_bank_account");
            $this->output($result);
    }

    public function delete_data_bank()
    {
            $key = stripslashes($_POST['KEYS']);
            $result = $this->mfb->delete_data($key,"m_vendor_balance_sheet");
            $this->output($result);
    }
}
