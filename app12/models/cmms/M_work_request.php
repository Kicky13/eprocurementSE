<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_work_request extends CI_Model {
  
  protected $table = 'cmms_wr';
  protected $table_approval = 'cmms_wr_approval';
  protected $long_desc_table = 'F00165';
  protected $long_desc_column = "gdobnm, gdtxky, gdmoseqn, gdgtmotype, gduser, gdupmj, gdgtitnm, gdtxft, gdgtfilenm, gdgtfutm1, gdgtfutm2, gdgtfuts1, gdgtfuts2, gdgtfuts3, gdgtfuts4, gdlngp, gdqunam, gdtday";
  protected $long_desc_values = "'GT4801A',wr_no,1,0,'BSV01',119240,'Text1',
utl_raw.cast_to_raw('{".'\r'."tf1\ansi\ansicpg1252\deff0\deflang1057 deskripsi_line}'),' ',0,0,' ',' ',' ', ' ',' ',' ',112236";
  public function __construct() {
    parent::__construct();
    $this->dbo = $this->load->database('oracle', true);
    $this->db_dev_user = $this->load->database('dev_user', true);
    $user = user();
    $this->user = $user;
    if (isset($user->ROLES)) {
        $roles = explode(",", $user->ROLES);
    } else {
        $roles = array();
    }
    $this->roles      = array_values(array_filter($roles));
  }
  public function _get_datatables_query($value='')
  {
    $sql = $this->sql();
    $sql .= " where 1=1  ";
    if($this->input->post('wr_no'))
    {
      $sql .= " and wr_no =  '".$this->input->post('wr_no')."'";
    }
    if($this->input->post('wo_type_id'))
    {
      $sql .= " and wo_type_id =  '".$this->input->post('wo_type_id')."'";
    }
    if($this->input->post('wr_description'))
    {
      $sql .= " and wr_description =  '".$this->input->post('wr_description')."'";
    }
    if($this->input->post('failure_desc'))
    {
      $sql .= " and failure_desc like '%".$this->input->post('failure_desc')."%'";
    }
    if($this->input->post('req_finish_date'))
    {
      $sql .= " and req_finish_date like '%".$this->input->post('req_finish_date')."%'";
    }
    if($this->input->post('priority'))
    {
      $sql .= " and priority like '%".$this->input->post('priority')."%'";
    }
    if($this->input->post('eq_number'))
    {
      $sql .= " and eq_number like '%".$this->input->post('eq_number')."%'";
    }
    if($this->input->post('eq_desc'))
    {
      $sql .= " and eq_desc like '%".$this->input->post('eq_desc')."%'";
    }
    if($this->input->post('eq_type'))
    {
      $sql .= " and eq_type like '%".$this->input->post('eq_type')."%'";
    }
    if($this->input->post('eq_class'))
    {
      $sql .= " and eq_class like '%".$this->input->post('eq_class')."%'";
    }
    if($this->input->post('eq_location'))
    {
      $sql .= " and eq_location like '%".$this->input->post('eq_location')."%'";
    }
    if($this->input->post('status'))
    {
      $sql .= " and cmms_wr.status like '%".$this->input->post('status')."%'";
    }
    if($this->input->post('all'))
    {

    }
    else
    {
      if(in_array(operator_cmms,$this->roles))
      {
        $sql .= " and cmms_wr.created_by = {$this->user->ID_USER}";
      }
      if(in_array(department_cmms,$this->roles))
      {
        $sql .= " and cmms_wr.created_by = {$this->user->ID_USER}";
      }
      if(in_array(supervior_cmms, $this->roles))
      {
        $cekDoa = "select creator_id from cmms_doa where assign_id = ".$this->session->userdata('ID_USER')." and (now() between start_date and end_date) ";
        $qdoa = $this->db->query($cekDoa);
        $qid = $this->session->userdata('ID_USER');
        if($qdoa->num_rows() > 0)
        {
          $qid = $qdoa->row()->creator_id.','.$this->session->userdata('ID_USER');
        }

        $q = "select id from cmms_position where user_id in ($qid) ";
        $q = "select user_id from cmms_position where parent_id in ($q) ";
        $sqlCheckAdd = "select * from cmms_wr where status = '01' and cmms_wr.created_by in ($q)";

        $sql .= " and cmms_wr.created_by in ($q) and cmms_wr.status = '01'";

        $rsCheckAdd = $this->db->query($sqlCheckAdd);
        if($rsCheckAdd->num_rows() > 0)
        {
          $sql .= $this->addSqlJdeWo($rsCheckAdd);
        }
      }
    }
    return $sql;

  }
  public function dt_get_datatables()
  {
    $sql = $this->_get_datatables_query();

    $sql .= " order by cmms_wr.id asc";
    if($_POST['length'] != -1)
    {
      $sql .= " LIMIT ".$_POST['start'].",".$_POST['length'];
    }
    
    $query = $this->db->query($sql);
    return $query->result();
  }
  public function sql($value='')
  {
    $sql = "select cmms_wr.*,cmms_wo_type.notation as wr_type, m_user.NAME as originator,concat(cmms_wr.status,' - ',cmms_wo_status.wo_status_desc) status
    from $this->table
    left join cmms_wo_type on cmms_wo_type.id = cmms_wr.wo_type_id
	 left join cmms_wo_status on cmms_wo_status.wo_status = cmms_wr.status
    left join m_user on m_user.ID_USER = cmms_wr.created_by
    ";
    return $sql;  
  }
  public function dt_count_all()
  {
    return $this->db->query($this->_get_datatables_query())->num_rows();
  }
  public function dt_count_filtered()
  {
    $sql = $this->_get_datatables_query();
    return $this->db->query($sql)->num_rows();
  }
  public function store($data)
  {
  	$this->db->trans_begin();
    $user = user();
    $data['created_by'] = $user->ID_USER;
    $data['created_at'] = date("Y-m-d H:i:s");
    $this->db->insert($this->table, $data);

    $wr_no = $this->find($this->db->insert_id())->wr_no;
    // $this->generate_approval($wr_no);
    $findSupervisor = $this->findSupervisor();
    if($findSupervisor)
    {
      $this->sendEmail($findSupervisor->EMAIL, $data);
    }

    if($this->db->trans_status() === true)
    {
      $this->db->trans_commit();
      return true;
    }
    else
    {
      $this->db->trans_rollback();
      return false;
    }
  }
  public function find($id='')
  {
    return $this->db->where(['id'=>$id])->get($this->table)->row();
  }
  public function findByWrNo($wr_no='')
  {
    return $this->db->where(['wr_no'=>$wr_no])->get($this->table)->row();
  }
  public function generate_approval($wr_no='')
  {
    $wr = $this->findByWrNo($wr_no);
    $t_jabatan = $this->db->where(['user_id'=>$wr->created_by])->get('t_jabatan')->row();
    $supervisor = $this->db->where(['id'=>$t_jabatan->parent_id])->get('t_jabatan')->row();
    $maintenance_planner = $this->db->where(['id'=>$supervisor->parent_id])->get('t_jabatan')->row();
    $data[] = ['wr_no'=>$wr_no, 'user_assign_id'=>$wr->created_by,'sequence'=>1,'status'=>1, 'created_at'=>date("Y-m-d H:i:s"), 'created_by'=> $this->session->userdata('ID_USER')];
    $data[] = ['wr_no'=>$wr_no, 'user_assign_id'=>$supervisor->user_id,'sequence'=>2,'status'=>0, 'created_at'=>date("Y-m-d H:i:s"), 'created_by'=> $this->session->userdata('ID_USER')];
    $data[] = ['wr_no'=>$wr_no, 'user_assign_id'=>$maintenance_planner->user_id,'sequence'=>3,'status'=>0, 'created_at'=>date("Y-m-d H:i:s"), 'created_by'=> $this->session->userdata('ID_USER')];
    $this->db->insert_batch($this->table_approval,$data);
  }
  public function can_approve_user_manager($wr_no='')
  {
    return $this->db->select("cmms_wr.*,cmms_wr_approval.id approval_id")
    ->join('cmms_wr_approval', "cmms_wr_approval.wr_no = cmms_wr.wr_no and cmms_wr_approval.user_assign_id={$this->user->ID_USER}",'left')
    ->where('cmms_wr.wr_no',$wr_no)
    ->where("cmms_wr.wr_no in (select wr_no from cmms_wr_approval where sequence = 2 and status = 0 and user_assign_id = {$this->user->ID_USER})")
    ->where("cmms_wr_approval.sequence = 2 and cmms_wr_approval.status = 0")
    ->get($this->table);
  }
  public function update_and_approve($data='')
  {
    $this->db->trans_begin();
    //unset($data['status'],$data['id'],$data['description']);
    if(@$data['parent_id_old'])
    {
      @$data['parent_id'] = null;
    }
    if(@$data['photo_old'])
    {
      @$data['photo'] = null;
    }
    unset($data['parent_id_old'],$data['photo_old']);
    $this->db->where('wr_no', $data['wr_no'])->update($this->table, $data);
    //$this->approve($this->input->post());
    if($this->db->trans_status() === true)
    {
      $this->db->trans_commit();
      return true;
    }
    else
    {
      $this->db->trans_rollback();
      return false;
    }
  }
  public function reject($data='')
  {
    $this->db->trans_begin();
    $this->db->where('wr_no', $data['wr_no'])->update($this->table, $data);
    if($this->db->trans_status() === true)
    {
      $this->db->trans_commit();
      return true;
    }
    else
    {
      $this->db->trans_rollback();
      return false;
    }
  }
  public function approve($data='')
  {
    $this->db->where("id",$data['id'])->update($this->table_approval, ['status'=>$data['status'], 'description'=>$data['description'], 'user_approval_id'=>$this->session->userdata('ID_USER'), 'updated_by'=>$this->session->userdata('ID_USER')]);
  }
  /*insert into F00165(gdobnm, gdtxky, gdmoseqn, gdgtmotype, gduser, gdupmj, gdgtitnm, gdtxft, gdgtfilenm, gdgtfutm1, gdgtfutm2, gdgtfuts1, gdgtfuts2, gdgtfuts3, gdgtfuts4, gdlngp, gdqunam, gdtday ) 
values ('GT4801A',19000056,1,0,'BSV01',119240,'Text1',
utl_raw.cast_to_raw('{\rtf1\ansi\ansicpg1252\deff0\deflang1057{\fonttbl{\f0\fswiss\fprq2\fcharset0 Courier New;}} deskripsi_line1\par deskripsi_line2\par deskripsi_line3\par deskripsi_line_seterusnya\par}')
,' ',0,0,' ',' ',' ', ' ',' ',' ',112236);*/
  public function insert_long_desc_jde($data='')
  {
    $this->dbo->trans_begin();
    $long_desc_values = $this->long_desc_values;
    $long_desc_values = str_replace('wr_no', $data['wr_no'], $long_desc_values);
    $hazard = " HAZARD:".$data['hazard']."\par";
    $long_desc_values = str_replace('deskripsi_line', cmms_long_desc_extract($data['long_description']).$hazard, $long_desc_values);
    $query = "insert into {$this->long_desc_table} ({$this->long_desc_column}) values ($long_desc_values)";
    $this->dbo->query($query);
    if($this->dbo->trans_status() === true)
    {
      $this->dbo->trans_commit();
      return true;
    }
    else
    {
      $this->dbo->trans_rollback();
      return false;
    }
  }
  public function update_long_desc_jde($data='')
  {
    $this->dbo->trans_begin();
    $sets = "gdtxft = utl_raw.cast_to_raw('{".'\r'."tf1\ansi\ansicpg1252\deff0\deflang1057 deskripsi_line}')";
    $long_description = cmms_long_desc_extract($data['long_description']);
    $hazard = " HAZARD:".$data['hazard']."\par";
    $long_description .= $hazard;
    $sets = str_replace('deskripsi_line', $long_description, $sets);
    $query = "update {$this->long_desc_table} set $sets where gdtxky = '".$data['wr_no']."' and gdobnm = 'GT4801A' and gdgtitnm = 'Text1' ";
    $this->dbo->query($query);
    if($this->dbo->trans_status() === true)
    {
      $this->dbo->trans_commit();
      return true;
    }
    else
    {
      $this->dbo->trans_rollback();
      return false;
    }
  }
  public function findSupervisor()
  {
    $q = "SELECT EMAIL from m_user where m_user.ID_USER = (select user_id from cmms_position where id = (select parent_id from cmms_position where user_id = ".$this->session->userdata('ID_USER')."))";
    return $this->db->query($q)->row();
  }
  public function sendEmail($email='',$data='')
  {
    $wr = $this->db->where('CATEGORY','wr_supervisor_approval')->get('cmms_email_notification_setting')->row();
    if($wr)
    {
      if(is_array($data))
      {

      }
      else
      {
        $data = $this->db->where('wr_no',$data)->get('cmms_wr')->row_array();
      }
      if($data)
      {
        $userCreated = user()->NAME;
        $createdAt = dateToIndo($data['created_at'], false, true);
        $wr_priority = wr_priority($data['priority']);
        $wrtype = $this->db->where('id',$data['wo_type_id'])->get('cmms_wo_type')->row();
        $open = $wr->OPEN_VALUE;
        $close = $wr->CLOSE_VALUE;
        $title = $wr->TITLE;
        $open = str_replace('__eqno__', $data['eq_number'], $open);
        $open = str_replace('__eqdesc__', $data['eq_desc'], $open);
        $open = str_replace('__wrno__', $data['wr_no'], $open);
        $open = str_replace('__wrdesc__', $data['wr_description'], $open);
        $open = str_replace('__wrtype__', $wrtype->notation, $open);
        $open = str_replace('__requestfinishdate__', dateToIndo($data['req_finish_date']), $open);
        $open = str_replace('__createdby__', $userCreated, $open);
        $open = str_replace('__createdat__', $createdAt, $open);
        $open = str_replace('__wrpriority__', $wr_priority, $open);
        $content['open'] = $open;
        $content['close'] = $close;
        $content['title'] = $title;
        $ctn = '<br>' . $content['open'] . '
                <br>
                ' . $content['close'] . '
                <br>';
        $data_email['recipient'] = $email;
        $data_email['subject'] = $content['title'];
        $data_email['content'] = $ctn;
        $data_email['ismailed'] = 0;
        $this->db_dev_user->trans_begin();
        $this->db_dev_user->insert('i_notification', $data_email);
        if ($this->db_dev_user->trans_status() === true) {
          $this->db_dev_user->trans_commit();
          return true;
        } else {
          $this->db_dev_user->trans_rollback();
          return false;
        }
      }
      else
      {
        echo "<pre>";
        echo $this->db_dev_user->last_query();
        print_r($data);
      }
    }
    else
    {
      return false;
    }
  }
  public function suprevisor_task()
  {
    $cekDoa = "select creator_id from cmms_doa where assign_id = ".$this->session->userdata('ID_USER')." and (now() between start_date and end_date) ";
    $qdoa = $this->db->query($cekDoa);
    $qid = $this->session->userdata('ID_USER');
    if($qdoa->num_rows() > 0)
    {
      $arrd = [];
      foreach ($qdoa->result() as $r) {
        $arrd[] = $r->creator_id;
      }
      $impl = implode('m', $arrd);
      $qid = $impl.','.$this->session->userdata('ID_USER');
    }
    $q = "select id from cmms_position where user_id in ($qid)";
    $q = "select user_id from cmms_position where parent_id in ($q) ";
    $sql = "select * from cmms_wr where status = '01' and cmms_wr.created_by in ($q)";
    $rs = $this->db->query($sql);
    if($rs->num_rows() > 0)
    {
      $sql .= $this->addSqlJdeWo($rs);
      $rs = $this->db->query($sql);      
    }
    return $rs;
  }
  public function addSqlJdeWo($rs)
  {
    $userId = [];
    foreach ($rs->result() as $r) {
      $userId[] = $r->created_by;
    }
    $impl = implode(',', $userId);
    $sqlGetUserNamePortal = "select USERNAME from m_user where ID_USER in ($impl)";
    $rsUserNamePortal = $this->db->query($sqlGetUserNamePortal);
    if($rsUserNamePortal->num_rows() > 0)
    {
      $userName = [];
      foreach ($rsUserNamePortal->result() as $rUserNamePortal) {
        $userName[] = "'".$rUserNamePortal->USERNAME."'";
      }
      $impl = implode(',', $userName);
      $sqlGetAvaJdeWo = "select WADOCO from f4801 where watyps not in ('M') and WASRST = '01' and WAANO in ($impl)";
      $rsAvaJdeWo = $this->dbo->query($sqlGetAvaJdeWo);
      if($rsAvaJdeWo->num_rows() > 0)
      {
        $woNoJde = [];
        foreach ($rsAvaJdeWo->result() as $rAvaJdeWo) {
          $woNoJde[] = "'".$rAvaJdeWo->WADOCO."'";
        }
        $impl = implode(',', $woNoJde);
        $sql = " and cmms_wr.wr_no in ($impl) ";
      }
      else
      {
        $sql = " and cmms_wr.wr_no = 'mrt' ";
      }
    }
    return $sql;
  }
}