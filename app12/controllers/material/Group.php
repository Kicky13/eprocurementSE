<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Group extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('material/M_group')->model('vendor/M_vendor');
        $this->load->helper(array('string', 'text'));
    }

    public function index() {
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $this->template->display('material/V_group', $data);
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function show() {
        $data = $this->M_group->show();
        //echopre($data);exit;
        $dt = array();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->klasifikasi);
            $dt[$k][2] = stripslashes($v->material_group);
            $dt[$k][3] = stripslashes($v->grupname);
            $dt[$k][4] = stripslashes($v->type);
            if ($v->status == 1) {
                $dt[$k][5] = "Active";
            } else {
                $dt[$k][5] = "Nonactive";
            }
           $dt[$k][6] = "<a class='btn btn-primary btn-sm' title='Update' href='javascript:void(0)' onclick='update(" . $v->id2 . ")'><i class='fa fa-edit'></i></a>";
        }
        $this->output($dt);
        // echo json_encode($dt);
    }

    public function change() {
        echopre($_POST);exit;
//        strtoupper($string)
        $data = array(
            'DESCRIPTION' => stripslashes($_POST['mat_group']),
            'DESCRIPTION' => stripslashes($_POST['desc']),
            'CATEGORY' => $_POST['type'],
            'STATUS' => $_POST('status'),
            'UPDATE_BY' => 1,
            'UPDATE_TIME' => date('Y-m-d H:i:s')
        );
        if ($_POST['id'] == null) {//add data
            $data['CREATE_BY'] = 1;
            //$cek = $this->m_material_group->show(array("MATERIAL_group" => strtoupper(stripslashes($_POST['mat_group']))));
            if (count == 0) {//cek ketersediaan data
                $q = $this->M_group->add($data);
            } else {
                echo "Grup Materaial Telah Digunakan";exit;
            }
        } else {//update data
            $q = $this->M_group->update($_POST['id'], $data);
        }

        //CEK QUERY BERHASIL DIJALANKAN
        if ($q == 1) {
            echo "sukses";
        } else {
            echo "Gagal Menambah Data!";
        }
    }

    public function add_material_group() {

      $id_material = $this->input->post('id_material');
      $mat_group = $this->input->post('mat_group');
      $desc = $this->input->post('desc');
      $type = $this->input->post('type');
      $status = $this->input->post('status');

      $group_id = $this->db->query("SELECT MATERIAL_GROUP FROM m_material_group WHERE ID = '".$mat_group."'");

      // $group = $this->db->query("SELECT COUNT(1)+1 as maxid FROM m_material_group where TYPE = '".$type."' AND PARENT = '".$group_id->row()->MATERIAL_GROUP."'");
      $group = $this->db->query("SELECT COUNT(1)+1 as maxid FROM m_material_group where TYPE = '".$type."'");

      $data = array(
       'MATERIAL_GROUP' => $group->row()->maxid,
       'DESCRIPTION' => $desc,
       'TYPE' => $type,
       'CREATE_BY' => $this->session->userdata['ID_USER'],
       'UPDATE_BY' => $this->session->userdata['ID_USER'],
       'CATEGORY' => 'GROUP',
       'STATUS' => $status,
       'PARENT' => $group_id->row()->MATERIAL_GROUP
      );

      if ($id_material != "") {
        $query = $this->M_group->update_m_group($id_material, $data);
      } else {
        $query = $this->M_group->simpan_m_group($data);
      }

      if ($query !== false) {
        $respon['success'] = true;
      } else {
        $respon['success'] = false;
      }
      echo json_encode($respon);
    }

    public function get($id) {
        echo json_encode($this->M_group->show(array("g.id" => $id)));
    }

}
