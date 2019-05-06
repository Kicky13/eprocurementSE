<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_itp_document extends CI_Model {

  public function __construct() {
      parent::__construct();
      $this->db = $this->load->database('default', true);
  }

  public function list_itp_onprogress(){
    $query = $this->db->query("select v.msr_no as msr_no, r.description as jabatan, a.id,a.id_itp,b.user_roles, b.email_approve,b.edit_content, b.email_reject,b.sequence,b.status_approve,CASE WHEN count(j.id)>0 THEN CONCAT(b.description,' (DATA DITOLAK)') ELSE b.description END as description,b.reject_step, v.note, y.company_desc, y.msr_type_desc, y.rloc_desc, y.pmethod_desc, y.create_on, y.req_date, y.title, y.id_currency, y.scope_of_work

    FROM (SELECT min(id) as id, id_itp, min(sequence) as sequence FROM t_approval_itp
                   WHERE (status_approve=0 OR status_approve=2)
                   AND extra_case=0
                   GROUP BY id_itp
                  ) a
    JOIN t_approval_itp b ON b.id_itp=a.id_itp AND b.id=a.id
    JOIN t_itp v ON v.id_itp=b.id_itp
    JOIN m_user_roles r ON r.ID_USER_ROLES=b.user_roles
    LEFT JOIN t_msr y ON y.msr_no=v.msr_no
    LEFT JOIN t_approval_itp j ON j.id_itp=b.id_itp AND j.status_approve=2

    group by
    v.msr_no, r.description, a.id,a.id_itp,b.user_roles, b.email_approve,b.edit_content, b.email_reject,b.sequence,b.status_approve,j.id, b.description, b.reject_step, v.note, y.company_desc, y.msr_type_desc, y.rloc_desc, y.pmethod_desc, y.create_on, y.req_date, y.title, y.id_currency, y.scope_of_work");
    return $query->result_array();
  }

  public function show_po_remaining(){
    // $query = $this->db->query("select * from ( select msr_no, msr_type_desc, scope_of_work, title, id_currency, create_on, req_date, sum(spending) as spending, sum(total) as total FROM (select a.msr_no, a.msr_type_desc, a.scope_of_work, a.title, a.id_currency, a.create_on, a.req_date, sum(case when l.b>=l.a then (b.priceunit * b.qty) - x.total else 0 end) as spending, b.qty * b.priceunit as total FROM t_msr a JOIN t_msr_item b ON b.msr_no=a.msr_no LEFT JOIN m_material c ON c.MATERIAL=b.material_id LEFT JOIN t_itp z ON z.msr_no=a.msr_no LEFT JOIN t_itp_detail x ON x.id_itp=z.id_itp AND x.material_id=b.material_id
    // left join (SELECT id_itp,count(1) a,sum(case when status_approve=2 THEN 0 ELSE status_approve END) b FROM `t_approval_itp` group by id_itp) l on l.id_itp=z.id_itp
    // GROUP by a.msr_no, a.msr_type_desc, a.scope_of_work, a.title, a.id_currency, a.create_on, a.req_date, b.qty, b.priceunit) as b GROUP by msr_no, msr_type_desc, scope_of_work, title, id_currency, create_on, req_date) as c where spending < total");
    // $query = $this->db->query("select msr_no, msr_type_desc, scope_of_work, title, id_currency, create_on, req_date, sum(totalmsr),sum(totalitp)
    // from (select m.msr_no,d.description,d.qty * d.priceunit as totalmsr,COALESCE(b.total,0) totalitp, m.msr_type_desc, m.scope_of_work, m.title, m.id_currency, m.create_on, m.req_date
    // from t_msr m
    // join t_msr_item d on d.msr_no=m.msr_no
    // left join (SELECT msr_no,material_id,sum(total) as total
    // FROM t_itp i join t_itp_detail id on id.id_itp=i.id_itp
    // group by msr_no,material_id) b on b.msr_no=d.msr_no and b.material_id=d.material_id ) a
    // group by msr_no, msr_type_desc, scope_of_work, title, id_currency, create_on, req_date");

    $query = $this->db->query("SELECT DISTINCT id_vendor, po_no, po_type, msr_no, title, po_date, delivery_date, payment_term, shipping_term, id_dpoint, id_importation, id_currency, account_name, bank_name, tkdn_type, tkdn_value_goods, tkdn_value_service, create_by, create_on, CURRENCY, vendor FROM (select id_vendor,
    id as id_po, po_no, po_type, msr_no, title, po_date, delivery_date, payment_term, shipping_term, id_dpoint, id_importation, id_currency, account_name, bank_name, tkdn_type, tkdn_value_goods, tkdn_value_service, create_by, create_on, sum(totalmsr) as totalmsr,sum(totalitp) as totalitp, CURRENCY, vendor, blanket
    from (select m.id_vendor, m.blanket, m.id as id_po, m.po_no, m.po_type, m.msr_no, m.title, m.po_date, m.delivery_date, m.payment_term, m.shipping_term, m.id_dpoint, m.id_importation, m.id_currency, m.account_name, m.bank_name, m.tkdn_type, m.tkdn_value_goods, m.tkdn_value_service, m.create_by, m.create_on, d.id, d.po_id, d.id_itemtype, d.material_id, d.semic_no, d.material_desc, d.qty, d.id_uom, d.uom_desc, d.est_unitprice, d.est_total_price, d.unitprice, d.total_price, d.qty * d.unitprice as totalmsr,COALESCE(b.total,0) totalitp, w.CURRENCY, n.NAMA as vendor
    from t_purchase_order m
    join t_purchase_order_detail d on d.po_id=m.id
    JOIN m_vendor n ON n.ID=m.id_vendor
    JOIN m_currency w ON w.ID=m.id_currency
    left join (SELECT no_po,material_id,sum(total) as total
    FROM t_itp i join t_itp_detail id on id.id_itp=i.id_itp
    group by no_po,material_id) b on b.no_po=d.po_id and b.material_id=d.material_id ) a
    group by vendor,id_vendor, id,po_no, po_type, msr_no, title, po_date, delivery_date, payment_term, shipping_term, id_dpoint, id_importation, id_currency, account_name, bank_name, tkdn_type, tkdn_value_goods, tkdn_value_service, create_by, create_on) as bb where totalmsr>totalitp  AND (po_type='20' OR (po_type='10' AND blanket='1'))");
    return $query->result_array();
  }

  public function __get_item_selection($id){
    // $query = $this->db->query("select sum(case when l.b>=l.a then (b.priceunit * b.qty) - x.total else 0 end) as spending, sum(case when l.b>=l.a then x.total else 0 end) as total, b.id_itemtype, b.description as desc_msrdet, b.priceunit, c.MATERIAL_NAME, c.MATERIAL, c.UOM1, b.qty FROM t_msr a JOIN t_msr_item b ON b.msr_no=a.msr_no LEFT JOIN m_material c ON c.MATERIAL=b.material_id LEFT JOIN t_itp z ON z.msr_no=a.msr_no LEFT JOIN t_itp_detail x ON x.id_itp=z.id_itp AND x.material_id=b.material_id
    // left join (SELECT id_itp,count(1) a,sum(case when status_approve=2 THEN 0 ELSE status_approve END) b FROM `t_approval_itp` group by id_itp) l on l.id_itp=z.id_itp
    // WHERE a.msr_no='".$id."'
    // GROUP BY desc_msrdet, b.priceunit, b.qty, c.MATERIAL_NAME, c.MATERIAL, c.UOM");

    // $query = $this->db->query("select m.msr_no,d.description,d.qty * d.priceunit as totalmsr,COALESCE(b.total,0) totalitp, m.msr_type_desc, m.scope_of_work, m.title, m.id_currency, m.create_on, m.req_date from t_msr m join t_msr_item d on d.msr_no=m.msr_no
    // left join (SELECT msr_no,material_id,sum(total) as total FROM t_itp i join t_itp_detail id on id.id_itp=i.id_itp group by msr_no,material_id) b on b.msr_no=d.msr_no and b.material_id=d.material_id");

    $query = $this->db->query("select a.id_vendor, r.NAMA as vendor,
        COALESCE( sum(sr.qty * sr.price)  ,0) sr_total,
        COALESCE(sr.price, 0) as sr_price,
        COALESCE(sr.qty, 0) as sr_qty,

        CASE WHEN COALESCE( sum(sr.qty * sr.price)  ,0) > COALESCE(sum( x.total ), 0) THEN COALESCE( (b.unitprice * b.qty - sum(x.total) ), 0) ELSE COALESCE( (b.unitprice * b.qty - (COALESCE( sum(sr.qty * sr.price)  ,0)) ), 0) END as sisa,
        CASE WHEN COALESCE( sum(sr.qty * sr.price)  ,0) > COALESCE(sum( x.total ), 0) THEN COALESCE( sum(sr.qty * sr.price)  ,0) ELSE COALESCE(sum( x.total ), 0) END as total,
        CASE WHEN COALESCE( sum(sr.qty * sr.price)  ,0) > COALESCE(sum( x.total ), 0) THEN sr.qty WHEN x.qty IS NULL THEN b.qty ELSE x.qty END as qty,
        b.id as id_po_det,
        b.po_id,
        b.id_itemtype,
        b.sop_bid_id as material_id,
        b.semic_no,
        b.material_desc as MATERIAL_NAME,
        b.unitprice as priceunit,
        b.id_uom,
        b.uom_desc,

        b.est_total_price,
        b.total_price,
        c.MATERIAL_NAME as mname,
        b.sop_bid_id as MATERIAL,
        b.uom_desc as UOM1,
        a.msr_no, 'ID' as dt_comp
        FROM t_purchase_order a
        JOIN t_purchase_order_detail b ON b.po_id=a.id
        LEFT JOIN m_material c ON c.MATERIAL=b.material_id
        LEFT JOIN t_itp z ON z.no_po=a.po_no
        LEFT JOIN t_itp_detail x ON x.id_itp=z.id_itp AND x.material_id=b.material_id
        LEFT JOIN t_service_receipt_detail sr ON sr.id_itp=x.id_itp AND sr.id_material=x.material_id
        JOIN m_vendor r ON r.ID=a.id_vendor
        WHERE a.po_no='".$id."'
        GROUP BY r.NAMA,a.id_vendor, b.id, b.po_id, b.id_itemtype, b.material_id, b.semic_no, b.material_desc, b.qty, b.id_uom, b.uom_desc, b.unitprice, b.est_total_price, b.unitprice, b.total_price, c.MATERIAL_NAME, MATERIAL, UOM1, b.qty, a.msr_no, dt_comp, sr.price, sr.qty, x.qty");
    return $query->result_array();
  }

  public function get_item_selection($id){
    $query = $this->db->query("
        SELECT
            a.id_vendor,
            r.NAMA as vendor,
            b.id as id_po_det,
            b.po_id,
            b.id_itemtype,
            b.material_id,
            b.semic_no,
            b.material_desc as MATERIAL_NAME,
            b.unitprice as priceunit,
            b.id_uom,
            b.uom_desc,
            b.est_total_price,
            b.total_price,
            c.MATERIAL_NAME as mname,
            b.sop_bid_id as MATERIAL,
            b.uom_desc as UOM1,
            a.msr_no, 'ID' as dt_comp,
            b.qty,
            COALESCE(receipt.itp_qty,0) as itp_qty,
            COALESCE(receipt.itp_total,0) as itp_total,
            COALESCE(receipt.sr_qty,0) as sr_qty,
            COALESCE(receipt.sr_total,0) as sr_total,
            COALESCE(receipt.total_receipt,0) as total_receipt
        FROM t_purchase_order a
        JOIN t_purchase_order_detail b ON b.po_id=a.id
        LEFT JOIN (
            SELECT
                a.no_po,
                b.material_id,
                SUM(b.qty) as itp_qty,
                SUM(b.total) as itp_total,
                SUM(c.qty) as sr_qty,
                SUM(c.total) as sr_total,
                SUM(
                    CASE WHEN b.total > COALESCE(c.total,0) THEN b.qty
                    ELSE c.qty
                    END
                ) AS qty_receipt,
                SUM(
                    CASE WHEN b.total > COALESCE(c.total,0) THEN b.total
                    ELSE c.total
                    END
                ) AS total_receipt
            FROM t_itp a
            JOIN t_itp_detail b ON b.id_itp = a.id_itp
            LEFT JOIN (
                SELECT t_service_receipt_detail.id_itp, t_service_receipt_detail.id_material, SUM(qty) as qty, SUM(total) as total FROM t_service_receipt_detail
                JOIN t_service_receipt ON t_service_receipt.id = t_service_receipt_detail.id_service_receipt
                WHERE t_service_receipt.cancel = 0
                GROUP BY t_service_receipt_detail.id_itp, t_service_receipt_detail.id_material
            ) c ON c.id_itp = b.id_itp AND c.id_material = b.material_id
            GROUP BY a.no_po, b.material_id
        ) receipt ON a.po_no = receipt.no_po AND receipt.material_id = b.sop_bid_id
        LEFT JOIN m_material c ON c.MATERIAL=b.material_id
        JOIN m_vendor r ON r.ID=a.id_vendor
        WHERE a.po_no='".$id."'
        GROUP BY r.NAMA,a.id_vendor, b.id, b.po_id, b.id_itemtype, b.material_id, b.semic_no, b.material_desc, b.qty, b.id_uom, b.uom_desc, b.unitprice, b.est_total_price, b.unitprice, b.total_price, c.MATERIAL_NAME, MATERIAL, UOM1, b.qty, a.msr_no, dt_comp
    ");
    return $query->result_array();
  }

  public function create_itp_document($data){

    $query1 = $this->db->select("ID_DEPARTMENT")->from("m_user")->where("ID_USER", $this->session->userdata['ID_USER'])->get();
    $row1 = $query1->row();
    $query = $this->db->query("SELECT COUNT(1)+1 as total FROM t_itp WHERE itp_no LIKE '%".date("Y")."%'");
    $row2 = $query->row();
    $lenidmax = strlen($row2->total);
    $increment = str_repeat('0',6-$lenidmax).$row2->total;
    $kode = $increment."/ITP/J/".date("m")."/".date("Y")."/".$row1->ID_DEPARTMENT;

    // insert itp
    $t_itp = array(
      'msr_no' => $data['msr_no'],
      'no_po' => $data['no_po'],
      'note' => $data['note'],
      'created_by' => $this->session->userdata['ID_USER'],
      'created_date' => date("Y-m-d H:i:s"),
      'dated' => $data['dated'],
      'id_vendor' => $data['id_vendor'],
      'itp_no' => $kode,
      'number_of' => $data['number_of'],
    );
    $this->db->insert('t_itp', $t_itp);
    $insert_id = $this->db->insert_id();

    // insert detail
    foreach ($data['material_id'] as $key => $val) {
      $t_itp_detail = array(
        'id_itp' =>  $insert_id,
        'material_id'	=> $data['material_id'][$key],
        'qty'	=> $data['qty'][$key],
        // 'qty'	=> $data['total'][$key] / $data['priceunit'][$key],
        'priceunit'	=> number_value($data['priceunit'][$key]),
        'total' => number_value($data['total'][$key]),
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

     if ($data['filename']["tmp_name"][$i] != "" OR $file != "-") {
       $this->db->insert("t_itp_upload", $t_itp_upload);
     }

    }

    $query_modul = $this->db->query("SELECT * FROM m_approval_modul WHERE description LIKE '%ITP DOCUMENT USER%'");
    foreach ($query_modul->result_array() as $arr) {
      $insert_t_approval = $this->db->query(
        "INSERT INTO t_approval_itp
          SELECT
            null,
            '".$insert_id."' AS id_itp,
            '%' AS id_user,
            user_roles,sequence,
            0 AS status_approve,
            description,
            reject_step,
            email_approve,
            email_reject,
            edit_content,
            extra_case,
            null as note,
            null as approve_by,
            now(),
            now()
          FROM m_approval_rule
          WHERE module='".$arr['id']."'
          AND status='1'
          ORDER BY sequence"
      );
    }

    $query = $this->db->query("SELECT * FROM t_jabatan a JOIN m_user b ON b.ID_USER=a.user_id WHERE a.user_id = '".$this->session->userdata['ID_USER']."' ");
    $par_id = $query->row()->parent_id;
    $query1 = $this->db->query("SELECT * FROM t_jabatan a JOIN m_user b ON b.ID_USER=a.user_id WHERE a.id = '".$par_id."' ");
    $usr_id = $query1->row()->user_id;

    $user_mgr = array(
      'id_user' => $usr_id,
    );
    $this->db->where("id_itp", $insert_id);
    $this->db->like("description",'USER MANAGER');
    $this->db->update("t_approval_itp", $user_mgr);

    $status_approve = array(
      'status_approve' => '1',
      'note' => 'Approved',
      'approve_by' => $this->session->userdata('ID_USER')
    );
    $this->db->where("id_itp", $insert_id);
    $this->db->where("sequence", '1');
    $this->db->update("t_approval_itp", $status_approve);
    return $t_itp;
  }

  public function show_data_itp($msr_no){
    $result = array();


    $q_itp = $this->db->select("*")->from("t_itp")->where("msr_no", $msr_no)->get();
    foreach ($q_itp->result_array() as $key => $arr) {
      $q_itp_detail = $this->db->select("a.*, b.*, d.id_itemtype, d.uom")->from("t_itp_detail a")->join("m_material b", "b.MATERIAL=a.material_id")->join("t_itp c", "c.id_itp=a.id_itp")->join("t_msr_item d", "d.msr_no=c.msr_no")->where("a.id_itp", $arr['id_itp'])->group_by("a.material_id")->get();
      $result2 = array();
      foreach ($q_itp_detail->result_array() as $key2 => $arr2) {
        $result2[] = array(
          'data_itp_detail' => $arr2,
        );
        $q_itp_upload = $this->db->select("*")->from("t_itp_upload")->where("id_itp", $arr['id_itp'])->get();
        $result3 = array();
        foreach ($q_itp_upload->result_array() as $ke3y => $arr3) {
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

  public function get_comp($id){
    $query = $this->db->query("select a.msr_no, h.company_desc, k.DEPARTMENT_DESC, '' AS number_of
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
    $query->row()->number_of = $this->number_of_itp($id);
    return $query->row();
  }

  public function number_of_itp($no_po){
    $qq = $this->db->query("select COUNT(no_po)+1 AS number_of FROM t_itp WHERE no_po = '".$no_po."'");
    return $qq->row()->number_of;
  }

}
