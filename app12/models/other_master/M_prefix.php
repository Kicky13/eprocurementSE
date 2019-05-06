<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_prefix extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function show($where = null) {
        if ($where != null) {
            $this->db->where($where);
        }
        $data = $this->db->from('m_prefix')->order_by('CREATE_TIME DESC')->get();
        return $data->result();
    }

    public function add($data) {
        $data = $this->db->insert('m_prefix', $data);
        return $data;
    }

    public function update($id, $data) {
        return $this->db->where('ID_PREFIX', $id)->update('m_prefix', $data);
    }

}
?>

