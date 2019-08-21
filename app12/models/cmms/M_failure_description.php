<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_failure_description extends CI_Model {
  
  protected $table = 'cmms_failure_description';

  public function __construct() {
    parent::__construct();
  }
  public function all($value='')
  {
  	return $this->db->get($this->table)->result();
  }
}