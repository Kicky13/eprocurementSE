<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Arf_notif_approval extends CI_Controller {

    protected $menu;

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'array', 'url'));
        $this->load->library('session');
        $this->load->model('m_base', 'mbs');
        $this->load->model('vendor/M_vendor', 'mvn');
        $this->load->model('vendor/M_all_intern', 'mai');
        $this->load->model('procurement/m_procurement', 'mpr');
        $this->load->model('procurement/arf/m_arf_po', 'map');
        $this->load->model('procurement/arf/m_arf_po_detail', 'mapd');
        $this->load->model('procurement/m_arf_notif_approval', 'mana');
    }

    public function index() {
        $cek = $this->mai->cek_session();
        $get_menu = $this->mvn->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data = $this->get_choice();
        $data['menu'] = $dt;
        $this->template->display('procurement/V_arf_notif_approval', $data);
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function get_list() {
        $dt = array();
        $res = $this->mana->get_list();
        if (count($res) > 0) {
            foreach ($res as $k => $v) {
                $dt[$k][0] = $k + 1;
                $dt[$k][1] = date('M j, Y', strtotime($v['doc_date']));
                $dt[$k][2] = $v['po_no'];
                $dt[$k][3] = $v['doc_no'];
                $dt[$k][4] = $v['po_type'];
                $dt[$k][5] = $v['po_title'];
                $dt[$k][6] = $v['requestor'];
                $dt[$k][7] = $v['department'];
                $dt[$k][8] = $v['abbr'];
                $dt[$k][9] = "<button class='btn btn-sm btn-success proc_get' data-seq='" . $v['sequence'] . "'>Go</button>";
            }
        }
        return $this->output($dt);
    }

    public function get_choice() {
        $this->load->model('setting/M_master_company', 'company')
                    ->model('setting/M_msrtype', 'msrtype')
                    ->model('other_master/M_currency', 'currency')
                    ->model('setting/M_pmethod', 'pmethod')
                    ->model('setting/M_pgroup', 'plocation')
                    ->model('setting/M_location', 'location')
                    ->model('setting/M_delivery_point', 'delivery_point')
                    ->model('setting/M_delivery_term', 'delivery_term')
                    ->model('setting/M_importation', 'importation')
                    ->model('setting/M_requestfor', 'requestfor')
                    ->model('setting/M_master_inspection', 'inspection')
                    ->model('setting/M_freight', 'freight')
                    ->model('setting/M_itemtype', 'itemtype')
                    ->model('setting/M_master_acc_sub', 'accsub')
                    ->model('procurement/M_msr', 'msr')
                    ->model('procurement/M_msr_item', 'msr_item')
                    ->model('procurement/M_msr_attachment', 'msr_attachment')
                    ->model('setting/M_itemtype_category', 'itemcat')
                    ->model('material/M_uom');

        $data = array();
        $opt_msr_type = array_pluck($this->msrtype->allActive(), 'MSR_DESC', 'ID_MSR');
        $data['opt_msr_type'] = array_filter($opt_msr_type, function($id_msr) {
            return in_array($id_msr, array('MSR01', 'MSR02'));
        }, ARRAY_FILTER_USE_KEY);

        $pmethods = $this->pmethod->allActive();
        $data['opt_pmethod'] = array_pluck($pmethods, 'PMETHOD_DESC', 'ID_PMETHOD');
        $data['opt_plocation'] = array_pluck($this->plocation->allActive(), 'PGROUP_DESC', 'ID_PGROUP');
        $currency = $this->currency->allActive();
        $data['opt_currency'] = array_pluck($currency, 'CURRENCY', 'ID');
        $data['opt_currency_abbr'] = array_pluck($currency, 'CURRENCY', 'ID');
        $data['opt_location'] = array_pluck($this->location->allActive(), 'LOCATION_DESC', 'ID_LOCATION');
        $data['opt_delivery_point'] = array_pluck($this->delivery_point->allActive(), 'DPOINT_DESC', 'ID_DPOINT');
        $data['opt_delivery_term'] = array_pluck($this->delivery_term->allActive(), 'DELIVERYTERM_DESC', 'ID_DELIVERYTERM');
        $data['opt_importation'] = array_pluck($this->importation->allActive(), 'IMPORTATION_DESC', 'ID_IMPORTATION');
        $data['opt_requestfor'] = array_pluck($this->requestfor->allActive(), 'REQUESTFOR_DESC', 'ID_REQUESTFOR');
        $data['opt_inspection'] = array_pluck($this->inspection->allActive(), 'INSPECTION_DESC', 'ID_INSPECTION');
        $data['opt_freight'] = array_pluck($this->freight->allActive(), 'FREIGHT_DESC', 'ID_FREIGHT');
        $data['opt_itemtype'] = array_pluck($this->itemtype->allActive(), 'ITEMTYPE_DESC', 'ID_ITEMTYPE');
        $data['opt_invtype'] = array_pluck($this->msr->m_msr_inventory_type(), 'description', 'id');
        $data['opt_attchtype'] = $this->msr_attachment->getTypes();
        $mapMsrTypeItemType = $this->msrtype->getMapItemType();

        $itemtype_category = $this->itemcat->byParentCategory();
        $data['opt_itemtype_category_by_parent'] = array_map(function($category) {
            return array_pluck($category, 'description', 'id');
        }, $itemtype_category);
        $data['opt_itemtype_category'] = array_pluck($this->itemcat->allActive(), 'description', 'id');

        $data['opt_uom'] = array();
        foreach($this->M_uom->allActive() as $uom) {
            $data['opt_uom'][$uom->MATERIAL_UOM] = $uom->MATERIAL_UOM.' ('.$uom->DESCRIPTION.')';
        }

        return $data;
    }

    public function get_cost_center() {
        $this->load->model('setting/M_master_costcenter', 'cost_center');
        $res = false;
        $cc = $this->cost_center->find_by_company($this->input->post('comp'));
        if ($cc) {
            foreach ($cc as $key => $value) {
                $res[$value->ID_COSTCENTER] = $value->ID_COSTCENTER . ' - ' . $value->COSTCENTER_DESC;
            }
        }
        return $this->output($res);
    }

    public function get_header() {
        $po = $this->input->post('po');
        $amd = $this->input->post('amd');
        $res = $this->mana->get_header($po, $amd);
        return $this->output($res);
    }

    public function create_main() {
        $po = $this->input->post('po');
        $amd = $this->input->post('amd');
        $res = $this->mana->create_main($po, $amd);
        if ($res) {
            $res->response_date = date('M j, Y', strtotime($res->response_date));
            return $this->output(array('status' => 'Success', 'msg' => 'Create main successful!', 'data' => $res));
        } else {
            return $this->output(array('status' => 'Failed', 'msg' => 'Oops, something went wrong!'));
        }
    }

    public function get_revision() {
        $po = $this->input->post('po');
        $amd = $this->input->post('amd');
        $res = $this->mana->get_revision($po, $amd);
        if ($res) {
            foreach ($res as $key => $value) {
                if ($value['type'] == 2 && $value['value'] != null)
                    $value['value'] = date('M j, Y', strtotime($value['value']));
                $res[$key] = $value;
            }
        }
        return $this->output($res);
    }

    public function get_upload() {
        $dt = array();
        $po = $this->input->post('po');
        $amd = $this->input->post('amd');
        $notif = $this->input->post('notif');
        $res = $this->mana->get_upload($po, $notif);
        if ($res != false) {
            $count = 1;
            foreach ($res as $k => $v) {
                $dt[$k][0] = $count;
                // $dt[$k][1] = 'Tipe';
                // $dt[$k][2] = 'Seq';
                $dt[$k][1] = $v['file_name'];
                $dt[$k][2] = date('M j, Y H:i', strtotime($v['create_date']));
                $dt[$k][3] = "<span class='badge badge-pill badge-success'>".$v['name']."</span>";
                $dt[$k][4] = "<button class='btn btn-sm btn-info btn-modif-upload' onclick='preview(".$v['id'].")'><i class='fa fa-file'></i></button>";
                $count++;
            }
        }
        return $this->output($dt);
    }

    public function download_file($param) {
        $param = explode('_', $param);
        $file_data = false;

        if (count($param) == 3) {
            $file_info = $this->mana->get_upload($param[0], $param[1], $param[2]);
            $file_name = $file_info[0]['file_name'];
            $file_path = $file_info[0]['file_path'];
            $file_type = $file_info[0]['file_type'];
            if (file_exists($file_path)) {
                $file_data = file_get_contents($file_path);
            }
        }

        if ($file_data) {
            header('Content-Description: File Transfer');
            header("Content-Type: " . $file_type);
            header("Content-Disposition: attachment; filename=" . $file_name);
            header('Content-Transfer-Encoding: binary');
            header("Content-length: " . filesize($file_path));
            header("Expires: 0");
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

            if (FALSE === strpos($_SERVER["HTTP_USER_AGENT"], 'MSIE ')) {
                header("Cache-Control: no-cache, must-revalidate");
            }
            header('Pragma: public');
            flush();

            ob_start();
            echo($file_data);
            ob_end_flush();
        } else {
            die("ERROR: Unable to open " . $file_name);
        }
    }

    public function get_item_ori() {
        $dt = array();
        $po = $this->input->post('po');
        $res = $this->mana->get_item_ori($po);
        if (count($res) > 0) {
            foreach ($res as $k => $v) {
                $dt[$k][0] = $k + 1;
                $dt[$k][1] = $v['item_type'];
                $dt[$k][2] = $v['material_desc'];
                $dt[$k][3] = $v['qty'];
                $dt[$k][4] = $v['uom'] . ' - ' . $v['uom_desc'];
                $dt[$k][5] = $v['is_modification'];
                $dt[$k][6] = $v['inv_type'];
                $dt[$k][7] = $v['costcenter_desc'];
                $dt[$k][8] = $v['id_accsub'] . ' - '.$v['accsub_desc'];
                $dt[$k][9] = $v['unitprice_base'];
                $dt[$k][10] = $v['total_price_base'];
            }
        }
        return $this->output($dt);
    }

    public function get_item_arf() {
        $dt = array();
        $po = $this->input->post('po');
        $amd = $this->input->post('amd');
        $res = $this->mana->get_item_arf($po, $amd);
        if (count($res) > 0) {
            foreach ($res as $k => $v) {
                $dt[$k][0] = $v['id'];
                $dt[$k][1] = $v['item_type'];
                $dt[$k][2] = $v['material_desc'];
                $dt[$k][3] = $v['qty'];
                $dt[$k][4] = $v['uom'] . ' - ' . $v['uom_desc'];
                $dt[$k][5] = $v['item_modification'];
                $dt[$k][6] = $v['inventory_type'];
                $dt[$k][7] = $v['costcenter'];
                $dt[$k][8] = $v['account_subsidiary'];
                $dt[$k][9] = $v['unit_price_base'];
                $dt[$k][10] = $v['total_price_base'];
            }
        }
        return $this->output($dt);
    }

    public function get_item_proc() {
        $dt = array();
        $po = $this->input->post('po');
        $amd = $this->input->post('amd');
        $res = $this->mana->get_item_proc($po, $amd);
        if (count($res) > 0) {
            $dt['type'] = $res[0]['sop_type'];
            foreach ($res as $k => $v) {
                $dt['data'][$k][0] = $k + 1;
                $dt['data'][$k][1] = $v['item_type'];
                $dt['data'][$k][2] = $v['material_desc'];
                $dt['data'][$k][3] = $v['qty1'];
                $dt['data'][$k][4] = $v['uom1'] . ' - ' . $v['uom_desc_1'];
                $dt['data'][$k][5] = ($v['uom2'] == null ? '-' : $v['qty2']);
                $dt['data'][$k][6] = ($v['uom2'] == null ? '-' : $v['uom2'] . ' - ' . $v['uom_desc_2']);
                $dt['data'][$k][7] = $v['item_modification'];
                $dt['data'][$k][8] = ($v['inv_type'] == 0 ? '-' : $v['inv_type_desc']);
                $dt['data'][$k][9] = $v['costcenter_desc'];
                $dt['data'][$k][10] = $v['id_accsub'] . ' - ' . $v['accsub_desc'];
            }
        }
        return $this->output($dt);
    }

    public function get_item_proc_single() {
        $id = $this->input->post('id');
        $res = $this->mana->get_item_proc_single($id);
        return $this->output($res);
    }

    public function get_approval() {
        $po = stripslashes($this->input->post('po'));
        $amd = stripslashes($this->input->post('amd'));
        $notif = stripslashes($this->input->post('notif'));
        $res = $this->mana->get_approval($po, $notif);
        $user = user();
        $roles = explode(",", $user->ROLES);
        $roles = array_values(array_filter($roles));

        if (count($res) > 0) {
            $no = 1;
            foreach ($res as $k => $v) {
                if ($v['sequence'] <> 1) {
                    if ($v['status_approve'] == 2) {
                        $status = "Rejected";
                    } elseif ($v['status_approve'] == 1) {
                        $status = "Approved";
                    } elseif ($v['status_approve'] == 0)
                    {
                        $status = "";
                    }

                    $dt[$k][0] = $no;
                    $dt[$k][1] = $v['role_desc'];
                    $dt[$k][2] = ($v['approve_by'] != null ? $v['app_name'] : ($v['user_id'] != '%' ? $v['user_name'] : 'Any User'));
                    $dt[$k][3] = $status;
                    $dt[$k][4] = ($v['update_date'] == null ? '' : dateToIndo($v['update_date']));
                    $dt[$k][5] = $v['note'];
                    $dt[$k][6] = ($v['status_approve'] == 0) ? "<button class='btn btn-sm btn-primary' data-toggle='modal' data-target='#modal_approve' onclick='sequenceClick($v[sequence])'>Approve/Reject</button>" : "";
                    $no++;
                }
            }
        }
        return $this->output($dt);
    }

    public function send_approval() {
        $po = stripslashes($this->input->post('po'));
        $amd = stripslashes($this->input->post('amd'));
        $notif = stripslashes($this->input->post('notif'));
        $seq = stripslashes($this->input->post('seq'));
        $type = stripslashes($this->input->post('type'));
        $note = stripslashes($this->input->post('modal_note'));

        $posted = array(
                    'status_approve' => $type,
                    'note' => $note,
                    'approve_by' => $this->session->ID_USER,
                    'update_date' => date('Y-m-d H:i:s')
                );

        $res = $this->mana->send_approval($po, $notif, $seq, $posted);

        if ($res != false) {
            $res = $this->mana->get_email_dest($po, $notif);
            if ($res != false) {
                $rec = $res[0]['recipients'];
                $rec_role = $res[0]['rec_role'];
                $user = $this->mana->get_email_rec($rec, $rec_role);
                if ($user != null) {
                    $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
                    $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";
                    $dt = array(
                        'dest' => $user,
                        'img1' => $img1,
                        'po' => $po,
                        'amd' => $amd,
                        'img2' => $img2,
                        'title' => $res[0]['TITLE'],
                        'open' => $res[0]['OPEN_VALUE'],
                        'close' => $res[0]['CLOSE_VALUE']
                    );
                    $email = $this->send_mail($dt);
                    if ($email == false)
                        $response = array("status" => "Failed", "msg" => "Oops, something went wrong!");
                }
            }

            $log = array(
                "module_kode" => "arfn",
                "data_id" => $notif,
                "description" => ($type == 1 ? 'Approved by ' : 'Rejected by') .  $this->session->NAME,
                "keterangan" => $note,
                "created_at" => date('Y-m-d H:i:s'),
                "created_by" => $this->session->ID_USER,
            );
            $log = $this->db->insert('log_history', $log);
            if ($type == 1) {
                $this->mana->set_notif_complete($po, $notif);

                $ap = $this->db->where(['status_approve'=>0,'doc_id'=>$notif])->get('t_approval_arf_notification');
                $ap_roles = [];
                $user  = user();
                $roles = explode(",", $user->ROLES);
                $roles = array_values(array_filter($roles));

                $response = array("status" => "Success", "msg" => "Approval has been submitted!");
                foreach ($ap->result() as $s) {
                    if(in_array($s->user_roles, $roles))
                    {
                        $response = array("status" => "Success", "msg" => "Approval has been submitted!","multi"=>true);
                        break;
                    }
                }
                $this->session->set_flashdata('message', array(
                    'message' => __('success_approve'),
                    'type' => 'success'
                ));
            } else {
                $response = array("status" => "Success", "msg" => "Rejection has been submitted!");
                $this->session->set_flashdata('message', array(
                    'message' => __('success_reject'),
                    'type' => 'success'
                ));
            }
        } else {
            $response = array("status" => "Failed", "msg" => "Oops, something went wrong!");
        }
        $this->db->trans_complete();
        $this->output($response);
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
                        <br>' . $open = str_replace(array('po_no', 'doc_no'), array($content['po'], $content['amd']), $content['open']) . '
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
}
?>
