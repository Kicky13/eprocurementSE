<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_service_receipt_itp extends M_base {

    protected $table = 't_itp';
    protected $primary_key = 'id_itp';

    public function view_total_receipt_po() {
        $this->db->select('
            t_purchase_order.id_currency,
            t_purchase_order.id_currency_base,
            receipt.itp_total,
            receipt.sr_total,
            receipt.total_receipt
        ')
        ->join('t_purchase_order', 't_purchase_order.po_no = t_itp.no_po')
        ->join('(
            SELECT
                receipt.no_po,
                SUM(itp_total) as itp_total,
                SUM(sr_total) as sr_total,
                SUM(total_receipt) as total_receipt
            FROM (
                SELECT
                    a.no_po,
                    b.material_id,
                    SUM(b.qty) as itp_qty,
                    SUM(b.total) as itp_total,
                    SUM(c.qty) as sr_qty,
                    SUM(c.total) as sr_total,
                    SUM(
                        CASE WHEN b.total > COALESCE(c.total,0) THEN b.qty
                        ELSE c.qty
                        END
                    ) AS qty_receipt,
                    SUM(
                        CASE WHEN b.total > COALESCE(c.total,0) THEN b.total
                        ELSE c.total
                        END
                    ) AS total_receipt
                FROM t_itp a
                JOIN t_itp_detail b ON b.id_itp = a.id_itp
                LEFT JOIN (
                    SELECT t_service_receipt_detail.id_itp, t_service_receipt_detail.id_material, SUM(qty) as qty, SUM(total) as total FROM t_service_receipt_detail
                    JOIN t_service_receipt ON t_service_receipt.id = t_service_receipt_detail.id_service_receipt
                    WHERE t_service_receipt.cancel = 0
                    GROUP BY t_service_receipt_detail.id_itp, t_service_receipt_detail.id_material
                )  c ON c.id_itp = b.id_itp AND c.id_material = b.material_id
                GROUP BY a.no_po, b.material_id
            ) receipt
            GROUP BY receipt.no_po
        ) receipt', 'receipt.no_po = t_purchase_order.po_no');
        /*$this->db->select('
            t_purchase_order.id_currency,
            t_purchase_order.id_currency_base,
            SUM(COALESCE(itp_receipt.itp_total, 0)) as itp_total,
            SUM(COALESCE(itp_receipt.sr_total, 0)) as sr_total,
            SUM(COALESCE(itp_receipt.total_receipt, 0)) as total_receipt,
        ')
        ->join('(
            SELECT
                t_itp.id_itp,
                SUM(t_itp_detail.total) as itp_total,
                (SELECT SUM(subtotal) FROM t_service_receipt WHERE t_service_receipt.id_itp = t_itp.id_itp AND t_service_receipt.cancel = 0) as sr_total,
                (
                    CASE
                        WHEN SUM(t_itp_detail.total) >= (SELECT COALESCE(SUM(subtotal),0) FROM t_service_receipt WHERE t_service_receipt.id_itp = t_itp.id_itp AND t_service_receipt.cancel = 0) THEN SUM(t_itp_detail.total)
                        ELSE (SELECT SUM(subtotal) FROM t_service_receipt WHERE t_service_receipt.id_itp = t_itp.id_itp AND t_service_receipt.cancel = 0)
                    END
                ) total_receipt
            FROM
                t_itp
            JOIN t_itp_detail ON t_itp_detail.id_itp = t_itp.id_itp
            GROUP BY t_itp.id_itp
        ) itp_receipt', 'itp_receipt.id_itp = t_itp.id_itp', 'left')
        ->join('t_purchase_order', 't_purchase_order.po_no = t_itp.no_po')
        ->GROUP_BY(array(
            't_itp.no_po',
            't_purchase_order.id_currency',
            't_purchase_order.id_currency_base'
        ));*/
    }

    public function view_total_receipt() {
        $this->db->select('
            t_itp.id_itp,
            t_itp.no_po,
            t_purchase_order.id_currency,
            t_purchase_order.id_currency_base,
            SUM(t_itp_detail.total) as itp_total,
            (SELECT SUM(subtotal) FROM t_service_receipt WHERE t_service_receipt.id_itp = t_itp.id_itp AND t_service_receipt.cancel = 0) as sr_total,
            (
                CASE
                    WHEN SUM(t_itp_detail.total) >= (SELECT COALESCE(SUM(subtotal),0) FROM t_service_receipt WHERE t_service_receipt.id_itp = t_itp.id_itp AND t_service_receipt.cancel = 0) THEN SUM(t_itp_detail.total)
                    ELSE (SELECT SUM(subtotal) FROM t_service_receipt WHERE t_service_receipt.id_itp = t_itp.id_itp AND t_service_receipt.cancel = 0)
                END
            ) total_receipt
        ')
        ->join('t_itp_detail', 't_itp_detail.id_itp = t_itp.id_itp')
        ->join('t_purchase_order', 't_purchase_order.po_no = t_itp.no_po')
        ->group_by(array(
            't_itp.id_itp',
            't_itp.no_po',
            't_purchase_order.id_currency',
            't_purchase_order.id_currency_base',
        ));
    }

    public function scope_vendor_accept() {
        $this->db->where('is_vendor_acc', 1);
    }

    public function scope_approved() {
        $this->db->where('(SELECT COUNT(1) FROM t_approval_itp WHERE t_approval_itp.id_itp = t_itp.id_itp AND (t_approval_itp.status_approve = 0 OR t_approval_itp.status_approve = 2)) = 0', null, false);
    }

    public function view_service_receipt_itp() {
        $this->db->select('
            t_itp.id_itp, m_company.DESCRIPTION as company, t_msr.department_desc as department, t_itp.itp_no, t_itp.id_vendor, t_itp.no_po, t_itp.note, t_itp.created_by, t_itp.dated, t_itp.is_vendor_acc, t_msr.id_company, t_purchase_order.id_currency, t_purchase_order.id_currency_base, currency.CURRENCY as currency, currency_base.CURRENCY as currency_base, SUM(total_price) as total, SUM(total_price_base) as total_base, m_vendor.NAMA as vendor, m_user.USERNAME as username, m_user.NAME as creator,
            (SELECT SUM(total) FROM t_itp_detail a WHERE a.id_itp=t_itp.id_itp) as itp_total,
            (
                SELECT SUM(total) FROM t_service_receipt_detail a
                JOIN t_service_receipt b ON b.id = a.id_service_receipt
                WHERE a.id_itp=t_itp.id_itp
                AND b.cancel = 0
            ) as sr_total,
        ')
        ->join('t_purchase_order', 't_purchase_order.po_no = t_itp.no_po')
        ->join('t_purchase_order_detail', 't_purchase_order_detail.po_id = t_purchase_order.id')
        ->join('t_bl_detail', 't_bl_detail.id = t_purchase_order.bl_detail_id')
        ->join('t_msr', 't_msr.msr_no = t_purchase_order.msr_no')
        ->join('m_company', 'm_company.ID_COMPANY = t_msr.id_company')
        ->join('m_vendor', 'm_vendor.ID = t_itp.id_vendor')
        ->join('m_currency currency', 'currency.ID = t_purchase_order.id_currency')
        ->join('m_currency currency_base', 'currency_base.ID = t_purchase_order.id_currency_base')
        ->join('m_user', 'm_user.ID_USER = t_itp.created_by')
        ->group_by(array('m_company.DESCRIPTION', 't_msr.department_desc','t_itp.id_itp', 't_itp.itp_no', 't_itp.id_vendor', 't_itp.no_po', 't_itp.note', 't_itp.created_by', 't_itp.dated', 't_itp.is_vendor_acc', 't_msr.id_company', 't_purchase_order.id_currency', 't_purchase_order.id_currency_base', 'currency.CURRENCY', 'currency_base.CURRENCY', 'm_vendor.NAMA', 'm_user.USERNAME', 'm_user.NAME'));
    }
}