<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Approve_update extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model('vendor/M_approve_update', 'mau')->model('vendor/M_vendor')->model('vendor/M_send_invitation');
        $this->load->model('vendor/M_all_intern', 'mai');
        $this->load->model('vendor/M_approve_slka', 'map');
        $this->load->database();
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function show_contact($data) {
        $result = $this->mau->get_contact($data);
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
        $result = $this->mau->get_address($data);
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
        $result = $this->mau->get_akta($data);
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
                $dt[$k][8] = '<button onclick="review_akta(\'' . base_url() . 'upload/LEGAL_DATA/AKTA/' . $v->AKTA_FILE . '\')" class="btn btn-sm btn-primary"><i class="fa fa-info-circle"></i></button>';
                $dt[$k][9] = '<button onclick="review_akta(\'' . base_url() . 'upload/LEGAL_DATA/AKTA/' . $v->VERIFICATION_FILE . '\')" class="btn btn-sm btn-primary"><i class="fa fa-info-circle"></i></button>';
                $dt[$k][10] = '<button onclick="review_akta(\'' . base_url() . 'upload/LEGAL_DATA/AKTA/' . $v->NEWS_FILE . '\')" class="btn btn-sm btn-primary"><i class="fa fa-info-circle"></i></button>';
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

    public function show() {
        $status = $this->M_send_invitation->show_status();
        $status = $this->get_status($status);
        $data = $this->mau->show();
        if ($data != false) {
            $dt = array();
            foreach ($data as $k => $v) {
                $dt[$k][0] = $k + 1;
                $dt[$k][1] = $v->NAMA;
                $dt[$k][2] = $v->ID_VENDOR;
                $dt[$k][3] = '<span>Registration Verified</span>';
                // $dt[$k][4] = '</a> <a data-toggle="modal" onclick="accept(\'' . $v->ID . '\',\'' . $v->ID_VENDOR . '\')" class="btn btn-sm btn-primary" title="Approve SLKA"><i class="fa fa-check"></i>&nbsp</a> ' .
                //         '</a> <a data-toggle="modal" onclick="reject(\'' . $v->ID . '\',\'' . $v->ID_VENDOR . '\')" class="btn btn-sm btn-danger" title="Reject SLKA"><i class="fa fa-ban"></i>&nbsp</a> ';
                // $checkbox = "<a class='btn btn-primary btn-sm' title='Approve & Send Email' href='javascript:void(0)' onclick='accept(" . $v->ID . ")'><i class='fa fa-check'></i></a>"
                //     . " <a class='btn btn-danger btn-sm' title='Reject' href='javascript:void(0)' onclick='hapus(" . $v->ID . ")'><i class='fa fa-ban'></i></a>";
                // $dt[$k][4] = "$checkbox";
                 $dt[$k][4] = '</a> <button data-toggle="modal" onclick="detail(\'' . $v->ID . '\',\'' . $v->ID_VENDOR . '\')" class="btn btn-sm btn-primary" title="Proses"><i class="fa fa-chevron-circle-right"></i> Process</button> ';
            }

            $return = array(
                'data' => $dt,
                'recordsTotal' => count($dt),
                'recordsFiltered' => count($dt)
            );
            $this->output($dt);
        } else {
            $this->output();
        }
    }

    public function show_update($id) {
        $list = $this->mau->show_update($id);
        foreach ($list as $log) {
            $row = array();
            $row["nama"] = $log->NAMA;
            $row["email"] = $log->ID_VENDOR;
            $row["id"] = $log->ID;
        }
        echo json_encode($row);
    }

    public function update_vendor_kirim_email() {
        //echopre($_POST);exit;
        $id = $this->input->post('id_data');
        $content = $this->mau->show_temp_email(6);
        $pass_random = rand(100000, 999999);
        $pass = stripslashes(str_replace('/','_',crypt($pass_random, mykeyencrypt)));
        date_default_timezone_set("Asia/Jakarta");
        //$bts_hari=$this->M_invite_acc->get_url($id);
        $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
        $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";
        $mini_url = date("HiY") . rand(100000000, 999999999) . date("md") . $id;
        $url = "<a href='" . base_url() . "log_in/index/" . $mini_url . "'>Invitation Link</a>";
        //$mini_url=date("HiY").rand(100000000,999999999).date("md").$id;
        $data = array(
            'email' => $this->input->post('email_id'),
            'img1' => $img1,
            'img2' => $img2,
            'nama' => $this->input->post('nama_id'),
            'hari' => $this->input->post('url_id'),
            'pass' => $pass_random,
            'link' => $url,
            'title' => $content->TITLE,
            'open' => $content->OPEN_VALUE,
            'close' => $content->CLOSE_VALUE
        );
        if ($this->sendMail($data)) {
            $rubah_data = array(
                'STATUS' => 7,
                'PASSWORD' => $pass,
                'URL' => $mini_url
            );
            $data_update2 = array(
                'ID_VENDOR' => $this->input->post('email_id'),
                'STATUS' => 7,
                'NOTE' => $this->input->post('note'),
                'CREATE_BY' => 1
            );
            $this->mau->upd('ID', 'm_vendor', $id, $rubah_data);
            $this->mau->add('log_vendor_acc', $data_update2);
            echo json_encode(array("status" => TRUE));
        } else {
            echo json_encode(array("status" => FALSE));
        }
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

        $this->load->library('email', $config);
        $this->email->initialize($config);
        $this->email->from($mail['email'], 'Lulus Kualifikasi Administrasi Perusahaan');
        $this->email->to($content['email']);
        $this->email->subject($content['title']);
        $ctn = ' <p>' . $content['img1'] . '<p>
                        <p>' . $content['open'] . '<p>
                        <br>
                        <P>' . $content['close'] . '<P>
                        ';

         $data_email['recipient'] = $content['email'];
        $data_email['subject'] = $content['title'];
        $data_email['content'] = $ctn;
        $data_email['ismailed'] = 0;

        if ($this->db->insert('i_notification',$data_email)) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_data() {
        $id = $this->input->post('id_email');
        $content = $this->mau->show_temp_email(1);
        $data = array(
            'email' => $this->input->post('email_edit'),
            'title' => $content->TITLE,
            'open' => $content->OPEN_VALUE,
            'close' => $content->CLOSE_VALUE
        );
        if ($this->rejekMail($data)) {
            $data_update = array(
                'ID_VENDOR' => $this->input->post('email_edit'),
                'STATUS' => 11,
                'NOTE' => $this->input->post('note'),
                'CREATE_BY' => 1
            );
            $data_update2 = array(
                'STATUS' => 11,
                'CREATE_BY' => 1
            );
//            echo "'ID', 'm_vendor', $id, $data_update2";exit;
            $this->mau->upd('ID', 'm_vendor', $id, $data_update2);
            $this->mau->add('log_vendor_acc', $data_update);
            echo json_encode(array("status" => TRUE));
        } else {
            echo json_encode(array("status" => FALSE));
        }
    }

    protected function rejekMail($content) {
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

        $this->load->library('email', $config);
        $this->email->initialize($config);
        $this->email->from($mail['email'], 'Undangan Pendaftaran Supplier PT. SUPREME');
        $this->email->to($content['email']);
        $this->email->subject($content['title']);
        $ctn = $content['open'] . "<br/><br/>Username : " . $content['email'] . "<br/><br/>Link ini akan kadaluarsa pada tanggal 12 Januari 2018<br/><br/>" . $content['close'];

        $data_email['recipient'] = $content['email'];
        $data_email['subject'] = $content['title'];
        $data_email['content'] = $ctn;
        $data_email['ismailed'] = 0;
        if ($this->db->insert('i_notification',$data_email)) {
            return true;
        } else {
            return false;
        }
    }

    public function change_btn() {
      $status = 0;
      $id_vendor = $this->input->post('id_vendor');
      $statusnya = $this->input->post('statusnya');
      $email = $this->input->post('email');
      $note = $this->input->post('note');
        $respon = array();
        $upd = array(
            'STATUS' => $statusnya,
            'UPDATE_TIME' => date('Y-m-d H:i:s'),
            'UPDATE_BY' => $this->session->userdata['ID_USER']
        );
        $q = $this->mau->upd('ID', 'm_vendor', $id_vendor, $upd);

        if ($q === true) {
          $ins = array(
              'ID_VENDOR' => $email,
              'STATUS' => $statusnya,
              'NOTE' => $note,
              'CREATE_TIME' => date('Y-m-d H:i:s'),
              'CREATE_BY' => $this->session->userdata['ID_USER']
          );
          $q_ins = $this->mau->add('log_vendor_acc', $ins);
          $respon['update'] = true;
          if ($q_ins === true) {
            $respon['insert'] = true;
          } else {
            $respon['insert'] = false;
          }
        } else {
          $respon['update'] = false;
        }

        if ($statusnya == '7') {
          $desc = 11;
        } else {
          $desc = 15;
        }

        $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
        $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";

        $content = $this->mau->get_email_dest($desc);
        $data = array(
            'email' => $email,
            'img1' => $img1,
            'img2' => $img2,
            'title' => $content[0]->TITLE,
            'open' =>  $content[0]->OPEN_VALUE,
            'close' => $content[0]->CLOSE_VALUE,
            'dest' => 'Cek cek'
        );
        $flag = $this->sendMail($data);


		$dtAlamat = array(
			'a.ID_VENDOR' => $_POST['id_vendor'],
			'BRANCH_TYPE' => 'KANTOR PUSAT',
			'a.STATUS' => 1
		);
		$dt = $this->map->alamatperusahaan($dtAlamat);
		$dt2 = false;
		if ($dt == false) {
			$dtAlamat = array(
				'a.ID_VENDOR' => $_POST['id_vendor'],
				'a.STATUS' => 1);
			$dt = $this->map->alamatperusahaan($dtAlamat,true);
		}
		$dtCountry = array(
			'name' => $dt[0]->COUNTRY
		);
		$dt2 = $this->map->get_Country_Code($dtCountry);
		$data_jde = array(
                    'ADDRESS_LINE1' => stripslashes($dt[0]->ADDRESS),
                    'ADDRESS_LINE2' => stripslashes($dt[0]->PROVINCE),
                    'ENTITY_ID' => stripslashes($dt[0]->ID_VENDOR), //id angka
                    'CITY' => stripslashes($dt[0]->CITY),
                    'COUNTRY_CODE' => stripslashes($dt2[0]->sortname),
                    'POSTAL_CODE' => stripslashes($dt[0]->POSTAL_CODE),
                    'BISNIS UNIT' => 10101,
                    'E_ADDRESS' => stripslashes($_POST['email']),
                    'ENTITY_TAX_ID' => stripslashes($_POST['entity_tax_id']),
                    'ENTITY_NAME' => stripslashes($_POST['entity_name']),
                    'PHONE_NUMBER' => $dt[0]->TELP
                );

		if ($statusnya == '7') {
          $toJDE = $this->change_jde($data_jde); //upload_JDE
		  if(!$toJDE){
				$upd = array(
					'STATUS' => 23,
					'UPDATE_TIME' => date('Y-m-d H:i:s'),
					'UPDATE_BY' => $_SESSION['ID_USER']
				);
				$q = $this->map->upd('ID', 'm_vendor', $_POST['id_vendor'], $upd); ///PENTING: jangan hapus
				$respon['update'] = false;
			}
        }



        echo json_encode($respon);

    }

     public function get_csms() {
        if ($this->input->post('API') == 'SELECT') {
            $id=  stripslashes($this->input->post('id'));
            $res = $this->mau->get_csms($id);
            if ($res == false)
                $this->output(null);
            else
                $this->output($res[0]);
        } else
            $this->output(null);
    }

     public function get_data($id) {
        $res = $this->mau->get_legal($id);

        $slka=$this->mau->get_slka($id);
        $data = array();
        $data2 = array();
        $cnt=0;
        $ktr=array(
            '','','',''
        );
        $branch=array();
        foreach($res as $row) {
            if (!isset($output[$row['ID']])) {
                // Form the desired data structure
                if(strcmp($row['BRANCH_TYPE'],'KANTOR PUSAT') == 0)
                {
                    $ktr[1]=$row['ADDRESS'];
                    $ktr[2]=$row['FAX'];
                    $ktr[3]=$row['TELP'];
                }
                else
                {
                    $branch[0]=$row['BRANCH_TYPE'];
                    $branch[1]=$row['ADDRESS'];
                    $branch[2]=$row['FAX'];
                    $branch[3]=$row['TELP'];
                }
                $data[0] = [
                    "GEN" => [
                        $row['NAMA'],
                        $row['PREFIX'],
                        $row['CLASSIFICATION'],
                        $row['CUALIFICATION'],
                        $row['CUALIFICATION'],
                        $ktr[1],
                        $ktr[2],
                        $ktr[3]
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
                $data2[$row['CATEGORY']]= array(
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
        foreach($slka as $k => $v)
        {

            $data3[0]=[
                "SLKA" =>[
                    str_replace("XXXX",$v->NO_SLKA,$v->OPEN_VALUE),
                    str_replace("XXXX",$v->NO_SLKA,$v->CLOSE_VALUE),
                ]
            ];
        }
        $data=array_merge($data, $data3);
        $data=array_merge($data, $data2);
        if($data[0]['GEN'][5] == '' && count($branch)>0)
        {
            $data[0]['GEN'][6]=$row['ADDRESS'];
            $data[0]['GEN'][7]=$row['FAX'];
            $data[0]['GEN'][8]=$row['TELP'];
        }
        $this->output($data);
    }

    public function index() {
        $cek = $this->mai->cek_session();
        $get_menu = $this->M_vendor->menu();
        //$all = $this->mau->get_alldata();
        ///$all1 = $this->mau->get_vendor();
        $dt = array();
        $data['vendor'] = [];
        $data['menu'] = [];

        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $this->template->display('vendor/V_approve_update', $data);
    }

    public function getlist($id_vendor) {
        $tot_un_apv = 0;
        foreach ($this->mau->get_checklist($id_vendor) as $k => $v) {
            if ($v == 1) {
                $dt[$k] = '<a href="#"><i class="fa fa-check text-navy"></i></a>';
            } else {
                $dt[$k] = '<a href="#"><i class="fa fa-times text-danger"></i></a>';
                $tot_un_apv++;
            }
        }
        echo '
                            <input style="display:none" value="' . $tot_un_apv . '" name"tot_un_apv">
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
                                        <td>Surat Keterangan Terdaftar EBTKE (Dirjen Energi Terdbarukan & Konservasi Energi)</td>
                                        <td>' . lang('Kondisional', 'Optional') . '</td>
                                        <td>' . $dt['LEGAL5'] . '</td>
                                    </tr>
                                    <tr>
                                        <td>6.</td>
                                        <td>Surat Keterangan Terdaftar MIGAS (Dirjen Minyak & Gas Bumi)</td>
                                        <td>' . lang('Kondisional', 'Optional') . '</td>
                                        <td>' . $dt['LEGAL6'] . '</td>
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

    public function alamatperusahaan($id) {
        $data = $this->mau->alamatperusahaan($id);
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
        $data = $this->mau->datakontakperusahaan($id);
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
        $data = $this->mau->dataakta($id);
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
            $dt[$k][8] = '<button onclick="review_gambar(\'' . base_url() . 'upload/LEGAL_DATA/AKTA/' . $v->AKTA_FILE . '\')" class="btn btn-sm btn-primary"><i class="fa fa-file-o"></i></button>';
            $dt[$k][9] = '<button onclick="review_gambar(\'' . base_url() . 'upload/LEGAL_DATA/AKTA/' . $v->VERIFICATION_FILE . '\')" class="btn btn-sm btn-primary"><i class="fa fa-file-o"></i></button>';
            $dt[$k][10] = '<button onclick="review_gambar(\'' . base_url() . 'upload/LEGAL_DATA/AKTA/' . $v->NEWS_FILE . '\')" class="btn btn-sm btn-primary"><i class="fa fa-file-o"></i></button>';
        }
        $this->output($dt);
    }

    public function show_datasertifikasi($id) {
        $data = $this->mau->show_datasertifikasi($id);
        $dt = array();
        $base = base_url();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->ISSUED_BY);
            $dt[$k][2] = stripslashes($v->NO_DOC);
            $dt[$k][3] = stripslashes($v->VALID_SINCE);
            $dt[$k][4] = stripslashes($v->VALID_UNTIL);
            $dt[$k][5] = stripslashes($v->DESCRIPTION);
            $dt[$k][6] = "<button class='btn btn-sm btn-primary' onclick=review_file('" . $base . 'upload/CERTIFICATION/' . $v->FILE_URL . "')><i class='fa fa-file-o'></i></button>";
        }
        $this->output($dt);
    }

    public function daftarjasa($id) {
        $data = $this->mau->daftarjasa($id);
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
        $data = $this->mau->daftarbarang($id);
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
        $data = $this->mau->show_company_management($id);
        $dt = array();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->NAME);
            $dt[$k][2] = stripslashes($v->POSITION);
            $dt[$k][3] = stripslashes($v->PHONE);
            $dt[$k][4] = stripslashes($v->EMAIL);
            $dt[$k][5] = stripslashes($v->NO_ID);
            $dt[$k][6] = '<button onclick="review_gambar(\'' . base_url() . 'upload/COMPANY_MANAGEMENT/DAFTAR_DEWAN_DIREKSI/' . $v->FILE_NO_ID . '\')" class="btn btn-sm btn-primary"><i class="fa fa-file-o"></i></button>';
            $dt[$k][7] = stripslashes($v->NPWP);
            $dt[$k][8] = '<button onclick="review_gambar(\'' . base_url() . 'upload/COMPANY_MANAGEMENT/DAFTAR_DEWAN_DIREKSI/' . $v->FILE_NPWP . '\')" class="btn btn-sm btn-primary"><i class="fa fa-file-o"></i></button>';
        }
        echo json_encode($dt);
    }

    public function show_vendor_shareholders($id) {
        $data = $this->mau->show_vendor_shareholders($id);
        $dt = array();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->NAME);
            $dt[$k][2] = stripslashes($v->PHONE);
            $dt[$k][3] = stripslashes($v->EMAIL);
            $dt[$k][4] = stripslashes($v->NPWP);
            $dt[$k][5] = '<button onclick="review_gambar(\'' . base_url() . 'upload/COMPANY_MANAGEMENT/DAFTAR_PEMILIK_SAHAM/' . $v->FILE_NPWP . '\')" class="btn btn-sm btn-primary"><i class="fa fa-file-o"></i></button>';
        }
        echo json_encode($dt);
    }

    public function show_financial_bank_data($id) {
        $data = $this->mau->show_financial_bank_data($id);
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
        $data = $this->mau->show_vendor_bank_account($id);
        $dt = array();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->BANK_NAME);
            $dt[$k][2] = stripslashes($v->BRANCH);
            $dt[$k][3] = stripslashes($v->ADDRESS);
            $dt[$k][4] = stripslashes($v->NO_REC);
            $dt[$k][5] = stripslashes($v->NAME);
            $dt[$k][6] = stripslashes($v->CURRENCY);
            $dt[$k][7] = '<button onclick="review_akta(\'' . base_url() . 'upload/FINANCIAL_BANK/BANK/' . $v->FILE_URL . '\')" class="btn btn-sm btn-primary"><i class="fa fa-file-o"></i></button>';
        }
        echo json_encode($dt);
    }

    public function show_experience($id) {
        # code...
        $data = $this->mau->show_experience_experience($id);
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
        $data = $this->mau->show_certification($id);
        $dt = array();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->KEY);
            $dt[$k][2] = stripslashes($v->ID_VENDOR);
            $dt[$k][3] = stripslashes($v->NO_DOC);
            $dt[$k][4] = stripslashes($v->ISSUED_BY);
            $dt[$k][5] = stripslashes($v->VALID_SINCE);
            $dt[$k][6] = stripslashes($v->VALID_UNTIL);
            $dt[$k][7] = '<button onclick="review_akta(\'' . base_url() . 'upload/FINANCIAL_BANK/BANK/' . $v->FILE_URL . '\')" class="btn btn-sm btn-primary"><i class="fa fa-file-o"></i></button>';
        }
        echo json_encode($dt);
    }

	public function change_jde($data) {

        //echopre($data);
        //exit;

        $ch = curl_init('https://10.1.1.94:91/PD910/AddressBookManager?WSDL');
        $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:orac="http://oracle.e1.bssv.JP010000/">
                            <soapenv:Header>
                            <wsse:Security
                            xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
                            xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
                            xmlns:env="http://schemas.xmlsoap.org/soap/envelope/"
                            soapenv:mustUnderstand="1">
                            <wsse:UsernameToken xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
                            xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
                            <wsse:Username>SCM</wsse:Username>
                            <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">password</wsse:Password>
                            </wsse:UsernameToken>
                            </wsse:Security>
                            </soapenv:Header>
                            <soapenv:Body>


                            <orac:processAddressBook>
                             <addressBook>
                             <address>
                                <addressLine1>' . $data['ADDRESS_LINE1'] . '</addressLine1>
                                <addressLine2>' . $data['ADDRESS_LINE2'] . '</addressLine2>
                                <addressLine3></addressLine3>
                                <addressLine4></addressLine4>
                                <city>' . $data['CITY'] . '</city>
                                <countryCode>' . $data['COUNTRY_CODE'] . '</countryCode>
                                <postalCode>' . $data['POSTAL_CODE'] . '</postalCode>
                             </address>
                             <businessUnit>10101</businessUnit>
                             <electronicAddresses>
                                <actionType>2</actionType>
                                <contactId>0</contactId>
                                <electronicAddress>' . $data['E_ADDRESS'] . '</electronicAddress>
                                <electronicAddressTypeCode>E</electronicAddressTypeCode>
                             </electronicAddresses>
                             <entity>
                                <entityId>' . $data['ENTITY_ID'] . '</entityId>
                                <entityTaxId>' . $data['ENTITY_TAX_ID'] . '</entityTaxId>
                             </entity>
                             <entityName>' . $data['ENTITY_NAME'] . '</entityName>
                             <entityNameSecondary>-</entityNameSecondary>
                             <!--<entityTaxIdAdditional>378888888881234</entityTaxIdAdditional>-->
                             <entityTypeCode>V</entityTypeCode>
                             <isEntityTypePayables>1</isEntityTypePayables>
                             <isEntityTypeReceivables>0</isEntityTypeReceivables>
                             <phoneNumbers>
                                <actionType>2</actionType>
                                <contactId>0</contactId>
                                <phoneNumber>' . $data['PHONE_NUMBER'] . '</phoneNumber>
                                <phoneTypeCode>FAX</phoneTypeCode>
                             </phoneNumbers>
                             <processing>
                                <actionType>2</actionType>
                                <processingVersion>ZJDE0001</processingVersion>
                             </processing>
                             </addressBook>
                            </orac:processAddressBook>


                            </soapenv:Body>
                            </soapenv:Envelope>';
        $headers = array(
            #"Content-type: application/soap+xml;charset=\"utf-8\"",
            "Content-Type: text/xml",
            "charset:utf-8",
            "Accept: application/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "Content-length: " . strlen($xml_post_string),
        );

        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        #curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_SSLv3);
        #curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_0 );
        curl_setopt($ch, CURLOPT_SSLVERSION, 'all');
        #curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_MAX_DEFAULT);

        curl_setopt($ch, CURLOPT_VERBOSE, true);
//		$verbose = fopen('testing.log', 'w+');
//		curl_setopt($ch, CURLOPT_STDERR, $verbose);


        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);

        $data = curl_exec($ch);
        //echo curl_error($ch);
        curl_close($ch);
		if (strpos($data, 'HTTP/1.1 200 OK') !== false) {
			return true;
		}else{
			return false;
		}
    }

}
