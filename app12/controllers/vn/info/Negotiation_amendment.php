<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Negotiation_amendment extends CI_Controller {

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
        $this->load->model('procurement/arf/m_arf_detail');
        $this->load->model('procurement/arf/m_arf_detail_revision');
        $this->load->model('procurement/arf/m_arf_po');
        $this->load->model('procurement/arf/m_arf_po_detail');
        $this->load->model('procurement/arf/m_arf_po_document');
        $this->load->model('procurement/arf/m_arf_sop');
        $this->load->model('procurement/arf/m_arf_recommendation_preparation');
        $this->load->model('procurement/arf/m_arf_acceptance');
        $this->load->model('procurement/arf/m_arf_acceptance_document');
        $this->load->model('procurement/arf/m_arf_nego');
        $this->load->model('vn/info/M_vn', 'mvn');
        $this->load->helper('exchange_rate_helper');
    }

    public function index() {
        $data['model'] = $this->m_arf_nego->with_vendor()->result();
        $this->template->display_vendor('vn/info/Negotiation_amendent', $data);
    }
    public function show($id='')
    {
        $data['model'] = $this->m_arf_nego->with_vendor($id)->row();
        $data['detail'] = $this->m_arf_nego->detail($data['model']->nego_id)->result();
        $data['title'] = 'Negotiation Amendment';
        $this->template->display_vendor('vn/info/Negotiation_amendent_show', $data);
    }
    public function store()
    {
        /*arf_nego_id*/
        $price = $this->input->post('new_price');
        $statusPrice = 0;
        foreach ($price as $key => $value) {
            if($value == 0)
            {
                $statusPrice = 1;
            }

        }
        if($statusPrice == 0)
        {
            $store = $this->m_arf_nego->response_vendor();
            if($price)
            {
                echo json_encode(['status'=>true,'msg'=>'Response Submitted']);
            }
            else
            {
                echo json_encode(['status'=>false,'msg'=>'Something went wrong']);
            }
        }
        else
        {
            echo json_encode(['status'=>false,'msg'=>'Mandatory Price']);
        }
    }
}