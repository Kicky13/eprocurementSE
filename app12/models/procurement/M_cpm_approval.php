<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_cpm_approval extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
/* ===========================================-------- API START------- ====================================== */        

    public function get_header($po, $vendor) {
        $res = $this->db->select('t.msr_no,
            CASE
                WHEN o.po_type = 10 THEN "Purchase Order"
                WHEN o.po_type = 20 THEN "Service Order"
                WHEN o.po_type = 30 THEN "Blanket Purchase Order"
                ELSE "Non"
            END as po_type, t.company_desc as comp, t.title, m1.NAME as req, v.NAMA as vendor, t.costcenter_desc as dept, o.delivery_date, o.total_amount_base', false)
                        ->from('t_purchase_order o')
                        ->join('t_msr t', 't.msr_no = o.msr_no')
                        ->join('t_approval_cpm c', 'c.po_no = o.po_no')
                        ->join('m_user m1', 'm1.ID_USER = t.create_by')
                        ->join('m_vendor v', 'v.ID = o.id_vendor')
                        ->where(array('o.po_no' => $po, 'o.id_vendor' => $vendor, 'c.sequence' => 1, 'c.extra_case' => 0))
                        ->get();
        return $res->result();
    }

    public function approve_reject($dt, $sel) {
        $id = $dt['supplier_id'];
        $seq = $dt['sequence'];
        $idT = $dt['tid'];

        $res = false;
        if ($sel == 1) {
            $q = $this->db->query("
                UPDATE t_approval_cpm
                SET status_approve = 0
                WHERE status_approve = 2 AND vendor_id = ".$id." AND po_no = '".$dt['po']."'");
            $res = $this->db->query("
                UPDATE t_approval_cpm
                SET update_date = '".$dt['updatedate']."', status_approve = 1,note='Approved - ".$dt['note']."', approve_by='".$this->session->userdata('ID_USER')."'
                WHERE sequence = ".$seq." AND vendor_id = ".$id." AND id = '".$idT."' AND po_no = '".$dt['po']."' AND extra_case = ".$dt['extra_case']);
        } else {
            $q = $this->db->query("
                UPDATE t_approval_cpm t
                JOIN t_approval_cpm t2 ON t2.vendor_id = t.vendor_id AND t2.po_no = t.po_no AND t2.sequence = ".$seq."
                SET t.status_approve = 0
                WHERE t.vendor_id = ".$id." AND t.sequence >= (".$seq."-t2.reject_step) AND t.po_no = '".$dt['po']."' AND t.extra_case = ".$dt['extra_case']." AND t.phase_id = ".$dt['phase_id']);
            if ($q) {
                $res = $this->db->query("
                    UPDATE t_approval_cpm t set t.status_approve=2,note='Rejected - ".$dt['note']."', approve_by='".$this->session->userdata('ID_USER')."'
                    WHERE t.vendor_id=".$id." AND t.sequence =".$seq." AND t.po_no = '".$dt['po']."' AND t.extra_case=".$dt['extra_case']." AND t.phase_id=".$dt['phase_id']);
            }
        }
        return $res;
    }

    public function check_seq($dt)
    {
        $res=$this->db->query("SELECT COUNT(sequence) as sequence
                        FROM t_approval_cpm
                        WHERE po_no='".$dt['po_no']."' AND vendor_id=".$dt['vendor_id']." AND extra_case=0");
        return $res->result_array();
    }

    public function set_approval($dt)
    {
        return $this->db->insert("t_approval_cpm",$dt);
    }

    public function update_dt($tbl,$dt,$phase)
    {
        return $this->db->where('id',$phase)
                        ->update($tbl,$dt);
    }
    

/* ===========================================-------- get data START------- ====================================== */    
    public function get_status($dt)
    {
        $res=$this->db->query(
            "SELECT CASE
                WHEN t.sequence=t2.sequence THEN 1
                ELSE 0
            END as max,t.edit_content,t.extra_case
            FROM (
                SELECT MAX(sequence) as sequence
                FROM t_approval_cpm t
                WHERE t.po_no='".$dt['po']."' AND t.vendor_id=".$dt['vendorid']." AND (t.status_approve=0 OR t.status_approve=2)
            )t2
            JOIN t_approval_cpm t ON t.sequence=".$dt['sequence']." AND t.po_no='".$dt['po']."' AND t.vendor_id=".$dt['vendorid']." AND (t.status_approve=0 OR t.status_approve=2)
            ");
        return $res->result();
    }

    public function get_email_dt($vendor,$po,$phase)
    {
        $res=$this->db->select('v.ID_VENDOR as email,n.TITLE,n.OPEN_VALUE,n.CLOSE_VALUE,c.due_date,p.phase')
                ->from('m_vendor v')
                ->join('m_notic n','n.ID=30','')
                ->join('t_cpm_phase_notif c','c.po_no="'.$po.'" AND c.id='.$phase)
                ->join('t_cpm_phase p','p.po_no=c.po_no AND p.id=c.phase_id')
                ->where('v.ID',$vendor)
                ->get();
                
        if ($res->num_rows() != 0)
            return $res->result();                
        else
            return false;
    }

    public function get_email_rec($rec, $role) {
        if ($rec == '%') {
            $qry = $this->db->select('email')
                            ->from('m_user')
                            ->where('status', '1')
                            ->like('ROLES', ',' . $role . ',')
                            ->get();
        } else {
            $qry = $this->db->select('email')
                            ->from('m_user')
                            ->where('status = 1')
                            ->where('ID_USER', $rec)
                            ->get();
        }
        if ($qry->num_rows() != 0)
            return $qry->result();
        else
            return false;
    }

    public function calc_weight($id, $val) {
        $res = $this->db->query("
            SELECT (ROUND(cat_weight * kpi_weight * ".$val." / 10000, 2)) as weight
            FROM t_cpm_detail
            WHERE id=".$id."
            ");
        return $res->result();
    }

    public function get_weight_input_data($id, $val, $po) {
        $res = $this->db->select('d.id, d.category_id,
                        CASE
                            WHEN d.id = '.$id.' THEN (ROUND(cat_weight * kpi_weight * '.$val.' / 10000, 2))
                            ELSE 0
                        END as weight', false)
                        ->from('t_cpm_detail d')
                        ->join('t_cpm c', 'c.id = d.cpm_id')
                        ->where('c.po_no', $po)
                        ->order_by('d.category_id, d.id')
                        ->get();
        return $res->result();
    }

    public function save_kpi($dt,$phase) {                
        $res = $this->db->where('phase_id', $phase)
                        ->update_batch('t_cpm_detail_phase', $dt, 'cpm_detail_id');        
        return $res;
    }

    public function get_email_dest($tid, $dt, $sel) {
        $qry = false;
        if($sel == 1) {
            $qry = $this->db->query(
                "SELECT MAX(t2.sequence) as max_seq, v.URL_BATAS_HARI as hari, v.NAMA, x.user_id as recipients, x.user_roles as rec_role, t.user_roles, t.sequence, t.reject_step, t.email_approve, t.email_reject, n.OPEN_VALUE, n.CLOSE_VALUE, n.TITLE
                FROM t_approval_cpm t
                JOIN t_approval_cpm t2 ON t2.po_no = t.po_no
                JOIN m_notic n ON n.ID = t.email_approve
                JOIN m_vendor v ON v.ID = t.vendor_id 
                LEFT JOIN (
                    SELECT user_id, user_roles, po_no, vendor_id, MIN(sequence) as seq
                    FROM t_approval_cpm
                    WHERE sequence != " . $dt['sequence'] . " AND vendor_id = " . $dt["supplier_id"] . " and status_approve = 0
                    GROUP BY user_id, user_roles, po_no, vendor_id
                ) x on x.vendor_id = t.vendor_id AND x.po_no = t.po_no
                WHERE t.id =" . $tid . " AND t.sequence=" . $dt['sequence'] . " AND t.extra_case=" . $dt['extra_case'] . "
                GROUP BY v.URL_BATAS_HARI, v.NAMA, x.user_id, x.user_roles, t.user_roles, t.sequence, t.reject_step, t.email_approve, t.email_reject, n.OPEN_VALUE, n.CLOSE_VALUE, n.TITLE");
        } else {
            $qry = $this->db->query(
                'SELECT v.URL_BATAS_HARI as hari, v.NAMA, t2.user_id as recipients, t2.user_roles as rec_role, t.user_roles, t.sequence, t.reject_step, t.email_approve, t.email_reject, n.OPEN_VALUE, n.CLOSE_VALUE, n.TITLE
                FROM t_approval_cpm t
                LEFT JOIN t_approval_cpm t2 ON t2.po_no=t.po_no AND t2.vendor_id='.$dt["supplier_id"].' AND t2.sequence='.$dt["sequence"].'-t.reject_step
                JOIN m_notic n ON n.ID = t.email_reject
                JOIN m_vendor v ON v.ID = t.vendor_id                 
                WHERE t.vendor_id='.$dt["supplier_id"].' AND t.sequence='.$dt["sequence"].' AND t.id ='.$tid.' AND t.extra_case='.$dt["extra_case"].'');                        
        }                
        return $qry->result_array();
    }

    public function get_cpm_detail($po, $vendor, $phase) {
        if ($phase == 0) {
            $res = $this->db->query(
                "SELECT DISTINCT d.id as id,d.category_id,m.category,d.cat_weight as weight,d.specific_kpi,d.kpi_weight,d.scoring_method,d.target_score,d.target_weight,total,COALESCE(dp.actual_score,' ') as actual_score,COALESCE(dp.actual_weight,' ') as actual_weight,COALESCE(dp.adjust_score,' ') as adjust_score,COALESCE(dp.adjust_weight,' ') as adjust_weight, CASE 
                        WHEN dp.remarks IS NULL THEN ''
                        ELSE dp.remarks
                    END as remarks
                FROM (
                    SELECT t.cpm_id,t.cat_weight,t.category_id,count(t.id) as total
                    FROM(
                        SELECT DISTINCT t.category_id,t.cpm_id,t.cat_weight
                        FROM t_cpm c
                        JOIN t_cpm_detail t ON t.cpm_id=c.id
                        WHERE po_no='".$po."' AND vendor_id=".$vendor."
                    )a
                    JOIN t_cpm_detail t ON t.category_id=a.category_id AND t.cpm_id=a.cpm_id AND t.cat_weight=a.cat_weight
                    GROUP BY t.cpm_id,t.cat_weight,t.category_id
                ) a
                JOIN t_cpm_detail d ON d.cpm_id=a.cpm_id AND d.cat_weight=a.cat_weight AND d.category_id=a.category_id
                LEFT JOIN t_cpm_detail_phase dp ON dp.cpm_id=a.cpm_id AND dp.cpm_detail_id = d.id AND dp.cpm_detail_id=d.id
                JOIN m_cpm_category m ON a.category_id=m.id
                ORDER BY d.category_id ASC"
            );
        } else {
            $res = $this->db->query(
                "SELECT DISTINCT d.id as id,d.category_id,m.category,d.cat_weight as weight,d.specific_kpi,d.kpi_weight,d.scoring_method,d.target_score,d.target_weight,total,dp.actual_score,dp.actual_weight,dp.adjust_score,dp.adjust_weight, CASE 
                        WHEN dp.remarks IS NULL THEN ''
                        ELSE dp.remarks
                    END as remarks
                FROM (
                    SELECT t.cpm_id,t.cat_weight,t.category_id,count(t.id) as total
                    FROM(
                        SELECT DISTINCT t.category_id,t.cpm_id,t.cat_weight
                        FROM t_cpm c
                        JOIN t_cpm_detail t ON t.cpm_id=c.id
                        WHERE po_no='".$po."' AND vendor_id=".$vendor."
                    )a
                    JOIN t_cpm_detail t ON t.category_id=a.category_id AND t.cpm_id=a.cpm_id AND t.cat_weight=a.cat_weight
                    GROUP BY t.cpm_id,t.cat_weight,t.category_id
                ) a
                JOIN t_cpm_detail d ON d.cpm_id=a.cpm_id AND d.cat_weight=a.cat_weight AND d.category_id=a.category_id
                LEFT JOIN t_cpm_detail_phase dp ON dp.cpm_id=a.cpm_id AND dp.cpm_detail_id = d.id AND dp.phase_id= ".$phase."
                JOIN m_cpm_category m ON a.category_id=m.id
                ORDER BY d.category_id ASC"
            );
        }
        // echo $this->db->last_query();
        return $res->result();
    }

    public function get_list() {
        $res = $this->db->query(
            "SELECT DISTINCT b.po_no, CASE
                WHEN a.po_type = 10 THEN 'PO'
                WHEN a.po_type = 20 THEN 'SO'
                WHEN a.po_type = 30 THEN 'Blanket PO'
            END as type, `m`.`title`, `c`.`description` as `company`, `v`.`NAMA`, `r`.`CURRENCY` as `currency`, `a`.`id_vendor`, m.total_amount_base as value, b.id, b.sequence, b.extra_case, b.phase_id, b.create_date, f.phase as cur_phase
            FROM (
                SELECT MIN(a.sequence) as sequence, a.po_no, a.extra_case, a.phase_id, o.id_vendor, o.msr_no, o.po_type
                FROM t_approval_cpm a
                JOIN t_purchase_order o ON o.po_no = a.po_no
                WHERE (status_approve = 0 OR status_approve = 2) AND status = 0 AND o.po_type = 20
                GROUP BY a.po_no, a.extra_case, a.phase_id, o.id_vendor, o.id, o.msr_no, o.po_type
            ) a
            JOIN t_approval_cpm b ON b.po_no = a.po_no AND b.extra_case = a.extra_case AND b.phase_id = a.phase_id AND b.sequence = a.sequence
            JOIN t_msr m ON m.msr_no = a.msr_no
            JOIN `m_company` `c` ON `c`.`ID_COMPANY` = `m`.`id_company`
            JOIN `m_vendor` `v` ON `v`.`ID` = `a`.`id_vendor`
            JOIN `m_currency` `r` ON `r`.`ID` = `m`.`id_currency`
            LEFT JOIN t_cpm_phase f ON f.id = b.phase_id
            WHERE ((`b`.`user_id` = '%' AND '" . $_SESSION['ROLES'] . "' LIKE CONCAT('%,', `b`.`user_roles`, ',%'))
            OR (`b`.`user_id` = " . $_SESSION['ID_USER'] . ")) AND (b.sequence != 1 OR b.extra_case != 0)
        ");
        return $res->result_array();
    }

    public function get_list_home($in = 0) {
        $where = 'and b.sequence not in (99)';
        if($in == 1){
            $where = " and b.sequence in (99) ";
        }
        if($in == 2){
            $where = " and b.sequence not in (1,2,3,4,99) ";
        }
        $res = $this->db->query(
            "SELECT DISTINCT b.po_no, CASE
                WHEN a.po_type = 10 THEN 'PO'
                WHEN a.po_type = 20 THEN 'SO'
                WHEN a.po_type = 30 THEN 'Blanket PO'
            END as type, `m`.`title`, `c`.`description` as `company`, `v`.`NAMA`, `r`.`CURRENCY` as `currency`, `d`.`vendor_id`, a.value, b.id, b.sequence, b.extra_case, b.phase_id, b.create_date, f.phase as cur_phase
            FROM (
                SELECT MIN(a.sequence) as sequence, a.po_no, a.extra_case, a.phase_id, o.id_vendor, o.msr_no, o.po_type, SUM(p.total_price) as value
                FROM t_approval_cpm a
                JOIN t_purchase_order o ON o.po_no = a.po_no
                JOIN t_purchase_order_detail p ON p.po_id = o.id
                WHERE (status_approve = 0 OR status_approve = 2) and status = 0
                GROUP BY a.po_no, a.extra_case, a.phase_id, o.id_vendor, o.msr_no, o.po_type
            ) a
            JOIN t_approval_cpm b ON b.po_no = a.po_no AND b.extra_case = a.extra_case AND b.phase_id = a.phase_id AND b.sequence = a.sequence
            JOIN t_msr m ON m.msr_no = a.msr_no
            JOIN `t_bl` `l` ON `l`.`msr_no` = `m`.`msr_no`
            JOIN `t_bl_detail` `d` ON `d`.`msr_no` = `l`.`msr_no` AND d.vendor_id = a.id_vendor
            JOIN `m_company` `c` ON `c`.`ID_COMPANY` = `m`.`id_company`
            JOIN `m_vendor` `v` ON `v`.`ID` = `d`.`vendor_id`
            JOIN `m_currency` `r` ON `r`.`ID` = `m`.`id_currency`
            LEFT JOIN t_cpm_phase f ON f.id = b.phase_id
            WHERE ((`b`.`user_id` = '%' AND '" . $_SESSION['ROLES'] . "' LIKE CONCAT('%,', `b`.`user_roles`, ',%'))
            OR (`b`.`user_id` = " . $_SESSION['ID_USER'] . ")) AND (b.sequence != 1 OR b.extra_case != 0) ".$where."
        ");
        // WHERE '".substr($_SESSION['ROLES'],1,-1)."' LIKE CONCAT('%',t2.user_roles,'%') AND '".$_SESSION['ID_USER']."' LIKE CONCAT('%',t2.user_id,'%')
        return $res;
    }

    public function get_plan($po, $phase = 0) {
        if ($phase == 0) {
            $res = $this->db->select('n.id as id_notif, p.id, p.phase, p.location, p.date_start, p.due_date, n.due_date as notif, n.status_delivered')
                            ->from('t_cpm_phase p')
                            ->join('t_cpm_phase_notif n', 'n.po_no = p.po_no AND n.phase_id = p.id')
                            ->where(array('p.status' => 1, 'p.po_no' => $po))
                            ->order_by('p.phase ASC, n.due_date ASC')
                            ->get();
        } else {
            $res = $this->db->select('n.id as id_notif, p.id, p.phase, p.location, p.date_start, p.due_date, n.due_date as notif, n.status_delivered')
                            ->from('t_cpm_phase p')
                            ->join('t_cpm_phase_notif n', 'n.po_no = p.po_no AND n.phase_id = p.id')
                            ->where(array('p.status' => 0, 'p.po_no' => $po, 'p.id' => $phase))
                            ->order_by('p.phase ASC, n.due_date ASC')
                            ->get();
        }
        return $res->result();
    }

    public function get_data_user($pil,$tbl)
    {
        $res=$this->db->select($pil)
                ->from($tbl)
                ->where("STATUS=1")
                ->get();
        if ($res->num_rows() != 0)
            return $res->result();
        else
            return false;    
    }

    public function get_user($roles,$dept)
    {
        $res=$this->db->select("ID_USER as id,USERNAME as name")
                    ->from("m_user")
                    ->where("ID_DEPARTMENT",$dept)
                    ->where_in("ROLES",','.$roles.',')
                    ->where("status =1")
                    ->get();
        
        if ($res->num_rows() != 0)
            return $res->result();
        else
            return false;    
    }

    public function get_category()
    {
        $res=$this->db->select("category")
                    ->from("m_cpm_category")
                    ->where("status","1")
                    ->get();
        if ($res->num_rows() != 0)
            return $res->result();
        else
            return false;
    }

    public function get_user_appr($po, $ven) {
        $res = $this->db->distinct()
                        ->select('t.sequence as no, m.DEPARTMENT_DESC as dept, u.name, u.USERNAME as logon,
                            CASE
                                WHEN t.user_roles = 1 THEN "User"
                                WHEN t.user_roles = 2 THEN "Subject Matter Expert"
                                ELSE "Subject Matter Support"
                            END as roles', false)
                        ->from('t_approval_cpm t')
                        ->join('m_user u', 'u.ID_USER = t.user_id')
                        ->join('m_user_roles r', 'r.ID_USER_ROLES = t.user_roles', 'left')
                        ->join('m_departement m', 'm.ID_DEPARTMENT = u.ID_DEPARTMENT')
                        ->where('t.po_no', $po)
                        ->where('t.vendor_id', $ven)
                        ->order_by('no')
                        ->get();
        return $res->result_array();
    }    

    public function get_upload($po)
    {
        $res=$this->db->select("t.id,t.type,t.seq,t.file_name,t.createdate,m.username,m.name,t.path")
                ->from("t_cpm_upload t")
                ->join('m_user m','m.ID_USER=t.createby','')
                ->where("po_no",$po)
                ->get();
        return $res->result_array();
    }
    
}