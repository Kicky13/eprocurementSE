<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_note extends M_base {

    protected $table = 't_note';
    protected $fillable = array('module_kode', 'data_id', 'description', 'path');
    protected $authors = true;
}