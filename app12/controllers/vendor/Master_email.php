<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Master_email extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('vendor/M_master_email')->model('vendor/M_vendor')->model('vendor/M_send_invitation');
        $this->load->model('vendor/m_all_intern', 'mai');
        $this->load->helper(array('string', 'text'));
    }

	public function index() {
		show_404();
		// $cek = $this->mai->cek_session();
		// //$temp = $this->M_master_email->show();
		// //$data['total'] = count($temp);
		// $get_menu = $this->M_vendor->menu();
		// $dt = array();
		// foreach ($get_menu as $k => $v) {
		// 	$dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
		// 	$dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
		// 	$dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
		// 	$dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
		// }
		// $data['menu'] = $dt;
		// $this->template->display('vendor/V_master_email_category', $data);
	}

	public function detail($idx = null) {
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
		if ($idx == null) {
			header("Location: index");
		} else {
			$data['get_id'] = $idx;
			$this->template->display('vendor/V_master_email', $data);
		}
	}

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function show($idx) {
        $data = $this->M_master_email->show($idx);
        $dt = array();
        //$base = base_url();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->TITLE);
            $dt[$k][2] = stripslashes($v->OPEN_VALUE);
            $dt[$k][3] = stripslashes($v->CLOSE_VALUE);
            $dt[$k][4] = "<a class='btn btn-primary btn-sm' title='Update' href='javascript:void(0)' onclick='email_temp(" . $v->ID . ")'><i class='fa fa-edit'></i></a>";
        }
        $this->output($dt);
    }

    public function show_email_temp($id) {
		// $id = 1;
        $list = $this->M_master_email->show_temp_email($id);
        $row = array();
        // $row["grubmenu"] = $list->GRUB_MENU;
        // $row["roles"] = $list->ROLES;
        $row["title"] = $list->TITLE;
        $row["open"] = $list->OPEN_VALUE;
        $row["close"] = $list->CLOSE_VALUE;
        $row["category"] = $list->CATEGORY;
        $row["id"] = $list->ID;
        echo json_encode($row);
    }

    public function add_email() {
        // $roles = null;
        // foreach ($_POST['roles'] as $k => $v) {
        //     $roles_tmp = $roles . "," . $v;
        //     $roles = $roles_tmp;
        // }
        // $roles = substr($roles, 1);

        $data_add = array(
            // 'GRUB_MENU' => $grubmenu,
            // 'ROLES' => $roles,
            'CATEGORY_ID' => $this->input->post('email_cat'),
            'TITLE' => $this->input->post('email_title'),
            'OPEN_VALUE' => $this->input->post('email_open'),
            'CLOSE_VALUE' => $this->input->post('email_close'),
            'CREATE_BY' => $this->session->userdata('ID_USER')
        );
        $ex = $this->M_master_email->add('m_notic', $data_add);
        if ($ex) {
            echo json_encode(array("status" => TRUE));
        } else {
            echo json_encode(array("status" => FALSE));
        }
    }

    public function update_email() {
        // $roles = null;
        // foreach ($_POST['roles'] as $k => $v) {
        //     $roles_tmp = $roles . "," . $v;
        //     $roles = $roles_tmp;
        // }
        // $roles = substr($roles, 1);

        $id = $this->input->post('id_email');
        $data_update = array(
            // 'GRUB_MENU' => $grubmenu,
            // 'ROLES' => $roles,
            'TITLE' => $this->input->post('email_title'),
            'OPEN_VALUE' => $this->input->post('email_open'),
            'CLOSE_VALUE' => $this->input->post('email_close'),
            'UPDATE_BY' => $this->session->userdata('ID_USER')
        );
        $ex = $this->M_master_email->update('ID', 'm_notic', $id, $data_update);
        if ($ex) {
            echo json_encode(array("status" => TRUE));
        } else {
            echo json_encode(array("status" => FALSE));
        }
    }

	public function show_email_category() {
		show_404();
		// $data = $this->M_master_email->show_email_category();
		// $result = array();
		// $no = 1;

		// foreach ($data as $arr) {
		// 	$result[] = array(
		// 		0 => '<center>'.$no.'</center>',
		// 		1 => '<center>'.$arr['description'].'</center>',
		// 		2 => '<center>'.$arr['create_date'].' </center>',
		// 		3 => "<center><a href='".base_url('vendor/Master_email/detail/').$arr['id']."' class='btn btn-info btn-sm' title='Detail'> Detail</a>",
		// 	);
		// 	$no++;
		// }
		// echo json_encode($result);
	}

	public function supplier() {
		$cek = $this->mai->cek_session();
		//$temp = $this->M_master_email->show();
		//$data['total'] = count($temp);
		$get_menu = $this->M_vendor->menu();
		$acc = $this->M_master_email->menu_access(uri_string())->ID_MENU;
		$right = false;
		$dt = array();
		foreach ($get_menu as $k => $v) {
			if ($acc == $v->ID_MENU)
				$right = true;
			$dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
			$dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
			$dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
			$dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
		}
		if ($right) {
			$data['menu'] = $dt;
			$data['get_id'] = 1;
			$data['header_title'] = lang("Master Email Penyedia", "Supplier Email Master");
			$data['breadcrumb_title'] = lang("Master Email Penyedia", "Supplier Email Master");
			$this->template->display('vendor/V_master_email', $data);
		} else {
			show_404();
		}
	}

	public function logistic() {
		$cek = $this->mai->cek_session();
		//$temp = $this->M_master_email->show();
		//$data['total'] = count($temp);
		$get_menu = $this->M_vendor->menu();
		$acc = $this->M_master_email->menu_access(uri_string())->ID_MENU;
		$right = false;
		$dt = array();
		foreach ($get_menu as $k => $v) {
			if ($acc == $v->ID_MENU)
				$right = true;
			$dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
			$dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
			$dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
			$dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
		}
		if ($right) {
			$data['menu'] = $dt;
			$data['get_id'] = 2;
			$data['header_title'] = lang("Master Email Logitik", "Logistic Email Master");
			$data['breadcrumb_title'] = lang("Master Email Logitik", "Logistic Email Master");
			$this->template->display('vendor/V_master_email', $data);
		} else {
			show_404();
		}
	}

	public function procurement() {
		$cek = $this->mai->cek_session();
		//$temp = $this->M_master_email->show();
		//$data['total'] = count($temp);
		$get_menu = $this->M_vendor->menu();
		$acc = $this->M_master_email->menu_access(uri_string())->ID_MENU;
		$right = false;
		$dt = array();
		foreach ($get_menu as $k => $v) {
			if ($acc == $v->ID_MENU)
				$right = true;
			$dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
			$dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
			$dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
			$dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
		}
		if ($right) {
			$data['menu'] = $dt;
			$data['get_id'] = 3;
			$data['header_title'] = lang("Master Email Pengadaan", "Procurement Email Master");
			$data['breadcrumb_title'] = lang("Master Email Pengadaan", "Procurement Email Master");
			$this->template->display('vendor/V_master_email', $data);
		} else {
			show_404();
		}
	}
}
