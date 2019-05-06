<?php
class Cor_approval extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('procurement/M_cor_approval', 'mcd');
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
        $data['cpm_rank'] = $this->mcd->get_cpm_rank();
        $this->template->display('procurement/V_cor_approval', $data);
    }
/* ===========================================-------- API START------- ====================================== */
    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }
/* ===========================================-------- get data START------- ====================================== */

    public function change_btn($sel) {
        if ($sel == 1 || $sel == 2) {
            $seq_max = false;
            $tid = $this->input->post('tid');
            $dt_note = ($sel == 1 ? 'Approved' : 'Rejected') . ($this->input->post('note') == '' ? '' : ' - ' . $this->input->post('note'));
            $data = array(
                "supplier_id" => $this->input->post('idS'),
                "sequence" => $this->input->post('seq'),
                "status_approve" => 1,
                "updatedate" => date("Y-m-d H:i:s"),
                "tid" => $tid,
                "po" => $this->input->post('po'),
                "type" => $this->input->post('type'),
                'note' => $dt_note
            );
            $res = $this->mcd->get_email_dest($tid, $data, $sel);
            if ($res != false) {
                foreach ($res as $key => $value) {
                    if ($sel == 1 ) {
                        if ($value['max_seq'] == $this->input->post('seq')) {
                            $seq_max = true;
                            if ($this->input->post('from_cpm') == 2) {
                                $total = $this->input->post('total');
                                $score = $this->input->post('scoring');
                                $data_sc = array(
                                    'total' => $total,
                                    'score' => $score
                                );
                            } else {
                                $total = $this->input->post('total');
                                $score = ($total / ($this->input->post('jumlah') * 4)) * 100;
                                $data_sc = array(
                                    'total' => $total,
                                    'score' => $score
                                );
                            }
                            if ($this->mcd->update_score($data_sc, $this->input->post('po')) == false)
                                $this->output(array("status" => "Failed", "msg" => "Oops, something went wrong!"));
                        }
                    }
                    if (!$seq_max) {
                        $rec = $value['recipients'];
                        $rec_role = $value['rec_role'];
                        $flag = false;
                        if ($rec != null) {
                            $user = $this->mcd->get_email_rec($rec, $rec_role);
                            $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
                            $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";
                            $dt = array(
                                'dest' => $user,
                                'img1' => $img1,
                                'po' => stripslashes($this->input->post('po')),
                                'img2' => $img2,
                                'title' => $value['TITLE'],
                                'open' => $value['OPEN_VALUE'],
                                'close' => $value['CLOSE_VALUE']
                            );
                            $flag = $this->sendMail($dt);
                        }
                        else
                            $flag = true;
                    } else {
                        $flag = true;
                    }
                }

                $res = false;
                if ($flag) {
                    // $data_log = array(
                    //     "ID_VENDOR"=>$this->input->post('idS'),
                    //     "STATUS"=>$this->input->post('seq'),
                    //     "CREATE_TIME"=>date('Y-m-d H:i:s'),
                    //     "CREATE_BY"=>$_SESSION['ID_USER'],
                    //     "TYPE"=>"COR",
                    //     "NOTE"=>stripslashes($_POST['note'])
                    // );

                    $data_log = array(
                        "module_kode" => "cor",
                        "data_id" => $tid,
                        "description" => ($sel == 1 ? 'Approved by ' . $_SESSION['NAME'] : 'Rejected by ' . $_SESSION['NAME']),
                        "keterangan" => stripslashes($this->input->post('note')),
                        "created_at" => date('Y-m-d H:i:s'),
                        "created_by" => $_SESSION['ID_USER'],
                    );
                    // if ($seq_max)
                    //     $data_log['description'] = 'Approved by ' . $_SESSION['NAME'];

                    $res = $this->mcd->submit_data($data, $sel);
                    $log = $this->map->add('log_history', $data_log);
                }

                if ($res != false) {
                    if ($this->input->post('from_cpm') == 2) {
                        $tkdn = $this->input->post('input_tkdn');
                        $tkdn_act = $this->input->post('input_tkdn_act');
                    }else{
                        $tkdn = $this->input->post('input_tkdn');
                        $tkdn_act = $this->input->post('input_tkdn_act');
                    }
                    if ($tkdn!="") {
                        $this->db->query("update t_performance_cor set input_contract=".$tkdn.",input_actual=".$tkdn_act." where id='".$tid."' ");
                    }
                    
                    if ($sel == 1) {
                        $this->output(array('status' => 'Success', 'msg' => 'Approval has been submitted!'));
                    } else {
                        $this->output(array('status' => 'Success', 'msg' => 'Rejection has been submitted!'));
                    }
                } else {
                    $this->output(array("status" => "Failed", "msg" => "Oops, something went wrong!"));
                }
            }
            $this->output(array("status" => "Failed", "msg" => "Oops, something went wrong!"));
        }
        else
            $this->output(array("status" => "Failed", "msg" => "Oops, something went wrong!"));
    }

    public function get_upload() {
        $dt = array();
        $po = stripslashes($this->input->post('po'));
        $id = stripslashes($this->input->post('id'));
        $type = stripslashes($this->input->post('type'));
        $sel = 0;

        $res = $this->mcd->check_condition($po, $id, $type);
        if ($res != false) {
            $sel = $res[0]->status_edit;
            $res = false;
        }

        $res = $this->mcd->get_upload($po);
        if ($res != false) {
            $count = 1;
            if ($sel > 1) {
                foreach ($res as $k => $v) {
                    $dt[$k][0] = $count;
                    $dt[$k][1] = ($v['type'] == 'memo' ? 'Memo' : ($v['type'] == 'scoring' ? 'Scoring Result' : 'Other'));
                    $dt[$k][2] = $v['file_name'];
                    $dt[$k][3] = date('M j, Y H:i', strtotime($v['createdate']));
                    $dt[$k][4] = "<span class='badge badge-pill badge-success'>".$v['name']."</span>";
                    $dt[$k][5] = "<button class='btn btn-sm btn-primary' onclick=preview('".$v['path']."')><i class='fa fa-file'></i></button>&nbsp;<button class='btn btn-sm btn-danger btn-modif-upload' onclick='delete_ul(".$v['id'].")'><i class='fa fa-trash'></i></button>";
                    $count++;
                }
            } else {
                foreach ($res as $k => $v) {
                    $dt[$k][0] = $count;
                    $dt[$k][1] = ($v['type'] == 'memo' ? 'Memo' : ($v['type'] == 'scoring' ? 'Scoring Result' : 'Other'));
                    $dt[$k][2] = $v['file_name'];
                    $dt[$k][3] = date('M j, Y H:i', strtotime($v['createdate']));
                    $dt[$k][4] = "<span class='badge badge-pill badge-success'>".$v['name']."</span>";
                    $dt[$k][5] = "<button class='btn btn-sm btn-primary' onclick=preview('".$v['path']."')><i class='fa fa-file'></i></button>";
                    $count++;
                }
            }
            return $this->output($dt);
        }
        else
            $this->output();
    }

    public function approve_comp() {
        $vid = $this->input->post('idS');
        $tid = stripslashes($this->input->post('tid'));
        $po_id = $this->input->post('po');
        $amount_orig = $this->input->post('amount_orig') == '' ? 0 : $this->input->post('amount_orig');
        $amount_comp = $this->input->post('amount_comp') == '' ? 0 : $this->input->post('amount_comp');
        if ($amount_orig > 0 && $amount_comp <= 0) {
            $this->output(array("status" => "Failed", "msg" => "Completion Amount must be greater than 0.00!"));
            exit;
        }
        if ($amount_comp > $amount_orig) {
            $res = $this->mcd->get_upload_type($po_id, 'memo');
            // Sementara dimatikan
            /*if ($res <= 0) {
                $this->output(array("status" => "Failed", "msg" => "Memo must be uploaded if Completion Amount greater than Original Amount!"));
                exit;
            }*/
        }

        $data = array(
            "supplier_id" => $vid,
            "sequence" => $this->input->post('seq'),
            "status_approve" => 1,
            "updatedate" => date("Y-m-d H:i:s"),
            "tid" => $this->input->post('tid'),
            "po" => $po_id,
            "type" => $this->input->post('type'),
            "note" => 'Approved' . ($this->input->post('note') == '' ? '' : ' - ' . $this->input->post('note'))
        );
        $res = $this->mcd->get_email_dest($tid, $data, 1);

        if ($res != false) {
            foreach ($res as $key => $value) {
                $rec = $value['recipients'];
                $rec_role = $value['rec_role'];
                $flag = false;
                if ($rec != null) {
                    $user = $this->mcd->get_email_rec($rec, $rec_role);
                    $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
                    $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";
                    $dt = array(
                        'dest' => $user,
                        'img1' => $img1,
                        'po' => $po_id,
                        'img2' => $img2,
                        'title' => $value['TITLE'],
                        'open' => $value['OPEN_VALUE'],
                        'close' => $value['CLOSE_VALUE']
                    );
                    $flag = $this->sendMail($dt);
                } else
                    $flag = true;
            }

            $cor_desc['amount_comp'] = $amount_comp;
            $cor_desc = $this->mcd->update_cor_desc($tid, $vid, $cor_desc);

            if ($flag == true) {
                $data_log = array(
                    "module_kode" => "cor",
                    "data_id" => $tid,
                    "description" => 'Approved by ' . $_SESSION['NAME'],
                    "keterangan" => stripslashes($this->input->post('note')),
                    "created_at" => date('Y-m-d H:i:s'),
                    "created_by" => $_SESSION['ID_USER'],
                );

                $res = $this->mcd->submit_data($data, 1);
                $log = $this->map->add('log_history', $data_log);
            }

            if ($res == false)
                $this->output(array("status" => "Failed", "msg" => "Oops, something went wrong!"));
            else{
                 if ($this->input->post('from_cpm') == 2) {
                        $tkdn = $this->input->post('input_tkdn');
                        $tkdn_act = $this->input->post('input_tkdn_act');
                    }else{
                        $tkdn = $this->input->post('input_tkdn');
                        $tkdn_act = $this->input->post('input_tkdn_act');
                    }
                    if ($tkdn!="") {
                        $this->db->query("update t_performance_cor set input_contract=".$tkdn.",input_actual=".$tkdn_act." where id='".$tid."' ");
                    }
                $this->output(array('status' => 'Success', 'msg' => 'Approval has been submitted!'));
            }
        }
        $this->output(array("status" => "Failed", "msg" => "Oops, something went wrong!"));
    }

    public function send_point_dt() {
        if ($this->input->post('actual_deliv_date') == null && $this->input->post('seq')>=3) {
            $this->output(array("status" => "Failed", "msg" => "Please input actual delivery date!"));
            exit;
        }

        $count = 0;
        $idV = stripslashes($this->input->post('idvendor'));
        $idT = stripslashes($this->input->post('tid'));
        $seq = stripslashes($this->input->post('seq'));
        $po_id = stripslashes($this->input->post('po_id'));
        $type = stripcslashes($this->input->post('type'));

        $check = $this->mcd->get_upload_type($po_id, 'scoring');
        // Sementara pengecekan upload data dibuka
        /*if ($check <= 0 && strpos($po_id,'-OS-') !== false) {
            $this->output(array("status" => "Failed", "msg" => "Scoring Result must be uploaded!"));
            exit;
        }*/

        $flag = false;
        $part = array();
        $part['total'] = 0;
        $part['input_contract'] = 0;
        $part['input_actual'] = 0;

        // if(count($idT) == null)
        //     $this->output(array("status"=>"error","msg"=>"Oops, terjadi kesalahan"));
        $dt2 = array();
        if ($this->input->post('from_cpm') == 2) {
            foreach ($this->input->post('point_data') as $k => $v) {
                if ($v['name'] != "total" && $v['name'] != "input_contract" && $v['name'] != "input_actual") {
                    $pos1 = strpos($v['name'], '_');
                    $id = substr($v['name'], $pos1+1, strlen($v['name']));
                    $cat = substr($v['name'], 0, $pos1);
                    $dt2[$count]['id'] = $idT;
                    $dt2[$count]['cor_id'] = $id;
                    if ($v['value'] != null) {
                        $dt2[$count]['rating'] = $v['value'];
                        $count++;
                    }
                } else {
                    $part[$v['name']] = $v['value'];
                }
            }
        } else {
            foreach ($this->input->post('point_data') as $k => $v) {
                if ($v['name'] != "total" && $v['name'] != "input_contract" && $v['name'] != "input_actual") {
                    $pos1 = strpos($v['name'], '_');
                    $id = substr($v['name'], $pos1+1, strlen($v['name']));
                    $cat = substr($v['name'], 0, $pos1);
                    $dt2[$count]['id'] = $idT;
                    $dt2[$count]['cor_id'] = $id;
                    if ($v['value'] != null) {
                        $dt2[$count]['rating'] = $v['value'];
                        $count++;
                    }
                } else {
                    $part[$v['name']] = $v['value'];
                }
            }
        }

        $cor_desc['actual_deliv_date'] = date('Y-m-d', strtotime($this->input->post('actual_deliv_date')));
        $cor_desc['check_partial'] = $this->input->post('check_partial');
        $cor_desc['check_penalty'] = $this->input->post('check_penalty');
        $cor_desc['input_contract'] = $part['input_contract'];
        $cor_desc['input_actual'] = $part['input_actual'];
        $cor_desc['amount_penalty'] = $this->input->post('amount_penalty') == '' ? 0 : $this->input->post('amount_penalty');

        if($count != $part['total']) {
            $this->output(array("status" => "Failed", "msg" => "There are empty scoring!"));
            exit;
        }

        $data = array(
            "supplier_id" => $idV,
            "sequence" => $seq,
            "status_approve" => 1,
            "updatedate" => date("Y-m-d H:i:s"),
            "tid" => $idT,
            "po" => $po_id,
            "type" => $type,
            "note" => 'Scored'
        );
        $res = $this->mcd->get_email_dest($idT, $data, 1);

        if ($res != false) {
            foreach ($res as $key => $value) {
                $rec = $value['recipients'];
                $rec_role = $value['rec_role'];
                $flag = false;
                if ($rec != null) {
                    $user = $this->mcd->get_email_rec($rec, $rec_role);
                    $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
                    $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";
                    $dt = array(
                        'dest' => $user,
                        'img1' => $img1,
                        'po' => $po_id,
                        'img2' => $img2,
                        'title' => $value['TITLE'],
                        'open' => $value['OPEN_VALUE'],
                        'close' => $value['CLOSE_VALUE']
                    );
                    $flag = $this->sendMail($dt);
                } else
                    $flag = true;
            }

            $cor_desc = $this->mcd->update_cor_desc($idT, $idV, $cor_desc);

            $cek = $this->mcd->check_data_point($data['tid']);
            if (count($cek) > 0)
                $res = $this->mcd->update_data($dt2);
            else
                $res = $this->mcd->send_data('t_performance_cor_detail', $dt2);

            if ($flag == true) {
                $data_log = array(
                    "module_kode" => "cor",
                    "data_id" => $idT,
                    "description" => 'Scoring by ' . $_SESSION['NAME'],
                    "keterangan" => '',
                    "created_at" => date('Y-m-d H:i:s'),
                    "created_by" => $_SESSION['ID_USER'],
                );

                $res = $this->mcd->submit_data($data, 1);
                $log = $this->map->add('log_history', $data_log);
            }

            if ($res == false)
                $this->output(array("status" => "Failed", "msg" => "Oops, something went wrong!"));
            else
                $this->output(array("status" => "Success", "msg" => "Data has been saved!"));
        }
        $this->output(array("status" => "Failed", "msg" => "Oops, something went wrong!"));
    }

    public function upload_file() {
        $result = false;
        $po = stripslashes($this->input->post('po'));
        $id = stripslashes($this->input->post('id'));
        $type = stripslashes($this->input->post('type'));
        $doc_type = stripslashes($this->input->post('file_unggah_tipe'));

        $res = $this->mcd->check_condition($po, $id, $type);
        if ($res[0]->user_id != $this->session->userdata('ID_USER'))
            return $this->output(array("msg" => "Oops, something went wrong!", "status" => "Failed"));

        $tmp = $this->cek_uploads($po, "upload/PROCUREMENT/COR", "file_unggah", "path");
        $flag = $tmp['flag'];
        $res = $tmp['res'];
        $data = array(
            'po_no' => $po,
            'type' => $doc_type,
            'createby' => $this->session->ID_USER,
            'createdate' => date('Y-m-d H:i:s'),
        );
        if ($flag == 1) {
            $data = array_merge($data, $res);
            $result = $this->mcd->add_data_file($data);
        }
        if ($result != false)
            return $this->output(array("msg" => "Data has been saved!", "status" => "Success"));
        else
            return $this->output(array("msg" => "Oops, something went wrong!", "status" => "Failed"));
    }

    public function delete_uploads() {
        $fid = $this->input->post('fid');
        $po = stripslashes($this->input->post('po'));
        $id = stripslashes($this->input->post('id'));
        $type = stripslashes($this->input->post('type'));

        $res = $this->mcd->check_condition($po, $id, $type);
        if ($res[0]->user_id != $this->session->userdata('ID_USER'))
            return $this->output(array("msg" => "Oops, something went wrong!", "status" => "Failed"));

        $del =  $this->mcd->get_upload($po, $fid);
        if ($del != false) {
            if (file_exists($del[0]['path'])) {
                if (unlink($del[0]['path'])) {
                    $this->mcd->delete_upload($fid);
                    return $this->output(array("msg" => "Data has been deleted!", "status" => "Success"));
                } else {
                    return $this->output(array("msg" => "Oops, something went wrong!", "status" => "Failed"));
                }
            } else {
                $this->mcd->delete_upload($fid);
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
            $this->output(array('msg' => "Only PDF, Excel, or Word allowed", 'status' => 'Failed'));
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
            if ($img_ext != ".pdf" && $img_ext != ".xls" && $img_ext != ".xlsx" && $img_ext != ".doc" && $img_ext != ".docx")
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

    public function check_data() {
        $po = stripslashes($this->input->post('po'));
        $id = stripslashes($this->input->post('id'));
        $type = stripslashes($this->input->post('type'));
        $res = $this->mcd->check_condition($po, $id, $type);
        if ($res) {
            $resp['status'] = 'Success';
            $resp['data_fn'] = ($res[0]->sequence == $res[0]->max_seq ? 1 : 0);
            $resp['data_sm'] = $res[0]->status_edit;
            $resp['data_sr'] = $res[0]->status_reject;
            return $this->output($resp);
        } else {
            return $this->output(array("status" => "Failed", "msg" => "Oops, something went wrong!"));
        }
    }

    protected function sendMail($content) {
        $mail = get_mail();
        $config = array();
        $config['protocol'] = $mail['protocol'];
        $config['smtp_crypto'] = $mail['crypto'];
        if ($mail['protocol'] == 'smtp'){
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
        $flag = 0;
        $no_msr = $this->mcd->get_msr($content['po']);

        if ($content['dest']) {
            foreach ($content['dest'] as $k => $v) {
                $this->load->library('email', $config);
                $this->email->initialize($config);
                $this->email->from($mail['email'], '[SYSTEM] EPROC SUPREME ENERGY');
                $this->email->subject($content['title']);
                $ctn = ' <p>' . $content['img1'] . '<p>
                        <br>' . $open = str_replace("no_msr", $no_msr[0]['msr_no'], $content['open']) . '
                        <br>
                        ' . $content['close'] . '
                        <br>
                        ';

                $data_email['recipient'] = $v->email;
                $data_email['subject'] = $content['title'];
                $data_email['content'] = $ctn;
                $data_email['ismailed'] = 0;

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

    public function calculate($id) {
        $id = (int) $id;
        $val = (int) $this->input->post('val');
        $po = $this->input->post('po');
        $res = $this->mcd->calc_weight($id, $val, $po);
        if ($res == false) {
            $this->output(array("status" => "Failed", "msg" => "Oops, something went wrong!"));
        } else {
            $this->output($res);
        }
    }

    public function get_performance_q($po, $type) {
        $ch = $this->mcd->check_condition($po, $this->input->post('id'), $type);
        $cpm = stripslashes($this->input->post('from_cpm'));

        $res = false;
        if ($cpm == 2) {
            $res = $this->mcd->get_performance_q_cpm($po);
            if ($res != false) {
                $count = 0;
                $temp = '';
                $tamp_cat = '';
                $total = 0;
                $total_weight = 0;
                foreach ($res as $k => $v) {
                    $count++;
                    if ($tamp_cat != $v->category)
                        echo '<tr><td class="text-left" colspan="8"><strong>' . $v->category . ' (' . $v->cat_weight . ' %)</strong></td></tr>';
                    $tamp_cat = $v->category;

                    if ($v->rating == null)
                        $v->rating = 0;

                    echo '<tr>
                        <td>' . $count . '</td>
                        <td>' . $v->specific_kpi . '</td>
                        <td class="text-center">' . $v->kpi_weight . ' %</td>
                        <td>' . $v->scoring_method . '</td>
                        <td class="text-center">' . $v->target_score . '</td>
                        <td class="text-center">' . $v->target_weight . '</td>';
                    if ($ch[0]->status_edit == 2) {
                        echo '<td class="text-center">' . $v->scoring . '<input type="hidden" name="cpms_' . $v->id . '" value="' . $v->scoring . '"></td>
                        <td class="text-center" name="cpmw_' . $v->id . '">' . $v->weighting . '</td>
                        </tr>';
                        // echo '<td class="text-center"><input type="number" class="form-control" name="cpms_' . $v->id . '" min="0" max="' . $v->target_score . '" onchange="calculate('.$v->id.', '.$v->category_id.')"></td>
                        // <td class="text-center" name="cpmw_' . $v->id . '">0</td>
                        // </tr>';
                    } else {
                        $temp = ($v->cat_weight * $v->kpi_weight * $v->rating / 10000);
                        $total += $temp;
                        echo '<td class="text-center">' . $v->rating . '</td>
                        <td class="text-center" name="cpmw_' . $v->id . '">' . $temp . '</td>
                        </tr>';
                    }
                    $total_weight += $v->target_weight;
                }
                echo '<td style="display:none"><input type="text" value=' . $count . ' name="total"></input></td>';
                echo '<td style="display:none" id="cpmttl">'.($total_weight).'</td>';
                echo '<td style="display:none"><input type="text" value='.$total.' id="total_nilai"></input></td>';
                if ($res[0]->actual_deliv_date == '0000-00-00' || $res[0]->actual_deliv_date == '1970-01-01' || $res[0]->actual_deliv_date == null) {
                    $deliv_date = '';
                } else {
                    if ($ch[0]->status_edit == 2) {
                        $deliv_date = date('Y-m-d', strtotime($res[0]->actual_deliv_date));
                    } else {
                        $deliv_date = date('j F Y', strtotime($res[0]->actual_deliv_date));
                    }
                }
                if ($ch[0]->status_edit == 2)
                    echo '<td style="display:none" id="tcpm">2</td>';
                else
                    echo '<td style="display:none" id="tcpm">1</td>';
                echo '<td style="display:none" id="cinc">'.($res[0]->input_contract).'</td>';
                echo '<td style="display:none" id="cina">'.($res[0]->input_actual).'</td>';
                echo '<td style="display:none" id="stat">'.($ch[0]->status_edit).'</td>';
                echo '<td style="display:none" id="coma">'.($res[0]->amount_comp).'</td>';
                echo '<td style="display:none" id="pena">'.($res[0]->amount_penalty).'</td>';
                echo '<td style="display:none" id="actd">'.($deliv_date).'</td>';
                echo '<td style="display:none" id="cpar">'.($res[0]->check_partial).'</td>';
                echo '<td style="display:none" id="cpen">'.($res[0]->check_penalty).'</td>';
                exit;
            }
        } else {
            $res = $this->mcd->get_performance_q($po);
            if ($res != false) {
                $count = 0;
                $temp = '';
                $tamp_cat = '';
                $total = 0;
                foreach($res as $k => $v) {
                    $count++;
                    if ($tamp_cat != $v->category)
                        echo '<tr><td class="text-left" colspan="7"><strong>'.$v->category.'</strong></td></tr>';
                    $tamp_cat = $v->category;

                    $offset = 0;
                    $custom_desc = $this->get_string_input($v->description, '#');
                    if ($ch[0]->status_edit == 2) {
                        foreach ($custom_desc as $custom) {
                            $replacer = '<input type="text" name="' . $custom['key'] . '" id="' . $custom['key'] . '" value="' . $v->{$custom['key']} . '" onchange="reformat(this, 100, 0)"></input> %';
                            $v->description = substr_replace($v->description, $replacer, $custom['start'] + $offset, $custom['length']);
                            $offset = strlen($replacer) - $custom['length'];
                        }
                    } else {
                        foreach ($custom_desc as $custom) {
                            $replacer = '<input type="text" name="' . $custom['key'] . '" id="' . $custom['key'] . '" value="' . $v->{$custom['key']} . '" onchange="reformat(this, 100, 0)"></input> %';
                            
                            //$replacer = ($v->{$custom['key']} > 0 ? $v->{$custom['key']} : 0.00) . ' %';
                            $v->description = substr_replace($v->description, $replacer, $custom['start'] + $offset, $custom['length']);
                            $offset = strlen($replacer) - $custom['length'];
                        }
                    }

                    echo '<tr>
                        <td>'.$count.'</td>
                        <td>'.$v->description.'</td>';
                    for ($val = 1; $val <= 4; $val++) {
                        if ($ch[0]->status_edit == 2) {
                            if ($val == $v->rating)
                                echo '<td class="text-center"><input type="radio" value="'.$val.'" id="'.str_replace(' ', '',$v->category).'_'.$v->id.'" name="'.str_replace(' ', '',$v->category).'_'.$v->id.'" data-cor-param="'.str_replace(' ', '',$v->category).'" onclick="count_score()" checked></td>';
                            else
                                echo '<td class="text-center"><input type="radio" value="'.$val.'" id="'.str_replace(' ', '',$v->category).'_'.$v->id.'" name="'.str_replace(' ', '',$v->category).'_'.$v->id.'"  data-cor-param="'.str_replace(' ', '',$v->category).'" onclick="count_score()"></td>';
                        } else {
                            if ($v->rating == $val) {
                                $temp = ($val / ($v->target_answer)) * ($v->weightage);
                                $total += $temp;
                                echo '<td class="text-center"><i class="fa fa-check success"></i></td>';
                            } else {
                                echo '<td class="text-center"></td>';
                            }
                        }
                    }
                    echo '<td>'.$temp.'</td></tr>';
                    $temp = '';
                }
                echo '<td style="display:none"><input type="text" value='.$count.' name="total"></input></td>';
                echo '<td style="display:none"><input type="text" value='.$total.' id="total_nilai"></input></td>';
                if ($res[0]->actual_deliv_date == '0000-00-00' || $res[0]->actual_deliv_date == '1970-01-01' || $res[0]->actual_deliv_date == null) {
                    $deliv_date = '';
                } else {
                    if ($ch[0]->status_edit == 2) {
                        $deliv_date = date('Y-m-d', strtotime($res[0]->actual_deliv_date));
                    } else {
                        $deliv_date = date('j F Y', strtotime($res[0]->actual_deliv_date));
                    }
                }
                echo '<td style="display:none" id="tcpm">0</td>';
                echo '<td style="display:none" id="stat">'.($ch[0]->status_edit).'</td>';
                echo '<td style="display:none" id="coma">'.($res[0]->amount_comp).'</td>';
                echo '<td style="display:none" id="pena">'.($res[0]->amount_penalty).'</td>';
                echo '<td style="display:none" id="actd">'.($deliv_date).'</td>';
                echo '<td style="display:none" id="cpar">'.($res[0]->check_partial).'</td>';
                echo '<td style="display:none" id="cpen">'.($res[0]->check_penalty).'</td>';
                echo '<td style="display:none"><input type="text" value="'.@$res[0]->tid.'" id="tid"></input></td>';
                exit;
            }
        }

        if (!$res) {
            echo "<tr><td colspan='7' class='text-center'> No Data</td></tr>";
            exit;
        }
    }

    public function get_string_input($input, $sign) {
        $last_pos = 0;
        $start_pos = 0;
        $keys = array();
        while (($last_pos = strpos($input, $sign, $last_pos)) !== false) {
            if ($start_pos == 0) {
                $start_pos = $last_pos;
            } else {
                $key_len = $last_pos - ($start_pos + strlen($sign));
                $key = substr($input, $start_pos + strlen($sign), $key_len);
                $keys[] = array('key' => $key, 'start' => $start_pos, 'length' => $key_len + 2 * strlen($sign));
                $start_pos = 0;
            }
            $last_pos = $last_pos + strlen($sign);
        }
        return $keys;
    }

/* ===========================================-------- get data Table START------- ====================================== */
    public function get_header() {
        $po = $this->input->post('po');
        $vendor = $this->input->post('vendor');
        $res = $this->mcd->get_header($po, $vendor);
        if ($res) {
            $res[0]->createdate = date('j F Y', strtotime($res[0]->createdate));
            $res[0]->delivery_date = date('j F Y', strtotime($res[0]->delivery_date));
        }
        return $this->output($res);
    }

    public function show_list2() {
        $dt = array();
        $res = $this->mcd->get_list2();
        if ($res != false) {
            foreach ($res as $k => $v) {
                $dt[$k][0] = $k + 1;
                $dt[$k][1] = $v['po_no'];
                $dt[$k][2] = $v['type_dt'];
                $dt[$k][3] = $v['cpm'];
                $dt[$k][4] = $v['t_cor_id'];
                $dt[$k][5] = $v['title'];
                $dt[$k][6] = $v['jabatan'];
                $dt[$k][7] = "<span class='badge badge badge-pill badge-light'>".$v['status']."</span>";
                $dt[$k][8] = '<button class="btn btn-sm btn-success" onclick=proc("'.$v['sequence'].'","'.$v['supplier_id'].'","'.$v['po_no'].'","'.$v['t_cor_id'].'",'.$v["type"].','.$v["cpm"].')>Detail</button>';
            }
            $this->output($dt);
        } else {
            $this->output($dt);
        }
    }

    public function get_data_assigned() {
        $id = stripslashes($_POST['id']);
        $po = stripslashes($_POST['po']);
        $cor = stripslashes($_POST['tid']);
        $type = stripslashes($_POST['type']);

        $ch = $this->mcd->check_condition($po, $id, $type);
        $res = $this->mcd->get_data_assigned($id, $po, $cor);

        if (count($res) >= 1) {
            $dt = array();
            foreach($res as $k => $v) {
                $dt[$k]['user_id'] = $v['user_id'];
                $dt[$k]['roles_id'] = $v['role_id'];
                $dt[$k]['name'] = $v['name'];
                $dt[$k]['sequence'] = $v['sequence'];
                $dt[$k]['type'] = $v['type'];
            }

            $temp = 0;
            $type = 'init';
            $type2 = 'init';
            $cnt = 1;
            $sel = 0;

            foreach($res as $k => $v) {
                $cond = "";
                if($temp != $v['sequence'] || ($temp == $v['sequence'] && $v['type']!=$type)) {
                    if ($v['type']=="PARAREL")
                        $sel = 1;
                    else
                        $sel = 0;
                    if ($v['sequence'] == 1)
                        $cond = 'Cor Preparation';
                    else if ($v['sequence'] == 2)
                        $cond = 'Cor Preparation Approval';
                    else if ($v['sequence'] == 3)
                        $cond = 'Cor Performed';
                    else
                        $cond = 'Cor Review Approval';

                    echo "<tr>
                        <td>" . $cnt . "</td>
                        <td>" . $cond . "</td>
                        <td><span>" . $v['name'] . "</span></td>
                        <td>" . $v['role_desc'] . "</td>";
                    if ($v['status'] == "Approved" || $v['status'] == "Prepared")
                        echo "<td><span class='badge badge badge-pill badge-success'>" . $v['status'] . "</span></td>";
                    else if ($v['status'] == "Rejected")
                        echo "<td><span class='badge badge badge-pill badge-danger'>" . $v['status'] . "</span></td>";
                    else
                        echo "<td><span class='badge badge badge-pill badge-light'>" . $v['status'] . "</span></td>";
                    echo "<td>" . ($v['date'] == '' ? '' : date('M j, Y H:i', strtotime($v['date']))) . "</td>
                    <td>" . $v['note'] . "</td>";
                    $cnt++;
                }
                $temp = $v['sequence'];
                $type = $v['type'];
            }
            exit;
        }
        else
            echo "<tr><td colspan='7'>Not Found</td></tr>";
        exit;
    }
}
?>