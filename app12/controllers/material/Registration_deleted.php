<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Registration_deleted extends CI_Controller {


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
          $this->template->display('material/V_registration_deleted', $data);
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

      public function datatable_regsitrasi_material() {
        $data = $this->M_registration->datatable_regsitrasi__deleted();
        $result = array();
        $no = 1;

        foreach ($data as $arr) {
          if ($arr['STATUS'] == '11') {
            $str = '<button data-id="'.$arr['MATERIAL'].'" id="prosesreq" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-primary" title="Update"><i class=""> Proeses Lagi</i></button>';
            $disabled = "disabled";
            $class = 'danger';
            $aksi2 = '<center><button data-toggle="modal" data-target="#myModal" data-id="'.$arr['MATERIAL'].'" class="btn btn-info btn-sm" title="Info"><i class="fa fa-info-circle"></i></button></center>';
          } else {
            $str = "";
            $disabled = "";
            $class = 'danger';
            $aksi2 = '<center><button data-toggle="modal" data-target="#myModal" data-id="'.$arr['MATERIAL'].'" class="btn btn-info btn-sm" title="Info"><i class="fa fa-info-circle"></i></button> <button type="button" class="btn btn-warning btn-sm" data-id="'.$arr['MATERIAL'].'" id="restore" title="Restore"><i class="fa fa-undo"></i></button></center>';
          }

          $aksi = '<center><button data-toggle="modal" data-target="#myModal" data-id="'.$arr['MATERIAL'].'" class="btn btn-info btn-sm" title="Update"><i class="fa fa-edit"></i></button> <button class="btn btn-success btn-sm" data-id="'.$arr['MATERIAL'].'" title="History"><i class="fa fa-clock-o"></i></button> <button type="button" class="btn btn-danger btn-sm" data-id="'.$arr['MATERIAL'].'" id="delete" title="Delete"><i class="fa fa-trash"></i></button></center>';

          $result[] = array(
            0 => '<center>'.$no.'</center>',
            1 => '<center>'.$arr['DESCRIPTION'].'</center>',
            2 => '<center>'.$arr['UOM'].'</center>',
            3 => '<center><span class="badge badge badge-pill badge-'.$class.'">'.$arr['DESCRIPTION_IND'].'</span></center>',
            4 => $aksi2
          );
          $no++;
        }
        echo json_encode($result);
      }

      public function restore_material(){
        $idnya = $this->input->post('idnya');
        $this->M_registration->restore_material($idnya);

        echo json_encode($idnya);
      }

  }
