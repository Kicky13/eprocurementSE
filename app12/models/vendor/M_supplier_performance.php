<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_supplier_performance extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
    }

    public function show()
    {
        $res=$this->db->query(
            "SELECT a.vendor_id,m.NAMA,a.total,(a.rating/a.total) as avg_rating,m.NO_SLKA,m.CLASSIFICATION
            FROM(
                SELECT vendor_id,COUNT(vendor_id) as total,SUM(score) as rating
                FROM t_performance_cor
                WHERE total != 0
                GROUP BY vendor_id
            ) a
            JOIN m_vendor m ON a.vendor_id = m.ID"
        );
        return $res->result();
    }

    public function get_nama($id)
    {
        $res=$this->db->select('NAMA')
                        ->from('m_vendor')
                        ->where('ID',$id)
                        ->get();
        if($res->num_rows()!=0)
            return $res->result();
        else
            return false;
    }

    public function get_hist($id)
    {
        $res=$this->db->select('id,po_no,score')
                    ->from('t_performance_cor')
                    ->where('vendor_id',$id)
                    ->get();
        if($res->num_rows()!=0)
            return $res->result();
        else
            return false;
    }
}
