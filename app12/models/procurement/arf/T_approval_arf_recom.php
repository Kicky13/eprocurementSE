<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class T_approval_arf_recom extends CI_Model {
	public function __construct() {
      parent::__construct();
      $this->db = $this->load->database('default', true);
      $this->table = 't_approval_arf_recom';
  }
  public function time_approval($value='')
  {
    $id_user = $this->session->userdata('ID_USER');
    /*$t = $this->db->where(['id_user'=>$id_user,'status'=>0])->order_by('sequence','asc')->get('t_approval_arf_recom');

    $tarf = false;
    if($t->num_rows() > 0)
    {
        $lists=[];
        foreach ($t->result() as $key => $value) {
            $s = $this->db->where(['status'=>1, 'sequence <'=>$value->sequence])->get('t_approval_arf_recom');

            if($s->num_rows()+1 == $value->sequence)
            {
                $lists[] = $value->id_ref;
            }
        }
        if(count($lists) > 0)
        {

            $tarf = $this->db->select('t_arf_recommendation_preparation.arf_response_id, t_arf_response.doc_no,t_arf.po_title title, t_arf.department department_desc, t_arf_notification.response_date, t_arf_response.responsed_at, m_user.NAME, t_arf_response.id')
            ->join('t_arf_response','t_arf_response.id = t_arf_recommendation_preparation.arf_response_id', 'left')
            ->join('t_arf','t_arf_response.doc_no = t_arf.doc_no', 'left')
            ->join('t_arf_assignment','t_arf_assignment.doc_id = t_arf.id', 'left')
            ->join('m_user','m_user.ID_USER = t_arf_assignment.user_id', 'left')
            ->join('t_arf_notification','t_arf_notification.po_no = t_arf.po_no', 'left')
            ->where_in('t_arf_recommendation_preparation.id', $lists)
            ->get('t_arf_recommendation_preparation');
            return $tarf;
        }
    }*/
    $q = $this->db->query("SELECT o.id_ref id,o.id_user_role,o.id_user from (
                        SELECT m.id_ref,min(m.sequence) as sequence
                        FROM t_approval_arf_recom m 
                        where m.status=0 and m.sequence < 7 group by m.id_ref
                ) n JOIN
                t_approval_arf_recom o on o.id_ref=n.id_ref and o.sequence=n.sequence
                JOIN t_arf_recommendation_preparation p on p.arf_response_id=o.id_ref
                 where o.id_user=$id_user and o.sequence < 7 and o.status = 0");
    $tarf = $q;
    /*$tarf = $this->db->query('
            SELECT DISTINCT r.po_no,p.arf_response_id, g.doc_no,r.po_title title, r.department department_desc, c.response_date, g.responsed_at, u.NAME, g.id,o.id_ref,o.id_user_role,o.id_user from (
                    SELECT m.id_ref,min(m.sequence) as sequence
                    FROM t_approval_arf_recom m 
                    where m.status!=1 group by m.id_ref
            ) n
            JOIN t_approval_arf_recom o on o.id_ref=n.id_ref and o.sequence=n.sequence
            JOIN t_arf_recommendation_preparation p on p.arf_response_id=o.id_ref
            LEFT JOIN t_arf_response g on g.id=p.arf_response_id
            LEFT JOIN t_arf r on r.doc_no=g.doc_no
            LEFT JOIN t_arf_assignment s on s.doc_id=r.id
            LEFT JOIN m_user u on u.ID_USER=s.user_id 
            LEFT JOIN t_arf_notification c on c.po_no=r.po_no  where o.id_user =  '.$id_user
          );*/
    /*echo $this->db->last_query();
    exit();*/
    return $tarf;
  }
  public function time_issued($arf_response_id='')
  {
    $this->db->where(['status'=>1,'sequence <'=>7])->get('t_approval_arf_recom');
    $sql1 = "select count(id_ref) jml, id_ref
    from 
    t_approval_arf_recom 
    where status = 1 and sequence < 8 
    group by id_ref";
    
    $sql2 = "select count(id_ref) jml, id_ref
    from 
    t_approval_arf_recom 
    where sequence < 8 
    group by id_ref";
    
    $sql = "select t_arf_response.id, t_arf_response.doc_no, t_arf.po_title title, t_arf.department department_desc, t_arf_notification.response_date, t_arf_response.responsed_at, m_user.NAME 
    from ($sql1) a 
    left join ($sql2) b on a.id_ref = b.id_ref
    left join t_arf_response on a.id_ref = t_arf_response.id
    left join t_arf on t_arf.doc_no = t_arf_response.doc_no
    left join t_arf_assignment on t_arf_assignment.doc_id = t_arf.id
    left join t_arf_notification on t_arf_notification.po_no = t_arf.doc_no
    left join m_user on m_user.ID_USER = t_arf_assignment.user_id
    where t_arf_assignment.user_id = '".$this->session->userdata('ID_USER')."' and a.jml = b.jml  and t_arf_response.id not in (select id_ref from t_approval_arf_recom where sequence = 8 and status = 1) ";
    if($arf_response_id)
    {
      $sql .= " and t_arf_response.id = $arf_response_id";
    }
    return $this->db->query($sql);
  }
  public function approve()
  {
    $p = $this->input->post();
    $transaction_date = date("Y-m-d H:i:s");
    $status_str = $p['status'] == 2 ? "Reject":"Approve";
    $this->db->where(['id'=>$p['approval_id']]);
    $this->db->update('t_approval_arf_recom',[
        'status' => $p['status'],
        'note' => $p['note'],
        'approved_at' => $transaction_date,
        'approved_by' => $this->session->userdata('ID_USER')
    ]);
    
    $t_approval_arf_recom = $this->find($p['approval_id']);
    $id_ref = $t_approval_arf_recom->id_ref;

    $ap = $this->db->where(['id_user'=>$this->session->userdata('ID_USER'),'status'=>0,'id_ref'=>$id_ref, 'sequence <'=> 8])->get('t_approval_arf_recom');
    if($ap->num_rows() > 0)
    {
        echo json_encode(['status'=>false, 'transaction_date'=>dateToIndo($transaction_date,false,false), 'note'=>$p['note'], 'status_str'=>$status_str]);
    }
    else
    {
        echo json_encode(['status'=>true]);
    }
  }
  public function issued()
  {
    $p = $this->input->post();
    $transaction_date = date("Y-m-d H:i:s");
    $status_str = "Issued";

    $approval = $this->db->where(['id_ref'=>$p['arf_response_id'],'status'=>0,'sequence'=>8])->get('t_approval_arf_recom')->row();
    $approval_id = $approval->id;

    $this->db->where(['id'=>$approval_id]);
    $this->db->update('t_approval_arf_recom',[
        'status' => 1,
        'note' => null,
        'approved_at' => $transaction_date,
        'approved_by' => $this->session->userdata('ID_USER')
    ]);
    
    $arf = $this->db->select('t_arf.id')
    ->join('t_arf_response','t_arf_response.doc_no = t_arf.doc_no')
    ->where('t_arf_response.id',$p['arf_response_id'])
    ->get('t_arf')->row();

    $this->db->where('id',$arf->id)->update('t_arf', ['is_issued'=>1]);

    $this->db->where(['arf_response_id'=>$p['arf_response_id']])->update('t_arf_recommendation_preparation', ['amendment_date'=>$p['amendment_date']]);
  }
  public function find($id='')
  {
    return $this->db->where(['id'=>$id])->get($this->table)->row();
  }
  public function reject_list()
  {
    $reject_list_id_ref = $this->db->select('id_ref')->where(['status'=>2])->group_by('id_ref')->get($this->table);
    $id_ref = [];
    foreach ($reject_list_id_ref->result() as $key => $value) {
        $id_ref[] = $value->id_ref;
    }
    
    if($reject_list_id_ref->num_rows() > 0)
    {
        $result = $this->db->select('t_arf_response.id, t_arf_response.doc_no, t_arf.po_title title, t_arf.department department_desc, t_arf_notification.response_date, t_arf_response.responsed_at, m_user.NAME ')
        ->join('t_arf','t_arf.doc_no = t_arf_response.doc_no','left')
        ->join('t_arf_assignment','t_arf_assignment.doc_id = t_arf.id','left')
        ->join('t_arf_notification','t_arf_notification.po_no = t_arf.po_no','left')
        ->join('m_user','m_user.ID_USER = t_arf_assignment.user_id','left')
        ->where(['t_arf_assignment.user_id'=>$this->session->userdata('ID_USER')])
        ->where_in('t_arf_response.id', $id_ref)
        ->get('t_arf_response');
    }
    else
    {
        $result = false;
    }
    
    return $result;
  }
  public function is_reject($id_ref='')
  {
      $reject_list_id_ref = $this->db->select('id_ref')->where(['status'=>2,'id_ref'=>$id_ref])->group_by('id_ref')->get($this->table);
      if($reject_list_id_ref->num_rows() > 0)
      {
        return true;
      }
      return false;
  }
  public function check_complete_approval($value='')
  {
    $unconfirmed = $this->db->query("select id_ref from t_approval_arf_recom where status = 0 group by id_ref");
    $id_ref_unconfirmed = [];
    foreach ($unconfirmed->result() as $key => $value) {
      $id_ref_unconfirmed[] = $value->id_ref;
    }
    $sql = "select * from ";

  }
  public function complete_update($id_ref='')
  {
    $arfRecom = $this->db->where(['id_ref'=>$id_ref,'status'=>0])->get('t_approval_arf_recom');
    $jml = $arfRecom->num_rows();
    if($jml > 0)
    {

    }
    else
    {
      $this->db->update('t_arf_response', ['is_done'=>1]);
    }
  }
  public function arf_response_done($switch_id=0)
  {
    /*NOT EXISTS (
            SELECT doc_no FROM t_arf_response
            WHERE doc_no = d.doc_no
        ) and*/
    $s = '';
    if($switch_id > 0)
    {
      $s = ", t_arf_recommendation_preparation.id id";
    }
    $sql = "SELECT a.*, b.jml as total, c.jml as approve, e.doc_no doc_no, e.po_no, f.title, m_company.ABBREVIATION company, e.doc_date $s
    from t_arf_response a 
    left join 
    (select count(id)jml, id_ref from t_approval_arf_recom group by id_ref) b 
    on a.id = b.id_ref
    join 
    (select count(id)jml, id_ref from t_approval_arf_recom where status = 1 group by id_ref) c 
    on a.id = c.id_ref
    left join t_arf_notification d on a.doc_no = d.doc_no
    LEFT join t_arf e on e.doc_no = d.doc_no
    LEFT JOIN t_purchase_order f on f.po_no = e.po_no
    left join t_msr on  t_msr.msr_no = f.msr_no
    left join m_company on m_company.ID_COMPANY = t_msr.id_company
    left join t_arf_recommendation_preparation on t_arf_recommendation_preparation.doc_no = e.doc_no
    where  b.jml = c.jml and f.id_vendor = ".$this->session->userdata('ID');
    $rs = $this->db->query($sql);
    return $rs;
  }
  public function greetings()
  {
    $id_user = $this->session->userdata('ID_USER');
    $rs= $this->db->query('
    SELECT DISTINCT o.id_ref,o.id_user_role,o.id_user from (
            SELECT m.id_ref,min(m.sequence) as sequence
            FROM t_approval_arf_recom m
            where m.status=0  and m.sequence < 7 group by m.id_ref
    ) n left JOIN
    t_approval_arf_recom o on o.id_ref=n.id_ref and o.sequence=n.sequence and o.status =0
    left JOIN t_arf_recommendation_preparation p on p.arf_response_id=o.id_ref
     where o.id_user= '.$id_user. ' and o.sequence < 7')->result();
    // echo $this->db->last_query();
            // exit();
            return $rs;
  }
}