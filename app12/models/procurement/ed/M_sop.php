<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_sop extends M_base {

    protected $table = 't_sop';
    protected $fillable = array('msr_item_id', 'msr_no', 'sop_type', 'item_material_id', 'item_semic_no_value', 'item', 'id_itemtype', 'id_itemtype_category', 'groupcat', 'groupcat_desc', 'sub_groupcat', 'sub_groupcat_desc', 'inv_type', 'item_modification', 'id_costcenter', 'costcenter_desc', 'id_accsub', 'accsub_desc', 'qty1', 'uom1', 'qty2', 'uom2', 'tax');
    protected $timestamps = true;
    protected $authors = true;

    public function view_sop() {
        $this->db->select('t_sop.*, t_msr_item.description as msr_item, m_msr_inventory_type.description as inv_type_desc')
        ->join('t_msr_item', 't_msr_item.line_item = t_sop.msr_item_id')
        ->join('m_msr_inventory_type', 'm_msr_inventory_type.id = t_sop.inv_type', 'left');
    }
}