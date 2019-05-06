<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pre_bid_location extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form');
        $this->load->library('url_generator');
        $this->load->library('redirect');

        $this->load->model('vendor/M_vendor');
        $this->load->model('vendor/M_all_intern', 'mai');
        $this->load->model('m_base');
        
        $this->load->model('setting/m_pre_bid_location');

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
            return $this->datatable->resource('m_pre_bid_location')
            // ->where('active', 1)
            ->generate();
        }
        $data['menu'] = $this->menu;
        $this->template->display('setting/V_pre_bid_location', $data);
    }

    public function find($id) {
        $model = $this->m_pre_bid_location->find($id);
        $response = array();
        if ($model) {
            $response = array(
                'success' => true,
                'data' => $model
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Can\'t find selected data'
            );
        }     
        echo json_encode($response);
    }

    public function create() {
        $post = $this->input->post();        
        $post['created_at'] = date('Y-m-d H:i:s');
        $result = $this->m_pre_bid_location->insert($post);
        $response = array();
        if ($result) {
            $response = array(
                'success' => true,
                'message' => 'Pre Bid Location saved successfully'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Pre Bid Location failed to save'
            );
        }
        echo json_encode($response);
    }

    public function update($id) {
        $post = $this->input->post();                
        $result = $this->m_pre_bid_location->update($id, $post);
        $response = array();
        if ($result) {
            $response = array(
                'success' => true,
                'message' => 'Pre Bid Location updated successfully'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Pre Bid Location failed to update'
            );
        }
        echo json_encode($response);
    }

    public function delete($id) {        
        $result = $this->m_pre_bid_location->update($id, array(
            'active' => 0
        ));
        $response = array();
        if ($result) {
            $response = array(
                'success' => true,
                'message' => 'Pre Bid Location deleted successfully'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Pre Bid Location failed to delete'
            );
        }
        echo json_encode($response);
    }
}