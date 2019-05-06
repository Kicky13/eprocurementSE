<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Send_invitation extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('vendor/M_send_invitation')->model('vendor/M_vendor');
        $this->db = $this->load->database('default', true);
        $this->load->model('vendor/m_all_intern', 'mai');
        $this->load->helper('html');
    }

    public function index() {
        $cek = $this->mai->cek_session();
        $temp = $this->M_send_invitation->show();
        $data['total'] = count($temp);
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $this->template->display('vendor/V_send_invitation', $data);
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function filter_data() {
        $res = $this->M_send_invitation->filter_data($_POST);
        $status = $this->M_send_invitation->show_status();
        $status = $this->get_status($status);
        $dt = array();
        if ($res != null) {
            foreach ($res as $k => $v) {
                $dt[$k][0] = $k + 1;
                $dt[$k][1] = stripslashes($v->NAMA);
                $dt[$k][2] = stripslashes($v->ID_VENDOR);
                $dt[$k][3] = "<span class='text-center' title='history'>" . $v->URL_BATAS_HARI . ' day' . "</span>";
                $dt[$k][4] = $status[$v->STATUS]['ENG'];
                if ($v->STATUS == 1) {
                    $btn_edit = "<a class='btn btn-info btn-sm' title='Update' href='javascript:void(0)' onclick='edit_undangan(" . $v->ID . ")'><i class='fa fa-edit'></i></a>";
                    $btn_resend = "<a class='btn btn-danger btn-sm disabled' title='Kirim ulang' href='javascript:void(0)' onclick='kirim_ulang(" . $v->ID . ")'><i class='fa fa-send'></i></a>";
                    $btn_history = "<a class='btn btn-success btn-sm' title='History' href='javascript:void(0)' onclick='tabel_detail(" . $v->ID . ")'><i class='fa fa-clock-o'></i></a>";
                } else if ($v->STATUS == 2 || $v->STATUS == 3) {
                    $btn_edit = "<a class='btn btn-info btn-danger btn-sm disabled' title='Update' href='javascript:void(0)' onclick='edit_undangan(" . $v->ID . ")'><i class='fa fa-edit'></i></a>";
                    $btn_resend = "<a class='btn btn-default btn-sm' title='Kirim ulang' href='javascript:void(0)' onclick='kirim_ulang(" . $v->ID . ")'><i class='fa fa-send'></i></a>";
                    $btn_history = "<a class='btn btn-success btn-sm' title='History' href='javascript:void(0)' onclick='tabel_detail(" . $v->ID . ")'><i class='fa fa-clock-o'></i></a>";
                } else {
                    $btn_edit = "<a class='btn btn-info btn-danger btn-sm disabled' title='Update' href='javascript:void(0)' onclick='edit_undangan(" . $v->ID . ")'><i class='fa fa-edit'></i></a>";
                    $btn_resend = "<a class='btn btn-danger btn-sm disabled' title='Kirim ulang' href='javascript:void(0)' onclick='kirim_ulang(" . $v->ID . ")'><i class='fa fa-send'></i></a>";
                    $btn_history = "<a class='btn btn-success btn-sm' title='History' href='javascript:void(0)' onclick='tabel_detail(" . $v->ID . ")'><i class='fa fa-clock-o'></i></a>";
                }
                $dt[$k][5] = "$btn_edit $btn_history $btn_resend";
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

    public function get_owner($data) {
        foreach ($data as $k => $v) {
            $dat[$v->ID_USER]['NAMA'] = $v->USERNAME;
        }
        return $dat;
    }

    public function get_code($data, $exp) {
        $dt['jam'] = substr($data, 0, 2);
        $dt['menit'] = substr($data, 2, 2);
        $dt['tahun'] = substr($data, 4, 4);
        $dt['bulan'] = substr($data, 18, 2);
        $dt['tgl'] = substr($data, 20, 2);
        $dt['pukul'] = $dt['jam'] . ":" . $dt['menit'];
        $dt['tgl_mulai'] = $dt['tahun'] . "-" . $dt['bulan'] . "-" . $dt['tgl'];
        $dt['tgl_mulai_min'] = str_replace("-", "", $dt['tgl_mulai']);
        $dt['tgl_selesai'] = date('Y-m-d', strtotime("+$exp days", strtotime($dt['tgl_mulai'])));
        $dt['tgl_selesai_min'] = str_replace("-", "", $dt['tgl_selesai']);
        $dt['wkt_selesai_min'] = $dt['tgl_selesai_min'] . $dt['jam'] . $dt['menit'];
        $dt['id_user'] = substr($data, 22);
        return $dt;
    }

    public function show() {
        $status = $this->M_send_invitation->show_status();
        $status = $this->get_status($status);

        $data = $this->M_send_invitation->show();
        $dt = array();
        foreach ($data as $k => $v) {
            $dt[$k]["ID"] = $k + 1;
            $dt[$k]["NAMA"] = stripslashes($v->NAMA);
            $dt[$k]["ID_VENDOR"] = stripslashes($v->ID_VENDOR);
            $bts = "-";
            if ($v->STATUS < 3) {
                $bts = $v->URL_BATAS_HARI . ' hari';
            }
            $dt[$k]["STATUS"] = "<span class='text-center' title='history'>" . $bts . "</span>";
            $date_exp = $this->get_code($v->URL, $v->URL_BATAS_HARI);
            if ($v->STATUS == 1) {
                $expr = "Not yet Approved";
            } else if ($v->STATUS == 2) {
                $expr = $date_exp['tgl_selesai'] . " (" . $date_exp['pukul'] . ")";
            } else if ($v->STATUS == 3) {
                $expr = "Link Activated";
            } else {
                $expr = "-";
            }
            $dt[$k]["URL"] = $expr;
            $dt[$k]["URL_BATAS_HARI"] =$status[$v->STATUS]['ENG'];
            $btn_edit = "<a class='btn btn-default btn-sm disabled' title='Update' href='javascript:void(0)' onclick='edit_undangan(" . $v->ID . ")'><i class='fa fa-edit'></i></a>";
            $btn_resend = "<a class='btn btn-default btn-sm disabled' title='Kirim ulang' href='javascript:void(0)' onclick='kirim_ulang(" . $v->ID . ")'><i class='fa fa-send'></i></a>";
            $btn_history = "<a class='btn btn-success btn-sm' title='History' href='javascript:void(0)' onclick='tabel_detail(" . $v->ID . ")'><i class='fa fa-clock-o'></i></a>";
            $btn_delete = "<a class='btn btn-danger btn-sm' title='Delete' href='javascript:void(0)' onclick='delete_data(" . $v->ID . ")'><i class='fa fa-trash'></i></a>";
            if ($v->STATUS == 1 || $v->STATUS == 11 ) {
                $btn_edit = "<a class='btn btn-info btn-sm' title='Update' href='javascript:void(0)' onclick='edit_undangan(" . $v->ID . ")'><i class='fa fa-edit'></i></a>";
            }
            if ($v->STATUS == 2 || $v->STATUS == 3) {
                $btn_resend = "<a class='btn btn-primary btn-sm' title='Kirim ulang' href='javascript:void(0)' onclick='kirim_ulang(" . $v->ID . ")'><i class='fa fa-send'></i></a>";
            }
            if($v->STATUS != 1 && $v->STATUS != 11 && $v->STATUS != 12 && $v->STATUS != 13 && $v->STATUS != 14&& $v->STATUS != 15)
            {
                $btn_delete = "<a class='btn btn-default btn-sm disabled' title='Delete' href='javascript:void(0)' onclick='delete_data(" . $v->ID . ")'><i class='fa fa-trash'></i></a>";
            }
            $dt[$k]["AKSI"] = "$btn_edit $btn_history $btn_delete $btn_resend ";
        }

        $return = array(
            'data' => $dt,
        );
        echo json_encode($return);
        //$this->output($dt);
    }

    public function add1() {
        $cek = $this->M_send_invitation->cek("m_vendor", stripslashes($_POST['nama']), stripslashes($_POST['email']));
        if (count($cek) == 0) {
            $data = array(
                'NAMA' => stripslashes($_POST['nama']),
                'ID_VENDOR' => stripslashes($_POST['email']),
                'URL_BATAS_HARI' => stripslashes($_POST['limit']),
                'CREATE_BY' => '1',
                'UPDATE_BY' => '1',
                'STATUS' => '1'
            );
            $this->M_send_invitation->add('m_vendor', $data);

            $data = array(
                'ID_VENDOR' => stripslashes($_POST['email']),
                'STATUS' => '1',
                'CREATE_BY' => '1'
            );
            $this->M_send_invitation->add('log_vendor_acc', $data);
            echo "sukses";
        } else {
            echo "nama_email_digunakan";
        }
    }

    public function add() {
        $email=  stripslashes($this->input->post('email'));
        $nama=  stripslashes($this->input->post('nama'));

        $cek = $this->M_send_invitation->cek('m_vendor',$nama,$email);
        if($cek != false)
            $this->output(array("msg"=>"Data sudah ada"));
        $content = $this->M_send_invitation->get_email_dest();
        $content[0]->ROLES = explode(",", $content[0]->ROLES);
        $res = $this->M_send_invitation->get_user($content[0]->ROLES,count($content[0]->ROLES));
        $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
        $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";
        $data = array(
            'email' => $this->input->post('email'),
            'img1' => $img1,
            'img2' => $img2,
            'nama' => $this->input->post('nama'),
            'hari' => $this->input->post('limit'),
            'title' => $content[0]->TITLE,
            'open' => $content[0]->OPEN_VALUE,
            'close' => $content[0]->CLOSE_VALUE
        );
        foreach ($res as $k => $v) {
            $data['dest'][] = $v->EMAIL;
        }

        if ($this->addsendMail($data)) {
            $rubah_data = array(
                'NAMA' => stripslashes($_POST['nama']),
                'ID_VENDOR' => stripslashes($_POST['email']),
                'URL_BATAS_HARI' => stripslashes($_POST['limit']),
                'CREATE_BY' => '1',
                'UPDATE_BY' => '1',
                'STATUS' => '1'
            );
            $data_update2 = array(
                'ID_VENDOR' => $this->input->post('email'),
                'STATUS' => 1,
                'CREATE_BY' => 1
            );
            $this->M_send_invitation->add('m_vendor', $rubah_data);
            $this->M_send_invitation->add('log_vendor_acc', $data_update2);
            echo json_encode(array("status" => TRUE));
        } else {
            echo json_encode(array("status" => FALSE));
        }
    }

    protected function addsendMail($content) {
        $flag = 0;
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

        if (count($content['dest']) != 0) {
            foreach ($content['dest'] as $k => $v) {
                $this->load->library('email', $config);
                $this->email->initialize($config);
                $this->email->from($mail['email'], '[SYSTEM] EPROC SUPREME ENERGY');
                $this->email->to($v);
                $this->email->subject($content['title']);
                $ctn = ' <p>' . $content['img1'] . '<p>
                        <br>'.$content['open'].'
                        <br>
                        '.$content['close'].'
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

    public function list_tabel_detail($id) {
        $status = $this->M_send_invitation->show_status();
        $owner = $this->M_send_invitation->show_owner();
        $status = $this->get_status($status);
        $owner = $this->get_owner($owner);
        $list = $this->M_send_invitation->show_detail($id);
        $data = array();
        foreach ($list as $k => $v) {
            $data[$k][0] = $k + 1;
            $data[$k][1] = $status[$v->STATUS]['ENG'];
            $data[$k][2] = stripslashes($v->NOTE);
            $data[$k][3] = stripslashes($owner[$v->CREATE_BY]['NAMA']);
            $data[$k][4] = stripslashes($v->CREATE_TIME);
        }
        echo json_encode($data);
    }

    public function show_edit($id) {
        $list = $this->M_send_invitation->show_edit($id);
        $row = array();
        foreach ($list as $k => $log) {
            $row["nama"] = $log->NAMA;
            $row["email"] = $log->ID_VENDOR;
            $row["limit"] = $log->URL_BATAS_HARI;
            $row["id"] = $log->ID;
        }
        echo json_encode($row);
    }

    public function update2($id) {
        $list = $this->M_send_invitation->update2($id);
        foreach ($list as $log) {
            $row = array();
            $row["status"] = $log->STATUS;
//            $row["email"] = $log->ID_VENDOR;
//            $row["limit"] = $log->URL_BATAS_HARI;
            $row["id"] = $log->ID;
        }
        echo json_encode($row);
    }

    public function update_vendor() {
        $id = $this->input->post('id_edit');
        $data_update = array(
            'NAMA' => $this->input->post('nama_vendor_edit'),
            'ID_VENDOR' => $this->input->post('email_edit'),
            'URL_BATAS_HARI' => $this->input->post('limit_edit')
        );
        $ex = $this->M_send_invitation->update('ID', 'm_vendor', $id, $data_update);
        if ($ex) {
            echo json_encode(array("status" => TRUE));
        } else {
            echo json_encode(array("status" => FALSE));
        }
    }

    public function show_email_temp() {
        $id = 1;
        $list = $this->M_send_invitation->show_temp_email($id);
        $row = array();
        $row["title"] = $list->TITLE;
        $row["ckeditor"] = $list->OPEN_VALUE;
        $row["close"] = $list->CLOSE_VALUE;
        echo json_encode($row);
    }

    public function update_email() {
        $id = 1;
        $data_update = array(
            'TITLE' => $this->input->post('title_edit'),
            'OPEN_VALUE' => $this->input->post('ckeditor'),
            'CLOSE_VALUE' => $this->input->post('close_edit'),
            'UPDATE_BY' => '1'
        );
        $ex = $this->M_send_invitation->update('ID', 'm_notic', $id, $data_update);
        if ($ex) {
            echo json_encode(array("status" => TRUE));
        } else {
            echo json_encode(array("status" => FALSE));
        }
    }

    public function resend_undangan($id) {
        $content = $this->M_send_invitation->show_temp_email(2);
        $email = $this->M_send_invitation->get_email($id);
        $nama = $this->M_send_invitation->get_nama($id);
        $hari = $this->M_send_invitation->get_hari($id);
        $pass_random = rand(100000, 999999);
        $pass = stripslashes(str_replace('/','_',crypt($pass_random, mykeyencrypt)));
        date_default_timezone_set("Asia/Jakarta");
        //$bts_hari=$this->M_invite_acc->get_url($id);
        $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
        $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";
        $mini_url = date("HiY") . rand(1000000000, 9999999999) . date("md") . $id;
        $url = "<a href=' " . base_url() . "log_in/index/" . $mini_url . "' class='btn btn-primary btn-lg'>Invitation Link</a>";
        //$mini_url=date("HiY").rand(100000000,999999999).date("md").$id;
        $data = array(
            'email' => $email->ID_VENDOR,
            'img1' => $img1,
            'img2' => $img2,
            'hari' => $hari->URL_BATAS_HARI,
            'nama' => $nama->NAMA,
            'pass' => $pass_random,
            'link' => $url,
            'title' => $content->TITLE,
            'open' => $content->OPEN_VALUE,
            'close' => $content->CLOSE_VALUE
        );
        if ($this->sendMail($data)) {
            $data_update = array(
                'PASSWORD' => $pass,
                'URL' => $mini_url
            );
            $data_update2 = array(
                'ID_VENDOR' => $email->ID_VENDOR,
                'STATUS' => 2,
                'NOTE' => "Kirim ulang undangan",
                'CREATE_BY' => 1
            );
            $this->M_send_invitation->update('ID', 'm_vendor', $id, $data_update);
            $this->M_send_invitation->add('log_vendor_acc', $data_update2);
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
        $this->email->from($mail['email'], '[SYSTEM] EPROC SUPREME ENERGY');
        $this->email->to($content['email']);
        $this->email->subject($content['title']);
        //$this->email->isHTML(true);
        $date_until = date('d F Y', strtotime("+" . $content['hari'] . " days", strtotime(date('Y-m-d'))));
        $ctn = ' <p>' . $content['img1'] . '<p>
                        <p>' . $content['open'] . '<p>
                        <br>
                        <table>
                            <tr>
                                <td>Nama Perusahaan</td>
                                <td>: ' . $content['nama'] . '</td>
                            </tr>
                        </table>
                        <br>
                        <table>
                            <tr>
                                <td>Username</td>
                                <td>: ' . $content['email'] . '</td>
                            </tr>
                            <tr>
                                <td>Password</td>
                                <td>: ' . $content['pass'] . '</td>
                            </tr>
                            <tr>
                                <td>Aktif Sampai</td>
                                <td>:  ' . $date_until . ' (' . date('H:i') . ')</td>
                            </tr>
                            <tr>
                                <td>Link</td>
                                <td>:  ' . $content['link'] . '</td>
                            </tr>
                        </table>
                        <br>

                        <br>
                        <p>Supreme Energy.</p>
                        ';
        $this->email->message($ctn);

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

    public function get($id) {
        echo json_encode($this->M_send_invitation->show2(array("ID" => $id)));
    }

    public function delete_data($id) {
        $email = $this->M_send_invitation->get_email($id);
        $data = array(
            'email' => $email->ID_VENDOR,
        );
        if ($data) {
            $data_update = array(
                'ID_VENDOR' => $email->ID_VENDOR,
                'STATUS' => 0,
                'NOTE' => "Hapus Vendor",
                'CREATE_BY' => 1
            );
            $data_update2 = array(
                'STATUS' => 0,
                'CREATE_BY' => 1
            );
            $this->M_send_invitation->update('ID', 'm_vendor', $id, $data_update2);
            $this->M_send_invitation->add('log_vendor_acc', $data_update);
            echo json_encode(array("status" => TRUE));
        } else {
            echo json_encode(array("status" => FALSE));
        }
    }

}
