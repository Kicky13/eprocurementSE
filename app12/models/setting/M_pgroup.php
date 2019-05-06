<?php
if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_pgroup extends CI_Model {
    protected $table = 'm_pgroup';

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function menu() {
        $data = $this->db->from('m_menu')->where('STATUS', '1')->get();
        return $data->result();
    }

    public function get_data(){
        $query = $this->db->select('ID_PGROUP,PGROUP_DESC,STATUS')
                ->from('m_pgroup')                
                ->get();                        
        if ($query->num_rows() != 0)
            return $query->result();
        else
            return false;
    }

    public function cek($dt){
        $query = $this->db->select('ID_PGROUP')
                ->from('m_pgroup')
                ->where('STATUS=',0)
                ->where('ID_PGROUP=',$dt['ID_PGROUP'])                
                ->get();
        if ($query->num_rows() != 0)
            return false;
        else
            return true;
    }

    public function add($dt){
        $this->db->insert('m_pgroup', $dt);
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }

    public function update($dt){
        $query = $this->db
                ->where('ID_PGROUP=', $dt['ID_PGROUP'])
                ->update('m_pgroup', $dt);
        if ($query)
            return true;
        else
            return false;
    }

    public function all() {
        return $this->db->get($this->table)->result();
    }

	public function find($id) {
		return $this->db->where('ID_PGROUP', $id)
			->get($this->table)->result();
	}

    public function allActive()
    {
        return $this->db->where('status', 1)->get($this->table)->result();
    }
}
