<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_document_expired extends CI_Model {

  public function __construct() {
      parent::__construct();
      $this->db = $this->load->database('default', true);
  }

  public function get_document_expired($id) {
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
  }


}
