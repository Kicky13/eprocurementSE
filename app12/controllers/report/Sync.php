<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sync extends CI_Controller {

    protected $menu;

    public function __construct() {
        parent::__construct();
        $this->load->model('vendor/M_vendor');
        $this->load->model('vendor/M_all_intern', 'mai');
        $this->load->model('report/m_report');        

        $this->mai->cek_session();
        $get_menu = $this->M_vendor->menu();
        $this->menu = array();
        foreach ($get_menu as $k => $v) {
            $this->menu[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $this->menu[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $this->menu[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $this->menu[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
    }        

    public function index() {         
        if ($this->input->is_ajax_request()) {
            $this->load->library('datatable');
            return $this->datatable->resource('i_sync')
            ->filter(function($model) {
                $filter = $this->input->get('filter');
                if (isset($filter['doc_type'])) {
                    $model->where_in('doc_type', $filter['doc_type']);
                }
                if ($filter['isclosed'] !== '') {
                    $model->where('isclosed', $filter['isclosed']);
                }
                if ($filter['begin_date']) {
                    $model->where('createdate >= ', date('Y-m-d', strtotime($filter['begin_date'])));
                }
                if ($filter['end_date']) {
                    $model->where('createdate <= ', date('Y-m-d', strtotime($filter['begin_date'])));
                }
            })
            ->generate();            
        }
        $data['menu'] = $this->menu;
        $data['rs_sync'] = $this->db->select('m_sync_doc.*, i_sync_log.last_execution_time')
        ->join('(SELECT script_type, MAX(execute_time) as last_execution_time FROM i_sync_log GROUP BY script_type) as i_sync_log', 'i_sync_log.script_type = m_sync_doc.doc', 'left')
        ->get('m_sync_doc')
        ->result();
        $this->template->display('report/V_sync', $data);
    }    

    public function resync($id) {
        $result = $this->db->where('id', $id)
        ->where('isclosed', 1)
        ->update('i_sync', array(
            'isclosed' => 0
        ));
        $response = array();
        if ($result) {
            $response = array(
                'success' => true,
                'message' => 'You have successfully resync'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'You have failed resync'
            );
        }
        echo json_encode($response);
    }
}