<?php
if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_master_department extends CI_Model {
    protected $table = 'm_departement';

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function menu() {
        $data = $this->db->from('m_menu')->where('STATUS', '1')->get();
        return $data->result();
    }

    public function get_data(){
        $query = $this->db->select('ID_COMPANY,ID_DEPARTMENT,DEPARTMENT_DESC,DEPARTMENT_ABR,STATUS')
                ->from('m_departement')                
                ->get();
        if ($query->num_rows() != 0)
            return $query->result();
        else
            return false;
    }

    public function cek($dt){
        $query = $this->db->select('ID_COMPANY,ID_DEPARTMENT')
                ->from('m_departement')
                ->where('STATUS=',1)
                ->where('ID_COMPANY=',$dt['ID_COMPANY'])
                ->where('ID_DEPARTMENT=',$dt['ID_DEPARTMENT'])
                ->where('DEPARTMENT_DESC=',$dt['DEPARTMENT_DESC'])
                ->where('DEPARTMENT_ABR=',$dt['DEPARTMENT_ABR'])
                ->get();
        if ($query->num_rows() != 0)
            return false;
        else
            return true;
    }

    public function add($dt){
        $this->db->insert('m_departement', $dt);
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
        $query = $this->db
                ->where('ID_COMPANY=', $dt['ID_COMPANY'])
                ->where('ID_DEPARTMENT=', $dt['ID_DEPARTMENT'])
                ->update('m_departement', $dt);
        if ($query)
            return true;
        else
            return false;
    }

    public function findByDeptAndCompany($dept_id, $company_id)
    {
        return @$this->db->where('ID_COMPANY', $company_id)
            ->where('ID_DEPARTMENT', $dept_id)
            ->get($this->table)->row();
    }

    public function find($department_id)
    {
        return @$this->db->where('ID_DEPARTMENT', $department_id)
            ->get($this->table)->result()[0];
    }
}
