<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Invite_acc extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('vendor/M_invite_acc')->model('vendor/M_vendor')->model('vendor/M_send_invitation');
        $this->load->model('vendor/m_all_intern', 'mai');
    }

    public function index() {
        $cek = $this->mai->cek_session();
        $temp = $this->M_invite_acc->show();
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
        $this->template->display('vendor/V_invite_acc', $data);
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function filter_data() {
        $res = $this->M_invite_acc->filter_data($_POST);
        $dt = array();
        if ($res != null) {
            foreach ($res as $k => $v) {
                $dt[$k][0] = $k + 1;
                $dt[$k][1] = stripslashes($v->NAMA);
                $dt[$k][2] = stripslashes($v->ID_VENDOR);
                $dt[$k][3] = "<span class='text-center' title='history'>" . $v->URL_BATAS_HARI . ' day' . "</span>";
                //$dt[$k][4] = $v->STATUS;
                $checkbox = "<a class='btn btn-info btn-sm' title='Approve & Send Email' href='javascript:void(0)' onclick='kirim(" . $v->ID . ")'><i class='fa fa-send'></i></a>";
                $dt[$k][4] = "$checkbox";
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

    public function show() {
        $status = $this->M_send_invitation->show_status();
        $owner = $this->M_send_invitation->show_owner();
        $status = $this->get_status($status);
        $owner = $this->get_owner($owner);
        $data = $this->M_invite_acc->show();

        $dt = array();
         foreach ($data as $k => $v) {
            $dt[$k]["NO"] = $k + 1;
            $dt[$k]["NAMA"] = stripslashes($v->NAMA);
            $dt[$k]["EMAIL"] =  stripslashes($v->ID_VENDOR);
            $dt[$k]["URL_BATAS_HARI"] = "<span class='text-center' title='history'>" . $v->URL_BATAS_HARI . ' hari' . "</span>";
            $dt[$k]["CREATE_BY"] = stripslashes($owner[$v->CREATE_BY]['NAMA']);
            $dt[$k]["CREATE_TIME"] = stripslashes($v->CREATE_TIME);
            $dt[$k]["STATUS"] = $status[$v->STATUS]['ENG'];
            $dt[$k]["AKSI"] = "<a class='btn btn-primary btn-sm' title='Approve & Send Email' href='javascript:void(0)' onclick='accept(" . $v->ID . ")'><i class='fa fa-check'></i></a>"
                    . " <a class='btn btn-danger btn-sm' title='Reject' href='javascript:void(0)' onclick='reject(" . $v->ID . ")'><i class='fa fa-ban'></i></a>";
        }
        $return = array(
            'data' => $dt,
        );
        echo json_encode($return);
    }

    function show_detail($id) {
        $list = $this->M_send_invitation->show_detail($id);
        foreach ($list as $log) {
            $row = array();
            $row["nama"] = $log->NAMA;
            $row["status"] = $log->STATUS;
            $row["note"] = $log->NOTE;
            $row["create_by"] = $log->CREATE_BY;
            $row["create_time"] = $log->CREATE_TIME;
        }
        echo json_encode($row);
    }

    public function list_tabel_detail($id) {
        $list = $this->M_invite_acc->show_detail($id);
        $data = array();
        foreach ($list as $k => $v) {
            $data[$k][0] = $k + 1;
            $data[$k][1] = stripslashes($v->NAMA);
            $data[$k][2] = stripslashes($v->ID_VENDOR);
            $data[$k][3] = stripslashes($v->STATUS);
            $data[$k][4] = stripslashes($v->NOTE);
            $data[$k][5] = stripslashes($v->CREATE_BY);
            $data[$k][6] = stripslashes($v->CREATE_TIME);
        }
        echo json_encode($data);
    }

    public function show_update($id) {
        $list = $this->M_invite_acc->show_update($id);
        foreach ($list as $log) {
            $row = array();
            $row["url"] = $log->URL_BATAS_HARI;
            $row["nama"] = $log->NAMA;
            $row["email"] = $log->ID_VENDOR;
            $row["id"] = $log->ID;
        }
        echo json_encode($row);
    }

    public function show_email_temp() {
        $id = 1;
        $list = $this->M_invite_acc->show_temp_email($id);
        $row = array();
        $row["title"] = $list->TITLE;
        $row["open"] = $list->OPEN_VALUE;
        $row["close"] = $list->CLOSE_VALUE;
        echo json_encode($row);
    }

    public function update_vendor_kirim_email() {
        $id = $this->input->post('id_data');
        $content = $this->M_invite_acc->show_temp_email(2);
        $pass_random = rand(100000, 999999);
        $pass = stripslashes(str_replace('/','_',crypt($pass_random, mykeyencrypt)));
        date_default_timezone_set("Asia/Jakarta");
        //$bts_hari=$this->M_invite_acc->get_url($id);
        $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
        $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";
        $mini_url = date("HiY") . rand(100000, 999999) . date("md") . $id;
        $url = "<a href='http:" . base_url() . "log_in/index/" . $mini_url . "'>Invitation Link</a>";
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
                'STATUS' => 2,
                'PASSWORD' => $pass,
                'URL' => $mini_url
            );
            $data_update2 = array(
                'ID_VENDOR' => $this->input->post('email_id'),
                'STATUS' => 2,
                'NOTE' => $this->input->post('note'),
                'CREATE_BY' => 1
            );
            $this->M_invite_acc->update('ID', 'm_vendor', $id, $rubah_data);
            $this->M_invite_acc->add('log_vendor_acc', $data_update2);
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
        $email = $this->input->post('email_edit');
        if ($this->rejekMail($email)) {
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
            $this->M_send_invitation->update('ID', 'm_vendor', $id, $data_update2);
            $this->M_send_invitation->add('log_vendor_acc', $data_update);
            echo json_encode(array("status" => TRUE));
        } else {
            echo json_encode(array("status" => FALSE));
        }
    }

    protected function rejekMail($id) {
        $flag=0;
        $data=array();
        $content = $this->M_invite_acc->get_email_dest();
        $content[0]->ROLES = explode(",", $content[0]->ROLES);
        $res = $this->M_invite_acc->get_user($content[0]->ROLES, count($content[0]->ROLES));

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
        $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
        $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";
        foreach ($res as $k => $v) {
                $data['dest'][] = $v->EMAIL;
        }

        if (count($data['dest']) != 0) {
            foreach ($data['dest'] as $k => $v) {
                $this->load->library('email', $config);
                $this->email->initialize($config);
                $this->email->from($mail['email'], '[SYSTEM] EPROC SUPREME ENERGY');
                $this->email->subject($content[0]->TITLE);
                $ctn =' <p>' . $img1 . '<p>
                        <br>'.str_replace("nama_supplier",$id, $content[0]->OPEN_VALUE).'
                        <br>
                        '.$content[0]->CLOSE_VALUE.'
                        <br>
                        <center><p>' . $img2 . '<p><center>';
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

    public function add() {
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

}
