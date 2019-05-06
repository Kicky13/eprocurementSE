<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_budget_spending extends CI_MODEL
{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_compndept()
    {
        $res=$this->db->query(
            "SELECT DISTINCT m.ID_COMPANY,m.DESCRIPTION,d.ID_DEPARTMENT,d.DEPARTMENT_DESC
            FROM m_company m
            JOIN m_departement d ON m.ID_COMPANY=d.ID_COMPANY AND d.status=1
            WHERE m.status=1"
        );
        if($res->num_rows()!=null)
            return $res->result();
        else
            return false;
    }

    public function get_budget_spending($filter) {
        $condition = array();
        if (isset($filter['periode'])) {
            $condition[] = 'LEFT(po.po_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'po.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'msr.id_department IN (\''.implode('\',\'', $filter['department']).'\')';
        }
        if (isset($filter['costcenter'])) {
            $condition[] = 'pod.id_costcenter IN (\''.implode('\',\'', $filter['costcenter']).'\')';
        }
        if (isset($filter['accsub'])) {
            $condition[] = 'pod.id_accsub IN (\''.implode('\',\'', $filter['accsub']).'\')';
        }
        if (count($condition) <> 0) {
            $condition_query = 'AND '.implode(' AND ', $condition);
        } else {
            $condition_query = '';
        }
        $sql = "SELECT status, SUM(total_price_base) as value, company
                FROM (SELECT 'Allocated' as status, c.ABBREVIATION as company, po.id, po.po_no, po.msr_no, po.id_company,
                LEFT(po.po_date, 7) as periode, pod.id_costcenter, pod.id_accsub, pod.total_price_base, msr.id_department, d.DEPARTMENT_DESC
                FROM t_purchase_order po
                JOIN t_purchase_order_detail pod ON pod.po_id=po.id
                JOIN m_company c ON c.ID_COMPANY=po.id_company
                JOIN t_msr msr ON msr.msr_no=po.msr_no
                JOIN m_departement d ON d.ID_DEPARTMENT=msr.id_department
                WHERE po.accept_completed = 1 ".$condition_query."
                UNION
                SELECT 'Allocated' as status, 'ALL' as company, po.id, po.po_no, po.msr_no, po.id_company,
                LEFT(po.po_date, 7) as periode, pod.id_costcenter, pod.id_accsub, pod.total_price_base, msr.id_department, d.DEPARTMENT_DESC
                FROM t_purchase_order po
                JOIN t_purchase_order_detail pod ON pod.po_id=po.id
                JOIN m_company c ON c.ID_COMPANY=po.id_company
                JOIN t_msr msr ON msr.msr_no=po.msr_no
                JOIN m_departement d ON d.ID_DEPARTMENT=msr.id_department
                WHERE po.accept_completed = 1 ".$condition_query."
                ) t_po
                GROUP BY company, status,id_costcenter, id_accsub
                UNION ALL
                SELECT status, SUM(bg.total_price_base) as value2, company FROM
                ( SELECT 'Approved' as status, b.amount, pod.total_price_base, com.ID_COMPANY, com.ABBREVIATION as company, cos.ID_COSTCENTER, cos.COSTCENTER_DESC, acc.ID_ACCSUB, LEFT(po.po_date, 7) as periode
                FROM m_company com
                JOIN m_costcenter cos ON cos.ID_COMPANY=com.ID_COMPANY
                JOIN m_accsub acc ON acc.COSTCENTER=cos.ID_COSTCENTER
                JOIN t_msr msr ON msr.id_department=cos.ID_COSTCENTER
                JOIN t_purchase_order po ON po.msr_no=msr.msr_no
                JOIN t_purchase_order_detail pod ON pod.po_id=po.id AND pod.id_accsub=acc.ID_ACCSUB
                LEFT JOIN m_budget b ON b.id_costcenter=cos.ID_COSTCENTER AND b.id_accsub=acc.ID_ACCSUB
                WHERE po.accept_completed = 1 ".$condition_query."
                UNION
                SELECT 'Approved' as status, b.amount, pod.total_price_base, com.ID_COMPANY, 'ALL' as company, cos.ID_COSTCENTER, cos.COSTCENTER_DESC, acc.ID_ACCSUB, LEFT(po.po_date, 7) as periode
                FROM m_company com
                JOIN m_costcenter cos ON cos.ID_COMPANY=com.ID_COMPANY
                JOIN m_accsub acc ON acc.COSTCENTER=cos.ID_COSTCENTER
                JOIN t_msr msr ON msr.id_department=cos.ID_COSTCENTER
                JOIN t_purchase_order po ON po.msr_no=msr.msr_no
                JOIN t_purchase_order_detail pod ON pod.po_id=po.id AND pod.id_accsub=acc.ID_ACCSUB
                LEFT JOIN m_budget b ON b.id_costcenter=cos.ID_COSTCENTER AND b.id_accsub=acc.ID_ACCSUB
                WHERE po.accept_completed = 1 ".$condition_query."
                 ) bg
                GROUP BY company, status
                UNION ALL
                SELECT * FROM (SELECT allocated.status, (COALESCE(approved.value2, 0) - COALESCE(allocated.value, 0)) as value, allocated.company FROM (SELECT status, SUM(total_price_base) as value, company, id_costcenter, id_accsub, LEFT(po_date, 7) as periode
                FROM (SELECT 'Remaining' as status, c.ABBREVIATION as company, po.id, po.po_no, po.msr_no, po.id_company,
                po.po_date, pod.id_costcenter, pod.id_accsub, pod.total_price_base, msr.id_department, d.DEPARTMENT_DESC
                FROM t_purchase_order po
                JOIN t_purchase_order_detail pod ON pod.po_id=po.id
                JOIN m_company c ON c.ID_COMPANY=po.id_company
                JOIN t_msr msr ON msr.msr_no=po.msr_no
                JOIN m_departement d ON d.ID_DEPARTMENT=msr.id_department
                WHERE po.accept_completed = 1 ".$condition_query."
                ) t_po
                GROUP BY company, status,id_costcenter, id_accsub,po_date ) allocated
                LEFT JOIN
                (SELECT status, SUM(bg.total_price_base) as value2, company FROM
                ( SELECT 'Remaining' as status, b.amount, pod.total_price_base, com.ID_COMPANY, com.ABBREVIATION as company, cos.ID_COSTCENTER, cos.COSTCENTER_DESC, acc.ID_ACCSUB, LEFT(po.po_date, 7) as periode
                FROM m_company com
                JOIN m_costcenter cos ON cos.ID_COMPANY=com.ID_COMPANY
                JOIN m_accsub acc ON acc.COSTCENTER=cos.ID_COSTCENTER
                JOIN t_msr msr ON msr.id_department=cos.ID_COSTCENTER
                JOIN t_purchase_order po ON po.msr_no=msr.msr_no
                JOIN t_purchase_order_detail pod ON pod.po_id=po.id AND pod.id_accsub=acc.ID_ACCSUB
                LEFT JOIN m_budget b ON b.id_costcenter=cos.ID_COSTCENTER AND b.id_accsub=acc.ID_ACCSUB
                WHERE po.accept_completed = 1 ".$condition_query."
                 ) bg
                GROUP BY company, status ) approved ON approved.company=allocated.company) rmn
                UNION
                SELECT * FROM (SELECT allocated.status, (COALESCE(approved.value2, 0) - COALESCE(allocated.value, 0)) as value, allocated.company FROM (SELECT status, SUM(total_price_base) as value, company, DEPARTMENT_DESC, id_costcenter, id_accsub, LEFT(po_date, 7) as periode
                FROM (SELECT 'Remaining' as status, 'ALL' as company, po.id, po.po_no, po.msr_no, po.id_company,
                po.po_date, pod.id_costcenter, pod.id_accsub, pod.total_price_base, msr.id_department, d.DEPARTMENT_DESC
                FROM t_purchase_order po
                JOIN t_purchase_order_detail pod ON pod.po_id=po.id
                JOIN m_company c ON c.ID_COMPANY=po.id_company
                JOIN t_msr msr ON msr.msr_no=po.msr_no
                JOIN m_departement d ON d.ID_DEPARTMENT=msr.id_department
                WHERE po.accept_completed = 1 ".$condition_query."
                ) t_po
                GROUP BY company, status,id_costcenter, id_accsub,po_date,DEPARTMENT_DESC ) allocated
                LEFT JOIN
                (SELECT status, SUM(bg.total_price_base) as value2, company FROM
                ( SELECT 'Remaining' as status, b.amount, pod.total_price_base, com.ID_COMPANY, 'ALL' as company, cos.ID_COSTCENTER, cos.COSTCENTER_DESC, acc.ID_ACCSUB, LEFT(po.po_date, 7) as periode
                FROM m_company com
                JOIN m_costcenter cos ON cos.ID_COMPANY=com.ID_COMPANY
                JOIN m_accsub acc ON acc.COSTCENTER=cos.ID_COSTCENTER
                JOIN t_msr msr ON msr.id_department=cos.ID_COSTCENTER
                JOIN t_purchase_order po ON po.msr_no=msr.msr_no
                JOIN t_purchase_order_detail pod ON pod.po_id=po.id AND pod.id_accsub=acc.ID_ACCSUB
                LEFT JOIN m_budget b ON b.id_costcenter=cos.ID_COSTCENTER AND b.id_accsub=acc.ID_ACCSUB
                WHERE po.accept_completed = 1 ".$condition_query."
                 ) bg
                GROUP BY company, status ) approved ON approved.company=allocated.company) rmn
                ";
        return $this->db->query($sql)->result();
    }

    public function get_budget_spending_trend($filter) {
      $condition = array();
      if (isset($filter['periode'])) {
          $condition[] = 'LEFT(po.po_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
      }
      if (isset($filter['company'])) {
          $condition[] = 'po.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
      }
      if (isset($filter['department'])) {
          $condition[] = 'msr.id_department IN (\''.implode('\',\'', $filter['department']).'\')';
      }
      if (isset($filter['costcenter'])) {
          $condition[] = 'pod.id_costcenter IN (\''.implode('\',\'', $filter['costcenter']).'\')';
      }
      if (isset($filter['accsub'])) {
          $condition[] = 'pod.id_accsub IN (\''.implode('\',\'', $filter['accsub']).'\')';
      }
      if (count($condition) <> 0) {
          $condition_query = 'AND '.implode(' AND ', $condition);
      } else {
          $condition_query = '';
      }
      $sql = "SELECT status, SUM(total_price_base) as value, company, periode
              FROM (SELECT 'Allocated' as status, c.ABBREVIATION as company, po.id, po.po_no, po.msr_no, po.id_company,
              LEFT(po.po_date, 7) as periode, pod.id_costcenter, pod.id_accsub, pod.total_price_base, msr.id_department
              FROM t_purchase_order po
              JOIN t_purchase_order_detail pod ON pod.po_id=po.id
              JOIN m_company c ON c.ID_COMPANY=po.id_company
              JOIN t_msr msr ON msr.msr_no=po.msr_no
              JOIN m_departement d ON d.ID_DEPARTMENT=msr.id_department
              WHERE po.accept_completed = 1 ".$condition_query."
              UNION
              SELECT 'Allocated' as status, 'ALL' as company, po.id, po.po_no, po.msr_no, po.id_company,
              LEFT(po.po_date, 7) as periode, pod.id_costcenter, pod.id_accsub, pod.total_price_base, msr.id_department
              FROM t_purchase_order po
              JOIN t_purchase_order_detail pod ON pod.po_id=po.id
              JOIN m_company c ON c.ID_COMPANY=po.id_company
              JOIN t_msr msr ON msr.msr_no=po.msr_no
              JOIN m_departement d ON d.ID_DEPARTMENT=msr.id_department
              WHERE po.accept_completed = 1 ".$condition_query."
              ) t_po
              GROUP BY company, status, periode
              UNION ALL
              SELECT status, SUM(bg.total_price_base) as value2, company, periode FROM
              ( SELECT 'Approved' as status, b.amount, pod.total_price_base, com.ID_COMPANY, com.ABBREVIATION as company, cos.ID_COSTCENTER, cos.COSTCENTER_DESC, acc.ID_ACCSUB, LEFT(po.po_date, 7) as periode
              FROM m_company com
              JOIN m_costcenter cos ON cos.ID_COMPANY=com.ID_COMPANY
              JOIN m_accsub acc ON acc.COSTCENTER=cos.ID_COSTCENTER
              JOIN t_msr msr ON msr.id_department=cos.ID_COSTCENTER
              JOIN t_purchase_order po ON po.msr_no=msr.msr_no
              JOIN t_purchase_order_detail pod ON pod.po_id=po.id AND pod.id_accsub=acc.ID_ACCSUB
              LEFT JOIN m_budget b ON b.id_costcenter=cos.ID_COSTCENTER AND b.id_accsub=acc.ID_ACCSUB
              WHERE po.accept_completed = 1 ".$condition_query."
              UNION
              SELECT 'Approved' as status, b.amount, pod.total_price_base, com.ID_COMPANY, 'ALL' as company, cos.ID_COSTCENTER, cos.COSTCENTER_DESC, acc.ID_ACCSUB, LEFT(po.po_date, 7) as periode
              FROM m_company com
              JOIN m_costcenter cos ON cos.ID_COMPANY=com.ID_COMPANY
              JOIN m_accsub acc ON acc.COSTCENTER=cos.ID_COSTCENTER
              JOIN t_msr msr ON msr.id_department=cos.ID_COSTCENTER
              JOIN t_purchase_order po ON po.msr_no=msr.msr_no
              JOIN t_purchase_order_detail pod ON pod.po_id=po.id AND pod.id_accsub=acc.ID_ACCSUB
              LEFT JOIN m_budget b ON b.id_costcenter=cos.ID_COSTCENTER AND b.id_accsub=acc.ID_ACCSUB
              WHERE po.accept_completed = 1 ".$condition_query."
               ) bg
              GROUP BY company, status, periode
              UNION ALL
              SELECT * FROM (SELECT allocated.status, (COALESCE(approved.value2, 0) - COALESCE(allocated.value, 0)) as value, allocated.company, periode FROM (SELECT status, SUM(total_price_base) as value, company, id_costcenter, id_accsub, LEFT(po_date, 7) as periode
              FROM (SELECT 'Remaining' as status, c.ABBREVIATION as company, po.id, po.po_no, po.msr_no, po.id_company,
              po.po_date, pod.id_costcenter, pod.id_accsub, pod.total_price_base, msr.id_department
              FROM t_purchase_order po
              JOIN t_purchase_order_detail pod ON pod.po_id=po.id
              JOIN m_company c ON c.ID_COMPANY=po.id_company
              JOIN t_msr msr ON msr.msr_no=po.msr_no
              JOIN m_departement d ON d.ID_DEPARTMENT=msr.id_department
              WHERE po.accept_completed = 1 ".$condition_query."
              ) t_po
              GROUP BY company, status, periode,id_costcenter, id_accsub ) allocated
              LEFT JOIN
              (SELECT status, SUM(bg.total_price_base) as value2, company FROM
              ( SELECT 'Remaining' as status, b.amount, pod.total_price_base, com.ID_COMPANY, com.ABBREVIATION as company, cos.ID_COSTCENTER, cos.COSTCENTER_DESC, acc.ID_ACCSUB, LEFT(po.po_date, 7) as periode
              FROM m_company com
              JOIN m_costcenter cos ON cos.ID_COMPANY=com.ID_COMPANY
              JOIN m_accsub acc ON acc.COSTCENTER=cos.ID_COSTCENTER
              JOIN t_msr msr ON msr.id_department=cos.ID_COSTCENTER
              JOIN t_purchase_order po ON po.msr_no=msr.msr_no
              JOIN t_purchase_order_detail pod ON pod.po_id=po.id AND pod.id_accsub=acc.ID_ACCSUB
              LEFT JOIN m_budget b ON b.id_costcenter=cos.ID_COSTCENTER AND b.id_accsub=acc.ID_ACCSUB
              WHERE po.accept_completed = 1 ".$condition_query."
               ) bg
              GROUP BY company, status, periode ) approved ON approved.company=allocated.company) rmn
              UNION
              SELECT * FROM (SELECT allocated.status, (COALESCE(approved.value2, 0) - COALESCE(allocated.value, 0)) as value, allocated.company, periode FROM (SELECT status, SUM(total_price_base) as value, company, id_costcenter, id_accsub, LEFT(po_date, 7) as periode
              FROM (SELECT 'Remaining' as status, 'ALL' as company, po.id, po.po_no, po.msr_no, po.id_company,
              po.po_date, pod.id_costcenter, pod.id_accsub, pod.total_price_base, msr.id_department
              FROM t_purchase_order po
              JOIN t_purchase_order_detail pod ON pod.po_id=po.id
              JOIN m_company c ON c.ID_COMPANY=po.id_company
              JOIN t_msr msr ON msr.msr_no=po.msr_no
              JOIN m_departement d ON d.ID_DEPARTMENT=msr.id_department
              WHERE po.accept_completed = 1 ".$condition_query."
              ) t_po
              GROUP BY company, status, periode,id_costcenter, id_accsub ) allocated
              LEFT JOIN
              (SELECT status, SUM(bg.total_price_base) as value2, company FROM
              ( SELECT 'Remaining' as status, b.amount, pod.total_price_base, com.ID_COMPANY, 'ALL' as company, cos.ID_COSTCENTER, cos.COSTCENTER_DESC, acc.ID_ACCSUB, LEFT(po.po_date, 7) as periode
              FROM m_company com
              JOIN m_costcenter cos ON cos.ID_COMPANY=com.ID_COMPANY
              JOIN m_accsub acc ON acc.COSTCENTER=cos.ID_COSTCENTER
              JOIN t_msr msr ON msr.id_department=cos.ID_COSTCENTER
              JOIN t_purchase_order po ON po.msr_no=msr.msr_no
              JOIN t_purchase_order_detail pod ON pod.po_id=po.id AND pod.id_accsub=acc.ID_ACCSUB
              LEFT JOIN m_budget b ON b.id_costcenter=cos.ID_COSTCENTER AND b.id_accsub=acc.ID_ACCSUB
              WHERE po.accept_completed = 1 ".$condition_query."
               ) bg
              GROUP BY company, status, periode ) approved ON approved.company=allocated.company) rmn
              ";
      return $this->db->query($sql)->result();
    }

}
?>
