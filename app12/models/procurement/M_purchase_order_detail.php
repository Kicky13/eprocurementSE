<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_purchase_order_detail extends MY_Model
{
    protected $table = 't_purchase_order_detail';

    public function __construct()
    {
        parent::__construct();
    }

    public function all()
    {
        return $this->db->get($this->table)->result();
    }

    public function find($id)
    {
        return $this->db->where('id', $id)->get($this->table)->result()[0];
    }

    public function findByPOId($po_id)
    {
        $this->load->model("procurement/M_msr_item");
        $t_msr_item = $this->M_msr_item->getTable();

        // TODO: Complete join to t_purchase_order
        return $this->db->select([
            "$t_msr_item.id_costcenter",
            "$t_msr_item.costcenter_desc",
            "$t_msr_item.id_accsub",
            "$t_msr_item.accsub_desc",
            "$t_msr_item.is_asset",
            "m_material_uom.DESCRIPTION as uom_description",
            "$this->table.*",
            ])
            ->select("$this->table.est_unitprice * $this->table.qty as est_total_price", false)
            ->select("$this->table.unitprice * $this->table.qty as total_price", false)
            ->join($t_msr_item, "$t_msr_item.line_item = $this->table.msr_item_id")
            ->join("m_material_uom", "m_material_uom.MATERIAL_UOM = $this->table.uom_desc")
            ->where('po_id', $po_id)
            ->get($this->table)
            ->result();
    }

    // TODO: add findByPONo($po_no)


    public function getFromED($bl_detail_id)
    {
        $this->load->model('approval/M_bl');

        $t_bl = $this->M_bl->tbl;
        $t_bl_detail = $this->M_bl->tbld;
        $t_msr= $this->M_bl->tbmsr;
        $t_msr_item = $this->M_bl->tbmi;
        $t_bid_detail = $this->M_bl->tbdd;
        $t_eq_data = $this->M_bl->tbeq;
        $t_sop = 't_sop';
        $t_sop_bid = 't_sop_bid';

        $this->db->select([
            "{$t_bl}.id bl_id",
            "{$t_bl}.msr_no",
            "{$t_bl}.bled_no",
            "{$t_bl_detail}.id bl_detail_id",
            "{$t_bl_detail}.vendor_id",
            "{$t_bid_detail}.id bid_detail_id",
            "{$t_bid_detail}.id bid_detail_id",
            "{$t_sop}.id sop_id",
            "{$t_sop}.msr_item_id as msr_item_id",
            "{$t_sop}.sop_type",
            "{$t_sop}.item as item_desc",

            "0 as qty",
            "{$t_sop}.qty1",
            "{$t_sop}.uom1",
            "{$t_sop}.qty2",
            "{$t_sop}.uom2",
            "'' as uom",
            "{$t_sop}.item_material_id as material_id",
            "{$t_sop}.item as material_desc",
            "{$t_sop}.item_semic_no_value as semic_no",
            "{$t_sop}.id_itemtype",
            "{$t_sop}.id_itemtype_category",
            "{$t_sop}.id_costcenter",
            "{$t_sop}.costcenter_desc",
            "{$t_sop}.id_accsub",
            "{$t_sop}.accsub_desc",
            "{$t_sop}.groupcat",
            "{$t_sop}.groupcat_desc",
            "{$t_sop}.sub_groupcat",
            "{$t_sop}.sub_groupcat_desc",
            "{$t_sop}.inv_type as id_msr_inv_type",
            "{$t_sop}.item_modification as is_modification",
            // "{$t_msr_item}.qty",
            // "{$t_msr_item}.uom_id",
            // "{$t_msr_item}.uom",

            "{$t_sop_bid}.id sop_bid_id",
            "{$t_sop_bid}.id_currency",
            "{$t_sop_bid}.id_currency_base",
            // estimated unit price
            "{$t_msr_item}.priceunit as est_unitprice",
            "0 as est_unitprice_base", // dummy value, count later!
            // estimated total price
            "0 as est_total_price",
            "0 as est_total_price_base", // dummy value, count later!
            // unit price
            "IF ({$t_sop_bid}.nego_price, {$t_sop_bid}.nego_price, {$t_sop_bid}.unit_price) unitprice",
            "IF ({$t_sop_bid}.nego_price_base, {$t_sop_bid}.nego_price_base, {$t_sop_bid}.unit_price_base) unitprice_base",
            // nego price
            "{$t_sop_bid}.nego_price",
            "{$t_sop_bid}.nego_price_base",
            // total price
            "0 as total_price",
            "0 as total_price_base",

            ])
            ->from($t_bl_detail)
            ->join($t_bl, "{$t_bl}.msr_no = {$t_bl_detail}.msr_no")
            ->join($t_eq_data, "{$t_eq_data}.msr_no = {$t_bl_detail}.msr_no")
            ->join($t_bid_detail, "{$t_bid_detail}.bled_no = {$t_bl}.bled_no
                AND {$t_bid_detail}.created_by = {$t_bl_detail}.vendor_id")
            ->join($t_sop, "{$t_sop}.msr_no = {$t_bl}.msr_no
                AND {$t_sop}.msr_item_id = {$t_bid_detail}.msr_detail_id")
            ->join($t_sop_bid, "{$t_sop_bid}.sop_id = {$t_sop}.id
                AND {$t_sop_bid}.msr_no = {$t_bl}.msr_no
                AND {$t_sop_bid}.vendor_id = {$t_bl_detail}.vendor_id")
            ->join($t_msr_item, "{$t_msr_item}.line_item = {$t_sop}.msr_item_id")
            ->where("{$t_bl_detail}.id", $bl_detail_id)
            ->where("{$t_eq_data}.award", 9)
            ->where("{$t_bl_detail}.awarder", 1)
            ->where("{$t_bl_detail}.commercial", 1)
            // ->where("{$t_bl_detail}.accept_award", 1)
            // ->where("{$t_bid_detail}.award", 1)
            ->where("{$t_sop_bid}.award", 1);

        // $this->db->select("{$t_msr_item}.priceunit * {$t_msr_item}.qty as est_total_price", false);
        // $this->db->select("{$t_bid_detail}.unit_price * {$t_msr_item}.qty as total_price", false);

        return $this->db->get()->result();
    }
}
