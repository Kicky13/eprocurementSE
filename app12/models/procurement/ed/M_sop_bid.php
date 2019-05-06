<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_sop_bid extends M_base {

    protected $table = 't_sop_bid';
    protected $fillable = array('sop_id', 'msr_no', 'vendor_id', 'id_currency', 'unit_price', 'nego_price', 'id_currency_base', 'unit_price_base', 'nego_price_base', 'remark', 'qty');
    protected $timestamps = true;
    protected $authors = true;
}