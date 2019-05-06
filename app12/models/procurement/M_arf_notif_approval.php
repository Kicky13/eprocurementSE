<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_arf_notif_approval extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_list() {
        $roles = explode(',', substr($this->session->ROLES, 1, -1));
        $res = $this->db->select('a.doc_date, a.po_no, a.doc_no,
            CASE
                WHEN p.po_type = 10 THEN "Purchase Order"
                WHEN p.po_type = 20 THEN "Service Order"
                WHEN p.po_type = 30 THEN "Blanket Purchase Order"
                ELSE "Non"
            END as po_type, a.po_title, u.NAME as requestor, a.department, a.company, anb.sequence,m_company.ABBREVIATION abbr', false)
                        ->from('t_arf a')
                        ->join('t_purchase_order p', 'p.po_no = a.po_no')
                        ->join('t_msr m', 'm.msr_no = p.msr_no')
                        ->join('m_user u', 'u.ID_USER = m.create_by')
                        ->join('t_arf_notification n', 'n.po_no = a.po_no and n.doc_no = a.doc_no')
                        ->join('(SELECT MIN(sequence) as sequence, po_no, doc_id, extra_case
                                FROM t_approval_arf_notification
                                WHERE (status_approve = 0 OR status_approve = 2)
                                GROUP BY po_no, doc_id, extra_case) ana',
                                'ana.po_no = n.po_no and ana.doc_id = n.id',
                                '',
                                false)
                        ->join('t_approval_arf_notification anb', 'anb.po_no = ana.po_no and anb.doc_id = ana.doc_id and anb.sequence = ana.sequence')
                        ->join('m_company','m_company.ID_COMPANY = a.company_id')
                        ->group_start()
                            ->where('anb.user_id', '%')
                            ->where_in('anb.user_roles', $roles)
                        ->group_end()
                        ->or_group_start()
                            ->where('anb.user_id', $this->session->ID_USER)
                            ->where_in('anb.user_roles', $roles)
                        ->group_end()
                        ->where('anb.sequence != ', 1)
                        ->where('n.is_done', 0)
                        ->get();
        return $res->result_array();
    }

    public function get_header($po, $amd) {
        $res = $this->db->select('a.po_title as title, v.NAMA as vendor, a.company_id as id_comp, a.company as company, u.NAME as requestor, a.po_no, a.doc_no, a.estimated_value as total, a.tax_base as vat, a.total_base as total_vat, p.total_amount_base as po_val')
                        ->from('t_arf a')
                        ->join('t_purchase_order p', 'p.po_no = a.po_no')
                        ->join('t_msr m', 'm.msr_no = p.msr_no')
                        ->join('m_user u', 'u.ID_USER = m.create_by')
                        ->join('m_vendor v', 'v.ID = p.id_vendor')
                        ->where(array('a.po_no' => $po, 'a.doc_no' => $amd))
                        ->get();
        return $res->row();
    }

    public function create_main($po, $amd) {
        $res = $this->db->select('id, is_draft, estimated_value_new, response_date')
                            ->from('t_arf_notification')
                            ->where(array('po_no' => $po, 'doc_no' => $amd))
                            ->get();
        return $res->row();
    }

    public function get_revision($po, $amd) {
        $res = $this->db->select('r.type, r.value, r.remark, n.estimated_value_new, n.response_date')
                        ->from('t_arf_notification n')
                        ->join('t_arf_notification_detail_revision r', 'r.doc_id = n.id', 'left')
                        ->where(array('n.po_no' => $po, 'n.doc_no' => $amd))
                        ->get();
        return $res->result_array();
    }

    public function proc_revision($notif, $data) {
        $check = $this->db->select('id')
                            ->from('t_arf_notification_detail_revision')
                            ->where(array('doc_id' => $notif))
                            ->count_all_results();
        $res = false;
        if ($check == 0) {
            foreach ($data as $entry) {
                $entry['doc_id'] = $notif;
                $res = $this->db->insert('t_arf_notification_detail_revision', $entry);
            }
        } else {
            foreach ($data as $entry) {
                $res = $this->db->where(array('doc_id' => $notif, 'type' => $entry['type']))->update('t_arf_notification_detail_revision', $entry);
            }
        }
        return $res;
    }

    public function get_upload($po, $notif, $id = 0) {
        if ($id == 0) {
            $res = $this->db->select('t.id, t.file_name, t.file_path, t.file_type, t.create_date, m.username, m.name')
                            ->from('t_arf_notification_upload t')
                            ->join('m_user m', 'm.ID_USER = t.create_by')
                            ->where(array('t.po_no' => $po, 't.doc_id' => $notif))
                            ->get();
        } else {
            $res = $this->db->select('t.id, t.file_name, t.file_path, t.file_type, t.create_date, m.username, m.name')
                            ->from('t_arf_notification_upload t')
                            ->join('m_user m', 'm.ID_USER = t.create_by')
                            ->where(array('t.po_no' => $po, 't.doc_id' => $notif, 't.id' => $id))
                            ->get();
        }
        return $res->result_array();
    }

    public function get_item_ori($po) {
        $res = $this->db->select('t.ITEMTYPE_DESC as item_type, d.material_desc, d.qty, d.uom_desc as uom, m_material_uom.DESCRIPTION as uom_desc, d.is_modification, i.description as inv_type, d.costcenter_desc, d.id_accsub, d.accsub_desc, d.unitprice_base, d.total_price_base')
                        ->from('t_purchase_order_detail d')
                        ->join('m_material_uom', 'm_material_uom.MATERIAL_UOM = d.uom_desc')
                        ->join('t_purchase_order o', 'o.id = d.po_id')
                        ->join('m_msr_inventory_type i', 'i.id = d.id_msr_inv_type', 'left')
                        ->join('m_itemtype t', 't.ID_ITEMTYPE = d.id_itemtype')
                        ->where('o.po_no', $po)
                        ->get();
        return $res->result_array();
    }

    public function get_item_arf($po, $amd) {
        $res = $this->db->select('d.id, t.ITEMTYPE_DESC as item_type, d.material_desc, d.qty, d.uom, m_material_uom.DESCRIPTION as uom_desc, d.item_modification, d.inventory_type, d.costcenter, d.account_subsidiary, d.unit_price_base, d.total_price_base')
                        ->from('t_arf_detail d')
                        ->join('m_material_uom', 'm_material_uom.MATERIAL_UOM = d.uom')
                        ->join('t_arf a', 'a.id = d.doc_id')
                        ->join('m_itemtype t', 't.ID_ITEMTYPE = d.id_item_type')
                        ->where(array('a.po_no' => $po, 'a.doc_no' => $amd))
                        ->get();
        return $res->result_array();
    }

    public function get_item_proc($po, $amd) {
        $res = $this->db->select('s.id, t.ITEMTYPE_DESC as item_type, d.material_desc, s.item, s.qty1, s.uom1, s.qty2, s.uom2, s.item_modification, s.inv_type, i.description as inv_type_desc, s.costcenter_desc, s.id_accsub, s.accsub_desc, s.sop_type, uom1.DESCRIPTION as uom_desc_1, uom2.DESCRIPTION as uom_desc_2')
                        ->from('t_arf_sop s')
                        ->join('m_material_uom uom1', 'uom1.MATERIAL_UOM = s.uom1')
                        ->join('t_arf_detail d', 'd.id = s.arf_item_id')
                        ->join('t_arf_notification n', 'n.id = s.doc_id')
                        ->join('m_itemtype t', 't.ID_ITEMTYPE = s.id_itemtype')
                        ->join('m_msr_inventory_type i', 'i.id = s.inv_type', 'left')
                        ->join('m_material_uom uom2', 'uom2.MATERIAL_UOM = s.uom2', 'left')
                        ->where(array('n.po_no' => $po, 'n.doc_no' => $amd))
                        ->order_by('s.id')
                        ->get();
        return $res->result_array();
    }

    public function get_item_proc_single($id) {
        $res = $this->db->select('*')
                        ->from('t_arf_sop d')
                        ->where(array('d.id' => $id))
                        ->get();
        return $res->row();
    }

    public function get_approval($po, $notif) {
        $res = $this->db->select('r.DESCRIPTION as role_desc, u1.NAME as user_name, an.user_id, an.sequence, an.status_approve, an.description, an.note, u2.NAME as app_name, an.approve_by, an.update_date, an.user_roles')
                        ->from('t_approval_arf_notification an')
                        ->join('m_user u1', 'u1.ID_USER = an.user_id', 'left')
                        ->join('m_user u2', 'u2.ID_USER = an.approve_by', 'left')
                        ->join('m_user_roles r', 'r.ID_USER_ROLES = an.user_roles')
                        ->where(array('po_no' => $po, 'doc_id' => $notif))
                        ->order_by('an.sequence')
                        ->get();
        return $res->result_array();
    }

    public function send_approval($po, $notif, $seq, $data) {
        $check = $this->db->query(
            "SELECT b.user_id as recipients, b.user_roles as rec_role, b.sequence, b.reject_step
            FROM (
                SELECT po_no, doc_id, min(sequence) as sequence
                FROM t_approval_arf_notification
                WHERE po_no = '" . $po . "' AND doc_id = " . (int)$notif . " AND status_approve = 0 AND extra_case = 0
                GROUP BY po_no, doc_id
            ) a
            JOIN t_approval_arf_notification b ON b.po_no = a.po_no AND b.doc_id = a.doc_id AND b.sequence = a.sequence
            WHERE (`b`.`user_id` = '%' AND '" . $this->session->ROLES . "' LIKE CONCAT('%,', `b`.`user_roles`, ',%')) OR (`b`.`user_id` = " . $this->session->ID_USER . " AND '" . $this->session->ROLES . "' LIKE CONCAT('%,', `b`.`user_roles`, ',%'))")
            ->row();

        if ($check && $check->sequence == $seq) {
            if ($data['status_approve'] == 1) {
                $res = $this->db->where(array('status_approve' => 2, 'po_no' => $po, 'doc_id' => $notif))
                                ->update('t_approval_arf_notification', array('status_approve' => 0));
                $res = $this->db->where(array('sequence' => $seq, 'po_no' => $po, 'doc_id' => $notif))
                                ->update('t_approval_arf_notification', $data);
            } else if ($data['status_approve'] == 2) {
                $res = $this->db->where(array('sequence >= ' => ($seq - $check->reject_step), 'po_no' => $po, 'doc_id' => $notif))
                                ->update('t_approval_arf_notification', array('status_approve' => 0));
                $res = $this->db->where(array('sequence' => $seq, 'po_no' => $po, 'doc_id' => $notif))
                                ->update('t_approval_arf_notification', $data);
            } else {
                $res = false;
            }
        } else {
            $res = false;
        }
        return $res;
    }

    public function set_notif_complete($po, $notif) {
        $check = $this->db->select('id, status_approve')
                            ->from('t_approval_arf_notification')
                            ->where(array('po_no' => $po, 'doc_id' => $notif))
                            ->get()
                            ->result_array();
        if ($check) {
            $max = true;
            foreach ($check as $value) {
                if ($value['status_approve'] == 0 || $value['status_approve'] == 2) {
                    $max = false;
                    break;
                }
            }
            if ($max) {
                $this->db->where(array('id' => $notif, 'po_no' => $po))->update('t_arf_notification', array('is_done' => 1));
            }
        }
    }

    public function get_email_dest($po, $notif) {
        $qry = $this->db->query(
            "SELECT b.user_id as recipients, b.user_roles as rec_role, b.reject_step, b.email_approve, b.email_reject, n.OPEN_VALUE, n.CLOSE_VALUE, n.TITLE
            FROM (
                SELECT po_no, doc_id, min(sequence) as sequence
                FROM t_approval_arf_notification
                WHERE po_no = '" . $po . "' AND doc_id = " . (int)$notif . " AND status_approve = 0 AND extra_case = 0
                GROUP BY po_no, doc_id
            ) a
            JOIN t_approval_arf_notification b ON b.po_no = a.po_no AND b.doc_id = a.doc_id AND b.sequence = a.sequence
            JOIN m_notic n ON n.ID = b.email_approve");
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
}
?>
