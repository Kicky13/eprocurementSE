<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class OR_Model extends CI_Model
{
  public function __construct() 
  {
    parent::__construct();
    $this->jde = $this->load->database('oracle', true);
  }
  public function get()
  {
    return $this->jde->get($this->table);
  }
  public function find($id='')
  {
    return $this->jde->where('id', $id)->get($this->table)->row();
  }
  public function update($id='', $data='')
  {
    return $this->jde->where('id', $id)->update($this->table, $data);
  }
  public function insert($data='')
  {
    return $this->jde->insert($this->table, $data);
  }
  public function delete($id='')
  {
    return $this->jde->where('id', $id)->delete($this->table);
  }
}
