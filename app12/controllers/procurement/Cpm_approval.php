<?php
class Cpm_approval extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('procurement/M_cpm_approval', 'mca');
        $this->load->model('vendor/M_vendor');
        $this->load->model('vendor/M_all_intern', 'mai');
        $this->load->model('vendor/M_approval', 'map');
        $this->load->model('procurement/M_cpm_development', 'mcd');
    }

    public function index() {
        $cek = $this->mai->cek_session();
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;

        $res=$this->mcd->get_category();
        if($res != false)
            $data['option']=$res;
        $dept=$this->mcd->get_data_user("ID_DEPARTMENT,DEPARTMENT_DESC","m_departement");
        if($dept != false)
            $data['dept']=$dept;
        $roles=$this->mcd->get_data_user("DESCRIPTION,ID_USER_ROLES","m_user_roles");
        if($dept != false)
            $data['roles']=$roles;
        $this->template->display('procurement/V_cpm_approval', $data);
    }
/* ===========================================-------- API START------- ====================================== */
    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function set_approval()
    {
        $data=array(
            "po_no"=>stripslashes($this->input->post('po')),
            "vendor_id"=>stripslashes($this->input->post('vendor')),
            "user_roles"=>stripslashes($this->input->post('roles')),
            "user_id"=>stripslashes($this->input->post('user')),
            "type"=>0,
            "status_approve"=>0,
            "reject_step"=>1,
            "edit_content"=>0,
            "extra_case"=>0,
            "email_approve"=>28,
            "email_reject"=>29,
            "phase_id"=>stripslashes($this->input->post('phase')),
            "status"=>0,
            "create_date"=>date("Y-m-d H:i:s")
        );
        $ch=$this->mca->check_seq($data);
        if($ch != false)
            $data['sequence']=$ch[0]['sequence'];
        $res=$this->mca->set_approval($data);

        if($res != false)
            return $this->output(array("msg"=>"Data has been submitted!", "status"=>"Success"));
        else
            return $this->output(array("msg"=>"Oops, something went wrong!","status"=>"Failed"));
    }

    public function send_email()
    {
        $po=$this->input->post('po');
        $vendor=$this->input->post('vendor');
        $phase=$this->input->post('phase');
        $content=$this->mca->get_email_dt($vendor,$po,$phase);

        if($content != false)
        {
            $open=$content[0]->OPEN_VALUE;
            $open=str_replace("_po_",''.$po.'',$open);
            $open=str_replace("_fase_",''.$content[0]->phase.'',$open);
            $open=str_replace("_tgl_",''.$content[0]->due_date.'',$open);
            $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
            $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";
            $data = array(
                'dest' => $content[0]->email,
                'img1' => $img1,
                'img2' => $img2,
                'title' => $content[0]->TITLE,
                'open' => $open,
                'close' => $content[0]->CLOSE_VALUE
            );

            if($this->addsendMail($data))
            {
                $dt=array(
                    "status_delivered"=>1
                );
                $res=$this->mca->update_dt('t_cpm_phase_notif',$dt,$phase);
                if($res)
                    $this->output(array("status"=>"Success", "msg"=>"Notification sent!"));
                else
                    $this->output(array("status"=>"Failed", "msg"=>"Oops, something went wrong!"));
            }
            else
                $this->output(array("status"=>"Failed", "msg"=>"Oops, something went wrong!"));
        }
        else
            $this->output(array("status"=>"Failed", "msg"=>"Oops, something went wrong!"));
    }

    protected function addsendMail($content) {
        $flag = false;
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
        $this->email->subject($content['title']);
        $ctn =' <p>' . $content['img1'] . '<p>
                <br>'.$content['open'].'
                <br>
                '.$content['close'].'
                <br>
                ';

        $data_email['recipient'] = $content['dest'];
        $data_email['subject'] = $content['title'];
        $data_email['content'] = $ctn;
        $data_email['ismailed'] = 0;

        if ($this->db->insert('i_notification',$data_email)) {
            $flag = true;
        } else {
            $flag = false;
        }
        return $flag;
    }

    public function send_kpi() {
        $cnt = 0;
        $phase = $_POST['phase'];
        foreach ($_POST as $k => $v) {
            if($k != 'po' && $k != 'phase' && $k != 'idS' && $k != 'extra' && $k != 'idT' && $k != 'seq') {
                $dlm = strpos($k, "_");
                $sel = substr($k, 0, $dlm);
                $id = substr($k, $dlm + 1, strlen($k));
                $dt[$cnt]['cpm_detail_id'] = $id;

                if ($sel == '1')
                    $dt[$cnt]['adjust_score'] = $v;
                else if ($sel == '2')
                    $dt[$cnt]['adjust_weight'] = $v;
                else if ($sel == '3')
                    $dt[$cnt]['remarks'] = $v;
            }
            $cnt++;
        }
        $res = $this->mca->save_kpi($dt, $phase);
        if($res != false)
            $this->change_btn(1);
        else
            $this->output(array("status"=>"Failed", "msg"=>"Oops, something went wrong!"));
    }

    public function change_btn($sel) {
        $data = array(
            "po" => stripslashes($this->input->post('po')),
            "sequence" => stripslashes($this->input->post('seq')),
            "tid" => stripslashes($this->input->post('idT')),
            "updatedate" => date("Y-m-d H:i:s"),
            "supplier_id" => stripslashes($this->input->post('idS')),
            "extra_case" => stripslashes($this->input->post('extra')),
            "phase_id" => stripslashes($this->input->post('phase')),
            'note' => $this->input->post('note')
        );

        // $log = array(
        //     "TYPE" => "CPM",
        //     "ID_VENDOR" => $this->input->post('idS'),
        //     "STATUS" => $this->input->post('seq'),
        //     "CREATE_TIME" => date('Y-m-d H:i:s'),
        //     "CREATE_BY" => $_SESSION['ID_USER'],
        // );

        // if (isset($_POST['note']))
        //     $log["NOTE"]=stripslashes($_POST['note']);

        $log = array(
            "module_kode" => "cpm_" . stripslashes($this->input->post('phase')),
            "data_id" => $this->input->post('po'),
            "description" => ($sel == 1 ? 'Approved by ' . $_SESSION['NAME'] : 'Rejected by ' . $_SESSION['NAME']),
            "keterangan" => stripslashes($this->input->post('note')),
            "created_at" => date('Y-m-d H:i:s'),
            "created_by" => $_SESSION['ID_USER'],
        );

        $res = $this->mca->get_email_dest($data['tid'], $data,$sel);
        if ($res != false) {
            $rec = $res[0]['recipients'];
            $rec_role = $res[0]['rec_role'];
            $user = $this->mca->get_email_rec($rec, $rec_role);
            $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
            $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";
            $dt = array(
                'dest' => $user,
                'img1' => $img1,
                'po' => stripslashes($this->input->post('po')),
                'img2' => $img2,
                'title' => $res[0]['TITLE'],
                'open' => $res[0]['OPEN_VALUE'],
                'close' => $res[0]['CLOSE_VALUE']
            );
            if($user != null) {
                 $email = $this->sendMail($dt);
                 if ($email == false)
                     $this->output(array('status' => 'Failed', 'msg' => 'Oops, something went wrong!'));
            }
        }
        $res = $this->mca->approve_reject($data, $sel);
        // $log = $this->map->add('log_vendor_acc', $log);
        $log = $this->map->add('log_history', $log);
        if ($res != false && $log != false) {
            if ($sel == 1) {
                $this->output(array('status' => 'Success', 'msg' => 'Approval has been submitted!'));
            } else {
                $this->output(array('status' => 'Success', 'msg' => 'Rejection has been submitted!'));
            }
        } else {
            $this->output(array('status' => 'Failed', 'msg' => 'Oops, something went wrong!'));
        }
    }
/* ===========================================-------- get data START------- ====================================== */

    public function get_status()
    {
        $data=array(
            "vendorid"=>$this->input->post("idvendor"),
            "po"=>$this->input->post('po'),
            "sequence"=>$this->input->post('seq')
        );
        $res=$this->mca->get_status($data);
        $dt=array(
            "max"=>0,
            "edit"=>0,
            "extra"=>0
        );

        if($res[0]->max == 1)
            $dt['max']=1;
        if($res[0]->edit_content==1)
            $dt['edit']=1;
        if($res[0]->extra_case==1)
            $dt['extra']=1;
        return $this->output($dt);
    }

    public function get_plan() {
        $po = stripslashes($this->input->post('po'));
        $phase = stripslashes($this->input->post('phase'));
        $res = $this->mca->get_plan($po, $phase);
        $c = 1;
        if (count($res) > 0) {
            $tamp = 1;
            foreach ($res as $k => $v) {
                if ($v->id != $tamp) {
                    $diff = date_diff(date_create($v->due_date), date_create(date("Y-m-d")));
                    if ($v->due_date >= date("Y-m-d")) {
                        $due = "<td>".$diff->format("%a")." Days</td>";
                    } else {
                        $due = "<td style='color: red;'>Over ".$diff->format("%a")." Days</td>";
                    }
                    echo "<tr>
                        <td>" . $c . "</td>
                        <td> Phase " . $v->phase . "</td>
                        <td>" . $v->location . "</td>
                        <td>" . date('j F Y', strtotime($v->due_date)) . "</td>"
                        .$due.
                        "<td><span class='badge badge-pill badge-success'>Open</span></td>
                    </tr>";
                    $tamp = $v->id;
                    $c++;
                }
            }
            exit;
        }
        $this->output(array('status' => 'Failed', 'msg' => 'Oops, something went wrong!'));
    }

    public function calculate($id) {
        $id = (int) $id;
        $val = (int) $this->input->post('val');
        $po = $this->input->post('po');
        $res = $this->mca->get_weight_input_data($id, $val, $po);
        if ($res == false) {
            $this->output(array("status" => "Failed", "msg" => "Oops, something went wrong!"));
        } else {
            $this->output($res);
        }
    }

    public function get_schedule() {
        $po = stripslashes($this->input->post('po'));
        $phase = stripslashes($this->input->post('phase'));
        $res = $this->mca->get_plan($po, $phase);
        if (count($res) > 0) {
            $c = 1;
            foreach ($res as $k => $v) {
                $date1 = date_create($v->due_date);
                $date2 = date_create($v->notif);
                $diff = date_diff($date1, $date2);
                echo '<tr>
                    <td>' . $c . '</td>
                    <td>Phase ' . $v->phase . '</td>
                    <td>' . $diff->format("%a") . ' days before due date</td>
                    <td>' . date('j F Y', strtotime($v->notif)) . '</td>
                    <td>' . ($v->status_delivered == 0 ? 'Not Yet Sent' : 'Sent') . '</td>
                    <td><button onclick="send_notif(' . $v->id_notif . ')" class="btn btn-sm btn-primary">
                        ' . ($_SESSION['lang'] == 'IND' ? 'Kirim Notifikasi' : 'Send Notification') . '
                    </button></td>
                </tr>';
                $c++;
            }
            exit;
        }
        $this->output(array('status' => 'Failed', 'msg' => 'Oops, something went wrong!'));
    }

    protected function sendMail($content) {
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
        $flag=0;

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

    public function get_upload($po) {
        $dt = array();
        $res = $this->mca->get_upload($po);
        if ($res != false) {
            $count = 1;
            foreach($res as $k => $v) {
                $dt[$k][0] = $count;
                $dt[$k][1] = ucwords($v['type']);
                $dt[$k][2] = $v['file_name'];
                $dt[$k][3] = date('M j, Y H:i', strtotime($v['createdate']));
                $dt[$k][4] = "<span class='badge badge-pill badge-success'>".$v['name']."</span>";
                $dt[$k][5] = "<button class='btn btn-sm btn-primary' onclick=preview('".$v['path']."')><i class='fa fa-file'></i></button>";
                $count++;
            }
            return $this->output($dt);
        }
        else
            $this->output();
    }

    public function get_user()
    {
        $po=$this->input->post("po");
        $vendor=$this->input->post("vendor");
        $res=$this->mca->get_user_appr($po,$vendor);

        if($res != false)
            return $this->output($res);
        else
            return $this->output(array("msg"=>"Oops, something went wrong!", "status"=>"Failed"));
    }

    public function get_cpm_detail()
    {
        $po=$this->input->post('po');
        $phase=$this->input->post('phase');
        $vendor=$this->input->post('vendor');
        $res=$this->mca->get_cpm_detail($po,$vendor,$phase);
        if($res != false)
            return $this->output($res);
        return $this->output();
    }

    public function get_header() {
        $po = $this->input->post('po');
        $vendor = $this->input->post('vendor');
        $res = $this->mca->get_header($po, $vendor);
        if ($res) {
            $res[0]->delivery_date = date('j F Y', strtotime($res[0]->delivery_date));
        }
        return $this->output($res);
    }

    public function get_list() {
        $dt = array();
        $res = $this->mca->get_list();
        if (count($res)>0) {
            foreach ($res as $k => $v) {
                $dt[$k][0] = $k+1;
                $dt[$k][1] = $v['po_no'];
                // $dt[$k][2] = $v['type'];
                $dt[$k][2] = $v['title'];
                $dt[$k][3] = $v['company'];
                $dt[$k][4] = $v['NAMA'];
                $dt[$k][5] = $v['currency'];
                $dt[$k][6] = $v['value'];
                $dt[$k][7] = ($v['phase_id'] == 0 ? 'Pre Vendor' : $v['cur_phase']);
                $dt[$k][8] = ($v['phase_id'] == 0 ? '' : date('M j, Y H:i', strtotime($v['create_date'])));
                $dt[$k][9] = "<button class='btn btn-sm btn-success' onclick='process(".$v['id_vendor'].",\"".$v['po_no']."\",".$v['id'].",".$v['sequence'].",".$v['phase_id'].")'>Detail</button>";
            }
        }
        return $this->output($dt);
    }
}

?>
