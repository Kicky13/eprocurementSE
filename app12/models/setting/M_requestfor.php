<?php

class M_requestfor extends MY_Model {
  protected $table = 'm_requestfor';

  public function __construct() {
    parent::__construct();
    $this->db = $this->load->database('default', true);
  }

  public function all() {
    return $this->db->get($this->table)->result();
  }

  public function find($id)
  {
  	return @$this->db->where('ID_REQUESTFOR', $id)->get($this->table)->result()[0];	
  }
}
