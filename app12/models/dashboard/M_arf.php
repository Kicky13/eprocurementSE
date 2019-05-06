<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_arf extends CI_MODEL
{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_status($filter) {
        $condition = array();
        if (isset($filter['periode'])) {
            $condition[] = 'LEFT(arf_t.created_at, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'msr.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'm_user.ID_DEPARTMENT IN (\''.implode('\',\'', $filter['department']).'\')';
        }
        if (isset($filter['status'])) {
            $condition[] = 'arf_t.status IN (\''.implode('\',\'', $filter['status']).'\')';
        }
        if (isset($filter['type'])) {
            $condition[] = 'arf_t.arf_type IN (\''.implode('\',\'', $filter['type']).'\')';
        }
        if (isset($filter['method'])) {
            $condition[] = 'msr.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
        }
        if (isset($filter['specialist'])) {
            $condition[] = 'arf_t.created_by IN (\''.implode('\',\'', $filter['specialist']).'\')';
        }
        if (count($condition) <> 0) {
            $condition_query = 'WHERE '.implode(' AND ', $condition);
        } else {
            $condition_query = '';
        }
        $sql = "SELECT SUM(total_base) as value, COUNT(1) as number, arf_t.status, LEFT(created_at,7) as periode
              	FROM (SELECT arf_t.* FROM (	SELECT 'Preparation' as status, CASE WHEN po.po_type = 10 THEN 'Goods' WHEN po.po_type = 20 THEN 'Services' ELSE 'Blanked' END as arf_type, f.po_no, f.created_by, f.created_at, f.total_base, mu.NAME as specialist
              		FROM t_arf as f
              		JOIN t_purchase_order po ON po.po_no=f.po_no
              		JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf GROUP BY id_ref) a ON a.id_ref=f.id
              		JOIN t_approval_arf b ON b.id_ref=a.id_ref AND b.sequence=a.sequence AND b.status=0
              		LEFT JOIN m_user mu ON mu.ID_USER=f.created_by AND mu.ROLES LIKE '%,28,%'
              		WHERE 1=1
              		UNION
              		SELECT 'Preparation' as status, CASE WHEN po.po_type = 10 THEN 'Goods' WHEN po.po_type = 20 THEN 'Services' ELSE 'Blanked' END as arf_type, n.po_no, f.created_by, f.created_at, f.total_base, mu.NAME as specialist
              		FROM t_arf as f
              		JOIN t_purchase_order po ON po.po_no=f.po_no
              		JOIN t_arf_notification n ON n.po_no=f.po_no
              		JOIN (SELECT max(sequence) as sequence, doc_id FROM t_approval_arf_notification GROUP BY doc_id) a ON a.doc_id=n.id
              		JOIN t_approval_arf_notification b ON b.doc_id=a.doc_id AND b.sequence=a.sequence AND b.status_approve=0
              		LEFT JOIN m_user mu ON mu.ID_USER=f.created_by AND mu.ROLES LIKE '%,28,%'
              		WHERE 1=1
              		UNION
              		SELECT 'Preparation' as status, CASE WHEN po.po_type = 10 THEN 'Goods' WHEN po.po_type = 20 THEN 'Services' ELSE 'Blanked' END as arf_type, n.po_no, f.created_by, f.created_at, f.total_base, mu.NAME as specialist
              		FROM t_arf as f
              		JOIN t_purchase_order po ON po.po_no=f.po_no
              		JOIN t_arf_recommendation_preparation n ON n.po_no=f.po_no
              		JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf_recom GROUP BY id_ref) a ON a.id_ref=n.id
              		JOIN t_approval_arf_recom b ON b.id_ref=a.id_ref AND b.sequence=a.sequence AND b.status=0
              		LEFT JOIN m_user mu ON mu.ID_USER=f.created_by AND mu.ROLES LIKE '%,28,%'
              		WHERE 1=1

              		UNION ALL

              		SELECT 'Completed' as status, CASE WHEN po.po_type = 10 THEN 'Goods' WHEN po.po_type = 20 THEN 'Services' ELSE 'Blanked' END as arf_type, f.po_no, f.created_by, f.created_at, f.total_base, mu.NAME as specialist
              		FROM t_arf as f
              		JOIN t_purchase_order po ON po.po_no=f.po_no
              		JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf GROUP BY id_ref) a ON a.id_ref=f.id
              		JOIN t_approval_arf b ON b.id_ref=a.id_ref AND b.sequence=a.sequence AND b.status=1
              		JOIN t_arf_notification n ON n.doc_no=f.doc_no
              		JOIN (SELECT max(sequence) as sequence, doc_id FROM t_approval_arf_notification GROUP BY doc_id) aa ON aa.doc_id=f.id
              		JOIN t_approval_arf_notification taan ON taan.sequence=aa.sequence AND taan.status_approve = 1
              		JOIN t_arf_recommendation_preparation r ON r.doc_no=f.doc_no
              		JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf_recom GROUP BY id_ref) aaa ON aaa.id_ref=f.id
              		JOIN t_approval_arf_recom taar ON taar.sequence=aaa.sequence AND taar.status=1
              		LEFT JOIN m_user mu ON mu.ID_USER=f.created_by AND mu.ROLES LIKE '%,28,%'
              		WHERE f.doc_no NOT IN (SELECT doc_no FROM t_arf_acceptance)

              		UNION ALL

              		SELECT DISTINCT 'Signed' as status, CASE WHEN po.po_type = 10 THEN 'Goods' WHEN po.po_type = 20 THEN 'Services' ELSE 'Blanked' END as arf_type, f.po_no, f.created_by, f.created_at, f.total_base, mu.NAME as specialist
              		FROM t_arf as f
              		JOIN t_purchase_order po ON po.po_no=f.po_no
              		JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf GROUP BY id_ref) a ON a.id_ref=f.id
              		JOIN t_approval_arf b ON b.id_ref=a.id_ref AND b.sequence=a.sequence AND b.status=1
              		JOIN t_arf_notification n ON n.doc_no=f.doc_no
              		JOIN (SELECT max(sequence) as sequence, doc_id FROM t_approval_arf_notification GROUP BY doc_id) aa ON aa.doc_id=f.id
              		JOIN t_approval_arf_notification taan ON taan.sequence=aa.sequence AND taan.status_approve = 1
              		JOIN t_arf_recommendation_preparation r ON r.doc_no=f.doc_no
              		JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf_recom GROUP BY id_ref) aaa ON aaa.id_ref=f.id
              		JOIN t_approval_arf_recom taar ON taar.sequence=aaa.sequence AND taar.status=1
              		LEFT JOIN m_user mu ON mu.ID_USER=f.created_by AND mu.ROLES LIKE '%,28,%'
              		WHERE f.doc_no IN (SELECT doc_no FROM t_arf_acceptance) ) arf_t
              		LEFT JOIN t_purchase_order ON t_purchase_order.po_no=arf_t.po_no
              		LEFT JOIN t_msr msr ON msr.msr_no=t_purchase_order.msr_no
              		LEFT JOIN m_user ON m_user.ID_USER=arf_t.created_by
              		LEFT JOIN t_assignment ON t_assignment.msr_no = msr.msr_no
                  ".$condition_query."
               ) arf_t
              GROUP BY created_at, status";
        return $this->db->query($sql)->result();
        // $this->db->query($sql);
        // return echopre($this->db->last_query());
    }

    public function get_status_trend($filter) {
      $condition = array();
      if (isset($filter['periode'])) {
          $condition[] = 'LEFT(arf_t.created_at, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
      }
      if (isset($filter['company'])) {
          $condition[] = 'msr.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
      }
      if (isset($filter['department'])) {
          $condition[] = 'm_user.ID_DEPARTMENT IN (\''.implode('\',\'', $filter['department']).'\')';
      }
      if (isset($filter['status'])) {
          $condition[] = 'arf_t.status IN (\''.implode('\',\'', $filter['status']).'\')';
      }
      if (isset($filter['type'])) {
          $condition[] = 'arf_t.arf_type IN (\''.implode('\',\'', $filter['type']).'\')';
      }
      if (isset($filter['method'])) {
          $condition[] = 'msr.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
      }
      if (isset($filter['specialist'])) {
          $condition[] = 'arf_t.created_by IN (\''.implode('\',\'', $filter['specialist']).'\')';
      }
      if (count($condition) <> 0) {
          $condition_query = 'WHERE '.implode(' AND ', $condition);
      } else {
          $condition_query = '';
      }
      $sql = "SELECT SUM(total_base) as value, COUNT(1) as number, arf_t.status, LEFT(created_at,7) as periode
              FROM (SELECT arf_t.* FROM (	SELECT 'Preparation' as status, CASE WHEN po.po_type = 10 THEN 'Goods' WHEN po.po_type = 20 THEN 'Services' ELSE 'Blanked' END as arf_type, f.po_no, f.created_by, f.created_at, f.total_base, mu.NAME as specialist
                FROM t_arf as f
                JOIN t_purchase_order po ON po.po_no=f.po_no
                JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf GROUP BY id_ref) a ON a.id_ref=f.id
                JOIN t_approval_arf b ON b.id_ref=a.id_ref AND b.sequence=a.sequence AND b.status=0
                LEFT JOIN m_user mu ON mu.ID_USER=f.created_by AND mu.ROLES LIKE '%,28,%'
                WHERE 1=1
                UNION
                SELECT 'Preparation' as status, CASE WHEN po.po_type = 10 THEN 'Goods' WHEN po.po_type = 20 THEN 'Services' ELSE 'Blanked' END as arf_type, n.po_no, f.created_by, f.created_at, f.total_base, mu.NAME as specialist
                FROM t_arf as f
                JOIN t_purchase_order po ON po.po_no=f.po_no
                JOIN t_arf_notification n ON n.po_no=f.po_no
                JOIN (SELECT max(sequence) as sequence, doc_id FROM t_approval_arf_notification GROUP BY doc_id) a ON a.doc_id=n.id
                JOIN t_approval_arf_notification b ON b.doc_id=a.doc_id AND b.sequence=a.sequence AND b.status_approve=0
                LEFT JOIN m_user mu ON mu.ID_USER=f.created_by AND mu.ROLES LIKE '%,28,%'
                WHERE 1=1
                UNION
                SELECT 'Preparation' as status, CASE WHEN po.po_type = 10 THEN 'Goods' WHEN po.po_type = 20 THEN 'Services' ELSE 'Blanked' END as arf_type, n.po_no, f.created_by, f.created_at, f.total_base, mu.NAME as specialist
                FROM t_arf as f
                JOIN t_purchase_order po ON po.po_no=f.po_no
                JOIN t_arf_recommendation_preparation n ON n.po_no=f.po_no
                JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf_recom GROUP BY id_ref) a ON a.id_ref=n.id
                JOIN t_approval_arf_recom b ON b.id_ref=a.id_ref AND b.sequence=a.sequence AND b.status=0
                LEFT JOIN m_user mu ON mu.ID_USER=f.created_by AND mu.ROLES LIKE '%,28,%'
                WHERE 1=1

                UNION ALL

                SELECT 'Completed' as status, CASE WHEN po.po_type = 10 THEN 'Goods' WHEN po.po_type = 20 THEN 'Services' ELSE 'Blanked' END as arf_type, f.po_no, f.created_by, f.created_at, f.total_base, mu.NAME as specialist
                FROM t_arf as f
                JOIN t_purchase_order po ON po.po_no=f.po_no
                JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf GROUP BY id_ref) a ON a.id_ref=f.id
                JOIN t_approval_arf b ON b.id_ref=a.id_ref AND b.sequence=a.sequence AND b.status=1
                JOIN t_arf_notification n ON n.doc_no=f.doc_no
                JOIN (SELECT max(sequence) as sequence, doc_id FROM t_approval_arf_notification GROUP BY doc_id) aa ON aa.doc_id=f.id
                JOIN t_approval_arf_notification taan ON taan.sequence=aa.sequence AND taan.status_approve = 1
                JOIN t_arf_recommendation_preparation r ON r.doc_no=f.doc_no
                JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf_recom GROUP BY id_ref) aaa ON aaa.id_ref=f.id
                JOIN t_approval_arf_recom taar ON taar.sequence=aaa.sequence AND taar.status=1
                LEFT JOIN m_user mu ON mu.ID_USER=f.created_by AND mu.ROLES LIKE '%,28,%'
                WHERE f.doc_no NOT IN (SELECT doc_no FROM t_arf_acceptance)

                UNION ALL

                SELECT DISTINCT 'Signed' as status, CASE WHEN po.po_type = 10 THEN 'Goods' WHEN po.po_type = 20 THEN 'Services' ELSE 'Blanked' END as arf_type, f.po_no, f.created_by, f.created_at, f.total_base, mu.NAME as specialist
                FROM t_arf as f
                JOIN t_purchase_order po ON po.po_no=f.po_no
                JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf GROUP BY id_ref) a ON a.id_ref=f.id
                JOIN t_approval_arf b ON b.id_ref=a.id_ref AND b.sequence=a.sequence AND b.status=1
                JOIN t_arf_notification n ON n.doc_no=f.doc_no
                JOIN (SELECT max(sequence) as sequence, doc_id FROM t_approval_arf_notification GROUP BY doc_id) aa ON aa.doc_id=f.id
                JOIN t_approval_arf_notification taan ON taan.sequence=aa.sequence AND taan.status_approve = 1
                JOIN t_arf_recommendation_preparation r ON r.doc_no=f.doc_no
                JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf_recom GROUP BY id_ref) aaa ON aaa.id_ref=f.id
                JOIN t_approval_arf_recom taar ON taar.sequence=aaa.sequence AND taar.status=1
                LEFT JOIN m_user mu ON mu.ID_USER=f.created_by AND mu.ROLES LIKE '%,28,%'
                WHERE f.doc_no IN (SELECT doc_no FROM t_arf_acceptance) ) arf_t
                LEFT JOIN t_purchase_order ON t_purchase_order.po_no=arf_t.po_no
                LEFT JOIN t_msr msr ON msr.msr_no=t_purchase_order.msr_no
                LEFT JOIN m_user ON m_user.ID_USER=arf_t.created_by
                LEFT JOIN t_assignment ON t_assignment.msr_no = msr.msr_no
                ".$condition_query."
             ) arf_t
            GROUP BY created_at, status";
      return $this->db->query($sql)->result();
    }

    public function get_type($filter) {
      $condition = array();
      if (isset($filter['periode'])) {
          $condition[] = 'LEFT(arf_t.created_at, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
      }
      if (isset($filter['company'])) {
          $condition[] = 'msr.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
      }
      if (isset($filter['department'])) {
          $condition[] = 'm.ID_DEPARTMENT IN (\''.implode('\',\'', $filter['department']).'\')';
      }
      if (isset($filter['status'])) {
          $condition[] = 'arf_t.status IN (\''.implode('\',\'', $filter['status']).'\')';
      }
      if (isset($filter['type'])) {
          $condition[] = 'arf_t.arf_type IN (\''.implode('\',\'', $filter['type']).'\')';
      }
      if (isset($filter['method'])) {
          $condition[] = 'msr.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
      }
      if (isset($filter['specialist'])) {
          $condition[] = 'arf_t.created_by IN (\''.implode('\',\'', $filter['specialist']).'\')';
      }
      if (count($condition) <> 0) {
          $condition_query = 'WHERE '.implode(' AND ', $condition);
      } else {
          $condition_query = '';
      }
      $sql = "SELECT SUM(total_base) as value, COUNT(1) as number, arf_t.arf_type, LEFT(created_at,7) as periode
            	FROM (SELECT arf_t.* FROM (	SELECT 'Preparation' as status, CASE WHEN po.po_type = 10 THEN 'Goods' WHEN po.po_type = 20 THEN 'Services' ELSE 'Blanked' END as arf_type, f.po_no, f.created_by, f.created_at, f.total_base, mu.NAME as specialist
            		FROM t_arf as f
            		JOIN t_purchase_order po ON po.po_no=f.po_no
            		JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf GROUP BY id_ref) a ON a.id_ref=f.id
            		JOIN t_approval_arf b ON b.id_ref=a.id_ref AND b.sequence=a.sequence AND b.status=0
            		LEFT JOIN m_user mu ON mu.ID_USER=f.created_by AND mu.ROLES LIKE '%,28,%'
            		WHERE 1=1
            		UNION
            		SELECT 'Preparation' as status, CASE WHEN po.po_type = 10 THEN 'Goods' WHEN po.po_type = 20 THEN 'Services' ELSE 'Blanked' END as arf_type, n.po_no, f.created_by, f.created_at, f.total_base, mu.NAME as specialist
            		FROM t_arf as f
            		JOIN t_purchase_order po ON po.po_no=f.po_no
            		JOIN t_arf_notification n ON n.po_no=f.po_no
            		JOIN (SELECT max(sequence) as sequence, doc_id FROM t_approval_arf_notification GROUP BY doc_id) a ON a.doc_id=n.id
            		JOIN t_approval_arf_notification b ON b.doc_id=a.doc_id AND b.sequence=a.sequence AND b.status_approve=0
            		LEFT JOIN m_user mu ON mu.ID_USER=f.created_by AND mu.ROLES LIKE '%,28,%'
            		WHERE 1=1
            		UNION
            		SELECT 'Preparation' as status, CASE WHEN po.po_type = 10 THEN 'Goods' WHEN po.po_type = 20 THEN 'Services' ELSE 'Blanked' END as arf_type, n.po_no, f.created_by, f.created_at, f.total_base, mu.NAME as specialist
            		FROM t_arf as f
            		JOIN t_purchase_order po ON po.po_no=f.po_no
            		JOIN t_arf_recommendation_preparation n ON n.po_no=f.po_no
            		JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf_recom GROUP BY id_ref) a ON a.id_ref=n.id
            		JOIN t_approval_arf_recom b ON b.id_ref=a.id_ref AND b.sequence=a.sequence AND b.status=0
            		LEFT JOIN m_user mu ON mu.ID_USER=f.created_by AND mu.ROLES LIKE '%,28,%'
            		WHERE 1=1

            		UNION ALL

            		SELECT 'Completed' as status, CASE WHEN po.po_type = 10 THEN 'Goods' WHEN po.po_type = 20 THEN 'Services' ELSE 'Blanked' END as arf_type, f.po_no, f.created_by, f.created_at, f.total_base, mu.NAME as specialist
            		FROM t_arf as f
            		JOIN t_purchase_order po ON po.po_no=f.po_no
            		JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf GROUP BY id_ref) a ON a.id_ref=f.id
            		JOIN t_approval_arf b ON b.id_ref=a.id_ref AND b.sequence=a.sequence AND b.status=1
            		JOIN t_arf_notification n ON n.doc_no=f.doc_no
            		JOIN (SELECT max(sequence) as sequence, doc_id FROM t_approval_arf_notification GROUP BY doc_id) aa ON aa.doc_id=f.id
            		JOIN t_approval_arf_notification taan ON taan.sequence=aa.sequence AND taan.status_approve = 1
            		JOIN t_arf_recommendation_preparation r ON r.doc_no=f.doc_no
            		JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf_recom GROUP BY id_ref) aaa ON aaa.id_ref=f.id
            		JOIN t_approval_arf_recom taar ON taar.sequence=aaa.sequence AND taar.status=1
            		LEFT JOIN m_user mu ON mu.ID_USER=f.created_by AND mu.ROLES LIKE '%,28,%'
            		WHERE f.doc_no NOT IN (SELECT doc_no FROM t_arf_acceptance)

            		UNION ALL

            		SELECT DISTINCT 'Signed' as status, CASE WHEN po.po_type = 10 THEN 'Goods' WHEN po.po_type = 20 THEN 'Services' ELSE 'Blanked' END as arf_type, f.po_no, f.created_by, f.created_at, f.total_base, mu.NAME as specialist
            		FROM t_arf as f
            		JOIN t_purchase_order po ON po.po_no=f.po_no
            		JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf GROUP BY id_ref) a ON a.id_ref=f.id
            		JOIN t_approval_arf b ON b.id_ref=a.id_ref AND b.sequence=a.sequence AND b.status=1
            		JOIN t_arf_notification n ON n.doc_no=f.doc_no
            		JOIN (SELECT max(sequence) as sequence, doc_id FROM t_approval_arf_notification GROUP BY doc_id) aa ON aa.doc_id=f.id
            		JOIN t_approval_arf_notification taan ON taan.sequence=aa.sequence AND taan.status_approve = 1
            		JOIN t_arf_recommendation_preparation r ON r.doc_no=f.doc_no
            		JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf_recom GROUP BY id_ref) aaa ON aaa.id_ref=f.id
            		JOIN t_approval_arf_recom taar ON taar.sequence=aaa.sequence AND taar.status=1
            		LEFT JOIN m_user mu ON mu.ID_USER=f.created_by AND mu.ROLES LIKE '%,28,%'
            		WHERE f.doc_no IN (SELECT doc_no FROM t_arf_acceptance) ) arf_t
            		LEFT JOIN t_purchase_order ON t_purchase_order.po_no=arf_t.po_no
            		LEFT JOIN t_msr msr ON msr.msr_no=t_purchase_order.msr_no
            		LEFT JOIN m_user m ON m.ID_USER=arf_t.created_by
            		LEFT JOIN t_assignment ON t_assignment.msr_no = msr.msr_no
                ".$condition_query."
             ) arf_t

            GROUP BY created_at, arf_type";
      return $this->db->query($sql)->result();
    }

    public function get_type_trend($filter) {
      $condition = array();
      if (isset($filter['periode'])) {
          $condition[] = 'LEFT(arf_t.created_at, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
      }
      if (isset($filter['company'])) {
          $condition[] = 'msr.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
      }
      if (isset($filter['department'])) {
          $condition[] = 'm.ID_DEPARTMENT IN (\''.implode('\',\'', $filter['department']).'\')';
      }
      if (isset($filter['status'])) {
          $condition[] = 'arf_t.status IN (\''.implode('\',\'', $filter['status']).'\')';
      }
      if (isset($filter['type'])) {
          $condition[] = 'arf_t.arf_type IN (\''.implode('\',\'', $filter['type']).'\')';
      }
      if (isset($filter['method'])) {
          $condition[] = 'msr.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
      }
      if (isset($filter['specialist'])) {
          $condition[] = 'arf_t.created_by IN (\''.implode('\',\'', $filter['specialist']).'\')';
      }
      if (count($condition) <> 0) {
          $condition_query = 'WHERE '.implode(' AND ', $condition);
      } else {
          $condition_query = '';
      }
      $sql = "SELECT SUM(total_base) as value, COUNT(1) as number, arf_t.arf_type, LEFT(created_at,7) as periode
              FROM (SELECT arf_t.* FROM (	SELECT 'Preparation' as status, CASE WHEN po.po_type = 10 THEN 'Goods' WHEN po.po_type = 20 THEN 'Services' ELSE 'Blanked' END as arf_type, f.po_no, f.created_by, f.created_at, f.total_base, mu.NAME as specialist
                FROM t_arf as f
                JOIN t_purchase_order po ON po.po_no=f.po_no
                JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf GROUP BY id_ref) a ON a.id_ref=f.id
                JOIN t_approval_arf b ON b.id_ref=a.id_ref AND b.sequence=a.sequence AND b.status=0
                LEFT JOIN m_user mu ON mu.ID_USER=f.created_by AND mu.ROLES LIKE '%,28,%'
                WHERE 1=1
                UNION
                SELECT 'Preparation' as status, CASE WHEN po.po_type = 10 THEN 'Goods' WHEN po.po_type = 20 THEN 'Services' ELSE 'Blanked' END as arf_type, n.po_no, f.created_by, f.created_at, f.total_base, mu.NAME as specialist
                FROM t_arf as f
                JOIN t_purchase_order po ON po.po_no=f.po_no
                JOIN t_arf_notification n ON n.po_no=f.po_no
                JOIN (SELECT max(sequence) as sequence, doc_id FROM t_approval_arf_notification GROUP BY doc_id) a ON a.doc_id=n.id
                JOIN t_approval_arf_notification b ON b.doc_id=a.doc_id AND b.sequence=a.sequence AND b.status_approve=0
                LEFT JOIN m_user mu ON mu.ID_USER=f.created_by AND mu.ROLES LIKE '%,28,%'
                WHERE 1=1
                UNION
                SELECT 'Preparation' as status, CASE WHEN po.po_type = 10 THEN 'Goods' WHEN po.po_type = 20 THEN 'Services' ELSE 'Blanked' END as arf_type, n.po_no, f.created_by, f.created_at, f.total_base, mu.NAME as specialist
                FROM t_arf as f
                JOIN t_purchase_order po ON po.po_no=f.po_no
                JOIN t_arf_recommendation_preparation n ON n.po_no=f.po_no
                JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf_recom GROUP BY id_ref) a ON a.id_ref=n.id
                JOIN t_approval_arf_recom b ON b.id_ref=a.id_ref AND b.sequence=a.sequence AND b.status=0
                LEFT JOIN m_user mu ON mu.ID_USER=f.created_by AND mu.ROLES LIKE '%,28,%'
                WHERE 1=1

                UNION ALL

                SELECT 'Completed' as status, CASE WHEN po.po_type = 10 THEN 'Goods' WHEN po.po_type = 20 THEN 'Services' ELSE 'Blanked' END as arf_type, f.po_no, f.created_by, f.created_at, f.total_base, mu.NAME as specialist
                FROM t_arf as f
                JOIN t_purchase_order po ON po.po_no=f.po_no
                JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf GROUP BY id_ref) a ON a.id_ref=f.id
                JOIN t_approval_arf b ON b.id_ref=a.id_ref AND b.sequence=a.sequence AND b.status=1
                JOIN t_arf_notification n ON n.doc_no=f.doc_no
                JOIN (SELECT max(sequence) as sequence, doc_id FROM t_approval_arf_notification GROUP BY doc_id) aa ON aa.doc_id=f.id
                JOIN t_approval_arf_notification taan ON taan.sequence=aa.sequence AND taan.status_approve = 1
                JOIN t_arf_recommendation_preparation r ON r.doc_no=f.doc_no
                JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf_recom GROUP BY id_ref) aaa ON aaa.id_ref=f.id
                JOIN t_approval_arf_recom taar ON taar.sequence=aaa.sequence AND taar.status=1
                LEFT JOIN m_user mu ON mu.ID_USER=f.created_by AND mu.ROLES LIKE '%,28,%'
                WHERE f.doc_no NOT IN (SELECT doc_no FROM t_arf_acceptance)

                UNION ALL

                SELECT DISTINCT 'Signed' as status, CASE WHEN po.po_type = 10 THEN 'Goods' WHEN po.po_type = 20 THEN 'Services' ELSE 'Blanked' END as arf_type, f.po_no, f.created_by, f.created_at, f.total_base, mu.NAME as specialist
                FROM t_arf as f
                JOIN t_purchase_order po ON po.po_no=f.po_no
                JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf GROUP BY id_ref) a ON a.id_ref=f.id
                JOIN t_approval_arf b ON b.id_ref=a.id_ref AND b.sequence=a.sequence AND b.status=1
                JOIN t_arf_notification n ON n.doc_no=f.doc_no
                JOIN (SELECT max(sequence) as sequence, doc_id FROM t_approval_arf_notification GROUP BY doc_id) aa ON aa.doc_id=f.id
                JOIN t_approval_arf_notification taan ON taan.sequence=aa.sequence AND taan.status_approve = 1
                JOIN t_arf_recommendation_preparation r ON r.doc_no=f.doc_no
                JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf_recom GROUP BY id_ref) aaa ON aaa.id_ref=f.id
                JOIN t_approval_arf_recom taar ON taar.sequence=aaa.sequence AND taar.status=1
                LEFT JOIN m_user mu ON mu.ID_USER=f.created_by AND mu.ROLES LIKE '%,28,%'
                WHERE f.doc_no IN (SELECT doc_no FROM t_arf_acceptance) ) arf_t
                LEFT JOIN t_purchase_order ON t_purchase_order.po_no=arf_t.po_no
                LEFT JOIN t_msr msr ON msr.msr_no=t_purchase_order.msr_no
                LEFT JOIN m_user m ON m.ID_USER=arf_t.created_by
                LEFT JOIN t_assignment ON t_assignment.msr_no = msr.msr_no
                ".$condition_query."
             ) arf_t

            GROUP BY created_at, arf_type";
      return $this->db->query($sql)->result();
    }

    public function get_specialist($filter) {
      $condition = array();
      if (isset($filter['periode'])) {
          $condition[] = 'LEFT(arf_t.created_at, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
      }
      if (isset($filter['company'])) {
          $condition[] = 'msr.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
      }
      if (isset($filter['department'])) {
          $condition[] = 'm.ID_DEPARTMENT IN (\''.implode('\',\'', $filter['department']).'\')';
      }
      if (isset($filter['status'])) {
          $condition[] = 'arf_t.status IN (\''.implode('\',\'', $filter['status']).'\')';
      }
      if (isset($filter['type'])) {
          $condition[] = 'arf_t.arf_type IN (\''.implode('\',\'', $filter['type']).'\')';
      }
      if (isset($filter['method'])) {
          $condition[] = 'msr.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
      }
      if (isset($filter['specialist'])) {
          $condition[] = 'arf_t.created_by IN (\''.implode('\',\'', $filter['specialist']).'\')';
      }
      if (count($condition) <> 0) {
          $condition_query = 'WHERE '.implode(' AND ', $condition);
      } else {
          $condition_query = '';
      }
      $sql = "SELECT SUM(total_base) as value, COUNT(1) as number, arf_t.specialist, LEFT(created_at,7) as periode
            	FROM (SELECT arf_t.* FROM (	SELECT 'Preparation' as status, CASE WHEN po.po_type = 10 THEN 'Goods' WHEN po.po_type = 20 THEN 'Services' ELSE 'Blanked' END as arf_type, f.po_no, f.created_by, f.created_at, f.total_base, mu.NAME as specialist
            		FROM t_arf as f
            		JOIN t_purchase_order po ON po.po_no=f.po_no
            		JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf GROUP BY id_ref) a ON a.id_ref=f.id
            		JOIN t_approval_arf b ON b.id_ref=a.id_ref AND b.sequence=a.sequence AND b.status=0
            		LEFT JOIN m_user mu ON mu.ID_USER=f.created_by AND mu.ROLES LIKE '%,28,%'
            		WHERE 1=1
            		UNION
            		SELECT 'Preparation' as status, CASE WHEN po.po_type = 10 THEN 'Goods' WHEN po.po_type = 20 THEN 'Services' ELSE 'Blanked' END as arf_type, n.po_no, f.created_by, f.created_at, f.total_base, mu.NAME as specialist
            		FROM t_arf as f
            		JOIN t_purchase_order po ON po.po_no=f.po_no
            		JOIN t_arf_notification n ON n.po_no=f.po_no
            		JOIN (SELECT max(sequence) as sequence, doc_id FROM t_approval_arf_notification GROUP BY doc_id) a ON a.doc_id=n.id
            		JOIN t_approval_arf_notification b ON b.doc_id=a.doc_id AND b.sequence=a.sequence AND b.status_approve=0
            		LEFT JOIN m_user mu ON mu.ID_USER=f.created_by AND mu.ROLES LIKE '%,28,%'
            		WHERE 1=1
            		UNION
            		SELECT 'Preparation' as status, CASE WHEN po.po_type = 10 THEN 'Goods' WHEN po.po_type = 20 THEN 'Services' ELSE 'Blanked' END as arf_type, n.po_no, f.created_by, f.created_at, f.total_base, mu.NAME as specialist
            		FROM t_arf as f
            		JOIN t_purchase_order po ON po.po_no=f.po_no
            		JOIN t_arf_recommendation_preparation n ON n.po_no=f.po_no
            		JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf_recom GROUP BY id_ref) a ON a.id_ref=n.id
            		JOIN t_approval_arf_recom b ON b.id_ref=a.id_ref AND b.sequence=a.sequence AND b.status=0
            		LEFT JOIN m_user mu ON mu.ID_USER=f.created_by AND mu.ROLES LIKE '%,28,%'
            		WHERE 1=1

            		UNION ALL

            		SELECT 'Completed' as status, CASE WHEN po.po_type = 10 THEN 'Goods' WHEN po.po_type = 20 THEN 'Services' ELSE 'Blanked' END as arf_type, f.po_no, f.created_by, f.created_at, f.total_base, mu.NAME as specialist
            		FROM t_arf as f
            		JOIN t_purchase_order po ON po.po_no=f.po_no
            		JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf GROUP BY id_ref) a ON a.id_ref=f.id
            		JOIN t_approval_arf b ON b.id_ref=a.id_ref AND b.sequence=a.sequence AND b.status=1
            		JOIN t_arf_notification n ON n.doc_no=f.doc_no
            		JOIN (SELECT max(sequence) as sequence, doc_id FROM t_approval_arf_notification GROUP BY doc_id) aa ON aa.doc_id=f.id
            		JOIN t_approval_arf_notification taan ON taan.sequence=aa.sequence AND taan.status_approve = 1
            		JOIN t_arf_recommendation_preparation r ON r.doc_no=f.doc_no
            		JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf_recom GROUP BY id_ref) aaa ON aaa.id_ref=f.id
            		JOIN t_approval_arf_recom taar ON taar.sequence=aaa.sequence AND taar.status=1
            		LEFT JOIN m_user mu ON mu.ID_USER=f.created_by AND mu.ROLES LIKE '%,28,%'
            		WHERE f.doc_no NOT IN (SELECT doc_no FROM t_arf_acceptance)

            		UNION ALL

            		SELECT DISTINCT 'Signed' as status, CASE WHEN po.po_type = 10 THEN 'Goods' WHEN po.po_type = 20 THEN 'Services' ELSE 'Blanked' END as arf_type, f.po_no, f.created_by, f.created_at, f.total_base, mu.NAME as specialist
            		FROM t_arf as f
            		JOIN t_purchase_order po ON po.po_no=f.po_no
            		JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf GROUP BY id_ref) a ON a.id_ref=f.id
            		JOIN t_approval_arf b ON b.id_ref=a.id_ref AND b.sequence=a.sequence AND b.status=1
            		JOIN t_arf_notification n ON n.doc_no=f.doc_no
            		JOIN (SELECT max(sequence) as sequence, doc_id FROM t_approval_arf_notification GROUP BY doc_id) aa ON aa.doc_id=f.id
            		JOIN t_approval_arf_notification taan ON taan.sequence=aa.sequence AND taan.status_approve = 1
            		JOIN t_arf_recommendation_preparation r ON r.doc_no=f.doc_no
            		JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf_recom GROUP BY id_ref) aaa ON aaa.id_ref=f.id
            		JOIN t_approval_arf_recom taar ON taar.sequence=aaa.sequence AND taar.status=1
            		LEFT JOIN m_user mu ON mu.ID_USER=f.created_by AND mu.ROLES LIKE '%,28,%'
            		WHERE f.doc_no IN (SELECT doc_no FROM t_arf_acceptance) ) arf_t
            		LEFT JOIN t_purchase_order ON t_purchase_order.po_no=arf_t.po_no
            		LEFT JOIN t_msr msr ON msr.msr_no=t_purchase_order.msr_no
            		LEFT JOIN m_user m ON m.ID_USER=arf_t.created_by
            		LEFT JOIN t_assignment ON t_assignment.msr_no = msr.msr_no
                ".$condition_query."
             ) arf_t

            GROUP BY created_at, specialist";
      return $this->db->query($sql)->result();
    }

    public function get_specialist_trend($filter) {
      $condition = array();
      if (isset($filter['periode'])) {
          $condition[] = 'LEFT(arf_t.created_at, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
      }
      if (isset($filter['company'])) {
          $condition[] = 'msr.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
      }
      if (isset($filter['department'])) {
          $condition[] = 'm.ID_DEPARTMENT IN (\''.implode('\',\'', $filter['department']).'\')';
      }
      if (isset($filter['status'])) {
          $condition[] = 'arf_t.status IN (\''.implode('\',\'', $filter['status']).'\')';
      }
      if (isset($filter['type'])) {
          $condition[] = 'arf_t.arf_type IN (\''.implode('\',\'', $filter['type']).'\')';
      }
      if (isset($filter['method'])) {
          $condition[] = 'msr.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
      }
      if (isset($filter['specialist'])) {
          $condition[] = 'arf_t.created_by IN (\''.implode('\',\'', $filter['specialist']).'\')';
      }
      if (count($condition) <> 0) {
          $condition_query = 'WHERE '.implode(' AND ', $condition);
      } else {
          $condition_query = '';
      }
      $sql = "SELECT SUM(total_base) as value, COUNT(1) as number, arf_t.specialist, LEFT(created_at,7) as periode
              FROM (SELECT arf_t.* FROM (	SELECT 'Preparation' as status, CASE WHEN po.po_type = 10 THEN 'Goods' WHEN po.po_type = 20 THEN 'Services' ELSE 'Blanked' END as arf_type, f.po_no, f.created_by, f.created_at, f.total_base, mu.NAME as specialist
                FROM t_arf as f
                JOIN t_purchase_order po ON po.po_no=f.po_no
                JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf GROUP BY id_ref) a ON a.id_ref=f.id
                JOIN t_approval_arf b ON b.id_ref=a.id_ref AND b.sequence=a.sequence AND b.status=0
                LEFT JOIN m_user mu ON mu.ID_USER=f.created_by AND mu.ROLES LIKE '%,28,%'
                WHERE 1=1
                UNION
                SELECT 'Preparation' as status, CASE WHEN po.po_type = 10 THEN 'Goods' WHEN po.po_type = 20 THEN 'Services' ELSE 'Blanked' END as arf_type, n.po_no, f.created_by, f.created_at, f.total_base, mu.NAME as specialist
                FROM t_arf as f
                JOIN t_purchase_order po ON po.po_no=f.po_no
                JOIN t_arf_notification n ON n.po_no=f.po_no
                JOIN (SELECT max(sequence) as sequence, doc_id FROM t_approval_arf_notification GROUP BY doc_id) a ON a.doc_id=n.id
                JOIN t_approval_arf_notification b ON b.doc_id=a.doc_id AND b.sequence=a.sequence AND b.status_approve=0
                LEFT JOIN m_user mu ON mu.ID_USER=f.created_by AND mu.ROLES LIKE '%,28,%'
                WHERE 1=1
                UNION
                SELECT 'Preparation' as status, CASE WHEN po.po_type = 10 THEN 'Goods' WHEN po.po_type = 20 THEN 'Services' ELSE 'Blanked' END as arf_type, n.po_no, f.created_by, f.created_at, f.total_base, mu.NAME as specialist
                FROM t_arf as f
                JOIN t_purchase_order po ON po.po_no=f.po_no
                JOIN t_arf_recommendation_preparation n ON n.po_no=f.po_no
                JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf_recom GROUP BY id_ref) a ON a.id_ref=n.id
                JOIN t_approval_arf_recom b ON b.id_ref=a.id_ref AND b.sequence=a.sequence AND b.status=0
                LEFT JOIN m_user mu ON mu.ID_USER=f.created_by AND mu.ROLES LIKE '%,28,%'
                WHERE 1=1

                UNION ALL

                SELECT 'Completed' as status, CASE WHEN po.po_type = 10 THEN 'Goods' WHEN po.po_type = 20 THEN 'Services' ELSE 'Blanked' END as arf_type, f.po_no, f.created_by, f.created_at, f.total_base, mu.NAME as specialist
                FROM t_arf as f
                JOIN t_purchase_order po ON po.po_no=f.po_no
                JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf GROUP BY id_ref) a ON a.id_ref=f.id
                JOIN t_approval_arf b ON b.id_ref=a.id_ref AND b.sequence=a.sequence AND b.status=1
                JOIN t_arf_notification n ON n.doc_no=f.doc_no
                JOIN (SELECT max(sequence) as sequence, doc_id FROM t_approval_arf_notification GROUP BY doc_id) aa ON aa.doc_id=f.id
                JOIN t_approval_arf_notification taan ON taan.sequence=aa.sequence AND taan.status_approve = 1
                JOIN t_arf_recommendation_preparation r ON r.doc_no=f.doc_no
                JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf_recom GROUP BY id_ref) aaa ON aaa.id_ref=f.id
                JOIN t_approval_arf_recom taar ON taar.sequence=aaa.sequence AND taar.status=1
                LEFT JOIN m_user mu ON mu.ID_USER=f.created_by AND mu.ROLES LIKE '%,28,%'
                WHERE f.doc_no NOT IN (SELECT doc_no FROM t_arf_acceptance)

                UNION ALL

                SELECT DISTINCT 'Signed' as status, CASE WHEN po.po_type = 10 THEN 'Goods' WHEN po.po_type = 20 THEN 'Services' ELSE 'Blanked' END as arf_type, f.po_no, f.created_by, f.created_at, f.total_base, mu.NAME as specialist
                FROM t_arf as f
                JOIN t_purchase_order po ON po.po_no=f.po_no
                JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf GROUP BY id_ref) a ON a.id_ref=f.id
                JOIN t_approval_arf b ON b.id_ref=a.id_ref AND b.sequence=a.sequence AND b.status=1
                JOIN t_arf_notification n ON n.doc_no=f.doc_no
                JOIN (SELECT max(sequence) as sequence, doc_id FROM t_approval_arf_notification GROUP BY doc_id) aa ON aa.doc_id=f.id
                JOIN t_approval_arf_notification taan ON taan.sequence=aa.sequence AND taan.status_approve = 1
                JOIN t_arf_recommendation_preparation r ON r.doc_no=f.doc_no
                JOIN (SELECT max(sequence) as sequence, id_ref FROM t_approval_arf_recom GROUP BY id_ref) aaa ON aaa.id_ref=f.id
                JOIN t_approval_arf_recom taar ON taar.sequence=aaa.sequence AND taar.status=1
                LEFT JOIN m_user mu ON mu.ID_USER=f.created_by AND mu.ROLES LIKE '%,28,%'
                WHERE f.doc_no IN (SELECT doc_no FROM t_arf_acceptance) ) arf_t
                LEFT JOIN t_purchase_order ON t_purchase_order.po_no=arf_t.po_no
                LEFT JOIN t_msr msr ON msr.msr_no=t_purchase_order.msr_no
                LEFT JOIN m_user m ON m.ID_USER=arf_t.created_by
                LEFT JOIN t_assignment ON t_assignment.msr_no = msr.msr_no
                ".$condition_query."
             ) arf_t

            GROUP BY created_at, specialist";
      return $this->db->query($sql)->result();
    }
}
?>
