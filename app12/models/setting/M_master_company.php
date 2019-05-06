<?php
if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_master_company extends CI_Model {
    protected $table = 'm_company';

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function menu() {
        $data = $this->db->from('m_menu')->where('STATUS', '1')->get();
        return $data->result();
    }

    public function get_data(){
        $query = $this->db->select('ID_COMPANY,DESCRIPTION,ABBREVIATION,STATUS')
                ->from('m_company')                
                ->get();
        if ($query->num_rows() != 0)
            return $query->result();
        else
            return false;
    }

    public function cek($dt){
        $query = $this->db->select('ID_COMPANY,DESCRIPTION')
                ->from('m_company')
                ->where('STATUS=',1)
                ->where('ID_COMPANY=',$dt['ID_COMPANY'])
                ->where('DESCRIPTION=',$dt['DESCRIPTION'])
                ->where('ABBREVIATION=',$dt['ABBREVIATION'])
                ->get();
        if ($query->num_rows() != 0)
            return false;
        else
            return true;
    }

    public function add($dt){
        $this->db->insert('m_company', $dt);
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }

    public function update($dt){
        $query = $this->db
                ->where('ID_COMPANY=', $dt['ID_COMPANY'])
                ->update('m_company', $dt);
        if ($query)
            return true;
        else
            return false;
    }

    public function find($id)
    {
        if (!is_array($id)) {
            $id = array($id);
        }

        $result = $this->db->where_in('id_company', $id)->get($this->table)->result();

        return count($id) == 1 ? @$result[0] : $result;
    }

    public function findAll($id)
    {
        if (!is_array($id)) {
            $id = array($id);
        }

        return $this->db->where_in('id_company', $id)->get($this->table)->result();
    }

    public function findAllActive($id)
    {
        if (!is_array($id)) {
            $id = array($id);
        }

        return $this->db->where('status', 1)->where_in('id_company', $id)->get($this->table)->result();
    }
}
