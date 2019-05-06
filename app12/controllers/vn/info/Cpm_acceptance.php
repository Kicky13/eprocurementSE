<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cpm_acceptance extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('session');        
        $this->load->model('vn/info/M_cpm_acceptance', 'mcs');
        $this->load->model('vn/info/M_vn', 'mvn');
        $this->load->model('vn/info/M_all_vendor', 'mav');    
    }
    
    public function index() {        
        $get_menu = $this->mvn->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['DESKRIPSI_IND'] = $v->DESCRIPTION_IND;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['DESKRIPSI_ENG'] = $v->DESCRIPTION_ENG;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['ICON'] = $v->ICON;
        }
        $data['menu'] = $dt;        
        $this->template->display_vendor('vn/info/V_cpm_acceptance', $data);        
    }
/* ===========================================-------- API START------- ====================================== */
    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }
    public function send()
    {
     
        $po=$this->input->post("po");
        $phase=$this->input->post("phase");
        $res=false;
        $res=$this->mcs->send_data($po,$phase);                
        $data_log=array(
            "ID_VENDOR"=>$_SESSION['ID'],
            "STATUS"=>'1',
            "CREATE_TIME"=>date('Y-m-d H:i:s'),
            "CREATE_BY"=>$_SESSION['ID'],
            "TYPE"=>"CPM",
            "NOTE"=>stripslashes($_POST['note'])
        );
        if($res)
            $log=$this->mcs->add('log_vendor_acc',$data_log);                
        if($res != false)
            $this->output(array('status'=>'Success', 'msg'=>'Data has been submitted!'));
        else
            $this->output(array('status'=>'Failed', 'msg'=>'Oops, something went wrong!'));
    }

    

/* ===========================================       Add data START     ====================================== */
    public function get_list() {
        $res = $this->mcs->get_list();
        $dt = array();
        if (count($res) > 0) {
            foreach($res as $k => $v) {
                $dt[$k][0] = $k+1;
                $dt[$k][1] = $v['po_no'];
                $dt[$k][2] = $v['title'];
                $dt[$k][3] = $v['company'];
                $dt[$k][4] = $v['phase'];
                $dt[$k][5] = date('j F Y', strtotime($v['due_date']));
                $dt[$k][6] = $v['status'];
                $dt[$k][7] = "<button class='btn btn-sm btn-success' onclick='process(\"".$v['po_no']."\",".$v['id'].")'>Detail</button>";
            }
        }
        return $this->output($dt);
    }

    public function get_cpm_detail()
    {
        $po=$this->input->post('po');
        $phase=$this->input->post('phase');
        $vendor=$_SESSION['ID'];
        $res=$this->mcs->get_cpm_detail($po,$vendor,$phase);
        if($res != false)
            return $this->output($res);
        return $this->output();        
    }

    public function get_upload($po) {
        $dt = array();
        $res = $this->mcs->get_upload($po);
        if ($res != false) {
            $count = 1;
            foreach ($res as $k => $v) {
                $dt[$k][0] = $count;
                $dt[$k][1] = ucwords($v['type']);
                $dt[$k][2] = $v['file_name'];
                $dt[$k][3] = $v['createdate'];
                $dt[$k][4] = "<span class='badge badge-pill badge-success'>".$v['name']."</span>";
                $dt[$k][5] = "<button class='btn btn-sm btn-primary' onclick=preview('".$v['path']."')><i class='fa fa-file'></i></button>";
            }
            return $this->output($dt);
        }
        else
            $this->output();
    }
}