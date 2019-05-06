<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_approval extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function menu() {
        $data = $this->db->from('m_menu')->where('STATUS', '1')->get();
        return $data->result();
    }

    public function attch_vendor($id){
        $query = $this->db->select("*")->from("m_vendor_attch_csms")->where("ID_VENDOR", $id)->get();
        return $query->result();
    }

    public function check_risk($id)
    {
        $res=$this->db->select('id')
                        ->from('m_vendor')
                        ->where('RISK=1')
                        ->where('ID',$id)
                        ->get();
        if($res->num_rows() != 0)
            return false;
        else
            return true;
    }

    public function get_email_dest($sup_id,$id,$status,$seq) {
        $qry=array();
        if(($seq != 3 || $seq!=6)&&($status !=13))
        {
            $qry=$this->db->query(
                'SELECT max(t2.sequence) as max_seq,v.URL_BATAS_HARI as hari,v.NAMA,x.user_roles as recipients,t.user_roles, t.sequence, t.reject_step, t.email_approve, t.email_reject, n.OPEN_VALUE, n.CLOSE_VALUE, n.TITLE,t.module
                FROM t_approval_supplier t
                JOIN t_approval_supplier t2 ON t2.supplier_id='.$sup_id.' AND t2.module=t.module
                JOIN m_notic n ON n.ID = t.email_approve
                JOIN m_vendor v ON v.ID = t.supplier_id
                LEFT JOIN (select user_roles,supplier_id from t_approval_supplier where supplier_id='.$sup_id.' and sequence='.$seq.'+1) x on x.supplier_id=t.supplier_id
                WHERE t.id ='.$id.'
                GROUP BY t.sequence,v.NAMA,v.URL_BATAS_HARI,x.user_roles,t.user_roles, t.sequence, t.reject_step, t.email_approve, t.email_reject, n.OPEN_VALUE, n.CLOSE_VALUE, n.TITLE,t.module');
        }
        else
        {
            $qry=$this->db->query(
                'SELECT v.URL_BATAS_HARI as hari,v.NAMA,\'null\' as recipients,t.user_roles, t.sequence, t.reject_step, t.email_approve, t.email_reject, n.OPEN_VALUE, n.CLOSE_VALUE, n.TITLE,t.module
                FROM t_approval_supplier t
                JOIN m_notic n ON n.ID = t.email_reject
                JOIN m_vendor v ON v.ID = t.supplier_id
                WHERE t.id ='.$id);
        }
        $res=$qry->result_array();
        if (count($res) != 0)
            return $res;
        else
            return false;
    }

    public function get_email_rec($roles)
    {
        // $qry = $this->db->query("select DISTINCT email FROM m_user WHERE status = 1 AND  ROLES LIKE '%,".$roles.",%' ESCAPE '!'
        //                       UNION
        //                       select DISTINCT EMAIL FROM m_user WHERE ROLES LIKE '%,29,%'");
        $qry = $this->db->query("select DISTINCT email FROM m_user WHERE status = 1 AND  ROLES LIKE '%,".$roles.",%' ESCAPE '!'");
        if ($qry->num_rows() != 0)
            return $qry->result();
         else
            return false;
    }

    public function get_email_reject($seq, $id)
    {
        $qry = $this->db->query("select EMAIL, TITLE, OPEN_VALUE, CLOSE_VALUE, NAMA as VENDOR FROM t_approval_supplier x
                                JOIN m_user u ON u.ROLES LIKE CONCAT('%,',x.user_roles,',%')
                                JOIN (SELECT xx.supplier_id, nn.OPEN_VALUE, nn.CLOSE_VALUE, nn.TITLE FROM t_approval_supplier xx JOIN m_notic nn ON nn.ID=xx.email_reject WHERE xx.supplier_id=".$id." AND xx.sequence=".$seq.") k ON k.supplier_id=x.supplier_id
                                JOIN m_vendor v ON v.ID='".$id."'
                                WHERE x.supplier_id = '".$id."' AND x.sequence = ".$seq."-1
                                ");
        if ($qry->num_rows() != 0)
            return $qry->result();
         else
            return false;
    }

    public function get_slka($id) {
        $qry = $this->db->query("select N.OPEN_VALUE, N.CLOSE_VALUE, V.NO_SLKA as SLKA, A.ADDRESS, A.TELP, A.FAX
                                FROM m_notic N
                                LEFT JOIN m_vendor V ON V.ID=".$id."
                                LEFT JOIN m_vendor_address A ON A.ID_VENDOR = V.ID AND A.BRANCH_TYPE='HEAD OFFICE'
                                WHERE N.ID = '14'");
        return $qry->result();
    }

    public function get_csms($id)
    {
        $val=$this->db->select("*")
                ->from('m_vendor_csms')
                ->where("ID_VENDOR=",$id)
                ->get();
        if ($val->num_rows() != 0)
           return $val->result();
        else
           return false;

    }

    public function show() {
        $data = $this->db->query(
        "SELECT b.module,r.description as jabatan, a.id, a.supplier_id, b.user_roles, b.status_approve, b.sequence,
            CASE WHEN count(j.id) > 0
                THEN CONCAT(b.description, ' (DATA DITOLAK)')
                ELSE b.description
            END as description, b.reject_step, v.nama, v.ID_VENDOR, v.CREATE_TIME, v.FILE
            FROM (
                SELECT MIN(id) as id, supplier_id, MIN(sequence) as sequence from t_approval_supplier
                WHERE (status_approve = 0 or status_approve = 2) and extra_case = 0
                GROUP BY supplier_id
            ) a
            JOIN t_approval_supplier b on b.supplier_id = a.supplier_id and b.id = a.id
            JOIN m_vendor v on v.id = b.supplier_id
            JOIN m_user_roles r on r.ID_USER_ROLES=b.user_roles
            LEFT JOIN t_approval_supplier j on j.supplier_id = b.supplier_id and j.status_approve = 2
            WHERE b.user_roles in (".substr($_SESSION['ROLES'],1,-1).") AND v.STATUS != '0' AND b.sequence <= 3 and b.module=1
            GROUP BY b.module,r.description, a.id, a.supplier_id, b.user_roles, b.status_approve, b.sequence, b.description, b.reject_step, v.nama, v.ID_VENDOR, v.CREATE_TIME");
        return $data->result_array();
    }

    public function show_temp_email($id) {
        $data = $this->db
                ->select('*')
                ->from('m_notic')
                ->where('ID', $id)
                ->get();
        return $data->row();
    }

    public function add($tbl, $data) {
        return $this->db->insert($tbl, $data);

//        echo $this->db->last_query();exit;
    }

    public function set_pswd($data)
    {
        $dt['PASSWORD']=$data['pass'];
        $dt['STATUS']='2';
        $dt['URL']=$data['URL'];
        $dt['UPDATE_TIME']=date('Y-m-d H:i:s');
        $dt['UPDATE_BY']=$_SESSION['ID_USER'];
        return $this->db->where('ID=',$data['id'])
                ->update('m_vendor',$dt);
    }

    // public function get_checklist($id_vendor){
    //     $dt = $this->db->query(
    //         "SELECT GENERAL1, GENERAL2, GENERAL3,LEGAL1,LEGAL2,LEGAL3,LEGAL4,LEGAL5,LEGAL6,LEGAL7,LEGAL8,GNS1,GNS2,GNS3,MANAGEMENT1,MANAGEMENT2,BNF1,BNF2,CNE1,CNE2,CSMS,RISK
    //         FROM (
    //             SELECT SUM(GENERAL1) GENERAL1, SUM(GENERAL2) GENERAL2, SUM(GENERAL3) GENERAL3, SUM(LEGAL1) LEGAL1, SUM(LEGAL2) LEGAL2, SUM(LEGAL3) LEGAL3, SUM(LEGAL4) LEGAL4, SUM(LEGAL5) LEGAL5, SUM(LEGAL6) LEGAL6,SUM(LEGAL7) LEGAL7,SUM(LEGAL8) LEGAL8, SUM(GNS1) GNS1, SUM(GNS2) GNS2, SUM(GNS3) GNS3, SUM(MANAGEMENT1) MANAGEMENT1, SUM(MANAGEMENT2) MANAGEMENT2, SUM(BNF1) BNF1, SUM(BNF2) BNF2, SUM(CNE1) CNE1, SUM(CNE2) CNE2, SUM(CSMS) CSMS
    //             FROM m_status_vendor_data
    //             WHERE STATUS=1 AND ID_VENDOR='".$id_vendor."'
    //         )a
    //         JOIN m_vendor v ON v.ID_VENDOR='".$id_vendor."'"
    //         );
    //     return $dt->row_array();
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
        SELECT k.code, k.description, a.TOTAL, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (SELECT '1' as id , SUM(svd.GENERAL1) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '2' as id, SUM(svd.GENERAL2) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '3' as id, SUM(svd.GENERAL3) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '10' as id, SUM(svd.LEGAL1) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '11' as id, SUM(svd.LEGAL2) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '12' as id, SUM(svd.LEGAL3) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '16' as id, SUM(svd.LEGAL4) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '13' as id, SUM(svd.LEGAL5) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '14' as id, SUM(svd.LEGAL6) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '17' as id, SUM(svd.LEGAL7) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '18' as id, SUM(svd.LEGAL8) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '22' as id, SUM(svd.GNS1) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, g.description as DESC_IND, g.description as DESC_ENG, CASE WHEN locate('Penyedia Jasa',v.CLASSIFICATION)>0 THEN '1' ELSE b.ismandatory END as ismandatory,CASE WHEN locate('Penyedia Jasa',v.CLASSIFICATION)>0 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '23' as id, SUM(svd.GNS3) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        JOIN m_vendor v ON v.ID='".$id."'
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, g.description as DESC_IND, g.description as DESC_ENG, CASE WHEN locate('Penyedia Barang',v.CLASSIFICATION)>0 THEN '1' ELSE b.ismandatory END as ismandatory,CASE WHEN locate('Penyedia Barang',v.CLASSIFICATION)>0 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '25' as id, SUM(svd.GNS2) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        JOIN m_vendor v ON v.ID='".$id."'
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, g.description as DESC_IND, g.description as DESC_ENG, CASE WHEN locate('Konsultan',v.CLASSIFICATION)>0 THEN '1' ELSE b.ismandatory END as ismandatory,CASE WHEN locate('Konsultan',v.CLASSIFICATION)>0 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '24' as id, SUM(svd.GNS4) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        JOIN m_vendor v ON v.ID='".$id."'
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '4' as id, SUM(svd.MANAGEMENT1) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '5' as id, SUM(svd.MANAGEMENT2) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '7' as id, SUM(svd.BNF1) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '8' as id, SUM(svd.BNF2) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '9' as id, SUM(svd.CNE2) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, g.description as DESC_IND, g.description as DESC_ENG, CASE WHEN v.RISK = 1 THEN '1' ELSE b.ismandatory END as ismandatory,CASE WHEN v.RISK = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '26' as id, SUM(svd.CSMS) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        JOIN m_vendor v ON v.ID='".$id."'
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '21' as id, SUM(svd.CNE1) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '19' as id, SUM(svd.BPJS) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '20' as id, SUM(svd.BPJSTK) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '15' as id, SUM(svd.SDKP) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        UNION
        SELECT k.code, k.description, a.TOTAL, g.description as DESC_IND, g.description as DESC_ENG, b.ismandatory,CASE WHEN b.ismandatory = 1 THEN 'REQUIRED' ELSE 'OPTIONAL' END as STATUS, a.RISK
         FROM (select '6' as id, SUM(svd.KTP) TOTAL, mv.RISK
                         FROM m_status_vendor_data svd JOIN m_vendor mv ON mv.ID_VENDOR=svd.ID_VENDOR
                         WHERE svd.STATUS=1 AND mv.ID='".$id."') a
        JOIN m_vendor_checklist_group_detail g ON g.id=a.id JOIN m_vendor_checklist_group_validation b ON a.id=b.checklist_group_detail_id
        JOIN m_vendor_checklist_group k ON k.id=g.group_id
        WHERE b.prefix_id = '".$prefix_id."'
        ");

        return $query;
    }

    public function upd( $id,$stat,$tabel,$dt,$app2,$sel=0) {
        $q=false;
        if($dt['status_approve'] == '1')
        {
            $q= $this->db->query(
                "UPDATE ".$tabel." as t
                LEFT JOIN t_approval_supplier t2 ON t2.supplier_id = t.supplier_id AND t2.status_approve=2
                SET t.status_approve =".$dt['status_approve'].",t.updatedate='".$dt['updatedate']."' ,t2.status_approve=".$app2.", t.extra_case=0,t2.extra_case=0,t.note='Approved - ".$dt['note']."',t.approve_by='".$this->session->userdata('ID_USER')."'
                WHERE t.sequence =".$dt['seq_strt']." AND t.status_approve =".$stat." AND t.supplier_id =".$id." and t.module=".$dt['module']);
            if($sel == 1 && $dt['module']== 1)
            {
                $q=$this->db->query("UPDATE m_vendor v SET v.ID_EXTERNAL='".$dt['ID_EXTERNAL']."',v.NO_SLKA='".$dt['NO_SLKA']."',v.SLKA_DATE='".$dt['SLKA_DATE']."' ,v.STATUS=".$dt['STATUS']."  WHERE v.ID = ".$id." AND v.NO_SLKA is NULL");
            }
        }
        else{
            if($dt['seq_last'] >= 4){
              if ($dt['seq_last'] == 4) {
                $upd_seq = "t.extra_case=(SELECT extra_case from m_approval_rule WHERE module=t.module and sequence =".$dt['seq_now'].")";
              } else {
                $upd_seq = "t.extra_case=0";
              }
                $q= $this->db->query(
                "UPDATE t_approval_supplier t set t.status_approve=0, ".$upd_seq." WHERE t.supplier_id=".$id." AND t.sequence >= ".$dt['seq_strt']." AND  t.module=".$dt['module']);
            }else{
                $q= $this->db->query(
                "UPDATE t_approval_supplier t set t.status_approve=0
                where t.supplier_id=".$id." AND t.sequence >= ".$dt['seq_strt']." AND  t.module=".$dt['module']);
            }
            if($q)
            {
                if($dt['seq_last'] >= 4){
                    $q= $this->db->query(
                        "UPDATE t_approval_supplier t set t.status_approve=2,t.note='Rejected - ".$dt['note']."',t.approve_by='".$this->session->userdata('ID_USER')."',
                        t.extra_case=(SELECT extra_case from m_approval_rule WHERE module=t.module and sequence =".$dt['seq_now'].")
                        WHERE t.supplier_id=".$id." AND t.sequence =".$dt['seq_now']." AND  t.module=".$dt['module']);
                }else{
                    $q= $this->db->query(
                "UPDATE t_approval_supplier t set t.status_approve=2,t.note='Rejected - ".$dt['note']."',t.approve_by='".$this->session->userdata('ID_USER')."'
                WHERE t.supplier_id=".$id." AND t.sequence =".$dt['seq_now']." AND  t.module=".$dt['module']);
                }

            }
                // "UPDATE ".$tabel." as t
                // LEFT JOIN t_approval_supplier t2 ON t2.sequence =".$dt['seq_now']."  AND t2.status_approve =".$stat."
                // SET t.status_approve =".$dt['status_approve'].",t.updatedate='".$dt['updatedate']."' ,t2.status_approve=".$app2."
                // ,t.edit_content=".$dt['edit_content'].",t.extra_case=".$dt['extra_case']."
                // WHERE t.sequence BETWEEN ".$dt['seq_strt']." AND ".$dt['seq_now']." AND t.supplier_id =".$id);
        }
        // echopre($this->db->last_query());
        return $q;
    }

    public function get_vendor() {
        $query = $this->db
                ->select('NAMA,PREFIX,CLASSIFICATION,CUALIFICATION')
                ->from('m_vendor')
                ->where('STATUS', '0')
                //->where('ID_VENDOR =', $id)
                ->get();
        if ($query->num_rows() != 0)
            return $query->result();
        else
            return false;
    }

    public function get_Country_Code($where) {
        $data = $this->db->from('m_loc_countries')
                ->where($where)
                ->get();
        return $data->result();
    }

    public function get_email($id) {
        $data = $this->db->select('ID_VENDOR')->from('m_vendor')->where('ID', $id)->get();
        return $data->row();
    }

    public function get_url($id) {
        $data = $this->db->select('URL_BATS_HARI')->from('m_vendor')->where('ID', $id)->get();
        return $data->row();
    }

    public function get_legal($id) {
        $data = $this->db->query("
        select V.CLASSIFICATION,V.NAMA, V.CUALIFICATION, p.DESKRIPSI_ENG as PREFIX, x.DESKRIPSI_ENG as SUFFIX, L.*, N.*
        FROM m_vendor as V
        LEFT JOIN m_vendor_legal_other as L ON V.ID = L.ID_VENDOR
        LEFT JOIN m_vendor_npwp as N ON V.ID = N.ID_VENDOR
        LEFT JOIN m_prefix p ON p.ID_PREFIX=SUBSTRING(V.PREFIX, 1, 1)
        LEFT JOIN m_prefix x ON x.ID_PREFIX=SUBSTRING(V.PREFIX, 3)
        WHERE V.ID ='".$id."' OR (L.CATEGORY='SIUP' OR L.CATEGORY='BKPM' OR L.CATEGORY='TDP'
        OR L.CATEGORY='SKT_EBTKE' OR L.CATEGORY='SKT_MIGAS') AND V.ID ='".$id."'");
        return $data->result_array();
    }

    public function data_search($data, $col) {
        $count = 0;
        if (count($data) > 0) {
            foreach ($data as $k => $v) {
                if ($count == 0) {
                    $this->db->like($col, $v);
                    $count++;
                } else
                    $this->db->or_like($col, $v);
            }
        }
    }

    public function filter_data($data) {
        $name = array();
        $email = array();
        $limit = $data['limit'];
        foreach ($data as $k => $v) {
            if (strpos($k, 'name') !== false && $v != null)
                array_push($name, $v);
            if (strpos($k, 'email') !== false && $v != null)
                array_push($email, $v);
        }
        $this->db->select("ID,ID_VENDOR,NAMA,STATUS")
                ->from("m_vendor");

        $this->db->group_start();
        $this->data_search($name, "NAMA");
        $this->data_search($email, "ID_VENDOR");
        $this->db->group_end();

        if ($data['status1'] != "none" && $data['status2'] == "none")
            $this->db->where("STATUS=", $data['status1']);
        else if ($data['status2'] != "none" && $data['status1'] == "none")
            $this->db->where("STATUS=", $data['status2']);
        else
            $this->db->where("STATUS=", 5);
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result();
    }

    public function tb_servis() {
        $this->db->select('NAMA,PREFIX,CLASSIFICATION,CUALIFICATION')
                ->from('m_vendor')
                ->where('STATUS', '1');
        return $this->db->get();
    }

    //------------------------------------------------------------------------------------------------------------------//
//    public function alamatperusahaan($id) {
//        $data = $this->db->from('m_vendor_address')
//                ->where('STATUS', '1')
//                ->where('ID_VENDOR', $id)
//                ->get();
//        return $data->result();
//    }
    public function alamatperusahaan($where,$limit=false) {
        $this->db->select('v.ID_EXTERNAL,a.ADDRESS,a.ADDRESS2,a.ADDRESS3,a.ADDRESS4,a.ID_VENDOR,s.NAME as PROVINCE,m.name as COUNTRY,a.POSTAL_CODE,a.BRANCH_TYPE,a.CITY,a.TELP,a.FAX,a.HP,a.WEBSITE')
                ->from('m_vendor_address a')
                ->join('m_loc_states s','a.PROVINCE=s.id','')
                ->join('m_vendor v','v.ID=a.ID_VENDOR','')
                ->join('m_loc_countries m','m.sortname=a.COUNTRY')
                ->where($where);
        if($limit == true)
        {
            $this->db->order_by('a.CREATE_TIME DESC')->limit(1);
        }
        $data =$this->db->get();
        if ($data->num_rows() != 0)
            return $data->result();
        else
            return false;
    }

    public function datakontakperusahaan($id) {
        $data = $this->db->from('m_vendor_contact')
                ->where('STATUS', '1')
                ->where('ID_VENDOR', $id)
                ->get();
        return $data->result();
    }

    //------------------------------------------------------------------------------------------------------------------//

    public function dataakta($id) {
        $data = $this->db->from('m_vendor_akta')
                ->where('ID_VENDOR', $id)
                ->get();
        return $data->result();
    }

    public function get_alldata() {
        $data = $this->db
                ->select('N.*')
                ->from('m_vendor_npwp N')
                ->where('STATUS', '1')
                ->get();
        return $data->result();
    }

    public function get_legal_others($id) {
        $data = $this->db->from('m_vendor_legal_other')
                ->where('STATUS', '1')
                ->where('ID_VENDOR', $id)
                ->get();
        return $data->result();
    }

    //--------------------------------------------------------------------------------------------------------------------//
    public function show_datasertifikasi($id) {
        $data = $this->db->from('m_vendor_certification')
                ->where('STATUS', '1')
                ->where('ID_VENDOR', $id)
                ->get();
        return $data->result();
    }

    public function daftarjasa($id) {
        $data = $this->db
                ->select("v.NAME,v.KEY,v.DESCRIPTION,m.DESCRIPTION as GROUP,m2.DESCRIPTION as SUB_GROUP,v.MERK,v.AGEN_STATUS,v.CERT_NO,v.FILE_URL")
                ->from('m_vendor_goods_service v')
                ->join("m_material_group m", "m.ID=v.GROUP","")
                ->join("m_material_group m2", "m2.ID=v.SUB_GROUP","")
                ->where("v.TYPE =","SERVICE")
                ->where('v.STATUS', '1')
                ->where('v.ID_VENDOR', $id)
                ->get();
        return $data->result();
    }

    public function daftarbarang($id) {
        $data = $this->db
                ->select("v.NAME,v.KEY,v.DESCRIPTION,m.DESCRIPTION as GROUP,m2.DESCRIPTION as SUB_GROUP,v.MERK,v.AGEN_STATUS,v.CERT_NO,v.FILE_URL")
                ->from('m_vendor_goods_service v')
                ->join("m_material_group m", "m.ID=v.GROUP","")
                ->join("m_material_group m2", "m2.ID=v.SUB_GROUP","")
                ->where('v.STATUS', '1')
                ->where("v.TYPE =","GOODS")
                ->where('v.ID_VENDOR', $id)
                ->get();
        return $data->result();
    }

    //----------------------------------------------------------------------------------------------------------------//

    public function show_company_management($id) {
        $data = $this->db->from('m_vendor_directors')
                ->where('STATUS', '1')
                ->where('ID_VENDOR', $id)
                ->get();
        return $data->result();
    }

    public function show_vendor_shareholders($id) {
        $data = $this->db->from('m_vendor_shareholders')
                ->where('STATUS', '1')
                ->where('ID_VENDOR', $id)
                ->get();
        return $data->result();
    }

    //--------------------------------------------------------------------------------------------------------------------//

    public function show_vendor_bank_account($id) {
        $data = $this->db->from('m_vendor_bank_account')
                ->where('STATUS', '1')
                ->where('ID_VENDOR', $id)
                ->get();
        return $data->result();
    }

    public function show_financial_bank_data($id) {
        $data = $this->db->from('m_vendor_balance_sheet')
                ->where('STATUS', '1')
                ->where('ID_VENDOR', $id)
                ->get();
        return $data->result();
    }

    //-----------------------------------------------------------------------------------------------------------------//
    public function show_experience_experience($id) {
        $data = $this->db->from('m_vendor_experience')
                ->where('STATUS', '1')
                ->where('ID_VENDOR', $id)
                ->get();
        return $data->result();
    }

    public function show_certification($id) {
      $data=$this->db->from('m_vendor_legal_other')
            ->where('CATEGORY','CERTIFICATION')
            ->where('STATUS',1)
            ->where("ID_VENDOR",$id)
            ->order_by('CREATE_TIME DESC')
            ->get();
      return $data->result();
    }

    public function get_vendor_info($id) {
        $qry = $this->db->select('*')
                ->from('m_vendor')
                ->where('ID_VENDOR', $id)
                ->get();
        return $qry->result();
    }

    public function get_vendor_info_by_id($id) {
        $qry = $this->db->select('*')
                ->from('m_vendor')
                ->where('ID', $id)
                ->get();
        return $qry->result();
    }

    public function get_info_ktp($id){
      $query = $this->db->select("*")->from("m_vendor_ktp")->where("id_vendor", $id)->get();
      return $query->result_array();
    }

}

?>
