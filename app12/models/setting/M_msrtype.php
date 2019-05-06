<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_msrtype extends MY_Model {
    const TYPE_GOODS = 'MSR01';
    const TYPE_SERVICE = 'MSR02';
    const TYPE_BLANKET = 'MSRBO';

    protected $table = 'm_msrtype';
	protected $itemType = array(
		'MSR01' => 'GOODS',
		'MSR02' => 'SERVICE',
		'MSRBO' => 'BLANKET'
	);

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function show($where = null) {
        if ($where != null) {
            $this->db->where("ID_MSR", $where);
        }
        $data = $this->db->select("*")
            ->from($this->table)
            ->order_by('CREATE_ON DESC')
            ->get()
            ->result_array();
        return $data;
    }

    public function simpan($data){
      $insert = $this->db->insert('m_msrtype', $data);
    }

    public function update($id, $data){
      return $this->db->where('ID_MSR', $id)->update('m_msrtype', $data);
    }

	/**
	 * Deprecated. Use all() instead
	 */
    public function get() {
		return $this->all();
    }

	public function all() {
        return $this->db->get($this->table)->result();
	}

	public function find($id) {
		return $this->db->where('ID_MSR', $id)->get($this->table)->result();
	}

	public function itemType($msr_type) {
		return array_key_exists($msr_type, $this->itemType) ?
			$this->itemType[$msr_type] :
			null;
	}

	public function getMapItemType() {
		return $this->itemType;
	}
}
