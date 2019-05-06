<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_log_ed extends M_base {

    protected $table = 'log_ed';
    protected $fillable = array('bled_no', 'description');
    protected $timestamps = true;
    protected $authors = true;
}