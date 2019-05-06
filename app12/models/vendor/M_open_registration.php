<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_open_registration extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function menu() {
        $data = $this->db->from('m_menu')->where('STATUS', '1')->get();
        return $data->result();
    }

    public function show() {
        $query = $this->db->select('ID,DATE_START,DATE_CLOSE')
                ->from('open_vendor')
                ->where('STATUS', '1')
                ->get();
        if ($query->num_rows() != 0)
            return $query->result();
        else
            return false;
    }

    public function get_data($id) {
        $data = $this->db
                ->select('S.*,T.*,N.*,V.NAMA,V.PREFIX,V.SUFFIX,V.KATEGORI')
                ->from('m_vendor_siup S')
                ->join('m_vendor V', 'V.ID_VENDOR="' . $id . '"', 'right')
                ->join('m_vendor_tdp T', 'T.ID_VENDOR="' . $id . '"', 'right')
                ->join('m_vendor_npwp N', 'N.ID_VENDOR="' . $id . '"', 'right')
                ->where('S.ID_VENDOR=', $id)
                ->get();
        if ($data->num_rows() != 0)
            return $data->result();
        else
            return false;
    }

    public function save_data($data) {
        $this->db->insert('open_vendor', $data);
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }

    public function update_data($data) {
        $query = $this->db
                ->where('ID=', $data['ID'])
                ->update('open_vendor', $data);
        if ($query)
            return true;
        else
            return false;
    }
    
    public function delete_data($data) {
        $query = $this->db
                ->where('ID=', $data['ID'])
                ->update('open_vendor', $data);
        if ($query)
            return true;
        else
            return false;
    }
    
    public function data_search($data, $col) {
        $count = 0;
        if (count($data) > 0) {
            foreach ($data as $k => $v) {
                if ($count == 0) {
                    $this->db->like($col, $v);
                    $count++;
                } else
                    $this->db->or_like($col, $v);
            }
        }
    }
    
    public function filter_data($data) {
        $open = array();
        $close = array();        
        $limit = $data['limit'];
        echopre($data);
        exit;
        foreach ($data as $k => $v) {
            if (strpos($k, 'open') !== false && $v!=null)
                array_push($open,DateTime::createFromFormat('d/m/Y', $v)->format('Y-m-d'));
            if (strpos($k, 'close') !== false && $v!=null)
                array_push($close,DateTime::createFromFormat('d/m/Y', $v)->format('Y-m-d'));            
        }
        $this->db->select("ID,DATE_START,DATE_CLOSE,STATUS")
                ->from("open_vendor");        
        
        $this->db->group_start();
        $this->data_search($open, "DATE_START");
        $this->data_search($close, "DATE_CLOSE");        
        $this->db->group_end();
        
        if($data['status1']!="none"&&$data['status2']=="none")
            $this->db->where("STATUS=", 1);
        else if($data['status2']!="none"&&$data['status1']=="none")
            $this->db->where("STATUS=", 0);
        
        $this->db->limit($limit);        
        $query = $this->db->get();        
        return $query->result();
    }
}

?>
