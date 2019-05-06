<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_roles extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user/M_user_roles')->model('vendor/M_vendor');
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
        $this->template->display('user/V_user_roles', $data);
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function get_usermenu() {

        $menu = $this->M_user_roles->get_usermenu();
        $dt = array();
        $temp = array();
        $c = 0;
        $d = 0;
        $this->load->helper('data_builder');
        $data = tree_data($menu, 'ID_MENU', 'PARENT', 0, 'DESKRIPSI_ENG');
        $this->output($data);
    }

    public function show() {
        $data = $this->M_user_roles->show();
        $dt = array();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->ID_USER_ROLES);
            $dt[$k][2] = stripslashes($v->DESCRIPTION);
            if ($v->STATUS == 1) {
                $dt[$k][3] = "Active";
            } else {
                $dt[$k][3] = "Nonactive";
            }
            $dt[$k][4] = "<button class='btn btn-primary btn-sm' title='Update' href='javascript:void(0)' onclick='update(" . $v->ID_USER_ROLES . ")'><i class='fa fa-edit'></i></button>";
        }
        echo json_encode($dt);
    }

    public function get($id) {
        $dt = $this->M_user_roles->show(array("ID_USER_ROLES" => $id));
        $menu=$dt[0]->MENU;
        if ($menu) {
          $menu = substr($menu,1,-1);
          $res=$this->M_user_roles->get_parent($menu);
          $menu=",".$menu.",";
          foreach ($res->result_array() as $row) {
              if(strpos($menu,$row['PARENT']) != false)
                  $menu=str_replace(",".$row['PARENT'].",","",$menu);
          }
        }
        $new=array();
        foreach ($dt as $k => $v) {
            $new=array(
              "ID_USER_ROLES"=>$v->ID_USER_ROLES,
                "MENU"=> $v->MENU,
                "STATUS"=>$v->STATUS,
                "DESCRIPTION"=>$v->DESCRIPTION,
                "TASK"=>$v->TASK,
            );
        }
        echo json_encode($new);
    }

    public function change() {

        if (!empty($_POST['idmenu'])) {
          $id_menu = $_POST['idmenu'];
        } else {
          $id_menu = "";
        }

        if (!empty($_POST['idtask'])) {
          $id_task = $_POST['idtask'];
        } else {
          $id_task = "";
        }

        $menu = null;

        if ($id_menu !== "" and $id_task !== "") {
          foreach ($id_menu as $k => $v) {
              $menu_tmp = $menu . "," . $v;
              $menu = $menu_tmp;
          }
          $menu = substr($menu, 1);
          $res=$this->M_user_roles->get_parent($menu);

          $menu =",".$menu;
          foreach ($res->result_array() as $row) {
              if(strpos($menu, ','.$row['PARENT'].',') === false) {
                  $menu= ",".$row['PARENT'].$menu;
              }
          }

          $menu = substr($menu, 1);
          $res=$this->M_user_roles->get_parent($menu);
          $menu =",".$menu;
          foreach ($res->result_array() as $row) {
              if(strpos($menu,','.$row['PARENT'].',') === false) {
                $menu = ",".$row['PARENT'].$menu;
              }
          }

          $menu = $menu . ",";
		  $task = $this->taskGen($id_task);
          $data = array(
              'DESCRIPTION' => ucfirst(stripslashes($_POST['desc'])),
              'TASK' => $task,
              'MENU' => $menu,
              'STATUS' => $_POST['status'],
              'UPDATE_BY' => $this->session->userdata['ID_USER'],
              'UPDATE_TIME' => date('Y-m-d H:i:s')
          );

          //add data
          if ($_POST['id'] == null) {
              $data['CREATE_BY'] = 1;
              $cek = $this->M_user_roles->show(array("DESCRIPTION" => ucfirst(stripslashes($_POST['desc']))));
              //cek ketersediaan data
              if (count($cek) == 0) {
                  $q = $this->M_user_roles->add($data);
              } else {
                  echo "Tipe Deskripsi Telah Digunakan";
                  exit;
              }
          } else {
              //update data
              $q = $this->M_user_roles->update($_POST['id'], $data);
          }

          //CEK QUERY BERHASIL DIJALANKAN
          if ($q == 1) {
              echo "sukses";
          } else {
              echo "Gagal Menambah Data!";
          }
          // echo json_encode($data);
        } else {
          echo "Menu Kategori dan Task Tidak Boleh Kosong!";
        }

    }
	
    public function taskGen($id_menu) {
		$menu = null;
		foreach ($id_menu as $k => $v) {
              $menu_tmp = $menu . "," . $v;
              $menu = $menu_tmp;
          }
          $menu = substr($menu, 1);
          $res=$this->M_user_roles->get_parentTask($menu);

          $menu =",".$menu;
          foreach ($res->result_array() as $row) {
              if(strpos($menu, ','.$row['parent'].',') === false) {
                  $menu= ",".$row['parent'].$menu;
              }
          }

          $menu = substr($menu, 1);
          $res=$this->M_user_roles->get_parentTask($menu);
          $menu =",".$menu;
          foreach ($res->result_array() as $row) {
              if(strpos($menu,','.$row['parent'].',') === false) {
                $menu = ",".$row['parent'].$menu;
              }
          }

          $menu = $menu . ",";
		  return $menu;
	}
    public function getTask() {
		$data = $this->db->where('parent', 0)->order_by('sort', 'asc')->get('m_menu_task')->result();
		$return = $this->getChild($data);
		$this->output($return);
	}

    public function getChild($value) {
		$result = array();
		foreach ($value as $val) {
		  $val->text = $val->desc_eng;
		  $val->tree_level = $val->desc_eng;
		
		  $datachild	= $this->db->where('parent', $val->id)->order_by('sort', 'asc')->get('m_menu_task')->result();

		  $val->items = array();
		  if ($datachild) {
			$childlist = $this->getChild($datachild);
			if ($childlist) {
			  $val->items = $childlist;
			}
		  }
		  array_push($result,$val);
		}
		return $result;
	
	}

}
