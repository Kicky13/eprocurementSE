<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_service_receipt_detail extends M_base {

    protected $table = 't_service_receipt_detail';
    protected $fillable = array('id_service_receipt', 'id_itp', 'id_material', 'qty', 'id_currency', 'price', 'total', 'id_currency_base', 'price_base', 'total_base', 'note');

    public function view_service_receipt_detail() {
        $this->db->select('
            t_service_receipt_detail.*,
            t_sop.item as material,
        ')
        ->join('t_itp', 't_itp.id_itp = t_service_receipt_detail.id_itp')
        ->join('t_purchase_order', 't_purchase_order.po_no = t_itp.no_po')
        ->join('t_purchase_order_detail', 't_purchase_order_detail.po_id = t_purchase_order.id AND t_purchase_order_detail.sop_bid_id = t_service_receipt_detail.id_material')
        ->join('t_sop_bid', 't_sop_bid.id = t_purchase_order_detail.sop_bid_id')
        ->join('t_sop', 't_sop.id = t_sop_bid.sop_id');
    }
}