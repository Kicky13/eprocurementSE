<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_classification extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function show($where = null) {
        if ($where != null) {
            $this->db->where($where);
        }
        $data = $this->db
                ->select("ID, MATERIAL_GROUP, DESCRIPTION, TYPE, STATUS")
                ->from('m_material_group')
                ->where('CATEGORY', "CLASIFICATION")
                ->order_by('CREATE_TIME DESC')->get();
        return $data->result();
    }

    public function add($data) {
        $data = $this->db->insert('m_material_group', $data);
//        echo $this->db->last_query();exit;
        return $data;
    }

    public function update($id, $data) {
        return $this->db->where('ID', $id)->update('m_material_group', $data);
    }

    public function data_search($data, $col) {
        $count = 0;
        if (count($data) > 0) {
            foreach ($data as $k => $v) {
                if ($count == 0) {
                    $this->db->like($col, $v);
                    $count++;
                } else
                    $this->db->or_like($col, $v);
            }
        }
    }

    public function filter_data($data) {
        $desc = array();
        $type = array();
        $count = 0;
        $limit = $data['limit'];
        $status = null;
        foreach ($data as $k => $v) {
            if (strpos($k, 'desc') !== false)
                array_push($desc, $v);
            if (strpos($k, 'type') !== false)
                array_push($type, $v);
        }
        $this->db->select("ID,MATERIAL_GROUP,DESCRIPTION,TYPE,STATUS")
                ->from("m_material_group")->where('CATEGORY', "CLASIFICATION");        
        
        $this->db->group_start();
        $this->data_search($desc, "DESCRIPTION");
        $this->data_search($type, "MATERIAL_GROUP");
        $this->db->group_end();
        
        if ($data['status1'] != "none" && $data['status2'] == "none")
            $this->db->where("STATUS=", 1);
        else if ($data['status2'] != "none" && $data['status1'] == "none")
            $this->db->where("STATUS=", 0);
        
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result();
    }

}

?>
