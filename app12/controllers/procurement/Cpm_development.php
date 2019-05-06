<?php
class Cpm_development extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('procurement/M_cpm_development', 'mcd');
        $this->load->model('vendor/M_vendor');
        $this->load->model('vendor/M_all_intern', 'mai');
        $this->load->model('vendor/M_approval', 'map');
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

        $res = $this->mcd->get_category();
        if ($res != false)
            $data['option'] = $res;

        $company = explode(',', $_SESSION['COMPANY']);
        $dept = $this->mcd->get_dept($company);
        if ($dept != false)
            $data['dept'] = $dept;
        $roles = $this->mcd->get_data_user("DESCRIPTION, ID_USER_ROLES", "m_user_roles");
        if ($dept != false)
            $data['roles'] = $roles;

        $this->template->display('procurement/V_cpm_development', $data);
    }
    /* ===========================================-------- API START------- ====================================== */
    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function send_phase_notif()
    {
        $po=$this->input->post('po');
        $vendor=$this->input->post('vendor');
        $phase=$this->input->post('phase');
        $content=$this->mcd->get_email_dt($vendor,$po,$phase);

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
            if($this->addsendMail($data)){
                $dt=array(
                    "status_delivered"=>1
                );
                $res=$this->mcd->update_dt('t_cpm_phase_notif',$dt,$phase);
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

        $this->load->library('email', $config);
        $this->email->initialize($config);

        $ctn=' <p>' . $content['img1'] . '<p>
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
                     return true;
                } else {
                    return false;
                }
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

    public function check_list() {
        $po = stripslashes($this->input->post('po'));
        $res = $this->mcd->check_list($po);
        if (count($res) > 0) {
            $this->output($res);
        } else {
            $this->output(array("status" => "Failed", "msg" => "Oops, something went wrong!"));
        }
    }

    public function send_all() {
        $po = $this->input->post('po');
        $vendor = $this->input->post('vendor');
        $sel = $this->input->post('selector');
        if ($sel == 3 || $sel == 0) {
            $this->output(array("status" => "error", "msg" => "Oops, something went wrong!"));
        } else {
            $log = array(
                "module_kode" => "cpm_0",
                "data_id" => $po,
                "description" => 'Prepared by ' . $_SESSION['NAME'],
                "keterangan" => '',
                "created_at" => date('Y-m-d H:i:s'),
                "created_by" => $_SESSION['ID_USER'],
            );

            $res = $this->mcd->send_all($po);
            if ($res != false) {
                $dest = $this->mcd->get_email_dest($po, $vendor);
                if ($dest != false) {
                    $rec = $dest[0]['recipients'];
                    $rec_role = $dest[0]['rec_role'];
                    $user = $this->mcd->get_email_rec($rec, $rec_role);
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
                $log = $this->map->add('log_history', $log);
                $this->output(array("status" => "success", "msg" => "Data has been submitted!"));
            } else {
                $this->output(array("status" => "error", "msg" => "Oops, something went wrong!"));
            }
        }
    }

    public function send_all_old() {
        $po = $this->input->post('po');
        $vendor = $this->input->post('vendor');
        $sel = $this->input->post('selector');
        if ($sel == 3 || $sel == 0) {
            $this->output(array("status" => "error", "msg" => "Oops, something went wrong!"));
        } else {
            $log = array(
                "module_kode" => "cpm_0",
                "data_id" => $po,
                "description" => 'Prepared by ' . $_SESSION['NAME'],
                "keterangan" => '',
                "created_at" => date('Y-m-d H:i:s'),
                "created_by" => $_SESSION['ID_USER'],
            );

            $this->mcd->del_old($po);
            $res = $this->mcd->send_all($po);
            if ($res != false) {
                $dest = $this->mcd->get_email_dest($po, $vendor);
                if ($dest != false) {
                    $rec = $dest[0]['recipients'];
                    $rec_role = $dest[0]['rec_role'];
                    $user = $this->mcd->get_email_rec($rec, $rec_role);
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
                $log = $this->map->add('log_history', $log);
                $this->output(array("status" => "success", "msg" => "Data has been submitted!"));
            } else {
                $this->output(array("status" => "error", "msg" => "Oops, something went wrong!"));
            }
        }
    }

    public function add_phase() {
        $plan = new DateTime(stripslashes($this->input->post('plan_date')));
        $plan_date = $plan->format('Y-m-d');

        $check = 1;
        $today = date('Y-m-d');
        $po_no = stripslashes($this->input->post('po_no'));
        $phase = stripslashes($this->input->post('category'));

        $phase_list = $this->mcd->check_phase($po_no);
        if ($plan_date < $today) {
            $this->output(array("status" => "Failed", "msg" => "Phase {$phase} is earlier than today!"));
        } else {
            if ($phase_list != false) {
                foreach ($phase_list as $value) {
                    if ($value['phase'] == $phase) {
                        $check = 2;
                    } else if ($value['phase'] < $phase) {
                        if ($value['due_date'] > $plan_date) {
                            $this->output(array("status" => "Failed", "msg" => "Phase {$phase} is earlier than phase {$value['phase']}!"));
                            exit;
                        }
                    } else {
                        if ($value['due_date'] < $plan_date) {
                            $this->output(array("status" => "Failed", "msg" => "Phase {$value['phase']} is earlier than phase {$phase}!"));
                            exit;
                        }
                    }
                }
            }

            $due2 = $plan->sub(new DateInterval('P30D'));
            $data = array(
                'po_no' => $po_no,
                'phase' => $phase,
                'location' => stripslashes($this->input->post('location')),
                'date_start' => date_format($due2, 'Y-m-d'),
                'due_date' => $plan_date,
                'createby' => $_SESSION['ID_USER'],
                'status' => '1',
                'create_time' => date('Y-m-d H:i:s')
            );

            $dt_notif = array(
                array(
                    'po_no' => $po_no,
                    'due_date' => date_format($due2, 'Y-m-d'),
                    'email_notif' => 30,
                    'status_delivered' => 0,
                    'createby' => $_SESSION['ID_USER'],
                    'createdate' => date('Y-m-d H:i:s')
                ),
                array(
                    'po_no' => $po_no,
                    'due_date' => date_format($plan->add(new DateInterval('P16D')), 'Y-m-d'),
                    'email_notif' => 30,
                    'status_delivered' => 0,
                    'createby' => $_SESSION['ID_USER'],
                    'createdate'=>date('Y-m-d H:i:s')
                ),
                array(
                    'po_no' => $po_no,
                    'due_date' => date_format($plan->add(new DateInterval('P7D')), 'Y-m-d'),
                    'email_notif' => 30,
                    'status_delivered' => 0,
                    'createby' => $_SESSION['ID_USER'],
                    'createdate' => date('Y-m-d H:i:s')
                )
            );

            if ($check == 1) {
                $res = $this->mcd->add_phase($data);
                if ($res != false) {
                    $dt_notif[0]['phase_id'] = $res;
                    $dt_notif[1]['phase_id'] = $res;
                    $dt_notif[2]['phase_id'] = $res;
                    $res = $this->mcd->add_notif($dt_notif);
                }
            } else if ($check == 2){
                $res = $this->mcd->update_phase($data, $po_no, $phase);
                if ($res != false) {
                    $res = $this->mcd->update_notif($dt_notif, $po_no, $phase);
                }
            }

            if ($res)
                $this->output(array("status" => "Success", "msg" => "Data has been saved!"));
            else
                $this->output(array("status" => "Failed", "msg" => "Oops, something went wrong!"));
        }
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
            "create_by"=>$_SESSION['ID_USER'],
            "createdate"=>date("Y-m-d H:i:s")
        );
        $ch=$this->mcd->check_seq($data);
        if($ch != false)
            $data['sequence']=$ch[0]['sequence'];
        $res=$this->mcd->set_approval($data);
        if($res != false)
            return $this->output(array("msg"=>"Data has been saved!", "status"=>"Success"));
        else
            return $this->output(array("msg"=>"Oops, something went wrong!", "status"=>"Failed"));
    }

    public function reset_approval() {
        $po_no = stripslashes($this->input->post('po'));
        $vendor = stripslashes($this->input->post('vendor'));
        $res = $this->mcd->reset_approval($po_no, $vendor);
        if($res != false)
            return $this->output(array("msg" => "Assignee list has been reset!", "status" => "Success"));
        else
            return $this->output(array("msg" => "Oops, something went wrong!", "status" => "Failed"));
    }

    public function upload_file() {
        $result = false;
        $cnt = 1;
        $po = $this->input->post('po_id');
        $tmp = $this->cek_uploads($po, "upload/PROCUREMENT/CPM", "file_unggah", "path");
        $flag = $tmp['flag'];
        $res = $tmp['res'];
        $data = array(
            'po_no' => $po,
            'type' => 'presentation',
            'createby' => $this->session->ID_USER,
            'createdate' => date('Y-m-d H:i:s'),
        );
        if ($flag == 1) {
            $data = array_merge($data, $res);
            $seq = $this->mcd->get_seq($data);
            if ($seq)
                $data['seq'] = $seq[0]['counter'];
            $result = $this->mcd->add_data_file($data);
        }
        if($result != false)
            return $this->output(array("msg" => "Data has been saved!", "status" => "Success"));
        else
            return $this->output(array("msg" => "Oops, something went wrong!", "status" => "Failed"));
    }

    public function delete_uploads() {
        $po = $this->input->post('po');
        $id = $this->input->post('id');
        $del =  $this->mcd->get_upload($po, $id);
        if ($del != false) {
            if (file_exists($del[0]['path'])) {
                if (unlink($del[0]['path'])) {
                    $this->mcd->delete_upload($id);
                    return $this->output(array("msg" => "Data has been deleted!", "status" => "Success"));
                } else {
                    return $this->output(array("msg" => "Oops, something went wrong!", "status" => "Failed"));
                }
            } else {
                $this->mcd->delete_upload($id);
                return $this->output(array("msg" => "Data has been deleted!", "status" => "Success"));
            }
        }
        return $this->output(array("msg" => "Oops, something went wrong!", "status" => "Failed"));
    }

    public function cek_uploads($po, $dest, $data_file, $file_db) {
        $flag = 0;
        $res = 0;
        if ($_FILES[$data_file]['name'] != '') {
            $res = $this->uploads($po, $dest, $data_file, $file_db);
            $this->check_response($res);
            $flag = 1;
        }
        return array("flag" => $flag, "res" => $res);
    }

    public function check_response($res) {
        if ($res == false)
            $this->output(array('msg' => "File uploading has failed", 'status' => 'Failed'));
        else if ($res == "failed")
            $this->output(array('msg' => "Only PDF allowed", 'status' => 'Failed'));
        else if ($res == "size")
            $this->output(array('msg' => "Maximum File size is 2 MB", 'status' => 'Failed'));
    }

    public function uploads($po, $dest, $data_file, $db_name) {
        $data = $_FILES;
        $ret = array();
        $counter = 0;
        foreach ($data as $k => $v) {
            $img_ext = substr($v['name'], strrpos($v['name'], '.'));
            $new_name = preg_replace('/[^A-Za-z0-9\-\.]/', '', $po);
            $new_name = str_replace(' ', '', $new_name . '_' . Date("Ymd_His") . $img_ext);
            if ($img_ext != ".pdf")
                return "failed";
            if ($_FILES[$k]['size'] > 2000000)
                return "size";
            if ($k == $data_file) {
                $ret[$db_name] = $dest.'/'.$new_name;
                $ret['file_name'] = $new_name;
            }
            if (move_uploaded_file($_FILES[$k]['tmp_name'], "$dest/$new_name"))
                $counter++;
        }
        if ($counter == 1)
            return $ret;
        else
            return false;
    }

    public function get_kpi_cat() {
        $po = stripslashes($this->input->post('po'));
        $vendor = stripslashes($this->input->post('vendor'));
        $res = $this->mcd->get_kpi_cat($po, $vendor);
        if($res != false)
            $this->output($res);
        else
            $this->output();
    }

    public function add_weight() {
        $res = false;
        $cat = stripslashes($this->input->post('category'));
        $wght = stripslashes($this->input->post('weight'));
        $po = stripslashes($this->input->post('po'));
        $vendor = stripslashes($this->input->post('vendor'));

        if ($wght < 0)
            $this->output(array("msg" => "Category Weight less than 0%!", "status" => "Failed"));
        else if($wght > 100)
            $this->output(array("msg" => "Category Weight greater than 100%!", "status" => "Failed"));

        $id = $this->mcd->check_id($po, $vendor);
        if ($id == false) {
            $id = $this->mcd->get_id($po);
            if ($id == false)
                $this->output(array("msg" => "Oops, something went wrong!", "status" => "Failed"));
            $dt = array(
                "id" => $id[0]->id,
                "vendor_id" => $vendor,
                "po_no" => $po,
                "createby" => $_SESSION['ID_USER'],
                "updatedate" => date("Y-m-d H:i:s"),
            );
            $res = $this->mcd->add_cpm_data('t_cpm', $dt);
        }

        $cpm_old = $this->mcd->check_id($po, $vendor, $cat);
        if ($cpm_old == false) {
            $dt = array(
                "cpm_id" => $id[0]->id,
                "category_id" => $cat,
                "cat_weight" => $wght,
                "createby" => $_SESSION['ID_USER'],
                "createdate" => date("Y-m-d H:i:s")
            );
            $chk = $this->mcd->validate_weight($wght, $id[0]->id);

            if ($chk == true)
                $res = $this->mcd->add_cpm_data('t_cpm_detail', $dt);
            else
                $this->output(array("msg" => "Category Total Weight exceeds 100%!", "status" => "Failed"));
        } else {
            $dt = array(
                "cat_weight" => $wght,
                "updateby" => $_SESSION['ID_USER'],
                "updatedate" => date("Y-m-d H:i:s")
            );
            $chk = $this->mcd->validate_weight($wght, $id[0]->id, $cat);

            if ($chk == true)
                $res = $this->mcd->update_weight($dt, array('cpm_id' => $id[0]->id, 'category_id' => $cat));
            else
                $this->output(array("msg" => "Category Total Weight exceeds 100%!", "status" => "Failed"));
        }

        if ($res != false)
            $this->output(array("msg" => "Data has been saved!", "status" => "Success"));
        else
            $this->output(array("msg" => "Oops, something went wrong!", "status" => "Failed"));
    }

    public function add_kpi_detail() {
        $res = false;
        $kpi = stripslashes($this->input->post('kpi_id'));
        $cat = stripslashes($this->input->post('category'));
        $wght = stripslashes($this->input->post('kpi_weight'));
        $po = stripslashes($this->input->post('po'));
        $vendor = stripslashes($this->input->post('vendor'));
        $id = $this->mcd->check_id($po, $vendor, $this->input->post('category'));

        if ($wght < 0)
            $this->output(array("msg" => "KPI Weight less than 0%!", "status" => "Failed"));
        else if($wght > 100)
            $this->output(array("msg" => "KPI Weight greater than 100%!", "status" => "Failed"));

        if ($id != false) {
            $dt = array(
                "cpm_id" => $id[0]->id,
                "category_id" => $cat,
                "specific_kpi" => $this->input->post('kpi_spec'),
                "kpi_weight" => $wght,
                "scoring_method" => $this->input->post('kpi_method'),
                "target_score" => $this->input->post('target_score'),
                "createby" => $_SESSION['ID_USER'],
                "createdate" => date("Y-m-d H:i:s"),
            );
            if ($kpi == 0) {
                $sel = 1;
                if ($id[0]->total == 1 && $id[0]->specific_kpi == null)
                    $sel = 2;
                $chk = $this->mcd->validate_kpi($wght, $id[0]->id, $cat, $kpi);
                if ($chk == true) {
                    $res = $this->mcd->add_kpi_detail($dt, $sel);
                } else
                    $this->output(array("msg" => "KPI Total Weight exceeds 100%!", "status" => "Failed"));
            } else {
                $sel = 3;
                $dt['kpi_id'] = $kpi;
                $chk = $this->mcd->validate_kpi($wght, $id[0]->id, $cat, $kpi);
                if ($chk == true) {
                    $res = $this->mcd->add_kpi_detail($dt, $sel);
                } else
                    $this->output(array("msg" => "KPI Total Weight exceeds 100%!", "status" => "Failed"));
            }
        }

        if ($res != false)
            $this->output(array("msg" => "Data has been saved!", "status" => "Success"));
        else
            $this->output(array("msg" => "Oops, something went wrong!", "status" => "Failed"));
    }

    /* ===========================================-------- get data START------- ====================================== */
    public function get_cpm_detail() {
        $po = $this->input->post('po');
        $vendor = $this->input->post('vendor');
        $pid = $this->input->post('pid');
        $res = $this->mcd->get_cpm_detail($po, $vendor, $pid);
        if ($res != false)
            return $this->output($res);
        return $this->output();
    }

    public function get_kpi_spec() {
        $po = stripslashes($this->input->post('po'));
        $vendor = stripslashes($this->input->post('vendor'));
        $kpi = $this->input->post('kpi');
        $res = $this->mcd->get_kpi_spec($kpi);
        if ($res != false) {
            $res[0]['cat_list'] = $this->mcd->get_kpi_cat($po, $vendor);
            return $this->output($res[0]);
        } else {
            return $this->output(array("msg" => "Oops, something went wrong!", "status" => "Failed"));
        }
    }

    public function get_user($sel = 0) {
        $res = false;
        if ($sel == 0) {
            $roles = stripslashes($this->input->post('roles'));
            $dept = stripslashes($this->input->post('dept'));
            $res = $this->mcd->get_user($dept);
        } else if ($sel == 1) {
            $po = $this->input->post("po");
            $vendor = $this->input->post("vendor");
            $res = $this->mcd->get_user_appr($po, $vendor);
        }
        else
            return $this->output(array("msg" => "Oops, something went wrong!", "status" => "Failed"));

        if ($res != false)
            return $this->output($res);
        else if ($sel == 0)
            return $this->output(array(array("id" => 0, "name" => "No User")));
        else
            return $this->output(array("msg" => "Oops, something went wrong!", "status" => "Failed"));
    }

    public function delete_dt() {
        $id = stripslashes($_POST['id']);
        $res = $this->mcd->delete_dt($id);
        if($res == true)
            return $this->output(array("msg"=>"Data has been deleted!", "status"=>"Success"));
        else
            return $this->output(array("msg"=>"Oops, something went wrong!", "status"=>"Failed"));
    }

    public function get_plan() {
        $po = stripslashes($this->input->post('po'));
        $pid = stripslashes($this->input->post('pid'));
        $res = $this->mcd->get_plan($po, $pid);
        $c = 0;
        $tmp_c = 1;
        if (count($res) > 0) {
            $tamp = 0;
            foreach($res as $k => $v) {
                if($v->id != $tamp) {
                    $c++;
                    $diff = date_diff(date_create($v->due_date), date_create(date("Y-m-d")));
                    if ($v->due_date >= date("Y-m-d")) {
                        $due = "<td>".$diff->format("%a")." Days</td>";
                    } else {
                        $due = "<td style='color: red;'>Over ".$diff->format("%a")." Days</td>";
                    }
                    echo "<tr>
                        <td>".$c."</td>
                        <td> Phase ".$v->phase."</td>
                        <td>".$v->location."</td>
                        <td>".date('j F Y', strtotime($v->due_date))."</td>"
                        .$due.
                        "<td><span class='badge badge-pill badge-success'>Open</span></td>
                    </tr>";
                    $tamp = $v->id;
                }
            }
        } else {
            echo "<tr><td colspan='6'>" . ($_SESSION['lang'] == 'IND' ? 'Tidak Ada Data' : 'No Data') . "</td></tr>";
        }
    }

    public function get_schedule() {
        $po = stripslashes($this->input->post('po'));
        $pid = stripslashes($this->input->post('pid'));
        $res = $this->mcd->get_plan($po, $pid);
        if (count($res) > 0) {
            $c = 0;
            foreach ($res as $k => $v) {
                $c++;
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
            }
        } else {
            echo "<tr><td colspan='6'>" . ($_SESSION['lang'] == 'IND' ? 'Tidak Ada Data' : 'No Data') . "</td></tr>";
        }
    }

    public function get_upload() {
        $dt = array();
        $po = $this->input->post('po');
        $sel = $this->input->post('sel');
        $res = $this->mcd->get_upload($po);
        if ($res != false) {
            $count = 1;
            foreach ($res as $k => $v) {
                $dt[$k][0] = $count;
                $dt[$k][1] = ucwords($v['type']);
                $dt[$k][2] = $v['file_name'];
                $dt[$k][3] = date('M j, Y H:i', strtotime($v['createdate']));
                $dt[$k][4] = "<span class='badge badge-pill badge-success'>".$v['name']."</span>";
                if ($sel == 1 || $sel == 2) {
                    $dt[$k][5] = "<button class='btn btn-sm btn-danger btn-modif-upload' onclick='delete_ul(".$v['id'].")'><i class='fa fa-trash'></i></button>";
                } else {
                    $dt[$k][5] = '';
                }
                $count++;
            }
            return $this->output($dt);
        }
        else
            $this->output();
    }

    public function get_header_prepare() {
        $po = $this->input->post('po');
        $vendor = $this->input->post('vendor');
        $res = $this->mcd->get_header_prepare($po, $vendor);
        if ($res) {
            $roles = explode(',', $this->session->ROLES);
            if (!in_array($res[0]->cor_role_id, $roles)) {
                $res[0]->cor_role = '-';
            }
            $res[0]->cor_creator = $this->session->NAME;
            $res[0]->createdate = date('j F Y');
            $res[0]->delivery_date = date('j F Y', strtotime($res[0]->delivery_date));
        }
        return $this->output($res);
    }

    public function get_header_progress() {
        $po = $this->input->post('po');
        $vendor = $this->input->post('vendor');
        $res = $this->mcd->get_header_progress($po, $vendor);
        if ($res) {
            $res[0]->createdate = date('j F Y', strtotime($res[0]->createdate));
            $res[0]->delivery_date = date('j F Y', strtotime($res[0]->delivery_date));
        }
        return $this->output($res);
    }

    public function get_history() {
        $po = $this->input->post('po');
        $vendor = $this->input->post('vendor');
        $phase = 'cpm_' . $this->input->post('phase');
        $res = $this->mcd->get_history($po, $phase);
        if ($res != false && count($res) > 0) {
            $c = 0;
            foreach ($res as $k => $v) {
                $dt[$c][0] = $c + 1;
                $dt[$c][1] = $v['description'];
                $dt[$c][2] = $v['keterangan'];
                $dt[$c][3] = date('M j, Y H:i', strtotime($v['created_at']));
                $c++;
            }
            return $this->output($dt);
        } else {
            return $this->output();
        }
    }

    public function get_list_prepared() {
        $dt = array();
        $res = $this->mcd->get_list_prepared();
        if (count($res)>0) {
            foreach ($res as $k => $v) {
                $dt[$k][0] = $k+1;
                $dt[$k][1] = $v['po_no'];
                // $dt[$k][2] = $v['type'];
                $dt[$k][2] = $v['title'];
                $dt[$k][3] = $v['ABBREVIATION'];
                $dt[$k][4] = $v['NAMA'];
                $dt[$k][5] = $v['currency'];
                $dt[$k][6] = $v['value'];
                $dt[$k][7] = '';
                $dt[$k][8] = '';
                $dt[$k][9] = "<button class='btn btn-sm btn-success' onclick='process(".$v['id_vendor'].",\"".$v['po_no']."\", 0, 1)'>CPM</button>";
            }
        }
        return $this->output($dt);
    }

    public function get_list_progress() {
        $dt = array();
        $res = $this->mcd->get_list_progress();
        if (count($res)>0) {
            foreach ($res as $k => $v) {
                if ($v['status_approve'] == 1) {
                    $col = 'success';
                    $stat = 'Approved';
                } else if ($v['status_approve'] == 2) {
                    $col = 'danger';
                    $stat = 'Rejected';
                } else {
                    $col = 'light';
                    $stat = 'Unconfirmed';
                }

                $dt[$k][0] = $k+1;
                $dt[$k][1] = $v['po_no'];
                // $dt[$k][2] = $v['type'];
                $dt[$k][2] = $v['title'];
                $dt[$k][3] = $v['ABBREVIATION'];
                $dt[$k][4] = $v['NAMA'];
                $dt[$k][5] = $v['currency'];
                $dt[$k][6] = $v['value'];
                $dt[$k][7] = ($v['phase_id'] == 0 ? 'Pre Vendor' : $v['cur_phase']);
                $dt[$k][8] = $v['user_roles'];
                $dt[$k][9] = "<span class='badge badge badge-pill badge-".$col."'>".$stat."</span>";
                if ($v['edit_content'] == 1 && $v['extra_case'] == 0) {
                    $dt[$k][10] = "<button class='btn btn-sm btn-success' onclick='process(".$v['id_vendor'].",\"".$v['po_no']."\", ".$v['phase_id'].", 2)'>Rework</button>";
                } else {
                    $dt[$k][10] = "<button class='btn btn-sm btn-primary' onclick='process(".$v['id_vendor'].",\"".$v['po_no']."\", ".$v['phase_id'].", 3)'>Progress</button>";
                }
            }
        }
        return $this->output($dt);
    }
}
?>
