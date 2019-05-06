<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_legal_data extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function cek_akta($id) {
        $query = $this->db->select('KEY_AKTA')
                ->from('m_vendor_akta')
                ->where('ID_VENDOR=', $id)
                ->order_by('KEY_AKTA DESC')
                ->limit(1)
                ->get();
        if ($query->num_rows() != 0)
            return $query->result();
        else
            return false;
    }

    public function get_data_siup()
    {
        $res= $this->db->select('ID,CATEGORY')
                        ->from('m_vendor_legal_other')
                        ->group_start()
                        ->where('CATEGORY=\'SIUP\'')
                        ->or_where('CATEGORY=\'BKPM\'')
                        ->group_end()
                        ->where('ID_VENDOR',$_SESSION['ID'])
                        ->order_by('CATEGORY ASC')
                        ->get();
        if ($res->num_rows() != 0) {
            return $res->result();
        } else {
            return false;
        }
    }

    public function delete_dt($pil)
    {
        $dt['STATUS']=0;
        if($pil=='BKPM')
            $pil='SIUP';
        else
            $pil='BKPM';
        return $this->db->where('CATEGORY=',$pil)
                ->where('ID_VENDOR=',$_SESSION['ID'])
                ->update('m_vendor_legal_other',$dt);
    }

    public function cek_data($id, $tbl, $catg) {
        if ($catg == null) {
            $this->db->select('ID_VENDOR')->from($tbl);
            $this->db->where('ID_VENDOR =', $id);
        } else {
            $this->db->select('ID')->from($tbl);
            $this->db->where('ID_VENDOR =', $id);
            $this->db->where('CATEGORY =', $catg);
        }
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_doc($id, $key = null, $sel, $table, $other = null) {
        $this->db->select($sel);
        $this->db->from($table);
        if ($other != null) {
            $this->db->where('ID_VENDOR=', $id);
            $this->db->where('CATEGORY=', $other);
        } else
            $this->db->where('ID_VENDOR=', $id);
        if ($key != null)
            $this->db->where('KEY_AKTA=', $key);
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            return $query->result();
        } else
            return false;
    }

    public function get_file($file, $tbl) {
        if ($file != "NPWP")
            $this->db->select('FILE_URL')
            ->where('CATEGORY', $file)
            ->where('ID_VENDOR',$this->session->ID);
        else
            $this->db->select('NPWP_FILE')->where("ID_VENDOR=",$this->session->ID);
        $tamp = $this->db->from($tbl)
                ->where('STATUS', '1')
                ->get();
        return $tamp->result();
    }

    public function remove_doc($pil, $data) {
        $count = 0;
        foreach ($data as $k => $v) {
            if ($pil == "SIUP/")
                unlink("upload/LEGAL_DATA/" . $pil . $v->FILE_URL);
            else if ($pil == "TDP/")
                unlink("upload/LEGAL_DATA/" . $pil . $v->FILE_URL);
            else if ($pil == "NPWP/")
                unlink("upload/LEGAL_DATA/" . $pil . $v->NPWP_FILE);
            else if ($pil == "EBTKE/")
                unlink("upload/LEGAL_DATA/" . $pil . $v->FILE_URL);
            else if ($pil == "MIGAS/")
                unlink("upload/LEGAL_DATA/" . $pil . $v->FILE_URL);
        }
    }

    public function add_data_akta($data_akta) {
        $key = $this->cek_akta($this->session->ID);
        if ($key == false)
            $data_akta['KEY_AKTA'] = 1;
        else
            $data_akta['KEY_AKTA'] = $key[0]->KEY_AKTA + 1;
        $this->db->insert('m_vendor_akta', $data_akta);
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }

    public function add_data_file($data, $tbl, $nfile, $path, $pil = null) {
        $key = null;
        $other = null;
        $id = null;
        if (isset($data['CATEGORY'])) {
            $other = $data['CATEGORY'];
            $id = $this->session->ID;
        } else
            $id = $this->session->ID;
        if ($tbl == "m_vendor_legal_other")
            $key = $this->cek_data($this->session->ID, $tbl, $data['CATEGORY']);
        else
            $key = $this->cek_data($this->session->ID, $tbl, null);
        if ($key == false) {
            $this->db->insert($tbl, $data);
            if ($this->db->affected_rows() > 0)
                return true;
            else
                return false;
        }
        else {
            if ($pil == null) {
                $res = $this->get_doc($id, null, $nfile, $tbl, $other);
                if ($res != false) {
                    $this->remove_doc($path, $res);
                    if ($tbl == "m_vendor_legal_other") {
                        $this->db->where('ID_VENDOR =', $this->session->ID);
                        $this->db->where('CATEGORY =', $data['CATEGORY']);
                    } else
                        $this->db->where('ID_VENDOR =', $this->session->ID);
                    $data['UPDATE_BY'] = $this->session->ID;
                    $data['UPDATE_TIME'] = date('Y-m-d H:i:s');
                    $query = $this->db->update($tbl, $data);
                    return true;
                } else
                    return $res;
            }
            else {
                if ($tbl == "m_vendor_legal_other") {
                    $this->db->where('ID_VENDOR =', $this->session->ID);
                    $this->db->where('CATEGORY =', $data['CATEGORY']);
                } else
                    $this->db->where('ID_VENDOR =', $this->session->ID);
                if ($this->db->update($tbl, $data))
                    return true;
                else
                    return false;
            }
        }
    }

    var $akta_column = array(
        'ID_VENDOR', 'KEY_AKTA', 'NO_AKTA', 'AKTA_DATE', 'AKTA_TYPE', 'NOTARIS', 'ADDRESS', 'VERIFICATION', 'NEWS');

    public function shows($key, $id) {
        $this->db->select('ID_VENDOR,KEY_AKTA,NO_AKTA,AKTA_DATE,AKTA_TYPE,NOTARIS,ADDRESS,VERIFICATION,NEWS,AKTA_FILE,VERIFICATION_FILE,NEWS_FILE');
        $this->db->from('m_vendor_akta');
        $this->db->where('ID_VENDOR =', $id);

        if ($key['search'] !== '') {
            $this->db->like('NO_AKTA', $key['search']);
            $this->db->or_like('AKTA_TYPE', $key['search']);
            $this->db->like('ID_VENDOR', $id);
            $this->db->or_like('NOTARIS', $key['search']);
            $this->db->like('ID_VENDOR', $id);
        }

        $this->db->order_by($this->akta_column[$key['ordCol']], $key['ordDir']);
        $data = $this->db->get();
        return $data->result();
    }

    public function get_alldata($id) {
        $data = $this->db
                ->select('N.*')
                ->from('m_vendor_npwp N')
                ->where('N.ID_VENDOR=', $id)
                ->get();
        return $data->result();
    }

    public function get_legal_others($id) {
        $query = $this->db->select("NO_DOC,TYPE,CATEGORY,CREATOR,VALID_SINCE,VALID_UNTIL,FILE_URL,DESCRIPTION")
                        ->from("m_vendor_legal_other")
                        ->group_start()
                            ->where("CATEGORY =", "SIUP")
                            ->or_where("CATEGORY =", "TDP")
                            ->or_where("CATEGORY =", "SKT_MIGAS")
                            ->or_where("CATEGORY =", "SKT_EBTKE")
                            ->or_where("CATEGORY =", "SPPKP")
                            ->or_where("CATEGORY =", "SKT_PAJAK")
                            ->or_where("CATEGORY =", "BKPM")
                        ->group_end()
                        ->where("ID_VENDOR",$this->session->ID)
                        ->where("STATUS", "1")
                        ->get();
        if ($query->num_rows() != 0) {
            return $query->result();
        } else
            return false;
    }

    public function get_data_akta($key, $id) {
        $query = $this->db
                ->select('*')
                ->from('m_vendor_akta')
                ->where('KEY_AKTA=', $key)
                ->where('ID_VENDOR=', $id)
                ->get();
        if ($query)
            return $query->result();
        else
            return false;
    }

    public function update_data_akta($data) {
        $query = $this->db
                ->where('KEY_AKTA=', $data["KEY_AKTA"])
                ->where('ID_VENDOR=', $this->session->ID)
                ->update('m_vendor_akta', $data);
        if ($query)
            return true;
        else
            return false;
    }

    public function delete_data_akta($key, $id) {
        $query = $this->db
                ->where('ID_VENDOR=', $id)
                ->where('KEY_AKTA=', $key)
                ->delete('m_vendor_akta');
        if ($query)
            return true;
        else
            return $query;
    }

    public function show_data_pajak(){
      $query = $this->db->query("SELECT ID_VENDOR, NO_NPWP, CASE WHEN NO_NPWP != 'SPPKP' OR NO_NPWP != 'SKT_PAJAK' THEN 'NPWP' ELSE 'OTHER DOC' END AS DOC_CATEGORY, NPWP_FILE
      FROM m_vendor_npwp
      WHERE ID_VENDOR= '".$this->session->userdata['ID']."'
      UNION ALL
      SELECT DISTINCT ID_VENDOR, NO_DOC, CATEGORY, FILE_URL FROM m_vendor_legal_other
      WHERE ID_VENDOR= '".$this->session->userdata['ID']."' AND CATEGORY IN ('SKT_PAJAK', 'SPPKP')");
      $data = $query->result();
      return $data;
    }

    public function delete_pajak_doc($id_vendor, $no_doc){

      $this->db->select('*');
      $this->db->where('ID_VENDOR', $id_vendor);
      $this->db->where('NO_DOC', $no_doc);
      $query = $this->db->get('m_vendor_legal_other');
      $num_legal_other = $query->num_rows();
      if ($num_legal_other > 0) {
        $del1 = $this->db->where('ID_VENDOR', $id_vendor)
                ->where('NO_DOC', $no_doc)
                ->delete("m_vendor_legal_other");
      }

      $this->db->select('*');
      $this->db->where('ID_VENDOR', $id_vendor);
      $this->db->where('NO_NPWP', $no_doc);
      $query = $this->db->get('m_vendor_npwp');
      $num_npwp = $query->num_rows();

      if ($num_npwp > 0) {
        $del2 = $this->db->where('ID_VENDOR', $id_vendor)
                ->where('NO_NPWP', $no_doc)
                ->delete("m_vendor_npwp");
      }
      return true;
    }


    public function get_sdkp(){
      $query = $this->db->select("*")->from("m_vendor_legal_other")->where("ID_VENDOR", $this->session->ID)->where("CATEGORY", "SDKP")->get();
      return $query->row();
    }

    public function add_sdkp($data){
      $insert = $this->db->insert('m_vendor_legal_other', $data);
      return $insert;
    }

    public function upd_sdkp($data){
      $this->db->where("CATEGORY", "SDKP");
      $this->db->where('ID', $data['ID']);
      $update = $this->db->update('m_vendor_legal_other', $data);
      return $update;
    }

}
