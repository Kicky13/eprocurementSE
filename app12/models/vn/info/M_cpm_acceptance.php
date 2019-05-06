<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_cpm_acceptance extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
/* ===========================================-------- API START------- ====================================== */        

    public function save_draft($dt)
    {                
        $res=$this->db->update_batch('t_cpm_detail',$dt,'id');        
        return $res;
    }

    public function send_data($po,$phase)
    {
        $res=$this->db->query(
            "UPDATE t_approval_cpm SET status = 1            
            WHERE po_no='".$po."' AND vendor_id=".$_SESSION['ID']." AND phase_id=".$phase." and status=0
            "
        );
        return $res;
    }

    public function add($tbl,$dt)
    {
        return $this->db->insert($tbl,$dt);
    }

/* ===========================================-------- get data START------- ====================================== */        

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
            "SELECT DISTINCT dp.cpm_detail_id as id,d.category_id,m.category,d.cat_weight as weight,d.specific_kpi,d.kpi_weight,d.scoring_method,d.target_score,d.target_weight,total,dp.actual_score,dp.actual_weight,dp.adjust_score,dp.adjust_weight, CASE 
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
        return $res->result();
    }

    public function get_list() {
        $res = $this->db->query(
            "SELECT DISTINCT p.id,o.po_no, r.title, c.description as company, p.phase, p.due_date, 'Approved' as status
            FROM 
            ( 
                SELECT MAX(t.sequence), t.po_no, t.phase_id
                FROM t_approval_cpm t
                LEFT JOIN t_approval_cpm t2 ON t2.po_no = t.po_no AND (t2.status_approve = 0 or t2.status_approve = 2) AND t2.extra_case = t.extra_case AND t2.phase_id = t.phase_id and t2.status = t.status
                WHERE t.vendor_id = ".$_SESSION['ID']." AND t.status_approve = 1 AND t.extra_case = 1 AND t.status = 0
                GROUP BY po_no, phase_id
                HAVING COUNT(t2.id) = 0
            ) a
            JOIN t_purchase_order o ON o.po_no = a.po_no
            JOIN t_cpm_phase p ON p.po_no = o.po_no AND p.id=a.phase_id
            JOIN t_msr r ON r.msr_no = o.msr_no
            JOIN `m_company` c ON c.ID_COMPANY = r.id_company
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
    
}