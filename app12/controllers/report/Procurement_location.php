<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Procurement_location extends CI_Controller {
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

    public function goods() {   
        if ($this->input->is_ajax_request()) {     
            return $this->get('GOODS');
        }
        $data['menu'] = $this->menu;        
        $data['title'] = 'Report Procurement Location (GOODS)';
        $this->template->display('report/V_procurement_location', $data);
    }

    public function service() {        
        if ($this->input->is_ajax_request()) {     
            return $this->get('SERVICE');
        }
        $data['menu'] = $this->menu;
        $data['rs_company'] = $this->m_report->get_company();     
        $data['title'] = 'Report Procurement Location (Service)';   
        $this->template->display('report/V_procurement_location', $data);
    }

    protected function get($type) {
        $this->load->library('datatable');
        $filter = $this->input->get('filter');        
        $condition = array();
        if (isset($filter['company'])) {
            $this->db->where_in('t_msr.ID_COMPANY', $filter['company']);            
            $condition[] = 't_msr.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if ($filter['begin_date']) {
            $this->db->where('t_purchase_order.po_date >= ', date('Y-m-d', strtotime($filter['begin_date'])));
            $condition[] = 't_purchase_order.po_date >= \''.date('Y-m-d', strtotime($filter['begin_date'])).'\'';
        }
        if ($filter['end_date']) {
            $this->db->where('t_purchase_order.po_date <= ', date('Y-m-d', strtotime($filter['end_date'])));
            $condition[] = 't_purchase_order.po_date <= \''.date('Y-m-d', strtotime($filter['end_date'])).'\'';
        }
        if (count($condition) <> 0) {
            $condition_query = 'AND '.implode(' AND ', $condition);
        } else {
            $condition_query = '';
        }  
        $total_agreement = $this->db->select('SUM(COALESCE(agreement.value, 0)) AS total_agreement')
        ->join('t_msr', 't_msr.id_ploc = m_plocation.ID_PGROUP', 'left')
        ->join('t_purchase_order', 't_purchase_order.msr_no = t_msr.msr_no', 'left')
        ->join('(
            SELECT 
                t_msr.id_ploc, count(1) AS number, 
                SUM(total_price_base) AS value
            FROM t_purchase_order_detail
            JOIN t_purchase_order ON t_purchase_order.id = t_purchase_order_detail.po_id
            JOIN t_msr ON t_msr.msr_no = t_purchase_order.msr_no    
            GROUP BY t_msr.id_ploc
        ) agreement', 'agreement.id_ploc = m_plocation.ID_PGROUP', 'left')   
        ->get('m_plocation')
        ->row();

        return $this->datatable->resource('m_plocation', '
            m_plocation.PGROUP_DESC AS location, 
            COALESCE(agreement.number, 0) AS number,
            COALESCE(agreement.value, 0) AS value
        ')        
        ->join('(
            SELECT 
                t_msr.id_ploc, count(1) AS number, 
                SUM(total_price_base) AS value
            FROM t_purchase_order_detail
            JOIN t_purchase_order ON t_purchase_order.id = t_purchase_order_detail.po_id
            JOIN t_msr ON t_msr.msr_no = t_purchase_order.msr_no            
            WHERE t_purchase_order_detail.id_itemtype = \''.$type.'\'
            '.$condition_query.'
            GROUP BY t_msr.id_ploc
        ) agreement', 'agreement.id_ploc = m_plocation.ID_PGROUP', 'left')                   
        ->add_column('total_agreement', $total_agreement->total_agreement)        
        ->generate();        
    }
}