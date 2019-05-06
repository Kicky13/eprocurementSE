<?php if (!defined('BASEPATH')) exit('Anda tidak masuk dengan benar');

class M_log extends CI_Model {

  public function __construct() {
      parent::__construct();
      $this->db = $this->load->database('default', true);
      $this->tb 	= 'log_history';
  }

 	public function store($data = array())
	{
    $this->db->insert($this->tb, $data);
	}
  public function daftar($data = '')
  {
    if (is_array($data)) {
      $this->db->where($data);
    }
    $this->db->order_by('id','desc');
    $daftar = $this->db->get($this->tb);
    return $daftar;
  }
}
