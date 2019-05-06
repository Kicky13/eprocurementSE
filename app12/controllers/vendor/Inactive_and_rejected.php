<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inactive_and_rejected extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('vendor/M_inactive_and_rejected')->model('vendor/M_vendor')->model('vendor/M_send_invitation');
        $this->load->model('vendor/m_all_intern', 'mai');
        $this->load->helper(array('string', 'text'));
    }

    public function index() {
        $cek = $this->mai->cek_session();
        //$temp = $this->M_master_email->show();
        //$data['total'] = count($temp);
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $this->template->display('vendor/V_inactive_and_rejected', $data);
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function get_status($status) {
        foreach ($status as $k => $v) {
            $stts[$v->STATUS]['IND'] = $v->DESCRIPTION_IND;
            $stts[$v->STATUS]['ENG'] = $v->DESCRIPTION_ENG;
        }
        return $stts;
    }

    public function show() {
        // $status = $this->M_send_invitation->show_status();
        // $status = $this->get_status($status);
        // $data = $this->M_inactive_and_rejected->show();
        $data = $this->M_inactive_and_rejected->get_data_new();
        $dt = array();
        //$base = base_url();
        foreach ($data as $k => $v) {
            if((($v['sequence']==4)&&($v['module']==1))||(($v['sequence']==1)&&($v['module']==2))){
                $pil=1;
            }
            else{
                $pil=0;
            }
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v['email']);
            $dt[$k][2] = stripslashes($v['nama']);
            $dt[$k][3] = stripslashes($v['PREFIX']);
            $dt[$k][4] = stripslashes($v['CLASSIFICATION']);
            $dt[$k][5] = stripslashes($v['status']);
            if (strpos(strtolower(' '.$v['status'].' '),"tidak aktif") !=false) {
                $btn_detail = '<button data-toggle="modal" onclick="detail(\'' . $v['id']. '\',\'' . $v['email']. '\',\'' . $v['id_approval']. '\','.$pil.',\'' . $v['sequence']. '\')" class="btn btn-sm btn-info btndetail" title="Detail">Detail</button>';
                $btn_edit = "<a class='btn btn-warning btn-sm' title='Update' href='javascript:void(0)' onclick='update(" . $v['id'] . ")'>Edit</a>";
                $btn_delete = "<a class='btn btn-danger btn-sm disabled' title='Delete' href='javascript:void(0)' onclick='delete_data(" . $v['id'] . ")'>Delete</a>";
            }
            else if (strpos(strtolower(' '.$v['status'].' '),"data ditolak") !=false) {
                $btn_detail = '<button data-toggle="modal" onclick="detail(\'' . $v['id']. '\',\'' . $v['email']. '\',\'' . $v['id_approval']. '\','.$pil.',\'' . $v['sequence']. '\')" class="btn btn-sm btn-info btndetail" title="Detail">Detail</button>';
                $btn_edit = "<a class='btn btn-warning btn-sm disabled' title='Update' href='javascript:void(0)' onclick='edit_undangan(" . $v['id'] . ")'>Edit</a>";
                $btn_delete = "<a class='btn btn-danger btn-sm' title='Delete' href='javascript:void(0)' onclick='delete_data(" . $v['id'] . ")'>Delete</a>";
            } else {
                $btn_detail = '<button data-toggle="modal" onclick="detail(\'' . $v['id']. '\',\'' . $v['email']. '\',\'' . $v['id_approval']. '\','.$pil.',\'' . $v['sequence']. '\')" class="btn btn-sm btn-info btndetail" title="Detail">Detail</button>';
                $btn_edit = "<a class='btn btn-warning btn-sm disabled' title='Update' href='javascript:void(0)' onclick='edit_undangan(" . $v['id'] . ")'>Edit</a>";
                $btn_delete = "<a class='btn btn-danger btn-sm' title='Delete' href='javascript:void(0)' onclick='delete_data(" . $v['id'] . ")'>Delete</a>";
            }
            $dt[$k][6] = "$btn_detail $btn_edit $btn_delete";
        }
        $this->output($dt);
    }

    public function get($id) {
        echo json_encode($this->M_inactive_and_rejected->show1(array("id" => $id)));
    }

    public function update_vendor() {
        $id = $this->input->post('id');
        $stat=$this->input->post('status');

        $stat_apv=0;
        if($stat == 1)
            $stat_apv=1;
        $data_update = array(
            'id' => $id,
            'status' => $this->input->post('status'),
            'status_approve'=>$stat_apv,
            'update_by'=>$_SESSION['ID_USER']
        );
        // $ex = $this->M_inactive_and_rejected->update('ID', 'm_vendor', $id, $data_update);
        $ex = $this->M_inactive_and_rejected->update_new($data_update,2);
        if ($ex) {
            echo json_encode(array("status" => TRUE));
        } else {
            echo json_encode(array("status" => FALSE));
        }
    }

    public function delete_data($id) {
        // $email = $this->M_send_invitation->get_email($id);
        // $data = array(
            // 'email' => $email->ID_VENDOR,
        // );
        // if ($data) {
            $data_update = array(
                'id'=>$id,
                // 'ID_VENDOR' => $email->ID_VENDOR,
                'status' => 1,
                'update_by' => $_SESSION['ID_USER'],
                'status_approve' => 0,
            );
            $data_update2 = array(
                'ID_VENDOR'=>$id,
                'NOTE' => "Hapus Vendor",
                'STATUS' => 0,
            );
            $res=$this->M_inactive_and_rejected->update_new($data_update);
            if($res)
                $res=$this->M_send_invitation->add('log_vendor_acc', $data_update2);
            if($res)
                echo json_encode(array("status" => TRUE));
            else
                echo json_encode(array("status" => FALSE));
    }


}
