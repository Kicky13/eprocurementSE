<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_approve_slka extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function menu() {
        $data = $this->db->from('m_menu')->where('STATUS', '1')->get();
        return $data->result();
    }
    
        public function get_email_dest($id) {
        $qry=$this->db->select("TITLE,OPEN_VALUE,CLOSE_VALUE,CATEGORY,ROLES")
                ->from("m_notic ")
                ->where("ID=",$id)                
                ->get();
        if ($qry->num_rows() != 0)
            return $qry->result();  
        else 
            return false;
    }

    public function get_slka($id) {
        $qry = $this->db->select('N.OPEN_VALUE,N.CLOSE_VALUE,V.NO_SLKA as SLKA,A.ADDRESS,A.TELP,A.FAX')
                ->from('m_notic N')
                ->where('N.ID', '14')
                ->join('m_vendor V', 'V.ID=' . $id, 'left')
                ->join('m_vendor_address A', 'A.ID_VENDOR = V.ID', 'left')                
                ->get();
        return $qry->result();
    }
    
     public function get_csms($id)
    {
        $val=$this->db->select("*")
                ->from('m_vendor_csms')
                ->where("ID_VENDOR=",$id)
                ->get();        
        if ($val->num_rows() != 0)
           return $val->result();                
        else
           return false;
        
    }    

    public function get_checklist($id_vendor) {
        return $dt = $this->db
                        ->select("SUM(GENERAL1) GENERAL1, SUM(GENERAL2) GENERAL2, SUM(GENERAL3) GENERAL3, SUM(LEGAL1) LEGAL1, SUM(LEGAL2) LEGAL2, SUM(LEGAL3) LEGAL3, SUM(LEGAL4) LEGAL4, SUM(LEGAL5) LEGAL5, SUM(LEGAL6) LEGAL6, SUM(GNS1) GNS1, SUM(GNS2) GNS2, SUM(GNS3) GNS3, SUM(MANAGEMENT1) MANAGEMENT1, SUM(MANAGEMENT2) MANAGEMENT2, SUM(BNF1) BNF1, SUM(BNF2) BNF2, SUM(CNE1) CNE1, SUM(CNE2) CNE2, SUM(CSMS) CSMS")
                        ->from('m_status_vendor_data')
                        ->where('ID_VENDOR', $id_vendor)
                        ->get()->row_array();
    }

    public function show() {
        $query = $this->db->select('ID,ID_VENDOR,NAMA,STATUS')
                ->from('m_vendor')
                ->where('STATUS', '6')
                ->get();
        if ($query->num_rows() != 0)
            return $query->result();
        else
            return false;
    }

    public function show_update($id) {
        $data = $this->db
                ->select('ID,ID_VENDOR, NAMA')
                ->from('m_vendor')
                //->where('STATUS !=', '0')
                ->where('ID', $id)
                ->group_by(array('ID_VENDOR', 'NAMA'))
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

    public function add($tbl, $data) {
        return $this->db->insert($tbl, $data);

//        echo $this->db->last_query();exit;
    }

    public function upd($nama_id, $tabel, $id, $rubah_data) {
        return $this->db->where($nama_id, $id)->update($tabel, $rubah_data);
    }

    // public function get_contact() {
    //     $query = $this->db
    //             ->select('NAMA,JABATAN,TELP,HP,EMAIL')
    //             ->from('m_vendor_contact')
    //             ->where('ID_VENDOR')
    //             ->get();
    //     return $query->result();
    // }

    public function get_vendor() {
        $query = $this->db
                ->select('NAMA,PREFIX,CLASSIFICATION,CUALIFICATION')
                ->from('m_vendor')
                ->where('STATUS', '0')
                //->where('ID_VENDOR =', $id)
                ->get();
        if ($query->num_rows() != 0)
            return $query->result();
        else
            return false;
    }

    public function get_Country_Code($where) {
        $data = $this->db->from('m_loc_countries')
                ->where($where)
                ->get();
        return $data->result();
    }

    public function get_email($id) {
        $data = $this->db->select('ID_VENDOR')->from('m_vendor')->where('ID', $id)->get();
        return $data->row();
    }

    public function get_url($id) {
        $data = $this->db->select('URL_BATS_HARI')->from('m_vendor')->where('ID', $id)->get();
        return $data->row();
    }

    public function get_legal($id) {
        $data = $this->db->query(
                "SELECT *
            FROM m_vendor as V
            LEFT JOIN m_vendor_legal_other as L
            ON V.ID = L.ID_VENDOR
            LEFT JOIN m_vendor_npwp as N
            ON V.ID = N.ID_VENDOR
            WHERE V.ID =" . $id . " OR (L.CATEGORY='SIUP' OR L.CATEGORY='TDP' OR L.CATEGORY='SKT_EBTKE' OR L.CATEGORY='SKT_MIGAS') AND V.ID =" . $id);
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
        $limit = $data['limit'];
        foreach ($data as $k => $v) {
            if (strpos($k, 'name') !== false && $v != null)
                array_push($name, $v);
            if (strpos($k, 'email') !== false && $v != null)
                array_push($email, $v);
        }
        $this->db->select("ID,ID_VENDOR,NAMA,STATUS")
                ->from("m_vendor");

        $this->db->group_start();
        $this->data_search($name, "NAMA");
        $this->data_search($email, "ID_VENDOR");
        $this->db->group_end();

        if ($data['status1'] != "none" && $data['status2'] == "none")
            $this->db->where("STATUS=", $data['status1']);
        else if ($data['status2'] != "none" && $data['status1'] == "none")
            $this->db->where("STATUS=", $data['status2']);
        else
            $this->db->where("STATUS=", 5);
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result();
    }

    public function tb_servis() {
        $this->db->select('NAMA,PREFIX,CLASSIFICATION,CUALIFICATION')
                ->from('m_vendor')
                ->where('STATUS', '1');
        return $this->db->get();
    }

    //------------------------------------------------------------------------------------------------------------------//
//    public function alamatperusahaan($id) {
//        $data = $this->db->from('m_vendor_address')
//                ->where('STATUS', '1')
//                ->where('ID_VENDOR', $id)
//                ->get();
//        return $data->result();
//    }
    public function alamatperusahaan($where,$limit=false) {
        $this->db->from('m_vendor_address')
                ->where($where);
        if($limit == true)
        {
            $this->db->order_by('CREATE_TIME DESC')->limit(1);
        }
        $data =$this->db->get();
        if ($data->num_rows() != 0)
            return $data->result();
        else
            return false;
    }

    public function datakontakperusahaan($id) {
        $data = $this->db->from('m_vendor_contact')
                ->where('STATUS', '1')
                ->where('ID_VENDOR', $id)
                ->get();
        return $data->result();
    }

    //------------------------------------------------------------------------------------------------------------------//

    public function dataakta($id) {
        $data = $this->db->from('m_vendor_akta')
                ->where('ID_VENDOR', $id)
                ->get();
        return $data->result();
    }

    public function get_alldata() {
        $data = $this->db
                ->select('N.*')
                ->from('m_vendor_npwp N')
                ->where('STATUS', '1')
                ->get();
        return $data->result();
    }

    public function get_legal_others($id) {
        $data = $this->db->from('m_vendor_legal_other')
                ->where('STATUS', '1')
                ->where('ID_VENDOR', $id)
                ->get();
        return $data->result();
    }

    //--------------------------------------------------------------------------------------------------------------------//
    public function show_datasertifikasi($id) {
        $data = $this->db->from('m_vendor_certification')
                ->where('STATUS', '1')
                ->where('ID_VENDOR', $id)
                ->get();
        return $data->result();
    }

    public function daftarjasa($id) {
        $data = $this->db->from('m_vendor_goods_service')
                ->where('STATUS', '1')
                ->where('ID_VENDOR', $id)
                ->get();
        return $data->result();
    }

    public function daftarbarang($id) {
        $data = $this->db->from('m_vendor_goods_service')
                ->where('STATUS', '1')
                ->where('ID_VENDOR', $id)
                ->get();
        return $data->result();
    }

    //----------------------------------------------------------------------------------------------------------------//

    public function show_company_management($id) {
        $data = $this->db->from('m_vendor_directors')
                ->where('STATUS', '1')
                ->where('ID_VENDOR', $id)
                ->get();
        return $data->result();
    }

    public function show_vendor_shareholders($id) {
        $data = $this->db->from('m_vendor_shareholders')
                ->where('STATUS', '1')
                ->where('ID_VENDOR', $id)
                ->get();
        return $data->result();
    }

    //--------------------------------------------------------------------------------------------------------------------//

    public function show_vendor_bank_account($id) {
        $data = $this->db->from('m_vendor_bank_account')
                ->where('STATUS', '1')
                ->where('ID_VENDOR', $id)
                ->get();
        return $data->result();
    }

    public function show_financial_bank_data($id) {
        $data = $this->db->from('m_vendor_balance_sheet')
                ->where('STATUS', '1')
                ->where('ID_VENDOR', $id)
                ->get();
        return $data->result();
    }

    //-----------------------------------------------------------------------------------------------------------------//
    public function show_experience_experience($id) {
        $data = $this->db->from('m_vendor_experience')
                ->where('STATUS', '1')
                ->where('ID_VENDOR', $id)
                ->get();
        return $data->result();
    }

    public function show_certification($id) {
        $data = $this->db->from('m_vendor_certification')
                ->where('STATUS', '1')
                ->where('ID_VENDOR', $id)
                ->get();
        return $data->result();
    }

}

?>
