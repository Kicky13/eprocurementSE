<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_all_intern extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
    }

    public function cek_session() {
        if (!isset($this->session->ID_USER) && !isset($this->session->ID))
            header('Location:' . base_url() . 'in/');
        else
            return true;
    }

    public function show_status($id=null){
        $this->db->from('m_status_vendor');
        if($id!=null)
            $this->db->where_in('STATUS',$id);
        $data = $this->db->get();
        return $data->result();
    }

    public function get_notification($idx) {
        $query = "select CONCAT('SUPPLIER ',a.NAMA) as ID,v.DESCRIPTION_IND as description,max(l.CREATE_TIME) as CREATE_TIME from (
                  select a.id_vendor,m.nama,max(a.status) as status from m_status_vendor v
                  join m_user u on u.id_user='".$idx."' and u.roles like CONCAT('%',v.send_email_to,'%')
                  join log_vendor_acc a on a.status=v.status and a.read=0
                  join m_vendor m on m.id_vendor=a.id_vendor
                  where v.send_email_to is not null and v.send_email_to <>'S'  and v.send_email_to <>''
                  group by m.nama,a.id_vendor
                  ) a
                  join m_status_vendor v on v.status=a.status
                  join log_vendor_acc l on l.status=a.status and l.ID_VENDOR=a.ID_VENDOR
                  group by  a.NAMA,v.DESCRIPTION_IND

                  UNION ALL

                  select CONCAT('MATERIAL ',a.DESCRIPTION) as ID,v.DESCRIPTION_IND as description,max(l.CREATE_TIME) as CREATE_TIME from (
                  select a.ID_MATERIAL, m.DESCRIPTION,max(a.status) as status from m_status_material v
                  join m_user u on u.id_user='".$idx."' and u.roles like CONCAT('%',v.send_email_to,'%')
                  join log_material a on a.status=v.status and a.read=0
                  join m_material m on m.MATERIAL=a.ID_MATERIAL
                  where v.send_email_to is not null and v.send_email_to <>'S'  and v.send_email_to <>''
                  group by a.ID_MATERIAL, m.DESCRIPTION
                  ) a
                  join m_status_material v on v.status=a.status
                  join log_material l on l.status=a.status and l.ID_MATERIAL=a.ID_MATERIAL
                  group by  a.DESCRIPTION,v.DESCRIPTION_IND

                  UNION ALL

                  select CONCAT('DOKUMEN ',l.CATEGORY,' ',v.nama) as ID, cASE WHEN CURDATE()>=(DATE_SUB(l.valid_until, INTERVAL REMINDER_DAY DAY)) THEN CONCAT('DOKUMEN AKAN EXPIRED TGL ',l.VALID_UNTIL)
					WHEN CURDATE()>=l.valid_until THEN CONCAT('DOKUMEN EXPIRED TGL ',l.VALID_UNTIL) END
					as description,CURDATE() as CREATE_TIME from m_vendor v
					join m_vendor_legal_other l on l.id_vendor=v.id
					join m_document d on d.document_type=l.category and active=1
					where v.status=7 and CURDATE()>=(DATE_SUB(l.valid_until, INTERVAL REMINDER_DAY DAY))";
        $qry = $this->db->query($query);
        return $qry;
    }

    public function update_notif($data){
      $this->db->where('READ != 1');
      $this->db->update('log_vendor_acc', $data);

      $this->db->where('READ != 1');
      $this->db->update('log_material', $data);
    }

    public function update_notif_msg($idnya){
      $data = array(
        'READ' => '1'
      );
      $this->db->where('RECEIVER', $idnya);
      $this->db->where('READ != 1');
      $this->db->update('m_status_vendor_chat', $data);

    }

    public function status_chat($id){
      $this->db->select('RECEIVER, SENDER, VALUE, TIME, TYPE')->from('m_status_vendor_chat')->where('RECEIVER', $id)->where('READ', '0');
      $data = $this->db->get();
      return $data;
    }

}
