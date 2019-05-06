<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_purchase_order_attachment extends MY_Model
{
	const TYPE_DRAFT_PO = 'DRAFT_PO';
	const TYPE_SIGNED_PO = 'SIGNED_PO';
	const TYPE_COMPLETENESS_PO = 'CMPLT_PO';
	const TYPE_COUNTER_SIGNED_PO = 'CSIGNED_PO';

	protected $types = array(
        self::TYPE_DRAFT_PO  => 'Draft of Agreement',
        self::TYPE_SIGNED_PO  => 'Signed Agreement',
        self::TYPE_COMPLETENESS_PO => 'Completeness Agreement',
        self::TYPE_COUNTER_SIGNED_PO => 'Counter Signed Agreement',
    );

	protected $table = 't_upload';

	public function __construct()
	{
		parent::__construct();
	}

	public function getTypes()
	{
		return $this->types;
	}

	public function all()
	{
		$this->load->model('procurement/M_purchase_order');

		$this->db->where('module_kode', $this->M_purchase_order::module_kode)
			->get($this->table)
			->result();
	}

    public function getByMsrNo($msr_no)
    {

    }

    public function getByDocument($data_id, $type = null)
    {
        /*
        return $this->db->where('module_kode', $this->M_purchase_order::module_kode)
            ->where('data_id', $data_id)
            ->get($this->table)
            ->result();
        */

        $this->load->model('procurement/M_purchase_order')
            ->model('user/M_view_user');

        $user_table = $this->M_view_user->getTable();

        $this->db->select(["$this->table.*",
            "(
                CASE
                    WHEN $this->table.creator_type = 'vendor' THEN (SELECT ID_VENDOR FROM m_vendor WHERE ID = {$this->table}.created_by)
                    ELSE (SELECT ID FROM m_user WHERE ID_USER = {$this->table}.created_by)
                END
            ) as created_by_username",
            "(
                CASE
                    WHEN $this->table.creator_type = 'vendor' THEN (SELECT NAMA FROM m_vendor WHERE ID = {$this->table}.created_by)
                    ELSE (SELECT NAME FROM m_user WHERE ID_USER = {$this->table}.created_by)
                END
            ) as created_by_name"])
            ->from($this->table)
            ->where('module_kode', $this->M_purchase_order::module_kode)
            ->where('data_id', $data_id);

        if ($type) {
            if (!is_array($type)) {
                $type = array($type);
            }

            $this->db->where_in('tipe', $type);
        }

        $this->db->order_by('created_at');
        $attachments = $this->db->get();

        $_seq = array();
        $result = array();
        foreach($attachments->result() as $att) {
            @$_seq[$att->tipe]++;
            $att->sequence = $_seq[$att->tipe];

            $result[] = $att;
        }

        return $result;
    }

    public function isDocumentOfTypeExists($data_id, $doc_type)
    {
        $result = @$this->db->where('module_kode', $this->M_purchase_order::module_kode)
            ->where('data_id', $data_id)
            ->where('tipe', $doc_type)
            ->select('count(1) as num')
            ->get($this->table)
            ->result()[0];

        return $result && $result->num > 0;
    }
}

