<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mregist_approval extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('material/M_mregist_approval')->model('vendor/M_vendor')->model('material/M_registration');
        $this->load->helper(array('string', 'text'));
        $this->load->helper('helperx_helper');
    }


    public function index(){
      $tamp = $this->M_mregist_approval->show();
      $get_menu = $this->M_vendor->menu();
      $get_uom = $this->M_mregist_approval->material_uom();
      $get_mgroup = $this->M_mregist_approval->material_group();
      $get_mindicator = $this->M_mregist_approval->material_indicator();
      $get_mstockclass = $this->M_mregist_approval->m_material_stock_class();
      $get_mavailable = $this->M_mregist_approval->m_material_availability();
      $get_mcritical = $this->M_mregist_approval->m_material_cricatility();
      $get_hazardous = $this->M_mregist_approval->m_hazardous();
      $get_gl_class = $this->M_mregist_approval->m_gl_class();
      $get_project_phase = $this->M_mregist_approval->m_project_phase();
      $get_line_type = $this->M_mregist_approval->m_line_type();
      $get_stocking_type = $this->M_mregist_approval->m_stocking_type();
      $get_stock_class = $this->M_mregist_approval->m_stock_class();
      $get_inventory_type = $this->M_mregist_approval->m_inventory_type();

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
          'material_desc' => $arr['DESCRIPTION'],
          'type' => $arr['TYPE'],
        );
      }

      foreach ($get_uom as $arr) {
        $res_uom[] = array(
          'id' => $arr['ID'],
          'material_uom' => $arr['MATERIAL_UOM'],
          'uom_desc' => $arr['DESCRIPTION'],
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
      $data['hazardous'] = $get_hazardous;
      $data['gl_class'] = $get_gl_class;
      $data['project_phase'] = $get_project_phase;
      $data['line_type'] = $get_line_type;
      $data['stocking_type'] = $get_stocking_type;
      $data['stock_class'] = $get_stock_class;
      $data['inventory_type'] = $get_inventory_type;
      $data['menu'] = $dt;
      $this->template->display('material/V_mregist_approval', $data);
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function datatable_logistic_specialist() {
      $data = $this->M_mregist_approval->get_list();
      $result = array();
      $no = 1;

      foreach ($data as $arr) {
        if (strpos($arr['description'], "DATA DITOLAK") === FALSE) {
          // $str = '<center><button data-id="'.$arr['material_id'].'" data-name="'.$arr['id'].'" data-status="'.$arr['description'].'" id="prosesreq" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-info" title="Update"><i class=""> Detail</i></button> <button data-id="'.$arr['material_id'].'" data-name="'.$arr['id'].'" data-name=" id="prosesreq" data-toggle="modal" data-target="#modal_rej" class="btn btn-sm btn-danger" title="Update"><i class=""> Reject</i></button></center>';
          $str = '<center><button data-id="'.$arr['material_id'].'" data-name="'.$arr['id'].'" data-status="'.$arr['description'].'" id="prosesreq" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-info" title="Update"><i class=""> Detail</i></button> </center>';
          $class = 'success';
        } else {
          $str = '<center><button data-id="'.$arr['material_id'].'" data-name="'.$arr['id'].'" data-status="'.$arr['description'].'" id="prosesreq" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-info" title="Update"><i class=""> Detail</i></button> </center>';
          $class = 'danger';
        }

        if (($arr['sequence'] == 2 && $arr['status_approve'] == 0) || $arr['sequence'] > 2 ) {
          $result[] = array(
            0 => $no,
            1 => $arr['request_no'],
            2 => $arr['material_name'],
            3 => (strcmp($arr['spec_uom'], '') == 0 ? $arr['user_uom'] : $arr['spec_uom']),
            4 => $arr['role'],
            5 => $arr['description'],
            6 => $str,
          );
          $no++;
        }

      }
      // $result['sequence'] = $data[0]['sequence'];
      echo json_encode($result);
    }

    public function request_sequence_id(){
      $get_sequence = (!empty($_POST['get_sequence'])?$_POST['get_sequence']:"");
      $data = $this->M_mregist_approval->datatable_logistic_specialist($get_sequence);
      $result = array();
      $result['sequence'] = $data[0]['sequence'];
      $result['email_approve'] = $data[0]['email_approve'];
      $result['email_reject'] = $data[0]['email_reject'];
      $result['edit_content'] = $data[0]['edit_content'];
      $result['reject_step'] = $data[0]['reject_step'];

      $query = $this->db->query("select u.*,u.roles,b.user_roles as recipient,email_approve,n.open_value from t_approval_material m
      join m_notic n on n.id=m.email_approve
      join ( select material_id,user_roles from t_approval_material where sequence=".$data[0]['sequence']."+1) b on b.material_id=m.material_id
      join m_user u on u.roles like CONCAT('%', b.user_roles ,'%')
      where m.sequence= '".$data[0]['sequence']."' and m.material_id = '".$data[0]['material_id']."' ");
      if ($query->num_rows() > 0) {
        $result['count_sequence'] = 1;
      } else {
        $result['count_sequence'] = 0;
      }

      echo json_encode($result);
    }

    public function material_equipment_group(){
      $idx = (!empty($_GET['idx'])?$_GET['idx']:"");
      $data = $this->M_mregist_approval->material_equipment_group($idx);
      if ($idx != "") {
        // print_r($data);
        echo '<option value="">Please Select</option>';
        foreach ($data as $arr) {
          echo '<option value="'.$arr['ID'].'">'.$arr['MATERIAL_GROUP'].'. '.$arr['DESCRIPTION'].'</option>';
        }
      } else {
          echo '<option value="">No Data Found</option>';
      }
    }

    public function material_classification_group(){
      $idx = (!empty($_GET['idx'])?$_GET['idx']:"");
      $data = $this->M_mregist_approval->material_classification_group($idx);
      $result = array();
      if ($idx != "") {
        foreach ($data as $arr) {
          $result['mgroup'] = $arr;
        }
      } else {
          $result['mgroup'] = false;
      }
      echo json_encode($result);
    }

    public function get_data_requestor(){
      $idnya = (!empty($_POST["idnya"])?$_POST["idnya"]:"");
      $data = $this->M_mregist_approval->get_data_requestor($idnya);
      $respon = array();

      foreach ($data as $arr) {
        $seq = $this->M_mregist_approval->get_cur_seq_list($arr['MATERIAL']);
        $respon[] = array(
          'material' => $arr['MATERIAL'],
          'edit_content' => $seq[0]['edit_content'],
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
          'data2' => $arr
        );
      }
      echo json_encode($respon, JSON_PRETTY_PRINT);
    }

    public function minta_manufacturer(){
      $term = (!empty($_GET['term'])?$_GET['term']:"");
      $respon = array();
      $result = $this->M_mregist_approval->material_group_manufacturer($term);
      foreach ($result as $arr) {
        $respon[] = array(
          'value' => $arr['MANUFACTURER'],
          'label' => $arr['MANUFACTURER'].", ".$arr['MANUFACTURER_DESCRIPTION'],
          'material_group' => $arr['MANUFACTURER_DESCRIPTION']
        );
      }
      echo json_encode($respon, JSON_PRETTY_PRINT);
    }

    public function minta_material_modeltype(){
      $term = (!empty($_GET['term'])?$_GET['term']:"");
      $respon = array();
      $result = $this->M_mregist_approval->material_group_modeltype($term);
      foreach ($result as $arr) {
        $respon[] = array(
          'value' => $arr['MATERIAL_TYPE'],
          'label' => $arr['MATERIAL_TYPE'].", ".$arr['MATERIAL_TYPE_DESCRIPTION'],
          'material_type' => $arr['MATERIAL_TYPE_DESCRIPTION']
        );
      }
      echo json_encode($respon, JSON_PRETTY_PRINT);
    }

    public function minta_material_sequence(){
      $term = (!empty($_GET['term'])?$_GET['term']:"");
      $respon = array();
      $result = $this->M_mregist_approval->material_sequence($term);
      foreach ($result as $arr) {
        $respon[] = array(
          'value' => $arr['SEQUENCE_GROUP'],
          'label' => $arr['SEQUENCE_GROUP'].", ".$arr['SEQUENCE_GROUP_DESCRIPTION'],
          'material_type' => $arr['SEQUENCE_GROUP_DESCRIPTION']
        );
      }
      echo json_encode($respon, JSON_PRETTY_PRINT);
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

    public function get_email_dest($id) {
        $qry=$this->db->select("TITLE,OPEN_VALUE,CLOSE_VALUE,CATEGORY,ROLES")
                ->from("m_notic")
                ->where("ID=",$id)
                ->get();
        if ($qry->num_rows() != 0)
            return $qry->result();
        else
            return false;
    }
    // -----------------------------------------------------------------------------------

    public function save_registrasi_catalog() {
        $path_ori = "upload/MATERIAL/img/ori/";
        $path_sml = "upload/MATERIAL/img/small/";
        $path_file = "upload/MATERIAL/files/";
        $img1 = $_FILES["material_image"];
        $img2 = $_FILES["material_drawing"];
        $img3 = $_FILES["material_other"];
        $img1_res = '';
        $img2_res = '';
        $img3_res = '';
        $material = !empty($_POST['material']) ? $_POST['material'] : "";
        $result = $this->M_mregist_approval->get_cur_seq($material);
        $sequence_id = $result[0]['sequence'];
        $mat_name = (!empty($_POST['m_name']) ? $_POST['m_name'] : "");
        $mat_code = (!empty($_POST['semic_no']) ? $_POST['semic_no'] : "");

        if ($result !== false) {
            if ($result[0]['edit_content'] == 1) {
              $array_data = array(
                  'SEARCH_TEXT' => (!empty($_POST['search_text']) ? $_POST['search_text'] : ""),
                  'MATERIAL_NAME'=> $mat_name,
                  'MATERIAL_CODE' => $mat_code,
                  'SEMIC_MAIN_GROUP' => (!empty($_POST['semic_group']) ? $_POST['semic_group'] : ""),
                  "SHORTDESC" => (!empty($_POST['m_short_desc']) ? $_POST['m_short_desc'] : ""),
                  "DESCRIPTION" => (!empty($_POST['m_desc']) ? $_POST['m_desc']:""),
                  "UOM" => (!empty($_POST['m_uom']) ? $_POST['m_uom'] : ""),
                  'DESCRIPTION1'=> (!empty($_POST['m_desc']) ? $_POST['m_desc']:""),
                  'UOM1'=> (!empty($_POST['m_uom']) ? $_POST['m_uom'] : ""),
                  'EQPMENT_NO'=> (!empty($_POST['equipment_no'])?$_POST['equipment_no']:""),
                  'EQPMENT_ID'=> (!empty($_POST['equipment_id'])?$_POST['equipment_id']:""),
                  'MANUFACTURER'=> (!empty($_POST['no_manufacturer'])?$_POST['no_manufacturer']:""),
                  'MANUFACTURER_DESCRIPTION'=> (!empty($_POST['name_manufacturer'])?$_POST['name_manufacturer']:""),
                  'MATERIAL_TYPE'=> (!empty($_POST['model_type_no'])?$_POST['model_type_no']:""),
                  'MATERIAL_TYPE_DESCRIPTION'=> (!empty($_POST['model_type_name'])?$_POST['model_type_name']:""),
                  // 'SEQUENCE_ID'=> (!empty($_POST['sequence_id'])?$_POST['sequence_id']:""),
                  // 'SEQUENCE_GROUP'=> (!empty($_POST['squence_group_no'])?$_POST['squence_group_no']:""),
                  // 'SEQUENCE_GROUP_DESCRIPTION'=> (!empty($_POST['squence_group_name'])?$_POST['squence_group_name']:""),
                  // 'INDICATOR'=> (!empty($_POST['material_indicator']) ? $_POST['material_indicator'] : ""),
                  // 'INDICATOR_DESCRIPTION'=> (!empty($_POST['material_indicator_desc']) ? $_POST['material_indicator_desc'] : ""),
                  'STOCK_CLASS'=> (!empty($_POST['stock_class']) ? $_POST['stock_class'] : ""),
                  'AVAILABILITY'=> (!empty($_POST['available']) ? $_POST['available'] : ""),
                  'CRITICALITY'=> (!empty($_POST['critical']) ? $_POST['critical'] : ""),
                  'PART_NO'=> (!empty($_POST['part_no'])?$_POST['part_no']:""),
                  // 'CREATE_BY'=> $this->session->userdata['ID_USER'],
                  'CREATE_TIME'=> date("Y-m-d H:i:s"),
                  // 'EDIT_CONTENT'=> (!empty($_POST['edit_content']) ? $_POST['edit_content'] : ""),
                  'COLLUQUIALS' => (!empty($_POST['colluquials']) ? $_POST['colluquials'] : ""),
                  'TYPE' => (!empty($_POST['m_type']) ? $_POST['m_type'] : ""),
                  'SERIAL_NUMBER' => (!empty($_POST['serial_number']) ? $_POST['serial_number'] : ""),
                  'GL_CLASS' => (!empty($_POST['gl_class']) ? $_POST['gl_class'] : ""),
                  'LINE_TYPE' => (!empty($_POST['line_type']) ? $_POST['line_type'] : ""),
                  'STOCKING_TYPE' => (!empty($_POST['stocking_type']) ? $_POST['stocking_type'] : ""),
                  'PROJECT_PHASE' => (!empty($_POST['project_phase']) ? $_POST['project_phase'] : ""),
                  'INVENTORY_TYPE' => (!empty($_POST['inventory_type']) ? $_POST['inventory_type'] : ""),
                  'MONTHLY_USAGE' => (!empty($_POST['monthly_usage']) ? $_POST['monthly_usage'] : ""),
                  'ANNUAL_USAGE' => (!empty($_POST['annual_usage']) ? $_POST['annual_usage'] : ""),
                  'INITIAL_ORDER_QTY' => (!empty($_POST['initial_order_qty']) ? $_POST['initial_order_qty'] : ""),
                  'EXPL_ELEMENT' => (!empty($_POST['expl_element']) ? $_POST['expl_element'] : ""),
                  'UNIT_OF_ISSUE' => (!empty($_POST['unit_of_issue']) ? $_POST['unit_of_issue'] : ""),
                  'ESTIMATE_VALUE' => (!empty($_POST['estimate_value']) ? $_POST['estimate_value'] : ""),
                  'SHELF_LIFE' => (!empty($_POST['shelf_life']) ? $_POST['shelf_life'] : ""),
                  'CROSS_RERERENCE' => (!empty($_POST['cross_rererence']) ? $_POST['cross_rererence'] : ""),
                  'HAZARDOUS' => (!empty($_POST['hazardous']) ? $_POST['hazardous'] : ""),
                  'GROUP_CLASS' => (!empty($_POST['group_class']) ? $_POST['group_class'] : ""),
                  'MNEMONIC' => (!empty($_POST['mnemonic']) ? $_POST['mnemonic'] : ""),
                  'ITEM_NAME_CODE' => (!empty($_POST['item_name_code']) ? $_POST['item_name_code'] : ""),
                  'PREFERENCE' => (!empty($_POST['preference']) ? $_POST['preference'] : ""),
                  'ITEM_NAME' => (!empty($_POST['item_name']) ? $_POST['item_name'] : ""),
                  'PART_NUMBER' => (!empty($_POST['part_number']) ? $_POST['part_number'] : ""),
                  'STOCK_CODE_NO' => (!empty($_POST['stock_code_no']) ? $_POST['stock_code_no'] : ""),
                  'PART_STATUS' => (!empty($_POST['part_status']) ? $_POST['part_status'] : ""),
                  'STOCK_TYPE' => (!empty($_POST['stock_type']) ? $_POST['stock_type'] : ""),
                  'ITEM_OWNERSHIP' => (!empty($_POST['item_ownership']) ? $_POST['item_ownership'] : ""),
                  'ROP' => (!empty($_POST['rop']) ? $_POST['rop'] : ""),
                  'STATISTIC_CODE' => (!empty($_POST['statistic_code']) ? $_POST['statistic_code'] : ""),
                  'ROQ' => (!empty($_POST['roq']) ? $_POST['roq'] : ""),
                  'UNIT_OF_PURCHASE' => (!empty($_POST['unit_of_purchase']) ? $_POST['unit_of_purchase'] : ""),
                  'MIN' => (!empty($_POST['min']) ? $_POST['min'] : ""),
                  'UNIT_OF_ISSUE2' => (!empty($_POST['unit_of_issue2']) ? $_POST['unit_of_issue2'] : ""),
                  'ORIGIN_CODE' => (!empty($_POST['origin_code']) ? $_POST['origin_code'] : ""),
                  'CONV_FACT' => (!empty($_POST['conv_fact']) ? $_POST['conv_fact'] : ""),
                  'TARIFF_CODE' => (!empty($_POST['tariff_code']) ? $_POST['tariff_code'] : ""),
                  'STD_PACK' => (!empty($_POST['std_pack']) ? $_POST['std_pack'] : ""),
                  'SUPPLIER_NUMBER' => (!empty($_POST['supplier_number']) ? $_POST['supplier_number'] : ""),
                  'UNIT_PRICE' => (!empty($_POST['unit_price']) ? $_POST['unit_price'] : ""),
                  'FPA' => (!empty($_POST['fpa']) ? $_POST['fpa'] : ""),
                  'FREIGHT_CODE' => (!empty($_POST['freight_code']) ? $_POST['freight_code'] : ""),
                  'LEAD_TIME' => (!empty($_POST['lead_time']) ? $_POST['lead_time'] : ""),
                  'INSPECTION_CODE' => (!empty($_POST['inspection_code']) ? $_POST['inspection_code'] : ""),
              );

              if ($img1['error'] != 4 && $img1['tmp_name'] !== '') {
                  $img1_res = image_upload($img1["tmp_name"], $img1["name"], $img1["type"], $img1["size"], $path_ori, $path_sml);
                  $array_data["IMG1_URL"] = $img1_res;
                  $array_data["IMG3_URL"] = $img1_res;
              }

              if ($img2['error'] != 4 && $img2['tmp_name'] !== '') {
                  $img2_res = image_upload($img2["tmp_name"], $img2["name"], $img2["type"], $img2["size"], $path_ori, $path_sml);
                  $array_data["IMG2_URL"] = $img2_res;
                  $array_data["IMG4_URL"] = $img2_res;
              }

              if ($img3['error'] != 4 && $img3['tmp_name'] !== '') {
                  $img3_res = file_uploads($img3["tmp_name"], $img3["name"], $img3["type"], $img3["size"], $path_file, $path_file);
                  $array_data["FILE_URL"] = $img3_res;
                  $array_data["FILE_URL2"] = $img3_res;
              }

              $result = $this->M_mregist_approval->save_registrasi_cataloguing($array_data, $material, 1, $sequence_id);
          } else {
              // update dt
              $array_data = array();
              $result = $this->M_mregist_approval->save_registrasi_cataloguing($array_data, $material, 0, $sequence_id);
          }

        // $result = true;
        if ($result == true) {
          ini_set('max_execution_time', 500);
          $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
          $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";

          $query = $this->db->query("select DISTINCT u.*,u.roles,b.user_roles as recipient,email_approve,n.open_value from t_approval_material m
          join m_notic n on n.id=m.email_approve
          join ( select id_user, material_id,user_roles, sequence as seq from t_approval_material where sequence=".$sequence_id."+1) b
						on b.material_id='".$material."' and b.seq = ".$sequence_id."+1 and m.sequence = b.seq
          join m_user u on u.roles like CONCAT('%', b.user_roles ,'%') AND u.ID_USER LIKE b.id_user
          where m.material_id = '".$material."' ");
          if ($query->num_rows() > 0) {
            $data_role = $query->result();
            $count = 1;
          } else {
            $query2 = $this->db->query("select min(sequence) as sequence, u.EMAIL, '20' as email_approve, v.email_reject, m.material_id, m.approve_by
            FROM t_approval_material m
            JOIN m_user u ON u.ID_USER=m.approve_by
            LEFT JOIN (SELECT sequence as seq, email_approve, email_reject, material_id FROM t_approval_material ) v ON v.material_id = '".$material."' AND v.seq = '".$sequence_id."'
            WHERE m.material_id = '".$material."' and m.sequence = '1' GROUP BY sequence, u.EMAIL, email_approve, v.email_reject, m.material_id, m.approve_by
            UNION
            select min(sequence) as sequence, u.EMAIL, '20' as email_approve, v.email_reject, m.material_id, m.approve_by
            FROM t_approval_material m
            JOIN m_user u ON u.ID_USER=m.approve_by
            LEFT JOIN (SELECT sequence as seq, email_approve, email_reject, material_id FROM t_approval_material ) v ON v.material_id = '".$material."' AND v.seq = '2'
            WHERE m.material_id = '".$material."' and m.sequence = '2' GROUP BY sequence, u.EMAIL, email_approve, v.email_reject, m.material_id, m.approve_by
             ");


            $data_role = $query2->result();
            $count = 0;
          }

          $resultExec = 0;
          // jika max sequence tidak ada
          if ($count == 0) {
            $data_jde = array(
                'MATERIAL_NAME' => stripslashes($mat_name),
                'DESCRIPTION' => stripslashes($_POST['m_desc']),
                'MATERIAL_CODE' => stripslashes($mat_code), //id angka
                'ID' => stripslashes($material),
                'UOM' => stripslashes($_POST['m_uom'])
            );

            $datas['doc_no'] = stripslashes($material);
            $datas['doc_type'] = 'm_reg';
            $datas['isclosed'] = 0;
            $this->db->insert('i_sync',$datas);

           $toJDE = true;
           if ($toJDE) {
             $resultExec = 1;
           } else {
             $resultExec = 2;
           }

           if ($resultExec == 2) {
             $result = $this->M_mregist_approval->rollback_apprvl($material);
           }

           if ($resultExec == 1) {
             $content = $this->M_mregist_approval->get_email_dest($data_role[0]->email_approve);
             $res = $data_role;

             $str = '
             <br>
             SEMIC Code : '.$mat_code.' <br>
             Nama Material : '.$mat_name.' <br>
             ';

             $data = array(
                 'img1' => $img1,
                 'img2' => $img2,
                 'title' => $content[0]->TITLE,
                 'open' => str_replace("deskripsinya", $str, $content[0]->OPEN_VALUE),
                 'close' => $content[0]->CLOSE_VALUE
             );
             // foreach ($data_role as $k => $v) {
             //     $data['dest'][] = $v->EMAIL;
             // }
             $arr_s = array();
             foreach ($data_role as $email) {
                $arr_s[] = $email->EMAIL;
             }
             $unique_data = array_unique($arr_s);
             // now use foreach loop on unique data
             foreach($unique_data as $val) {
               $data['dest'][] = $val;
             }
             $flag = $this->sendMail($data);
           }
         }

         // jika max sequence ada
         if ($count == 1) {
           $content = $this->M_mregist_approval->get_email_dest($data_role[0]->email_approve);
           $res = $data_role;

           $str = '
           SEMIC : '.$mat_code.'<br>
           Nama material : '.$mat_name.'<br>
           UOM : '.$_POST['m_uom'].'<br>
           Deskripsi : '.$_POST['m_desc'].'<br>
           ';

           $data = array(
               'img1' => $img1,
               'img2' => $img2,
               'title' => $content[0]->TITLE,
               'open' => str_replace("deskripsinya", $str, $content[0]->OPEN_VALUE),
               'close' => $content[0]->CLOSE_VALUE
           );
           // foreach ($data_role as $k => $v) {
           //     $data['dest'][] = $v->EMAIL;
           // }

           $arr_s = array();
           foreach ($data_role as $email) {
              $arr_s[] = $email->EMAIL;
           }
           $unique_data = array_unique($arr_s);
           // now use foreach loop on unique data
           foreach($unique_data as $val) {
             $data['dest'][] = $val;
           }

           $flag = $this->sendMail($data);
          }

          if ($resultExec == 1 && $_POST['semic_no'] != '') {
            $this->session->set_flashdata('message', array(
              'message' => 'Registration Material Approved With SEMIC Code :'.$_POST['semic_no'],
              'type' => 'success'
            ));
          } elseif ($resultExec == 0) {
            $this->session->set_flashdata('message', array(
              'message' => __('success_approve'),
              'type' => 'success'
            ));
          } elseif ($resultExec) {
            $this->session->set_flashdata('message', array(
              'message' => 'Registration Material Is Failed - JDE ERROR, Please Try Again or Contact administrator',
              'type' => 'danger'
            ));
          } else {

          }

          $respon = array(
            'success' => true,
            'semic_no' => $_POST['semic_no'],
            'sendjde' => $resultExec,
            'count' => $count,
            'data' => $data,
            'array_data' => $array_data,
          );
        } else {
          $respon['success'] = false;
        }
      }

      echo json_encode($respon, JSON_PRETTY_PRINT);
    }

    public function get_log(){
        $idx = $this->input->post("idx");
        $data = $this->M_mregist_approval->get_log($idx);
        $no = 1;
        foreach ($data as $key => $value) {
            echo '
            <tr>
              <td>'.$no.'</td>
              <td>'.$value['NAME'].'</td>
              <td>'.$value['CREATE_TIME'].'</td>
              <td>'.$value['NOTE'].'</td>
            </tr>
            ';
            $no++;
        }
    }

    public function reject_request_material(){
      $idnya = (!empty($_POST['material_id_rej'])?$_POST['material_id_rej']:"");
      $note = (!empty($_POST['note'])?$_POST['note']:"");
      $sequence_id_rej = (!empty($_POST['sequence_id_rej'])?$_POST['sequence_id_rej']:"");
      $email_approve_rej = (!empty($_POST['email_approve_rej'])?$_POST['email_approve_rej']:"");
      $email_reject_rej = (!empty($_POST['email_reject_rej'])?$_POST['email_reject_rej']:"");
      $reject_step_rej = (!empty($_POST['reject_step_rej'])?$_POST['reject_step_rej']:"0");
      $m_approval_id = (!empty($_POST['m_approval_id'])?$_POST['m_approval_id']:"");

      $save_data = array(
        'idnya' => $idnya,
        'note' => $note,
        'user' => $this->session->userdata['ID_USER'],
        'sequence_id_rej' => $sequence_id_rej,
        'email_approve_rej' => $email_approve_rej,
        'email_reject_rej' => $email_reject_rej,
        'reject_step_rej' => $reject_step_rej,
        'm_approval_id' => $m_approval_id,
      );

      $result = $this->M_mregist_approval->reject_request_material($save_data);

      // $result = true;
      if ($note != "") {
        $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
        $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";

        $seq_now  = $sequence_id_rej - $reject_step_rej;
        if ($seq_now == 1) {
          $query = $this->db->query("select min(sequence) as sequence, u.ID_USER, u.NAME, u.EMAIL, v.email_approve, v.email_reject, m.material_id, m.approve_by
            FROM t_approval_material m
            JOIN m_user u ON u.ID_USER=m.approve_by
            LEFT JOIN (SELECT sequence as seq, email_approve, email_reject, material_id FROM t_approval_material ) v
						ON v.material_id = '".$idnya."' AND v.seq = ".$seq_now."
            WHERE m.material_id = '".$idnya."' and m.sequence = ".$seq_now."
            GROUP BY sequence, u.EMAIL, v.email_approve, v.email_reject, m.material_id, m.approve_by");
        } else {
          $query = $this->db->query("select DISTINCT u.*,u.roles,b.user_roles as recipient,email_approve,n.open_value from t_approval_material m
          join m_notic n on n.id=m.email_approve
          join ( select id_user, material_id,user_roles, sequence as seq from t_approval_material where sequence=".$seq_now.") b
						on b.material_id='".$idnya."' and b.seq = ".$seq_now." and m.sequence = b.seq
          join m_user u on u.roles like CONCAT('%', b.user_roles ,'%') AND u.ID_USER LIKE b.id_user
          where m.material_id = '".$idnya."'");
        }
        $data_role = $query->result();

        $content = $this->M_mregist_approval->get_email_dest($email_reject_rej);
        $show_material = $this->M_mregist_approval->show('MATERIAL = '.$idnya);

        $res = $data_role;
        $str = '
        Nama material : '.$show_material[0]->MATERIAL_NAME.'<br>
        UOM : '.$show_material[0]->UOM.'<br>
        Catatan : '.$note.'<br>
        ';
        // $str = 'Catatan: '.$note.'<br>';

        $data = array(
            'img1' => $img1,
            'img2' => $img2,
            'title' => $content[0]->TITLE,
            'open' => str_replace("deskripsinya", $str, $content[0]->OPEN_VALUE),
            'close' => $content[0]->CLOSE_VALUE
        );

        // foreach ($res as $k => $v) {
        //     $data['dest'][] = $v->EMAIL;
        // }
        $arr_s = array();
        foreach ($data_role as $email) {
           $arr_s[] = $email->EMAIL;
        }
        $unique_data = array_unique($arr_s);
        // now use foreach loop on unique data
        foreach($unique_data as $val) {
          $data['dest'][] = $val;
        }
        $flag = $this->sendMail($data);
        $respon = true;
      } else {
        $respon = false;
      }
      echo json_encode($respon, JSON_PRETTY_PRINT);
    }

    public function material_clasification_group(){
      $idx = (!empty($_GET['idx'])?$_GET['idx']:"");
      $data = $this->M_registration->material_clasification_group($idx);

      $data_semic_grp = $this->M_mregist_approval->material_semic_main_group($idx);

      $result = array();
      if ($idx != "") {
        foreach ($data as $arr) {
          $result['mgroup'] = $arr;
        }
        foreach ($data_semic_grp as $key) {
          $result['semic_main_group'] = $key;
        }
      } else {
          $result['mgroup'] = false;
      }
      echo json_encode($result);
    }


      public function change_jde($data) {
        ini_set('max_execution_time', 300);
        $ch = curl_init('https://10.1.1.94:91/PD910/InventoryManager?WSDL');
        $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:orac="http://oracle.e1.bssv.JP410000/">
              <soapenv:Header>
                  <wsse:Security
                      xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
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
                  <orac:processInventoryItem>
                   <!--Optional:-->
                   <daysShelfLife>25</daysShelfLife>
                   <!--Optional:-->
                   <description1>' . $data['MATERIAL_NAME'] . '</description1>
                   <!--Optional:-->
                   <description2>' . $data['MATERIAL_NAME'] . '</description2>
                   <!--Optional:-->
                   <glClassCode>IN50</glClassCode>
                   <!--Optional:-->
                   <item>
                    <!--Optional:-->
                    <itemCatalog>' . $data['MATERIAL_CODE'] . '</itemCatalog>
                    <!--Optional:-->
                    <!--<itemFreeForm>?</itemFreeForm>-->
                    <!--Optional:-->
                    <itemId>' . $data['ID'] . '</itemId>
                    <!--Optional:-->
                    <!--<itemProduct>?</itemProduct>-->
                    <!--Optional:-->
                    <!--<itemSupplier>?</itemSupplier>-->>
                   </item>
                   <!--Optional:-->
                   <itemDimensions>
                    <!--Optional:-->
                    <unitOfMeasureCodePrimary>' . $data['UOM'] . '</unitOfMeasureCodePrimary>
                    <!--Optional:-->
                    <unitOfMeasureCodeVolume>' . $data['UOM'] . '</unitOfMeasureCodeVolume>
                    <!--Optional:-->
                    <unitOfMeasureCodeWeight>' . $data['UOM'] . '</unitOfMeasureCodeWeight>
                   </itemDimensions>
                   <!--Optional:-->
                   <lineTypeCode>S</lineTypeCode>
                   <!--Optional:-->
                   <!--<lotProcessCode>?</lotProcessCode>-->
                   <!--Optional:-->
                   <!--<lotStatusCode>?</lotStatusCode>-->
                   <!--Optional:-->
                   <processing>
                    <!--Optional:-->
                    <actionTypeCode>A</actionTypeCode>
                    <!--Optional:-->
                    <version>ZJDE001</version>
                   </processing>
                   <searchText>' . $data['SEARCH_TEXT'] . '</searchText>
                   <searchTextCompressed>' . $data['MATERIAL_NAME'] . '</searchTextCompressed>
                   <!--Optional:-->
                   <serialNumberFlag>N</serialNumberFlag>
                   <!--Optional:-->
                   <stockingTypeCode>S</stockingTypeCode>
                  </orac:processInventoryItem>
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

        $data_curl = curl_exec($ch);
        curl_close($ch);

    if (strpos($data_curl, 'HTTP/1.1 200 OK') !== false) {
      $itemNumber = substr($data_curl,strpos($data_curl,'<itemId>')+8,((strpos($data_curl,'</itemId>'))-(strpos($data_curl,'<itemId>')+8)));

        $text = strip_tags($data['DESCRIPTION']);

        $str = '';
        $str2 = ' ';
        if(strlen($text)>500){
        $text = substr($text,0,500);
        $arr =  explode(" ", $text);

        //print all the value which are in the array
        foreach($arr as $v){
          if(strlen($str)<225){
          $str = $str .' '. $v;
          }else{
          $str2 = $str2 .' '. $v;
          }
        }

            }else{
            $str = $text;
            }

            // Insert Long description
            $ch = curl_init('https://10.1.1.94:91/PD910/F4101_UpdateMgr?WSDL');
        $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:orac="http://oracle.e1.bssv.JP554101/">
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
      <orac:AddF554101>
         <NODETEXT>'.$str.'</NODETEXT>
         <NOTES>'.$str2.'</NOTES>
         <identifierShortItem>
            <value>'.$itemNumber.'</value>
         </identifierShortItem>
      </orac:AddF554101>
   </soapenv:Body>
</soapenv:Envelope>
';
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
              $query_update = $this->db->query("update i_sync set isclosed=1,updatedate=now() where doc_type='m_reg' and doc_no='".$req_no."' and isclosed=0");
              }else{
                echo "Gagal Exec JDE M REG LONG DESC -  Doc No ".$req_no." at ".date("Y-m-d H:i:s");
              }
          }else{
            echo "Gagal Exec JDE MR REG -  Doc No ".$req_no." at ".date("Y-m-d H:i:s");
          }

        // }else{
        //   echo "Execution - M Reg at ".date("Y-m-d H:i:s");
        // }
        echo $xml_post_string;
        $data_log['script_type'] = 'm_reg';
        $this->db->insert('i_sync_log',$data_log);
        $this->db->close();
    }




    public function requestJDE_insertMaterialCategory() {
        ini_set('max_execution_time', 300);
        error_reporting(0);
        ini_set('display_errors', 0);
        $req_no = "";
        $result = true;
        $query_check_out = $this->db->query("select doc_no from i_sync where doc_type='m_reg_cat' and isclosed=0 limit 1");
        if($query_check_out->num_rows()>0){
            $result_check = $query_check_out->result();
            $req_no = $result_check[0]->doc_no;

            $query_select_mat = $this->db->query("SELECT g.PARENT,LEFT(m.MATERIAL_CODE,2) as MAIN_GROUP,m.* FROM m_material m
JOIN m_material_group g on g.MATERIAL_GROUP=CAST(LEFT(m.MATERIAL_CODE,2) as SIGNED) AND g.TYPE='GOODS'
where MATERIAL='".$req_no."' ");
            $res = $query_select_mat->result();


            $ch = curl_init('https://10.1.1.94:91/PD910/F4101_UpdateMgr?WSDL');
        $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:orac="http://oracle.e1.bssv.JP574101/">
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
      <orac:Update_CatCode>
         <identifier2ndItem>'.$res[0]->MATERIAL_CODE.'</identifier2ndItem>
         <!--Optional:-->
         <salesReportingCode10>'.$res[0]->MAIN_GROUP.'</salesReportingCode10>
         <!--Optional:-->
         <salesReportingCode6>'.$res[0]->PARENT.'</salesReportingCode6>
         <!--Optional:-->
         <salesReportingCode7>'.$res[0]->INVENTORY_TYPE.'</salesReportingCode7>
         <!--Optional:-->
         <salesReportingCode8>'.$res[0]->CRITICALITY.'</salesReportingCode8>
         <!--Optional:-->
         <salesReportingCode9>'.$res[0]->PROJECT_PHASE.'</salesReportingCode9>
         <!--Optional:-->
         <searchText>'.$res[0]->SEARCH_TEXT.'</searchText>
         <unitOfMeasurePurchas>'.$res[0]->UNIT_OF_ISSUE.'</unitOfMeasurePurchas>

         <!--<unitOfMeasureSecondary>?</unitOfMeasureSecondary>
         <unitOfMeasureVolume>?</unitOfMeasureVolume>
         <unitOfMeasureWeight>?</unitOfMeasureWeight>
-->
      </orac:Update_CatCode>
   </soapenv:Body>
</soapenv:Envelope>
';
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
          $query_update = $this->db->query("update i_sync set isclosed=1,updatedate=now() where doc_type='m_reg_cat' and doc_no='".$req_no."' and isclosed=0");
          }else{
            echo "Gagal Exec JDE MR CAT CODE -  Doc No ".$req_no." at ".date("Y-m-d H:i:s");
          }
        }else{
          echo "Execution - M Cat Code at ".date("Y-m-d H:i:s");
        }
        echo $xml_post_string;
        $data_log['script_type'] = 'm_reg_cat';
        $this->db->insert('i_sync_log',$data_log);
        $this->db->close();
    }


    public function requestJDE_insertMaterial() {
      ini_set('max_execution_time', 300);
      error_reporting(0);
      ini_set('display_errors', 0);
      $req_no = "";
      $result = true;
      $query_check_out = $this->db->query("select doc_no from i_sync where doc_type='m_reg' and isclosed=0 limit 1");
      if($query_check_out->num_rows()>0){
        $result_check = $query_check_out->result();
        $req_no = $result_check[0]->doc_no;

        $m_mat_header = $this->db->query("SELECT g.code as glClassCode,m.*, l.code as LINE_TYPE_CODE, s.code as STOCKING_TYPE_NAME FROM m_material m join m_gl_class g on g.id=m.gl_class join m_line_type l ON l.id=m.LINE_TYPE join m_stocking_type s ON s.id=m.STOCKING_TYPE where m.MATERIAL='".$req_no."'");

        $res = $m_mat_header->result();

        $MATERIAL_NAME = str_replace('&','',$res[0]->MATERIAL_NAME);
        $SHORTDESC = str_replace('&','',$res[0]->SHORTDESC);

        $ch = curl_init('https://10.1.1.94:91/PD910/InventoryManager?WSDL');
        $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:orac="http://oracle.e1.bssv.JP410000/">
              <soapenv:Header>
                  <wsse:Security
                      xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
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
                  <orac:processInventoryItem>
                   <!--Optional:-->
                   <daysShelfLife>25</daysShelfLife>
                   <!--Optional:-->
                   <description1>' . $MATERIAL_NAME . '</description1>
                   <!--Optional:-->
                   <description2>' . $SHORTDESC . '</description2>
                   <!--Optional:-->
                   <glClassCode>'. $res[0]->glClassCode .'</glClassCode>
                   <!--Optional:-->
                   <item>
                    <!--Optional:-->
                    <itemCatalog>' . $res[0]->MATERIAL_CODE . '</itemCatalog>
                    <!--Optional:-->
                    <!--<itemFreeForm>?</itemFreeForm>-->
                    <!--Optional:-->
                    <itemId>' . $res[0]->MATERIAL . '</itemId>
                    <!--Optional:-->
                    <!--<itemProduct>?</itemProduct>-->
                    <!--Optional:-->
                    <!--<itemSupplier>?</itemSupplier>-->
                   </item>
                   <!--Optional:-->
                   <itemDimensions>
                    <!--Optional:-->
                    <unitOfMeasureCodePrimary>' . $res[0]->UOM . '</unitOfMeasureCodePrimary>
                    <!--Optional:-->
                    <unitOfMeasureCodeVolume>' . $res[0]->UOM . '</unitOfMeasureCodeVolume>
                    <!--Optional:-->
                    <unitOfMeasureCodeWeight>' . $res[0]->UOM . '</unitOfMeasureCodeWeight>
                   </itemDimensions>
                   <!--Optional:-->
                   <lineTypeCode>'.$res[0]->LINE_TYPE_CODE.'</lineTypeCode>
                   <!--Optional:-->
                   <!--<lotProcessCode>?</lotProcessCode>-->
                   <!--Optional:-->
                   <!--<lotStatusCode>?</lotStatusCode>-->
                   <!--Optional:-->
                   <processing>
                    <!--Optional:-->
                    <actionTypeCode>A</actionTypeCode>
                    <!--Optional:-->
                    <version>ZJDE001</version>
                   </processing>
                   <searchText>' . $res[0]->SEARCH_TEXT . '</searchText>
                   <searchTextCompressed>' . $MATERIAL_NAME . '</searchTextCompressed>
                   <!--Optional:-->
                   <serialNumberFlag>N</serialNumberFlag>
                   <!--Optional:-->
                   <stockingTypeCode>'. $res[0]->STOCKING_TYPE_NAME . '</stockingTypeCode>
                  </orac:processInventoryItem>
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
            $datas['doc_no'] = stripslashes($req_no);
            $datas['doc_type'] = 'm_reg_cat';
            $datas['isclosed'] = 0;
            $this->db->insert('i_sync',$datas);

            $datas['doc_no'] = stripslashes($req_no);
            $datas['doc_type'] = 'm_reg_long';
            $datas['isclosed'] = 0;
            $this->db->insert('i_sync',$datas);
            echo "Berhasil Exec JDE -  Doc No ".$req_no." at ".date("Y-m-d H:i:s");
            $query_update = $this->db->query("update i_sync set isclosed=1,updatedate=now() where doc_type='m_reg' and doc_no='".$req_no."' and isclosed=0");
        }else{
          echo "Gagal Exec JDE MAT REG -  Doc No ".$req_no." at ".date("Y-m-d H:i:s");
        }
        // }else{
        //   echo "Execution - M Reg at ".date("Y-m-d H:i:s");
        // }
        echo $xml_post_string;
      $data_log['script_type'] = 'm_reg';
      $this->db->insert('i_sync_log',$data_log);
    }
    $this->db->close();
  }


    public function requestJDE_insertMaterialLong() {
      error_reporting(0);
      ini_set('display_errors', 0);
      $req_no = "";
      $result = true;
      $query_check_out = $this->db->query("select doc_no from i_sync where doc_type='m_reg_long' and isclosed=0 limit 1");

      if($query_check_out->num_rows()>0){
        $result_check = $query_check_out->result();
        $req_no = $result_check[0]->doc_no;

        $m_mat_header = $this->db->query("SELECT g.code as glClassCode,m.* FROM m_material m join m_gl_class g on g.id=m.gl_class where m.MATERIAL='".$req_no."'");

        $res = $m_mat_header->result();

        $text = strip_tags($res[0]->DESCRIPTION);
        $text = htmlentities($text, null, 'utf-8');
        $text = str_replace('&nbsp;', ' ', $text);
        $text = str_replace('<', ' ', $text);
        $text = str_replace('>', ' ', $text);
        $text = html_entity_decode($text);
        $text = preg_replace('/\s|&nbsp;/',' ',$text);
        $text = str_replace('quot;','"',$text);
        $text = str_replace('&',' ',$text);

        $str = '';
        $str2 = ' ';

        if(((strlen($text)>499))||((strlen($text)>249))){
            $text = substr($text,0,499);
            $arr =  explode(' ', $text);

            //print all the value which are in the array
            foreach($arr as $v){
              if(strlen($str)<249){
                  if(($str=='')||($str==' ')){
                    $str = $v;
                  }else{
                    if((strlen($str)+strlen($v))<249){
                      $str = $str .' '. $v;
                    }else{
                      $str2 = $v;
                    }
                  }
              }else{
                  if(($str2=='')||($str2==' ')){
                    $str2 = $v;
                  }else{
                    if((strlen($str2)+strlen($v))<249){
                      $str2 = $str2 .' '. $v;
                    }
                  }
              }
            }
        }else{
          $str = $text;
        }


            // Insert Long description
            $ch = curl_init('https://10.1.1.94:91/PD910/F554101AddManager?WSDL');
        $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:orac="http://oracle.e1.bssv.JP554101/">
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
      <orac:AddF554101>
         <NODETEXT>'.$str2.'</NODETEXT>
         <NOTES>'.$str.'</NOTES>
         <identifierShortItem>
            <value>'.$res[0]->MATERIAL.'</value>
         </identifierShortItem>
      </orac:AddF554101>
   </soapenv:Body>
</soapenv:Envelope>
';
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
                echo "Berhasil Exec JDE MAT LONG -  Doc No ".$req_no." at ".date("Y-m-d H:i:s");
                 $query_update = $this->db->query("update i_sync set isclosed=1,updatedate=now() where doc_type='m_reg_long' and doc_no='".$req_no."' and isclosed=0");
              }else{
                echo "Gagal Exec JDE M REG LONG DESC -  Doc No ".$req_no." at ".date("Y-m-d H:i:s");
              }
          }else{
            echo "Gagal Exec JDE MR REG LG -  Doc No ".$req_no." at ".date("Y-m-d H:i:s");
          }
          echo $xml_post_string;

      $data_log['script_type'] = 'm_reg_long';
      $this->db->insert('i_sync_log',$data_log);
      $this->db->close();
    }


  }
