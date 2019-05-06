<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_arf_detail_reason extends M_base {

    protected $table = 't_arf_detail_reason';
    protected $fillable = array('doc_id', 'reason_id', 'description');
}