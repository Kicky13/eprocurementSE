<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Master_inspection extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');        
        $this->load->model('vendor/M_all_intern', 'mai');
        $this->load->model('setting/M_master_inspection', 'mmip');        
        $this->load->model('vendor/M_vendor');        
    }

    public function output($return = array()) {
        
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function show() {        
        $result = $this->mmip->get_data();        
        $dt = array();
        if ($result != false) {
            foreach ($result as $k => $v) {                
                $dt[$k][0] = $k + 1;
                $dt[$k][1] = $v->ID_INSPECTION;
                $dt[$k][2] = $v->INSPECTION_DESC;
                $stat=$v->STATUS;
                if($stat==1)
                    $stat="ACTIVE";  
                else
                    $stat="NOT ACTIVE";                              
                $dt[$k][3] = $stat;
                $dt[$k][4] = '<button id='.$v->ID_INSPECTION.' class="btn btn-sm btn-primary update" title="Edit"><i class="fa fa-edit"></i></button>&nbsp<button class="btn btn-sm btn-danger" onclick="delete_dt(\''.$v->ID_INSPECTION.'\')"><i class="fa fa-trash"></i></button>';                                
            }
        }
        $this->output($dt);
    }

    public function add_data()
    {
        $dt=array(
            "ID_INSPECTION"=>stripslashes($this->input->post('ins')),
            "INSPECTION_DESC"=>stripslashes($this->input->post('des_bank')),
            "CREATE_BY"=>$_SESSION['ID_USER'],
            "STATUS"=>stripslashes($this->input->post('status')),
        );
        $key=stripslashes($this->input->post('key'));
        if($key == '0')
        {
            $res=$this->mmip->cek($dt);
            if($res!= false)
            {
                $res=$this->mmip->add($dt);
                if($res != false)
                    $this->output(array("msg"=>"Data Berhasil Disimpan","Status"=>"Success"));
                else
                    $this->output(array("msg"=>"Data Gagal Disimpan","Status"=>"Error"));
            }
            else
            {
                $this->output(array("msg"=>"Data sudah ada","Status"=>"Error"));
            }
        }
        else{
            $dt['CHANGED_ON']=date('Y-m-d H:i:s');
            $dt['CHANGED_BY']=$_SESSION['ID_USER'];
            $dt['ID_INSPECTION']=$key;
            $res=$this->mmip->update($dt);
            if($res != false)
                $this->output(array("msg"=>"Data Berhasil Disimpan","Status"=>"Success"));
            else
                $this->output(array("msg"=>"Data Gagal Disimpan","Status"=>"Error"));
        }
    }

    public function index() {
        $cek = $this->mai->cek_session();
        $get_menu = $this->M_vendor->menu();
        
        $dt = array();
        $data['vendor'] = [];
        $data['menu'] = [];

        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $this->template->display('setting/V_inspection', $data);
    }

    public function delete_data()
    {
        $dt=array(
            "ID_INSPECTION"=>stripslashes($this->input->post('ID')),            
            "STATUS"=>"0"
        );
        $res=$this->mmip->update($dt);
        if($res != false)
            $this->output(array("msg"=>"Data Berhasil Dihapus","Status"=>"Success"));
        else
            $this->output(array("msg"=>"Data Gagal Dihapus","Status"=>"Error"));
    }
}