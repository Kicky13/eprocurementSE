<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_material_req_list extends CI_Model {

  public function __construct() {
      parent::__construct();
      $this->db = $this->load->database('default', true);
  }

  public function datatable_mr($where=null) {
      if (!empty($where)) { $and_where = 'AND b.id_mr="'.$where.'"'; } else { $and_where = "AND ".$this->session->userdata['ID_USER']." LIKE b.id_user"; }
      $searchString = ',';

      if( strpos($this->session->userdata['ROLES'], ',') !== false ) {
        $roles = substr($this->session->userdata['ROLES'], 1, -1);
      } else {
        $roles = $this->session->userdata['ROLES'];
      }
      // if ($this->session->userdata['ROLES'] != "") { $roles = "and b.user_roles in (".substr($this->session->userdata['ROLES'], 1, -1).")"; } else { $roles = ''; }
      $query = $this->db->query("select a.request_no, a.request_no, a.request_date, a.to_branch_plant, a.branch_plant, a.purpose_of_request, a.account_desc, cc.max_seq,  b.user_roles, b.email_approve,b.edit_content,b.extra_case, b.email_reject,b.sequence,b.status_approve, 'MATERIAL REQUEST HAS BEEN APPROVED BY ALL' as description,b.reject_step, y.description as mr_type_desc, y.doc_type, t.semic_no,  CONCAT(c.MATERIAL_NAME,' ',c.SHORTDESC) as item_desc, t.currency, t.uom, t.unit_cost, t.qty, t.qty_act, t.branch_plant, t.to_branch_plant, a.isclosed as status_jde
      FROM t_material_request a
      JOIN (SELECT max(sequence) as max_seq, id_mr FROM t_approval_material_request GROUP BY id_mr) cc ON cc.id_mr=a.request_no
      JOIN t_approval_material_request b ON b.id_mr=cc.id_mr AND b.sequence=cc.max_seq
      JOIN t_material_request_item t ON t.request_no=a.request_no
      JOIN m_material_request_type y ON y.id=a.document_type
      JOIN m_user usr ON usr.ID_USER=a.create_by
	  JOIN m_material c ON c.MATERIAL_CODE=t.semic_no
      WHERE b.status_approve = 1
      GROUP BY c.MATERIAL_NAME,c.SHORTDESC,a.request_no, a.request_no, a.request_date, a.to_branch_plant, a.branch_plant, a.purpose_of_request, a.account_desc, cc.max_seq,  b.user_roles, b.email_approve,b.edit_content,b.extra_case, b.email_reject,b.sequence,b.status_approve, description,b.reject_step, mr_type_desc, y.doc_type, t.semic_no, t.item_desc, t.currency, t.uom, t.unit_cost, t.qty, t.qty_act, t.branch_plant, t.to_branch_plant, status_jde");

      return $query->result_array();
  }

  public function get_material_req($id){
    $data = array();
    $mr = $this->db->query("select a.request_no,a.company_code,a.departement,a.create_by,a.document_type,a.purpose_of_request,a.branch_plant,a.request_date,a.busines_unit,a.account,a.account_desc,a.to_branch_plant,a.from_company,a.to_company,a.wo_reason,a.inspection,a.asset_valuation,a.asset_type,a.disposal_method,a.justification_disposal_method,a.disposal_value,a.disposal_cost,a.disposal_value_curr,a.disposal_cost_curr, b.name,
    c.DEPARTMENT_DESC, 'RP' as CURRENCY, 'IDR' as CURRENCY_NAME, 'location' as get_location,a.isclosed
    FROM t_material_request a
    JOIN m_user b ON b.ID_USER=a.create_by
    JOIN m_departement c ON c.ID_DEPARTMENT=b.ID_DEPARTMENT
    WHERE a.request_no = '".$id."' AND c.STATUS = '1'
    GROUP BY a.request_no,a.company_code,a.departement,a.create_by,a.document_type,a.purpose_of_request,a.branch_plant,a.request_date,a.busines_unit,a.account,a.account_desc,a.to_branch_plant,a.from_company,a.to_company,a.wo_reason,a.inspection,a.asset_valuation,a.asset_type,a.disposal_method,a.justification_disposal_method,a.disposal_value,a.disposal_cost,a.disposal_value_curr,a.disposal_cost_curr, b.name, c.DEPARTMENT_DESC, CURRENCY, CURRENCY_NAME, get_location,a.isclosed
    ");
    $loc = $this->db->query("SELECT * FROM m_location WHERE STATUS = '1' ");
    foreach ($mr->result_array() as $key => $arr) {
      $mr_item = $this->db->query("select a.request_no, a.semic_no, CONCAT(c.MATERIAL_NAME,' ',c.SHORTDESC) as item_desc, a.uom, a.qty, a.qty_act, a.qty_avl, a.branch_plant, a.to_branch_plant, a.location, a.to_location, a.currency, a.unit_cost, a.to_unit_cost, a.extended_ammount, a.branch_plant, a.account, a.account_desc, a.remark,a.to_extended_ammount,a.acq_year,a.acq_value,a.category,a.book_value,a.material_status,
      b.CURRENCY, c.MATERIAL, a.glclass_desc
      FROM t_material_request_item a
      JOIN m_currency b ON a.currency=b.ID
      JOIN m_material c ON c.MATERIAL_CODE=a.semic_no
      WHERE a.request_no = '".$arr['request_no']."'
      GROUP BY c.MATERIAL_NAME,c.SHORTDESC,a.request_no, a.semic_no, a.item_desc, a.uom, a.qty, a.qty_act, a.qty_avl, a.branch_plant, a.to_branch_plant, a.location, a.to_location, a.currency, a.unit_cost, a.to_unit_cost, a.extended_ammount, a.branch_plant, a.account, a.account_desc, a.remark,a.to_extended_ammount,a.acq_year,a.acq_value,a.category,a.book_value,a.material_status, b.CURRENCY, c.MATERIAL,a.glclass_desc");
      $data_item = array();
      foreach ($mr_item->result_array() as $key => $value) {
        $data_item[] = array(
          'mr_item' => $value,
        );
      }
      $data = array(
        'get_approval' => self::datatable_mr($id),
        'get_location' => $loc->result_array(),
        'material_request' => $arr,
        'material_request_detail' => $data_item,
      );
    }

    return $data;
  }

  public function save_note($data){
    return $this->db->insert("t_note", $data);
  }

  public function get_note($id){
    return $this->db->query("SELECT * FROM t_note a JOIN m_user b ON b.ID_USER=a.created_by WHERE a.data_id = '".$id."'");
  }

  public function get_log($id){
    return $this->db->query("select * FROM log_history a JOIN m_user b ON b.ID_USER=a.created_by JOIN t_jabatan ee ON ee.user_id=b.ID_USER WHERE a.data_id = '".$id."' ORDER BY created_at ASC");
  }

  public function approve_mr($data){
    $data_squence = array(
      'updatedate' => date("Y-m-d H:i:s"),
      'status_approve' => '1',
    );

    $status_reject = array(
      'status_approve' => '0',
      'extra_case' => '0',
    );

    if ($data['extra_case'] == 1) {
      foreach ($data['semic'] as $key => $value) {
        $upd_item = array(
          'qty' => $data['qty'][$key],
          'unit_cost' => str_replace(",", "", $data['unit_price'][$key]),
          'to_unit_cost' => str_replace(",", "", $data['to_unit_cost'][$key]),
          'extended_ammount' => str_replace(",", "", $data['ammount'][$key]),
          'to_extended_ammount' => str_replace(",", "", $data['to_ammount'][$key]),
          'remark' => $data['remark'][$key],
        );

        $this->db->where("request_no", $data['mr_no']);
        $this->db->where("semic_no", $data['semic'][$key]);
        $this->db->update("t_material_request_item", $upd_item);
      }
    }

    $this->db->where("id_mr", $data['mr_no']);
    $this->db->where("status_approve", "2");
    $this->db->update("t_approval_material_request", $status_reject);

    $this->db->where("id_mr", $data['mr_no']);
    $this->db->where("sequence", $data['sequence']);
    $this->db->update("t_approval_material_request", $data_squence);

    $dt_log = array(
      'module_kode' => 'log_mr',
      'data_id' => $data['mr_no'],
      'description' => 'MATERIAL REQUEST APPROVED',
      'created_at' => date("Y-m-d H:i:s"),
      'created_by' => $this->session->userdata['ID_USER'],
    );

    $qq_item = $this->db->insert("log_history", $dt_log);

    return true;
  }

  public function reject_mr($data){
    $sequence_status = $data['sequence'] - $data['reject_step'];
    if ($sequence_status == 0) {
      $sequence_status = 1;
    }
    $upd_status_reject = array(
      'status_approve' => '2',
    );

    $upd_status_0 = array(
      'status_approve' => '0',
    );

    $upd_excase = array(
      'extra_case' => '1',
    );

    $this->db->where("sequence >=", $sequence_status);
    $this->db->where("id_mr", $data['mr_no']);
    $this->db->update("t_approval_material_request", $upd_status_0);

    $this->db->where("sequence", $sequence_status);
    $this->db->where("id_mr", $data['mr_no']);
    $this->db->update("t_approval_material_request", $upd_status_reject);

    if ($sequence_status === 1) {
      $this->db->where("sequence", $sequence_status);
      $this->db->where("id_mr", $data['mr_no']);
      $this->db->update("t_approval_material_request", $upd_excase);
    }

    $dt_log = array(
      'module_kode' => 'log_mr',
      'data_id' => $data['mr_no'],
      'description' => 'MATERIAL REQUEST REJECTED',
      'created_at' => date("Y-m-d H:i:s"),
      'created_by' => $this->session->userdata['ID_USER'],
    );

    $qq_item = $this->db->insert("log_history", $dt_log);

    return true;
  }

  // --------------------------------------- sendmail  --------------------------------------------
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

  public function get_user($dt,$cnt=0) {
      $this->db->select("EMAIL")
              ->from("m_user ")
              ->group_start();
      if ($cnt != 0) {
          foreach ($dt as $k => $v) {
              if ($k == 0)
                  $this->db->like("ROLES", ',' . $v . ',');
              else
                  $this->db->or_like("ROLES", ',' . $v . ',');
          }
      } else
          $this->db->like("ROLES", $dt);
      $qry = $this->db->group_end()
              ->where("STATUS=", "1")
              ->get();
      if ($qry->num_rows() != 0)
          return $qry->result();
      else
          return false;
  }
  // --------------------------------------- sendmail  --------------------------------------------

}
