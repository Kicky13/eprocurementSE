<?php if (!defined('BASEPATH')) exit('Anda tidak masuk dengan benar');

class M_equipment_picture extends CI_Model {

  public function __construct() {
    parent::__construct();    
    $this->table = 'cmms_equipment_picture';
  }
  public function find($id='')
  {
    return $this->db->where('id',$id)->get($this->table)->row();
  }
  public function findByEquipment($id='')
  {
    return $this->db->where('equipment_id',$id)->get($this->table)->result();
  }
}