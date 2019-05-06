<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_subcategory extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function show_edit($where = null) {
        if ($where != null) {
            $this->db->where($where);
        }
        // $data = $this->db
        //         ->select("e.ID as id1, m.ID as id2, g.ID as id3, e.MATERIAL_GROUP as mgrup1, e.TYPE as mtype1, e.DESCRIPTION as desc1, m.DESCRIPTION as desc2, s.id as id4, m.description as klasifikasi,g.material_group,g.description as grupname,g.type,g.status")
        //         ->from('m_material_group m')
        //         ->join("m_material_group g","g.PARENT=m.material_group and g.type=m.type and g.category='SUBGROUP'",'')
        //         ->join("m_material_group s","s.PARENT=m.material_group and s.type=s.type and s.category='SUBGROUP'",'')
        //         ->join("m_material_group e","e.MATERIAL_GROUP=m.PARENT and e.type=m.TYPE and e.CATEGORY= 'CLASIFICATION'",'')
        //         ->order_by('g.type,m.description')->get();
        $data = $this->db
                ->select("s.id as idsub, g.id as id1, g.PARENT as id2, m.id as id3, m.description as klasifikasi,g.material_group,g.description as grupname,s.description as subdesc, g.type,g.status")
                ->from('m_material_group m')
                ->join("m_material_group g "," g.PARENT=m.material_group and g.CATEGORY='GROUP' and g.type=m.type")
                ->join("m_material_group s "," s.PARENT=g.material_group and s.CATEGORY='SUBGROUP' and s.type=m.type and s.type=g.type")
                ->where("m.CATEGORY='CLASIFICATION'")
                ->order_by('g.type,m.description')->get();
        return $data->result();
    }

    public function show($where = null) {
        if ($where != null) {
            $this->db->where($where);
        }
        $data = $this->db
                ->select("s.id as idsub, g.id as id1, g.PARENT as id2, m.id as id3, m.description as klasifikasi,g.material_group,g.description as grupname,s.description as subdesc, g.type,g.status")
                ->from('m_material_group m')
                ->join("m_material_group g "," g.PARENT=m.material_group and g.CATEGORY='GROUP' and g.type=m.type")
                ->join("m_material_group s "," s.PARENT=g.material_group and s.CATEGORY='SUBGROUP' and s.type=m.type and s.type=g.type")
                ->where("m.parent='' AND m.CATEGORY='CLASIFICATION'")
                ->order_by('g.type,m.description')->get();
        return $data->result();
    }

    public function getsubgroup($data){
      $group = explode("|", $data);
      $data = $this->db->select("*")->from("m_material_group")->where("TYPE", $group[1])->where("PARENT", $group[0])->get();
      return $data->result();
    }

    public function simpan_m_subgroup($data){
      $insert = $this->db->insert('m_material_group', $data);
    }

    public function update_m_subgroup($id, $data){
      return $this->db->where('ID', $id)->update('m_material_group', $data);
    }
}
