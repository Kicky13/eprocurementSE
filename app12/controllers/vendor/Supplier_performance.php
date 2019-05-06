<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Supplier_performance extends CI_Controller {

    protected $itemNumber = "";
    protected static $valueNextNumber = 0;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model('vendor/M_approval', 'map')->model('vendor/M_vendor');
        $this->load->model('vendor/M_all_intern', 'mai');                
        $this->load->model('vendor/M_supplier_performance', 'msp');     
        $this->load->database();
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
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
        $this->template->display('vendor/V_supplier_performance', $data);
    }

    public function get_nama($id)
    {
        $res=$this->msp->get_nama($id);
        if($res != false)
            return $this->output($res);
        else
            return $this->output("false");
    }

    public function show()
    {
        $dt=array();
        $res=$this->msp->show();
        if($res!=null)
        {
            foreach($res as $k => $v)
            {
                $tamp = $k + 1;
                $dt[$k][0] = $tamp;
                $dt[$k][1] = $v->NO_SLKA;
                $dt[$k][2] = $v->NAMA;
                $dt[$k][3] = $v->CLASSIFICATION;
                $dt[$k][4] = $v->total;
                $dt[$k][5] = $v->avg_rating;
                $dt[$k][6] = "<button class='btn btn-sm btn-success' onclick='proc(".$v->vendor_id.")'><i class='fa fa-history'></i></button>";
            }
        }
        return $this->output($dt);
    }

    public function get_hist($id)
    {
        $dt=array();
        $res=$this->msp->get_hist($id);
        if($res!=null)
        {
            foreach($res as $k => $v)
            {
                $tamp = $k + 1;
                $dt[$k][0] = $tamp;
                $dt[$k][1] = $v->po_no;
                $dt[$k][2] = $v->id;
                $dt[$k][3] = $v->score;                
            }
        }
        return $this->output($dt);
    }
}