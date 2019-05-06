<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Itp_approval extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('procurement/M_itp_approval')->model('vendor/M_vendor');
        $this->load->model('m_base');
        $this->load->model('m_base');
        $this->load->model('procurement/m_service_receipt_itp');

        $this->load->model('procurement/m_service_receipt_itp');

        $this->load->model('procurement/m_service_receipt_itp');
        $this->load->helper(array('string', 'text'));
        $this->load->helper('helperx_helper');
        $this->load->helper('global_helper');
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
        $this->template->display('procurement/V_itp_approval', $data);
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
      $data = $this->M_itp_approval->show_msr_remaining();
      $result = array();
      $no = 1;
      foreach ($data as $arr) {
        $aksi = '<center> <button data-id="'.$arr['msr_no'].'" id="approve" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-info" title="Update"><i class=""> Process</i></button></center>';
        // $no++;
        $result[] = array(
          0 => $no++,
          1 => $arr['msr_no'],
          2 => $arr['msr_type_desc'],
          3 => $arr['scope_of_work'],
          4 => $arr['title'],
          5 => $arr['id_currency'],
          6 => $arr['create_on'],
          7 => dateToIndo($arr['req_date']),
          8 => $aksi,
        );
      }
      echo json_encode($result);
    }

    public function datatable_list_itp_on_progress(){
      $data = $this->M_itp_approval->list_itp_onprogress();
      $result = array();
      $no = 1;

      $class = 'success';
      foreach ($data as $arr) {

        if (strpos($arr['description'], "DATA DITOLAK") === FALSE) {
          $class = 'success';
        } else {
          $class = 'danger';
        }

        if ($arr['sequence'] <= 1 AND $arr['status_approve'] == 2) {
          $aksi = '<center> <button data-id="'.$arr['po_no'].'" data-code="'.$arr['id'].'|'.$arr['id_itp'].'|'.$arr['user_roles'].'|'.$arr['email_approve'].'|'.$arr['edit_content'].'|'.$arr['email_reject'].'|'.$arr['sequence'].'|'.$arr['status_approve'].'|'.$arr['reject_step'].'" id="approve" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-info" title="Update"><i class=""> Detail</i></button></center>';
        } else {
          $aksi = '<center> <button data-id="'.$arr['po_no'].'" data-code="'.$arr['id'].'|'.$arr['id_itp'].'|'.$arr['user_roles'].'|'.$arr['email_approve'].'|'.$arr['edit_content'].'|'.$arr['email_reject'].'|'.$arr['sequence'].'|'.$arr['status_approve'].'|'.$arr['reject_step'].'" id="approve" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-info" title="Update"><i class=""> Detail</i></button></center>';
        }

        // $aksi = '<center> <button data-id="'.$arr['msr_no'].'" data-code="'.$arr['id'].'|'.$arr['id_itp'].'|'.$arr['user_roles'].'|'.$arr['email_approve'].'|'.$arr['edit_content'].'|'.$arr['email_reject'].'|'.$arr['sequence'].'|'.$arr['status_approve'].'|'.$arr['reject_step'].'" id="approve" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-info" title="Update"><i class=""> Proses</i></button><button data-id="'.$arr['msr_no'].'" data-code="'.$arr['id'].'|'.$arr['id_itp'].'|'.$arr['user_roles'].'|'.$arr['email_approve'].'|'.$arr['edit_content'].'|'.$arr['email_reject'].'|'.$arr['sequence'].'|'.$arr['status_approve'].'|'.$arr['reject_step'].'" id="reject" data-toggle="modal" data-target="#modal_rej" class="btn btn-sm btn-danger" title="Update"><i class=""> Reject</i></button></center>';


        // $no++;
        $result[] = array(
          0 => $no++,
          1 => $arr['msr_no'],
          2 => $arr['number_of'],
          3 => $arr['title'],
          4 => $arr['jabatan'],
          5 => '<center><span class="badge badge badge-pill badge-'.$class.'">'.$arr['description'].'</span></center>',
          6 => $aksi,
        );
      }
      echo json_encode($result);
    }

    public function get_item_selection(){
      $idnya = $this->input->post("idnya");
      $data = $this->M_itp_approval->get_item_selection($idnya);

      $get_comp = $this->M_itp_approval->get_comp($idnya);

      foreach($data as $key => $val){
        $data[$key]['dt_comp'] = $get_comp;
        $data[$key]['receipt'] = $total_receipt = $this->m_service_receipt_itp->view('total_receipt_po')
        ->where('t_itp.no_po', $idnya)
        ->first();
      }

      echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function create_itp_document(){
      $msr_number = $this->input->post("msr_number");
      $item_type = $this->input->post("item_type");
      $note = $this->input->post("note");
      $item_qty = $this->input->post("item_qty");
      $item_ammount = $this->input->post("item_ammount");
      $material_id = $this->input->post("material_id");
      $total_spending = $this->input->post("total_spending");
      $price_unit = $this->input->post("price_unit");
      $remark = $this->input->post("remark");
      // $file_attch = ($_FILES["file_attch"] != "" ? $_FILES["file_attch"] : "");

      $data = array(
        'msr_no' => $msr_number,
        'no_po' => "",
        'note' => $note,
        'type' => 'ITP',
        'material_id'	=> $material_id,
        'qty'	=> $item_qty,
        'priceunit'	=> $price_unit,
        'total' => $item_ammount,
        'filename' => $_FILES["file_attch"],
        'remark' => $remark,
      );

      $this->M_itp_approval->create_itp_document($data);
      echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function show_data_itp(){
      $msr_no = $this->input->post("msr_no"); //ini po number
      $data = $this->M_itp_approval->show_data_itp($msr_no);
      // if (!empty(array_filter($data))) {
      //   foreach ($data['itp_detail'] as $key => $value) {
      //     $str = '<tr>'.
      //                 '<td><input type="hidden" name="material_id[]" value="'.$value['data_itp_detail']['material_id'].'" readonly />'.$value['data_itp_detail']['material_id'].'</td>'.
      //                 '<td><input type="hidden" name="item_type[]" value="'.$value['data_itp_detail']['id_itemtype'].'" readonly />'.$value['data_itp_detail']['id_itemtype'].'</td>'.
      //                 '<td>'.$value['data_itp_detail']['MATERIAL_NAME'].'</td>'.
      //                 '<td><input id="qty2'.$value['data_itp_detail']['material_id'].'" type="text" name="item_qty[]" onKeyup="change('.$value['data_itp_detail']['material_id'].', '.$value['data_itp_detail']['priceunit'].', '.$value['data_itp_detail']['total'].')" value="'.$value['data_itp_detail']['qty'].'" required /></td>'.
      //                 '<td>'.$value['data_itp_detail']['uom'].'</td>'.
      //                 '<td><input id="spending2'.$value['data_itp_detail']['material_id'].'" type="text" name="item_ammount[]" onChange="change('.$value['data_itp_detail']['material_id'].', '.$value['data_itp_detail']['total'].')" value="'.$value['data_itp_detail']['total'].'" readonly required /></td>'.
      //                 '<td><button type="button" data-id="'.$value['data_itp_detail']['material_id'].'" id="remove_item" class="btn btn-sm btn-danger">Remove</button></td>'.
      //               '</tr>';
      //   echo $str;
      //   }
      // }

      echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function itp_doc_approval(){
      $idx = $this->input->post("idx");
      $id_itp = $this->input->post("id_itp");
      $sequence = $this->input->post("sequence");
      $user_roles = $this->input->post("user_roles");
      $email_approve = $this->input->post("email_approve");
      $edit_content = $this->input->post("edit_content");


      $msr_number = $this->input->post("msr_number");
      $item_type = $this->input->post("item_type");
      $note = $this->input->post("note");
      $item_qty = $this->input->post("item_qty");
      $item_ammount = $this->input->post("item_ammount");
      $material_id = $this->input->post("material_id");
      $total_spending = $this->input->post("total_spending");
      $total_sebelumnya = $this->input->post("total_sebelumnya");
      $price_unit = $this->input->post("price_unit");
      $rm_file = $this->input->post("rm_file");
      $vendor_email = $this->input->post("vendor_email");
      $remark = $this->input->post("remark");
      $total_actual = intval($this->input->post("total_actual"));
      $itp_total = $this->input->post("itp_total");
      $itp_to = $this->input->post("itp_number_to");
      $sum_spending = array_sum($item_ammount);
      (!empty($_POST['date_itp']) ? $date_itp = $_POST['date_itp'] : $date_itp = date("Y:m:d") );
      // $file_attch = ($_FILES["file_attch"] != "" ? $_FILES["file_attch"] : "");

      $data_itp = array();

      if ($itp_to > 1) {
        $itp_val = $sum_spending;
      } else {
        $itp_val = $sum_spending;
      }

      // $data = array(
      //   'sum_spending' => $sum_spending,
      //   'item_ammount' => $item_ammount,
      //   'itp_total' => $itp_total,
      //   'total_actual' => $total_actual,
      //   'hasil' => $sum_spending + $itp_total,
      //   'success' => false,
      // );

      $data = array();
      $result = array();
      if ($itp_val > $total_actual) {
        $result['success'] = false;
      } else {
        $result['success'] = true;
        if ($edit_content == 1) {

          $data_itp = array(
            'id_itp' => $id_itp,
            'msr_no' => $msr_number,
            'no_po' => "",
            'note' => $note,
            'type' => 'ITP',
            'material_id'	=> $material_id,
            'qty'	=> $item_qty,
            'priceunit'	=> $price_unit,
            'total' => $item_ammount,
            'filename' => $_FILES["file_attch"],
            'rm_file' => $rm_file,
            'remark' => $remark,
            'dated' => $date_itp,
          );

          $send_data_upd = $this->M_itp_approval->itp_doc_approval_upd($data_itp);
        }


        $data = array(
          'idx' => $idx,
          'sequence' => $sequence,
          'user_roles' => $user_roles,
          'id_itp' => $id_itp,
          'data_itp' => $data_itp,
        );

        $send_data = $this->M_itp_approval->itp_doc_approval($data);
        // $send_data = true;

        if ($send_data == true) {
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

          if ($count === 1) {
            $content = $this->M_itp_approval->get_email_dest($email_approve);

            $res = $data_role;

            $str = '
            PO No: '.$msr_number.'<br>
            Catatan: '.$note.'<br>
            ';

            $data = array(
              'img1' => $img1,
              'img2' => $img2,
              'title' => $content[0]->TITLE,
              'open' => str_replace("_var1_", $msr_number, $content[0]->OPEN_VALUE),
              // 'open2' =>,
              'close' => $content[0]->CLOSE_VALUE
            );

            foreach ($data_role as $k => $v) {
              $data['dest'][] = $v->EMAIL;
            }
            $flag = $this->sendMail($data);
          }

          if ($count === 0) {
            $content = $this->M_itp_approval->get_email_dest($email_approve);

            $str = '
            ITP dengan PO No: '.$msr_number.' telah Lulus Kualifikasi Administrasi dan Telah Disetujui. <br>
            Catatan: '.$note.'<br>
            ';

            $data = array(
              'img1' => $img1,
              'img2' => $img2,
              'title' => $content[0]->TITLE,
              'open' => str_replace("_var1_", $msr_number, $content[0]->OPEN_VALUE),
              // 'open2' =>,
              'close' => $content[0]->CLOSE_VALUE,
              'dest' => array($vendor_email),
              // 'dest' => array('bangsueb0@gmail.com'),
            );

            $flag = $this->sendMail($data);

          }

        }
      }
      echo json_encode($result, JSON_PRETTY_PRINT);

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

        $content = $this->M_itp_approval->get_email_dest($email_reject_rej);
        $res = $data_role;
        $str = 'Catatan: '.$note.'<br>';

        $data = array(
            'img1' => $img1,
            'img2' => $img2,
            'title' => $content[0]->TITLE,
            'open' => str_replace("_var1_", $note, $content[0]->OPEN_VALUE),
            // 'open2' =>,
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

      $send = $this->M_itp_approval->reject_itp_doc($save_data);
      echo json_encode($send);
    }

}
