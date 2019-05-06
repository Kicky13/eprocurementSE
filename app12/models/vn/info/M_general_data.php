<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_general_data extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function cek_address($id) {
        $query = $this->db->select('KEYS')
                ->from('m_vendor_address')
                ->where('ID_VENDOR=', $id)
                ->order_by('KEYS DESC')
                ->limit(1)
                ->get();
        if ($query->num_rows() != 0)
            return $query->result();
        else
            return false;
    }

    public function cek_contact($id) {
        $query = $this->db->select('KEYS')
                ->from('m_vendor_contact')
                ->where('ID_VENDOR=', $id)
                ->order_by('KEYS DESC')
                ->limit(1)
                ->get();
        if ($query->num_rows() != 0)
            return $query->result();
        else
            return false;
    }

    public function add_data_info($data_info) {
        $query = $this->db->where('ID=', $this->session->ID)
                ->update('m_vendor', $data_info);
//        $this->db->insert('m_vendor', $data_info);
        if ($query)
            return true;
        else
            return false;
    }

    public function get_info_perusahaan(){
      $query = $this->db->select("*")->from("m_vendor")->where("ID", $this->session->ID)->get();
      return $query->result_array();
    }

    public function get_klasifikasi() {
        $data = $this->db->select("DESKRIPSI_IND,DESKRIPSI_ENG")
                ->from("m_supp_category")
                ->where("status=", 1)
                ->get()
                ->result();
        return $data;
    }

    public function add_data_kontak($data_kontak) {
        $key = $this->cek_contact($data_kontak['ID_VENDOR']);
        if ($key == false)
            $data_kontak['KEYS'] = 1;
        else
            $data_kontak['KEYS'] = $key[0]->KEYS + 1;
        $this->db->insert('m_vendor_contact', $data_kontak);
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }

    public function add_data_alamat($data_addr) {
        $key = $this->cek_address($data_addr['ID_VENDOR']);
        if ($key == false)
            $data_addr['KEYS'] = 1;
        else
            $data_addr['KEYS'] = $key[0]->KEYS + 1;
        $this->db->insert('m_vendor_address', $data_addr);
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }

    public function add_dataumum($data_umum) {
        $this->db->insert('m_vendor', $data_umum);
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }

    public function get_data($id) {
        $query = $this->db
                ->select("V.PREFIX,"
                        . "V.NAMA,"
                        . "V.CLASSIFICATION,"
                        . "V.CUALIFICATION,"
                        . "V.STATUS")
                ->from('m_vendor V')
                ->where('V.ID_VENDOR=', $id)
                ->get();
        if ($query->num_rows() != 0)
            return $query->result();
        else
            return false;
    }

    public function get_data_kontak($id, $key) {
        $query = $this->db
                ->select("V.NAMA,"
                        . "V.JABATAN,"
                        . "V.TELP,"
                        . "V.EXTENTION,"
                        . "V.HP,"
                        . "V.EMAIL")
                ->from('m_vendor_contact V')
                ->where('V.ID_VENDOR=', $id)
                ->where('V.KEYS=', $key)
                ->where('V.STATUS=', "1")
                ->get();
        if ($query->num_rows() != 0)
            return $query->result();
        else
            return false;
    }

    public function get_data_alamat($id, $key) {
        $query = $this->db
                ->select("BRANCH_TYPE,"
                        . "ADDRESS,"
                        . "COUNTRY,"
                        . "PROVINCE,"
                        . "CITY,"
                        . "POSTAL_CODE,"
                        . "TELP,"
                        . "HP,"
                        . "FAX,"
                        . "WEBSITE"
                )
                ->from('m_vendor_address')
                ->where('ID_VENDOR=', $id)
                ->where('KEYS=', $key)
                ->where('STATUS=', "1")
                ->get();
        if ($query->num_rows() != 0)
            return $query->result();
        else
            return false;
    }

    public function get_state($state) {
        $q = $this->db->select("id")
                ->from("m_loc_countries")
                ->where("sortname", $state)
                ->get();
        return $q->row();
    }

    public function get_province($prov,$sel=false) {
        $this->db->select("name,id");
                if($sel == true)
                    $this->db->distinct($sel);
        $q = $this->db->from("m_loc_states")
                ->where("country_id=", $prov)
                ->get();
        return $q->result();
    }

    public function get_dt_wparam($id)
    {
        $q1 = $this->db->select("id")
                ->from("m_loc_states")
                ->where("name=", $id)
                ->get();
        return $q1->row();
        // if ($q1->num_rows() != 0)
        //     return $q1->result_array();
        // else
        //     return false;
    }

    public function get_city($id,$sel=false) {

        $q = $this->db->select("name,id")
                ->from("m_loc_cities")
                ->where("state_id=",$id)
                ->get();
        return $q->result();
    }

    public function update_data_kontak($data_kontak) {
        $query = $this->db
                ->where('ID_VENDOR=', $data_kontak['ID_VENDOR'])
                ->where('KEYS=', $data_kontak['KEYS'])
                ->where('STATUS=', "1")
                ->update('m_vendor_contact', $data_kontak);
        if ($query)
            return true;
        else
            return false;
    }

    public function update_data_alamat($data) {
        $query = $this->db
                ->where('ID_VENDOR=', $data['ID_VENDOR'])
                ->where('KEYS=', $data['KEYS'])
                ->update('m_vendor_address', $data);
        if ($query)
            return true;
        else
            return false;
    }

    public function delete_data_address($key, $id) {
        $data = array(
            "UPDATE_TIME" => date("Y-m-d H:i:s"),
            "STATUS" => "0",
        );
        $query = $this->db
                ->where('ID_VENDOR=', $id)
                ->where('KEYS=', $key)
                ->update('m_vendor_address', $data);
        if ($query)
            return true;
        else
            return $query;
    }

    public function delete_data_contact($key, $id) {
        $data = array(
            "UPDATE_TIME" => date("Y-m-d H:i:s"),
            "STATUS" => "0",
        );
        $query = $this->db
                ->where('ID_VENDOR=', $id)
                ->where('KEYS=', $key)
                ->update('m_vendor_contact', $data);
        if ($query)
            return true;
        else
            return false;
    }

    public function data_finish($data) {
        $STATUS['STATUS'] = 5;
        $query = $this->db
                ->where('ID_VENDOR=', $data['ID_VENDOR'])
                ->update('m_vendor', $STATUS);
        $query = $this->db
                ->insert('ID_VENDOR=' . $data['ID_VENDOR'] . ',STATUS=5,CREATE_BY=1')
                ->update('m_vendor', $STATUS);
        if ($query)
            return true;
        else
            return $query;
    }

    public function menu() {
        $data = $this->db->from('m_menu_vendor')
                ->where('STATUS', '1')
                ->order_by('SORT ASC')
                ->get();
        return $data->result();
    }

    var $contact_column = array(
        'KEYS', 'NAMA', 'JABATAN', 'TELP','EXTENTION',
        'EMAIL', 'HP', 'ID_VENDOR'
    );

    public function show($key, $id) {
        $this->db->select('ID_VENDOR,KEYS,NAMA,JABATAN,TELP,EXTENTION,HP,EMAIL');
        $this->db->from('m_vendor_contact');
        $this->db->where('ID_VENDOR =', $id);
        $this->db->where('STATUS=', "1");
        if ($key['search'] !== '') {
            $this->db->like('NAMA', $key['search']);
            $this->db->group_start();
            $this->db->or_like('JABATAN', $key['search']);
            $this->db->or_like('EMAIL', $key['search']);
            $this->db->or_like('EXTENTION', $key['search']);
            $this->db->group_end();
            $this->db->like('ID_VENDOR', $id);

        }
        $this->db->order_by($this->contact_column[$key['ordCol']], $key['ordDir']);
        $data = $this->db->get();
        return $data->result();
    }

    var $addr_column = array(
        'KEYS', 'BRANCH_TYPE', 'ADDRESS', 'COUNTRY', 'PROVINCE', 'CITY', 'POSTAL_CODE', 'TELP', 'HP', 'FAX', 'WEBSITE'
    );

    public function show_address($key, $id) {
        $this->db->select('ID_VENDOR,KEYS,BRANCH_TYPE,ADDRESS,ADDRESS2,ADDRESS3,ADDRESS4,s.name as COUNTRY,PROVINCE,CITY,POSTAL_CODE,TELP,HP,FAX,WEBSITE,b.name');
        $this->db->from('m_vendor_address a');
        $this->db->join('m_loc_states b', 'a.PROVINCE=b.id');
        $this->db->join('m_loc_countries s', 's.sortname=a.COUNTRY');
        $this->db->where('ID_VENDOR =', $id);
        $this->db->where('STATUS=', "1");
        if ($key['search'] !== '') {
            $this->db->like('BRANCH_TYPE', $key['search']);
            $this->db->or_like('PROVINCE', $key['search']);
            $this->db->like('ID_VENDOR', $id);
            $this->db->or_like('CITY', $key['search']);
            $this->db->like('ID_VENDOR', $id);
        }
        $this->db->order_by($this->addr_column[$key['ordCol']], $key['ordDir']);
        $data = $this->db->get();
        return $data->result();
        // return echopre($this->db->last_query());
    }

    public function get_info_ktp(){
      $query = $this->db->select("*")->from("m_vendor_ktp")->where("id_vendor", $this->session->ID)->get();
      return $query->row();
    }

    public function add_info_ktp($data){
      $insert = $this->db->insert('m_vendor_ktp', $data);
      return $insert;
    }

    public function upd_info_ktp($data){
      $this->db->where('id', $data['id']);
      $update = $this->db->update('m_vendor_ktp', $data);
      return $update;
    }

}
