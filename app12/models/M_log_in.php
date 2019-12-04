<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_log_in extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
        $this->load->library('encryption');
    }

    public function cek_intern($post) {
//        $decrypt = $this->encryption->decrypt($post['password']);
        $decrypt = $post['password'];
        $data = $this->db->select("*")
                ->from('m_user')
                ->where('USERNAME', $post['username'])
                ->where('PASSWORD', stripslashes(str_replace('/','_',crypt($decrypt, mykeyencrypt))))
                //->where('PASSWORD', md5(md5($decrypt)))
                ->where('STATUS', '1')
                ->get();
        return $data->row();
    }


    public function cek_intern_ex($post) {
        $data = $this->db->query("select * FROM m_user WHERE (USERNAME = '".$post['username']."' OR id_external = '".$post['username']."') AND is_external = '1' AND STATUS = '1'");
			//echo $this->db->last_query();exit;
        return $data->row();
    }

    public function get_menu_in($roles){
        $data = $this->db->select("MENU as M")
                ->from('m_user_roles')
                ->where_in('ID_USER_ROLES', $roles)
                ->where('STATUS', '1')
                ->get();
        return $data->result_array();
    }

    public function get_task_in($roles){
        $data = $this->db->select("TASK as M")
                ->from('m_user_roles')
                ->where_in('ID_USER_ROLES', $roles)
                ->where('STATUS', '1')
                ->get();
        return $data->result_array();
    }

    public function get_vendor($url) {
        $data = $this->db->from('m_vendor')
                ->where('URL', $url)
                ->where('STATUS !=', '0')
                ->get();
        return $data->row();
    }

    public function update_vendor($where, $data) {
        return $this->db->where("STATUS < 3 AND STATUS > 0")->update('m_vendor', $data);
    }

    public function cek_vendor($post) {
//        $decrypt = $this->encryption->decrypt($post['password']);
        $data = $this->db->from('m_vendor')
                ->where('ID_VENDOR', $post['username'])
                ->where('PASSWORD', stripslashes(str_replace('/','_',crypt($post['password'], mykeyencrypt))))
                ->where('STATUS >=', '3')
                ->get();
//        echo $this->db->last_query();exit;
        return $data->result();
    }

    public function check_reg() {
        $query = $this->db->from('open_vendor')
                ->where('DATE_START <=', 'CURDATE()', FALSE)
                ->where('DATE_CLOSE >', 'CURDATE()', FALSE)
                ->where('STATUS =', 1)
                ->get();
        if ($query->num_rows() != 0)
            return $query->result();
        else
            return false;
    }

}

?>
