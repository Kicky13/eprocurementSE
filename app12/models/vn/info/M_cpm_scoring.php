<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_cpm_scoring extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
/* ===========================================-------- API START------- ====================================== */

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

    public function send_data($po, $phase) {
        $res = $this->db->query("
            INSERT INTO t_approval_cpm
            (SELECT DISTINCT 'NULL', po_no, vendor_id, user_roles, user_id, type, sequence, '0', reject_step, email_approve, email_reject, edit_content, 1, ".$phase.", 0, '', 0, now(), now()
            FROM t_approval_cpm a
            JOIN (
                SELECT max(sequence) as max_seq
                FROM t_approval_cpm
                WHERE po_no = '".$po."' AND vendor_id = ".$_SESSION['ID']."
            ) b
            WHERE po_no = '".$po."' AND vendor_id = ".$_SESSION['ID']." AND sequence < max_seq
            ORDER BY sequence)
            ");
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

    public function get_email_dest($po, $vendor, $phase) {
        $qry = $this->db->query(
            "SELECT v.URL_BATAS_HARI as hari, v.NAMA, b.user_id as recipients, b.user_roles as rec_role, b.reject_step, b.email_approve, b.email_reject, n.OPEN_VALUE, n.CLOSE_VALUE, n.TITLE
            FROM (
                SELECT po_no, vendor_id, min(sequence) as sequence, phase_id
                FROM t_approval_cpm
                WHERE po_no ='" . $po . "' AND vendor_id = " . $vendor . " AND phase_id = " . $phase . " AND status_approve = 0 AND extra_case = 1
                GROUP BY po_no, vendor_id
            ) a
            JOIN t_approval_cpm b ON b.sequence = a.sequence AND b.po_no = a.po_no AND b.vendor_id = a.vendor_id AND b.phase_id = a.phase_id
            JOIN m_notic n ON n.ID = b.email_approve
            JOIN m_vendor v ON v.ID = b.vendor_id");
        return $qry->result_array();
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

    public function get_cpm_detail($po, $vendor, $phase) {
        $res = $this->db->query("
            SELECT DISTINCT dp.actual_score as act_score, dp.actual_weight as act_weight, d.id as id, d.category_id, m.category, d.cat_weight as weight, d.specific_kpi, d.kpi_weight, d.scoring_method, d.target_score, d.target_weight, total,
            CASE
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
            LEFT JOIN t_cpm_detail_phase dp ON dp.cpm_id=a.cpm_id AND dp.cpm_detail_id=d.id AND dp.phase_id=".$phase."
            JOIN m_cpm_category m ON a.category_id=m.id
            ORDER BY d.category_id ASC"
        );
        return $res->result();
    }

    public function calc_weight($po) {
        $res = $this->db->select("(ROUND(cat_weight * kpi_weight * ".$val." / 10000, 2)) as weight")
                        ->from('t_cpm_detail')
                        ->where('id', $id)
                        ->get();
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

    public function get_list() {
        $res = $this->db->query(
            "SELECT DISTINCT p.id,o.po_no, r.title, c.description as company,p.phase,p.due_date,'Open' as status
            FROM
            (
                SELECT MAX(t.sequence),t.po_no
                FROM t_approval_cpm t
                LEFT JOIN t_approval_cpm t2 ON t2.po_no=t.po_no AND t2.status_approve=0 AND t2.phase_id=t.phase_id
                WHERE t.vendor_id=".$_SESSION['ID']." AND t.status_approve=1 AND t.extra_case=0
                GROUP BY po_no
                HAVING COUNT(t2.id) = 0
            )a
            JOIN t_purchase_order o ON o.po_no = a.po_no
            JOIN t_cpm_phase p ON p.po_no=o.po_no AND CURDATE()>=p.date_start AND p.due_date>=CURDATE() and p.status =1
            JOIN t_msr r ON r.msr_no=o.msr_no
            JOIN `m_company` c ON c.ID_COMPANY=r.id_company
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
