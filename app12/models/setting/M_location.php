<?php
if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_location extends CI_Model {
    protected $table = 'm_location';

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function menu() {
        $data = $this->db->from('m_menu')->where('STATUS', '1')->get();
        return $data->result();
    }

    public function get_data(){
        $query = $this->db->select('ID_LOCATION,LOCATION_DESC,STATUS')
                ->from('m_location')                
                ->get();
        if ($query->num_rows() != 0)
            return $query->result();
        else
            return false;
    }

    public function cek($dt,$sel=null){
        unset($dt['ID_LOCATION']);            
        $this->db->select('MAX(ID_LOCATION) as ID_LOCATION')
                ->from('m_location')
                ->where('STATUS=',0);
                if($sel== null)
                    $this->db->where('LOCATION_DESC=',$dt['LOCATION_DESC']);
        $query = $this->db->get();
        if ($query->num_rows() != 0)
            return $query->result();
        else
            return true;
    }

    public function add($dt){
        $this->db->insert('m_location', $dt);
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }    

    public function update($dt){
        $query = $this->db
                ->where('ID_LOCATION=', $dt['ID_LOCATION'])
                ->update('m_location', $dt);
        if ($query)
            return true;
        else
            return false;
    }

    public function all() {
        return $this->db->get($this->table)->result();
    }

    public function find($id)
    { 
        return @$this->db->where('ID_LOCATION', $id)->get($this->table)->result()[0]; 
    }
    
    public function allActive()
    {
        return $this->db->where('status', 1)->get($this->table)->result();
    }

}
