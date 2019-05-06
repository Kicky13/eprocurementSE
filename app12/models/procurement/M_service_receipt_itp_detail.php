<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_service_receipt_itp_detail extends M_base {

    protected $table = 't_itp_detail';

    public function view_itp_detail() {
        $this->db->select('
            t_itp_detail.*,
            t_sop.item as material,
            (
                SELECT COALESCE(SUM(qty),0) FROM t_service_receipt_detail
                JOIN t_service_receipt ON t_service_receipt.id = t_service_receipt_detail.id_service_receipt
                WHERE t_service_receipt_detail.id_itp = t_itp_detail.id_itp
                AND t_service_receipt_detail.id_material = t_itp_detail.material_id
                AND t_service_receipt.cancel = 0
            ) as qty_spending,
            (
                SELECT COALESCE(SUM(total),0) FROM t_service_receipt_detail
                JOIN t_service_receipt ON t_service_receipt.id = t_service_receipt_detail.id_service_receipt
                WHERE t_service_receipt_detail.id_itp = t_itp_detail.id_itp
                AND t_service_receipt_detail.id_material = t_itp_detail.material_id
                AND t_service_receipt.cancel = 0
            ) as total_spending,
            (
                SELECT COALESCE(SUM(t_service_receipt_detail.qty), 0) FROM t_service_receipt_detail
                JOIN t_service_receipt ON t_service_receipt.id = t_service_receipt_detail.id_service_receipt
                WHERE t_service_receipt_detail.id_itp = t_itp_detail.id_itp AND t_service_receipt_detail.id_material = t_itp_detail.material_id
                AND t_service_receipt.id_external IS NOT NULL
            ) as qty_actual,
            (
                SELECT COALESCE(SUM(t_service_receipt_detail.total), 0) FROM t_service_receipt_detail
                JOIN t_service_receipt ON t_service_receipt.id = t_service_receipt_detail.id_service_receipt
                WHERE t_service_receipt_detail.id_itp = t_itp_detail.id_itp AND t_service_receipt_detail.id_material = t_itp_detail.material_id
                AND t_service_receipt.id_external IS NOT NULL
            ) as total_actual
        ')
        ->join('t_itp', 't_itp.id_itp = t_itp_detail.id_itp')
        ->join('t_purchase_order', 't_purchase_order.po_no = t_itp.no_po')
        ->join('t_purchase_order_detail', 't_purchase_order_detail.po_id = t_purchase_order.id AND t_purchase_order_detail.sop_bid_id = t_itp_detail.material_id')
        ->join('t_sop_bid', 't_sop_bid.id = t_purchase_order_detail.sop_bid_id')
        ->join('t_sop', 't_sop.id = t_sop_bid.sop_id');
    }
}