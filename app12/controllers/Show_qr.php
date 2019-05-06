<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Show_qr extends CI_Controller {

    public function __construct() {
        parent::__construct();        
        $this->load->model('vn/info/M_slka', 'msl');
        $this->load->library('phpqrcode/qrlib');
    }

    public function get_qr($q)
    {        
        $res=$this->msl->check_slka(stripslashes($q));
        if($res != false)
        {
            $qr=md5($res[0]->NO_SLKA);                     
            $svgCode = QRcode::png('http:'.base_url().'show_qr?q='.$qr);                   
        }
        else
            $this->output();
    }

    public function index() {
        if(isset($_GET['q']))
        {
            $slka=stripslashes($_GET['q']);
            $res=$this->msl->check_slka($slka);  
            $dt = array();
                $data['menu'] = $dt;  
                $data['slka']=array();
            if($res!=false)
            {
                $slka =$this->msl->get_slka($res[0]->ID);                
                $data['verif']=true;
                $data['slka'] = $slka;
                $new = array(                
                    "lang" => 'IDN',                
                );
                $this->session->set_userdata($new);
            }     
            else
            {
                $data['verif']=false;           
            }
            $this->load->view('V_slka', $data);
        }
        else
            header('Location:' . base_url().'page_404');
//        $this->template->display_vendor('vn/info/V_slka', $data);
    }    
}