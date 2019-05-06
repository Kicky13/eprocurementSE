<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Arf_notification extends CI_Controller {

    protected $document_path = 'upload/ARF';
    protected $document_allowed_types = 'jpg|jpeg|pdf|doc|docx';
    protected $document_max_size = '2048';

    public function __construct() {
        parent::__construct();

        $this->load->model('vn/info/M_all_vendor');
        $this->M_all_vendor->cek_session();

        $this->load->library('url_generator');
        $this->load->library('redirect');
        $this->load->library('form');
        $this->load->model('m_base');
        $this->load->model('procurement/m_procurement');
        $this->load->model('procurement/arf/m_arf');
        $this->load->model('procurement/arf/m_arf_assignment');
        $this->load->model('procurement/arf/m_arf_attachment');
        $this->load->model('procurement/arf/m_arf_detail');
        $this->load->model('procurement/arf/m_arf_detail_reason');
        $this->load->model('procurement/arf/m_arf_detail_revision');
        $this->load->model('procurement/arf/m_arf_po');
        $this->load->model('procurement/arf/m_arf_po_detail');
        $this->load->model('procurement/arf/m_arf_notification');
        $this->load->model('procurement/arf/m_arf_notification_detail_revision');
        $this->load->model('procurement/arf/m_arf_notification_attachment');
        $this->load->model('procurement/arf/m_arf_sop');
        $this->load->model('procurement/arf/m_arf_response');
        $this->load->model('procurement/arf/m_arf_response_detail');
        $this->load->model('procurement/arf/m_arf_response_attachment');

        $this->load->helper('exchange_rate_helper');
    }

    public function index() {
        $data['model'] = $this->m_arf_notification->view('arf_notification')
        ->scope(array('auth_vendor', 'unresponse'))
        ->get();
        $this->template->display_vendor('vn/info/arf_notification', $data);
    }

    public function closed() {
        $data['model'] = $this->m_arf_notification->view('arf_notification')
        ->scope(array('auth_vendor', 'unresponse', 'close'))
        ->get();
        $this->template->display_vendor('vn/info/arf_notification', $data);
    }

    public function submitted() {
        $data['model'] = $this->m_arf_notification->view('arf_responsed')
        ->scope(array('auth_vendor', 'responsed'))
        ->get();
        $this->template->display_vendor('vn/info/arf_responsed', $data);
    }

    public function response($id) {
        $arf = $this->m_arf_notification->view('arf_notification')
        ->scope(array('auth_vendor', 'unresponse'))
        ->find($id);
        if (!$arf) {
            $this->redirect->back();
        }
        $arf->item = $this->m_arf_sop->view('sop')->where('t_arf_sop.doc_id', $id)->order_by('t_arf_sop.id','asc')->get();
        foreach ($this->m_arf_notification_detail_revision->where('doc_id', $id)->get() as $revision) {
            $arf->revision[$revision->type] = $revision;
        }
        $arf->attachment = $this->m_arf_notification_attachment->view('notification_attachment')
        ->where('t_arf_notification_upload.doc_id', $arf->id)
        ->get();
        $po = $this->m_arf_po->where('t_purchase_order.po_no', $arf->po_no)
        ->first();
        $po->po_type = $this->m_arf_po->enum('type', $po->po_type);
        $po->item = $this->m_arf_po_detail->view('po_detail')
        ->where('t_purchase_order_detail.po_id', $po->id)
        ->get();
        $data['arf'] = $arf;
        $data['po'] = $po;
        $data['document_path'] = $this->document_path;
        $this->template->display_vendor('vn/info/arf_response', $data);
    }

    public function view($id) {
        $arf = $this->m_arf_notification->view('arf_responsed')
        ->scope(array('auth_vendor', 'responsed'))
        ->find($id);
        if (!$arf) {
            $this->redirect->back();
        }
        $arf->item = $this->m_arf_sop->view('response')->where('t_arf_sop.doc_id', $id)->get();
        foreach ($this->m_arf_notification_detail_revision->where('doc_id', $id)->get() as $revision) {
            $arf->revision[$revision->type] = $revision;
        }
        $arf->attachment = $this->m_arf_notification_attachment->view('notification_attachment')
        ->where('t_arf_notification_upload.doc_id', $arf->id)
        ->get();
        $arf->response_attachment = $this->m_arf_response_attachment->where('t_arf_response_attachment.doc_id', $arf->doc_id)
        ->get();
        $po = $this->m_arf_po->where('t_purchase_order.po_no', $arf->po_no)
        ->first();
        $po->po_type = $this->m_arf_po->enum('type', $po->po_type);
        $po->item = $this->m_arf_po_detail->view('po_detail')
        ->where('t_purchase_order_detail.po_id', $po->id)
        ->get();
        $data['arf'] = $arf;
        $data['po'] = $po;
        $data['document_path'] = $this->document_path;
        $this->template->display_vendor('vn/info/arf_notification_view', $data);
    }

    public function submit($id) {
        $post = $this->input->post();
        if (!isset($post['confirm'])) {
            $response = array(
                'success' => false,
                'message' => 'You have to select confirm to submit amendment'
            );
            echo json_encode($response);
            exit;
        }
        $notification = $this->m_arf_notification->view('arf_notification')
        ->scope(array('auth_vendor', 'unresponse'))
        ->find($id);
        if (!$notification) {
            $response = array(
                'success' => false,
                'message' => 'You dont have permission to submit this amendment'
            );
            echo json_encode($response);
            exit;
        }
        $arf = $this->m_arf->where('doc_no', $notification->doc_no)
        ->first();
        $responsed_at = date('Y-m-d H:i:s');
        $this->m_arf_response->insert(array(
            'doc_no' =>  $arf->doc_no,
            'currency_id' => $arf->currency_id,
            'currency_base_id' => $arf->currency_base_id,
            'subtotal' => $post['total'],
            'subtotal_base' => exchange_rate_by_id($arf->currency_id, $arf->currency_base_id, $post['total']),
            'confirm' => $post['confirm'],
            'note' => $post['note'],
            'responsed_at' => $responsed_at
        ));
        if (isset($post['arf_item'])) {
            $record_item = array();
            foreach ($post['arf_item'] as $detail_id => $item) {
                $total = $item['qty1'] * $item['unit_price'];
                if (isset($item['qty2'])) {
                    $total *= $item['qty2'];
                }
                $tax = (10/100) * $total;
                $total_with_tax = $total + $tax;
                $record_item[] = array(
                    'doc_no' =>  $arf->doc_no,
                    'detail_id' => $detail_id,
                    'currency_id' => $arf->currency_id,
                    'currency_base_id' => $arf->currency_base_id,
                    'qty1' => $item['qty1'],
                    'qty2' => isset($item['qty2']) ? $item['qty2'] : null,
                    'unit_price' => $item['unit_price'],
                    'unit_price_base' => exchange_rate_by_id($arf->currency_id, $arf->currency_base_id, $item['unit_price']),
                    'is_tax' => 1,
                    'tax' => $tax,
                    'tax_base' => exchange_rate_by_id($arf->currency_id, $arf->currency_base_id, $tax),
                    'total' => $total_with_tax,
                    'total_base' => exchange_rate_by_id($arf->currency_id, $arf->currency_base_id, $total_with_tax),
                );
            }
            $this->m_arf_response_detail->insert_batch($record_item);
        }
        if (isset($post['attachment'])) {
            $record_attachment = array();
            foreach ($post['attachment'] as $attachment) {
                $record_attachment[] = array(
                    'doc_id' => $arf->id,
                    'file_name' => $attachment['nama_file'],
                    'file' => $attachment['file'],
                    'created_by' =>  $this->session->userdata('ID_USER'),
                    'created_at' => $responsed_at
                );
            }
            $this->m_arf_response_attachment->insert_batch($record_attachment);
        }

        $response = array(
            'success' => true,
            'message' => 'Amendment Number '.$arf->doc_no.' submitted successfully'
        );
        echo json_encode($response);
    }

    public function attachment_upload() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('file_name', 'File Name', 'required');
        if (!$this->form_validation->run()) {
            $response = array(
                'success' => false,
                'message' => validation_errors('<div>', '</div>')
            );
            echo json_encode($response);
            exit;
        }
        $config['upload_path'] = $this->document_path;
        $config['allowed_types'] = $this->document_allowed_types;
        $config['max_size'] = $this->document_max_size;
        $this->load->library('upload', $config);
        $response = array();
        if ($this->upload->do_upload('file')) {
            $response = array(
                'success' => true,
                'message' => 'Successfully uploded document',
                'data' => $this->upload->data(),
				'nama_file' => $this->input->post('file_name')
            );
        } else {
            $response = array(
                'success' => false,
                'message' => $this->upload->display_errors()
            );
        }
        echo json_encode($response);
    }
}