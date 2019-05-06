<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_service_receipt_approval extends CI_Model {

    protected $table = 't_approval_service_receipt';
    public $module_kode;

    public function start($id) {
        $rs_module_rule = $this->db->where('module', $this->module_kode)
        ->order_by('sequence', 'asc')
        ->get('m_approval_rule')
        ->result();
        $jabatan = $this->db->where('user_id', $this->session->userdata('ID_USER'))
        ->get('t_jabatan')
        ->row();
        foreach ($rs_module_rule as $r_module_rule) {
            if ($jabatan) {
                $this->db->insert($this->table, array(
                    'id_ref' => $id,
                    'id_user_role' => $r_module_rule->user_roles,
                    'id_user' => ($jabatan) ? $jabatan->user_id : '%',
                    'sequence' => $r_module_rule->sequence,
                    'description' => $r_module_rule->description,
                    'reject_step' => $r_module_rule->reject_step,
                    'email_approve' => $r_module_rule->email_approve,
                    'email_reject' => $r_module_rule->email_reject,
                    'edit_content' => $r_module_rule->edit_content,
                    'status' => 0
                ));
                $atasan = $this->db->where('id', $jabatan->parent_id)
                ->get('t_jabatan')
                ->row();
                $jabatan = $atasan;
            }
        }
        $this->db->insert('log_history', array(
            'module_kode' => $this->module_kode,
            'data_id' => $id,
            'description' => 'Approve',
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('ID_USER')
        ));
        $approval = $this->find($id);
        $this->approve($approval->id, 1);
    }

    public function approve($id, $status, $description = null) {
        $approval = $this->db->where('id', $id)
        ->get($this->table)
        ->row();
        if ($approval) {
            $this->db->where('id', $id)
            ->update($this->table, array(
                'status' => $status,
                'approve_by' => $this->session->userdata('ID_USER'),
                'note' => $description,
                'approve_date' => date('Y-m-d H:i:s')
            ));
            if ($status == 1) {
                $email = $this->db->where('ID', $approval->email_approve)
                ->get('m_notic')
                ->row();
                $next_approval = $this->db->where('id_ref', $approval->id_ref)
                ->where('sequence', ($approval->sequence+1))
                ->get($this->table)
                ->row();
                $this->db->insert('log_history', array(
                    'module_kode' => $this->module_kode,
                    'data_id' => $id,
                    'description' => 'Approve - '.$description,
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => $this->session->userdata('ID_USER')
                ));

                if (!$next_approval) {
                    $this->on_complete($id);
                }
            } else {
                $reject_step = $approval->reject_step;

                $email = $this->db->where('ID', $approval->email_reject)
                ->get('m_notic')
                ->row();
                $next_approval = $this->db->where('id_ref', $approval->id_ref)
                ->where('sequence', $approval->reject_step)
                ->get($this->table)
                ->row();
                $this->db->where('id_ref', $approval->id_ref)
                ->where('sequence >= ', ($approval->sequence - $reject_step))
                ->where('sequence <= ', $approval->sequence)
                ->where('id <>', $approval->id)
                ->update($this->table, array(
                    'status' => 0
                ));
                $this->db->insert('log_history', array(
                    'module_kode' => $this->module_kode,
                    'data_id' => $id,
                    'description' => 'Reject - '.$description,
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => $this->session->userdata('ID_USER')
                ));
            }
            if ($next_approval) {
                $users = $this->db->join('m_departement', 'm_departement.ID_DEPARTMENT = m_user.ID_DEPARTMENT')
                ->like('ROLES', $next_approval->id_user_role)
                ->where($next_approval->id_user.' LIKE m_user.ID_USER')
                ->get('m_user')
                ->result();
                $content_template = $email->OPEN_VALUE.$email->CLOSE_VALUE;
                foreach ($users as $user) {
                    $content = str_replace(array('_var1_', '_var2_'), array($user->NAME, $user->DEPARTMENT_DESC), $content_template);
                    $this->db->insert('i_notification', array(
                        'recipient' => $user->EMAIL,
                        'subject' => $email->TITLE,
                        'content' => $content,
                        'ismailed' => 0,
                        'create_date' => date('Y-m-d H:i:s')
                    ));
                }
            }
            return true;
        } else {
            return false;
        }
    }

    public function find($id) {
        $user_roles = $this->session->userdata('ROLES');
        $user_roles = trim($user_roles, ',');
        $user_roles = explode(',', $user_roles);
        $approval = $this->db->select($this->table.'.*')
        ->from('(SELECT id_ref, MIN(sequence) AS sequence FROM '.$this->table.' WHERE status = 0 OR status = 2 GROUP BY id_ref) approval')
        ->join($this->table, $this->table.'.id_ref = approval.id_ref AND '.$this->table.'.sequence = approval.sequence')
        ->where('approval.id_ref', $id)
        ->where_in($this->table.'.id_user_role', $user_roles)
        ->where($this->session->userdata('ID_USER') .' LIKE '.$this->table.'.id_user')
        ->get()
        ->row();
        return $approval;
    }

    public function on_complete($id) {
        $approval = $this->db->where('id', $id)->get($this->table)->row();
        $this->db->insert('i_sync', array(
            'doc_no' => $approval->id_ref,
            'doc_type' => 'srv_rcp',
            'isclosed' => 0
        ));
    }
}