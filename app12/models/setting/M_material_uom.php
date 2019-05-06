<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_material_uom extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
        $this->table = 'm_material_uom';
    }

    public function show($where = null) {
        if ($where != null) {
            $this->db->where("ID", $where);
        }
        $data = $this->db->select("*")->from($this->table)->order_by('ID DESC')->get();
        return $data->result_array();
    }

    public function simpan($data){
      $insert = $this->db->insert($this->table, $data);
    }

    public function update($id, $data){
      return $this->db->where('ID', $id)->update($this->table, $data);
    }
    public function find($id)
    {
        return @$this->db->where('ID', $id)->get($this->table)->result()[0];
    }
    public function all($value='')
    {
        return $this->db->get($this->table)->result();
    }

    public function findByMaterialUom($uom)
    {
        return @$this->db->where('MATERIAL_UOM', $uom)->get($this->table)->first_row();
    }

}
