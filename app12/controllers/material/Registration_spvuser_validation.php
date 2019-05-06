<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Registration_spvuser_validation extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('material/M_registration')->model('vendor/M_vendor');
        $this->load->helper(array('string', 'text'));
        $this->load->helper('helperx_helper');
    }


    public function index(){
      $tamp = $this->M_registration->show();
      $get_menu = $this->M_vendor->menu();
      $get_uom = $this->M_registration->material_uom();
      $get_mgroup = $this->M_registration->material_group();
      $get_mindicator = $this->M_registration->material_indicator();
      $get_mstockclass = $this->M_registration->m_material_stock_class();
      $get_mavailable = $this->M_registration->m_material_availability();
      $get_mcritical = $this->M_registration->m_material_cricatility();

      $data['total'] = count($tamp);
      $dt = array();
      $res_uom = array();
      $res_mgroup = array();
      $res_mindicator = array();
      $res_mstockclass = array();
      $res_mavailable = array();
      $res_mcritical = array();

      foreach ($get_mcritical as $arr) {
        $res_mcritical[] = array(
          'id' => $arr['ID'],
          'desc_in' => $arr['DESCRIPTION_IND'],
          'desc_en' => $arr['DESCRIPTION_ENG'],
        );
      }
      foreach ($get_mavailable as $arr) {
        $res_mavailable[] = array(
          'id' => $arr['ID'],
          'desc_in' => $arr['DESCRIPTION_IND'],
          'desc_en' => $arr['DESCRIPTION_ENG'],
        );
      }

      foreach ($get_mstockclass as $arr) {
        $res_mstockclass[] = array(
          'id' => $arr['ID'],
          'desc_in' => $arr['DESCRIPTION_IND'],
          'desc_en' => $arr['DESCRIPTION_ENG'],
        );
      }

      foreach ($get_mindicator as $arr) {
        $res_mindicator[] = array(
          'id' => $arr['ID'],
          'desc_in' => $arr['DESCRIPTION_IND'],
          'desc_en' => $arr['DESCRIPTION_ENG'],
        );
      }

      foreach ($get_mgroup as $arr) {
        $res_mgroup[] = array(
          'id' => $arr['ID'],
          'material_group' => $arr['MATERIAL_GROUP'],
          'type' => $arr['TYPE'],
        );
      }

      foreach ($get_uom as $arr) {
        $res_uom[] = array(
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

      $data['material_criticaly'] = $res_mcritical;
      $data['material_avalable'] = $res_mavailable;
      $data['material_stackclass'] = $res_mstockclass;
      $data['material_uom'] = $res_uom;
      $data['material_group'] = $res_mgroup;
      $data['material_indicator'] = $res_mindicator;
      $data['menu'] = $dt;
      $this->template->display('material/V_registration_spvuser_validation', $data);
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


    public function datatable_persetujuan_katalog() {
      $data = $this->M_registration->datatable_persetujuan_katalog();
      $result = array();
      $no = 1;

      foreach ($data as $arr) {
        if ($arr['STATUS'] == '2') {
          $str = '<center><button data-id="'.$arr['MATERIAL'].'" id="prosesreq" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-primary" title="Update"><i class=""> Proses</i></button> <button data-id="'.$arr['MATERIAL'].'" id="prosesreq" data-toggle="modal" data-target="#modal_rej" class="btn btn-sm btn-danger" title="Update"><i class=""> Reject</i></button></center>';
        } else {
          $str = '<center> - </center>';
        }

        $result[] = array(
          0 => '<center>'.$no.'</center>',
          1 => '<center>'.$arr['REQUEST_NO'].'</center>',
          2 => '<center>'.$arr['MATERIAL_NAME'].'</center>',
          3 => '<center>'.$arr['UOM1'].'</center>',
          4 => '<center><span class="badge badge badge-pill badge-success">'.$arr['DESCRIPTION_IND'].'</span></center>',
          5 => $str
        );
        $no++;
      }
      echo json_encode($result);
    }

    public function get_data_requestor(){
      $idnya = (!empty($_POST["idnya"])?$_POST["idnya"]:"");
      $data = $this->M_registration->get_data_requestor_user($idnya);
      $respon = array();
      foreach ($data as $arr) {
        $respon[] = array(
          'material' => $arr['MATERIAL'],
          'description' => $arr['DESCRIPTION'],
          'img1_url' => $arr['IMG1_URL'],
          'img2_url' => $arr['IMG2_URL'],
          'file_url' => $arr['FILE_URL'],
          'uom' => $arr['UOM'],
          'material_name' => $arr['MATERIAL_NAME'],
          'description1' => $arr['DESCRIPTION1'],
          'img3_url' => $arr['IMG3_URL'],
          'img4_url' => $arr['IMG4_URL'],
          'file_url2' => $arr['FILE_URL2'],
          'uom1' => $arr['UOM1'],
          'equipment_no' => $arr['EQPMENT_NO'],
          'equipment_id' => $arr['EQPMENT_ID'],
          'manufacturer' => $arr['MANUFACTURER'],
          'manufacturer_desc' => $arr['MANUFACTURER_DESCRIPTION'],
          'material_type' => $arr['MATERIAL_TYPE'],
          'material_type_desc' => $arr['MATERIAL_TYPE_DESCRIPTION'],
          'sequence_group' => $arr['SEQUENCE_GROUP'],
          'sequence_group_desc' => $arr['SEQUENCE_GROUP_DESCRIPTION'],
          'indicator' => $arr['INDICATOR'],
          'stock_class' => $arr['STOCK_CLASS'],
          'availability' => $arr['AVAILABILITY'],
          'criticality' => $arr['CRITICALITY'],
          'part_no' => $arr['PART_NO'],
          'eqp_id' => $arr['EQP_ID'],
          'material_grp' => $arr['MATERIAL_GROUP'],
          'eqp_desc' => $arr['EQPMENT_DESC'],
          'type' => $arr['TYPE'],
          'cat' => $arr['CATEGORY'],
          'indicator_id' => $arr['INDI_ID'],
          'indicator_desc' => $arr['INDI_DESC'],
          'name' => $arr['NAME'],
          'department_desc' => $arr['DEPARTMENT_DESC'],
        );
      }
      echo json_encode($respon, JSON_PRETTY_PRINT);
    }

    public function reject_request_catalog(){
      $idnya = (!empty($_POST['idnya'])?$_POST['idnya']:"");
      $note = (!empty($_POST['note'])?$_POST['note']:"");
      $save_data = array(
        'idnya' => $idnya,
        'note' => $note,
        'user' => $this->session->userdata['ID_USER'],
      );

      if ($note != "") {
        $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
        $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";

        $content = $this->M_registration->get_email_dest(21);
        $content[0]->ROLES = explode(",", $content[0]->ROLES);
        $res = $this->M_registration->get_user($content[0]->ROLES, count($content[0]->ROLES));
        $str = 'Catatan: '.$note.'<br>';

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
      }

      $result = $this->M_registration->reject_request_catalog($save_data);
      echo json_encode($save_data, JSON_PRETTY_PRINT);
    }

    public function approve_request_catalog(){
      $idnya = (!empty($_POST['idnya'])?$_POST['idnya']:"");
      $note = (!empty($_POST['note'])?$_POST['note']:"");
      $save_data = array(
        'idnya' => $idnya,
        'note' => $note,
        'user' => $this->session->userdata['ID_USER'],
      );

      $result = $this->M_registration->approve_request_catalog($save_data);
      if ($note != "") {
        $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
        $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";

        $content = $this->M_registration->get_email_dest(20);
        $content[0]->ROLES = explode(",", $content[0]->ROLES);
        $res = $this->M_registration->get_user($content[0]->ROLES, count($content[0]->ROLES));
        $str = $note;

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
      }

      echo json_encode($save_data, JSON_PRETTY_PRINT);
    }

}
