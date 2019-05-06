<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Registration extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('material/M_registration')->model('vendor/M_vendor');
        $this->load->model('material/M_registration');
        $this->load->helper(array('string', 'text'));
        $this->load->helper('helperx_helper');
    }

    public function index() {
        $tamp = $this->M_registration->show();
        $get_menu = $this->M_vendor->menu();

        $data['total'] = count($tamp);
        $dt = array();

        $result = array();
        $datax = $this->M_registration->material_uom();
        foreach ($datax as $arr) {
          $result[] = array(
            'id' => $arr['ID'],
            'material_uom' => $arr['MATERIAL_UOM'],
          );
        }

        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['material_uom'] = $result;
        $data['menu'] = $dt;
        $this->template->display('material/V_registration', $data);
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }


    // --------------------------------------- sendmail  --------------------------------------------
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

        if (count($content['dest']) != 0 && !isset($content['email'])) {
            foreach ($content['dest'] as $k => $v) {
                $this->load->library('email', $config);
                $this->email->initialize($config);
                $this->email->from($mail['email'], '[SYSTEM] EPROC SUPREME ENERGY');
                $this->email->subject($content['title']);
                $ctn = ' <p>' . $content['img1'] . '<p>
                        <br>' . $content['open'] . '
                        <br>
                        ' . $content['close'] . '
                        <br>

                        ';
                //$this->email->message();
                //$this->email->to($v);

                $data_email['recipient'] = $v;
        $data_email['subject'] = $content['title'];
        $data_email['content'] = $ctn;
        $data_email['ismailed'] = 0;

                if ($this->db->insert('i_notification',$data_email)) {
                    $flag = 1;
                } else {
                    $flag = 0;
                }
            }
        }
        else
        {
            $this->load->library('email', $config);
                $this->email->initialize($config);
                $this->email->from($mail['email'], '[SYSTEM] EPROC SUPREME ENERGY');
                $this->email->subject($content['title']);
                $ctn = ' <p>' . $content['img1'] . '<p>
                        <br>' . $content['open'] . '
                        <br>
                        ' . $content['close'] . '
                        <br>

                        ';
                //$this->email->message();
                //$this->email->to($content['email']);

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
        if ($flag == 1)
            return true;
        else
            return false;
    }
    // -----------------------------------------------------------------------------------

    public function filter_data() {
        $res = $this->M_registration->filter_data($_POST);
        $dt = array();
        foreach ($res as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->MATERIAL);
            $dt[$k][2] = stripslashes($v->DESCRIPTION);
            $dt[$k][3] = stripslashes(word_limiter($v->LONG_DESCRIPTION, 2));
            $dt[$k][4] = stripslashes($v->MATERIAL_GROUP);
            $dt[$k][5] = stripslashes($v->MATERIAL_TYPE);
            $dt[$k][6] = stripslashes($v->MATERIAL_UOM);
            if ($v->STATUS == 1) {
                $dt[$k][7] = "Active";
            } else {
                $dt[$k][7] = "Nonactive";
            }
            $dt[$k][8] = "<a class='btn btn-info btn-sm' title='Update' href='javascript:void(0)' onclick='update(" . $v->ID . ")'><i class='fa fa-edit'></i></a>";
        }
        $this->output($dt);
    }

    public function show() {
        $data = $this->M_registration->show();
        $dt = array();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->DESCRIPTION);
            $dt[$k][2] = stripslashes(word_limiter($v->LONG_DESCRIPTION, 2));
            $dt[$k][3] = stripslashes($v->MATERIAL_GROUP);
            $dt[$k][4] = stripslashes($v->MATERIAL_TYPE);
            $dt[$k][5] = stripslashes($v->MATERIAL_UOM);
            if ($v->STATUS == 1) {
                $dt[$k][6] = "Active";
            } else {
                $dt[$k][6] = "Nonactive";
            }
            $dt[$k][7] = "<a class='btn btn-info btn-sm' title='Update' href='javascript:void(0)' onclick='update(" . $v->ID . ")'><i class='fa fa-edit'></i></a>";
        }
        echo json_encode($dt);
    }

    public function get($id) {
        echo json_encode($this->M_registration->show(array("ID" => $id)));
    }

    public function change() {
//        strtoupper($string)
        $data = array(
            'MATERIAL' => strtoupper(stripslashes($_POST['mat_material'])),
            'DESCRIPTION' => stripslashes($_POST['desc']),
            'LONG_DESCRIPTION' => stripslashes(($_POST['open_edit'])),
            'MATERAIL_GROUP' => stripslashes($_POST['group_material']),
            'MATERAIL_TYPE' => strtoupper(stripslashes($_POST['material_type'])),
            'MATERAIL_UOM' => stripslashes($_POST['material_uom']),
            'STATUS' => $_POST['status'],
            'UPDATE_BY' => 1,
            'UPDATE_TIME' => date('Y-m-d H:i:s')
        );
        if ($_POST['id'] == null) {//add data
            $data['CREATE_BY'] = 1;
            $cek = $this->M_registration->show(array("MATERIAL" => strtoupper(stripslashes($_POST['mat_material']))));
            if (count($cek) == 0) {//cek ketersediaan data
                $q = $this->M_registration->add($data);
            } else {
                echo "Tipe Materaial Telah Digunakan";
                exit;
            }
        } else {//update data
            $q = $this->M_registration->update($_POST['id'], $data);
        }

        //CEK QUERY BERHASIL DIJALANKAN
        if ($q == 1) {
            echo "sukses";
        } else {
            echo "Gagal Menambah Data!";
        }
    }

    public function save_material_requestor(){
      $material_id = (!empty($_POST['material_id'])?$_POST['material_id']:"");
      $m_desc = (!empty($_POST['m_desc'])?$_POST['m_desc']:"");
      $m_uom = (!empty($_POST['m_uom'])?$_POST['m_uom']:"");
      $material_image = ($_FILES["material_image"]["name"] != "" ? $_FILES["material_image"] : "");
      $material_drawing = ($_FILES["material_drawing"]["name"] != "" ? $_FILES["material_drawing"] : "");
      $material_other = ($_FILES["material_other"]["name"] != "" ? $_FILES["material_other"] : "");

      $respon = array();
      $simpan_data = array(
        "MATERIAL" => $material_id,
        "DESCRIPTION" => $m_desc,
        "UOM" => $m_uom,
        "IMG1_URL" => $material_image,
        "IMG2_URL" => $material_drawing,
        "FILE_URL" => $material_other,
        "CREATE_BY" => $this->session->userdata['ID_USER'],
        "CREATE_TIME" => date("Y-m-d H:i:s"),
      );

      $result = $this->M_registration->save_material_requestor($simpan_data);

      if ($result == true) {

        $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
        $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";

        $content = $this->M_registration->get_email_dest(16);
        $content[0]->ROLES = explode(",", $content[0]->ROLES);
        $res = $this->M_registration->get_user($content[0]->ROLES, count($content[0]->ROLES));
        $str = 'Deskripsi Material: '.$m_desc.'<br>
                UOM:'.$m_uom.'<br>';
        $data = array(
            'img1' => $img1,
            'img2' => $img2,
            'title' => $content[0]->TITLE,
            'open' => str_replace("deskripsinya", $str, $content[0]->OPEN_VALUE),
            'close' => $content[0]->CLOSE_VALUE
        );
        foreach ($res as $k => $v) {
            $data['dest'][] = $v->EMAIL;
        }
        $flag = $this->sendMail($data);

        $respon[] = array(
          'success' => true,
          'data' => $simpan_data
        );
      } else {
        $respon = array(
          'success' => false,
        );
      }

      echo json_encode($respon, JSON_PRETTY_PRINT);
    }

    public function datatable_regsitrasi_material() {
      $data = $this->M_registration->datatable_regsitrasi_m();
      $result = array();
      $no = 1;

      foreach ($data as $arr) {
        if ($arr['STATUS'] == '11') {
          $str = '<button data-id="'.$arr['MATERIAL'].'" id="prosesreq" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-primary" title="Update"><i class=""> Proeses Lagi</i></button>';
          $disabled = "disabled";
          $class = 'danger';
        } else {
          $str = "";
          $disabled = "";
          $class = 'success';
        }

        $aksi = '<center><button data-toggle="modal" data-target="#myModal" data-id="'.$arr['MATERIAL'].'" class="btn btn-info btn-sm" title="Update"><i class="fa fa-edit"></i></button> <button class="btn btn-success btn-sm" data-id="'.$arr['MATERIAL'].'" title="History"><i class="fa fa-clock-o"></i></button> <button type="button" class="btn btn-danger btn-sm" data-id="'.$arr['MATERIAL'].'" id="delete" title="Delete"><i class="fa fa-trash"></i></button></center>';

        $aksi2 = '<center><button data-toggle="modal" data-target="#myModal" data-id="'.$arr['MATERIAL'].'" class="btn btn-info btn-sm" title="Update"><i class="fa fa-edit"></i></button> <button type="button" class="btn btn-danger btn-sm" data-id="'.$arr['MATERIAL'].'" id="delete" title="Delete"><i class="fa fa-trash"></i></button></center>';

        $result[] = array(
          0 => '<center>'.$no.'</center>',
          1 => '<center>'.$arr['REQUEST_NO'].'</center>',
          2 => '<center>'.$arr['DESCRIPTION'].'</center>',
          3 => '<center>'.$arr['UOM'].'</center>',
          4 => '<center><span class="badge badge badge-pill badge-'.$class.'">'.$arr['DESCRIPTION_IND'].'</span></center>',
          5 => $aksi2
        );
        $no++;
      }
      echo json_encode($result);
    }

    public function delete_material(){
      $idnya = $this->input->post('idnya');
      $this->M_registration->delete_material($idnya);

      echo json_encode($idnya);
    }

}
