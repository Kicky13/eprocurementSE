<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Master_company extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');        
        $this->load->model('vendor/M_all_intern', 'mai');
        $this->load->model('setting/M_master_company', 'mmc');        
        $this->load->model('vendor/M_vendor');        
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function show() {
        $result = $this->mmc->get_data();
        $dt = array();
        if ($result != false) {
            foreach ($result as $k => $v) {                
                $dt[$k][0] = $k + 1;
                $dt[$k][1] = $v->ID_COMPANY;
                $dt[$k][2] = $v->DESCRIPTION;
                $dt[$k][3] = $v->ABBREVIATION;
                $stat=$v->STATUS;
                if($stat==1)
                    $stat="ACTIVE"; 
                else
                    $stat="NOT ACTIVE";                               
                $dt[$k][4] = $stat;
                $dt[$k][5] = '<button id='.$v->ID_COMPANY.' class="btn btn-sm btn-primary update" title="Edit"><i class="fa fa-edit"></i></button>&nbsp<button class="btn btn-sm btn-danger" onclick="delete_dt('.$v->ID_COMPANY.')"><i class="fa fa-trash"></i></button>';                                
            }
        }
        $this->output($dt);
    }    

    public function add_data()
    {
        $dt=array(
            "ID_COMPANY"=>stripslashes($this->input->post('id_com')),
            "DESCRIPTION"=>stripslashes($this->input->post('des_com')),
            "ABBREVIATION"=>stripslashes($this->input->post('abb_com')),            
            "STATUS"=>stripslashes($this->input->post('status')),
        );
        $key=stripslashes($this->input->post('key'));
        if($key == 0)
        {            
            $dt['CREATE_BY']=date('ID_USER');
            $res=$this->mmc->cek($dt);
            if($res!= false)
            {
                $res=$this->mmc->add($dt);
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
            $dt['UPDATE_TIME']=date('Y-m-d H:i:s');
            $dt['UPDATE_BY']=$_SESSION['ID_USER'];
            $dt['ID_COMPANY']=$key;
            $res=$this->mmc->update($dt);
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
        $this->template->display('setting/V_master_company', $data);
    }

    public function delete_data()
    {
        $dt=array(
            "ID_COMPANY"=>stripslashes($this->input->post('ID')),            
            "STATUS"=>"0"
        );
        $res=$this->mmc->update($dt);
        if($res != false)
            $this->output(array("msg"=>"Data Berhasil Dihapus","Status"=>"Success"));
        else
            $this->output(array("msg"=>"Data Gagal Dihapus","Status"=>"Error"));
    }
}