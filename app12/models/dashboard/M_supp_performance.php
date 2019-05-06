<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_supp_performance extends CI_Model {

    public function get_performance($filter) {
        $rating = $this->m_dashboard->get_supplier_rating();
        $condition = array();
        if (isset($filter['periode'])) {
            $condition[] = 'LEFT(t_purchase_order.po_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['classification'])) {
            $condition_clasification[]='m_vendor.CLASSIFICATION LIKE \'%'.$filter['classification'][0].'%\'';
            unset($filter['classification'][0]);
            foreach($filter['classification'] as $classification) {
                $condition_clasification[]='m_vendor.CLASSIFICATION LIKE \'%'.$classification.'%\'';
            }
            $condition[] = '('.implode(' OR ', $condition_clasification).')';
        }
        if (isset($filter['supplier'])) {
            $condition[] = 'm_vendor.ID IN (\''.implode('\',\'', $filter['supplier']).'\')';
        }
        if (count($condition) <> 0) {
            $condition_query = implode(' AND ', $condition);
        } else {
            $condition_query = '';
        }
        if (isset($filter['rating'])) {
            $this->db->having('PERFORMANCE IN (\''.implode('\',\'', $filter['rating']).'\')');
        }
        if ($condition_query) {
            $this->db->where($condition_query, null, false);
        }
        return $this->db->select('m_vendor.ID, m_vendor.NAMA, m_vendor.NO_SLKA,m_vendor.CLASSIFICATION, AVG(t_performance_cor.score) AVG_RATING,
            (CASE
                WHEN AVG(t_performance_cor.score) >= '.$rating['Excellent']->score_bawah.' THEN \'Excellent\'
                WHEN AVG(t_performance_cor.score) <= '.$rating['Good']->score_atas.' AND AVG(t_performance_cor.score) <= '.$rating['Good']->score_bawah.' THEN \'Good\'
                WHEN AVG(t_performance_cor.score) <= '.$rating['Fair']->score_atas.' AND AVG(t_performance_cor.score) <= '.$rating['Fair']->score_bawah.' THEN \'Fair\'
                ELSE \'Poor\'
            END) PERFORMANCE
        ')
        ->join('t_purchase_order', 't_purchase_order.po_no = t_performance_cor.po_no')
        ->join('m_vendor', 'm_vendor.ID = t_performance_cor.vendor_id')
        ->group_by(array('m_vendor.ID', 'm_vendor.NAMA', 'm_vendor.NO_SLKA', 'm_vendor.CLASSIFICATION'))
        ->get('t_performance_cor')
        ->result();
    }

    public function get_performance_agreement($filter, $vendors) {
        $arr_vendors = [];
        foreach ($vendors as $vendor) {
            $arr_vendors[] = $vendor->ID;
        }
        return $this->db->group_by('po_type')
        ->where_in('id_vendor', $arr_vendors)
        ->get('t_purchase_order')
        ->result();
    }

    public function get_cpm_cor_agreement($filter){
      $condition = array();
      if (isset($filter['periode'])) {
          $condition[] = 'LEFT(po.po_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
      }
      if (isset($filter['classification'])) {
          $condition_clasification[]='m_vendor.CLASSIFICATION LIKE \'%'.$filter['classification'][0].'%\'';
          unset($filter['classification'][0]);
          foreach($filter['classification'] as $classification) {
              $condition_clasification[]='m_vendor.CLASSIFICATION LIKE \'%'.$classification.'%\'';
          }
          $condition[] = '('.implode(' OR ', $condition_clasification).')';
      }
      if (isset($filter['supplier'])) {
          $condition[] = 'm_vendor.ID IN (\''.implode('\',\'', $filter['supplier']).'\')';
      }
      if (count($condition) <> 0) {
          $condition_query = 'WHERE '.implode(' AND ', $condition);
      } else {
          $condition_query = '';
      }
      return $this->db->query("SELECT COUNT(1) as number, agreement.* FROM (SELECT 'Agreement' as status, 'CPM' as doc, po.po_no, po.po_type, LEFT(po.po_date, 7) as po_date
                  FROM t_purchase_order po
                  JOIN t_cpm c ON c.po_no=po.po_no
                  JOIN m_vendor ON m_vendor.ID=c.vendor_id
                  ".$condition_query."
                  UNION
                  SELECT 'Agreement' as status, 'COR' as doc, po.po_no, po.po_type, LEFT(po.po_date, 7) as po_date
                  FROM t_purchase_order po
                  JOIN t_performance_cor c ON c.po_no=po.po_no
                  JOIN m_vendor ON m_vendor.ID=c.vendor_id
                  ".$condition_query."
                  UNION ALL
                  SELECT 'Performed' as status, 'COR' as doc, po.po_no, po.po_type, LEFT(po.po_date, 7) as po_date
                  FROM t_purchase_order po
                  JOIN t_performance_cor c ON c.po_no=po.po_no
                  JOIN (SELECT MAX(sequence) as sequence, status_approve, po_no, t_cor_id FROM t_approval_cor GROUP BY po_no)
                  a ON a.t_cor_id=c.id AND a.status_approve=1
                  JOIN m_vendor ON m_vendor.ID=c.vendor_id
                  ".$condition_query."
                  UNION
                  SELECT 'Performed' as status, 'CPM' as doc, po.po_no, po.po_type, LEFT(po.po_date, 7) as po_date
                  FROM t_purchase_order po
                  JOIN t_cpm c ON c.po_no=po.po_no
                  JOIN (SELECT MAX(sequence) as sequence, status_approve, po_no FROM t_approval_cpm GROUP BY po_no)
                  a ON a.po_no=c.po_no AND a.status_approve=1
                  JOIN m_vendor ON m_vendor.ID=c.vendor_id
                  ".$condition_query."
                ) agreement
            GROUP BY  agreement.status, agreement.doc ORDER BY agreement.status DESC")->result();
    }
}
