<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_work_request extends CI_Model {
  
  protected $table = 'cmms_wr';
  protected $table_approval = 'cmms_wr_approval';

  public function __construct() {
    parent::__construct();
  }
  public function _get_datatables_query($value='')
  {
    $sql = $this->sql();
    return $sql;

  }
  public function dt_get_datatables()
  {
    $sql = $this->_get_datatables_query();
    $sql .= " where 1=1  ";
    if($this->input->post('wr_no') == 2)
    {
      $sql .= " and wr_no =  '".$this->input->post('wr_no')."'";
    }
    if($this->input->post('wo_type_id') == 1)
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
      $sql .= " and status like '%".$this->input->post('status')."%'";
    }
    
    $sql .= " order by cmms_wr.id asc";
    if($_POST['length'] != -1)
    {
      $sql .= " LIMIT ".$_POST['start'].",".$_POST['length'];
    }
    // echo $sql;
    $query = $this->db->query($sql);
    return $query->result();
  }
  public function sql($value='')
  {
    $sql = "select cmms_wr.*,cmms_wo_type.notation as wr_type, m_user.NAME as originator
    from $this->table
    left join cmms_wo_type on cmms_wo_type.id = cmms_wr.wo_type_id
    left join m_user on m_user.ID_USER = cmms_wr.created_by
    ";
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
    // echo "<pre>SUPERVISOR<br>";
    // print_r($supervisor);
    $maintenance_planner = $this->db->where(['id'=>$supervisor->parent_id])->get('t_jabatan')->row();
    // echo "MAINTENANCE PLANNER<br>";
    // print_r($maintenance_planner);
    // $this->db->trans_begin();
    $data[] = ['wr_no'=>$wr_no, 'user_assign_id'=>$wr->created_by,'sequence'=>1,'status'=>1, 'created_at'=>date("Y-m-d H:i:s"), 'created_by'=> $this->session->userdata('ID_USER')];
    $data[] = ['wr_no'=>$wr_no, 'user_assign_id'=>$supervisor->user_id,'sequence'=>2,'status'=>0, 'created_at'=>date("Y-m-d H:i:s"), 'created_by'=> $this->session->userdata('ID_USER')];
    $data[] = ['wr_no'=>$wr_no, 'user_assign_id'=>$maintenance_planner->user_id,'sequence'=>3,'status'=>0, 'created_at'=>date("Y-m-d H:i:s"), 'created_by'=> $this->session->userdata('ID_USER')];
    $this->db->insert_batch($this->table_approval,$data);

    /*if($this->db->trans_status() === true)
    {
      $this->db->trans_commit();
      return true;
    }
    else
    {
      $this->db->trans_rollback();
      return false;
    }*/
  }
}