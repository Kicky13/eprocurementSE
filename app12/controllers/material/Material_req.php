<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Material_req extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('material/M_material_req')->model('material/M_material_req_approval')->model('vendor/M_vendor');
        $this->load->helper('global_helper');
    }

    public function index($id = null) {
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

        if (!empty($_POST['mr_no'])) { $mr_no = $_POST['mr_no']; } else { $mr_no = ""; }
        $data['get_id'] = $id;
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $this->template->display('material/V_material_req', $data);
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

    public function show_acharge(){
      $idx = $this->input->post("idx");
      if (!empty($this->input->post("mid"))) {
        $data = $this->M_material_req->show_acharge($idx,$this->input->post("mid"));
      } else {
        $data = $this->M_material_req->show_acharge($idx);
      }

      $str = '<option value=""> Select ... </option>';
      // if ($data->num_rows() > 0) {
      // } else {
      //   $str = '<option value="">Data Not Found</option>';
      // }
      foreach ($data->result_array() as $key => $arr) {
        $str .= '<option value="'.$arr['ID_ACCSUB']."|".$arr['ACCSUB_DESC'].'">'.$arr['ID_ACCSUB']." - ".$arr['ACCSUB_DESC'].'</option>';
      }
      $dt['data'] = $str;
      echo json_encode($dt);
    }

    public function show_acharge_item(){
      $idx = $this->input->post("idx");
      $data = $this->M_material_req->show_acharge($idx);
      $str = '<option value=""> Select ... </option>';
      // if ($data->num_rows() > 0) {
      // } else {
      //   $str = '<option value="">Data Not Found</option>';
      // }
      foreach ($data->result_array() as $key => $arr) {
        $str .= '<option value="'.$arr['ID_ACCSUB'].'">'.$arr['ID_ACCSUB']." - ".$arr['ACCSUB_DESC'].'</option>';
      }
      $dt['data'] = $str;
      echo json_encode($dt);
    }

    public function show_company_selection(){
      $idx = $this->input->post("idx");
      $data_bplant = $this->M_material_req->show_bplant_selection($idx);
      // $data_to_bplant = $this->M_material_req->show_to_bplant_selection($idx);
      $data_to_bplant = $this->M_material_req->show_bplant_selection($idx);
      $data_costcenter = $this->M_material_req->show_costcenter_selection($idx);
      $request_no = $this->M_material_req->mreq_number($idx);

      $str_bplant = '';
      $str_to_bplant = '';
      $str_currency = '';
      $str_costcenter = '<option value=""> Select ... </option>';
      $in = 1;
      foreach ($data_bplant->result_array() as $key => $arr) {
        $str_bplant .= '<option value="'.$arr['id_warehouse'].'" mytag="'.$arr['id_warehouse']." - ".$arr['description'].'">'.$arr['id_warehouse']." - ".$arr['description'].'</option>';
      }
      foreach ($data_to_bplant->result_array() as $key => $arr) {
        $str_to_bplant .= '<option value="'.$arr['id_warehouse'].'" mytag="'.$arr['id_warehouse']." - ".$arr['description'].'">'.$arr['id_warehouse']." - ".$arr['description'].'</option>';
      }
      foreach ($data_costcenter->result_array() as $key => $arr) {
        $str_costcenter .= '<option value="'.$arr['ID_COSTCENTER'].'">'.$arr['ID_COSTCENTER']." - ".$arr['COSTCENTER_DESC'].'</option>';
      }

      $dt['data_bplant'] = $str_bplant;
      $dt['data_to_bplant'] = $str_to_bplant;
      $dt['data_costcenter'] = $str_costcenter;
      $dt['data_request_no'] = $request_no;
      echo json_encode($dt);
    }

    public function get_material(){
      $material_id = $this->input->post("select_material");
      $currency_id = $this->input->post("select_currency");
      $semic_no = $this->input->post("semic_no");
      $bplant = $this->input->post("bplant");
      $data = $this->M_material_req->get_material($material_id);
      $data_loc = $this->M_material_req->get_location();
      $obj_dt = $data->row();
      $obj_dt->CURRENCY = $currency_id;
      $data_curr = $this->M_material_req->show_curency($obj_dt->CURRENCY);
      $obj_dt->CURRENCY_NAME = $data_curr->row()->CURRENCY;
      $currency = $this->M_material_req->show_curency();
      $str_currency = '';
      foreach ($currency->result_array() as $key => $arr) {
        $str_currency .= '<option value="'.$arr['ID'].'">'.$arr['CURRENCY'].'</option>';
      }

      $acc_sub = $this->M_material_req->show_acharge($this->input->post("costcenter"), $semic_no);
      $str_acc_sub = '<option value="">Select .. </option>';
      foreach ($acc_sub->result_array() as $key => $arr) {
        $str_acc_sub .= '<option value="'.$arr['ID_ACCSUB'].'">'.$arr['ID_ACCSUB'].' - '.$arr['ACCSUB_DESC'].'</option>';
      }

      //$bplant = $this->requestJDEQtyonHand($bplant ,$obj_dt->MATERIAL_CODE);

      /**$bplant = array(
        'qty_onhand' => 2,
      );**/
      //$bplant = $this->requestJDEQtyonHand($bplant ,$material_id);

      // $dt_bplant = $this->requestJDEQtyonHand($bplant, $semic_no);

      // $dt_bplant = array(
      //   'qty_onhand' => 11,
      // );

      // $obj_dt->get_jde = $dt_bplant;
      $obj_dt->get_location = $str_acc_sub;
      $obj_dt->get_currency = $str_currency;

      echo json_encode($obj_dt, JSON_PRETTY_PRINT);
    }

    public function get_data_jde(){
      ini_set('max_execution_time', 300);
      $bplant = $this->input->post("bplant");
      $semic_no = $this->input->post("semic_no");
      $data_jde = array();
      foreach ($semic_no as $key => $value) {
        $material_no = explode("|", $value);
        $data_jde[] = array(
          'data_jde' => $this->requestJDEQtyonHand($bplant, $material_no[1]),
          'material_id' => $material_no[0]
        );
      }
      echo json_encode($data_jde, JSON_PRETTY_PRINT);
    }

    public function create_mr(){
      $result = array();
      $check_business_unit = array();
      if (!empty($_POST['dept'])) { $dept = $_POST['dept']; } else { $dept = ""; }
      $request_no = $this->input->post("mr_no");
      $company_code = $this->input->post("comp_code");
      $departement = $this->input->post("departement");
      $costcenter = $this->input->post("costcenter");
      $user = $this->input->post("user");
      $document_type = $this->input->post("mr_type");
      $purpose_of_request = $this->input->post("issue");
      $branch_plant = $this->input->post("bp");
      $to_branch_plant = $this->input->post("to_branch_plant");
      $request_date = date("Y-m-d");
      $from_company = $this->input->post("from_company");
      $to_company = $this->input->post("to_company");
      $wo_reason = $this->input->post("wo_reason");
      $disposal_method = $this->input->post("disposal_method");
      $disposal_desc = $this->input->post("disposal_desc");
      $disposal_value = $this->input->post("disposal_value");
      $dis_val = $this->input->post("dis_val");
      $disposal_cost = $this->input->post("disposal_cost");
      $dis_cost = $this->input->post("dis_cost");
      if (!empty($_POST['inspection'])) { $inspection = 1; } else { $inspection = 0; }
      if (!empty($_POST['asset_valuation'])) { $asset_valuation = 1; } else { $asset_valuation = 0; }
      $asset_type = $this->input->post("asset_type");
      $check_aas = $this->input->post("check_aas");

      // item mr
      $semic_no = $this->input->post("semic");
      $item_desc = $this->input->post("m_name");
      $uom = $this->input->post("uom");
      $qty = $this->input->post("qty");
      $currency = $this->input->post("curr");

      if (!empty($_POST['unit_price'])) { $unit_cost = $_POST['unit_price']; } else { $unit_cost = 0; }

      $to_unit_cost = $this->input->post("to_unit_cost");
      $extended_ammount = $this->input->post("ammount");
      $to_extended_ammount = $this->input->post("to_ammount");
      if (!empty($_POST['from_loc'])) { $location = $_POST['from_loc']; } else { $location = ""; }
      if (!empty($_POST['to_loc'])) { $to_location = $_POST['to_loc']; } else { $to_location = ""; }

      $remark = $this->input->post("remark");
      $qty_act = $this->input->post("qty_act");
      $qty_avl = $this->input->post("qty_avl_ori");
      $bp_item = $this->input->post("bp_item");
      $to_bp_item = $this->input->post("to_bp_item");
      $acc = $this->input->post("acc");
      $acc_desc = $this->input->post("acc_desc");
      $category = $this->input->post("category");
      $acq_year = $this->input->post("acq_year");
      $acq_value = $this->input->post("acq_value");
      $bu = $this->input->post("bu");
      // $curr_book = $this->input->post("curr_book");
      if (!empty($_POST['curr_book'])) { $curr_book = $_POST['curr_book']; } else { $curr_book = 0; }

      $sum_book = array_sum($curr_book);
      $sum_cost = array_sum($unit_cost);
      $get_id = $this->input->post("get_id");
      $mtr_status = $this->input->post("mtr_status");

      if(!empty($this->input->post("get_id"))){
        $request_no = $get_id;
      }else{
        $request_no = $this->M_material_req->mreq_number($from_company);
      }
      $dt = array(
        // heads
        'request_no' => $request_no,
        'company_code' => $company_code,
        'departement' => $departement,
        'user' => $user,
        'document_type' => $document_type,
        'busines_unit' => $costcenter,
        'purpose_of_request' => $purpose_of_request,
        'request_date' => $request_date,
        'branch_plant' => $branch_plant,
        'to_branch_plant' => $to_branch_plant,
        'from_company' => $from_company,
        'to_company' => $to_company,
        'wo_reason' => $wo_reason,
        'create_date' => date('Y-m-d H:i:s'),
        'create_by' => $this->session->userdata['ID_USER'],
        'get_id' => $get_id,
        'inspection' => $inspection,
        'asset_valuation' => $asset_valuation,
        'asset_type' => $asset_type,
        'disposal_method' => $disposal_method,
        'disposal_desc' => $disposal_desc,
        'disposal_value' => $disposal_value,
        'dis_val' => $dis_val,
        'disposal_cost' => $disposal_cost,
        'dis_cost' => $dis_cost,
        // item
        'request_no' => $request_no,
        'semic_no' => $semic_no,
        'item_desc' => $item_desc,
        'uom' => $uom,
        'qty' => $qty,
        'location' => $location,
        'to_location' => $to_location,
        'currency' => $currency,
        'unit_cost' => $unit_cost,
        'to_unit_cost' => $to_unit_cost,
        'extended_ammount' => $extended_ammount,
        'to_extended_ammount' => $to_extended_ammount,
        'remark' => $remark,
        'qty_act' => $qty_act,
        'qty_avl' => $qty_avl,
        'bp_item' => $bp_item,
        'to_bp_item' => $to_bp_item,
        'acc' => $acc,
        'acc_desc' => $acc_desc,
        'category' => $category,
        'acq_year' => $acq_year,
        'acq_value' => $acq_value,
        'curr_book' => $curr_book,
        'sum_book' => $sum_book,
        'sum_cost' => $sum_cost,
        'mtr_status' => $mtr_status,
        'bu' => $bu,
      );

      if (!empty($this->input->post("gl_class"))) { $dt['gl_class'] = $this->input->post("gl_class"); }

      if ($dept != "") {
        $deptx = explode("|", $dept);
        $account = $deptx[0];
        $account_desc = $deptx[1];

        $dt['account'] = $account;
        $dt['account_desc'] = $account_desc;
      } else {
        $dt['account'] = '';
        $dt['account_desc'] = '';
      }

      // check busines unit
      $check_bu = true;


      if ($document_type == "1" || $document_type == "4") {
        foreach ($acc as $i => $val) {
          if ($acc[$i] == "") {
            $check_acc = false;
          } else {
            $splitx = explode("-", $acc[$i]);
            $qq = $this->M_material_req->check_business_unit($semic_no[$i], $splitx[0], $splitx[1]);
            $check_business_unit[$i] = $qq;
            $check_acc = true;
          }

        }

        if ($check_acc == true) {
          if (in_array('0', $check_business_unit)) {
            $check_bu = false;
          }
        }

      }


      if ($check_bu == true) {
        if (!empty($get_id)) {
          // $qq = 'update';
          $qq = $this->M_material_req->update_mr($dt);
        } else {
          // $qq = true;
          $qq = $this->M_material_req->create_mr($dt);
        }

        // check aas insert a
        if ($document_type == "6") {
          $dt_array = array();
          $writeoff = $this->tjabatan_intrf($this->session->userdata['ID_USER'], $sum_cost);
          $qaas_1 = $this->db->query("SELECT a.id, a.user_id, b.NAME, a.title, a.golongan, a.position, a.nominal, a.nominal_writeoff FROM t_jabatan a JOIN m_user b ON b.ID_USER=a.user_id WHERE a.user_id='".$writeoff->user_id."' AND b.COMPANY LIKE '%".$from_company."%' ");
          $aas2 = $this->db->query("SELECT a.user_id, b.NAME FROM t_jabatan a JOIN m_user b ON b.ID_USER=a.user_id WHERE a.golongan = '".$writeoff->golongan."' AND nominal_writeoff = '".$writeoff->nominal_writeoff."' AND b.COMPANY LIKE '%".$from_company."%' AND a.user_id != '".$qaas_1->row()->user_id."'");

          $str = '<select class="form-control aas_2" style="width:450px !important;" name="aas_2" required>
          <option value=""> Select .. </option>';
          foreach ($aas2->result_array() as $arr) {
            $str .= '<option value="'.$arr['user_id'].'|'.$arr['NAME'].'">'.$arr['NAME'].'</option>';
           }
          $str .= '</select>';

          $qfrom_comp = $this->db->query("SELECT DESCRIPTION FROM m_company WHERE ID_COMPANY = '".$from_company."'");
          $qto_comp = $this->db->query("SELECT DESCRIPTION FROM m_company WHERE ID_COMPANY = '".$to_company."'");
          $aas_oth = $this->db->query("SELECT a.user_id, b.NAME FROM t_jabatan a JOIN m_user b ON b.ID_USER=a.user_id WHERE a.golongan = '".$writeoff->golongan."' AND nominal_writeoff = '".$writeoff->nominal_writeoff."' AND b.COMPANY LIKE '%".$to_company."%'");

          $str1 = '<select class="form-control aas_1_other" style="width:450px !important;" name="aas_1_other" required><option value=""> Select .. </option>';
          foreach ($aas_oth->result_array() as $arr) {
            $dt_array[] = array(
              'dt' => $arr['user_id'].'|'.$arr['NAME'],
            );
            $str1 .= '<option value="'.$arr['user_id'].'|'.$arr['NAME'].'">'.$arr['NAME'].'</option>';
           }
          $str1 .= '</select>';

          $str2 = '<select class="form-control aas_2_other" style="width:450px !important;" name="aas_2_other" required><option value=""> Select .. </option>';
          foreach ($aas_oth->result_array() as $arr) {
            $str2 .= '<option value="'.$arr['user_id'].'|'.$arr['NAME'].'">'.$arr['NAME'].'</option>';
           }
          $str2 .= '</select>';

          $result['aas_1'] = $qaas_1->row();
          $result['aas_2'] = $str;
          $result['aas_1_other_comp'] = $str1;
          $result['aas_2_other_comp'] = $str2;
          $result['aas_other_comp'] = $dt_array;
          $result['aas_1_other_comp_title'] = 'Asign to user AAS '.$qfrom_comp->row()->DESCRIPTION;
          $result['aas_2_other_comp_title'] = 'Asign to second user AAS '.$qto_comp->row()->DESCRIPTION;
        }

        if ($document_type == "7") {
          $writeoff = $this->tjabatan_wo($this->session->userdata['ID_USER'], $sum_book);
          $qaas_1 = $this->db->query("SELECT a.id, a.user_id, b.NAME, a.title, a.golongan, a.position, a.nominal, a.nominal_writeoff FROM t_jabatan a JOIN m_user b ON b.ID_USER=a.user_id WHERE a.user_id='".$writeoff->user_id."'");
          $aas2 = $this->db->query("SELECT a.id, a.user_id, b.NAME FROM t_jabatan a JOIN m_user b ON b.ID_USER=a.user_id WHERE a.golongan = '".$writeoff->golongan."' AND nominal_writeoff = '".$writeoff->nominal_writeoff."' AND a.user_id != '".$qaas_1->row()->user_id."' ");

          $str = '<select class="form-control aas_2" style="width:450px !important;" name="aas_2" required>
          <option value=""> Select .. </option>';
          foreach ($aas2->result_array() as $arr) {
            $str .= '<option value="'.$arr['user_id'].'|'.$arr['NAME'].'">'.$arr['NAME'].'</option>';
           }
          $str .= '</select>';

          $result['aas_1'] = $qaas_1->row();
          $result['aas_2'] = $str;
        }

        if ($document_type == "8") {
          $writeoff = $this->tjabatan_wo($this->session->userdata['ID_USER'], $sum_book);
          $qaas_1 = $this->db->query("SELECT a.id, a.user_id, b.NAME, a.title, a.golongan, a.position, a.nominal, a.nominal_writeoff FROM t_jabatan a JOIN m_user b ON b.ID_USER=a.user_id WHERE a.user_id='".$writeoff->user_id."'");
          $aas2 = $this->db->query("SELECT a.id, a.user_id, b.NAME FROM t_jabatan a JOIN m_user b ON b.ID_USER=a.user_id WHERE a.golongan = '".$writeoff->golongan."' AND nominal_writeoff = '".$writeoff->nominal_writeoff."' AND a.user_id != '".$qaas_1->row()->user_id."' ");

          $str = '<select class="form-control aas_2" style="width:450px !important;" name="aas_2" required>
          <option value=""> Select .. </option>';
          foreach ($aas2->result_array() as $arr) {
            $str .= '<option value="'.$arr['user_id'].'|'.$arr['NAME'].'">'.$arr['NAME'].'</option>';
           }
          $str .= '</select>';

          $result['aas_1'] = $qaas_1->row();
          $result['aas_2'] = $str;
        }

        $result['data'] = $dt;
        $result['success'] = $qq;

        // send email
        if ($result['success'] == true) {
          if ($check_aas == "0") {
            ini_set('max_execution_time', 500);
            $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
            $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";

            $query2 = $this->db->query("select m.email_approve, m.id_user, m.user_roles, u.*,u.roles,b.user_roles as recipient,m.email_approve,n.open_value from t_approval_material_request m
            join m_notic n on n.id=m.email_approve
            join ( select id_mr,user_roles from t_approval_material_request where sequence='1') b on b.id_mr=m.id_mr
            join m_user u on u.roles like CONCAT('%', b.user_roles ,'%')
            where m.sequence='1' AND m.id_mr = '".$request_no."' AND u.ID_USER LIKE m.id_user ");
            $data_role = $query2->result();
            $email_approve = $this->db->query("select email_approve from t_approval_material_request WHERE sequence=1 and id_mr = '".$request_no."' ");
            $get_email_approve = $email_approve->row()->email_approve;

            $content = $this->M_material_req_approval->get_email_dest(intval($get_email_approve));
            $res = $data_role;
            // $str = 'No Material Request '.$request_no.' ';
            $mail_content = $this->db->query("SELECT d.NAME, c.DEPARTMENT_DESC, b.description as doc_desc, a.purpose_of_request
                                              FROM t_material_request a
                                              JOIN m_material_request_type b ON b.id=a.document_type
                                              JOIN m_departement c ON c.ID_DEPARTMENT=a.departement
                                              JOIN m_user d ON d.ID_USER=a.create_by
                                              WHERE a.request_no = '".$request_no."' ");
            $str = '<br> <b>MR No</b> '.$request_no.'
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
            foreach ($data_role as $k => $v) {
              $data_email['dest'][] = $v->EMAIL;
            }
            $flag = $this->sendMail($data_email);
          }
        }
        $result['check_business_unit'] = $check_bu;
      } else {
        $result['check_business_unit'] = $check_bu;
      }

      echo json_encode($result, JSON_PRETTY_PRINT);
    }


    public function datatable_mr(){
      $data = $this->M_material_req->datatable_mr();
      $result = array();
      $no = 1;
      foreach ($data as $arr) {

        if (strpos($arr['description'], "DATA DITOLAK") === FALSE) {
          $class = 'success';
          // $aksi = '<center> - </center>';
        } else {
          $class = 'danger';
        }
        $aksi = '<center> <button data-id="'.$arr['request_no'].'" data-status="'.$arr['description'].'" data-approval="'.$class.'" id="approve" data-toggle="modal" data-target="#modal_approval" class="btn btn-sm btn-info" title="Update"><i class=""> Detail</i></button></center>';
        // $no++;
        $result[] = array(
          0 => $no++,
          1 => $arr['request_no'],
          2 => dateToIndo($arr['request_date'], false, false),
          3 => $arr['branch_plant'],
          4 => $arr['mr_type_desc'],
          5 => $arr['to_branch_plant'],
          6 => $arr['purpose_of_request'],
          7 => '<center><span class="badge badge badge-pill badge-'.$class.'">'.$arr['description'].'</span></center>',
          8 => $aksi,
        );
      }
      echo json_encode($result);
    }

    public function datatable_add_material(){
      $bplant = $this->input->post("bplant");
      // $bplant  = (!empty($requestData["bplant"]) ? $requestData["bplant"] : "");

      $data = $this->M_material_req->show_material($bplant);
      $result = array();
      $no = 1;
      foreach ($data->result_array() as $arr) {
        // $no++;
        $result[] = array(
          0 => '<input type="checkbox" class="material_check" id="material_check'.$arr['MATERIAL'].'" value="'.$arr['MATERIAL'].'|'.$arr['MATERIAL_CODE'].'|'.preg_replace("/[^A-Za-z0-9?![:space:]]/",'',$arr['MATERIAL_NAME']).'|'.$arr['UOM'].'">',
          1 => $arr['MATERIAL_CODE'],
          2 => $arr['MATERIAL_NAME'],
          3 => $arr['UOM'],
          4 => $arr['QTY'].'<input class="form-control" type="hidden" id="qty_avl_mtr'.$arr['MATERIAL'].'" name="qty_avl_mtr[]" value="'.$arr['QTY'].'" readonly>',
          5 => numIndo($arr['ITEM_COST']).'<input class="form-control" type="hidden" id="item_cost'.$arr['MATERIAL'].'" name="item_cost[]" value="'.$arr['ITEM_COST'].'" readonly>',
        );
      }
      echo json_encode($result);
    }

    public function add_approval_aas(){
      $id = $this->input->post("id");
      $position = $this->input->post("position");
      $title = $this->input->post("title");
      $parent_id = $this->input->post("parent_id");
      $user_id = $this->input->post("user_id");
      $golongan = $this->input->post("golongan");
      $nominal = $this->input->post("nominal");
      $company_id = $this->input->post("company_id");
      $first = $this->input->post("first");
      $nominal_writeoff = $this->input->post("nominal_writeoff");
      $aas_2 = $this->input->post("aas_2");
      $mr_no = $this->input->post("mr_no");
      $doc_type = $this->input->post("doc_type");
      $aas_1_other = $this->input->post("aas_1_other");
      $aas_2_other = $this->input->post("aas_2_other");
      $create_by = $this->input->post("create_by");

      $aas2_type = explode("|", $aas_2);
      $aas1_other = explode("|", $aas_1_other);
      $aas2_other = explode("|", $aas_2_other);
      $data = array(
        'id' => $id,
        'position' => $position,
        'title' => $title,
        'parent_id' => $parent_id,
        'user_id' => $user_id,
        'golongan' => $golongan,
        'nominal' => $nominal,
        'company_id' => $company_id,
        'first' => $first,
        'nominal_writeoff' => $nominal_writeoff,
        'aas2_id' => $aas2_type[0],
        'aas2_title' => $aas2_type[1],
        'mr_no' => $mr_no,
        'doc_type' => $doc_type,
        'aas_1_other' => $aas1_other[0],
        'aas_2_other' => $aas2_other[0],
        'create_by' => $create_by,
      );
      $qq = $this->M_material_req->create_mr_aas($data);
      if ($qq == true) {
        if ($doc_type == "7" || $doc_type == "8" || $doc_type == "6") {
          ini_set('max_execution_time', 500);
          $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
          $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";

          $query2 = $this->db->query("select m.email_approve, m.id_user, m.user_roles, u.*,u.roles,b.user_roles as recipient,m.email_approve,n.open_value from t_approval_material_request m
          join m_notic n on n.id=m.email_approve
          join ( select id_mr,user_roles from t_approval_material_request where sequence='1') b on b.id_mr=m.id_mr
          join m_user u on u.roles like CONCAT('%', b.user_roles ,'%')
          where m.sequence='1' AND m.id_mr = '".$mr_no."' AND u.ID_USER LIKE m.id_user ");
          $data_role = $query2->result();
          $email_approve = $this->db->query("select email_approve from t_approval_material_request WHERE sequence=1 and id_mr = '".$mr_no."' ");
          $get_email_approve = $email_approve->row()->email_approve;

          $content = $this->M_material_req_approval->get_email_dest(intval($get_email_approve));
          $res = $data_role;
          // $str = '<br> No Material Request '.$mr_no.' ';
          $mail_content = $this->db->query("SELECT d.NAME, c.DEPARTMENT_DESC, b.description as doc_desc, a.purpose_of_request
                                            FROM t_material_request a
                                            JOIN m_material_request_type b ON b.id=a.document_type
                                            JOIN m_departement c ON c.ID_DEPARTMENT=a.departement
                                            JOIN m_user d ON d.ID_USER=a.create_by
                                            WHERE a.request_no = '".$mr_no."' ");
          $str = '<br> <b>MR No</b> '.$mr_no.'
                  <br> <b>Purpose</b> '.$mail_content->row()->purpose_of_request.'
                  <br> <b>MR Type</b> '.$mail_content->row()->doc_desc.'
                  <br> <b>Requestoe</b> '.$mail_content->row()->NAME.'
                  <br> <b>Department</b> '.$mail_content->row()->DEPARTMENT_DESC.'
                  ';


          $data_email = array(
            'img1' => $img1,
            'img2' => $img2,
            'title' => $content[0]->TITLE,
            'open' => str_replace("_var1_", $str, $content[0]->OPEN_VALUE),
            'close' => $content[0]->CLOSE_VALUE
          );
          foreach ($data_role as $k => $v) {
            $data_email['dest'][] = $v->EMAIL;
          }
          $flag = $this->sendMail($data_email);
        }
      }
      $data['success'] = $qq;
      echo json_encode($data);
    }

    public function tjabatan_wo($id, int $wo_val){
      ini_set('max_execution_time', 500);
      // echo $id;
      for ($i=0; $i < 100; $i++) {
        a:
        $query = $this->db->query("SELECT * FROM t_jabatan a JOIN m_user b ON b.ID_USER=a.user_id WHERE a.user_id = '".$id."' ");
        if ($query->num_rows() > 0) {
          $par_id = $query->row()->parent_id;
          $qqsq = $this->db->query("SELECT * FROM t_jabatan WHERE id = '".$par_id."' ");
          if ($wo_val <= intval($qqsq->row()->nominal_writeoff) && intval($qqsq->row()->nominal_writeoff) > 0) {
            // echo $id;
            return $qqsq->row();
            exit;
          } else {
            $id = $qqsq->row()->user_id;
            goto a;
          }
          // if ($wo_val <= intval($qqsq->row()->nominal_writeoff) && intval($qqsq->row()->nominal_writeoff) > 0) {
          //   echopre( $qqsq->row()->nominal_writeoff );
          //   echopre( $id );
          //   // $qqs = $this->db->query("SELECT * FROM t_jabatan WHERE id = '".$qqsq->row()->parent_id."' ");
          //   return $qqsq->row();
          //   // return AREK WAKWAU;
          // } else {
          //   $qq = $this->db->query("SELECT * FROM t_jabatan WHERE id = '".$qqsq->row()->parent_id."' ");
          //   return $this->tjabatan_wo($qq->row()->user_id, $wo_val);
          //   // return AREK RECURSIVE;
          // }
        }
      }

    }

    public function tjabatan_intrf($id, int $wo_val){
      ini_set('max_execution_time', 500);
      $query = $this->db->query("SELECT * FROM t_jabatan a JOIN m_user b ON b.ID_USER=a.user_id WHERE a.user_id = '".$id."' ");
      if ($query->num_rows() > 0) {
        $par_id = $query->row()->parent_id;
        $qqsq = $this->db->query("SELECT * FROM t_jabatan WHERE id = '".$par_id."' ");
        if ($wo_val <= intval($qqsq->row()->nominal_intercompany) && intval($qqsq->row()->nominal_intercompany) > 0) {
          // $qqs = $this->db->query("SELECT * FROM t_jabatan WHERE id = '".$qqsq->row()->parent_id."' ");
          return $qqsq->row();
          // return AREK WAKWAU;
        } else {
          $qq = $this->db->query("SELECT * FROM t_jabatan WHERE id = '".$qqsq->row()->parent_id."' ");
          return $this->tjabatan_intrf($qq->row()->user_id, $qq->row()->nominal_writeoff);
          // return AREK RECURSIVE;
        }
      }
    }

    public function check_aas(){
      $document_type = $this->input->post("document_type");

      $qmr_type = $this->db->query("SELECT * FROM m_material_request_type WHERE id = '".$document_type."'");
      $query_modul = $this->db->query("SELECT * FROM m_approval_modul WHERE id = '".$qmr_type->row()->modul."'");
      $count_aas = $this->db->query("SELECT count(1) as count FROM m_approval_rule WHERE module = '".$qmr_type->row()->modul."' AND user_roles = '22'");
      if ($count_aas->row()->count <= 0) {
        echo "0";
      } else {
        echo "1";
      }
    }

    public function requestJDEQtyonHand($wh, $semic_no)
    {
      if (strlen($wh)<12) {
        $wh = '            '.$wh;
        $wh = substr($wh,-12);
      }
        // $wh = $_GET['wh'];
        // $semic_no = $_GET['semic_no'];

        // $this->load->model('material/M_show_material', 'material');
        //
        // $id_item = $this->material->showItem($semic_no);


        $ch = curl_init('https://10.1.1.94:91/PD910/InventoryManager');
        //$ch = curl_init('https://10.1.1.94:91/PD910/V41021A_SelectMgr');
        $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:orac="http://oracle.e1.bssv.JP410000/">
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
      <orac:getCalculatedAvailability>
         <branchPlantList>'.$wh.'</branchPlantList>
         <itemPrimary>'.$semic_no.'</itemPrimary>
      </orac:getCalculatedAvailability>
   </soapenv:Body>
</soapenv:Envelope>';
        /**$xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:orac="http://oracle.e1.bssv.JP574102/">
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
      <orac:V41021A_SelectMgr>
         <!--Optional:-->

         <!--Optional:-->
         <costCenter>'.$wh.'</costCenter>
         <!--Optional:-->
         <identifierShortItem>
            <!--Optional:-->
            <!--<currencyCode>?</currencyCode>
-->
            <!--<currencyDecimals>?</currencyDecimals>-->
            <!--Optional:-->
            <value>'.$semic_no.'</value>
         </identifierShortItem>
         <!--Optional:-->
         <!--<location>?</location>
-->
      </orac:V41021A_SelectMgr>
   </soapenv:Body>
</soapenv:Envelope>';**/
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

        $data_curl = curl_exec($ch);
        curl_close($ch);

        if (strpos($data_curl, 'HTTP/1.1 200 OK') !== false) {
          //return true;
            $itemNumber = "0";
            $itemOrder = "0";
            if (strpos($data_curl,'<totalQtyAvailable>') !== false) {
                $itemNumber = substr($data_curl,strpos($data_curl,'<totalQtyAvailable>')+19,((strpos($data_curl,'</totalQtyAvailable>'))-(strpos($data_curl,'<totalQtyAvailable>')+19)));
            }

            /**
            if (strpos($data_curl,'<qtyOnHandPrimaryUn>') !== false) {
                $data_onhand = substr($data_curl,strpos($data_curl,'<qtyOnHandPrimaryUn>')+20,((strpos($data_curl,'</qtyOnHandPrimaryUn>'))-(strpos($data_curl,'<qtyOnHandPrimaryUn>')+20)));
                if (strpos($data_onhand,'<value>') !== false) {
                    $itemNumber = substr($data_onhand,strpos($data_onhand,'<value>')+7,((strpos($data_onhand,'</value>'))-(strpos($data_onhand,'<value>')+7)));
                }
            }

            if (strpos($data_curl,'<qtyOnPurchaseOrderPr>') !== false) {
                $data_onorder = substr($data_curl,strpos($data_curl,'<qtyOnPurchaseOrderPr>')+22,((strpos($data_curl,'</qtyOnPurchaseOrderPr>'))-(strpos($data_curl,'<qtyOnPurchaseOrderPr>')+22)));
                if (strpos($data_onorder,'<value>') !== false) {
                    $itemOrder = substr($data_onorder,strpos($data_onorder,'<value>')+7,((strpos($data_onorder,'</value>'))-(strpos($data_onorder,'<value>')+7)));
                }
            }**/

            $result = array("qty_onhand"=>$itemNumber,"qty_onorder"=>$itemOrder);
        }else{
            $result = array("qty_onhand"=>"0","qty_onorder"=>"0");
          //return false;
        }

        return $result;
    }

    public function aas_aas($id, $val){
      $dt_array = array();
      $from_company = '100101';

      $writeoff = $this->tjabatan_wo($id, $val);
      $qaas_1 = $this->db->query("SELECT a.id, a.user_id, b.NAME, a.title, a.golongan, a.position, a.nominal, a.nominal_writeoff FROM t_jabatan a JOIN m_user b ON b.ID_USER=a.user_id WHERE a.user_id='".$writeoff->user_id."'");

      $aas2 = $this->db->query("SELECT a.id, a.user_id, b.NAME FROM t_jabatan a JOIN m_user b ON b.ID_USER=a.user_id WHERE a.golongan = '".$writeoff->golongan."' AND nominal_writeoff = '".$writeoff->nominal_writeoff."' AND a.user_id != '".$qaas_1->row()->user_id."' ");

      foreach ($aas2->result_array() as $key => $value) {
        $dt_array = array(
          'aas1' => $qaas_1->result_array(),
          'aas2' => $value,
          'wo' => $writeoff,
          'aas' => $writeoff->user_id,
        );
      }

      echo json_encode($dt_array);
    }


}
