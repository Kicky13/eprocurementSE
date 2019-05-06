<?php
class Inventory_index extends CI_Controller
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
        $this->load->model('dashboard/m_inventory_index');

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
        $data['menu'] = $this->menu;
        $data = $this->config->item('dashboard')['scm'];
        $data['filters'] = array(
            'company',
            'material_group',
            'years',
            'months'
        );
        $data['rs_company'] = $this->m_dashboard->get_company();
        $this->template->display_dash('dashboard/V_inventory_index', $data);
    }

}
