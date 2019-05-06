<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_registered_supplier extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function menu() {
        $data = $this->db->from('m_menu')->where('STATUS', '1')->get();
        return $data->result();
    }

    public function get_legal($id) {
        $data = $this->db->query(
            "SELECT V.NAMA,V.PREFIX,V.CLASSIFICATION,V.CUALIFICATION,L.*,N.*,A.BRANCH_TYPE,A.ADDRESS,A.FAX,A.TELP
            FROM m_vendor as V
            LEFT JOIN m_vendor_legal_other as L
            ON V.ID = L.ID_VENDOR AND L.STATUS = 1
            LEFT JOIN m_vendor_npwp as N
            ON V.ID = N.ID_VENDOR AND N.STATUS = 1
            LEFT JOIN m_vendor_address as A
            ON A.ID_VENDOR = V.ID AND A.STATUS = 1
            WHERE V.ID =".$id." OR (L.CATEGORY='SIUP' OR L.CATEGORY='TDP' OR L.CATEGORY='SKT_EBTKE' OR L.CATEGORY='SKT_MIGAS') AND V.ID =".$id);
        return $data->result_array();
    }

    public function get_slka_data($id)
    {
        $qry=$this->db->select('N.OPEN_VALUE,N.CLOSE_VALUE,V.NO_SLKA,V.SLKA_DATE')
                ->from('m_notic N')
                ->where('N.ID','14')
                ->join('m_vendor V','V.ID='.$id,'left')
                // ->join('log_vendor_acc L','L.ID_VENDOR=V.ID_VENDOR AND L.STATUS=7','left')
                // ->group_by('1,2,3')
                ->get();
        return $qry->result();
    }

    public function set_notif($id,$key,$dt)
    {
        $res= $this->db->where('ID_VENDOR=',$id)
                        ->where('KEYS=',$key)
                        ->update('m_vendor_contact',$dt);
        return $res;
    }

    public function get_data($id)
    {
        $query = $this->db->select('*')
                ->from('m_vendor')
                ->where('ID',$id)
                ->where('STATUS','7')
                ->get();
        if ($query->num_rows() != 0)
            return $query->result();
        else
            return false;
    }

    public function verify_mail($id, $mail) {
        $res = $this->db->select('ID_VENDOR')
                        ->from('m_vendor')
                        ->where(array('ID !=' => $id, 'ID_VENDOR' => $mail))
                        ->limit(1)
                        ->get();
        return $res->result_array();
    }

    public function edit_data($id, $data) {
        return $this->db->where('ID', $id)->update('m_vendor', $data);
    }

    public function cek_contact($id) {
        $query = $this->db->select('KEYS')
                ->from('m_vendor_contact')
                ->where('ID_VENDOR=', $id)
                ->order_by('KEYS DESC')
                ->limit(1)
                ->get();
        if ($query->num_rows() != 0)
            return $query->result();
        else
            return false;
    }

    public function add_data_kontak($data_kontak) {
        $key = $this->cek_contact($data_kontak['ID_VENDOR']);
        if ($key == false)
            $data_kontak['KEYS'] = 1;
        else
            $data_kontak['KEYS'] = $key[0]->KEYS + 1;
        $this->db->insert('m_vendor_contact', $data_kontak);
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }

    public function get_slka($id)
    {
        $qry=$this->db->select('NO_SLKA')
                ->from('m_vendor')
                ->where('ID',$id)
                ->get();
        return $qry->result();
    }

    public function delete($id,$data)
    {
        return $this->db->where("ID", $id)->update('m_vendor',$data);
    }

    public function show(){
        $query = $this->db->query("
            SELECT v.ID,NAMA,v.ID_VENDOR as email,s.DESCRIPTION_IND,s.DESCRIPTION_ENG,
                CASE WHEN count(l.ID)>0
                    THEN 'DOCUMENT EXPIRED'
                    ELSE ''
                END as status_doc
            from m_vendor v
            join m_status_vendor s on s.STATUS=v.STATUS
            left join m_vendor_legal_other l on l.ID_VENDOR=v.ID and l.STATUS = 1
            left join m_document d on d.document_type=l.category and d.active=1 and CURDATE()>=(DATE_SUB(l.VALID_UNTIL, INTERVAL d.REMINDER_DAY DAY))
            where v.STATUS=7
            group by 1,2,3,4,5
        ");
        return $query->result_array();
    }

    public function show2($id = null)
    {
        $where = '';
        if ($id) {
            $where .= ' AND v.id = "'.$id.'"';
        }
        $query = $this->db->query('SELECT
            v.id as ID,
            v.nama as NAMA,
            v.ID_VENDOR as email,
            \'Supplier Registered\' as DESCRIPTION_ENG,
            (
                SELECT
                    CASE
                        WHEN document.VALID_UNTIL <= NOW() THEN \'DOCUMENT EXPIRED\'
                        WHEN DATEDIFF(document.VALID_UNTIL, NOW()) <= m_document.reminder_day THEN CONCAT(\'DOCUMENT WILL BE EXPIRED ON \', DATEDIFF(document.VALID_UNTIL, NOW()),\' DAYS\')
                        ELSE NULL
                    END AS STATUS_DOCUMENT
                FROM
                (
                    SELECT ID_VENDOR, MIN(VALID_UNTIL) as VALID_UNTIL FROM (
                        SELECT ID_VENDOR,NO_DOC,CATEGORY,FILE_URL,VALID_UNTIL FROM m_vendor_legal_other
                        UNION ALL
                        SELECT ID_VENDOR, NO_DOC,\'CERTIFICATION\' AS CATEGORY, FILE_URL,VALID_UNTIL FROM m_vendor_certification
                    ) as older
                    GROUP BY ID_VENDOR
                ) older
                JOIN (
                    SELECT ID_VENDOR,NO_DOC,CATEGORY,FILE_URL,VALID_UNTIL FROM m_vendor_legal_other
                    UNION ALL
                    SELECT ID_VENDOR, NO_DOC,\'CERTIFICATION\' AS CATEGORY, FILE_URL,VALID_UNTIL FROM m_vendor_certification
                ) as document ON document.ID_VENDOR = older.ID_VENDOR AND document.VALID_UNTIL = older.VALID_UNTIL
                JOIN m_document ON m_document.document_type = document.CATEGORY
                WHERE document.ID_VENDOR = v.id
                LIMIT 1
            ) as status_doc,
            p.DESKRIPSI_ENG as PREFIX, x.DESKRIPSI_ENG as SUFFIX, v.NO_SLKA, v.ID_EXTERNAL, v.CLASSIFICATION
        FROM m_vendor v
        LEFT JOIN m_prefix p ON p.ID_PREFIX=SUBSTRING(v.PREFIX, 1, 1)
        LEFT JOIN m_prefix x ON x.ID_PREFIX=SUBSTRING(v.PREFIX, 3)
        WHERE (SELECT count(1) FROM t_approval_supplier WHERE t_approval_supplier.supplier_id = v.id AND (status_approve = 0 OR status_approve = 2)) = 0'.$where);
        return $query->result_array();
    }

    public function get_data_exp($id)
    {
        $qry = $this->db->select("l.CATEGORY,l.VALID_UNTIL")
        ->from("m_vendor_legal_other l")
        ->where("l.ID_VENDOR=",$id)
        ->where("l.STATUS=",'1')
        ->where("CURDATE()>=(DATE_SUB(DATE(l.VALID_UNTIL), INTERVAL 30 DAY))")
        ->order_by("l.CATEGORY")
        ->get();

        if ($qry->num_rows() != 0)
            return $qry->result();
        else
            return false;
    }

    public function get_email_dest($val) {
        $qry = $this->db->select("TITLE,OPEN_VALUE,CLOSE_VALUE,CATEGORY,ROLES")
                ->from("m_notic ")
                ->where("ID=", $val)
                ->get();
        if ($qry->num_rows() != 0)
            return $qry->result();
        else
            return false;
    }

    public function get_document_expired($id) {
        // $sql = ' SELECT * FROM (
        //     SELECT
        //         document.*,
        //         CASE
        //             WHEN VALID_UNTIL <= NOW() THEN \'DOCUMENT EXPIRED\'
        //             WHEN DATEDIFF(VALID_UNTIL, NOW()) <= m_document.reminder_day THEN CONCAT(\'DOCUMENT WILL BE EXPIRED ON \', DATEDIFF(VALID_UNTIL, NOW()),\' DAYS\')
        //             ELSE NULL
        //         END AS STATUS_DOCUMENT
        //     FROM
        //     (
        //         SELECT ID_VENDOR,NO_DOC,CATEGORY,FILE_URL,VALID_SINCE, VALID_UNTIL FROM m_vendor_legal_other
        //         UNION ALL
        //         SELECT ID_VENDOR, NO_DOC,\'CERTIFICATION\' AS CATEGORY, FILE_URL,VALID_SINCE, VALID_UNTIL FROM m_vendor_certification
        //     ) document
        //     JOIN m_document ON m_document.document_type = document.CATEGORY
        //     WHERE document.ID_VENDOR = \''.$id.'\'
        // ) document WHERE STATUS_DOCUMENT <> \'\'';
        $sql = "SELECT *
                FROM ( SELECT   document.ID_VENDOR, document.NO_DOC, document.FILE_URL, document.VALID_SINCE, document.VALID_UNTIL,
                CASE WHEN document.CATEGORY = 'CERTIFICATION' THEN 'AGENCY_AND_PRINCIPAL_CERTIFICATION' WHEN document.CATEGORY = 'SIUP' OR document.CATEGORY = 'BKPM' THEN 'BUSINESS_LICENSE' ELSE document.CATEGORY END as CATEGORY,
                w.*, CASE WHEN w.last_sent_email IS NULL THEN '-' ELSE w.last_sent_email END as last_sent_mail,
                CASE WHEN VALID_UNTIL <= NOW() THEN 'DOCUMENT EXPIRED'
                WHEN DATEDIFF(VALID_UNTIL, NOW()) <= m_document.reminder_day
                THEN CONCAT('DOCUMENT WILL BE EXPIRED ON ', DATEDIFF(VALID_UNTIL, NOW()),' DAYS') ELSE NULL
                END AS STATUS_DOCUMENT, ID as EMAIL_VENDOR
                FROM ( SELECT ID_VENDOR,NO_DOC,CATEGORY,FILE_URL,VALID_SINCE, VALID_UNTIL
                			FROM m_vendor_legal_other
                			UNION ALL
                			SELECT ID_VENDOR, NO_DOC,'CERTIFICATION' AS CATEGORY, FILE_URL,VALID_SINCE, VALID_UNTIL
                			FROM m_vendor_certification )
                document
                JOIN m_document ON m_document.document_type = document.CATEGORY
                LEFT JOIN ( SELECT vv.ID as IDV, ww.create_date as last_sent_email, ww.doc_type
                			FROM i_notification ww
                			JOIN m_vendor vv ON ww.recipient=vv.ID_VENDOR
                			WHERE vv.ID='".$id."' ORDER BY ww.create_date DESC LIMIT 1 ) as w ON w.IDV=document.ID_VENDOR AND document.CATEGORY LIKE CONCAT('%',w.doc_type, '%')
                WHERE document.ID_VENDOR = '".$id."') document
                WHERE STATUS_DOCUMENT <> '' ";
        return $this->db->query($sql)->result();
        // $this->db->query($sql);
        // return $this->db->last_query();
    }

     public function get_data_exp_auto()
    {
         $sql = "SELECT CATEGORY,VALID_UNTIL,NO_DOC,STATUS_DOCUMENT,v.ID_VENDOR as EMAIL
                FROM ( SELECT  m_document.reminder_day3,m_document.reminder_day2,m_document.reminder_day,document.ID_VENDOR, document.NO_DOC, document.FILE_URL, document.VALID_SINCE, document.VALID_UNTIL,
                CASE WHEN document.CATEGORY = 'CERTIFICATION' THEN 'AGENCY_AND_PRINCIPAL_CERTIFICATION' WHEN document.CATEGORY = 'SIUP' OR document.CATEGORY = 'BKPM' THEN 'BUSINESS_LICENSE' ELSE document.CATEGORY END as CATEGORY,
                w.*, CASE WHEN w.last_sent_email IS NULL THEN '-' ELSE w.last_sent_email END as last_sent_mail,
                CASE WHEN VALID_UNTIL <= NOW() THEN 'DOCUMENT EXPIRED'
                WHEN DATEDIFF(VALID_UNTIL, NOW()) <= m_document.reminder_day
                THEN CONCAT('DOCUMENT WILL BE EXPIRED ON ', DATEDIFF(VALID_UNTIL, NOW()),' DAYS') ELSE NULL
                END AS STATUS_DOCUMENT,  m_document.ID as EMAIL_VENDOR
                FROM ( SELECT ID_VENDOR,NO_DOC,CATEGORY,FILE_URL,VALID_SINCE, VALID_UNTIL
                            FROM m_vendor_legal_other
                            UNION ALL
                            SELECT ID_VENDOR, NO_DOC,'CERTIFICATION' AS CATEGORY, FILE_URL,VALID_SINCE, VALID_UNTIL
                            FROM m_vendor_certification )
                document
                JOIN m_document ON m_document.document_type = document.CATEGORY
                LEFT JOIN ( SELECT vv.ID as IDV, ww.create_date as last_sent_email
                            FROM i_notification ww
                            JOIN m_vendor vv ON ww.recipient=vv.ID_VENDOR
                            ORDER BY ww.create_date DESC LIMIT 1 ) as w ON w.IDV=document.ID_VENDOR
               ) d join m_vendor v on v.ID=d.ID_VENDOR
                WHERE STATUS_DOCUMENT <> '' AND (DATEDIFF(VALID_UNTIL, NOW())=d.reminder_day OR DATEDIFF(VALID_UNTIL, NOW())=d.reminder_day2 OR DATEDIFF(VALID_UNTIL, NOW())=d.reminder_day3) AND CONCAT(CATEGORY,v.ID_VENDOR) NOT IN (SELECT CONCAT(COALESCE(doc_type,''),recipient) from i_notification where date(create_date)=CURRENT_DATE ) LIMIT 1  ";
        return $this->db->query($sql)->result();
    }
}
