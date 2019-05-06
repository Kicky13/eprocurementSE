<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Perform_itp extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('vn/info/M_perform_itp');
        $this->load->model('vn/info/M_vn', 'mvn');
        $this->load->model('vn/info/M_all_vendor', 'mav');
        $this->load->model('procurement/M_itp_approval')->model('vendor/M_vendor');
        $this->load->helper('helperx_helper');
    }

    public function index() {
      $this->itp_acceptance();
    }

    public function itp_acceptance() {
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
        $this->template->display_vendor('vn/info/V_perform_itp', $data);
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

    /* ===========================================     Get data START     ====================================== */
    public function get_data($id) {
        $result = $this->mgd->get_data($id);
        if ($result)
            return $result;
        else
            return "failed";
    }

    public function datatable_itpuser_remaining(){
      $data = $this->M_perform_itp->show_itpuser_remaining();
      $result = array();
      $no = 1;
      foreach ($data as $arr) {
        $queryx = $this->db->query('SELECT * FROM t_approval_itp_vendor WHERE id_itp = "'.$arr['id_itp'].'"');
        $row = $queryx->num_rows();
        if ($row > 0) {
          $disabled = 'disabled';
        } else {
          $disabled = '';
        }

        // if ($arr['is_vendor_acc'] == 1) {
        //   $acc_rej = "";
        //   $perform = '<button data-id="'.$arr['id_itp'].'" data-po="'.$arr['no_po'].'" id="perform" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-success" title="Perform ITP"><i class=""> PERFORM ITP</i></button>';
        // } else {
        //   $acc_rej = '<button data-id="'.$arr['id_itp'].'" data-po="'.$arr['no_po'].'" data-vendoracc="'.$arr['is_vendor_acc'].'" id="" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-info" title="Detail"><i class=""> Detail</i></button>';
        //   $perform = "";
        // }

        $acc_rej = '<button data-id="'.$arr['id_itp'].'" data-po="'.$arr['no_po'].'" data-vendoracc="'.$arr['is_vendor_acc'].'" id="detail_itp" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-info" title="Detail"><i class=""> Detail</i></button>';
        $perform = "";
        $aksi = '<center> '.$acc_rej.$perform.' </center>';

        $result[] = array(
          0 => $no,
          1 => $arr['no_po'],
          2 => $arr['itp_no'],
          3 => $arr['id_vendor'],
          4 => $arr['is_accept'],
          5 => $arr['created_date'],
          6 => $aksi,
        );
        $no++;
      }
      echo json_encode($result);
    }

    public function datatable_list_itp_on_progress(){
      $data = $this->M_perform_itp->list_itp_onprogress();
      $result = array();
      $no = 1;

      $class = 'success';
      foreach ($data as $arr) {
        $aksi = '<center> <button data-id="'.$arr['msr_no'].'" id="approve" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-success" title="Update"><i class=""> PERFORM ITP</i></button>
        <button data-id="'.$arr['msr_no'].'" id="reject" data-toggle="modal" data-target="#modal_rej" class="btn btn-sm btn-danger" title="Update"><i class=""> Reject</i></button></center>';

        $result[] = array(
          0 => $no,
          1 => $arr['msr_no'],
          2 => $arr['note'],
          3 => $arr['jabatan'],
          4 => '<center><span class="badge badge badge-pill badge-'.$class.'">'.$arr['description'].'</span></center>',
          5 => $aksi,
        );
        $no++;
      }
      echo json_encode($result);
    }

    public function get_item_selection(){
      $idnya = $this->input->post("idnya");
      $data = $this->M_perform_itp->get_item_selection($idnya);
      echo json_encode($data);
    }

    public function create_itp_document(){
      // $msr_number = $this->input->post("msr_number");
      $id_itp = $this->input->post("id_itp");
      $item_type = $this->input->post("item_type");
      $note = $this->input->post("note");
      $item_qty = $this->input->post("item_qty");
      $item_ammount = $this->input->post("item_ammount");
      $material_id = $this->input->post("material_id");
      $total_spending = $this->input->post("total_spending");
      $price_unit = $this->input->post("price_unit");
      $remark = $this->input->post("remark");
      (!empty($_POST['date_itp']) ? $date_itp = $_POST['date_itp'] : $date_itp = date("Y:m:d") );


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
        'remark' => $remark,
        'dated' => $date_itp,
      );

      if (!empty($item_qty) AND !empty($item_ammount) AND !empty($material_id) AND !empty($total_spending) AND !empty($price_unit)) {
        $handle = 1;

        // foreach ($total_spending as $key => $value) {
        //   if ($value < 0) {
        //     $handle = 0;
        //     break;
        //   } else {
        //     $handle = 1;
        //   }
        // }

        if ($handle == 1) {
          $ressult = true;
          $this->M_perform_itp->create_itp_document($data);
        } else {
          $ressult = false;
        }
      } else {
        $ressult = false;
      }
      echo json_encode($ressult, JSON_PRETTY_PRINT);
    }

    public function show_data_itp(){
      $msr_no = $this->input->post("msr_no");
      $data = $this->M_perform_itp->show_data_itp($msr_no);
      if (!empty(array_filter($data))) {
        foreach ($data['itp_detail'] as $key => $value) {
          $str = '<tr>'.
                      '<td><input type="hidden" name="material_id[]" value="'.$value['data_itp_detail']['material_id'].'" readonly />'.$value['data_itp_detail']['material_id'].'</td>'.
                      '<td><input type="hidden" name="item_type[]" value="'.$value['data_itp_detail']['id_itemtype'].'" readonly />'.$value['data_itp_detail']['id_itemtype'].'</td>'.
                      '<td>'.$value['data_itp_detail']['MATERIAL_NAME'].'</td>'.
                      '<td><input id="qty2'.$value['data_itp_detail']['material_id'].'" type="text" name="item_qty[]" onKeyup="change('.$value['data_itp_detail']['material_id'].', '.$value['data_itp_detail']['priceunit'].', '.$value['data_itp_detail']['total'].')" value="'.$value['data_itp_detail']['qty'].'" required /></td>'.
                      '<td>'.$value['data_itp_detail']['uom'].'</td>'.
                      '<td><input id="spending2'.$value['data_itp_detail']['material_id'].'" type="text" name="item_ammount[]" onChange="change('.$value['data_itp_detail']['material_id'].', '.$value['data_itp_detail']['total'].')" value="'.$value['data_itp_detail']['total'].'" readonly required /></td>'.
                      '<td><button type="button" data-id="'.$value['data_itp_detail']['material_id'].'" id="remove_item" class="btn btn-sm btn-danger">Remove</button></td>'.
                    '</tr>';
        echo $str;
        }
      }

      // echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function accept_document_itp(){
      $id_itp = $this->input->post("id_itp");
      $data = $this->M_perform_itp->accept_document_itp($id_itp);
      echo json_encode($data);
    }

    public function reject_itp_doc(){
      $id_itp_rej = $this->input->post("id_itp_rej");
      $note = $this->input->post("note");
      $data = $this->M_perform_itp->reject_itp_doc($id_itp_rej);
      if ($data == true) {
        if ($note != "") {
          $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
          $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";

          $query = $this->db->query("select u.*,u.roles,b.user_roles as recipient,email_approve,n.open_value, email_reject from t_approval_itp m
          join m_notic n on n.id=m.email_approve
          join ( select id_itp,user_roles from t_approval_itp where sequence= '1') b on b.id_itp=m.id_itp
          join m_user u on u.roles like CONCAT('%', b.user_roles ,'%')
          where m.sequence='1' and m.id_itp = '".$id_itp_rej."'");
          $data_role = $query->result();

          $content = $this->M_perform_itp->get_email_dest($query->row()->email_reject);
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
          $result['respon'] = true;
        } else {
          $result['respon'] = false;
        }
        $result['result'] = true;
      } else {
        $result['result'] = false;
      }
      echo json_encode($result);
    }

    public function get_item_selection_userrep(){
      $idnya = $this->input->post("idnya");
      $data = $this->M_itp_approval->get_item_selection($idnya);
      echo json_encode($data);
    }

    public function itp_accepted() {
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
        $this->template->display_vendor('vn/info/V_perform_itp_accepted', $data);
    }

    public function show_itpuser_accepted(){
      $data = $this->M_perform_itp->show_itpuser_accepted();
      $result = array();
      $no = 1;
      foreach ($data as $arr) {
        $queryx = $this->db->query('SELECT * FROM t_approval_itp_vendor WHERE id_itp = "'.$arr['id_itp'].'"');
        $row = $queryx->num_rows();
        if ($row > 0) {
          $disabled = 'disabled';
        } else {
          $disabled = '';
        }

        // if ($arr['is_vendor_acc'] == 1) {
        //   $acc_rej = "";
        //   $perform = '<button data-id="'.$arr['id_itp'].'" data-po="'.$arr['no_po'].'" id="perform" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-success" title="Perform ITP"><i class=""> PERFORM ITP</i></button>';
        // } else {
        //   $acc_rej = '<button data-id="'.$arr['id_itp'].'" data-po="'.$arr['no_po'].'" data-vendoracc="'.$arr['is_vendor_acc'].'" id="" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-info" title="Detail"><i class=""> Detail</i></button>';
        //   $perform = "";
        // }

        $acc_rej = '<button data-id="'.$arr['id_itp'].'" data-po="'.$arr['no_po'].'" data-vendoracc="'.$arr['is_vendor_acc'].'" id="detail_itp" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-info" title="Detail"><i class=""> Detail</i></button>';
        $perform = "";
        $aksi = '<center> '.$acc_rej.$perform.' </center>';

        $result[] = array(
          0 => $no,
          1 => $arr['no_po'],
          2 => $arr['itp_no'],
          3 => $arr['id_vendor'],
          4 => $arr['is_accept'],
          5 => $arr['created_date'],
          6 => $aksi,
        );
        $no++;
      }
      echo json_encode($result);
    }

}
