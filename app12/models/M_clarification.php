<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_clarification extends M_base {

    protected $table = 't_note';
    protected $primary_key = 'id';
    protected $fillable = array('module_kode', 'data_id', 'description', 'path', 'created_at', 'created_by', 'author_type', 'vendor_id', 'is_read');

    public function view_clarification() {
        $this->db->select('
            t_note.description AS description, t_note.path AS attachment, t_note.created_at,
            CASE
                WHEN author_type = \'m_user\' THEN (SELECT NAME FROM m_user WHERE ID_USER = t_note.created_by)
                ELSE (SELECT NAMA FROM m_vendor WHERE ID = t_note.created_by)
            END AS created_by
        ')->order_by('t_note.created_at', 'DESC');
    }

    public function scope_ed() {
        $this->db->join('t_bl', 't_bl.bled_no = t_note.data_id')
        ->join('t_eq_data', 't_eq_data.msr_no = t_bl.msr_no')
        ->where('t_note.created_at <= t_eq_data.closing_date');
    }

    public function scope_bid_proposal() {
        $this->db->join('t_bl', 't_bl.bled_no = t_note.data_id')
        ->join('t_eq_data', 't_eq_data.msr_no = t_bl.msr_no')
        ->where('t_note.created_at > t_eq_data.bid_opening_date');
    }

    public function scope_unread_ed() {
        $this->db->join('t_bl', 't_bl.bled_no = t_note.data_id')
        ->join('t_eq_data', 't_eq_data.msr_no = t_bl.msr_no')
        ->join('t_assignment', 't_bl.msr_no = t_assignment.msr_no')
        ->where('t_assignment.user_id', $this->session->userdata('ID_USER'))
        ->where('t_eq_data.bid_opening', 0)
        ->where('t_note.module_kode', 'bidnote')
        ->where('t_note.is_read', 0)
        ->where('t_note.author_type <> ', 'm_user')
        ->where('t_note.created_at <= t_eq_data.closing_date');
    }

    public function scope_unread_bid_proposal() {
        $this->db->join('t_bl', 't_bl.bled_no = t_note.data_id')
        ->join('t_eq_data', 't_eq_data.msr_no = t_bl.msr_no')
        ->join('t_assignment', 't_bl.msr_no = t_assignment.msr_no')
        ->where('t_assignment.user_id', $this->session->userdata('ID_USER'))
        ->where('t_eq_data.bid_opening', 1)
        ->where('t_note.module_kode', 'bidnote')
        ->where('t_note.is_read', 0)
        ->where('t_note.author_type <> ', 'm_user')
        ->where('t_note.created_at > t_eq_data.bid_opening_date');
    }

    public function get_threads($module_kode, $search) {
        if ($module_kode == 'bid_proposal') {
            return $this->get_bid_proposal($search);
        } else {
            return $this->get_ed($search);
        }
    }

    public function get_users($module_kode, $thread_id) {
        if ($module_kode == 'bid_proposal') {
            return $this->get_bl_submitted($thread_id);
        } else {
            return $this->get_bl($thread_id);
        }
    }

    public function get_ed($search = null) {
        if ($search) {
            $this->db->group_start()
                ->like('t_bl.bled_no', $search)
                ->or_like('t_eq_data.subject', $search)
            ->group_end();
        }
        return $this->db->select('
            t_bl.bled_no AS id, t_bl.bled_no AS thread, t_eq_data.subject as subject,
            (
                SELECT COUNT(1) FROM t_note
                WHERE data_id = t_bl.bled_no
                AND t_note.created_at <= t_eq_data.closing_date
                AND t_note.is_read = 0
                AND t_note.author_type <> \'m_user\'
                AND t_note.module_kode = \'bidnote\'
            ) AS notification,
            (
                SELECT MAX(t_note.created_at) FROM t_note
                WHERE data_id = t_bl.bled_no
                AND t_note.created_at <= t_eq_data.closing_date
                AND t_note.author_type <> \'m_user\'
                AND t_note.module_kode = \'bidnote\'
            ) AS last_clarification,
            CASE
                WHEN t_eq_data.bid_opening = 1 THEN 0
                ELSE 1
            END AS open
        ', false)
        ->join('t_bl', 't_bl.msr_no = t_eq_data.msr_no')
        ->join('t_assignment', 't_bl.msr_no = t_assignment.msr_no')
        ->where('t_assignment.user_id', $this->session->userdata('ID_USER'))
        ->order_by('open', 'desc')
        ->order_by('last_clarification', 'desc')
        ->order_by('t_eq_data.msr_no', 'desc')
        ->get('t_eq_data')
        ->result();
    }

    public function get_bid_proposal($search = null) {
        if ($search) {
            $this->db->group_start()
                ->like('t_bl.bled_no', $search)
                ->or_like('t_eq_data.subject', $search)
            ->group_end();
        }
        return $this->db->select('
            t_bl.bled_no AS id, t_bl.bled_no AS thread, t_eq_data.subject as subject,
            (
                SELECT COUNT(1) FROM t_note
                WHERE data_id = t_bl.bled_no
                AND t_note.created_at > t_eq_data.bid_opening_date
                AND t_note.is_read = 0
                AND t_note.author_type <> \'m_user\'
                AND t_note.module_kode = \'bidnote\'
            ) AS notification,
            (
                SELECT MAX(t_note.created_at) FROM t_note
                WHERE data_id = t_bl.bled_no
                AND t_note.created_at > t_eq_data.bid_opening_date
                AND t_note.author_type <> \'m_user\'
                AND t_note.module_kode = \'bidnote\'
            ) AS last_clarification,
            1 AS open
        ', false)
        ->join('t_bl', 't_bl.msr_no = t_eq_data.msr_no')
        ->join('t_assignment', 't_bl.msr_no = t_assignment.msr_no')
        ->where('t_assignment.user_id', $this->session->userdata('ID_USER'))
        ->where('t_eq_data.bid_opening', 1)
        ->order_by('open', 'desc')
        ->order_by('last_clarification', 'desc')
        ->order_by('t_eq_data.msr_no', 'desc')
        ->get('t_eq_data')
        ->result();
    }

    public function get_bl($ed_no) {
        return $this->db->select('
            m_vendor.ID AS id, m_vendor.NAMA AS name, m_vendor.ID_VENDOR AS username, \'\' as description,
            (
                SELECT COUNT(1) FROM t_note
                WHERE data_id = t_bl.bled_no
                AND t_note.created_at <= t_eq_data.closing_date
                AND t_note.is_read = 0
                AND t_note.author_type <> \'m_user\'
                AND t_note.module_kode = \'bidnote\'
                AND t_note.created_by = m_vendor.ID
            ) AS notification
        ')
        ->join('t_bl', 't_bl.msr_no = t_bl_detail.msr_no')
        ->join('t_eq_data', 't_eq_data.msr_no = t_bl.msr_no')
        ->join('m_vendor', 'm_vendor.ID = t_bl_detail.vendor_id')
        ->where('t_bl.bled_no', $ed_no)
        ->where('t_bl_detail.confirmed', 1)
        ->get('t_bl_detail')
        ->result();
    }

    public function get_bl_submitted($ed_no) {
        return $this->db->select('
            m_vendor.ID AS id, m_vendor.NAMA AS name, m_vendor.ID_VENDOR AS username, \'\' as description,
            (
                SELECT COUNT(1) FROM t_note
                WHERE data_id = t_bid_head.bled_no
                AND t_note.created_at > t_eq_data.bid_opening_date
                AND t_note.is_read = 0
                AND t_note.author_type <> \'m_user\'
                AND t_note.module_kode = \'bidnote\'
                AND t_note.created_by = m_vendor.ID
            ) AS notification
        ')
        ->join('t_bl', 't_bl.bled_no = t_bid_head.bled_no')
        ->join('t_eq_data', 't_eq_data.msr_no = t_bl.msr_no')
        ->join('m_vendor', 'm_vendor.ID = t_bid_head.created_by')
        ->where('t_bid_head.bled_no', $ed_no)
        ->get('t_bid_head')
        ->result();
    }
}