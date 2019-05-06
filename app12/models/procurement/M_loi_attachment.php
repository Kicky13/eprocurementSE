<?php

class M_loi_attachment extends MY_Model
{
	const TYPE_DRAFT_LOI = 'DRAFT_LOI';
	const TYPE_ITP_FORM = 'ITP_FORM';
	const TYPE_PBOND = 'PBOND';
	const TYPE_STMT_AUTH = 'STMT_AUTH';
	const TYPE_SIGNED_LOI = 'SIGNED_LOI';

	protected $types = array(
        self::TYPE_DRAFT_LOI   => 'LOI',
        self::TYPE_SIGNED_LOI  => 'Signed LOI',
        self::TYPE_ITP_FORM    => 'ITP Form',
        self::TYPE_PBOND       => 'Performance Bond',
    //    self::TYPE_STMT_AUTH   => 'Statement of Authenticity'
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
		$this->load->model('procurement/M_loi');
		
		$this->db->where('module_kode', $this->M_loi::module_kode)
			->get($this->table)
			->result();
	}

    public function getByDocument($data_id)
    {
        /*
        return $this->db->where('module_kode', $this->M_loi::module_kode)
            ->where('data_id', $data_id)
            ->get($this->table)
            ->result();
         */

        $this->load->model('procurement/M_loi')
            ->model('user/M_view_user');

        $user_table = $this->M_view_user->getTable();

        $attachments = $this->db->select(["$this->table.*"])
            ->from($this->table)
            ->where('module_kode', $this->M_loi::module_kode)
            ->where('data_id', $data_id)
            ->order_by('created_at')
            ->get();

        $_seq = array();
        $result = array();
        $users = array();
        while($att = $attachments->unbuffered_row()) {
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
