<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_service_receive_notification extends CI_Model {

  public function __construct() {
      parent::__construct();
      $this->db = $this->load->database('default', true);
  }

  public function list_itp_onprogress(){
    $query2 = $this->db->query("SELECT COALESCE(max(sequence), 0) as max_sequence FROM t_approval_itp_vendor a JOIN t_vendor_itp b ON b.id_itp=a.id_itp");
    $query = $this->db->query("select a.id_itp as id_itp_vendor, a.user_roles,a.email_approve,a.extra_case, a.email_reject,a.sequence,a.status_approve, a.reject_step, min(a.id) as id, a.status_approve as sum_approve, COUNT(1) as count_row, min(a.sequence) as sequence, h.no_po, h.itp_no, v.note, v.id_itp, REPLACE(a.description, a.description, 'SEMUA DATA TELAH DISETUJUI') as description, v.created_date
    FROM t_approval_itp_vendor a
    JOIN t_vendor_itp v ON v.id_itp_vendor=a.id_itp
    JOIN t_itp h on h.id_itp=v.id_itp
    WHERE a.status_approve='1' AND a.extra_case='0' AND a.sequence='".$query2->row()->max_sequence."' AND v.is_closed='0' AND h.id_vendor='".$this->session->ID."'
    GROUP BY a.user_roles,a.email_approve,a.extra_case, a.email_reject,a.sequence,a.status_approve, a.reject_step, v.id_itp, id_itp_vendor, h.no_po, h.itp_no, v.note, description, v.created_date
    ");
    return $query->result_array();
  }

  public function show_msr_remaining(){
    $query = $this->db->query("SELECT * FROM t_msr WHERE msr_no NOT IN (select a.msr_no as msr FROM t_msr a join t_itp b on b.msr_no=a.msr_no)");
    return $query->result_array();
  }

  public function get_item_selection($id){
    $query = $this->db->query("select a.itp_no, a.id_vendor, a.no_po, r.NAMA as vendor, COALESCE( (b.priceunit * b.qty - x.total ), 0) as spending, COALESCE(x.total, 0) as total, x.total as total_det, b.priceunit, x.qty as vqty, b.qty, w.material_desc AS MATERIAL_NAME, w.material_id AS MATERIAL, w.uom_desc AS UOM1, w.id_itemtype, 'ID' as dt_comp
    FROM t_itp a
    JOIN t_itp_detail b ON b.id_itp=a.id_itp
    LEFT JOIN t_vendor_itp z ON z.id_itp=a.id_itp
    LEFT JOIN t_vendor_itp_detail x ON x.id_itp_vendor=z.id_itp_vendor AND x.material_id=b.material_id
    LEFT JOIN t_vendor_itp_upload h ON h.id_itp_vendor=z.id_itp_vendor
    LEFT JOIN t_purchase_order q ON q.po_no=a.no_po
    LEFT JOIN t_purchase_order_detail w ON w.po_id=q.id AND w.material_id=b.material_id
    LEFT JOIN m_vendor r ON r.ID=a.id_vendor
    WHERE z.id_itp_vendor='".$id."'
    GROUP BY a.itp_no, a.id_vendor, a.no_po, r.NAMA, b.priceunit, x.qty, b.qty, MATERIAL_NAME, MATERIAL, UOM1, w.id_itemtype, x.total, dt_comp");
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

  public function show_data_itp($idc){
    $result = array();

    $q_itp = $this->db->select("*")->from("t_vendor_itp")->where("id_itp_vendor", $idc)->get();
    foreach ($q_itp->result_array() as $key => $arr) {
      $q_itp_detail = $this->db->query("SELECT a.material_id, a.id_itp_vendor, a.qty, a.priceunit, a.total, d.material_id AS MATERIAL, d.semic_no AS MATERIAL_CODE, d.material_desc AS MATERIAL_NAME, d.semic_no AS REQUEST_NO, d.material_desc AS DESCRIPTION, d.id_itemtype, d.uom_desc as uom, a.remark
      FROM t_vendor_itp_detail a
      JOIN t_vendor_itp c ON c.id_itp_vendor=a.id_itp_vendor
      JOIN t_itp g ON g.id_itp=c.id_itp
      JOIN t_purchase_order po ON po.po_no=g.no_po
      JOIN t_purchase_order_detail d ON d.po_id=po.id and d.material_id=a.material_id
      WHERE a.id_itp_vendor = '".$arr['id_itp_vendor']."'
      GROUP BY a.material_id, a.id_itp_vendor, a.qty, a.priceunit, a.total, MATERIAL, MATERIAL_CODE, MATERIAL_NAME, REQUEST_NO, DESCRIPTION, d.id_itemtype, d.uom_desc, a.remark");
      $result2 = array();
      foreach ($q_itp_detail->result_array() as $key2 => $arr2) {
        $result3 = array();
        $result2[] = array(
          'data_itp_detail' => $arr2,
        );
        $q_itp_upload = $this->db->select("*")->from("t_vendor_itp_upload")->where("id_itp_vendor", $arr['id_itp_vendor'])->get();
        foreach ($q_itp_upload->result_array() as $key3 => $arr3) {
          $result3[] = array(
            'data_itp_upload' => $arr3,
          );
        }
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
    // $sequence_status = $data['sequence_rej'] - $data['reject_step_rej'];
    // $upd_status_reject = array(
    //   'status_approve' => '2',
    // );
    // $upd_status_0 = array(
    //   'status_approve' => '0',
    //   'extra_case' => '1',
    // );
    // $this->db->where("sequence >=", $sequence_status);
    // $this->db->where("id_itp", $data['id_itp_rej']);
    // $this->db->update("t_approval_itp_vendor", $upd_status_0);
    // $this->db->where("id", $data['id_rej']);
    // $this->db->update("t_approval_itp_vendor", $upd_status_reject);

    $sequence_status = $data['sequence_rej'] - $data['reject_step_rej'];

    $upd_status_reject = array(
      'status_approve' => '2',
    );

    $upd_status_0 = array(
      'status_approve' => '0',
      'extra_case' => '1',
    );

    $this->db->where("sequence >=", $sequence_status);
    $this->db->where("id_itp", $data['id_itp_rej']);
    $this->db->update("t_approval_itp_vendor", $upd_status_0);

    $this->db->where("sequence", $sequence_status);
    $this->db->where("id_itp", $data['id_itp_rej']);
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

}
