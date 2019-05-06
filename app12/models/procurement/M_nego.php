<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_nego extends M_base {

    protected $table = 't_nego';
    protected $fillable = array('msr_no', 'vendor_id', 'company_letter_no', 'closing_date', 'supporting_document', 'note', 'bid_letter_no', 'bid_letter_no', 'bid_letter_file', 'id_local_content_type', 'local_content', 'local_content_file', 'bid_note', 'status', 'closed', 'created_by', 'created_at', 'responsed_at');

    public function view_nego() {
        $this->db->select('t_nego.msr_no, t_nego.company_letter_no, t_nego.supporting_document, t_nego.closing_date, t_nego.note, COALESCE(nego_requested.nego_requested, 0) AS nego_requested, COALESCE(nego_responsed.nego_responsed, 0) AS nego_responsed, t_nego.closed, t_nego.created_at')
        ->join('(
            SELECT msr_no, company_letter_no, COUNT(1) as nego_requested
            FROM t_nego
            GROUP BY msr_no, company_letter_no
        ) nego_requested', 'nego_requested.msr_no = t_nego.msr_no AND nego_requested.company_letter_no =t_nego.company_letter_no', 'left')
        ->join('(
            SELECT msr_no, company_letter_no, COUNT(1) as nego_responsed
            FROM t_nego
            WHERE status = 1
            GROUP BY msr_no, company_letter_no
        ) nego_responsed', 'nego_responsed.msr_no = t_nego.msr_no AND nego_responsed.company_letter_no =t_nego.company_letter_no', 'left')
        ->group_by(array(
            'msr_no',
            'company_letter_no',
            'supporting_document',
            'closing_date',
            'note',
            'nego_requested',
            'nego_responsed',
            'closed',
            'created_at'
        ));
    }

    public function view_detail_nego() {
        $this->db->select('t_nego.*, m_tkdn_type.name as local_content_type')
        ->join('m_tkdn_type', 'm_tkdn_type.id = t_nego.id_local_content_type');
    }

    public function view_detail_negotiation() {
        $this->db->select('m_vendor.*, t_nego.id as nego_id, t_nego.status')
        ->join('m_vendor', 'm_vendor.ID = t_nego.vendor_id');
    }
}