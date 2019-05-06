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

        foreach ($menu as $k => $v) {
            if ($v->PARENT == 0) {
                $temp[$v->ID_MENU] = $c;
                $dt[$c]['id'] = $v->ID_MENU;
                $dt[$c]['text'] = strtolower($v->DESKRIPSI_IND);
//                $dt[$c]['expanded'] = true;
                $c++;
            } else {
                $tamp[$temp[$v->PARENT]][] = array(
                    'id' => $v->ID_MENU,
                    'text' => strtolower($v->DESKRIPSI_IND),
                );
                $d++;
            }
        }
        foreach ($dt as $k => $v) {
            foreach ($tamp as $k1 => $v1) {
                if ($k == $k1)
                    $dt[$k]['items'] = $tamp[$k1];
            }
        }
        $this->output($dt);
    }

    public function show() {
        $data = $this->M_user_roles->show();
        $dt = array();
        foreach ($data as $k => $v) {

        }
        echo json_encode($dt);
    }

    public function get($id) {
        $dt=$this->M_user_roles->show(array("ID_USER_ROLES" => $id));
        $menu=$dt[0]->MENU;
        $menu = substr($menu,1,-1);
        $res=$this->M_user_roles->get_parent($menu);
        $menu=",".$menu.",";
        foreach ($res->result_array() as $row) {
            if(strpos($menu,$row['PARENT'])!= false)
                $menu=str_replace(",".$row['PARENT'].",","",$menu);
        }
        $new=array();
        foreach ($dt as $k => $v) {
            $new=array(
              "ID_USER_ROLES"=>$v->ID_USER_ROLES,
                "MENU"=>$menu,
                "STATUS"=>$v->STATUS,
                "DESCRIPTION"=>$v->DESCRIPTION,
            );
        }
        echo json_encode($new);
    }

    public function change() {

    }

}
