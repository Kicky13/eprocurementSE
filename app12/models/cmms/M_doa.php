<?php if (!defined('BASEPATH')) exit('Anda tidak masuk dengan benar');

class M_doa extends CI_Model {

  public function __construct() {
    parent::__construct();    
    $this->table = 'cmms_doa';
  }
  public function store($data='')
  {
    $this->db->trans_begin();
    $this->db->insert($this->table, $data);
    if($this->db->trans_status() === true)
    {
      $this->db->trans_commit();
      return true;
    }
    else
    {
      $this->db->trans_rollback();
      return false;
    }
  }
  public function update($data='')
  {
    $this->db->trans_begin();
    $this->db->where('id',$data['id']);
    $this->db->update($this->table, $data);
    if($this->db->trans_status() === true)
    {
      $this->db->trans_commit();
      return true;
    }
    else
    {
      $this->db->trans_rollback();
      return false;
    }
  }
  public function delete($id='')
  {
    $this->db->trans_begin();
    $this->db->where('id',$id);
    $this->db->delete($this->table);
    if($this->db->trans_status() === true)
    {
      $this->db->trans_commit();
      return true;
    }
    else
    {
      $this->db->trans_rollback();
      return false;
    }
  }
  public function findByCreator($creator_id='')
  {
    return $this->db->where('creator_id',$creator_id)->get($this->table)->row();
  }
  public function findAssingUsers()
  {
    $query = "select a.user_id, b.NAME user_nama 
    from cmms_position a
    inner join m_user b on a.user_id = b.ID_USER
    where a.portal_rule in (1,2) "; 
    return $this->db->query($query);
  }
}