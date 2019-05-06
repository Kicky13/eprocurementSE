<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Negotiated_ed extends CI_Controller {

    protected $menu;

    public function __construct() {
        parent::__construct();
        $this->load->library('form');
        $this->load->library('url_generator');
        $this->load->library('redirect');
        $this->load->model('vendor/M_vendor');
        $this->load->model('vendor/M_all_intern', 'mai');

        $this->load->model('m_base');
        $this->load->model('procurement/m_nego');
        $this->load->model('procurement/m_nego_detail');

        $this->load->helper('exchange_rate');

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
            return $this->datatable->resource('t_nego','
                t_nego.msr_no,
                t_bl.bled_no,
                t_eq_data.subject,
                m_company.DESCRIPTION as company,
                m_departement.DEPARTMENT_DESC as department,
                m_user.NAME as requestor
            ')
            ->join('t_bl', 't_bl.msr_no = t_nego.msr_no')
            ->join('t_eq_data', 't_eq_data.msr_no = t_nego.msr_no')
            ->join('t_msr', 't_msr.msr_no = t_eq_data.msr_no')
            ->join('m_msrtype', 'm_msrtype.ID_MSR = t_msr.id_msr_type')
            ->join('m_company', 'm_company.ID_COMPANY = t_msr.id_company')
            ->join('m_user', 'm_user.ID_USER = t_msr.create_by')
            ->join('m_departement', 'm_departement.ID_DEPARTMENT = m_user.ID_DEPARTMENT')
            ->join('t_assignment', 't_assignment.msr_no = t_msr.msr_no')
            ->where('t_assignment.user_id', $this->session->userdata('ID_USER'))
            ->group_by(array(
                't_nego.msr_no',
                't_bl.bled_no',
                't_eq_data.subject',
                'm_company.DESCRIPTION',
                'm_departement.DEPARTMENT_DESC',
                'm_user.NAME'
            ))
            ->order_by('t_bl.bled_no', 'DESC')
            ->generate();
        }
        $data['menu'] = $this->menu;
        $this->template->display('procurement/V_negotiated_ed', $data);
    }

    public function detail($msr_no) {
        $ed = $this->db->select('t_eq_data.*, t_bl.bled_no, t_msr.title, t_msr.total_amount, m_msrtype.MSR_DESC as msr_type, m_company.DESCRIPTION as company, m_departement.DEPARTMENT_DESC as department, m_user.NAME as requestor, m_currency.CURRENCY as currency')
        ->join('t_bl', 't_bl.msr_no = t_eq_data.msr_no')
        ->join('t_msr', 't_msr.msr_no = t_eq_data.msr_no')
        ->join('m_currency', 'm_currency.ID = t_eq_data.currency')
        ->join('m_msrtype', 'm_msrtype.ID_MSR = t_msr.id_msr_type')
        ->join('m_company', 'm_company.ID_COMPANY = t_msr.id_company')
        ->join('m_user', 'm_user.ID_USER = t_msr.create_by')
        ->join('m_departement', 'm_departement.ID_DEPARTMENT = m_user.ID_DEPARTMENT')
        ->join('t_assignment', 't_assignment.msr_no = t_msr.msr_no')
        ->where('t_eq_data.msr_no', $msr_no)
        ->get('t_eq_data')
        ->row();
        $rs_negotiated = $this->m_nego->view('nego')
        ->where('t_nego.msr_no', $msr_no)
        ->get();

        $this->template->display('procurement/V_negotiated_ed_detail',  array(
            'ed' => $ed,
            'rs_negotiated' => $rs_negotiated,
            'menu' => $this->menu
        ));
    }

    public function close($msr_no, $company_letter_no = null) {
        if ($company_letter_no) {
            $this->m_nego->where('company_letter_no', $company_letter_no);
        }
        $rs_nego = $this->m_nego->where('msr_no', $msr_no)
        ->where('closed', 0)
        ->where('status', 0)
        ->get();
        foreach ($rs_nego as $r_nego) {
            $rs_nego_detail = $this->m_nego_detail->where('nego_id', $r_nego->id)
            ->get();
            foreach ($rs_nego_detail as $r_nego_detail) {
                $this->db->where('sop_id', $r_nego_detail->sop_id)
                ->where('vendor_id', $r_nego_detail->vendor_id)
                ->update('t_sop_bid', array(
                    'nego_price' => $r_nego_detail->latest_price,
                    'nego_price_base' => $r_nego_detail->latest_price_base,
                    'nego' => 1,
                    'nego_date' => date('Y-m-d')
                ));
            }
            $this->m_nego->update($r_nego->id, array('closed' => 1));
        }
        $this->redirect->with('success_message', 'Successfully close negotiation proccess')->back();
    }

    public function detail_negotiation() {
        $company_letter_no = $this->input->get('company_letter_no');
        $rs_detail_negotiation = $this->m_nego->view('detail_negotiation')
        ->where('t_nego.company_letter_no', $company_letter_no)
        ->get();
        $this->load->view('procurement/V_negotiated_ed_detail_negotiation', array(
            'rs_detail_negotiation' => $rs_detail_negotiation
        ));
    }

    public function detail_negotiation_submited($id) {
        $negotiation = $this->m_nego->view('detail_nego')->find($id);
        $items = $this->m_nego_detail->view('negotiation_item')
        ->where('nego_id', $id)
        ->get();
        $this->load->view('procurement/V_negotiated_ed_detail_negotiation_submited', array(
            'negotiation' => $negotiation,
            'items' => $items
        ));
    }
}