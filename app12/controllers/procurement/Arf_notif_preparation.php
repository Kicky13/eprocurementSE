<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Arf_notif_preparation extends CI_Controller {

    protected $menu;

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'array', 'url'));
        $this->load->library('session');
        $this->load->model('m_base', 'mbs');
        $this->load->model('m_base_approval');
        $this->load->model('vendor/M_vendor', 'mvn');
        $this->load->model('vendor/M_all_intern', 'mai');
        $this->load->model('procurement/m_procurement', 'mpr');
        $this->load->model('procurement/arf/m_arf_po', 'map');
        $this->load->model('procurement/arf/m_arf_po_detail', 'mapd');
        $this->load->model('procurement/arf/m_arf');
        $this->load->model('procurement/arf/m_arf_approval');
        $this->load->model('procurement/m_arf_notif_preparation', 'manp');
        $this->load->model('procurement/arf/m_arf_detail_revision');
        $this->load->model('M_sendmail');
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
        $data['list1'] = $this->manp->get_list_prepare();
        $data['list2'] = $this->manp->get_list_progress();
        /*echo "<pre>";
        print_r($data['list2']);
        exit();*/
        $this->template->display('procurement/V_arf_notif_preparation', $data);
    }

    public function create_main($id) {
        $res = $this->manp->create_main($id);
        if ($res) {
            $res->flag = 'after_review';
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
            $data['data_rev'] = $res;
            $this->template->display('procurement/V_arf_notif_preparation', $data);
        } else {
            redirect(base_url('procurement/arf_notif_preparation'), 'refresh');
        }
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function get_list_prepare() {
        $dt = array();
        $res = $this->manp->get_list_prepare();
        if (count($res) > 0) {
            foreach ($res as $k => $v) {
                $dt[$k][0] = $k + 1;
                $dt[$k][1] = dateToIndo($v['doc_date']);
                $dt[$k][2] = $v['po_no'];
                $dt[$k][3] = $v['doc_no'];
                /*$dt[$k][4] = $v['po_type'];*/
                $dt[$k][4] = $v['po_title'];
                $dt[$k][5] = $v['requestor'];
                $dt[$k][6] = $v['department'];
                $dt[$k][7] = $v['abbr'];
                if ($v['status'] == 1) {
                    $dt[$k][8] = "<button class='btn btn-sm btn-success proc_prep'>GO</button>";
                } else {
                    $dt[$k][8] = "<button class='btn btn-sm btn-success proc_review' data-arf='" . $v['id'] . "''>GO</button>";
                }
            }
        }
        return $this->output($dt);
    }

    public function get_list_progress() {
        $dt = array();
        $res = $this->manp->get_list_progress();
        if (count($res) > 0) {
            foreach ($res as $k => $v) {
                if ($v['status_approve'] == 2) {
                    $status = "<td><span class='badge badge badge-pill badge-danger'>Rejected</span></td>";
                } else if ($v['status_approve'] == 1) {
                    $status = "<td><span class='badge badge badge-pill badge-success'>" . ($v['sequence'] == 1 ? "Prepared" : "Approved") . "</span></td>";
                } else {
                    $status = "<td><span class='badge badge badge-pill badge-light'>Unconfirmed</span></td>";
                }

                $dt[$k][0] = $k + 1;
                $dt[$k][1] = dateToIndo($v['doc_date']);
                $dt[$k][2] = $v['po_no'];
                $dt[$k][3] = $v['doc_no'];
                /*$dt[$k][4] = $v['po_type'];*/
                $dt[$k][4] = $v['po_title'];
                $dt[$k][5] = $v['user_roles'];
                $dt[$k][6] = $status;
                $dt[$k][7] = ($v['status_approve'] == 0 ? '' : date('M j, Y H:i', strtotime($v['update_date'])));
                if ($v['status_approve'] == 2 && $v['assignee'] == $this->session->ID_USER) {
                    $dt[$k][8] = "<button class='btn btn-sm btn-success proc_resub'>Rework</button>";
                } else {
                    $dt[$k][8] = "<button class='btn btn-sm btn-info proc_watch'>Detail</button>";
                }
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
            $data['opt_uom'][$uom->MATERIAL_UOM] = $uom->MATERIAL_UOM.' - '.$uom->DESCRIPTION;
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
        $res = $this->manp->get_header($po, $amd);
        return $this->output($res);
    }

    public function get_main() {
        $po = $this->input->post('po');
        $amd = $this->input->post('amd');
        $res = $this->manp->get_main($po, $amd);
        if ($res) {
            if ($res->response_date != null) {
                if ($this->input->post('type') == 3)
                    $res->response_date = date('M j, Y', strtotime($res->response_date));
                else if ($this->input->post('type') == 2 || $res->is_draft == 1)
                    $res->response_date = date('Y-m-d', strtotime($res->response_date));
            }
            return $this->output(array('status' => 'Success', 'msg' => 'Create main successful!', 'data' => $res));
        } else {
            return $this->output(array('status' => 'Failed', 'msg' => 'Oops, something went wrong!'));
        }
    }

    public function get_revision() {
        $po = $this->input->post('po');
        $amd = $this->input->post('amd');
        $draft = $this->input->post('draft');
        if ($draft == 1) {
            $res = $this->manp->get_revision_notif($po, $amd);
        } else {
            $res = $this->manp->get_revision_base($po, $amd);
        }
        return $this->output($res);
    }

    public function get_upload() {
        $dt = array();
        $po = $this->input->post('po');
        $amd = $this->input->post('amd');
        $notif = $this->input->post('notif');
        $res = $this->manp->get_upload($po, $notif);
        if ($res != false) {
            $count = 1;
            foreach ($res as $k => $v) {
                $dt[$k][0] = $k + 1;
                // $dt[$k][1] = 'Tipe';
                // $dt[$k][2] = 'Seq';
                $dt[$k][1] = "<a href='javascript:void(0)' onclick='preview(".$v['id'].")'>".$v['file_name']."</a>";
                $dt[$k][2] = date('M j, Y H:i', strtotime($v['create_date']));
                $dt[$k][3] = $v['name'];
                if ($this->input->post('type') != 3)
                    $dt[$k][4] = "<button class='btn btn-sm btn-danger btn-modif-upload' onclick='delete_ul(".$v['id'].")'>Delete</button>";
                else
                    $dt[$k][4] = "";
            }
        }
        return $this->output($dt);
    }

    public function download_file($param) {
        $param = explode('_', $param);
        $file_data = false;

        if (count($param) == 3) {
            $file_info = $this->manp->get_upload($param[0], $param[1], $param[2]);
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

    public function upload_file() {
        $result = false;
        $po = $this->input->post('po');
        $amd = $this->input->post('amd');
        $notif = $this->input->post('notif');
        $tmp = $this->cek_uploads($po, $amd, "upload/PROCUREMENT/ARF_NOTIF", "modal_upload_file", "file_path");
        $flag = $tmp['flag'];
        $res = $tmp['res'];
        $data = array(
            'po_no' => $po,
            'doc_id' => $notif,
            'create_by' => $this->session->ID_USER,
            'create_date' => date('Y-m-d H:i:s'),
        );
        if ($flag == 1) {
            $data = array_merge($data, $res);
            $result = $this->manp->add_data_file($data);
        }
        if ($result != false)
            return $this->output(array("msg" => "Data has been saved!", "status" => "Success"));
        else
            return $this->output(array("msg" => "Oops, something went wrong!", "status" => "Failed"));
    }

    public function delete_uploads() {
        $po = $this->input->post('po');
        $amd = $this->input->post('amd');
        $notif = $this->input->post('notif');
        $id = $this->input->post('id');
        $del =  $this->manp->get_upload($po, $notif, $id);
        if ($del != false) {
            if (file_exists($del[0]['file_path'])) {
                if (unlink($del[0]['file_path'])) {
                    $this->manp->delete_upload($id);
                    return $this->output(array("msg" => "Data has been deleted!", "status" => "Success"));
                } else {
                    return $this->output(array("msg" => "Oops, something went wrong!", "status" => "Failed"));
                }
            } else {
                $this->manp->delete_upload($id);
                return $this->output(array("msg" => "Data has been deleted!", "status" => "Success"));
            }
        }
        return $this->output(array("msg" => "Oops, something went wrong!", "status" => "Failed"));
    }

    public function cek_uploads($po, $amd, $dest, $data_file, $db_col) {
        $flag = 0;
        $res = 0;
        if ($_FILES[$data_file]['name'] != '') {
            $res = $this->uploads($po, $amd, $dest, $data_file, $db_col);
            $this->check_response($res);
            $flag = 1;
        }
        return array("flag" => $flag, "res" => $res);
    }

    public function check_response($res) {
        if ($res == false)
            $this->output(array('msg' => "File uploading has failed!", 'status' => 'Failed'));
        else if ($res == "failed")
            $this->output(array('msg' => "Only PDF, Excel, or Word allowed!", 'status' => 'Failed'));
        else if ($res == "size")
            $this->output(array('msg' => "Maximum File size is 2 MB!", 'status' => 'Failed'));
    }

    public function uploads($po, $amd, $dest, $data_file, $db_col) {
        $data = $_FILES;
        $ret = array();
        $counter = 0;
        foreach ($data as $k => $v) {
            $img_ext = substr($v['name'], strrpos($v['name'], '.'));
            $true_name = $v['name'];
            $store_name = preg_replace('/[^A-Za-z0-9\-\.]/', '', $po . '-' . $amd);
            $store_name = str_replace(' ', '', $store_name . '_' . Date("Ymd_His") . $img_ext);
            if ($img_ext != ".pdf" && $img_ext != ".xls" && $img_ext != ".xlsx" && $img_ext != ".doc" && $img_ext != ".docx")
                return "failed";
            if ($_FILES[$k]['size'] > 2000000)
                return "size";
            if ($k == $data_file) {
                $ret[$db_col] = $dest.'/'.$store_name;
                $ret['file_name'] = $true_name;
                $ret['file_type'] = $v['type'];
            }
            if (move_uploaded_file($_FILES[$k]['tmp_name'], "$dest/$store_name"))
                $counter++;
        }
        if ($counter == 1)
            return $ret;
        else
            return false;
    }

    public function get_item_ori() {
        $dt = array();
        $po = $this->input->post('po');
        $res = $this->manp->get_item_ori($po);
        if (count($res) > 0) {
            foreach ($res as $k => $v) {
                $dt[$k][0] = $k + 1;
                $dt[$k][1] = $v['item_type'];
                $dt[$k][2] = $v['material_desc'];
                $dt[$k][3] = $v['qty'];
                $dt[$k][4] = $v['uom'] . ' - ' . $v['uom_desc'];
                $dt[$k][5] = $v['is_modification'];
                $dt[$k][6] = $v['inv_type_desc'];
                $dt[$k][7] = $v['costcenter_desc'];
                $dt[$k][8] = $v['id_accsub'] . ' - '.$v['accsub_desc'];
                $dt[$k][9] = $v['unitprice'];
                $dt[$k][10] = $v['total_price'];
            }
        }
        return $this->output($dt);
    }

    public function get_item_arf() {
        $dt = array();
        $po = $this->input->post('po');
        $amd = $this->input->post('amd');
        $res = $this->manp->get_item_arf($po, $amd);
        if (count($res) > 0) {
            foreach ($res as $k => $v) {
                $dt[$k][0] = $v['id'];
                $dt[$k][1] = $v['item_type'];
                $dt[$k][2] = $v['material_desc'];
                $dt[$k][3] = $v['qty'];
                $dt[$k][4] = $v['uom'] . ' - ' . $v['uom_desc'];
                $dt[$k][5] = $v['item_modification'];
                $dt[$k][6] = $v['inv_type_desc'];
                $dt[$k][7] = $v['costcenter'];
                $dt[$k][8] = $v['id_account_subsidiary'] . ' - ' . $v['account_subsidiary'];
                $dt[$k][9] = $v['unit_price'];
                $dt[$k][10] = $v['total_price'];
                if ($this->input->post('type') != 3)
                    $dt[$k][11] = "<button class='btn btn-sm btn-primary' onclick='arf_item_copy(" . $v['id'] . ")'>Copy</button>";
                else
                    $dt[$k][11] = "";
            }
        }
        return $this->output($dt);
    }

    public function get_item_proc() {
        $data = array();
        $po = $this->input->post('po');
        $amd = $this->input->post('amd');
        $res = $this->manp->get_item_proc($po, $amd);
        if (count($res) > 0) {
            foreach ($res as $key => $value) {
                $data[$key]['modal_sop_notif'] = $value['doc_id'];
                $data[$key]['modal_sop_id'] = $value['id'];
                $data[$key]['modal_sop_item_name'] = $value['arf_item_id'];
                $data[$key]['modal_sop_item_name_desc'] = $value['material_desc'];
                $data[$key]['modal_sop_item_type'] = $value['id_itemtype'];
                $data[$key]['modal_sop_item_type_desc'] = $value['item_type_desc'];
                $data[$key]['modal_sop_cat'] = $value['id_itemtype_category'];
                $data[$key]['modal_sop_subcat'] = $value['item_material_id'];
                $data[$key]['modal_sop_desc'] = $value['item'];
                $data[$key]['modal_sop_desc_val'] = $value['item_semic_no_value'];
                $data[$key]['modal_sop_group_value'] = $value['groupcat'];
                $data[$key]['modal_sop_group_name'] = $value['groupcat_desc'];
                $data[$key]['modal_sop_subgroup_value'] = $value['sub_groupcat'];
                $data[$key]['modal_sop_subgroup_name'] = $value['sub_groupcat_desc'];
                $data[$key]['modal_sop_inv_type'] = $value['inv_type'];
                $data[$key]['modal_sop_inv_type_desc'] = $value['inv_type_desc'];
                $data[$key]['modal_sop_item_mod'] = $value['item_modification'];
                $data[$key]['modal_sop_qty_type'] = $value['sop_type'];
                $data[$key]['modal_sop_qty_1'] = $value['qty1'];
                $data[$key]['modal_sop_uom_1'] = $value['uom1'];
                $data[$key]['modal_sop_uom_desc_1'] = $value['uom_desc_1'];
                $data[$key]['modal_sop_qty_2'] = $value['qty2'];
                $data[$key]['modal_sop_uom_2'] = $value['uom2'];
                $data[$key]['modal_sop_uom_desc_2'] = $value['uom_desc_2'];
                $data[$key]['modal_sop_cost_center'] = $value['id_costcenter'];
                $data[$key]['modal_sop_cost_center_name'] = $value['costcenter_desc'];
                $data[$key]['modal_sop_sub_acc'] = $value['id_accsub'];
                $data[$key]['modal_sop_sub_acc_name'] = $value['accsub_desc'];
                $data[$key]['modal_sop_import'] = $value['id_importation'];
                $data[$key]['modal_sop_deliv'] = $value['id_delivery_point'];
                $data[$key]['modal_sop_deliv_name'] = $value['delivery_point'];
                $data[$key]['status'] = 0;
            }
        }
        return $this->output($data);
    }

    public function get_item_proc_single() {
        $id = $this->input->post('id');
        $res = $this->manp->get_item_proc_single($id);
        return $this->output($res);
    }

    public function get_approval() {
        $po = stripslashes($this->input->post('po'));
        $amd = stripslashes($this->input->post('amd'));
        $notif = stripslashes($this->input->post('notif'));
        $res = $this->manp->get_approval($po, $notif);
        if (count($res) > 0) {
            foreach ($res as $k => $v) {
                if ($v['status_approve'] == 2) {
                    $status = "<td><span class='badge badge badge-pill badge-danger'>Rejected</span></td>";
                } else if ($v['status_approve'] == 1) {
                    $status = "<td><span class='badge badge badge-pill badge-success'>" . ($v['sequence'] == 1 ? "Prepared" : "Approved") . "</span></td>";
                } else {
                    $status = "<td><span class='badge badge badge-pill badge-light'>Unconfirmed</span></td>";
                }

                $dt[$k][0] = $k + 1;
                $dt[$k][1] = $v['role_desc'];
                $dt[$k][2] = ($v['approve_by'] != null ? $v['app_name'] : ($v['user_id'] != '%' ? $v['user_name'] : 'Any User'));
                $dt[$k][3] = $status;
                $dt[$k][4] = ($v['status_approve'] == 0 ? '' : date('M j, Y', strtotime($v['update_date'])));
                $dt[$k][5] = $v['note'];
            }
        }
        return $this->output($dt);
    }

    protected function sop_store($posted, $notif) {
        $id = $posted['modal_sop_id'];
        $dt = array(
            'arf_item_id' => $posted['modal_sop_item_name'],
            'doc_id' => $notif,
            'sop_type' => $posted['modal_sop_qty_type'],
            'item_material_id' => $posted['modal_sop_subcat'],
            'item_semic_no_value' => $posted['modal_sop_desc_val'],
            'item' => $posted['modal_sop_desc'],
            'id_itemtype' => $posted['modal_sop_item_type'],
            'id_itemtype_category' => $posted['modal_sop_cat'],
            'groupcat' => $posted['modal_sop_group_value'],
            'groupcat_desc' => $posted['modal_sop_group_name'],
            'sub_groupcat' => $posted['modal_sop_subgroup_value'],
            'sub_groupcat_desc' => $posted['modal_sop_subgroup_name'],
            'inv_type' => (!isset($posted['modal_sop_inv_type']) || $posted['modal_sop_inv_type'] == null ? 0 : $posted['modal_sop_inv_type']),
            'item_modification' => (!isset($posted['modal_sop_item_mod']) || $posted['modal_sop_item_mod'] == null ? 0 : $posted['modal_sop_item_mod']),
            'id_costcenter' => $posted['modal_sop_cost_center'],
            'costcenter_desc' => $posted['modal_sop_cost_center_name'],
            'id_accsub' => (!isset($posted['modal_sop_sub_acc']) ? null : $posted['modal_sop_sub_acc']),
            'accsub_desc' => (!isset($posted['modal_sop_sub_acc_name']) ? null : $posted['modal_sop_sub_acc_name']),
            'id_importation' => $posted['modal_sop_import'],
            'id_delivery_point' => $posted['modal_sop_deliv'],
            'delivery_point' => $posted['modal_sop_deliv_name'],
            'qty1' => (!isset($posted['modal_sop_qty_1']) || $posted['modal_sop_qty_1'] == null ? 0 : $posted['modal_sop_qty_1']),
            'uom1' => $posted['modal_sop_uom_1'],
            'qty2' => (!isset($posted['modal_sop_qty_2']) || $posted['modal_sop_qty_2'] == null ? 0 : $posted['modal_sop_qty_2']),
            'uom2' => (!isset($posted['modal_sop_uom_2']) ? null : $posted['modal_sop_uom_2']),
            'tax' => 0
        );

        if ($id == 0) {
            $dt['created_by'] = $this->session->ID_USER;
            $dt['created_at'] = date('Y-m-d H:i:s');
        } else {
            $dt['updated_by'] = $this->session->ID_USER;
            $dt['updated_at'] = date('Y-m-d H:i:s');
        }

        $check = $this->manp->sop_check($dt['doc_id'], $id);
        if (count($check) > 0 && $check[0]['sop_type'] != $dt['sop_type']) {
            $this->output(array('status' => 'Failed', 'msg' => 'SOP Type is different from other data!'));
        }

        if ($dt['qty1'] <= 0) {
            $this->output(array('status' => 'Failed', 'msg' => 'Quantity 1 must be greater than 0!'));
        }

        if ($dt['sop_type'] == 2 && $dt['uom2'] != '' && $dt['qty2'] <= 0) {
            $this->output(array('status' => 'Failed', 'msg' => 'Quantity 2 must be greater than 0!'));
        }

        $res = $this->manp->sop_store($dt, $id);
        return $res;
    }

    public function arf_item_copy() {
        $id = $this->input->post('id');
        $po = $this->input->post('po');
        $amd = $this->input->post('amd');
        $notif = $this->input->post('notif');
        $res = $this->manp->arf_item_copy($po, $amd, $notif, $id);
        if ($res)
            $this->output(array('msg' => "Data has been added!", 'status' => 'Success', 'data' => $res));
        else
            $this->output(array('msg' => "Oops, something went wrong!", 'status' => 'Failed'));
    }

    protected function sop_del($id) {
        $res = $this->manp->sop_del($id);
        return $res;
    }

    public function send_data() {
        $po = stripslashes($this->input->post('po'));
        $amd = stripslashes($this->input->post('amd'));
        $notif = stripslashes($this->input->post('notif'));
        $type = stripslashes($this->input->post('type'));

        $main = array();
        $main_placer = $this->input->post('main');
        foreach ($main_placer as $key => $value) {
            switch ($value['name']) {
                case 'notif_newval_input':
                    $main['estimated_value_new'] = $value['value'];
                    break;
                case 'notif_comdate_input':
                    $main['response_date'] = ($value['value'] == '' ? null : $value['value']);
                    break;
                default:
                    break;
            }
        }

        $rev_code = ['value', 'time', 'scope', 'other'];
        $revision = array();
        for ($i = 0; $i < count($rev_code); $i++) {
            $revision[$i] = array(
                            'type' => ($i+1),
                            'value' => null,
                            'remark' => null,
                        );
        }
        $rev_placer = $this->input->post('revision');
        foreach ($rev_placer as $key => $value) {
            $namer = explode('_', $value['name']);
            $rev_index = array_search($namer[1], $rev_code);
            if ($namer[2] == 'input')
                $revision[$rev_index]['value'] = $value['value'];
            else if ($namer[2] == 'remark')
                $revision[$rev_index]['remark'] = $value['value'];
        }
        $this->manp->proc_revision($notif, $revision);

        $this->db->trans_start();
        if ($sop_placer = $this->input->post('sop')) {
            foreach ($sop_placer as $key => $value) {
                if ($value['status'] == 3)
                    $this->sop_del($value['modal_sop_id']);
                else if ($value['status'] == 2 || $value['status'] == 1)
                    $this->sop_store($value, $notif);
            }
        }

        $res = true;
        if (!$res) {
            $response = array("status" => "Failed", "msg" => "Oops, failure on processing revision!");
        } else {
            $res = $this->manp->get_main($po, $amd);
            if (!$res || $res->id != $notif) {
                $response = array("status" => "Failed", "msg" => "Oops, something went wrong 2!");
            } else if ($type == 1) {
                $main['is_draft'] = 1;
                $main['updated_by'] = $this->session->ID_USER;
                $main['updated_date'] = date('Y-m-d H:i:s');
                $res = $this->manp->proc_main($po, $amd, $main);
            } else if ($type == 2) {
                $main['dated'] = date('Y-m-d');
                $main['is_draft'] = 1;
                $main['updated_by'] = $this->session->ID_USER;
                $main['updated_date'] = date('Y-m-d H:i:s');
                $res = $this->manp->proc_main($po, $amd, $main);
                if ($res) {
                    $res = $this->manp->create_approval($po, $notif);
                    $log_desc = 'Prepared by ' .  $this->session->NAME;
                    $log_note = '';
                }
            } else if ($type == 3) {
                $note = stripslashes($this->input->post('note'));
                if ($note == null || $note == '') {
                    $res = false;
                } else {
                    $posted = array(
                            'status_approve' => 1,
                            'note' => 'Resubmit - ' . $note,
                            'approve_by' => $this->session->ID_USER,
                            'update_date' => date('Y-m-d H:i:s')
                        );
                    $main['is_draft'] = 1;
                    $main['updated_by'] = $this->session->ID_USER;
                    $main['updated_date'] = date('Y-m-d H:i:s');
                    $res = $this->manp->proc_main($po, $amd, $main);
                    if ($res) {
                        $res = $this->manp->resub_approval($po, $notif, $posted);
                        $log_desc = 'Resubmitted by ' .  $this->session->NAME;
                        $log_note = $note;
                    }
                }
            }
        }

        if ($res) {
            if ($type == 1) {
                $response = array("status" => "Success", "msg" => "Draft has been saved!");
            } else {
                $res = $this->manp->get_email_dest($po, $notif);
//                if ($res != false) {
                    $rec = $res[0]['recipients'];
                    $rec_role = $res[0]['rec_role'];
                    $user = $this->manp->get_email_rec($rec, $rec_role);
//                    if ($user != null) {
                        $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
                        $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";
                        $querymail = $this->db->query("SELECT arf.doc_no, arf.po_title, po.po_no AS po_no, po.company_desc AS company, po.msr_no AS msr_no, vnd.NAMA AS nama, vnd.ID_VENDOR AS email, notif.TITLE AS title, notif.OPEN_VALUE AS open, notif.CLOSE_VALUE AS close FROM t_purchase_order po
                        LEFT JOIN t_bl_detail bl ON po.msr_no = bl.msr_no
                        LEFT JOIN m_vendor vnd ON bl.vendor_id = vnd.ID
                        LEFT JOIN t_arf arf ON po.po_no = arf.po_no
                        JOIN m_notic notif ON notif.ID = 90
                        WHERE po.po_no = '" . $po . "' AND bl.awarder = 1")->result();
                        $str = $querymail[0]->open;
                        $str = str_replace('_var1_', $querymail[0]->nama, $str);
                        $str = str_replace('title_agreement', $querymail[0]->po_title, $str);
                        $str = str_replace('no_arf', $querymail[0]->doc_no, $str);

                        $dt = array(
                            'img1' => $img1,
                            'img2' => $img2,
                            'title' => $querymail[0]->title,
                            'open' => $str,
                            'close' => $querymail[0]->close
                        );
                        foreach ($querymail as $val => $k){
                            $dt['dest'][] = $k->email;
                        }
                        $email = $this->M_sendmail->sendMail($dt);
                        if ($email == false)
                            $response = array("status" => "Failed", "msg" => "Oops, something went wrong 3!");
//                    }
//                }

                $log = array(
                    "module_kode" => "arfn",
                    "data_id" => $notif,
                    "description" => $log_desc,
                    "keterangan" => $log_note,
                    "created_at" => date('Y-m-d H:i:s'),
                    "created_by" => $this->session->ID_USER,
                );
                $log = $this->db->insert('log_history', $log);
                $response = array("status" => "Success", "msg" => "Data has been submitted!");
                $this->session->set_flashdata('message', array(
                    'message' => __('success_submit'),
                    'type' => 'success'
                ));
            }
        } else {
            $response = array("status" => "Failed", "msg" => "Oops, something went wrong 4!");
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

    public function get_approval_arf_prep() {
        $post = $this->input->post();
        $arf = $this->m_arf->where('doc_no', $post['amd'])->first();
        $approval = $this->m_arf_approval->get($arf->id);
        //if ($arf->review_bod) {
            foreach ($approval as $i => $row) {
                $review_bod = $this->m_arf_approval->find_detail($row->id, 'bod_review_meeting');
                if ($review_bod) {
                    $row->review_bod = $review_bod;
                }
                $approval[$i] = $row;
            }
        //}
        echo json_encode($approval);
    }
    public function view($doc_no='')
    {
        $get_menu = $this->mvn->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $data['row'] = $this->manp->view($doc_no);
        $arf = $this->db->select('t_arf.*,t_arf_notification.id as notification_id,
            t_arf_notification.dated as notification_date,
            t_arf_notification.response_date as close_date,
            t_arf_notification.estimated_value_new,m_vendor.NAMA as vendor,m_user.NAME AS requestor')
        ->join('t_arf_notification', 't_arf_notification.doc_no = t_arf.doc_no','left')
        ->join('t_purchase_order', 't_purchase_order.po_no = t_arf.po_no')
        ->join('m_vendor', 'm_vendor.ID = t_purchase_order.id_vendor')
        ->join('m_user', 'm_user.ID_USER = t_arf.created_by')
        ->where(['t_arf.doc_no'=>$doc_no])->get('t_arf')->row();
        /*$q = $this->db->select('
            u.NAME as ps,
            t_arf_notification.id as notification_id,
            t_arf_notification.dated as notification_date,
            t_arf_notification.response_date as close_date,
            t_arf_notification.estimated_value_new,
            t_purchase_order.title, t_purchase_order.po_type,
            t_msr.create_by AS id_requestor,
            m_user.NAME AS requestor,
            t_msr.id_company,
            m_company.DESCRIPTION as company,
            m_company.ABBREVIATION as abbr,
            u.NAME as ps,
            m_user.ID_DEPARTMENT as id_department,
            m_departement.DEPARTMENT_DESC as department,m_vendor.NAMA as vendor,
            currency.CURRENCY as currency,
            currency_base.CURRENCY as currency_base')
        ->join('t_purchase_order', 't_purchase_order.po_no = t_arf.po_no')
        ->join('t_msr', 't_msr.msr_no = t_purchase_order.msr_no')
        ->join('m_company', 'm_company.ID_COMPANY = t_msr.id_company')
        ->join('m_user', 'm_user.ID_USER = t_msr.create_by')
        ->join('m_user u', 'u.ID_USER = t_arf_assignment.user_id', 'left')
        ->join('m_departement', 'm_departement.ID_DEPARTMENT = m_user.ID_DEPARTMENT')
        ->join('m_vendor', 'm_vendor.ID = t_purchase_order.id_vendor')
        ->join('m_currency currency', 'currency.ID = t_arf.currency_id')
        ->join('m_currency currency_base', 'currency_base.ID = t_arf.currency_base_id')
        ->where('t_arf_notification.doc_no', $doc_no)
        ->get('t_arf');*/

        /*foreach ($this->m_arf_detail_revision->where('doc_id', $arf->id)->get() as $revision) {
            $arf->revision[$revision->type] = $revision;
        }*/
        $markingType = [1=>'value', 2=>'time', 3=>'scope', 4=>'other'];
        foreach ($this->db->where('doc_id', $arf->notification_id)->get('t_arf_notification_detail_revision')->result() as $revision) {
            $arf->revision[$markingType[$revision->type]] = $revision;
        }
        $data['arf'] = $arf;
        $data['po_no'] = $arf->po_no;
        $data['title'] = 'ARF Notification';
        $this->template->display('procurement/V_arf_notif_view', $data);
    }
}
?>
