<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_inventory_stock extends CI_Model {

    public function get_stock_moving($filter) {
        if (isset($filter['periode']) <> 0) {
            $condition[] = 'LEFT(s.CREATED, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'c.ID_COMPANY IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'CASE
                WHEN u.ID_DEPARTMENT IS NULL AND CONCAT(c.ID_COMPANY, \'3800\') IN (\''.implode('\',\'', $filter['department']).'\') THEN TRUE
                ELSE  u.ID_DEPARTMENT IN (\''.implode('\',\'', $filter['department']).'\')
            END';
        }
        if (isset($filter['movement_type'])) {
            $condition[] = 'm.id IN (\''.implode('\',\'', $filter['movement_type']).'\')';
        }
        if (isset($filter['requestor'])) {
            $condition[] = 'u.ID_USER IN (\''.implode('\',\'', $filter['requestor']).'\')';
        }
        if (isset($filter['category'])) {
            $condition[] = 'CAST(LEFT(s.SEMIC_NO, 2) AS SIGNED) IN (\''.implode('\',\'', $filter['category']).'\')';
        }
        if (count($condition) <> 0) {
            $condition_query = 'WHERE '.implode(' AND ', $condition);
        } else {
            $condition_query = '';
        }  
        $sql = "SELECT c.ID_COMPANY AS ID_COMPANY,c.DESCRIPTION  AS COMPANY,m.description AS DOC,COUNT(DISTINCT DOC_ID)  AS TRANSACTION,SUM(COALESCE(ABS(s.TOTAL),0)) as TOTAL FROM m_company c
        join m_mutasi_doc_type m on m.STATUS=1
        LEFT join sync_mutasi_stock s on s.DOC=m.doc_type and LEFT(TRIM(s.BRACH_PLANT),5)=c.ID_COMPANY
		left join t_material_request r on r.request_no like '%'
        left join m_user u on u.ID_USER=r.create_by
        ".$condition_query."
        GROUP BY c.ID_COMPANY,c.DESCRIPTION,m.description";
        return $result = $this->db->query($sql)->result();            
    }

    public function get_stock_moving_trend($filter) {
        if (isset($filter['periode']) <> 0) {
            $condition[] = 'LEFT(s.CREATED, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'c.ID_COMPANY IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'CASE
                WHEN u.ID_DEPARTMENT IS NULL AND CONCAT(c.ID_COMPANY, \'3800\') IN (\''.implode('\',\'', $filter['department']).'\') THEN TRUE
                ELSE  u.ID_DEPARTMENT IN (\''.implode('\',\'', $filter['department']).'\')
            END';
        }
        if (isset($filter['movement_type'])) {
            $condition[] = 'm.id IN (\''.implode('\',\'', $filter['movement_type']).'\')';
        }
        if (isset($filter['category'])) {
            $condition[] = 'CAST(LEFT(s.SEMIC_NO, 2) AS SIGNED) IN (\''.implode('\',\'', $filter['category']).'\')';
        }
        if (count($condition) <> 0) {
            $condition_query = 'WHERE '.implode(' AND ', $condition);
        } else {
            $condition_query = '';
        } 
        

        $sql = "SELECT LEFT(s.DATED, 7) AS PERIODE,c.ID_COMPANY AS ID_COMPANY,c.DESCRIPTION  AS COMPANY,m.description AS DOC,SUM(COALESCE(ABS(s.TOTAL),0)) as TOTAL FROM m_company c
        join m_mutasi_doc_type m on m.STATUS=1
        LEFT join sync_mutasi_stock s on s.DOC=m.doc_type and LEFT(TRIM(s.BRACH_PLANT),5)=c.ID_COMPANY
		left join t_material_request r on r.request_no like '%'
		left join m_user u on u.ID_USER=r.create_by
        ".$condition_query."
        GROUP BY LEFT(s.DATED, 7),c.ID_COMPANY,c.DESCRIPTION,m.description";
        return $result = $this->db->query($sql)->result();            
    }
}