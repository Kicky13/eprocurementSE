<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_arf_sop extends M_base {

    protected $table = 't_arf_sop';
    protected $fillable = array('line_no');

    public function view_sop() {
        $this->db->select('
            t_arf_sop.*,
            t_arf_detail.unit_price,
            m_itemtype.ITEMTYPE_DESC as item_type,
            m_msr_inventory_type.code as inventory_type_code,
            m_msr_inventory_type.description as inventory_type,
            t_purchase_order_detail.id as po_item_id,
            m_gl_class.vat,
            COALESCE(m_line_type.code, IF(t_arf_sop.item_modification = 1, \'I\',\'J\')) as line_type_code
        ')
        ->join('t_arf_detail', 't_arf_detail.id = t_arf_sop.arf_item_id')
        ->join('t_arf', 't_arf.id = t_arf_detail.doc_id')
        ->join('m_itemtype', 'm_itemtype.ID_ITEMTYPE = t_arf_sop.id_itemtype')
        ->join('m_msr_inventory_type', 'm_msr_inventory_type.id = t_arf_sop.inv_type','left')
        ->join('t_purchase_order', 't_purchase_order.po_no = t_arf.po_no', 'left')
        ->join('t_purchase_order_detail', 't_purchase_order_detail.po_id = t_purchase_order.id AND t_purchase_order_detail.semic_no = t_arf_sop.item_semic_no_value AND t_purchase_order_detail.material_desc = t_arf_sop.item', 'left')
        ->join('m_material', 'm_material.MATERIAL_CODE = t_arf_sop.item_semic_no_value', 'left')
        ->join('m_gl_class', 'm_gl_class.id = m_material.GL_CLASS', 'left')
        ->join('m_line_type', 'm_line_type.id = m_material.LINE_TYPE', 'left');

    }

     public function view_response() {
        $this->db->select('
            t_arf_sop.*,
            t_arf_detail.unit_price,
            t_arf_response_detail.qty1 as response_qty1,
            t_arf_response_detail.qty2 as response_qty2,
            t_arf_response_detail.unit_price as response_unit_price,
            t_arf_response_detail.unit_price_base as response_unit_price_base,
            m_itemtype.ITEMTYPE_DESC as item_type,
            m_msr_inventory_type.code as inventory_type_code,
            m_msr_inventory_type.description as inventory_type,
            t_purchase_order_detail.id as po_item_id,
            m_gl_class.vat,
            COALESCE(m_line_type.code, IF(t_arf_sop.item_modification = 1, \'I\',\'J\')) as line_type_code
        ')
        ->join('t_arf_response_detail', 't_arf_response_detail.detail_id = t_arf_sop.id', 'left')
        ->join('t_arf_detail', 't_arf_detail.id = t_arf_sop.arf_item_id', 'left')
        ->join('t_arf', 't_arf.id = t_arf_detail.doc_id', 'left')
        ->join('m_itemtype', 'm_itemtype.ID_ITEMTYPE = t_arf_sop.id_itemtype', 'left')
        ->join('m_msr_inventory_type', 'm_msr_inventory_type.id = t_arf_sop.inv_type','left')
        ->join('t_purchase_order', 't_purchase_order.po_no = t_arf.po_no', 'left')
        ->join('t_purchase_order_detail', 't_purchase_order_detail.po_id = t_purchase_order.id AND t_purchase_order_detail.semic_no = t_arf_sop.item_semic_no_value AND t_purchase_order_detail.material_desc = t_arf_sop.item', 'left')
        ->join('m_material', 'm_material.MATERIAL_CODE = t_arf_sop.item_semic_no_value', 'left')
        ->join('m_gl_class', 'm_gl_class.id = m_material.GL_CLASS', 'left')
        ->join('m_line_type', 'm_line_type.id = m_material.LINE_TYPE', 'left');
    }
    public function with_nego($value='')
    {
        /*left join t_arf_response b on a.arf_response_id = b.id */
        $this->db->select('t_arf_nego_detail.unit_price new_price')
        ->join('t_arf_nego_detail', 't_arf_sop.id = t_arf_nego_detail.arf_sop_id', 'left')
        ->join('(select * from t_arf_nego where status = 2 order by id desc limit 1) t_arf_nego','t_arf_nego.id = t_arf_nego_detail.arf_nego_id', 'left');
    }
}