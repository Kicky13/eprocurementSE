<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_purchase_order extends MY_Model {
    const module_kode = 'po';

    protected $table = 't_purchase_order';
    protected $loi = 't_letter_of_intent';
    protected $t_approval = 't_approval';
    protected $m_approval = 'm_approval';
    protected $m_vendor = 'm_vendor';

    public function __construct()
    {
        parent::__construct();
    }

    public function all()
    {
        return $this->db->get($this->table)->result();
    }

    public function getLastDocNumber($year, $company)
    {
        $result = $this->db->from($this->table)
            ->select_max('substring(po_no, 1, 8)', 'number')
            ->where('id_company', $company)
            ->where('left(po_no, 2) = ', substr($year, -2))
            ->where($year, 'YEAR(create_on)', false)
            ->get()
            ->row();

        if ($result) {
            $result = $this->db->from($this->table)
                ->select('po_no as number')
                ->where('id_company', $company)
                ->where('left(po_no, 2) = ', substr($year, -2))
                ->where($year, 'YEAR(create_on)', false)
                ->where('substring(po_no, 1, 8) = ', $result->number)
                ->get()->row();
        }

        return $result ? $result->number : 0;
    }

    public function isDocNumberExists($po_no, $year, $company)
    {
        return $this->db->from($this->table)
            ->where('substring(po_no, 1, 8) =', substr($po_no, 0, 8))
            ->where('id_company', $company)
            ->where($year, 'YEAR(create_on)', false)
            ->get()->num_rows() > 0;
    }

    public function isMSRHasPO($msr_no)
    {
        return $this->db->where('msr_no', $msr_no)
            ->get($this->table)->num_rows() > 0;
    }

    public function isMSRHasPO2($msr_no)
    {
        return $this->db->where('msr_no', $msr_no)
            ->get($this->table)->row();
    }

    /* public function find($po_no) */
    /* { */
    /*     return @$this->db->where('po_no', $po_no)->get($this->table)->result()[0]; */
    /* } */

    public function findByBlDetailId($id)
    {
        return @$this->db->where('bl_detail_id', $id)->get($this->table)->result()[0];
    }

    public function canCreateFromBlDetail($bl_detail_id)
    {
        $this->load->model("approval/M_bl");

        $awarder = @$this->M_bl->awarders($bl_detail_id)[0];

        // awarder found, has bl_detail_id and has no po_id
        return $awarder && $awarder->bled_detail_id != '' && $awarder->po_id == '';
    }

	public function toApprove($options = array())
	{
        $this->load->model('procurement/M_msr')
            ->model('approval/M_approval')
            ->model('setting/M_jabatan');

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
        $t_msr = $this->M_msr->getTable();
        $t_jabatan = $this->M_jabatan->getTable();

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
        $user_id = $this->session->userdata('ID_USER');

        $res = $this->db->select(array(
            "m_approval.module_kode",
            "m_approval.role_id",
            /* "m_approval.urutan", */
            "m_approval.opsi",
            /* "m_approval.deskripsi", */
            /* "m_approval.aktif", */

            "t_approval.id",
            "t_approval.data_id",
            "t_approval.deskripsi",
            "t_approval.urutan",
            "t_approval.status",
            "t_approval.created_at",
            "t_approval.created_by",

            "t_approval_prev.id as id_prev",
            "t_approval_prev.data_id as data_id_prev",
            "t_approval_prev.deskripsi as deskripsi_prev",
            "t_approval_prev.urutan as urutan_prev",
            "t_approval_prev.status as status_prev",
            "m_company.ABBREVIATION",

            "$this->table.*"

        ))
        ->from($m_approval)
        ->join($t_approval, "$t_approval.m_approval_id = $m_approval.id")
        ->join($this->table, "{$this->table}.id = $t_approval.data_id")
        ->join($t_approval." as ".$t_approval_prev, "$t_approval_prev.data_id = $t_approval.data_id"
            ." AND ($t_approval.urutan - 1) = $t_approval_prev.urutan", 'left', NULL)
        ->join($m_approval." as ".$m_approval_prev, "$m_approval_prev.module_kode = $m_approval.module_kode"
            ." AND $m_approval_prev.id = $t_approval_prev.id", 'left')
        ->join($t_msr, "$t_msr.msr_no = {$this->table}.msr_no")
        ->join($t_jabatan . " as jab", "jab.user_id = $t_msr.create_by")
        ->join($t_jabatan . " as pjab", "pjab.id = jab.parent_id", 'left')
        ->join('m_company', 'm_company.ID_COMPANY = '.$this->table.'.id_company')
        ->where("$m_approval.module_kode", $this::module_kode)
        ->where_in("$m_approval.role_id", $roles_id)
        ->where("
        case $t_approval.urutan
            when 2  /* MSR creator */
            then
               $t_msr.create_by = '$user_id'
            when 3 /* MSR creator manager */
            then
               pjab.user_id = '$user_id'
            else
                true
        end
        ")
        ->group_start()
            ->where("$t_approval.status", 0)
           // ->or_where("$t_approval.status", 2)
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

	public function toIssue($options = array())
	{
		$user_id = $this->session->userdata('ID_USER');
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
			->where("$this->table.create_by", $user_id)
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

    /**
     *  Deprecated
     */
    public function toAgreementList($id_vendor, $options = array())
    {
        $this->load->model('procurement/M_purchase_order_document')
            ->model('procurement/M_purchase_order_required_doc');

        $t_purchase_order_required_doc = $this->M_purchase_order_required_doc->getTable();
        $t_purchase_order_document = $this->M_purchase_order_document->getTable();

        $this->db->reset_query();

        $res = $this->db->select('*')
            ->from($this->table)
            ->get();

        if (isset($options['resource']) && $options['resource'] == true) {
            return $res;
        }

		return $res->result();
	}

    public function complete($id)
    {
        return $this->db->set('completed', 1)
            ->set('completed_date', today_sql())
            ->set('completed_by', $this->session->userdata('ID') ?: $this->session->userdata('ID_USER'))
            ->where('id', $id)
            ->update($this->table);
    }

    public function acceptCompleteness($id)
    {
        return $this->db->set('accept_completed', 1)
            ->set('accept_completed_date', today_sql())
            ->set('accept_completed_by', $this->session->userdata('ID') ?: $this->session->userdata('ID_USER'))
            ->where('id', $id)
            ->update($this->table);
    }

	public function issue($doc_id)
	{
		$issued = $this->db->set('issued', 1)
            ->set('issued_date', today_sql())
            ->set('issued_by', $this->session->userdata('ID_USER'))
			->where('id', $doc_id)
			->update($this->table);

		$img1 = '';
		$img2 = '';
		$query = $this->db->query("SELECT * FROM m_notic WHERE ID = 40");
		$data_replace = $query->result();

		$str = str_replace('[no]', $doc_id, $data_replace[0]->OPEN_VALUE);

        $ctn = ' <p>' . $img1 . '<p>
                        <br>' . $str . '
                        <br>
                        ' . $data_replace[0]->CLOSE_VALUE . '
                        <br>
                        ';
        $data = array(
            'recipient' => 'kicky120@gmail.com',
            'subject' => $data_replace[0]->TITLE,
            'content' => $ctn,
            'ismailed' => 0
        );

        $this->db->insert('i_notification', $data);

		return $issued;
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
        $_POST['created_by'] = $this->session->userdata('ID_USER');

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
        $_POST['created_by'] = $this->session->userdata('ID_USER');

		$result = $this->M_approval->reject();

		unset($_POST);
		$_POST = $post; // restore $_POST

		return $result;
	}

    public function inquiry($options = array())
    {
        $m_vendor = 'm_vendor';
        $i_sync = 'i_sync';

        $this->db->from($this->table);
        $ROLES = $this->session->userdata('ROLES');
        $ID_USER = $this->session->userdata('ID_USER');
		$ID_DEPARTMENT = $this->session->userdata('DEPARTMENT');

		if (isset($options['limit'])) {
	      $this->db->limit($options['limit']);
	    }

	    if (isset($options['offset'])) {
	      $this->db->offset($options['offset']);
	    }

	    if (isset($options['orderBy'])) {
	      $this->db->order_by($options['orderBy']);
        } else {
	      $this->db->order_by('po_no DESC');
        }

        if (strpos($ROLES, ',23,') !== false ) {
          $where = '1=1';
        }else if (strpos($ROLES, ',28,') !== false ) {
          $where = '1=1';
        } else {
          $where = "(t_msr.id_department = '".$ID_DEPARTMENT."' OR e.created_by='".$ID_USER."' )";
        }
        if($this->input->get('reject_list'))
        {
            $where .= " and t_purchase_order.id in (select data_id from t_approval WHERE m_approval_id in (17,18,19) and status = 2 GROUP BY data_id) and t_purchase_order.create_by =  ".$this->session->userdata('ID_USER');
        }
		//
        // $this->db->select([
        //     "{$this->table}.*",
        //     "{$i_sync}.doc_no",
        //     "{$i_sync}.doc_type",
        //     "{$i_sync}.isclosed",
        //     "{$m_vendor}.NAMA nama_vendor",
        //     "m_currency.CURRENCY",
        //     "m_departement.ID_DEPARTMENT department_requestor_id",
        //     "m_departement.DEPARTMENT_DESC department_requestor"
        //     ])
        //     ->join('t_msr', 't_msr.msr_no = '.$this->table.'.msr_no')
        //     ->join('m_user', 'm_user.ID_USER = t_msr.create_by')
        //     ->join('m_departement', 'm_departement.ID_DEPARTMENT = m_user.ID_DEPARTMENT')
        //     ->join($i_sync, "$i_sync.doc_no = {$this->table}.id
        //         AND $i_sync.doc_type = '".$this::module_kode."'", 'left')
        //     ->join($m_vendor, "$m_vendor.ID = {$this->table}.id_vendor", 'left')
        //     ->join('m_currency', 'm_currency.ID = t_purchase_order.id_currency');

            $qq = $this->db->query("SELECT DISTINCT t_msr.create_by as creator, m_user.ROLES, t_purchase_order.*, i_sync.doc_no, i_sync.doc_type, i_sync.isclosed, m_vendor.NAMA nama_vendor, m_currency.CURRENCY, m_departement.ID_DEPARTMENT department_requestor_id, m_departement.DEPARTMENT_DESC department_requestor
            FROM t_purchase_order
            JOIN t_msr ON t_msr.msr_no = t_purchase_order.msr_no
            JOIN m_user ON m_user.ID_USER = t_msr.create_by
            JOIN m_departement ON m_departement.ID_DEPARTMENT = t_msr.ID_DEPARTMENT
            LEFT JOIN i_sync ON i_sync.doc_no = t_purchase_order.id AND i_sync.doc_type = 'po'
            LEFT JOIN m_vendor ON m_vendor.ID = t_purchase_order.id_vendor
            JOIN m_currency ON m_currency.ID = t_purchase_order.id_currency
            LEFT JOIN (SELECT DISTINCT data_id, m_approval_id, created_by FROM t_approval WHERE status=1 and m_approval_id=6 ) e ON e.data_id=t_msr.msr_no
            WHERE ".$where."
            ORDER BY po_no DESC");
        // $res = $this->db->get();
        $res = $qq;

        if (isset($options['resource']) && $options['resource'] == true) {
            return $res;
        }
        // return echopre($this->db->last_query());
        return $res->result();
    }

    public function approvalStatuses($id = null, $params = [])
    {
        $module_kode = $this::module_kode;

        $sql = <<<SQL
select {$this->table}.*
    , mapp.module_kode, mapp.id mapp_id, mapp.role_id
    , tapp.id tapp_id, tapp.m_approval_id, tapp.status, tapp.urutan
    , mapp_prev.module_kode prev_module_kode, mapp_prev.role_id prev_role_id
    , tapp_prev.id prev_tapp_id, tapp_prev.status prev_status, tapp_prev.urutan prev_urutan
    , case
        when
            (tapp.status = 0 and tapp_prev.status = 1)
        then 'WAITING_APPROVAL' -- in approval
        when
            ( tapp.status = 0 and tapp_prev.status is null)
        then 'NEW'  -- first approval
        when
            (tapp.status = 2)
        then'REJECT'-- reject
        when
            (tapp.urutan = 3 and tapp.status = 1)
        then 'COMPLETE' -- complete
        else 'UNKNOWN'
    end as status_code
    , CONCAT('Approval ', urole.DESCRIPTION) as action_to_role_description
from {$this->table}
join t_approval tapp on tapp.data_id = {$this->table}.id
join m_approval mapp on mapp.id = tapp.m_approval_id
left join t_approval tapp_prev on tapp_prev.data_id = tapp.data_id
    and tapp_prev.urutan = tapp.urutan - 1
left join m_approval mapp_prev on mapp_prev.module_kode = mapp.module_kode
    and tapp_prev.m_approval_id = mapp_prev.id
left join m_user_roles urole on case
  when
    (tapp.status = 2) -- reject
    or (tapp.status = 0 and tapp_prev.status = 1) -- waiting approval
  then urole.ID_USER_ROLES = mapp.role_id
  when
    (tapp.status = 1 and tapp_prev.status is null)
  then urole.ID_USER_ROLES = ''
  when
    (tapp.status = 0 and tapp_prev.status is null) -- first approver
   then urole.ID_USER_ROLES = mapp.role_id
  else
    urole.ID_USER_ROLES = '' -- mapp.role_id
  end
where mapp.module_kode = '$module_kode'
    and if (tapp.urutan = 1,
        mapp_prev.module_kode is null and tapp_prev.id is null,
        mapp_prev.module_kode is not null and tapp.id is not null)
    and (

        ( tapp.status = 0 and tapp_prev.status is null) -- first approval
        or (tapp.status = 0 and tapp_prev.status = 1) -- waiting approval
        or (tapp.status = 2 ) -- reject
        or ( if (tapp.urutan = 3, tapp.status = 1 , false) ) -- completed
    )
SQL;

        if ($id) {
            $sql .=  " AND {$this->table}.id = '$id' ";
        }

        $sql .= " order by {$this->table}.id, mapp.module_kode, tapp.urutan";

        $res = $this->db->query($sql);

        if (isset($params['resource']) && $params['resource'] === true) {
            return $res;
        }

        return $res->result();
    }

    public function getHeaderFromEd($bl_detail_id)
    {
        $this->load->model('approval/M_bl');

        return $this->M_bl->getBlByBlDetailId($bl_detail_id);
    }

    public function getIssuedByVendor($vendor_id, $params = array())
    {
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

        $this->db->where('id_vendor', $vendor_id);

        $this->whereIssued();

        $res = $this->db->get();

        if (isset($params['resource']) && $params['resource'] === true) {
            return $res;
        }

        return $res->result();
    }

    public function getToBeCompletedByVendor($vendor_id, $options = array())
    {
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

        $this->db->where('id_vendor', $vendor_id);

        $this->whereIssued();
        $this->whereNotCompleted();

        $res = $this->db->get();

        if (isset($options['resource']) && $options['resource'] === true) {
            return $res;
        }

        return $res->result();
    }

    public function completed($id = null, $options = [])
    {

		if (isset($options['limit'])) {
	      $this->db->limit($options['limit']);
	    }

	    if (isset($options['offset'])) {
	      $this->db->offset($options['offset']);
	    }

	    if (isset($options['orderBy'])) {
	      $this->db->order_by($options['orderBy']);
	    }

        if ($id) {
            $this->db->where("{$this->table}.id", $id);
        }

        $this->whereCompleted();

        $this->db->from($this->table)
            ->select([
                "{$this->m_vendor}.*",
                "{$this->m_vendor}.NAMA as nama_vendor",
                "{$this->table}.*",
            ])
            ->join($this->m_vendor, "{$this->m_vendor}.ID = {$this->table}.id_vendor", 'left');

        $res = $this->db->get();

        if (isset($options['resource']) && $options['resource'] === true) {
            return $res;
        }

        return $res->result();
    }

    public function toBeAcceptCompleted($id = null, $options = [])
    {

		if (isset($options['limit'])) {
	      $this->db->limit($options['limit']);
	    }

	    if (isset($options['offset'])) {
	      $this->db->offset($options['offset']);
	    }

	    if (isset($options['orderBy'])) {
	      $this->db->order_by($options['orderBy']);
	    }

        if ($id) {
            $this->db->where("{$this->table}.id", $id);
        }

        $this->whereCompleted();
        $this->whereNotAcceptCompleted();

        $this->db->from($this->table)
            ->select([
                "{$this->m_vendor}.*",
                "{$this->m_vendor}.NAMA as nama_vendor",
                "{$this->table}.*",
            ])
            ->join($this->m_vendor, "{$this->m_vendor}.ID = {$this->table}.id_vendor", 'left');

        $res = $this->db->get();

        if (isset($options['resource']) && $options['resource'] === true) {
            return $res;
        }

        return $res->result();
    }

    public function acceptCompleted($id = null, $options = [])
    {

		if (isset($options['limit'])) {
	      $this->db->limit($options['limit']);
	    }

	    if (isset($options['offset'])) {
	      $this->db->offset($options['offset']);
	    }

	    if (isset($options['orderBy'])) {
	      $this->db->order_by($options['orderBy']);
	    }

        if ($id) {
            $this->db->where("{$this->table}.id", $id);
        }

        $this->whereAcceptCompleted();

        $this->db->from($this->table)
            ->select([
                "{$this->m_vendor}.*",
                "{$this->m_vendor}.NAMA as nama_vendor",
                "{$this->table}.*",
            ])
            ->join($this->m_vendor, "{$this->m_vendor}.ID = {$this->table}.id_vendor", 'left');

        $res = $this->db->get();

        if (isset($options['resource']) && $options['resource'] === true) {
            return $res;
        }

        return $res->result();
    }

    public function addToISync($doc_no)
    {
        $data['doc_no'] = stripslashes($doc_no);
        $data['doc_type'] = $this::module_kode;
        $data['isclosed'] = 0;

        $this->db->insert('i_sync', $data);
    }

    public function isApprovalCompleted($id)
    {
        $m_approval = $this->m_approval;
        $t_approval = $this->t_approval;

        $result = $this->db->select('count(1) as count')
            ->join($m_approval, "{$m_approval}.id = {$t_approval}.m_approval_id")
            ->where("{$m_approval}.module_kode", $this::module_kode)
            ->where("{$t_approval}.data_id", $id)
            ->where("{$t_approval}.status !=", 1)
            ->get($t_approval)->row();

        return $result->count == 0;
    }

    protected function whereIssued()
    {
        return $this->db->where("{$this->table}.issued", 1);
    }

    protected function whereCompleted()
    {
        return $this->db->where("{$this->table}.completed", 1);
    }

    protected function whereNotCompleted()
    {
        return $this->db->where("{$this->table}.completed", 0);
    }

    protected function whereAcceptCompleted()
    {
        return $this->db->where("{$this->table}.accept_completed", 1);
    }

    protected function whereNotAcceptCompleted()
    {
        return $this->db->where("{$this->table}.accept_completed", 0);
    }
    public function new_agreement_no($msr_no='')
    {
        // $bidder = $this->db->where(['awarder'=>1, 'msr_no'=>$msr_no])->get('t_bl_detail');
        $po  = $this->db->where('msr_no', $msr_no)->get($this->table);
        $loi = $this->db->where('msr_no', $msr_no)->get($this->loi);
        if($po->num_rows() == 0)
        {
            if($loi->num_rows() == 0)
            {
                $bidder = $this->db->where(['awarder'=>1, 'msr_no'=>$msr_no])->get('t_bl_detail');
                if($bidder->num_rows() > 1)
                {
                    #first

                }
                else
                {

                }
            }
        }
        else
        {

        }
    }
    public function value_award($msr_no='', $vendor_id='')
    {
        $q = "select vendor_id, sum(new_price * qty) amount, sum(new_price_base * qty) amount_base from
        (select sop_id, vendor_id, (case 
            when nego_price > 0 then nego_price
            else unit_price
        end) new_price,  (case 
            when nego_price_base > 0 then nego_price_base
            else unit_price_base
        end) new_price_base, (case when t_sop.qty2 > 0 then t_sop.qty1 * t_sop.qty2 else t_sop.qty1 end) qty 
                from t_sop_bid 
                left join t_sop on t_sop.id = t_sop_bid.sop_id
                where t_sop_bid.msr_no = '$msr_no' and award = 1) a where vendor_id = '$vendor_id' group by vendor_id";
        return $this->db->query($q)->row();
    }
    public function reject_list()
    {
        $q = "select data_id from t_approval WHERE m_approval_id in (17,18,19) and status = 2 GROUP BY data_id";
        // $qq = "select * from t_purchase_order where id in ($q) and ";
        return $this->db->where("id in ($q)",'',false)->from('t_purchase_order');
    }
}
