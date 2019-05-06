<?php
class Cor_cpm_development extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('procurement/M_cor_development', 'mcd');
        $this->load->model('vendor/M_vendor');
        $this->load->model('vendor/m_all_intern', 'mai');
    }

    public function index() {
        $cek = $this->mai->cek_session();
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $data['cpm_rank'] = $this->mcd->get_cpm_rank();
        $data['init_from_cpm'] = 2;
        $this->template->display('procurement/V_cor_development', $data);
    }
}
?>