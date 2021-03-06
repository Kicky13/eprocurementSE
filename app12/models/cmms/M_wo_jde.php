<?php if (!defined('BASEPATH')) exit('Anda tidak masuk dengan benar');

class M_wo_jde extends CI_Model {

  public function __construct() {
    parent::__construct();    
    $this->db = $this->load->database('oracle', true);
    $this->dbm = $this->load->database('default', true);
    $this->wo_table = 'f4801';
    /*F3112
    F48311 as labor list
    F48310 as labor list old/false*/
  }
  public function _get_datatables_query($value='')
  {
    $sql = $this->sql();
    $sql .= " where 1=1  ";
    
    if($this->input->post('STATUS'))
    {
      $sql .= " and UPPER(substr(status,1,2)) = UPPER('".$this->input->post('STATUS')."')";
    }
    if($this->input->post('wotype'))
    {
      // $sql .= " and UPPER(wotype) like UPPER('%".$this->input->post('wotype')."%')";
      $q = $this->dbm->query("select * from cmms_wo_type where code_alpha = '".$this->input->post('wotype')."'");
      if($q->num_rows() > 0)
      {
        $qr = $q->row();
        $sql .= " and wotype = '".$qr->id."'";
      }
    }
    if($this->input->post('WADOCO'))
    {
      $sql .= " and UPPER(wadoco) like UPPER('%".$this->input->post('WADOCO')."%')";
    }
    if($this->input->post('WADL01'))
    {
      $sql .= " and UPPER(wadl01) like UPPER('%".$this->input->post('WADL01')."%')";
    }
    if($this->input->post('WASRST'))
    {
      $sql .= " and UPPER(wasrst) like UPPER('%".$this->input->post('WASRST')."%')";
    }
    if($this->input->post('WAPRTS'))
    {
      $sql .= " and UPPER(WAPRTS) = UPPER(".$this->input->post('WAPRTS').")";
    }
    if($this->input->post('WANUMB'))
    {
      $sql .= " and UPPER(wanumb) like UPPER('%".$this->input->post('WANUMB')."%')";
    }
    if($this->input->post('failure_desc'))
    {
      $sql .= " and UPPER(failure_desc) like UPPER('%".$this->input->post('failure_desc')."%')";
    }
    if($this->input->post('EQNO'))
    {
      $sql .= " and UPPER(EQNO) like UPPER('%".$this->input->post('EQNO')."%')";
    }
    if($this->input->post('EQDESC'))
    {
      $sql .= " and UPPER(EQDESC) like UPPER('%".$this->input->post('EQDESC')."%')";
    }
    if($this->input->post('ORIGINATOR'))
    {
      $sql .= " and UPPER(ORIGINATOR) like UPPER('%".$this->input->post('ORIGINATOR')."%')";
    }

    if(isset($_POST['order']) and $this->input->post('param') == 'wr')
    {
      $columns = [];
      //var $column_order = array('id','bantuan_id','nama_alat','jumlah','terpasang','terpakai','kondisi','dimanfaatkan','foto_alat','titik_pemasangan','created_by','updated_by');
$i=1;
      foreach (cmms_settings('wr_list_tracking')->order_by('seq','asc')->get()->result() as $wr_list_tracking) {
        $columns[$i] = $wr_list_tracking->desc1;
		$i++;
      }
      // $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
      $sql .= " order by ".$columns[$_POST['order']['0']['column']]." ".$_POST['order']['0']['dir'];

    } 
    else
    {
      /*$order = $this->order;
      $this->db->order_by(key($order), $order[key($order)]);*/
      $sql .= " order by wadoco asc";

    }
	/*
	$q = "select * from m_user where id_user = ".$this->session->userdata('ID_USER');
	$u = $this->dbm->query($q)->row();
	if (isset($u->ROLES)) {
		$roles = explode(",", $u->ROLES);
	} else {
		$roles = array();
	}
	$roles      = array_values(array_filter($roles));
	//print_r($roles);
	if(in_array(100008,$roles) or in_array(100010,$roles))
	{
		$sql .= " and ABAN8 = $u->USERNAME ";
	}
	if(in_array(100009,$roles))
	{
		$q = "select user_id from t_jabatan where parent_id = (select id from t_jabatan where user_id = ".$this->session->userdata('ID_USER').")";
		$j = $this->dbm->query($q);
		$sql .= " and ABAN8 in (xx,yy,xx) ";
		if($j->num_rows() > 0)
		{
			$users_id = [];
			foreach($j->result() as $v)
			{
				$users_id[] = $v->user_id;
			}
			$implode = implode(',',$users_id);
			$sql .= " and ABAN8 in ($implode)";
		}
	}*/
    return $sql;

  }
  public function dt_get_datatables()
  {
    $sql = $this->_get_datatables_query();
    
    // $sql .= " order by wadoco asc";
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
	  $where = ' where 1=1 ';
	  if($this->input->post('washno'))
    {
      // $where .= " and a.WASHNO is not null";
      $where .= " and a.wadoco in (".$this->maintenance_task_list().")";
    }
	if($this->input->post('wasrst'))
    {
      $where .= " and a.wasrst = '".$this->input->post('wasrst')."'";
    }
	  $sql="select a.watyps as wotype,a.wadoco,a.wadl01,a.wasrst,a.wanumb,upper(concat(trim(drky),concat(' - ',drdl01))) as status, (to_date(concat(to_char(to_number(substr(a.WATRDJ,1,3)+1900)),substr(a.WATRDJ,4,3)),'YYYYDDD')) WO_DATE, a.KBDS01 FAILURE_DESC, f0101.ABALPH ORIGINATOR, ABAN8, f1201.FAASID as EQNO, f1201.FADL01 as EQDESC,'Under Consturction' as LABOR, a.WAHRSA as ACTHOUR,a.WAPRTS,(case when a.WASTRT > 0 then (to_date(concat(to_char(to_number(substr(a.WASTRT,1,3)+1900)),substr(a.WASTRT,4,3)),'YYYYDDD')) else null end) PLANNED_START_DATE,
    (case when WADPL > 0 then (to_date(concat(to_char(to_number(substr(WADPL,1,3)+1900)),substr(WADPL,4,3)),'YYYYDDD')) else null end) REQUESTED_FINISH_DATE, 
	  (case when WASTRX > 0 then (to_date(concat(to_char(to_number(substr(WASTRX,1,3)+1900)),substr(WASTRX,4,3)),'YYYYDDD')) else null end) as ACTFINISHDATE, 
	  a.KBDS01 as ANALYSISDESC,'Under Consturction' as RESDESC, a.WAANSA as CREWID
	from (select f4801.*,F48164.KBDS01 from f4801 left join (select * from F48164 where KBKNLT = 1) F48164 on F48164.KBDOCO = f4801.WADOCO where f4801.watyps not in ('M')) a 
	left outer join f4801t b on a.wadoco=b.wadoco inner join f40039 c on a.wadcto = c.dtdct 
	inner join CRPCTL.f0005 d on trim(d.drky) = trim(a.wasrst) and  d.drsy='00' and d.drrt='SS'
  left join f0101 on f0101.ABAN8 = a.WAANO
  left join f1201 on f1201.fanumb = a.WANUMB $where";
    $sql = "select x.*,crew.ABALPH as CREWNAME from ($sql) x left join f0101 crew  on crew.ABAN8 = x.CREWID ";
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

    $sql = "select c.dta201 as wotype,a.washno as taskinstruction, a.*,
    upper(concat(trim(drky),concat(' - ',drdl01))) as status
    from (select f4801.*,$f4801 from f4801 where  wadoco='$wo_no' ) a left outer join f4801t b on a.wadoco=b.wadoco inner join f40039 c on a.wadcto = c.dtdct 
    inner join CRPCTL.f0005 d on trim(d.drky) = trim(a.wasrst) and  d.drsy='00' and d.drrt='SS'";
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
  public function wr_no_jde($value='')
  {
    $sql = "select NNN001 from crpctl.F0002 where nnsy='48'";
    $r = $this->db->query($sql)->row();
	$q = "update crpctl.f0002 set nnn001=nnn001+1 where nnsy='48'";
	$this->db->query($q);
    return $r->NNN001;
  }
  public function outstanding_wo_report()
  {
    $sql = $this->db->query("select * from {$this->wo_table} where WASRST = ?", ['70']);
    return $sql;
  }
  public function maintenance_task_list($id_user='')
  {
    $user = user()->USERNAME;
    
    if($id_user)
      $user = user($id_user)->USERNAME;

    $columnDefault = "a.RATSKID, a.RADOCO, a.RADSC1, a.RADSC2, b.ABAN8, b.ABAN81, b.ABALPH";
    $sql = "select a.RADOCO
    from F48311 a 
    left join F0101 b on a.RARSCN = b.ABAN81 
    where b.ABAN8 = $user";
    return $sql;
  }
}