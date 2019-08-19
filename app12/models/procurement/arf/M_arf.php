<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_arf extends M_base {

    protected $table = 't_arf';
    protected $fillable = array('doc_no', 'doc_date', 'po_no', 'po_title', 'po_date', 'company_id', 'company', 'department_id', 'department', 'currency_id', 'currency', 'currency_base_id', 'currency_base', 'amount_po', 'amount_po_base', 'amount_po_arf', 'amount_po_arf_base', 'amount_spending', 'amount_spending_base', 'amount_remaining', 'amount_remaining_base', 'delivery_date_po', 'amended_date', 'estimated_value', 'estimated_value_base', 'estimated_new_value', 'estimated_new_value_base', 'expected_commencement_date', 'review_bod', 'tax', 'tax_base', 'total', 'total_base', 'status');
    protected $authors = true;
    protected $timestamps = true;

    protected $procurement_head_id = 23;

    public function view_arf() {
        $this->db->select("t_arf.*, t_purchase_order.title, t_purchase_order.po_type, t_arf.created_by AS id_requestor, m_user.USERNAME as username_requestor, m_user.NAME AS requestor, t_msr.id_company, m_company.DESCRIPTION as company, m_user.NAME as requestor,m_company.ABBREVIATION as abbr, m_user.ID_DEPARTMENT as id_department, m_departement.DEPARTMENT_DESC as department,m_vendor.NAMA as vendor, m_warehouse.id_warehouse, approval.sequence, user_assignment.NAME user_assignment_name, t_arf_recommendation_preparation.arf_response_id, t_arf_notification.doc_no as arf_notification_doc_no,
            (case 
                when t_arf_acceptance.doc_no is not null then 'Acceptance'
                when issuance.id_ref is not null then 'Award Recommendation Issuance'
                when approval_arf_recom.id_ref is not null then 'Award Recommendation Approval'
                when t_arf_recommendation_preparation.doc_no is not null then 'AMD Recommendation Preparation'
                when t_arf_response.doc_no is not null then 'AMD Notification Response'
                when t_arf_notification.doc_no is not null then 'AMD Notification'
                when t_arf_assignment.user_id is not null then 'Assignment' 
                when approval_arf.sequence = 6 then 'ARF APPROVAL (BOD)'
                else approval_arf.description
                end) 
             as approval_status")
        ->join('t_purchase_order', 't_purchase_order.po_no = t_arf.po_no')
        ->join('t_msr', 't_msr.msr_no = t_purchase_order.msr_no')
        ->join('m_company', 'm_company.ID_COMPANY = t_msr.id_company')
        ->join('m_user', 'm_user.ID_USER = t_arf.created_by')
        ->join('m_departement', 'm_departement.ID_DEPARTMENT = m_user.ID_DEPARTMENT')
        ->join('m_vendor', 'm_vendor.ID = t_purchase_order.id_vendor')
        ->join('m_warehouse', 'm_warehouse.id_company = m_company.id_company')
        ->join('t_arf_assignment', 't_arf_assignment.doc_id = t_arf.id', 'left')
        ->join('m_user user_assignment', 'user_assignment.ID_USER = t_arf_assignment.user_id', 'left')
        ->join('t_arf_notification', 't_arf_notification.doc_no = t_arf.doc_no', 'left')
        ->join('t_arf_response', 't_arf_response.doc_no = t_arf.doc_no', 'left')
        ->join('t_arf_recommendation_preparation', 't_arf_recommendation_preparation.doc_no = t_arf.doc_no', 'left')
        ->join('(select id_ref from  t_approval_arf_recom where sequence in (1,2,3,4,5) group by id_ref) approval_arf_recom', 'approval_arf_recom.id_ref = t_arf_response.id', 'left')
        ->join('(select id_ref from  t_approval_arf_recom where sequence = 8 and status = 1 group by id_ref) issuance', 'issuance.id_ref = t_arf_response.id', 'left')
        ->join('t_arf_acceptance', 't_arf_acceptance.doc_no = t_arf.doc_no', 'left')
        ->join('(
            SELECT id_ref,
            MIN(sequence) AS sequence
            FROM t_approval_arf
            WHERE status = 0 OR status = 2
            GROUP BY id_ref
        ) approval', 'approval.id_ref = t_arf.id', 'left')
        ->join('(
            SELECT
                id_ref,
                sequence,
                GROUP_CONCAT(t_approval_arf.description SEPARATOR \', \') as description
            FROM t_approval_arf
            GROUP BY id_ref, sequence
        ) approval_arf', 'approval_arf.id_ref = approval.id_ref AND approval_arf.sequence = approval.sequence', 'left');
    }

    public function view_approval() {
        $this->db->select('t_arf.*, t_approval_arf.edit_content, t_purchase_order.title, t_purchase_order.po_type, t_arf.created_by AS id_requestor, m_user.NAME AS requestor, t_msr.id_company, m_company.DESCRIPTION as company, m_company.ABBREVIATION as abbr, m_user.NAME as requestor, m_user.ID_DEPARTMENT as id_department, m_departement.DEPARTMENT_DESC as department,m_vendor.NAMA as vendor')
        ->join('(
            SELECT id_ref,
            MIN(sequence) AS sequence
            FROM t_approval_arf
            WHERE status = 0 OR status = 2
            GROUP BY id_ref
        ) approval', 'approval.id_ref = t_arf.id')
        ->join('t_approval_arf', 't_approval_arf.id_ref = approval.id_ref AND t_approval_arf.sequence = approval.sequence')
        ->join('t_purchase_order', 't_purchase_order.po_no = t_arf.po_no')
        ->join('t_msr', 't_msr.msr_no = t_purchase_order.msr_no')
        ->join('m_company', 'm_company.ID_COMPANY = t_msr.id_company')
        ->join('m_user', 'm_user.ID_USER = t_arf.created_by')
        ->join('m_departement', 'm_departement.ID_DEPARTMENT = m_user.ID_DEPARTMENT')
        ->join('m_vendor', 'm_vendor.ID = t_purchase_order.id_vendor');
    }

    public function view_arf_status() {
        $this->db->select('t_arf.*,
            (CASE
                WHEN (SELECT COUNT(1) FROM t_approval_arf WHERE id_ref = t_arf.id AND (status = 0 OR status = 2)) = 0 AND t_arf.status=\'submitted\' THEN \'completed\'
                WHEN (SELECT COUNT(1) FROM t_approval_arf WHERE id_ref = t_arf.id AND status = 2) > 0 THEN \'rejected\'
                ELSE
                    CASE
                        WHEN t_arf.status = \'submitted\' THEN \'process\'
                        ELSE t_arf.status
                    END
            END) arf_status
        ');
    }

    public function scope_auth() {
        $this->db->where('t_arf.created_by', $this->session->userdata('ID_USER'));
    }

    public function scope_draft() {
        $this->db->where('t_arf.status', 'draft');
    }

    public function scope_approval() {
        $this->load->model('m_base_approval');
        $this->load->model('procurement/arf/m_arf_approval');
        $company = $this->session->userdata('COMPANY');
        $company = trim($company, ',');
        $company = explode(',', $company);
        $user_roles = $this->session->userdata('ROLES');
        $user_roles = trim($user_roles, ',');
        $user_roles = explode(',', $user_roles);
        $this->db->where('approval.sequence > ', 1)
        ->where_in('t_approval_arf.id_user_role', $user_roles)
        ->where('t_approval_arf.id_user_role <> ', $this->m_arf_approval->scm_performance_support_id)
        ->where($this->session->userdata('ID_USER') .' LIKE t_approval_arf.id_user and t_approval_arf.status in (0,2)')
        ->where_in('t_msr.id_company', $company)
        ->where('t_arf.status', 'submitted');
    }

    public function scope_verification() {
        $this->load->model('m_base_approval');
        $this->load->model('procurement/arf/m_arf_approval');
        $user_roles = $this->session->userdata('ROLES');
        $user_roles = trim($user_roles, ',');
        $user_roles = explode(',', $user_roles);
        $this->db->where_in($this->m_arf_approval->scm_performance_support_id, $user_roles)
        ->where($this->session->userdata('ID_USER') .' LIKE t_approval_arf.id_user')
        ->where('t_arf.status', 'submitted')
        ->where('(SELECT COUNT(1) FROM t_approval_arf a WHERE a.id_ref = t_arf.id
            AND (status = 0 OR status = 2) AND sequence < (SELECT MAX(sequence) FROM t_approval_arf b WHERE b.id_ref = t_arf.id)
        ) = 0');
    }

    public function scope_assignment() {
        $user_roles = $this->session->userdata('ROLES');
        $user_roles = trim($user_roles, ',');
        $user_roles = explode(',', $user_roles);

        $this->db->where('(SELECT COUNT(1) FROM t_approval_arf WHERE id_ref = t_arf.id AND (status = 0 OR status = 2)) = 0')
        ->where_in($this->procurement_head_id, $user_roles)
        ->where('NOT EXISTS (
            SELECT doc_id FROM t_arf_assignment
            WHERE doc_id = t_arf.id
        )')
        ->where('t_arf.status', 'submitted');
    }

    public function scope_on_creator() {
        $this->db->where('(SELECT status FROM t_approval_arf WHERE id_ref = t_arf.id AND status = 0 AND sequence = 1) = 0', null, false)
        ->where('t_arf.status', 'submitted');
    }


    public function enum_status() {
        return array(
            'draft' => 'Draft',
            'submitted' => 'Submitted'
        );
    }

    public function generate_no($po_no) {
        $no_columns = 'doc_no';
        $format = $po_no.'-AMD:2';
        $parse = explode(':', $format);
        $prefix = str_replace(array('{y}', '{Y}', '{m}', '{d}'), array(date('y'), date('Y'), date('m'), date('d')), $parse[0]);
        $digit = str_repeat('0', $parse[1]);
        $this->db->where('left('.$no_columns.', '.(strlen($prefix)).') = ', $prefix);
        $last_id =  $this->db->select_max($no_columns)
        ->get($this->table)->row()->{$no_columns};
        if ($last_id) {
            $counter = substr($last_id, -strlen($digit)) + 1;
            return $prefix.substr($digit.$counter, -strlen($digit));
        } else {
            return $prefix.substr($digit.'1', -strlen($digit));
        }
    }
    public function arf_issued()
    {
        return $this->db->query("SELECT t_arf.id, t_arf.po_no, t_arf.doc_no, t_arf_recommendation_preparation.arf_response_id FROM t_arf LEFT JOIN t_arf_response on t_arf_response.doc_no = t_arf.doc_no LEFT JOIN t_arf_recommendation_preparation on t_arf_recommendation_preparation.arf_response_id = t_arf_response.id LEFT JOIN t_approval_arf_recom on t_approval_arf_recom.id_ref = t_arf_response.id WHERE t_approval_arf_recom.sequence = 8 and t_approval_arf_recom.status = 1");
    }
    public function scope_reject() {
        $this->db->where('`t_arf`.`id` in (select `id_ref` from `t_approval_arf` where status = 2)', null, false);
    }
}