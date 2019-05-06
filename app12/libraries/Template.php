<?php if(!defined('BASEPATH')) exit ('No Direct Script access allowed');

class Template {
    private $_obj = null;
    
    function __construct() {
        $this->_obj =&get_instance();
    }
    
    function display($view,$data=array()){
        $this->_obj->load->view('V_head',$data);        
        $this->_obj->load->view($view,$data);
        $this->_obj->load->view('V_foot');
    }
    function display_vendor($view,$data=array()){
        $this->_obj->load->view('V_head_vendor',$data);
        $this->_obj->load->view($view,$data);
        $this->_obj->load->view('V_foot_vendor');
    }
    function display_dash($view,$data=array()){
        $this->_obj->load->view('V_head_dash',$data);
        $this->_obj->load->view($view,$data);
        $this->_obj->load->view('V_foot_dash');
    }
    
//    function view($view,$data=array()){
//        $this->_obj->load->view('home/header',$data);
//        $this->_obj->load->view('home/navigation');
//        $this->_obj->load->view($view,$data);
//        $this->_obj->load->view('home/berita');
//        $this->_obj->load->view('home/footer');
//    }
}