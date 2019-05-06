<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Service_receipt extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('vn/info/M_all_vendor');
        $this->M_all_vendor->cek_session();

        $this->load->library('url_generator');
        $this->load->library('redirect');
        $this->load->model('m_base');
        $this->load->model('procurement/m_service_receipt');
        $this->load->model('procurement/m_service_receipt_detail');
        $this->load->model('procurement/m_service_receipt_attachment');
        $this->load->model('procurement/m_service_receipt_itp');
        $this->load->model('procurement/m_service_receipt_itp_detail');
    }

    public function acceptance() {
        $data['title'] = 'SR Acceptance';
        $data['rs_service_receipt'] = $this->m_service_receipt->view('service_receipt')
        ->scope(array('approval_completed', 'auth_vendor', 'unaccepted'))
        ->get();
        $this->template->display_vendor('vn/info/service_receipt_acceptance', $data);
    }

    public function accepted() {
        $data['title'] = 'SR Acceptance';
        $data['rs_service_receipt'] = $this->m_service_receipt->view('service_receipt')
        ->scope(array('approval_completed', 'auth_vendor', 'accepted'))
        ->get();
        $this->template->display_vendor('vn/info/service_receipt_accepted', $data);
    }

    public function view($id) {
        $data['service_receipt'] = $this->m_service_receipt->view('service_receipt')
        ->scope(array('approval_completed', 'auth_vendor'))
        ->find($id);
        $data['service_receipt']->detail = $this->m_service_receipt_detail->view('service_receipt_detail')
        ->where('t_service_receipt_detail.id_service_receipt', $id)
        ->get();
        $data['service_receipt']->attachments = $this->m_service_receipt_attachment->where('id_service_receipt', $id)
        ->get();
        $this->template->display_vendor('vn/info/service_receipt_view', $data);
    }

    public function accept($id) {
        $service_receipt = $this->m_service_receipt->view('service_receipt')
        ->scope(array('approval_completed', 'auth_vendor'))
        ->find($id);
        $this->m_service_receipt->update($service_receipt->id, array(
            'accept' => 1,
            'accepted_at' => date('Y-m-d H:i:s')
        ));
        $this->redirect->with('success_message', 'Service Receipt No : '.$service_receipt->service_receipt_no.' accepted successfuly')->to('vn/info/service_receipt/acceptance');
    }
}
