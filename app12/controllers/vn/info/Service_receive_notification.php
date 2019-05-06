<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Service_receive_notification extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('vn/info/M_service_receive_notification');
        $this->load->model('vn/info/M_vn', 'mvn');
        $this->load->model('vn/info/M_all_vendor', 'mav');
        $this->load->helper('helperx_helper');
    }

    public function index() {
        $id = $this->session->ID_VENDOR;
        $get_menu = $this->mvn->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['DESKRIPSI_IND'] = $v->DESCRIPTION_IND;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['DESKRIPSI_ENG'] = $v->DESCRIPTION_ENG;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['ICON'] = $v->ICON;
        }
        $data['menu'] = $dt;
        $this->template->display_vendor('vn/info/V_service_receive_notification', $data);
    }

    /* ===========================================     Get data START     ====================================== */
    public function get_data($id) {
        $result = $this->mgd->get_data($id);
        if ($result)
            return $result;
        else
            return "failed";
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

    public function datatable_msr_remaining(){
      $data = $this->M_service_receive_notification->show_msr_remaining();
      $result = array();
      $no = 1;
      foreach ($data as $arr) {
        $aksi = '<center> <button data-id="'.$arr['msr_no'].'" id="approve" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-primary" title="Update"><i class=""> Proses</i></button></center>';
        // $no++;
        $result[] = array(
          0 => $no++,
          1 => $arr['msr_no'],
          2 => $arr['msr_type_desc'],
          3 => $arr['scope_of_work'],
          4 => $arr['title'],
          5 => $arr['id_currency'],
          6 => $arr['create_on'],
          7 => $arr['req_date'],
          8 => $aksi,
        );
      }
      echo json_encode($result);
    }

    public function datatable_list_itp_on_progress(){
      $data = $this->M_service_receive_notification->list_itp_onprogress();
      $result = array();
      $no = 1;

      $class = 'success';
      foreach ($data as $arr) {

        if (strpos($arr['description'], "SEMUA DATA TELAH DISETUJUI") === FALSE) {
          $class = 'primary';
        } else {
          $class = 'success';
        }


        $aksi = '<center> <button data-id="'.$arr['id_itp_vendor'].'" data-code="'.$arr['id'].'|'.$arr['id_itp_vendor'].'|'.$arr['user_roles'].'|'.$arr['email_approve'].'|'.$arr['extra_case'].'|'.$arr['email_reject'].'|'.$arr['sequence'].'|'.$arr['status_approve'].'|'.$arr['reject_step'].'" id="approve" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-primary" title="Accept"><i class=""> Accept</i></button> <button data-id="'.$arr['id_itp_vendor'].'" data-code="'.$arr['id'].'|'.$arr['id_itp_vendor'].'|'.$arr['user_roles'].'|'.$arr['email_approve'].'|'.$arr['extra_case'].'|'.$arr['email_reject'].'|'.$arr['sequence'].'|'.$arr['status_approve'].'|'.$arr['reject_step'].'" id="Rejcet" data-toggle="modal" data-target="#modal_rej" class="btn btn-sm btn-danger" title="Rejcet"><i class=""> Rejcet</i></button> <button data-id="'.bin2hex(base64_encode($arr['id_itp'])).'" data-code="'.$arr['id'].'|'.$arr['id_itp_vendor'].'|'.$arr['user_roles'].'|'.$arr['email_approve'].'|'.$arr['extra_case'].'|'.$arr['email_reject'].'|'.$arr['sequence'].'|'.$arr['status_approve'].'|'.$arr['reject_step'].'" id="print_sr" class="btn btn-sm btn-info" title="Print SR"><i class=""> Print SR</i></button></center>';

        $result[] = array(
          0 => $no++,
          1 => $arr['no_po'],
          2 => $arr['itp_no'],
          3 => $arr['created_date'],
          4 => '<center><span class="badge badge badge-pill badge-'.$class.'">'.$arr['description'].'</span></center>',
          5 => $aksi,
        );
      }
      echo json_encode($result);
    }

    public function get_item_selection(){
      $idnya = $this->input->post("idnya");
      $data = $this->M_service_receive_notification->get_item_selection($idnya);
      echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function create_itp_document(){
      $id_itp = $this->input->post("id_itp");
      $item_type = $this->input->post("item_type");
      $note = $this->input->post("note");
      $item_qty = $this->input->post("item_qty");
      $item_ammount = $this->input->post("item_ammount");
      $material_id = $this->input->post("material_id");
      $total_spending = $this->input->post("total_spending");
      $price_unit = $this->input->post("price_unit");
      // $file_attch = ($_FILES["file_attch"] != "" ? $_FILES["file_attch"] : "");

      $data = array(
        'id_itp' => $id_itp,
        'no_po' => "",
        'note' => $note,
        'type' => 'ITP',
        'material_id'	=> $material_id,
        'qty'	=> $item_qty,
        'priceunit'	=> $price_unit,
        'total' => $item_ammount,
        'filename' => $_FILES["file_attch"],
      );

      $this->M_service_receive_notification->create_itp_document($data);
      echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function show_data_itp(){
      $msr_no = $this->input->post("msr_no");
      $data = $this->M_service_receive_notification->show_data_itp($msr_no);

      echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function itp_doc_approval(){
      $idx = $this->input->post("idx");
      $id_itp = $this->input->post("id_itp");
      $id_itp_vendor = $this->input->post("id_itp_vendor");
      $sequence = $this->input->post("sequence");
      $user_roles = $this->input->post("user_roles");
      $email_approve = $this->input->post("email_approve");
      $edit_content = $this->input->post("edit_content");


      $id_itp = $this->input->post("id_itp");
      $item_type = $this->input->post("item_type");
      $note = $this->input->post("note");
      $item_qty = $this->input->post("item_qty");
      $item_ammount = $this->input->post("item_ammount");
      $material_id = $this->input->post("material_id");
      $total_spending = $this->input->post("total_spending");
      $price_unit = $this->input->post("price_unit");
      $rm_file = $this->input->post("rm_file");
      // $file_attch = ($_FILES["file_attch"] != "" ? $_FILES["file_attch"] : "");

      $data_itp = array();
      $data = array(
        'idx' => $idx,
        'sequence' => $sequence,
        'user_roles' => $user_roles,
        'id_itp' => $id_itp,
        'id_itp_vendor' => $id_itp_vendor,
      );

      $send_data = $this->M_service_receive_notification->itp_doc_approval($data);

      if ($send_data) {
        ini_set('max_execution_time', 500);
        $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
        $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";


        $query = $this->db->query("select u.*,u.roles,b.user_roles as recipient,email_approve,n.open_value from t_approval_itp m
        join m_notic n on n.id=m.email_approve
        join ( select id_itp,user_roles from t_approval_itp where sequence=".$sequence."+1) b on b.id_itp=m.id_itp
        join m_user u on u.roles like CONCAT('%', b.user_roles ,'%')
        where m.sequence=".$sequence." and m.id_itp = ".$id_itp."");
        if ($query->num_rows() > 0) {
          $data_role = $query->result();
          $count = 1;
        } else {
          $query2 = $this->db->query("select u.*,u.roles,b.user_roles as recipient,email_approve,n.open_value from t_approval_itp m
          join m_notic n on n.id=m.email_approve
          join ( select id_itp,user_roles from t_approval_itp where sequence=".$sequence.") b on b.id_itp=m.id_itp
          join m_user u on u.roles like CONCAT('%', b.user_roles ,'%')
          where m.sequence=".$sequence." and m.id_itp = ".$id_itp."");
          $data_role = $query2->result();
          $count = 0;
        }

        if ($count = 1) {
          $content = $this->M_service_receive_notification->get_email_dest($email_approve);
          $res = $data_role;

          $str = 'ITP IS CLOSED<br>
          ';

          $data = array(
            'img1' => $img1,
            'img2' => $img2,
            'title' => $content[0]->TITLE,
            'open' => str_replace("deskripsinya", $str, $content[0]->OPEN_VALUE),
            'close' => $content[0]->CLOSE_VALUE
          );

          foreach ($data_role as $k => $v) {
            $data['dest'][] = $v->EMAIL;
          }
          $flag = $this->sendMail($data);
        }

      }

      echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function reject_itp_doc(){
      $note = (!empty($_POST['note'])?$_POST['note']:"");
      $id_rej = (!empty($_POST['id_rej'])?$_POST['id_rej']:"0");
      $id_itp_rej = (!empty($_POST['id_itp_rej'])?$_POST['id_itp_rej']:"0");
      $user_roles_rej = (!empty($_POST['user_roles_rej'])?$_POST['user_roles_rej']:"0");
      $email_approve_rej = (!empty($_POST['email_approve_rej'])?$_POST['email_approve_rej']:"0");
      $edit_content_rej = (!empty($_POST['edit_content_rej'])?$_POST['edit_content_rej']:"0");
      $email_reject_rej = (!empty($_POST['email_reject_rej'])?$_POST['email_reject_rej']:"0");
      $sequence_rej = (!empty($_POST['sequence_rej'])?$_POST['sequence_rej']:"0");
      $status_approve_rej = (!empty($_POST['status_approve_rej'])?$_POST['status_approve_rej']:"0");
      $reject_step_rej = (!empty($_POST['reject_step_rej'])?$_POST['reject_step_rej']:"0");


      $save_data = array(
        'note' => $note,
        'id_rej' => $id_rej,
        'id_itp_rej' => $id_itp_rej,
        'user_roles_rej' => $user_roles_rej,
        'email_approve_rej' => $email_approve_rej,
        'edit_content_rej' => $edit_content_rej,
        'email_reject_rej' => $email_reject_rej,
        'sequence_rej' => $sequence_rej,
        'status_approve_rej' => $status_approve_rej,
        'reject_step_rej' => $reject_step_rej,
      );

      // $result = true;
      if ($note != "") {
        $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
        $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";

        $query = $this->db->query("select u.*,u.roles,b.user_roles as recipient,email_approve,n.open_value from t_approval_itp m
        join m_notic n on n.id=m.email_approve
        join ( select id_itp,user_roles from t_approval_itp where sequence=".$sequence_rej." - ".$reject_step_rej.") b on b.id_itp=m.id_itp
        join m_user u on u.roles like CONCAT('%', b.user_roles ,'%')
        where m.sequence=".$sequence_rej." and m.id_itp = ".$id_itp_rej."");
        $data_role = $query->result();

        $content = $this->M_service_receive_notification->get_email_dest($email_reject_rej);
        $res = $data_role;
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
        $respon = true;
      } else {
        $respon = false;
      }

      $send = $this->M_service_receive_notification->reject_itp_doc($save_data);
      echo json_encode($send);
    }

}
