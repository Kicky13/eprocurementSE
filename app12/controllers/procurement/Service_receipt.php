<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Service_receipt extends CI_Controller {

    protected $menu;
    public $module_kode = 12;

    public function __construct() {
        parent::__construct();
        $this->load->library('form');
        $this->load->library('url_generator');
        $this->load->library('redirect');
        $this->load->model('vendor/M_vendor');
        $this->load->model('vendor/M_all_intern', 'mai');

        $this->load->model('m_base');
        $this->load->model('note_approval/m_note');
        $this->load->model('procurement/m_service_receipt');
        $this->load->model('procurement/m_service_receipt_detail');
        $this->load->model('procurement/m_service_receipt_attachment');
        $this->load->model('procurement/m_service_receipt_itp');
        $this->load->model('procurement/m_service_receipt_itp_detail');
        $this->load->model('m_base_approval');
        $this->load->model('procurement/m_service_receipt_approval');

        $this->load->helper('exchange_rate');

        $this->m_service_receipt_approval->module_kode = $this->module_kode;

        $this->mai->cek_session();
        $get_menu = $this->M_vendor->menu();
        $this->menu = array();
        foreach ($get_menu as $k => $v) {
            $this->menu[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $this->menu[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $this->menu[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $this->menu[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
    }


    public function index() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('datatable');
            return $this->datatable->resource('t_service_receipt', 't_service_receipt.*, t_itp.itp_no, t_itp.no_po, m_vendor.NAMA as vendor, m_user.USERNAME as username, m_user.NAME as creator, t_approval_service_receipt.status as approval_status')
            ->join('t_itp', 't_itp.id_itp = t_service_receipt.id_itp')
            ->join('t_purchase_order', 't_purchase_order.po_no = t_itp.no_po')
            ->join('t_bl_detail', 't_bl_detail.id = t_purchase_order.bl_detail_id')
            ->join('m_vendor', 'm_vendor.ID = t_itp.id_vendor')
            ->join('m_user', 'm_user.ID_USER = t_service_receipt.created_by')
            ->join('t_approval_service_receipt', 't_approval_service_receipt.id_ref = t_service_receipt.id AND sequence = 1')
            ->where('t_service_receipt.created_by', $this->session->userdata('ID_USER'))
            ->order_by('receipt_date', 'DESC')
            ->generate();
        }
        $data['menu'] = $this->menu;
        $this->template->display('procurement/V_service_receipt', $data);
    }

    public function itp_list() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('datatable');
            return $this->datatable->resource('t_itp', 't_itp.*, m_vendor.NAMA as vendor, m_user.USERNAME as username, m_user.NAME as creator')
            ->join('t_purchase_order', 't_purchase_order.po_no = t_itp.no_po')
            ->join('t_bl_detail', 't_bl_detail.id = t_purchase_order.bl_detail_id')
            ->join('m_vendor', 'm_vendor.ID = t_itp.id_vendor')
            ->join('m_user', 'm_user.ID_USER = t_itp.created_by')
            ->join('(select id_itp,SUM(total) total from t_itp_detail group by id_itp) a','a.id_itp=t_itp.id_itp')
            ->join('(select id_itp,SUM(subtotal) total from t_service_receipt group by id_itp) b','b.id_itp=t_itp.id_itp ','left')
            ->where('t_itp.is_vendor_acc', 1)
            ->where('(SELECT COUNT(1) FROM t_approval_itp WHERE t_approval_itp.id_itp = t_itp.id_itp AND (t_approval_itp.status_approve = 0 OR t_approval_itp.status_approve = 2)) = 0', null, false)
            ->where('t_purchase_order.po_type', 20)
            ->order_by('dated', 'DESC')
            //->where('a.total>COALESCE(b.total,0)')
            ->generate();
        }
        $data['menu'] = $this->menu;
        $this->template->display('procurement/V_service_receipt_itp_list', $data);
    }

    public function approval() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('datatable');
            $user_roles = $this->session->userdata('ROLES');
            $user_roles = trim($user_roles, ',');
            $user_roles = explode(',', $user_roles);
            return $this->datatable->resource(
                '(SELECT id_ref, MIN(sequence) AS sequence FROM t_approval_service_receipt WHERE status = 0 OR status = 2 GROUP BY id_ref) approval',
                't_service_receipt.*, t_itp.itp_no, t_itp.no_po, m_vendor.NAMA as vendor, m_user.USERNAME as username, m_user.NAME as creator'
            )
            ->join('t_approval_service_receipt', 't_approval_service_receipt.id_ref = approval.id_ref AND t_approval_service_receipt.sequence = approval.sequence')
            ->join('t_service_receipt', 't_service_receipt.id = t_approval_service_receipt.id_ref')
            ->join('t_itp', 't_itp.id_itp = t_service_receipt.id_itp')
            ->join('t_purchase_order', 't_purchase_order.po_no = t_itp.no_po')
            ->join('t_bl_detail', 't_bl_detail.id = t_purchase_order.bl_detail_id')
            ->join('m_vendor', 'm_vendor.ID = t_itp.id_vendor')
            ->join('m_user', 'm_user.ID_USER = t_service_receipt.created_by')
            ->where('approval.sequence > ', 1)
            ->where_in('t_approval_service_receipt.id_user_role', $user_roles)
            ->where($this->session->userdata('ID_USER') .' LIKE t_approval_service_receipt.id_user')
            ->where('t_service_receipt.cancel', 0)
            ->order_by('receipt_date', 'DESC')
            ->generate();
        }
        $data['menu'] = $this->menu;
        $this->template->display('procurement/V_service_receipt_approval', $data);
    }

    public function completed() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('datatable');
            return $this->datatable->resource('t_service_receipt', 't_service_receipt.*, t_itp.itp_no, t_itp.no_po, m_vendor.NAMA as vendor, m_user.USERNAME as username, m_user.NAME as creator')
            ->join('t_itp', 't_itp.id_itp = t_service_receipt.id_itp')
            ->join('t_purchase_order', 't_purchase_order.po_no = t_itp.no_po')
            ->join('t_bl_detail', 't_bl_detail.id = t_purchase_order.bl_detail_id')
            ->join('m_vendor', 'm_vendor.ID = t_itp.id_vendor')
            ->join('m_user', 'm_user.ID_USER = t_service_receipt.created_by')
            ->where('(SELECT COUNT(1) FROM t_approval_service_receipt WHERE t_approval_service_receipt.id_ref = t_service_receipt.id AND (status = 0 OR status = 2)) = ', 0)
            ->where('t_service_receipt.cancel', 0)
            ->generate();
        }
        $data['menu'] = $this->menu;
        $this->template->display('procurement/V_service_receipt_completed', $data);
    }

    public function view($id_itp, $id) {
        $data['menu'] = $this->menu;
        $itp = $this->m_service_receipt_itp->view('service_receipt_itp')
        ->scope(array('vendor_accept', 'approved'))
        ->where('t_itp.id_itp', $id_itp)
        ->first();
        $itp_detail = $this->m_service_receipt_itp_detail->view('itp_detail')
        ->join('t_service_receipt_detail', 't_service_receipt_detail.id_itp = t_itp_detail.id_itp AND t_service_receipt_detail.id_material = t_itp_detail.material_id AND t_service_receipt_detail.id_service_receipt="'.$id.'"')
        ->where('t_itp_detail.id_itp', $id_itp)
        ->get();
        $total_receipt = $this->m_service_receipt_itp->view('total_receipt_po')
        ->where('t_itp.no_po', $itp->no_po)
        ->first();
        $itp->detail = $itp_detail;
        $data['itp'] = $itp;
        $data['total_receipt'] = $total_receipt;
        $model = $this->m_service_receipt->find_or_fail($id);
        $rs_item = $this->m_service_receipt_detail->where('id_service_receipt', $id)->get();
        $item = array();
        foreach ($rs_item as $r_item) {
            $item[$r_item->id_itp][$r_item->id_material] = $r_item;
        }
        $model->item = $item;
        $attachments = $this->m_service_receipt_attachment->view('attachment')->where('id_service_receipt',$model->id)->get();
        $data['model'] = $model;
        $data['approval'] = $this->m_service_receipt_approval->find($id);
        $data['attachment'] = $attachments;
        //echopre($attachments);
        $this->template->display('procurement/V_service_receipt_view', $data);
    }

    public function create($id_itp) {
        $data['menu'] = $this->menu;
        $itp = $this->m_service_receipt_itp->view('service_receipt_itp')
        ->scope(array('vendor_accept', 'approved'))
        ->where('t_itp.id_itp', $id_itp)
        ->first();
        $detail = $this->m_service_receipt_itp_detail->view('itp_detail')
        ->where('t_itp_detail.id_itp', $id_itp)
        ->get();
        $total_receipt = $this->m_service_receipt_itp->view('total_receipt_po')
        ->where('t_itp.no_po', $itp->no_po)
        ->first();
        $itp->detail = $detail;
        $total_receipt->total_receipt -= $itp->itp_total;
        $total_receipt->total_receipt += $itp->sr_total;
        $data['service_receipt_no'] = $this->m_service_receipt->generate_no($itp->id_company);
        $data['itp'] = $itp;
        $data['total_receipt'] = $total_receipt;
        $this->template->display('procurement/V_service_receipt_create', $data);
    }

    public function store($id_itp) {
        $post = $this->input->post();
        $itp = $this->m_service_receipt_itp->view('service_receipt_itp')
        ->scope(array('vendor_accept', 'approved'))
        ->where('t_itp.id_itp', $id_itp)
        ->first();
        $post['id_itp'] = $id_itp;
        $post['service_receipt_no'] = $this->m_service_receipt->generate_no($itp->id_company);
        $post['id_currency'] = $itp->id_currency;
        $post['id_currency_base'] = $itp->id_currency_base;
        $post['subtotal_base'] = exchange_rate_by_id($itp->id_currency, $itp->id_currency_base, $post['subtotal']);
        $response = array();
        $this->db->trans_start();
            $service_receipt = $this->m_service_receipt->insert($post);
            $counter = 0;
            $valid = 0;
            foreach ($post['item'][$id_itp] as $id_material => $item) {
                $counter++;
                if ($item['qty'] <> 0 && $item['qty'] != "" && $counter>0) {
                    $valid = 1;
                    $item['id_itp'] = $id_itp;
                    $item['id_service_receipt'] = $service_receipt->id;
                    $item['id_material'] = $id_material;
                    $item['id_currency'] = $itp->id_currency;
                    $item['id_currency_base'] = $itp->id_currency_base;
                    $item['price_base'] = exchange_rate_by_id($itp->id_currency, $itp->id_currency_base, $item['price']);
                    $item['total_base'] = exchange_rate_by_id($itp->id_currency, $itp->id_currency_base, $item['total']);
                    $this->m_service_receipt_detail->insert($item);
                }else if($counter == 1){
                    $response = array(
                        'success' => false,
                        'doc_no' => "",
                        'message' => 'Failed to save service receipt, qty must be more than 0'
                    );
                    $this->db->trans_rollback();
                    $this->output->set_content_type('application/json')->set_output(json_encode($response))->_display();
                    exit();
                }
            }
            if (isset($post['attachment'])) {
                $created_date = date('Y-m-d H:i:s');
                foreach ($post['attachment'] as $attachment) {
                    $data_insert = array(
                        'id_service_receipt' => $service_receipt->id,
                        'description' => $attachment['description'],
                        'file' => $attachment['file'],
                        'created_by' => $this->session->userdata('ID_USER'),
                        'created_date' => $created_date
                    );
                    $this->m_service_receipt_attachment->insert($data_insert);
                }
            }
            $this->m_service_receipt_approval->start($service_receipt->id);
        if ($this->db->trans_status() && $valid == 1) {
            $response = array(
                'success' => true,
                'id_service_receipt' => $service_receipt->id,
                'doc_no' => $service_receipt->service_receipt_no,
                'message' => 'Service receipt saved successfully with service receipt no : '.$service_receipt->service_receipt_no
            );
            $this->db->trans_commit();
        } else {
            $response = array(
                'success' => false,
                'doc_no' => "",
                'message' => 'Failed to save service receipt'
            );
            $this->db->trans_rollback();
        }
        $this->output->set_content_type('application/json')
        ->set_output(json_encode($response));
    }

    public function save_attachment($id_service_receipt){
        $post = $this->input->post();
        $created_date = date('Y-m-d H:i:s');
        foreach (json_decode($post['attachment']) as $atc => $item) {
            if($item->description != ""){
                $data_insert = array(
                    'id_service_receipt' => $id_service_receipt,
                    'description' => $item->description,
                    'file' => $item->file,
                    'created_by' => $this->session->userdata('ID_USER'),
                    'created_date' => $created_date
                );
                $this->m_service_receipt_attachment->insert($data_insert);
            }
        }
        $response = array(
            'success' => true,
            'message' => 'Attachment saved successfully'
        );
        $this->output->set_content_type('application/json')
        ->set_output(json_encode($response));
    }

    public function edit($id_itp, $id) {
        $approval = $this->m_service_receipt_approval->find($id);
        if ($approval->edit_content <> 1 && $approval->sequence <> 1) {
            $this->redirect->back();
        }
        $data['menu'] = $this->menu;
        $itp = $this->m_service_receipt_itp->view('service_receipt_itp')
        ->scope(array('vendor_accept', 'approved'))
        ->where('t_itp.id_itp', $id_itp)
        ->first();
        $itp_detail = $this->m_service_receipt_itp_detail->view('itp_detail')
        ->join('t_service_receipt_detail', 't_service_receipt_detail.id_itp = t_itp_detail.id_itp AND t_service_receipt_detail.id_material = t_itp_detail.material_id AND t_service_receipt_detail.id_service_receipt="'.$id.'"')
        ->where('t_itp_detail.id_itp', $id_itp)
        ->get();
        $total_receipt = $this->m_service_receipt_itp->view('total_receipt_po')
        ->where('t_itp.no_po', $itp->no_po)
        ->first();
        $attachment = $this->m_service_receipt_attachment->view('attachment')
        ->where('id_service_receipt', $id)
        ->get();
        $itp->detail = $itp_detail;
        $itp->attachment = $attachment;
        $model = $this->m_service_receipt->find_or_fail($id);
        $rs_item = $this->m_service_receipt_detail->where('id_service_receipt', $id)->get();
        $item = array();
        foreach ($rs_item as $r_item) {
            $item[$r_item->id_itp][$r_item->id_material] = $r_item;
        }
        $model->item = $item;
        $total_receipt->total_receipt -= $itp->itp_total;
        $total_receipt->total_receipt += ($itp->sr_total - $model->subtotal);
        $data['model'] = $model;
        $data['itp'] = $itp;
        $data['total_receipt'] = $total_receipt;
        $this->template->display('procurement/V_service_receipt_edit', $data);
    }

    public function update($id_itp, $id) {
        $approval = $this->m_service_receipt_approval->find($id);
        if ($approval->edit_content == 1 || $approval->sequence == 1) {
            $this->db->trans_start();
                $post = $this->input->post();
                $itp = $this->m_service_receipt_itp->view('service_receipt_itp')
                ->scope(array('vendor_accept', 'approved'))
                ->where('t_itp.id_itp', $id_itp)
                ->first();
                $post['id_itp'] = $id_itp;
                $post['service_receipt_no'] = $this->m_service_receipt->generate_no($itp->id_company);
                $post['id_currency'] = $itp->id_currency;
                $post['id_currency_base'] = $itp->id_currency_base;
                $post['subtotal_base'] = exchange_rate_by_id($itp->id_currency, $itp->id_currency_base, $post['subtotal']);
                $response = array();
                $service_receipt = $this->m_service_receipt->update($id, $post);
                $this->m_service_receipt_detail->where('id_service_receipt', $id)->delete();
                foreach ($post['item'][$id_itp] as $id_material => $item) {
                    if ($item['qty'] <> 0) {
                        $item['id_itp'] = $id_itp;
                        $item['id_service_receipt'] = $id;
                        $item['id_material'] = $id_material;
                        $item['id_currency'] = $itp->id_currency;
                        $item['id_currency_base'] = $itp->id_currency_base;
                        $item['price_base'] = exchange_rate_by_id($itp->id_currency, $itp->id_currency_base, $item['price']);
                        $item['total_base'] = exchange_rate_by_id($itp->id_currency, $itp->id_currency_base, $item['total']);
                        $this->m_service_receipt_detail->insert($item);
                    }
                }
                $this->m_service_receipt_attachment->where('id_service_receipt', $id)
                ->delete();
                if (isset($post['attachment'])) {
                    $created_date = date('Y-m-d H:i:s');
                    foreach ($post['attachment'] as $attachment) {
                        $data_insert = array(
                            'id_service_receipt' => $id,
                            'description' => $attachment['description'],
                            'file' => $attachment['file'],
                            'created_by' => $this->session->userdata('ID_USER'),
                            'created_date' => $created_date
                        );
                        $this->m_service_receipt_attachment->insert($data_insert);
                    }
                }
                $approve = $this->m_service_receipt_approval->approve($approval->id, 1);
            if ($this->db->trans_status()) {
                $response = array(
                    'success' => true,
                    'message' => 'Service receipt resubmit successfully'
                );
                $this->db->trans_commit();
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Failed to resubmit service receipt'
                );
                $this->db->trans_rollback();
            }
        } else {
            $response = array(
                'success' => false,
                'message' => 'You don\'t have permission to update this service receipt'
            );
        }
        $this->output->set_content_type('application/json')
        ->set_output(json_encode($response));
    }

    public function cancel($id_itp, $id) {
        $this->m_service_receipt->where('id', $id)
        ->update(array(
            'cancel' => 1
        ));
        $this->redirect->with('success_message', 'Successfully canceled service receipt')->back();
    }

    public function doc_upload() {
        $config['upload_path']          = './upload/PROCUREMENT/SERVICE_RECEIPT';
        $config['allowed_types']        = 'xls|xlsx|doc|docx|pdf';
        $config['max_size']             = 10240;
        $config['encrypt_name']         = TRUE;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('file')) {
            $data = $this->upload->data();
            $response = array(
                'success' => true,
                'data' => $this->upload->data()
            );
        } else {
            $response = array(
                'success' => false,
                'message' => $this->upload->display_errors()
            );
        }
        echo json_encode($response);
    }

    public function doc_store() {

    }

    public function doc_delete() {

    }

    public function approval_store($id_itp, $id) {
        $status = $this->input->post('status');
        $description = $this->input->post('description');
        $response = array();
        $approval = $this->m_service_receipt_approval->find($id);
        if ($approval) {
            $approve = $this->m_service_receipt_approval->approve($approval->id, $status, $description);
            if ($approve) {
                $response = array(
                    'success' => true,
                    'message' => 'Service receipt '.(($status == 1) ? 'approved' : 'rejected').' successfully'
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Failed to '.(($status == 1) ? 'approve' : 'reject').' service receipt'
                );
            }
        } else {
            $response = array(
                'success' => false,
                'message' => 'You don\'t have permission to approve this service receipt'
            );
        }
        $this->output->set_content_type('application/json')
        ->set_output(json_encode($response));
    }
}
