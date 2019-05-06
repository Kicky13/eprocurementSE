<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_msr_budget_status extends CI_Model
{
	const PLANNED = 'PLANNED';
	const BOOKED = 'BOOKED';
	const DUMMY_BOOKED = 'DUMMY_BOOKED';
	
	protected $table = 'm_msr_budget_status';

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
		return @$this->db->where('id', $id)->get($this->table)->result()[0];
	}
}