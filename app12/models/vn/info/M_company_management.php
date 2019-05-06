<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_company_management extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function show_company_management($where = null) {
        if ($where != null) {
            $this->db->where($where);
        }
        $data = $this->db->from('m_vendor_directors')->where('STATUS', '1')->where('ID_VENDOR',$this->session->ID)->get();
        return $data->result();
    }
    
    public function add_company_management($data) {
        $data = $this->db->insert('m_vendor_directors', $data);
//        echo $this->db->last_query();exit;
        return $data;
    }
    
    public function update_company_management($id, $data){
        return $this->db->where('ID', $id)->update('m_vendor_directors', $data);
    }
    
    public function delete_company_management($data){
        return $this->db->where('ID')->update('m_vendor_directors', $data);
    }

    public function delete_data($id) {
        $data = array(
            "UPDATE_TIME"=>date("Y-m-d H:i:s"),            
            "STATUS" => "0",
        );
        $query = $this->db
                ->where('ID=', $id)
                ->update('m_vendor_directors',$data);
        if ($query)
            return true;
        else
            return $query;
    }
    
    public function show_vendor_shareholders($where = null) {
        if ($where != null) {
            $this->db->where($where);
        }
        $data = $this->db->from('m_vendor_shareholders')->where('STATUS', '1')->where('ID_VENDOR',$this->session->ID)->get();
        return $data->result();
    }
    
    public function add_vendor_shareholders($data) {
        $data = $this->db->insert('m_vendor_shareholders', $data);
//        echo $this->db->last_query();exit;
        return $data;
    }
    
    public function update_vendor_shareholders($id, $data){
        return $this->db->where('ID', $id)->update('m_vendor_shareholders', $data);
    }
    
    public function hapus_data($id) {
        $data = array(
            "UPDATE_TIME"=>date("Y-m-d H:i:s"),            
            "STATUS" => "0",
        );
        $query = $this->db
                ->where('ID=', $id)
                ->update('m_vendor_shareholders',$data);
        if ($query)
            return true;
        else
            return $query;
    }
    
    public function get_doc($id, $key = null, $sel, $table, $other = null) {
        $this->db->select($sel);
        $this->db->from($table);        
        $this->db->where('ID_VENDOR=', $id);
        if ($key != null)
            $this->db->where('ID=', $key);
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            return $query->result();
        } else
            return false;
    }
}