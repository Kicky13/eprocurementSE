<?php
if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_master_bank extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function menu() {
        $data = $this->db->from('m_menu')->where('STATUS', '1')->get();
        return $data->result();
    }

    public function get_data(){
        $query = $this->db->select('ID,NAMA_BANK,DESCRIPTION,STATUS')
                ->from('m_bank')                
                ->get();
        if ($query->num_rows() != 0)
            return $query->result();
        else
            return false;
    }

    public function cek($dt){
        $query = $this->db->select('NAMA_BANK,DESCRIPTION')
                ->from('m_bank')
                ->where('STATUS=',1)
                ->where('NAMA_BANK=',$dt['NAMA_BANK'])
                ->where('DESCRIPTION=',$dt['DESCRIPTION'])
                ->get();
        if ($query->num_rows() != 0)
            return false;
        else
            return true;
    }

    public function add($dt){
        $this->db->insert('m_bank', $dt);
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }

    public function update($dt){
        $query = $this->db
                ->where('ID=', $dt['ID'])
                ->update('m_bank', $dt);
        if ($query)
            return true;
        else
            return false;
    }
}