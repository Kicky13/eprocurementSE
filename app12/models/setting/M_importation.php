<?php

class M_importation extends MY_Model {
  protected $table = 'm_importation';

  public function __construct() {
    parent::__construct();
    $this->db = $this->load->database('default', true);
  }

  public function all() {
    return $this->db->get($this->table)->result();
  }

  public function find($id)
  {
  	return @$this->db->where('ID_IMPORTATION', $id)->get($this->table)->result()[0];	
  }
}
