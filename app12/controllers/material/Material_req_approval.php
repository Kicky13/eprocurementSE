<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Material_req_approval extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('material/M_material_req_approval')->model('vendor/M_vendor')->model('material/M_material_req');
        $this->load->helper('global_helper');
    }

    public function index() {
      $data['material'] = $this->M_material_req->show_material();
      $data['req_no'] = $this->M_material_req->mreq_number();
      $data['company'] = $this->M_material_req->show_company($this->session->DEPARTMENT);
      $data['bp'] = $this->M_material_req->show_bp();
      $data['mr_type'] = $this->M_material_req->show_mr_type();
      $data['dept'] = $this->M_material_req->show_dept();
      $data['currency'] = $this->M_material_req->show_curency();
      $data['bplant'] = $this->M_material_req->show_bplant();
      $data['to_comp'] = $this->M_material_req->company();
      $data['wo_reason'] = $this->M_material_req->show_wo_reason();
      $data['asset_type'] = $this->M_material_req->show_asset_type();
      $data['disposal_method'] = $this->M_material_req->show_disposal_method();
      $data['costcenter'] = $this->M_material_req->show_costcenter();

      $get_menu = $this->M_vendor->menu();
      $dt = array();
      foreach ($get_menu as $k => $v) {
          $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
          $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
          $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
          $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
      }
      $data['menu'] = $dt;
      $this->template->display('material/V_material_req_approval', $data);
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
                $this->email->message(' <p>' . $content['img1'] . '<p>
                        <br>' . $content['open'] . '
                        <br>
                        ' . $content['close'] . '
                        <br>

                        ');
                $ctn = ' <p>' . $content['img1'] . '<p>
                        <br>' . $content['open'] . '
                        <br>
                        ' . $content['close'] . '
                        <br>';

                $this->email->to($v);


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
                $this->email->message(' <p>' . $content['img1'] . '<p>
                        <br>' . $content['open'] . '
                        <br>
                        ' . $content['close'] . '
                        <br>

                        ');

                $ctn = ' <p>' . $content['img1'] . '<p>
                        <br>' . $content['open'] . '
                        <br>
                        ' . $content['close'] . '
                        <br>';

                $this->email->to($content['email']);
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

    public function datatable_mr(){
      $data = $this->M_material_req_approval->datatable_mr();
      $result = array();
      $no = 1;
      foreach ($data as $arr) {
        if (strpos($arr['description'], "DATA DITOLAK") === FALSE) {
          $class = 'success';
          $disabled = '';
        } else {
          $class = 'danger';
          $disabled = 'disabled';
        }
        $aksi = '<center> <button data-id="'.$arr['request_no'].'" data-status="'.$arr['description'].'" id="approve" data-toggle="modal" data-target="#modal_approval" class="btn btn-sm btn-info" title="Detail" '.$disabled.'><i class=""> Detail</i></button></center>';
        if ($arr['document_type'] == 6) {
          if (strpos($this->session->userdata['COMPANY'], $arr['to_company']) == false) {

          } else {
            $result[] = array(
              0 => $no++,
              1 => $arr['request_no'],
              2 => dateToIndo($arr['request_date'], false, false),
              3 => $arr['mr_type_desc'],
              4 => $arr['purpose_of_request'],
              5 => $arr['semic_no'],
              6 => $arr['item_desc'],
              7 => $arr['uom'],
              8 => $arr['qty'],
              9 => $arr['qty_act'],
              10 => $arr['branch_plant'],
              11 => $arr['to_branch_plant'],
              12 => '<center><span class="badge badge badge-pill badge-'.$class.'">'.$arr['description'].'</span></center>',
              13 => $arr['status_jde'],
              14 => $aksi,
            );
          }
        } else {
          $result[] = array(
            0 => $no++,
            1 => $arr['request_no'],
            2 => $arr['request_date'],
            3 => $arr['mr_type_desc'],
            4 => $arr['purpose_of_request'],
            5 => $arr['semic_no'],
            6 => $arr['item_desc'],
            7 => $arr['uom'],
            8 => $arr['qty'],
            9 => $arr['qty_act'],
            10 => $arr['branch_plant'],
            11 => $arr['to_branch_plant'],
            12 => '<center><span class="badge badge badge-pill badge-'.$class.'">'.$arr['description'].'</span></center>',
            13 => $arr['status_jde'],
            14 => $aksi,
          );
        }
        // $no++;

      }
      echo json_encode($result);
    }

    public function get_material_req(){
      $idnya = $this->input->post("idnya");
      $data = $this->M_material_req_approval->get_material_req($idnya);
      $data_loc = $this->M_material_req->get_location();

      $acc_sub = $this->M_material_req->show_acharge($this->input->post("costcenter"));
      $str_acc_sub = '';
      foreach ($acc_sub->result_array() as $key => $arr) {
        $str_acc_sub .= '<option value="'.$arr['ID_ACCSUB'].'">'.$arr['ACCSUB_DESC'].'</option>';
      }
      $data['get_accsub'] = $this->input->post("costcenter");
      // $obj_dt = $data[0];
      // $data->material_request->get_location = $str_acc_sub;

      echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function save_note(){
      $notes = $this->input->post("notes");
      $mr_no = $this->input->post("mr_no");
      $data_insert = array(
        'module_kode' => 'mrnote',
        'data_id' => $mr_no,
        'description' => $notes,
        'created_at' => date("Y-m-d H:i:s"),
        'created_by' => $this->session->userdata['ID_USER'],
        'author_type' => 'm_user',
      );
      $save = $this->M_material_req_approval->save_note($data_insert);
      if ($save == true) {
        $result['success'] = true;
      } else {
        $result['success'] = false;
      }
      echo json_encode($result);
    }
    //
    public function get_note(){
      $mr_no = $this->input->post("mr_no");
      $data = $this->M_material_req_approval->get_note($mr_no);
      foreach ($data->result_array() as $key => $value) {
        echo '<div class="media-list">
              <div id="headingCollapse1" class="card-header p-0">
                <a data-toggle="collapse" href="#collapse1" aria-expanded="false" aria-controls="collapse1"
                class="collapsed email-app-sender media border-0 bg-blue-grey bg-lighten-5">
                  <div class="media-left pr-1">
                    <span class="avatar avatar-md">
                      <img class="media-object rounded-circle" src="'.base_url('ast11/img/iconuser.png').'"
                      alt="Generic placeholder image">
                    </span>
                  </div>
                  <div class="media-body w-100">
                    <h6 class="list-group-item-heading"><b>'.$value['NAME'].'</b></h6>
                    <p class="list-group-item-text">'.$value['description'].'
                      <span class="float-right text muted">'.$value['created_at'].'</span>
                    </p>
                  </div>
                </a>
              </div>
            </div>
            <br>';
      }
    }


    public function get_log(){
      $mr_no = $this->input->post("mr_no");
      $data = $this->M_material_req_approval->get_log($mr_no);
      $no = 1;
      foreach ($data->result_array() as $key => $value) {
        echo '
        <tr>
          <td>'.$no++.'</td>
          <td>'.$value['title'].'</td>
          <td>'.strtoupper($value['NAME']).'</td>
          <td>'.$value['description'].'</td>
          <td>'.dateToIndo($value['created_at'],false,true).'</td>
        </tr>
        ';
      }
    }

    public function approve_mr(){
      $mr_no = $this->input->post("mr_no");
      $user = $this->input->post("user");
      $user_roles = $this->input->post("user_roles");
      $sequence = $this->input->post("sequence");
      $status_approve = $this->input->post("status_approve");
      $reject_step = $this->input->post("reject_step");
      $email_approve = $this->input->post("email_approve");
      $email_reject = $this->input->post("email_reject");
      $edit_content = $this->input->post("edit_content");
      $extra_case = $this->input->post("extra_case");

      $semic = $this->input->post("semic");
      $qty = $this->input->post("qty");
      $unit_price = $this->input->post("unit_price");
      $to_unit_cost = $this->input->post("to_unit_cost");
      $ammount = $this->input->post("ammount");
      $to_ammount = $this->input->post("to_ammount");
      $remark = $this->input->post("remark");
      if (!empty($_POST['inspection'])) { $inspection = 1; } else { $inspection = 0; }
      if (!empty($_POST['asset_valuation'])) { $asset_valuation = 1; } else { $asset_valuation = 0; }

      $respon = array();
      $data = array(
        'mr_no' => $mr_no,
        'user' => $user,
        'user_roles' => $user_roles,
        'sequence' => $sequence,
        'status_approve' => $status_approve,
        'reject_step' => $reject_step,
        'email_approve' => $email_approve,
        'email_reject' => $email_reject,
        'edit_content' => $edit_content,
        'extra_case' => $extra_case,
        'type' => 'mr_approve',
        'qty' => $qty,
        'unit_price' => $unit_price,
        'to_unit_cost' => $to_unit_cost,
        'ammount' => $ammount,
        'to_ammount' => $to_ammount,
        'remark' => $remark,
        'semic' => $semic,
        'inspection' => $inspection,
        'asset_valuation' => $asset_valuation,
      );


      //
      $nextseq = $this->db->query("select max(sequence) as seq from t_approval_material_request where id_mr='".$mr_no."' ");
      $nexts = $nextseq->result();

    if($sequence == $nexts[0]->seq){
        $datas['doc_no'] = $mr_no;
        $datas['doc_type'] = 'mr';
        $datas['isclosed'] = 0;
        $this->db->insert('i_sync',$datas);
      }
      //

      if ($sequence !=  "") {
      $result = $this->M_material_req_approval->approve_mr($data);

      // $result = true;
      if ($result == true) {
        ini_set('max_execution_time', 500);
        $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
        $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";

        $query2 = $this->db->query("select m.email_approve, m.id_user, m.user_roles, u.*,u.roles,b.user_roles as recipient,m.email_approve,n.open_value from t_approval_material_request m
        join m_notic n on n.id=m.email_approve
        join ( select id_mr,user_roles from t_approval_material_request where sequence=".$sequence."+1) b on b.id_mr=m.id_mr
        join m_user u on u.roles like CONCAT('%', b.user_roles ,'%')
        where m.sequence=".$sequence."+1 AND m.id_mr = '".$mr_no."' AND u.ID_USER LIKE m.id_user ");
        $data_role = $query2->result();
        // echopre($this->db->last_query());
        // echopre($data_role);
        // exit;
        $content = $this->M_material_req_approval->get_email_dest($email_approve);
        $res = $data_role;
        // $str = 'No Material Request '.$mr_no.' ';
        $mail_content = $this->db->query("SELECT d.NAME, c.DEPARTMENT_DESC, b.description as doc_desc, a.purpose_of_request
                                          FROM t_material_request a
                                          JOIN m_material_request_type b ON b.id=a.document_type
                                          JOIN m_departement c ON c.ID_DEPARTMENT=a.departement
                                          JOIN m_user d ON d.ID_USER=a.create_by
                                          WHERE a.request_no = '".$mr_no."' ");
        $str = '<br> <b>MR No</b> '.$mr_no.'
                <br> <b>Purpose</b> '.$mail_content->row()->purpose_of_request.'
                <br> <b>MR Type</b> '.$mail_content->row()->doc_desc.'
                <br> <b>Requestor</b> '.$mail_content->row()->NAME.'
                <br> <b>Department</b> '.$mail_content->row()->DEPARTMENT_DESC.'
                ';

        $data_email = array(
          'img1' => $img1,
          'img2' => $img2,
          'title' => $content[0]->TITLE,
          'open' => str_replace("_var1_", $str, $content[0]->OPEN_VALUE),
          'close' => $content[0]->CLOSE_VALUE
        );

        // jika ada sequence
        if ($query2->num_rows() > 0) {
          foreach ($data_role as $k => $v) {
            $data_email['dest'][] = $v->EMAIL;
          }
          $flag = $this->sendMail($data_email);

          if ($flag == true) {
            // code kirim notif ke user
            $mail_content2 = $this->db->query("SELECT d.NAME, c.DEPARTMENT_DESC, b.description as doc_desc, a.purpose_of_request, d.EMAIL, '55' as email_approve
                                              FROM t_material_request a
                                              JOIN m_material_request_type b ON b.id=a.document_type
                                              JOIN m_departement c ON c.ID_DEPARTMENT=a.departement
                                              JOIN m_user d ON d.ID_USER=a.create_by
                                              JOIN m_notic e ON e.ID='55'
                                              WHERE a.request_no = '".$mr_no."' ");

            $content_usr = $this->M_material_req_approval->get_email_dest($mail_content2->row()->email_approve);

            $str_2 = '<br> <b>MR No</b> '.$mr_no.'
                    <br> <b>Purpose</b> '.$mail_content2->row()->purpose_of_request.'
                    <br> <b>MR Type</b> '.$mail_content2->row()->doc_desc.'
                    <br> <b>Requestor</b> '.$mail_content2->row()->NAME.'
                    <br> <b>Department</b> '.$mail_content2->row()->DEPARTMENT_DESC.'
                    ';

            $data_email2 = array(
              'img1' => $img1,
              'img2' => $img2,
              'title' => $content_usr[0]->TITLE,
              'open' => str_replace("_var1_", $str_2, $content_usr[0]->OPEN_VALUE),
              'close' => $content_usr[0]->CLOSE_VALUE
            );

            foreach ($mail_content2->result() as $k => $v) {
              $data_email2['dest'][] = $v->EMAIL;
            }
            $flag_1 = $this->sendMail($data_email2);
          }
        } else {
          // jika max sequence

          $flag2 = true;
          if ($flag2 == true) {
            $mail_content3 = $this->db->query("select a.from_company, d.NAME, k.NAME as requestor, c.DEPARTMENT_DESC, b.description as doc_desc, a.purpose_of_request, d.EMAIL, '56' as email_approve
            FROM t_material_request a
            JOIN m_material_request_type b ON b.id=a.document_type
            JOIN m_departement c ON c.ID_DEPARTMENT=a.departement
            JOIN m_user d ON d.ROLES LIKE '%,15,%'
            JOIN m_user k ON k.ID_USER=a.create_by
            JOIN m_notic e ON e.ID='56'
            WHERE a.request_no = '".$mr_no."'
            UNION
            select d.COMPANY, d.NAME, k.NAME as requestor, c.DEPARTMENT_DESC, b.description as doc_desc, a.purpose_of_request, d.EMAIL, '56' as email_approve
            FROM t_material_request a
            JOIN m_material_request_type b ON b.id=a.document_type
            JOIN m_departement c ON c.ID_DEPARTMENT=a.departement
            JOIN m_user d ON d.ROLES LIKE '%,35,%' AND d.COMPANY LIKE CONCAT('%',a.from_company,'%')
            JOIN m_user k ON k.ID_USER=a.create_by
            JOIN m_notic e ON e.ID='56'
            WHERE a.request_no = '".$mr_no."' ");

            $content_max = $this->M_material_req_approval->get_email_dest($mail_content3->row()->email_approve);
            $str = '<br> <b>MR No</b> '.$mr_no.'
                    <br> <b>Purpose</b> '.$mail_content3->row()->purpose_of_request.'
                    <br> <b>MR Type</b> '.$mail_content3->row()->doc_desc.'
                    <br> <b>Requestor</b> '.$mail_content3->row()->requestor.'
                    <br> <b>Department</b> '.$mail_content3->row()->DEPARTMENT_DESC.'
                    ';

            $data_email3 = array(
              'img1' => $img1,
              'img2' => $img2,
              'title' => $content_max[0]->TITLE,
              'open' => str_replace("_var1_", $str, $content_max[0]->OPEN_VALUE),
              'close' => $content_max[0]->CLOSE_VALUE
            );

            foreach ($mail_content3->result() as $k => $v) {
              $data_email3['dest'][] = $v->EMAIL;
            }
            $flag3 = $this->sendMail($data_email3);
          }
        }

        $respon = array(
          'success' => true,
          'data' => $data,
          'res' => $data_role,
        );
      } else {
        $respon['success'] = false;
      }
    }

    echo json_encode($respon);
  }

    public function reject_mr(){
      $mr_no = $this->input->post("mr_no");
      $user = $this->input->post("user");
      $user_roles = $this->input->post("user_roles");
      $sequence = $this->input->post("sequence");
      $status_approve = $this->input->post("status_approve");
      $reject_step = $this->input->post("reject_step");
      $email_approve = $this->input->post("email_approve");
      $email_reject = $this->input->post("email_reject");
      $edit_content = $this->input->post("edit_content");
      $extra_case = $this->input->post("extra_case");
      $note = $this->input->post("note");

      $data = array(
        'mr_no' => $mr_no,
        'user' => $user,
        'user_roles' => $user_roles,
        'sequence' => $sequence,
        'status_approve' => $status_approve,
        'reject_step' => $reject_step,
        'email_approve' => $email_approve,
        'email_reject' => $email_reject,
        'edit_content' => $edit_content,
        'extra_case' => $extra_case,
        'type' => 'mr_reject',
        'note' => $note,
      );

      $qq = $this->M_material_req_approval->reject_mr($data);
      if ($qq = true) {
        $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
        $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";

        $count_seq = $sequence - $reject_step;
        if ($count_seq > 0) {
          $seq = $count_seq;
        } else {
          $seq = $sequence;
        }

        $mail_content = $this->db->query("SELECT d.NAME, c.DEPARTMENT_DESC, b.description as doc_desc, a.purpose_of_request, d.EMAIL, a.create_by, i.email_reject
                                                FROM t_material_request a
                                                JOIN m_material_request_type b ON b.id=a.document_type
                                                JOIN m_departement c ON c.ID_DEPARTMENT=a.departement
                                                JOIN m_user d ON d.ID_USER=a.create_by
                                                JOIN ( select id_mr,email_reject from t_approval_material_request where sequence='".$seq."') i ON i.id_mr=a.request_no
                                                JOIN m_notic e ON e.ID=i.email_reject
                                                WHERE a.request_no = '".$mr_no."' ");
        $res = $mail_content->result();
        $content = $this->M_material_req_approval->get_email_dest($mail_content->row()->email_reject);
        $str = '<br> <b>MR No</b> '.$mr_no.'
                <br> <b>Purpose</b> '.$mail_content->row()->purpose_of_request.'
                <br> <b>MR Type</b> '.$mail_content->row()->doc_desc.'
                <br> Has been rejected.
                <br> Reject Note : '.$note.'
                ';

        $data_email = array(
            'img1' => $img1,
            'img2' => $img2,
            'title' => $content[0]->TITLE,
            'open' => str_replace("_var1_", $str, $content[0]->OPEN_VALUE),
            'close' => $content[0]->CLOSE_VALUE
        );

        foreach ($res as $k => $v) {
            $data_email['dest'][] = $v->EMAIL;
        }

        $flag = $this->sendMail($data_email);
        $data_email = true;
      } else {
        $data_email = false;
      }
      $data['success'] = $data_email;
      echo json_encode($data);
    }


    public function requestJDEsendHeader()
    {
      ini_set('max_execution_time', 300);
    error_reporting(0);
    ini_set('display_errors', 0);
    $req_no = "";
    $result = true;
    $query_check_out = $this->db->query("select doc_no from i_sync where doc_type='mr' and isclosed=0 limit 1");
    if($query_check_out->num_rows()>0){
      $result_check = $query_check_out->result();
      $req_no = $result_check[0]->doc_no;

      $m_mat_header = $this->db->query("select t.doc_type,t.ex_code,u.username,m.request_no,m.company_code,m.departement,m.document_type,m.purpose_of_request,m.request_date,m.account,m.branch_plant,m.to_branch_plant,m.from_company,m.to_company,m.intrans_no,m.intrans_user,m.wo_reason,m.create_date,m.create_by,m.busines_unit,DATE_FORMAT(m.create_date,'%Y-%m-%dT%H:%i:%s.000+07:00') as request_date,DATE_FORMAT(m.create_date,'%H%i%s') as timeofday from t_material_request m
  join m_user u on u.ID_USER=m.create_by
  join m_material_request_type t on t.id=m.document_type where m.request_no='".$req_no."'");

      $res = $m_mat_header->result();

      $wh = $res[0]->branch_plant;
      if (strlen($wh)<12) {
      $wh = '            '.$wh;
      $wh = substr($wh,-12);
      }

    $whto = $res[0]->to_branch_plant;
      if (strlen($whto)<12) {
      $whto = '            '.$whto;
      $whto = substr($whto,-12);
      }

    $ch = curl_init('https://10.1.1.94:91/PD910/F55MR001_InputMgr?WSDL');
        $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:orac="http://oracle.e1.bssv.JP57MR01/">
<soapenv:Header>
   <wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
     xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
     xmlns:env="http://schemas.xmlsoap.org/soap/envelope/"
     soapenv:mustUnderstand="1">
     <wsse:UsernameToken xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
       xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
       <wsse:Username>SCM</wsse:Username>
       <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">password</wsse:Password>
     </wsse:UsernameToken>
   </wsse:Security>
 </soapenv:Header>
   <soapenv:Body>
      <orac:F55MR001_InputMgr>
         <addressNumber>
            <value>'.$res[0]->username.'</value>
         </addressNumber>
         <costCenter>'.$wh.'</costCenter>
     <costCenter2>'.$whto.'</costCenter2>
         <dateTransactionJulian>'.$res[0]->request_date.'</dateTransactionJulian>
         <dateUpdated>'.$res[0]->request_date.'</dateUpdated>
         <descriptionLine1>'.$res[0]->busines_unit.'</descriptionLine1>
         <docVoucherInvoiceE>
            <value>'.$res[0]->request_no.'</value>
         </docVoucherInvoiceE>
         <documentType>'.$res[0]->doc_type.'</documentType>
         <everestEventPoint02>'.$res[0]->ex_code.'</everestEventPoint02>
         <nameAlpha>'.$res[0]->purpose_of_request.'</nameAlpha>
         <timeOfDay>
            <value>'.$res[0]->timeofday.'</value>
         </timeOfDay>
         <userId>SCM</userId>
      </orac:F55MR001_InputMgr>
   </soapenv:Body>
</soapenv:Envelope>';
      $headers = array(
        #"Content-type: application/soap+xml;charset=\"utf-8\"",
        "Content-Type: text/xml",
        "charset:utf-8",
        "Accept: application/xml",
        "Cache-Control: no-cache",
        "Pragma: no-cache",
        "Content-length: " . strlen($xml_post_string),
      );

      curl_setopt($ch, CURLOPT_HEADER, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($ch, CURLOPT_SSLVERSION, 'all');

      curl_setopt($ch, CURLOPT_VERBOSE, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,300);
              curl_setopt($ch, CURLOPT_TIMEOUT,360);

      $data_curl = curl_exec($ch);
      curl_close($ch);

      if (strpos($data_curl, 'HTTP/1.1 200 OK') !== false) {
        $m_mat_item = $this->db->query("select CASE WHEN length(i.account)>3 THEN CONCAT(u.COST_CENTER,'.',REPLACE(i.account,'-','.')) ELSE ' ' END  as acctNoInputMode,u.COST_CENTER,m.from_company as COMPANY,l.MATERIAL,m.*,i.*
				FROM t_material_request m
        join t_material_request_item i on i.request_no=m.request_no
        join m_user u on u.ID_USER=m.create_by
        join m_material l on l.MATERIAL_CODE=i.semic_no
        left join m_accsub a on a.ID_ACCSUB=m.account and a.COMPANY=m.from_company and a.COSTCENTER=u.COST_CENTER
        where m.request_no='".$req_no."'");

        if($m_mat_item->num_rows()>0){
          $res_item = $m_mat_item->result();
          $counter_item = 0;

          foreach ($res_item as $k => $v) {
            $ch = curl_init('https://10.1.1.94:91/PD910/F55MR002_InputMgr?WSDL');
            $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:orac="http://oracle.e1.bssv.JP57MR02/">
<soapenv:Header>
   <wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
     xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
     xmlns:env="http://schemas.xmlsoap.org/soap/envelope/"
     soapenv:mustUnderstand="1">
     <wsse:UsernameToken xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
       xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
       <wsse:Username>SCM</wsse:Username>
       <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">password</wsse:Password>
     </wsse:UsernameToken>
   </wsse:Security>
 </soapenv:Header>
   <soapenv:Body>
      <orac:F55MR002_InputMgr>
         <acctNoInputMode>'.$v->acctNoInputMode.'</acctNoInputMode>
         <address>'.$v->remark.'</address>
         <dateTransactionJulian>'.$res[0]->request_date.'</dateTransactionJulian>
         <dateUpdated>'.$res[0]->request_date.'</dateUpdated>
         <docVoucherInvoiceE>
            <value>'.$res[0]->request_no.'</value>
         </docVoucherInvoiceE>
         <documentType>'.$res[0]->doc_type.'</documentType>
         <identifier2ndItem>'.$v->semic_no.'</identifier2ndItem>
         <identifierShortItem>
            <value>'.$v->MATERIAL.'</value>
         </identifierShortItem>
         <lineNumber>
            <value>'.($counter_item+1).'</value>
         </lineNumber>
         <location></location>
         <quantityTransaction>
            <value>'.$v->qty.'</value>
         </quantityTransaction>
         <timeOfDay>
            <value>'.$res[0]->timeofday.'</value>
         </timeOfDay>
         <userId>SCM</userId>
      </orac:F55MR002_InputMgr>
   </soapenv:Body>
</soapenv:Envelope>';
            $headers = array(
              #"Content-type: application/soap+xml;charset=\"utf-8\"",
              "Content-Type: text/xml",
              "charset:utf-8",
              "Accept: application/xml",
              "Cache-Control: no-cache",
              "Pragma: no-cache",
              "Content-length: " . strlen($xml_post_string),
            );

            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSLVERSION, 'all');

            curl_setopt($ch, CURLOPT_VERBOSE, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,300);
              curl_setopt($ch, CURLOPT_TIMEOUT,360);

            $data_curl = curl_exec($ch);
            curl_close($ch);

            if (strpos($data_curl, 'HTTP/1.1 200 OK') !== false) {
              echo "Berhasil Exec JDE -  Doc No ".$req_no." at ".date("Y-m-d H:i:s");
              $query_update = $this->db->query("update i_sync set isclosed=1,updatedate=now() where doc_type='mr' and doc_no='".$req_no."' and isclosed=0");
            }else{
              echo "Gagal Exec JDE MR Item -  Doc No ".$req_no." at ".date("Y-m-d H:i:s");
            }

            $counter_item++;
          }
        }

        }else{
          echo "Gagal Exec JDE Header - Doc No ".$req_no." at ".date("Y-m-d H:i:s");
        }

      }else{
        echo "Execute No Data at ".date("Y-m-d H:i:s");
      }
    $data_log['script_type'] = 'mr';
    $this->db->insert('i_sync_log',$data_log);
    $this->db->close();

    }

        public function requestJDEcheckStatusMR()
    {
      ini_set('max_execution_time', 300);
      error_reporting(0);
      ini_set('display_errors', 0);


      $query_check_lastexec = $this->db->query(" select DATE_FORMAT(CAST(max(DATE_ADD(COALESCE(execute_time,now()), INTERVAL 5 MINUTE)) as DATE),'%m/%d/%Y') as exectime from i_sync_log where script_type='status_mr' ");
      $extime = $query_check_lastexec->result();

      if($query_check_lastexec->num_rows()>0){
        $ch = curl_init('https://10.1.1.94:91/PD910/F55MR001_InputMgr');
        $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:orac="http://oracle.e1.bssv.JP57MR01/">
<soapenv:Header>
   <wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
     xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
     xmlns:env="http://schemas.xmlsoap.org/soap/envelope/"
     soapenv:mustUnderstand="1">
     <wsse:UsernameToken xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
       xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
       <wsse:Username>SCM</wsse:Username>
       <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">password</wsse:Password>
     </wsse:UsernameToken>
   </wsse:Security>
 </soapenv:Header>
   <soapenv:Body>
      <orac:V55MR001_SelClose>

         <address>'.$extime[0]->exectime.'</address>
         <!--Optional:-->
         <everestEventPoint01>1</everestEventPoint01>

      </orac:V55MR001_SelClose>
   </soapenv:Body>
</soapenv:Envelope>';
      $headers = array(
        #"Content-type: application/soap+xml;charset=\"utf-8\"",
        "Content-Type: text/xml",
        "charset:utf-8",
        "Accept: application/xml",
        "Cache-Control: no-cache",
        "Pragma: no-cache",
        "Content-length: " . strlen($xml_post_string),
      );

        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSLVERSION, 'all');

        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,300);
        curl_setopt($ch, CURLOPT_TIMEOUT,360);

        $data_curl = curl_exec($ch);
        curl_close($ch);


        if (strpos($data_curl, 'HTTP/1.1 200 OK') !== false) {
          echo "Execute MR Status at ".date("Y-m-d H:i:s")." get data date ".$extime[0]->exectime;
          $a=$data_curl;

          $lastpos = 0;$lastposclose = 0;
          $content = '';
          for($i=0;$i<100;$i++){
            if ((strpos($a, '<queryResults xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="ns0:v55MR001_Select">') !== false)) {
              $lastpos = strpos($a, '<queryResults xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="ns0:v55MR001_Select">');
              $lastposclose = strpos($a, '</queryResults>');
              $content = substr($a,$lastpos,($lastposclose-$lastpos));

              $actqty = "0";
              $doc_no = "0";
              $semic_no = "0";
              $actremark = "";

              $actualqtypos = (strpos($content,'<address>'));
              $actualqtyposclose = (strpos($content,'</address>'));
              if($actualqtypos !== false){
                  $actremark = substr($content,($actualqtypos+strlen('<address>')),($actualqtyposclose-($actualqtypos+strlen('<address>'))));
                    //echo $actqty.'<br><br>';
              }

              $actualqtypos = (strpos($content,'<assignedQuantity>'));
              $actualqtyposclose = (strpos($content,'</assignedQuantity>'));
              if($actualqtypos !== false){
                  $actqtystr = substr($content,$actualqtypos,($actualqtyposclose-$actualqtypos));

                  $actqtypos = (strpos($actqtystr,'<value>'));
                  $actqtyposclose = (strpos($actqtystr,'</value>'));

                    $actqty = substr($actqtystr,($actqtypos+strlen('<value>')),($actqtyposclose-($actqtypos+strlen('<value>'))));
                    //echo $actqty.'<br><br>';
              }

              $actualqtypos = (strpos($content,'<docVoucherInvoiceE>'));
              $actualqtyposclose = (strpos($content,'</docVoucherInvoiceE>'));
              if($actualqtypos !== false){
                  $actqtystr = substr($content,$actualqtypos,($actualqtyposclose-$actualqtypos));

                  $actqtypos = (strpos($actqtystr,'<value>'));
                  $actqtyposclose = (strpos($actqtystr,'</value>'));

                    $doc_no = substr($actqtystr,($actqtypos+strlen('<value>')),($actqtyposclose-($actqtypos+strlen('<value>'))));
                    //echo $doc_no.'<br><br>';
              }

              $actualqtypos = (strpos($content,'<identifier2ndItem>'));
              $actualqtyposclose = (strpos($content,'</identifier2ndItem>'));
              if($actualqtypos !== false){
                  $semic_no = substr($content,($actualqtypos+strlen('<identifier2ndItem>')),($actualqtyposclose-($actualqtypos+strlen('<identifier2ndItem>'))));
                  //echo $semic_no.'<br><br>';
              }

              $this->db->query("update t_material_request set isclosed=1,update_date=now() where isclosed=0 and request_no='".$doc_no."' ");

              $this->db->query("update t_material_request_item set qty_act=".$actqty.",remark='".$actremark."' where semic_no='".$semic_no."' and request_no='".$doc_no."' ");

              $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
              $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";

              $mail_content2 = $this->db->query("SELECT d.NAME, c.DEPARTMENT_DESC, b.description as doc_desc, a.purpose_of_request, d.EMAIL, a.create_by
                                                FROM t_material_request a
                                                JOIN m_material_request_type b ON b.id=a.document_type
                                                JOIN m_departement c ON c.ID_DEPARTMENT=a.departement
                                                JOIN m_user d ON d.ID_USER=a.create_by
                                                JOIN m_notic e ON e.ID='70'
                                                WHERE a.request_no = '".$doc_no."' ");
              $content = $this->M_material_req_approval->get_email_dest($mail_content2->row()->create_by);

              $str = '<br> <b>MR No</b> '.$doc_no.'
                      <br> <b>Purpose</b> '.$mail_content2->row()->purpose_of_request.'
                      <br> <b>MR Type</b> '.$mail_content2->row()->doc_desc.'
                      <br> <b>Requestor</b> '.$mail_content2->row()->NAME.'
                      <br> <b>Department</b> '.$mail_content2->row()->DEPARTMENT_DESC.'
                      ';

              $data_email2 = array(
                'img1' => $img1,
                'img2' => $img2,
                'title' => $content[0]->TITLE,
                'open' => str_replace("_var1_", $str, $content[0]->OPEN_VALUE),
                'close' => $content[0]->CLOSE_VALUE
              );

              foreach ($mail_content2->result() as $k => $v) {
                $data_email2['dest'][] = $v->EMAIL;
              }
              $flag2 = $this->sendMail($data_email2);

              $a = substr($a,$lastposclose+strlen('</queryResults>'),strlen($a));
              //echo $content.'<br><br>';
            }
          }
        }else{
          echo "Execute MR Status Failed at ".date("Y-m-d H:i:s");
        }
      }


      $data_log['script_type'] = 'status_mr';
      $this->db->insert('i_sync_log',$data_log);
      $this->db->close();
    }


}
