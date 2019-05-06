<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_financial_bank extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function check_financial_bank_data($dt) {
        $data = $this->db->from('m_vendor_balance_sheet')
                ->where("TYPE", $dt['TYPE'])
                ->where("YEAR", $dt['YEAR'])
                ->where("STATUS", "1")
                ->where('ID_VENDOR=', $this->session->ID)
                ->order_by('CREATE_TIME DESC')->get();
        return $data->result();
    }

    public function show_bank_data() {
        $data = $this->db->from('m_vendor_balance_sheet')->where("STATUS", "1")->where("ID_VENDOR", $this->session->ID)->order_by('CREATE_TIME DESC')->get();
        return $data->result();
    }

    public function cek_data($id, $tbl) {
        $query = $this->db->select('KEYS')
                ->from($tbl)
                ->where('ID_VENDOR=', $id)
                ->where('STATUS=', "1")
                ->order_by('KEYS DESC')
                ->limit(1)
                ->get();
        if ($query->num_rows() != 0)
            return $query->result();
        else
            return false;
    }

    public function add_financial_bank_data($data) {
        $key = $this->cek_data($data['ID_VENDOR'], 'm_vendor_balance_sheet');

        if ($key == false)
            $data['KEYS'] = 1;
        else
            $data['KEYS'] = $key[0]->KEYS + 1;

        $this->db->insert('m_vendor_balance_sheet', $data);
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }

    public function add_data_account($data) {
        $key = $this->cek_data($data['ID_VENDOR'], 'm_vendor_bank_account');
        if ($key == false)
            $data['KEYS'] = 1;
        else
            $data['KEYS'] = $key[0]->KEYS + 1;
        $data = $this->db->insert('m_vendor_bank_account', $data);
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }

    public function update_financial_bank_data($id, $key, $data) {
        return $this->db->where('ID_VENDOR', $id)->where('KEYS', $key)->update('m_vendor_balance_sheet', $data);
    }

    public function update_data_account($id, $key, $data) {
        return $this->db->where('ID_VENDOR', $id)->where("KEYS", $key)->update('m_vendor_bank_account', $data);
    }

    public function show_vendor_bank_account($where = null) {
        $data = $this->db->from('m_vendor_bank_account')->where("STATUS=", "1")->where("ID_VENDOR", $this->session->ID)->order_by('CREATE_TIME DESC')->get();
        return $data->result();
    }

    public function add_vendor_bank_account($data) {
        $data = $this->db->insert('m_vendor_bank_account', $data);
//        echo $this->db->last_query();exit;
        return $data;
    }

    public function update_vendor_bank_account($id, $data) {
        return $this->db->where('ID_VENDOR', $id)->update('m_vendor_bank_account', $data);
    }

    public function get_currency() {
        $query = $this->db->select("CURRENCY")
                ->from("m_currency ")
                ->where("STATUS=", 1)
                ->get();
        if ($query->num_rows() != 0)
            return $query->result();
        else
            return false;
    }

    public function get_report() {
        $query = $this->db->select("BALANCE_SHEET_TYPE")
                ->from("m_balance_sheet_type")
                ->where("STATUS=", 1)
                ->get();
        if ($query->num_rows() != 0)
            return $query->result();
        else
            return false;
    }

    public function get_doc($id, $key, $sel, $table) {
        $this->db->select($sel);
        $this->db->from($table);
        $this->db->where('ID_VENDOR=', $id);
        $this->db->where('KEYS=', $key);
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            return $query->result();
        } else
            return false;
    }

    public function delete_data($key, $tbl) {
        $data = array(
            "UPDATE_BY" => $this->session->ID,
            "UPDATE_TIME" => date("Y-m-d H:i:s"),
            "STATUS" => "0",
        );
        $query = $this->db
                ->where('ID_VENDOR=', $this->session->ID)
                ->where('KEYS=', $key)
                ->update($tbl, $data);
        if ($query)
            return true;
        else
            return $query;
    }

}
