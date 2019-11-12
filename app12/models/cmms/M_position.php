<?php if (!defined('BASEPATH')) exit('Anda tidak masuk dengan benar');

class M_position extends CI_Model {

  public function __construct() {
    parent::__construct();    
    $this->table = 'cmms_position';
  }
  public function index_list()
  {
  	return $this->db->query("select a.id, b.NAME user_name, d.NAME parent_name, a.portal_rule, a.title
      from cmms_position a 
      left join m_user b on a.user_id  = b.ID_USER 
      left join cmms_position c on a.parent_id = c.id 
      left join m_user d on c.user_id = d.ID_USER 
      order by a.id desc
      ")->result();
  }
  public function form_user_1($id='')
  {
  	return $this->db->query("select * from m_user where id_user not in (1) and id_user not in (select user_id from cmms_position)");
  }
  public function form_user($id='')
  {
  	return $this->db->query("select * from m_user where id_user = $id ");
  }
  public function form_row($id='')
  {
  	return $this->db->where('id',$id)->get('cmms_position')->row();
  }
  public function form_parent()
  {
  	return $this->db->query("select cmms_position.id, m_user.NAME  from m_user LEFT JOIN cmms_position on m_user.ID_USER = cmms_position.user_id where id_user in (select user_id from cmms_position where portal_rule in (1,2))");
  }
}