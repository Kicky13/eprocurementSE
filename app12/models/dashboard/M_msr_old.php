<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_msr_old extends CI_MODEL
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

    public function get_status($m,$m2,$y,$y2)
    {
        $res=$this->db->query(
            "SELECT DISTINCT SUM(prep) as preparation,SUM(sel) as selection,SUM(comp) as completed,SUM(sign) as signed,SUM(cancel) as canceled,CONCAT(MONTH(m.create_on)) as period,SUM(t_p) as t_p,SUM(t_s) as t_s,SUM(t_c) as t_c,SUM(t_sg) as t_sg,SUM(t_cl) as t_cl,m.create_on
            FROM (
                SELECT DISTINCT msr_no as msr, SUM(total) as prep,0 as sel,0 as comp,0 as sign,0 as cancel,SUM(value) as t_p,0 as t_s,0 as t_c,0 as t_sg,0 as t_cl
                FROM (
                    SELECT DISTINCT m.msr_no,1 as total, SUM(t.priceunit*t.qty) as value
                    FROM t_msr m
                    JOIN t_approval a ON a.data_id=m.msr_no AND a.data_id NOT IN (select data_id FROM t_approval WHERE m_approval_id IN (SELECT id FROM m_approval WHERE module_kode='msr_spa'))
                    JOIN m_approval d ON d.id=a.m_approval_id AND d.module_kode='msr'
                    JOIN t_msr_item t ON t.msr_no = a.data_id
                    WHERE MONTH(m.create_on) BETWEEN '".$m."' AND '".$m2."' AND YEAR(m.create_on) BETWEEN '".$y."' AND '".$y2."'
                    AND m.msr_no NOT IN (SELECT data_id FROM  t_approval WHERE status=2)
                    GROUP BY m.msr_no,total
                ) a
                GROUP by msr,sel,comp,sign,cancel,t_s,t_c,t_sg,t_cl
                UNION
                SELECT DISTINCT msr,0 as prep,SUM(total) as sel,0 as comp,0 as sign,0 as cancel,0 as t_p,SUM(value) as t_s,0 as t_c,0 as t_sg,0 as t_cl
                FROM (
                    SELECT DISTINCT m.msr_no as msr,1 as total, SUM(t.priceunit*t.qty) as value
                    FROM t_msr m
                    JOIN t_approval a ON a.data_id=m.msr_no AND a.urutan=1
                    JOIN m_approval d ON d.id=a.m_approval_id AND d.module_kode='msr_spa' AND a.m_approval_id NOT IN (SELECT id FROM m_approval WHERE module_kode='loi' or module_kode='po')
                    JOIN t_msr_item t ON t.msr_no = a.data_id
                    WHERE MONTH(m.create_on) BETWEEN '".$m."' AND '".$m2."' AND YEAR(m.create_on) BETWEEN '".$y."' AND '".$y2."'
                    AND m.msr_no NOT IN (SELECT data_id FROM  t_approval WHERE status=2)
                    GROUP BY m.msr_no,total
                )b
                GROUP by msr,prep,comp,sign,cancel,t_p,t_c,t_sg,t_cl
                UNION
                SELECT DISTINCT msr,0 as prep,0 as sel,comp,0 as sign,0 as cancel,0 as t_p,0 as t_s,SUM(value) as t_c,0 as t_sg,0 as t_cl
                FROM (
                    SELECT DISTINCT m.msr_no as msr,1 as comp, (t.priceunit*t.qty) as value
                    FROM t_msr m
                    JOIN t_approval a ON a.data_id=m.msr_no
                    JOIN m_approval d ON d.id=a.m_approval_id AND (d.module_kode='loi' OR d.module_kode='po')
                    JOIN t_msr_item t ON t.msr_no = a.data_id
                    WHERE MONTH(m.create_on) BETWEEN '".$m."' AND '".$m2."' AND YEAR(m.create_on) BETWEEN '".$y."' AND '".$y2."'
                    AND m.msr_no NOT IN (SELECT data_id FROM  t_approval WHERE status=2)
                )c
                GROUP by msr,prep,sel,comp,sign,cancel,t_p,t_s,t_sg,t_cl
                UNION
                SELECT DISTINCT msr,0 as prep,0 as sel,0 as comp,0 as sign,cancel,0 as t_p,0 as t_s,0 as t_c,0 as t_sg,sum(value) as t_cl
                FROM (
                    SELECT DISTINCT m.msr_no as msr,1 as cancel, (t.priceunit*t.qty) as value
                    FROM t_msr m
                    JOIN t_approval a ON a.data_id=m.msr_no AND a.status=2
                    JOIN t_msr_item t ON t.msr_no = a.data_id
                    WHERE MONTH(m.create_on) BETWEEN '".$m."' AND '".$m2."' AND YEAR(m.create_on) BETWEEN '".$y."' AND '".$y2."'
                )d
                GROUP by msr,prep,sel,comp,sign,cancel,t_p,t_s,t_c,t_sg
            ) als
            JOIN t_msr m ON m.msr_no=als.msr
            GROUP BY period
        ");
        return $res->result_array();
    }

    public function get_type($m,$m2,$y,$y2,$dt)
    {
        $res=$this->db->query(
            "SELECT SUM(goods) as goods,SUM(service) as services,SUM(blanket) as blanket,SUM(t_g) as t_g,SUM(t_s) as t_s,SUM(t_b) as t_b,period
            FROM (
                SELECT DISTINCT goods,service,blanket,t_g,t_s,t_b,period
                FROM (
                 SELECT DISTINCT msr_no,total as goods,0 as service,0 as blanket,SUM(value) as t_g,0 as t_s,0 as t_b,period
                  FROM (
                      SELECT DISTINCT m.msr_no,1 as total, (t.priceunit*t.qty) as value,CONCAT(MONTH(m.create_on)) as period
                      FROM t_msr m
                      JOIN t_msr_item t ON t.msr_no = m.msr_no AND t.id_itemtype = 'GOODS'
                      JOIN m_user u ON u.ID_USER = m.create_by AND u.ID_DEPARTMENT LIKE '%".$dt['department']."%'
                      WHERE MONTH(m.create_on) BETWEEN '".$m."' AND '".$m2."' AND YEAR(m.create_on) BETWEEN '".$y."' AND '".$y2."'
                      AND m.id_company LIKE '%".$dt['company']."%'
                      AND m.id_pmethod LIKE'%".$dt['method']."%'
                  ) a
                  GROUP by msr_no,goods,service,blanket,t_s,t_b,period
                  UNION
                  SELECT DISTINCT b.msr_no,0 as goods,total as service,0 as blanket,0 as t_g,SUM(value) as t_s,0 as t_b,period
                  FROM (
                      SELECT DISTINCT m.msr_no,1 as total, (t.priceunit*t.qty) as value,CONCAT(MONTH(m.create_on)) as period
                      FROM t_msr m
                      JOIN t_msr_item t ON t.msr_no = m.msr_no AND t.id_itemtype = 'SERVICE'
                      JOIN m_user u ON u.ID_USER = m.create_by AND u.ID_DEPARTMENT LIKE '%".$dt['department']."%'
                      WHERE MONTH(m.create_on) BETWEEN '".$m."' AND '".$m2."' AND YEAR(m.create_on) BETWEEN '".$y."' AND '".$y2."'
                      AND m.id_company LIKE '%".$dt['company']."%'
                      AND m.id_pmethod LIKE'%".$dt['method']."%'
                  )b
                  GROUP by b.msr_no,goods,service,blanket,t_g,t_b,period
                  UNION
                  SELECT DISTINCT msr_no,0 as goods,0 as service,blanket,SUM(value) as t_b,0 as t_s,0 as t_g,period
                  FROM (
                      SELECT DISTINCT m.msr_no,1 as blanket, (t.priceunit*t.qty) as value,CONCAT(MONTH(m.create_on)) as period
                      FROM t_msr m
                      JOIN t_msr_item t ON t.msr_no = m.msr_no AND t.id_itemtype='BLANKET'
                      JOIN m_user u ON u.ID_USER = m.create_by AND u.ID_DEPARTMENT LIKE '%".$dt['department']."%'
                      WHERE MONTH(m.create_on) BETWEEN '".$m."' AND '".$m2."' AND YEAR(m.create_on) BETWEEN '".$y."' AND '".$y2."'
                      AND m.id_company LIKE '%".$dt['company']."%'
                      AND m.id_pmethod LIKE'%".$dt['method']."%'
                  )c
                  GROUP by c.msr_no,goods,service,blanket,t_s,t_g,period
              ) als
              ORDER BY period ASC
          )a
          GROUP BY period
            "
        );
        return $res->result_array();
    }

    public function get_method($m,$m2,$y,$y2,$dt)
    {
        $res=$this->db->query(
            "SELECT SUM(DA) as DA,SUM(DS) as DS,SUM(TN) as TN,SUM(t_a) as t_a,SUM(t_s) as t_s,SUM(t_n) as t_n,period
            FROM (
                SELECT DISTINCT DA,DS,TN,t_a,t_s,t_n,period
                FROM (
                 SELECT DISTINCT msr_no,total as DA,0 as DS,0 as TN,SUM(value) as t_a,0 as t_s,0 as t_n,period
                  FROM (
                      SELECT DISTINCT m.msr_no,1 as total, (t.priceunit*t.qty) as value,CONCAT(MONTH(m.create_on)) as period
                      FROM t_msr m
                      JOIN t_msr_item t ON t.msr_no = m.msr_no
                      AND t.id_itemtype LIKE '%".$dt['type']."%'
                      JOIN m_user u ON u.ID_USER = m.create_by AND u.ID_DEPARTMENT LIKE '%".$dt['department']."%'
                      WHERE MONTH(m.create_on) BETWEEN '".$m."' AND '".$m2."' AND YEAR(m.create_on) BETWEEN '".$y."' AND '".$y2."' AND m.id_pmethod='DA'
                      AND m.id_company LIKE '%".$dt['company']."%'
                  ) a
                  GROUP by msr_no,DA,DS,TN,t_s,t_n,period
                  UNION
                  SELECT DISTINCT b.msr_no,0 as DA,total as DS,0 as TN,0 as t_a,SUM(value) as t_s,0 as t_n,period
                  FROM (
                      SELECT DISTINCT m.msr_no,1 as total, (t.priceunit*t.qty) as value,CONCAT(MONTH(m.create_on)) as period
                      FROM t_msr m
                      JOIN t_msr_item t ON t.msr_no = m.msr_no
                      AND t.id_itemtype LIKE '%".$dt['type']."%'
                      JOIN m_user u ON u.ID_USER = m.create_by AND u.ID_DEPARTMENT LIKE '%".$dt['department']."%'
                      WHERE MONTH(m.create_on) BETWEEN '".$m."' AND '".$m2."' AND YEAR(m.create_on) BETWEEN '".$y."' AND '".$y2."' AND m.id_pmethod = 'DS'
                      AND m.id_company LIKE '%".$dt['company']."%'
                  )b
                  GROUP by b.msr_no,DA,DS,TN,t_a,t_n,period
                  UNION
                  SELECT DISTINCT msr_no,0 as DA,0 as DS,TN,SUM(value) as t_n,0 as t_s,0 as t_a,period
                  FROM (
                      SELECT DISTINCT m.msr_no,1 as TN, (t.priceunit*t.qty) as value,CONCAT(MONTH(m.create_on)) as period
                      FROM t_msr m
                      JOIN t_msr_item t ON t.msr_no = m.msr_no
                      AND t.id_itemtype LIKE '%".$dt['type']."%'
                      JOIN m_user u ON u.ID_USER = m.create_by AND u.ID_DEPARTMENT LIKE '%".$dt['department']."%'
                      WHERE MONTH(m.create_on) BETWEEN '".$m."' AND '".$m2."' AND YEAR(m.create_on) BETWEEN '".$y."' AND '".$y2."' AND m.id_pmethod='TN'
                      AND m.id_company LIKE '%".$dt['company']."%'
                  )c
                  GROUP by c.msr_no,DA,DS,TN,t_s,t_a,period
              ) als
              ORDER BY period ASC
          )a
          GROUP BY period
            "
        );
        return $res->result_array();
    }

    public function get_data($sel,$db,$cond,$ct)
    {
        $this->db->select($sel)
                    ->from($db)
                    ->where($cond);
        if($ct!=0)
            $this->db->like('ROLES','8');
        $res=$this->db->get();

        if($res->num_rows()!=null)
            return $res->result();
        else
            return false;
    }

    public function get_all($m,$m2,$y,$y2,$dt)
    {
        $res=$this->db->query(
            "SELECT SUM(prep) as preparation,SUM(sel) as selection,SUM(comp) as completed,SUM(sign) as signed,SUM(cancel) as canceled,period,SUM(t_p) as t_p,SUM(t_s) as t_s,SUM(t_c) as t_c,SUM(t_sg) as t_sg,SUM(t_cl) as t_cl
            FROM (
              SELECT DISTINCT msr,prep,sel,comp,sign,cancel,CONCAT(MONTH(m.create_on)) as period,SUM(t_p) as t_p,SUM(t_s) as t_s,SUM(t_c) as t_c,SUM(t_sg) as t_sg,SUM(t_cl) as t_cl
                  FROM (
                      SELECT DISTINCT msr_no as msr, SUM(total) as prep,0 as sel,0 as comp,0 as sign,0 as cancel,(value) as t_p,0 as t_s,0 as t_c,0 as t_sg,0 as t_cl
                      FROM (
                          SELECT DISTINCT m.msr_no,1 as total, SUM(t.priceunit*t.qty) as value
                          FROM t_msr m
                          JOIN t_approval a ON a.data_id=m.msr_no AND a.data_id NOT IN (select data_id FROM t_approval WHERE m_approval_id IN (SELECT id FROM m_approval WHERE module_kode='msr_spa'))
                          JOIN m_approval d ON d.id=a.m_approval_id AND d.module_kode='msr'
                          JOIN t_msr_item t ON t.msr_no = a.data_id
                          AND t.id_itemtype LIKE '%".$dt['type']."%'
                          JOIN m_user u ON u.ID_USER = m.create_by AND u.ID_DEPARTMENT LIKE '%".$dt['department']."%'
                          WHERE MONTH(m.create_on) BETWEEN '".$m."' AND '".$m2."' AND YEAR(m.create_on) BETWEEN '".$y."' AND '".$y2."'
                          AND m.msr_no NOT IN (SELECT data_id FROM  t_approval WHERE status=2)
                          AND m.id_company LIKE '%".$dt['company']."%'
                          AND m.id_pmethod LIKE'%".$dt['method']."%'
                          GROUP BY m.msr_no,total
                      ) a
                      GROUP by msr,sel,comp,sign,cancel,t_p,t_s,t_c,t_sg,t_cl
                      UNION
                      SELECT DISTINCT msr,0 as prep,SUM(total) as sel,0 as comp,0 as sign,0 as cancel,0 as t_p,(value) as t_s,0 as t_c,0 as t_sg,0 as t_cl
                      FROM (
                          SELECT DISTINCT m.msr_no as msr,1 as total, SUM(t.priceunit*t.qty) as value
                          FROM t_msr m
                          JOIN t_approval a ON a.data_id=m.msr_no AND a.urutan=1
                          JOIN m_approval d ON d.id=a.m_approval_id AND d.module_kode='msr_spa' AND a.m_approval_id NOT IN (SELECT id FROM m_approval WHERE module_kode='loi' or module_kode='po')
                          JOIN t_msr_item t ON t.msr_no = a.data_id
                        AND t.id_itemtype LIKE '%".$dt['type']."%'
                        JOIN m_user u ON u.ID_USER = m.create_by AND u.ID_DEPARTMENT LIKE '%".$dt['department']."%'
                          WHERE MONTH(m.create_on) BETWEEN '".$m."' AND '".$m2."' AND YEAR(m.create_on) BETWEEN '".$y."' AND '".$y2."'
                          AND m.msr_no NOT IN (SELECT data_id FROM  t_approval WHERE status=2)
                          AND m.id_company LIKE '%".$dt['company']."%'
                          AND m.id_pmethod LIKE'%".$dt['method']."%'
                          GROUP BY m.msr_no,total
                      )b
                      GROUP by msr,prep,comp,sign,cancel,t_p,t_s,t_c,t_sg,t_cl
                      UNION
                      SELECT DISTINCT msr,0 as prep,0 as sel,comp,0 as sign,0 as cancel,0 as t_p,0 as t_s,SUM(value) as t_c,0 as t_sg,0 as t_cl
                      FROM (
                          SELECT DISTINCT m.msr_no as msr,1 as comp, (t.priceunit*t.qty) as value
                          FROM t_msr m
                          JOIN t_approval a ON a.data_id=m.msr_no
                          JOIN m_approval d ON d.id=a.m_approval_id AND (d.module_kode='loi' OR d.module_kode='po')
                          JOIN t_msr_item t ON t.msr_no = a.data_id
                        AND t.id_itemtype LIKE '%".$dt['type']."%'
                        JOIN m_user u ON u.ID_USER = m.create_by AND u.ID_DEPARTMENT LIKE '%".$dt['department']."%'
                          WHERE MONTH(m.create_on) BETWEEN '".$m."' AND '".$m2."' AND YEAR(m.create_on) BETWEEN '".$y."' AND '".$y2."'
                          AND m.msr_no NOT IN (SELECT data_id FROM  t_approval WHERE status=2)
                          AND m.id_company LIKE '%".$dt['company']."%'
                          AND m.id_pmethod LIKE'%".$dt['method']."%'
                      )c
                      GROUP by msr,prep,sel,comp,sign,cancel,t_p,t_s,t_sg,t_cl
                      UNION
                      SELECT DISTINCT msr,0 as prep,0 as sel,0 as comp,0 as sign,cancel,0 as t_p,0 as t_s,0 as t_c,0 as t_sg,sum(value) as t_cl
                      FROM (
                          SELECT DISTINCT m.msr_no as msr,1 as cancel, (t.priceunit*t.qty) as value
                          FROM t_msr m
                          JOIN t_approval a ON a.data_id=m.msr_no AND a.status=2
                          JOIN t_msr_item t ON t.msr_no = a.data_id
                        AND t.id_itemtype LIKE '%".$dt['type']."%'
                        JOIN m_user u ON u.ID_USER = m.create_by AND u.ID_DEPARTMENT LIKE '%".$dt['department']."%'
                        WHERE MONTH(m.create_on) BETWEEN '".$m."' AND '".$m2."' AND YEAR(m.create_on) BETWEEN '".$y."' AND '".$y2."'
                        AND m.id_company LIKE '%".$dt['company']."%'
                        AND m.id_pmethod LIKE'%".$dt['method']."%'
                      )d
                      GROUP by msr,prep,sel,comp,sign,cancel,t_p,t_s,t_c,t_sg
                  ) als
                  JOIN t_msr m ON m.msr_no=als.msr
                    GROUP BY msr,prep,sel,comp,sign,cancel,period
                  ORDER BY m.create_on ASC
              )a
              GROUP BY period
              ORDER BY period ASC
            ");
            return $res->result_array();
    }
    public function get_specialist($m,$m2,$y,$y2,$dt)
    {
        $res=$this->db->query(
            "SELECT COUNT(name) as total,NAME,SUM(value) as value,period
            FROM(
                SELECT DISTINCT m.msr_no as msr,u.NAME,(t.priceunit*t.qty) as value,CONCAT(MONTH(m.create_on)) as period
                FROM t_msr m
                JOIN t_msr_item t ON t.msr_no = m.msr_no
                AND t.id_itemtype LIKE '%".$dt['type']."%'
                JOIN m_user u ON u.ROLES LIKE '%8%' AND u.ID_DEPARTMENT LIKE '%".$dt['department']."%'
                WHERE MONTH(m.create_on) BETWEEN '".$m."' AND '".$m2."' AND YEAR(m.create_on) BETWEEN '".$y."' AND '".$y2."'
                AND m.id_company LIKE '%".$dt['company']."%'
                AND m.id_pmethod LIKE'%".$dt['method']."%'
            )a
            GROUP BY NAME,period
            ORDER BY NAME ASC"
        );
        return $res->result();
    }

    public function get_details($m,$m2,$y,$y2,$dt)
    {
        $res=$this->db->query(
            "SELECT m.msr_no,t.id_itemtype as item,t.description as units,t.priceunit,(t.qty*t.priceunit) as total,t.groupcat_desc as groups,t.sub_groupcat_desc as sgroup,t.qty as qty,t.uom,t.importation_desc as import,t.costcenter_desc as costcenter,
                m.msr_type_desc as types,m.title,m.req_date,c.description as currency,m.pmethod_desc as method,m.rloc_desc as locations,m.dpoint_desc,m.requestfor_desc,
                m.deliveryterm_desc,m.freight_desc,m.create_on,accsub_desc,inspection_desc
            FROM t_msr m
            JOIN t_msr_item t ON t.msr_no = m.msr_no
            AND t.id_itemtype LIKE '%".$dt['type']."%'
            JOIN m_currency c ON c.id=m.id_currency
            JOIN m_user u ON u.ID_USER = m.create_by AND u.ID_DEPARTMENT LIKE '%".$dt['department']."%'
            WHERE MONTH(m.create_on) BETWEEN '".$m."' AND '".$m2."' AND YEAR(m.create_on) BETWEEN '".$y."' AND '".$y2."'
            AND m.id_company LIKE '%".$dt['company']."%'
            AND m.id_pmethod LIKE'%".$dt['method']."%'
            ORDER BY m.create_on ASC
        ");
        return $res->result_array();
    }
}
?>