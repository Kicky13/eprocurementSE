<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_bank extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function show($where) {
        if ($where != null) {
            $this->db->where($where);
        }
        $data = $this->db->from('m_bank')->order_by('CREATE_TIME DESC')->get();
        return $data->result();
    }

    public function add($data) {
        $data = $this->db->insert('m_bank', $data);
        return $data;
    }

    public function update($id, $data) {
        return $this->db->where('ID', $id)->update('m_bank', $data);
    }

}
?>

