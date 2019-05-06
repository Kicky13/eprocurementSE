<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Organizational_structure extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('setting/M_organizational_structure')->model('vendor/M_vendor')->model('user/M_view_user');
        $this->load->helper(array('string', 'text'));
        $this->load->helper('helperx_helper');
    }

    public function index() {
        $get_menu = $this->M_vendor->menu();
        $get_user = $this->M_view_user->show();
        $get_pos = $this->M_organizational_structure->show_job('m_job_position', 'id ASC', array('status' => 1));
        $get_title = $this->M_organizational_structure->show_job('m_job_title', 'id ASC', array('status' => 1));

        $dt_menu = array();
        $dt_user = array();

        foreach ($get_menu as $k => $v) {
            $dt_menu[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt_menu[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt_menu[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt_menu[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }

        $data['user'] = $get_user;
        $data['menu'] = $dt_menu;
        $data['pos'] = $get_pos;
        $data['title'] = $get_title;
        $this->template->display('setting/V_organizational_structure', $data);
    }

    public function show() {
        $data = $this->M_organizational_structure->show();
        $total = count($data);
        $result = array();
        $no = 1;

        foreach ($data as $arr) {
            $parent_name = '';
            foreach ($data as $parent) {
                if ($arr['parent_id'] == $parent['id']) {
                    $parent_name = $parent['NAME'];
                    break;
                }
            }
            $result[] = array(
                0 => '<center>'.$no.'</center>',
                1 => '<center>'.$arr['NAME'].'</center>',
                2 => '<center>'.$arr['position'].'</center>',
                3 => '<center>'.$arr['title'].'</center>',
                4 => '<center>'.($arr['parent_id'] == 0 ? 'None' : $parent_name).'</center>',
                5 => "<center><button class='btn btn-primary btn-sm' title='Update' href='javascript:void(0)' onclick=\"update('" . $arr['id'] . "')\"><i class='fa fa-edit'></i></button>",
                );
            $no++;
        }
        echo json_encode($result);
    }

    public function get($id) {
        $result = $this->M_organizational_structure->show($id);
        if ($result) {
            $result = $result[0];
            $temp = $this->M_organizational_structure->show_supervisor('user_id != ' . $result['user_id']);
            $spv_list = array();
            array_push($spv_list , array('id' => 0, 'text' => 'None'));
            foreach ($temp as $value) {
                array_push($spv_list , array('id' => $value['user_id'], 'text' => $value['NAME']));
            }
            if ($result['parent_id'] != 0) {
                $parent = $this->M_organizational_structure->show($result['parent_id']);
                $result['parent_id'] = $parent[0]['user_id'];
            }
            $result['spv_list'] = $spv_list;
            echo json_encode($result);
        } else {
            echo json_encode($result);
        }
    }

    public function get_supervisor($id) {
        $temp = $this->M_organizational_structure->show_supervisor('user_id != ' . $id);
        $result = array();
        array_push($result, array('id' => '0', 'text' => 'None'));
        foreach ($temp as $value) {
            array_push($result, array('id' => $value['user_id'], 'text' => $value['NAME']));
        }
        echo json_encode($result);
    }

    public function process() {
        if ($this->input->post('global_approval') == 1)
            $app = $this->M_organizational_structure->get_global_approval();
        else
            $app = array();

        if (count($app) > 0) {
            echo "Global Approval already assigned to " . $app[0]['position'] . " - " . $app[0]['NAME'] . "!";
        } else {
            $supervisor = 0;
            if ($this->input->post('supervisor') != 0) {
                $parent = $this->M_organizational_structure->show_supervisor('user_id = ' . $this->input->post('supervisor'));
                $supervisor = $parent[0]['id'];
            }

            $data = array(
                'position' => $this->input->post('position'),
                'title' => $this->input->post('title'),
                'user_role' => $this->input->post('role'),
                'parent_id' => $supervisor,
                'user_id' => $this->input->post('name'),
                'nominal' => $this->input->post('nominal'),
                'operand' => $this->input->post('operand'),
                'nominal_writeoff' => $this->input->post('writeoff'),
                'nominal_intercompany' => $this->input->post('intercompany'),
                'first' => $this->input->post('global_approval'),
            );

            if ($this->input->post('id') == null) {
                $cek = $this->M_organizational_structure->check(array(
                    'user_id' => $data['user_id'],
                    'position' => $data['position'],
                    'title' => $data['title']
                ));
                if (count($cek) == 0) {
                    $q = $this->M_organizational_structure->add($data);
                } else {
                    echo "Combination of Name, Position, and Title already exist!";
                    exit();
                }
            } else {
                $cek = $this->M_organizational_structure->check(array(
                    'user_id' => $data['user_id'],
                    'position' => $data['position'],
                    'title' => $data['title'],
                    'id != ' => $this->input->post('id')
                ));
                if (count($cek) == 0) {
                    $q = $this->M_organizational_structure->update($this->input->post('id'), $data);
                } else {
                    echo "Combination of Name, Position, and Title already exist!";
                    exit();
                }
            }

            if ($q == 1) {
                echo "Success!";
            } else {
                echo "Failed to process data!";
            }
        }
    }
}
