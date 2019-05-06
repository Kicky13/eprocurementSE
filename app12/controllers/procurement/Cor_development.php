<?php
class Cor_development extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('procurement/M_cor_development', 'mcd');
        $this->load->model('vendor/M_vendor');
        $this->load->model('vendor/m_all_intern', 'mai');
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
        $data['init_from_cpm'] = 1;
        $this->template->display('procurement/V_cor_development', $data);
    }
/* ===========================================-------- API START------- ====================================== */
    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }
/* ===========================================-------- get data START------- ====================================== */
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

    public function process()
    {
        $id=stripslashes($this->input->post('entity_id'));
        $res=$this->mbp->get_template($id);
        if($res != false)
            $this->output($res);
        else
            $this->output("false");
    }

    public function update_user()
    {
        $sel=stripslashes($this->input->post('sel'));
        if($sel != '0')
            $sel =1;
        else
            $sel =0;

        $usr=$this->input->post('usr');
        $dt=array(
            "idusr"=>substr($usr,0,strpos($usr,"_")),
            "seq"=>$this->input->post('seq'),
            "sel"=>$sel,
            "po"=>$this->input->post('po'),
            "idvendor"=>$this->input->post('entid'),
            "roles"=>substr($usr,strpos($usr,"_")+1,strlen($usr))
        );

        $res=$this->mcd->update_user($dt);
        if($res != false)
            $this->output(array("status" => "Success"));
        else
            $this->output(array("status" => "Failed"));
    }

    public function upload_file() {
        $result = false;
        $po = $this->input->post('po_id');
        $doc_type = stripslashes($this->input->post('file_unggah_tipe'));
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

    public function send_data($sel) {
        $miss = false;
        foreach ($this->input->post() as $key => $value) {
            $key = substr($key, 0, -1);
            $value = substr($value, 0, 1);
            if ($key == 'user' && $value == '0') {
                $miss = true;
                break;
            }
        }

        if (strpos($_SESSION['ROLES'], ',29,') === false || $miss) {
            $this->output(array("status" => "Failed", "msg" => "Sorry, there are unchosen assignees!"));
        } else {
            $po = stripslashes($this->input->post('po_id'));
            $idV = stripslashes($this->input->post('vendor_id'));
            $type = stripslashes($this->input->post('from_cpm'));
            $idC = '';

            if ($sel == 1) {
                $idT = $this->mcd->get_id($po);

                if (count($idT) < 1) {
                    $this->output(array("status" => "Failed", "msg" => "Oops, something went wrong!"));
                    exit;
                }

                $idC = $idT[0]['id'];
                $conval =  $this->mcd->get_con_val($po, $idV);
                $dt = array(
                    "id" => $idT[0]['id'],
                    "vendor_id" => $idV,
                    "po_no" => $po,
                    "type" => $type,
                    "input_contract" => $conval[0]['tkdn_value'],
                    "create_date" => date("Y-m-d H:i:s"),
                    "create_by" => $_SESSION['ID_USER']
                );

                $log_desc = 'Prepared by ' . $_SESSION['NAME'];
                $log_note = '';
                $res = $this->mcd->add_data_perf($dt);
                if ($res)
                    $res = $this->mcd->add_data($idC, $idV, $po);
            } else if ($sel == 2) {
                $idC = stripslashes($this->input->post('cor_id'));
                $res = $this->mcd->get_data($idV, $idC);
                $data_update = array();
                for ($i = 0; $i < count($res); $i++) {
                    if ($this->input->post('user' . ($i + 1))) {
                        $temp = explode('_', $this->input->post('user' . ($i + 1)));

                        if ($temp[1] == $res[$i]['role_id']) {
                            $entry['user_id'] = $temp[0];
                            $entry['id'] = $res[$i]['id'];
                        } else {
                            $entry['user_id'] = $res[$i]['user_id'];
                            $entry['id'] = $res[$i]['id'];
                        }
                    } else {
                        $entry['user_id'] = $res[$i]['user_id'];
                        $entry['id'] = $res[$i]['id'];
                    }

                    if ($i == 0) {
                        $entry['status_approve'] = 1;
                        $entry['note'] = 'Resubmit - ' . $this->input->post('note');
                    } else {
                        $entry['status_approve'] = 0;
                        $entry['note'] = $res[$i]['note'];
                    }

                    array_push($data_update, $entry);
                }
                $log_desc = 'Resubmitted by ' . $_SESSION['NAME'];
                $log_note = $this->input->post('note');
                $res = $this->mcd->edit_data($data_update);
            } else {
                $res = false;
            }

            if ($res != false) {
                if ($sel == 1) {
                    $this->mcd->delete_temp($idV, $po);
                }

                $res = $this->mcd->get_email_dest($idC);
                if ($res != false) {
                    $rec = $res[0]['recipients'];
                    $rec_role = $res[0]['rec_role'];
                    $user = $this->mcd->get_email_rec($rec, $rec_role);
                    $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
                    $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";
                    $dt = array(
                        'dest' => $user,
                        'img1' => $img1,
                        'po' => $po,
                        'img2' => $img2,
                        'title' => $res[0]['TITLE'],
                        'open' => $res[0]['OPEN_VALUE'],
                        'close' => $res[0]['CLOSE_VALUE']
                    );
                    if ($user != null) {
                        $email = $this->send_mail($dt);
                        if ($email == false)
                            $this->output(array('status' => 'Failed', 'msg' => 'Oops, something went wrong!'));
                    }
                }

                $log = array(
                    "module_kode" => "cor",
                    "data_id" => $idC,
                    "description" => $log_desc,
                    "keterangan" => $log_note,
                    "created_at" => date('Y-m-d H:i:s'),
                    "created_by" => $_SESSION['ID_USER'],
                );

                $log = $this->map->add('log_history', $log);
                $this->output(array("status" => "Success", "msg" => "Data has been submitted!"));
            }
            else
                $this->output(array("status" => "Failed", "msg" => "Oops, something went wrong!"));
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
        $no_msr = $this->mcd->get_msr($content['po']);

        if (count($content['dest']) != 0 ) {
            foreach ($content['dest'] as $k => $v) {
                $this->load->library('email', $config);
                $this->email->initialize($config);
                $this->email->from($mail['email'], '[SYSTEM] EPROC SUPREME ENERGY');
                $this->email->subject($content['title']);
                $ctn = ' <p>' . $content['img1'] . '</p>
                        <br>' . $open = str_replace("no_msr", $no_msr[0]['msr_no'], $content['open']) . '
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

    public function get_performance_q($sel, $po) {
        $id = 0;
        $type = stripslashes($this->input->post('from_cpm'));
        if ($sel == 2)
            $id = stripslashes($this->input->post('id'));
        $res = false;
        if ($type == 2) {
            $res = $this->mcd->get_performance_q_cpm($id, $po);
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

                    echo'<tr>
                        <td>' . $count . '</td>
                        <td>' . $v->specific_kpi . '</td>
                        <td class="text-center">' . $v->kpi_weight . ' %</td>
                        <td>' . $v->scoring_method . '</td>
                        <td class="text-center">' . $v->target_score . '</td>
                        <td class="text-center">' . $v->target_weight . '</td>';
                    // if ($sel == 2) {
                        if ($v->rating == null)
                            $v->rating = 0;
                        $temp = ($v->cat_weight * $v->kpi_weight * $v->rating / 10000);
                        $total += $temp;
                        echo '<td class="text-center">' . $v->rating . '</td>
                        <td class="text-center" name="inp_weight">' . $temp . '</td>
                        </tr>';
                    // } else {
                    //     echo '<td class="text-center"><input name="cat_' . $v->id . '" disabled></td>
                    //     <td class="text-center" name="inp_weight">0</td>
                    //     </tr>';
                    // }
                    $total_weight += $v->target_weight;
                }
                echo '<td style="display:none"><input type="text" value=' . $count . ' name="total"></input></td>';
                echo '<td style="display:none" id="cpmttl">'.($total_weight).'</td>';
                if ($id != 0) {
                    echo '<td style="display:none"><input type="text" value='.$total.' id="total_nilai"></input></td>';
                    if ($res[0]->actual_deliv_date == '0000-00-00' || $res[0]->actual_deliv_date == '1970-01-01' || $res[0]->actual_deliv_date == null) {
                        $deliv_date = '';
                    } else {
                        $deliv_date = date('j F Y', strtotime($res[0]->actual_deliv_date));
                    }
                    echo '<td style="display:none" id="cinc">'.($res[0]->input_contract).'</td>';
                    echo '<td style="display:none" id="cina">'.($res[0]->input_actual).'</td>';
                    echo '<td style="display:none" id="coma">'.($res[0]->amount_comp).'</td>';
                    echo '<td style="display:none" id="pena">'.($res[0]->amount_penalty).'</td>';
                    echo '<td style="display:none" id="actd">'.($deliv_date).'</td>';
                    echo '<td style="display:none" id="cpar">'.($res[0]->check_partial).'</td>';
                    echo '<td style="display:none" id="cpen">'.($res[0]->check_penalty).'</td>';
                }
                exit;
            }
        } else {
            $res = $this->mcd->get_performance_q($id, $po);
            if ($res != false) {
                $count = 0;
                $temp = '';
                $tamp_cat = '';
                $total = 0;
                foreach ($res as $k => $v) {
                    $count++;
                    if ($tamp_cat != $v->category)
                        echo '<tr><td class="text-left" colspan="7"><strong>' . $v->category . '</strong></td></tr>';
                    $tamp_cat = $v->category;

                    $offset = 0;
                    $custom_desc = $this->get_string_input($v->description, '#');
                    if ($id == 0) {
                        foreach ($custom_desc as $custom) {
                            $replacer = '0.00 %';
                            $v->description = substr_replace($v->description, $replacer, $custom['start'] + $offset, $custom['length']);
                            $offset = strlen($replacer) - $custom['length'];
                        }
                    } else {
                        foreach ($custom_desc as $custom) {
                            $replacer = ($v->{$custom['key']} > 0 ? $v->{$custom['key']} : '0.00') . ' %';
                            $v->description = substr_replace($v->description, $replacer, $custom['start'] + $offset, $custom['length']);
                            $offset = strlen($replacer) - $custom['length'];
                        }
                    }

                    echo'<tr>
                        <td>' . $count . '</td>
                        <td>' . $v->description . '</td>';

                    for ($val = 0; $val < 5; $val++) {
                        $cat = $v->category;
                        $pos1 = strpos($cat, ' ');
                        if ($pos1 != false || $pos1 > 0)
                            $cat = str_replace(' ', '', $cat);
                        if ($val == 0) {
                            echo '<input type="hidden" value="' . $val . '" id="' . $cat . '_' . $v->id . '" name="' . $cat . '_' . $v->id . '">';
                        } else {
                            if ($sel == 2) {
                                if ($v->rating == $val) {
                                    if ($id == 0) {
                                        $temp = $val;
                                    } else {
                                        $temp = ($val / ($v->target_answer)) * ($v->weightage);
                                        $total += $temp;
                                    }
                                    echo '<td class="text-center"><i class="fa fa-check success"></i></td>';
                                } else
                                    echo '<td></td>';
                            } else {
                                echo '<td class="text-center">
                                <input type="radio" value="' . $val . '" id="' . $cat . '_' . $v->id . '" name="' . $cat . '_' . $v->id . '"  disabled>
                                </td>';
                            }
                        }
                    }
                    echo '<td>' . $temp . '</td></tr>';
                    $temp = '';
                }
                echo '<td style="display:none"><input type="text" value=' . $count . ' name="total"></input></td>';
                if ($id != 0) {
                    echo '<td style="display:none"><input type="text" value='.$total.' id="total_nilai"></input></td>';
                    if ($res[0]->actual_deliv_date == '0000-00-00' || $res[0]->actual_deliv_date == '1970-01-01' || $res[0]->actual_deliv_date == null) {
                        $deliv_date = '';
                    } else {
                        $deliv_date = date('j F Y', strtotime($res[0]->actual_deliv_date));
                    }
                    echo '<td style="display:none" id="coma">'.($res[0]->amount_comp).'</td>';
                    echo '<td style="display:none" id="pena">'.($res[0]->amount_penalty).'</td>';
                    echo '<td style="display:none" id="actd">'.($deliv_date).'</td>';
                    echo '<td style="display:none" id="cpar">'.($res[0]->check_partial).'</td>';
                    echo '<td style="display:none" id="cpen">'.($res[0]->check_penalty).'</td>';
                }
                exit;
            }
        }

        if (!$res) {
            echo "<tr><td colspan='7' class='text-center'> No Data</td></tr>";
            exit;
        }
    }

    public function get_invitation()
    {
        $id=stripslashes($this->input->post('entity_id'));
        $res=$this->mbp->get_template($id);
        if($res != false)
            $this->output($res);
        else
            $this->output("false");
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
    public function check_maker() {
        $cor = $this->input->post('cor');
        $po = $this->input->post('po');
        $res = $this->mcd->check_maker($cor, $po);
        if (count($res) > 0 && $_SESSION['ID_USER'] == $res[0]['user_id']) {
            $this->output('true');
        } else {
            return false;
        }
    }

    public function get_data_assigned($id, $po) {
        $cek = $this->mcd->check_data_temp($id, $po);

        if ($cek == null || $cek == false)
            $cek = $this->mcd->insert_temp_data($id, $po);

        $job = $this->mcd->get_role_assigned($po, $id);
        $user = $this->mcd->get_user_assigned();
        $owner = $this->mcd->get_owner_assigned($po);

        if (count($job) > 0 && count($user) > 0) {
            $count = 1;
            foreach ($job as $val1) {
                $sel = 1;
                if ($val1['type'] == "SERIAL")
                    $sel = 0;

                if ($val1['sequence'] == 1)
                    $cond = 'Cor Preparation';
                else if ($val1['sequence'] == 2)
                    $cond = 'Cor Preparation Approval';
                else if ($val1['sequence'] == 3)
                    $cond = 'Cor Performed';
                else
                    $cond = 'Cor Review Approval';

                if ($val1['role_id'] == 29) {
                    $name = 'Invalid';
                    foreach ($user as $val2) {
                        if ($val2['user_id'] == $_SESSION['ID_USER'] && $val2['user_role'] == 29) {
                            $name = $val2['user_name'];
                            $dt = array(
                                "idusr" => $_SESSION['ID_USER'],
                                "seq" => $val1['sequence'],
                                "sel" => $sel,
                                "po" => $po,
                                "idvendor" => $id,
                                "roles" => 29
                            );
                            $this->mcd->update_user($dt);
                        }
                    }
                    echo "<tr>
                            <td>" . $count . "</td>
                            <td>" . $cond . "</td>
                            <td>" . $name . "</td>
                            <td>" . $val1['role_desc'] . "</td>
                            <td><span class='badge badge badge-pill badge-light'>Unconfirmed</span></td>
                            <td></td>
                            <td></td>
                        </tr>";
                } else if ($val1['edit_content'] == 2) {
                    $name = 'Invalid';
                    foreach ($owner as $val2) {
                        $name = $val2['user_name'];
                        $role_owner = explode(',', $val2['role']);
                        $dt = array(
                            "idusr" => $val2['user_id'],
                            "seq" => $val1['sequence'],
                            "sel" => $sel,
                            "po" => $po,
                            "idvendor" => $id,
                            "roles" => (count($role_owner) > 1 ? $role_owner[1] : 0)
                        );
                        $this->mcd->update_user($dt);
                    }
                    echo "<tr>
                            <td>" . $count . "</td>
                            <td>" . $cond . "</td>
                            <td>" . $name . "</td>
                            <td>User Representative</td>
                            <td><span class='badge badge badge-pill badge-light'>Unconfirmed</span></td>
                            <td></td>
                            <td></td>
                        </tr>";
                } else {
                    echo "<tr>
                            <td>" . $count . "</td>
                            <td>" . $cond . "</td>
                            <td>
                            <select id='user" . $count . "' name='user" . $count . "' onchange='choose_user(this.value, " . $val1['sequence'] . ",\"" . $po . "\", " . $id.", " . $sel . ")' class='select2 form-control valid'>
                            <option value='0_" . $val1['role_id'] . "' " . ($val1['cur_user'] == 0 ? 'selected' : '') . "> Please Select</option>
                            <option value='%_" . $val1['role_id'] . "' " . ($val1['cur_user'] == '%' ? 'selected' : '') . "> All User</option>";
                    foreach ($user as $val2) {
                        if ($val1['role_id'] == $val2['user_role']) {
                            echo "<option value='" . $val2['user_id'] . "_" . $val2['user_role'] . "' " . ($val1['cur_user'] == $val2['user_id'] ? 'selected' : '') . ">" . $val2['user_name'] . "</option>";
                        }
                    }
                    echo "</select></td>
                        <td>" . $val1['role_desc'] . "</td>
                        <td><span class='badge badge badge-pill badge-light'>Unconfirmed</span></td>
                        <td></td>
                        <td></td>
                        </tr>";
                }
                $count++;
            }
        } else
            echo "<tr><td colspan='7'>Not Found</td></tr>";
        exit;
    }

    public function show_app() {
        $id = $this->input->post('id');
        $cor = $this->input->post('cor');
        $po = $this->input->post('po');
        $sel = $this->input->post('sel');
        $res = $this->mcd->get_data($id, $cor);

        if (count($res) > 0) {
            $tamp = 0;
            $count = 1;
            if ($sel == 1 && $res[0]['user_id'] == $_SESSION['ID_USER']) {
                $user = $this->mcd->get_user_assigned();
                $owner = $this->mcd->get_owner_assigned($po);
                foreach ($res as $val1) {
                    $sel = 1;
                    if ($val1['type'] == "SERIAL")
                        $sel = 0;

                    if ($val1['sequence'] == 1)
                        $cond = 'Cor Preparation';
                    else if ($val1['sequence'] == 2)
                        $cond = 'Cor Preparation Approval';
                    else if ($val1['sequence'] == 3)
                        $cond = 'Cor Performed';
                    else
                        $cond = 'Cor Review Approval';

                    if ($val1['status'] == "Approved" || $val1['status'] == "Prepared")
                        $stat_color = "success";
                    else if ($val1['status'] == "Rejected")
                        $stat_color = "danger";
                    else
                        $stat_color = "light";

                    if ($val1['role_id'] == 29) {
                        $name = 'Invalid';
                        foreach ($user as $val2) {
                            if ($val1['user_id'] == $val2['user_id'] && $val2['user_role'] == 29) {
                                $name = $val2['user_name'];
                                break;
                            }
                        }
                        echo "<tr>
                                <td>" . $count . "</td>
                                <td>" . $cond . "</td>
                                <td>" . $name . "</td>
                                <td>" . $val1['role_desc'] . "</td>
                                <td><span class='badge badge badge-pill badge-" . $stat_color . "'>" . $val1['status'] . "</span></td>
                                <td>" . ($val1['date'] == '' ? '' : date('M j, Y H:i', strtotime($val1['date']))) . "</td>
                                <td>" . $val1['note'] . "</td>
                            </tr>";
                    } else if ($val1['edit_content'] == 2) {
                        $name = 'Invalid';
                        foreach ($owner as $val2) {
                            $name = $val2['user_name'];
                            $role_owner = explode(',', $val2['role']);
                            $dt = array(
                                "idusr" => $val2['user_id'],
                                "seq" => $val1['sequence'],
                                "sel" => $sel,
                                "po" => $po,
                                "idvendor" => $id,
                                "roles" => (count($role_owner) > 1 ? $role_owner[1] : 0)
                            );
                            $this->mcd->update_user_old($dt, $cor);
                        }
                        echo "<tr>
                                <td>" . $count . "</td>
                                <td>" . $cond . "</td>
                                <td>" . $name . "</td>
                                <td>User Representative</td>
                                <td><span class='badge badge badge-pill badge-" . $stat_color . "'>" . $val1['status'] . "</span></td>
                                <td>" . ($val1['date'] == '' ? '' : date('M j, Y H:i', strtotime($val1['date']))) . "</td>
                                <td>" . $val1['note'] . "</td>
                            </tr>";
                    } else {
                        echo "<tr>
                                <td>" . $count . "</td>
                                <td>" . $cond . "</td>
                                <td>
                                <select id='user" . $count . "' name='user" . $count . "' class='select2 form-control valid'>
                                <option value='0_" . $val1['role_id'] . "' " . ($val1['user_id'] == 0 ? 'selected' : '') . "> Please Select</option>
                                <option value='%_" . $val1['role_id'] . "' " . ($val1['user_id'] == '%' ? 'selected' : '') . "> All User</option>";
                        foreach ($user as $val2) {
                            if ($val1['role_id'] == $val2['user_role']) {
                                echo "<option value='" . $val2['user_id'] . "_" . $val2['user_role'] . "' " . ($val1['user_id'] == $val2['user_id'] ? 'selected' : '') . ">" . $val2['user_name'] . "</option>";
                            }
                        }
                        echo "</select></td>
                            <td>" . $val1['role_desc'] . "</td>
                            <td><span class='badge badge badge-pill badge-" . $stat_color . "'>" . $val1['status'] . "</span></td>
                            <td>" . ($val1['date'] == '' ? '' : date('M j, Y H:i', strtotime($val1['date']))) . "</td>
                            <td>" . $val1['note'] . "</td>
                            </tr>";
                    }
                    $count++;
                }
            } else {
                foreach ($res as $k => $v) {
                    $name = $v['name'];

                    if ($v['sequence'] == 1)
                        $cond = 'Cor Preparation';
                    else if ($v['sequence'] == 2)
                        $cond = 'Cor Preparation Approval';
                    else if ($v['sequence'] == 3)
                        $cond = 'Cor Performed';
                    else
                        $cond = 'Cor Review Approval';

                    if ($v['status'] == "Approved" || $v['status'] == "Prepared")
                        $stat_color = "success";
                    else if ($v['status'] == "Rejected")
                        $stat_color = "danger";
                    else
                        $stat_color = "light";

                    echo "<tr>
                            <td>" . $count . "</td>
                            <td>" . $cond . "</td>
                            <td>" . $name . "</td>
                            <td>" . $v['role_desc'] . "</td>
                            <td><span class='badge badge badge-pill badge-" . $stat_color . "'>" . $v['status'] . "</span></td>
                            <td>" . ($v['date'] == '' ? '' : date('M j, Y H:i', strtotime($v['date']))) . "</td>
                            <td>" . $v['note'] . "</td>
                        </tr>";
                    $tamp = $v['sequence'];
                    $count++;
                }
            }
        } else
            echo "<tr><td colspan='7'>Not Found</td></tr>";
        exit;
    }

    public function get_upload() {
        $dt = array();
        $po = $this->input->post('po');
        $sel = $this->input->post('sel');
        $res = $this->mcd->get_upload($po);
        if ($res != false) {
            $count = 1;
            if ($sel == 1 || $sel == 2) {
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

    public function get_history() {
        $cor = $this->input->post('cor');
        $vendor = $this->input->post('vendor');
        $res = $this->mcd->get_history($cor);
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
        $from_cpm = $this->input->post('init_from_cpm');
        $res = $this->mcd->get_list_prepared($from_cpm);
        if ($res != false) {
            foreach($res as $k => $v) {
                if($v['po_no'] != null) {
                    $dt[$k][0] = $k+1;
                    $dt[$k][1] = $v['po_no'];
                    $dt[$k][2] = $v['type'];
                    $dt[$k][3] = $v['title'];
                    $dt[$k][4] = $v['company'];
                    $dt[$k][5] = $v['NAMA'];
                    $dt[$k][6] = $v['ABBREVIATION'];
                    $dt[$k][7] = $v['value'];
                    $dt[$k][8] = '';
                    $dt[$k][9] = '';
                    // if ($v['cpm'] == null) {
                    //     $dt[$k][10] = '<button class="btn btn-sm btn-success process" id='.$v["id_vendor"].'>COR</button>';
                    // } else {
                    //     $dt[$k][10] = '<button class="btn btn-sm btn-success process" id='.$v["id_vendor"].'>COR</button><button class="btn btn-sm btn-success process-cpm" id='.$v["id_vendor"].'>COR - CPM</button>';
                    // }
                    if ($from_cpm == 2) {
                        $dt[$k][10] = '<button class="btn btn-sm btn-success process-cpm" id='.$v["id_vendor"].'>COR - CPM</button>';
                    } else {
                        $dt[$k][10] = '<button class="btn btn-sm btn-success process" id='.$v["id_vendor"].'>COR</button>';
                    }
                }
            }
            $this->output($dt);
        } else {
            $this->output($dt);
        }
    }

    public function get_list_progress() {
        $dt = array();
        $from_cpm = $this->input->post('init_from_cpm');
        $res = $this->mcd->get_list_progress($from_cpm);
        if ($res != false) {
            foreach ($res as $k => $v) {
                $dt[$k][0] = $k + 1;
                $dt[$k][1] = $v['po_no'];
                $dt[$k][2] = $v['type'];
                $dt[$k][3] = $v['cpm'];
                $dt[$k][4] = $v['cor_id'];
                $dt[$k][5] = $v['title'];
                $dt[$k][6] = $v['jabatan'];
                if ($v['status_approve'] == 0) {
                    $dt[$k][7] = "<span class='badge badge badge-pill badge-light'>Unconfirmed</span>";
                } else if ($v['status_approve'] == 2) {
                    $dt[$k][7] = "<span class='badge badge badge-pill badge-danger'>Rejected</span>";
                } else {
                    $dt[$k][7] = "<span class='badge badge badge-pill badge-success'>Approved</span>";
                }
                $dt[$k][8] = '<button class="btn btn-sm btn-success process" name='.$v['sequence'].' id='.$v['supplier_id'].'>Detail</button>';
            }
            $this->output($dt);
        } else {
            $this->output($dt);
        }
    }

}
?>