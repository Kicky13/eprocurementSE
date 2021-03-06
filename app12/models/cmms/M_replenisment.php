<?php if (!defined('BASEPATH')) exit('Anda tidak masuk dengan benar');

class M_replenisment extends CI_Model {

  public function __construct() {
    parent::__construct();    
    $this->db = $this->load->database('oracle', true);
    $this->dbm = $this->load->database('default', true);
    /* [RPLITM] => 14.10.005.002.1          
      [RPMCU] =>    10101WH02
      [RPUORG] => 30
      [RPEV01] => 1
      [RPEV02] => 1
      [RPTRDJ] => 119283
      [RPTDAY] => 93938
      [RPUSER] => SCM       
      [RPUSER] => PC
      [RPDOCO] => 0
      [RPTRQT] => 0
      [RPDRQJ] => 0
      [RPDPL] => 0*/
  }
  public function _get_datatables_query($value='')
  {
    $sql = $this->sql();
    $sql .= " where 1=1  ";
    
    if($this->input->post('RPLITM') == 1)
    {
      $sql .= " and RPLITM =  '".$this->input->post('RPLITM')."'";
    }
    if($this->input->post('RPMCU'))
    {
      $sql .= " and UPPER(TRIM(RPMCU)) = UPPER('".$this->input->post('RPMCU')."')";
    }
    if($this->input->post('RPUORG'))
    {
      $sql .= " and UPPER(RPUORG) like UPPER('%".$this->input->post('RPUORG')."%')";
    }
    if($this->input->post('RPEV01'))
    {
      $sql .= " and UPPER(RPEV01) like UPPER('%".$this->input->post('RPEV01')."%')";
    }
    if($this->input->post('RPEV02'))
    {
      $sql .= " and UPPER(RPEV02) like UPPER('%".$this->input->post('RPEV02')."%')";
    }
    if($this->input->post('RPTRDJ'))
    {
      $sql .= " and UPPER(RPTRDJ) like UPPER('%".$this->input->post('RPTRDJ')."%')";
    }
    if($this->input->post('RPTDAY'))
    {
      $sql .= " and UPPER(RPTDAY) like UPPER('%".$this->input->post('RPTDAY')."%')";
    }

    // $sql .= $addParents;
    return $sql;

  }
  public function dt_get_datatables()
  {
    $sql = $this->_get_datatables_query();
    
    $sql .= " order by RPLITM asc";
    if($_POST['length'] != -1)
    {
      $sql .= " OFFSET ".$_POST['start']." ROWS FETCH NEXT ".$_POST['length']." ROWS ONLY ";
    }
    $query = $this->db->query($sql);
    return $query->result();
  }
  public function sql($value='')
  {
	  
    $sql = "select * from (select RPMCU, RPUNCS, RPLITM, RPPQOH, RPUORG, RPDOCO, RPEV01, RPTRQT, (case when RPDRQJ > 0 then (to_date(concat(to_char(to_number(substr(RPDRQJ,1,3)+1900)),substr(RPDRQJ,4,3)),'YYYYDDD')) else null end) RPDRQJ, (case when RPDPL > 0 then (to_date(concat(to_char(to_number(substr(RPDPL,1,3)+1900)),substr(RPDPL,4,3)),'YYYYDDD')) else null end) RPDPL from F5743702 where RPEV01 = 1 and RPUORG > 0) x";
    return $sql;  
  }
  public function detail($id)
  {
    $sql = "select RPMCU, RPLITM, RPUNCS, RPUORG, RPDOCO, RPEV01, RPPQOH, RPTRQT, (case when RPDRQJ > 0 then (to_date(concat(to_char(to_number(substr(RPDRQJ,1,3)+1900)),substr(RPDRQJ,4,3)),'YYYYDDD')) else null end) RPDRQJ, (case when RPDPL > 0 then (to_date(concat(to_char(to_number(substr(RPDPL,1,3)+1900)),substr(RPDPL,4,3)),'YYYYDDD')) else null end) RPDPL from F5743702 where RPEV01 = 1 and RPUORG = 0 and RPLITM = '$id'";
    return $this->db->query($sql);
  }
  public function dt_count_all()
  {
    return $this->db->query($this->sql())->num_rows();
  }
  public function dt_count_filtered()
  {
    $sql = $this->_get_datatables_query();
    return $this->db->query($sql)->num_rows();
  }
  public function find($item_number='')
  {
    $sql = $this->sql();
    $sql .= " where RPLITM = '$item_number'";
    $rs = $this->db->query($sql)->row();
    return $rs;
  }
  public function pm1($id='')
  {
    $sql = "select fwdoco wo_number, wadl01 wo_desc,fwtdt, b.washno as taskinstruction, (to_date(concat(to_char(to_number(substr(fwtdt,1,3)+1900)),substr(fwtdt,4,3)),'YYYYDDD')) next_due_date from f1207 a inner join f4801 b on a.fwdoco = b.wadoco and b.watyps = 'M' and a.fwmsts = '01' where fwnumb = $id";
    return $this->db->query($sql)->result();
  }
  public function pm2($id='')
  {
    $sql = "select * from f1216 where gznumb=$id";
    return $this->db->query($sql)->result();
  }
  public function spec($id='')
  {
    $sql = "select a.*, b.gzfb01 as service_desc, b.gzfb02 as item_cat
    from 
    (select * from f1216 where gznumb = $id and gzpgnm = 1) a
    left join 
    (select * from f1216 where gznumb = $id and gzpgnm = 2) b
    on a.gznumb = b.gznumb
    ";
    return $this->db->query($sql)->row();
  }
  public function wo($id='')
  {
    /*$sql = "select c.dta201 as wotype,a.wadoco,a.wadl01,a.wasrst,a.wanumb,concat(trim(drky),concat(' - ',drdl01)) as status
    from (select * from f4801 where  watyps not in ('M')  and wanumb='$id' ) a left outer join f4801t b on a.wadoco=b.wadoco inner join f40039 c on a.wadcto = c.dtdct 
    inner join CRPCTL.f0005 d on trim(d.drky) = trim(a.wasrst) and  d.drsy='00' and d.drrt='SS'";*/
	$sql="select c.dta201 as wotype,a.wadoco,a.wadl01,a.wasrst,a.wanumb,concat(trim(drky),concat(' - ',drdl01)) as status, (to_date(concat(to_char(to_number(substr(a.WATRDJ,1,3)+1900)),substr(a.WATRDJ,4,3)),'YYYYDDD')) WO_DATE, a.KBDS01 FAILURE_DESC
	from (select f4801.*,F48164.KBDS01 from f4801 left join (select * from F48164 where KBKNLT = 1) F48164 on F48164.KBDOCO = f4801.WADOCO where f4801.watyps not in ('M') and f4801.wanumb='$id') a 
	left outer join f4801t b on a.wadoco=b.wadoco inner join f40039 c on a.wadcto = c.dtdct 
	inner join CRPCTL.f0005 d on trim(d.drky) = trim(a.wasrst) and  d.drsy='00' and d.drrt='SS'";
    return $this->db->query($sql)->result();
  }
  public function wo_detail($wo_no='')
  {
    $f4801 = "(case when WADPL > 0 then (to_date(concat(to_char(to_number(substr(WADPL,1,3)+1900)),substr(WADPL,4,3)),'YYYYDDD')) else null end) REQUESTED_FINISH_DATE, 
    (case when WATRDJ > 0 then (to_date(concat(to_char(to_number(substr(WATRDJ,1,3)+1900)),substr(WATRDJ,4,3)),'YYYYDDD')) else null end) ORDER_DATE, 
    (case when WASTRT > 0 then (to_date(concat(to_char(to_number(substr(WASTRT,1,3)+1900)),substr(WASTRT,4,3)),'YYYYDDD')) else null end) PLANNED_START_DATE,
    (case when WADRQJ > 0 then (to_date(concat(to_char(to_number(substr(WADRQJ,1,3)+1900)),substr(WADRQJ,4,3)),'YYYYDDD')) else null end) PLANNED_FINISH_DATE,
    (case when WASTRX > 0 then (to_date(concat(to_char(to_number(substr(WASTRX,1,3)+1900)),substr(WASTRX,4,3)),'YYYYDDD')) else null end) ACTUAL_FINISH_DATE";

    $sql = "select a.watyps as wotype,a.washno as taskinstruction, a.*, f0101.ABALPH ORIGINATOR,a.WAPRTS,
    concat(trim(drky),concat(' - ',drdl01)) as status
    from (select f4801.*,$f4801 from f4801 where  wadoco='$wo_no' ) a left outer join f4801t b on a.wadoco=b.wadoco inner join f40039 c on a.wadcto = c.dtdct 
    inner join CRPCTL.f0005 d on trim(d.drky) = trim(a.wasrst) and  d.drsy='00' and d.drrt='SS'
	left join f0101 on f0101.ABAN8 = a.WAANO
	";
    return $this->db->query($sql)->row();
  }
  public function task_instruction($cfky='')
  {
    //cfky = washno
    $sql = "select * from f00192 where cfsy='48' and cfrt='SN' and cfky='$cfky' order by cflins";
    return $this->db->query($sql)->result();
  }
  public function part_list($wo_no='')
  {
    $sql = "select WMCPIL as item_number, concat(trim(WMDSC1),concat(' ',trim(WMDSC1))) as DESCRIPTION, WMTRQT as qty,WMUM AS UOM from f3111 where WMTRQT > 0 and WMDOCO = '$wo_no'" ;
    return $this->db->query($sql)->result();
  }
  public function labor_list($wo_no='')
  {
    $sql = "select a.WLDOCO WO_NO, b.ABALPH EMPLOYEE_NAME, trim(c.RADSC2) DEPARTMENT, (WLRUNL/100) LABOR_HOUR from F3112  a 
    inner join F48311 c on c.RADOCO = a.WLDOCO and c.RAOPSQ = a.WLOPSQ
    inner join F0101 b on c.RARSCN = B.ABAN8
    where a.WLDOCO = '$wo_no'";
    return $this->db->query($sql)->result();
  }
  public function search_for_wr($q='')
  {
    $a = [];
    for ($i=1; $i < 10; $i++) { 
      $a[] = ['EQ_NO'=>'1900000'.$i, 'EQ_DESC'=>'Desc of Eq 1900000'.$i, 'EQ_CLASS'=>'EQ Clas Of 1900000'.$i, 'EQ_TYPE'=>'EQ TYPE Of 1900000'.$i];
    }
    return $a;
  }
  public function criticality()
  {
    $q = "select concat(trim(drky),concat(' - ',trim(drdl01))) critically from CRPCTL.f0005 where drsy='12' and drrt='C7'";
    $s = $this->db->query($q);
    return $s->result();
  }
  public function eq_type()
  {
    $q = "select concat(trim(drky),concat(' - ',trim(drdl01))) EQ_TYPE  from CRPCTL.f0005 where drsy='17' and drrt='PA'";
    $s = $this->db->query($q);
    return $s->result();
  }
  function failure_wr($eq_class)
  {
	  $sql = "select * from F48162 where KNKNLT = 1 and KNPRODM = '$eq_class'";
	  return $this->db->query($sql)->result();
  }
  public function wr_no_jde($value='')
  {
    $sql = "select NNN001 from crpctl.F0002 where nnsy='48'";
    $r = $this->db->query($sql)->row();
	$q = "update crpctl.f0002 set nnn001=nnn001+1 where nnsy='48'";
	$this->db->query($q);
    return $r->NNN001;
  }
  public function reprentitive()
  {
	  $addSql['join'] = "inner join (select WANUMB, count(*) jml from f4801 group by wanumb) c on a.FANUMB = c.WANUMB";
	  $addSql['column_db'] = "JML";
	  $addSql['column_tb'] = "TOTAL";
	  return $addSql;
  }
  public function attachment_jde($wo_no='')
  {
    $sql = "select replace(replace(testing,'{".'\r'."tf1\ansi\ansicpg1252\deff0\deflang1057'),'\x') as aye from (
    select UTL_RAW.CAST_TO_VARCHAR2(DBMS_LOB.SUBSTR(GDTXFT, 8000,1)) testing from f00165 where gdtxky like '%$wo_no%' and GDGTITNM = 'Text1')";
    $rs = $this->db->query($sql);
    if($rs->num_rows() > 0)
      $rs =  str_replace('\par','<br />',substr($rs->row()->AYE, 0,-1));
    else
      $rs = '';
    return $rs;
  }
  public function attachment_jde_other($wo_no='')
  {
    $sql = "select GDGTITNM,GDGTFILENM from f00165 where gdtxky like '%$wo_no%' and GDGTITNM != 'Text1'";
    $rs = $this->db->query($sql);
    return $rs;
  }
  public function new_part_list($wono='')
  {
    $sql = "select WMCPIL ITEM_NUMBER,concat(trim(WMDSC1),concat(' ',trim(WMDSC2))) as DESCRIPTION, WMUORG as request,WMTRQT as actual from f3111 where wmdoco='$wono'";
    $rs = $this->db->query($sql);
    return $rs;
  }
  public function labor_detail($wono='')
  {
    $estimate =  "select trim(WLMCU),WLDSC1 DEPARTMENT,WLOPSQ,WLRUNL/100 as MANHOUR,WLSETL/100 MANPOWER from f3112 where wldoco='$wono'";
    $actual = "select YTPALF as NAME,sum(YTPHRW)/100 ACTHOURS from f06116 where ytsbl='$wono' group by YTPALF";

    $estimate = $this->db->query($estimate);
    $actual = $this->db->query($actual);
    return ['estimate'=>$estimate, 'actual'=>$actual];
  }
  public function new_pm($value='')
  {
    /*select * from F1308 where F0NUMB = '10000029' car parent pm as F0AAID*/
    /*select * from f1201 where FANUMB = '10004322' cari disini*/
    /*select * from f1201 where FANUMB = '10000029'*/
    /*select * from f4801 where WADOCO = '19000099'*/
    /*pm status = 01 atau 50 dengan kondisi jika ada service type yang kembar, ambil yang statusnya 01 berapa pun banyaknya data*/
  }
  public function get_parent_wo($wo_no='')
  {
    $sql = "select WAPARS from f4801 where  wadoco='$wo_no'";
    $r = $this->db->query($sql)->row();
    return $r->WAPARS;
  }
  public function get_po_no($wo_no='')
  {
    $sql = "SELECT b.po_no FROM `t_msr` a join t_purchase_order b on a.msr_no = b.msr_no WHERE wo_no = '$wo_no'";
    $r = $this->db->query($sql)->row();
    return @$r->po_no;
  }
  public function update($value='')
  {
    $this->db->query("update F5743702 set RPEV01 = 2 where RPEV01 = 1 and RPUORG > 0 and RPLITM = '$value'");
  }
  public function updateToAvailabel($msr_no='')
  {
    $msr_items = $this->dbm->query("select * from t_msr_item where msr_no = '$msr_no' and semic_no in (select semic_no from cmms_replenishment)");
    $semic = [];
    foreach ($msr_items->result() as $r) {
      $semic[] = "'".$r->semic_no."'";
    }
    if(count($semic) > 0)
    {
      $semic_join = implode(',', $semic);
      $this->db->query("update F5743702 set RPEV01 = 1 where RPEV01 = 2 and RPUORG > 0 and RPLITM in ($semic_join)");
      $this->dbm->query("delete from cmms_replenishment where semic_no in ($semic_join)");
    }
  }
  public function msrReplenishment($data='')
  {
    $this->dbm->insert('cmms_replenishment',$data);
  }
}