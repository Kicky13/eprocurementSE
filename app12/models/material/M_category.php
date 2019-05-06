<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_category extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function show($where = null) {
        if ($where != null) {
            $this->db->where($where);
        }
        $data = $this->db
                    ->select('ID, MATERIAL_GROUP, DESCRIPTION', 'PARENT')
                    ->from('m_material_group')
                    ->order_by('CREATE_TIME DESC')
                    ->limit(100)->get();
        return $data->result();
    }
    
    public function get_group_data($arr){
        $data = $this->db
                    ->select('ID, MATERIAL_GROUP')
                    ->from('m_material_group')
                    ->where_in($arr);
        return $data->result();
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
    
    public function get_group($data) {
        $desc = array();
        $group = array();
        $long = array();
        $count = 0;
        $limit = $data['limit'];
        foreach ($data as $k => $v) {
            if (strpos($k, 'desc') !== false)
                array_push($desc, $v);
            if (strpos($k, 'group') !== false)
                array_push($group, $v);
            if (strpos($k, 'long') !== false)
                array_push($long, $v);
        }
        $this->db->select("ID,MATERIAL_GROUP,DESCRIPTION,LONG_DESCRIPTION,STATUS")
                ->where("CATEGORY", "CATEGORY")
                ->from("m_material_group");        
        
        $this->db->group_start();
        $this->data_search($desc, "DESCRIPTION");
        $this->data_search($group, "MATERIAL_GROUP");
        $this->data_search($long, "LONG_DESCRIPTION");        
        $this->db->group_end();
        
        if($data['status1']!="none"&&$data['status2']=="none")
            $this->db->where("STATUS=", 1);
        else if($data['status2']!="none"&&$data['status1']=="none")
            $this->db->where("STATUS=", 0);
        
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result();
    }

    public function add($data) {
        $data = $this->db->insert('m_material_group', $data);
//        echo $this->db->last_query();exit;
        return $data;
    }

    public function update($id, $data) {
        return $this->db->where('ID', $id)->update('m_material_group', $data);
    }

}

?>
