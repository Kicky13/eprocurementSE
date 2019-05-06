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
        foreach ($data as $x => $v) {
            $dt[$v->PARENT][$v->ID_MENU] = $v;
        }

        $n = 0;
        $dt1 = array();
        foreach ($dt[0] as $k => $v) {
            $dt1[$n][0] = $n + 1;
            $dt1[$n][1] = "<i class='fa " . $v->ICON . "'></i> " . stripslashes($v->DESKRIPSI_IND);
            $dt1[$n][2] = $v->URL;
            $btn_up = "<button class='disabled btn btn-primary btn-sm' title='Up' href='javascript:void(0)' onclick=\"sort('up', " . $v->ID_MENU . ", " . $v->SORT . ")\" disabled><i class='fa fa-arrow-up'></i></button>";
            $btn_dw = "<button class='disabled btn btn-primary btn-sm' title='down' href='javascript:void(0)' onclick=\"sort('down', " . $v->ID_MENU . ", " . $v->SORT . ")\" disabled><i class='fa fa-arrow-down'></i></button>";
            $btn_edit = "<button class='btn btn-info btn-sm' title='Update' href='javascript:void(0)' onclick='edit(" . $v->ID_MENU . ")'><i class='fa fa-edit'></i></button>";
            $dt1[$n][3] = "$btn_edit";
            $n++;

            $query = $this->db->query("SELECT * FROM m_menu WHERE PARENT != '0' AND PARENT = '".$v->ID_MENU."'");
            $row = $query->result();
            foreach ($row as $kk => $vv) {
                  $dt1[$n][0] = $n + 1;
                  $dt1[$n][1] = "&nbsp&nbsp&nbsp&nbsp<i class='fa fa-angle-double-right'></i> " . stripslashes($vv->DESKRIPSI_IND);
                  $dt1[$n][2] = $vv->URL;
                  $btn_up = "<a class='btn btn-primary btn-sm' title='Up' href='javascript:void(0)' onclick=\"sort('up', " . $vv->ID_MENU . ", " . $v->SORT . ")\"><i class='fa fa-arrow-up'></i></a>";
                  $btn_dw = "<a class='btn btn-primary btn-sm' title='down' href='javascript:void(0)' onclick=\"sort('down', " . $vv->ID_MENU . ", " . $v->SORT . ")\")'><i class='fa fa-arrow-down'></i></a>";
                  $btn_edit = "<a class='btn btn-info btn-sm' title='Update' href='javascript:void(0)' onclick='edit(" . $vv->ID_MENU . ")'><i class='fa fa-edit'></i></a>";
                  $dt1[$n][3] = "$btn_up $btn_dw $btn_edit";
                  $n++;
            }
        }
        echo json_encode($dt1, JSON_PRETTY_PRINT);
    }

    public function add() {
        $idmenu = stripslashes($this->input->post('idmenu'));
        $desc_ind = stripslashes($this->input->post('desc_ind'));
        $desc_eng = stripslashes($this->input->post('desc_eng'));
        $icon = stripslashes($this->input->post('icon'));

        $data = array(
          'DESKRIPSI_ENG' => $desc_eng,
          'DESKRIPSI_IND' => $desc_ind,
          'ICON' => $icon,
        );

        if ($idmenu != "") {
          $query = $this->M_config_menu->update_menu($data, $idmenu);
          $result['success'] = true;
        } else {
          $result['success'] = false;
        }
        echo json_encode($result);
    }

    public function get($id) {
        echo json_encode($this->M_config_menu->show2(array("ID_MENU" => $id)));
    }

    public function sort($id, $data) {
      $query = $this->db->query("SELECT * FROM m_menu WHERE ID_MENU = '".$id."'");
      $sort = $query->row()->SORT;
      $idmenu = $query->row()->ID_MENU;
      // $result = array();
      if ($data == "up") {
        $result['SORT'] = $sort-1;
        $this->M_config_menu->update_menu($result, $idmenu);
      } elseif ($data == "down") {
        $result['SORT'] = $sort+1;
        $this->M_config_menu->update_menu($result, $idmenu);
      } else {
        $result['SORT'] = $sort+1;
      }

      echo json_encode($result);
    }

}
