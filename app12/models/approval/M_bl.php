<?php if (!defined('BASEPATH')) exit('Anda tidak masuk dengan benar');

class M_bl extends CI_Model {

  public function __construct() {
      parent::__construct();
      $this->db = $this->load->database('default', true);
      $this->tbmsr 	= 't_msr';
      $this->tbmi 	= 't_msr_item';
      $this->tbl 	  = 't_bl';
      $this->tbld 	= 't_bl_detail';
      $this->tbeq 	= 't_eq_data';
      $this->tbv 	  = 'm_vendor';
      $this->tbdd 	= 't_bid_detail';
      $this->tbloi  = 't_letter_of_intent';
      $this->tbpo   = 't_purchase_order';
      $this->tbtapp = 't_approval';
      $this->tsop   = 't_sop';
      $this->mc     = 'm_currency';
      $this->mdt     = 'm_deliveryterm';
      $this->mdp     = 'm_deliverypoint';
      $this->msrinv     = 'm_msr_inventory_type';
  }
  public function getEdFromMsr($msr_no='')
  {
    return $this->db->select($this->tbeq.'.*,'.$this->mdt.'.DELIVERYTERM_DESC,'.$this->mdp.'.DPOINT_DESC')
    ->join($this->mdt, $this->mdt.'.ID_DELIVERYTERM = '.$this->tbeq.'.incoterm', 'left')
    ->join($this->mdp, $this->mdp.'.ID_DPOINT = '.$this->tbeq.'.delivery_point', 'left')
    ->where([$this->tbeq.'.msr_no' => $msr_no])
    ->get($this->tbeq);
  }
 	public function tbld($msr_no='')
	{
		$this->db->select('*');
		$this->db->where([$this->tbl.'.msr_no'=>$msr_no]);
		$this->db->join($this->tbv, $this->tbv.'.ID = '.$this->tbld.'.vendor_id');
		$this->db->join($this->tbl, $this->tbl.'.msr_no = '.$this->tbld.'.msr_no');
    $s = $this->uri->rsegment(3);
    if($s == 'nego')
    {
      $id = $this->session->ID;
      $this->db->where(['vendor_id'=>$id]);
    }

		$c = $this->db->get($this->tbld);
    // echo $this->db->last_query();
    return $c;
  }
  public function tbld_isi($msr_no='')
  {
  	$this->db->select('*');
		$this->db->where([$this->tbl.'.msr_no'=>$msr_no]);
		$this->db->join($this->tbv, $this->tbv.'.ID = '.$this->tbld.'.vendor_id');
		$this->db->join($this->tbl, $this->tbl.'.msr_no = '.$this->tbld.'.msr_no');
		$this->db->join($this->tbdd, $this->tbdd.'.bled_no = '.$this->tbl.'.bled_no');
		$this->db->join($this->tbmi, $this->tbmi.'.line_item = '.$this->tbdd.'.msr_detail_id');
		return $this->db->get($this->tbld);
  }
  public function tbmi($msr_no='')
  {
    $s = $this->uri->rsegment(3);
    $join = '';
    $where = '';
    /*if($s == 'nego')
    {
      $id = $this->session->ID;
      $join .= 'JOIN t_bid_detail b ON b.bled_no=a.bled_no AND t_bid_detail.msr_detail_id = t_msr_item.line_item';
      $where = 'and b.created_by = "'.$id.'" and b.nego=1';
    }
    $s = $this->db->query('select * from '.$this->tbmi.' a '.$join.' WHERE a.msr_no="'.$msr_no.'" '.$where.' ');*/

    // original
    $this->db->select($this->tbmi.'.*,'.$this->tbl.'.*, currency.CURRENCY as currency, t_msr.id_currency_base, currency_base.CURRENCY as currency_base');
    $this->db->where([$this->tbmi.'.msr_no'=>$msr_no]);
    $this->db->join($this->tbl, $this->tbl.'.msr_no = '.$this->tbmi.'.msr_no');
    $this->db->join($this->tbmsr, $this->tbmsr.'.msr_no='.$this->tbmi.'.msr_no');
    $this->db->join($this->mc.' currency', 'currency.ID = '.$this->tbmsr.'.id_currency');
    $this->db->join($this->mc.' currency_base', 'currency_base.ID = '.$this->tbmsr.'.id_currency_base');

    $s = $this->uri->rsegment(3);
    $join = '';
    $where = '';
    if($s == 'nego')
    {
      $id = $this->session->ID;
      $join .= 'JOIN t_bid_detail b ON b.bled_no=a.bled_no AND and t_bid_detail.msr_detail_id = t_msr_item.line_item';
      $where = 'and b.created_by = "'.$id.'" and b.nego=1';
    }
    $s = $this->db->get($this->tbmi);
    // echo $this->db->last_query();
    // print_r($s->result());
    return $s;
  }
  public function tbmi2($msr_no='')
  {
    $s = $this->uri->rsegment(3);
    $join = '';
    $where = '';
    /*if($s == 'nego')
    {
      $id = $this->session->ID;
      $join .= 'JOIN t_bid_detail b ON b.bled_no=a.bled_no AND t_bid_detail.msr_detail_id = t_msr_item.line_item';
      $where = 'and b.created_by = "'.$id.'" and b.nego=1';
    }
    $s = $this->db->query('select * from '.$this->tbmi.' a '.$join.' WHERE a.msr_no="'.$msr_no.'" '.$where.' ');*/

    // original
    $this->db->where([$this->tbmi.'.msr_no'=>$msr_no]);
    // $this->db->join($this->tbl, $this->tbl.'.msr_no = '.$this->tbmi.'.msr_no');
    $s = $this->uri->rsegment(3);
    if($s == 'nego')
    {
      $id = $this->session->ID;
      $this->db->select($this->tbmi.'.*, '.$this->tbdd.'.*, m_material_uom.DESCRIPTION as uom_desc');
      $this->db->join($this->tbdd, $this->tbdd.'.bled_no = '.$this->tbl.'.bled_no and t_bid_detail.msr_detail_id = t_msr_item.line_item');
      $this->db->where([$this->tbdd.'.created_by'=>$id,'nego'=>1]);
    } else {
      $this->db->select($this->tbmi.'.*, m_material_uom.DESCRIPTION as uom_desc');
    }
    $this->db->join('m_material_uom', 'm_material_uom.MATERIAL_UOM = t_msr_item.uom');
    $s = $this->db->get($this->tbmi);
    // print_r($qq);
    // die;
    return $s;
  }
  public function priceVendorByItem($line_item, $vendor_id, $bled_no)
  {
  	$this->db->select('*, currency.CURRENCY as currency, currency_base.CURRENCY as currency_base');
    $this->db->where(['line_item'=>$line_item, 't_bid_detail.created_by'=>$vendor_id, $this->tbdd.'.bled_no'=>$bled_no]);
    $this->db->join($this->tbv, $this->tbv.'.ID = '.$this->tbld.'.vendor_id');
    $this->db->join($this->tbl, $this->tbl.'.msr_no = '.$this->tbld.'.msr_no');
    $this->db->join($this->tbdd, $this->tbdd.'.bled_no = '.$this->tbl.'.bled_no');
    $this->db->join($this->tbmi, $this->tbmi.'.line_item = '.$this->tbdd.'.msr_detail_id');
    $this->db->join($this->mc.' currency', $this->tbdd.'.id_currency = currency.ID');
    $this->db->join($this->mc.' currency_base', $this->tbdd.'.id_currency_base = currency_base.ID');
    $x = $this->db->get($this->tbld);
    // echo $this->db->last_query();
    return $x;
  }

  public function getVendorPass($msr_no)
  {
    $this->db->select('*');
    $this->db->where(['msr_no'=>$msr_no, 'administrative'=>1, 'technical'=>1]);
    $this->db->join($this->tbv, $this->tbv.'.ID = '.$this->tbld.'.vendor_id');
    return $this->db->get($this->tbld);
  }
  public function issued_nego($data)
  {
    $this->db->where(['created_by'=>$data['vendor_id']]);
    if(isset($data['msr_detail_id']))
      $this->db->where(['msr_detail_id'=>$data['msr_detail_id']]);

    $this->db->update($this->tbdd, ['nego'=>$data['nego'], 'nego_date'=>date("Y-m-d")]);
  }
  public function getItemByMsr($msr_no='')
  {
    return $this->db->where(['msr_no'=>$msr_no])->get($this->tbmi);
  }
  public function getBledNoNego($value='')
  {
      $sql = "SELECT COUNT(*) jml, bled_no jml from t_bid_detail GROUP BY bled_no";
      $rs = $this->db->query($sql);
      $data = [];
      foreach ($rs->result() as $r) {
          $sql = "SELECT count(*) jml from t_bid_detail WHERE bled_no = '$r->bled_no' and nego = 2";
          $result = $this->db->query($sql);
          if($result->num_rows() > 0)
          {
              $data[] = ['bled_no'=>$r->bled_no];
          }
      }
      return $data;
  }
  public function update_eq_data()
  {
    $this->db->trans_begin();
    $data = $this->input->post();
    $this->db->where(['id'=>$data['id']]);
    unset($data['id']);
    $this->db->update($this->tbeq, $data);

    if($this->db->trans_status() === true)
    {
        $this->db->trans_commit();
        echo 'Success Submited';
    }
    else
    {
        $this->db->trans_rollback();
        echo 'Fail, Try Again';
    }
  }
  public function getEdFromBled($bled_no='')
  {
    return $this->db->select($this->tbeq.'.*')
    ->join($this->tbeq, 't_eq_data.msr_no = t_bl.msr_no')
    ->where(['bled_no'=>$bled_no])
    ->get($this->tbl);
  }
  public function getPar()
  {
    return $this->db->where(['award'=>1])->get('t_eq_data');
  }
  public function getVendorNoNego($value='')
  {
    return $this->db->select($this->tbeq.'.*')
    ->join($this->tbeq, 't_eq_data.msr_no = t_bl.msr_no')
    ->where(['award'=>1])
    ->get($this->tbl);
  }

  public function awarders($bl_detail_id = null, $options = array())
  {
    $id = $this->session->userdata('ID_USER');
    $this->db->select([
      "{$this->tbl}.*",
      "{$this->tbld}.*",
      "{$this->tbld}.id bled_detail_id",
      "{$this->tbmsr}.id_company",
      "{$this->tbmsr}.company_desc",
      "{$this->tbmsr}.total_amount",
      "{$this->tbmsr}.id_msr_type",
      "{$this->tbpo}.id po_id",
      "{$this->tbloi}.id loi_id",
      ])
      ->from($this->tbl)
      ->join($this->tbld, "{$this->tbld}.msr_no = {$this->tbl}.msr_no")
      ->join($this->tbmsr, "{$this->tbmsr}.msr_no = {$this->tbl}.msr_no")
      ->join($this->tbeq, "{$this->tbeq}.msr_no = {$this->tbl}.msr_no")
      ->join($this->tbloi, "{$this->tbloi}.bl_detail_id = {$this->tbld}.id", 'left')
      ->join($this->tbpo, "{$this->tbpo}.bl_detail_id = {$this->tbld}.id and t_msr.msr_no = t_purchase_order.msr_no", 'left')

      // awarder flag
      ->where("{$this->tbeq}.award", 9)
      ->where("{$this->tbld}.awarder", 1)
      ->where("{$this->tbld}.commercial", 1)
      ->where("{$this->tbeq}.created_by", $id)

      // ->where("{$this->tbld}.accept_award", 1)
      ->where("{$this->tbpo}.id IS NULL")
      ;

    if ($bl_detail_id != null) {
        $this->db->where("{$this->tbld}.id", $bl_detail_id);
    }

    if (isset($options['limit'])) {
      $this->db->limit($options['limit']);
    }

    if (isset($options['offset'])) {
      $this->db->offset($options['offset']);
    }

    if (isset($options['orderBy'])) {
      $this->db->order_by($options['orderBy']);
    }

    if (isset($options['resource']) && $options['resource'] == true) {
        return $this->db->get();
    }

    return $this->db->get()->result();
  }

  public function getBlByBlDetailId($bl_detail_id)
  {
    $this->db->select([
        "{$this->tbl}.*",
        "{$this->tbmsr}.*",
        "COALESCE({$this->tbl}.title, {$this->tbeq}.subject) title",
        "{$this->tbeq}.incoterm",
        "t_bid_head.duration",
        "t_bid_head.delivery_month",
        "t_bid_head.delivery_week",
        "t_bid_head.delivery_nilai",
        "t_bid_head.delivery_satuan",
        "t_bid_head.id_local_content_type as tkdn_type",
        "if (t_bid_head.id_local_content_type = 1, t_bid_head.local_content, '') as tkdn_value_goods",
        "if (t_bid_head.id_local_content_type = 2, t_bid_head.local_content, '') as tkdn_value_service",
        "if (t_bid_head.id_local_content_type = 3, t_bid_head.local_content, '') as tkdn_value_combination",
        "{$this->tbld}.vendor_id"
    ])
    // $this->db->join($this->tbv, $this->tbv.'.ID = '.$this->tbld.'.vendor_id');
        ->join($this->tbl, $this->tbl.'.msr_no = '.$this->tbld.'.msr_no')
        ->join('t_bid_head', "t_bid_head.created_by = {$this->tbld}.vendor_id
            AND t_bid_head.bled_no = {$this->tbl}.bled_no", 'left')
        ->join($this->tbeq, "{$this->tbeq}.msr_no = {$this->tbld}.msr_no")
        ->join($this->tbmsr, $this->tbmsr.'.msr_no = '.$this->tbl.'.msr_no')
        ->where("{$this->tbld}.id", $bl_detail_id);


    return @$this->db->get($this->tbld)->row();
  }

  public function getAwarderById($id)
  {
    $this->db->select("{$this->tbld}.*, {$this->tbv}.*")
      ->from($this->tbld)
      ->join($this->tbl, $this->tbl.'.msr_no = '.$this->tbld.'.msr_no')
      ->join($this->tbv, $this->tbv.'.ID = '.$this->tbld.'.vendor_id')
      ->where("{$this->tbld}.id", $id)
      ->where("{$this->tbld}.awarder", 1)
      ->where("{$this->tbld}.commercial", 1);

    return @$this->db->get()->result()[0];
  }
  public function issuednego($data='')
  {
    $this->db->trans_begin();
    $t_bl = $this->db->where(['msr_no'=>$data['msr_no']])->get('t_bl')->row();
    $bled_no = $t_bl->bled_no;

    $this->db->where(['bled_no'=>$bled_no]);
    $this->db->update('t_bid_detail',['nego'=>2,'nego_date'=>date("Y-m-d")]);

    $this->db->where(['bled_no'=>$bled_no]);
    $this->db->update('t_bid_head',['issued_nego'=>1]);

    if($this->db->trans_status() === true)
    {
        $this->db->trans_commit();
        echo 'Success Submited';
    }
    else
    {
        $this->db->trans_rollback();
        echo 'Fail, Try Again';
    }
  }
  public function getBidderPass($msr_no='')
  {
    $this->db->select('*');
    $this->db->where([$this->tbl.'.msr_no'=>$msr_no, $this->tbld.'.confirmed'=>1, $this->tbld.'.administrative'=>1, $this->tbld.'.technical'=>1, $this->tbld.'.commercial'=>1]);
    $this->db->join($this->tbv, $this->tbv.'.ID = '.$this->tbld.'.vendor_id');
    $this->db->join($this->tbl, $this->tbl.'.msr_no = '.$this->tbld.'.msr_no');
    return $this->db->get($this->tbld);
  }
  public function bidDetailByBled($bled_no='')
  {
    $sql = "SELECT t_bid_detail.created_by as vendor_id, sum((unit_price*qty)) price_total
      FROM t_bl
      left join t_bid_detail on t_bl.bled_no = t_bid_detail.bled_no
      left join t_msr_item on t_msr_item.msr_no = t_bl.msr_no and msr_detail_id = line_item
      WHERE t_bl.bled_no = '$bled_no'
      GROUP BY t_bid_detail.created_by";
    return $this->db->query($sql);
  }
  public function withdraw()
  {
    $this->db->trans_begin();

    $msr_no = $this->input->post('msr_no');
    $msr_no = $this->input->post('msr_no');
    $vendor_id = $id = $this->session->userdata('ID');
    $this->db->where(['msr_no'=>$msr_no, 'vendor_id'=>$vendor_id]);
    $this->db->update('t_bl_detail', ['confirmed'=>3]);
    if($this->db->trans_status() === true)
    {
        $this->db->trans_commit();
        // echo 'Success Submited';
        return true;
    }
    else
    {
        $this->db->trans_rollback();
        // echo 'Fail, Try Again';
        return false;
    }
  }
  public function sop_store($value = '') {
    $this->db->trans_begin();
    $id = $this->input->post('id');
    $d = array(
            'msr_item_id' => $this->input->post('msr_item_id'),
            'msr_no' => $this->input->post('msr_no'),
            'sop_type' => $this->input->post('sop_type'),
            'item_material_id' => $this->input->post('item-material_id'),
            'item_semic_no_value' => $this->input->post('item-semic_no_value'),
            'item' => $this->input->post('item'),
            'id_itemtype' => $this->input->post('item-item_type'),
            'id_itemtype_category' => $this->input->post('item-itemtype_category'),
            'groupcat' => $this->input->post('item-group_value'),
            'groupcat_desc' => $this->input->post('item-group_name'),
            'sub_groupcat' => $this->input->post('item-subgroup_value'),
            'sub_groupcat_desc' => $this->input->post('item-subgroup_name'),
            'inv_type' => ($this->input->post('item-inventory_type') ? $this->input->post('item-inventory_type') : 0),
            'item_modification' => ($this->input->post('item-item_modification') ? $this->input->post('item-item_modification') : 0),
            'id_costcenter' => $this->input->post('item-cost_center'),
            'costcenter_desc' => $this->input->post('item-cost_center_name'),
            'id_accsub' => $this->input->post('item-account_subsidiary'),
            'accsub_desc' => $this->input->post('item-account_subsidiary_name'),
            'qty1' => $this->input->post('qty1'),
            'uom1' => $this->input->post('uom1'),
            'qty2' => ($this->input->post('qty2') ? $this->input->post('qty2') : 0),
            'uom2' => $this->input->post('uom2'),
            'tax' => 0,
            'created_by' => $this->session->userdata('ID_USER'),
            'created_at' => date('Y-m-d H:i:s'),
    );
    /*check msr*/
    $this->db->where(['msr_no' => $d['msr_no']]);
    if ($d['qty1'] == 0 || $d['qty1'] == '' || $d['uom1'] == '') {
      echo json_encode(['msg'=>'Item, QTY 1, UOM 1 is Required']);
      return false;
    }
    if ($d['sop_type'] == 2 && $d['uom2'] != null && $d['qty2'] <= 0) {
      echo json_encode(['msg'=>'Type 2 qty > 0 ? UOM 2 Must be Filled ']);
      // $this->db->trans_rollback();
      return false;
    }
    if ($id > 0) {
      $all = $this->db->get($this->tsop)->num_rows();
      /*check msr*/
      $this->db->where(['msr_no' => $d['msr_no']]);
      $this->db->where(['sop_type'=>$d['sop_type']]);
      $this->db->where_not_in('id', $id);
      $c = $this->db->get($this->tsop);
      if ($c->num_rows() > 0 || $all == 1) {
        $this->db->where(['id'=>$id]);
        $this->db->update($this->tsop, $d);
      } else {
        echo json_encode(['msg'=>'Fail, Data type different from before!']);
        return false;
      }
    } else {
      /*check msr*/
      $c = $this->db->get($this->tsop);
      if ($c->num_rows() > 0) {
        $r = $c->row();
        if($r->sop_type == $d['sop_type']) {
          $this->db->insert($this->tsop, $d);
        } else {
          echo json_encode(['msg'=>'Fail, Data type different from before!']);
          return false;
        }
      } else {
        $this->db->insert($this->tsop, $d);
      }
    }
    if ($this->db->trans_status() === true) {
        $this->db->trans_commit();
        echo json_encode(['msg'=>'Success','status'=>true]);
        return true;
    } else {
        $this->db->trans_rollback();
        echo json_encode(['msg'=>'Fail, Try Again']);
        return false;
    }
  }
  public function sop_get($where='',$msrItemList='')
  {
    $this->db->select($this->tsop.'.*,'.$this->tbmi.'.description,m_currency.CURRENCY currency,t_msr_item.id_itemtype msr_id_itemtype,IFNULL('.$this->msrinv.'.description,\'\') as inv_desc, uom1.DESCRIPTION as uom1_desc, uom2.DESCRIPTION as uom2_desc');
    $this->db->join($this->tbmi, $this->tbmi.'.line_item = '.$this->tsop.'.msr_item_id', 'left');
    $this->db->join($this->tbeq, 't_eq_data.msr_no=t_sop.msr_no', 'left');
    $this->db->join($this->msrinv, 't_sop.inv_type=m_msr_inventory_type.id', 'left');
    $this->db->join('m_material_uom uom1', 'uom1.MATERIAL_UOM = t_sop.uom1', 'left');
    $this->db->join('m_material_uom uom2', 'uom2.MATERIAL_UOM = t_sop.uom2', 'left');
    $this->db->join('m_currency', 'm_currency.ID=t_eq_data.currency', 'left');
    if(is_array($where))
    {
      $this->db->where($where);
    }
    if(is_array($msrItemList))
    {
      $this->db->where_in('t_sop.msr_item_id',$msrItemList);
    }
    $sop = $this->db->get($this->tsop);
    return $sop;
  }
  public function getEd($msr_no='')
  {
    return $this->db->where(['msr_no'=>$msr_no])->get($this->tbeq);
  }
  public function getMc($value='')
  {
    if($value)
    {
      $this->db->where(['ID'=>$value]);
    }
    return $this->db->get($this->mc);
    # code...mc
  }
  public function sop_delete($value='')
  {
    $this->db->trans_begin();
    $this->db->where(['id'=>$value]);
    $this->db->delete($this->tsop);
    if($this->db->trans_status() === true)
    {
        $this->db->trans_commit();
        echo json_encode(['msg'=>'Success']);
        return true;
    }
    else
    {
        $this->db->trans_rollback();
        echo json_encode(['msg'=>'Fail, Try Again']);
        return false;
    }
  }
  public function getBlBy()
  {
    return $this->db->get($this->tbl);
  }
  public function getSopValidation($msr_no)
  {
    $sql = "select msr_item_id from t_sop where msr_no = '$msr_no' group by msr_item_id";
    return $this->db->query($sql);
  }
  public function getTbmsr($msr_no='')
  {
    return $this->db->where(['msr_no'=>$msr_no])->get($this->tbmsr);
  }

  public function sop_copy($value = '') {
    $id = $this->input->post('id');
    $msr_no = $this->input->post('msr_no');
    $m = $this->db->where(['line_item'=>$id])->get($this->tbmi)->row();
    $data['msr_item_id'] = $id;
    $data['msr_no'] = $msr_no;
    $c = $this->db->select('id, sop_type')->where(['msr_no' => $msr_no])->get($this->tsop)->result();
    if (count($c) == 0) {
      $data['sop_type'] = 1;
    } else {
      $data['sop_type'] = $c[0]->sop_type;
    }
    $data['item_material_id'] = $m->material_id;
    $data['item_semic_no_value'] = $m->semic_no;
    $data['item'] = $m->description;
    $data['id_itemtype'] = $m->id_itemtype;
    if ($m->id_itemtype_category == null) {
      if (substr_count($m->semic_no, '.') > 1) {
        $data['id_itemtype_category'] = 'SEMIC';
      } else {
        $type_cat = $this->db->select('TYPE')->where(['ID'=>$m->material_id])->get('m_material_group')->row();
        if ($type_cat->TYPE === 'SERVICE')
          $data['id_itemtype_category'] = 'WORKS';
        else if ($type_cat->TYPE === 'GOODS')
          $data['id_itemtype_category'] = 'MATGROUP';
        else if ($type_cat->TYPE === 'CONSULTATION')
          $data['id_itemtype_category'] = 'CONSULTATION';
        else
          $data['id_itemtype_category'] = 'ERR';
      }
    } else {
      $data['id_itemtype_category'] = $m->id_itemtype_category;
    }
    $data['groupcat'] = $m->groupcat;
    $data['groupcat_desc'] = $m->groupcat_desc;
    $data['sub_groupcat'] = $m->sub_groupcat;
    $data['sub_groupcat_desc'] = $m->sub_groupcat_desc;
    $data['inv_type'] = $m->inv_type;
    $data['item_modification'] = $m->item_modification;
    $data['id_costcenter'] = $m->id_costcenter;
    $data['costcenter_desc'] = $m->costcenter_desc;
    $data['id_accsub'] = $m->id_accsub;
    $data['accsub_desc'] = $m->accsub_desc;
    $data['qty1'] = $m->qty;
    $data['uom1'] = $m->uom;
    $this->db->insert($this->tsop, $data);
    echo json_encode(['msg'=>'Success','status'=>true]);
  }

  public function time_approval_ed($msr_no='')
  {
    $t_approval = $this->db->where(['data_id'=>$msr_no, 'm_approval_id'=>13, 'status'=>5])->get('t_approval');
    $num_rows = $t_approval->num_rows();
    if($num_rows > 0)
    {
      return true;
    }
    else
    {
      return false;
    }
  }

  public function getAssignmentAgreement($id_user='')
  {

    $msr_no = [];
    foreach ($this->ed_list($id_user)->result() as $key => $value) {
      $msr_no[$value->msr_no] = $value->msr_no;
    }

    $t_purchase_order = 0;
    if(count($msr_no) > 0)
    {
      $t_purchase_order = $this->db->where_in('msr_no',$msr_no)->where(['issued'=>1])->get('t_purchase_order')->num_rows();
//        $t_purchase_order = $this->db->where(['t_assignment.user_id'=>$id_user])->get('t_assignment')->num_rows();
    }
    $hitung = count($msr_no) - $t_purchase_order;
    return $hitung;
  }
  public function ed_list($id_user='')
  {
    $this->db->where(['t_assignment.user_id'=>$id_user]);
    $eds = $this->db->select("t_eq_data.*,replace(t_eq_data.msr_no,'OR','OQ') ed_no, m_departement.DEPARTMENT_DESC as department, specialist.NAME as specialist, (CASE WHEN approval.approval_posisition IS NULL THEN 'Completed' ELSE approval.approval_posisition END) as approval_posisition")
        ->join('t_msr', 't_msr.msr_no = t_eq_data.msr_no', 'left')
        ->join('m_user', 'm_user.ID_USER = t_msr.create_by', 'left')
        ->join('m_departement', 'm_departement.ID_DEPARTMENT = m_user.ID_DEPARTMENT', 'left')
        ->join('t_assignment', 't_assignment.msr_no = t_msr.msr_no', 'left')
        ->join('m_user as specialist', 'specialist.ID_USER = t_assignment.user_id', 'left')
        ->join('(
            SELECT t_approval.*, m_user_roles.DESCRIPTION as approval_posisition FROM
            (
                SELECT
                    data_id,
                    MIN(t_approval.urutan) as urutan
                FROM t_approval
                JOIN m_approval ON m_approval.id = t_approval.m_approval_id
                WHERE m_approval.module_kode = \'msr_spa\'
                AND (t_approval.status = 0 OR t_approval.status = 2)
                GROUP BY data_id
            ) as approval
            JOIN (
                SELECT
                    t_approval.*, m_approval.module_kode, m_approval.role_id
                FROM t_approval
                JOIN m_approval ON m_approval.id = t_approval.m_approval_id
                WHERE m_approval.module_kode = \'msr_spa\'
            ) t_approval ON t_approval.data_id = approval.data_id AND t_approval.urutan = approval.urutan
            JOIN m_user_roles ON m_user_roles.ID_USER_ROLES = t_approval.role_id
        ) approval', 'approval.data_id = t_eq_data.msr_no', 'left')
         ->where_in('t_msr.status', [0,1])
        ->order_by('msr_no','desc')->get('(select * from t_eq_data where status = 1) t_eq_data');
        return $eds;
  }
  public function getMsrAssignment($id_user='')
  {
    return $this->db->select('t_msr.*')
    ->join('t_assignment','t_assignment.msr_no=t_msr.msr_no','left')
    ->where(['t_assignment.user_id'=>$id_user])
	->where('t_msr.msr_no not in (select msr_no from t_purchase_order where issued = 1)')
    ->get('t_msr');
  }
}
