<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_service_uom extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
        $this->table = 'm_service_uom';
    }

    public function show($where = null) {
        if ($where != null) {
            $this->db->where($where);
        }
        $data = $this->db->from($this->table)->order_by('id DESC')->get();
        return $data->result();
    }
    
    public function add($data) {
        $data = $this->db->insert($this->table, $data);
//        echo $this->db->last_query();exit;
        return $data;
    }
    
    public function update($id, $data){
        return $this->db->where('ID', $id)->update($this->table, $data);
    }
    
    public function filter_data($data) {
        $desc = array();
        $uom = array();        
        $count = 0;
        $limit = $data['limit'];
        foreach ($data as $k => $v) {
            if (strpos($k, 'desc') !== false)
                array_push($desc, $v);            
            if (strpos($k, 'uom') !== false)
                array_push($uom, $v);
        }
        $this->db->select("ID,MATERIAL_UOM,DESCRIPTION,STATUS")
                ->from("m_material_uom");
        if($data['status1']!="none"&&$data['status2']=="none")
            $this->db->where("STATUS=", 1);
        else if($data['status2']!="none"&&$data['status1']=="none")
            $this->db->where("STATUS=", 0);
                
        if (count($desc) > 0) {
            foreach ($desc as $k => $v) {
                if ($count == 0) {
                    $this->db->like("DESCRIPTION", $v);
                    $count++;
                } else
                    $this->db->or_like("DESCRIPTION", $v);
            }
        }
        $count=0;        
        if (count($uom) > 0) {
            foreach ($uom as $k => $v) {
                if ($count == 0) {
                    $this->db->like("MATERIAL_UOM", $v);
                    $count++;
                } else
                    $this->db->or_like("MATERIAL_UOM", $v);
            }
        }
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result();
    }
        
}

?>
