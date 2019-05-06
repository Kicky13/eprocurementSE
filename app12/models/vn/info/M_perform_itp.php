<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_perform_itp extends CI_Model {

  public function __construct() {
      parent::__construct();
      $this->db = $this->load->database('default', true);
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

  public function list_itp_onprogress(){
    $query = $this->db->query("select v.msr_no as msr_no, r.description as jabatan, a.id,a.id_itp,b.user_roles,b.email_approve,b.edit_content, b.email_reject,b.sequence,b.status_approve,CASE WHEN count(j.id)>0 THEN CONCAT(b.description,' (DATA DITOLAK)') ELSE b.description END as description,b.reject_step, v.note, y.company_desc, y.msr_type_desc, y.rloc_desc, y.pmethod_desc, y.create_on, y.req_date, y.title, y.id_currency, y.scope_of_work

    FROM (SELECT min(id) as id, id_itp, min(sequence) as sequence FROM t_approval_itp
                   WHERE (status_approve=0 OR status_approve=2)
                   AND extra_case=0
                   GROUP BY id_itp
                  ) a
    JOIN t_approval_itp b ON b.id_itp=a.id_itp AND b.id=a.id
    JOIN t_itp v ON v.id_itp=b.id_itp
    JOIN m_user_roles r ON r.ID_USER_ROLES=b.user_roles
    LEFT JOIN t_purchase_order y ON y.po_no=v.no_po
    LEFT JOIN t_approval_itp j ON j.id_itp=b.id_itp AND j.status_approve=2

    group by
    r.description,a.id,a.id_itp,b.user_roles,b.status_approve,b.description,b.reject_step,v.note");
    return $query->result_array();
  }

  public function show_itpuser_remaining(){
    $query = $this->db->query("select case when COALESCE(is_vendor_acc,0)=1 THEN 'ACCEPTED' ELSE 'UNCONFIRM' END as is_accept ,a.itp_no, a.msr_no, mv.NAMA as id_vendor, a.no_po, a.note, a.created_date, a.dated, b.id_itp, c.total, a.is_vendor_acc
    FROM t_itp a
    JOIN (SELECT id_itp, COUNT(status_approve) as count_apprv, SUM(CASE WHEN status_approve != 1 THEN 0 ELSE status_approve END) as total_apprv
          FROM t_approval_itp GROUP BY id_itp, status_approve) b ON b.id_itp=a.id_itp
          JOIN (SELECT id.id_itp, sum(total) as total FROM t_itp i
                JOIN t_itp_detail id on id.id_itp=i.id_itp
                GROUP BY id.id_itp) as c ON c.id_itp=a.id_itp
    LEFT JOIN (SELECT k.id_itp, SUM(total) as total_vendor FROM t_vendor_itp k
              JOIN t_vendor_itp_detail l ON l.id_itp_vendor=k.id_itp_vendor GROUP BY k.id_itp, total) as d ON d.id_itp=a.id_itp
              JOIN m_vendor mv ON mv.ID=a.id_vendor
              WHERE (total_apprv=count_apprv or total_vendor < total) AND a.id_vendor='".$this->session->ID."' AND COALESCE(a.is_vendor_acc,0)=0
    GROUP BY a.itp_no, a.msr_no, a.id_vendor, a.no_po, a.note, a.created_date, a.dated, b.id_itp, c.total, a.is_vendor_acc");
    return $query->result_array();
  }

  public function get_item_selection($id){
    $query = $this->db->query("select DISTINCT a.itp_no, a.itp_no as id_itemtype, r.NAMA, COALESCE( (b.priceunit * b.qty) - SUM(x.total), 0) as sisa, b.priceunit, pod.material_desc as MATERIAL_NAME, pod.sop_bid_id as MATERIAL, pod.uom_desc AS UOM1, b.qty, COALESCE( SUM(b.total), 0) as total, COALESCE(a.is_vendor_acc, 0) as is_vendor_acc, b.remark, a.no_po
    FROM t_itp a
    JOIN t_itp_detail b ON b.id_itp=a.id_itp
    JOIN t_purchase_order po ON po.po_no=a.no_po
    JOIN t_purchase_order_detail pod ON pod.po_id=po.id AND pod.sop_bid_id=b.material_id
    LEFT JOIN t_vendor_itp z ON z.id_itp=a.id_itp
    LEFT JOIN t_vendor_itp_detail x ON x.id_itp_vendor=z.id_itp_vendor AND x.material_id=b.material_id
    JOIN m_vendor r ON r.ID=a.id_vendor
    WHERE a.id_itp='".$id."'
    GROUP BY a.itp_no, id_itemtype, r.NAMA,pod.sop_bid_id, b.priceunit, pod.material_desc, pod.material_id, pod.uom_desc, b.qty, a.is_vendor_acc, b.remark, a.no_po");

    return $query->result_array();
    // return $this->db->last_query();
  }

  public function create_itp_document($data){
    // insert itp
    $t_itp = array(
      'id_itp' => $data['id_itp'],
      'no_po' => $data['no_po'],
      'note' => $data['note'],
      'created_by' => '1',
      'created_date' => date("Y-m-d H:i:s"),
      'dated' => $data['dated'],
    );
    $this->db->insert('t_vendor_itp', $t_itp);
    $insert_id = $this->db->insert_id();

    // insert detail
    foreach ($data['material_id'] as $key => $val) {
      $t_itp_detail = array(
        'id_itp_vendor' =>  $insert_id,
        'material_id'	=> $data['material_id'][$key],
        'qty'	=> $data['qty'][$key],
        'priceunit'	=> $data['priceunit'][$key],
        'total' => $data['total'][$key],
        'remark' => $data['remark'][$key],
      );
      $this->db->insert('t_vendor_itp_detail', $t_itp_detail);
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
       'id_itp_vendor' =>  $insert_id,
       'type'	=> $data['type'],
       'filename'	=> $file,
       'created_date'	=> date("Y-m-d H:i:s"),
     );

     if ($data['filename']["tmp_name"][$i] != "" OR $file != "-") {
       $this->db->insert("t_vendor_itp_upload", $t_itp_upload);
     }

    }

    $query_modul = $this->db->query("SELECT * FROM m_approval_modul WHERE description LIKE '%ITP DOCUMENT VENDOR%'");
    foreach ($query_modul->result_array() as $arr) {
      $insert_t_approval = $this->db->query(
        "INSERT INTO t_approval_itp_vendor SELECT null,".$insert_id." AS id_itp, '%' AS id_user, user_roles,sequence,0 AS status_approve,description,reject_step,email_approve,email_reject,edit_content,extra_case,now(),now() from m_approval_rule WHERE module='".$arr['id']."' AND status='1' ORDER BY sequence"
      );
    }

    $quser = $this->db->query("SELECT created_by FROM t_itp WHERE id_itp = '".$data['id_itp']."' ");
    $query = $this->db->query("SELECT * FROM t_jabatan a JOIN m_user b ON b.ID_USER=a.user_id WHERE a.user_id = '".$quser->row()->created_by."' ");
    $par_id = $query->row()->parent_id;
    $query1 = $this->db->query("SELECT * FROM t_jabatan a JOIN m_user b ON b.ID_USER=a.user_id WHERE a.id = '".$par_id."' ");
    $usr_id = $query1->row()->user_id;

    $user_mgr = array(
      'id_user' => $usr_id,
    );
    $this->db->where("id_itp", $insert_id);
    $this->db->like("description",'USER MANAGER');
    $this->db->update("t_approval_itp_vendor", $user_mgr);

  }


  public function show_data_itp($msr_no){
    $result = array();
    $result3 = array();
    $q_itp = $this->db->select("*")->from("t_itp")->where("msr_no", $msr_no)->get();
    foreach ($q_itp->result_array() as $key => $arr) {
      $q_itp_detail = $this->db->select("a.*, b.*, d.id_itemtype, d.uom")->from("t_itp_detail a")->join("m_material b", "b.MATERIAL=a.material_id")->join("t_itp c", "c.id_itp=a.id_itp")->join("t_msr_item d", "d.msr_no=c.msr_no")->where("a.id_itp", $arr['id_itp'])->group_by("a.material_id")->get();
      $result2 = array();
      foreach ($q_itp_detail->result_array() as $key2 => $arr2) {
        $result2[] = array(
          'data_itp_detail' => $arr2,
        );
        $q_itp_upload = $this->db->select("*")->from("t_itp_upload")->where("id_itp", $arr['id_itp'])->get();
      }
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

  public function accept_document_itp($id){
    $this->db->where("id_itp", $id);
    $this->db->update("t_itp", array('is_vendor_acc' => '1'));
    return true;
  }

  public function reject_itp_doc($data){
    $sequence_status = 1;

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
    $this->db->where("id_itp", $data);
    $this->db->update("t_approval_itp", $upd_status_0);

    $this->db->where("sequence", $sequence_status);
    $this->db->where("id_itp", $data);
    $this->db->update("t_approval_itp", $upd_status_reject);

    if ($sequence_status === 1) {
      $this->db->where("sequence", $sequence_status);
      $this->db->where("id_itp", $data);
      $this->db->update("t_approval_itp", $upd_excase);
    }

    return true;
  }


  public function show_itpuser_accepted(){
    $query = $this->db->query("select case when COALESCE(is_vendor_acc,0)=1 THEN 'ACCEPTED' ELSE 'UNCONFIRM' END as is_accept ,a.itp_no, a.msr_no, mv.NAMA as id_vendor, a.no_po, a.note, a.created_date, a.dated, b.id_itp, c.total, a.is_vendor_acc
    FROM t_itp a
    JOIN (SELECT id_itp, COUNT(status_approve) as count_apprv, SUM(CASE WHEN status_approve != 1 THEN 0 ELSE status_approve END) as total_apprv
          FROM t_approval_itp GROUP BY id_itp, status_approve) b ON b.id_itp=a.id_itp
          JOIN (SELECT id.id_itp, sum(total) as total FROM t_itp i
                JOIN t_itp_detail id on id.id_itp=i.id_itp
                GROUP BY id.id_itp) as c ON c.id_itp=a.id_itp
    LEFT JOIN (SELECT k.id_itp, SUM(total) as total_vendor FROM t_vendor_itp k
              JOIN t_vendor_itp_detail l ON l.id_itp_vendor=k.id_itp_vendor GROUP BY k.id_itp, total) as d ON d.id_itp=a.id_itp
              JOIN m_vendor mv ON mv.ID=a.id_vendor
              WHERE (total_apprv=count_apprv or total_vendor < total) AND a.id_vendor='".$this->session->ID."' AND COALESCE(a.is_vendor_acc,0)=1
    GROUP BY a.itp_no, a.msr_no, a.id_vendor, a.no_po, a.note, a.created_date, a.dated, b.id_itp, c.total, a.is_vendor_acc");
    return $query->result_array();
  }

}
