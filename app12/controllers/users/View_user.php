<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class View_user extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user/M_view_user')->model('vendor/M_vendor');
        $this->load->helper('helperx_helper');
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
        $this->template->display('user/V_view_user', $data);
    }


    protected function sendMail($content) {
         $mail = get_mail();
         $config = array();
         $config['protocol'] = $mail['protocol'];
        $config['smtp_crypto'] = $mail['crypto'];
        if($mail['protocol'] == 'smtp'){
            $config['smtp_pass'] = $mail['password'];
        }

        //$config['protocol'] = 'mail';
        //$config['smtp_crypto'] = '';

        $config['crlf'] = "\r\n";
        $config['mailtype'] = 'html';
        $config['smtp_host'] = $mail['smtp'];
        $config['smtp_port'] = $mail['port'];
        $config['smtp_user'] = $mail['email'];
        $config['charset'] = "utf-8";
        $config['newline'] = "\r\n";

         $this->load->library('email', $config);
         $this->email->initialize($config);
         $this->email->from($mail['email'], '[SYSTEM] EPROC SUPREME ENERGY');
         $this->email->to($content['email']);
         $this->email->subject($content['title']);
         //$this->email->isHTML(true);

         $ctn=' <p>' . $content['img1'] . '<p>
                         <p>' . $content['open'] . '<p>
                         <br/>
                         <table>
                             <tr>
                                 <td>Username</td>
                                 <td>: ' . $content['nama'] . '</td>
                             </tr>
                             <tr>
                                 <td>Password</td>
                                 <td>: ' . $content['pass'] . '</td>
                             </tr>
                             <tr>
                                 <td>Link</td>
                                 <td>:  ' . $content['link'] . '</td>
                             </tr>
                         </table>
                         <br/>
                         <br/>
                         '. $content['close'] .'
                         ';
         $data_email['recipient'] = $content['email'];
        $data_email['subject'] = $content['title'];
        $data_email['content'] = $ctn;
        $data_email['ismailed'] = 0;
                if ($this->db->insert('i_notification',$data_email)) {
                     return true;
                } else {
                    return false;
                }
     }

    public function show() {
        $where = '';
        $data = $this->M_view_user->show($where);
        $dt = array();
        foreach ($data as $k => $v) {
          $id_comp = explode(",", $v->COMPANY);
          foreach ($id_comp as $key) {
            $query = $this->db->query("SELECT * FROM m_company WHERE ID_COMPANY = '".$key."'");
            foreach ($query->result() as $arr) {
              $dt[$k][4][] = '<li>'.$arr->DESCRIPTION.'</li>';
            }
          }
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->NAME);
            $dt[$k][2] = stripslashes($v->USERNAME);
            $dt[$k][3] = stripslashes($v->EMAIL);
            $dt[$k][5] = stripslashes($v->CONTACT);
            if (stripslashes($v->STATUS) == 1) {
                $status = 'Yes';
            } else {
                $status = 'No';
            }
            $dt[$k][6] = stripslashes($status);
            $dt[$k][7] = "<a class='btn btn-primary btn-sm' title='Update' href='javascript:void(0)' onclick='update(" . $v->ID_USER . ")'><i class='fa fa-edit'></i></a>&nbsp"
                    . "<a class='btn btn-warning btn-sm' title='Reset Password' href='javascript:void(0)' onclick='update_password(" . $v->ID_USER . "," . $password = rand(1000, 9999) . ")'><i class='fa fa-gears'></i></a>&nbsp"
                    . "<a class='btn btn-danger btn-sm' title='Hapus User' href='javascript:void(0)' onclick='user_delete(" . $v->ID_USER . ",\"" . $v->NAME . "\")'><i class='fa fa-trash'></i></a>";
        }
        echo json_encode($dt);
    }

    public function get($id) {
        echo json_encode($this->M_view_user->show(array("ID_USER" => $id)));
    }

    public function change() {
        $company = null;
        foreach ($_POST['company'] as $k => $v) {
            $company_tmp = $company . "," . $v;
            $company = $company_tmp;
        }
        $company = substr($company, 1);

        $departement = null;
        foreach ($_POST['departement'] as $k => $v) {
            $departement_tmp = $departement . "," . $v;
            $departement = $departement_tmp;
        }
        $departement = substr($departement, 1);

        $roles = null;
        foreach ($_POST['roles'] as $k => $v) {
            $roles_tmp = $roles . "," . $v;
            $roles = $roles_tmp;
        }
        $roles = $roles.",";
        $encript_password = stripslashes(str_replace('/','_',crypt($_POST['password'], mykeyencrypt)));
        if(empty($_POST['id_external'])||empty($_POST['is_external'])){
			if(empty($_POST['id_external'])&&empty($_POST['is_external'])){
				$data = array(
					'NAME' => ucfirst(stripslashes($_POST['name'])),
					'USERNAME' => stripslashes($_POST['username']),
					'PASSWORD' => $encript_password,
					'EMAIL' => stripslashes($_POST['email']),
					'COMPANY' => $company,
					'ID_DEPARTMENT' => $departement,
					'COST_CENTER' => stripslashes($_POST['cost_center']),
					'CONTACT' => stripslashes($_POST['contact']),
					'ROLES' => $roles,
					'STATUS' => 1,
					'UPDATE_BY' => $this->session->userdata['ID_USER'],
					'UPDATE_TIME' => date('Y-m-d H:i:s'),
				);
			}else if(empty($_POST['id_external'])){
				$data = array(
					'NAME' => ucfirst(stripslashes($_POST['name'])),
					'USERNAME' => stripslashes($_POST['username']),
					'PASSWORD' => $encript_password,
					'EMAIL' => stripslashes($_POST['email']),
					'COMPANY' => $company,
					'ID_DEPARTMENT' => $departement,
					'COST_CENTER' => stripslashes($_POST['cost_center']),
					'CONTACT' => stripslashes($_POST['contact']),
					'ROLES' => $roles,
					'STATUS' => 1,
					'UPDATE_BY' => $this->session->userdata['ID_USER'],
					'UPDATE_TIME' => date('Y-m-d H:i:s'),
					'is_external' => $_POST['is_external'],
					
				);
			}else if(empty($_POST['is_external'])){
				$data = array(
					'NAME' => ucfirst(stripslashes($_POST['name'])),
					'USERNAME' => stripslashes($_POST['username']),
					'PASSWORD' => $encript_password,
					'EMAIL' => stripslashes($_POST['email']),
					'COMPANY' => $company,
					'ID_DEPARTMENT' => $departement,
					'COST_CENTER' => stripslashes($_POST['cost_center']),
					'CONTACT' => stripslashes($_POST['contact']),
					'ROLES' => $roles,
					'STATUS' => 1,
					'UPDATE_BY' => $this->session->userdata['ID_USER'],
					'UPDATE_TIME' => date('Y-m-d H:i:s'),
					'id_external' => $_POST['id_external'],
				);
			}
		}else{
			$data = array(
				'NAME' => ucfirst(stripslashes($_POST['name'])),
				'USERNAME' => stripslashes($_POST['username']),
				'PASSWORD' => $encript_password,
				'EMAIL' => stripslashes($_POST['email']),
				'COMPANY' => $company,
				'ID_DEPARTMENT' => $departement,
				'COST_CENTER' => stripslashes($_POST['cost_center']),
				'CONTACT' => stripslashes($_POST['contact']),
				'ROLES' => $roles,
				'STATUS' => 1,
				'UPDATE_BY' => $this->session->userdata['ID_USER'],
				'UPDATE_TIME' => date('Y-m-d H:i:s'),
				'id_external' => $_POST['id_external'],
				'is_external' => $_POST['is_external'],
			);
		}

        if ($_POST['id'] == null) {//add data
            $data['CREATE_BY'] = 1;
            $cek = $this->M_view_user->show(array("USERNAME" => ucfirst(stripslashes($_POST['username']))));
            if (count($cek) == 0) {//cek ketersediaan data
                $q = $this->M_view_user->add($data);
            } else {
                echo "Tipe Username Telah Digunakan";
                exit;
            }
        } else {//update data
            $img_profile = ($_FILES["img_profile"]["name"] != "" ? $_FILES["img_profile"] : "");
            if (!empty($img_profile)) {
              $img1 = image_upload(
                     $_FILES["img_profile"]["tmp_name"],
                     $_FILES["img_profile"]["name"],
                     $_FILES["img_profile"]["type"],
                     $_FILES["img_profile"]["size"],
                     "upload/",
                     "upload/");
              $data['IMG'] = $img1;
            }
            $q = $this->M_view_user->update($_POST['id'], $data);
        }

        //CEK QUERY BERHASIL DIJALANKAN
        if ($q == 1) {
          // $user = $this->M_view_user->get_user($_POST['id_user']);
          $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
          $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";
          $url = "<a href='http:" . base_url() . "in/'>Login Link</a>";
          $content = $this->M_view_user->show_temp_email(17);
          $data = array(
              'email' => stripslashes($_POST['email']),
              'img1' => $img1,
              'img2' => $img2,
              'nama' => stripslashes($_POST['username']),
              'pass' => stripslashes($_POST['password']),
              'link' => $url,
              'title' => "Informasi User Eproc Supreme Energy",
              'open' => $content->OPEN_VALUE,
              'close' => $content->CLOSE_VALUE
          );
          $this->sendMail($data);
            echo "sukses";
        } else {
            echo "Gagal Menambah Data!";
        }
    }

    /*
      0=>terhapus
      1=>aktif
      2=>non-aktif
     */




    public function reset_password() {
        $encript_password = stripslashes(str_replace('/','_',crypt($_POST['password'], mykeyencrypt)));
        $data = array(
            'PASSWORD' => $encript_password,
            'STATUS' => 1,
            'UPDATE_BY'=>$this->session->ID_USER,
            'UPDATE_TIME'=>date('Y-m-d H:i:s')
        );
        $q = $this->M_view_user->update($_POST['id_user'], $data);

        //CEK QUERY BERHASIL DIJALANKAN
        if ($q == 1) {
            $user=$this->M_view_user->get_user($_POST['id_user']);
            $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
            $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";
            $url = "<a href='http:" . base_url() . "in/'>Login Link</a>";
            $content = $this->M_view_user->show_temp_email(17);
            $data = array(
                'email' => $user[0]->EMAIL,
                'img1' => $img1,
                'img2' => $img2,
                'nama' => $user[0]->USERNAME,
                'pass' => $_POST['password'],
                'link' => $url,
                'title' => $content->TITLE,
                'open' => $content->OPEN_VALUE,
                'close' => $content->CLOSE_VALUE
            );
            if ($this->sendMail($data)){
              echo "sukses";
            } else{
              echo "Gagal Merubah Password!";
            }
        } else {
            echo "Gagal Merubah Password!";
        }
    }

    public function delete() {
        $data = array(
            'STATUS' => 0
        );
        $q = $this->M_view_user->update($_POST['id_user'], $data);

        if ($q == 1) {
            echo "sukses";
        } else {
            echo "Gagal Menambah Data!";
        }
    }

    public function get_departement(){
      $id_comp = $this->input->post('id_comp');
      $result = array();
      if ($id_comp != null) {

        foreach ($id_comp as $arr) {
          $q = $this->M_view_user->get_departement($arr);
          foreach ($q as $value) {
            echo '<option value="'.$value['ID_DEPARTMENT'].'">'.$value['ID_DEPARTMENT'].' - '.$value['DEPARTMENT_DESC'].'</option>';
          }
        }
      }
      // echo json_encode($result);
    }

    public function get_costcenter(){
      $id_comp = $this->input->post('id_comp');
      $result = array();
      if ($id_comp != null) {

        foreach ($id_comp as $arr) {
          $q = $this->M_view_user->get_costcenter($arr);
          foreach ($q as $value) {
            echo '<option value="'.$value['ID_COSTCENTER'].'">'.$value['ID_COSTCENTER'].' - '.$value['COSTCENTER_DESC'].'</option>';
          }
        }
      }
      // echo json_encode($result);
    }

}
