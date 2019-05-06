<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_arf_notification_attachment extends M_base {

    protected $table = 't_arf_notification_upload';
    protected $fillable = array('doc_id', 'file_type', 'file_name', 'file_path', 'create_by', 'create_date');

    public function view_notification_attachment() {
        $this->db->select('t_arf_notification_upload.*, m_user.NAME as creator')
        ->join('m_user', 'm_user.ID_USER = t_arf_notification_upload.create_by');
    }
}