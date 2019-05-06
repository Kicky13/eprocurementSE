<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_cor_finished extends CI_Model {

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

    public function get_upload($po) {
        $res = $this->db->select('t.id, t.type, t.file_name, t.path, t.createdate, m.username, m.name')
                        ->from('t_performance_cor_upload t')
                        ->join('m_user m', 'm.ID_USER = t.createby')
                        ->where('t.po_no', $po)
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

    public function get_list2() {
        $qry = $this->db->query("
            SELECT o.po_no, CASE
                WHEN o.po_type = 10 THEN 'PO'
                WHEN o.po_type = 20 THEN 'SO'
                WHEN o.po_type = 30 THEN 'Blanket PO'
            END as type, t2.t_cor_id as cor_id, 'Finished' as status, t2.vendor_id as supplier_id, t2.sequence, v.ID_VENDOR, t2.id, roles.DESCRIPTION as jabatan, m.title, d.total, d.score, d.type as cpm
            FROM (	    
                SELECT a.id, a.sequence, regis, COUNT(t.id) as total, cor_id
                FROM (
                  SELECT MAX(id) as id, MAX(sequence) as sequence, count(id) as regis, t_cor_id as cor_id
                  FROM t_approval_cor
                  WHERE status_approve = 1
                  GROUP BY t_cor_id
                ) a
                LEFT JOIN t_approval_cor t ON t.t_cor_id = a.cor_id AND t.status_approve != 1
                GROUP BY a.id, a.sequence, regis, a.cor_id
            ) t
            JOIN t_approval_cor t2 ON t2.id = t.id
            JOIN t_purchase_order o ON o.po_no = t2.po_no
            JOIN t_msr m ON m.msr_no = o.msr_no
            JOIN t_performance_cor d ON d.id = t.cor_id
            JOIN m_company c ON c.ID_COMPANY = m.id_company
            JOIN m_vendor v ON v.ID = d.vendor_id
            JOIN m_currency r ON r.ID = m.id_currency
            JOIN m_user_roles as roles ON roles.ID_USER_ROLES = t2.user_roles
            WHERE t.total = 0          
            ");
        return $qry->result_array();
    }
    
    public function get_data($id, $po) {
        $res = $this->db->select('t.sequence, t.description, t.note,
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
                END as status, r.ID_USER_ROLES as role_id, t.user_id as user_id, t.type as type,
                CASE
                    WHEN t.status_approve = 1 THEN t.updatedate
                    ELSE ""
                END as date', false)
                    ->from('t_approval_cor t')
                    ->join('m_user u', 'u.ID_USER = t.user_id', 'left')
                    ->join('m_user_roles r', 'r.ID_USER_ROLES = t.user_roles', 'left')
                    ->where(array('t.po_no' => $po, 't.vendor_id' => $id))
                    ->order_by('t.sequence')
                    ->get();
        return $res->result_array();
    }

    public function get_performance_q($id, $po) {
        $res = $this->db->select('t.cor_id as id, c.category, m.description, t.rating, m.weightage, m.target_answer, p.amount_comp, p.actual_deliv_date, p.check_partial, p.check_penalty, p.amount_penalty, p.input_contract, p.input_actual')
                        ->from('t_performance_cor p')
                        ->join('t_performance_cor_detail t', 't.id = p.id', 'left')
                        ->join('m_cor_performance m', 'm.id = t.cor_id')
                        ->join('m_cor_performance_category c', 'm.category_id = c.id and c.status = 1')
                        ->where('p.po_no', $po)
                        ->order_by('m.category_id, c.sequence, m.id')
                        ->get();
        return $res->result();
    }

    public function get_performance_q_cpm($id, $po) {
        $res = $this->db->select('p.po_no, d.id, d.category_id, d.cat_weight, d.specific_kpi, d.kpi_weight, d.scoring_method, d.target_score, d.target_weight, k.category, p.amount_comp, p.actual_deliv_date, p.check_partial, p.check_penalty, p.amount_penalty, p.input_contract, p.input_actual, pd.rating')
                        ->from('t_performance_cor p')
                        ->join('t_performance_cor_detail pd', 'pd.id = p.id', 'left')
                        ->join('t_cpm_detail d', 'd.id = pd.cor_id')
                        ->join('m_cpm_category k', 'k.id = d.category_id')
                        ->where('p.po_no', $po)
                        ->order_by('d.category_id, d.id')
                        ->get();
        return $res->result();
    }
}