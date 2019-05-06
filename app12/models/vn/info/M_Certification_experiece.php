<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_certification_experiece extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }


    public function get_currency()
    {
      # code...
    $data=$this->db->from('m_currency')->order_by('CREATE_TIME DESC')->get();
    return $data->result();
    }

    public function get_doc($id, $key = null, $sel, $table, $other = null) {
        $this->db->select($sel);
        $this->db->from($table);
        $this->db->where('ID_VENDOR=', $id);
        if ($key != null)
            $this->db->where('KEY=', $key);
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            return $query->result();
        } else
            return false;
    }

    public function get_certificate()
    {
      # code...
      $data=$this->db->from('m_vendor_legal_other')
            ->where('CATEGORY','CERTIFICATION')
            ->where('STATUS',1)
            ->where("ID_VENDOR",$this->session->ID)
            ->order_by('CREATE_TIME DESC')
            ->get();
      return $data->result();
    }
    public function get_cert()
    {
      # code...
      $data=$this->db->from('m_legal_other_type')
            ->where('CATEGORY','CERTIFICATION')
            ->where('STATUS',1)
            ->order_by('CREATE_TIME ASC')
            ->get();
      return $data->result();
    }


    public function show_experience($where = null) {
        if ($where != null) {
            $this->db->where($where);
        }
        $data = $this->db->from('m_vendor_experience')
                         ->where('ID_VENDOR',$this->session->ID)
                         ->where('STATUS',1)
                         ->order_by('CREATE_TIME DESC')->get();
        return $data->result();
    }

    public function add_certification_experience($data) {
        $data = $this->db->insert('m_vendor_experience', $data);
        return $data;
    }

    public function add_data_certification($data)
    {
      # code...
      $data = $this->db->insert('m_vendor_legal_other', $data);
      return $data;
    }


    public function add_exp($data)
    {
      # code...
      $data = $this->db->insert('m_vendor_experience', $data);
      return $data;
    }

    public function update_exp($id, $data){
        return $this->db->where('ID', $id)->update('m_vendor_experience', $data);
    }
    public function update_cer($id, $data){
        return $this->db->where('ID', $id)->update('m_vendor_legal_other', $data);
    }
    public function show_experience_experience($where = null) {
        if ($where != null) {
            $this->db->where($where);
        }
        $data = $this->db->from('m_vendor_experience')
                         ->where('ID_VENDOR',$this->session->ID)
                         ->where('STATUS',"1")
                         ->order_by('CREATE_TIME DESC')->get();
        return $data->result();
    }

    public function m_d_exp($id,$vend)
    {
      # code...
      $data=array(
            "STATUS"=>"0",
            "UPDATE_BY"=>$vend,
            "UPDATE_TIME"=>date("Y-m-d H:i:s")
        );
        $query = $this->db->where("ID=", $id)
                ->update("m_vendor_experience",$data);
        if ($query)
            return true;
        else
            return false;
    }

    public function m_d_cert($id,$vend)
    {
      # code...
      $data=array(
            "STATUS"=>"0",
            "UPDATE_BY"=>$vend,
            "UPDATE_TIME"=>date("Y-m-d H:i:s")
        );
        $query = $this->db->where("ID=", $id)
                ->update("m_vendor_legal_other",$data);
        if ($query)
            return true;
        else
            return false;
    }

    public function get_bpjs(){
      $query = $this->db->select("*")->from("m_vendor_legal_other")->where("ID_VENDOR", $this->session->ID)->where("CATEGORY", "BPJS")->get();
      return $query->row();
    }

    public function get_bpjstk(){
      $query = $this->db->select("*")->from("m_vendor_legal_other")->where("ID_VENDOR", $this->session->ID)->where("CATEGORY", "BPJSTK")->get();
      return $query->row();
    }

    public function add_bpjs($data){
      $insert = $this->db->insert('m_vendor_legal_other', $data);
      return $insert;
    }

    public function upd_bpjs($data){
      $this->db->where("CATEGORY", $data['CATEGORY']);
      $this->db->where('ID', $data['ID']);
      $update = $this->db->update('m_vendor_legal_other', $data);
      return $update;
    }
}
