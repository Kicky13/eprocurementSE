<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_inactive_and_rejected extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function show() {
        $query = $this->db->select('ID,ID_VENDOR,NAMA,STATUS')
                ->from('m_vendor')
                ->where_in('STATUS', array('0', '11', '12', '13', '14', '15'))
                ->get();
        if ($query->num_rows() != 0)
            return $query->result();
        else
            return false;
    }

    public function get_data_new()
    {
        $qry = $this->db->query("SELECT b.sequence, b.module,r.description as jabatan,
            a.id as id_approval, a.supplier_id as id, b.user_roles, b.status_approve, b.sequence,
            CASE WHEN count(j.id) > 0
                THEN CONCAT(b.description, ' (DATA DITOLAK)')
                ELSE b.description
            END as status, b.reject_step, v.nama, v.ID_VENDOR as email, v.NAMA as nama, v.CREATE_TIME, v.CLASSIFICATION, v.CUALIFICATION, p.DESKRIPSI_ENG as PREFIX, x.DESKRIPSI_ENG as SUFFIX
            FROM (
                SELECT MIN(id) as id, supplier_id, MIN(sequence) as sequence from t_approval_supplier
                WHERE (status_approve = 0 or status_approve = 2)
                GROUP BY supplier_id
            ) a
            JOIN t_approval_supplier b on b.supplier_id = a.supplier_id and b.id = a.id
            JOIN m_vendor v on v.id = b.supplier_id
            JOIN m_user_roles r on r.ID_USER_ROLES=b.user_roles
            LEFT JOIN t_approval_supplier j on j.supplier_id = b.supplier_id and j.status_approve = 2
            LEFT JOIN m_prefix p ON p.ID_PREFIX=SUBSTRING(v.PREFIX, 1, 1)
            LEFT JOIN m_prefix x ON x.ID_PREFIX=SUBSTRING(v.PREFIX, 3)
            WHERE IF(b.module = 1, b.sequence > 3, b.sequence <> 0)
            GROUP BY b.module,r.description, a.id, a.supplier_id, b.user_roles, b.status_approve,
            b.sequence, b.description, b.reject_step, v.nama, v.ID_VENDOR, v.CREATE_TIME, v.CLASSIFICATION, v.CUALIFICATION, p.DESKRIPSI_ENG, x.DESKRIPSI_ENG");
        return $qry->result_array();
    }

    public function update($nama_id, $tabel, $id, $data) {
        return $this->db->where($nama_id, $id)->update($tabel, $data);
    }

    public function update_new($dt,$sel=1)
    {
        $res=false;
        if($sel==1)
        {
         $res=$this->db->query(
            'UPDATE t_approval_supplier t
            JOIN m_vendor v ON v.ID=t.supplier_id
            SET t.status_approve ='.$dt["status_approve"].',v.STATUS='.$dt["status"].',
            v.UPDATE_BY='.$dt['update_by'].'
            WHERE t.supplier_id='.$dt["id"]
         );
        }
        else{
            $res=$this->db->query(
                'UPDATE t_approval_supplier t
                JOIN m_vendor v ON v.ID=t.supplier_id
                SET t.status_approve ='.$dt["status_approve"].',v.STATUS='.$dt["status"].',
                v.UPDATE_BY='.$dt['update_by'].'
                WHERE t.supplier_id='.$dt["id"].' AND t.sequence=1'
             );
        }
        return $res;
    }

    public function show1($where = null) {
        if ($where != null) {
            $this->db->where($where);
        }
        $data = $this->db->from('m_vendor')->get();
        return $data->result();
    }

//    public function delete($id) {
//        //$id = $this->input->get('id');
//        $this->db->where('id', $id);
//        $this->db->delete('m_vendor');
//        if ($this->db->affected_rows() > 0) {
//            return true;
//        } else {
//            return false;
//        }
//    }

    public function delete($id) {
        $this->db->delete('m_vendor', array(
            'ID' => $id,
            'ID !=' => 1
        ));
    }

}
