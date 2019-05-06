<?php
if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_procurement_value extends CI_Model {

  public function __construct() {
      parent::__construct();
      $this->db = $this->load->database('default', true);
  }

  public function m_company(){
    $qq = $this->db->query("SELECT * FROM m_company WHERE STATUS = '1'");
    return $qq;
  }

  public function show_datatable_goods($data){

    $total = $this->db->query("select 'Value > USD 5,000,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
    FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
    JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='10'
    GROUP BY m.po_no,m.po_date) a WHERE total_base > 5000000
    UNION
    SELECT 'USD 1,000,001 < Value ≤ USD 5,000,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
    FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
    JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='10'
    GROUP BY m.po_no,m.po_date) a WHERE total_base > 1000001 AND total_base <= 5000000
    UNION
    SELECT 'USD 500,001 < Value ≤ USD 1,000,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
    FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
    JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='10'
    GROUP BY m.po_no,m.po_date) a WHERE total_base > 500001 AND total_base <= 1000000
    UNION
    SELECT 'USD 100,001 < Value ≤ USD 500,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
    FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
    JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='10'
    GROUP BY m.po_no,m.po_date) a WHERE total_base > 100001 AND total_base <= 500000
    UNION
    SELECT 'USD 10,001 < Value ≤ USD 100,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
    FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
    JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='10'
    GROUP BY m.po_no,m.po_date) a WHERE total_base > 10001 AND total_base <= 100000
    UNION
    SELECT 'USD 5,001 < Value ≤ USD 10,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
    FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
    JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='10'
    GROUP BY m.po_no,m.po_date) a WHERE total_base > 5001 AND total_base <= 10000
    UNION
    SELECT 'Value ≤ USD 5,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
    FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
    JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='10'
    GROUP BY m.po_no,m.po_date) a WHERE total_base <= 500")->num_rows();
    $output = array();
    $output["draw"] = $data["draw"];
    $output["recordsTotal"] = $output["recordsFiltered"] = $total;
    $output["data"] = array();
    if($data["search"] != ""){
        $this->db->or_like("proc_value", $data["search"]);
    }

      $query = $this->db->query("select 'Value > USD 5,000,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
      FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
      JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='10'
      GROUP BY m.po_no,m.po_date) a WHERE total_base > 5000000
      UNION
      SELECT 'USD 1,000,001 < Value ≤ USD 5,000,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
      FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
      JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='10'
      GROUP BY m.po_no,m.po_date) a WHERE total_base > 1000001 AND total_base <= 5000000
      UNION
      SELECT 'USD 500,001 < Value ≤ USD 1,000,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
      FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
      JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='10'
      GROUP BY m.po_no,m.po_date) a WHERE total_base > 500001 AND total_base <= 1000000
      UNION
      SELECT 'USD 100,001 < Value ≤ USD 500,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
      FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
      JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='10'
      GROUP BY m.po_no,m.po_date) a WHERE total_base > 100001 AND total_base <= 500000
      UNION
      SELECT 'USD 10,001 < Value ≤ USD 100,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
      FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
      JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='10'
      GROUP BY m.po_no,m.po_date) a WHERE total_base > 10001 AND total_base <= 100000
      UNION
      SELECT 'USD 5,001 < Value ≤ USD 10,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
      FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
      JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='10'
      GROUP BY m.po_no,m.po_date) a WHERE total_base > 5001 AND total_base <= 10000
      UNION
      SELECT 'Value ≤ USD 5,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
      FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
      JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='10'
      GROUP BY m.po_no,m.po_date) a WHERE total_base <= 500");

      if (!empty($data['company']) AND !empty($data['start_date']) AND !empty($data['end_date'])) {
        $and_where = "AND m.po_date BETWEEN '".$data['start_date']."' AND '".$data['end_date']."' AND SUBSTR(m.po_no, -5) IN (".$data['company'].") " ;
        $query = $this->db->query("select 'Value > USD 5,000,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
        FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
        JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='10' ".$and_where."
        GROUP BY m.po_no,m.po_date) a WHERE total_base > 5000000
        UNION
        SELECT 'USD 1,000,001 < Value ≤ USD 5,000,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
        FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
        JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='10' ".$and_where."
        GROUP BY m.po_no,m.po_date) a WHERE total_base > 1000001 AND total_base <= 5000000
        UNION
        SELECT 'USD 500,001 < Value ≤ USD 1,000,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
        FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
        JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='10' ".$and_where."
        GROUP BY m.po_no,m.po_date) a WHERE total_base > 500001 AND total_base <= 1000000
        UNION
        SELECT 'USD 100,001 < Value ≤ USD 500,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
        FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
        JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='10' ".$and_where."
        GROUP BY m.po_no,m.po_date) a WHERE total_base > 100001 AND total_base <= 500000
        UNION
        SELECT 'USD 10,001 < Value ≤ USD 100,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
        FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
        JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='10' ".$and_where."
        GROUP BY m.po_no,m.po_date) a WHERE total_base > 10001 AND total_base <= 100000
        UNION
        SELECT 'USD 5,001 < Value ≤ USD 10,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
        FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
        JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='10' ".$and_where."
        GROUP BY m.po_no,m.po_date) a WHERE total_base > 5001 AND total_base <= 10000
        UNION
        SELECT 'Value ≤ USD 5,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
        FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
        JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='10' ".$and_where."
        GROUP BY m.po_no,m.po_date) a WHERE total_base <= 500");
        $output["recordsTotal"] = $output["recordsFiltered"] = $query->num_rows();
      }

    $nomor_urut = $data["start"]+1;
    $sumbase = 0;
    foreach ($query->result_array() as $val) {
      $output["data"][] = array(
        $nomor_urut,
        $val["proc_value"],
        $val["no_proc_process"],
        $val["total_base"],
        $val["total_base"],
        $nomor_urut."|".$val["total_base"],
        $sumbase += $val["total_base"],
      );
      $nomor_urut++;
    }
    $output['sum_base'] = $sumbase;
    echo json_encode($output, JSON_PRETTY_PRINT);
  }

  public function show_datatable_detail_goods($data){
    if ($data['po_value'] == 1) {
      $po_value = 'total_base > 5000000';
    } elseif ($data['po_value'] == 2) {
      $po_value = 'total_base > 1000001 AND total_base <= 5000000';
    } elseif ($data['po_value'] == 3) {
      $po_value = 'total_base > 500001 AND total_base <= 1000000';
    } elseif ($data['po_value'] == 4) {
      $po_value = 'total_base > 100001 AND total_base <= 500000';
    } elseif ($data['po_value'] == 5) {
      $po_value = 'total_base > 10001 AND total_base <= 100000';
    }elseif ($data['po_value'] == 6) {
      $po_value = 'total_base > 5001 AND total_base <= 10000';
    } elseif ($data['po_value'] == 7) {
      $po_value = 'total_base <= 500';
    } else {
      $po_value = 'total_base >= 0';
    }

    $total = $this->db->query("select po_no, total_base, msr_i.amount_base, msr.pmethod_desc, msr.rloc_desc, g.DESCRIPTION as commodity_type, SUBSTR(a.po_no, -5), e.ID_COMPANY, e.DESCRIPTION as company, d.ID, d.CURRENCY, c.ID, c.NAMA as vendor, c.PREFIX as vendor_type, c.CLASSIFICATION as vendor_qlf, a.delivery_date, a.msr_no, a.title, a.po_date, a.est_total_price, a.est_total_price_base, a.total_price_base, a.est_unitprice_base
    FROM (select m.title,m.id_currency,m.id_vendor, m.msr_no, m.delivery_date, m.id,m.po_no,m.po_date,SUM(d.total_price_base) as total_base, d.est_total_price, d.est_total_price_base, d.total_price_base, d.est_unitprice_base from t_purchase_order m
    JOIN t_purchase_order_detail d on d.po_id=m.id WHERE m.po_type=10
    GROUP BY m.po_no,m.po_date, m.id, m.delivery_date, m.msr_no, m.id_vendor,m.id_currency,m.title, d.est_total_price, d.est_total_price_base, d.total_price_base, d.est_unitprice_base) as a
        JOIN t_purchase_order_detail b ON b.po_id=a.id
        LEFT JOIN t_msr msr ON msr.msr_no=a.msr_no
        LEFT JOIN t_msr_item msr_i ON msr_i.msr_no=msr.msr_no AND msr_i.semic_no=b.semic_no
        LEFT JOIN m_vendor c ON c.ID=a.id_vendor
        LEFT JOIN m_currency d ON d.ID=a.id_currency
        LEFT JOIN m_company e ON e.ID_COMPANY LIKE SUBSTR(a.po_no, -5)
        LEFT JOIN m_material f ON f.MATERIAL=b.material_id
        LEFT JOIN m_material_group g ON g.ID=f.SEMIC_MAIN_GROUP
    WHERE ".$po_value." ")->num_rows();
    $output = array();
    $output["draw"] = $data["draw"];
    $output["recordsTotal"] = $output["recordsFiltered"] = $total;
    $output["data"] = array();
    if($data["search"] != ""){
        $this->db->or_like("po_no", $data["search"]);
    }

      $query = $this->db->query("select po_no, total_base, msr_i.amount_base, msr.pmethod_desc, msr.rloc_desc, g.DESCRIPTION as commodity_type, SUBSTR(a.po_no, -5), e.ID_COMPANY, e.DESCRIPTION as company, d.ID, d.CURRENCY, c.ID, c.NAMA as vendor, c.PREFIX as vendor_type, c.CLASSIFICATION as vendor_qlf, a.delivery_date, a.msr_no, a.title, a.po_date, a.est_total_price, a.est_total_price_base, a.total_price_base, a.est_unitprice_base
      FROM (select m.title,m.id_currency,m.id_vendor, m.msr_no, m.delivery_date, m.id,m.po_no,m.po_date,SUM(d.total_price_base) as total_base, d.est_total_price, d.est_total_price_base, d.total_price_base, d.est_unitprice_base from t_purchase_order m
      JOIN t_purchase_order_detail d on d.po_id=m.id WHERE m.po_type=10
      GROUP BY m.po_no,m.po_date, m.id, m.delivery_date, m.msr_no, m.id_vendor,m.id_currency,m.title, d.est_total_price, d.est_total_price_base, d.total_price_base, d.est_unitprice_base) as a
          JOIN t_purchase_order_detail b ON b.po_id=a.id
          LEFT JOIN t_msr msr ON msr.msr_no=a.msr_no
          LEFT JOIN t_msr_item msr_i ON msr_i.msr_no=msr.msr_no AND msr_i.semic_no=b.semic_no
          LEFT JOIN m_vendor c ON c.ID=a.id_vendor
          LEFT JOIN m_currency d ON d.ID=a.id_currency
          LEFT JOIN m_company e ON e.ID_COMPANY LIKE SUBSTR(a.po_no, -5)
          LEFT JOIN m_material f ON f.MATERIAL=b.material_id
          LEFT JOIN m_material_group g ON g.ID=f.SEMIC_MAIN_GROUP
      WHERE ".$po_value." ");

      if (!empty($data['company']) AND !empty($data['start_date']) AND !empty($data['end_date'])) {
        $and_where = "AND a.po_date BETWEEN '".$data['start_date']."' AND '".$data['end_date']."' AND SUBSTR(po_no, -5) IN (".$data['company'].") " ;
        $query = $this->db->query("select po_no, total_base, msr_i.amount_base, msr.pmethod_desc, msr.rloc_desc, g.DESCRIPTION as commodity_type, SUBSTR(a.po_no, -5), e.ID_COMPANY, e.DESCRIPTION as company, d.ID, d.CURRENCY, c.ID, c.NAMA as vendor, c.PREFIX as vendor_type, c.CLASSIFICATION as vendor_qlf, a.delivery_date, a.msr_no, a.title, a.po_date, a.est_total_price, a.est_total_price_base, a.total_price_base, a.est_unitprice_base
        FROM (select m.title,m.id_currency,m.id_vendor, m.msr_no, m.delivery_date, m.id,m.po_no,m.po_date,SUM(d.total_price_base) as total_base, d.est_total_price, d.est_total_price_base, d.total_price_base, d.est_unitprice_base from t_purchase_order m
        JOIN t_purchase_order_detail d on d.po_id=m.id WHERE m.po_type=10
        GROUP BY m.po_no,m.po_date, m.id, m.delivery_date, m.msr_no, m.id_vendor,m.id_currency,m.title, d.est_total_price, d.est_total_price_base, d.total_price_base, d.est_unitprice_base) as a
            JOIN t_purchase_order_detail b ON b.po_id=a.id
            LEFT JOIN t_msr msr ON msr.msr_no=a.msr_no
            LEFT JOIN t_msr_item msr_i ON msr_i.msr_no=msr.msr_no AND msr_i.semic_no=b.semic_no
            LEFT JOIN m_vendor c ON c.ID=a.id_vendor
            LEFT JOIN m_currency d ON d.ID=a.id_currency
            LEFT JOIN m_company e ON e.ID_COMPANY LIKE SUBSTR(a.po_no, -5)
            LEFT JOIN m_material f ON f.MATERIAL=b.material_id
            LEFT JOIN m_material_group g ON g.ID=f.SEMIC_MAIN_GROUP
        WHERE ".$po_value." ".$and_where." ");
        $output["recordsTotal"] = $output["recordsFiltered"] = $query->num_rows();
      }


    $nomor_urut = $data["start"]+1;
    foreach ($query->result_array() as $val) {
      $output["data"][] = array(
        $nomor_urut,
        $val["po_no"],
        $val["title"],
        $val["commodity_type"],
        $val["pmethod_desc"],
        $val["rloc_desc"],
        $val["vendor"],
        $val["vendor_type"],
        $val["vendor_qlf"],
        $val["po_date"],
        $val["delivery_date"],
        $val["delivery_date"],
        $val["amount_base"],
        $val["CURRENCY"],
        $val["est_total_price"],
        $val["est_total_price_base"],
        $val["total_price_base"],
        $val["est_unitprice_base"],
        $val["total_price_base"],
      );
      $nomor_urut++;
    }
    echo json_encode($output, JSON_PRETTY_PRINT);
  }


  public function show_datatable_services($data){

    $total = $this->db->query("select 'Value > USD 5,000,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
    FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
    JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='20' OR m.po_type='30'
    GROUP BY m.po_no,m.po_date) a WHERE total_base > 5000000
    UNION
    SELECT 'USD 1,000,001 < Value ≤ USD 5,000,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
    FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
    JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='20' OR m.po_type='30'
    GROUP BY m.po_no,m.po_date) a WHERE total_base > 1000001 AND total_base <= 5000000
    UNION
    SELECT 'USD 500,001 < Value ≤ USD 1,000,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
    FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
    JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='20' OR m.po_type='30'
    GROUP BY m.po_no,m.po_date) a WHERE total_base > 500001 AND total_base <= 1000000
    UNION
    SELECT 'USD 100,001 < Value ≤ USD 500,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
    FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
    JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='20' OR m.po_type='30'
    GROUP BY m.po_no,m.po_date) a WHERE total_base > 100001 AND total_base <= 500000
    UNION
    SELECT 'USD 10,001 < Value ≤ USD 100,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
    FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
    JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='20' OR m.po_type='30'
    GROUP BY m.po_no,m.po_date) a WHERE total_base > 10001 AND total_base <= 100000
    UNION
    SELECT 'USD 5,001 < Value ≤ USD 10,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
    FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
    JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='20' OR m.po_type='30'
    GROUP BY m.po_no,m.po_date) a WHERE total_base > 5001 AND total_base <= 10000
    UNION
    SELECT 'Value ≤ USD 5,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
    FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
    JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='20' OR m.po_type='30'
    GROUP BY m.po_no,m.po_date) a WHERE total_base <= 500")->num_rows();
    $output = array();
    $output["draw"] = $data["draw"];
    $output["recordsTotal"] = $output["recordsFiltered"] = $total;
    $output["data"] = array();
    if($data["search"] != ""){
        $this->db->or_like("proc_value", $data["search"]);
    }

      $query = $this->db->query("select 'Value > USD 5,000,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
      FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
      JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='20' OR m.po_type='30'
      GROUP BY m.po_no,m.po_date) a WHERE total_base > 5000000
      UNION
      SELECT 'USD 1,000,001 < Value ≤ USD 5,000,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
      FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
      JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='20' OR m.po_type='30'
      GROUP BY m.po_no,m.po_date) a WHERE total_base > 1000001 AND total_base <= 5000000
      UNION
      SELECT 'USD 500,001 < Value ≤ USD 1,000,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
      FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
      JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='20' OR m.po_type='30'
      GROUP BY m.po_no,m.po_date) a WHERE total_base > 500001 AND total_base <= 1000000
      UNION
      SELECT 'USD 100,001 < Value ≤ USD 500,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
      FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
      JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='20' OR m.po_type='30'
      GROUP BY m.po_no,m.po_date) a WHERE total_base > 100001 AND total_base <= 500000
      UNION
      SELECT 'USD 10,001 < Value ≤ USD 100,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
      FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
      JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='20' OR m.po_type='30'
      GROUP BY m.po_no,m.po_date) a WHERE total_base > 10001 AND total_base <= 100000
      UNION
      SELECT 'USD 5,001 < Value ≤ USD 10,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
      FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
      JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='20' OR m.po_type='30'
      GROUP BY m.po_no,m.po_date) a WHERE total_base > 5001 AND total_base <= 10000
      UNION
      SELECT 'Value ≤ USD 5,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
      FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
      JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='20' OR m.po_type='30'
      GROUP BY m.po_no,m.po_date) a WHERE total_base <= 500");

      if (!empty($data['company']) AND !empty($data['start_date']) AND !empty($data['end_date'])) {
        $and_where = "AND m.po_date BETWEEN '".$data['start_date']."' AND '".$data['end_date']."' AND SUBSTR(m.po_no, -5) IN (".$data['company'].") " ;
        $query = $this->db->query("select 'Value > USD 5,000,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
        FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
        JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='20' OR m.po_type='30' ".$and_where."
        GROUP BY m.po_no,m.po_date) a WHERE total_base > 5000000
        UNION
        SELECT 'USD 1,000,001 < Value ≤ USD 5,000,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
        FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
        JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='20' OR m.po_type='30' ".$and_where."
        GROUP BY m.po_no,m.po_date) a WHERE total_base > 1000001 AND total_base <= 5000000
        UNION
        SELECT 'USD 500,001 < Value ≤ USD 1,000,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
        FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
        JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='20' OR m.po_type='30' ".$and_where."
        GROUP BY m.po_no,m.po_date) a WHERE total_base > 500001 AND total_base <= 1000000
        UNION
        SELECT 'USD 100,001 < Value ≤ USD 500,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
        FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
        JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='20' OR m.po_type='30' ".$and_where."
        GROUP BY m.po_no,m.po_date) a WHERE total_base > 100001 AND total_base <= 500000
        UNION
        SELECT 'USD 10,001 < Value ≤ USD 100,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
        FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
        JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='20' OR m.po_type='30' ".$and_where."
        GROUP BY m.po_no,m.po_date) a WHERE total_base > 10001 AND total_base <= 100000
        UNION
        SELECT 'USD 5,001 < Value ≤ USD 10,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
        FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
        JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='20' OR m.po_type='30' ".$and_where."
        GROUP BY m.po_no,m.po_date) a WHERE total_base > 5001 AND total_base <= 10000
        UNION
        SELECT 'Value ≤ USD 5,000' as proc_value, count(po_no) as no_proc_process, COALESCE(sum(COALESCE(total_base,0)),0) as total_base
        FROM (select m.po_no,m.po_date,SUM(d.total_price_base) as total_base FROM t_purchase_order m
        JOIN t_purchase_order_detail d ON d.po_id=m.id WHERE m.po_type='20' OR m.po_type='30' ".$and_where."
        GROUP BY m.po_no,m.po_date) a WHERE total_base <= 500");
        $output["recordsTotal"] = $output["recordsFiltered"] = $query->num_rows();
      }

    $nomor_urut = $data["start"]+1;
    $sumbase = 0;
    foreach ($query->result_array() as $val) {
      $output["data"][] = array(
        $nomor_urut,
        $val["proc_value"],
        $val["no_proc_process"],
        $val["total_base"],
        $val["total_base"],
        $nomor_urut."|".$val["total_base"],
        $sumbase += $val["total_base"],
      );
      $nomor_urut++;
    }
    $output['sum_base'] = $sumbase;
    echo json_encode($output, JSON_PRETTY_PRINT);
  }

  public function show_datatable_detail_services($data){
    if ($data['po_value'] == 1) {
      $po_value = 'total_base > 5000000';
    } elseif ($data['po_value'] == 2) {
      $po_value = 'total_base > 1000001 AND total_base <= 5000000';
    } elseif ($data['po_value'] == 3) {
      $po_value = 'total_base > 500001 AND total_base <= 1000000';
    } elseif ($data['po_value'] == 4) {
      $po_value = 'total_base > 100001 AND total_base <= 500000';
    } elseif ($data['po_value'] == 5) {
      $po_value = 'total_base > 10001 AND total_base <= 100000';
    }elseif ($data['po_value'] == 6) {
      $po_value = 'total_base > 5001 AND total_base <= 10000';
    } elseif ($data['po_value'] == 7) {
      $po_value = 'total_base <= 500';
    } else {
      $po_value = 'total_base >= 0';
    }

    $total = $this->db->query("select po_no, total_base, msr_i.amount_base, msr.pmethod_desc, msr.rloc_desc, g.DESCRIPTION as commodity_type, SUBSTR(a.po_no, -5), e.ID_COMPANY, e.DESCRIPTION as company, d.ID, d.CURRENCY, c.ID, c.NAMA as vendor, c.PREFIX as vendor_type, c.CLASSIFICATION as vendor_qlf, a.delivery_date, a.msr_no, a.title, a.po_date, a.est_total_price, a.est_total_price_base, a.total_price_base, a.est_unitprice_base
    FROM (select m.title,m.id_currency,m.id_vendor, m.msr_no, m.delivery_date, m.id,m.po_no,m.po_date,SUM(d.total_price_base) as total_base, d.est_total_price, d.est_total_price_base, d.total_price_base, d.est_unitprice_base from t_purchase_order m
    JOIN t_purchase_order_detail d on d.po_id=m.id WHERE m.po_type='20' OR m.po_type='30'
    GROUP BY m.po_no,m.po_date, m.id, m.delivery_date, m.msr_no, m.id_vendor,m.id_currency,m.title, d.est_total_price, d.est_total_price_base, d.total_price_base, d.est_unitprice_base) as a
        JOIN t_purchase_order_detail b ON b.po_id=a.id
        LEFT JOIN t_msr msr ON msr.msr_no=a.msr_no
        LEFT JOIN t_msr_item msr_i ON msr_i.msr_no=msr.msr_no AND msr_i.semic_no=b.semic_no
        LEFT JOIN m_vendor c ON c.ID=a.id_vendor
        LEFT JOIN m_currency d ON d.ID=a.id_currency
        LEFT JOIN m_company e ON e.ID_COMPANY LIKE SUBSTR(a.po_no, -5)
        LEFT JOIN m_material f ON f.MATERIAL=b.material_id
        LEFT JOIN m_material_group g ON g.ID=f.SEMIC_MAIN_GROUP
    WHERE ".$po_value." ")->num_rows();
    $output = array();
    $output["draw"] = $data["draw"];
    $output["recordsTotal"] = $output["recordsFiltered"] = $total;
    $output["data"] = array();
    if($data["search"] != ""){
        $this->db->or_like("po_no", $data["search"]);
    }

      $query = $this->db->query("select po_no, total_base, msr_i.amount_base, msr.pmethod_desc, msr.rloc_desc, g.DESCRIPTION as commodity_type, SUBSTR(a.po_no, -5), e.ID_COMPANY, e.DESCRIPTION as company, d.ID, d.CURRENCY, c.ID, c.NAMA as vendor, c.PREFIX as vendor_type, c.CLASSIFICATION as vendor_qlf, a.delivery_date, a.msr_no, a.title, a.po_date, a.est_total_price, a.est_total_price_base, a.total_price_base, a.est_unitprice_base
      FROM (select m.title,m.id_currency,m.id_vendor, m.msr_no, m.delivery_date, m.id,m.po_no,m.po_date,SUM(d.total_price_base) as total_base, d.est_total_price, d.est_total_price_base, d.total_price_base, d.est_unitprice_base from t_purchase_order m
      JOIN t_purchase_order_detail d on d.po_id=m.id WHERE m.po_type='20' OR m.po_type='30'
      GROUP BY m.po_no,m.po_date, m.id, m.delivery_date, m.msr_no, m.id_vendor,m.id_currency,m.title, d.est_total_price, d.est_total_price_base, d.total_price_base, d.est_unitprice_base) as a
          JOIN t_purchase_order_detail b ON b.po_id=a.id
          LEFT JOIN t_msr msr ON msr.msr_no=a.msr_no
          LEFT JOIN t_msr_item msr_i ON msr_i.msr_no=msr.msr_no AND msr_i.semic_no=b.semic_no
          LEFT JOIN m_vendor c ON c.ID=a.id_vendor
          LEFT JOIN m_currency d ON d.ID=a.id_currency
          LEFT JOIN m_company e ON e.ID_COMPANY LIKE SUBSTR(a.po_no, -5)
          LEFT JOIN m_material f ON f.MATERIAL=b.material_id
          LEFT JOIN m_material_group g ON g.ID=f.SEMIC_MAIN_GROUP
      WHERE ".$po_value." ");

      if (!empty($data['company']) AND !empty($data['start_date']) AND !empty($data['end_date'])) {
        $and_where = "AND a.po_date BETWEEN '".$data['start_date']."' AND '".$data['end_date']."' AND SUBSTR(po_no, -5) IN (".$data['company'].") " ;
        $query = $this->db->query("select po_no, total_base, msr_i.amount_base, msr.pmethod_desc, msr.rloc_desc, g.DESCRIPTION as commodity_type, SUBSTR(a.po_no, -5), e.ID_COMPANY, e.DESCRIPTION as company, d.ID, d.CURRENCY, c.ID, c.NAMA as vendor, c.PREFIX as vendor_type, c.CLASSIFICATION as vendor_qlf, a.delivery_date, a.msr_no, a.title, a.po_date, a.est_total_price, a.est_total_price_base, a.total_price_base, a.est_unitprice_base
        FROM (select m.title,m.id_currency,m.id_vendor, m.msr_no, m.delivery_date, m.id,m.po_no,m.po_date,SUM(d.total_price_base) as total_base, d.est_total_price, d.est_total_price_base, d.total_price_base, d.est_unitprice_base from t_purchase_order m
        JOIN t_purchase_order_detail d on d.po_id=m.id WHERE m.po_type='20' OR m.po_type='30'
        GROUP BY m.po_no,m.po_date, m.id, m.delivery_date, m.msr_no, m.id_vendor,m.id_currency,m.title, d.est_total_price, d.est_total_price_base, d.total_price_base, d.est_unitprice_base) as a
            JOIN t_purchase_order_detail b ON b.po_id=a.id
            LEFT JOIN t_msr msr ON msr.msr_no=a.msr_no
            LEFT JOIN t_msr_item msr_i ON msr_i.msr_no=msr.msr_no AND msr_i.semic_no=b.semic_no
            LEFT JOIN m_vendor c ON c.ID=a.id_vendor
            LEFT JOIN m_currency d ON d.ID=a.id_currency
            LEFT JOIN m_company e ON e.ID_COMPANY LIKE SUBSTR(a.po_no, -5)
            LEFT JOIN m_material f ON f.MATERIAL=b.material_id
            LEFT JOIN m_material_group g ON g.ID=f.SEMIC_MAIN_GROUP
        WHERE ".$po_value." ".$and_where." ");
        $output["recordsTotal"] = $output["recordsFiltered"] = $query->num_rows();
      }


    $nomor_urut = $data["start"]+1;
    foreach ($query->result_array() as $val) {
      $output["data"][] = array(
        $nomor_urut,
        $val["po_no"],
        $val["title"],
        $val["commodity_type"],
        $val["pmethod_desc"],
        $val["rloc_desc"],
        $val["vendor"],
        $val["vendor_type"],
        $val["vendor_qlf"],
        $val["po_date"],
        $val["delivery_date"],
        $val["delivery_date"],
        $val["amount_base"],
        $val["CURRENCY"],
        $val["est_total_price"],
        $val["est_total_price_base"],
        $val["total_price_base"],
        $val["est_unitprice_base"],
        $val["total_price_base"],
      );
      $nomor_urut++;
    }
    echo json_encode($output, JSON_PRETTY_PRINT);
  }

}
