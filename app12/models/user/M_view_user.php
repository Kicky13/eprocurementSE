<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_view_user extends CI_Model {
    protected $table = 'm_user';

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function getTable() {
        return $this->table;
    }

    public function show($where = null) {
        if ($where != null) {
            $this->db->where($where);
        }

        $data = $this->db->from('m_user')->order_by('CREATE_TIME DESC')->get();
        return $data->result();
    }

    public function get_user($id)
    {
        $dt=$this->db->select('USERNAME,EMAIL')
                ->from('m_user')
                ->where('ID_USER',$id)
                ->get();
        return $dt->result();
    }

    public function show_temp_email($id) {
        $data = $this->db
                ->select('*')
                ->from('m_notic')
                ->where('ID', $id)
                ->get();
        return $data->row();
    }

    public function add($data) {
        $data = $this->db->insert('m_user', $data);
//        echo $this->db->last_query();exit;
        return $data;
    }

    public function update($id, $data) {
        return $this->db->where('ID_USER', $id)->update('m_user', $data);
    }

    public function show_user($where) {
        $this->db->where('ID_USER', $where);
        $data = $this->db->select('*')->from('m_user a')
        ->order_by('CREATE_TIME DESC')->get();
        return $data->row();
    }

    public function get_departement($where) {
        $this->db->where('ID_COMPANY', $where);
        $this->db->where('STATUS', '1');
        $data = $this->db->select('*')->from('m_departement')->get();
        return $data->result_array();
    }

    public function get_costcenter($idx) {
        $this->db->where('ID_COMPANY', $idx);
        $this->db->where('STATUS', '1');
        $data = $this->db->select('*')->from('m_costcenter')->get();
        return $data->result_array();
    }

    public function getByRole($role_id)
    {
        return $this->db->from($this->table)
            ->like('roles', ','.$role_id.',')
            ->get()->result();
    }

}

?>
