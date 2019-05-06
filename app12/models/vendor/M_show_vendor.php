<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_show_vendor extends CI_Model {

    protected $table = 'm_vendor';

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function menu() {
        $data = $this->db->from('m_menu')->where('STATUS', '1')->get();
        return $data->result();
    }    
    
    public function get_comment($id,$type)
    {        
        $qry = $this->db->select('SENDER,VALUE,TIME')
                ->from('m_status_vendor_chat')                
                ->group_start()
                    ->where('RECEIVER',$id)
                    ->or_where('SENDER',$id)
                ->group_end()
                ->where('TYPE',$type)
                ->order_by('TIME ASC')
                ->get();
        if ($qry->num_rows() != 0)
           return $qry->result();                
        else
           return false;
    }
    public function get_slka_data()
    {        
        $qry = $this->db->select('N.OPEN_VALUE,N.CLOSE_VALUE,A.ADDRESS,A.TELP,A.FAX')
                ->from('m_notic N')
                ->where('N.ID', '14')                
                ->join('m_vendor_address A', 'A.ID_VENDOR = N.ID', 'left')                              
                ->limit(1)
                ->get();
        return $qry->result();
    }
    
    public function get_slka()            
    {
        $qry=$this->db->select('MAX(NO_SLKA) as NO_SLKA')
            ->from('m_vendor')            
//            ->order_by('NO_SLKA DESC')
//            ->limit('1')
            ->get();
            if ($qry->num_rows() != 0)
            return $qry->result();                
         else
            return false;
        
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

    public function show() {
        $query = $this->db->select('ID,ID_VENDOR,NAMA,STATUS')
                ->from('m_vendor')
                ->where_in('STATUS', array('5','12','13'))
                ->get();
        if ($query->num_rows() != 0)
            return $query->result();
        else
            return false;
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
    
    //check list
    public function get_checklist($id_vendor){
        $dt = $this->db
                ->select("SUM(GENERAL1) GENERAL1, SUM(GENERAL2) GENERAL2, SUM(GENERAL3) GENERAL3, SUM(LEGAL1) LEGAL1, SUM(LEGAL2) LEGAL2, SUM(LEGAL3) LEGAL3, SUM(LEGAL4) LEGAL4, SUM(LEGAL5) LEGAL5, SUM(LEGAL6) LEGAL6,SUM(LEGAL7) LEGAL7,SUM(LEGAL8) LEGAL8, SUM(GNS1) GNS1, SUM(GNS2) GNS2, SUM(GNS3) GNS3, SUM(MANAGEMENT1) MANAGEMENT1, SUM(MANAGEMENT2) MANAGEMENT2, SUM(BNF1) BNF1, SUM(BNF2) BNF2, SUM(CNE1) CNE1, SUM(CNE2) CNE2, SUM(CSMS) CSMS")
                ->from('m_status_vendor_data')
                ->where('ID_VENDOR', $id_vendor)
                ->where('STATUS','1')
                ->get();        
        return $dt->row_array();
        
    } 
    
    public function cek($post){
        return $dt = $this->db->select('ID')->from('m_status_vendor_data')->where('ID_VENDOR', $post['id'])->where('STATUS','1')->get()->result();
    }
    
    public function add($tbl, $data){
        $dt = $this->db->insert($tbl, $data);
        return $dt;
    }
    
    public function upd($nama_id, $tabel, $id, $rubah_data){
        return $this->db->where($nama_id, $id)->update($tabel, $rubah_data);
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
    
    public function get_name($id) {
        $data = $this->db->select('NAMA')->from('m_vendor')->where('ID', $id)->get();
        return $data->row();
    }
    
    public function add_show_vendor($tbl, $data) {
        $this->db->insert($tbl, $data);
//        echo $this->db->last_query();exit;
    }
    
    public function update($nama_id, $tabel, $id, $data){
        return $this->db->where($nama_id, $id)->update($tabel, $data);
    }

    public function get_vendor($id) {
        $query = $this->db
                ->select('NAMA,PREFIX,CLASSIFICATION,CUALIFICATION')
                ->from('m_vendor')
                //->where('STATUS', '1')
                ->where('ID_VENDOR =', $id)
                ->get();
        if ($query->num_rows() != 0)
            return $query->result();
        else
            return false;
    }

    public function get_legal($id) {
        $data = $this->db->query(
            "SELECT *
            FROM m_vendor as V
            LEFT JOIN m_vendor_legal_other as L
            ON V.ID = L.ID_VENDOR
            LEFT JOIN m_vendor_npwp as N
            ON V.ID = N.ID_VENDOR
            WHERE  V.ID =".$id." OR (L.CATEGORY='SIUP' OR L.CATEGORY='TDP' OR L.CATEGORY='SKT_EBTKE' OR L.CATEGORY='SKT_MIGAS' OR L.CATEGORY='SPPKP' OR L.CATEGORY='SKT_PAJAK') AND V.ID =".$id);                            
        return $data->result_array();
    }

    public function data_approve($data) {
        $query = $this->db
                ->set('V.STATUS', 7)
                ->where('V.ID_VENDOR=', $data['ID_VENDOR'])
                ->update('m_vendor V');
        $query2 = $this->db
                ->set('V.STATUS', 7)
                ->where('V.ID_VENDOR=', $data['ID_VENDOR'])
                ->update('log_vendor_acc V');
        if ($query && $query2)
            return true;
        else
            return $this->db->last_query();
    }

    public function data_reject($data) {
        $query = $this->db
                ->set('V.STATUS', 6)
                ->where('V.ID_VENDOR=', $data['ID_VENDOR'])
                ->update('m_vendor V');
        $query2 = $this->db
                ->set('V.STATUS', 6)
                ->where('V.ID_VENDOR=', $data['ID_VENDOR'])
                ->update('log_vendor_acc V');
        if ($query && $query2)
            return true;
        else
            return $this->db->last_query();
    }
    
    public function data_search($data, $col) {
        $count = 0;
        if (count($data) > 0) {
            foreach ($data as $k => $v) {
                if ($count == 0) {
                    $this->db->like($col, $v);
                    $count++;
                }                
                else
                    $this->db->or_like($col, $v);
            }
        }
    }
    
    public function filter_data($data) {
        $name = array();
        $email = array();        
        $status =array();
        $limit = $data['limit'];
        foreach($data['STATUS'] as $k => $v)
        {
            array_push($status,$v);
        }
        foreach ($data as $k => $v) {
            if (strpos($k, 'name') !== false && $v!=null)
                array_push($name,$v);
            if (strpos($k, 'email') !== false && $v!=null)
                array_push($email,$v);            
        }        
        $this->db->select("ID,ID_VENDOR,NAMA,STATUS")
                ->from("m_vendor");        
        
        $this->db->group_start();
        $this->data_search($name, "NAMA");
        $this->data_search($email, "ID_VENDOR");        
        $this->db->where_in("STATUS",$status);
        $this->db->group_end();
                
        $this->db->limit($limit);          
        $query = $this->db->get();         
        return $query->result();
    }

    public function tb_servis()
    {
        $this->db->select('NAMA,PREFIX,CLASSIFICATION,CUALIFICATION')
                 ->from('m_vendor')
                 ->where('STATUS', '1');
        return $this->db->get();
    }
               
    //------------------------------------------------------------------------------------------------------------------//

    public function alamatperusahaan($id) {
        $data = $this->db->from('m_vendor_address')
                         ->where('STATUS', '1')
                         ->where('ID_VENDOR', $id)
                         ->get();
        return $data->result();
    }

    public function qdatakontakperusahaan($id) {
        $data = $this->db->from('m_vendor_contact')
                          ->where('STATUS', '1')
                         ->where('ID_VENDOR', $id)
                          ->get();
        return $data->result();
    }
    
    public function datakontakperusahaan($id){
        return $dt = $this->db
                ->select("NAMA, JABATAN, TELP, EMAIL, HP")
                ->from('m_vendor_contact')->where('ID_VENDOR', $id)->get()->result();
    } 


    //------------------------------------------------------------------------------------------------------------------//

    public function dataakta($id) {
        $data = $this->db->from('m_vendor_akta')
                         ->where('STATUS', '1')
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

    public function get_legal_others() {
        $data = $this->db->from('m_vendor_legal_other')
                         ->where('STATUS', '1')
                         //->where('ID_VENDOR', $id)
                         ->get();
        return $data->result();
    }

    // public function get_alldata() {
    //     $data = $this->db->from('m_vendor_npwp')
    //                      ->where('STATUS', '1')
    //                      ->get();
    //     return $data->result();
    // }

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
        $data = $this->db->from('m_vendor_legal_other')
                         ->where('CATEGORY','CERTIFICATION')
                         ->where('STATUS', '1')
                         ->where('ID_VENDOR', $id)
                         ->get();
        return $data->result();
    }
    
   public function find($id)
   {
        return @$this->db->where('ID', $id)->get($this->table)->result()[0];
   } 

}

?>
