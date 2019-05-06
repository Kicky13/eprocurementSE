<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Procurement_value extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('vendor/M_vendor');
        $this->load->model('report/M_procurement_value');
        $this->load->helper('global_helper');
    }

    public function index($id = null) {
        $get_menu = $this->M_vendor->menu();
        $get_company = $this->M_procurement_value->m_company();

        $data['doc_type'] = $id;
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $data['company'] = $get_company;

        $this->template->display('report/V_procurement_value', $data);
    }

    public function send_datatable_goods(){
      $columns = array(
        0 => "no",
        1 => "proc_value",
        2 => "no_proc_process",
        3 => "total_base",
        4 => "po_id",
      );
      $requestData= $_REQUEST;
      $start_date  = (!empty($requestData["filter_start_date"]) ? $requestData["filter_start_date"] : "");
      $end_date  = (!empty($requestData["filter_end_date"]) ? $requestData["filter_end_date"] : "");
      if(!empty($requestData["filter_company"])) { $company  = join(",", $requestData["filter_company"]); } else { $company  = ""; }
      $draw   =  $_REQUEST['draw'];
      $length =  $_REQUEST['length'];
      $start  = $_REQUEST['start'];
      $search =  $_REQUEST['search']["value"];
      // $order_column  = $columns[$_REQUEST['order'][0]['column']];
      // $order_dir  = $_REQUEST['order'][0]['dir'];

      $dt = array(
        "start_date" => date("Y-m-d", strtotime($start_date)),
        "end_date" => date("Y-m-d", strtotime($end_date)),
        "company" => $company,
        "draw" => $draw,
        "length" => $length,
        "start" => $start,
        "search" => $search,
      );

      $send = $this->M_procurement_value->show_datatable_goods($dt);
      echo $send;
      // echo json_encode($dt, JSON_PRETTY_PRINT);
    }

    public function send_datatable_detail_goods($idx){
      $columns = array(
        0 => "no",
        1 => "po_no",
        2 => "title",
        3 => "commodity_type",
        4 => "pmethod_desc",
        5 => "rloc_desc",
        6 => "vendor",
        7 => "vendor_type",
        8 => "vendor_qlf",
        9 => "po_date",
        10 => "delivery_date",
        11 => "delivery_date",
        12 => "amount_base",
        13 => "CURRENCY",
        14 => "est_total_price",
        15 => "est_total_price_base",
        16 => "total_price_base",
        17 => "ext_unitprice_base",
        18 => "total_price_base2",
      );

      $requestData= $_REQUEST;
      $start_date  = (!empty($requestData["filter_start_date_detail"]) ? $requestData["filter_start_date_detail"] : "");
      $end_date  = (!empty($requestData["filter_end_date_detail"]) ? $requestData["filter_end_date_detail"] : "");
      if(!empty($requestData["filter_company_detail"])) { $company  = join(",", $requestData["filter_company_detail"]); } else { $company  = ""; }
      $draw   =  $_REQUEST['draw'];
      $length =  $_REQUEST['length'];
      $start  = $_REQUEST['start'];
      $search =  $_REQUEST['search']["value"];
      // $order_column  = $columns[$_REQUEST['order'][0]['column']];
      // $order_dir  = $_REQUEST['order'][0]['dir'];

      $dt = array(
        "start_date" => date("Y-m-d", strtotime($start_date)),
        "end_date" => date("Y-m-d", strtotime($end_date)),
        "company" => $company,
        "po_value" => $idx,
        "draw" => $draw,
        "length" => $length,
        "start" => $start,
        "search" => $search,
      );

      $send = $this->M_procurement_value->show_datatable_detail_goods($dt);
      echo $send;
      // echo json_encode($dt, JSON_PRETTY_PRINT);
    }

    public function send_datatable_services(){
      $columns = array(
        0 => "no",
        1 => "proc_value",
        2 => "no_proc_process",
        3 => "total_base",
        4 => "po_id",
      );
      $requestData= $_REQUEST;
      $start_date  = (!empty($requestData["filter_start_date"]) ? $requestData["filter_start_date"] : "");
      $end_date  = (!empty($requestData["filter_end_date"]) ? $requestData["filter_end_date"] : "");
      if(!empty($requestData["filter_company"])) { $company  = join(",", $requestData["filter_company"]); } else { $company  = ""; }
      $draw   =  $_REQUEST['draw'];
      $length =  $_REQUEST['length'];
      $start  = $_REQUEST['start'];
      $search =  $_REQUEST['search']["value"];
      // $order_column  = $columns[$_REQUEST['order'][0]['column']];
      // $order_dir  = $_REQUEST['order'][0]['dir'];

      $dt = array(
        "start_date" => date("Y-m-d", strtotime($start_date)),
        "end_date" => date("Y-m-d", strtotime($end_date)),
        "company" => $company,
        "draw" => $draw,
        "length" => $length,
        "start" => $start,
        "search" => $search,
      );

      $send = $this->M_procurement_value->show_datatable_services($dt);
      echo $send;
      // echo json_encode($dt, JSON_PRETTY_PRINT);
    }

    public function send_datatable_detail_services($idx){
      $columns = array(
        0 => "no",
        1 => "po_no",
        2 => "title",
        3 => "commodity_type",
        4 => "pmethod_desc",
        5 => "rloc_desc",
        6 => "vendor",
        7 => "vendor_type",
        8 => "vendor_qlf",
        9 => "po_date",
        10 => "delivery_date",
        11 => "delivery_date",
        12 => "amount_base",
        13 => "CURRENCY",
        14 => "est_total_price",
        15 => "est_total_price_base",
        16 => "total_price_base",
        17 => "ext_unitprice_base",
        18 => "total_price_base2",
      );

      $requestData= $_REQUEST;
      $start_date  = (!empty($requestData["filter_start_date_detail"]) ? $requestData["filter_start_date_detail"] : "");
      $end_date  = (!empty($requestData["filter_end_date_detail"]) ? $requestData["filter_end_date_detail"] : "");
      if(!empty($requestData["filter_company_detail"])) { $company  = join(",", $requestData["filter_company_detail"]); } else { $company  = ""; }
      $draw   =  $_REQUEST['draw'];
      $length =  $_REQUEST['length'];
      $start  = $_REQUEST['start'];
      $search =  $_REQUEST['search']["value"];
      // $order_column  = $columns[$_REQUEST['order'][0]['column']];
      // $order_dir  = $_REQUEST['order'][0]['dir'];

      $dt = array(
        "start_date" => date("Y-m-d", strtotime($start_date)),
        "end_date" => date("Y-m-d", strtotime($end_date)),
        "company" => $company,
        "po_value" => $idx,
        "draw" => $draw,
        "length" => $length,
        "start" => $start,
        "search" => $search,
      );

      $send = $this->M_procurement_value->show_datatable_detail_services($dt);
      echo $send;
      // echo json_encode($dt, JSON_PRETTY_PRINT);
    }

  }
