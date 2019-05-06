<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_msr_item extends CI_Model {

	protected $table = 't_msr_item';
	protected $table_budget = 't_msr_budget';

  protected $primaryKey = ['id', 'id_company'];

  public function __construct()
  {
      parent::__construct();
      $this->db = $this->load->database('default', true);
  }

  public function getTable()
  {
    return $this->table;
  }

  public function all()
  {
    return $this->db->get($this->table)->query()->result();
  }

  // do we need $company?
  public function find($id, $company = null)
  {
    return $this->db->where($this->primaryKey[0], $id)
      ->andWhere($this->primaryKey[1], $company)
      ->get($this->table)
      ->result();
  }

  public function add($data)
  {
    return $this->db->insert($this->table, $data);
  }

  public function addBatch($data)
  {
    return $this->db->insert_batch($this->table, $data);
  }

  public function getByMsrNo($msr_no)
  {
    return $this->db->where('msr_no', $msr_no)->get($this->table)->result();
		// return $this->db->query("SELECT * FROM t_msr_item a JOIN t_msr_budget b ON b.msr_no=a.msr_no WHERE b.msr_no = '".$msr_no."' ")->result();
  }

  public function deleteByMsrNo($msr_no)
  {
    return $this->db->from($this->table)
        ->where('msr_no', $msr_no)
        ->delete();
  }

	public function addMsrBudget($data){
		return $this->db->insert("t_msr_budget", $data);
	}

	public function deleteMsrBudgetByMsrNo($msr_no){
		return $this->db->where('msr_no', $msr_no)->delete("t_msr_budget");
	}
}
