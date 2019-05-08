<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Clarification extends CI_Controller {

    protected $menu;
    protected $module_kode;

    public function __construct() {
        parent::__construct();
        $this->load->library('form');
        $this->load->library('url_generator');
        $this->load->library('redirect');
        $this->load->model('vendor/M_vendor');
        $this->load->model('vendor/M_all_intern', 'mai');

        $this->load->model('m_base');
        $this->load->model('m_clarification');

        $this->mai->cek_session();
        $get_menu = $this->M_vendor->menu();
        $this->menu = array();
        foreach ($get_menu as $k => $v) {
            $this->menu[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $this->menu[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $this->menu[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $this->menu[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $this->module_kode = $this->input->get('module_kode');
    }

    /*public function index() {
        $data['menu'] = $this->menu;
        $data['rs_thread'] = $this->m_clarification->get_ed();
        $this->template->display('clarification/index', $data);
    }*/

    public function ed() {
        $data['menu'] = $this->menu;
        $data['module_kode'] = 'ed';
        $data['title'] = 'ED Clarification';
        $this->template->display('clarification/index', $data);
    }

    public function bid_proposal() {
        $data['menu'] = $this->menu;
        $data['module_kode'] = 'bid_proposal';
        $data['title'] = 'BID Proposal Clarification';
        $this->template->display('clarification/index', $data);
    }

    public function get_threads() {
        $search = $this->input->get('search');
        $data['rs_threads'] = $this->m_clarification->get_threads($this->module_kode, $search);
        $this->load->view('clarification/threads', $data);
    }

    public function get_users() {
        $thread_id = $this->input->get('thread_id');
        $data['rs_users'] = $this->m_clarification->get_users($this->module_kode, $thread_id);
        $data['thread_id'] = $thread_id;
        $this->load->view('clarification/users', $data);
    }

    public function get_clarifications() {
        $thread_id = $this->input->get('thread_id');
        $user_id = $this->input->get('user_id');

        if ($this->module_kode == 'bid_proposal') {
            $this->m_clarification->scope('bid_proposal');
        } else {
            $this->m_clarification->scope('ed');
        }

        $data['rs_clarifications'] = $this->m_clarification->view('clarification')
        ->where('t_note.module_kode', 'bidnote')
        ->where('t_note.data_id', $thread_id)
        ->group_start()
            ->where('t_note.vendor_id', $user_id)
            ->or_group_start()
                ->where('t_note.created_by', $user_id)
                ->where('t_note.author_type <> ', 'm_user')
            ->group_end()
        ->group_end()
        ->order_by('t_note.created_at', 'DESC')
        ->get();

        $this->m_clarification->where('t_note.module_kode', 'bidnote')
        ->where('t_note.data_id', $thread_id)
        ->where('t_note.created_by', $user_id)
        ->where('t_note.author_type <> ', 'm_user')
        ->update(array(
            'is_read' => 1
        ));
        $data['thread_id'] = $thread_id;
        $data['user_id'] = $user_id;
        $this->load->view('clarification/clarifications', $data);
    }

    public function send() {
        /*print_r($_FILES['attachment_add']);
        exit();*/
        $post = $this->input->post();
        $module_kode = 'bidnote';
        $response = array();
        if ($_FILES['attachment']['tmp_name']) {
            $config['upload_path'] = './upload/CLARIFICATION';
            $config['allowed_types'] = 'pdf|jpg|jpeg|doc|docx';
            $config['max_size'] = '2048';
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('attachment')) {
                $response = array(
                    'success' => false,
                    'message' => $this->upload->display_errors()
                );
                echo json_encode($response);
                return false;
            }
            $uploaded = $this->upload->data();
            $post['attachment'] = $uploaded['file_name'];
        }
        if(isset($_FILES['attachment_add']))
        {
            $files = $_FILES['attachment_add'];
            $uploaded = [];
            for ($i=0; $i < count($_FILES['attachment_add']['name']) ; $i++) { 
              $_FILES['images']['name']= $files['name'][$i];
              $_FILES['images']['type']= $files['type'][$i];
              $_FILES['images']['tmp_name']= $files['tmp_name'][$i];
              $_FILES['images']['error']= $files['error'][$i];
              $_FILES['images']['size']= $files['size'][$i];
              if($_FILES['images']['name'])
              {
                $config = [];
                $config['upload_path'] = './upload/clarifitaction_details';
                $config['allowed_types'] = 'pdf|jpg|jpeg|doc|docx';
                $config['max_size'] = '2048';
                $config['encrypt_name'] = TRUE;
                
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('images')) {
                  $uploaded[] = $this->upload->data();
                  // print_r($uploaded);
                } else {
                  $errorMsg = $this->upload->display_errors('', '');
                  $response = array(
                    'success' => false,
                    'message' => $errorMsg
                  );
                  echo json_encode($response);
                  return false;
                }
              }
            }
        }
        // exit();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('thread_id', 'ED', 'required');
        if (!$this->form_validation->run()) {
            $response = array(
                'success' => false,
                'message' => validation_errors('<div>', '</div>')
            );
            echo json_encode($response);
            return false;
        }

        if (!@$post['to']) {
            $rs_users = $this->m_clarification->get_bl($post['thread_id']);
            foreach ($rs_users as $r_user) {
                $post['to'][] = $r_user->id;
            }
        }
        foreach ($post['to'] as $to) {
            $this->db->insert('t_note', array(
                'vendor_id' => $to,
                'module_kode' => $module_kode,
                'data_id' => $post['thread_id'],
                'description' => htmlspecialchars($post['message']),
                'path' => @$post['attachment'],
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('ID_USER'),
                'author_type' => 'm_user'
            ));
            /*$noteId = $this->db->insert_id();
            if(count($uploaded) > 0)
            {
              foreach ($uploaded as $key => $value) {
                $fieldDetail = ['note_id' => $noteId, 'path' => $value['file_name']];
                $this->db->insert('t_note_detail', $fieldDetail);
              }
            }*/
        }
        $response = array(
            'success' => true,
            'message' => 'Clarification has been sent'
        );
        echo json_encode($response);
    }

    public function get_users_json() {
        $thread_id = $this->input->get('thread_id');
        $reponse = $this->m_clarification->get_users($this->module_kode, $thread_id);
        echo json_encode($reponse);
    }
}
