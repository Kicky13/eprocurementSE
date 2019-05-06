<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_send_invitation extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function menu() {
        $data = $this->db->from('m_menu')->where('STATUS', '1')->get();
        return $data->result();
    }

    public function show() {
        $data = $this->db
                ->select('ID, ID_VENDOR, NAMA, URL_BATAS_HARI, STATUS, URL')
                ->from('m_vendor')
                ->where('STATUS !=', '0')
                ->order_by("CREATE_TIME DESC")
                ->get();
        return $data->result();
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
        $name = array();
        $email = array();
        $link = array();
        $limit = $data['limit'];
        foreach ($data as $k => $v) {
            if (strpos($k, 'name') !== false && $v!=null)
                array_push($name, $v);
            if (strpos($k, 'email') !== false && $v!=null)
                array_push($email, $v);
            if (strpos($k, 'link') !== false && $v!=null)
                array_push($link, $v);
        }
        $this->db->select("ID,ID_VENDOR,NAMA,URL_BATAS_HARI,STATUS")
                ->from("m_vendor");

        $this->db->group_start();
        $this->data_search($name, "NAMA");
        $this->data_search($email, "ID_VENDOR");
        $this->data_search($link, "URL_BATAS_HARI");
        $this->db->group_end();

        if($data['status1']!="none"&&$data['status2']=="none")
            $this->db->where("STATUS=", 1);
        else if($data['status2']!="none"&&$data['status1']=="none")
            $this->db->where("STATUS=", 0);

        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result();
    }

    public function show_status_review(){
        $data = $this->db->from('m_status_vendor')->where("STATUS", 22);
        return $data->result();
    }

    public function show_status(){
        $data = $this->db->from('m_status_vendor')->get();
        return $data->result();
    }

    public function show_owner(){
        $data = $this->db->select("ID_USER,USERNAME")->from('m_user')->where("STATUS=1")->get();
        return $data->result();
    }

    public function cek($tbl, $nama, $email){
        $data = $this->db->from($tbl)
                ->where('NAMA', $nama)
                ->or_where('ID_VENDOR', $email)
                //->where('STATUS >','0')
                ->get();
        if ($data->num_rows() != 0)
            return $data->result();  
        else 
            return false;
    }        
    
    public function get_email_dest() {
        $qry=$this->db->select("TITLE,OPEN_VALUE,CLOSE_VALUE,CATEGORY,ROLES")
                ->from("m_notic ")
                ->where("ID=","1")                
                ->get();
        if ($qry->num_rows() != 0)
            return $qry->result();  
        else 
            return false;
    }
    
    public function get_user($dt,$cnt=0) {
        $this->db->select("EMAIL")
                ->from("m_user ")
                ->group_start();
        if ($cnt != 0) {
            foreach ($dt as $k => $v) {
                if ($k == 0)
                    $this->db->like("ROLES", ',' . $v . ',');
                else
                    $this->db->or_like("ROLES", ',' . $v . ',');
            }
        } else
            $this->db->like("ROLES", $dt);
        $qry = $this->db->group_end()
                ->where("STATUS=", "1")
                ->get();        
        if ($qry->num_rows() != 0)
            return $qry->result();
        else
            return false;
    }
    
    public function show_detail($id) {
        $data = $this->db
                ->select('L.ID_VENDOR, L.STATUS, NAMA, L.CREATE_BY, L.CREATE_TIME, L.NOTE ')
                ->from('m_vendor M')
                ->join('log_vendor_acc L', 'M.ID_VENDOR = L.ID_VENDOR')
                ->where('M.STATUS !=', '0')
                ->where('M.ID', $id)
                ->order_by('L.CREATE_TIME DESC')
                ->get();
//        echo $this->db->last_query();exit;
        return $data->result();
    }

    public function update2($id) {
        $data = $this->db
                ->select('ID, STATUS, NOTE, CREATE_BY, CREATE_TIME')
                ->from('log_vendor_acc')
                ->where('STATUS !=', '1')
                ->where('ID', $id)
                ->group_by(array('ID, STATUS, NOTE, CREATE_BY, CREATE_TIME'))
                ->get();
//        echo $this->db->last_query();exit;
        return $data->result();
    }

    public function show_edit($id) {        
        $data = $this->db
                ->select('*')
                ->from('m_vendor')                                                                
                ->where('ID', $id)
                ->get();
        return $data->result();
    }

    public function add($tbl, $data) {
        return $this->db->insert($tbl, $data);
//        echo $this->db->last_query();exit;
    }

    public function update($nama_id, $tabel, $id, $data){
        return $this->db->where($nama_id, $id)->update($tabel, $data);
    }

    public function show_temp_email($id) {
        $data = $this->db
                ->select('*')
                ->from('m_notic')
                ->where('ID', $id)
                ->get();
        return $data->row();
    }

    public function get_email($id) {
        $data = $this->db->select('ID_VENDOR')->from('m_vendor')->where('ID', $id)->get();
        return $data->row();
    }

    public function get_hari($id) {
        $data = $this->db->select('URL_BATAS_HARI')->from('m_vendor')->where('ID', $id)->get();
        return $data->row();
    }
    
    public function get_nama($id) {
        $data = $this->db->select('NAMA')->from('m_vendor')->where('ID', $id)->get();
        return $data->row();
    }

     public function show2($where = null) {
        if ($where != null) {
            $this->db->where($where);
        }
        $data = $this->db->from('log_vendor_acc');
        return $data->result();
    }

//    public function show_join($tbl, $where, $tbl2, $gabung, $jenis_join, $sel, $order = null, $group_by = null, $tbl3 = null, $gabung2 = null) {
//        if ($group_by != null) {$this->db->group_by($group_by);}
//
//        if ($order != null) {$this->db->order_by($order);}
//        if ($tbl3 != null) {$this->db->join($tbl3, $gabung2, $jenis_join);}
//        $data = $this->db->select($sel)
//                        ->from($tbl)
//                        ->join($tbl2, $gabung, $jenis_join)
//                        ->where($where)
//                        ->get();
////        echo $this->db->last_query();exit;
//        return $data->result_array();
//    }
//
//
//    public function edit($tbl, $data, $where){
//        $this->db->where($where)->update($tbl, $data);
////        echo $this->db->last_query();exit;
//    }
}

?>
