<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_itp_onclosed extends CI_Model {

  public function __construct() {
      parent::__construct();
      $this->db = $this->load->database('default', true);
  }

  public function list_itp_onprogress(){
    $query2 = $this->db->query("SELECT COALESCE(max(sequence), 0) as max_sequence FROM t_approval_itp_vendor a JOIN t_vendor_itp b ON b.id_itp=a.id_itp");
      $query = $this->db->query("SELECT distinct p.title,
      CASE WHEN j.user_roles IS NOT NULL THEN CONCAT('(',j.note,')')
      WHEN h.id_itp IS NOT NULL AND r.DESCRIPTION IS NOT NULL THEN CONCAT('(',i.note,')') ELSE '' END as description, v.nama,
      CASE WHEN is_vendor_acc=1 THEN 'Completed - Supplier Accepted'
      WHEN j.user_roles IS NOT NULL THEN CONCAT('Rejected by ',s.DESCRIPTION)
      WHEN r.DESCRIPTION IS NULL THEN 'Completed' ELSE CONCAT('Approval by ',r.DESCRIPTION) END as status,
      CASE WHEN t.is_closed=1 THEN 'CLOSED' ELSE 'OPEN' END as is_closed,
      t.id_itp,t.itp_no,t.id_vendor,t.no_po,t.dated, p.po_no, t.created_by, t.is_closed as close_status
      from t_itp t
      join t_approval_itp a on a.id_itp=t.id_itp
      join m_vendor v on v.id=t.id_vendor
      join t_purchase_order p on p.po_no=t.no_po
      LEFT JOIN (select id_itp,min(sequence) as minseq from t_approval_itp where status_approve=0 group by id_itp) f on f.id_itp=t.id_itp
      LEFT JOIN (select id_itp,user_roles,sequence,note from t_approval_itp where status_approve=0) g on g.id_itp=t.id_itp and g.sequence=f.minseq
      LEFT JOIN (select id_itp,user_roles,note from t_approval_itp where status_approve=2) j on j.id_itp=t.id_itp
      LEFT JOIN (select id_itp,max(sequence) as maxseq from t_approval_itp where status_approve=1 group by id_itp) h on h.id_itp=t.id_itp
      LEFT JOIN (select id_itp,note,sequence from t_approval_itp ) i on i.id_itp=h.id_itp and i.sequence=h.maxseq
      LEFT JOIN m_user_roles r on r.ID_USER_ROLES=g.user_roles
      LEFT JOIN m_user_roles s on s.ID_USER_ROLES=j.user_roles
      GROUP BY p.title,t.id_itp,j.user_roles,j.note,r.DESCRIPTION,i.note");
    return $query->result_array();
  }

  public function show_msr_remaining(){
    $query = $this->db->query("SELECT * FROM t_msr WHERE msr_no NOT IN (select a.msr_no as msr FROM t_msr a join t_itp b on b.msr_no=a.msr_no)");
    return $query->result_array();
  }

  public function get_item_selection($id){
    $query = $this->db->query("select a.itp_no, a.id_vendor, a.no_po, r.NAMA as vendor, COALESCE( (b.priceunit * b.qty), 0) as spending,  0 as total,0 as total_det, b.priceunit, 0 as vqty, b.qty, w.material_desc AS MATERIAL_NAME, w.material_id AS MATERIAL, w.uom_desc AS UOM1, w.id_itemtype, 'ID' as dt_comp
    FROM t_itp a
    JOIN t_itp_detail b ON b.id_itp=a.id_itp
    LEFT JOIN t_purchase_order q ON q.po_no=a.no_po
    LEFT JOIN t_purchase_order_detail w ON w.po_id=q.id AND w.sop_bid_id=b.material_id
    LEFT JOIN m_vendor r ON r.ID=a.id_vendor
    WHERE a.id_itp='".$id."'
    GROUP BY a.itp_no, a.id_vendor, a.no_po, r.NAMA, b.priceunit, b.qty, MATERIAL_NAME, MATERIAL, UOM1, w.id_itemtype, dt_comp");
    return $query->result_array();
  }

  public function create_itp_document($data){
    // insert itp
    $t_itp = array(
      'id_itp' => $data['id_itp'],
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
      $q_itp_detail = $this->db->query("SELECT a.material_id, a.id_itp, a.qty, a.priceunit, a.total, d.sop_bid_id AS MATERIAL, d.semic_no AS MATERIAL_CODE, d.material_desc AS MATERIAL_NAME, d.semic_no AS REQUEST_NO, d.material_desc AS DESCRIPTION, d.id_itemtype, d.uom_desc as uom, a.remark
      FROM t_itp_detail a
      JOIN t_itp c ON c.id_itp=a.id_itp
      JOIN t_purchase_order x ON x.po_no=c.no_po
      JOIN t_purchase_order_detail d ON d.po_id=x.id AND d.sop_bid_id=a.material_id
      WHERE a.id_itp = '".$arr['id_itp']."' GROUP BY a.material_id, a.id_itp, a.qty, a.priceunit, a.total, MATERIAL, MATERIAL_CODE, MATERIAL_NAME, REQUEST_NO, DESCRIPTION, d.id_itemtype, d.uom_desc, a.remark");
      $result2 = array();
      // return $this->db->last_query();
      foreach ($q_itp_detail->result_array() as $key2 => $arr2) {
        $result2[] = array(
          'data_itp_detail' => $arr2,
        );
      }
      $q_itp_upload = $this->db->select("*")->from("t_itp_upload")->where("id_itp", $arr['id_itp'])->get();
      foreach ($q_itp_upload->result_array() as $arr3) {
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
    $status_reject = array(
      'is_closed' => '1',
    );

    $this->db->where("id_itp", $data['id_itp']);
    $this->db->where("id_itp_vendor", $data['id_itp_vendor']);
    $this->db->update("t_vendor_itp", $status_reject);

    return true;
  }

  public function reject_itp_doc($data){
    $sequence_status = $data['sequence_rej'] - $data['reject_step_rej'];

    $upd_status_reject = array(
      'status_approve' => '2',
    );

    $upd_status_0 = array(
      'status_approve' => '0',
    );

    $this->db->where("sequence >=", $sequence_status);
    $this->db->where("id_itp", $data['id_itp_rej']);
    $this->db->update("t_approval_itp_vendor", $upd_status_0);

    $this->db->where("id", $data['id_rej']);
    $this->db->update("t_approval_itp_vendor", $upd_status_reject);

    return true;
  }

  public function itp_doc_approval_upd($data){
    // $this->db->query("UPDATE t_itp SET id_itp = '1', msr_no = '18000002-OR-010001', no_po = '1', note = '1', created_by = '1', created_date = '2018-03-23 17:40:41', dated = '2018-03-23' WHERE id_itp = '1'");


    // update itp
    $dt_itp = array(
      'note' => $data['note'],
      'dated' => date("Y-m-d"),
      'created_by' => $this->session->userdata['ID_USER'],
      'created_date' => date("Y-m-d H:i:s"),
      'dated' => date("Y-m-d"),
    );

    $this->db->where("id_itp_vendor", $data['id_itp']);
    $this->db->update("t_vendor_itp", $dt_itp);

    // update detail
    foreach ($data['material_id'] as $key => $val) {
      $t_itp_detail = array(
        'qty'	=> $data['qty'][$key],
        'priceunit'	=> $data['priceunit'][$key],
        'total' => $data['total'][$key],
      );

      $this->db->where("material_id", $data['material_id'][$key]);
      $this->db->where("id_itp_vendor", $data['id_itp']);
      $this->db->update("t_vendor_itp_detail", $t_itp_detail);
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
         'id_itp_vendor' =>  $data['id_itp'],
         'type'	=> $data['type'],
         'filename'	=> $file,
         'created_date'	=> date("Y-m-d H:i:s"),
       );

       if ($data['filename']["tmp_name"][$i] != "" OR $file != "-") {
         $this->db->insert("t_vendor_itp_upload", $t_itp_upload);
       }

      }
    }

    if (count($data['rm_file']) > 0) {
      foreach ($data['rm_file'] as $k => $val) {
        $this->db->where('id_itp_vendor', $data['id_itp']);
        $this->db->where('filename', $val);
        $this->db->delete('t_vendor_itp_upload');
      }
    }

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
  // --------------------------------------- sendmail  --------------------------------------------

  public function get_comp($id){
    $query = $this->db->query("select a.msr_no, hh.company_desc, k.DEPARTMENT_DESC
    FROM t_itp a
    JOIN t_itp_detail b ON b.id_itp=a.id_itp
    LEFT JOIN m_material c ON c.MATERIAL=b.material_id
    LEFT JOIN t_vendor_itp z ON z.id_itp=a.id_itp
    LEFT JOIN t_vendor_itp_detail x ON x.id_itp_vendor=z.id_itp_vendor AND x.material_id=b.material_id
    LEFT JOIN t_vendor_itp_upload h ON h.id_itp_vendor=z.id_itp_vendor
    LEFT JOIN t_purchase_order q ON q.po_no=a.no_po
    LEFT JOIN t_purchase_order_detail w ON w.po_id=q.po_no
    LEFT JOIN t_msr hh ON hh.msr_no=q.msr_no
    LEFT JOIN m_vendor r ON r.ID=a.id_vendor
    LEFT JOIN m_user m ON m.ID_USER=q.create_by
    LEFT JOIN m_departement k ON k.ID_DEPARTMENT=hh.id_department
    WHERE a.id_itp='".$id."'
    GROUP BY a.msr_no, hh.company_desc, k.DEPARTMENT_DESC");
    return $query->row();
  }

  public function update_is_closed($id_itp){
    $this->db->where("id_itp", $id_itp);
    return $this->db->update("t_itp", ['is_closed' => '1']);
  }

}
