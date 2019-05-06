<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Note extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('m_base');
        $this->load->model('note_approval/m_note');
    }

    public function get($module_kode, $data_id) {
        $this->load->view('note_approval/note', array(
            'module_kode' => $module_kode,
            'data_id' => $data_id
        ));
    }

    public function store($module_kode, $data_id) {        
        $post = $this->input->post();
        $this->m_note->insert(array(
            'module_kode' => $module_kode,
            'data_id' => $data_id,
            'description' => $post['description'],
            'author_type' => 'm_user',
            'is_read' => 0
        ));
        $response = array(
            'success' => true,
            'message' => 'Note has been posted'
        );
        $this->output->set_content_type('application/json')
        ->set_output(json_encode($response));
    }
}