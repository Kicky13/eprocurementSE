<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_work_request extends OR_Model {
  
  protected $table = 'work_order';
  var $columnSearch = ['nama', 'etc'];
  var $columnSort = ['id', 'nama', 'etc'];
  var $sortDefault = ['id', 'desc'];

  public function __construct() {
    parent::__construct();
  }
}