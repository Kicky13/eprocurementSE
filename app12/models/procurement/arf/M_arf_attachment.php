<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_arf_attachment extends M_base {

    protected $table = 't_arf_attachment';
    protected $fillable = array('doc_id', 'type', 'file_name', 'file');
    protected $authors = true;
    protected $timestamps = true;

    public function enum_type() {
        return array(
            'Owner Estimate' => 'Owner Estimate',
            'Scope of Work/Supply' => 'Scope of Work/Supply',
            'other' => 'Other'
        );
    }
}