<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Master_department extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');        
        $this->load->model('vendor/M_all_intern', 'mai');
        $this->load->model('setting/M_master_department', 'mmd');        
        $this->load->model('vendor/M_vendor');        
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function show() {
        $result = $this->mmd->get_data();
        $dt = array();
        if ($result != false) {
            foreach ($result as $k => $v) {                
                $dt[$k][0] = $k + 1;
                $dt[$k][1] = $v->ID_COMPANY;
                $dt[$k][2] = $v->ID_DEPARTMENT;
                $dt[$k][3] = $v->DEPARTMENT_DESC;
                $dt[$k][4] = $v->DEPARTMENT_ABR;
                $stat=$v->STATUS;
                if($stat==1)
                    $stat="ACTIVE";     
                else
                    $stat="NOT ACTIVE";                           
                $dt[$k][5] = $stat;
                $dt[$k][6] = '<button id='.$v->ID_COMPANY.' class="btn btn-sm btn-primary update" title="Edit"><i class="fa fa-edit"></i></button>&nbsp<button class="btn btn-sm btn-danger" onclick="delete_dt('.$v->ID_COMPANY.','.$v->ID_DEPARTMENT.')"><i class="fa fa-trash"></i></button>';                                
            }
        }
        $this->output($dt);
    }

    public function add_data()
    {
        $dt=array(
            "ID_COMPANY"=>stripslashes($this->input->post('id_com')),
            "ID_DEPARTMENT"=>stripslashes($this->input->post('id_cost')),
            "DEPARTMENT_DESC"=>stripslashes($this->input->post('des_com')),
            "DEPARTMENT_ABR"=>stripslashes($this->input->post('abb_com')),            
            "STATUS"=>stripslashes($this->input->post('status')),
        );
        $key=stripslashes($this->input->post('key'));
        if($key == 0)
        {            
            $dt['CREATE_BY']=$_SESSION['ID_USER'];
            $dt['CREATE_ON']=date('Y-m-d H:i:s');
            $res=$this->mmd->cek($dt);
            if($res!= false)
            {
                $res=$this->mmd->add($dt);
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
            $dt['ID_COMPANY']=$key;
            
            $res=$this->mmd->update($dt);
            if($res != false)
                $this->output(array("msg"=>"Data Berhasil Disimpan","Status"=>"Success"));
            else
                $this->output(array("msg"=>"Data Gagal Disimpan","Status"=>"Error"));
        }
    }

    public function index() {
        $cek = $this->mai->cek_session();
        $get_menu = $this->M_vendor->menu();
        $sel=$this->mmd->get_company();        
        $dt = array();
        $data['vendor'] = [];
        $data['menu'] = [];
        if($sel != false)
            $data['sel']=$sel;
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $this->template->display('setting/V_master_department', $data);
    }    

    public function delete_data()
    {
        $dt=array(
            "ID_COMPANY"=>stripslashes($this->input->post('ID')),            
            "ID_DEPARTMENT"=>stripslashes($this->input->post('DEP')),            
            "STATUS"=>"0"
        );
        $res=$this->mmd->update($dt);
        if($res != false)
            $this->output(array("msg"=>"Data Berhasil Dihapus","Status"=>"Success"));
        else
            $this->output(array("msg"=>"Data Gagal Dihapus","Status"=>"Error"));
    }
}