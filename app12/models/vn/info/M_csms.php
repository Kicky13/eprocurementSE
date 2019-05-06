<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_csms extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function cek_data() {
        $q = $this->db->select("ID_VENDOR")
                ->from("m_vendor_csms")
                ->where("ID_VENDOR=", $this->session->ID)
                ->get();
        if ($q->num_rows() != 0)
            return true;
        else
            return false;
    }

    public function check_status()
    {
        $res=$this->db->select('RISK')
                    ->from('m_vendor')
                    ->where('ID',$this->session->ID)
                    ->get();
        return $res->result();
    }

    public function cek_data_attch($id, $tbl) {
        $this->db->select('ID')->from($tbl);
        $this->db->where('ID_VENDOR =', $id);
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            return true;
        } else {
            return false;
        }
    }

    public function show()
    {
        $qry=$this->db->select('ID,TYPE,DESCRIPTION,FILE_URL')
                ->from('m_vendor_attch_csms')
                ->where('ID_VENDOR',$this->session->ID)
                ->where('STATUS','1')
                ->get();
        return $qry->result();
    }

    public function remove_doc($pil, $data) {
        $count = 0;
        unlink("upload/" . $pil .$data);
    }

    public function get_doc($id, $key = null, $sel, $table, $other = null) {
        $this->db->select($sel);
        $this->db->from($table);
        $this->db->where('ID_VENDOR=', $id);
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            return $query->result();
        } else
            return false;
    }

    public function add_data_attch($data, $tbl, $nfile, $path, $pil = null, $idx) {
        $key = null;
        $other = null;
        $id = $this->session->ID;
        $key = $this->cek_data_attch($this->session->ID, $tbl, null);
        if (empty($idx)) {
            $this->db->insert($tbl, $data);
            if ($this->db->affected_rows() > 0)
                return true;
            else
                return false;
        }
        else {
          // echopre($data);
            if ($pil == null) {
                $res = $this->get_doc($id, null, $nfile, $tbl, $other);
                if ($res != false) {
                    // $this->remove_doc('CSMS/', $res[0]->FILE_URL);
                    $this->db->where('ID', $idx);
                    $this->db->where('ID_VENDOR', $this->session->ID);
                    $data['UPDATE_BY'] = $this->session->ID;
                    $data['UPDATE_TIME'] = date('Y-m-d H:i:s');
                    $query = $this->db->update($tbl, $data);
                    return true;
                    // return echopre($this->db->last_query());
                } else
                    return $res;
                    // return echopre($this->db->last_query());

            }
            else {
                $this->db->where('ID_VENDOR', $this->session->ID);
                $this->db->where('ID', $idx);
                if ($this->db->update($tbl, $data))
                    return true;
                else
                    return false;
            }
        }
    }

    public function save_data($data) {
        $q = $this->cek_data();
        if ($q) {
            $res = $this->update_data($data);
            return $res;
        } else {
            if (isset($data['update']))
                unset($data['update']);
            $this->db->insert('m_vendor_csms', $data);
            if ($this->db->affected_rows() > 0)
                return true;
            else
                return false;
        }
    }

    public function delete_attch($key) {
        $data=array(
            "STATUS"=>"0",
            "UPDATE_TIME"=>date("Y-m-d H:i:s")
        );
        $query = $this->db->where("ID=", $key)
                ->update("m_vendor_attch_csms",$data);
        if ($query)
            return true;
        else
            return false;
    }

    public function update_data($data) {
        if (isset($data['update']))
            unset($data['update']);
        $query = $this->db->where('ID_VENDOR=', $this->session->ID)
                ->update('m_vendor_csms', $data);
        if ($query)
            return true;
        else
            return false;
    }

    public function get_data() {
        $val = $this->db->select("*")
                ->from('m_vendor_csms')
                ->where("ID_VENDOR=", $this->session->ID)
                ->get();
        if ($val->num_rows() != 0)
            return $val->result();
        else
            return false;
    }

}
