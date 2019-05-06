<?php
if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_delivery_point extends CI_Model {
    protected $table = 'm_deliverypoint';

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function menu() {
        $data = $this->db->from('m_menu')->where('STATUS', '1')->get();
        return $data->result();
    }

    public function get_data(){
        $query = $this->db->select('ID_DPOINT,DPOINT_DESC,STATUS')
                ->from('m_deliverypoint')                
                ->get();
        if ($query->num_rows() != 0)
            return $query->result();
        else
            return false;
    }

    public function cek($dt,$sel=null){
        unset($dt['ID_DPOINT']);            
        $this->db->select('MAX(ID_DPOINT) as ID_DPOINT')
                ->from('m_deliverypoint')
                ->where('STATUS=',1);
                if($sel== null)
                    $this->db->where('DPOINT_DESC=',$dt['DPOINT_DESC']);
        $query = $this->db->get();
        if ($query->num_rows() != 0)
            return $query->result();
        else
            return true;
    }

    public function add($dt){
        $this->db->insert('m_deliverypoint', $dt);
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }    

    public function update($dt){
        $query = $this->db
                ->where('ID_DPOINT=', $dt['ID_DPOINT'])
                ->update('m_deliverypoint', $dt);
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
        return @$this->db->where('ID_DPOINT', $id)->get($this->table)->result()[0];    
    }

    public function allActive()
    {
        return $this->db->where('status', 1)->get($this->table)->result();
    }
}
