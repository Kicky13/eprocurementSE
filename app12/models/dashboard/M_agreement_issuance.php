<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_agreement_issuance extends CI_MODEL
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
    public function get_total_po_type($condition = '1=1') {
        return $this->db->query("select coalesce(r.amount_from,0) amount_from,'Purchase Order' as po,count(m.po_no) countpo,COALESCE(SUM(CASE WHEN m.id_currency=1 THEN 1 ELSE 0 END),0) as countidr,COALESCE(SUM(CASE WHEN m.id_currency =3 THEN 1 ELSE 0 END),0) as countusd,
            COALESCE(SUM(CASE WHEN m.id_currency=1 THEN m.total_amount ELSE 0 END),0) as total,SUM(CASE WHEN m.id_currency=3 THEN m.total_amount_base ELSE 0 END) as total_base 
            from t_purchase_order m 
            join t_msr x on x.msr_no=m.msr_no
            join t_assignment n on n.msr_no=m.msr_no
            join m_currency c on c.id=m.id_currency 
            join (select max(id) as id,1 as a from m_exchange_rate where currency_from=1 and currency_to=3 ) a on a=1 
            left join m_exchange_rate r on r.id=a.id
            where  po_type='10' and m.blanket=0 and ".$condition." group by r.amount_from
            union 
            select coalesce(r.amount_from,0) amount_from,'Service Order' as po,count(m.po_no) countpo,COALESCE(SUM(CASE WHEN m.id_currency=1 THEN 1 ELSE 0 END),0) as countidr,COALESCE(SUM(CASE WHEN m.id_currency =3 THEN 1 ELSE 0 END),0) as countusd,
            COALESCE(SUM(CASE WHEN m.id_currency=1 THEN m.total_amount ELSE 0 END),0) as total,SUM(CASE WHEN m.id_currency=3 THEN m.total_amount_base ELSE 0 END) as total_base 
            from t_purchase_order m 
            join t_msr x on x.msr_no=m.msr_no
            join t_assignment n on n.msr_no=m.msr_no
            join m_currency c on c.id=m.id_currency 
            join (select max(id) as id,1 as a from m_exchange_rate where currency_from=1 and currency_to=3 ) a on a=1 
            left join m_exchange_rate r on r.id=a.id
            where   po_type='20' and ".$condition."  group by r.amount_from
            union
            select coalesce(r.amount_from,0) amount_from,'Blanket Order' as po,count(m.po_no) countpo,COALESCE(SUM(CASE WHEN m.id_currency=1 THEN 1 ELSE 0 END),0) as countidr,COALESCE(SUM(CASE WHEN m.id_currency =3 THEN 1 ELSE 0 END),0) as countusd,
            COALESCE(SUM(CASE WHEN m.id_currency=1 THEN m.total_amount ELSE 0 END),0) as total,SUM(CASE WHEN m.id_currency=3 THEN m.total_amount_base ELSE 0 END) as total_base 
            from t_purchase_order m 
            join t_msr x on x.msr_no=m.msr_no
            join t_assignment n on n.msr_no=m.msr_no
            join m_currency c on c.id=m.id_currency 
            join (select max(id) as id,1 as a from m_exchange_rate where currency_from=1 and currency_to=3 ) a on a=1 
            left join m_exchange_rate r on r.id=a.id
            where   po_type='10' and m.blanket=1 and ".$condition."  group by r.amount_from")->result();
        
    }

    public function issuance_agreement_type($condition = '1=1') {
        return $this->db->query("select count(m.po_no) value,'PO' as name
            from t_purchase_order m 
            join t_msr x on x.msr_no=m.msr_no
            join t_assignment n on n.msr_no=m.msr_no
            join m_currency c on c.id=m.id_currency 
            join (select max(id) as id,1 as a from m_exchange_rate where currency_from=1 and currency_to=3 ) a on a=1 
            join m_exchange_rate r on r.id=a.id
            where  po_type='10' and m.blanket=0 and ".$condition."
            union 
            select COALESCE(count(m.po_no),0) value,'SO' as name
            from t_purchase_order m 
            join t_msr x on x.msr_no=m.msr_no
            join t_assignment n on n.msr_no=m.msr_no
            join m_currency c on c.id=m.id_currency 
            join (select max(id) as id,1 as a from m_exchange_rate where currency_from=1 and currency_to=3 ) a on a=1 
            join m_exchange_rate r on r.id=a.id
            where   po_type='20' and ".$condition."
            union
            select COALESCE(count(m.po_no),0) value,'BPO' as name
            from t_purchase_order m 
            join t_msr x on x.msr_no=m.msr_no
            join t_assignment n on n.msr_no=m.msr_no
            join m_currency c on c.id=m.id_currency 
            join (select max(id) as id,1 as a from m_exchange_rate where currency_from=1 and currency_to=3 ) a on a=1 
            join m_exchange_rate r on r.id=a.id
            where   po_type='10' and m.blanket=1 and ".$condition)->result();
        
    }

    public function issuance_agreement_type_trend($condition = '1=1') {
        return $this->db->query("select COALESCE(count(m.po_no),0) value,'PO' as name,LEFT(po_date,7) as periode
            from t_purchase_order m 
            join t_msr x on x.msr_no=m.msr_no
            join t_assignment n on n.msr_no=m.msr_no
            join m_currency c on c.id=m.id_currency 
            join (select max(id) as id,1 as a from m_exchange_rate where currency_from=1 and currency_to=3 ) a on a=1 
            join m_exchange_rate r on r.id=a.id
            where  po_type='10' and m.blanket=0 and ".$condition." group by po_date
            union 
            select COALESCE(count(m.po_no),0) value,'SO' as name,LEFT(po_date,7) as periode
            from t_purchase_order m 
            join t_msr x on x.msr_no=m.msr_no
            join t_assignment n on n.msr_no=m.msr_no
            join m_currency c on c.id=m.id_currency 
            join (select max(id) as id,1 as a from m_exchange_rate where currency_from=1 and currency_to=3 ) a on a=1 
            join m_exchange_rate r on r.id=a.id
            where   po_type='20' and ".$condition." group by po_date
            union
            select COALESCE(count(m.po_no),0) value,'BPO' as name,LEFT(po_date,7) as periode
            from t_purchase_order m 
            join t_msr x on x.msr_no=m.msr_no
            join t_assignment n on n.msr_no=m.msr_no
            join m_currency c on c.id=m.id_currency 
            join (select max(id) as id,1 as a from m_exchange_rate where currency_from=1 and currency_to=3 ) a on a=1 
            join m_exchange_rate r on r.id=a.id
            where   po_type='10' and m.blanket=1 and ".$condition." group by po_date")->result();
        
    }

    public function issuance_agreement_type_trend_value($condition = '1=1') {
        return $this->db->query("select COALESCE(count(distinct m.po_no),0) as number,COALESCE(sum(m.total_amount_base),0) value,'PO' as name,LEFT(po_date,7) as periode
            from t_purchase_order m 
            join t_msr x on x.msr_no=m.msr_no
            join t_assignment n on n.msr_no=m.msr_no
            join m_currency c on c.id=m.id_currency 
            join (select max(id) as id,1 as a from m_exchange_rate where currency_from=1 and currency_to=3 ) a on a=1 
            join m_exchange_rate r on r.id=a.id
            where  po_type='10' and m.po_date IS NOT NULL and m.blanket=0 and ".$condition." group by po_date
            union 
            select COALESCE(count(distinct m.po_no),0) as number,COALESCE(sum(m.total_amount_base),0) value,'SO' as name,LEFT(po_date,7) as periode
            from t_purchase_order m 
            join t_msr x on x.msr_no=m.msr_no
            join t_assignment n on n.msr_no=m.msr_no
            join m_currency c on c.id=m.id_currency 
            join (select max(id) as id,1 as a from m_exchange_rate where currency_from=1 and currency_to=3 ) a on a=1 
            join m_exchange_rate r on r.id=a.id
            where   po_type='20'  and m.po_date IS NOT NULL and ".$condition." group by po_date
            union
            select COALESCE(count(distinct m.po_no),0) as number,COALESCE(sum(m.total_amount_base),0) value,'BPO' as name,LEFT(po_date,7) as periode
            from t_purchase_order m 
            join t_msr x on x.msr_no=m.msr_no
            join t_assignment n on n.msr_no=m.msr_no
            join m_currency c on c.id=m.id_currency 
            join (select max(id) as id,1 as a from m_exchange_rate where currency_from=1 and currency_to=3 ) a on a=1 
            join m_exchange_rate r on r.id=a.id
            where   po_type='10' and m.po_date IS NOT NULL and m.blanket=1 and ".$condition." group by po_date")->result();
        
    }

     public function issuance_agreement_company_trend($condition = '1=1') {
        return $this->db->query("select COALESCE(count(distinct m.po_no),0) as number,COALESCE(sum(m.total_amount_base),0) value,g.ABBREVIATION as name,LEFT(po_date,7) as periode
            from t_purchase_order m 
            join t_msr x on x.msr_no=m.msr_no
            join m_company g on g.ID_COMPANY=x.id_company
            join t_assignment n on n.msr_no=m.msr_no
            join m_currency c on c.id=m.id_currency 
            join (select max(id) as id,1 as a from m_exchange_rate where currency_from=1 and currency_to=3 ) a on a=1 
            join m_exchange_rate r on r.id=a.id
            where m.po_date IS NOT NULL and ".$condition." group by g.ABBREVIATION,m.po_date")->result();
        
    }

    public function issuance_agreement_type_value($condition = '1=1') {
        return $this->db->query("select COALESCE(sum(m.total_amount_base),0) value,'PO' as name
            from t_purchase_order m 
            join t_msr x on x.msr_no=m.msr_no
            join t_assignment n on n.msr_no=m.msr_no
            join m_currency c on c.id=m.id_currency 
            join (select max(id) as id,1 as a from m_exchange_rate where currency_from=1 and currency_to=3 ) a on a=1 
            join m_exchange_rate r on r.id=a.id
            where  po_type='10' and m.blanket=0 and ".$condition."
            union 
            select COALESCE(sum(m.total_amount_base),0) value,'SO' as name
            from t_purchase_order m 
            join t_msr x on x.msr_no=m.msr_no
            join t_assignment n on n.msr_no=m.msr_no
            join m_currency c on c.id=m.id_currency 
            join (select max(id) as id,1 as a from m_exchange_rate where currency_from=1 and currency_to=3 ) a on a=1 
            join m_exchange_rate r on r.id=a.id
            where   po_type='20' and ".$condition."
            union
            select COALESCE(sum(m.total_amount_base),0) value,'BPO' as name
            from t_purchase_order m 
            join t_msr x on x.msr_no=m.msr_no
            join t_assignment n on n.msr_no=m.msr_no
            join m_currency c on c.id=m.id_currency
            join (select max(id) as id,1 as a from m_exchange_rate where currency_from=1 and currency_to=3 ) a on a=1 
            join m_exchange_rate r on r.id=a.id
            where   po_type='10' and m.blanket=1 and ".$condition)->result();
        
    }

    public function issuance_agreement_company($condition = '1=1') {
        return $this->db->query("select COALESCE(count(m.po_no),0) number,COALESCE(sum(m.total_amount_base),0) value,COALESCE(y.ABBREVIATION,0) as name
            from t_purchase_order m 
            join t_msr x on x.msr_no=m.msr_no
            join t_assignment n on n.msr_no=m.msr_no
            join m_currency c on c.id=m.id_currency 
            join m_company y on y.ID_COMPANY=m.id_company
            join (select max(id) as id,1 as a from m_exchange_rate where currency_from=1 and currency_to=3 ) a on a=1 
            join m_exchange_rate r on r.id=a.id
            where  ".$condition." group by y.ABBREVIATION")->result();
        
    }

    public function issuance_agreement_procurement_method($condition = '1=1') {
        return $this->db->query("select COALESCE(count(m.po_no),0) number,COALESCE(sum(m.total_amount_base),0) value,COALESCE(x.id_pmethod,0) as name
            from t_purchase_order m 
            join t_msr x on x.msr_no=m.msr_no
            join t_assignment n on n.msr_no=m.msr_no
            join m_currency c on c.id=m.id_currency 
            join m_company y on y.ID_COMPANY=m.id_company
            join (select max(id) as id,1 as a from m_exchange_rate where currency_from=1 and currency_to=3 ) a on a=1 
            join m_exchange_rate r on r.id=a.id
            where  ".$condition." group by x.id_pmethod")->result();
        
    }

    public function issuance_agreement_procurement_specialist($condition = '1=1') {
        return $this->db->query("select COALESCE(count(m.po_no),0) number,COALESCE(sum(m.total_amount_base),0) value,COALESCE(u.NAME,0) as name
            from t_purchase_order m 
            join t_msr x on x.msr_no=m.msr_no
            join t_assignment n on n.msr_no=m.msr_no
            join m_user u on u.ID_USER=n.user_id
            join m_currency c on c.id=m.id_currency 
            join m_company y on y.ID_COMPANY=m.id_company
            join (select max(id) as id,1 as a from m_exchange_rate where currency_from=1 and currency_to=3 ) a on a=1 
            join m_exchange_rate r on r.id=a.id
            where  ".$condition." group by u.NAME")->result();
        
    }

    public function issuance_agreement_risk($condition = '1=1') {
        return $this->db->query("select COALESCE(count(m.po_no),0) number,COALESCE(sum(m.total_amount_base),0) value,COALESCE(CASE WHEN v.RISK=1 THEN 'High' ELSE 'Low' END,0) as name
            from t_purchase_order m 
            join t_msr x on x.msr_no=m.msr_no
            join t_assignment n on n.msr_no=m.msr_no
            join m_currency c on c.id=m.id_currency 
            join m_company y on y.ID_COMPANY=m.id_company
            join m_vendor v on v.ID=m.id_vendor
            join (select max(id) as id,1 as a from m_exchange_rate where currency_from=1 and currency_to=3 ) a on a=1 
            join m_exchange_rate r on r.id=a.id
            where  ".$condition." group by v.RISK")->result();
        
    }

    public function issuance_agreement_status($condition = '1=1') {
        return $this->db->query(" select count(m.po_no) as value,'Active' as name
            from t_purchase_order m 
            join t_msr x on x.msr_no=m.msr_no
            join t_assignment n on n.msr_no=m.msr_no
            join m_currency c on c.id=m.id_currency 
            join m_company y on y.ID_COMPANY=m.id_company
            left join (select t.no_po,sum(COALESCE(s.subtotal_base,0))  as total from t_itp t
            left join t_service_receipt s on s.id_itp=t.id_itp
            group by t.no_po) t on t.no_po=m.po_no
            where  CURRENT_DATE<=m.delivery_date  and COALESCE(t.total,0)<m.total_amount_base and ".$condition."
            UNION 
            select count(m.po_no) as value,'Overdue' as name
            from t_purchase_order m 
            join t_msr x on x.msr_no=m.msr_no
            join t_assignment n on n.msr_no=m.msr_no
            join m_currency c on c.id=m.id_currency 
            join m_company y on y.ID_COMPANY=m.id_company
            left join (select t.no_po,sum(COALESCE(s.subtotal_base,0))  as total from t_itp t
            left join t_service_receipt s on s.id_itp=t.id_itp
            group by t.no_po) t on t.no_po=m.po_no
            where  CURRENT_DATE>m.delivery_date  and COALESCE(t.total,0)<m.total_amount_base and ".$condition."
            UNION 
            select count(m.po_no) as value,'Close Out' as name
            from t_purchase_order m 
            join t_msr x on x.msr_no=m.msr_no
            join t_assignment n on n.msr_no=m.msr_no
            join m_currency c on c.id=m.id_currency 
            join m_company y on y.ID_COMPANY=m.id_company
            join t_performance_cor o on o.po_no = m.po_no
            where  CURRENT_DATE>m.delivery_date  and ".$condition."
            "
        )->result();
        
    }

    public function issuance_agreement_method_trend($condition = '1=1') {
        return $this->db->query("select COALESCE(count(distinct m.po_no),0) as number,COALESCE(sum(m.total_amount_base),0) value,COALESCE(x.id_pmethod,0) as name,LEFT(po_date,7) as periode
            from t_purchase_order m 
            join t_msr x on x.msr_no=m.msr_no
            join m_company g on g.ID_COMPANY=x.id_company
            join t_assignment n on n.msr_no=m.msr_no
            join m_currency c on c.id=m.id_currency 
            join (select max(id) as id,1 as a from m_exchange_rate where currency_from=1 and currency_to=3 ) a on a=1 
            join m_exchange_rate r on r.id=a.id
            where m.po_date IS NOT NULL  and ".$condition." group by COALESCE(x.id_pmethod,0),m.po_date")->result();
        
    }

    public function issuance_agreement_procurement_specialist_trend($condition = '1=1') {
        return $this->db->query("select COALESCE(count(distinct m.po_no),0) as number,COALESCE(sum(m.total_amount_base),0) value,COALESCE(u.NAME,0) as name,LEFT(po_date,7) as periode
            from t_purchase_order m 
            join t_msr x on x.msr_no=m.msr_no
            join m_company g on g.ID_COMPANY=x.id_company
            join t_assignment n on n.msr_no=m.msr_no
            join m_user u on u.ID_USER=n.user_id
            join m_currency c on c.id=m.id_currency 
            join (select max(id) as id,1 as a from m_exchange_rate where currency_from=1 and currency_to=3 ) a on a=1 
            join m_exchange_rate r on r.id=a.id
            where m.po_date IS NOT NULL  and ".$condition." group by COALESCE(u.NAME,0),m.po_date")->result();
        
    }

    public function issuance_agreement_risk_trend($condition = '1=1') {
        return $this->db->query("select COALESCE(count(m.po_no),0) number,COALESCE(sum(m.total_amount_base),0) value,COALESCE(CASE WHEN v.RISK=1 THEN 'High' ELSE 'Low' END,0) as name,LEFT(po_date,7) as periode
            from t_purchase_order m 
            join t_msr x on x.msr_no=m.msr_no
            join t_assignment n on n.msr_no=m.msr_no
            join m_currency c on c.id=m.id_currency 
            join m_company y on y.ID_COMPANY=m.id_company
            join m_vendor v on v.ID=m.id_vendor
            join (select max(id) as id,1 as a from m_exchange_rate where currency_from=1 and currency_to=3 ) a on a=1 
            join m_exchange_rate r on r.id=a.id
            where  ".$condition." group by v.RISK,m.po_date")->result();
        
    }

    public function issuance_agreement_detail($condition = '1=1') {
        return $this->db->query("select m.po_no as agreement_no,CASE WHEN (m.po_type='10' and m.blanket=0) THEN 'Goods' WHEN (m.po_type='20' and m.blanket=0) THEN 'Services' ELSE 'Blanket' END as type,m.total_amount_base as value,c.CURRENCY as currency,v.NAMA as supplier,m.delivery_date as promise_date
            from t_purchase_order m 
            join t_msr x on x.msr_no=m.msr_no
            join t_assignment n on n.msr_no=m.msr_no
            join m_currency c on c.id=m.id_currency 
            join m_vendor v on v.ID=m.id_vendor
            join (select max(id) as id,1 as a from m_exchange_rate where currency_from=1 and currency_to=3 ) a on a=1 
            join m_exchange_rate r on r.id=a.id where ".$condition." order by m.po_no")->result();
        
    }

}
?>