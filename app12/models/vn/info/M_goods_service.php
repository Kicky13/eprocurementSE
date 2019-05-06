<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_goods_service extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function check_data($dt)
    {
        $query = $this->db->select('NAME')
        ->from("m_vendor_goods_service")
        ->where('ID_VENDOR=', $this->session->ID)
        ->where('TYPE=',"GOODS")
        ->where('NAME=',$dt['GOODS_NAME'])
        ->where('STATUS=',"1")
        ->get();
        if ($query->num_rows() == 0)
            return false;
        else
            return true;
    }

    public function cek_keys($id, $tbl,$typ=null, $chk = null) {
        $this->db->select('KEY')
                ->from($tbl);
        if($typ != null)
            $this->db->where("TYPE",$typ);
        if ($chk == null)
            $this->db->where('ID_VENDOR=', $id);
        else
            $this->db->where($chk . '=', $id);
        $query = $this->db->order_by('KEY DESC')
                ->limit(1)
                ->get();
        if ($query->num_rows() != 0)
            return $query->result();
        else
            return false;
    }

/*================================================    Update Service     ========================================*/

    public function update_service($data) {
        $query = $this->db->where("KEY=", $data['KEY'])
                ->where("ID_VENDOR", $data['ID_VENDOR'])
                ->where("TYPE", "SERVICE")
                ->update("m_vendor_goods_service", $data);
        if ($query)
            return true;
        else
            return false;
    }

    public function update_consul($data) {
        $query = $this->db->where("KEY=", $data['KEY'])
                ->where("ID_VENDOR", $data['ID_VENDOR'])
                ->where("TYPE", "CONSULTATION")
                ->update("m_vendor_goods_service", $data);
        if ($query)
            return true;
        else
            return false;
    }

    public function conv_data($dt)
    {
        $query = $this->db->select('ID')
        ->from("m_material_group")
        ->where('TYPE=', $dt['TYPE'])
        ->where('CATEGORY=',$dt['CATEGORY'])
        ->where('DESCRIPTION=',$dt['DATA'])
        ->get();

        if ($query->num_rows() != 0)
            return $query->result();
        else
            return false;
    }

    public function update_cert($data) {
        $query = $this->db->where("KEY=", $data['KEY'])
                ->where("CREATE_BY", $data['CREATE_BY'])
                ->update("m_vendor_certification", $data);
        if ($query)
            return true;
        else
            return false;
    }

    public function update_goods($data) {
        $query = $this->db->where("KEY=", $data['KEY'])
                ->where("ID_VENDOR", $data['ID_VENDOR'])
                ->where("TYPE", "GOODS")
                ->update("m_vendor_goods_service", $data);
        if ($query)
            return true;
        else
            return false;
    }

    public function update_goods_pilih($data) {
        $query = $this->db->where("KEY=", $data['KEY'])
                ->where("ID_VENDOR", $data['ID_VENDOR'])
                ->where("TYPE", "GOODS")
                ->update("m_vendor_goods_service", $data);
        if ($query)
            return true;
        else
            return false;
    }

/*================================================    Add Service     ========================================*/

    public function add_cert($data) {
        $key = $this->cek_keys($this->session->ID, "m_vendor_certification");
        if ($key == false)
            $data['KEY'] = 1;
        else
            $data['KEY'] = $key[0]->KEY + 1;
        $this->db->insert("m_vendor_certification", $data);
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }

    public function add_service($data) {
        $key = $this->cek_keys($data['ID_VENDOR'], "m_vendor_goods_service","SERVICE");
        if ($key == false)
            $data['KEY'] = 1;
        else
            $data['KEY'] = $key[0]->KEY + 1;
        $this->db->insert("m_vendor_goods_service", $data);
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }

    public function add_consul($data) {
        $key = $this->cek_keys($data['ID_VENDOR'], "m_vendor_goods_service","CONSULTATION");
        if ($key == false)
            $data['KEY'] = 1;
        else
            $data['KEY'] = $key[0]->KEY + 1;
        $this->db->insert("m_vendor_goods_service", $data);
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }

    public function add_goods($data) {
        $key = $this->cek_keys($data['ID_VENDOR'], "m_vendor_goods_service","GOODS");
        if ($key == false)
            $data['KEY'] = 1;
        else
            $data['KEY'] = $key[0]->KEY + 1;
        $this->db->insert("m_vendor_goods_service", $data);
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }

    public function add_goods_pilih($data) {
        $key = $this->cek_keys($data['ID_VENDOR'], "m_vendor_goods_service","GOODS");
        if ($key == false)
            $data['KEY'] = 1;
        else
            $data['KEY'] = $key[0]->KEY + 1;
        $this->db->insert("m_vendor_goods_service", $data);
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }
/*================================================    Get Service     ========================================*/
    public function get_produk($dt)
    {
        $query=$this->db->select('MATERIAL_NAME,DESCRIPTION,DESCRIPTION1,IMG1_URL,IMG2_URL,IMG3_URL,IMG4_URL')
                        ->from('m_material')
                        ->where('EQPMENT_ID=',$dt['group'])
                        ->get();
        if($query->num_rows()>0)
            return $query->result();
        else
            return false;
    }

    public function get_data() {
        $query = $this->db->select("ID,DESCRIPTION,TYPE,MATERIAL_GROUP")
                ->from("m_material_group")
                ->where("CATEGORY=","CLASIFICATION")
                ->where("STATUS =", "1")
                ->group_start()
                ->where("TYPE =", "SERVICE")
                ->or_where("TYPE =", "GOODS")
                ->or_where("TYPE =", "CONSULTATION")
                ->group_end()
                ->order_by("MATERIAL_GROUP", "ASC")
                ->get();
        return $query->result();
    }

    public function get_group($id) {
        $this->db->select("ID,DESCRIPTION,MATERIAL_GROUP")
                ->from("m_material_group")
                ->where("STATUS","1")
                ->where("ID =",$id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_all_group($type)
    {
        $query = $this->db->select("ID,DESCRIPTION,CATEGORY")
                ->from("m_material_group")
                ->where("TYPE",$type)
                ->get();
        if ($query->num_rows() != 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    public function get_sub($type,$prnt) {
        $query = $this->db->select("ID,MATERIAL_GROUP,DESCRIPTION")
                ->from("m_material_group")
                ->where("PARENT =",$prnt)
                ->where("TYPE =",$type)
                ->where("CATEGORY =","GROUP")
                ->where("STATUS","1")
                ->order_by("ID","ASC")
                ->get();
        return $query->result();
    }

    public function get_cert($id) {
        $query = $this->db->select("ID,KEY,NO_DOC,ISSUED_BY,FILE_URL,VALID_SINCE,VALID_UNTIL,DESCRIPTION")
                ->from("m_vendor_certification")
                ->where("ID_VENDOR =", $id)
                ->where("STATUS =", "1")
                ->order_by("KEY ASC")
                ->get();
        if ($query->num_rows() != 0) {
            return $query->result();
        } else
            return null;
    }

    public function get_goods($id) {
        $query = $this->db->select("v.NAME,v.KEY,v.DESCRIPTION,m.DESCRIPTION as GROUP,m2.DESCRIPTION as SUB_GROUP,v.MERK,v.AGEN_STATUS,v.CERT_NO,v.FILE_URL")
        ->from("m_vendor_goods_service v")
        ->join("m_material_group m", "m.ID=v.GROUP","")
        ->join("m_material_group m2", "m2.ID=v.SUB_GROUP","")
        ->where("v.ID_VENDOR =",$this->session->ID)
        ->where("v.TYPE =","GOODS")
        ->where("v.STATUS =", "1")
        ->order_by("v.KEY ASC")
        ->get();
        if ($query->num_rows() != 0) {
            return $query->result();
        } else
            return false;
    }

    public function get_service($id) {
        $query = $this->db->select("ID_VENDOR,KEY,GROUP,SUB_GROUP,NAME,DESCRIPTION,CERT_NO")
                ->from("m_vendor_goods_service")
                ->where("ID_VENDOR =", $id)
                ->where("TYPE =","SERVICE")
                ->where("STATUS =", "1")
                ->order_by("KEY ASC")
                ->get();
        if ($query->num_rows() != 0) {
            return $query->result();
        } else
            return null;
    }

    public function material_vendor()
    {
        $qry=$this->db->select("CLASSIFICATION")
                ->from('m_vendor')
                ->where('ID',$this->session->ID)
                ->get();
        return $qry->result();
    }

    public function get_consul($id) {
        $query = $this->db->select("ID_VENDOR,KEY,GROUP,SUB_GROUP,NAME,DESCRIPTION,CERT_NO")
                ->from("m_vendor_goods_service")
                ->where("ID_VENDOR =", $id)
                ->where("TYPE =","CONSULTATION")
                ->where("STATUS =", "1")
                ->order_by("KEY ASC")
                ->get();
        if ($query->num_rows() != 0) {
            return $query->result();
        } else
            return null;
    }

    public function get_doc($id, $key = null, $sel, $table, $other = null) {
        $this->db->select($sel);
        $this->db->from($table);
        $this->db->where('ID_VENDOR=', $id);
        if ($key != null)
            $this->db->where('KEY=', $key);
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            return $query->result();
        } else
            return false;
    }

/*================================================    Delete Service     ========================================*/
    public function delete_service($key, $id) {
        $data=array(
            "STATUS"=>"0",
            "UPDATE_TIME"=>date("Y-m-d H:i:s")
        );
        $query = $this->db->where("KEY=", $key)
                ->where("ID_VENDOR=", $id)
                ->where("TYPE=", "SERVICE")
                ->update("m_vendor_goods_service",$data);
        if ($query)
            return true;
        else
            return false;
    }

    public function delete_goods($key) {
        $data=array(
            "STATUS"=>"0",
            "UPDATE_TIME"=>date("Y-m-d H:i:s")
        );
        $query = $this->db->where("KEY=", $key)
                ->where("ID_VENDOR=", $this->session->ID)
                ->where("TYPE=", "GOODS")
                ->update("m_vendor_goods_service",$data);
        if ($query)
            return true;
        else
            return false;
    }

    public function delete_cert($id,$vend) {
        $data=array(
            "STATUS"=>"0",
            "UPDATE_BY"=>$vend,
            "UPDATE_TIME"=>date("Y-m-d H:i:s")
        );
        $query = $this->db->where("ID=", $id)
                ->update("m_vendor_certification",$data);
        if ($query)
            return true;
        else
            return false;
    }

}
