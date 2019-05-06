<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_message extends CI_Model {
	public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
        $this->tb = 'm_message';
    }
    public function get($param = '' )
    {
    	if(is_array($param))
    	{
    		$this->db->where($param);
    	}
    	return $this->db->get($this->tb);
    }
}