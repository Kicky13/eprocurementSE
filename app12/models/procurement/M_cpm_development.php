<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_cpm_development extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
/* ===========================================-------- API START------- ====================================== */

    public function check_id($po,$vendor,$sel=0)
    {
        if($sel == 0)
        {
            $res=$this->db->select("id")
                        ->from("t_cpm")
                        ->where("po_no",$po)
                        ->where("vendor_id",$vendor)
                        ->get();

        }
        else{
            $res=$this->db->select("t.id,d.specific_kpi,COUNT(d.id) as total")
            ->from("t_cpm t")
            ->join('t_cpm_detail d','d.cpm_id=t.id AND d.category_id='.$sel,'')
            ->where("t.po_no",$po)
            ->where("t.vendor_id",$vendor)
            ->group_by("t.id,d.specific_kpi")
            ->get();

        }
        if($res->num_rows() != 0)
            return $res->result();
        else
            return false;
    }

    public function get_id($po)
    {
        $res=$this->db->query(
            "SELECT CONCAT(id_company,'/',CONVERT(date_format(curdate(),'%Y/%m/') USING utf8),RIGHT(CONCAT('00000',(
                SELECT COUNT(id)+1 as total FROM t_cpm)),6)) as id
            FROM ( SELECT t.id_company from t_purchase_order o JOIN t_msr t ON t.msr_no=o.msr_no WHERE o.po_no='".$po."')a
            LIMIT 1
        ");
        if($res->num_rows() != 0)
            return $res->result();
        else
            return false;
    }

    public function add_cpm_data($tbl, $dt) {
        return $this->db->insert($tbl, $dt);
    }

    public function update_cpm_data($tbl, $dt, $cond) {
        return $this->db->where($cond)->update($tbl, $dt);
    }

    public function check_phase($po_no) {
        $res = $this->db->select('id, phase, due_date')
                ->from('t_cpm_phase')
                ->where('po_no', $po_no)
                ->order_by('phase')
                ->get();
        if ($res->num_rows() != 0)
            return $res->result_array();
        else
            return false;
    }

    public function add_phase($dt) {
        $res = $this->db->insert('t_cpm_phase', $dt);
        if ($res != false) {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
        return $res;
    }

    public function add_notif($dt) {
        $res = $this->db->insert_batch('t_cpm_phase_notif', $dt);
        return $res;
    }

    public function update_phase($dt, $po, $phase) {
        $res = $this->db->where('phase', $phase)
                        ->where('po_no', $po)
                        ->update('t_cpm_phase', $dt);
        return $res;
    }

    public function update_notif($dt, $po, $phase) {
        $phase = $this->db->select('n.id')
                          ->from('t_cpm_phase_notif n')
                          ->join('t_cpm_phase p', 'n.phase_id = p.id')
                          ->where(array('p.phase' => $phase, 'p.po_no' => $po))
                          ->order_by('n.due_date')
                          ->get()->result_array();
        for ($i = 0; $i < count($phase); $i++) {
            $dt[$i]['id'] = $phase[$i]['id'];
        }
        return $this->db->update_batch('t_cpm_phase_notif', $dt, 'id');
    }

    public function add_data_file($dt)
    {
        $res=$this->db->insert('t_cpm_upload',$dt);
        return $res;
    }

    public function update_weight($dt, $cond) {
        $res = $this->db->set('cat_weight', $dt['cat_weight'])
                        ->set('target_weight', "CASE WHEN kpi_weight IS NULL THEN '' ELSE ROUND(cat_weight * kpi_weight * target_score / 10000, 2) END", false)
                        ->set('updateby', $dt['updateby'])
                        ->set('updatedate', $dt['updatedate'])
                        ->where($cond)
                        ->update('t_cpm_detail');
        return $res;
    }

    public function add_kpi_detail($dt, $cond) {
        $res = false;
        $sel = $this->db->distinct()
                        ->select('category_id, cat_weight')
                        ->from('t_cpm_detail')
                        ->where(array('cpm_id' => $dt['cpm_id'], 'category_id' => $dt['category_id']))
                        ->get();

        if ($sel != false) {
            $sel = $sel->result_array();
            if ($cond == 1) {
                $dt['cat_weight'] = $sel[0]['cat_weight'];
                $dt['target_weight'] = round(($sel[0]['cat_weight'] * $dt['kpi_weight'] * $dt['target_score']) / 10000, 2);
                $dt['updateby'] = $dt['createby'];
                $dt['updatedate'] = $dt['createdate'];
                $res = $this->db->insert('t_cpm_detail', $dt);
            } else if ($cond == 2) {
                $res = $this->db->set('specific_kpi', $dt['specific_kpi'])
                                ->set('kpi_weight', $dt['kpi_weight'])
                                ->set('scoring_method', $dt['scoring_method'])
                                ->set('target_score', $dt['target_score'])
                                ->set('target_weight', round($sel[0]['cat_weight'] * $dt['kpi_weight'] * $dt['target_score'] / 10000, 2))
                                ->set('updateby', $dt['createby'])
                                ->set('updatedate', $dt['createdate'])
                                ->where(array('cpm_id' => $dt['cpm_id'], 'category_id' => $dt['category_id']))
                                ->update('t_cpm_detail');
            } else if ($cond == 3) {
                $res = $this->db->set('specific_kpi', $dt['specific_kpi'])
                                ->set('kpi_weight', $dt['kpi_weight'])
                                ->set('scoring_method', $dt['scoring_method'])
                                ->set('target_score', $dt['target_score'])
                                ->set('target_weight', round($sel[0]['cat_weight'] * $dt['kpi_weight'] * $dt['target_score'] / 10000, 2))
                                ->set('updateby', $dt['createby'])
                                ->set('updatedate', $dt['createdate'])
                                ->where(array('cpm_id' => $dt['cpm_id'], 'category_id' => $dt['category_id'], 'id' => $dt['kpi_id']))
                                ->update('t_cpm_detail');
            }
        }
        return $res;
    }

    public function delete_dt($id) {
        return $this->db->where('id', $id)
                        ->delete('t_cpm_detail');
    }

    public function delete_upload($id) {
        return $this->db->where('id', $id)
                        ->delete('t_cpm_upload');
    }

    public function check_list($po) {
        $res=$this->db->query("
            SELECT pf.head, filled, total
            FROM (SELECT 'Schedule' as head, count(id) as filled FROM t_cpm_phase WHERE po_no = '" . $po . "' AND due_date >= CURDATE()) pf
            JOIN (SELECT 'Schedule' as head, count(id) as total FROM t_cpm_phase WHERE po_no = '" . $po . "') pt
            ON pf.head = pt.head
            UNION
            SELECT kf.head, filled, total
            FROM (SELECT 'KPI' as head, count(DISTINCT d.category_id) as filled FROM t_cpm_detail d JOIN t_cpm c ON d.cpm_id = c.id WHERE c.po_no = '" . $po . "' AND d.specific_kpi != '') kf
            JOIN (SELECT 'KPI' as head, count(DISTINCT d.category_id) as total FROM t_cpm_detail d JOIN t_cpm c ON d.cpm_id = c.id WHERE c.po_no = '" . $po . "') kt
            ON kf.head = kt.head
            UNION
            SELECT 'Approval List' as head, '-' as filled, count(id) as total FROM t_approval_cpm_temp WHERE po_no = '" . $po . "'
            UNION
            SELECT 'Attachment' as head, '-' as filled, count(id) as total FROM t_cpm_upload WHERE po_no = '" . $po . "'
        ");
        return $res->result_array();
    }

    public function send_all($po) {
        $res = $this->db->query("
            INSERT INTO t_approval_cpm(SELECT *
            FROM (
                SELECT 'NULL' as id,po_no,vendor_id,29 as user_roles,'%' as user_id,0 as type,1 as sequence,1 as status_approve,
                0 as reject_step,28 as appr1,29 as rej1,1 as edit_content,0 as appr,0 as rej,0 as extra,'Approved' as note,'".$this->session->userdata('ID_USER')."' as approve_by,now() as createn,now() as updaten
                    FROM t_approval_cpm_temp
                    WHERE po_no='".$po."'
            UNION
                SELECT 'NULL' as id,po_no,vendor_id,30 as user_roles,'%' as user_id,0 as type,2 as sequence,0 as status_approve,
                1 as reject_step,28 as appr1,29 as rej1,0 as edit_content,0 as appr,0 as rej,0 as extra,null as note, null as approve_by,now() as createn,now() as updaten
                    FROM t_approval_cpm_temp
                    WHERE po_no='".$po."'
            UNION
                SELECT 'NULL' as id,po_no,vendor_id,user_roles,user_id,type,sequence,status_approve,CASE
                    WHEN sequence=1 THEN 0
                    ELSE sequence-1
                END as reject_step,28 as appr1,29 as rej1,CASE
                    WHEN sequence=1 THEN 1
                    ELSE 0
                END as edit_content,0 as appr,0 as rej,0 as extra,null as note, null as approve_by,now() as createn,now() as updaten
                    FROM t_approval_cpm_temp
                    WHERE po_no='".$po."'
            UNION
                SELECT 'NULL'as id,po_no,vendor_id,29 as user_roles,'%' as user_id,0 as type,99 as sequence,0 as status_approve,
                0 as reject_step,28 as appr1,29 as rej1,0 as edit_content,0 as appr,0 as rej,0 as extra,null as note, null as approve_by,now() as createn,now() as updaten
                    FROM t_approval_cpm_temp
                    WHERE po_no='".$po."'
            )a
            )");
        return $res;
    }

    public function del_old($po) {
        $res = $this->db->delete('t_approval_cpm', array('po_no' => $po));
        return $res;
    }

/* ===========================================-------- get data START------- ====================================== */

    public function get_cpm_detail($po, $vendor, $phase) {
        if ($phase == 0) {
            $res = $this->db->query(
                "SELECT DISTINCT d.id,d.category_id,m.category,d.cat_weight as weight,d.specific_kpi,d.kpi_weight,d.scoring_method,d.target_score,d.target_weight,total ,COALESCE(dp.actual_score,' ') as actual_score,COALESCE(dp.actual_weight,' ') as actual_weight,COALESCE(dp.adjust_score,' ') as adjust_score,COALESCE(dp.adjust_weight,' ') as adjust_weight, CASE
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
                "SELECT DISTINCT d.id as id, d.category_id, m.category, d.cat_weight as weight, d.specific_kpi, d.kpi_weight, d.scoring_method, d.target_score, d.target_weight, total, dp.actual_score, dp.actual_weight, dp.adjust_score, dp.adjust_weight, CASE
                        WHEN dp.remarks IS NULL THEN ''
                        ELSE dp.remarks
                    END as remarks
                FROM (
                    SELECT t.cpm_id, t.cat_weight, t.category_id, count(t.id) as total
                    FROM(
                        SELECT DISTINCT t.category_id, t.cpm_id, t.cat_weight
                        FROM t_cpm c
                        JOIN t_cpm_detail t ON t.cpm_id = c.id
                        WHERE po_no = '".$po."' AND vendor_id = ".$vendor."
                    )a
                    JOIN t_cpm_detail t ON t.category_id = a.category_id AND t.cpm_id = a.cpm_id AND t.cat_weight = a.cat_weight
                    GROUP BY t.cpm_id, t.cat_weight, t.category_id
                ) a
                JOIN t_cpm_detail d ON d.cpm_id = a.cpm_id AND d.cat_weight = a.cat_weight AND d.category_id = a.category_id
                LEFT JOIN t_cpm_detail_phase dp ON dp.cpm_id = a.cpm_id AND dp.cpm_detail_id = d.id AND dp.phase_id = ".$phase."
                JOIN m_cpm_category m ON a.category_id = m.id
                ORDER BY d.category_id ASC"
            );
        }
        return $res->result();
    }

    public function get_kpi_spec($kpi) {
        $res = $this->db->select('category_id, specific_kpi, kpi_weight, scoring_method, target_score')
                        ->from('t_cpm_detail')
                        ->where('id', $kpi)
                        ->get();
        return $res->result_array();
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
                        ->join('m_user_roles r', 'r.ID_USER_ROLES = 29')
                        ->join('m_vendor v', 'v.ID = o.id_vendor')
                        ->where(array('o.po_no' => $po, 'o.id_vendor' => $vendor))
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
            END as po_type, t.company_desc as comp, t.title, m1.NAME as req, v.NAMA as vendor, t.costcenter_desc as dept, o.delivery_date, o.total_amount_base, m2.NAME as cor_creator, r.DESCRIPTION as cor_role, c.create_date', false)
                        ->from('t_purchase_order o')
                        ->join('t_msr t', 't.msr_no = o.msr_no')
                        ->join('t_approval_cpm c', 'c.po_no = o.po_no')
                        ->join('m_user m1', 'm1.ID_USER = t.create_by')
                        ->join('m_user m2', 'm2.ID_USER = c.user_id')
                        ->join('m_user_roles r', 'r.ID_USER_ROLES = c.user_roles')
                        ->join('m_vendor v', 'v.ID = o.id_vendor')
                        ->where(array('o.po_no' => $po, 'o.id_vendor' => $vendor, 'c.sequence' => 1, 'c.extra_case' => 0))
                        ->get();
        return $res->result();
    }

    public function get_history($po, $phase) {
        $res = $this->db->select('*')
                        ->from('log_history')
                        ->where(array('data_id' => $po, 'module_kode' => $phase))
                        ->order_by('created_at')
                        ->get();
        return $res->result_array();
    }

    public function get_list_prepared() {
        $res = $this->db->query(
            "SELECT DISTINCT `o`.`po_no`, CASE
                WHEN o.po_type = 10 THEN 'PO'
                WHEN o.po_type = 20 THEN 'SO'
                WHEN o.po_type = 30 THEN 'Blanket PO'
            END as type, `m`.`title`, `c`.`description` as `company`, `v`.`NAMA`, `r`.`CURRENCY` as `currency`, o.id_vendor, m.total_amount_base as value, o.status, c.ABBREVIATION
            FROM (
                SELECT o.id, o.po_no, o.msr_no, o.po_type, o.id_vendor, 0 as status
                FROM `t_purchase_order` `o`
                WHERE o.po_no NOT IN (SELECT po_no FROM t_approval_cpm) AND o.po_type = 20 AND o.issued = 1
            ) o
            JOIN t_msr m ON m.msr_no = o.msr_no
            JOIN m_company c ON c.ID_COMPANY = m.id_company
            JOIN m_vendor v ON v.ID = o.id_vendor
            JOIN m_currency r ON r.ID = m.id_currency
            JOIN t_msr_item t ON m.msr_no = t.msr_no
        ");
        return $res->result_array();
    }

    public function get_list_progress() {
        $res = $this->db->query("
            SELECT DISTINCT a.po_no, CASE
                WHEN a.po_type = 10 THEN 'PO'
                WHEN a.po_type = 20 THEN 'SO'
                WHEN a.po_type = 30 THEN 'Blanket PO'
            END as type, `m`.`title`, `c`.`description` as `company`, `v`.`NAMA`, `r`.`CURRENCY` as `currency`, `a`.`id_vendor`, m.total_amount_base as value, a.id, a.sequence, CASE
                WHEN a.sequence < 3 OR a.sequence = 99 THEN ur.DESCRIPTION
                WHEN a.user_roles = 3 THEN 'Subject Matter Support'
                WHEN a.user_roles = 2 THEN 'Subject Matter Expert'
                ELSE 'User'
            END as user_roles, a.extra_case, a.edit_content, a.phase_id, a.status_approve, a.create_date, f.phase as cur_phase, c.ABBREVIATION
            FROM (
                SELECT b.id, b.po_no, b.sequence as sequence, CASE
                        WHEN c.user_roles IS NULL THEN b.user_roles
                        ELSE c.user_roles
                    END as user_roles, CASE
                        WHEN c.status_approve = 2 THEN c.status_approve
                        ELSE b.status_approve
                    END as status_approve, b.extra_case, b.edit_content, b.phase_id, b.create_date, a.id_vendor, a.msr_no, a.po_type
                FROM (
                    SELECT MIN(a.sequence) as sequence, a.po_no, a.extra_case, a.phase_id, o.id_vendor, o.id as po_id, o.msr_no, o.po_type
                    FROM t_approval_cpm a
                    JOIN t_purchase_order o ON o.po_no = a.po_no
                    WHERE (status_approve = 0 OR status_approve = 2) AND o.po_type = 20 AND o.issued = 1
                    GROUP BY a.po_no, a.extra_case, a.phase_id, o.id_vendor, o.id, o.msr_no, o.po_type
                ) a
                JOIN t_approval_cpm b ON b.po_no = a.po_no AND b.extra_case = a.extra_case AND b.phase_id = a.phase_id AND b.sequence = a.sequence
                LEFT JOIN t_approval_cpm c ON c.po_no = a.po_no AND c.extra_case = a.extra_case AND c.phase_id = a.phase_id AND c.status_approve = 2
            ) a
            JOIN t_msr m ON m.msr_no = a.msr_no
            JOIN `m_company` `c` ON `c`.`ID_COMPANY` = `m`.`id_company`
            JOIN `m_vendor` `v` ON `v`.`ID` = `a`.`id_vendor`
            JOIN `m_currency` `r` ON `r`.`ID` = `m`.`id_currency`
            LEFT JOIN m_user_roles `ur` ON ur.ID_USER_ROLES = a.user_roles
            LEFT JOIN t_cpm_phase f ON f.id = a.phase_id
        ");
        return $res->result_array();
    }

    public function validate_weight($cw, $cpm_id, $cat = 0) {
        $res = false;
        if ($cat == 0) {
            $tmp = $this->db->distinct()
                            ->select('cat_weight, category_id')
                            ->from('t_cpm_detail')
                            ->where('cpm_id', $cpm_id)
                            ->get();
        } else {
            $tmp = $this->db->distinct()
                            ->select('cat_weight, category_id')
                            ->from('t_cpm_detail')
                            ->where('cpm_id', $cpm_id)
                            ->where('category_id != ', $cat)
                            ->get();
        }

        if ($tmp != false) {
            $sum = 0;
            foreach ($tmp->result() as $value) {
                $sum += $value->cat_weight;
            }
            if ($sum + $cw <= 100)
                $res = true;
        }
        return $res;
    }

    public function validate_kpi($kw, $cpm_id, $cat, $kpi = 0) {
        $res = false;
        if ($kpi == 0) {
            $tmp = $this->db->select('kpi_weight, id')
                            ->from('t_cpm_detail')
                            ->where('cpm_id', $cpm_id)
                            ->where('category_id', $cat)
                            ->get();
        } else {
            $tmp = $this->db->select('kpi_weight, id')
                            ->from('t_cpm_detail')
                            ->where('cpm_id', $cpm_id)
                            ->where('category_id', $cat)
                            ->where('id != ', $kpi)
                            ->get();
        }

        if ($tmp != false) {
            $sum = 0;
            foreach ($tmp->result() as $value) {
                $sum += $value->kpi_weight;
            }
            if ($sum + $kw <= 100)
                $res = true;
        }
        return $res;
    }

    public function get_plan($po, $pid) {
        if ($pid == 0) {
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
                            ->where(array('p.status' => 0, 'p.po_no' => $po, 'p.id' => $pid))
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

    public function get_dept($company) {
        $res = $this->db->select('ID_DEPARTMENT, DEPARTMENT_DESC')
                        ->from('m_departement')
                        ->where_in('ID_COMPANY', $company)
                        ->get();

        return $res->result();
    }

    public function get_user($dept) {
        $res=$this->db->select("ID_USER as id,USERNAME as logon,NAME as name")
                    ->from("m_user")
                    ->where("ID_DEPARTMENT", $dept)
                    // ->like("ROLES",','.$roles.',')
                    ->where("status =1")
                    ->get();

        if ($res->num_rows() != 0)
            return $res->result();
        else
            return false;
    }

    public function get_category()
    {
        $res=$this->db->select("id,category")
                    ->from("m_cpm_category")
                    ->where("status","1")
                    ->get();
        if ($res->num_rows() != 0)
            return $res->result();
        else
            return false;
    }

    public function get_kpi_cat($po, $vendor) {
        $res = $this->db->select('m.id, m.category')
                    ->from('m_cpm_category m')
                    ->join('t_cpm_detail d', 'm.id = d.category_id')
                    ->join('t_cpm c', 'd.cpm_id = c.id')
                    ->where(array('c.po_no' => $po, 'c.vendor_id' => $vendor))
                    ->group_by('m.id, m.category')
                    ->get();
        if ($res->num_rows() != 0)
            return $res->result();
        else
            return false;
    }

    public function get_user_appr($po, $ven) {
        $res = $this->db->distinct()
                        ->select('t.sequence as no, m.DEPARTMENT_DESC as dept, u.USERNAME as logon, u.NAME as name,
                            CASE
                                WHEN t.user_roles = 1 THEN "User"
                                WHEN t.user_roles = 2 THEN "Subject Matter Expert"
                                ELSE "Subject Matter Support"
                            END as roles', false)
                        ->from('t_approval_cpm_temp t')
                        ->join('m_user u','u.ID_USER = t.user_id','')
                        ->join('m_departement m','m.ID_DEPARTMENT = u.ID_DEPARTMENT','')
                        ->where('t.po_no', $po)
                        ->where('t.vendor_id', $ven)
                        ->order_by('no')
                        ->get();
        return $res->result_array();
    }

    public function check_seq($dt)
    {
        $res=$this->db->query("SELECT COUNT(sequence)+3 as sequence
                        FROM t_approval_cpm_temp
                        WHERE po_no='".$dt['po_no']."' AND vendor_id=".$dt['vendor_id']."");
        return $res->result_array();
    }

    public function set_approval($dt)
    {
        return $this->db->insert("t_approval_cpm_temp",$dt);
    }

    public function reset_approval($po, $vendor) {
        return $this->db->delete('t_approval_cpm_temp', array('po_no' => $po, 'vendor_id' => $vendor));
    }

    public function update_dt($tbl,$dt,$phase)
    {
        return $this->db->where('id',$phase)
                        ->update($tbl,$dt);
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

    public function get_email_dest($po, $vendor) {
        $qry = $this->db->query(
            "SELECT v.URL_BATAS_HARI as hari, v.NAMA, b.user_id as recipients, b.user_roles as rec_role, b.reject_step, b.email_approve, b.email_reject, n.OPEN_VALUE, n.CLOSE_VALUE, n.TITLE
            FROM (
                SELECT po_no, vendor_id, min(sequence) as sequence
                FROM t_approval_cpm
                WHERE po_no ='" . $po . "' AND vendor_id = " . $vendor . " AND status_approve = 0 AND extra_case = 0
                GROUP BY po_no, vendor_id
            ) a
            JOIN t_approval_cpm b ON b.sequence = a.sequence AND b.po_no = a.po_no AND b.vendor_id = a.vendor_id
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

    public function get_upload($po, $id = 0) {
        if ($id == 0) {
            $res = $this->db->select('t.id, t.type, t.seq, t.file_name, t.path, t.createdate, m.username, m.name')
                            ->from('t_cpm_upload t')
                            ->join('m_user m', 'm.ID_USER = t.createby')
                            ->where("t.po_no", $po)
                            ->get();
        } else {
            $res = $this->db->select('t.id, t.type, t.seq, t.file_name, t.path, t.createdate, m.username, m.name')
                            ->from('t_cpm_upload t')
                            ->join('m_user m', 'm.ID_USER = t.createby')
                            ->where(array('t.po_no' => $po, 't.id' => $id))
                            ->get();
        }
        return $res->result_array();
    }

    public function get_seq($dt)
    {
        $res=$this->db->select('count(id)+1 as counter')
                    ->from('t_cpm_upload')
                    ->where("po_no",$dt['po_no'])
                    ->get();
        if ($res->num_rows() != 0)
            return $res->result_array();
        else
            return false;
    }
}