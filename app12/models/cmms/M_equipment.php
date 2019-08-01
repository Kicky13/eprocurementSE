<?php if (!defined('BASEPATH')) exit('Anda tidak masuk dengan benar');

class M_equipment extends CI_Model {

  public function __construct() {
    parent::__construct();    
    $this->db = $this->load->database('oracle', true);
  }
  public function _get_datatables_query($value='')
  {
    $sql = $this->sql();
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
    $sql .= " where 1=1  ";
    if($this->input->post('FAASID'))
    {
      $sql .= " and FAASID =  '".$this->input->post('FAASID')."'";
    }
    if($this->input->post('FADL01'))
    {
      $sql .= " and FADL01 like '%".$this->input->post('FADL01')."%'";
    }
    if($this->input->post('LOCT'))
    {
      $sql .= " and LOCT like '%".$this->input->post('LOCT')."%'";
    }
    if($this->input->post('CIT'))
    {
      $sql .= " and CIT like '%".$this->input->post('CIT')."%'";
    }
    if($this->input->post('PARENTS'))
    {
      $sql .= " and PARENTS like '%".$this->input->post('PARENTS')."%'";
    }
    if($this->input->post('DSPARENTS'))
    {
      $sql .= " and DSPARENTS like '%".$this->input->post('DSPARENTS')."%'";
    }
    if($this->input->post('EQCLAS'))
    {
      $sql .= " and EQCLAS like '%".$this->input->post('EQCLAS')."%'";
    }
    if($this->input->post('EQTYPE'))
    {
      $sql .= " and EQTYPE like '%".$this->input->post('EQTYPE')."%'";
    }
    
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
    $sql = "select * from (select a.fawoyn,a.faaaid,a.fanumb,fadl01,faasid,(select faasid from f1201 where fanumb=a.faaaid ) parents,(select fadl01 from f1201 where fanumb=a.faaaid ) dsparents,
        nvl((select concat(trim(drky),concat(' - ',drdl01))  from CRPCTL.f0005 where drsy='17' and drrt='PA' and trim(drky)=trim(b.wrprodf) ),' ') as eqtype,
        nvl((select concat(trim(drky),concat(' - ',drdl01))  from CRPCTL.f0005 where drsy='17' and drrt='PM' and trim(drky)=trim(b.wrPRODM) ),' ') as eqclas,
        (select concat(trim(drky),concat(' - ',drdl01))  from CRPCTL.f0005 where drsy='12' and drrt='C3' and trim(drky)=trim(a.faacl3) ) as manuf,
        (select concat(trim(drky),concat(' - ',drdl01))  from CRPCTL.f0005 where drsy='12' and drrt='C4' and trim(drky)=trim(a.faacl4) ) as years,
        (select concat(trim(drky),concat(' - ',drdl01))  from CRPCTL.f0005 where drsy='12' and drrt='C1' and trim(drky)=trim(a.faacl1) ) as mjacclass,
        (select concat(trim(drky),concat(' - ',drdl01))  from CRPCTL.f0005 where drsy='12' and drrt='C2' and trim(drky)=trim(a.faacl2) ) as majorequiclass,
        (select concat(trim(drky),concat(' - ',drdl01))  from CRPCTL.f0005 where drsy='12' and drrt='C6' and trim(drky)=trim(a.faacl6) ) as loct,
        (select concat(trim(drky),concat(' - ',drdl01))  from CRPCTL.f0005 where drsy='12' and drrt='C7' and trim(drky)=trim(a.faacl7) ) as cit,
        (select concat(trim(drky),concat(' - ',drdl01))  from CRPCTL.f0005 where drsy='12' and drrt='C5' and trim(drky)=trim(a.faacl5) ) as usages
        from f1201 a inner join f1217 b on a.fanumb=b.wrnumb) x";
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
  public function find($faaaid='')
  {
    $sql = $this->sql();
    $sql .= " where faaaid = $faaaid";
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
    $sql = "select c.dta201 as wotype,a.wadoco,a.wadl01,a.wasrst,a.wanumb,concat(trim(drky),concat(' - ',drdl01)) as status
    from (select * from f4801 where  watyps not in ('M')  and wanumb='$id' ) a left outer join f4801t b on a.wadoco=b.wadoco inner join f40039 c on a.wadcto = c.dtdct 
    inner join CRPCTL.f0005 d on trim(d.drky) = trim(a.wasrst) and  d.drsy='00' and d.drrt='SS'";
    return $this->db->query($sql)->result();
  }
  public function wo_detail($wo_no='')
  {
    $q = "select c.dta201 as wotype,a.washno as taskinstruction, a.*,
    concat(trim(drky),concat(' - ',drdl01)) as status
    from (select * from f4801 where  wadoco='$id' ) a left outer join f4801t b on a.wadoco=b.wadoco inner join f40039 c on a.wadcto = c.dtdct 
    inner join CRPCTL.f0005 d on trim(d.drky) = trim(a.wasrst) and  d.drsy='00' and d.drrt='SS'";
    return $this->db->query($sql)->row();
  }
  public function task_instruction($cfky='')
  {
    //cfky = washno
    $q = "select * from f00192 where cfsy='48' and cfrt='SN' and cfky='$cfky' order by cflins";
    return $this->db->query($sql)->result();
  }
}