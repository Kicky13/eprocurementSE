<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_Msr_item_draft extends MY_Model
{
    protected $table = 't_msr_item_draft';

    public function __construct() {
        parent::__construct();
    }

    public function deleteAllByDraftId($draft_id)
    {
        return $this->db->where('t_msr_draft_id', $draft_id)
            ->delete($this->table);
    }

    public function addBatch($data)
    {
        return $this->db->insert_batch($this->table, $data);
    }

    public function updateByDraftId($draft_id, $data)
    {
        $this->db->where('t_msr_draft_id', $draft_id)
            ->update($this->table, $data);
    }

    public function getByDraftId($id)
    {
        return $this->db->where('t_msr_draft_id', $id)->get($this->table)->result();
    }

}



/* vim: set fen foldmethod=indent ts=4 sw=4 tw=0 et smartindent autoindent :*/
