<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_invite_acc extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function menu() {
        $data = $this->db->from('m_menu')->where('STATUS', '1')->get();
        return $data->result();
    }
    public function get_email_dest() {
        $qry=$this->db->select("TITLE,OPEN_VALUE,CLOSE_VALUE,CATEGORY,ROLES")
                ->from("m_notic ")
                ->where("ID=","8")                
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

    public function show() {
        $data = $this->db
                ->select('M.ID_VENDOR,M.ID, NAMA, URL_BATAS_HARI, M.CREATE_BY, M.CREATE_TIME, M.STATUS, MAX(L.CREATE_TIME) AS time ')
                ->from('m_vendor M')
                ->join('log_vendor_acc L', 'M.ID_VENDOR = L.ID_VENDOR', 'left')
                ->where('M.STATUS', '1')
                ->group_by(array('M.ID_VENDOR', 'NAMA', 'URL_BATAS_HARI', 'CREATE_BY', 'CREATE_TIME','M.ID'))
                ->order_by('M.CREATE_TIME DESC')
                ->get();
//        echo $this->db->last_query();exit;
        return $data->result();
    }
    
   public function show_detail($id) {        
        $data = $this->db
                ->select('L.ID_VENDOR, L.STATUS, NAMA, L.CREATE_BY, L.CREATE_TIME, L.NOTE ')
                ->from('m_vendor M')
                ->join('log_vendor_acc L', 'M.ID_VENDOR = L.ID_VENDOR')
                ->where('M.STATUS !=', '1')
                ->where('M.ID', $id)                
                ->order_by('L.CREATE_TIME DESC')
                ->get();
//        echo $this->db->last_query();exit;
        return $data->result();
    }
    
    public function show_update($id) {        
        $data = $this->db
                ->select('ID,ID_VENDOR, NAMA, URL_BATAS_HARI')
                ->from('m_vendor')                
                ->where('STATUS !=', '0')
                ->where('ID', $id)
                ->group_by(array('ID_VENDOR', 'NAMA' , 'URL_BATAS_HARI'))                
                ->get();
//        echo $this->db->last_query();exit;
        return $data->result();
    }
    
    public function add($tbl, $data) {
        $this->db->insert($tbl, $data);
//        echo $this->db->last_query();exit;
    }
    
    public function update($nama_id, $tabel, $id, $rubah_data){
        return $this->db->where($nama_id, $id)->update($tabel, $rubah_data);
    }
    
    
    public function cek($tbl, $nama, $email){
        $data = $this->db->from($tbl)
                ->where('NAMA', $nama)
                ->or_where('ID_VENDOR', $email)
                ->get();
//        echo $this->db->last_query();exit;
        return $data->result();
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
    public function get_url($id) {
        $data = $this->db->select('URL_BATS_HARI')->from('m_vendor')->where('ID', $id)->get();
        return $data->row();
    }

    public function hapus_data($id) {
        $data = array(
           'STATUS' => "3",
              //'PASSWORD' => $pass,
             // 'URL' => $mini_url,
        );
        $query = $this->db
                ->where('ID=', $id)
                ->update('m_vendor_shareholders',$data);
        if ($query)
            return true;
        else
            return $query;
    }
//    public function show_join($tbl, $where, $tbl2, $gabung, $jenis_join, $sel, $order = null, $email_by = null, $tbl3 = null, $gabung2 = null) {
//        if ($email_by != null) {$this->db->email_by($email_by);}
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
