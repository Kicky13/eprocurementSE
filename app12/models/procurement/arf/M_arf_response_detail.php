<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_arf_response_detail extends M_base {

    protected $table = 't_arf_response_detail';
    protected $fillable = array('doc_no', 'detail_id', 'currency_id', 'currency_base_id', 'qty1', 'qty2', 'unit_price', 'unit_price_base', 'is_tax', 'tax', 'tax_base', 'total', 'total_base');
}