<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_service_receipt extends M_base {

    protected $table = 't_service_receipt';
    protected $fillable = array('id_itp', 'service_receipt_no', 'receipt_date', 'id_currency', 'subtotal', 'id_currency_base', 'subtotal_base', 'note', 'status', 'accept', 'cancel', 'accepted_at');
    protected $authors = true;
    protected $timestamps = true;

    public function view_service_receipt() {
        $this->db->select('t_service_receipt.*, t_itp.itp_no, t_itp.no_po, currency.CURRENCY as currency, currency_base.CURRENCY as currency_base, m_vendor.NAMA as vendor, m_user.USERNAME as username, m_user.NAME as creator, m_company.DESCRIPTION as company')
        ->join('t_itp', 't_itp.id_itp = t_service_receipt.id_itp')
        ->join('t_purchase_order', 't_purchase_order.po_no = t_itp.no_po')
        ->join('t_bl_detail', 't_bl_detail.id = t_purchase_order.bl_detail_id')
        ->join('m_currency currency', 'currency.ID = t_service_receipt.id_currency')
        ->join('m_currency currency_base', 'currency_base.ID = t_service_receipt.id_currency_base')
        ->join('t_msr', 't_msr.msr_no = t_purchase_order.msr_no')
        ->join('m_company', 'm_company.ID_COMPANY = t_msr.id_company')
        ->join('m_vendor', 'm_vendor.ID = t_itp.id_vendor')
        ->join('m_user', 'm_user.ID_USER = t_service_receipt.created_by');
    }

    public function scope_approval_completed() {
        $this->db->where('(SELECT COUNT(1) FROM t_approval_service_receipt WHERE t_approval_service_receipt.id_ref = t_service_receipt.id AND (status = 0 OR status = 2)) = ', 0);
    }

    public function scope_auth_vendor() {
        $this->db->where('t_itp.id_vendor', $this->session->userdata('ID'));
    }

    public function scope_unaccepted() {
        $this->db->where('t_service_receipt.accept', '0');
    }

    public function scope_accepted() {
        $this->db->where('t_service_receipt.accept', '1');
    }

    public function generate_no($id_company) {
        $no_columns = 'service_receipt_no';
        $format = '{y}0'.substr($id_company, -1).':4';
        $parse = explode(':', $format);
        $prefix = str_replace(array('{y}', '{Y}', '{m}', '{d}'), array(date('y'), date('Y'), date('m'), date('d')), $parse[0]);
        $digit = str_repeat('0', $parse[1]);
        $this->db->where('left('.$no_columns.', '.(strlen($prefix)).') = ', $prefix);
        $last_id =  $this->db->select_max($no_columns)
        ->get($this->table)->row()->{$no_columns};
        if ($last_id) {
            $counter = substr($last_id, -strlen($digit)) + 1;
            return $prefix.substr($digit.$counter, -strlen($digit));
        } else {
            return $prefix.substr($digit.'1', -strlen($digit));
        }
    }
}