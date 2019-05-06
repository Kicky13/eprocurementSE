<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_Msr_draft extends MY_Model
{

    const module_kode = 'msr_draft';
    protected $table = 't_msr_draft';

    public function __construct() {
        parent::__construct();
    }

    public function add($data)
    {
        $data['create_on'] = today_sql();
        $data['create_by'] = $this->session->userdata('ID_USER');

        parent::add($data);
    }

    public function getByCreator($user_id, $options = array())
    {
        if (isset($options['limit'])) {
            $this->db->limit($options['limit']);
        }

        if (isset($options['offset'])) {
            $this->db->offset($options['offset']);
        }

        if (isset($options['orderBy'])) {
            $this->db->order_by($options['orderBy']);
        }

        $this->db->where('create_by', $user_id);

        $res = $this->db->get($this->table);

        if (isset($options['resource']) && $options['resource'] == true) {
            return $res;
        }

        return $res->result();

    }

    public function getPrimarySecondaryByUserId($user_id, $options = array())
    {
        $this->load->model('setting/M_jabatan')
            ->helper(['array']);

        if (isset($options['limit'])) {
            $this->db->limit($options['limit']);
        }

        if (isset($options['offset'])) {
            $this->db->offset($options['offset']);
        }

        if (isset($options['orderBy'])) {
            $this->db->order_by($options['orderBy']);
        }

        $primary_secondary = $this->M_jabatan->getPrimarySecondaryUserByUserId($user_id);

        $primary = array_filter($primary_secondary, function($user) {
            return $user->user_role == t_jabatan_user_primary;
        });

        $creator = array_pluck($primary_secondary, 'user_id');

        if ($creator) {
            $this->db->where_in($this->table.'.create_by', $creator);
        } else {
            $this->db->where($this->table.'.create_by', ''); // assume this will select nothing
        }
        $this->db->select($this->table.'.*, m_company.ABBREVIATION');
        $this->db->join('m_company', 'm_company.ID_COMPANY = '.$this->table.'.id_company', 'left');
        $this->db->from($this->table);
        $this->db->order_by('id', 'DESC');

        $res = $this->db->get();

        if (isset($options['resource']) && $options['resource'] == true) {
            return $res;
        }

        return $res->result();

    }
}



/* vim: set fen foldmethod=indent ts=4 sw=4 tw=0 et smartindent autoindent :*/
