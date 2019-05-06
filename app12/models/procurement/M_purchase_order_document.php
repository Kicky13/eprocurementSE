<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_purchase_order_document extends MY_Model {
    const TYPE_PERFORMANCE_BOND = '1';
    const TYPE_INSURANCE = '2';
    const TYPE_OTHER = '3';

    protected $types = array(
        self::TYPE_PERFORMANCE_BOND     => 'Performance Bond',
        self::TYPE_INSURANCE            => 'Insurance',
        self::TYPE_OTHER                => 'Other'
    );

    protected $table = 't_purchase_order_document';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('procurement/M_purchase_order')
            ->model('procurement/M_purchase_order_required_doc');
    }

    public function getTypes($type = NULL)
    {
        if ($type == NULL) {
            return $this->types;
        }

        if (array_key_exists($type, $this->types)) {
            return $this->types[$type];
        }

        return null;
    }

    public function add($data)
    {
        // due to every field has NULL as default value
        foreach($data as &$d) {
            $d = $d ?: NULL;
        }

        $user_id = $this->session->userdata('ID') ?: $this->session->userdata('ID_USER');
        $data['create_by'] = $user_id; 
        $data['create_on'] = today_sql();

        parent::add($data);
    }

    public function findByPOId($po_id, $doc_type = null)
    {
        $this->db->where('po_id', $po_id);

        if ($doc_type) {
            $this->db->where('doc_type', $doc_type);
        }
        
        return $this->db->get($this->table)->result();
    }

    public function findByPONo($po_no, $doc_type = null) {
        $po_table = $this->M_purchase_order->getTable();
        $po_doc_table = $this->M_purchase_order_required_doc->getTable();

        if ($doc_type) {
            $this->db->where('doc_type', $doc_type);
        }

        return $this->db->from($this->table)
            ->join($po_doc_table, "$po_doc_table.po_id = {$this->table}.id")
            ->join($po_table, "$po_table.id = {$this->table}.id")
            ->where("$po_table.po_no", $po_no)
            ->get()
            ->result();
    }
}

/* vim: set fen foldmethod=indent ts=4 sw=4 tw=4 et autoindent :*/
