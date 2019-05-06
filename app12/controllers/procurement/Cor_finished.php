<?php
class Cor_finished extends CI_Controller
{
    public function __construct() {
        parent::__construct();        
        $this->load->helper('url');
        $this->load->library('session');        
        $this->load->model('procurement/M_cor_finished', 'mcf');        
        $this->load->model('vendor/M_vendor');
        $this->load->model('vendor/m_all_intern', 'mai');        
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
        $data['cpm_rank'] = $this->mcf->get_cpm_rank();
        $this->template->display('procurement/V_cor_finished', $data);
    }    
/* ===========================================-------- API START------- ====================================== */
    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }
/* ===========================================-------- get data START------- ====================================== */
    public function get_header() {
        $po = $this->input->post('po');
        $vendor = $this->input->post('vendor');
        $res = $this->mcf->get_header($po, $vendor);
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

    public function get_performance_q() {
        $po = stripslashes($this->input->post('po'));
        $id = stripslashes($this->input->post('id'));
        $cpm = stripslashes($this->input->post('from_cpm'));

        $res = false;
        if ($cpm == 2) {
            $res = $this->mcf->get_performance_q_cpm($id, $po);
            if ($res != false) {
                $count = 0;
                $temp = '';
                $tamp_cat = '';
                $total = 0;
                foreach ($res as $k => $v) {
                    $count++;
                    if($tamp_cat != $v->category)
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
                        $temp = ($v->cat_weight * $v->kpi_weight * $v->rating / 10000);
                        $total += $temp;
                        echo '<td class="text-center">' . $v->rating . '</td>
                        <td class="text-center" name="cpmw_' . $v->id . '">' . $temp . '</td>
                        </tr>';
                    $total_weight += $v->target_weight;
                }
                echo '<td style="display:none"><input type="text" value='.$count.' name="total"></input></td>';
                echo '<td style="display:none" id="cpmttl">'.($total_weight).'</td>';
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
                exit;
            }
        } else {
            $res = $this->mcf->get_performance_q($id, $po);
            if ($res != false) {
                $count = 0;
                $temp = '';
                $tamp_cat = '';
                $total = 0;
                foreach ($res as $k => $v) {
                    $count++;
                    if($tamp_cat != $v->category)
                        echo '<tr><td class="text-left" colspan="7"><strong>'.$v->category.'</strong></td></tr>';
                    $tamp_cat = $v->category;

                    $offset = 0;
                    $custom_desc = $this->get_string_input($v->description, '#');
                    foreach ($custom_desc as $custom) {
                        $replacer = ($v->{$custom['key']} > 0 ? $v->{$custom['key']} : '0.00') . ' %';
                        $v->description = substr_replace($v->description, $replacer, $custom['start'] + $offset, $custom['length']);
                        $offset = strlen($replacer) - $custom['length'];
                    }

                    echo '<tr>
                        <td>'.$count.'</td>
                        <td>'.$v->description.'</td>';

                    for ($val = 1; $val <= 4; $val++) {
                        if ($v->rating == $val) {
                            $temp = $val / ($v->target_answer) * ($v->weightage);
                            $total += $temp;
                            echo '<td class="text-center"><i class="fa fa-check success"></i></td>';
                        } else {
                            echo '<td></td>';
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
                    $deliv_date = date('j F Y', strtotime($res[0]->actual_deliv_date));
                }
                echo '<td style="display:none" id="coma">'.($res[0]->amount_comp).'</td>';
                echo '<td style="display:none" id="pena">'.($res[0]->amount_penalty).'</td>';
                echo '<td style="display:none" id="actd">'.($deliv_date).'</td>';
                echo '<td style="display:none" id="cpar">'.($res[0]->check_partial).'</td>';
                echo '<td style="display:none" id="cpen">'.($res[0]->check_penalty).'</td>';
                exit;
            }
        }

        if (!$res) {
            $this->output();
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

    public function get_upload() {
        $dt = array();
        $po = $this->input->post('po');
        $res = $this->mcf->get_upload($po);
        if ($res != false) {
            $count = 1;
            foreach($res as $k => $v) {
                $dt[$k][0] = $count;
                $dt[$k][1] = ($v['type'] == 'memo' ? 'Memo' : ($v['type'] == 'scoring' ? 'Scoring Result' : 'Other'));
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

    public function get_history() {
        $cor = $this->input->post('cor');
        $vendor = $this->input->post('vendor');
        $res = $this->mcf->get_history($cor);
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

    public function get_list2() {
        $dt = array();
        $cpm_rank = $this->mcf->get_cpm_rank();
        $res = $this->mcf->get_list2();
        if ($res != false) {
            foreach ($res as $k => $v) {
                if ($v['cpm'] == 2) {
                    for ($i = 0; $i < count($cpm_rank); $i++) {
                        if ($v['total'] > $cpm_rank[$i]['value']) {
                            $score = $cpm_rank[$i]['description'];
                            break;
                        }
                    }
                } else {
                    $score = $v['score'];
                }
                $dt[$k][0] = $k + 1;
                $dt[$k][1] = $v['po_no'];
                $dt[$k][2] = $v['type'];
                $dt[$k][3] = $v['cpm'];
                $dt[$k][4] = $v['cor_id'];
                $dt[$k][5] = $v['title'];
                $dt[$k][6] = $score;
                $dt[$k][7] = "<span class='badge badge badge-pill badge-success'>".$v['status']."</span>";
                $dt[$k][8] = '<button class="btn btn-sm btn-success process" name='.$v['sequence'].' id='.$v['supplier_id'].'>Detail</button>';
            }
            $this->output($dt);
        } else {
            $this->output($dt);
        }
    }

    public function show_app() {
        $id = stripslashes($this->input->post('id'));
        $po = stripslashes($this->input->post('po'));
        $dt = array();
        $res = $this->mcf->get_data($id, $po);

        if (count($res) > 0) {
            $tamp = 0;
            $nama = '';
            $cond = '';
            $count = 0;
            foreach ($res as $k => $v) {
                $nama = $v['name'];

                if ($v['sequence'] == 1)
                    $cond = 'Order is Completed';
                else if ($v['sequence'] == 2)
                    $cond = 'Payment is 100% completed';
                else if ($v['sequence'] == 3)
                    $cond = 'Prepared by';
                else
                    $cond = 'Approve';

                if ($v['status'] == "Approved" || $v['status'] == "Prepared")
                    $stat_color = "success";
                else if ($v['status'] == "Rejected")
                    $stat_color = "danger";
                else
                    $stat_color = "light";

                $dt[$count][0] = $count + 1;
                $dt[$count][1] = $cond;
                $dt[$count][2] = $nama;
                $dt[$count][3] = $v['role_desc'];
                $dt[$count][4] = "<span class='badge badge badge-pill badge-" . $stat_color . "'>" . $v['status'] . "</span>";
                $dt[$count][5] = date('M j, Y H:i', strtotime($v['date']));
                $dt[$count][6] = $v['note'];
                $tamp = $v['sequence'];
                $count++;
            }
            $this->output($dt);
        } else
            $this->output($dt);
    }
}
?>