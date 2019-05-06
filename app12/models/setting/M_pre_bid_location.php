<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_pre_bid_location extends M_base {

    protected $table = 'm_pre_bid_location';
    protected $fillable = array('nama', 'alamat', 'active', 'created_at');    
}