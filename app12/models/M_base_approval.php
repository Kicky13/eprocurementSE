<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_base_approval extends CI_Model {

    protected $table = 't_approval';
    protected $table_detail = null;
    protected $module_kode = 'approval';

    protected $user_creator_id = '41';
    protected $user_manager_id = '18';

    public function status($value = null) {
        $data =  array(
            0 => 'Waiting Approval',
            1 => 'Approved',
            2 => 'Rejected'
        );
        if ($value) {
            return $data[$value];
        }
        return $data;
    }

    public function approve_option() {
        $data =  array(
            1 => 'Approve',
            2 => 'Reject'
        );
        return $data;
    }

    public function start($id) {
        $rs_module_rule = $this->db->where('module', $this->module_kode)
        ->order_by('sequence', 'asc')
        ->get('m_approval_rule')
        ->result();
        $fieldDebug = [];
        foreach ($rs_module_rule as $r_module_rule) {

            if (method_exists($this, 'approval_rule')) {
                $approval_rule = $this->approval_rule($id, $r_module_rule);
                if (!$approval_rule) {
                    continue;
                }
            }

            if ($r_module_rule->user_roles == $this->user_creator_id) {
                $id_user = $this->session->userdata('ID_USER');
            } elseif ($r_module_rule->user_roles == $this->user_manager_id) {
                $jabatan = $this->db->where('user_id', $this->session->userdata('ID_USER'))
                ->get('t_jabatan')
                ->row();
                $id_user = $this->db->where('id', $jabatan->parent_id)
                ->get('t_jabatan')
                ->row()
                ->user_id;

                $newIdUser = $this->extra_case($id, $r_module_rule);

                // $id_user =  $newIdUser ? $newIdUser : $id_user;

                if($newIdUser and ($newIdUser != $id_user))
                {
                    $id_users = [$id_user => 'ARF APPROVAL (USER MANAGER)', $newIdUser => 'ARF APPROVAL (AAS)'];
                }

            } else {
                if (method_exists($this, 'user_approver')) {
                    $this->user_approver($id, $r_module_rule);
                } else {
                    $id_user = '%';
                }
            }
            if(isset($id_users))
            {
                foreach ($id_users as $k=>$v) {
                    $isiField = array(
                        'id_ref' => $id,
                        'id_user_role' => $r_module_rule->user_roles,
                        'id_user' => $k,
                        'sequence' => $r_module_rule->sequence,
                        'description' => $v,
                        'reject_step' => $r_module_rule->reject_step,
                        'email_approve' => $r_module_rule->email_approve,
                        'email_reject' => $r_module_rule->email_reject,
                        'edit_content' => $r_module_rule->edit_content,
                        'status' => 0
                    );
                    if($this->input->get('debug'))
                    {
                        $fieldDebug[] = $isiField;
                    }
                    else
                    {
                        $this->db->insert($this->table, $isiField);
                    }
                }
                unset($id_users);
            }
            else
            {
                $isiField = array(
                    'id_ref' => $id,
                    'id_user_role' => $r_module_rule->user_roles,
                    'id_user' => $id_user,
                    'sequence' => $r_module_rule->sequence,
                    'description' => $r_module_rule->description,
                    'reject_step' => $r_module_rule->reject_step,
                    'email_approve' => $r_module_rule->email_approve,
                    'email_reject' => $r_module_rule->email_reject,
                    'edit_content' => $r_module_rule->edit_content,
                    'status' => 0
                );
                if($this->input->get('debug'))
                {
                    $fieldDebug[] = $isiField;
                }
                else
                {
                    $this->db->insert($this->table, $isiField);
                }
            }
        }
        if($this->input->get('debug'))
        {
            return $fieldDebug;
        }
        else
        {
            $approval = $this->find($id);
            $this->approve($approval->id, 1);
        }
    }

    public function approve($id, $status, $description = null, $detail = array()) {
        $user_roles = $this->session->userdata('ROLES');
        $user_roles = trim($user_roles, ',');
        $user_roles = explode(',', $user_roles);
        $approval = $this->db->where('id', $id)
        ->where_in('id_user_role', $user_roles)
        ->where($this->session->userdata('ID_USER') .' LIKE id_user')
        ->get($this->table)
        ->row();
        if ($approval) {
            $this->db->where('id', $id)
            ->update($this->table, array(
                'status' => $status,
                'approved_by' => $this->session->userdata('ID_USER'),
                'note' => $description,
                'approved_at' => date('Y-m-d H:i:s')
            ));
            if ($status <> 0) {
                if ($status == 1) {
                    $email = $this->db->where('ID', $approval->email_approve)
                    ->get('m_notic')
                    ->row();
                    $next_approval = $this->db->where('id_ref', $approval->id_ref)
                    ->where('sequence = (SELECT MIN(sequence) FROM '.$this->table.' WHERE id_ref=\''.$approval->id_ref.'\' AND status = 0 OR status = 2)', null, false)
                    ->get($this->table)
                    ->row();
                    $this->db->insert('log_history', array(
                        'module_kode' => $this->module_kode,
                        'data_id' => $id,
                        'description' => 'Approve - '.$description,
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by' => $this->session->userdata('ID_USER')
                    ));

                    if (method_exists($this, 'on_approve')) {
                        $this->on_approve($id, $approval);
                    }

                    if (!$next_approval) {
                        if (method_exists($this, 'on_complete')) {
                            $this->on_complete($id, $approval);
                        }
                    }
                } else {
                    if (method_exists($this, 'reject_step')) {
                        $reject_step = $this->reject_step($id, $approval->reject_step);
                    } else {
                        $reject_step = $approval->reject_step;
                    }
                    $email = $this->db->where('ID', $approval->email_reject)
                    ->get('m_notic')
                    ->row();
                    $next_approval = $this->db->where('id_ref', $approval->id_ref)
                    ->where('sequence', $reject_step)
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
                    if (method_exists($this, 'on_reject')) {
                        $this->on_reject($id, $approval);
                    }
                }
                if ($next_approval) {
                    $users = $this->db->join('m_departement', 'm_departement.ID_DEPARTMENT = m_user.ID_DEPARTMENT')
                    ->like('ROLES', $next_approval->id_user_role)
                    ->where('\''.$next_approval->id_user.'\' LIKE m_user.ID_USER', null, false)
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
            }
            if ($detail) {
                $record_detail = array();
                foreach ($detail as $key => $value) {
                    $record_detail[] = array(
                        'id_approval' => $approval->id,
                        'key' => $key,
                        'value' => $value
                    );
                }
                $this->db->insert_batch($this->table_detail, $record_detail);
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

    public function get($id) {
        return $this->db->select(array(
            $this->table.'.id',
            $this->table.'.id_ref',
            $this->table.'.id_user_role',
            $this->table.'.id_user',
            $this->table.'.description',
            $this->table.'.note',
            $this->table.'.status',
            $this->table.'.approved_by',
            $this->table.'.approved_at',
            'm_user_roles.DESCRIPTION as role',
            'GROUP_CONCAT(m_user.NAME SEPARATOR \', \') as name',
            'approver.NAME as approver',
            '(
                SELECT COUNT(1) FROM m_user auth
                WHERE auth.ID_USER = \''.$this->session->userdata('ID_USER').'\'
                AND auth.ROLES LIKE CONCAT(\'%,\','.$this->table.'.id_user_role,\',%\')
                AND auth.ID_USER LIKE '.$this->table.'.id_user
            ) as auth'
        ))
        ->join('m_user_roles', 'm_user_roles.ID_USER_ROLES = '.$this->table.'.id_user_role')
        ->join('m_user', 'm_user.ROLES LIKE CONCAT(\'%,\',m_user_roles.ID_USER_ROLES,\',%\') AND m_user.ID_USER LIKE '.$this->table.'.id_user AND m_user.STATUS = 1')
        ->join('m_user approver', 'approver.ID_USER = '.$this->table.'.approved_by', 'left')
        ->where($this->table.'.id_ref', $id)
        ->group_by(array(
            $this->table.'.id',
            $this->table.'.id_ref',
            $this->table.'.id_user_role',
            $this->table.'.id_user',
            $this->table.'.description',
            $this->table.'.note',
            $this->table.'.status',
            $this->table.'.approved_by',
            $this->table.'.approved_at',
            'm_user_roles.DESCRIPTION',
            'approver.NAME'
        ))
        ->order_by($this->table.'.sequence', 'ASC')
        ->get($this->table)
        ->result();
    }

    public function get_detail($id) {
        return $this->db->where('id_approval', $id)
        ->get($this->table_detail)
        ->result();
    }

    public function find_detail($id, $key) {
        return $this->db->where('id_approval', $id)
        ->where('key', $key)
        ->get($this->table_detail)
        ->row();
    }

    public function last_sequence($id) {
        return $this->db->select($this->table.'.*')
        ->join('(SELECT id_ref, MAX(sequence) as sequence FROM '.$this->table.' WHERE id_ref=\''.$id.'\') last', 'last.id_ref = '.$this->table.'.id_ref AND last.sequence = '.$this->table.'.sequence')
        ->get($this->table)
        ->row();
    }
}