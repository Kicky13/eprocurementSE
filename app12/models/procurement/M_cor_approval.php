<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_cor_approval extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_header($po, $vendor) {
        $res = $this->db->select('t.msr_no,
            CASE
                WHEN o.po_type = 10 THEN "Purchase Order"
                WHEN o.po_type = 20 THEN "Service Order"
                WHEN o.po_type = 30 THEN "Blanket Purchase Order"
                ELSE "Non"
            END as po_type, t.company_desc as comp, t.title, m1.NAME as req, v.NAMA as vendor, t.costcenter_desc as dept, o.delivery_date, o.total_amount_base, m2.NAME as cor_creator, r.DESCRIPTION as cor_role, c.createdate', false)
                        ->from('t_purchase_order o')
                        ->join('t_msr t', 't.msr_no = o.msr_no')
                        ->join('t_approval_cor c', 'c.po_no = o.po_no')
                        ->join('m_user m1', 'm1.ID_USER = t.create_by')
                        ->join('m_user m2', 'm2.ID_USER = c.user_id')
                        ->join('m_user_roles r', 'r.ID_USER_ROLES = c.user_roles')
                        ->join('m_vendor v', 'v.ID = o.id_vendor')
                        ->where(array('o.po_no' => $po, 'o.id_vendor' => $vendor, 'c.sequence' => 1))
                        ->get();
        return $res->result();
    }

    public function get_cpm_rank() {
        $res = $this->db->select('*')
                        ->from('m_cpm_rank')
                        ->order_by('value', 'desc')
                        ->get();
        return $res->result_array();
    }

    public function get_email_dest($tid, $dt, $sel) {
        if ($sel == 1) {
            $qry = $this->db->query(
                "SELECT DISTINCT max(t2.sequence) as max_seq, v.URL_BATAS_HARI as hari, v.NAMA, x.user_id as recipients, x.user_roles as rec_role, t.sequence, t.reject_step, t.email_approve, t.email_reject, n.OPEN_VALUE, n.CLOSE_VALUE, n.TITLE, t.module
                FROM t_approval_cor t
                JOIN t_approval_cor t2 ON t2.t_cor_id = '".$tid."'
                JOIN m_notic n ON n.ID = t.email_approve
                JOIN m_vendor v ON v.ID = t.vendor_id
                LEFT JOIN (
                    SELECT user_id, user_roles, t_cor_id, vendor_id
                    FROM t_approval_cor
                    WHERE vendor_id = ".$dt['supplier_id']." AND sequence = ".$dt['sequence']."+1
                    ) x ON x.vendor_id = t.vendor_id AND x.t_cor_id = t.t_cor_id
                WHERE t.t_cor_id = '".$tid."' AND t.sequence = ".$dt['sequence']."
                GROUP BY t.sequence, v.NAMA, v.URL_BATAS_HARI, x.user_id, x.user_roles, t.user_roles, t.sequence, t.reject_step, t.email_approve, t.email_reject, n.OPEN_VALUE, n.CLOSE_VALUE, n.TITLE, t.module");
            return $qry->result_array();
        } else {
            $qry = $this->db->query(
                'SELECT v.URL_BATAS_HARI as hari, v.NAMA, x.user_id as recipients, x.user_roles as rec_role, t.sequence, t.reject_step, t.email_approve, t.email_reject, n.OPEN_VALUE, n.CLOSE_VALUE, n.TITLE, t.module
                FROM t_approval_cor t
                LEFT JOIN t_approval_cor x ON x.vendor_id = t.vendor_id AND x.t_cor_id = t.t_cor_id AND x.sequence = '.$dt["sequence"].'-t.reject_step
                JOIN m_notic n ON n.ID = t.email_reject
                JOIN m_vendor v ON v.ID = t.vendor_id
                WHERE t.vendor_id = '.$dt["supplier_id"].' AND t.sequence = '.$dt["sequence"].' AND t.t_cor_id = "'.$tid.'" AND t.reject_step > 0');
            return $qry->result_array();
        }
    }

    public function get_upload($po, $id = 0) {
        if ($id == 0) {
            $res = $this->db->select('t.id, t.type, t.file_name, t.path, t.createdate, m.username, m.name')
                            ->from('t_performance_cor_upload t')
                            ->join('m_user m', 'm.ID_USER = t.createby')
                            ->where("t.po_no", $po)
                            ->get();
        } else {
            $res = $this->db->select('t.id, t.type, t.file_name, t.path, t.createdate, m.username, m.name')
                            ->from('t_performance_cor_upload t')
                            ->join('m_user m', 'm.ID_USER = t.createby')
                            ->where(array('t.po_no' => $po, 't.id' => $id))
                            ->get();
        }
        return $res->result_array();
    }

    public function get_upload_type($po, $type) {
        $res = $this->db->select('t.id, t.type, t.file_name, t.path, t.createdate, m.username, m.name')
                        ->from('t_performance_cor_upload t')
                        ->join('m_user m', 'm.ID_USER = t.createby')
                        ->where('t.po_no', $po)
                        ->where('type', $type);
        return $res->count_all_results();
    }

    public function add_data_file($dt) {
        $res = $this->db->insert('t_performance_cor_upload',$dt);
        return $res;
    }

    public function delete_upload($id) {
        return $this->db->where('id', $id)
                        ->delete('t_performance_cor_upload');
    }

    public function get_msr($po) {
        $res = $this->db->select('msr_no')->from('t_purchase_order')->where('po_no', $po)->get();
        return $res->result_array();
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

    public function update_score($dt,$po){
        $res=$this->db->where('po_no',$po)
                        ->update('t_performance_cor',$dt);
        return $res;
    }

    public function get_list2() {
        $qry = $this->db->query(
        "SELECT o.po_no, CASE
            WHEN o.po_type = 10 THEN 'PO'
            WHEN o.po_type = 20 THEN 'SO'
            WHEN o.po_type = 30 THEN 'Blanket PO'
        END as type_dt, o.po_no, m.title, c.description as company, v.NAMA, r.CURRENCY as currency, b.vendor_id as supplier_id, b.t_cor_id, b.sequence, v.ID_VENDOR, b.id, 'Unconfirmed' as status,
        CASE
            WHEN b.edit_content = 2 THEN 'User Representative'
            ELSE roles.DESCRIPTION
        END as jabatan, b.type, m.title, p.type as cpm
        FROM (
            SELECT t_cor_id, po_no, vendor_id, min(sequence) as sequence
            FROM t_approval_cor
            WHERE status_approve = 0 OR status_approve = 2
            GROUP BY t_cor_id, po_no, vendor_id
        ) a
        JOIN t_performance_cor p ON p.id = a.t_cor_id
        JOIN t_approval_cor b ON b.t_cor_id = a.t_cor_id AND b.po_no = a.po_no AND b.vendor_id = a.vendor_id AND b.sequence = a.sequence
        JOIN t_purchase_order o ON o.po_no = b.po_no
        JOIN t_msr m ON m.msr_no = o.msr_no
        JOIN m_company c ON c.ID_COMPANY = m.id_company
        JOIN m_vendor v ON v.ID = b.vendor_id
        JOIN m_currency r ON r.ID = m.id_currency
        JOIN m_user_roles as roles ON roles.ID_USER_ROLES = b.user_roles
        WHERE ((`b`.`user_id` = '%' AND '" . $_SESSION['ROLES'] . "' LIKE CONCAT('%,', `b`.`user_roles`, ',%')) OR (`b`.`user_id` = " . $_SESSION['ID_USER'] . " AND '" . $_SESSION['ROLES'] . "' LIKE CONCAT('%,', `b`.`user_roles`, ',%'))) AND (status_approve = 0 OR status_approve = 2) AND b.sequence != 1");
        return $qry->result_array();
    }

    public function get_list_home($in = 0) {
        $where = ' and b.sequence not in (1,3) ';
        if($in == 1){
            $where = " and b.user_roles!=31 and b.sequence in (3) ";
        }
        if($in == 2){
            $where = " and b.user_roles=31 and b.sequence in (3) ";
        }
        $qry = $this->db->query(
        "SELECT o.po_no, CASE
            WHEN o.po_type = 10 THEN 'PO'
            WHEN o.po_type = 20 THEN 'SO'
            WHEN o.po_type = 30 THEN 'Blanket PO'
        END as type_dt, o.po_no, m.title, c.description as company, v.NAMA, r.CURRENCY as currency, b.vendor_id as supplier_id, b.t_cor_id, b.sequence, v.ID_VENDOR, b.id, 'Unconfirmed' as status, roles.DESCRIPTION as jabatan, b.type
        FROM (
            SELECT t_cor_id, po_no, vendor_id, min(sequence) as sequence
            FROM t_approval_cor
            WHERE status_approve = 0 OR status_approve = 2
            GROUP BY t_cor_id, po_no, vendor_id
        ) a
        JOIN t_approval_cor b ON b.t_cor_id = a.t_cor_id AND b.po_no = a.po_no AND b.vendor_id = a.vendor_id AND b.sequence = a.sequence
        JOIN t_purchase_order o ON o.po_no = b.po_no
        JOIN t_msr m ON m.msr_no = o.msr_no
        JOIN m_company c ON c.ID_COMPANY = m.id_company
        JOIN m_vendor v ON v.ID = b.vendor_id
        JOIN m_currency r ON r.ID = m.id_currency
        JOIN m_user_roles as roles ON roles.ID_USER_ROLES = b.user_roles
        WHERE ((`b`.`user_id` = '%' AND '" . $_SESSION['ROLES'] . "' LIKE CONCAT('%,', `b`.`user_roles`, ',%')) OR (`b`.`user_id` = " . $_SESSION['ID_USER'] . " AND '" . $_SESSION['ROLES'] . "' LIKE CONCAT('%,', `b`.`user_roles`, ',%'))) AND (status_approve = 0 OR status_approve = 2) AND b.sequence != 1  ".$where." ");
        return $qry;
    }

    public function send_data($tbl,$dt)
    {
        return $this->db->insert_batch($tbl,$dt);
    }

    public function add_data($id)
    {
        return $this->db->query(
            "INSERT INTO t_approval_cor 
                SELECT 'NULL','".$id."' as supplier_id,user_roles,sequence,'0' as status_approve,description,reject_step,module,now(),now() 
                FROM m_approval_rule 
                WHERE module=5                
            ");        
    }

    public function check_data_point($cor)
    {
        $res=$this->db->select('id')
                    ->from('t_performance_cor_detail')
                    ->where('id',$cor)
                    ->get();
        return $res->result();
    }

    public function calc_weight($id, $val) {
        $res = $this->db->select('d.id, ROUND(d.cat_weight * d.kpi_weight * '.$val.' / 10000, 2) as weight', false)
                        ->from('t_cpm_detail d')
                        ->where('d.id', $id)
                        ->get();
        return $res->result();
    }

    public function update_data($dt)
    {
        $res=$this->db->where('id',$dt[0]['id'])
                        ->update_batch('t_performance_cor_detail',$dt,'cor_id');        
        return $res;
    }

    public function check_condition($po, $id, $type) {
        $res = $this->db->query("
            SELECT
            CASE
                WHEN t2.reject_step > 0 THEN 1
                ELSE 0
            END as status_reject, t2.edit_content as status_edit, t.sequence, t.max_seq, t2.user_id
            FROM t_performance_cor c
            JOIN (
                SELECT t.po_no, min(t.sequence) as sequence, max(t.sequence) as max_seq
                FROM `t_approval_cor` t
                WHERE (t.status_approve=0 or t.status_approve=2) AND po_no ='".$po."' AND vendor_id=".$id."
                GROUP BY po_no
            ) t ON t.po_no = c.po_no
            JOIN t_approval_cor t2 ON (t2.status_approve=0 or t2.status_approve=2) AND t2.t_cor_id=c.id AND t2.po_no='".$po."' AND t2.vendor_id=".$id." AND t2.type=".$type." AND t2.sequence=t.sequence
            WHERE c.po_no ='".$po."' AND c.vendor_id=".$id."
        ");
        return $res->result();
    }

    public function get_data_assigned($id, $po, $cor) {
        $res = $this->db->select('t.id, t.sequence, t.description, t.note,
                CASE
                    WHEN t.edit_content = 2 THEN "User Representative"
                    ELSE r.DESCRIPTION
                END as role_desc,
                CASE
                    WHEN t.user_id = "%" THEN "Any User"
                    ELSE u.NAME
                END as name,
                CASE
                    WHEN t.status_approve = 1 AND t.sequence = 1 THEN "Prepared"
                    WHEN t.status_approve = 1 THEN "Approved"
                    WHEN t.status_approve = 2 THEN "Rejected"
                    ELSE "Unconfirmed"
                END as status, r.ID_USER_ROLES as role_id, u.ID_USER, t.user_id as user_id, t.type as type,
                CASE
                    WHEN t.status_approve = 1 THEN t.updatedate
                    ELSE ""
                END as `date`', false)
                        ->from('t_approval_cor t')
                        ->join('m_user u', 'u.ID_USER = t.user_id', 'left')
                        ->join('m_user_roles r', 'r.ID_USER_ROLES = t.user_roles', 'left')
                        ->where(array('t.t_cor_id' => $cor, 't.vendor_id' => $id, 't.po_no' => $po))
                        ->order_by('t.sequence, t.type')
                        ->get();
        return $res->result_array();
    }

    public function update_cor_desc($cor, $vendor, $data) {
        $this->db->where(array('id' => $cor, 'vendor_id' => $vendor))->update('t_performance_cor', $data);
    }

    public function submit_data($dt, $sel) {
        $id = $dt['supplier_id'];
        $seq = $dt['sequence'];
        $cor_id = $dt['tid'];

        $res = false;
        if ($sel == 1) {
            $q = $this->db->query("
                UPDATE t_approval_cor
                SET status_approve = 0
                WHERE status_approve = 2 AND vendor_id = ".$id." AND t_cor_id = '".$cor_id."'");
            $res = $this->db->query("
                UPDATE t_approval_cor
                SET updatedate = '".$dt['updatedate']."', status_approve = ".$dt['status_approve'].", note = '".$dt['note']."', approve_by = '".$this->session->userdata('ID_USER')."'
                WHERE sequence = ".$seq." AND vendor_id = ".$id." AND t_cor_id='".$cor_id."' AND po_no = '".$dt['po']."' AND type = ".$dt['type']);
        } else {
            $q = $this->db->query("
                UPDATE t_approval_cor t
                JOIN t_approval_cor t2 ON t2.vendor_id = t.vendor_id AND t2.po_no = t.po_no AND t2.sequence = ".$seq."
                SET t.status_approve = 0
                WHERE t.vendor_id = ".$id." AND t.t_cor_id = '".$cor_id."' AND t.sequence >= (".$seq."-t2.reject_step)");
            if ($q) {
                $res = $this->db->query("
                    UPDATE t_approval_cor
                    SET status_approve = 2, note = '".$dt['note']."', approve_by = '".$this->session->userdata('ID_USER')."'
                    WHERE vendor_id = ".$id." AND t_cor_id = '".$cor_id."' AND sequence = ".$seq." AND type = ".$dt['type']);
            }            
        }
        return $res;
    }

    public function get_performance_q($po) {
        $res = $this->db->query("
            SELECT DISTINCT m.id, c.category, m.description, m.category_id, c.sequence, d.rating, m.weightage, m.target_answer, p.amount_comp, p.actual_deliv_date, p.check_partial, p.check_penalty, p.amount_penalty, p.input_contract, p.input_actual
            FROM (
                SELECT c.category, c.sequence, c.id, t.po_no
                FROM t_purchase_order t
                JOIN m_cor_performance_category c ON (t.po_type = c.type AND c.status = 1) OR (t.po_type = 30 AND c.type = 10 AND c.status = 1)
                WHERE t.po_no = '".$po."'
            ) c
            JOIN t_approval_cor a ON c.po_no = a.po_no
            JOIN m_cor_performance m ON m.category_id = c.id AND m.status = 1
            JOIN t_performance_cor p ON p.id = a.t_cor_id
            LEFT JOIN t_performance_cor_detail d ON d.id = a.t_cor_id and d.cor_id = m.id
            ORDER BY m.category_id, c.sequence, m.id
        ");
        return $res->result();
    }

    public function get_performance_q_cpm($po) {
        $res = $this->db->query("
            SELECT c.po_no, d.id, d.category_id, d.cat_weight, d.specific_kpi, d.kpi_weight, d.scoring_method, d.target_score, d.target_weight, k.category, p.amount_comp, p.actual_deliv_date, p.check_partial, p.check_penalty, p.amount_penalty, p.input_contract, p.input_actual, pd.rating, dp.scoring, round(d.cat_weight * d.kpi_weight * dp.scoring / 10000, 2) as weighting
            FROM t_purchase_order m
            JOIN t_approval_cor a ON a.po_no = m.po_no
            JOIN t_cpm c ON c.po_no = m.po_no
            JOIN t_cpm_detail d ON d.cpm_id = c.id
            JOIN m_cpm_category k ON k.id = d.category_id
            JOIN t_performance_cor p ON p.id = a.t_cor_id
            JOIN (
                SELECT cpm_detail_id, floor(avg(adjust_score)) as scoring
                FROM t_cpm_detail_phase
                GROUP BY cpm_detail_id
            ) dp ON dp.cpm_detail_id = d.id
            LEFT JOIN t_performance_cor_detail pd ON pd.id = a.t_cor_id and pd.cor_id = d.id
            WHERE a.sequence = 1 AND k.status = 1 AND m.po_no = '" . $po . "'
            ORDER BY d.category_id, d.id
        ");
        return $res->result();
    }
}