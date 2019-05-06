<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Home extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('dashboard', TRUE);
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('dashboard/M_home', 'mhm');
        $this->load->model('vendor/M_all_intern', 'mai');
        $this->load->model('dashboard/m_dashboard');
        $cek = $this->mai->cek_session();
    }

    public function index($key = null) {
        $data = array();
        if ($key) {
            $data = $this->config->item('dashboard')[$key];
            $get_menu = $this->mhm->menu($key);
            if ($get_menu) {
                $menu = array();
                foreach($get_menu as $k => $v)
                {
                    $menu[$v->PARENT][$v->ID_MENU]['DESCRIPTION_IND']=$v->DESCRIPTION_IND;
                    $menu[$v->PARENT][$v->ID_MENU]['DESCRIPTION_ENG']=$v->DESCRIPTION_ENG;
                    $menu[$v->PARENT][$v->ID_MENU]['URL']=$v->URL;
                    $menu[$v->PARENT][$v->ID_MENU]['ICON']=$v->ICON;
                }
                $data['dashboard_menu'] = $menu;
            }
        }
        $this->template->display_dash('dashboard/V_home', $data);
    }
}