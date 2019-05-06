<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_master_acc_sub extends MY_Model {
    protected $table = 'm_accsub';

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function show($where = null) {
        if ($where != null) {
            $this->db->where("ID_ACCSUB", $where);
        }
        $data = $this->db->select("COSTCENTER,ID_ACCSUB,ACCSUB_DESC,STATUS,POSTING")->from('m_accsub')->order_by('CREATE_ON DESC')->get();
        return $data->result_array();
    }

    public function simpan($data){
      $insert = $this->db->insert('m_accsub', $data);
    }

    public function update($id, $data){
      return $this->db->where('ID_ACCSUB', $id)->update('m_accsub', $data);
    }

    public function all() {
        return $this->db->get($this->table)->result();
    }

    public function find_by_company_and_costcenter($company_id, $costcenter_id, $posting_flag = [])
    {
        $this->whereActive();
        $this->wherePostingFlag($posting_flag);

        return $this->db->where('COMPANY', $company_id)
            ->where('COSTCENTER', $costcenter_id)
            ->where('STATUS', 1)
            ->get($this->table)
            ->result();
    }

    public function find_by_costcenter($costcenter_id)
    {
        $m_costcenter = 'm_costcenter';

        $this->whereActive();

        return $this->db->select([
            "{$this->table}.*",
            "{$m_costcenter}.COSTCENTER_DESC",
            "{$m_costcenter}.COSTCENTER_ABR",
            ])
            ->where('COSTCENTER', $costcenter_id)
            ->join($m_costcenter, "m_costcenter.ID_COSTCENTER = {$this->table}.COSTCENTER")
            ->where('STATUS', 1)
            ->get($this->table)
            ->result();
    }

    protected function wherePostingFlag($flag = [])
    {
        $this->db->where_in($this->table.'.POSTING', $flag);
    }
}
