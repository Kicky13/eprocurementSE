<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_slka extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_slka($id) {
        $qry = $this->db->select('N.OPEN_VALUE,N.CLOSE_VALUE,V.NO_SLKA,V.NAMA,A.ADDRESS,A.TELP,A.FAX,P.NO_NPWP,A.BRANCH_TYPE,V.SLKA_DATE')
                ->from('m_notic N')
                ->where('N.ID', '14')
                ->join('m_vendor V', 'V.ID=' . $id, 'left')
                ->join('m_vendor_address A', 'A.ID_VENDOR = V.ID AND A.STATUS = 1', 'left')
                ->join('m_vendor_npwp P', 'P.ID_VENDOR = V.ID', 'left')                
                // ->join('log_vendor_acc L', 'L.ID_VENDOR = V.ID_VENDOR AND L.STATUS = 7', 'left')                
                // ->group_by('1,2,3,4,5,6,7,8,9')
                ->get();                        
        return $qry->result_array();
    }
    
    public function check_slka($no)
    {
        $qry=$this->db->select('ID,NO_SLKA')
                ->from('m_vendor')
                ->where("md5(NO_SLKA)=",$no)
                ->get();        
        if ($qry->num_rows() != 0)
            return $qry->result();
        else
            return false;
    }
    
    public function get_no_slka($id)
    {
        $qry=$this->db->select('NO_SLKA')
                ->from('m_vendor')
                ->where('ID',$id)
                ->where('STATUS > 5')
                ->get();        
        if ($qry->num_rows() != 0)
            return $qry->result();
        else
            return false;
    }
}