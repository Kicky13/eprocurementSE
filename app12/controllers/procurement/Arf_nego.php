<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Arf_nego extends CI_Controller {

    protected $menu;
    protected $document_path = 'upload/ARF';
    protected $document_allowed_types = 'jpg|jpeg|pdf|doc|docx';
    protected $document_max_size = '2048';

    public function __construct() {
        parent::__construct();
        $this->load->library('url_generator');
        $this->load->library('redirect');

        $this->load->model('vendor/M_vendor');
        $this->load->model('vendor/M_all_intern', 'mai');

        $this->load->model('m_base');
        $this->load->model('procurement/m_procurement');
        $this->load->model('procurement/arf/m_arf_sop');
        $this->load->model('procurement/arf/m_arf_response');
        $this->load->model('procurement/arf/m_arf_response_attachment');
        $this->load->model('procurement/arf/m_arf_po');
        $this->load->model('procurement/arf/m_arf_po_detail');
        $this->load->model('procurement/arf/m_arf_detail');
        $this->load->model('procurement/arf/m_arf_detail_revision');
        $this->load->model('procurement/arf/T_approval_arf_recom');
        $this->load->model('procurement/arf/T_arf_recommendation_preparation');
        $this->load->model('procurement/arf/m_arf_nego');
        $this->load->model('vn/info/M_vn', 'mvn');
        $this->load->library('form');
        $this->load->helper('data_builder_helper');
        $this->load->helper('exchange_rate_helper');

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

    public function index($value='')
    {
        $data['list'] = $this->m_arf_response->view('arf_response')->scope(['not_amd'])->where('t_arf_response.id not in (select arf_response_id from t_arf_nego where status = 0 group by arf_response_id)')->get();
        $data['title'] = 'Negotiation Amendment';
        $data['menu'] = $this->menu;
        $this->template->display('procurement/V_arf_nego', $data);
    }
    public function create($id='')
    {
        $data['menu'] = $this->menu;
        $list = $this->m_arf_response->view('arf_response')->where(['t_arf_response.id'=>$id])->get();
        $data['list'] = $list[0];
        $data['sop'] = $this->m_arf_response->arf_nego($id);
        $data['latest_nego'] = $this->m_arf_response->latest_nego($id);
        $data['arf_response_id'] = $id;
        $this->template->display('procurement/V_arf_nego_create', $data);
    }
    public function store($value='')
    {
        $nego = $this->input->post('nego');
        if($nego)
        {
            $arf_nego_store = $this->m_arf_response->arf_nego_store();
            if($arf_nego_store)
            {
                echo json_encode(['status'=>true,'msg'=>'Negotiation Submitted']);
            }
            else
            {
                echo json_encode(['status'=>false,'msg'=>'Something went wrong']);
            }
        }
        else
        {
            echo json_encode(['status'=>false,'msg'=>'Mandatory Checklist Item']);
        }
        // echo "<pre>";
        // print_r($post);
    }
    public function response($id=0)
    {
        $data['title'] = 'Negotiation Amendment Response';
        $data['menu'] = $this->menu;
        if($id > 0)
        {
            $status = $this->input->get('close') ? 2 : 1;
            $data['list'] = $this->m_arf_response->view('arf_response')->select('t_arf_nego.*')
            ->join('t_arf_nego','t_arf_nego.arf_response_id = t_arf_response.id','left')
            ->where(['t_arf_nego.status'=>$status ,'t_arf_nego.arf_response_id'=>$id])
            ->get();
            $data['arf_response_id'] = $id;
            $data['status'] = $status;
            $this->template->display('procurement/V_arf_nego_response', $data);
        }
        else
        {
            $status = $this->input->get('close') ? 2 : 1;
            $data['list'] = $this->m_arf_response->view('arf_response')->select('t_arf_nego.tanggal nego_date, t_arf_nego.vendor_response_date')
            ->join('t_arf_nego','t_arf_nego.arf_response_id = t_arf_response.id','left')
            ->where('t_arf_nego.status',$status)
            ->get();
            // echo "<pre>";
            /*print_r($data['list']);
            exit();*/
            $data['response'] = 1;
            $data['btn_title'] = $this->input->get('close') ? 'Show' : 'Process';
            $data['add_link'] = $this->input->get('close') ? "?close=1" : '';
        $this->template->display('procurement/V_arf_nego', $data);
        }
    }
    public function close_all_nego($value='')
    {
        $this->db->where(['arf_response_id'=>$this->input->post('arf_response_id')]);
        $arf_nego_store = $this->db->update('t_arf_nego', ['status'=>2]);
        if($arf_nego_store)
        {
            echo json_encode(['status'=>true,'msg'=>'Successfully negotiation process']);
        }
        else
        {
            echo json_encode(['status'=>false,'msg'=>'Something went wrong']);
        }
    }
}