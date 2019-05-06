<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_pmethod extends MY_Model {
    protected $table = 'm_pmethod';

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function show($where = null) {
        if ($where != null) {
            $this->db->where("ID_PMETHOD", $where);
        }
        $data = $this->db->select("*")->from('m_pmethod')->order_by('CREATE_ON DESC')->get();
        return $data->result_array();
    }

    public function simpan($data){
      $insert = $this->db->insert('m_pmethod', $data);
    }

    public function update($id, $data){
      return $this->db->where('ID_PMETHOD', $id)->update('m_pmethod', $data);
    }

    public function all() {
        return $this->db->get($this->table)->result();
    }
	
	public function find($id) {
		return $this->db->where('ID_PMETHOD', $id)
			->get($this->table)->result();
	}
}
