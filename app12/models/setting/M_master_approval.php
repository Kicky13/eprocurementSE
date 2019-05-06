<?php
if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_master_approval extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function menu() {
        $data = $this->db->from('m_menu')->where('STATUS', '1')->get();
        return $data->result();
    }

    public function get_data(){
        $query = $this->db->select('r.id,u.DESCRIPTION as user_roles, r.description, r.sequence, r.type, r.status, a.description as modul,
        r.reject_step, r.email_approve, 
        CASE
            WHEN r.email_approve = 0 THEN \'None\'
            ELSE r.email_approve
        END as email_approve, 
        CASE
            WHEN r.email_reject = 0 THEN \'None\'
            ELSE r.email_reject
        END as email_reject, 
        CASE
            WHEN r.edit_content = 1 THEN \'No\'
            ELSE \'Yes\'
        END as edit_content, 
        CASE
            WHEN r.extra_case = 0 THEN \'No\'
            ELSE \'Yes\'
        END as extra_case,
            ')
                ->from('m_approval_rule r')                
                ->join('m_user_roles u','u.ID_USER_ROLES=r.user_roles','')
                ->join('m_approval_modul a','r.module=a.id','')
                ->order_by('r.module')
                ->order_by('r.sequence asc')
                ->get();        
        if ($query->num_rows() != 0)
            return $query->result();
        else
            return false;
    }

    public function cek($dt){
        $query = $this->db->select('description,module,sequence')
                ->from('m_approval_rule')                
                ->where('module=',$dt['module'])
                ->where('sequence=',$dt['sequence'])
                ->or_where('description=',$dt['description'])                
                ->get();
        if ($query->num_rows() != 0)
            return false;
        else
            return true;
    }

    public function add($dt){
        $this->db->insert('m_approval_rule', $dt);
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }

    public function update($dt){
        $query = $this->db
                ->where('id=', $dt['id'])
                ->update('m_approval_rule', $dt);
        if ($query)
            return true;
        else
            return false;
    }

    public function get_ids($id)
    {
        $res=$this->db->select('*')
            ->from('m_approval_rule')
            ->where('id='.$id)
            ->get();
        if ($res->num_rows() != 0)
            return $res->result();
        else
            return true;
    }

    public function get_sel()
    {
        $res=$this->db->select('u.id_user_roles as id_user,u.description as jabatan,t.id as id_mod,t.description as modul')
                    ->from('m_approval_modul t')
                    ->join('m_user_roles u','u.status = 1','')                            
                    ->get();
        if ($res->num_rows() != 0)
            return $res->result();
        else
            return true;
    }

    public function change_seq($dt)
    {
        $id=$dt['id'];
        unset($dt['id']);
        return $this->db->where('$id=',$id)
                        ->update('m_approval_rule',$dt);
    }
}
