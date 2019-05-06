<?php
if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_report extends CI_Model {

    public function get_company() {
        return $this->db->get('m_company')->result();
    }    

    public function get_sync_doc() {
        return $this->db->get('m_sync_doc')->result();
    }
}