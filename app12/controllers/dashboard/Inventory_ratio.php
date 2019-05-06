<?php
class Inventory_ratio extends CI_Controller
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
        $this->load->model('dashboard/m_inventory_ratio');

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
            'company',
            'material_group',
            'years',
            'months'
        );
        $data['rs_company'] = $this->m_dashboard->get_company();
        $this->template->display_dash('dashboard/V_inventory_ratio', $data);
    }

    public function get_ratio() {
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
        $rs_ito = $this->m_inventory_ratio->get_ito($filter);
        $ito = array();
        foreach ($rs_ito as $r_ito) {
            $ito[$r_ito->PERIODE] = $r_ito;
        }
        $rs_service_level = $this->m_inventory_ratio->get_service_level($filter);
        $service_level = array();
        foreach ($rs_service_level as $r_service_level) {
            $service_level[$r_service_level->PERIODE]['actual'] = $r_service_level;
        }
        foreach ($periode as $month) {
            $service_level[$month]['ideal'] = '100';
            $service_level[$month]['min'] = '95';
        }
        echo json_encode(array(
            'periode' => $periode,
            'data' => array (
                'ito' => $ito,
                'service_level' => $service_level
            )
        ));
    }

    /*public function generate_material_request() {
        $rs_mutasi = $this->db->where('DOC', 'II')->get('sync_mutasi_stock')->result();
        foreach ($rs_mutasi as $r_mutasi) {
            $this->db->insert('t_material_request_item', array(
                'request_no' => $r_mutasi->DOC_NO,
                'semic_no' => $r_mutasi->SEMIC_NO,
                'qty' => $r_mutasi->QTY,
                'qty_act' => $r_mutasi->QTY,
                'qty_avl' => $r_mutasi->QTY,
                'branch_plant' => $r_mutasi->BRACH_PLANT
            ));
        }
    }*/
}