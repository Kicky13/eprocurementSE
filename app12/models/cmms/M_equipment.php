<?php if (!defined('BASEPATH')) exit('Anda tidak masuk dengan benar');

class M_equipment extends CI_Model {

  public function __construct() {
    parent::__construct();    
    $this->db = $this->load->database('oracle', true);
  }
  public function _get_datatables_query($value='')
  {
    $sql = $this->sql();
    $sql .= " where 1=1  ";
    if($this->input->post('ALLOWANCE') == 2)
    {
      $sql .= " and FAWOYN =  '0'";
    }
    if($this->input->post('ALLOWANCE') == 1)
    {
      $sql .= " and FAWOYN =  '".$this->input->post('ALLOWANCE')."'";
    }
    if($this->input->post('FAASID'))
    {
      $sql .= " and UPPER(FAASID) = UPPER('".$this->input->post('FAASID')."')";
    }
    if($this->input->post('FADL01'))
    {
      $sql .= " and UPPER(FADL01) like UPPER('%".$this->input->post('FADL01')."%')";
    }
    if($this->input->post('LOCT'))
    {
      $sql .= " and UPPER(LOCT) like UPPER('%".$this->input->post('LOCT')."%')";
    }
    if($this->input->post('CIT'))
    {
      $sql .= " and UPPER(CIT) like UPPER('%".$this->input->post('CIT')."%')";
    }
    $addParents = '';
    if($this->input->post('PARENTS'))
    {
      // $sql .= " and PARENTS like '%".$this->input->post('PARENTS')."%'";
    	$findFANUMB = $this->db->query("select FANUMB from F1201 where TRIM(UPPER(FAASID)) = UPPER('".$this->input->post('PARENTS')."')")->row();
    	if($findFANUMB)
    	{
    		$fanumb = $findFANUMB->FANUMB;
    		/*SELECT ID,EMPLOYEE_NAME,MANAGER_ID FROM "EMPLOYEE_TEST" START WITH ID = 101 CONNECT BY PRIOR ID = MANAGER_ID */
    		$addParents = " START WITH FANUMB = $fanumb CONNECT BY PRIOR FANUMB = FAAAID ";
    	}
      else
      {
        $addParents = " START WITH FANUMB = 123 CONNECT BY PRIOR FANUMB = FAAAID ";
      }
    	/*get FANUMB*/
    }
    if($this->input->post('DSPARENTS'))
    {
      $sql .= " and UPPER(DSPARENTS) like UPPER('%".$this->input->post('DSPARENTS')."%')";
    }
    if($this->input->post('EQCLAS'))
    {
      $sql .= " and UPPER(EQCLAS) like UPPER('%".$this->input->post('EQCLAS')."%')";
    }
    if($this->input->post('EQTYPE'))
    {
      $sql .= " and UPPER(EQTYPE) like UPPER('%".$this->input->post('EQTYPE')."%')";
    }
    $sql .= $addParents;
    return $sql;

  }
  public function dt_get_datatables()
  {
    $sql = $this->_get_datatables_query();
    /*'FAASID' => 'Equipment Number',
      'FADL01' => 'Equipment Description',
      'LOCT' => 'Location',
      'CIT' => 'Criticality',
      'PARENTS' => 'Parent EQ Number',
      'DSPARENTS' => 'Parent Description',
      'EQCLAS' => 'Equipment Class',
      'EQTYPE' => 'Equipment Type',*/
    
    
    $sql .= " order by faaaid asc";
    if($_POST['length'] != -1)
    {
      $sql .= " OFFSET ".$_POST['start']." ROWS FETCH NEXT ".$_POST['length']." ROWS ONLY ";
    }
	//echo $sql;
    $query = $this->db->query($sql);
    return $query->result();
  }
  public function sql($value='')
  {
	  $addSql='';
	  $addColumn='';
	  
	if($this->input->post('reprentitive'))
	{
		$reprentitive = $this->reprentitive();
		$addSql = $reprentitive['join'];
		$addColumn = ", ".$reprentitive['column_db'];
	}
    $sql = "select * from (select a.fawoyn,a.faaaid,a.fanumb, concat(fadl01, ' ' || fadl02 || ' ' || fadl03) fadl01, faasid, (select faasid from f1201 where fanumb=a.faaaid ) parents, 
        (select concat(fadl01, ' ' || fadl02 || ' ' || fadl03) fadl01 from f1201 where fanumb=a.faaaid ) dsparents, 
        nvl((select concat(trim(drky),concat(' - ',drdl01))  from CRPCTL.f0005 where drsy='17' and drrt='PA' and trim(drky)=trim(b.wrprodf) ),' ') as eqtype,
        nvl((select concat(trim(drky),concat(' - ',drdl01))  from CRPCTL.f0005 where drsy='17' and drrt='PM' and trim(drky)=trim(b.wrPRODM) ),' ') as eqclas,
        (select concat(trim(drky),concat(' - ',drdl01))  from CRPCTL.f0005 where drsy='12' and drrt='C3' and trim(drky)=trim(a.faacl3) ) as manuf,
        (select concat(trim(drky),concat(' - ',drdl01))  from CRPCTL.f0005 where drsy='12' and drrt='C4' and trim(drky)=trim(a.faacl4) ) as years,
        (select concat(trim(drky),concat(' - ',drdl01))  from CRPCTL.f0005 where drsy='12' and drrt='C1' and trim(drky)=trim(a.faacl1) ) as mjacclass,
        (select concat(trim(drky),concat(' - ',drdl01))  from CRPCTL.f0005 where drsy='12' and drrt='C2' and trim(drky)=trim(a.faacl2) ) as majorequiclass,
        (select concat(trim(drky),concat(' - ',drdl01))  from CRPCTL.f0005 where drsy='12' and drrt='C6' and trim(drky)=trim(a.faacl6) ) as loct,
        (select concat(trim(drky),concat(' - ',drdl01))  from CRPCTL.f0005 where drsy='12' and drrt='C7' and trim(drky)=trim(a.faacl7) ) as cit,
        (select concat(trim(drky),concat(' - ',drdl01))  from CRPCTL.f0005 where drsy='12' and drrt='C5' and trim(drky)=trim(a.faacl5) ) as usages $addColumn
        from f1201 a 
		inner join f1217 b on a.fanumb=b.wrnumb 
		$addSql
		) x";
    return $sql;  
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
  public function find($fanumb='')
  {
    $sql = $this->sql();
    $sql .= " where fanumb = $fanumb";
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

    $sql = "select c.dta201 as wotype,a.washno as taskinstruction, a.*, f0101.ABALPH ORIGINATOR,
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
    $sql = "select a.WTDOCO WO_NO, b.ABALPH EMPLOYEE_NAME, trim(c.RMMCULT) DEPARTMENT, WTHRW LABOR_HOUR from F31122 a 
    inner join F0101 b on a.WTAN8 = B.ABAN8
    inner join F48310 c on c.RMRSCN = a.WTAN8 where a.WTDOCO = '$wo_no'";
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
  function wo_search()
  {
	  $query = $this->input->get('search');
	  $sql = "select WADOCO, WADL01 from f4801 where ((WASRST between '60' and '90') or WASRST = '99') and UPPER(WADOCO)like UPPER('&$query%') fetch first 5 ROWS ONLY ";
	  $r =  $this->db->query($sql)->result();
	  
	  $d = [];
	  foreach($r as $v)
	  {
		 $d[] = ['id'=>$v->WADOCO, 'text'=>$v->WADOCO];
	  }
	  return $d;
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
}