<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_delivery_term extends MY_Model {
	protected $table = 'm_deliveryterm';

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function show($where = null) {
        if ($where != null) {
            $this->db->where("ID_DELIVERYTERM", $where);
        }
        $data = $this->db->select("*")->from('m_deliveryterm')->order_by('CREATE_ON DESC')->get();
        return $data->result_array();
    }

    public function simpan($data){
      $insert = $this->db->insert('m_deliveryterm', $data);
    }

    public function update($id, $data){
      return $this->db->where('ID_DELIVERYTERM', $id)->update('m_deliveryterm', $data);
    }

	public function all() {
		return $this->db->get($this->table)->result();
	}

    public function find($id)
    { 
        return @$this->db->where('ID_DELIVERYTERM', $id)->get($this->table)->result()[0]; 
    }
}
