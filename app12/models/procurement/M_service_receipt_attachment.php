<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_service_receipt_attachment extends M_base {

    protected $table = 't_service_receipt_attachment';
    protected $fillable = array('file', 'description','created_by', 'created_date','id_service_receipt');

    public function view_attachment() {
        $this->db->select('t_service_receipt_attachment.*, m_user.NAME as creator')
        ->join('m_user', 'm_user.ID_USER = t_service_receipt_attachment.created_by');
    }
}