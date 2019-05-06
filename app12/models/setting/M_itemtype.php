<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_itemtype extends MY_Model {
	protected $table = 'm_itemtype';

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function show($where = null) {
        if ($where != null) {
            $this->db->where("ID_ITEMTYPE", $where);
        }
        $data = $this->db->select("*")->from('m_itemtype')->order_by('CREATE_ON DESC')->get();
        return $data->result_array();
    }

    public function simpan($data){
      $insert = $this->db->insert('m_itemtype', $data);
    }

    public function update($id, $data){
      return $this->db->where('ID_ITEMTYPE', $id)->update('m_itemtype', $data);
    }

	public function all() {
		return $this->db->get($this->table)->result();
	}
}
