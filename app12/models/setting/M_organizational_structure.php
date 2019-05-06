<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_organizational_structure extends MY_Model {
    protected $table = 't_jabatan';

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function show($where = null) {
        if ($where != null) {
            $this->db->where('id', $where);
        }
        $data = $this->db->select('id, position, title, user_role, parent_id, user_id, golongan, nominal, operand, next_level, company_id, first, nominal_writeoff, nominal_intercompany, m_user.ID_USER, m_user.NAME')->from($this->table)->join('m_user', 'user_id = ID_USER')->order_by('id ASC')->get();
        return $data->result_array();
    }

    public function show_no_job() {
        $data = $this->db->select('m_user.ID_USER, m_user.NAME')->from($this->table)->join('m_user', $this->table . '.user_id = m_user.ID_USER', 'right')->where(array($this->table . '.user_id' => NULL, 'm_user.STATUS' => 1))->order_by('m_user.ID_USER ASC')->get();
        return $data->result_array();
    }

    public function show_supervisor($where) {
        $data = $this->db->select('id, position, title, user_role, parent_id, user_id, golongan, nominal, operand, next_level, company_id, first, nominal_writeoff, nominal_intercompany, m_user.ID_USER, m_user.NAME')->from($this->table)->join('m_user', 'user_id = ID_USER')->order_by('id ASC')->where($where)->get();
        return $data->result_array();
    }

    public function show_job($table, $order, $where = null) {
        if ($where != null) {
            $this->db->where($where);
        }
        $data = $this->db->select("*")->from($table)->order_by($order)->get();
        return $data->result_array();
    }

    public function get_global_approval() {
        $data = $this->db->select('j.position, u.NAME')->from('t_jabatan j')->join('m_user u', 'u.ID_USER = j.user_id')->where('j.first', 1)->get();
        return $data->result_array();
    }

    public function check($where) {
        $data = $this->db->select('id')->where($where)->from($this->table)->limit(1)->get();
        return $data->result_array();
    }

    public function add($data) {
      return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
      return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function find($id) {
        return @$this->db->where('id', $id)->get($this->table)->result()[0];
    }

    public function all($value='') {
        return $this->db->where(['status'=>1])->get($this->table)->result();
    }

    public function findAllActive($id) {
        if (!is_array($id)) {
            $id = array($id);
        }
        return $this->db->where('status', 1)->where_in('id', $id)->get($this->table)->result();
    }
}
