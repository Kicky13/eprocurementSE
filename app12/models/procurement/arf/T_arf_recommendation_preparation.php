<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class T_arf_recommendation_preparation extends CI_Model {
	public function __construct() {
      parent::__construct();
      $this->db = $this->load->database('default', true);
      $this->table = 't_arf_recommendation_preparation';
  }
  public function view($id='')
  {
  	$r = $this->db->where(['arf_response_id'=>$id])->get($this->table)->row();
  	$data['new_date_1'] = $r ? dateToIndo($r->new_date_1) : '';
    $data['new_date_2'] = $r ? dateToIndo($r->new_date_2) : '';
    $data['remarks_1'] = $r ? $r->remarks_1 : '';
    $data['remarks_2'] = $r ? $r->remarks_2 : '';
    $data['extend1'] = $r ? $r->extend1 : '';
  	$data['extend2'] = $r ? $r->extend2 : '';
    $data['recom'] = $r;
  	return $data;
  }
  public function nego_lists($arf_response_id)
  {
    $sql = "select t_arf_nego.* from 
    t_arf_response
    join t_arf_nego on t_arf_response.id = t_arf_nego.arf_response_id
    where t_arf_response.id = $arf_response_id";
    $arfNegos = $this->db->query($sql)->result();
    $sql = "select t_arf_nego_detail.*, t_arf_sop.item, (case when t_arf_sop.qty2 > 0 then qty2*qty1 else qty1 end) qty, (case when uom2 != '' then concat(uom1,' & ',uom2) else uom1 end) uom from 
    t_arf_response
    left join t_arf_nego on t_arf_response.id = t_arf_nego.arf_response_id
    left join t_arf_nego_detail on t_arf_nego_detail.arf_nego_id = t_arf_nego.id and t_arf_response.id = t_arf_nego_detail.arf_response_id
    left join t_arf_sop on t_arf_sop.id = t_arf_nego_detail.arf_sop_id
    where t_arf_response.id = $arf_response_id";
    $arfNegoDetails = $this->db->query($sql)->result();
    return ['arfNegos'=>$arfNegos, 'arfNegoDetails'=>$arfNegoDetails];
  }
  public function find($id='')
  {
    return $this->db->where('id', $id)->get($this->table)->row();
  }
}