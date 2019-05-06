<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_nego_detail extends M_base {

    protected $table = 't_nego_detail';

    public function view_negotiation_item() {
        $this->db->select('t_sop.*, t_nego_detail.latest_price, t_nego_detail.negotiated_price, t_nego_detail.id_currency, t_nego_detail.id_currency_base, t_nego_detail.nego, t_msr_item.priceunit, m_itemtype.ITEMTYPE_DESC as item_type, t_sop_bid.unit_price as bid_price, t_sop_bid.nego_price, m_currency.CURRENCY as currency')
        ->join('t_sop', 't_sop.id = t_nego_detail.sop_id')
        ->join('t_sop_bid', 't_sop_bid.sop_id = t_nego_detail.sop_id AND t_sop_bid.vendor_id = t_nego_detail.vendor_id')
        ->join('t_msr_item', 't_msr_item.line_item = t_sop.msr_item_id AND t_msr_item.msr_no = t_sop.msr_no')
        ->join('m_itemtype', 'm_itemtype.ID_ITEMTYPE = t_msr_item.id_itemtype')
        ->join('m_currency', 'm_currency.ID = t_nego_detail.id_currency');
    }
}