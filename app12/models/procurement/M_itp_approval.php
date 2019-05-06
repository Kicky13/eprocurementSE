<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_itp_approval extends CI_Model {

  public function __construct() {
      parent::__construct();
      $this->db = $this->load->database('default', true);
  }

  public function list_itp_onprogress(){
    $query = $this->db->query("select v.no_po, r.description as jabatan, a.id,a.id_itp,b.user_roles,b.email_approve,b.extra_case, b.edit_content, b.email_reject,b.sequence,b.status_approve, b.reject_step, CASE WHEN count(j.id)>0 THEN CONCAT(b.description,' (DATA DITOLAK)') ELSE b.description END as description, v.note, y.id as id_po, y.po_no, y.po_type, y.msr_no, y.title, y.po_date, y.delivery_date, y.payment_term, y.shipping_term, y.id_dpoint, y.id_importation, y.id_currency, y.account_name, y.bank_name, y.tkdn_type, y.tkdn_value_goods, y.tkdn_value_service, y.create_by, y.create_on, v.number_of
    FROM (SELECT min(id) as id, id_itp, min(sequence) as sequence FROM t_approval_itp
                   WHERE (status_approve=0 OR status_approve=2)
                   GROUP BY id_itp
                  ) a
    JOIN t_approval_itp b ON b.id_itp=a.id_itp AND b.id=a.id
    JOIN t_itp v ON v.id_itp=b.id_itp
    JOIN m_user_roles r ON r.ID_USER_ROLES=b.user_roles
    LEFT JOIN t_purchase_order y ON y.po_no=v.no_po
    LEFT JOIN t_approval_itp j ON j.id_itp=b.id_itp AND j.status_approve=2
    where b.user_roles in (".substr($this->session->userdata['ROLES'], 1, -1).") AND ".$this->session->userdata['ID_USER']." LIKE b.id_user
    group by v.no_po, r.description, a.id,a.id_itp,b.user_roles,b.email_approve,b.extra_case, b.edit_content, b.email_reject,b.sequence,b.status_approve,j.id,b.description,b.reject_step, v.note, y.id, y.po_no, y.po_type, y.msr_no, y.title, y.po_date, y.delivery_date, y.payment_term, y.shipping_term, y.id_dpoint, y.id_importation, y.id_currency, y.account_name, y.bank_name, y.tkdn_type, y.tkdn_value_goods, y.tkdn_value_service, y.create_by, y.create_on, v.number_of");
    return $query->result_array();
  }

  public function show_msr_remaining(){
    $query = $this->db->query("SELECT * FROM t_msr WHERE msr_no NOT IN (select a.msr_no as msr FROM t_msr a join t_itp b on b.msr_no=a.msr_no)");
    return $query->result_array();
  }

  public function get_item_selection($id){
    $query = $this->db->query("
    select
    'receipt' as receipt,
    'data_company' as dt_comp,
    COALESCE( (b.unitprice * b.qty) - x.total , 0) as sisa,
    COALESCE( x.total , 0) as total,
    a.id_vendor, a.po_no as no_po, r.NAMA as vendor,
    b.id as id_po_det, b.po_id, b.id_itemtype, b.material_id as MATERIAL,
    b.semic_no, b.material_desc as MATERIAL_NAME,
    b.qty, b.id_uom, b.uom_desc, b.unitprice as priceunit, b.est_total_price, b.unitprice, b.total_price,
    c.MATERIAL_NAME as mname, c.UOM1, b.qty
    FROM t_purchase_order a
    JOIN t_purchase_order_detail b ON b.po_id=a.id
    LEFT JOIN m_material c ON c.MATERIAL=b.material_id
    JOIN (SELECT SUM(xx.total) as total, aa.no_po, xx.material_id FROM t_itp aa JOIN t_itp_detail xx ON xx.id_itp=aa.id_itp WHERE aa.no_po = '".$id."' GROUP BY aa.no_po, xx.material_id )  x ON x.no_po=a.po_no AND x.material_id=b.sop_bid_id
    JOIN m_vendor r ON r.ID=a.id_vendor
    WHERE a.po_no='".$id."'
    GROUP BY a.id_vendor, a.po_no, r.NAMA, b.id, b.po_id, b.id_itemtype, b.material_id, b.semic_no, b.material_desc, b.qty, b.id_uom, b.uom_desc, b.unitprice, b.est_total_price, b.unitprice, b.total_price, c.MATERIAL_NAME, c.UOM1
    ");
    return $query->result_array();
  }

  public function create_itp_document($data){
    // insert itp
    $t_itp = array(
      'msr_no' => $data['msr_no'],
      'no_po' => $data['no_po'],
      'note' => $data['note'],
      'created_by' => $this->session->userdata['ID_USER'],
      'created_date' => date("Y-m-d H:i:s"),
      'dated' => date("Y-m-d"),
    );
    $this->db->insert('t_itp', $t_itp);
    $insert_id = $this->db->insert_id();

    // insert detail
    foreach ($data['material_id'] as $key => $val) {
      $t_itp_detail = array(
        'id_itp' =>  $insert_id,
        'material_id'	=> $data['material_id'][$key],
        'qty'	=> $data['qty'][$key],
        'priceunit'	=> $data['priceunit'][$key],
        'total' => $data['total'][$key],
        'remark' => $data['remark'][$key],
      );
      $this->db->insert('t_itp_detail', $t_itp_detail);
    }

    // insert file
    foreach ($data['filename']['tmp_name'] as $i => $value) {
      $file = file_uploads(
             $data['filename']["tmp_name"][$i],
             $data['filename']["name"][$i],
             $data['filename']["type"][$i],
             $data['filename']["size"][$i],
             "upload/ITP/");

     $t_itp_upload = array(
       'id_itp' =>  $insert_id,
       'type'	=> $data['type'],
       'filename'	=> $file,
       'created_date'	=> date("Y-m-d H:i:s"),
     );

     $this->db->insert("t_itp_upload", $t_itp_upload);
    }

    $query_modul = $this->db->query("SELECT * FROM m_approval_modul WHERE description LIKE '%ITP DOCUMENT%'");
    foreach ($query_modul->result_array() as $arr) {
      $insert_t_approval = $this->db->query(
        "INSERT INTO t_approval_itp SELECT null,".$insert_id." AS id_itp,user_roles,sequence,0 AS status_approve,description,reject_step,email_approve,email_reject,edit_content,extra_case,now(),now() from m_approval_rule WHERE module='".$arr['id']."' AND status='1' ORDER BY sequence"
      );
    }

  }

  public function show_data_itp($po_no){
    $result = array();
    $result3 = array();

    $q_itp = $this->db->select("*")->from("t_itp")->where("id_itp", $po_no)->get();
    foreach ($q_itp->result_array() as $key => $arr) {
      $q_itp_detail = $this->db->query("select a.material_id, a.id_itp, a.qty, a.priceunit, a.total, d.sop_bid_id AS MATERIAL, d.semic_no AS MATERIAL_CODE, d.material_desc AS MATERIAL_NAME, d.semic_no AS REQUEST_NO, d.material_desc AS DESCRIPTION, d.id_itemtype, d.uom_desc as uom, a.remark, c.number_of
      FROM t_itp_detail a
      JOIN t_itp c ON c.id_itp=a.id_itp
      JOIN t_purchase_order x ON x.po_no=c.no_po
      JOIN t_purchase_order_detail d ON d.po_id=x.id AND d.sop_bid_id=a.material_id
      WHERE a.id_itp = '".$arr['id_itp']."' GROUP BY a.material_id, a.id_itp, a.qty, a.priceunit, a.total, MATERIAL, MATERIAL_CODE, MATERIAL_NAME, REQUEST_NO, DESCRIPTION, d.id_itemtype, d.uom_desc, a.remark, c.number_of");
      $result2 = array();
      // return $this->db->last_query();
      foreach ($q_itp_detail->result_array() as $key2 => $arr2) {
        $result2[] = array(
          'data_itp_detail' => $arr2,
        );
      }
      $q_itp_upload = $this->db->select("*")->from("t_itp_upload")->where("id_itp", $arr['id_itp'])->get();
      foreach ($q_itp_upload->result_array() as $ke3y => $arr3) {
        $result3[] = array(
          'data_itp_upload' => $arr3,
        );
      }
      $result = array(
        'itp' => $arr,
        'itp_detail' => $result2,
        'itp_upload' => $result3,
      );
    }
    return $result;
  }

  public function itp_doc_approval($data){
    $data_squence = array(
      'updatedate' => date("Y-m-d H:i:s"),
      'status_approve' => '1',
      'edit_content' => '0',
      'note' => 'Approved',
      'approve_by' => $this->session->userdata('ID_USER')
    );

    $status_reject = array(
      'status_approve' => '0',
      'extra_case' => '0',
      'edit_content' => '0',
    );

    $this->db->where("id_itp", $data['id_itp']);
    $this->db->where("status_approve", "2");
    $this->db->update("t_approval_itp", $status_reject);

    $this->db->where("id_itp", $data['id_itp']);
    $this->db->where("sequence", $data['sequence']);
    $this->db->update("t_approval_itp", $data_squence);

    return true;
  }

  public function reject_itp_doc($data){

    // if ($data['sequence_rej'] == 1 AND $data['status_approve_rej'] == 2 AND $data['reject_step_rej'] == 0) {
    //   $this->db->delete('t_itp_upload', array('id_itp' => $data['id_itp_rej']));
    //   $this->db->delete('t_itp_detail', array('id_itp' => $data['id_itp_rej']));
    //   $this->db->delete('t_approval_itp', array('id_itp' => $data['id_itp_rej']));
    //   $this->db->delete('t_itp', array('id_itp' => $data['id_itp_rej']));
    // } else {
    //
    // }
    $sequence_status = $data['sequence_rej'] - $data['reject_step_rej'];

    $upd_status_reject = array(
      'status_approve' => '2',
      'note' => 'Rejected - '.$data['note'],
      'approve_by' => $this->session->userdata('ID_USER')
    );

    $upd_status_0 = array(
      'status_approve' => '0',
    );

    $upd_excase = array(
      'edit_content' => '1',
    );

    $this->db->where("sequence >=", $sequence_status);
    $this->db->where("id_itp", $data['id_itp_rej']);
    $this->db->update("t_approval_itp", $upd_status_0);

    $this->db->where("sequence", $sequence_status);
    $this->db->where("id_itp", $data['id_itp_rej']);
    $this->db->update("t_approval_itp", $upd_status_reject);

    if ($sequence_status === 1) {
      $this->db->where("sequence", $sequence_status);
      $this->db->where("id_itp", $data['id_itp_rej']);
      $this->db->update("t_approval_itp", $upd_excase);
    }

    return true;
  }

  public function itp_doc_approval_upd($data){
    // $this->db->query("UPDATE t_itp SET id_itp = '1', msr_no = '18000002-OR-010001', no_po = '1', note = '1', created_by = '1', created_date = '2018-03-23 17:40:41', dated = '2018-03-23' WHERE id_itp = '1'");

    // update approval
    $upd_excase = array(
      'edit_content' => '0',
    );

    $this->db->where("sequence >=", '1');
    $this->db->where("id_itp", $data['id_itp']);
    $this->db->update("t_approval_itp", $upd_excase);

    // update itp
    $dt_itp = array(
      'note' => $data['note'],
      'dated' => date("Y-m-d"),
      'created_by' => $this->session->userdata['ID_USER'],
      'created_date' => date("Y-m-d H:i:s"),
      'dated' => $data['dated'],
    );

    $this->db->where("id_itp", $data['id_itp']);
    $this->db->update("t_itp", $dt_itp);

    // update detail
    foreach ($data['material_id'] as $key => $val) {
      $t_itp_detail = array(
        'qty'	=> $data['qty'][$key],
        'priceunit'	=> $data['priceunit'][$key],
        'total' => $data['total'][$key],
        'remark' => $data['remark'][$key],
      );

      $this->db->where("material_id", $data['material_id'][$key]);
      $this->db->where("id_itp", $data['id_itp']);
      $this->db->update("t_itp_detail", $t_itp_detail);
    }

    // insert file
    if (!empty($data['filename']['tmp_name'])) {
      foreach ($data['filename']['tmp_name'] as $i => $value) {
        $file = file_uploads(
               $data['filename']["tmp_name"][$i],
               $data['filename']["name"][$i],
               $data['filename']["type"][$i],
               $data['filename']["size"][$i],
               "upload/ITP/");

       $t_itp_upload = array(
         'id_itp' =>  $data['id_itp'],
         'type'	=> $data['type'],
         'filename'	=> $file,
         'created_date'	=> date("Y-m-d H:i:s"),
       );

       if ($data['filename']["tmp_name"][$i] != "" OR $file != "-") {
         $this->db->insert("t_itp_upload", $t_itp_upload);
       }

      }
    }

    if (count($data['rm_file']) > 0) {
      foreach ($data['rm_file'] as $k => $val) {
        $this->db->where('id_itp', $data['id_itp']);
        $this->db->where('filename', $val);
        $this->db->delete('t_itp_upload');
      }
    }

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
  // --------------------------------------- sendmail  --------------------------------------------

  public function get_comp($id){
    $query = $this->db->query("select a.msr_no, h.company_desc, k.DEPARTMENT_DESC
    FROM t_purchase_order a
    JOIN t_purchase_order_detail b ON b.po_id=a.id
    LEFT JOIN m_material c ON c.MATERIAL=b.material_id
    LEFT JOIN t_itp z ON z.no_po=a.po_no
    LEFT JOIN t_itp_detail x ON x.id_itp=z.id_itp AND x.material_id=b.material_id
    JOIN m_vendor r ON r.ID=a.id_vendor
    JOIN t_msr h ON h.msr_no=a.msr_no
    JOIN m_user m ON m.ID_USER=a.create_by
    JOIN m_departement k ON k.ID_DEPARTMENT=h.id_department
    WHERE a.po_no='".$id."'
    GROUP BY a.msr_no, h.company_desc, k.DEPARTMENT_DESC");
    return $query->row();
  }

  public function number_of_itp($no_po){
    $qq = $this->db->query("select COUNT(no_po)+1 AS number_of FROM t_itp WHERE no_po = '".$no_po."'");
    return $qq->row()->number_of;
  }

}
