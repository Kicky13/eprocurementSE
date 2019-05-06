<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Local_content extends CI_Controller {
    protected $menu;

    public function __construct() {
        parent::__construct();
        $this->load->model('vendor/M_vendor');
        $this->load->model('vendor/M_all_intern', 'mai');
        $this->load->model('report/m_report');        

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
            $filter = $this->input->get('filter');        
                        
            $condition = array();
            if (isset($filter['company'])) {            
                $condition[] = 't_msr.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
            }
            if ($filter['begin_date']) {            
                $condition[] = 't_purchase_order.po_date >= \''.date('Y-m-d', strtotime($filter['begin_date'])).'\'';
            }
            if ($filter['end_date']) {            
                $condition[] = 't_purchase_order.po_date <= \''.date('Y-m-d', strtotime($filter['end_date'])).'\'';
            }
            if (count($condition) <> 0) {
                $condition_query = implode(' AND ', $condition);
            } else {
                $condition_query = '';
            }  

            if ($condition_query) {
                $this->datatable->where($condition_query);
            }
            return $this->datatable->resource('t_purchase_order', '
                t_purchase_order.*,
                m_vendor.NAMA as vendor,
                currency.CURRENCY as currency,               
                currency_base.CURRENCY as currency_base,                
                ROUND(CASE
                    WHEN tkdn_type = 1 THEN tkdn_value_goods
                    WHEN tkdn_type = 2 THEN tkdn_value_service
                    WHEN tkdn_type = 3 THEN (tkdn_value_goods+tkdn_value_service)/2
                    ELSE 0
                END, 2) as commitment
            ')
            ->join('m_vendor', 'm_vendor.ID = t_purchase_order.id_vendor')
            ->join('t_msr', 't_msr.msr_no = t_purchase_order.msr_no')
            ->join('m_currency currency', 'currency.ID = t_purchase_order.id_currency')
            ->join('m_currency currency_base', 'currency_base.ID = t_purchase_order.id_currency_base')   
            ->where('t_purchase_order.issued', 1)         
            ->generate();
        }
        $data['menu'] = $this->menu;         
        $data['title'] = 'Local Content';
        $this->template->display('report/V_local_content', $data);
    }

}