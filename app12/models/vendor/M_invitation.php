<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_invitation extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function menu() {
        $data = $this->db->from('m_menu')->where('STATUS', '1')->get();
        return $data->result();
    }

    public function show() {

        $data = $this->db->query(
            "SELECT v.ID, v.ID_VENDOR, v.NAMA,'' as SEND_DATE, v.URL_BATAS_HARI,v.URL,CASE WHEN t.extra_case='1' THEN 'SUPPLIER FILLING FORM' ELSE COALESCE(t.description,' ') END as STATUS,'' as ATTACHMENT,a.NOTE,t.status_approve,t.extra_case,t.sequence, v.FILE
            FROM (
                SELECT MIN(s.id) as id,s.supplier_id,MIN(s.sequence),MAX(l.CREATE_TIME) as cr_time,l.NOTE as NOTE
                FROM t_approval_supplier s
                LEFT join log_vendor_acc l ON l.ID_VENDOR = s.supplier_id AND l.STATUS=1
                WHERE (s.status_approve=0 or s.status_approve=2)
                GROUP BY s.supplier_id,l.NOTE
            ) a
            JOIN t_approval_supplier t ON t.id=a.id
            JOIN m_vendor v ON t.supplier_id=v.id AND v.status != 0
            WHERE t.sequence <= 3 OR (t.sequence = '4' AND t.status_approve = '0' AND t.extra_case = '1')
            ");

        // echo $this->db->last_query();
        return $data->result_array();
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
        $data = $this->db->select("ID_USER,USERNAME,NAME")->from('m_user')->where("STATUS=1")->get();
        return $data->result();
    }

    public function cek($tbl, $nama, $email){
        $data = $this->db->from($tbl)
                ->where('NAMA', $nama)
                ->or_where('ID_VENDOR', $email)
                //->where('STATUS >','0')
                ->get();
        if ($data->num_rows() != 0) {
          return $data->result();
        } else {
          return false;
        }
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

    public function get_rule_approval() {
        $qry=$this->db->select("user_roles")
                ->from("m_approval_rule ")
                ->where("module=","1")
                ->where("sequence=","2")
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
        $data = $this->db->query("select M.ID_VENDOR, L.STATUS, NAMA, L.CREATE_BY, L.CREATE_TIME, L.NOTE FROM m_vendor M JOIN log_vendor_acc L ON M.ID_VENDOR = L.ID_VENDOR OR L.ID_VENDOR=M.ID WHERE M.STATUS != '0' AND M.ID = '".$id."' ORDER BY L.CREATE_TIME DESC");
       // echo $this->db->last_query();exit;
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

    public function add($data) {
        $qry=$this->db->query(
            'INSERT into t_approval_supplier
            SELECT NULL,
                (SELECT ID FROM m_vendor WHERE ID_VENDOR = \''.$data["ID_VENDOR"].'\') as
                suppiler_id,
                a.user_roles,
                a.sequence,
                CASE WHEN a.sequence=1 THEN \'1\' ELSE \'0\' END as status_approve,
                a.description,
                a.reject_step,
                a.email_approve,
                a.email_reject,
                a.edit_content,
                a.module,
                a.extra_case,
                CASE WHEN a.sequence=1 THEN \'Approved\' ELSE NULL END as note,
                CASE WHEN a.sequence=1 THEN \''.$this->session->userdata('ID_USER').'\' ELSE NULL END as approve_by,
                now(),
                now()
            from m_approval_rule a
            JOIN m_approval_modul m ON m.description=\'SUPPLIER REGISTRASI\'
            WHERE a.module=m.id and a.status=1 order by a.sequence');
    }

    public function add_data($tbl, $data) {
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

     public function show_log_vendor_acc($where = null) {
        if ($where != null) {
          $and_where = 'ID_VENDOR = "'.$where.'" ';
        } else {
          $and_where = '1=1';
        }
        $data = $this->db->query('SELECT DISTINCT ID_VENDOR, NOTE FROM log_vendor_acc WHERE '.$and_where.' ');
        return $data->row_array();
    }

}

?>
