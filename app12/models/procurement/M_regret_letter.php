<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_regret_letter extends MY_Model
{
    protected $table = 't_regret_letter';
    protected $t_bl_detail;
    protected $t_bl;
    protected $t_eq_data;
    protected $t_msr;

    public function __construct()
    {
        parent::__construct();

        $this->load->model("procurement/M_msr")
            ->model('vendor/M_show_vendor');

        $this->t_bl_detail = 't_bl_detail';
        $this->t_bl = 't_bl';
        $this->t_eq_data = 't_eq_data';
        $this->t_msr = $this->M_msr->getTable();
    }

    public function findByBlDetailId($id)
    {
        $this->prepareBaseSelect();
        $this->prepareBaseTable();
        $this->whereUnaward();

        $this->db->from($this->t_bl_detail)
            ->join($this->table, "{$this->table}.bl_detail_id = {$this->t_bl_detail}.id", 'left')
            ->where("{$this->t_bl_detail}.id", $id);

        return $this->db->get()->row();
    }

    public function send($bl_detail_id)
    {
        return parent::add([
            'bl_detail_id' => $bl_detail_id,
            'regret_date' => today_sql(),
            'create_by' => $this->session->userdata('ID_USER'),
            'create_on' => today_sql()
        ]);
    }

    public function vendorInquiry($vendor_id, $params = [])
    {
        $this->prepareBaseSelect();

		if (isset($params['limit'])) {
	      $this->db->limit($params['limit']);
	    }

	    if (isset($params['offset'])) {
	      $this->db->offset($params['offset']);
	    }

	    if (isset($params['orderBy'])) {
	      $this->db->order_by($params['orderBy']);
	    }

        $this->db->from($this->table)
            ->join($this->t_bl_detail, "{$this->t_bl_detail}.id = {$this->table}.bl_detail_id");

        $this->prepareBaseTable();

        $this->db->where("{$this->t_bl_detail}.vendor_id", $vendor_id)
            ->where("{$this->t_bl_detail}.awarder", 0);

        $res = $this->db->get();

        if (isset($params['resource']) && $params['resource'] === true) {
            return $res;    
        }

        return $res->result();
    }

    public function openList($params = [])
    {
		if (isset($params['limit'])) {
	        $this->db->limit($params['limit']);
	    }

	    if (isset($params['offset'])) {
	        $this->db->offset($params['offset']);
	    }

	    if (isset($params['orderBy'])) {
	        $this->db->order_by($params['orderBy']);
	    }

        $this->prepareBaseSelect();
        $this->prepareBaseTable();
        $this->whereUnaward();

        $this->db->from($this->t_bl_detail)
            ->join($this->table, "{$this->table}.bl_detail_id = {$this->t_bl_detail}.id", 'left')
            ->where("{$this->table}.id IS NULL");

        $res = $this->db->get();

        if (isset($params['resource']) && $params['resource'] === true) {
            return $res;    
        }

        return $res->result();
    }

    public function openListByBlDetail($bl_detail_id, $params = [])
    {
        if (!is_array($bl_detail_id)) {
            $bl_detail_id = array($bl_detail_id);
        }

        $this->db->where_in("{$this->t_bl_detail}.id", $bl_detail_id);

        return $this->openList($params);
    }

    public function getData($id)
    {
        $this->prepareBaseSelect();
        $this->prepareBaseTable();
        $this->whereUnaward();

        $this->db->from($this->table)
            ->join($this->t_msr, "{$this->t_msr}.msr_no = {$this->t_bl}.msr_no")
            ->where("{$this->table}.id", $id);

        return $this->db->get()->result();
    }

    public function getDataFromBlDetail($id)
    {
        $this->load->model("procurement/M_msr");

        $this->prepareBaseSelect();
        $this->prepareBaseTable();
        $this->whereUnaward();

        $this->db->from($this->t_bl_detail)
            ->join($this->table, "{$this->table}.bl_detail_id = {$this->t_bl_detail}.id", 'left')
            ->where("{$this->t_bl_detail}.id", $id);

        return $this->db->get()->result();
    }

    protected function prepareBaseTable()
    {
        $this->db->join($this->t_bl, "{$this->t_bl}.msr_no = {$this->t_bl_detail}.msr_no")
            ->join($this->t_eq_data, "{$this->t_eq_data}.msr_no = {$this->t_bl_detail}.msr_no")
            ->join($this->t_msr, "{$this->t_msr}.msr_no = {$this->t_bl}.msr_no");
    }

    protected function prepareBaseSelect()
    {
        $this->db->select([
            "{$this->t_bl_detail}.vendor_id",
            "{$this->t_bl}.msr_no",
            "{$this->t_bl}.bled_no",
            "{$this->t_bl}.title",
            "{$this->t_eq_data}.closing_date",
            "{$this->t_msr}.id_company",
            "{$this->t_msr}.company_desc",
            "{$this->table}.*",
            "{$this->table}.id regret_letter_id",
            // Important! always after $this->table selection
            "{$this->t_bl_detail}.id as bl_detail_id",
        ]);

    }

    protected function whereUnaward()
    {
        $this->db->where("{$this->t_bl_detail}.awarder", 0);
    }
}
