<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_freight extends MY_Model {
	protected $table = 'm_freight';

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function show($where = null) {
        if ($where != null) {
            $this->db->where("ID_FREIGHT", $where);
        }
        $data = $this->db->select("*")->from('m_freight')->order_by('CREATE_ON DESC')->get();
        return $data->result_array();
    }

    public function simpan($data){
      $insert = $this->db->insert('m_freight', $data);
    }

    public function update($id, $data){
      return $this->db->where('ID_FREIGHT', $id)->update('m_freight', $data);
    }
	
	public function all() {
		return $this->db->get($this->table)->result();
	}

    public function find($id)
    { 
        return @$this->db->where('ID_FREIGHT', $id)->get($this->table)->result()[0]; 
    }
}
