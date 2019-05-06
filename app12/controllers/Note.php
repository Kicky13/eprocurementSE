<?php
class Note extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('vendor/M_send_invitation')->model('vendor/M_vendor');

    }

    public function store()
    {
        $data = $this->input->post();
        $data['created_by'] = $this->session->userdata('ID') ? $this->session->userdata('ID') : $this->session->userdata('ID_USER');
        $data['author_type'] = $this->session->userdata('ID_VENDOR') ? 'm_vendor' : 'm_user';
        $this->db->insert('t_note', $data);

        $s = $this->vendor_lib->note($data['module_kode'],$data['data_id']);
        $tbody = '';
        foreach ($s->result() as $r) {
            $tbody .= "<tr><td>";
            $where = $r->author_type == 'm_vendor' ? ['ID'=>$r->created_by] : ['ID_USER'=>$r->created_by];
            $auhtor = $this->db->where($where)->get($r->author_type)->row();
            $auth = $r->author_type == 'm_vendor' ? $auhtor->NAMA : $auhtor->NAME;
            $tbody .= $auth;
            $tbody .= "<br><small>".dateToIndo($r->created_at,false,true)."</small><br>".$r->description."</td></tr>";
        }
        echo $tbody;
    }
    public function store_clarification_vendor()
    {
        $data = $this->input->post();
        $config['upload_path']  = './upload/CLARIFICATION/';
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'],0755,TRUE);
        }
        $config['allowed_types']= '*';
        
        if ($_FILES['file_path']['name']) {
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('file_path'))
            {
                echo $this->upload->display_errors('', '');exit;
            }else
            {
                $user = user();
                $files = $this->upload->data();
                $data['path'] = $files['file_name'];
            }
        }

        $data['created_by'] = $this->session->userdata('ID') ? $this->session->userdata('ID') : $this->session->userdata('ID_USER');
        $data['author_type'] = $this->session->userdata('ID_VENDOR') ? 'm_vendor' : 'm_user';
        $this->db->insert('t_note', $data);

        $s = $this->vendor_lib->note_clarification($data['data_id']);
        $tbody = '';
        foreach ($s->result() as $r) {
            $tbody .= "<tr><td>";
            $where = $r->author_type == 'm_vendor' ? ['ID'=>$r->created_by] : ['ID_USER'=>$r->created_by];
            $auhtor = $this->db->where($where)->get($r->author_type)->row();
            $auth = $r->author_type == 'm_vendor' ? $auhtor->NAMA : $auhtor->NAME;
            $tbody .= $auth;
            $tbody .= "<br><small>".dateToIndo($r->created_at,false,true)."</small><br>".$r->description;
            if($r->path):
            $tbody .= "<br><a target='_blank' href='".base_url('upload/CLARIFICATION/'.$r->path)."' class='btn btn-sm btn-info'><i class='fa fa-download'></i> Download</a>";
            endif;
            $tbody .= "</td></tr>";
        }
        echo $tbody;
    }
    public function store_clarification()
    {
    	$data = $this->input->post();
        
        $config['upload_path']  = './upload/CLARIFICATION/';
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'],0755,TRUE);
        }
        $config['allowed_types']= '*';
        
        if ($_FILES['file_path']['name']) {
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('file_path'))
            {
                echo $this->upload->display_errors('', '');exit;
            }else
            {
                $user = user();
                $files = $this->upload->data();
                $data['path'] = $files['file_name'];
            }
        }

    	$data['created_by'] = $this->session->userdata('ID') ? $this->session->userdata('ID') : $this->session->userdata('ID_USER');
    	$data['author_type'] = $this->session->userdata('ID_VENDOR') ? 'm_vendor' : 'm_user';
        $vendor_id_flag = $data['vendor_id_flag'];
        if($data['to'] > 0)
        {
            $data['vendor_id'] = $data['to'];
            /*insert 1 aja*/
            unset($data['to'],$data['vendor_id_flag']);
            $this->db->insert('t_note', $data);
        }
        else
        {
            /*insert foreach*/
            unset($data['to'],$data['vendor_id_flag']);
            $getBld = $this->vendor_lib->getBld(str_replace('OQ', 'OR', $data['data_id']));

            foreach ($getBld->result() as $r) {
                $data['vendor_id'] = $r->vendor_id;
                $this->db->insert('t_note', $data);
            }
            
            if($vendor_id_flag > 0)
            {
                $data['vendor_id'] = $vendor_id_flag;
            }
            else
            {
                return false;
            }
        }
        $data['s'] = $this->vendor_lib->note3($data);
        $this->load->view('V_note_message_clarification', $data);
        /*$s = $this->vendor_lib->note3($data['module_kode'],$data['data_id']);
        $tbody = '';
        foreach ($s->result() as $r) {
            $tbody .= "<tr><td>";
            $where = $r->author_type == 'm_vendor' ? ['ID'=>$r->created_by] : ['ID_USER'=>$r->created_by];
            $auhtor = $this->db->where($where)->get($r->author_type)->row();
            $auth = $r->author_type == 'm_vendor' ? $auhtor->NAMA : $auhtor->NAME;
            $tbody .= $auth;
            $tbody .= "<br><small>".dateToIndo($r->created_at,false,true)."</small><br>".$r->description."</td></tr>";
        }
        echo $tbody;*/
    }
    public function clarification_admin()
    {
        $data = $this->input->post();
        $data['s'] = $this->vendor_lib->note3($data);
        $q = "update t_note set is_read = 1 WHERE data_id = '$data[data_id]' AND created_by = $data[vendor_id] and author_type = 'm_vendor' and is_read = 0 and module_kode = 'bidnote'";
        $this->db->query($q);
        $this->load->view('V_note_message_clarification', $data);
    }
    public function clarification_lists($value='')
    {
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $data['lists'] = $this->vendor_lib->clarificationList();
        $this->template->display('approval/clarification_lists', $data);
    }
    public function clarification_show($msr_no='')
    {
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $data['data_id'] = $msr_no;
        // $data['lists'] = $this->vendor_lib->clarificationShow($msr_no);
        $this->template->display('V_note_admin_clarification', $data);
    }
}