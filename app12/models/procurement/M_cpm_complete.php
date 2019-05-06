<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_cpm_complete extends CI_Model {

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

    public function save_draft($dt)
    {
        $res=$this->db->insert_batch('t_cpm_detail_phase',$dt);
        return $res;
    }

    public function update_draft($dt,$id,$phase)
    {
        $res=$this->db->where('cpm_id',$id)
                    ->where('phase_id',$phase)
            ->update_batch('t_cpm_detail_phase',$dt,'cpm_detail_id');
        return $res;
    }

    public function send_data($po,$phase)
    {
        $res=$this->db->query(
            "INSERT INTO t_approval_cpm
            (SELECT DISTINCT 'NULL',po_no,vendor_id,user_roles,user_id,type,sequence,'0',reject_step,email_approve,
            email_reject,CASE
                WHEN edit_content=1 THEN 1
                ELSE edit_content
            END as edit_content,1,".$phase.",0,now(),now()
            FROM t_approval_cpm
            WHERE po_no='".$po."' AND vendor_id=".$_SESSION['ID'].")
            "
        );
        return $res;
    }

    public function add($tbl,$dt)
    {
        return $this->db->insert($tbl,$dt);
    }

    public function update_data($po,$phase)
    {
        $dt=array(
            "status"=>0
        );
        return $this->db->where('id',$phase)
                        ->update("t_cpm_phase",$dt);
    }

/* ===========================================-------- get data START------- ====================================== */

    public function check($po,$phase)
    {
        $res=$this->db->query(
            "SELECT a.id,COUNT(dp.cpm_id) as total
            FROM (
                SELECT id
                FROM t_cpm
                WHERE po_no='".$po."' AND vendor_id=".$_SESSION['ID']."
            )a
            LEFT JOIN t_cpm_detail_phase dp ON dp.cpm_id=a.id AND dp.phase_id=".$phase."
            GROUP BY a.id
            ");
        return $res->result_array();
    }
    public function get_email_rec($seq)
    {
        $qry=$this->db->select('email')
            ->from('m_user')
            ->where('status = 1')
            ->where('ID_USER',$seq)
            ->get();
        if ($qry->num_rows() != 0)
            return $qry->result();
        else
            return false;
    }

    public function get_email_dest($tid,$dt,$sel)
    {
        $qry=false;
        if($sel == 1)
        {
            $qry=$this->db->query(
                "SELECT max(t2.sequence) as max_seq,v.URL_BATAS_HARI as hari,v.NAMA,x.user_id as recipients,t.user_roles, t.sequence, t.reject_step, t.email_approve, t.email_reject, n.OPEN_VALUE, n.CLOSE_VALUE, n.TITLE
                FROM t_approval_cpm t
                JOIN t_approval_cpm t2 ON t2.po_no=t.po_no
                JOIN m_notic n ON n.ID = t.email_approve
                JOIN m_vendor v ON v.ID = t.vendor_id
                LEFT JOIN (select user_id,vendor_id from t_approval_cpm where vendor_id=".$dt['supplier_id']." and sequence=".$dt['sequence']."+1) x on x.vendor_id=t.vendor_id
                WHERE t.id =".$tid." AND t.sequence=".$dt['sequence']."
                GROUP BY t.sequence,v.NAMA,v.URL_BATAS_HARI,x.user_id,t.user_roles, t.sequence, t.reject_step, t.email_approve, t.email_reject, n.OPEN_VALUE, n.CLOSE_VALUE, n.TITLE");
        }
        else{
            $qry=$this->db->query(
                'SELECT v.URL_BATAS_HARI as hari,v.NAMA,t2.user_id as recipients,t.user_roles, t.sequence, t.reject_step, t.email_approve, t.email_reject, n.OPEN_VALUE, n.CLOSE_VALUE, n.TITLE
                FROM t_approval_cpm t
                LEFT JOIN t_approval_cpm t2 ON t2.po_no=t.po_no AND t2.vendor_id='.$dt["supplier_id"].' AND t2.sequence='.$dt["sequence"].'-t.reject_step
                JOIN m_notic n ON n.ID = t.email_reject
                JOIN m_vendor v ON v.ID = t.vendor_id
                WHERE t.vendor_id='.$dt["supplier_id"].' AND t.sequence='.$dt["sequence"].' AND t.id ='.$tid.'');
        }
        return $qry->result_array();
    }

    public function get_cpm_detail($po,$vendor,$phase)
    {
        $res=$this->db->query(
            "SELECT DISTINCT dp.actual_score,dp.actual_weight,dp.adjust_score,dp.adjust_weight,d.id as id,d.category_id,m.category,d.cat_weight as weight,d.specific_kpi,d.kpi_weight,d.scoring_method,d.target_score,d.target_weight,total, CASE
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
            JOIN t_cpm_phase cp ON cp.po_no='".$po."' AND cp.phase=".$phase." AND status=0
            LEFT JOIN t_cpm_detail_phase dp ON dp.cpm_id=a.cpm_id AND dp.cpm_detail_id=d.id AND dp.phase_id=cp.id
            JOIN m_cpm_category m ON a.category_id=m.id
            ORDER BY d.category_id ASC"
        );
        return $res->result();
    }

    public function calc_weight($id,$val)
    {
        $res=$this->db->query(
            "SELECT (".$val."*target_weight/target_score) as weight
            FROM t_cpm_detail
            WHERE id=".$id."
            "
        );
        return $res->result();
    }

    public function get_list() {
        $res = $this->db->query(
            "SELECT DISTINCT b.id as cpm_id, p.id, o.po_no, r.title, c.description as company, v.NAMA, a.vendor_id, p.phase, p.due_date,'Finished' as status, c.ABBREVIATION
            FROM (
                SELECT MAX(c.sequence) as sequence, MAX(p.phase) as phase, c.po_no, c.vendor_id
                FROM t_approval_cpm c
                JOIN t_cpm_phase p ON p.id = c.phase_id AND p.status = 0
                WHERE c.status_approve = 1 AND c.extra_case = 1 AND c.status = 1
                GROUP BY c.po_no, c.vendor_id
            ) a
            JOIN t_cpm b ON b.po_no = a.po_no AND b.vendor_id = a.vendor_id
            JOIN t_purchase_order o ON o.po_no = a.po_no
            JOIN t_cpm_phase p ON p.po_no = a.po_no AND p.phase = a.phase
            JOIN t_msr r ON r.msr_no = o.msr_no
            JOIN m_company c ON c.ID_COMPANY = r.id_company
            JOIN m_vendor v ON v.ID = a.vendor_id
            WHERE o.po_type = 20
        ");
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

    public function get_history($po) {
        $res = $this->db->select('h.description, h.keterangan, h.created_at, p.phase')
                        ->from('log_history h')
                        ->join('t_cpm_phase p', 'CONCAT("cpm_", p.id, "") = h.module_kode', 'left')
                        ->where(array('h.data_id' => $po))
                        ->order_by('p.phase, h.created_at')
                        ->get();
        return $res->result_array();
    }

}