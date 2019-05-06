<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Approval_verification extends CI_Controller {

    protected $itemNumber = "";
    protected static $valueNextNumber = 0;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('global_helper');
        $this->load->model('vendor/M_approval', 'map')->model('vendor/M_vendor')->model('vendor/M_invitation')->model('vn/info/M_all_vendor', 'mav');
        $this->load->model('vendor/M_show_vendor', 'msv');
        $this->load->model('vendor/m_all_intern', 'mai');
        $this->load->model('vendor/M_approval_verification');
        $this->load->database();
    }

    public function index() {
        $cek = $this->mai->cek_session();
        $get_menu = $this->M_vendor->menu();
        $all = $this->map->get_alldata();
        $all1 = $this->map->get_vendor();
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
        $this->template->display('vendor/V_approval', $data);
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function show() {
        $data = $this->M_approval_verification->show();
        if ($data != false) {
            $dt = array();
            $k=0;
            foreach ($data as $row) {
                $dt_note = $this->M_invitation->show_log_vendor_acc($row['ID_VENDOR']);
                if ($row['FILE'] != '') {
                  $attch_file = '<a href="'.base_url("upload/LEGAL_DATA/").$row['FILE'].'" target="_blank" class="btn btn-primary btn-sm" title="View File" ><i class="fa fa-file"></i></a>';
                } else {
                  $attch_file = "-";
                }
                $dt[$k][0] = $k+1;
                $dt[$k][1] = $row['ID_VENDOR'];
                $dt[$k][2] = $row['nama'];
                $dt[$k][3] = $row['PREFIX'];
                $dt[$k][4] = $row['CLASSIFICATION'];
                $dt[$k][5] = $row['description'];
                $dt[$k][6] = $dt_note['NOTE'];
                if((($row['sequence']==4)&&($row['module']==1))||(($row['sequence']==1)&&($row['module']==2))){
                    $pil=1;
                }
                else{
                    $pil=0;
                }
                if(($row['sequence']<4)&&($row['module']==1))
                {
                    $dt[$k][7] ='<a class="btn btn-success btn-sm" title="Approve" href="javascript:void(0)" onclick="accept_inv(\'' . $row['supplier_id']. '\',\'' . $row['ID_VENDOR']. '\',\'' . $row['id']. '\',\'' . $row['sequence']. '\')">Approve</a>'
                    . ' <a class="btn btn-danger btn-sm" title="Reject" href="javascript:void(0)" onclick="reject_inv(\'' . $row['supplier_id']. '\',\'' . $row['ID_VENDOR']. '\',\'' . $row['id']. '\',\'' . $row['sequence']. '\')">Reject</a>';
                }
                else
                    $dt[$k][7] = '</a> <button data-toggle="modal" onclick="detail(\'' . $row['supplier_id']. '\',\'' . $row['ID_VENDOR']. '\',\'' . $row['id']. '\','.$pil.',\'' . $row['sequence']. '\')" class="btn btn-sm btn-info" title="Process">Process</button> ';
                $k++;
            }
            $this->output($dt);
        } else {
            $this->output();
        }
    }

  }
