<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Invitation extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('vendor/M_invitation')->model('vendor/M_vendor');
        $this->db = $this->load->database('default', true);
        $this->load->model('vendor/m_all_intern', 'mai');
        $this->load->helper('html');
        $this->load->helper('helperx_helper');
        $this->load->helper('global_helper');
    }

    public function index() {
        $cek = $this->mai->cek_session();
        $temp = $this->M_invitation->show();
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
        $this->template->display('vendor/V_invitation', $data);
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function filter_data() {
        $res = $this->M_invitation->filter_data($_POST);
        $status = $this->M_invitation->show_status();
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
            $dat[$v->ID_USER]['NAMA'] = $v->NAME;
        }
        return $dat;
    }

    public function get_code($data, $exp) {
        $dt['jam'] = substr($data, 0, 2);
        $dt['menit'] = substr($data, 2, 2);
        $dt['tahun'] = substr($data, 4, 4);
        $dt['bulan'] = substr($data, 17, 2);
        $dt['tgl'] = substr($data, 19, 2);
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
        $status = $this->M_invitation->show_status();
        // $status = $this->get_status($status);

        $data = $this->M_invitation->show();
        $dt = array();
        foreach ($data as $k => $v) {
          if ($v['FILE'] != '') {
            $attch_file = '<a href="'.base_url("upload/LEGAL_DATA/").$v['FILE'].'" target="_blank" class="btn btn-primary btn-sm" title="View File" ><i class="fa fa-file"></i></a>';
          } else {
            $attch_file = '-';
          }
            $dt_note = $this->M_invitation->show_log_vendor_acc($v['ID_VENDOR']);
            // echopre($dt_note->NOTE);
            $dt[$k]["ID"] = $k + 1;
            $dt[$k]["NAMA"] = stripslashes($v['NAMA']);
            $dt[$k]["ID_VENDOR"] = stripslashes($v['ID_VENDOR']);
            $bts = "-";
            //if ($v['sequence'] < 3) {
                $bts = $v['URL_BATAS_HARI'] . ' hari';
            //}
            // $dt[$k]["STATUS"] = "<span class='text-center' title='history'>" . $bts . "</span>";
            $date_exp = $this->get_code($v['URL'], $v['URL_BATAS_HARI']);
            // echopre('hello'.$v['URL']);
            if ($v['sequence'] <= 3) {
                $expr = "";
                $send_date = "";
            } else if ($v['sequence'] == 4 && $v['extra_case']==1) {
                $expr = dateToIndo($date_exp['tgl_selesai'], false, false).' '.$date_exp['pukul'];
                $send_date = dateToIndo($date_exp['tgl_mulai'], false, false).' '.$date_exp['pukul'];
            } else if ($v['sequence'] == 4 && $v['extra_case']==0) {
                $expr = "Link Activated";
                $send_date = dateToIndo($date_exp['tgl_mulai'], false, false).' '.$date_exp['pukul'];
            } else {
                $expr = $date_exp['tgl_selesai'] . " " . $date_exp['pukul'];
                $send_date = dateToIndo($date_exp['tgl_mulai'], false, false).' '.$date_exp['pukul'];
            }
            $dt[$k]["URL"] = $expr;
            $dt[$k]["URL_BATAS_HARI"] = $v['STATUS'];
            $dt[$k]["SEND_DATE"] = $send_date;
            $dt[$k]["ATTACHMENT"] = '<center>'.$attch_file.'</center>';
            $dt[$k]["CATATAN"] = $dt_note['NOTE'];
            $btn_edit = "<a class='btn btn-warning btn-sm disabled' title='Update' href='javascript:void(0)' onclick='edit_undangan(" . $v['ID'] . ")'>Edit</a>";
            $btn_resend = "<a class='btn btn-primary btn-sm disabled' title='Resend' href='javascript:void(0)' onclick='kirim_ulang(" . $v['ID'] . ")'>Resend</a>";
            $btn_history = "<a class='btn btn-info btn-sm' title='History' href='javascript:void(0)' onclick='tabel_detail(" . $v['ID'] . ")'>History</a>";
            $btn_delete = "<a class='btn btn-danger btn-sm' title='Delete' href='javascript:void(0)' onclick='delete_data(" . $v['ID'] . ")'>Delete</a>";
            if ($v['sequence'] == 1||$v['status_approve']==2||$v['sequence'] == 2) {
                $btn_edit = "<a class='btn btn-warning btn-sm' title='Update' href='javascript:void(0)' onclick='edit_undangan(" . $v['ID'] . ")'>Edit</a>";
            }
            if ($v['sequence'] == 4) {
                $btn_resend = "<a class='btn btn-primary btn-sm' title='Kirim ulang' href='javascript:void(0)' onclick='kirim_ulang(" . $v['ID'] . ")'>Resend</a>";
            }
            if($v['sequence'] > 2 || ($v['status_approve']!=2 && $v['status_approve'] != 0))
            {
                $btn_delete = "<a class='btn btn-danger btn-sm disabled' title='Delete' href='javascript:void(0)' onclick='delete_data(" . $v['ID'] . ")'>Delete</a>";
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
        $cek = $this->M_invitation->cek("m_vendor", stripslashes($_POST['nama']), stripslashes($_POST['email']));
        if (count($cek) == 0) {
            $data = array(
                'NAMA' => stripslashes($_POST['nama']),
                'ID_VENDOR' => stripslashes($_POST['email']),
                'URL_BATAS_HARI' => stripslashes($_POST['limit']),
                'CREATE_BY' => '1',
                'UPDATE_BY' => '1',
                'STATUS' => '1'
            );
            $this->M_invitation->add('m_vendor', $data);

            $data = array(
                'ID_VENDOR' => stripslashes($_POST['email']),
                'STATUS' => '1',
                'CREATE_BY' => '1'
            );
            $this->M_invitation->add('log_vendor_acc', $data);
            echo "sukses";
        } else {
            echo "nama_email_digunakan";
        }
    }

    public function add() {
        $email=  stripslashes($this->input->post('email'));
        $nama=  stripslashes($this->input->post('nama'));
        $risk=0;
        $path_file = "upload/LEGAL_DATA/";
        $attch = $_FILES["attachment"];

        if(isset($_POST['risk']))
            $risk = stripslashes($this->input->post('risk'));

        $cek = $this->M_invitation->cek('m_vendor',$nama,$email);
        if($cek != false)
            $this->output(array("msg"=>"Data sudah ada"));
        $content = $this->M_invitation->get_email_dest();
        $roles = $this->M_invitation->get_rule_approval();
        $content[0]->ROLES = explode(",", $roles[0]->user_roles);
        $res = $this->M_invitation->get_user($content[0]->ROLES,count($content[0]->ROLES));
        $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
        $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";
        $var_link = "<br><br>Klik link berikut untuk memproses <a href='" . base_url() . "log_in/in' class='btn btn-primary btn-lg'>Link Portal</a><br><br>";
        $data = array(
            'email' => $this->input->post('email'),
            'img1' => $img1,
            'img2' => $img2,
            'nama' => $this->input->post('nama'),
            'hari' => $this->input->post('limit'),
            'title' => $content[0]->TITLE,
            'open' => str_replace('_var1_',$this->input->post('nama'), $content[0]->OPEN_VALUE.$var_link),
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
                'STATUS' => '1',
                'RISK' => $risk
            );

            if ($attch['error'] != 4 && $attch['tmp_name'] !== '') {
                $attch_res = file_uploads($attch["tmp_name"], $attch["name"], $attch["type"], $attch["size"], $path_file, $path_file);
                $rubah_data["FILE"] = $attch_res;
            }

            $data_update2 = array(
                'ID_VENDOR' => $this->input->post('email'),
                'STATUS' => 1,
                'CREATE_BY' => $_SESSION['ID_USER'],
                'TYPE'=>"SUP",
                "NOTE"=>stripslashes($this->input->post('note'))
            );
            $this->M_invitation->add_data('m_vendor', $rubah_data);
            $this->M_invitation->add($rubah_data);
            $this->M_invitation->add_data('log_vendor_acc', $data_update2);
            echo json_encode(array("status" => TRUE));
        } else {
            echo json_encode(array("status" => FALSE));
        }
    }

    protected function addsendMail($content) {
        $flag = 0;
        $mail = get_mail();
        $config = array();

        $mail = get_mail();
        $config = array();
        $config['protocol'] = $mail['protocol'];
        $config['smtp_crypto'] = $mail['crypto'];
        if($mail['protocol'] == 'smtp'){
            $config['smtp_pass'] = $mail['password'];
        }

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
                $ctn =' <p>' . $content['img1'] . '<p>
                        <br>'.$content['open'].'
                        <br>
                        '.$content['close'].'
                        <br>
                        ';
                $this->email->to($v);

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
        $status = $this->M_invitation->show_status();
        $owner = $this->M_invitation->show_owner();
        $status = $this->get_status($status);
        $owner = $this->get_owner($owner);
        $list = $this->M_invitation->show_detail($id);
        $data = array();
        foreach ($list as $k => $v) {
            $data[$k][0] = $k + 1;
            $data[$k][1] = $status[$v->STATUS]['ENG'];
            $data[$k][2] = stripslashes($v->NOTE);
            $data[$k][3] = stripslashes($owner[$v->CREATE_BY]['NAMA']);
            $data[$k][4] = dateToIndo(stripslashes($v->CREATE_TIME));
        }
        echo json_encode($data);
    }

    public function show_edit($id) {
        $list = $this->M_invitation->show_edit($id);
        $row = array();
        foreach ($list as $k => $log) {
            $dt_note = $this->M_invitation->show_log_vendor_acc($log->ID_VENDOR);
            $row["nama"] = $log->NAMA;
            $row["email"] = $log->ID_VENDOR;
            $row["limit"] = $log->URL_BATAS_HARI;
            $row["id"] = $log->ID;
            $row["risk"] = $log->RISK;
            $row["file"] = $log->FILE;
            $row["note"] = $dt_note['NOTE'];
        }
        echo json_encode($row);
    }

    public function update2($id) {
        $list = $this->M_invitation->update2($id);
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
        $note = $this->input->post('note_edit');
        $path_file = "upload/LEGAL_DATA/";
        $attch = $_FILES["attachment_edit"];

        $data_update = array(
            'NAMA' => $this->input->post('nama_vendor_edit'),
            'ID_VENDOR' => $this->input->post('email_edit'),
            'URL_BATAS_HARI' => $this->input->post('limit_edit'),
            'RISK' => $this->input->post('risk_edit'),
        );

        if ($attch['error'] != 4 && $attch['tmp_name'] !== '') {
            $attch_res = file_uploads($attch["tmp_name"], $attch["name"], $attch["type"], $attch["size"], $path_file, $path_file);
            $data_update["FILE"] = $attch_res;
        }

        $ex = $this->M_invitation->update('ID', 'm_vendor', $id, $data_update);
        $update_note = $this->db->query("update log_vendor_acc SET NOTE = '".$note."' WHERE ID_VENDOR = '".$this->input->post('email_edit')."' ");

        $get_id = $this->db->query("select ID, ID_VENDOR from m_vendor WHERE ID_VENDOR = '".$this->input->post('email_edit')."' ");
        $update_approval1 = $this->db->query("update t_approval_supplier SET status_approve = '1' WHERE supplier_id = '".$get_id->row()->ID."' AND sequence = '1' ");
        $update_approval2 = $this->db->query("update t_approval_supplier SET status_approve = '0' WHERE supplier_id = '".$get_id->row()->ID."' AND sequence > '1' ");
        if ($ex) {
          $content = $this->M_invitation->get_email_dest();
          $roles = $this->M_invitation->get_rule_approval();
          $content[0]->ROLES = explode(",", $roles[0]->user_roles);
          $res = $this->M_invitation->get_user($content[0]->ROLES,count($content[0]->ROLES));
          $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
          $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";
          $var_link = "<br><br>Klik link berikut untuk memproses <a href='" . base_url() . "log_in/in' class='btn btn-primary btn-lg'>Link Portal</a><br><br>";
          $data = array(
              'email' => $this->input->post('email_edit'),
              'img1' => $img1,
              'img2' => $img2,
              'nama' => $this->input->post('nama_vendor_edit'),
              'hari' => $this->input->post('limit_edit'),
              'title' => $content[0]->TITLE,
              'open' => str_replace('_var1_',$this->input->post('nama_vendor_edit'), $content[0]->OPEN_VALUE.$var_link),
              'close' => $content[0]->CLOSE_VALUE
          );
          foreach ($res as $k => $v) {
              $data['dest'][] = $v->EMAIL;
          }
          $this->addsendMail($data);
            echo json_encode(array("status" => true));
        } else {
            echo json_encode(array("status" => FALSE));
        }
    }

    public function show_email_temp() {
        $id = 1;
        $list = $this->M_invitation->show_temp_email($id);
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
        $ex = $this->M_invitation->update('ID', 'm_notic', $id, $data_update);
        if ($ex) {
            echo json_encode(array("status" => TRUE));
        } else {
            echo json_encode(array("status" => FALSE));
        }
    }

    public function resend_undangan($id) {
        $content = $this->M_invitation->show_temp_email(2);
        $email = $this->M_invitation->get_email($id);
        $nama = $this->M_invitation->get_nama($id);
        $hari = $this->M_invitation->get_hari($id);
        $pass_random = rand(100000, 999999);
        $pass = stripslashes(str_replace('/','_',crypt($pass_random, mykeyencrypt)));
        date_default_timezone_set("Asia/Jakarta");
        //$bts_hari=$this->M_invite_acc->get_url($id);
        $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
        $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";
        $mini_url = date("HiY") . rand(10000000, 99999999) . date("md") . $id;
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
                'TYPE' => 'SUP',
                'CREATE_BY' => 1
            );
            $this->M_invitation->update('ID', 'm_vendor', $id, $data_update);
            $this->M_invitation->add_data('log_vendor_acc', $data_update2);
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
        //$this->db->insert('i_notification',$data_email);
        if ($this->db->insert('i_notification',$data_email)) {
            return true;
        } else {
            return false;
        }
    }

    public function get($id) {
        echo json_encode($this->M_invitation->show2(array("ID" => $id)));
    }

    public function delete_data($id) {
        $email = $this->M_invitation->get_email($id);
        $data = array(
            'email' => $email->ID_VENDOR,
        );
        if ($data) {
            $data_update = array(
                'ID_VENDOR' => $email->ID_VENDOR,
                'STATUS' => 0,
                'NOTE' => "Hapus Vendor",
                'CREATE_BY' => $_SESSION['ID_USER'],
                "TYPE"=>"SUP"
            );
            $data_update2 = array(
                'STATUS' => 0,
                'CREATE_BY' => $_SESSION['ID_USER']
            );
            // $res=$this->M_invitation->update('ID', 'm_vendor', $id, $data_update2);
            $this->db->delete('m_vendor', array('ID' => $id));
            $res=$this->M_invitation->add_data('log_vendor_acc', $data_update);
            if($res)
                echo json_encode(array("status" => TRUE));
            else
                echo json_encode(array("status" => FALSE));
        } else {
            echo json_encode(array("status" => FALSE));
        }
    }

}
