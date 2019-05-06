<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_arf_po_detail extends M_base {

    protected $table = 't_purchase_order_detail';

    public function view_po_detail() {
        $this->db->select('
            t_purchase_order_detail.id_itemtype as id_item_type,
            m_itemtype.ITEMTYPE_DESC as item_type,
            t_sop.id_itemtype_category as id_item_type_category,
            m_itemtype_category.description as item_type_category,
            t_purchase_order_detail.semic_no,
            t_purchase_order_detail.material_desc,
            t_sop.groupcat as id_classification,
            t_sop.groupcat_desc as classification,
            t_sop.sub_groupcat as id_category,
            t_sop.sub_groupcat_desc as category,
            t_purchase_order_detail.qty,
            t_purchase_order_detail.uom_desc as uom,
            m_material_uom.DESCRIPTION as uom_desc,
            t_purchase_order_detail.est_unitprice as unit_price,
            t_purchase_order_detail.est_unitprice_base as unit_price_base,
            t_purchase_order_detail.est_total_price,
            t_purchase_order_detail.est_total_price_base,
            t_purchase_order_detail.unitprice as unit_price,
            t_purchase_order_detail.unitprice_base,
            t_purchase_order_detail.total_price,
            t_purchase_order_detail.total_price_base,
            t_sop.inv_type as id_inventory_type,
            m_msr_inventory_type.description as inventory_type,
            t_sop.item_modification,
            t_sop.id_costcenter,
            t_sop.costcenter_desc as costcenter,
            t_sop.id_accsub as id_account_subsidiary,
            t_sop.accsub_desc as account_subsidiary,
            t_msr_item.id_importation,
            t_msr_item.id_dpoint as id_delivery_point
        ')
        ->join('t_msr_item', 't_msr_item.line_item = t_purchase_order_detail.msr_item_id')
        ->join('t_sop_bid', 't_sop_bid.id = t_purchase_order_detail.sop_bid_id')
        ->join('t_sop', 't_sop.id = t_sop_bid.sop_id')
        ->join('m_itemtype', 'm_itemtype.ID_ITEMTYPE = t_purchase_order_detail.id_itemtype')
        ->join('m_itemtype_category', 'm_itemtype_category.id = t_sop.id_itemtype_category')
        ->join('m_material_uom', 'm_material_uom.MATERIAL_UOM = t_purchase_order_detail.uom_desc')
        ->join('m_msr_inventory_type', 'm_msr_inventory_type.id = t_sop.inv_type','left');
    }

    public function enum_type() {
        return array(
            10 => 'PO',
            20 => 'SO',
            30 => 'Blanket',
            40 => 'Contracts'
        );
    }
}