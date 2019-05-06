<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_all_vendor extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
    }

    public function cek_session() {

        if (!isset($this->session->ID_VENDOR) && !isset($this->session->ID)){
            header('Location:' . base_url());
            exit;
        }
        else if($this->session->ID_VENDOR==''){
            header('Location:' . base_url());
            exit;
        }
        else
            return true;
    }

    public function check_date($open,$close)
    {
        $open_date = $open;
        $close_date = $close;
        $open_date = DateTime::createFromFormat('Y-m-d', $open_date)->format('Y-m-d');
        $close_date = DateTime::createFromFormat('Y-m-d', $close_date)->format('Y-m-d');
        $diff = date_diff(date_create($open_date), date_create($close_date));
        if ($diff->format("%R%a") == 0)
            return(array("msg" => "Validation issued date and expiry date not allow same", "status" => "Error"));
        else if ($diff->format("%R%a") < 0)
            return(array("msg" => "Expired date is not allowed before issued date", "status" => "Error"));
        else
            return true;
    }

    public function check_vendor_data($id)
    {
          $qry = $this->db->select('STATUS')
                ->from('m_status_vendor_data')
                ->where('ID_VENDOR=',$id)
                ->where('STATUS=1')
                ->get();
          if ($qry->num_rows() != 0)
           return $qry->result();
        else
           return false;
    }
    public function remove_vendor_data($id,$data)
    {
        $qry = $this->db->where("ID_VENDOR=",$id)
                ->where('STATUS','1')
                ->update("m_status_vendor_data", $data);
        return $qry;
    }

    public function get_comment($id,$type)
    {
        $qry = $this->db->select('SENDER,VALUE,TIME')
                ->from('m_status_vendor_chat')
                ->group_start()
                    ->where('RECEIVER',$id)
                    ->or_where('SENDER',$id)
                ->group_end()
                ->where('TYPE',$type)
                ->order_by('TIME ASC')
                ->get();
        if ($qry->num_rows() != 0)
           return $qry->result();
        else
           return false;
    }

    public function add($tbl, $data) {
        return $this->db->insert($tbl, $data);
    }

    public function update_supplier($data)
    {
        $qry = $this->db->where("ID=", $this->session->ID)
                ->update("m_vendor", $data);
        return $qry;
    }

    public function update_supplier_new($data)
    {
        return $qry=$this->db->query(
            "INSERT into t_approval_supplier
            SELECT NULL,(SELECT ID FROM m_vendor WHERE ID_VENDOR = '".$data["ID_VENDOR"]."') as suppiler_id,a.user_roles,a.sequence,'0' as status_approve,a.description,a.reject_step,a.email_approve,a.email_reject,a.edit_content,a.module,a.extra_case,NULL as note,NULL as approved,now(),now()
            from m_approval_rule a
            JOIN m_approval_modul m ON m.id=2
            WHERE a.module=m.id and a.status=1 order by a.sequence");
    }

    public function check_vendor($id) {
        $res = $this->db->select("STATUS")
                ->from("m_vendor")
                ->where("ID", $id)
                ->get();
        return $res->result();
    }

    public function submit_data($data) {

        $query = $this->db->where("ID=", $this->session->ID)
                ->update("m_vendor", $data);
        return $query;
    }

    public function update_data($data) {

        $query = $this->db->where("ID=", $this->session->ID)
                ->update("m_vendor", $data);
        return $query;
    }

    public function submit_log($status) {
        $data = array(
            "ID_VENDOR" => $this->session->ID_VENDOR,
            "STATUS" => $status,
            "CREATE_BY" => "1"
        );
        $this->db->insert('log_vendor_acc', $data);
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }

    public function get_email_dest($val) {
        $qry = $this->db->select("TITLE,OPEN_VALUE,CLOSE_VALUE,CATEGORY,ROLES")
                ->from("m_notic ")
                ->where("ID=", $val)
                ->get();
        if ($qry->num_rows() != 0)
            return $qry->result();
        else
            return false;
    }
    public function check_update($id)
    {
        $res=$this->db->select('id')
                        ->from('t_approval_supplier')
                        ->where('supplier_id='.$id.' and module=2')
                        ->get();
        if ($res->num_rows() != 0)
            return true;
        else
            return false;
    }

    public function remove_vendor_update($id)
    {
        return $this->db->where('supplier_id ='.$id.' and module = 2')
                        ->delete('t_approval_supplier');
    }

    public function get_dest($id,$supp,$seq)
    {
        $qry=$this->db->query(
            'select DISTINCT u.email,x.user_roles as recipients,t.user_roles, t.sequence, t.reject_step, t.email_approve, t.email_reject, n.OPEN_VALUE, n.CLOSE_VALUE, n.TITLE
            FROM t_approval_supplier t
            JOIN m_notic n ON n.ID = t.email_approve
            JOIN (select user_roles,supplier_id from t_approval_supplier where supplier_id='.$supp.' and sequence=4
            and (status_approve=0 or status_approve=2)) x on x.supplier_id=t.supplier_id
            LEFT JOIN m_user u ON u.ROLES LIKE CONCAT(\'%,\',x.user_roles,\',%\') AND u.status=1
            WHERE t.id ='.$id);
        // return echopre($this->db->last_query());
        // exit;
        return $qry->result_array();
    }

    public function upd($tabel,$dt,$id,$stat,$app2)
    {
        $q= $this->db->query(
            "UPDATE ".$tabel." as t
            LEFT JOIN t_approval_supplier t2 ON t2.supplier_id = t.supplier_id AND t2.status_approve=2
            SET t.status_approve =".$dt['status_approve'].",t.updatedate='".$dt['updatedate']."' ,t2.status_approve=".$app2.",t2.extra_case=0,t.extra_case=0,t.edit_content=1
            WHERE t.sequence >= ".$dt['seq_strt']." AND t.status_approve =".$stat." AND t.supplier_id =".$id);
        return $q;
    }

    public function get_user($dt, $cnt = 0) {
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

    public function get_notice() {
        $q = $this->db->select("TITLE,OPEN_VALUE,CLOSE_VALUE")
                ->from("m_notic")
                ->where("ID=", "5")
                ->get();
        return $q->result();
    }

    public function get_status() {
        $query = $this->db->select("STATUS")
                ->from("m_vendor")
                ->where("ID=", $this->session->ID)
                ->get();
        return $query->result();
    }

    public function get_fulldt($supp)
    {
        $q= $this->db->select('min(id) as id,min(sequence) as sequence')
                    ->from('t_approval_supplier')
                    ->where('supplier_id=',$_SESSION['ID'])
                    ->where('status_approve=0')
                    ->group_by('supplier_id')
                    ->get();
        return $q->result();
    }

    public function get_status_new()
    {
        $q=$this->db->query(
            'select sum(approval) as wait,sum(isreject) as reject,sum(isfinish) as finish,sum(edits) as edits,sum(extra) as extra
            from (
              select 1 as approval,0 as isreject,0 isfinish,0 as edits,0 as extra from t_approval_supplier where supplier_id='.$_SESSION['ID'].' and status_approve=0
              union
              select 0 as approval,1 as isreject,0 isfinish,0 as edits,0 as extra from t_approval_supplier where supplier_id='.$_SESSION['ID'].' and status_approve=2
              union
              SELECT approval,isreject,CASE
                   WHEN status >= total THEN 1
                   else 0
              end as isfinish,0 as edits,0 as extra
              from (
                select 0 as approval,0 as isreject,
                SUM( CASE
                  WHEN status_approve = 2 THEN 0
                  ELSE status_approve
                  END) as status,count(id) as total
                from t_approval_supplier where supplier_id='.$_SESSION['ID'].') d
              union
              SELECT 0,0,0,0 as edits, CASE WHEN COUNT(1) > 0 THEN 1 ELSE 0 END as extra from t_approval_supplier where supplier_id='.$_SESSION['ID'].'
              and status_approve=0 and extra_case=1
            ) as c
        ');
        return $q->result_array();
    }

    public function get_reject($src) {
        $qry = $this->db->select("GENERAL1,GENERAL2,GENERAL3,LEGAL1,LEGAL2,LEGAL3,LEGAL4,LEGAL5,LEGAL6,LEGAL7,LEGAL8,GNS1,GNS2,GNS3,GNS4,MANAGEMENT1,MANAGEMENT2,BNF1,BNF2,CNE1,CNE2,CSMS,SDKP,KTP,BPJS,BPJSTK")
                ->from('m_status_vendor_data')
                ->where('ID_VENDOR', $this->session->ID_VENDOR)
                ->where('STATUS', $src)
                ->get();
        return $qry->row_array();
    }

    public function get_module()
    {
        $res=$this->db->select('min(sequence),module')
                        ->from('t_approval_supplier')
                        ->where('(status_approve=0 or status_approve=2) and supplier_id='.$_SESSION['ID'])
                        ->group_by('module')
                        ->get();
        return $res->result();
    }

    public function check_gns()
    {
        $qry=$this->db->select("CLASSIFICATION,RISK")
                ->from('m_vendor')
                ->where('ID',$this->session->ID)
                ->get();
        return $qry->result();
    }


    public function get_list_rejected($id) {
        // $id = $this->session->ID;

        $qchekck_prefix = $this->db->query("SELECT CASE WHEN REPLACE(SUBSTR(prefix,locate('.',prefix)),'.','')!='' THEN REPLACE(SUBSTR(prefix,locate('.',prefix)),'.','') ELSE REPLACE(SUBSTR(prefix,1,locate('.',prefix)),'.','') END PREFIX FROM m_vendor WHERE ID = '".$id."'");

        if ($qchekck_prefix->num_rows() > 0) {
          $prefix_id = $qchekck_prefix->row()->PREFIX;
        } else {
          $prefix_id = '';
        }
        $query = $this->db->query("
        SELECT k.code, k.description, a.TOTAL, 'GENERAL1' as LEGAL_DATA, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (SELECT '1' as id , SUM(svd.GENERAL1) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, 'GENERAL2' as LEGAL_DATA, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '2' as id, SUM(svd.GENERAL2) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, 'GENERAL3' as LEGAL_DATA, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '3' as id, SUM(svd.GENERAL3) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, 'LEGAL1' as LEGAL_DATA, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '10' as id, SUM(svd.LEGAL1) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, 'LEGAL2' as LEGAL_DATA, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '11' as id, SUM(svd.LEGAL2) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, 'LEGAL3' as LEGAL_DATA, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '12' as id, SUM(svd.LEGAL3) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, 'LEGAL4' as LEGAL_DATA, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '16' as id, SUM(svd.LEGAL4) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, 'LEGAL5' as LEGAL_DATA, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '13' as id, SUM(svd.LEGAL5) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, 'LEGAL6' as LEGAL_DATA, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '14' as id, SUM(svd.LEGAL6) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, 'LEGAL7' as LEGAL_DATA, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '17' as id, SUM(svd.LEGAL7) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, 'LEGAL8' as LEGAL_DATA, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '18' as id, SUM(svd.LEGAL8) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, 'GNS1' as LEGAL_DATA, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '22' as id, SUM(svd.GNS1) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, 'GNS3' as LEGAL_DATA, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN locate('Penyedia Jasa',v.CLASSIFICATION)>0 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '23' as id, SUM(svd.GNS3) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        JOIN m_vendor v ON v.ID='".$id."'
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, 'GNS2' as LEGAL_DATA, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN locate('Penyedia Barang',v.CLASSIFICATION)>0 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '25' as id, SUM(svd.GNS2) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        JOIN m_vendor v ON v.ID='".$id."'
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, 'GNS4' as LEGAL_DATA, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN locate('Konsultan',v.CLASSIFICATION)>0 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '24' as id, SUM(svd.GNS4) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        JOIN m_vendor v ON v.ID='".$id."'
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, 'MANAGEMENT1' as LEGAL_DATA, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '4' as id, SUM(svd.MANAGEMENT1) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, 'MANAGEMENT2' as LEGAL_DATA, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '5' as id, SUM(svd.MANAGEMENT2) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, 'BNF1' as LEGAL_DATA, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '7' as id, SUM(svd.BNF1) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, 'BNF2' as LEGAL_DATA, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '8' as id, SUM(svd.BNF2) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, 'CNE2' as LEGAL_DATA, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '9' as id, SUM(svd.CNE2) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, 'CSMS' as LEGAL_DATA, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN v.RISK = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '26' as id, SUM(svd.CSMS) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        JOIN m_vendor v ON v.ID='".$id."'
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, 'CNE1' as LEGAL_DATA, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '21' as id, SUM(svd.CNE1) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, 'BPJS' as LEGAL_DATA, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '19' as id, SUM(svd.BPJS) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, 'BPJSTK' as LEGAL_DATA, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '20' as id, SUM(svd.BPJSTK) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, 'SDKP' as LEGAL_DATA, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '15' as id, SUM(svd.SDKP) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, 'KTP' as LEGAL_DATA, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '6' as id, SUM(svd.KTP) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        ");

        return $query;
    }

    // public function get_list_rejected() {
    //     $id = $this->session->ID_VENDOR;
    //     $stat=$this->session->status_vendor;
    //     $status=1;
    //     if($stat == 14 || $stat == 15)
    //         $status=2;
    //     return $dt = $this->db
    //                     ->select("SUM(GENERAL1) GENERAL1, SUM(GENERAL2) GENERAL2, SUM(GENERAL3) GENERAL3, SUM(LEGAL1) LEGAL1, SUM(LEGAL2) LEGAL2, SUM(LEGAL3) LEGAL3, SUM(LEGAL4) LEGAL4, SUM(LEGAL5) LEGAL5, SUM(LEGAL6) LEGAL6,SUM(LEGAL7) LEGAL7,SUM(LEGAL8) LEGAL8, SUM(GNS1) GNS1, SUM(GNS2) GNS2, SUM(GNS3) GNS3,SUM(GNS4) GNS4, SUM(MANAGEMENT1) MANAGEMENT1, SUM(MANAGEMENT2) MANAGEMENT2, SUM(BNF1) BNF1, SUM(BNF2) BNF2, SUM(CNE1) CNE1, SUM(CNE2) CNE2, SUM(CSMS) CSMS")
    //                     ->from('m_status_vendor_data')
    //                     ->where('ID_VENDOR', $id)
    //                     ->where('STATUS',$status)
    //                     ->get()->row_array();
    // }

    // public function get_checklist() {
    //     $id = $this->session->ID;
    //
    //     $query = $this->db->query("
    //     SELECT HEAD,TOTAL,DESC_IND,DESC_ENG,STATUS,SUM(resiko) as RISKS
    //     FROM (
    //             select 'A' HEAD, count(ID_VENDOR) TOTAL, 'Info Perusahaan' DESC_IND, 'Company Information' DESC_ENG, 'REQUIRED' STATUS ,RISK as resiko FROM m_vendor WHERE ID = '" . $id . "' AND CLASSIFICATION != ''
    //             UNION
    //             select 'A' HEAD, count(ID_VENDOR) TOTAL, 'Alamat Perusahaan' DESC_IND, 'Company Address' DESC_ENG, 'REQUIRED' STATUS,0 as resiko FROM m_vendor_address WHERE ID_VENDOR = '" . $id . "' AND STATUS = '1'
    //             UNION
    //             select 'A' HEAD, count(ID_VENDOR) TOTAL, 'Kontak Perusahaan' DESC_IND, 'Company Contact' DESC_ENG, 'REQUIRED' STATUS,0 as resiko FROM m_vendor_contact WHERE ID_VENDOR = '" . $id . "' AND STATUS = '1'
    //             UNION
    //             select 'B' HEAD,  count(ID_VENDOR) TOTAL, 'Akta' DESC_IND, 'Akta' DESC_ENG, 'REQUIRED' STATUS,0 as resiko FROM m_vendor_akta WHERE ID_VENDOR = '" . $id . "' AND STATUS = '1'
    //             union
    //             select 'B' HEAD,  count(ID_VENDOR) TOTAL, 'Surat Izin Usaha' DESC_IND, 'Bussiness License' DESC_ENG, 'REQUIRED' STATUS,0 as resiko FROM m_vendor_legal_other WHERE ID_VENDOR = '" . $id . "' AND (CATEGORY = 'SIUP' OR CATEGORY= 'BKPM') AND STATUS = '1'
    //             UNION
    //             select 'B' HEAD,  count(ID_VENDOR) TOTAL, 'TDP' DESC_IND, 'TDP' DESC_ENG, 'REQUIRED' STATUS,0 as resiko FROM m_vendor_legal_other WHERE ID_VENDOR = '" . $id . "' AND CATEGORY = 'TDP' AND STATUS = '1'
    //             UNION
    //             select 'B' HEAD,  count(ID_VENDOR) TOTAL, 'NPWP' DESC_IND, 'NPWP' DESC_ENG, 'REQUIRED' STATUS,0 as resiko FROM m_vendor_npwp WHERE ID_VENDOR = '" . $id . "' AND STATUS = '1'
    //             UNION
    //             select 'B' HEAD,  count(ID_VENDOR) TOTAL, 'SKT Direktorat Panas Bumi' DESC_IND, 'Geothermal Directorate' DESC_ENG, 'OPTIONAL' STATUS,0 as resiko FROM m_vendor_legal_other WHERE ID_VENDOR = '" . $id . "' AND CATEGORY = 'SKT_EBTKE' AND STATUS = '1'
    //             UNION
    //             select 'B' HEAD,  count(ID_VENDOR) TOTAL, 'Oil and Gas Certificate' DESC_IND, 'Oil and Gas Certificate' DESC_ENG, 'OPTIONAL' STATUS,0 as resiko FROM m_vendor_legal_other WHERE ID_VENDOR = '" . $id . "' AND CATEGORY = 'SKT_MIGAS' AND STATUS = '1'
    //             UNION
    //             select 'B' HEAD,  count(ID_VENDOR) TOTAL, 'SPPKP' DESC_IND, 'SPPKP' DESC_ENG, 'REQUIRED' STATUS,0 as resiko FROM m_vendor_legal_other WHERE ID_VENDOR = '" . $id . "' AND CATEGORY = 'SPPKP' AND STATUS = '1'
    //             UNION
    //             select 'B' HEAD,  count(ID_VENDOR) TOTAL, 'SKT PAJAK' DESC_IND, 'Tax Certificate' DESC_ENG, 'REQUIRED' STATUS,0 as resiko FROM m_vendor_legal_other WHERE ID_VENDOR = '" . $id . "' AND CATEGORY = 'SKT_PAJAK' AND STATUS = '1'
    //             UNION
    //             select 'C' HEAD,  count(ID_VENDOR) TOTAL, 'Sertifikasi Keagenan & Prinsipal' DESC_IND, 'Agency Certification & Principals' DESC_ENG, 'OPTIONAL' STATUS,0 as resiko FROM m_vendor_certification WHERE ID_VENDOR = '" . $id . "' AND STATUS = '1'
    //             UNION
    //             select 'C' HEAD,  count(ID_VENDOR) TOTAL, 'Jasa yang dipasok' DESC_IND, 'Service Supplied' DESC_ENG, 'REQUIRED' STATUS,0 as resiko FROM m_vendor_goods_service WHERE ID_VENDOR = '" . $id . "' AND STATUS = '1' AND TYPE = 'SERVICE'
    //             UNION
    //             select 'C' HEAD,  count(ID_VENDOR) TOTAL, 'Barang yang dipasok' DESC_IND, 'Goods Supplied' DESC_ENG, 'REQUIRED' STATUS,0 as resiko FROM m_vendor_goods_service WHERE ID_VENDOR = '" . $id . "' AND STATUS = '1' AND TYPE = 'GOODS'
    //             UNION
    //             select 'C' HEAD,  count(ID_VENDOR) TOTAL, 'Konsultasi yang dipasok' DESC_IND, 'Consultation Supplied' DESC_ENG, 'REQUIRED' STATUS,0 as resiko FROM m_vendor_goods_service WHERE ID_VENDOR = '" . $id . "' AND STATUS = '1' AND TYPE = 'CONSULTATION'
    //             UNION
    //             select 'D' HEAD,  count(ID_VENDOR) TOTAL, 'Dafar Rekening Bank' DESC_IND, 'List Account Bank' DESC_ENG, 'REQUIRED' STATUS,0 as resiko FROM m_vendor_bank_account WHERE ID_VENDOR = '" . $id . "' AND STATUS = '1'
    //             UNION
    //             select 'D' HEAD,  count(ID_VENDOR) TOTAL, 'Neraca Keuangan' DESC_IND, 'Financial Balance Sheet' DESC_ENG, 'REQUIRED' STATUS,0 as resiko FROM m_vendor_balance_sheet WHERE ID_VENDOR = '" . $id . "' AND STATUS = '1'
    //             UNION
    //             select 'E' HEAD,  count(ID_VENDOR) TOTAL, 'Dewan Direksi' DESC_IND, 'Board of Directors' DESC_ENG, 'REQUIRED' STATUS,0 as resiko FROM m_vendor_directors WHERE ID_VENDOR = '" . $id . "' AND STATUS = '1'
    //             UNION
    //             select 'E' HEAD,  count(ID_VENDOR) TOTAL, 'Daftar Pemilik Saham' DESC_IND, 'List Stock Owners' DESC_ENG, 'OPTIONAL' STATUS,0 as resiko FROM m_vendor_shareholders WHERE ID_VENDOR = '" . $id . "' AND STATUS = '1'
    //             union
    //             select 'F' HEAD,  count(ID_VENDOR) TOTAL, 'Sertifikasi Umum' DESC_IND, 'General Certification' DESC_ENG, 'OPTIONAL' STATUS,0 as resiko FROM m_vendor_legal_other WHERE ID_VENDOR = '" . $id . "' AND CATEGORY = 'CERTIFICATION' AND STATUS = '1'
    //             UNION
    //             select 'F' HEAD,  count(ID_VENDOR) TOTAL, 'Pengalaman Perusahaan' DESC_IND, 'Company Experience' DESC_ENG, 'OPTIONAL' STATUS,0 as resiko FROM m_vendor_experience WHERE ID_VENDOR = '" . $id . "' AND STATUS = '1'
    //             UNION
    //             select 'G' HEAD,  count(ID_VENDOR) TOTAL, 'CSMS' DESC_IND, 'CSMS' DESC_ENG, 'REQUIRED' STATUS,0 as resiko FROM m_vendor_csms WHERE ID_VENDOR = '" . $id . "' AND STATUS = '1'
    //     )a
    //     GROUP BY HEAD,TOTAL,DESC_IND,DESC_ENG,STATUS
    //     ORDER BY HEAD
    //             ");
    //
    //     return $query;
    // }

    public function get_checklist($id) {
        // $id = $this->session->ID;

        $qchekck_prefix = $this->db->query("SELECT CASE WHEN REPLACE(SUBSTR(prefix,locate('.',prefix)),'.','')!='' THEN REPLACE(SUBSTR(prefix,locate('.',prefix)),'.','') ELSE REPLACE(SUBSTR(prefix,1,locate('.',prefix)),'.','') END PREFIX FROM m_vendor WHERE ID = '".$id."'");

        if ($qchekck_prefix->num_rows() > 0) {
          $prefix_id = $qchekck_prefix->row()->PREFIX;
        } else {
          $prefix_id = '';
        }
        $query = $this->db->query("
        SELECT k.code, k.description, a.HEAD, a.TOTAL, REPLACE(LOWER(g.description), ' ', '_') as divname, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.resiko
         FROM (select 'A' HEAD, count(ID_VENDOR) TOTAL, 'Info Perusahaan' DESC_IND, 'Company Information' DESC_ENG, 'REQUIRED' STATUS ,RISK as resiko, '1' as id FROM m_vendor WHERE ID = '".$id."' AND CLASSIFICATION != '') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.HEAD, a.TOTAL, REPLACE(LOWER(g.description), ' ', '_') as divname, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.resiko
         FROM (select '2' as id, 'A' HEAD, count(ID_VENDOR) TOTAL, 'Alamat Perusahaan' DESC_IND, 'Company Address' DESC_ENG, 'REQUIRED' STATUS,0 as resiko FROM m_vendor_address WHERE ID_VENDOR = '".$id."' AND STATUS = '1') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.HEAD, a.TOTAL, REPLACE(LOWER(g.description), ' ', '_') as divname, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.resiko
         FROM (select '3' as id, 'A' HEAD, count(ID_VENDOR) TOTAL, 'Kontak Perusahaan' DESC_IND, 'Company Contact' DESC_ENG, 'REQUIRED' STATUS,0 as resiko FROM m_vendor_contact WHERE ID_VENDOR = '".$id."' AND STATUS = '1') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.HEAD, a.TOTAL, REPLACE(LOWER(g.description), ' ', '_') as divname, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.resiko
         FROM (select '10' as id, 'B' HEAD,  count(ID_VENDOR) TOTAL, 'Akta' DESC_IND, 'Akta' DESC_ENG, 'REQUIRED' STATUS,0 as resiko FROM m_vendor_akta WHERE ID_VENDOR = '".$id."' AND STATUS = '1') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.HEAD, a.TOTAL, REPLACE(LOWER(g.description), ' ', '_') as divname, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.resiko
         FROM (select '11' as id, 'B' HEAD,  count(ID_VENDOR) TOTAL, 'Surat Izin Usaha' DESC_IND, 'Bussiness License' DESC_ENG, 'REQUIRED' STATUS,0 as resiko FROM m_vendor_legal_other WHERE ID_VENDOR = '".$id."' AND (CATEGORY = 'SIUP' OR CATEGORY= 'BKPM') AND STATUS = '1') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.HEAD, a.TOTAL, REPLACE(LOWER(g.description), ' ', '_') as divname, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.resiko
         FROM (select '12' as id, 'B' HEAD,  count(ID_VENDOR) TOTAL, 'TDP' DESC_IND, 'TDP' DESC_ENG, 'REQUIRED' STATUS,0 as resiko FROM m_vendor_legal_other WHERE ID_VENDOR = '".$id."' AND CATEGORY = 'TDP' AND STATUS = '1') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.HEAD, a.TOTAL, REPLACE(LOWER(g.description), ' ', '_') as divname, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.resiko
         FROM (select '16' as id, 'B' HEAD,  count(ID_VENDOR) TOTAL, 'NPWP' DESC_IND, 'NPWP' DESC_ENG, 'REQUIRED' STATUS,0 as resiko FROM m_vendor_npwp WHERE ID_VENDOR = '".$id."' AND STATUS = '1') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.HEAD, a.TOTAL, REPLACE(LOWER(g.description), ' ', '_') as divname, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.resiko
         FROM (select '13' as id, 'B' HEAD,  count(ID_VENDOR) TOTAL, 'SKT Direktorat Panas Bumi' DESC_IND, 'Geothermal Directorate' DESC_ENG, 'OPTIONAL' STATUS,0 as resiko FROM m_vendor_legal_other WHERE ID_VENDOR = '".$id."' AND CATEGORY = 'SKT_EBTKE' AND STATUS = '1') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.HEAD, a.TOTAL, REPLACE(LOWER(g.description), ' ', '_') as divname, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.resiko
         FROM (select '14' as id, 'B' HEAD,  count(ID_VENDOR) TOTAL, 'Oil and Gas Certificate' DESC_IND, 'Oil and Gas Certificate' DESC_ENG, 'OPTIONAL' STATUS,0 as resiko FROM m_vendor_legal_other WHERE ID_VENDOR = '".$id."' AND CATEGORY = 'SKT_MIGAS' AND STATUS = '1') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.HEAD, a.TOTAL, REPLACE(LOWER(g.description), ' ', '_') as divname, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.resiko
         FROM (select '17' as id, 'B' HEAD,  count(ID_VENDOR) TOTAL, 'SPPKP' DESC_IND, 'SPPKP' DESC_ENG, 'REQUIRED' STATUS,0 as resiko FROM m_vendor_legal_other WHERE ID_VENDOR = '".$id."' AND CATEGORY = 'SPPKP' AND STATUS = '1') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.HEAD, a.TOTAL, REPLACE(LOWER(g.description), ' ', '_') as divname, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.resiko
         FROM (select '18' as id, 'B' HEAD,  count(ID_VENDOR) TOTAL, 'SKT PAJAK' DESC_IND, 'Tax Certificate' DESC_ENG, 'REQUIRED' STATUS,0 as resiko FROM m_vendor_legal_other WHERE ID_VENDOR = '".$id."' AND CATEGORY = 'SKT_PAJAK' AND STATUS = '1') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.HEAD, a.TOTAL, REPLACE(LOWER(g.description), ' ', '_') as divname, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.resiko
         FROM (select '22' as id, 'C' HEAD,  count(ID_VENDOR) TOTAL, 'Sertifikasi Keagenan & Prinsipal' DESC_IND, 'Agency Certification & Principals' DESC_ENG, 'OPTIONAL' STATUS,0 as resiko FROM m_vendor_certification WHERE ID_VENDOR = '".$id."' AND STATUS = '1') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.HEAD, a.TOTAL, REPLACE(LOWER(g.description), ' ', '_') as divname, g.description as DESC_IND, g.description as DESC_ENG, CASE WHEN locate('Penyedia Jasa',v.CLASSIFICATION)>0 THEN 1 ELSE b.ismandatory END as ismandatory,CASE WHEN locate('Penyedia Jasa',v.CLASSIFICATION)>0 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.resiko
         FROM (select '23' as id, 'C' HEAD,  count(ID_VENDOR) TOTAL, 'Jasa yang dipasok' DESC_IND, 'Service Supplied' DESC_ENG, 'REQUIRED' STATUS,0 as resiko FROM m_vendor_goods_service WHERE ID_VENDOR = '".$id."' AND STATUS = '1' AND TYPE = 'SERVICE') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        JOIN m_vendor v on v.id='".$id."'
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.HEAD, a.TOTAL, REPLACE(LOWER(g.description), ' ', '_') as divname, g.description as DESC_IND, g.description as DESC_ENG, CASE WHEN locate('Penyedia Barang',v.CLASSIFICATION)>0 THEN 1 ELSE b.ismandatory END as ismandatory,CASE WHEN locate('Penyedia Barang',v.CLASSIFICATION)>0 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.resiko
         FROM (select '25' as id, 'C' HEAD,  count(ID_VENDOR) TOTAL, 'Barang yang dipasok' DESC_IND, 'Goods Supplied' DESC_ENG, 'REQUIRED' STATUS,0 as resiko FROM m_vendor_goods_service WHERE ID_VENDOR = '".$id."' AND STATUS = '1' AND TYPE = 'GOODS') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        JOIN m_vendor v on v.id='".$id."'
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.HEAD, a.TOTAL, REPLACE(LOWER(g.description), ' ', '_') as divname, g.description as DESC_IND, g.description as DESC_ENG, CASE WHEN locate('Konsultan',v.CLASSIFICATION)>0 THEN 1 ELSE b.ismandatory END as ismandatory,CASE WHEN locate('Konsultan',v.CLASSIFICATION)>0 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.resiko
         FROM (select '24' as id, 'C' HEAD,  count(ID_VENDOR) TOTAL, 'Konsultasi yang dipasok' DESC_IND, 'Consultation Supplied' DESC_ENG, 'REQUIRED' STATUS,0 as resiko FROM m_vendor_goods_service WHERE ID_VENDOR = '".$id."' AND STATUS = '1' AND TYPE = 'CONSULTATION') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        JOIN m_vendor v on v.id='".$id."'
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.HEAD, a.TOTAL, REPLACE(LOWER(g.description), ' ', '_') as divname, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.resiko
         FROM (select '8' as id, 'D' HEAD,  count(ID_VENDOR) TOTAL, 'Dafar Rekening Bank' DESC_IND, 'List Account Bank' DESC_ENG, 'REQUIRED' STATUS,0 as resiko FROM m_vendor_bank_account WHERE ID_VENDOR = '".$id."' AND STATUS = '1') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.HEAD, a.TOTAL, REPLACE(LOWER(g.description), ' ', '_') as divname, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.resiko
         FROM (select '7' as id, 'D' HEAD,  count(ID_VENDOR) TOTAL, 'Neraca Keuangan' DESC_IND, 'Financial Balance Sheet' DESC_ENG, 'REQUIRED' STATUS,0 as resiko FROM m_vendor_balance_sheet WHERE ID_VENDOR = '".$id."' AND STATUS = '1') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.HEAD, a.TOTAL, REPLACE(LOWER(g.description), ' ', '_') as divname, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.resiko
         FROM (select '4' as id, 'E' HEAD,  count(ID_VENDOR) TOTAL, 'Dewan Direksi' DESC_IND, 'Board of Directors' DESC_ENG, 'REQUIRED' STATUS,0 as resiko FROM m_vendor_directors WHERE ID_VENDOR = '".$id."' AND STATUS = '1') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.HEAD, a.TOTAL, REPLACE(LOWER(g.description), ' ', '_') as divname, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.resiko
         FROM (select '5' as id, 'E' HEAD,  count(ID_VENDOR) TOTAL, 'Daftar Pemilik Saham' DESC_IND, 'List Stock Owners' DESC_ENG, 'OPTIONAL' STATUS,0 as resiko FROM m_vendor_shareholders WHERE ID_VENDOR = '".$id."' AND STATUS = '1') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.HEAD, a.TOTAL, REPLACE(LOWER(g.description), ' ', '_') as divname, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.resiko
         FROM (select '9' as id, 'F' HEAD,  count(ID_VENDOR) TOTAL, 'Pengalaman Perusahaan' DESC_IND, 'Company Experience' DESC_ENG, 'OPTIONAL' STATUS,0 as resiko FROM m_vendor_experience WHERE ID_VENDOR = '".$id."' AND STATUS = '1') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.HEAD, a.TOTAL, REPLACE(LOWER(g.description), ' ', '_') as divname, g.description as DESC_IND, g.description as DESC_ENG, CASE WHEN v.RISK = 1 THEN '1' ELSE b.ismandatory END AS ismandatory,CASE WHEN v.RISK = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.resiko
         FROM (select '26' as id, 'G' HEAD,  count(ID_VENDOR) TOTAL, 'CSMS' DESC_IND, 'CSMS' DESC_ENG, 'REQUIRED' STATUS,0 as resiko FROM m_vendor_csms WHERE ID_VENDOR = '".$id."' AND STATUS = '1') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        JOIN m_vendor v on v.id='".$id."'
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.HEAD, a.TOTAL, REPLACE(LOWER(g.description), ' ', '_') as divname, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.resiko
         FROM (select '21' as id, 'G' HEAD,  count(ID_VENDOR) TOTAL, 'General Certificate' DESC_IND, 'General Certificate' DESC_ENG, 'REQUIRED' STATUS,0 as resiko FROM m_vendor_legal_other WHERE ID_VENDOR = '".$id."' AND CATEGORY = 'CERTIFICATION' AND STATUS = '1') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.HEAD, a.TOTAL, REPLACE(LOWER(g.description), ' ', '_') as divname, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.resiko
         FROM (select '19' as id, 'G' HEAD,  count(ID_VENDOR) TOTAL, 'BPJS' DESC_IND, 'BPJS' DESC_ENG, 'REQUIRED' STATUS,0 as resiko FROM m_vendor_legal_other WHERE ID_VENDOR = '".$id."' AND CATEGORY = 'BPJS' AND STATUS = '1') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.HEAD, a.TOTAL, REPLACE(LOWER(g.description), ' ', '_') as divname, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.resiko
         FROM (select '20' as id, 'G' HEAD,  count(ID_VENDOR) TOTAL, 'BPJSTK' DESC_IND, 'BPJSTK' DESC_ENG, 'REQUIRED' STATUS,0 as resiko FROM m_vendor_legal_other WHERE ID_VENDOR = '".$id."' AND CATEGORY = 'BPJSTK' AND STATUS = '1') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.HEAD, a.TOTAL, REPLACE(LOWER(g.description), ' ', '_') as divname, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.resiko
         FROM (select '15' as id, 'G' HEAD,  count(ID_VENDOR) TOTAL, 'SDKP' DESC_IND, 'SDKP' DESC_ENG, 'REQUIRED' STATUS,0 as resiko FROM m_vendor_legal_other WHERE ID_VENDOR = '".$id."' AND CATEGORY = 'SDKP' AND STATUS = '1') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.HEAD, a.TOTAL, REPLACE(LOWER(g.description), ' ', '_') as divname, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.resiko
         FROM (select '6' as id, 'G' HEAD,  count(id_vendor) TOTAL, 'KTP' DESC_IND, 'KTP' DESC_ENG, 'REQUIRED' STATUS,0 as resiko FROM m_vendor_ktp WHERE id_vendor = '".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        ");

        return $query;
    }

    public function get_header(){
      $this->db->where("active", '1');
      $this->db->order_by('sort ASC');
      $query = $this->db->get("m_vendor_checklist_group");
      return $query->result_array();
    }

}
