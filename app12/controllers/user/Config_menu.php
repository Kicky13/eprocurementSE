<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Config_menu extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user/M_config_menu')->model('vendor/M_vendor');
        $this->db = $this->load->database('default', true);
        $this->load->model('vendor/m_all_intern', 'mai');
        $this->load->helper('html');
    }

    public function index() {
        $cek = $this->mai->cek_session();
        $temp = $this->M_config_menu->show();
        $data['total'] = count($temp);
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $data['icone'] = $this->M_config_menu->icon();
        $this->template->display('user/V_config_menu', $data);
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function show() {
        $data = $this->M_config_menu->show();
        $dt[0] = array();
        foreach ($data as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU] = $v;
        }

        $n = 0;
        $dt1 = array();
        foreach ($dt[0] as $k => $v) {
            $dt1[$n][0] = $n + 1;
            $dt1[$n][1] = "<i class='fa " . $v->ICON . "'></i> " . stripslashes($v->DESKRIPSI_IND);
            $dt1[$n][2] = $v->URL;
            $btn_up = "<a class='btn btn-primary btn-sm' title='Up' href='javascript:void(0)' onclick=\"sort('up', '" . $v->ID_MENU . "', '" . $v->SORT . "')\"><i class='fa fa-arrow-up'></i></a>";
            $btn_dw = "<a class='btn btn-primary btn-sm' title='down' href='javascript:void(0)' onclick='sort('down', '" . $v->ID_MENU . "', '" . $v->SORT . "')'><i class='fa fa-arrow-down'></i></a>";
            $btn_edit = "<a class='btn btn-info btn-sm' title='Update' href='javascript:void(0)' onclick='edit('" . $v->ID_MENU . "')'><i class='fa fa-edit'></i></a>";
            $dt1[$n][3] = "$btn_up $btn_dw $btn_edit";
            $n++;
            foreach ($dt[$k] as $kk => $vv) {
                $dt1[$n][0] = $n + 1;
                $dt1[$n][1] = "&nbsp&nbsp&nbsp&nbsp<i class='fa fa-angle-double-right'></i> " . stripslashes($vv->DESKRIPSI_IND);
                $dt1[$n][2] = $vv->URL;
                $btn_up = "<a class='btn btn-primary btn-sm' title='Up' href='javascript:void(0)' onclick='up('up', " . $vv->ID_MENU . ", '" . $v->SORT . "')'><i class='fa fa-arrow-up'></i></a>";
                $btn_dw = "<a class='btn btn-primary btn-sm' title='down' href='javascript:void(0)' onclick='down('down', " . $vv->ID_MENU . ", '" . $v->SORT . "')'><i class='fa fa-arrow-down'></i></a>";
                $btn_edit = "<a class='btn btn-info btn-sm' title='Update' href='javascript:void(0)' onclick='edit(" . $vv->ID_MENU . ")'><i class='fa fa-edit'></i></a>";
                $dt1[$n][3] = "$btn_up $btn_dw $btn_edit";
                $n++;
            }
        }
        echo json_encode($dt1);
    }

    public function add() {
        $email = stripslashes($this->input->post('email'));
        $nama = stripslashes($this->input->post('nama'));

        $cek = $this->M_config_menu->cek('m_vendor', $nama, $email);
        if ($cek != false)
            $this->output(array("msg" => "Data sudah ada"));
        $content = $this->M_config_menu->get_email_dest();
        $content[0]->ROLES = explode(",", $content[0]->ROLES);
        $res = $this->M_config_menu->get_user($content[0]->ROLES, count($content[0]->ROLES));
        $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
        $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";
        $data = array(
            'email' => $this->input->post('email'),
            'img1' => $img1,
            'img2' => $img2,
            'nama' => $this->input->post('nama'),
            'hari' => $this->input->post('limit'),
            'title' => $content[0]->TITLE,
            'open' => $content[0]->OPEN_VALUE,
            'close' => $content[0]->CLOSE_VALUE
        );
        foreach ($res as $k => $v) {
            $data['dest'][] = $v->EMAIL;
        }

        if ($this->addsendMail($data)) {
            $rubah_data = array(
                'NAMA' => stripslashes($_POST['nama']),
                'ID_VENDOR' => stripslashes($_POST['email']),
                'URL_BATAS_HARI' => stripslashes($_POST['limit']),
                'CREATE_BY' => '1',
                'UPDATE_BY' => '1',
                'STATUS' => '1'
            );
            $data_update2 = array(
                'ID_VENDOR' => $this->input->post('email'),
                'STATUS' => 1,
                'CREATE_BY' => 1
            );
            $this->M_config_menu->add('m_vendor', $rubah_data);
            $this->M_config_menu->add('log_vendor_acc', $data_update2);
            echo json_encode(array("status" => TRUE));
        } else {
            echo json_encode(array("status" => FALSE));
        }
    }

    public function get($id) {
        echo json_encode($this->M_config_menu->show2(array("ID" => $id)));
    }

    public function sort($id) {
        if ($data) {
            $data_update = array(
                'ID_VENDOR' => $email->ID_VENDOR,
                'STATUS' => 0,
                'NOTE' => "Hapus Vendor",
                'CREATE_BY' => 1
            );
            $data_update2 = array(
                'STATUS' => 0,
                'CREATE_BY' => 1
            );
            $this->M_config_menu->update('ID', 'm_vendor', $id, $data_update2);
            $this->M_config_menu->add('log_vendor_acc', $data_update);
            echo json_encode(array("status" => TRUE));
        } else {
            echo json_encode(array("status" => FALSE));
        }
    }

}
