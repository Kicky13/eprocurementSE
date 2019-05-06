<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_purchase_order_required_doc extends MY_Model
{
    protected $table = 't_purchase_order_required_doc';

    public function getByPOId($po_id)
    {
        return @$this->db->where('po_id', $po_id)->get($this->table)->result();
    }
}
