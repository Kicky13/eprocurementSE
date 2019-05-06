<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_inventory_ratio extends CI_Model {

    public function get_ito($filter) {
        if (isset($filter['periode']) <> 0) {
            $condition[] = 'LEFT(sync_mutasi_stock.CREATED, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'm_company.ID_COMPANY IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['category'])) {
            $condition[] = 'CAST(LEFT(sync_mutasi_stock.SEMIC_NO, 2) AS SIGNED) IN (\''.implode('\',\'', $filter['category']).'\')';
        }
        if (count($condition) <> 0) {
            $condition_query = 'WHERE '.implode(' AND ', $condition);
        } else {
            $condition_query = '';
        }  
        $sql = 'SELECT  DISTINCT
            LEFT(CREATED,7) AS PERIODE, 
            (
                SELECT SUM(TOTAL)
                FROM sync_mutasi_stock balance
                WHERE LEFT(balance.CREATED, 7) <= LEFT(sync_mutasi_stock.CREATED,7)
            ) BALANCE,
            -(
                SELECT 
                    SUM(TOTAL)
                FROM sync_mutasi_stock ltmi         
                WHERE LEFT(ltmi.CREATED, 7) >= LEFT(DATE_ADD(sync_mutasi_stock.CREATED, INTERVAL -12 MONTH), 7)
                AND LEFT (ltmi.CREATED, 7) <= LEFT(sync_mutasi_stock.CREATED, 7)    
                AND ltmi.DOC = \'II\'
            ) LTMI
        FROM sync_mutasi_stock
        JOIN m_bplant ON m_bplant.ID_BPLANT = TRIM(sync_mutasi_stock.BRACH_PLANT)
        JOIN m_company ON m_company.ID_COMPANY = LEFT(m_bplant.ID_BPLANT, 5)
        '.$condition_query.'
        ORDER BY LEFT(sync_mutasi_stock.CREATED, 7) ASC';
        return $this->db->query($sql)->result();
    }

    public function get_service_level($filter) {
        if (isset($filter['periode']) <> 0) {
            $condition[] = 'LEFT(sync_mutasi_stock.CREATED, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'm_company.ID_COMPANY IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['category'])) {
            $condition[] = 'CAST(LEFT(sync_mutasi_stock.SEMIC_NO, 2) AS SIGNED) IN (\''.implode('\',\'', $filter['category']).'\')';
        }
        if (count($condition) <> 0) {
            $condition_query = 'AND '.implode(' AND ', $condition);
        } else {
            $condition_query = '';
        }        
        $sql = 'SELECT  
            LEFT(CREATED,7) AS PERIODE, 
            SUM(-sync_mutasi_stock.QTY) AS ISSUED_QTY,
            SUM(t_material_request_item.qty_act) AS SERVICE_QTY
        FROM sync_mutasi_stock
        JOIN t_material_request_item ON t_material_request_item.request_no = sync_mutasi_stock.DOC_NO AND t_material_request_item.semic_no = sync_mutasi_stock.SEMIC_NO
        JOIN m_bplant ON m_bplant.ID_BPLANT = TRIM(sync_mutasi_stock.BRACH_PLANT)
        JOIN m_company ON m_company.ID_COMPANY = LEFT(m_bplant.ID_BPLANT, 5)
        WHERE sync_mutasi_stock.DOC = \'II\'
        '.$condition_query.'
        GROUP BY LEFT(sync_mutasi_stock.CREATED, 7)
        ORDER BY LEFT(sync_mutasi_stock.CREATED, 7) ASC';
        return $this->db->query($sql)->result();
    }
}