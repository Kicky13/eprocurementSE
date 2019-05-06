<?php if (!defined('BASEPATH')) exit('Anda tidak masuk dengan benar');

class M_ed extends CI_Model {

  public function __construct() {
      parent::__construct();
      $this->db = $this->load->database('default', true);
      $this->tb 	= 't_eq_data';
  }

  public function bod_contract_review_list()
  {
    /*ambil all data yg award*/
    $sql = "select t_sop_bid.*,t_sop.qty1,t_sop.qty2 
    from t_sop_bid 
    left join t_sop on t_sop.id = t_sop_bid.sop_id
    where t_sop_bid.award = 1";
    $q = $this->db->query($sql);

    /*kumpulin msr dan jumlahnya*/
    $data = [];
    if($q->num_rows() > 0)
    {
      foreach ($q->result() as $r) {
        $price = $r->nego_price > 0 ? $r->nego_price : $r->unit_price;
        if($r->qty2 > 0)
        {
          $newPrice = $price*$r->qty1*$r->qty2;
        }
        else
        {
          $newPrice = $price*$r->qty1;
        }

        @$data[$r->msr_no] += $newPrice;
      }
    }
    if($this->input->get('debug'))
    {
      echo "<pre>";
      echo "kumpulin msr dan jumlahnya";
      echo "<br>";
      print_r($data);
    }
    /*kumpulin yang lebih dari 100000*/
    $msr_bod = [];
    if(count($data) > 0)
    {
      foreach ($data as $msr_no => $price) {
        if($price >= 100000)
        {
          $msr_bod[$msr_no] = $price;
        }
      }
    }
    if($this->input->get('debug'))
    {
      echo "kumpulin yang lebih dari 100000";
      echo "<br>";
      print_r($msr_bod);
    }
    /*switch no msr aja*/
    $msr_verify = [];
    if(count($msr_bod) > 0)
    {
      $msr_key = [];
      foreach ($msr_bod as $key => $value) {
        $msr_key[] = "'$key'";
      }
      
      $implode = implode(',', $msr_key);

      /*echo "cek no msr nya yang bod = 0";*/
      $sql = "select t_approval.data_id 
      from t_approval 
      left join m_approval on m_approval.id = t_approval.m_approval_id
      where m_approval.module_kode = 'award' 
      and m_approval.opsi in ('ceo', 'coo', 'cfo') 
      and t_approval.status = 0
      and data_id in ($implode)";
      $msr_bod_0 = $this->db->query($sql);

      $msr_bod_0_msr = [];
      foreach ($msr_bod_0->result() as $r) {
        $msr_bod_0_msr[$r->data_id] = $r->data_id;
      }


      if($this->input->get('debug'))
      {
        echo "cek no msr nya yang bod = 0";
        echo "<br>";
        echo $sql;
        echo "<br>";
        print_r($msr_bod_0->result());
      }
      /*select yang semua yang belum lengkap approvalnya pada array msr yang udah dikumpulin*/
      $sql = "select t_approval.* 
      from t_approval 
      left join m_approval on m_approval.id = t_approval.m_approval_id
      where m_approval.module_kode = 'award' 
      and t_approval.status in (0,2)
      and m_approval.opsi not in ('ceo', 'coo', 'cfo') 
      and data_id in ($sql)";
      $rs = $this->db->query($sql);

      if($this->input->get('debug'))
      {
        echo "select yang semua yang belum lengkap approvalnya pada array msr yang udah dikumpulin";
        echo "<br>";
        echo $this->db->last_query();
        echo "<br>";
        print_r($rs->result());
      }

      if($rs->num_rows() > 0)
      {
        $msr_not_bod_0_msr = [];
        foreach ($rs->result() as $r) {
          $msr_not_bod_0_msr[$r->data_id] = $r->data_id;
        }

        $s = [];
        foreach ($msr_bod_0_msr as $r) {
          if(in_array($r, $msr_not_bod_0_msr))
          {
            // $a[$r->data_id] = $r->data_id;
          }
          else
          {
            $s[$r] = $r;
          }
        }
        return $s;
      }
      else
      {
        return $msr_bod_0_msr;
      }
    }
    return $msr_verify;
  }
  public function eq_data($field='t_eq_data.*')
  {
    return $this->db->select($field)
    ->from($this->tb)
    ->join('t_msr', 't_msr.msr_no = t_eq_data.msr_no', 'left');
  }
}
