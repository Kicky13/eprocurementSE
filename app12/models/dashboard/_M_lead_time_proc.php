<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_lead_time_proc extends CI_MODEL
{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_compndept()
    {
        $res=$this->db->query(
            "SELECT DISTINCT m.ID_COMPANY,m.DESCRIPTION,d.ID_DEPARTMENT,d.DEPARTMENT_DESC
            FROM m_company m
            JOIN m_departement d ON m.ID_COMPANY=d.ID_COMPANY AND d.status=1
            WHERE m.status=1"
        );
        if($res->num_rows()!=null)
            return $res->result();
        else
            return false;
    }
}
?>