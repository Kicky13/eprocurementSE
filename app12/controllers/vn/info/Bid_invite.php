<?php
class Bid_invite extends CI_Controller
{
    public function __construct() {
        parent::__construct();        
        $this->load->helper('url');
        $this->load->library('session');        
        $this->load->model('vn/info/M_bid_invite', 'mbi');
        $this->load->model('vn/info/M_vn', 'mvn');
        $this->load->model('vn/info/M_all_vendor', 'mav');
    }

    public function index() {
        $cek = $this->mav->cek_session();
     
        $get_menu = $this->mvn->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['DESKRIPSI_IND'] = $v->DESCRIPTION_IND;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['DESKRIPSI_ENG'] = $v->DESCRIPTION_ENG;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['ICON'] = $v->ICON;
        }
        $data['menu'] = $dt;
        $this->template->display_vendor('vn/info/V_bid_invite', $data);
    }    
/* ===========================================-------- API START------- ====================================== */
    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }
/* ===========================================-------- get data START------- ====================================== */
    public function process()
    {
        $id=stripslashes($this->input->post('entity_id'));
        $res=$this->mbi->get_template($id);
        if($res != false)
            $this->output($res);
        else
            $this->output("false");
    }

    public function get_invitation()
    {
        $id=stripslashes($this->input->post('entity_id'));
        $res=$this->mbi->get_template($id);
        if($res != false)
            $this->output($res);
        else
            $this->output("false");
    }

/* ===========================================-------- get data Table START------- ====================================== */
    public function show_list_invite(){
        // $res=$this->mbi->get_list_invite();
        // foreach($res as $k => $v)
        // {

        // }
        $dt = array();        
        $k=0;
        $dt[$k][0] = 1;
        $dt[$k][1] = "120000000-OQ-10101";
        $dt[$k][2] = "Provision Of";
        $dt[$k][3] = "Supreme Energy Muara Laboh";
        $dt[$k][4] = "Feb 10,2018";
        $dt[$k][5] = "Feb 10,2018 02:00 PM";
        $dt[$k][6] = "Feb 10,2018 02:00 PM";
        $dt[$k][7] = '<button class="btn btn-sm btn-outline-primary detail" title="Bid" id=1><span class="fa fa-info"></span></button>';
        $this->output($dt);
    }

    public function show_attch($id)
    {
        $dt = array();        
        $k=0;        
        $dt[$k][0] = "Exhibit E";
        $dt[$k][1] = 1;
        $dt[$k][2] = "Performance bond.pdf";        
        $dt[$k][3] = "Feb 10,2018 02:00 PM";
        $dt[$k][4] = "Dimas Seto<br/>Procurement Specialist";        
        $this->output($dt);
    }
}
?>