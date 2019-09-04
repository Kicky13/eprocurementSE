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
        $q = "select id from t_jabatan where user_id = ".$this->session->userdata('ID_USER');
        $q = "select user_id from t_jabatan where parent_id = ($q) ";
        $sql .= " and cmms_wr.created_by in ($q) and cmms_wr.status = '01'";
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
    $sets = "gdtxft = utl_raw.cast_to_raw('{".'\r'."tf1\ansi\ansicpg1252\deff0\deflang1057{\fonttbl deskripsi_line}'";
    $long_description = cmms_long_desc_extract($data['long_description']);
    $hazard = " HAZARD:".$data['hazard']."\par";
    $long_desc_values .= $hazard;
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
}