<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_arf_detail extends M_base {

    protected $table = 't_arf_detail';
    protected $fillable = array('doc_id', 'semic_no', 'material_desc', 'material_classification', 'material_category', 'id_item_type', 'item_type', 'id_item_type_category', 'item_type_category', 'id_inventory_type', 'inventory_type', 'item_modification', 'id_importation', 'id_delivery_point', 'delivery_point', 'id_costcenter', 'costcenter', 'id_account_subsidiary', 'account_subsidiary', 'qty', 'uom', 'id_currency', 'id_currency_base', 'unit_price', 'unit_price_base', 'is_tax', 'tax', 'tax_base', 'total_price', 'total_price_base');

    public function view_item() {
        $this->db->select('t_arf_detail.*, m_material_uom.DESCRIPTION as uom_desc')
        ->join('m_material_uom', 'm_material_uom.MATERIAL_UOM = t_arf_detail.uom');
    }

    public function view_po_item() {
        $this->db->select('t_arf_detail.*, m_material_uom.DESCRIPTION as uom_desc, t_purchase_order_detail.id as po_item_id')
        ->join('t_arf', 't_arf.id = t_arf_detail.doc_id')
        ->join('m_material_uom', 'm_material_uom.MATERIAL_UOM = t_arf_detail.uom')
        ->join('t_purchase_order', 't_purchase_order.po_no = t_arf.po_no', 'left')
        ->join('m_material_uom', 'm_material_uom.MATERIAL_UOM = t_arf_detail.uom')
        ->join('t_purchase_order_detail', 't_purchase_order_detail.po_id = t_purchase_order.id AND t_purchase_order_detail.semic_no = t_arf_detail.semic_no', 'left');
    }

    public function scope_not_exists_on_po() {
        $this->db->join('t_arf', 't_arf.id = t_arf_detail.doc_id')
        ->where('NOT EXISTS (
            SELECT semic_no
            FROM t_purchase_order_detail
            JOIN t_purchase_order ON t_purchase_order.id = t_purchase_order_detail.po_id
            WHERE semic_no = t_arf_detail.semic_no AND t_purchase_order.po_no = t_arf.po_no AND material_desc = t_arf_detail.material_desc)')
        ->where('t_arf_detail.id_item_type', 'GOODS');
    }
    public function getDetails($doc_id='')
    {
        $rs = $this->db->where('doc_id',$doc_id)->get($this->table)->result(); return $rs;
    }
}