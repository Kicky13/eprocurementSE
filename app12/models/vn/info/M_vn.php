<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_vn extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function menu() {
        $data = $this->db->from('m_menu_vendor')
                        ->where('STATUS', '1')
                        ->like('VENDOR_STATUS',$this->session->status_vendor)
                        ->order_by('SORT')
                        ->get();
//        echo $this->db->last_query();exit;
        return $data->result();
    }
    
    public function get_tkdn_type() {        
        return $this->db->get('m_tkdn_type')
        ->result();
    }
    public function find($id='')
    {
        return $this->db->where('id',$id)->get('m_tkdn_type')->row();
    }
}

?>
