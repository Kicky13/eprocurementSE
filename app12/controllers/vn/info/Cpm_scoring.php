<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cpm_scoring extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('session');        
        $this->load->model('vn/info/M_cpm_scoring', 'mcs');
        $this->load->model('vn/info/M_vn', 'mvn');
        $this->load->model('vn/info/M_all_vendor', 'mav');    
    }
    
    public function index() {        
        $get_menu = $this->mvn->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['DESKRIPSI_IND'] = $v->DESCRIPTION_IND;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['DESKRIPSI_ENG'] = $v->DESCRIPTION_ENG;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['ICON'] = $v->ICON;
        }
        $data['menu'] = $dt;        
        $this->template->display_vendor('vn/info/V_cpm_scoring', $data);        
    }
/* ===========================================-------- API START------- ====================================== */
    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function send() {
        $res = $this->process();
        if ($res !== false) {
            $po = $this->input->post("po");
            $phase = $this->input->post("phase");

            $res = $this->mcs->send_data($po, $phase);
            $data_log = array(
                "ID_VENDOR" => $_SESSION['ID'],
                "STATUS" => '1',
                "CREATE_TIME" => date('Y-m-d H:i:s'),
                "CREATE_BY" => $_SESSION['ID'],
                "TYPE" => "CPM",
                "NOTE" => stripslashes($_POST['note'])
            );

            if ($res != false) {
                $res = $this->mcs->update_data($po, $phase);
                $log = $this->mcs->add('log_vendor_acc', $data_log);

                $dest = $this->mcs->get_email_dest($po, $_SESSION['ID'], $phase);
                if ($dest != false) {
                    $rec = $dest[0]['recipients'];
                    $rec_role = $dest[0]['rec_role'];
                    $user = $this->mcs->get_email_rec($rec, $rec_role);
                    $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
                    $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";
                    $dt = array(
                        'dest' => $user,
                        'img1' => $img1,
                        'po' => $po,
                        'img2' => $img2,
                        'title' => $dest[0]['TITLE'],
                        'open' => $dest[0]['OPEN_VALUE'],
                        'close' => $dest[0]['CLOSE_VALUE']
                    );
                    $email = $this->send_mail($dt);
                    if ($email == false)
                        $this->output(array('status' => 'Failed', 'msg' => 'Oops, something went wrong!'));
                }
            }
        }
        if ($res != false)
            $this->output(array('status' => 'Success', 'msg' => 'Data has been submitted!'));
        else
            $this->output(array('status' => 'Failed', 'msg' => 'Oops, something went wrong!'));
    }

    protected function send_mail($content) {
        $mail = get_mail();
        $config = array();
        $config['protocol'] = "mail";
        $config['smtp_timeout'] = "5";
        $config['smtp_crypto'] = '';
        $config['mailtype'] = "html";
        $config['smtp_host'] = $mail['smtp'];
        $config['smtp_port'] = $mail['port'];
        $config['smtp_user'] = $mail['email'];
        //$config['smtp_pass'] = $mail['password'];
        $config['charset'] = "utf-8";
        $config['newline'] = "\r\n";
        $flag = 0;

        if (count($content['dest']) != 0 ) {
            foreach ($content['dest'] as $k => $v) {
                $this->load->library('email', $config);
                $this->email->initialize($config);
                $this->email->from($mail['email'], '[SYSTEM] EPROC SUPREME ENERGY');
                $this->email->subject($content['title']);
                $ctn = ' <p>' . $content['img1'] . '</p>
                        <br>' . $open = str_replace("no_po", $content['po'],$content['open']) . '
                        <br>
                        ' . $content['close'] . '
                        <br>
                        <center><p></p><center>';
                //$this->email->message();
                $data_email['recipient'] = $v->email;
                $data_email['subject'] = $content['title'];
                $data_email['content'] = $ctn;
                $data_email['ismailed'] = 0;

                //$this->email->to($v->email);
                if ($this->db->insert('i_notification', $data_email)) {
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

    public function draft() {
        $res = $this->process();
        if ($res != false)
            $this->output(array("status" => "Success", "msg" => "Data has been saved!"));
        else
            $this->output(array("status" => "Failed", "msg" => "Oops, something went wrong!"));
    }
    
    public function calc($id) {
        $id = (int) $id;
        $val = (int) $this->input->post('val');
        $po = $this->input->post('po');
        $res = $this->mcs->get_weight_input_data($id, $val, $po);
        if ($res == false) {
            $this->output(array("status" => "Failed", "msg" => "Oops, something went wrong!"));
        } else {
            $this->output($res);
        }
    }
 
    public function process() {
        $dt = array();
        $res = false;
        $cnt = 0;
        $po = $this->input->post("po");
        $phase = $this->input->post("phase");
        $check = $this->mcs->check($po,$phase);
        $tamp = 0;
        $cntTamp = 0;
        $flag = 0;
        foreach ($_POST as $k => $v) {
            if ($k != 'po' && $k != 'phase' && $k != 'note') {
                if ($flag == 0)
                    $cnt = 0;
                $flag = 1;
                $dlm = strpos($k, "_");
                $id = substr($k, 0, $dlm);
                $sel = substr($k, $dlm+1, strlen($k));
                if ($tamp == $id)
                    $cnt = $cntTamp;
                $dt[$cnt]['cpm_detail_id'] = $id;

                if ($sel == '0')
                    $dt[$cnt]['actual_score'] = $v;
                else if ($sel == '1')
                    $dt[$cnt]['actual_weight'] = $v;
                else if ($sel == 'r')
                    $dt[$cnt]['remarks'] = $v;
                if ($check[0]['total'] == 0) {
                    $dt[$cnt]["cpm_id"] = $check[0]['id'];
                    $dt[$cnt]["phase_id"] = $phase;
                    $dt[$cnt]["createby"] = $_SESSION['ID'];
                    $dt[$cnt]["createdate"] = date('Y-m-d H:i:s');
                }
                $tamp = $id;
                $cntTamp = $cnt;
            }
            $cnt++;
        }
        if ($check[0]['total'] == 0) {
            // $data = array(
            //     "cpm_id" => $check[0]['id'],
            //     "phase_id" => $phase,
            //     "createby" => $_SESSION['ID'],
            //     "createdate" => date('Y-m-d H:i:s')
            // );
            // $res = $this->mcs->add("t_cpm_detail_phase",$data);
            // if ($res == false)
            //     return $res;
            $res = $this->mcs->save_draft($dt);
        } 
        else
            $res = $this->mcs->update_draft($dt,$check[0]['id'],$phase);
        return $res;
    }

/* ===========================================       Add data START     ====================================== */
    public function get_list() {
        $res = $this->mcs->get_list();
        $dt = array();
        if (count($res) > 0) {
            foreach($res as $k => $v) {
                $dt[$k][0] = $k+1;
                $dt[$k][1] = $v['po_no'];
                $dt[$k][2] = $v['title'];
                $dt[$k][3] = $v['company'];
                $dt[$k][4] = $v['phase'];
                $dt[$k][5] = date('j F Y', strtotime($v['due_date']));
                $dt[$k][6] = $v['status'];
                $dt[$k][7] = "<button class='btn btn-sm btn-success' onclick='process(\"".$v['po_no']."\",".$v['id'].")'>Detail</button>";
            }
        }
        return $this->output($dt);
    }

    public function get_cpm_detail()
    {
        $po=$this->input->post('po');
        $phase=$this->input->post('phase');
        $vendor=$_SESSION['ID'];
        $res=$this->mcs->get_cpm_detail($po,$vendor,$phase);
        if($res != false)
            return $this->output($res);
        return $this->output();        
    }

    public function get_upload($po) {
        $dt = array();
        $res = $this->mcs->get_upload($po);
        if ($res != false) {
            $count = 1;
            foreach($res as $k => $v) {
                $dt[$k][0] = $count;
                $dt[$k][1] = ucwords($v['type']);
                $dt[$k][2] = $v['file_name'];
                $dt[$k][3] = $v['createdate'];
                $dt[$k][4] = "<span class='badge badge-pill badge-success'>".$v['name']."</span>";
                $dt[$k][5] = "<button class='btn btn-sm btn-primary' onclick=preview('".$v['path']."')><i class='fa fa-file'></i></button>";
                $count++;
            }
            return $this->output($dt);
        }
        else
            $this->output();
    }
}