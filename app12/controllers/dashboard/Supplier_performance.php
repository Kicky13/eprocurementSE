<?php
class Supplier_performance extends CI_Controller
{
    protected $menu;
    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('dashboard', TRUE);
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('dashboard/M_home', 'mhm');
        $this->load->model('vendor/M_all_intern', 'mai');

        $this->load->model('dashboard/m_dashboard');
        $this->load->model('dashboard/m_supp_performance');
        $this->load->helper('exchange_rate');

        $cek = $this->mai->cek_session();
        $get_menu = $this->mhm->menu();
        foreach($get_menu as $k => $v)
        {
            $this->menu[$v->PARENT][$v->ID_MENU]['DESCRIPTION_IND']=$v->DESCRIPTION_IND;
            $this->menu[$v->PARENT][$v->ID_MENU]['DESCRIPTION_ENG']=$v->DESCRIPTION_ENG;
            $this->menu[$v->PARENT][$v->ID_MENU]['URL']=$v->URL;
            $this->menu[$v->PARENT][$v->ID_MENU]['ICON']=$v->ICON;
        }
    }
    public function index() {
        $data = $this->config->item('dashboard')['scm'];
        $data['filters'] = array(
            'supplier_rating',
            'supplier_classification',
            'supplier',
            'years',
            'months'
        );
        $this->template->display_dash('dashboard/V_supplier_performance', $data);
    }

    public function get_performance() {
        $filter = $this->input->post('filter');
        if (!isset($filter['years'])) {
            $filter['years'][] = date('Y');
        }
        $periode = array();
        if (isset($filter['months'])) {
            foreach ($filter['years'] as $y) {
                foreach ($filter['months'] as $month) {
                    $periode[] = $y.'-'.$month;
                }
            }
            $filter['periode'] = $periode;
        }
        $rs_performance = $this->m_supp_performance->get_performance($filter);
        $performance = array();
        foreach ($rs_performance as $record_performance) {
            $performance[$record_performance->PERFORMANCE][] = $record_performance;
        }
        $agreement = array();
        // $rs_agreement = $this->m_supp_performance->get_performance_agreement($filter, $rs_performance);
        $rs_agreement = $this->m_supp_performance->get_cpm_cor_agreement($filter);
        foreach ($rs_agreement as $r_agreement) {
            $agreement[$r_agreement->status][$r_agreement->doc] = $r_agreement;
            // $agreement['cor'][] = $r_agreement;
            // if ($r_agreement->po_type == 20) {
            //     $agreement['cpm'][] = $r_agreement;
            // }
        }
        $rating = $this->m_dashboard->get_supplier_rating();
        echo json_encode(array(
            'periode' => $periode,
            'rating' => $rating,
            'data' => array (
                'performance' => $performance,
                'agreement' => $agreement
            )
        ));
    }

    public function get_details() {
        $filter = $this->input->get('filter');
        if (!isset($filter['years'])) {
            $filter['years'][] = date('Y');
        }
        $periode = array();
        if (isset($filter['months'])) {
            foreach ($filter['years'] as $y) {
                foreach ($filter['months'] as $month) {
                    $periode[] = $y.'-'.$month;
                }
            }
            $filter['periode'] = $periode;
        }
        $condition = array();
        if (isset($filter['periode'])) {
            $condition[] = 'LEFT(t_purchase_order.po_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['classification'])) {
            $condition_clasification[]='m_vendor.CLASSIFICATION LIKE \'%'.$filter['classification'][0].'%\'';
            unset($filter['classification'][0]);
            foreach($filter['classification'] as $classification) {
                $condition_clasification[]='m_vendor.CLASSIFICATION LIKE \'%'.$classification.'%\'';
            }
            $condition[] = '('.implode(' OR ', $condition_clasification).')';
        }
        if (isset($filter['supplier'])) {
            $condition[] = 'm_vendor.ID IN (\''.implode('\',\'', $filter['supplier']).'\')';
        }
        if (count($condition) <> 0) {
            $condition_query = implode(' AND ', $condition);
        } else {
            $condition_query = '';
        }
        $this->load->library('datatable');
        if ($condition_query) {
            $this->datatable->where($condition_query, null, false);
        }
        if (isset($filter['rating'])) {
            $this->datatable->having('PERFORMANCE IN (\''.implode('\',\'', $filter['rating']).'\')');
        }
        $rating = $this->m_dashboard->get_supplier_rating();
        $this->datatable->resource('t_performance_cor', 'm_vendor.ID, m_vendor.NAMA, m_vendor.NO_SLKA,m_vendor.CLASSIFICATION, AVG(t_performance_cor.score) AVG_RATING,
            (CASE
                WHEN AVG(t_performance_cor.score) >= '.$rating['Excellent']->score_bawah.' THEN \'Excellent\'
                WHEN AVG(t_performance_cor.score) <= '.$rating['Good']->score_atas.' AND AVG(t_performance_cor.score) <= '.$rating['Good']->score_bawah.' THEN \'Good\'
                WHEN AVG(t_performance_cor.score) <= '.$rating['Fair']->score_atas.' AND AVG(t_performance_cor.score) <= '.$rating['Fair']->score_bawah.' THEN \'Fair\'
                ELSE \'Poor\'
            END) PERFORMANCE
        ')
        ->join('t_purchase_order', 't_purchase_order.po_no = t_performance_cor.po_no')
        ->join('m_vendor', 'm_vendor.ID = t_performance_cor.vendor_id')
        ->group_by(array('m_vendor.ID', 'm_vendor.NAMA', 'm_vendor.NO_SLKA', 'm_vendor.CLASSIFICATION'))
        ->generate();
    }
}
