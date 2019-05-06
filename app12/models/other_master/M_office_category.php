<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_office_category extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function show($where) {
        if ($where != null) {
            $this->db->where($where);
        }
        $data = $this->db->from('m_office_category')->order_by('CREATE_TIME DESC')->get();

        return $data->result();
    }

    public function add($data) {
        $data = $this->db->insert('m_office_category', $data);
        return $data;
    }

    public function update($id, $data) {
        return $this->db->where('ID_OFFICE', $id)->update('m_office_category', $data);
    }

}
?>

