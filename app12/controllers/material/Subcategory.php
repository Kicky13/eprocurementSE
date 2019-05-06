<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Subcategory extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('material/M_subcategory')->model('vendor/M_vendor');
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
        $this->template->display('material/V_subcategory', $data);
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function show() {
      $data = $this->M_subcategory->show();
      //echopre($data);exit;
      $dt = array();
      foreach ($data as $k => $v) {
          $dt[$k][0] = $k + 1;
          $dt[$k][1] = stripslashes($v->klasifikasi);
          $dt[$k][2] = stripslashes($v->grupname);
          $dt[$k][3] = stripslashes($v->subdesc);
          $dt[$k][4] = stripslashes($v->type);
          if ($v->status == 1) {
              $dt[$k][5] = "Active";
          } else {
              $dt[$k][5] = "Nonactive";
          }
         $dt[$k][6] = "<a class='btn btn-primary btn-sm' title='Update' href='javascript:void(0)' onclick='update(" . $v->idsub . ")'><i class='fa fa-edit'></i></a>";
      }
      $this->output($dt);
    }

    public function get($id) {
        echo json_encode($this->M_subcategory->show_edit(array("s.id" => $id)));
    }

    public function getsubgroup(){
      if (!empty($_POST['idnya'])) { $idnya = $_POST['idnya']; } else { $idnya = ""; }
      $data  = $this->M_subcategory->getsubgroup($idnya);
      echo '<option value=""> Select</option>';
      foreach ($data as $arr => $val) {
        echo '<option value="'.$val->ID.'">'.$val->DESCRIPTION.'</option>';
      }
      // echo $str;
    }

    public function save_subsubgrup(){
      if (!empty($_POST['id_material'])) { $id_material = $_POST['id_material']; } else { $id_material = ""; }
      if (!empty($_POST['mat_group'])) { $mat_group = $_POST['mat_group']; } else { $mat_group = ""; }
      if (!empty($_POST['mat_subgroup'])) { $mat_subgroup = $_POST['mat_subgroup']; } else { $mat_subgroup = ""; }
      if (!empty($_POST['desc'])) { $desc = $_POST['desc']; } else { $desc = ""; }
      if (!empty($_POST['type'])) { $type = $_POST['type']; } else { $type = ""; }
      if (!empty($_POST['status'])) { $status = $_POST['status']; } else { $status = ""; }

      $group_id = $this->db->query("SELECT MATERIAL_GROUP FROM m_material_group WHERE ID = '".$mat_subgroup."'");

      $group = $this->db->query("SELECT COUNT(1)+1 as maxid FROM m_material_group where TYPE = '".$type."' AND PARENT = '".$group_id->row()->MATERIAL_GROUP."'");

      $data = array(
       'MATERIAL_GROUP' => $group->row()->maxid,
       'DESCRIPTION' => $desc,
       'TYPE' => $type,
       'CREATE_BY' => $this->session->userdata['ID_USER'],
       'UPDATE_BY' => $this->session->userdata['ID_USER'],
       'CATEGORY' => 'SUBGROUP',
       'STATUS' => $status,
       'PARENT' => $group_id->row()->MATERIAL_GROUP
      );

      if ($id_material != "") {
        $query = $this->M_subcategory->update_m_subgroup($id_material, $data);
      } else {
        $query = $this->M_subcategory->simpan_m_subgroup($data);
      }

      if ($query !== false) {
        $respon['success'] = true;
      } else {
        $respon['success'] = false;
      }

      echo json_encode($respon);
    }

}
