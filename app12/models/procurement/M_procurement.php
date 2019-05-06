<?php

class M_procurement extends CI_Model {

    public function get_msr_inventory_type() {
        return $this->db->get('m_msr_inventory_type')
        ->result();
    }

    public function get_item_type() {
        return $this->db->where('status', 1)
        ->get('m_itemtype')
        ->result();
    }

    public function get_item_type_category($item_type = null) {
        if ($item_type) {
            $this->db->where('itemtype', $item_type);
        }
        return $this->db->where('status', 1)
        ->get('m_itemtype_category')->result();
    }

    public function get_costcenter($company) {
        $user = $this->auth();
        $company = explode(',', $user->COMPANY);
        $this->db->where_in('ID_COMPANY', $company);
        return $this->db->get('m_costcenter')
        ->result();
    }

    public function get_importation() {
        return $this->db->get('m_importation')
        ->result();
    }

    public function get_delivery_point() {
        return $this->db->where('STATUS', 1)
        ->get('m_deliverypoint')
        ->result();
    }

    public function auth() {
        $id_user = $this->session->userdata['ID_USER'];
        $user = $this->db->get('m_user')
        ->row();
        return $user;
    }

    public function get_reason($type = null) {
        if ($type) {
            $this->db->where('type', $type);
        }
        $result = $this->db->get('m_reason')
        ->result();
        return $result;
    }
}