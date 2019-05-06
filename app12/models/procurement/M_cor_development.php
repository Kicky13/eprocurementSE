<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_cor_development extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_header_prepare($po, $vendor) {
        $res = $this->db->select('t.msr_no,
            CASE
                WHEN o.po_type = 10 THEN "Purchase Order"
                WHEN o.po_type = 20 THEN "Service Order"
                WHEN o.po_type = 30 THEN "Blanket Purchase Order"
                ELSE "Non"
            END as po_type, t.company_desc as comp, t.title, m1.NAME as req, v.NAMA as vendor, t.costcenter_desc as dept, o.delivery_date, o.total_amount_base, r.DESCRIPTION as cor_role, r.ID_USER_ROLES as cor_role_id', false)
                        ->from('t_purchase_order o')
                        ->join('t_msr t', 't.msr_no = o.msr_no')
                        ->join('m_user m1', 'm1.ID_USER = t.create_by')
                        ->join('m_approval_modul am', 'am.description LIKE "COR APPROVAL"')
                        ->join('m_approval_rule ar', 'ar.module = am.id')
                        ->join('m_user_roles r', 'r.ID_USER_ROLES = ar.user_roles')
                        ->join('m_vendor v', 'v.ID = o.id_vendor')
                        ->where(array('o.po_no' => $po, 'o.id_vendor' => $vendor, 'ar.sequence' => 1))
                        ->get();
        return $res->result();
    }

    public function get_header_progress($po, $vendor) {
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

    public function get_history($cor) {
        $res = $this->db->select('*')
                        ->from('log_history')
                        ->where(array('data_id' => $cor, 'module_kode' => 'cor'))
                        ->order_by('created_at')
                        ->get();
        return $res->result_array();
    }

    public function get_list_prepared($from_cpm) {
        if ($from_cpm == 2) {
            $qry = $this->db->query("
                SELECT DISTINCT `m`.`po_no`, a.po_no as cpm, CASE
                    WHEN m.po_type=10 THEN 'PO'
                    WHEN m.po_type=20 THEN 'SO'
                    WHEN m.po_type=30 THEN 'Blanket PO'
                END as type, `m`.`title`, `c`.`description` as `company`, `v`.`NAMA`, `r`.`CURRENCY` as `currency`, `m`.`id_vendor`, m.total_amount_base as value, c.ABBREVIATION
                FROM `t_purchase_order` `m`
                JOIN (
                    SELECT a.po_no, count(a.phase_id) as counter
                    FROM (
                        SELECT po_no, phase_id, max(sequence)
                        FROM t_approval_cpm
                        WHERE status_approve = 1 AND status = 1
                        GROUP BY po_no, phase_id) a
                    GROUP BY po_no
                ) a ON a.po_no = m.po_no
                JOIN (
                    SELECT po_no, count(po_no) as counter
                    FROM t_cpm_phase
                    GROUP BY po_no
                ) f ON f.po_no = m.po_no
                JOIN t_msr m2 ON m2.msr_no = m.msr_no
                JOIN `m_company` `c` ON `c`.`ID_COMPANY`=`m2`.`id_company`
                JOIN `m_vendor` `v` ON `v`.`ID`=`m`.`id_vendor`
                JOIN `m_currency` `r` ON `r`.`ID`=`m2`.`id_currency`
                WHERE m.po_no NOT IN (SELECT po_no FROM t_approval_cor) AND a.counter = f.counter AND m.issued = 1
                ");
        } else {
            $qry = $this->db->query("
                SELECT DISTINCT `m`.`po_no`, a.po_no as cpm, CASE
                    WHEN m.po_type=10 THEN 'PO'
                    WHEN m.po_type=20 THEN 'SO'
                    WHEN m.po_type=30 THEN 'Blanket PO'
                END as type, `m`.`title`, `c`.`description` as `company`, `v`.`NAMA`, `r`.`CURRENCY` as `currency`, `m`.`id_vendor`, m.total_amount_base as value, c.ABBREVIATION
                FROM `t_purchase_order` `m`
                LEFT JOIN (
                    SELECT DISTINCT po_no, max(sequence)
                    FROM t_approval_cpm
                    WHERE status_approve = 1 AND status = 1
                    GROUP BY po_no
                ) a ON a.po_no = m.po_no
                JOIN t_msr m2 ON m2.msr_no = m.msr_no
                JOIN `m_company` `c` ON `c`.`ID_COMPANY`=`m2`.`id_company`
                JOIN `m_vendor` `v` ON `v`.`ID`=`m`.`id_vendor`
                JOIN `m_currency` `r` ON `r`.`ID`=`m2`.`id_currency`
                WHERE m.po_no NOT IN (SELECT po_no FROM t_approval_cor) AND m.delivery_date <= DATE(NOW() - INTERVAL 90 DAY) AND a.po_no IS NULL
                ");
        }
        return $qry->result_array();
    }

    public function get_list_progress($from_cpm) {
        if ($from_cpm == 2) {
            $qry = $this->db->query("
                SELECT DISTINCT o.po_no, CASE
                    WHEN o.po_type = 10 THEN 'PO'
                    WHEN o.po_type = 20 THEN 'SO'
                    WHEN o.po_type = 30 THEN 'Blanket PO'
                END as type, `m`.`title`, t.t_cor_id as cor_id, t.status_approve, t.vendor_id as supplier_id, t.sequence, v.ID_VENDOR, t.id,
                CASE
                    WHEN t.edit_content = 2 THEN 'User Representative'
                    ELSE roles.DESCRIPTION
                END as jabatan, p.type as cpm
                FROM (
                    SELECT b.id, b.po_no, b.t_cor_id, b.sequence as sequence, CASE
                            WHEN c.user_roles IS NULL THEN b.user_roles
                            ELSE c.user_roles
                        END as user_roles, CASE
                            WHEN c.status_approve = 2 THEN c.status_approve
                            ELSE b.status_approve
                        END as status_approve, CASE
                            WHEN c.status_approve = 2 THEN c.edit_content
                            ELSE b.edit_content
                        END as edit_content, b.extra_case, b.createdate, b.vendor_id
                    FROM (
                        SELECT MIN(id) as id, MIN(sequence) as sequence, t_cor_id, vendor_id
                        FROM t_approval_cor
                        WHERE status_approve = 0 OR status_approve = 2
                        GROUP BY t_cor_id, vendor_id
                    ) a
                    JOIN t_approval_cor b ON b.t_cor_id = a.t_cor_id AND b.vendor_id = a.vendor_id AND b.sequence = a.sequence AND b.id = a.id
                    LEFT JOIN t_approval_cor c ON c.t_cor_id = a.t_cor_id AND c.vendor_id = a.vendor_id AND c.status_approve = 2
                ) t
                JOIN t_performance_cor p ON p.id = t.t_cor_id
                JOIN t_purchase_order o ON o.po_no = t.po_no
                JOIN t_msr m ON m.msr_no = o.msr_no
                JOIN m_company c ON c.ID_COMPANY = m.id_company
                JOIN m_vendor v ON v.ID = t.vendor_id
                JOIN m_currency r ON r.ID = m.id_currency
                JOIN m_user_roles as roles ON roles.ID_USER_ROLES = t.user_roles
                WHERE p.type = 2
                ");
        } else {
            $qry = $this->db->query("
                SELECT DISTINCT o.po_no, CASE
                    WHEN o.po_type = 10 THEN 'PO'
                    WHEN o.po_type = 20 THEN 'SO'
                    WHEN o.po_type = 30 THEN 'Blanket PO'
                END as type, `m`.`title`, t.t_cor_id as cor_id, t.status_approve, t.vendor_id as supplier_id, t.sequence, v.ID_VENDOR, t.id,
                CASE
                    WHEN t.edit_content = 2 THEN 'User Representative'
                    ELSE roles.DESCRIPTION
                END as jabatan, p.type as cpm
                FROM (
                    SELECT b.id, b.po_no, b.t_cor_id, b.sequence as sequence, CASE
                            WHEN c.user_roles IS NULL THEN b.user_roles
                            ELSE c.user_roles
                        END as user_roles, CASE
                            WHEN c.status_approve = 2 THEN c.status_approve
                            ELSE b.status_approve
                        END as status_approve, CASE
                            WHEN c.status_approve = 2 THEN c.edit_content
                            ELSE b.edit_content
                        END as edit_content, b.extra_case, b.createdate, b.vendor_id
                    FROM (
                        SELECT MIN(id) as id, MIN(sequence) as sequence, t_cor_id, vendor_id
                        FROM t_approval_cor
                        WHERE status_approve = 0 OR status_approve = 2
                        GROUP BY t_cor_id, vendor_id
                    ) a
                    JOIN t_approval_cor b ON b.t_cor_id = a.t_cor_id AND b.vendor_id = a.vendor_id AND b.sequence = a.sequence AND b.id = a.id
                    LEFT JOIN t_approval_cor c ON c.t_cor_id = a.t_cor_id AND c.vendor_id = a.vendor_id AND c.status_approve = 2
                ) t
                JOIN t_performance_cor p ON p.id = t.t_cor_id
                JOIN t_purchase_order o ON o.po_no = t.po_no
                JOIN t_msr m ON m.msr_no = o.msr_no
                JOIN m_company c ON c.ID_COMPANY = m.id_company
                JOIN m_vendor v ON v.ID = t.vendor_id
                JOIN m_currency r ON r.ID = m.id_currency
                JOIN m_user_roles as roles ON roles.ID_USER_ROLES = t.user_roles
                WHERE p.type = 1
                ");
        }
        return $qry->result_array();
    }

    public function get_msr($po) {
        $res = $this->db->select('msr_no')->from('t_purchase_order')->where('po_no', $po)->get();
        return $res->result_array();
    }

    public function check_data_temp($id,$po)
    {
        $res=$this->db->query("SELECT id from t_approval_cor_temp WHERE vendor_id=".$id." AND po_no='".$po."'");
        return $res->result();
    }

    public function insert_temp_data($id, $po) {
        $res = $this->db->query("
            INSERT INTO t_approval_cor_temp
            SELECT NULL,'".$po."', ".$id.", 0, 0,
                CASE
                    WHEN type='SERIAL' THEN 0
                    ELSE 1
                END as type, sequence, 0, description, reject_step, email_approve, email_reject, edit_content, extra_case, module, now(), now()
            FROM m_approval_rule m
            WHERE m.module = (
                SELECT id
                FROM m_approval_modul
                WHERE description = 'COR APPROVAL'
                ORDER BY sequence, type
            )
            ORDER BY sequence, type");
        return $res;
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

    public function add_data_file($dt) {
        $res = $this->db->insert('t_performance_cor_upload',$dt);
        return $res;
    }

    public function delete_upload($id) {
        return $this->db->where('id', $id)
                        ->delete('t_performance_cor_upload');
    }

    public function check_maker($cor, $po) {
        $res = $this->db->select('user_id, user_roles')
                        ->from('t_approval_cor')
                        ->where(array('t_cor_id' => $cor, 'po_no' => $po, 'sequence' => 1))
                        ->get();
        return $res->result_array();
    }

    public function get_role_assigned($po, $vendor) {
        $res = $this->db->select('a.id, a.sequence, a.description, r.DESCRIPTION as role_desc, a.type, r.ID_USER_ROLES as role_id, t.user_id as cur_user, a.edit_content')
                        ->from('m_approval_rule a')
                        ->join('m_user_roles r', 'r.ID_USER_ROLES = a.user_roles')
                        ->join('t_approval_cor_temp t', 't.sequence = a.sequence AND t.description = a.description', 'left')
                        ->where(array('a.module' => 5, 't.po_no' => $po, 't.vendor_id' => $vendor))
                        ->order_by('a.sequence, a.id')
                        ->get();
        return $res->result_array();
    }

    public function get_user_assigned() {
        $res = $this->db->distinct()
                        ->select('u.ID_USER as user_id, u.NAME as user_name, m.user_roles as user_role')
                        ->from('m_user u')
                        ->join('m_approval_rule m', 'u.ROLES LIKE CONCAT("%", m.user_roles, "%")')
                        ->where(array('m.module' => 5, 'm.user_roles != ' => 32))
                        ->order_by('m.user_roles')
                        ->get();
        return $res->result_array();
    }

    public function get_owner_assigned($po) {
        $res = $this->db->select('u.ID_USER as user_id, u.NAME as user_name, u.ROLES as role')
                        ->from('m_user u')
                        ->join('t_msr m', 'u.ID_USER = m.create_by')
                        ->join('t_purchase_order o', 'o.msr_no = m.msr_no')
                        ->where('o.po_no', $po)
                        ->get();
        return $res->result_array();
    }

    public function get_data_assigned($id, $po) {
        $res = $this->db->query(
            'SELECT m.id,m.sequence,m.description,r.DESCRIPTION as role2,u.NAME as name,\'Unconfirmed\' as status,m.type,
                CASE
                    WHEN  m.edit_content=0 AND m.extra_case=1 THEN "1"
                    ELSE "0"
                END as status_assigned,r.ID_USER_ROLES,u.ID_USER
                FROM m_approval_rule m
                JOIN m_user u ON u.ROLES LIKE CONCAT(\'%\',m.user_roles,\'%\')
                JOIN m_user_roles r ON  r.ID_USER_ROLES=m.user_roles
                WHERE m.module = 5
                order by m.sequence,m.type
        ');
        return $res->result_array();
    }

    public function send_data($tbl,$dt)
    {
        return $this->db->insert_batch($tbl,$dt);
    }

    public function add_data_perf($dt)
    {
        return $this->db->insert("t_performance_cor",$dt);
    }

    public function delete_temp($id,$po)
    {
        $res=$this->db->where('po_no=',$po)
                    ->where('vendor_id=',$id)
                    ->delete('t_approval_cor_temp');
    }

    public function add_data($cor, $id, $po) {
        $res = $this->db->query("
            INSERT INTO t_approval_cor
                SELECT id, t_cor_id, po_no, vendor_id, user_roles, user_id, type, sequence, status_approve, description, reject_step, email_approve, email_reject, edit_content, extra_case, module, note, approve_by, created, updated
                FROM (
                        SELECT 'NULL' as id, '".$cor."' as t_cor_id, po_no, '".$id."' as vendor_id, user_roles, user_id, type, sequence,
                        CASE
                            WHEN sequence=1 THEN '1'
                            ELSE '0'
                        END as status_approve, description, reject_step, email_approve, email_reject, edit_content, extra_case, module,
                        CASE
                            WHEN sequence=1 THEN 'Prepared'
                            ELSE NULL
                        END as note,
                        CASE
                            WHEN sequence=1 THEN '".$this->session->userdata('ID_USER')."'
                            ELSE NULL
                        END as approve_by,
                        now() as created, now() as updated
                        FROM t_approval_cor_temp
                        WHERE vendor_id=".$id." AND po_no='".$po."'
                ) a
                ORDER BY sequence
            ");
        return $res;
    }

    public function edit_data($data) {
        $res = $this->db->update_batch('t_approval_cor', $data, 'id');
        return $res;
    }

    public function get_email_dest($tid) {
        $qry = $this->db->query(
            "SELECT v.URL_BATAS_HARI as hari, v.NAMA, b.user_id as recipients, b.user_roles as rec_role, b.reject_step, b.email_approve, b.email_reject, n.OPEN_VALUE, n.CLOSE_VALUE, n.TITLE
            FROM (
                SELECT t_cor_id, min(sequence) as sequence
                FROM t_approval_cor
                WHERE t_cor_id ='" . $tid . "' AND status_approve = 0 AND extra_case = 0
                GROUP BY t_cor_id
            ) a
            JOIN t_approval_cor b ON b.t_cor_id = a.t_cor_id AND b.sequence = a.sequence
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

    public function get_id($id)
    {
        $res=$this->db->query(
            "SELECT CONCAT(id_company,'/',CONVERT(date_format(curdate(),'%Y/%m/') USING utf8),RIGHT(CONCAT('00000',(
                SELECT COUNT(id)+1 as total FROM t_performance_cor)),6)) as id
            FROM ( SELECT t.id_company from t_purchase_order o JOIN t_msr t ON t.msr_no=o.msr_no WHERE o.po_no='".$id."')a
            LIMIT 1
            -- WHERE msr_no ='".$id."'
        ");
        return  $res->result_array();
    }

    public function get_con_val($po, $vendor) {
        $res = $this->db->select('CASE
                                    WHEN tkdn_value_combination > 0 THEN tkdn_value_combination
                                    WHEN po_type = 20 THEN tkdn_value_service
                                    ELSE tkdn_value_goods
                                END as tkdn_value', false)
                        ->from('t_purchase_order')
                        ->where('po_no', $po)
                        ->where('id_vendor', $vendor)
                        ->get();
        return $res->result_array();
    }

    public function get_data($id, $cor) {
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
                    END as status, r.ID_USER_ROLES as role_id, t.user_id as user_id, t.type as type, edit_content,
                    CASE
                        WHEN t.status_approve = 0 THEN ""
                        ELSE t.updatedate
                    END as date', false)
                        ->from('t_approval_cor t')
                        ->join('m_user u', 'u.ID_USER = t.user_id', 'left')
                        ->join('m_user_roles r', 'r.ID_USER_ROLES = t.user_roles', 'left')
                        ->where(array('t.t_cor_id' => $cor, 't.vendor_id' => $id))
                        ->order_by('t.sequence')
                        ->get();
        return $res->result_array();
    }

    public function update_user($dt) {
        $res = $this->db->query("
            UPDATE t_approval_cor_temp t
            SET t.user_roles = ".$dt['roles'].", t.user_id='".$dt['idusr']."'
            WHERE t.po_no='".$dt['po']."' AND t.vendor_id=".$dt['idvendor']." AND t.sequence=".$dt['seq']." AND t.type=".$dt['sel']);
        return $res;
    }

    public function update_user_old($dt, $cor) {
        $res = $this->db->query("
            UPDATE t_approval_cor t
            SET t.user_roles=".$dt['roles'].", t.user_id='".$dt['idusr']."', t.status_approve = 0
            WHERE t.po_no='".$dt['po']."' AND t.vendor_id=".$dt['idvendor']." AND t.sequence=".$dt['seq']." AND t.t_cor_id=".$cor." AND t.type=".$dt['sel']);
        return $res;
    }

    public function submit_data($dt,$sel)
    {
        $id=$dt['supplier_id'];
        unset($dt['supplier_id']);
        $seq=$dt['sequence'];
        unset($dt['sequence']);
        $res=false;
        if($sel == 1)
        {
        $res= $this->db->query(
            "UPDATE t_approval_cor as t
            LEFT JOIN t_approval_cor t2 ON t2.supplier_id = t.supplier_id AND t2.status_approve=2
            SET t.status_approve =".$dt['status_approve'].",t.updatedate='".$dt['updatedate']."' ,t2.status_approve=0
            WHERE t.sequence =".$seq." AND t.supplier_id =".$id);
        }
        else{
            $q= $this->db->query(
                "UPDATE t_approval_cor t set t.status_approve=0
                where t.supplier_id=".$id." AND  t.sequence BETWEEN (".$seq."-t.reject_step) AND ".$seq);
            if($q)
            {
                $res= $this->db->query(
                "UPDATE t_approval_cor t set t.status_approve=2
                WHERE t.supplier_id=".$id." AND t.sequence =".$seq);
            }
        }
        return $res;
    }

    public function get_performance_q($id, $po) {
        if ($id == 0) {
            $res = $this->db->query("
                SELECT DISTINCT m.sequence a,m.id, c.category, m.description, m.category_id, c.sequence, 1 as state
                FROM (
                    SELECT c.category, c.sequence, c.id
                    FROM t_purchase_order t
                    JOIN m_cor_performance_category c ON (t.po_type = c.type AND c.status = 1) OR (t.po_type = 30 AND c.type = 10 AND c.status = 1)
                    WHERE t.po_no = '".$po."'
                ) c
                JOIN m_cor_performance m ON m.category_id = c.id AND m.status = 1
                ORDER BY m.category_id, c.sequence, m.sequence
            ");
            return $res->result();
        } else {
            $res = $this->db->query("
                SELECT DISTINCT m.id, c.category, m.description, m.category_id, c.sequence, d.rating, m.weightage, m.target_answer,
                CASE
                    WHEN a.status_approve = 1 THEN 2
                    ELSE 3
                END as state, p.amount_comp, p.actual_deliv_date, p.check_partial, p.check_penalty, p.amount_penalty, p.input_contract, p.input_actual
                FROM (
                    SELECT c.category, c.sequence, c.id, t.po_no
                    FROM t_purchase_order t
                    JOIN m_cor_performance_category c ON (t.po_type = c.type AND c.status = 1) OR (t.po_type = 30 AND c.type = 10 AND c.status = 1)
                    WHERE t.po_no='".$po."'
                ) c
                JOIN t_approval_cor a ON c.po_no = a.po_no
                JOIN m_cor_performance m ON m.category_id = c.id AND m.status = 1
                JOIN t_performance_cor p ON p.id = a.t_cor_id
                LEFT JOIN t_performance_cor_detail d ON d.id = a.t_cor_id and d.cor_id = m.id
                WHERE a.sequence = 1
                ORDER BY m.category_id, c.sequence, m.id
            ");
            return $res->result();
            // $res = $this->db->select('t.cor_id as id, c.category, m.description, t.rating, m.weightage, m.target_answer')
            //                 ->from('t_performance_cor p')
            //                 ->join('t_performance_cor_detail t', 't.id = p.id', 'left')
            //                 ->join('m_cor_performance m','m.id = t.cor_id','')
            //                 ->join('m_cor_performance_category c','m.category_id = c.id and c.status=1')
            //                 ->where('p.po_no', $po)
            //                 ->order_by('m.category_id, c.sequence, m.id')
            //                 ->get();
            // return $res->result();
        }
    }

    public function get_performance_q_cpm($id, $po) {
        if ($id == 0) {
            $res = $this->db->query("
                SELECT c.po_no, d.id, d.category_id, d.cat_weight, d.specific_kpi, d.kpi_weight, d.scoring_method, d.target_score, d.target_weight, 1 as state, k.category
                FROM t_purchase_order m
                JOIN t_cpm c ON c.po_no = m.po_no
                JOIN t_cpm_detail d ON d.cpm_id = c.id
                JOIN m_cpm_category k ON k.id = d.category_id
                WHERE k.status = 1 AND m.po_no = '" . $po . "'
                ORDER BY d.category_id, d.id
            ");
            return $res->result();
        } else {
            $res = $this->db->query("
                SELECT c.po_no, d.id, d.category_id, d.cat_weight, d.specific_kpi, d.kpi_weight, d.scoring_method, d.target_score, d.target_weight,
                CASE
                    WHEN a.status_approve = 1 THEN 2
                    ELSE 3
                END as state, k.category, p.amount_comp, p.actual_deliv_date, p.check_partial, p.check_penalty, p.amount_penalty, p.input_contract, p.input_actual, pd.rating
                FROM t_purchase_order m
                JOIN t_approval_cor a ON a.po_no = m.po_no
                JOIN t_cpm c ON c.po_no = m.po_no
                JOIN t_cpm_detail d ON d.cpm_id = c.id
                JOIN m_cpm_category k ON k.id = d.category_id
                JOIN t_performance_cor p ON p.id = a.t_cor_id
                LEFT JOIN t_performance_cor_detail pd ON pd.id = a.t_cor_id and pd.cor_id = d.id
                WHERE a.sequence = 1 AND k.status = 1 AND m.po_no = '" . $po . "'
                ORDER BY d.category_id, d.id
            ");
            return $res->result();
        }
    }
}
