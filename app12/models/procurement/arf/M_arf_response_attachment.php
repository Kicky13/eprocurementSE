<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_arf_response_attachment extends M_base {

    protected $table = 't_arf_response_attachment';
    protected $fillable = array('doc_id', 'type', 'file');

    public function enum_type() {
        return array(
            'Justification Document' => 'Justification Document',
            'Risk Assessment' => 'Risk Assessment',
            'other' => 'Other'
        );
    }
}