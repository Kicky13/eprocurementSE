<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Show_vendor extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model('vendor/M_show_vendor', 'msv')->model('vendor/M_vendor')->model('vendor/M_send_invitation');
        $this->load->model('vendor/m_all_intern', 'mai');
        $this->load->database();
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function show_contact() {
        $result = $this->msv->datakontakperusahaan();
        $dt = array();
        if ($result != false) {
            foreach ($result as $k => $v) {
                $tamp = $k + 1;
                $dt[$k][0] = $tamp;
                $dt[$k][1] = $v->NAMA;
                $dt[$k][2] = $v->JABATAN;
                $dt[$k][3] = $v->TELP;
                $dt[$k][4] = $v->EMAIL;
                $dt[$k][5] = $v->HP;
            }
        }
        $this->output($dt);
    }

    public function show_address($data) {
        $result = $this->msv->get_address($data);
        $dt = array();
        if ($result != false) {
            foreach ($result as $k => $v) {
                $dt[$k][0] = $k + 1;
                $dt[$k][1] = $v->BRANCH_TYPE;
                $dt[$k][2] = $v->ADDRESS;
                $dt[$k][3] = $v->COUNTRY;
                $dt[$k][4] = $v->PROVINCE;
                $dt[$k][5] = $v->CITY;
                $dt[$k][6] = $v->POSTAL_CODE;
                $dt[$k][7] = $v->TELP;
                $dt[$k][8] = $v->HP;
                $dt[$k][9] = $v->FAX;
                $dt[$k][10] = $v->WEBSITE;
            }
        }
        $this->output($dt);
    }

    public function show_akta($data) {
        $result = $this->msv->get_akta($data);
        $dt = array();
        if ($result != false) {
            foreach ($result as $k => $v) {
                $dt[$k][0] = $k + 1;
                $dt[$k][1] = $v->NO_AKTA;
                $dt[$k][2] = $v->AKTA_DATE;
                $dt[$k][3] = $v->AKTA_TYPE;
                $dt[$k][4] = $v->NOTARIS;
                $dt[$k][5] = $v->ADDRESS;
                $dt[$k][6] = $v->VERIFICATION;
                $dt[$k][7] = $v->NEWS;
                $dt[$k][8] = '<a onclick="review_akta(\'' . base_url() . 'upload/LEGAL_DATA/AKTA/' . $v->AKTA_FILE . '\')" class="btn btn-sm btn-primary"><i class="fa fa-info-circle"></i></a>';
                $dt[$k][9] = '<a onclick="review_akta(\'' . base_url() . 'upload/LEGAL_DATA/AKTA/' . $v->VERIFICATION_FILE . '\')" class="btn btn-sm btn-primary"><i class="fa fa-info-circle"></i></a>';
                $dt[$k][10] = '<a onclick="review_akta(\'' . base_url() . 'upload/LEGAL_DATA/AKTA/' . $v->NEWS_FILE . '\')" class="btn btn-sm btn-primary"><i class="fa fa-info-circle"></i></a>';
            }
        }
        $this->output($dt);
    }

    public function get_status($status) {
        foreach ($status as $k => $v) {
            $stts[$v->STATUS]['IND'] = $v->DESCRIPTION_IND;
            $stts[$v->STATUS]['ENG'] = $v->DESCRIPTION_ENG;
        }
        return $stts;
    }

    public function send_comment()
    {
        $data=array(
          "VALUE"=>stripslashes($this->input->post('msg')),
          "TYPE"=>stripslashes($this->input->post('type')),
          "TIME"=>date('Y-m-d H:i:s'),
          "SENDER"=>$this->session->ID_USER,
          "RECEIVER"=>stripslashes($this->input->post('id')),
        );
        $res=$this->msv->add('m_status_vendor_chat',$data);
        $this->output($res);
    }

    public function comment() {
        $type = $this->input->post('type');
        $id = $this->input->post('id');
        $q = $this->msv->get_comment($id, $type);
        if($q == false)
            $this->output();
        foreach ($q as $k => $v) {
            if($v->SENDER != $id)
            {
            echo'<div class="chat">
                    <div class="chat-body" style="margin:0px">
                            <div class="chat-content">
                                <p>'.$v->VALUE.'</p>
                                <br/><p>'.$v->TIME.'</p>
                            </div>
                    </div>
                </div>';
            }
            else
            {
            echo'<div class="chat chat-left">
                    <div class="chat-body">
                        <div class="chat-content" style="margin:0px">
                            <p>'.$v->VALUE.'</p>
                            <br/><p>'.$v->TIME.'</p>
                        </div>
                    </div>
                </div>';
            }
        }
        exit;
    }

    public function change_btn($status) {

        $cek = $this->msv->cek($_POST);
        $data = array(
            //'UPDATE_BY' => $_SESSION['ID'],
            'UPDATE_TIME' => date('Y-m-d H:i:s'),
            $_POST['type'] => $status
        );
        if (count($cek) == 0) {//insert
            $data['ID_VENDOR'] = $_POST['id'];
            $data['CREATE_BY'] = $_SESSION['ID_USER'];
            $data['CREATE_TIME'] = date('Y-m-d H:i:s');
            $data['STATUS'] ='1';
            $q = $this->msv->add('m_status_vendor_data', $data);
        } else {//upd
            $q = $this->msv->upd('ID_VENDOR', 'm_status_vendor_data', $_POST['id'], $data);
        }
        if ($q == 1) {
          if (!empty($_POST['note'])) { $note = $_POST['note']; } else { $note = ""; }
            //note tidak kosong
            if ($note != '') {
                $data = array(
                    'RECEIVER' => $_POST['id'],
                    'SENDER' => $_SESSION['ID_USER'],
                    'VALUE' => stripslashes($note),
                    'TYPE' => $_POST['type']
                );
                $qry = $this->msv->add('m_status_vendor_chat', $data);
                if ($qry == 1) {
                    echo "sukses";
                } else {
                    echo "Catatan tidak tersimpan";
                }
            } else {
                echo "sukses";
            }
        } else {
            echo "Proses Gagal, silahkan coba lagi!";
        }
    }

    public function checklist_app() {
        $id = $this->input->post('id_vendor');
        $un_app = $this->input->post('tot_un_apv');
        $none = $this->input->post('tot_none');
        $status = 6;
        $flag = 0;

        if ($none > 0) {
            echo json_encode(array("msg" => "Masih ada data yang belum direview"));
            exit;
        }
        if ($un_app > 0)
            $status = 12;

        $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
        $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";

        if ($status == 6) {
            $content = $this->msv->get_email_dest(5);
            $content[0]->ROLES = explode(",", $content[0]->ROLES);
            $res = $this->msv->get_user($content[0]->ROLES, count($content[0]->ROLES));
            $data = array(
                'img1' => $img1,
                'img2' => $img2,
                'title' => $content[0]->TITLE,
                'open' => str_replace("nama_supplier", $id, $content[0]->OPEN_VALUE),
                'close' => $content[0]->CLOSE_VALUE
            );
            foreach ($res as $k => $v) {
                $data['dest'][] = $v->EMAIL;
            }
            $flag = $this->sendMail($data);
        }
        else{
            $content = $this->msv->get_email_dest(15);
            $data = array(
                'email' => $id,
                'img1' => $img1,
                'img2' => $img2,
                'title' => $content[0]->TITLE,
                'open' =>  $content[0]->OPEN_VALUE,
                'close' => $content[0]->CLOSE_VALUE,
            );
            $data['dest'][] = $id;
            $flag = $this->sendMail($data);
        }
        if (($status == 12 && $flag == true) || ($status == 6 && $flag == true)) {
            $rubah_data = array(
                'STATUS' => $status
            );
            if ($status == 6) {
                $res = $this->msv->get_slka();
                $num =1;
                if($res != false)
                    $num = $res[0]->NO_SLKA + 1;
                $rubah_data['NO_SLKA'] = str_pad($num,4, '0', STR_PAD_LEFT);
            }
            $data_update2 = array(
                'ID_VENDOR' => $id,
                'STATUS' => $status,
                'CREATE_BY' => 1
            );
            $this->msv->update('ID_VENDOR', 'm_vendor', $id, $rubah_data);
            $this->msv->add_show_vendor('log_vendor_acc', $data_update2);
            echo json_encode(array('status' => TRUE));
        } else {
            echo json_encode(array('status' => FALSE));
        }
    }

    public function get_slka_data() {
        $slka = $this->msv->get_slka_data();
        $this->output($slka);
    }

    protected function sendMail($content) {
        $mail = get_mail();
        $config = array();
        $config['protocol'] = $mail['protocol'];
        $config['smtp_crypto'] = $mail['crypto'];
        if($mail['protocol'] == 'smtp'){
            $config['smtp_pass'] = $mail['password'];
        }

        //$config['protocol'] = 'mail';
        //$config['smtp_crypto'] = '';

        $config['crlf'] = "\r\n";
        $config['mailtype'] = 'html';
        $config['smtp_host'] = $mail['smtp'];
        $config['smtp_port'] = $mail['port'];
        $config['smtp_user'] = $mail['email'];
        $config['charset'] = "utf-8";
        $config['newline'] = "\r\n";

        if (count($content['dest']) != 0 ) {
            foreach ($content['dest'] as $k => $v) {
                $this->load->library('email', $config);
                $this->email->initialize($config);
                $this->email->from($mail['email'], '[SYSTEM] EPROC SUPREME ENERGY');
                $this->email->subject($content['title']);
                $ctn = ' <p>' . $content['img1'] . '<p>
                        <br>' . $content['open'] . '
                        <br>
                        ' . $content['close'] . '
                        <br>
                        ';
                $data_email['recipient'] = $v;
        $data_email['subject'] = $content['title'];
        $data_email['content'] = $ctn;
        $data_email['ismailed'] = 0;

                if ($this->db->insert('i_notification',$data_email)) {
                    $flag = 1;
                } else {
                    $flag = 0;
                }
            }
        }

        if ($flag == 1)
            return true;
        else
            return false;
    }

    public function show() {
        $status = $this->M_send_invitation->show_status();
        $status = $this->get_status($status);
        $data = $this->msv->show();
        if ($data != false) {
            $dt = array();
            foreach ($data as $k => $v) {
                $dt[$k][0] = $k + 1;
                $dt[$k][1] = $v->NAMA;
                $dt[$k][2] = $v->ID_VENDOR;
                $dt[$k][3] = $status[$v->STATUS]['ENG'];
                $dt[$k][4] = '</a> <button data-toggle="modal" onclick="add(\'' . $v->ID . '\',\'' . $v->ID_VENDOR . '\')" class="btn btn-sm btn-primary" title="Verifikasi Data Vendor"><i class="fa fa-chevron-circle-right"></i>&nbspProcess</button> ';
            }
            $this->output($dt);
        } else {
            $this->output();
        }
    }

    public function filter_data() {
        $data = array(
            "name" => stripslashes($this->input->post('filter_name')),
            "email" => stripslashes($this->input->post('filter_email')),
            "STATUS" => $this->input->post('status'),
            "limit" => $this->input->post('limit')
        );
        $res = $this->msv->filter_data($data);
        $dt = array();
        if ($res != null) {
            foreach ($res as $k => $v) {
                $dt[$k][0] = $k + 1;
                $dt[$k][1] = stripslashes($v->NAMA);
                $dt[$k][2] = stripslashes($v->ID_VENDOR);
                $dt[$k][3] = $v->STATUS;
                $dt[$k][4] = '</a> <button data-toggle="modal" onclick="add(\'' . $v->ID . '\',\'' . $v->ID_VENDOR . '\')" class="btn btn-sm btn-primary" title="Verifikasi Data Vendor"><i class="fa fa-chevron-circle-right"></i>&nbspProcess</button> ';
            }
        }
        $this->output($dt);
    }

    public function get_data($id) {
        $res = $this->msv->get_legal($id);
        $data = array();
        $data2 = array();
        $cnt = 0;
        foreach ($res as $row) {
            if (!isset($output[$row['ID']])) {
                // Form the desired data structure
                $data[0] = [
                    "GEN" => [
                        $row['NAMA'],
                        $row['PREFIX'],
                        $row['CLASSIFICATION'],
                        $row['CUALIFICATION'],
                    ],
                    "NPWP" => [
                        $row['NO_NPWP'],
                        $row['NOTARIS_ADDRESS'],
                        $row['NPWP_PROVINCE'],
                        $row['NPWP_CITY'],
                        $row['POSTAL_CODE'],
                        $row['NPWP_FILE']
                    ],
                ];
                $data2[$row['CATEGORY']] = array(
                    $row['TYPE'],
                    $row['VALID_SINCE'],
                    $row['VALID_UNTIL'],
                    $row['CREATOR'],
                    $row['NO_DOC'],
                    $row['FILE_URL'],
                );
            }
            $cnt++;
        }
        $data = array_merge($data, $data2);
        $this->output($data);
    }

    public function index() {
        $this->mai->cek_session();
        $get_menu = $this->M_vendor->menu();
        $status = $this->mai->show_status(array('5', '13'));
        $dt = array();
        $data['status'] = $status;
        $data['menu'] = [];


        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $this->template->display('vendor/V_show_vendor', $data);
    }

    public function getlist2() {
        $list = $this->msv->getlist();
        foreach ($list as $log) {
            $row = array();
            $row["url"] = $log->URL_BATAS_HARI;
            $row["nama"] = $log->NAMA;
            $row["email"] = $log->ID_VENDOR;
            $row["id"] = $log->ID;
        }
        echo json_encode($row);
    }

    //----------------------------------------------------------------------------------------------------------//

    public function alamatperusahaan($id) {
        $data = $this->msv->alamatperusahaan($id);
        $dt = array();
        $base = base_url();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->BRANCH_TYPE);
            $dt[$k][2] = stripslashes($v->ADDRESS);
            $dt[$k][3] = stripslashes($v->COUNTRY);
            $dt[$k][4] = stripslashes($v->PROVINCE);
            $dt[$k][5] = stripslashes($v->CITY);
            $dt[$k][6] = stripslashes($v->POSTAL_CODE);
            $dt[$k][7] = stripslashes($v->TELP);
            $dt[$k][8] = stripslashes($v->HP);
            $dt[$k][9] = stripslashes($v->FAX);
            $dt[$k][10] = stripslashes($v->WEBSITE);
        }
        $this->output($dt);
    }

    public function datakontakperusahaan($id) {
        $data = $this->msv->datakontakperusahaan($id);
        $dt = array();
        $base = base_url();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->NAMA);
            $dt[$k][2] = stripslashes($v->JABATAN);
            $dt[$k][3] = stripslashes($v->TELP);
            $dt[$k][4] = stripslashes($v->EMAIL);
            $dt[$k][5] = stripslashes($v->HP);
        }
        $this->output($dt);
    }

    public function dataakta($id) {
        $data = $this->msv->dataakta($id);
        $dt = array();
        $base = base_url();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->NO_AKTA);
            $dt[$k][2] = stripslashes($v->AKTA_DATE);
            $dt[$k][3] = stripslashes($v->AKTA_TYPE);
            $dt[$k][4] = stripslashes($v->NOTARIS);
            $dt[$k][5] = stripslashes($v->ADDRESS);
            $dt[$k][6] = stripslashes($v->VERIFICATION);
            $dt[$k][7] = stripslashes($v->NEWS);
            $dt[$k][8] = '<button onclick="review_akta(\'' . base_url() . 'upload/LEGAL_DATA/AKTA/' . $v->AKTA_FILE . '\')" class="btn btn-sm btn-primary"><i class="fa fa-file-o"></i></button>';
            $dt[$k][9] = '<button onclick="review_akta(\'' . base_url() . 'upload/LEGAL_DATA/AKTA/' . $v->VERIFICATION_FILE . '\')" class="btn btn-sm btn-primary"><i class="fa fa-file-o"></i></button>';
            $dt[$k][10] = '<button onclick="review_akta(\'' . base_url() . 'upload/LEGAL_DATA/AKTA/' . $v->NEWS_FILE . '\')" class="btn btn-sm btn-primary"><i class="fa fa-file-o"></i></button>';
        }
        $this->output($dt);
    }

    public function show_datasertifikasi($id) {
        $data = $this->msv->show_datasertifikasi($id);
        $dt = array();
        $base = base_url();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->ISSUED_BY);
            $dt[$k][2] = stripslashes($v->NO_DOC);
            $dt[$k][3] = stripslashes($v->VALID_SINCE);
            $dt[$k][4] = stripslashes($v->VALID_UNTIL);
            $dt[$k][5] = stripslashes($v->DESCRIPTION);
            $dt[$k][6] = "<button class='btn btn-primary' onclick=review_akta('" . $base . 'upload/CERTIFICATION/' . $v->FILE_URL . "')><i class='fa fa-file-o'></i></button>";
        }
        $this->output($dt);
    }

    public function daftarjasa($id) {
        $data = $this->msv->daftarjasa($id);
        $dt = array();
        $base = base_url();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->GROUP);
            $dt[$k][2] = stripslashes($v->SUB_GROUP);
            $dt[$k][3] = stripslashes($v->NAME);
            $dt[$k][4] = stripslashes($v->DESCRIPTION);
            $dt[$k][5] = stripslashes($v->CERT_NO);
        }
        $this->output($dt);
    }

    public function daftarbarang($id) {
        $data = $this->msv->daftarbarang($id);
        $dt = array();
        $base = base_url();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->GROUP);
            $dt[$k][2] = stripslashes($v->SUB_GROUP);
            $dt[$k][3] = stripslashes($v->NAME);
            $dt[$k][4] = stripslashes($v->DESCRIPTION);
            $dt[$k][5] = stripslashes($v->CERT_NO);
        }
        $this->output($dt);
    }

    public function show_company_management($id) {
        $data = $this->msv->show_company_management($id);
        $dt = array();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->NAME);
            $dt[$k][2] = stripslashes($v->POSITION);
            $dt[$k][3] = stripslashes($v->PHONE);
            $dt[$k][4] = stripslashes($v->EMAIL);
            $dt[$k][5] = stripslashes($v->NO_ID);
            $dt[$k][6] = '<button onclick="review_akta(\'' . base_url() . 'upload/COMPANY_MANAGEMENT/DAFTAR_DEWAN_DIREKSI/' . $v->FILE_NO_ID . '\')" class="btn btn-sm btn-primary"><i class="fa fa-file-o"></i></button>';
            $dt[$k][7] = stripslashes($v->VALID_UNTIL);
            $dt[$k][8] = stripslashes($v->NPWP);
            $dt[$k][9] = '<button onclick="review_akta(\'' . base_url() . 'upload/COMPANY_MANAGEMENT/DAFTAR_DEWAN_DIREKSI/' . $v->FILE_NPWP . '\')" class="btn btn-sm btn-primary"><i class="fa fa-file-o"></i></button>';
        }
        echo json_encode($dt);
    }

    public function show_vendor_shareholders($id) {
        $data = $this->msv->show_vendor_shareholders($id);
        $dt = array();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->TYPE);
            $dt[$k][2] = stripslashes($v->NAME);
            $dt[$k][3] = stripslashes($v->PHONE);
            $dt[$k][4] = stripslashes($v->EMAIL);
            $dt[$k][5] = stripslashes($v->VALID_UNTIL);
            $dt[$k][6] = stripslashes($v->NPWP);
            $dt[$k][7] = '<button onclick="review_akta(\'' . base_url() . 'upload/COMPANY_MANAGEMENT/DAFTAR_PEMILIK_SAHAM/' . $v->FILE_NPWP . '\')" class="btn btn-sm btn-primary"><i class="fa fa-file-o"></i></button>';
        }
        echo json_encode($dt);
    }

    public function show_financial_bank_data($id) {
        $data = $this->msv->show_financial_bank_data($id);
        $dt = array();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->YEAR);
            $dt[$k][2] = stripslashes($v->TYPE);
            $dt[$k][3] = stripslashes($v->CURRENCY);
            $dt[$k][4] = stripslashes($v->ASSET_VALUE);
            $dt[$k][5] = stripslashes($v->DEBT);
            $dt[$k][6] = stripslashes($v->BRUTO);
            $dt[$k][7] = stripslashes($v->NETTO);
            $dt[$k][8] = '<button onclick="review_akta(\'' . base_url() . 'upload/FINANCIAL_BANK/NERACA/' . $v->FILE_URL . '\')" class="btn btn-sm btn-primary"><i class="fa fa-file-o"></i></button>';
        }
        echo json_encode($dt);
    }

    public function show_vendor_bank_account($id) {
        $data = $this->msv->show_vendor_bank_account($id);
        $dt = array();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->BANK_NAME);
            $dt[$k][2] = stripslashes($v->BRANCH);
            $dt[$k][3] = stripslashes($v->ADDRESS);
            $dt[$k][4] = stripslashes($v->NO_REC);
            $dt[$k][5] = stripslashes($v->CURRENCY);
            //$dt[$k][6] = stripslashes($v->FILE_URL);
            $dt[$k][6] = '<button onclick="review_akta(\'' . base_url() . 'upload/FINANCIAL_BANK/BANK/' . $v->FILE_URL . '\')" class="btn btn-sm btn-primary"><i class="fa fa-file-o"></i></button>';
        }
        echo json_encode($dt);
    }

    public function show_experience($id) {
        # code...
        $data = $this->msv->show_experience_experience($id);
        $dt = array();
        foreach ($data as $k => $v) {
            # code...
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->CUSTOMER_NAME);
            $dt[$k][2] = stripslashes($v->PROJECT_NAME);
            $dt[$k][3] = stripslashes($v->PROJECT_DESCRIPTION);
            $dt[$k][4] = stripslashes($v->PROJECT_VALUE);
            $dt[$k][5] = stripslashes($v->CURRENCY);
            $dt[$k][6] = stripslashes($v->CONTRACT_NO);
            $dt[$k][7] = stripslashes($v->START_DATE);
            $dt[$k][8] = stripslashes($v->END_DATE);
            $dt[$k][9] = stripslashes($v->CONTACT_PERSON);
            $dt[$k][10] = stripslashes($v->PHONE);
        }
        echo json_encode($dt);
    }

    public function show_certification($id) {
        $data = $this->msv->show_certification($id);
        $dt = array();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->CREATOR);
            $dt[$k][2] = stripslashes($v->TYPE);
            $dt[$k][3] = stripslashes($v->NO_DOC);
            $dt[$k][4] = stripslashes($v->CREATE_BY);
            $dt[$k][5] = stripslashes($v->VALID_SINCE);
            $dt[$k][6] = stripslashes($v->VALID_UNTIL);
            $dt[$k][7] = '<button onclick="review_akta(\'' . base_url() . 'upload/CE/CERTIFICATION/' . $v->FILE_URL . '\')" class="btn btn-sm btn-primary"><i class="fa fa-file-o"></i></button>';
        }
        echo json_encode($dt);
    }

    public function get_csms() {
        if ($this->input->post('API') == 'SELECT') {
            $id = stripslashes($this->input->post('id'));
            $res = $this->msv->get_csms($id);
            if ($res == false)
                $this->output(null);
            else
                $this->output($res[0]);
        } else
            $this->output(null);
    }

    public function getlist($id_vendor) {
        $tot_un_apv = 0;
        $total = 0;
        foreach ($this->msv->get_checklist($id_vendor) as $k => $v) {
            if ($v == 1) {
                $dt[$k] = '<a href="#"><i class="fa fa-check text-navy"></i></a>';
            } else if ($v == '') {
                $total++;
                $dt[$k] = '<a href="#"><i></i></a>';
            } else if ($v == 0) {
                $dt[$k] = '<a href="#"><i class="fa fa-times text-danger"></i></a>';
                $tot_un_apv++;
            }
        }
        echo '
                            <input style="display:none" value="' . $tot_un_apv . '" name="tot_un_apv" id="tot_un_apv">
                            <input style="display:none" value="' . $total . '" name="tot_none" id="tot_none">
                            <table class="table table-striped table-bordered table-hover display" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>' . lang('Deskirpsi', 'Description') . '</th>
                                        <th><span>Status</span></th>
                                        <th>' . lang('Verifikasi', 'Check') . '</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="5" class="text-centered"><b>A. Data Umum</b></td>
                                    </tr>
                                    <tr>
                                        <td>1.</td>
                                        <td>Info Perusahaan</td>
                                        <td>' . lang('Wajib', 'Required') . '</td>
                                        <td>' . $dt['GENERAL1'] . '</td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Alamat Perusahaan</td>
                                        <td>' . lang('Wajib', 'Required') . '</td>
                                        <td>' . $dt['GENERAL2'] . '</td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Kontak Perusahaan</td>
                                        <td>' . lang('Wajib', 'Required') . '</td>
                                        <td>' . $dt['GENERAL3'] . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-centered"><b>B. Data Legal</b></td>
                                    </tr>
                                    <tr>
                                        <td>1.</td>
                                        <td>Akta</td>
                                        <td>' . lang('Wajib', 'Required') . '</td>
                                        <td>' . $dt['LEGAL1'] . '</td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Surat Izin Usaha Perdagangan (SIUP)</td>
                                        <td>' . lang('Wajib', 'Required') . '</td>
                                        <td>' . $dt['LEGAL2'] . '</td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Tanda Daftar Perusahaan (TDP)</td>
                                        <td>' . lang('Wajib', 'Required') . '</td>
                                        <td>' . $dt['LEGAL3'] . '</td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td>Nomor Pokok Wajib Pajak (NPWP)</td>
                                        <td>' . lang('Wajib', 'Required') . '</td>
                                        <td>' . $dt['LEGAL4'] . '</td>
                                    </tr>
                                    <tr>
                                        <td>5.</td>
                                        <td>' . lang('Direktorat Panas Bumi', 'Geothermal Directorate') . '</td>
                                        <td>' . lang('Kondisional', 'Optional') . '</td>
                                        <td>' . $dt['LEGAL5'] . '</td>
                                    </tr>
                                    <tr>
                                        <td>6.</td>
                                        <td>' . lang('Surat Keterangan Terdaftar MIGAS (Dirjen Minyak & Gas Bumi)', 'Oil and Gas Certificate') . '</td>
                                        <td>' . lang('Kondisional', 'Optional') . '</td>
                                        <td>' . $dt['LEGAL6'] . '</td>
                                    </tr>
                                    <tr>
                                        <td>7.</td>
                                        <td>SPPKP</td>
                                        <td>' . lang('Kondisional', 'Optional') . '</td>
                                        <td>' . $dt['LEGAL7'] . '</td>
                                    </tr>
                                    <tr>
                                        <td>8.</td>
                                        <td>' . lang('SKT PAJAK', 'TAX cERTIFICATE') . '</td>
                                        <td>' . lang('Kondisional', 'Optional') . '</td>
                                        <td>' . $dt['LEGAL8'] . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-centered"><b>C. Barang & Jasa yang Bisa Dipasok</b></td>
                                    </tr>
                                    <tr>
                                        <td>1.</td>
                                        <td>Sertifikasi Keagenan & Prinsipal</td>
                                        <td>' . lang('Kondisional', 'Optional') . '</td>
                                        <td>' . $dt['GNS1'] . '</td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Barang</td>
                                        <td>' . lang('Wajib', 'Required') . '</td>
                                        <td>' . $dt['GNS2'] . '</td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Jasa</td>
                                        <td>' . lang('Wajib', 'Required') . '</td>
                                        <td>' . $dt['GNS3'] . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-centered"><b>D. Data Bank & Keuangan</b></td>
                                    </tr>
                                    <tr>
                                        <td>1.</td>
                                        <td>Dafar Rekening Bank</td>
                                        <td>' . lang('Wajib', 'Required') . '</td>
                                        <td>' . $dt['BNF1'] . '</td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Neraca Keuangan</td>
                                        <td>' . lang('Wajib', 'Required') . '</td>
                                        <td>' . $dt['BNF2'] . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-centered"><b>E. Pengurus Perusahaan</b></td>
                                    </tr>
                                    <tr>
                                        <td>1.</td>
                                        <td>Dewan Direksi</td>
                                        <td>' . lang('Wajib', 'Required') . '</td>
                                        <td>' . $dt['MANAGEMENT1'] . '</td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Daftar Pemilik Saham</td>
                                        <td>' . lang('Kondisinoal', 'Optional') . '</td>
                                        <td>' . $dt['MANAGEMENT1'] . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-centered"><b>F. Sertifikasi & Pengalaman Perusahaan</b></td>
                                    </tr>
                                    <tr>
                                        <td>1.</td>
                                        <td>Sertifikasi Umum</td>
                                        <td>' . lang('Kondisional', 'Optional') . '</td>
                                        <td>' . $dt['CNE1'] . '</td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Pengalaman Perusahaan</td>
                                        <td>' . lang('Kondisinoal', 'Optional') . '</td>
                                        <td>' . $dt['CNE2'] . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-centered"><b>G. Contractor SHE Mangement System (CSMS)</b></td>
                                    </tr>
                                    <tr>
                                        <td>1.</td>
                                        <td>CSMS</td>
                                        <td>' . lang('Wajib', 'Required') . '</td>
                                        <td>' . $dt['CSMS'] . '</td>
                                    </tr>
                                </tbody>
                            </table>';
    }

}
