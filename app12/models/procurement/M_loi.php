<?php

class M_loi extends MY_Model
{
	const module_kode = 'loi';

	protected $table = 't_letter_of_intent';

	public function __construct()
	{
		parent::__construct();
	}

	public function issue($id)
	{
		// if ($t_approval = $this->getTApprovalToBeIssued($doc_id)) {
		// 	return $this->db->set('status', 1)
		// 		->where('id', $t_approval->id)
		// 		->update('t_approval');
		// }
		$loi = $this->find($id);
		if (!$loi) {
			return false;
		}

        return $this->db->set([
            'issued'    => 1,
            'issued_on' => today_sql(),
            'issued_by' => $this->session->userdata('ID_USER')
            ])
			->where('id', $id)
			->update($this->table);
	}

	public function approve($step_id, $doc_id, $comment)
	{	
		$this->load->model('approval/M_approval');

		$post = $_POST; // backup $_POST
		unset($_POST);

		// set required data
		$_POST['id'] = $step_id;
		$_POST['data_id'] = $doc_id;
		$_POST['deskripsi'] = $comment;
        $_POST['module_kode'] = $this::module_kode;
		$_POST['status'] = 1;
        $_POST['status_str'] = '';

		$result = $this->M_approval->approve();

		unset($_POST);
		$_POST = $post; // restore $_POST

		return $result;
	}

	public function reject($step_id, $doc_id, $comment)
	{
		$this->load->model('approval/M_approval');

		$post = $_POST; // backup $_POST
		unset($_POST);
		
		// set required data
		$_POST['id'] = $step_id;
		$_POST['data_id'] = $doc_id;
		$_POST['deskripsi'] = $comment;
        $_POST['module_kode'] = $this::module_kode;
		$_POST['status'] = 2;
        $_POST['status_str'] = '';

		$result = $this->M_approval->reject();

		unset($_POST);
		$_POST = $post; // restore $_POST

		return $result;
	}

	public function toIssue($options = array())
	{
        /*
SELECT `t_letter_of_intent`.`id`,
    SUM(
    CASE
        WHEN t_approval.status = 1
            THEN 1
        ELSE 0
    END ) as sum_status,
    COUNT( t_approval.id ) count_approval
FROM `t_letter_of_intent`
JOIN `t_approval` ON `t_approval`.`data_id` = `t_letter_of_intent`.`id`
JOIN `m_approval` ON `m_approval`.`id` = `t_approval`.`m_approval_id`
WHERE `m_approval`.`module_kode` = 'loi'
AND `t_letter_of_intent`.`issued` = 0
GROUP BY t_letter_of_intent.id
HAVING sum_status = count_approval and sum_status > 0 and count_approval > 0
         */
        $this->db->select("$this->table.id")
            ->select("
                SUM(
                CASE
                    WHEN t_approval.status = 1
                        THEN 1
                    ELSE 0
                END ) as sum_status,
            ", false)
            ->select("COUNT( t_approval.id ) as count_approval", false)
            ->from($this->table)
            ->join('t_approval', "t_approval.data_id = {$this->table}.id")
            ->join('m_approval', "m_approval.id = t_approval.m_approval_id")
            ->where('m_approval.module_kode', $this::module_kode)
            ->where("$this->table.issued", 0)
            ->group_by("$this->table.id")
            ->having("sum_status > 0")
            ->having("count_approval > 0")
            ->having("sum_status >= count_approval");
        $inner_sql = $this->db->get_compiled_select();

        $this->db->reset_query();

		if (isset($options['limit'])) {
	      $this->db->limit($options['limit']);
	    }

	    if (isset($options['offset'])) {
	      $this->db->offset($options['offset']);
	    }

	    if (isset($options['orderBy'])) {
	      $this->db->order_by($options['orderBy']);
	    }

        $res = $this->db->select("source.*")
            ->from("$this->table as source")
            ->join('( '.$inner_sql.' ) as selected', 'source.id = selected.id', '', false)
			->get();

        if (isset($options['resource']) && $options['resource'] == true) {
            return $res;
        }

        return $res->result();
	}

	public function toApprove($options = array())
	{
        /* // raw SQL
         * Replace <document_table> with table used by document transaction
         * i.e: t_letter_of_intent, t_purchase_order, etc
         
        SELECT m_approval.module_kode, m_approval.role_id, m_approval.urutan, m_approval.opsi, m_approval.deskripsi, m_approval.aktif
         , t_approval.id, t_approval.data_id, t_approval.deskripsi, t_approval.urutan, t_approval.status
         , t_approval_prev.id, t_approval_prev.data_id, t_approval_prev.deskripsi, t_approval_prev.urutan, t_approval_prev.status
        FROM m_approval 
        JOIN t_approval on m_approval_id = m_approval.id
        JOIN <document_table> <dt> ON <dt>.id = t_approval.data_id
        LEFT JOIN t_approval t_approval_prev ON t_approval_prev.data_id = t_approval.data_id
            AND t_approval.urutan - 1 = t_approval_prev.urutan
        LEFT JOIN m_approval m_approval_prev ON m_approval_prev.module_kode = m_approval.module_kode
            AND m_approval_prev.id = t_approval_prev.id
        WHERE m_approval.module_kode = '<document_model>::module_kode'
            AND m_approval.role_id in (18,23,26)
            AND ( t_approval.status = 0 or t_approval.status = 2 )
            AND ( t_approval_prev.status is null or t_approval_prev.status = 1 )
        ORDER BY m_approval.module_kode, t_approval.data_id, t_approval.urutan
        */

        $m_approval = 'm_approval';
        $t_approval = 't_approval';
        $m_approval_prev = "{$m_approval}_prev";
        $t_approval_prev = "{$t_approval}_prev";

		if (isset($options['limit'])) {
	      $this->db->limit($options['limit']);
	    }

	    if (isset($options['offset'])) {
	      $this->db->offset($options['offset']);
	    }

	    if (isset($options['orderBy'])) {
	      $this->db->order_by($options['orderBy']);
	    }

		$roles_id = array_values(array_filter(explode(',', $this->session->userdata('ROLES'))));

        /* $res = $this->db->from($this->table) */
        /*     ->join('t_approval', "t_approval.data_id = {$this->table}.id") */
        /*     ->join('m_approval', "m_approval.id = t_approval.m_approval_id") */
        /*     ->where('m_approval.module_kode', $this::module_kode) */
        /*     ->or_group_start() */
        /*         ->where('t_approval.status', 0) */
        /*         ->where('t_approval.status', 2) */
        /*     ->group_end() */
        /*     //->where('t2.prior_status', 1) */
        /*     ->where_in('m_approval.role_id', $roles_id) */
        /*     ->get(); */

        $res = $this->db->select(array(
            "m_approval.module_kode",
            "m_approval.role_id",
            "m_approval.urutan",
            "m_approval.opsi",
            "m_approval.deskripsi",
            "m_approval.aktif",

            "t_approval.id",
            "t_approval.data_id",
            "t_approval.deskripsi",
            "t_approval.urutan",
            "t_approval.status",

            "t_approval_prev.id as id_prev",
            "t_approval_prev.data_id as data_id_prev",
            "t_approval_prev.deskripsi as deskripsi_prev",
            "t_approval_prev.urutan as urutan_prev",
            "t_approval_prev.status as status_prev",

            "{$this->table}.*"

        ))
        ->from($m_approval)
        ->join($t_approval, "$t_approval.m_approval_id = $m_approval.id")
        ->join($this->table, "{$this->table}.id = $t_approval.data_id") 
        ->join($t_approval." as ".$t_approval_prev, "$t_approval_prev.data_id = $t_approval.data_id"
            ." AND ($t_approval.urutan - 1) = $t_approval_prev.urutan", 'left', NULL)
        ->join($m_approval." as ".$m_approval_prev, "$m_approval_prev.module_kode = $m_approval.module_kode"
            ." AND $m_approval_prev.id = $t_approval_prev.id", 'left')
        ->where("$m_approval.module_kode", $this::module_kode)
        ->where_in("$m_approval.role_id", $roles_id)
        ->group_start()
            ->where("$t_approval.status", 0)
            ->or_where("$t_approval.status", 2)
        ->group_end()
        ->group_start()
            ->where("$t_approval_prev.status", NULL, false)
            ->or_where("$t_approval_prev.status", 1)
        ->group_end()
        ->get();

        if (isset($options['resource']) && $options['resource'] == true) {
            return $res;
        }

        return $res->result();
	} 

	public function accept($id)
	{
        return $this->db->set([
            'accepted'    => 1,
            'accepted_on' => today_sql(),
            'accepted_by' => $this->session->userdata('ID')
            ])
			->where('id', $id)
			->update($this->table);
	}

    public function accepted($id = null, $options = array())
    {
        $m_vendor = 'm_vendor';

        $this->db->from($this->table);

		if (isset($options['limit'])) {
	      $this->db->limit($options['limit']);
	    }

	    if (isset($options['offset'])) {
	      $this->db->offset($options['offset']);
	    }

	    if (isset($options['orderBy'])) {
	      $this->db->order_by($options['orderBy']);
	    }

        $this->db->select([
            "{$this->table}.*",
            "{$m_vendor}.NAMA nama_vendor",
            ])
            ->join($m_vendor, "$m_vendor.ID = {$this->table}.awarder_id", 'left')
            ->join('t_assignment','t_assignment.msr_no = '.$this->table.'.msr_no','left');

        $this->whereAccepted();
        $this->db->where('t_assignment.user_id',$this->session->userdata('ID_USER'));
        if ($id) {
            $this->db->where("{$this->table}.id", $id);
        }
            
        $res = $this->db->get();

        if (isset($options['resource']) && $options['resource'] == true) {
            return $res;
        }

        return $res->result();
        
    }

    public function findByBlDetailId($id)
    {
        return @$this->db->where('bl_detail_id', $id)->get($this->table)->result()[0];
    }

    public function canCreateFromBlDetail($bl_detail_id)
    {
        $this->load->model("approval/M_bl");

        $awarder = $this->M_bl->awarder($bl_detail_id)[0];

        return $awarder->bled_detail_id != '' && !$awarder->po_id && $awarder->loi_id == '';
    }

    public function whereIssued()
    {
        $this->db->where("{$this->table}.issued", 1);
    }

    public function whereAccepted()
    {
        $this->db->where("{$this->table}.accepted", 1);
    }

    public function getIssuedByVendor($vendor_id, $options = array())
    {
        $m_vendor = 'm_vendor';

        $this->db->from($this->table)
            ->join($m_vendor, "$m_vendor.ID = {$this->table}.awarder_id", 'left')
            ->where("{$this->table}.awarder_id", $vendor_id);

        $this->whereIssued();

		if (isset($options['limit'])) {
	      $this->db->limit($options['limit']);
	    }

	    if (isset($options['offset'])) {
	      $this->db->offset($options['offset']);
	    }

	    if (isset($options['orderBy'])) {
	      $this->db->order_by($options['orderBy']);
	    }
    
        $res = $this->db->get();

        if (isset($options['resource']) && $options['resource'] == true) {
            return $res;
        }

        return $res->result();
    }

    public function inquiry($params = array())
    {

        $m_vendor = 'm_vendor';

        $this->db->from($this->table);

		if (isset($params['limit'])) {
	      $this->db->limit($params['limit']);
	    }

	    if (isset($params['offset'])) {
	      $this->db->offset($params['offset']);
	    }

	    if (isset($params['orderBy'])) {
	      $this->db->order_by($params['orderBy']);
        } else {
	      $this->db->order_by('rfq_no DESC');
        }

        $this->db->select([
            "{$this->table}.*",
            "{$m_vendor}.NAMA nama_vendor",
            ])
            ->join($m_vendor, "$m_vendor.ID = {$this->table}.awarder_id", 'left');
            
        $res = $this->db->get();

        if (isset($params['resource']) && $params['resource'] == true) {
            return $res;
        }

        return $res->result();
    }

	// protected function getTApprovalToBeIssued($doc_id)
	// {
	// 	if (! ( $m_approval = $this->getMApprovalToBeIssued()) {
	// 		return false;
	// 	}

	// 	return @$this->db->where('data_id', $doc_id)
	// 		->where('m_approval_id', $m_approval->id)
	// 		->where('status != 1') // Not issued yet. Any other condition ?
	// 		->get('t_approval')
	// 		->result()[0];
	// }

	// protected function getMApprovalToBeIssued()
	// {
	// 	return @$this->db->where('module_kode', $this::module_kode)
	// 		->where('opsi', 'bl-ed')
	// 		->get('m_approval')
	// 		->result()[0];
	// }
}
