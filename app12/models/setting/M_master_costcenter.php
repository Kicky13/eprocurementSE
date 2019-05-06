<?php
if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_master_costcenter extends CI_Model {
    protected $table = 'm_costcenter';

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function menu() {
        $data = $this->db->from('m_menu')->where('STATUS', '1')->get();
        return $data->result();
    }

    public function get_data(){
        $query = $this->db->select('ID_COMPANY,ID_COSTCENTER,COSTCENTER_DESC,COSTCENTER_ABR,STATUS')
                ->from('m_costcenter')                
                ->get();
        if ($query->num_rows() != 0)
            return $query->result();
        else
            return false;
    }

    public function cek($dt){
        $query = $this->db->select('ID_COMPANY,ID_COSTCENTER')
                ->from('m_costcenter')
                ->where('STATUS=',1)
                ->where('ID_COMPANY=',$dt['ID_COMPANY'])
                ->where('ID_COSTCENTER=',$dt['ID_COSTCENTER'])
                ->where('COSTCENTER_DESC=',$dt['COSTCENTER_DESC'])
                ->where('COSTCENTER_ABR=',$dt['COSTCENTER_ABR'])
                ->get();
        if ($query->num_rows() != 0)
            return false;
        else
            return true;
    }

    public function add($dt){
        $this->db->insert('m_costcenter', $dt);
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }

    public function get_company()
    {
        $query = $this->db->select('ID_COMPANY,DESCRIPTION')
        ->from('m_company')
        ->where('STATUS=',1)        
        ->get();
        if ($query->num_rows() != 0)
            return $query->result();
        else
            return true;
    }

    public function update($dt){
        $com=$dt['ID_COMPANY'];
        $cc=$dt['ID_COSTCENTER'];
        unset($dt['ID_COSTCENTER']);
        unset($dt['ID_COMPANY']);
        $query = $this->db
                ->where('ID_COMPANY=',$com )
                ->where('ID_COSTCENTER=',$cc)
                ->update('m_costcenter', $dt);
        if ($query)
            return true;
        else
            return false;
    }

    public function all() {
        return $this->db->get($this->table)->result();
    }

    public function find_by_company($company, $id = null) {
      $costcenter = $this->db->where('id_company', $company);

      if ($id) {
        $costcenter->where('id_costcenter', $id);
      }

      $costcenter->where('status', 1);

      return $costcenter->get($this->table)->result();
    }

    public function find($id)
    {
        return @$this->db->where('ID_COSTCENTER', $id)->get($this->table)->result()[0];
    }


    public function allActive()
    {
        return $this->db->where('status', 1)->get($this->table)->result();
    }

}
