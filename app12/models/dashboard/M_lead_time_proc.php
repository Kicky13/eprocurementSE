<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_lead_time_proc extends CI_Model
{

    public function get_procurement_method_steps($filter) {
        $condition = array();
        if (isset($filter['periode'])) {
            $condition[] = 'LEFT(msr.po_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'msr.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'm_user.ID_DEPARTMENT IN (\''.implode('\',\'', $filter['department']).'\')';
        }
        if (isset($filter['type'])) {
            $condition[] = 'msr.id_msr_type IN (\''.implode('\',\'', $filter['type']).'\')';
        }
        if (isset($filter['method'])) {
            $condition[] = 'msr.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
        }
        if (isset($filter['specialist'])) {
            $condition[] = 't_assignment.user_id IN (\''.implode('\',\'', $filter['specialist']).'\')';
        }
        if (count($condition) <> 0) {
            $condition_query = 'WHERE '.implode(' AND ', $condition);
        } else {
            $condition_query = '';
        }
        $sql = 'SELECT
            msr.description,
            step,
            id_pmethod,
            CEIL(
                AVG(
                    CASE WHEN COALESCE(days,0) = 0 THEN 1
                    ELSE days
                    END
                )
            ) days
        FROM (
            SELECT DISTINCT
                t_msr.*,
                t_purchase_order.po_no,
                t_purchase_order.po_type,
                t_purchase_order.po_date,
                \'MSR Realease\' AS description,
                1 AS step,
                DATEDIFF(t_approval.created_at, t_msr.create_on) AS days
            FROM t_msr
            JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no AND t_purchase_order.issued = 1
            JOIN t_approval ON t_approval.data_id = t_msr.msr_no
            JOIN m_approval ON m_approval.id = t_approval.m_approval_id
            WHERE m_approval.module_kode = \'msr\'
            AND t_approval.urutan = (
                SELECT MAX(a.urutan) FROM t_approval a
                JOIN m_approval b ON b.id = a.m_approval_id
                WHERE a.data_id = t_msr.msr_no
                AND b.module_kode = \'msr\'
            )

            UNION ALL

            SELECT DISTINCT
                t_msr.*,
                t_purchase_order.po_no,
                t_purchase_order.po_type,
                t_purchase_order.po_date,
                \'MSR Verification\' AS description,
                2 AS step,
                DATEDIFF(
                    t_approval.created_at, (
                        SELECT a.created_at FROM t_approval a
                        JOIN m_approval b ON b.id = a.m_approval_id
                        WHERE a.data_id = t_msr.msr_no
                        AND b.module_kode = \'msr\'
                        ORDER BY a.urutan DESC
                        LIMIT 1
                    )
                ) AS days
            FROM t_msr
            JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no AND t_purchase_order.issued = 1
            JOIN t_approval ON t_approval.data_id = t_msr.msr_no
            JOIN m_approval ON m_approval.id = t_approval.m_approval_id
            WHERE m_approval.module_kode = \'msr_spa\'
            AND t_approval.urutan = 1

            UNION ALL

            SELECT DISTINCT
                t_msr.*,
                t_purchase_order.po_no,
                t_purchase_order.po_type,
                t_purchase_order.po_date,
                \'MSR Assignment\' AS description,
                3 AS step,
                DATEDIFF(
                    t_approval.created_at, (
                        SELECT a.created_at FROM t_approval a
                        JOIN m_approval b ON b.id = a.m_approval_id
                        WHERE a.data_id = t_msr.msr_no
                        AND b.module_kode = \'msr_spa\'
                        AND a.urutan = 1
                    )
                ) AS days
            FROM t_msr
            JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no AND t_purchase_order.issued = 1
            JOIN t_approval ON t_approval.data_id = t_msr.msr_no
            JOIN m_approval ON m_approval.id = t_approval.m_approval_id
            WHERE m_approval.module_kode = \'msr_spa\'
            AND t_approval.urutan = 2

            UNION ALL

            SELECT DISTINCT
                t_msr.*,
                t_purchase_order.po_no,
                t_purchase_order.po_type,
                t_purchase_order.po_date,
                \'ED Issuance\' AS description,
                4 AS step,
                DATEDIFF(
                    t_approval.created_at, (
                        SELECT a.created_at FROM t_approval a
                        JOIN m_approval b ON b.id = a.m_approval_id
                        WHERE a.data_id = t_msr.msr_no
                        AND b.module_kode = \'msr_spa\'
                        AND a.urutan = 2
                    )
                ) AS days
            FROM t_msr
            JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no AND t_purchase_order.issued = 1
            JOIN t_approval ON t_approval.data_id = t_msr.msr_no
            JOIN m_approval ON m_approval.id = t_approval.m_approval_id
            WHERE m_approval.module_kode = \'msr_spa\'
            AND t_approval.urutan = (
                SELECT MAX(a.urutan) FROM t_approval a
                JOIN m_approval b ON b.id = a.m_approval_id
                WHERE a.data_id = t_msr.msr_no
                AND b.module_kode = \'msr_spa\'
            )

            UNION ALL

            SELECT DISTINCT
                t_msr.*,
                t_purchase_order.po_no,
                t_purchase_order.po_type,
                t_purchase_order.po_date,
                \'BID Opening\' AS description,
                5 AS step,
                DATEDIFF(
                    t_eq_data.bid_opening_date, (
                            SELECT a.created_at FROM t_approval a
                            JOIN m_approval b ON b.id = a.m_approval_id
                            WHERE a.data_id = t_msr.msr_no
                            AND b.module_kode = \'msr_spa\'
                            AND a.urutan = (
                            SELECT MAX(a.urutan) FROM t_approval a
                            JOIN m_approval b ON b.id = a.m_approval_id
                            WHERE a.data_id = t_msr.msr_no
                            AND b.module_kode = \'msr_spa\'
                        )
                    )
                ) AS days
            FROM t_msr
            JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no AND t_purchase_order.issued = 1
            JOIN t_eq_data ON t_eq_data.msr_no = t_msr.msr_no

            UNION ALL

            SELECT DISTINCT
                t_msr.*,
                t_purchase_order.po_no,
                t_purchase_order.po_type,
                t_purchase_order.po_date,
                \'Awarding\' AS description,
                6 AS step,
                DATEDIFF(
                    (
                        SELECT MAX(a.accept_award_date) FROM t_bl_detail a
                        WHERE a.msr_no = t_msr.msr_no
                    ), t_eq_data.bid_opening_date
                ) AS days
            FROM t_msr
            JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no AND t_purchase_order.issued = 1
            JOIN t_eq_data ON t_eq_data.msr_no = t_msr.msr_no

            UNION ALL

            SELECT DISTINCT
                t_msr.*,
                t_purchase_order.po_no,
                t_purchase_order.po_type,
                t_purchase_order.po_date,
                \'Agreement\' AS description,
                7 AS step,
                DATEDIFF(
                    (
                        SELECT MAX(a.issued_date) FROM t_purchase_order a
                        WHERE a.msr_no = t_msr.msr_no
                    ),
                    (
                        SELECT MAX(a.accept_award_date) FROM t_bl_detail a
                        WHERE a.msr_no = t_msr.msr_no
                    )
                ) AS days
            FROM t_msr
            JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no AND t_purchase_order.issued = 1

            UNION ALL

            SELECT DISTINCT
                t_msr.*,
                t_purchase_order.po_no,
                t_purchase_order.po_type,
                t_purchase_order.po_date,
                \'Procurement Lead Time\' AS description,
                8 AS step,
                DATEDIFF(
                    (
                        SELECT MAX(a.issued_date) FROM t_purchase_order a
                        WHERE a.msr_no = t_msr.msr_no
                    ),
                    t_approval.created_at
                ) AS days
            FROM t_msr
            JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no AND t_purchase_order.issued = 1
            JOIN t_approval ON t_approval.data_id = t_msr.msr_no
            JOIN m_approval ON m_approval.id = t_approval.m_approval_id
            WHERE m_approval.module_kode = \'msr_spa\'
            AND t_approval.urutan = 1

            UNION ALL

            SELECT DISTINCT
                t_msr.*,
                t_purchase_order.po_no,
                t_purchase_order.po_type,
                t_purchase_order.po_date,
                \'All Cycle\' AS description,
                9 AS step,
                DATEDIFF(
                    (
                        SELECT MAX(a.issued_date) FROM t_purchase_order a
                        WHERE a.msr_no = t_msr.msr_no
                    ),
                    t_msr.create_on
                ) AS days
            FROM t_msr
            JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no AND t_purchase_order.issued = 1
        ) msr
        JOIN m_user ON m_user.ID_USER = msr.create_by
        JOIN t_assignment ON t_assignment.msr_no = msr.msr_no
        '.$condition_query. '
        GROUP BY description, step, id_pmethod
        ORDER BY step ASC       ';
        return $this->db->query($sql)->result();
    }

    public function get_procurement_method_steps_trend($filter) {
        $condition = array();
        if (isset($filter['periode'])) {
            $condition[] = 'LEFT(msr.po_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'msr.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'm_user.ID_DEPARTMENT IN (\''.implode('\',\'', $filter['department']).'\')';
        }
        if (isset($filter['type'])) {
            $condition[] = 'msr.id_msr_type IN (\''.implode('\',\'', $filter['type']).'\')';
        }
        if (isset($filter['method'])) {
            $condition[] = 'msr.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
        }
        if (isset($filter['specialist'])) {
            $condition[] = 't_assignment.user_id IN (\''.implode('\',\'', $filter['specialist']).'\')';
        }
        if (count($condition) <> 0) {
            $condition_query = 'WHERE '.implode(' AND ', $condition);
        } else {
            $condition_query = '';
        }
        $sql = 'SELECT
            msr.periode,
            msr.description,
            step,
            id_pmethod,
            CEIL(
                AVG(
                    CASE WHEN COALESCE(days,0) = 0 THEN 1
                    ELSE days
                    END
                )
            ) days
        FROM (
            SELECT DISTINCT
                LEFT(t_purchase_order.po_date, 7) AS periode,
                t_msr.*,
                t_purchase_order.po_no,
                t_purchase_order.po_type,
                t_purchase_order.po_date,
                \'MSR Realease\' AS description,
                1 AS step,
                DATEDIFF(t_approval.created_at, t_msr.create_on) AS days
            FROM t_msr
            JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no AND t_purchase_order.issued = 1
            JOIN t_approval ON t_approval.data_id = t_msr.msr_no
            JOIN m_approval ON m_approval.id = t_approval.m_approval_id
            WHERE m_approval.module_kode = \'msr\'
            AND t_approval.urutan = (
                SELECT MAX(a.urutan) FROM t_approval a
                JOIN m_approval b ON b.id = a.m_approval_id
                WHERE a.data_id = t_msr.msr_no
                AND b.module_kode = \'msr\'
            )

            UNION ALL

            SELECT DISTINCT
                LEFT(t_purchase_order.po_date, 7) AS periode,
                t_msr.*,
                t_purchase_order.po_no,
                t_purchase_order.po_type,
                t_purchase_order.po_date,
                \'MSR Verification\' AS description,
                2 AS step,
                DATEDIFF(
                    t_approval.created_at, (
                        SELECT a.created_at FROM t_approval a
                        JOIN m_approval b ON b.id = a.m_approval_id
                        WHERE a.data_id = t_msr.msr_no
                        AND b.module_kode = \'msr\'
                        ORDER BY a.urutan DESC
                        LIMIT 1
                    )
                ) AS days
            FROM t_msr
            JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no AND t_purchase_order.issued = 1
            JOIN t_approval ON t_approval.data_id = t_msr.msr_no
            JOIN m_approval ON m_approval.id = t_approval.m_approval_id
            WHERE m_approval.module_kode = \'msr_spa\'
            AND t_approval.urutan = 1

            UNION ALL

            SELECT DISTINCT
                LEFT(t_purchase_order.po_date, 7) AS periode,
                t_msr.*,
                t_purchase_order.po_no,
                t_purchase_order.po_type,
                t_purchase_order.po_date,
                \'MSR Assignment\' AS description,
                3 AS step,
                DATEDIFF(
                    t_approval.created_at, (
                        SELECT a.created_at FROM t_approval a
                        JOIN m_approval b ON b.id = a.m_approval_id
                        WHERE a.data_id = t_msr.msr_no
                        AND b.module_kode = \'msr_spa\'
                        AND a.urutan = 1
                    )
                ) AS days
            FROM t_msr
            JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no AND t_purchase_order.issued = 1
            JOIN t_approval ON t_approval.data_id = t_msr.msr_no
            JOIN m_approval ON m_approval.id = t_approval.m_approval_id
            WHERE m_approval.module_kode = \'msr_spa\'
            AND t_approval.urutan = 2

            UNION ALL

            SELECT DISTINCT
                LEFT(t_purchase_order.po_date, 7) AS periode,
                t_msr.*,
                t_purchase_order.po_no,
                t_purchase_order.po_type,
                t_purchase_order.po_date,
                \'ED Issuance\' AS description,
                4 AS step,
                DATEDIFF(
                    t_approval.created_at, (
                        SELECT a.created_at FROM t_approval a
                        JOIN m_approval b ON b.id = a.m_approval_id
                        WHERE a.data_id = t_msr.msr_no
                        AND b.module_kode = \'msr_spa\'
                        AND a.urutan = 2
                    )
                ) AS days
            FROM t_msr
            JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no AND t_purchase_order.issued = 1
            JOIN t_approval ON t_approval.data_id = t_msr.msr_no
            JOIN m_approval ON m_approval.id = t_approval.m_approval_id
            WHERE m_approval.module_kode = \'msr_spa\'
            AND t_approval.urutan = (
                SELECT MAX(a.urutan) FROM t_approval a
                JOIN m_approval b ON b.id = a.m_approval_id
                WHERE a.data_id = t_msr.msr_no
                AND b.module_kode = \'msr_spa\'
            )

            UNION ALL

            SELECT DISTINCT
                LEFT(t_purchase_order.po_date, 7) AS periode,
                t_msr.*,
                t_purchase_order.po_no,
                t_purchase_order.po_type,
                t_purchase_order.po_date,
                \'BID Opening\' AS description,
                5 AS step,
                DATEDIFF(
                    t_eq_data.bid_opening_date, (
                        SELECT a.created_at FROM t_approval a
                        JOIN m_approval b ON b.id = a.m_approval_id
                        WHERE a.data_id = t_msr.msr_no
                        AND b.module_kode = \'msr_spa\'
                        AND a.urutan = (
                        SELECT MAX(a.urutan) FROM t_approval a
                        JOIN m_approval b ON b.id = a.m_approval_id
                        WHERE a.data_id = t_msr.msr_no
                        AND b.module_kode = \'msr_spa\'
                    )
                )
                ) AS days
            FROM t_msr
            JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no AND t_purchase_order.issued = 1
            JOIN t_eq_data ON t_eq_data.msr_no = t_msr.msr_no

            UNION ALL

            SELECT DISTINCT
                LEFT(t_purchase_order.po_date, 7) AS periode,
                t_msr.*,
                t_purchase_order.po_no,
                t_purchase_order.po_type,
                t_purchase_order.po_date,
                \'Awarding\' AS description,
                6 AS step,
                DATEDIFF(
                    (
                        SELECT MAX(a.accept_award_date) FROM t_bl_detail a
                        WHERE a.msr_no = t_msr.msr_no
                    ), t_eq_data.bid_opening_date
                ) AS days
            FROM t_msr
            JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no AND t_purchase_order.issued = 1
            JOIN t_eq_data ON t_eq_data.msr_no = t_msr.msr_no

            UNION ALL

            SELECT DISTINCT
                LEFT(t_purchase_order.po_date, 7) AS periode,
                t_msr.*,
                t_purchase_order.po_no,
                t_purchase_order.po_type,
                t_purchase_order.po_date,
                \'Agreement\' AS description,
                7 AS step,
                DATEDIFF(
                    (
                        SELECT MAX(a.issued_date) FROM t_purchase_order a
                        WHERE a.msr_no = t_msr.msr_no
                    ),
                    (
                        SELECT MAX(a.accept_award_date) FROM t_bl_detail a
                        WHERE a.msr_no = t_msr.msr_no
                    )
                ) AS days
            FROM t_msr
            JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no AND t_purchase_order.issued = 1

            UNION ALL

            SELECT DISTINCT
                LEFT(t_purchase_order.po_date, 7) AS periode,
                t_msr.*,
                t_purchase_order.po_no,
                t_purchase_order.po_type,
                t_purchase_order.po_date,
                \'Procurement Lead Time\' AS description,
                8 AS step,
                DATEDIFF(
                    (
                        SELECT MAX(a.issued_date) FROM t_purchase_order a
                        WHERE a.msr_no = t_msr.msr_no
                    ),
                    t_approval.created_at
                ) AS days
            FROM t_msr
            JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no AND t_purchase_order.issued = 1
            JOIN t_approval ON t_approval.data_id = t_msr.msr_no
            JOIN m_approval ON m_approval.id = t_approval.m_approval_id
            WHERE m_approval.module_kode = \'msr_spa\'
            AND t_approval.urutan = 1

            UNION ALL

            SELECT DISTINCT
                LEFT(t_purchase_order.po_date, 7) AS periode,
                t_msr.*,
                t_purchase_order.po_no,
                t_purchase_order.po_type,
                t_purchase_order.po_date,
                \'All Cycle\' AS description,
                9 AS step,
                DATEDIFF(
                    (
                        SELECT MAX(a.issued_date) FROM t_purchase_order a
                        WHERE a.msr_no = t_msr.msr_no
                    ),
                    t_msr.create_on
                ) AS days
            FROM t_msr
            JOIN t_purchase_order ON t_purchase_order.msr_no = t_msr.msr_no AND t_purchase_order.issued = 1
        ) msr
        JOIN m_user ON m_user.ID_USER = msr.create_by
        JOIN t_assignment ON t_assignment.msr_no = msr.msr_no
        '.$condition_query. '
        GROUP BY periode, description, step, id_pmethod
        ORDER BY step ASC';
        return $this->db->query($sql)->result();
    }
}