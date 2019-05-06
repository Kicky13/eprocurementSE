<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_log_in extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function cek_intern($post) {
        $decrypt = $post['password'];
        $data = $this->db->select("*")
                ->from('m_user')
                ->where('USERNAME', $post['username'])
                ->where('PASSWORD', stripslashes(str_replace('/','_',crypt($decrypt, mykeyencrypt))))                
                ->where('STATUS', '1')
                ->get();
        return $data->row();
    }
}
?>