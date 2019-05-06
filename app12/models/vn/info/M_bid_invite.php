<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_bid_invite extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_template($id)
    {
        $qry=$this->db->select('OPEN_VALUE,CLOSE_VALUE')
            ->from('m_notic')
            ->where('ID',$id)
            ->geT();
        if($qry->num_rows() != 0)
            return $qry->result();
        else
            return false;
    }

}