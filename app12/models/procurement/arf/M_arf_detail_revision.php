<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_arf_detail_revision extends M_base {

    protected $table = 't_arf_detail_revision';
    protected $fillable = array('doc_id', 'type', 'value', 'remark');

    public function detail_revision($arf='')
    {
    	return $this->db->select('t_arf_detail_revision.*')
        ->join('t_arf_detail_revision','t_arf_detail_revision.doc_id = t_arf.id')
        ->where(['po_no <='=>$arf->doc_no, 't_arf_detail_revision.type'=>'time'])
        ->order_by('t_arf_detail_revision.value','desc')->get('t_arf');
    }
    public function time_revision($doc_no='')
    {
    	return $this->db->select('t_arf_detail_revision.*')
        ->join('t_arf_detail_revision','t_arf_detail_revision.doc_id = t_arf.id')
        ->where(['t_arf.doc_no'=>$doc_no, 't_arf_detail_revision.type'=>'time'])
        ->order_by('t_arf_detail_revision.value','desc')->get('t_arf');
    }
}