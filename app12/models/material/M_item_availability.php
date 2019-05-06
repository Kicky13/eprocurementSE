<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_item_availability extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function m_material(){
      $query = $this->db->query("SELECT DISTINCT MATERIAL, MATERIAL_CODE, MATERIAL_NAME FROM m_material WHERE MATERIAL_CODE != '' ");
      return $query->result_array();
    }

    public function m_bplant(){
      $query = $this->db->query("SELECT * FROM m_bplant WHERE STATUS = '1' ");
      return $query->result_array();
    }

    public function search_Item_availability($data){
      if (!empty($data['MATERIAL_ID'])) { $this->db->where("MATERIAL_ID", $data['MATERIAL_ID']); }
      if (!empty($data['LOCATION_TYPE'])) { $this->db->like("LOCATION", $data['LOCATION_TYPE']); }
      if (!empty($data['BRANCH_PLANT'])) { $this->db->where("BRANCH_PLANT", $data['BRANCH_PLANT']); }
      // if (!empty($data['LOCATION_TYPE'])) { $this->db->where("LOCATION_TYPE", $data['LOCATION_TYPE']); }
      $this->db->select("*")->from("sync_item_available");
      $query = $this->db->get();
      // $query = $this->db->query("select * FROM sync_item_available WHERE BRANCH_PLANT LIKE '%".$data['BRANCH_PLANT']."%' AND MATERIAL_ID LIKE '%".$data['MATERIAL_ID']."%' AND LOCATION LIKE '%".$data['LOCATION']."%' AND LOCATION_TYPE LIKE '%".$data['LOCATION_TYPE']."%' ");
      return $query->result_array();
    }

}
