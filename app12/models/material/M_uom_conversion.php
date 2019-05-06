<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_uom_conversion extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function show($where = null) {
        if ($where != null) {
            $this->db->where($where);
        }
        $data = $this->db->from('m_material_uom_conversion')->order_by('CREATE_TIME DESC')->get();
        return $data->result();
    }
    
    public function add($data) {
        $data = $this->db->insert('m_material_uom_conversion', $data);
//        echo $this->db->last_query();exit;
        return $data;
    }
    
    public function update($id, $data){
        return $this->db->where('ID', $id)->update('m_material_uom_conversion', $data);
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
        $matr = array();        
        $from_uom = array();
        $to_uom = array();
        $from_qty = array();
        $to_qty = array();
        $count = 0;
        $limit = $data['limit'];
        $status = null;
        foreach ($data as $k => $v) {
            if (strpos($k, 'desc') !== false)
                array_push($desc, $v);
            if (strpos($k, 'matr') !== false)
                array_push($matr, $v);
            if (strpos($k, 'from_uom') !== false)
                array_push($from_uom, $v);
            if (strpos($k, 'to_uom') !== false)
                array_push($to_uom, $v);
            if (strpos($k, 'from_qty') !== false)
                array_push($from_qty, $v);
            if (strpos($k, 'to_qty') !== false)
                array_push($to_qty, $v);
        }
        $this->db->select("ID,MATERIAL,DESCRIPTION,FROM_UOM,FROM_QTY,TO_UOM,TO_QTY,STATUS")
                ->from("m_material_uom_conversion");
                
        $this->db->group_start();
        $this->data_search($matr, "MATERIAL");
        $this->data_search($desc, "DESCRIPTION");
        $this->data_search($from_uom, "FROM_UOM");
        $this->data_search($from_qty, "FROM_QTY");
        $this->data_search($to_uom, "TO_UOM");
        $this->data_search($to_qty, "TO_QTY");
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
