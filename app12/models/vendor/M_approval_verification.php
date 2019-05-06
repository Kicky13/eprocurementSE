<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_approval_verification extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function show() {
        $data = $this->db->query(
        "SELECT b.module,r.description as jabatan, a.id, a.supplier_id, b.user_roles, b.status_approve, b.sequence,
            CASE WHEN count(j.id) > 0
                THEN CONCAT(b.description, ' (DATA DITOLAK)')
                ELSE b.description
            END as description, b.reject_step, v.nama, v.ID_VENDOR, v.CREATE_TIME, v.FILE, v.CLASSIFICATION, v.CUALIFICATION, p.DESKRIPSI_ENG as PREFIX, x.DESKRIPSI_ENG as SUFFIX
            FROM (
                SELECT MIN(id) as id, supplier_id, MIN(sequence) as sequence from t_approval_supplier
                WHERE (status_approve = 0 or status_approve = 2) and extra_case = 0
                GROUP BY supplier_id
            ) a
            JOIN t_approval_supplier b on b.supplier_id = a.supplier_id and b.id = a.id
            JOIN m_vendor v on v.id = b.supplier_id
            JOIN m_user_roles r on r.ID_USER_ROLES=b.user_roles
            LEFT JOIN t_approval_supplier j on j.supplier_id = b.supplier_id and j.status_approve = 2
            LEFT JOIN m_prefix p ON p.ID_PREFIX=SUBSTRING(v.PREFIX, 1, 1)
            LEFT JOIN m_prefix x ON x.ID_PREFIX=SUBSTRING(v.PREFIX, 3)
            WHERE b.user_roles in (".substr($_SESSION['ROLES'],1,-1).") AND v.STATUS != '0' AND ((b.sequence > 3 and b.module=1) OR (b.sequence <= 3 and b.module=2))
            GROUP BY b.module,r.description, a.id, a.supplier_id, b.user_roles, b.status_approve, b.sequence, b.description, b.reject_step, v.nama, v.ID_VENDOR, v.CREATE_TIME, v.CLASSIFICATION, v.CUALIFICATION, p.DESKRIPSI_ENG, x.DESKRIPSI_ENG");
        return $data->result_array();
    }

}
