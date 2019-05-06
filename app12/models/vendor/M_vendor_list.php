<?php
if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');
    
class M_vendor_list extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function menu() {
        $data = $this->db->from('m_menu')->where('STATUS', '1')->get();
        return $data->result();
    }

}

?>
