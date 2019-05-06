<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_group extends CI_Model {
    protected $table = 'm_material_group';

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function show($where = null) {
        if ($where != null) {
            $this->db->where($where);
        }
        $data = $this->db
                ->select("m.id as id1, g.id as id2, g.PARENT as m_group, m.description as klasifikasi, g.material_group, g.description as grupname, g.type, g.status")
                ->from('m_material_group m')
                ->join("m_material_group g","g.PARENT=m.material_group and g.type=m.type and g.category='GROUP'")
                ->order_by('g.type,m.description')->get();
        return $data->result();
    }

    public function add($tbl, $data) {
        $this->db->insert($tbl, $data);
//        echo $this->db->last_query();exit;
    }

    public function update($id, $data){
        return $this->db->where('ID', $id)->update('m_material_group', $data);
    }

    public function show_material_group_datatable($where = null){
      if ($where != null) {
        $this->db->where($where);
      } else {
        $data = $this->db
                ->select("ID, MATERIAL_GROUP, DESCRIPTION, TYPE, STATUS")
                ->from('m_material_group')
                ->where('CATEGORY', "CLASIFICATION")
                ->order_by('CREATE_TIME DESC')->get();
        return $data->result();
      }
      $query = $this->db
      ->select('*')
      ->from('m_material_group')
      ->where('STATUS', '1')
      ->where('TYPE', 'GOODS')
      ->where('CATEGORY', 'CLASIFICATION')
      ->order_by('MATERIAL_GROUP ASC');
      $result = $this->db->get();
      return $result->result_array();
    }

    public function simpan_m_group($data){
      $insert = $this->db->insert('m_material_group', $data);
    }

    public function update_m_group($id, $data){
      return $this->db->where('ID', $id)->update('m_material_group', $data);
    }

    public function all($fields = array()) {
        if(empty($fields)) {
            $fields = '*';
        }

        return $this->db->select($fields)->get($this->table)->result();
    }

    public function findByTypeAndDescription($type, $query = null, $fields = array()) {
        if (empty($fields)) {
            $fields = '*';
        }

        //if (!is_array($type)) {
            //$type = array($type);
        //}

        $db = $this->db->select($fields)->where('type', $type)
            ->where('CATEGORY', 'GROUP');

        if ($query) {
            $db->where("(description like ".$this->db->escape('%'.$query.'%')." 
                OR CONCAT_WS('', parent, material_group) like ".$this->db->escape('%'.$query.'%').")");
        }
        //$db->from($this->table);
        //echo $this->db->get_compiled_select();
        //exit;


        return $db->get($this->table)->result();
    }

    public function findByMaterialAndType($material_id, $type)
    {
        //if ($type == 'SERVICE' || $type == 'CONSULTATION') {
            //$separator = '-';
        //} 
        //elseif ($type == 'GOODS' || $type == 'BLANKET') { 
            //$separator = '.';
            //$type = 'GOODS';
        //} 
        //else {
            //return array();
        //}
        //$separator = '.';

        //$arr_semic_no = explode($separator, $semic_no);

        //if (count($arr_semic_no) < 2) {
            //return array(); // not enough parameter
        //}

        //$parent = array_shift($arr_semic_no); // first part
        //$material_group = array_shift($arr_semic_no); // second part
        
        // Type : GOODS, we use material_id and parse it to get material group and subgroup
        if ($type == 'GOODS') {
            // TODO use model best practice!!!
            $material = @$this->db->select([
                'm_material.*',
                'uom.id as uom_id',
                'uom.material_uom as uom_name',
                'uom.description as uom_description'
                ]) 
                ->where('material', $material_id)
                ->join('m_material_uom as uom', 'uom.MATERIAL_UOM = m_material.unit_of_issue and uom.status = 1', 'left')
                ->get('m_material')->result()[0];

            if (!$material) {
                return false;
            }

            // Get material Group and Subgroup
            $material_group = $this->parseFromMaterialCode($material->MATERIAL_CODE);

            //select mg2.material_group, mg2.description, mg2.category, mg1.* 
                //from m_material_group mg1  
                //join m_material_group mg2 on mg2.material_group = mg1.parent and mg2.type = mg1.type  
                //where mg1.material_group = 53     
                //and mg1.type = 'GOODS'
            // select child first then parent
            
            // TODO: Find where qty_onhand and qty_ordered come from
            return $this->db->select([
                'mg1.type',
                'mg2.description as group_name',
                'mg2.material_group as group_code',
                'mg1.description as subgroup_name',
                'mg1.material_group as subgroup_code',
                '"'.$material->uom_description.'" as uom_description',
                '"'.$material->uom_name.'" as uom_name',
                '"'.$material->uom_id.'" as uom_id',
                '"" as qty_onhand',
                '"" as qty_ordered'
                ])
                ->from($this->table.' as mg1')
                ->join($this->table.' as mg2', 'mg2.material_group = mg1.parent and mg2.type = mg1.type')
                ->where('mg1.material_group', (int)$material_group['group'])
                ->where('mg1.type', $type)
                //->where('mg1.parent = m', )
                ->get()
                ->result();
        }
        // Type : SERVICE, CONSULTATION, we use material group ID directly, instead of ID of material
        elseif ($type == 'SERVICE' || $type == 'CONSULTATION' || $type == 'BLANKET') {
            if ($type == 'BLANKET') {
                $type = 'GOODS';
            }

            return $this->db->select([
                'mg1.type',
                'mg2.description as group_name',
                'mg2.material_group as group_code',
                'mg1.description as subgroup_name',
                'mg1.material_group as subgroup_code',
                '"" as uom_description',
                '"" as uom_name',
                '"" as uom_id',
                '"" as qty_onhand', '"" as qty_ordered'
                ])
                ->from($this->table.' as mg1')
                ->join($this->table.' as mg2', 'mg2.material_group = mg1.parent and mg2.type = mg1.type')
                ->where('mg1.id', $material_id)
                //->where('mg1.material_group', $material_group)
                ->where('mg1.type', $type)
                //->where('mg1.parent', $parent)
                ->get()
                ->result();
        }
        else {
            return false;
        }

    }

    public function parseFromMaterialCode($material_code)
    {
        $arr_material = explode('.', $material_code);

        return array(
            'group'     => array_shift($arr_material),
            'subgroup'  => array_shift($arr_material)
        );
    }
}
