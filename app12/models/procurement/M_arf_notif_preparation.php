<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_arf_notif_preparation extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_list_prepare() {
        $res = $this->db->select('a.id, a.doc_date, a.po_no, a.doc_no,
            CASE
                WHEN p.po_type = 10 THEN "Purchase Order"
                WHEN p.po_type = 20 THEN "Service Order"
                WHEN p.po_type = 30 THEN "Blanket Purchase Order"
                ELSE "Non"
            END as po_type, a.po_title, u.NAME as requestor, a.department, a.company,m_company.ABBREVIATION abbr,
            CASE
                WHEN n.id IS NOT NULL THEN 1
                ELSE 0
            END as status', false)
                        ->from('t_arf a')
                        ->join('t_arf_assignment as', 'as.doc_id = a.id and as.po_no = a.po_no')
                        ->join('t_purchase_order p', 'p.po_no = a.po_no')
                        ->join('t_msr m', 'm.msr_no = p.msr_no')
                        ->join('m_user u', 'u.ID_USER = m.create_by')
                        ->join('t_arf_notification n', 'n.po_no = a.po_no and n.doc_no = a.doc_no', 'left')
                        ->join('t_approval_arf_notification an', 'an.po_no = n.po_no and an.doc_id = n.id and an.sequence = 1', 'left')
                        ->join('m_company','m_company.ID_COMPANY = a.company_id', 'left')
                        ->where(array('an.id' => null, 'as.user_id' => $this->session->ID_USER))
                        ->order_by('doc_date', 'DESC')
                        ->get();
        return $res->result_array();
    }

    public function get_list_progress() {
        $res = $this->db->select('a.doc_date, a.po_no, a.doc_no,
            CASE
                WHEN p.po_type = 10 THEN "Purchase Order"
                WHEN p.po_type = 20 THEN "Service Order"
                WHEN p.po_type = 30 THEN "Blanket Purchase Order"
                ELSE "Non"
            END as po_type, a.po_title, u.NAME as requestor, a.department, a.company, an.sequence, r.DESCRIPTION as user_roles, an.status_approve, an.update_date, as.user_id as assignee', false)
                        ->from('t_arf a')
                        ->join('t_arf_assignment as', 'as.doc_id = a.id and as.po_no = a.po_no')
                        ->join('t_purchase_order p', 'p.po_no = a.po_no')
                        ->join('t_msr m', 'm.msr_no = p.msr_no')
                        ->join('m_user u', 'u.ID_USER = m.create_by')
                        ->join('t_arf_notification n', 'n.po_no = a.po_no and n.doc_no = a.doc_no')
                        ->join('(
                    SELECT b.id, b.po_no, b.sequence as sequence, CASE
                        WHEN c.user_roles IS NULL THEN b.user_roles
                        ELSE c.user_roles
                    END as user_roles, CASE
                        WHEN c.status_approve IS NULL THEN b.status_approve
                        ELSE c.status_approve
                    END as status_approve, CASE
                        WHEN c.update_date IS NULL THEN b.update_date
                        ELSE c.update_date
                    END as update_date, b.create_date, b.extra_case, b.edit_content, a.doc_id
                FROM (
                    SELECT MIN(a.sequence) as sequence, a.po_no, a.doc_id
                    FROM t_approval_arf_notification a
                    WHERE status_approve = 0 OR status_approve = 2
                    GROUP BY a.po_no, a.doc_id
                ) a
                JOIN t_approval_arf_notification b ON b.po_no = a.po_no AND b.doc_id = a.doc_id AND b.sequence = a.sequence
                LEFT JOIN t_approval_arf_notification c ON c.po_no = a.po_no AND b.doc_id = a.doc_id AND c.status_approve = 2) an', 'an.po_no = n.po_no and an.doc_id = n.id', '', false)
                        ->join('m_user_roles r', 'r.ID_USER_ROLES = an.user_roles', 'left')
                        ->get();
        return $res->result_array();
    }

    public function get_header($po, $amd) {
        $res = $this->db->select('a.po_title as title, v.NAMA as vendor, a.company_id as id_comp, a.company as company, u.NAME as requestor, a.po_no, a.doc_no, a.currency, a.currency_base, a.estimated_value as total, a.estimated_value_base as total_base, a.tax as vat, a.tax_base as vat_base, a.total as total_vat, a.total_base as total_vat_base, p.total_amount as po_val, p.total_amount_base as po_val_base')
                        ->from('t_arf a')
                        ->join('t_purchase_order p', 'p.po_no = a.po_no')
                        ->join('t_msr m', 'm.msr_no = p.msr_no')
                        ->join('m_user u', 'u.ID_USER = m.create_by')
                        ->join('m_vendor v', 'v.ID = p.id_vendor')
                        ->where(array('a.po_no' => $po, 'a.doc_no' => $amd))
                        ->get();
        return $res->row();
    }

    public function create_main($id) {
        $res = $this->db->select('a.doc_no, a.po_no, as.user_id')
                            ->from('t_arf a')
                            ->join('t_arf_assignment as', 'as.doc_id = a.id')
                            ->join('t_arf_notification n', 'n.doc_no = a.doc_no and n.po_no = a.po_no', 'left')
                            ->where(array('a.id' => $id, 'n.id' => null, 'as.user_id' => $this->session->ID_USER))
                            ->get()
                            ->row();
        if ($res) {
            $doc_no = $res->doc_no;
            $po_no = $res->po_no;
            $dt = array(
                    'doc_no' => $doc_no,
                    'dated' => date('Y-m-d'),
                    'po_no' => $po_no,
                    'is_draft' => 0,
                    'is_done' => 0,
                    'created_by' => $this->session->ID_USER,
                    'created_date' => date('Y-m-d H:i:s'),
                );
            $res = $this->db->insert('t_arf_notification', $dt);
            if ($res) {
                $res = new stdClass();
                $res->id = $this->db->insert_id();
                $res->doc_no = $doc_no;
                $res->po_no = $po_no;
                $res->is_draft = 0;
                $res->estimated_value_new = null;
                $res->response_date = null;
            }
        }
        return $res;
    }

    public function get_main($po, $amd) {
        $res = $this->db->select('id, is_draft, estimated_value_new, response_date')
                            ->from('t_arf_notification')
                            ->where(array('po_no' => $po, 'doc_no' => $amd))
                            ->get()
                            ->row();
        return $res;
    }

    public function proc_main($po, $amd, $data) {
        $res = $this->db->where(array('po_no' => $po, 'doc_no' => $amd))
                        ->update('t_arf_notification', $data);
        return $res;
    }

    public function get_revision_base($po, $amd) {
        $res = $this->db->select('r.type, r.value, r.remark, n.estimated_value_new, n.response_date')
                        ->from('t_arf a')
                        ->join('t_arf_notification n', 'n.po_no = a.po_no AND n.doc_no = a.doc_no')
                        ->join('t_arf_detail_revision r', 'r.doc_id = a.id', 'left')
                        ->where(array('a.po_no' => $po, 'a.doc_no' => $amd))
                        ->get();
        return $res->result_array();
    }

    public function get_revision_notif($po, $amd) {
        $res = $this->db->select('r.type, r.value, r.remark, n.estimated_value_new, n.response_date')
                        ->from('t_arf_notification n')
                        ->join('t_arf_notification_detail_revision r', 'r.doc_id = n.id', 'left')
                        ->where(array('n.po_no' => $po, 'n.doc_no' => $amd))
                        ->get();
        return $res->result_array();
    }

    public function proc_revision($notif, $data) {
        $this->db->where('doc_id', $notif)
        ->delete('t_arf_notification_detail_revision');
        foreach ($data as $entry) {
            if ($entry['value']) {
                $entry['doc_id'] = $notif;
                $res = $this->db->insert('t_arf_notification_detail_revision', $entry);
            }
        }
        return true;
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

    public function add_data_file($dt) {
        $res = $this->db->insert('t_arf_notification_upload', $dt);
        return $res;
    }

    public function delete_upload($id) {
        return $this->db->where('id', $id)
                        ->delete('t_arf_notification_upload');
    }

    public function get_item_ori($po) {
        $res = $this->db->select('t.ITEMTYPE_DESC as item_type, d.material_desc, d.qty, d.uom_desc as uom, m_material_uom.DESCRIPTION as uom_desc, d.is_modification, i.description as inv_type_desc, d.costcenter_desc,  d.id_accsub, d.accsub_desc, d.unitprice_base, d.total_price_base')
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
        $res = $this->db->select('d.id, t.ITEMTYPE_DESC as item_type, d.material_desc, d.qty, d.uom, m_material_uom.DESCRIPTION as uom_desc, d.item_modification, i.description as inv_type_desc, d.costcenter, d.id_account_subsidiary, d.account_subsidiary, d.unit_price_base, d.total_price_base')
                        ->from('t_arf_detail d')
                        ->join('m_material_uom', 'm_material_uom.MATERIAL_UOM = d.uom')
                        ->join('t_arf a', 'a.id = d.doc_id')
                        ->join('m_msr_inventory_type i', 'i.id = d.id_inventory_type', 'left')
                        ->join('m_itemtype t', 't.ID_ITEMTYPE = d.id_item_type')
                        ->where(array('a.po_no' => $po, 'a.doc_no' => $amd))
                        ->get();
        return $res->result_array();
    }

    public function get_item_proc($po, $amd) {
        // $res = $this->db->select('s.id, t.ITEMTYPE_DESC as item_type, d.material_desc, s.item, s.qty1, s.uom1, s.qty2, s.uom2, s.item_modification, i.description as inv_type_desc, s.costcenter_desc, s.accsub_desc, s.sop_type')
        $res = $this->db->select('s.*, uom1.DESCRIPTION as uom_desc_1, uom2.DESCRIPTION as uom_desc_2, t.ITEMTYPE_DESC as item_type_desc, d.material_desc, i.description as inv_type_desc')
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
        $res = $this->db->select('r.DESCRIPTION as role_desc, u1.NAME as user_name, an.user_id, an.sequence, an.status_approve, an.description, an.note, u2.NAME as app_name, an.approve_by, an.update_date')
                        ->from('t_approval_arf_notification an')
                        ->join('m_user u1', 'u1.ID_USER = an.user_id', 'left')
                        ->join('m_user u2', 'u2.ID_USER = an.approve_by', 'left')
                        ->join('m_user_roles r', 'r.ID_USER_ROLES = an.user_roles')
                        ->where(array('po_no' => $po, 'doc_id' => $notif))
                        ->order_by('an.sequence')
                        ->get();
        return $res->result_array();
    }

    public function sop_check($notif, $id) {
        $res = $this->db->select('id, doc_id, sop_type')->from('t_arf_sop')->where(array('id !=' => $id, 'doc_id' => $notif))->get();
        return $res->result_array();
    }

    public function sop_store($dt, $id) {
        if ($id == 0)
            $res = $this->db->insert('t_arf_sop', $dt);
        else
            $res = $this->db->where('id', $id)->update('t_arf_sop', $dt);
        return $res;
    }

    public function arf_item_copy($po, $amd, $notif, $id) {
        $res = false;
        $arf = $this->db->select('d.*, m_material_uom.DESCRIPTION as uom_desc, t.ITEMTYPE_DESC as item_type_desc, i.description as inv_type_desc')
                        ->from('t_arf_detail d')
                        ->join('m_material_uom', 'm_material_uom.MATERIAL_UOM = d.uom')
                        ->join('m_msr_inventory_type i', 'i.id = d.inventory_type', 'left')
                        ->join('m_itemtype t', 't.ID_ITEMTYPE = d.id_item_type')
                        ->where('d.id', $id)
                        ->get()
                        ->row();

        if ($arf) {

            if ($arf->id_item_type_category == 'SEMIC') {
                $mat = $this->db->select('m_material.*, category.ID as ID_CATEGORY, category.MATERIAL_GROUP as GROUP_CATEGORY, category.DESCRIPTION as CATEGORY, clasification.ID as ID_CLASSIFICATION, clasification.MATERIAL_GROUP as GROUP_CLASSIFICATION, clasification.DESCRIPTION as CLASSIFICATION')
                ->where('MATERIAL_CODE', $arf->semic_no)
                ->join('m_material_group category', 'category.TYPE = \'GOODS\' AND CAST(LEFT(MATERIAL_CODE, 2) AS SIGNED) = category.MATERIAL_GROUP')
                ->join('m_material_group clasification', 'clasification.TYPE = \'GOODS\' AND clasification.MATERIAL_GROUP = category.PARENT')
                ->get('m_material')
                ->row();
            } else {
                if ($arf->id_item_type_category == 'MATGROUP') {
                    $type = 'GOODS';
                } elseif ($arf->id_item_type_category == 'WORKS') {
                    $type = 'SERVICE';
                } else {
                    $type = $arf->id_item_type_category;
                }
                $mat = $this->db->select('category.ID as MATERIAL, category.ID as ID_CATEGORY, category.MATERIAL_GROUP as GROUP_CATEGORY, category.DESCRIPTION as CATEGORY, clasification.ID as ID_CLASSIFICATION, clasification.MATERIAL_GROUP as GROUP_CLASSIFICATION, clasification.DESCRIPTION as CLASSIFICATION')
                ->join('m_material_group clasification', 'clasification.TYPE = \''.$type.'\' AND clasification.MATERIAL_GROUP = category.PARENT')
                ->where('category.TYPE', $type)
                ->WHERE('category.MATERIAL_GROUP =  SUBSTRING_INDEX(SUBSTRING_INDEX(\''.$arf->semic_no.'\',\'.\', 2), \'.\', -1)')
                ->get('m_material_group category')
                ->row();
            }

            $res = array(
                'modal_sop_notif' => $notif,
                'modal_sop_id' => 0,
                'modal_sop_item_name' => $id,
                'modal_sop_item_name_desc' => $arf->material_desc,
                'modal_sop_subcat' => $mat->MATERIAL,
                'modal_sop_desc' => $arf->material_desc,
                'modal_sop_desc_val' => $arf->semic_no,
                'modal_sop_item_type' => $arf->id_item_type,
                'modal_sop_item_type_desc' => $arf->item_type_desc,
                'modal_sop_cat' => $arf->id_item_type_category,
                'modal_sop_group_value' => $mat->GROUP_CLASSIFICATION,
                'modal_sop_group_name' => $mat->CLASSIFICATION,
                'modal_sop_subgroup_value' => $mat->GROUP_CATEGORY,
                'modal_sop_subgroup_name' => $mat->CATEGORY,
                'modal_sop_inv_type' => $arf->id_inventory_type,
                'modal_sop_inv_type_desc' => $arf->inventory_type,
                'modal_sop_item_mod' => $arf->item_modification,
                'modal_sop_cost_center' => $arf->id_costcenter,
                'modal_sop_cost_center_name' => $arf->costcenter,
                'modal_sop_sub_acc' => $arf->id_account_subsidiary,
                'modal_sop_sub_acc_name' => $arf->account_subsidiary,
                'modal_sop_import' => $arf->id_importation,
                'modal_sop_deliv' => $arf->id_delivery_point,
                'modal_sop_deliv_name' => $arf->delivery_point,
                'modal_sop_qty_type' => 1,
                'modal_sop_qty_1' => $arf->qty,
                'modal_sop_uom_1' => $arf->uom,
                'modal_sop_uom_desc_1' => $arf->uom_desc,
                'modal_sop_qty_2' => 0,
                'modal_sop_uom_2' => '',
                'modal_sop_uom_desc_2' => '',
                'status' => 1
            );
        }
        return $res;
    }

    public function sop_del($id) {
        $res = $this->db->where(array('id' => $id))->delete('t_arf_sop');
        return $res;
    }

    public function create_approval($po, $notif) {
        $res = false;
        $app = $this->db->select('*')
                        ->from('m_approval_rule')
                        ->where(array('module' => 14, 'status' => 1))
                        ->order_by('sequence')
                        ->get()
                        ->result_array();
        if ($app) {
            foreach ($app as $key => $value) {
                $data = array(
                            'po_no' => $po,
                            'doc_id' => $notif,
                            'user_roles' => $value['user_roles'],
                            'user_id' => ($value['sequence'] == 1 ? $this->session->ID_USER : '%'),
                            'type' => $value['type'],
                            'sequence' => $value['sequence'],
                            'status_approve' => ($value['sequence'] == 1 ? 1 : 0),
                            'description' => $value['description'],
                            'reject_step' => $value['reject_step'],
                            'email_approve' => $value['email_approve'],
                            'email_reject' => $value['email_reject'],
                            'edit_content' => $value['edit_content'],
                            'extra_case' => $value['extra_case'],
                            'note' => ($value['sequence'] == 1 ? 'Prepared' : null),
                            'approve_by' => ($value['sequence'] == 1 ? $this->session->ID_USER : null),
                            'update_date' => ($value['sequence'] == 1 ? date('Y-m-d H:i:s') : null),
                            'create_date' => date('Y-m-d H:i:s')
                        );
                $res = $this->db->insert('t_approval_arf_notification', $data);
                if ($res == false)
                    break;
            }
        }
        return $res;
    }

    public function resub_approval($po, $notif, $data) {
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

        if ($check && $check->sequence == 1) {
            $res = $this->db->where(array('status_approve' => 2, 'po_no' => $po, 'doc_id' => $notif))
                            ->update('t_approval_arf_notification', array('status_approve' => 0));
            $res = $this->db->where(array('sequence' => 1, 'po_no' => $po, 'doc_id' => $notif))
                            ->update('t_approval_arf_notification', $data);
        } else {
            $res = false;
        }
        return $res;
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
