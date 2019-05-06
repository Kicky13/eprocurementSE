<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_master_requestfor extends MY_Model {
    protected $table = 'm_requestfor';

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function show($where = null) {
        if ($where != null) {
            $this->db->where('ID_REQUESTFOR', $where);
        }
        $data = $this->db->select('ID_REQUESTFOR, REQUESTFOR_DESC, STATUS')->from($this->table)->order_by('CREATE_ON DESC')->get();
        return $data->result_array();
    }

    public function check($where = null) {
        if ($where != null) {
            $this->db->where($where);
        }
        $data = $this->db->select('ID_REQUESTFOR')->from($this->table)->limit(1)->get();
        return $data->result_array();
    }

    public function add($data) {
      return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
      return $this->db->where('ID_REQUESTFOR', $id)->update($this->table, $data);
    }

    public function find($id) {
        return @$this->db->where('ID_REQUESTFOR', $id)->get($this->table)->result()[0];
    }

    public function all($value='') {
        return $this->db->where(['STATUS'=>1])->get($this->table)->result();
    }

    public function findAllActive($id) {
        if (!is_array($id)) {
            $id = array($id);
        }
        return $this->db->where('STATUS', 1)->where_in('ID_REQUESTFOR', $id)->get($this->table)->result();
    }
}
