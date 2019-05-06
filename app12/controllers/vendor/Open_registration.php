<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Open_Registration extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('vendor/M_open_registration', 'mor')->model('vendor/M_vendor');
        $this->load->model('vendor/m_all_intern', 'mai');
        $this->load->database();
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function show() {
        $data = $this->mor->show();
        if ($data != false) {
            $dt = array();
            foreach ($data as $k => $v) {
                $dt[$k][0] = $k + 1;
                $dt[$k][1] = DateTime::createFromFormat('Y-m-d', $v->DATE_START)->format('d/m/Y');
                $dt[$k][2] = DateTime::createFromFormat('Y-m-d', $v->DATE_CLOSE)->format('d/m/Y');                
                $dt[$k][3] = '<button id="' . $v->ID . '" class="btn btn-sm btn-primary update" title="Update"><i class="fa fa-edit"></i></button>'
                        . '<button id="' . $v->ID . '" style="margin-left:3px" class="btn btn-sm btn-danger delete" title="Delete"><i class="fa fa-trash"></i></button>';
            }
            $this->output($dt);
        } else {
            $this->output();
        }
    }

    public function get_data($id) {
        
    }

    public function check_date($open_date, $close_date) {
        $open_date = DateTime::createFromFormat('d/m/Y', $open_date)->format('Y-m-d');
        $close_date = DateTime::createFromFormat('d/m/Y', $close_date)->format('Y-m-d');
        $diff = date_diff(date_create($open_date), date_create($close_date));
        $tamp = date('Y-m-d');
        $check = date_diff(date_create($tamp), date_create($close_date));

        if ($check->format("%R%a") < 0)
            $this->output(array("msg" => "The close date is not valid", "status" => false));
        else if ($diff->format("%R%a") == 0)
            $this->output(array("msg" => "The open and close date is same", "status" => false));
        else if ($diff->format("%R%a") < 0)
            $this->output(array("msg" => "The close date is before open date", "status" => false));
    }

    public function add_data() {
        $open_date = $this->input->post('open_date');
        $close_date = $this->input->post('close_date');
        $this->check_date($open_date, $close_date);
        $open_date = DateTime::createFromFormat('d/m/Y', $open_date)->format('Y-m-d');
        $close_date = DateTime::createFromFormat('d/m/Y', $close_date)->format('Y-m-d');
        $data = array(
            'DATE_START' => $open_date,
            'DATE_CLOSE' => $close_date,
            'CREATE_BY' => 1,
            'STATUS' => 1
        );
        $res = $this->mor->save_data($data);
        if ($res != false)
            return $this->output(array("status" => true));
        else
            return $this->output(array("status" => false));
    }

    public function update_data() {
        $open_date = $this->input->post('open_date');
        $close_date = $this->input->post('close_date');
        $this->check_date($open_date, $close_date);

        $open_date = DateTime::createFromFormat('d/m/Y', $open_date)->format('Y-m-d');
        $close_date = DateTime::createFromFormat('d/m/Y', $close_date)->format('Y-m-d');
        $data = array(
            'DATE_START' => $open_date,
            'DATE_CLOSE' => $close_date,
            'UPDATE_BY' => 1,
            'ID' => $this->input->post('ID')
        );
        $res = $this->mor->update_data($data);
        if ($res != false)
            return $this->output(array("status" => true));
        else
            return $this->output(array("status" => false));
    }

    public function delete_data() {
        $data = array(            
            'STATUS' => 0,
            'UPDATE_BY' => 1,
            'ID' => $this->input->post('ID')
        );        
        $res = $this->mor->delete_data($data);
        if ($res != false)
            return $this->output(array("status" => true));
        else
            return $this->output(array("status" => false));
    }
    
    public function filter_data() {        
        $res = $this->mor->filter_data($_POST);
        $dt = array();
        if ($res != null) {
            foreach ($res as $k => $v) {
                $dt[$k][0] = $k + 1;
                $dt[$k][1] = DateTime::createFromFormat('Y-m-d', $v->DATE_START)->format('d/m/Y');
                $dt[$k][2] = DateTime::createFromFormat('Y-m-d', $v->DATE_CLOSE)->format('d/m/Y');
                $dt[$k][3] = '<span>' . $v->STATUS . '</span>';
                $dt[$k][4] = '<a id="' . $v->ID . '" class="btn btn-sm btn-primary update"><i class="fa fa-edit"></i></a>'
                        . '<a id="' . $v->ID . '" style="margin-left:3px" class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i></a>';
            }
        }
        $this->output($dt);
    }

    public function index() {
        $cek=$this->mai->cek_session();
        $get_menu = $this->M_vendor->menu();
        $tamp = $this->mor->show();
        $data['total']=count($tamp);
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
        $this->template->display('vendor/V_open_registration', $data);
    }

}
