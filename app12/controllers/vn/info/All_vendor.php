<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class All_vendor extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('vn/info/M_all_vendor', 'mav');
        $this->load->model('vendor/M_approval', 'map');
        $this->load->database();
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

     public function comment() {
        $type = $this->input->post('type');
        $id=$this->session->ID_VENDOR;
        $q = $this->mav->get_comment($id, $type);
        if($q == false)
            $this->output();
        foreach ($q as $k => $v) {
            if($v->SENDER != $id)
            {
                echo'<div class="chat chat-left">
                    <div class="chat-body">
                        <div class="chat-content" style="margin:0px">
                            <p>'.$v->VALUE.'</p>
                            <br/><p style="font-size: 11px">'.$v->TIME.'</p>
                        </div>
                    </div>
                </div>';
            }
            else
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
        }
        exit;
    }

    public function send()
    {
        $data=array(
          "VALUE"=>stripslashes($this->input->post('msg')),
          "TYPE"=>stripslashes($this->input->post('type')),
          "TIME"=>date('Y-m-d H:i:s'),
          "SENDER"=>$this->session->ID_VENDOR,
          "RECEIVER"=>1,
        );
        $res=$this->mav->add('m_status_vendor_chat',$data);
        $this->output($res);
    }

    public function log_out() {
        $this->session->sess_destroy();
        header('Location:' . base_url());
    }

    public function check_lang_sess() {
        $this->output($_SESSION['lang']);
    }

    public function update_supplier() {
        $id = $this->session->ID;
        $data = array(
            "STATUS" => '21',
            "UPDATE_BY" => $id,
            "UPDATE_TIME" => date('Y-m-d H:i:s')
        );
        $res = $this->mav->update_supplier($data);
        if ($res != false) {
            $this->session->status_vendor = '21';
            $res2 = $this->mav->submit_log('21');
            if ($res2)
                $this->output(array("status" => "success", "msg" => "Please update the Data"));
            else
                $this->output(array("status" => "Error", "msg" => "Oops,Something Wrong"));
        } else {
            $this->output(array("status" => "Error", "msg" => "Oops,Something Wrong"));
        }
    }

    public function update_supplier_new() {
        $id = $this->session->ID;
        $data = array(
           "ID_VENDOR"=>$_SESSION['ID_VENDOR']
        );
        $cek1=$this->mav->check_update($this->session->ID);
        if($cek1)
            $this->mav->remove_vendor_update($this->session->ID);
        $cek=$this->mav->check_vendor_data($this->session->ID_VENDOR);
        if($cek != false)
        {
            $dt=array(
              "STATUS" => '0'
            );
            $this->mav->remove_vendor_data($this->session->ID_VENDOR,$dt);
        }
        $res = $this->mav->update_supplier_new($data);
        if ($res != false) {
            $this->session->status_vendor = '21';
            $res2 = $this->mav->submit_log('21');
            if ($res2)
                $this->output(array("status" => "success", "msg" => "Please update the Data"));
            else
                $this->output(array("status" => "Error", "msg" => "Oops,Something Wrong"));
        } else {
            $this->output(array("status" => "Error", "msg" => "Oops,Something wrong"));
        }
    }

    public function set_sess() {
        $this->session->lang = $_POST['lang'];
    }

    public function get_reject() {
        // $stat=$this->session->status_vendor;
        // if ($stat == "12"||$stat == "13"||$stat == "14"||$stat == "15") {
            $src =1;
            $stat=$this->mav->get_module();
            if($stat[0]->module == 2)
                $src = 2;
            $res = $this->mav->get_reject($src);
            $temp = array();
            foreach ($res as $k => $v) {
                if ($v == 1)
                    $temp["deact"][] = $k;
                else if ($v == 0)
                    $temp["act"][] = $k;
            }
            $this->output($temp);
            // echo json_encode($temp);
        // } else
            // $this->output(false);
    }

    public function check_vendor() {
        $res = $this->mav->check_vendor($this->session->ID);
        if ($res[0]->STATUS == 5 || $res[0]->STATUS == 6 || $res[0]->STATUS == 22 || $res[0]->STATUS == 23 || $res[0]->STATUS == 7)
            $this->output(true);
        else
            $this->output(false);
    }

    public function check_send() {
        $res=$this->mav->check_gns();
        $extnd=0;
        $all = 13;
        if(strpos(strtolower(' '.$res[0]->CLASSIFICATION),"barang")!= false)
            $extnd++;
        if(strpos(strtolower(' '.$res[0]->CLASSIFICATION),"jasa")!= false)
            $extnd++;
        if(strpos(strtolower(' '.$res[0]->CLASSIFICATION),"konsultan")!= false)
            $extnd++;
        if($res[0]->RISK == 0)
            $all-=1;

        $total = $_POST['total'];
        $total_check_mandatory = $_POST['total_check_mandatory'];
        $all+=$extnd;
        if ($total != $total_check_mandatory)
            $this->output(array("status" => "failed", "msg" => "Data Not Completed, Please fill all required data", "total", $total."=".$extnd." - ".$total_check_mandatory));
        else
            $this->output(array("status" => "success", "msg" => "Processing Data..."));
    }

    public function check_status() {
        $val = $this->mav->get_status();
        $stat = $val[0]->STATUS;
        if ($this->session->status_vendor != $stat)
            $this->session->status_vendor = $stat;
        if ($stat == "5" ||  $stat == "22")
            $this->output(array("status" => true, "msg" => ""));
        else if ($stat == "6")
            $this->output(array("status" => true, "msg" => "app", "slka" => false));
        else if ($stat == "7" || $stat == "23")
            $this->output(array("status" => true, "msg" => "app", "slka" => true));
        else if ($stat == "21")
            $this->output(array("status" => true, "msg" => "app", "slka" => true, "update" => true));
        else if ($stat == "15" || $stat == "14"||$stat == "13" || $stat == "12")
            $this->output(array("status" => true, "msg" => "rej"));
        else
            $this->output(array("status" => false, "msg" => false));
    }

    public function check_status_new()
    {
        $val = $this->mav->get_status();
        $stat = $val[0]->STATUS;
        // echopre($stat);
        if ($this->session->status_vendor != $stat)
            $this->session->status_vendor = $stat;
        $res=$this->mav->get_status_new();
        if($res[0]['wait']==1)
        {
            if($res[0]['reject']==1)
                $this->output(array("status" => true, "msg" => "rej"));
            // else if($res[0]['edits']==1 && $res[0]['extra']==0)
            //     $this->output(array("status" => true, "msg" => ""));
            else if($res[0]['extra']==1)
                $this->output(array("status" => false, "msg" => false));
            else
                $this->output(array("status" => true, "msg" => "app", "slka" => false));
        }
        else{
            if($res[0]['finish']==1)
                $this->output(array("status" => true, "msg" => "app", "slka" => true));
        }
        // $edit_stat=$res[0]['edit_content'];

        // $desc=$res[0]['description'];

        // if(strpos(strtolower(' '.$desc.' '),"rej"))
        //     $this->output(array("status" => true, "msg" => "rej"));
        // if(strpos(strtolower(' '.$desc.' '),"fin"))
        //     $this->output(array("status" => true, "msg" => "app", "slka" => true));
        // if(strpos(strtolower(' '.$desc.' '),"max"))
        //     $this->output(array("status" => true, "msg" => "app", "slka" => false));
        // if($edit_stat == 1)
        //     $this->output(array("status" => true, "msg" => ""));
        // else
        //     $this->output(array("status" => false, "msg" => false));
    }

    public function submit_data() {
        if ($_POST['API'] = "insert") {
            $email_temp = 4;
            $log = 5;
            $open = null;

            $data = array(
                "STATUS" => $log,
                "UPDATE_BY" => $this->session->ID,
                "UPDATE_TIME" => date('Y-m-d H:i:s')
            );

            $content = $this->mav->get_email_dest($email_temp);
            $content[0]->ROLES = explode(",", $content[0]->ROLES);
            $user = $this->mav->get_user($content[0]->ROLES, count($content[0]->ROLES));
            $res = $this->mav->submit_data($data);
            if ($res && $user) {
                $this->mav->submit_log($log);
                date_default_timezone_set("Asia/Jakarta");
                $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
                $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";

                $open = str_replace("name_vendor", $this->session->ID_VENDOR, $content[0]->OPEN_VALUE);

                $data = array(
                    'img1' => $img1,
                    'img2' => $img2,
                    'title' => $content[0]->TITLE,
                    'open' => $open,
                    'close' => $content[0]->CLOSE_VALUE
                );
                foreach ($user as $k => $v) {
                    $data['dest'][] = $v->EMAIL;
                }
                if ($this->sendMail($data)) {
                    $this->session->status_vendor = "5";
                }
                $this->output(array("status" => "success", "msg" => "Data sending successfully"));
            } else
                $this->output(array("status" => "failed", "msg" => "Data sending failed"));
        }
        else {
            $this->output(array("status" => "failed", "msg" => "Oops, Something wrong"));
        }
    }

    public function update_data() {
        if ($_POST['API'] = "update") {
            $stat=$this->session->status_vendor;
            $email_temp = 9;
            if($stat == 12 || $stat == 13)
            {
                $email_temp = 4;
                $status = "5";
            }
            else{
                $email_temp = 9;
                $status = "22";
            }
            $content = $this->mav->get_email_dest($email_temp);
            $content[0]->ROLES = explode(",", $content[0]->ROLES);
            $user = $this->mav->get_user($content[0]->ROLES, count($content[0]->ROLES));
            $cek=$this->mav->check_vendor_data($this->session->ID_VENDOR);
            if($cek != false)
            {
                $data=array(
                  "STATUS" => '0'
                );
                $this->mav->remove_vendor_data($this->session->ID_VENDOR,$data);
            }
            $tgl=date('Y-m-d H:i:s');

            $data = array(
                "STATUS" => $status,
                "UPDATE_BY" => $this->session->ID,
                "UPDATE_TIME" => $tgl
            );
            $res = $this->mav->update_data($data);
            if ($res && $user) {
                $this->mav->submit_log($status);
                date_default_timezone_set("Asia/Jakarta");
                $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
                $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";
                $open=null;
                if($status == 22)
                {
                    $open = str_replace("Nama_supplier", $this->session->ID_VENDOR, $content[0]->OPEN_VALUE);
                    $open = str_replace("tanggal_update",$tgl, $open);
                }
                else
                    $open = str_replace("name_vendor", $this->session->ID_VENDOR, $content[0]->OPEN_VALUE);
                $data = array(
                    'img1' => $img1,
                    'img2' => $img2,
                    'title' => $content[0]->TITLE,
                    'open' => $open,
                    'close' => $content[0]->CLOSE_VALUE
                );

                foreach ($user as $k => $v) {
                    $data['dest'][] = $v->EMAIL;
                }

                if ($this->sendMail($data)) {
                    $this->session->status_vendor = $status;
                }
                $this->output(array("status" => "success", "msg" => "Data sending successfully"));
            } else
                $this->output(array("status" => "failed", "msg" => "Data sending failed"));
        }
        else {
            $this->output(array("status" => "failed", "msg" => "Oops, Something Wrong"));
        }
    }

    public function submit_data_new() {
        if ($_POST['API'] = "insert") {
            $id=0;
            $seq = 0;
            $supp = $_SESSION['ID'];
            $res=$this->mav->get_fulldt($supp);
            if(count($res)>0)
            {
                $id=$res[0]->id;
                $seq=$res[0]->sequence;
            }

            $log = 5;
            $open = null;

            $upd = array(
                'extra_case'=>'0',
                'status_approve' =>'0',
                'updatedate' => date('Y-m-d H:i:s'),
            );

            $content = $this->mav->get_dest($id,$supp,$seq);
            $upd['seq_now']=$upd['seq_strt']=$seq;

            $res = $this->mav->upd('t_approval_supplier',$upd,$supp,0,0);

            if ($res && count($content)>0) {
                $this->mav->submit_log($log);
                date_default_timezone_set("Asia/Jakarta");
                $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
                $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";
                $var_link = "<br><br>Klik link berikut untuk memproses <a href='" . base_url() . "log_in/in' class='btn btn-primary btn-lg'>Link Portal</a><br><br>";
                $open = str_replace("_var1_", $this->session->NAME, $content[0]['OPEN_VALUE'].$var_link);

                $data = array(
                    'img1' => $img1,
                    'img2' => $img2,
                    'title' => $content[0]['TITLE'],
                    'open' => $open,
                    'close' => $content[0]['CLOSE_VALUE']
                );
                foreach ($content as $k => $v) {

                  $data['dest'][] = $content[$k]['email'];
                  // echopre($v['email']);
                  // echopre($content[$k]['email']);
                }
                if ($this->sendMail($data)) {
                    $this->session->status_vendor = "5";
                }
                $this->output(array("status" => "success", "msg" => "Data sending successfully"));
            } else
                $this->output(array("status" => "failed", "msg" => "Data sending failed"));
        }
        else {
            $this->output(array("status" => "failed", "msg" => "Oops, Something Wrong"));
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

        if (count($content['dest']) != 0) {
            foreach ($content['dest'] as $k => $v) {
                $ctn = ' <p>' . $content['img1'] . '<p>
                        <br>' . $content['open'] . '
                        <br>
                        ' . $content['close'] . '
                        <br>
                        ';
                $this->load->library('email', $config);
                $this->email->initialize($config);
                $this->email->from($mail['email'], '[SYSTEM] EPROC SUPREME ENERGY');
                $this->email->to($v);
                $this->email->subject($content['title']);
                $this->email->message($ctn);
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

    public function get_list_rejected() {
        // $qry = $this->mav->get_list_rejected();
        $res=$this->mav->check_gns();
        $total = 0;
        $dt=array();

        $tot_un_apv = 0;
        $total = 0;
        $val_btn = 0;
        $id_vendor = $this->session->ID_VENDOR;
        $get_idv = $this->db->query("select ID FROM m_vendor WHERE ID_VENDOR = '".$id_vendor."' ");
        $qry_chk = $this->mav->get_list_rejected($get_idv->row()->ID);
        // $res = $this->mav->check_gns();
        $header = $this->mav->get_header();
        $arr_head = array();
        $chk = $qry_chk->result_array();
        // $total = 0;
        $total_checklist = 0;
        $no = 1;
        $flag = 0;
        $split = explode(",", $res[0]->CLASSIFICATION);



        echo'
        <input style="display : none;" value="' . $tot_un_apv . '" name="tot_un_apv" id="tot_un_apv">
        <input style="display : none;" value="' . $total . '" name="tot_none" id="tot_none">
        <input style="display : none;" value="' . $val_btn . '" name="validate_btn" id="validate_btn">
        <table class="table table-striped table-bordered table-hover display" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>' . lang('Deskripsi', 'Description') . '</th>
                <th><span>Status</span></th>
                <th>' . lang('Verifikasi', 'Check') . '</th>
                <th>' . lang('Comment', 'Comment') . '</th>
            </tr>
        </thead>
        <tbody>';
        foreach ($header as $key => $value) {

          echo '<tr>
                   <td colspan="6" class="text-centered"><h5><b>'.$value['code'].'. '.$value['description'].'</b></h5></td>
               </tr>';

               foreach ($chk as $i => $arr) {
                 if ($value['description'] == $arr['description']) {

                   if ($arr['TOTAL'] > 0) {
                     $status = '<a href="#"><i class="fa fa-check text-navy"></i></a>';
                     $comment = '';
                     if ($arr['ismandatory'] == 1) {
                       $total_checklist+= 1;
                     }
                   } else {
                     $status = '<a href="#"><i class="fa fa-times text-danger"></i></a>';
                     $comment = '<a onclick="comment(\''.$arr['LEGAL_DATA'].'\')" class="btn btn-sm btn-primary white"><i class="fa fa-envelope"></i></a>';
                   }


                   $total += $arr['ismandatory'];
                   // $total_checklist += $arr['TOTAL'];

                   $tbody = '<tr>
                   <td>' . $no++ . '.</td>
                   <td>' . $arr['DESC_ENG'] . '</td>
                   <td>' . $arr['STATUS'] . '</td>
                   <td>' . $status . '</td>
                   <td>' . $comment . '</td>
                   </tr>';


                   if($arr["DESC_ENG"] === "Goods" ) {
                       if(in_array('Penyedia Barang', $split, true)){
                         echo $tbody;
                       } else {

                       }
                   }
                   else if($arr["DESC_ENG"] === "Services") {
                       if(in_array('Jasa Pemborongan', $split, true)){
                         echo $tbody;
                       } elseif (in_array('Penyedia Jasa', $split, true)) {
                         echo $tbody;
                       } else {

                       }
                   }
                   else if($arr['DESC_ENG'] === "Consultant Service") {
                       if(in_array('Konsultan', $split, true)){
                         echo $tbody;
                       } else {

                       }
                   } else {
                     echo $tbody;
                     // echo $res[0]->CLASSIFICATION;
                   }
                   // echo $tbody;
                 }
               }
        }

        echo '<tr style="display:none"><td style="display:none"><input id="total_wajib" value=' . $total . '><input id="total_check_mandatory" value=' . $total_checklist . '></tr></td>';
        echo '</tbody></table>';
        exit;
    }

//     public function get_list_rejected() {
//         $qry = $this->mav->get_list_rejected();
//         $res=$this->mav->check_gns();
//         $total = 0;
//         $dt=array();
//         foreach ($qry as $k => $v) {
//             if ($v == 1) {
//                 $dt[$k] = '<a href="#"><i class="fa fa-check text-navy"></i></a>';
//                 $dt['cmnt'][$k]="";
// //                $dt['cmnt'][$k]= '<a onclick="comment('.$k.')" class="btn btn-sm btn-primary white"><i class="fa fa-envelope"></i></a>';
//             } else {
//                 $dt[$k] = '<a href="#"><i class="fa fa-times text-danger"></i></a>';
//                 $dt['cmnt'][$k] = '<a onclick="comment(\''.$k.'\')" class="btn btn-sm btn-primary white"><i class="fa fa-envelope"></i></a>';
//                 $total++;
//             }
//         }
//         echo '
//                             <input style="display:none" value="' . $total . '" name"total">
//                             <table class="table table-striped table-bordered table-hover display" width="100%">
//                                 <thead>
//                                     <tr>
//                                         <th>#</th>
//                                         <th>' . lang('Deskripsi', 'Description') . '</th>
//                                         <th><span>Status</span></th>
//                                         <th>' . lang('Verifikasi', 'Check') . '</th>
//                                         <th>' . lang('Komentar', 'Comment') . '</th>
//                                     </tr>
//                                 </thead>
//                                 <tbody>
//                                     <tr>
//                                         <td colspan="5" class="text-centered"><b>A. General Information</b></td>
//                                     </tr>
//                                     <tr>
//                                         <td>1.</td>
//                                         <td>General Information</td>
//                                         <td>' . lang('Wajib', 'Required') . '</td>
//                                         <td>' . $dt['GENERAL1'] . '</td>
//                                         <td>' . $dt['cmnt']['GENERAL1'] . '</td>
//                                     </tr>
//                                     <tr>
//                                         <td>2.</td>
//                                         <td>Company Address</td>
//                                         <td>' . lang('Wajib', 'Required') . '</td>
//                                         <td>' . $dt['GENERAL2'] . '</td>
//                                         <td>' . $dt['cmnt']['GENERAL2'] . '</td>
//                                     </tr>
//                                     <tr>
//                                         <td>3.</td>
//                                         <td>Company Contact</td>
//                                         <td>' . lang('Wajib', 'Required') . '</td>
//                                         <td>' . $dt['GENERAL3'] . '</td>
//                                         <td>' . $dt['cmnt']['GENERAL3'] . '</td>
//                                     </tr>
//                                     <tr>
//                                         <td colspan="5" class="text-centered"><b>B. Legal Data</b></td>
//                                     </tr>
//                                     <tr>
//                                         <td>1.</td>
//                                         <td>Deed</td>
//                                         <td>' . lang('Wajib', 'Required') . '</td>
//                                         <td>' . $dt['LEGAL1'] . '</td>
//                                         <td>' . $dt['cmnt']['LEGAL1'] . '</td>
//                                     </tr>
//                                     <tr>
//                                         <td>2.</td>
//                                         <td>Bussiness License</td>
//                                         <td>' . lang('Wajib', 'Required') . '</td>
//                                         <td>' . $dt['LEGAL2'] . '</td>
//                                         <td>' . $dt['cmnt']['LEGAL2'] . '</td>
//                                     </tr>
//                                     <tr>
//                                         <td>3.</td>
//                                         <td>TDP</td>
//                                         <td>' . lang('Wajib', 'Required') . '</td>
//                                         <td>' . $dt['LEGAL3'] . '</td>
//                                         <td>' . $dt['cmnt']['LEGAL3'] . '</td>
//                                     </tr>
//                                     <tr>
//                                         <td>4.</td>
//                                         <td>NPWP</td>
//                                         <td>' . lang('Wajib', 'Required') . '</td>
//                                         <td>' . $dt['LEGAL4'] . '</td>
//                                         <td>' . $dt['cmnt']['LEGAL4'] . '</td>
//                                     </tr>
//                                     <tr>
//                                         <td>5.</td>
//                                         <td>SKT EBTKE</td>
//                                         <td>' . lang('Kondisional', 'Optional') . '</td>
//                                         <td>' . $dt['LEGAL5'] . '</td>
//                                         <td>' . $dt['cmnt']['LEGAL5'] . '</td>
//                                     </tr>
//                                     <tr>
//                                         <td>6.</td>
//                                         <td>SKT MIGAS (Oil & Geo Thermal)</td>
//                                         <td>' . lang('Kondisional', 'Optional') . '</td>
//                                         <td>' . $dt['LEGAL6'] . '</td>
//                                         <td>' . $dt['cmnt']['LEGAL6'] . '</td>
//                                     </tr>
//                                     <tr>
//                                         <td colspan="5" class="text-centered"><b>C. Goods & Services</b></td>
//                                     </tr>
//                                     <tr>
//                                         <td>1.</td>
//                                         <td>Agency Sertification & Principal</td>
//                                         <td>' . lang('Kondisional', 'Optional') . '</td>
//                                         <td>' . $dt['GNS1'] . '</td>
//                                         <td>' . $dt['cmnt']['GNS1'] . '</td>
//                                     </tr>';
//                                     if(strpos(strtolower($res[0]->CLASSIFICATION),"barang")!==false)
//                                     {
//                                         echo'<tr>
//                                             <td>2.</td>
//                                             <td>Goods</td>
//                                             <td>' . lang('Wajib', 'Required') . '</td>
//                                             <td>' . $dt['GNS2'] . '</td>
//                                             <td>' . $dt['cmnt']['GNS2'] . '</td>
//                                         </tr>';
//                                     }
//                                     else
//                                         $total--;
//                                     if(strpos(strtolower($res[0]->CLASSIFICATION),"jasa")!==false)
//                                     {
//                                         echo'<tr>
//                                             <td>3.</td>
//                                             <td>Services</td>
//                                             <td>' . lang('Wajib', 'Required') . '</td>
//                                             <td>' . $dt['GNS3'] . '</td>
//                                             <td>' . $dt['cmnt']['GNS3'] . '</td>
//                                         </tr>';
//                                     }
//                                     else
//                                         $total--;
//                                     if(strpos(strtolower($res[0]->CLASSIFICATION),"konsul")!==false)
//                                     {
//                                         echo'<tr>
//                                             <td>3.</td>
//                                             <td>Services</td>
//                                             <td>' . lang('Wajib', 'Required') . '</td>
//                                             <td>' . $dt['GNS3'] . '</td>
//                                             <td>' . $dt['cmnt']['GNS4'] . '</td>
//                                         </tr>';
//                                     }
//                                     else
//                                         $total--;
//                                     echo'<tr>
//                                         <td colspan="5" class="text-centered"><b>D. Bank & Finance</b></td>
//                                     </tr>
//                                     <tr>
//                                         <td>1.</td>
//                                         <td>Bank Account</td>
//                                         <td>' . lang('Wajib', 'Required') . '</td>
//                                         <td>' . $dt['BNF1'] . '</td>
//                                         <td>' . $dt['cmnt']['BNF1'] . '</td>
//                                     </tr>
//                                     <tr>
//                                         <td>2.</td>
//                                         <td>Balance Sheet</td>
//                                         <td>' . lang('Wajib', 'Required') . '</td>
//                                         <td>' . $dt['BNF2'] . '</td>
//                                         <td>' . $dt['cmnt']['BNF2'] . '</td>
//                                     </tr>
//                                     <tr>
//                                         <td colspan="5" class="text-centered"><b>E. Company Mangement</b></td>
//                                     </tr>
//                                     <tr>
//                                         <td>1.</td>
//                                         <td>Board of Director</td>
//                                         <td>' . lang('Wajib', 'Required') . '</td>
//                                         <td>' . $dt['MANAGEMENT1'] . '</td>
//                                         <td>' . $dt['cmnt']['MANAGEMENT1'] . '</td>
//                                     </tr>
//                                     <tr>
//                                         <td>2.</td>
//                                         <td>Shareholders</td>
//                                         <td>' . lang('Kondisinoal', 'Optional') . '</td>
//                                         <td>' . $dt['MANAGEMENT2'] . '</td>
//                                         <td>' . $dt['cmnt']['MANAGEMENT2'] . '</td>
//                                     </tr>
//                                     <tr>
//                                         <td colspan="5" class="text-centered"><b>F. Certification & Experience</b></td>
//                                     </tr>
//                                     <tr>
//                                         <td>1.</td>
//                                         <td>General Certification</td>
//                                         <td>' . lang('Kondisional', 'Optional') . '</td>
//                                         <td>' . $dt['CNE1'] . '</td>
//                                         <td>' . $dt['cmnt']['CNE1'] . '</td>
//                                     </tr>
//                                     <tr>
//                                         <td>2.</td>
//                                         <td>Experience</td>
//                                         <td>' . lang('Kondisinoal', 'Optional') . '</td>
//                                         <td>' . $dt['CNE2'] . '</td>
//                                         <td>' . $dt['cmnt']['CNE2'] . '</td>
//                                     </tr>
//                                     <tr>
//                                         <td colspan="5" class="text-centered"><b>G. Contractor SHE Mangement System (CSMS)</b></td>
//                                     </tr>
//                                     <tr>
//                                         <td>1.</td>
//                                         <td>CSMS</td>
//                                         <td>' . lang('Wajib', 'Required') . '</td>
//                                         <td>' . $dt['CSMS'] . '</td>
//                                         <td>' . $dt['cmnt']['CSMS'] . '</td>
//                                     </tr>
//                                     <tr style="display:none"><td style="display:none"><button id="total_wajib" value=' . $total . '></button></tr></td>
//                                 </tbody>
//                             </table>';
//     }

    public function get_checklist() {
        $qry_chk = $this->mav->get_checklist($this->session->ID);
        $res = $this->mav->check_gns();
        $header = $this->mav->get_header();
        $arr_head = array();
        $chk = $qry_chk->result_array();
        $total = 0;
        $total_checklist = 0;
        $no = 1;
        $flag = 0;
        $split = explode(",", $res[0]->CLASSIFICATION);
        echo'
        <thead>
            <tr>
                <th style="width:5%;">No</th>
                <th>' . lang('Deskripsi', 'Description') . '</th>
                <th><span>Status</span></th>
                <th>' . lang('Verifikasi', 'Check') . '</th>
            </tr>
        </thead>
        <tbody>';
        foreach ($header as $key => $value) {
          echo '<tr>
                   <td colspan="5" class="text-centered"><b>'.$value['code'].'. '.$value['description'].'</b></td>
               </tr>';

               foreach ($chk as $arr) {
                 if ($value['description'] == $arr['description']) {

                   if ($arr['TOTAL'] > 0) {
                     $status = '<a href="#"><i class="fa fa-check text-navy"></i></a>';
                     if ($arr['ismandatory'] == 1) {
                       $total_checklist+= 1;
                     }
                   } else {
                     $status = '<a href="#"><i class="fa fa-times text-danger"></i></a>';
                   }


                   $total += $arr['ismandatory'];
                   // $total_checklist += $arr['TOTAL'];

                   $tbody = '<tr>
                   <td>' . $no++ . '.</td>
                   <td>' . $arr['DESC_ENG'] . '</td>
                   <td>' . $arr['STATUS'] . '</td>
                   <td>' . $status . '</td>
                   <input type="hidden" class="'.$arr['divname'].'" value="'.$arr['TOTAL'].'">
                   </tr>';


                   /*if($arr["DESC_ENG"] === "Goods" ) {
                       if(in_array('Penyedia Barang', $split, true)){
                         echo $tbody;
                       } else {

                       }
                   }
                   else if($arr["DESC_ENG"] === "Services") {
                       if(in_array('Jasa Pemborongan', $split, true)){
                         echo $tbody;
                       } elseif (in_array('Penyedia Jasa', $split, true)) {
                         echo $tbody;
                       } else {

                       }
                   }
                   else if($arr['DESC_ENG'] === "Consultant Service") {
                       if(in_array('Konsultan', $split, true)){
                         echo $tbody;
                       } else {

                       }
                   } else {
                     echo $tbody;
                     // echo $res[0]->CLASSIFICATION;
                   }*/
                   echo $tbody;
                 }
               }
          // echo $value['code'].' - '.$value['description'];
        }

        echo '<tr style="display:none"><td style="display:none"><input id="total_wajib" value=' . $total . '><input id="total_check_mandatory" value=' . $total_checklist . '></tr></td>';
        // echo '<tr style=""><td style=""><input id="" value=' . $total . '><input id="total_check_mandatory" value=' . $total_checklist . '></tr></td>';
        echo '</tbody>';
        exit;
    }

    public function get_status_vendor() {
        $id = $this->input->post("param1");
        $qry_chk = $this->mav->get_checklist($id);
        $res = $this->mav->check_gns();
        $header = $this->mav->get_header();
        $arr_head = array();
        $chk = $qry_chk->result_array();
        $total = 0;
        $total_checklist = 0;
        $no = 1;
        $flag = 0;
        // $split = explode(",", $res[0]->CLASSIFICATION);

        $dt_array = array();
        foreach ($header as $key => $value) {

               foreach ($chk as $arr) {
                 if ($value['description'] == $arr['description']) {

                   if ($arr['TOTAL'] > 0) {
                     $status = '<a href="#"><i class="fa fa-check text-navy"></i></a>';
                     if ($arr['ismandatory'] == 1) {
                       $total_checklist+= 1;
                     }
                   } else {
                     $status = '<a href="#"><i class="fa fa-times text-danger"></i></a>';
                   }
                   $total += $arr['ismandatory'];
                 }
                 $dt_array[] = array(
                   $arr['divname'] => $arr['TOTAL'],
                 );
               }
               break;
        }

        echo json_encode($dt_array);;

    }



    // public function get_checklist() {
    //     $qry = $this->mav->get_checklist();
    //     $res=$this->mav->check_gns();
    //     $head = array(
    //         'A' => 'A. General Data',
    //         'B' => 'B. Legal Data',
    //         'C' => 'C. Goods & Services',
    //         'D' => 'D. Bank & Finance',
    //         'E' => 'E. Company Mangement',
    //         'F' => 'F. Certification & Experience',
    //         'G' => 'G. Contractor SHE Mangement System (CSMS)'
    //     );
    //     echo'
    //     <thead>
    //         <tr>
    //             <th>No</th>
    //             <th>' . lang('Deskripsi', 'Description') . '</th>
    //             <th><span>Status</span></th>
    //             <th>' . lang('Verifikasi', 'Check') . '</th>
    //         </tr>
    //     </thead>
    //     <tbody>';
    //     $awal = "";
    //     $cnt = 1;
    //     $total = 0;
    //     $flag=0;
    //     $tamp=$qry->result_array();
    //     $risk=0;
    //     foreach ($tamp as $row) {
    //         if($awal == 'A' && $row['DESC_IND']=='Info Perusahaan')
    //         {
    //             if($row['RISKS']==1)
    //                 $risk=1;
    //         }
    //         if ($awal != $row['HEAD']) {
    //             echo'
    //             <tr>
    //                 <td colspan="5" class="text-centered"><b>' . $head[$row['HEAD']] . '</b></td>
    //             </tr>';
    //             $awal = $row['HEAD'];
    //             $cnt = 1;
    //         }
    //         if(strpos(' '.$row["DESC_IND"],"Barang") != false )
    //         {
    //             if(strpos(strtolower(' '.$res[0]->CLASSIFICATION),"barang")== false)
    //                 $flag=1;
    //             else
    //                 $flag=0;
    //         }
    //         else if(strpos(' '.$row["DESC_IND"],"Jasa") != false)
    //         {
    //             if(strpos(strtolower(' '.$res[0]->CLASSIFICATION),"jasa")==false)
    //                 $flag=1;
    //             else
    //                 $flag=0;
    //         }
    //         else if(strpos(' '.$row['DESC_IND'],"Konsul")!= false)
    //         {
    //             if(strpos(strtolower(' '.$res[0]->CLASSIFICATION),"konsul")== false)
    //                 $flag=1;
    //             else
    //                 $flag=0;
    //         }
    //         else
    //             $flag=0;
    //
    //         if($flag==0)
    //         {
    //             $stat=$row["STATUS"];
    //             if($risk== 0 && $row['HEAD'] == 'G')
    //                 $stat='OPTIONAL';
    //             echo'<tr>
    //                 <td>' . $cnt . '.</td>
    //                 <td>' . lang($row["DESC_IND"], $row["DESC_ENG"]) . '</td>
    //                 <td>' . $stat . '</td>';
    //             if ($row["TOTAL"] > 0) {
    //                 echo '<td><a href="#"><i class="fa fa-check text-navy"></i></a></td>';
    //             if ($stat == "REQUIRED")
    //                 $total++;
    //             } else
    //                 echo '<td><a href="#"><i class="fa fa-times text-danger"></i></a></td>';
    //             echo '</tr>';
    //             $cnt++;
    //         }
    //     }
    //     echo '<tr style="display:none"><td style="display:none"><button id="total_wajib" value=' . $total . '></button></tr></td>';
    //     echo '</tbody>';
    //     exit;
    // }
}

?>
