<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_material_req extends CI_Model {

  public function __construct() {
      parent::__construct();
      $this->db = $this->load->database('default', true);
  }

  public function datatable_mr() {
      if( strpos($this->session->userdata['ROLES'], ',') !== false ) {
        $roles = substr($this->session->userdata['ROLES'], 1, -1);
      } else {
        $roles = $this->session->userdata['ROLES'];
      }
      $query = $this->db->query("select DISTINCT b.user_roles, b.email_approve,b.edit_content, b.email_reject,b.sequence,b.status_approve,CASE WHEN count(j.id)>0 THEN CONCAT(b.description,' (DATA DITOLAK)') ELSE b.description END as description,b.reject_step, v.request_no, v.request_date, v.to_branch_plant, v.branch_plant, v.purpose_of_request, v.account_desc, y.description as mr_type_desc, y.doc_type
      FROM (SELECT min(id) as id, id_mr, min(sequence) as sequence FROM t_approval_material_request
                     WHERE (status_approve=2 OR status_approve=0)
                     GROUP BY id_mr
                    ) a
      JOIN t_approval_material_request b ON b.id_mr=a.id_mr AND b.id=a.id
      JOIN t_material_request v ON v.request_no=b.id_mr
      JOIN m_user_roles r ON r.ID_USER_ROLES=b.user_roles
      JOIN m_material_request_type y ON y.id=v.document_type
      LEFT JOIN t_approval_material_request j ON j.id_mr=b.id_mr AND j.status_approve=2
      WHERE v.create_by='".$this->session->userdata['ID_USER']."'
      GROUP BY b.user_roles, b.email_approve,b.edit_content, b.email_reject,b.sequence,b.status_approve, j.id, b.description,b.reject_step, v.request_no, v.request_date, v.to_branch_plant, v.branch_plant, v.purpose_of_request, v.account_desc, y.description, y.doc_type");
      return $query->result_array();
  }

  public function show_material($data = null){
    if (!empty($data)) { $id = $data; } else { $id = '10101WH01'; }
    $query = $this->db->query("SELECT a.MATERIAL_CODE,a.MATERIAL,a.MATERIAL_NAME,a.UOM,a.ITEM_COST,SUM(COALESCE(v.QTY,0)) QTY, a.STOCKING_TYPE FROM (
                SELECT k.BRANCH_PLANT,a.MATERIAL_CODE,a.MATERIAL,a.MATERIAL_NAME,a.UOM,SUM(COALESCE(ITEM_COST,0)) as ITEM_COST, a.STOCKING_TYPE  FROM m_material a
              JOIN (SELECT MAX(sequence) as max_seq, material_id FROM t_approval_material GROUP BY material_id ) cc ON cc.material_id=a.MATERIAL
              JOIN t_approval_material b ON b.material_id=cc.material_id AND b.sequence=cc.max_seq
              JOIN m_material_group c ON c.ID=a.SEMIC_MAIN_GROUP
              LEFT JOIN sync_item_cost k on k.MATERIAL_ID=a.MATERIAL and k.SEMIC=a.MATERIAL_CODE AND k.BRANCH_PLANT='".$id."'
              WHERE b.status_approve = '1' group by k.BRANCH_PLANT,a.MATERIAL_CODE,a.MATERIAL,a.MATERIAL_NAME,a.UOM
              ORDER BY a.CREATE_TIME DESC
            ) a LEFT JOIN sync_item_available v on v.BRANCH_PLANT='".$id."' and v.MATERIAL_ID=a.MATERIAL
            WHERE a.STOCKING_TYPE != '3'
            GROUP BY a.MATERIAL_CODE,a.MATERIAL,a.MATERIAL_NAME,a.UOM,a.ITEM_COST");
    return $query;
    // echopre( $this->db->last_query() );
  }

  public function mreq_number($post = null){
    // $datex = date("Ym").date("s");
    // return $this->db->query("SELECT COALESCE(CONCAT($datex, count(request_no)+1), CONCAT($datex, 1)) as req_no FROM t_material_request");

    // if ($this->session->COMPANY == 10101) {
    //   $cd = 'ML';
    // } elseif ($this->session->COMPANY == 10102) {
    //   $cd = 'RB';
    // } elseif ($this->session->COMPANY == 10103) {
    //   $cd = 'RD';
    // } else {
    //   $cd = 'MR';
    // }
    if ($post != null) {
      $cd = date('y').substr($post, 4, 1);
    } else {
      $cd = date('y').substr($this->session->COMPANY, 4, 1);
    }
    $query = $this->db->query("SELECT COUNT(1)+1 as total FROM t_material_request WHERE request_no LIKE '%".$cd."%' ");
    $row2 = $query->row();
    $lenidmax = strlen($row2->total);
    $increment = str_repeat('0',5-$lenidmax).$row2->total;
    $kode = $increment;
    return $cd.$kode;
  }

  public function show_company($id){
    return $this->db->query("SELECT * FROM m_departement WHERE ID_DEPARTMENT = '".$id."'");
  }

  public function company(){
    return $this->db->query("SELECT * FROM m_company ");
  }

  public function get_location(){
    return $this->db->query("SELECT * FROM m_location ");
  }

  public function get_material($id){
    return $this->db->where("a.MATERIAL", $id)->select("a.*, CONCAT(b.code, ' - ', b.description) as GL_CLASS_NAME, 'RP' as CURRENCY, 'IDR' as CURRENCY_NAME, 'location' as get_location ")->from("m_material a")->join("m_gl_class b", "b.id=a.GL_CLASS")->get();
  }

  public function show_bp(){
    return $this->db->where("STATUS", "1")->get("m_bplant");
  }

  public function show_mr_type(){
    return $this->db->where("status", "1")->get("m_material_request_type");
  }

  public function show_bplant(){
    return $this->db->where("status", "1")->get("m_bplant");
  }

  public function show_asset_type(){
    return $this->db->where("status", "1")->get("m_asset_type");
  }

  public function show_disposal_method(){
    return $this->db->where("status", "1")->get("m_disposal_method");
  }

  public function show_costcenter(){
    return $this->db->where("STATUS", "1")->get("m_costcenter");
  }

  public function show_dept($where = null){
    if ($where != null) {
      $this->db->where("ID_COMPANY", $where);
    }
    return $this->db->where("STATUS", "1")->get("m_costcenter");
  }

  public function show_acharge($costcenter, $semic='%'){
    // $this->db->where("COSTCENTER", $costcenter);
    // return $this->db->get("m_accsub");
    $gl_fuel = $this->db->query("SELECT MATERIAL_CODE FROM m_material WHERE MATERIAL_CODE LIKE '%".$semic."%' AND GL_CLASS = '1' ");
    if ($gl_fuel->num_rows() > 0) {
      $semic = '%';
      return $this->db->query("select DISTINCT s.* FROM m_material m
      join m_accsub s on s.COSTCENTER='".$costcenter."' where s.status=1 ");
    }else{
      return $this->db->query("select DISTINCT s.* FROM m_material m
      join m_accsub s on s.COSTCENTER='".$costcenter."'
      join m_gl_class f on f.id=m.GL_CLASS
      join sync_dmaai d on trim(d.GLCLASS)=f.code and s.ID_ACCSUB=CONCAT(TRIM(ACC_OBJ),'-',TRIM(ACC_SUB))
      WHERE m.MATERIAL_CODE LIKE '".$semic."'");
    }

  }

  public function show_bplant_selection($where){
     // return $this->db->query("SELECT a.ID_BPLANT as id_warehouse, a.BPLANT_DESC as description, CASE WHEN a.ID_BPLANT = trim(b.id_warehouse) THEN 1 ELSE 0 END as is_default FROM m_bplant a JOIN m_warehouse b ON a.ID_BPLANT LIKE CONCAT('%', b.id_company, '%') WHERE a.STATUS = '1' AND a.ID_BPLANT LIKE '%".$where."%' ORDER BY is_default DESC");
     return $this->db->query("SELECT a.ID_BPLANT as id_warehouse, a.BPLANT_DESC as description, CASE WHEN a.ID_BPLANT = trim(b.id_warehouse) THEN 1 ELSE 0 END as is_default FROM m_bplant a JOIN m_warehouse b ON b.id_company=a.ID_COMPANY WHERE a.STATUS = '1' AND a.ID_COMPANY = ".$where." ORDER BY is_default DESC");
  }

  public function show_to_bplant_selection($where){
    return $this->db->query("SELECT ID_BPLANT as id_warehouse, BPLANT_DESC as description FROM m_bplant WHERE STATUS = '1' AND ID_BPLANT NOT LIKE '%".$where."%' ");
  }

  public function show_costcenter_selection($where){
    $this->db->where("ID_COMPANY", $where);
    return $this->db->where("STATUS", "1")->get("m_costcenter");
  }

  public function show_wo_reason(){
    return $this->db->where("status", "1")->get("m_writeoff_reason");
  }

  public function show_curency($where = null){
    if ($where != "") {
      $and_where = 'AND ID= "'.$where.'" ';
    } else {
      $and_where = "";
    }
    return $this->db->query("SELECT * FROM m_currency WHERE STATUS = '1' ".$and_where."  ORDER BY (CASE CURRENCY WHEN 'USD' THEN 1 ELSE 99 END) ASC");
  }

  public function create_mr($data){
    $dt = array(
      'request_no' => $data['request_no'],
      'company_code' => $data['company_code'],
      'departement' => $data['departement'],
      'create_by' => $data['user'],
      'document_type' => $data['document_type'],
      'busines_unit' => $data['busines_unit'],
      'purpose_of_request' => $data['purpose_of_request'],
      'branch_plant' => $data['branch_plant'],
      'to_branch_plant' => $data['to_branch_plant'],
      'from_company' => $data['from_company'],
      'to_company' => $data['to_company'],
      'request_date' => $data['request_date'],
      'account' => $data['account'],
      'account_desc' => $data['account_desc'],
      'wo_reason' => $data['wo_reason'],
      'inspection' => $data['inspection'],
      'asset_valuation' => $data['asset_valuation'],
      'asset_type' => $data['asset_type'],
      'disposal_method' => $data['disposal_method'],
      'justification_disposal_method' => $data['disposal_desc'],
      'disposal_value' => $data['dis_val'],
      'disposal_cost' => $data['dis_cost'],
      'disposal_value_curr' => $data['disposal_cost'],
      'disposal_cost_curr' => $data['disposal_cost'],
      'create_date' => $data['create_date'],
      'create_by' => $data['create_by'],
    );

    $qq = $this->db->insert("t_material_request", $dt);

    if ($qq) {
      foreach ($data['semic_no'] as $i => $val) {
        $dt_item = array(
          'request_no' => $data['request_no'],
          'semic_no' => $data['semic_no'][$i],
          'item_desc' => $data['item_desc'][$i],
          'uom' => $data['uom'][$i],
          'qty' => $data['qty'][$i],
          'currency' => $data['currency'][$i],
          'unit_cost' => $data['unit_cost'][$i],
          'to_unit_cost' => $data['to_unit_cost'][$i],
          'extended_ammount' => $data['extended_ammount'][$i],
          'to_extended_ammount' => $data['to_extended_ammount'][$i],
          'branch_plant' => $data['branch_plant'],
          'remark' => $data['remark'][$i],
          'qty_act' => $data['qty_act'][$i],
          'qty_avl' => $data['qty_avl'][$i],
          'branch_plant' => $data['bp_item'][$i],
          'to_branch_plant' => $data['to_bp_item'][$i],
          'account' => $data['acc'][$i],
          'account_desc' => $data['acc_desc'][$i],
          'category' => $data['category'][$i],
          'acq_year' => $data['acq_year'][$i],
          'acq_value' => $data['acq_value'][$i],
          'book_value' => $data['curr_book'][$i],
          'material_status' => $data['mtr_status'][$i],
          //'busines_unit' => $data['bu'][$i],
        );

        if (!empty($data['bu'][$i])) { $dt_item['busines_unit'] = $data['bu'][$i]; }
        if (!empty($data['location'][$i])) { $dt_item['location'] = $data['location'][$i]; }
        if (!empty($data['to_location'][$i])) { $dt_item['to_location'] = $data['to_location'][$i]; }
        if (!empty($data['gl_class'][$i])) { $dt_item['glclass_desc'] = $data['gl_class'][$i]; }
        $qq_item = $this->db->insert("t_material_request_item", $dt_item);
      }

      $qmr_type = $this->db->query("SELECT * FROM m_material_request_type WHERE id = '".$data['document_type']."'");
      $query_modul = $this->db->query("SELECT * FROM m_approval_modul WHERE id = '".$qmr_type->row()->modul."'");
      $count_aas = $this->db->query("SELECT count(1) as count FROM m_approval_rule WHERE module = '".$qmr_type->row()->modul."' AND user_roles = '22'");
      if ($count_aas->row()->count <= 0) {
        if ($data['document_type'] == 6) { $extra_case = $data['to_company']; } else { $extra_case = 0; }
        $insert_t_approval = $this->db->query("INSERT INTO t_approval_material_request
          SELECT
            null,
            '".$data['request_no']."' AS id_mr,
            '%' AS id_user,
            user_roles,
            sequence,
            '0' AS status_approve,
            description,
            reject_step,
            email_approve,
            email_reject,
            edit_content,
            '".$extra_case."' AS extra_case,
            null as note,
            null as approve_by,
            now(),
            now()
          from m_approval_rule
          WHERE module='".$query_modul->row()->id."' AND status='1' ORDER BY sequence"
        );
      }

      $dt_log = array(
        'module_kode' => 'log_mr',
        'data_id' => $data['request_no'],
        'description' => 'MATERIAL REQUEST CREATED',
        'created_at' => date("Y-m-d H:i:s"),
        'created_by' => $this->session->userdata['ID_USER'],
      );

      $qq_log = $this->db->insert("log_history", $dt_log);

      if ($qq_log == true) {
        $query = $this->db->query("SELECT * FROM t_jabatan a JOIN m_user b ON b.ID_USER=a.user_id WHERE a.user_id = '".$data['create_by']."' ");
        $par_id = $query->row()->parent_id;
        $query1 = $this->db->query("SELECT * FROM t_jabatan a JOIN m_user b ON b.ID_USER=a.user_id WHERE a.id = '".$par_id."' ");
        $usr_id = $query1->row()->user_id;

        $user_mgr = array(
          'id_user' => $usr_id,
        );
        $this->db->where("id_mr", $data['request_no']);
        $this->db->like("description",'USER MANAGER');
        $this->db->update("t_approval_material_request", $user_mgr);
      }

      return true;
    }
  }

  public function create_mr_aas($data){
    $qmr_type = $this->db->query("SELECT * FROM m_material_request_type WHERE id = '".$data['doc_type']."'");
    $query2 = $this->db->query("SELECT * FROM m_approval_rule WHERE module = '".$qmr_type->row()->modul."' ORDER BY sequence ASC");
    $urutan = 1;

    if ($data['doc_type'] == 6) {
      foreach ($query2->result_array() as $key => $val) {
        if ($val['user_roles'] == 22) {
          $insert_aas = $this->db->query(
            "INSERT INTO t_approval_material_request VALUES (null, '".$data['mr_no']."', '".$data['user_id']."', '".$val['user_roles']."', '".$urutan."','0', '".$val['description']."','".$urutan."','".$val['email_approve']."','".$val['email_reject']."','".$val['edit_content']."','".$val['extra_case']."',null,null,now(),now() )"
          );
          $urutan++;
          $insert_aas2 = $this->db->query(
            "INSERT INTO t_approval_material_request VALUES (null, '".$data['mr_no']."', '".$data['aas2_id']."', '".$val['user_roles']."','".$urutan."','0', '".$val['description']."','".$urutan."','".$val['email_approve']."','".$val['email_reject']."','".$val['edit_content']."','".$val['extra_case']."',null,null,now(),now() )"
          );
        } elseif ($val['user_roles'] == 34) {
          $insert_aas = $this->db->query(
            "INSERT INTO t_approval_material_request VALUES (null, '".$data['mr_no']."', '".$data['aas_1_other']."', '".$val['user_roles']."', '".$urutan."','0', '".$val['description']."','".$urutan."','".$val['email_approve']."','".$val['email_reject']."','".$val['edit_content']."','".$val['extra_case']."',null,null,now(),now() )"
          );
          $urutan++;
          $insert_aas2 = $this->db->query(
            "INSERT INTO t_approval_material_request VALUES (null, '".$data['mr_no']."', '".$data['aas_2_other']."', '".$val['user_roles']."','".$urutan."','0', '".$val['description']."','".$urutan."','".$val['email_approve']."','".$val['email_reject']."','".$val['edit_content']."','".$val['extra_case']."',null,null,now(),now() )"
          );
        } else {
          $insert_noaas = $this->db->query(
            "INSERT INTO t_approval_material_request VALUES (null, '".$data['mr_no']."', '%', '".$val['user_roles']."','".$urutan."','0', '".$val['description']."','".$urutan."','".$val['email_approve']."','".$val['email_reject']."','".$val['edit_content']."','".$val['extra_case']."',null,null,now(),now() )"
          );
        }
        $urutan++;
      }

    } elseif ($data['doc_type'] == 7 || $data['doc_type'] == 8) {
      foreach ($query2->result_array() as $key => $val) {
        if ($val['user_roles'] == 22) {
          $insert_aas = $this->db->query(
            "INSERT INTO t_approval_material_request VALUES (null, '".$data['mr_no']."', '".$data['user_id']."', '".$val['user_roles']."', '".$urutan."','0', '".$val['description']."','".$urutan."','".$val['email_approve']."','".$val['email_reject']."','".$val['edit_content']."','".$val['extra_case']."',null,null,now(),now() )"
          );
          $urutan++;
          $insert_aas2 = $this->db->query(
            "INSERT INTO t_approval_material_request VALUES (null, '".$data['mr_no']."', '".$data['aas2_id']."', '".$val['user_roles']."','".$urutan."','0', '".$val['description']."','".$urutan."','".$val['email_approve']."','".$val['email_reject']."','".$val['edit_content']."','".$val['extra_case']."',null,null,now(),now() )"
          );
        } else {
          $insert_noaas = $this->db->query(
            "INSERT INTO t_approval_material_request VALUES (null, '".$data['mr_no']."', '%', '".$val['user_roles']."','".$urutan."','0', '".$val['description']."','".$urutan."','".$val['email_approve']."','".$val['email_reject']."','".$val['edit_content']."','".$val['extra_case']."',null,null,now(),now() )"
          );
        }
        $urutan++;
      }
    }

    $query = $this->db->query("SELECT * FROM t_jabatan a JOIN m_user b ON b.ID_USER=a.user_id WHERE a.user_id = '".$data['create_by']."' ");
    $par_id = $query->row()->parent_id;
    $query1 = $this->db->query("SELECT * FROM t_jabatan a JOIN m_user b ON b.ID_USER=a.user_id WHERE a.id = '".$par_id."' ");
    $usr_id = $query1->row()->user_id;

    $user_mgr = array(
      'id_user' => $usr_id,
    );
    $this->db->where("id_mr", $data['mr_no']);
    $this->db->like("description",'USER MANAGER');
    $this->db->update("t_approval_material_request", $user_mgr);
    return true;
  }


  public function update_mr($data){
    $dt = array(
      'request_no' => $data['get_id'],
      'company_code' => $data['company_code'],
      'departement' => $data['departement'],
      'create_by' => $data['user'],
      // 'document_type' => $data['document_type'],
      'purpose_of_request' => $data['purpose_of_request'],
      'branch_plant' => $data['branch_plant'],
      'to_branch_plant' => $data['to_branch_plant'],
      'from_company' => $data['from_company'],
      'to_company' => $data['to_company'],
      'request_date' => $data['request_date'],
      'account' => $data['account'],
      'account_desc' => $data['account_desc'],
      'wo_reason' => $data['wo_reason'],
      'create_date' => $data['create_date'],
      'create_by' => $data['create_by'],
    );

    $qq = $this->db->where("request_no", $data['get_id'])->update("t_material_request", $dt);

    if ($qq) {
      $del = $this->db->query("DELETE FROM t_material_request_item WHERE request_no = '".$data['get_id']."'");
      $del_approval = $this->db->query("DELETE FROM t_approval_material_request WHERE id_mr = '".$data['get_id']."'");
      foreach ($data['semic_no'] as $i => $val) {
        $dt_item = array(
          'request_no' => $data['get_id'],
          'semic_no' => $data['semic_no'][$i],
          'item_desc' => $data['item_desc'][$i],
          'uom' => $data['uom'][$i],
          'qty' => $data['qty'][$i],
          'currency' => $data['currency'][$i],
          'unit_cost' => $data['unit_cost'][$i],
          'to_unit_cost' => $data['to_unit_cost'][$i],
          'extended_ammount' => $data['extended_ammount'][$i],
          'to_extended_ammount' => $data['to_extended_ammount'][$i],
          'branch_plant' => $data['branch_plant'],
          'remark' => $data['remark'][$i],
          'qty_act' => $data['qty_act'][$i],
          'branch_plant' => $data['bp_item'][$i],
          'to_branch_plant' => $data['to_bp_item'][$i],
          'account' => $data['acc'][$i],
          'account_desc' => $data['acc_desc'][$i],
          'category' => $data['category'][$i],
          'acq_year' => $data['acq_year'][$i],
          'acq_value' => $data['acq_value'][$i],
          'book_value' => $data['curr_book'][$i],
          'busines_unit' => $data['bu'][$i],
        );

        if (!empty($data['location'][$i])) { $dt_item['location'] = $data['location'][$i]; }
        if (!empty($data['to_location'][$i])) { $dt_item['to_location'] = $data['to_location'][$i]; }
        if (!empty($data['gl_class'][$i])) { $dt_item['glclass_desc'] = $data['gl_class'][$i]; }
        $qq_item = $this->db->insert("t_material_request_item", $dt_item);
      }

      $qmr_type = $this->db->query("SELECT * FROM m_material_request_type WHERE id = '".$data['document_type']."'");
      $query_modul = $this->db->query("SELECT * FROM m_approval_modul WHERE id = '".$qmr_type->row()->modul."'");
      $count_aas = $this->db->query("SELECT count(1) as count FROM m_approval_rule WHERE module = '".$qmr_type->row()->modul."' AND user_roles = '22'");
      if ($count_aas->row()->count <= 0) {
        if ($data['document_type'] == 6) { $extra_case = $data['to_company']; } else { $extra_case = 0; }
        $insert_t_approval = $this->db->query("INSERT INTO t_approval_material_request
          SELECT
            null,
            '".$data['request_no']."' AS id_mr,
            '%' AS id_user,
            user_roles,
            sequence,
            '0' AS status_approve,
            description,
            reject_step,
            email_approve,
            email_reject,
            edit_content,
            '".$extra_case."' AS extra_case,
            null as note,
            null as approve_by,
            now(),
            now()
          from m_approval_rule
          WHERE module='".$query_modul->row()->id."' AND status='1' ORDER BY sequence"
        );
      }

      // $dt_apprval = array(
      //   'status_approve' => '0',
      //   'extra_case' => '0',
      //   'updatedate' => date("Y-m-d H:i:s"),
      // );
      //
      // $this->db->where("id_mr", $data['get_id']);
      // $this->db->update("t_approval_material_request", $dt_apprval);

      $dt_log = array(
        'module_kode' => 'log_mr',
        'data_id' => $data['get_id'],
        'description' => 'MATERIAL REQUEST RE-PROPOSED',
        'created_at' => date("Y-m-d H:i:s"),
        'created_by' => $this->session->userdata['ID_USER'],
      );

      $qq_log = $this->db->insert("log_history", $dt_log);


      if ($qq_log == true) {
        $query = $this->db->query("SELECT * FROM t_jabatan a JOIN m_user b ON b.ID_USER=a.user_id WHERE a.user_id = '".$data['create_by']."' ");
        $par_id = $query->row()->parent_id;
        $query1 = $this->db->query("SELECT * FROM t_jabatan a JOIN m_user b ON b.ID_USER=a.user_id WHERE a.id = '".$par_id."' ");
        $usr_id = $query1->row()->user_id;

        $user_mgr = array(
          'id_user' => $usr_id,
        );
        $this->db->where("id_mr", $data['request_no']);
        $this->db->like("description",'USER MANAGER');
        $this->db->update("t_approval_material_request", $user_mgr);
      }

      return true;
    }
  }

  public function add_approval_aas($data){
    $qmr_type = $this->db->query("SELECT * FROM m_material_request_type WHERE id = '".$data['doc_type']."'");
    $query_modul = $this->db->query("SELECT * FROM m_approval_modul WHERE id = '".$qmr_type->row()->modul."'");
    $insert_aas_1 = $this->db->query(
      "INSERT INTO t_approval_material_request SELECT null, '".$data['mr_no']."' AS id_mr, '".$data['user_id']."' AS id_user, '%' AS user_roles, (SELECT max(sequence)+1 FROM t_approval_material_request WHERE id_mr = '".$data['mr_no']."' ) AS sequence,'0' AS status_approve, 'MATERIAL REQUEST (WRITE OFF) - (".$data['title'].")'  AS description,(SELECT max(sequence) FROM t_approval_material_request WHERE id_mr = '".$data['mr_no']."' ) as reject_step,email_approve,email_reject,edit_content,extra_case,now(),now() from m_approval_rule where module='".$query_modul->row()->id."' AND sequence=reject_step ORDER BY reject_step ASC"
    );

    if ($insert_aas_1 == true) {
      $insert_aas_2 = $this->db->query(
        "INSERT INTO t_approval_material_request SELECT null, '".$data['mr_no']."' AS id_mr, '".$data['aas2_id']."' AS id_user, '%' AS user_roles, (SELECT max(sequence)+1 FROM t_approval_material_request WHERE id_mr = '".$data['mr_no']."' ) AS sequence,'0' AS status_approve, 'MATERIAL REQUEST (WRITE OFF) - (".$data['aas2_title'].")'  AS description,(SELECT max(sequence) FROM t_approval_material_request WHERE id_mr = '".$data['mr_no']."' ) as reject_step,email_approve,email_reject,edit_content,extra_case,now(),now() from m_approval_rule where module='".$query_modul->row()->id."' AND sequence=reject_step ORDER BY reject_step ASC"
      );
      if ($insert_aas_2 == true) {
        return true;
      }
    }
  }

  public function check_business_unit($semic, $acc_obj, $acc_sub){
    $gl_class = $this->db->query("select b.code, a.GL_CLASS FROM m_material a JOIN m_gl_class b ON b.id=a.GL_CLASS WHERE a.MATERIAL_CODE = '".$semic."' ");
    if ($gl_class->row()->GL_CLASS == '1') {
      $result = 1;
    } else {
      $query = $this->db->query("select * FROM sync_dmaai WHERE GLCLASS = '".$gl_class->row()->code."' AND ACC_OBJ = '".$acc_obj."' AND ACC_SUB = '".$acc_sub."' ");
      $result = $query->num_rows();
    }

    return $result;
  }

}
