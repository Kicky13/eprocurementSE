<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_show_material extends CI_Model {
	protected $table = 'm_material';
    protected $primaryKey = 'material';

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

	public function get() {
		return isset($this->table) && !empty($this->table) ?
			$this->db->get($this->table) :
			$this->db->get();
	}

    public function find($id) {
        return $this->db->where($this->primaryKey, $id)->get($this->table)->first_row();
    }

    public function show($id = null) {
      if ($id != null) {
          $strwhere = "AND a.MATERIAL = ".$id;
      } else {
          $strwhere = "";
      }
      $query = $this->db->query("select DISTINCT a.UOM,a.MANUFACTURER_DESCRIPTION,a.UNIT_OF_ISSUE,a.UNIT_OF_PURCHASE,
      CONCAT(gl.code, ' - ', gl.description) AS GL_CLASS,
      lt.description as LINE_TYPE,
      st.description as STOCKING_TYPE,
      sc.description as STOCK_CLASS,
      it.description as INVENTORY_TYPE,
      pp.description as PROJECT_PHASE,
      av.DESCRIPTION_ENG as AVAILABILITY,
      cr.DESCRIPTION_ENG as CRITICALITY,
      a.SEARCH_TEXT,
      a.CREATE_TIME,
      a.PART_NO,a.MATERIAL, a.MATERIAL_CODE, a.MATERIAL_NAME, a.REQUEST_NO, 'MATERIAL CREATED' as s_status, 'MATERIAL CREATED' as status_ind, 'MATERIAL CREATED' as status_eng, c.DESCRIPTION as desc_group FROM m_material a
            JOIN (SELECT MAX(sequence) as max_seq, material_id FROM t_approval_material GROUP BY material_id ) cc ON cc.material_id=a.MATERIAL
            JOIN t_approval_material b ON b.material_id=cc.material_id AND b.sequence=cc.max_seq
            JOIN m_material_group c ON c.ID=a.SEMIC_MAIN_GROUP
      LEFT JOIN m_gl_class gl ON gl.id=a.GL_CLASS
      LEFT JOIN m_line_type lt ON lt.id=a.LINE_TYPE
      LEFT JOIN m_stocking_type st ON st.id=a.STOCKING_TYPE
      LEFT JOIN m_stock_class sc ON sc.id=a.STOCK_CLASS
      LEFT JOIN m_inventory_type it ON it.id=a.INVENTORY_TYPE
      LEFT JOIN m_project_phase pp ON pp.id=a.PROJECT_PHASE
      LEFT JOIN m_material_availability av ON av.ID=a.AVAILABILITY
      LEFT JOIN m_material_cricatility cr ON cr.ID=a.CRITICALITY
      WHERE b.status_approve = '1' ".$strwhere."
      ORDER BY a.CREATE_TIME DESC");
      return $query->result_array();
    }

	public function findByTypeAndQuery($type, $query, $company = '') {
		$semic_no_separator = ".";

		$this->load->model('material/M_group', 'material_group');

		$fields = $this->db->list_fields($this->table);
		//unset($fields['CREATE_BY'], $field['CREATE_TIME'],
			//$field['UPDATE_BY'], $FIELD['UPDATE_TIME']);

		if ($type == 'GOODS') { // Goods/Material
			return $this->findByCodeAndName($query,
				array('material as id', 'material_code as semic_no',
  				'material_name as name', 'uom'), $company);
		} elseif ($type == 'SERVICE' or $type == 'CONSULTATION') { // Service & Consultation
			return $this->material_group->findByTypeAndDescription(
				$type, $query,
				array('id', 'concat_ws("'.$semic_no_separator.'", parent, material_group) as semic_no',
          'description as name', '"" as uom')
			);
		} elseif ($type == 'BLANKET') { // Blanket
			return $this->material_group->findByTypeAndDescription(
				'GOODS', $query,
				array('id', 'concat_ws("'.$semic_no_separator.'", parent, material_group) as semic_no',
          'description as name', '"" as uom')
			);
		} else {
			return [];
		}
		//$this->db->select($fields)
			//->where('material_name', 'like', '%{$query}%')
			//->get()->result();

		//return $fields;
	}

    public function findByCodeAndName($query = null, $fields = array(), $company = '')
    {
        $this->load->model('material/M_material_warehouse');

        $t_approval_material = 't_approval_material';
        $m_warehouse = 'm_warehouse';
        $m_material_warehouse = $this->M_material_warehouse->getTable();

		if (empty($fields)) {
			$fields = $this->table.'.*';
		}

        $query = trim($query);

		$this->db->select($fields);

        $this->db->join("(
            select count(1) num, id_material
            from $m_material_warehouse matw
            join $m_warehouse wh on TRIM(wh.id_warehouse) = TRIM(matw.id_warehouse)
            where wh.id_company = '$company'
            group by id_material
        ) matw", "matw.id_material = {$this->table}.material");

        $this->db->join('
            (SELECT MAX(sequence) as max_seq, material_id
            FROM t_approval_material GROUP BY material_id)
            as cc', "cc.material_id = {$this->table}.MATERIAL");

        $this->db->join($t_approval_material, "{$t_approval_material}.material_id = cc.material_id
            and {$t_approval_material}.sequence = cc.max_seq");

        $this->db->where("{$t_approval_material}.status_approve", 1);

		if ($query) {
            $this->db->distinct()->group_start()
                ->where('material_code like', '%'.$query.'%')
                ->where('STOCKING_TYPE !=', '3')
                ->or_where('material_name like', '%'.$query.'%')
                ->where('STOCKING_TYPE !=', '3')
                ->group_end();
		}

		return $this->db->get($this->table)->result();
	}

	public function showItem($semic_no) {
      $query = $this->db->select('MATERIAL')
              ->from('m_material')
              ->where('MATERIAL_CODE', $semic_no);
      $result = $this->db->get()->row();
      return $result->MATERIAL;
    }

    public function update($material_id, $data)
    {
        unset($data['id']);
        return $this->db->set($data)
            ->where('MATERIAL', $material_id)
            ->update($this->table);
    }
}
