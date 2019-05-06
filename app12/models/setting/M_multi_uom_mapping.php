<?php if (!defined('BASEPATH')) exit('Anda tidak masuk dengan benar');

class M_multi_uom_mapping extends MY_Model
{
    protected $table = 'm_multi_uom_mapping';
    protected $primaryKey = 'uom';

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function findMap($uom1, $uom2)
    {
        return $this->db->where('uom1', $uom1)
            ->where('uom2', $uom2)
            ->get($this->table)->first_row();
    }

    public function show($where = null) {
        if ($where != null) {
          $andwhere = "uom = '".$where."' ";
        } else {
          $andwhere = "1=1";
        }
        $data = $this->db->query("SELECT a.*, bb.MATERIAL_UOM AS uom1_code, bb.DESCRIPTION AS uom1_desc, cc.MATERIAL_UOM AS uom2_code, cc.DESCRIPTION AS uom2_desc, dd.MATERIAL_UOM AS uom_code, dd.DESCRIPTION AS uom_desc FROM m_multi_uom_mapping a
        JOIN (SELECT ID, DESCRIPTION, MATERIAL_UOM FROM m_material_uom ) bb ON bb.ID=a.uom1
        JOIN (SELECT ID, DESCRIPTION, MATERIAL_UOM FROM m_material_uom ) cc ON cc.ID=a.uom2
        JOIN (SELECT ID, DESCRIPTION, MATERIAL_UOM FROM m_material_uom ) dd ON dd.ID=a.uom
        WHERE ".$andwhere." ");
        return $data->result_array();
    }

    public function simpan($data){
      $insert = $this->db->insert('m_multi_uom_mapping', $data);
    }

    public function update($id, $data){
      return $this->db->where('uom', $id)->update('m_multi_uom_mapping', $data);
    }

    public function m_material_uom($where = null){
      if ($where != null) {
          $this->db->where("ID", $where);
      }
      $this->db->where("STATUS", '1');
      $data = $this->db->select("*")->from('m_material_uom')->order_by('MATERIAL_UOM ASC')->get();
      return $data->result_array();
    }

}
