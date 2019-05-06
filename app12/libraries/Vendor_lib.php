<?php
/**
*  $new = array(
                "ID_VENDOR" => $cek[0]->ID_VENDOR,
                "NAME" => $cek[0]->NAMA,
                "ID" => $cek[0]->ID,
                "lang" => $_POST['lang'],
                "status_vendor" => $cek[0]->STATUS,
            );
*/
class Vendor_lib
{

	function __construct()
	{
		$ci =& get_instance();
		$sesi = $ci->session->userdata();
	}
	public function greeting_list_uncorfimed($value='')
	{
		return $this->greeting_list(0);
	}
	public function greeting_list_confirmed($value='')
	{
		return $this->greeting_list(1);
	}
	public function greeting_list_withdraw($value='')
	{
		return $this->greeting_list(2);
	}
	public function greeting_list($value='',$bled_no='')
	{
		$ci =& get_instance();
		$idVendor = $ci->session->userdata('ID');
		$msr_no = str_replace('OQ', 'OR', $bled_no);

		$t_approval = $ci->db->where(['status'=>1, 'm_approval_id'=>13])->get('t_approval');
		$msr = [];
		if($t_approval->num_rows() > 0)
		{
			$rows = $t_approval->result();
			foreach ($rows as $row) {
				$msr[] = $row->data_id;
			}
			$ci->db->where_in('t_msr.msr_no', $msr);
		}

		if($bled_no)
			$ci->db->where(['bled_no'=>$bled_no]);

		if ($value) {
			if ($value == 10) {
				$ci->db->group_start()
					->where_in('confirmed', array('2', '3'))
					->or_group_start()
						->where_in('confirmed', array('0', '1'))
						->where('t_eq_data.closing_date <', date('Y-m-d H:i:s'))
						->where('NOT EXISTS(SELECT * FROM t_bid_head WHERE t_bid_head.created_by =\''.$idVendor.'\' AND t_bid_head.bled_no=t_bl.bled_no)')
					->group_end()
				->group_end();
			} else {
				if ($value == 11) {
					$ci->db->where('confirmed', 1);
					$ci->db->where('EXISTS(SELECT * FROM t_bid_head WHERE t_bid_head.created_by =\''.$idVendor.'\' AND t_bid_head.bled_no=t_bl.bled_no)');
				} else {
					$ci->db->where('confirmed', $value);
					$ci->db->where('t_eq_data.closing_date >= ', date('Y-m-d H:i:s'));
					$ci->db->where('NOT EXISTS(SELECT * FROM t_bid_head WHERE t_bid_head.created_by =\''.$idVendor.'\' AND t_bid_head.bled_no=t_bl.bled_no)');
				}
			}
		} else {
			$ci->db->where('confirmed', 0)
			->where('t_eq_data.closing_date >=', date('Y-m-d H:i:s'));
		}

		return $ci->db->select('t_bl_detail.*,t_bl.*,m_company.DESCRIPTION company_name, m_company.ABBREVIATION abbreviation,t_bl_detail.created_at invitation_date,t_eq_data.prebiddate prebiddate,t_eq_data.prebid_loc prebid_loc,t_eq_data.closing_date closing_date,t_eq_data.currency as id_currency,m_currency.CURRENCY currency,m_pmethod.PMETHOD_DESC pmethod_name,t_msr.dpoint_desc loc,t_eq_data.prebid_address,t_eq_data.bid_validity,t_eq_data.bid_bond_validity,t_eq_data.bid_bond,t_bl_detail.id bldetail_id,t_eq_data.bid_bond_type, bid_opening, t_msr.id_msr_type, t_msr.id_currency_base, t_msr.id_dpoint,(case when closing_date >= now() then \'Open\' ELSE \'Close\' END) `status_closing_date`, t_eq_data.envelope_system, t_eq_data.incoterm, t_eq_data.packet, t_eq_data.issued_date, unread_message.unread_message, addendum.unread_message as addendum')
		->join('t_bl','t_bl.msr_no = t_bl_detail.msr_no', 'left')
		->join('t_msr','t_msr.msr_no = t_bl.msr_no', 'left')
		->join('m_company','m_company.ID_COMPANY = t_msr.id_company', 'left')
		->join('t_eq_data','t_eq_data.msr_no = t_msr.msr_no', 'left')
		->join('m_currency','m_currency.ID = t_eq_data.currency', 'left')
		->join('m_pmethod','m_pmethod.ID_PMETHOD = t_bl.pmethod', 'left')
		->join('m_pre_bid_location','m_pre_bid_location.id = t_eq_data.prebid_loc', 'left')
		->join('(
			SELECT data_id, vendor_id, COUNT(1) AS unread_message FROM t_note
			WHERE module_kode=\'bidnote\'
			AND is_read = 0
			AND vendor_id <> 0
			GROUP BY data_id, vendor_id
		) unread_message', 'unread_message.data_id = t_bl.bled_no and unread_message.vendor_id=t_bl_detail.vendor_id', 'left')
		->join('(
			SELECT data_id, vendor_id, COUNT(1) AS unread_message FROM t_note
			WHERE module_kode=\'addendum_bled\'
			AND is_read = 0
			AND vendor_id <> 0
			GROUP BY data_id, vendor_id
		) addendum', 'addendum.data_id = t_msr.msr_no and addendum.vendor_id=t_bl_detail.vendor_id', 'left')
		->where(['t_bl_detail.vendor_id'=>$idVendor])
		->order_by('addendum.unread_message', 'DESC')
		->order_by('unread_message.unread_message', 'DESC')
		->order_by('t_bl.bled_no', 'DESC')
		->get('t_bl_detail');
	}

	public function count_unread_message($value='',$bled_no='') {
		$ci =& get_instance();
		$idVendor = $ci->session->userdata('ID');
		$msr_no = str_replace('OQ', 'OR', $bled_no);

		$t_approval = $ci->db->where(['status'=>1, 'm_approval_id'=>13])->get('t_approval');
		$msr = [];
		if($t_approval->num_rows() > 0)
		{
			$rows = $t_approval->result();
			foreach ($rows as $row) {
				$msr[] = $row->data_id;
			}
			$ci->db->where_in('t_msr.msr_no', $msr);
		}

		if($bled_no)
			$ci->db->where(['bled_no'=>$bled_no]);

		if ($value) {
			if ($value == 10) {
				$ci->db->group_start()
					->where_in('confirmed', array('2', '3'))
					->or_group_start()
						->where('confirmed', 0)
						->where('t_eq_data.closing_date <', date('Y-m-d H:i:s'))
					->group_end()
				->group_end();
			} else {
				if ($value == 11) {
					$ci->db->where('confirmed', 1);
					$ci->db->where('EXISTS(SELECT * FROM t_bid_head WHERE t_bid_head.created_by =\''.$idVendor.'\' AND t_bid_head.bled_no=t_bl.bled_no)');
				} else {
					$ci->db->where('confirmed', $value);
					$ci->db->where('t_eq_data.closing_date >= ', date('Y-m-d H:i:s'));
					$ci->db->where('NOT EXISTS(SELECT * FROM t_bid_head WHERE t_bid_head.created_by =\''.$idVendor.'\' AND t_bid_head.bled_no=t_bl.bled_no)');
				}
			}
		} else {
			$ci->db->where('confirmed', 0)
			->where('t_eq_data.closing_date >=', date('Y-m-d H:i:s'));
		}

		$unread_message = $ci->db->select('SUM(COALESCE(unread_message.unread_message, 0)) as unread_message, SUM(COALESCE(addendum.unread_message, 0)) as addendum')
		->join('t_bl','t_bl.msr_no = t_bl_detail.msr_no', 'left')
		->join('t_msr','t_msr.msr_no = t_bl.msr_no', 'left')
		->join('t_eq_data','t_eq_data.msr_no = t_msr.msr_no', 'left')
		->join('(
			SELECT data_id, vendor_id, COUNT(1) AS unread_message FROM t_note
			WHERE module_kode=\'bidnote\'
			AND is_read = 0
			AND vendor_id <> 0
			GROUP BY data_id, vendor_id
		) unread_message', 'unread_message.data_id = t_bl.bled_no and unread_message.vendor_id=t_bl_detail.vendor_id', 'left')
		->join('(
			SELECT data_id, vendor_id, COUNT(1) AS unread_message FROM t_note
			WHERE module_kode=\'addendum_bled\'
			AND is_read = 0
			AND vendor_id <> 0
			GROUP BY data_id, vendor_id
		) addendum', 'addendum.data_id = t_msr.msr_no and addendum.vendor_id=t_bl_detail.vendor_id', 'left')
		->where(['t_bl_detail.vendor_id'=>$idVendor])
		->get('t_bl_detail')
		->row();
		return $unread_message;
	}

	public function note($module_kode='', $data_id='')
	{
		$ci =& get_instance();
		return $ci->db->where(['module_kode'=>$module_kode,'data_id'=>$data_id])->order_by('id','desc')->get('t_note');
	}
	public function tUpload($module_kode='',$msr_no='')
	{
		$ci =& get_instance();
		return $ci->db->where(['module_kode'=>$module_kode,'data_id'=>$msr_no])->get('t_upload');
	}
	public function msrItem($msr_no='')
	{
		$ci =& get_instance();
		return $ci->db->select('t_msr_item.*, t_msr.id_currency, currency.CURRENCY as currency, t_msr.id_currency_base, currency_base.CURRENCY as currency_base')
		->join('t_msr', 't_msr.msr_no = t_msr_item.msr_no')
		->join('m_currency currency', 'currency.ID = t_msr.id_currency')
		->join('m_currency currency_base', 'currency_base.ID = t_msr.id_currency_base')
		->where(['t_msr_item.msr_no'=>$msr_no])
		->get('t_msr_item');
	}
	public function tBidBond($bled_no='', $id='')
	{
		$ci =& get_instance();
		return  $ci->db->select('t_bid_bond.*,m_currency.CURRENCY currency_name')
        ->where(['bled_no' => $bled_no, 'created_by' => $id])
        ->join('m_currency','m_currency.ID=t_bid_bond.currency')
        ->get('t_bid_bond');
	}
	public function tBidHead($bled_no='', $id='')
	{
		$ci =& get_instance();
		return  $ci->db->select('t_bid_head.*')
        ->where(['bled_no' => $bled_no, 'created_by' => $id])
        ->get('t_bid_head');
	}
	public function tBidDetail($where = array())
	{
		$ci =& get_instance();
		return  $ci->db->select('t_bid_detail.*')
        ->where($where)
        ->get('t_bid_detail');
	}
	public function blDetail($msr_no='', $where_in='')
	{
		$ci =& get_instance();
		if(is_array($where_in))
		{
			$ci->db->where_in('vendor_id', $where_in);
		}
		/*new*/
		/*return  $ci->db->select('t_bl_detail.*,m_vendor.NAMA vendor_name,m_vendor.NO_SLKA no_slka,t_bl_detail.id bl_detail_id,t_bid_head.created_at submission_date,t_bid_head.*')
		->join('m_vendor','m_vendor.ID = t_bl_detail.vendor_id')
		->join('t_bl','t_bl.msr_no=t_bl_detail.msr_no')
		->join('t_bid_head','t_bid_head.bled_no=t_bl.bled_no')
        ->where(['t_bl_detail.msr_no' => $msr_no])
        ->get('t_bl_detail');*/

        /*old*/
        return  $ci->db->select('
        	t_bl_detail.*,
        	m_vendor.NAMA vendor_name,
        	m_vendor.NO_SLKA no_slka,
        	m_vendor.status_doc,
        	t_bl_detail.id bl_detail_id,
        	m_currency.CURRENCY currency
        ')
		->join('(
			SELECT
	           	m_vendor.*,
	            (
	                SELECT
	                    CASE
	                        WHEN document.VALID_UNTIL <= NOW() THEN \'DOCUMENT EXPIRED\'
	                        WHEN DATEDIFF(document.VALID_UNTIL, NOW()) <= m_document.reminder_day THEN CONCAT(\'DOCUMENT WILL BE EXPIRED ON \', DATEDIFF(document.VALID_UNTIL, NOW()),\' DAYS\')
	                        ELSE NULL
	                    END AS STATUS_DOCUMENT
	                FROM
	                (
	                    SELECT ID_VENDOR, MIN(VALID_UNTIL) as VALID_UNTIL FROM (
	                        SELECT ID_VENDOR,NO_DOC,CATEGORY,FILE_URL,VALID_UNTIL FROM m_vendor_legal_other
	                        UNION ALL
	                        SELECT ID_VENDOR, NO_DOC,\'CERTIFICATION\' AS CATEGORY, FILE_URL,VALID_UNTIL FROM m_vendor_certification
	                    ) as older
	                    GROUP BY ID_VENDOR
	                ) older
	                JOIN (
	                    SELECT ID_VENDOR,NO_DOC,CATEGORY,FILE_URL,VALID_UNTIL FROM m_vendor_legal_other
	                    UNION ALL
	                    SELECT ID_VENDOR, NO_DOC,\'CERTIFICATION\' AS CATEGORY, FILE_URL,VALID_UNTIL FROM m_vendor_certification
	                ) as document ON document.ID_VENDOR = older.ID_VENDOR AND document.VALID_UNTIL = older.VALID_UNTIL
	                JOIN m_document ON m_document.document_type = document.CATEGORY
	                WHERE document.ID_VENDOR = m_vendor.id
	                LIMIT 1
	            ) as status_doc
	        FROM m_vendor
		) m_vendor','m_vendor.ID = t_bl_detail.vendor_id')
		->join('t_bl','t_bl.msr_no=t_bl_detail.msr_no')
		->join('t_eq_data','t_bl.msr_no=t_eq_data.msr_no')
		->join('m_currency','m_currency.ID=t_eq_data.currency')
        ->where(['t_bl_detail.msr_no' => $msr_no])
        ->get('t_bl_detail');
	}
	public function msrItemTobeAdmin($msr_no='')
	{
		$ci =& get_instance();
		return $ci->db->select('t_msr_item.*,t_bid_detail.unit_price unit_price2, t_bid_detail.nego_price,t_bl_detail.vendor_id ')
		->join('t_bl','t_bl.msr_no=t_msr_item.msr_no')
		->join('t_bl_detail','t_bl_detail.msr_no=t_bl.msr_no')
		->join('t_bid_detail','t_bid_detail.bled_no=t_bl.bled_no and t_bid_detail.created_by=t_bl_detail.vendor_id and t_bid_detail.msr_detail_id=t_msr_item.line_item')
		->where(['t_msr_item.msr_no'=>$msr_no])
		->get('t_msr_item');
	}

	public function get_cpm_list() {
		$ci =& get_instance();
		$res = $ci->db->query("
			SELECT CONCAT(p.po_no,'/',p.phase) as po
			FROM (
				SELECT MAX(sequence) as sequence, po_no
				FROM t_approval_cpm
				WHERE status_approve = 1 AND vendor_id = ".$_SESSION['ID']." AND extra_case = 0
				GROUP BY po_no
			) a
			JOIN (
				SELECT MAX(sequence) as sequence, po_no
				FROM t_approval_cpm
				WHERE vendor_id = ".$_SESSION['ID']." AND extra_case = 0
				GROUP BY po_no
			) b ON b.po_no = a.po_no AND b.sequence = a.sequence
			JOIN t_cpm_phase p ON p.po_no = a.po_no AND date_start <= CURDATE() AND due_date >= CURDATE() and p.status = 1
			GROUP BY p.po_no, p.phase
		");
		return $res;
	}

	public function get_cpm_accepted() {
		$ci =& get_instance();
		$res = $ci->db->query("
			SELECT CONCAT(p.po_no,'/',p.phase) as po
			FROM (
				SELECT MAX(sequence) as sequence, po_no, phase_id
				FROM t_approval_cpm
				WHERE status_approve = 1 AND vendor_id = ".$_SESSION['ID']." AND extra_case = 1 AND status = 0
				GROUP BY po_no, phase_id
			) a
			JOIN (
				SELECT MAX(sequence) as sequence, po_no, phase_id
				FROM t_approval_cpm
				WHERE vendor_id = ".$_SESSION['ID']." AND extra_case = 1 AND status = 0
				GROUP BY po_no, phase_id
			) b ON b.po_no = a.po_no AND b.sequence = a.sequence AND b.phase_id = a.phase_id
			JOIN t_cpm_phase p ON p.po_no = a.po_no AND a.phase_id = p.id
			GROUP BY p.po_no, p.phase
		");
		return $res;
	}

	public function getNegoVendorSession()
	{
		$ci =& get_instance();
		$idVendor = $ci->session->userdata('ID');

		$sql = "select bled_no from t_bid_detail where nego = 1 and created_by = '$idVendor' group by bled_no";
		return $ci->db->query($sql);
	}
	public function getNegoVendorSessionData()
	{
		$ci =& get_instance();
		$idVendor = $ci->session->userdata('ID');
		/*->join('m_company','m_company.ID_COMPANY = t_msr.id_company')
		->join('t_eq_data','t_eq_data.msr_no = t_msr.msr_no')
		->join('t_msr','t_msr.msr_no = t_bl.msr_no')*/
		$sql = "select bled_no from t_bid_detail where nego = 1 and created_by = '$idVendor' group by bled_no";

		/*$sql = "select t_bid_head.*, t_bl.title, m_company.DESCRIPTION company_name, t_eq_data.closing_date closing_date
		from t_bid_head
		left join t_bl on t_bid_head.bled_no = t_bl.bled_no
		left join t_msr on t_msr.msr_no = t_bl.msr_no
		left join m_company on m_company.ID_COMPANY = t_msr.id_company
		left join t_eq_data on t_eq_data.msr_no = t_msr.msr_no
		where t_bl.bled_no in ($sql)";*/
		return $ci->db->query($sql);
	}
	public function sqlUtama($where='')
	{
		$ci =& get_instance();
		$idVendor = $ci->session->userdata('ID');
		if(is_array($where))
		{
			$ci->db->where($where);
		}
		return $ci->db->select('t_bl_detail.*,t_bl.*,m_company.DESCRIPTION company_name,t_bl_detail.created_at invitation_date,t_eq_data.prebiddate prebiddate,t_eq_data.closing_date closing_date,m_currency.CURRENCY currency,t_eq_data.prebid_address,t_eq_data.bid_validity,t_eq_data.bid_bond_validity,t_eq_data.bid_bond,t_bl_detail.id bldetail_id,t_eq_data.bid_bond_type')
		->join('t_bl','t_bl.msr_no = t_bl_detail.msr_no')
		->join('t_msr','t_msr.msr_no = t_bl.msr_no')
		->join('m_company','m_company.ID_COMPANY = t_msr.id_company')
		->join('t_eq_data','t_eq_data.msr_no = t_msr.msr_no')
		->join('m_currency','m_currency.ID = t_eq_data.currency')
		->where(['vendor_id'=>$idVendor])
		->get('t_bl_detail');
	}
	public function sqlListNego($where='')
	{
		$ci =& get_instance();
		$idVendor = $ci->session->userdata('ID');
		if(is_array($where))
		{
			$ci->db->where($where);
		}
		return $ci->db->select('t_bl_detail.*,t_bl.*,m_company.DESCRIPTION company_name,t_bl_detail.created_at invitation_date,t_eq_data.prebiddate prebiddate,t_eq_data.closing_date closing_date,m_currency.CURRENCY currency,t_eq_data.prebid_address,t_eq_data.bid_validity,t_eq_data.bid_bond_validity,t_eq_data.bid_bond,t_bl_detail.id bldetail_id,t_eq_data.bid_bond_type')
		->join('t_bl','t_bl.msr_no = t_bl_detail.msr_no')
		->join('t_msr','t_msr.msr_no = t_bl.msr_no')
		->join('m_company','m_company.ID_COMPANY = t_msr.id_company')
		->join('t_eq_data','t_eq_data.msr_no = t_msr.msr_no')
		->join('m_currency','m_currency.ID = t_eq_data.currency')
		->where(['vendor_id'=>$idVendor])
		->get('t_bl_detail');
	}
	public function accept_award_nomination($value=1)
	{
		$ci =& get_instance();
		$idVendor = $ci->session->userdata('ID');

		return $ci->db->select('*,m_company.DESCRIPTION company_name,m_pmethod.PMETHOD_DESC pmethod_name,t_bl_detail.created_at invitation_date,m_location.LOCATION_DESC loc, t_bl_detail.id t_bl_detail_id')
		->where(['awarder'=>$value, 'award'=>9, 'vendor_id'=>$idVendor,'accept_award'=>0])
		->join('t_eq_data','t_eq_data.msr_no = t_bl_detail.msr_no')
		->join('t_bl','t_bl.msr_no = t_bl_detail.msr_no')
		->join('t_msr','t_msr.msr_no = t_bl.msr_no')
		->join('m_company','m_company.ID_COMPANY = t_msr.id_company')
		->join('m_pmethod','m_pmethod.ID_PMETHOD = t_bl.pmethod')
		->join('m_location','m_location.ID_LOCATION = t_eq_data.prebid_loc')
		->get('t_bl_detail');
	}
	public function award_form($bled_no='')
	{
		$ci =& get_instance();
		$idVendor = $ci->session->userdata('ID');

		return $ci->db->select('t_bl_detail.*,t_bl.*,m_company.DESCRIPTION company_name,t_bl_detail.created_at invitation_date,t_eq_data.prebiddate prebiddate,t_eq_data.closing_date closing_date,m_currency.CURRENCY currency,m_pmethod.PMETHOD_DESC pmethod_name,m_location.LOCATION_DESC loc, t_eq_data.prebid_address,t_eq_data.bid_validity,t_eq_data.bid_bond_validity,t_eq_data.bid_bond,t_bl_detail.id bldetail_id,t_eq_data.bid_bond_type')
		->join('t_bl','t_bl.msr_no = t_bl_detail.msr_no')
		->join('t_msr','t_msr.msr_no = t_bl.msr_no')
		->join('m_company','m_company.ID_COMPANY = t_msr.id_company')
		->join('t_eq_data','t_eq_data.msr_no = t_msr.msr_no')
		->join('m_currency','m_currency.ID = t_eq_data.currency')
		->join('m_pmethod','m_pmethod.ID_PMETHOD = t_bl.pmethod')
		->join('m_location','m_location.ID_LOCATION = t_eq_data.prebid_loc')
		->where(['vendor_id'=>$idVendor,'bled_no'=>$bled_no])
		->get('t_bl_detail');
	}
	public function getBl($where='')
	{
		$ci =& get_instance();
		if(is_array($where))
		{
			$ci->db->where($where);
		}
		return $ci->db->get('t_bl_detail');
	}
	public function note2($module_kode='', $data_id='')
	{
		$ci =& get_instance();
		if($ci->session->userdata('status_vendor'))
		{
			$ci->db->where(['vendor_id'=>$ci->session->userdata('ID')]);
		}
		return $ci->db->where(['module_kode'=>$module_kode,'data_id'=>$data_id])->order_by('id','desc')->get('t_note');
	}
	public function note3($data)
	{
		$ci =& get_instance();
		$user_id = $ci->session->userdata('ID_USER');
		$sql = "select * from t_note where data_id = '$data[data_id]' and module_kode='bidnote' and ((created_by='$data[vendor_id]' and author_type='m_vendor') or (created_by = '$user_id' and author_type = 'm_user' and vendor_id = '$data[vendor_id]')) order by id desc";
		return $ci->db->query($sql);
		/*$ci->db->where(['created_by'=>$data['vendor_id'],'author_type'=>'m_vendor']);
		return $ci->db->where(['module_kode'=>$data['module_kode'],'data_id'=>$data['data_id']])->order_by('id','desc')->get('t_note');*/
	}
	public function getBld($msr_no='')
	{
		$ci =& get_instance();
		$ci->load->model('approval/M_bl');
		return $ci->M_bl->tbld($msr_no);
	}
	public function isRead()
	{
		$ci =& get_instance();
		$user_id = $ci->session->userdata('ID_USER');
		$sql = "select t_note.* from t_note
			left join t_msr on t_msr.msr_no = t_note.data_id
			where module_kode = 'bidnote'
			and t_msr.status = 0
			and author_type='m_vendor'
			and is_read = 0 and data_id in (select REPLACE(msr_no,'OR','OQ') from t_assignment where user_id = '$user_id')";
		return $ci->db->query($sql);
	}
	public function clarificationList()
	{
		$ci =& get_instance();
		$user_id = $ci->session->userdata('ID_USER');
		$sql = "
		select REPLACE(a.msr_no,'OR','OQ') data_id, b.jml from t_assignment a
		left join
		(select data_id, count(*) jml from t_note
					where module_kode = 'bidnote'
					and author_type='m_vendor'
					and is_read = 0 and data_id in (select REPLACE(msr_no,'OR','OQ') from t_assignment where user_id = '$user_id') group by data_id) b
					on REPLACE(a.msr_no,'OR','OQ') = b.data_id where a.user_id = '$user_id' order by data_id desc";
		return $ci->db->query($sql);
	}
	public function clarificationShow($data)
	{
		$ci =& get_instance();
		$sql = "select * from t_note
			where module_kode = 'bidnote'
			and is_read = 0
			and created_by = '$data[vendor_id]'
			and author_type = 'm_vendor'
			and data_id = '$data[msr_no] order by id desc'";
		return $ci->db->query($sql);
	}
	public function getNoRead($data='')
	{
		return $this->clarificationShow($data);
	}
	public function getVendorMsrAll()
	{
		$ci =& get_instance();
		$ci->load->model('vendor/M_vendor');
		return $ci->M_vendor->getVendorMsrAll();
	}
	public function note_clarification($data_id='')
	{
		$ci =& get_instance();
		$vendor_id = $ci->session->userdata('ID');
		$sql = "select * from t_note where data_id = '$data_id' and module_kode='bidnote' and ((created_by='$vendor_id' and author_type='m_vendor') or (author_type = 'm_user' and vendor_id = '$vendor_id')) order by id desc";
		return $ci->db->query($sql);
		// return $ci->db->where(['module_kode'=>$module_kode,'data_id'=>$data_id])->order_by('id','desc')->get('t_note');
	}

    public function getIssuedLoI($params = array())
    {
        $ci =& get_instance();
        $ci->load->model("procurement/M_loi");

        if (!isset($params['resource'])) {
            $params['resource'] = true;
        }

        return $ci->M_loi->getIssuedByVendor($ci->session->userdata('ID'), $params);
    }
    public function sop_get($where='',$msrItemList='')
    {
    	$ci =& get_instance();
        $ci->load->model("approval/M_bl");
        return $ci->M_bl->sop_get($where,$msrItemList);
    }

    public function getITPSession()
	{
		$ci =& get_instance();
		$idVendor = $ci->session->userdata('ID');

		$sql = "select id_itp from t_itp where id_vendor='$idVendor' and COALESCE(is_vendor_acc,0)=0";
		return $ci->db->query($sql);
	}
    public function getDocExpired()
	{
		$ci =& get_instance();
		$id = $ci->session->userdata('ID');

		$sql = "SELECT *
						FROM ( SELECT   document.ID_VENDOR, document.NO_DOC, document.FILE_URL, document.VALID_SINCE, document.VALID_UNTIL,
						CASE WHEN document.CATEGORY = 'CERTIFICATION' THEN 'AGENCY_AND_PRINCIPAL_CERTIFICATION' WHEN document.CATEGORY = 'SIUP' OR document.CATEGORY = 'BKPM' THEN 'BUSINESS_LICENSE' ELSE document.CATEGORY END as CATEGORY,
						w.*, CASE WHEN w.last_sent_email IS NULL THEN '-' ELSE w.last_sent_email END as last_sent_mail,
						CASE WHEN VALID_UNTIL <= NOW() THEN 'DOCUMENT EXPIRED'
						WHEN DATEDIFF(VALID_UNTIL, NOW()) <= m_document.reminder_day
						THEN CONCAT('DOCUMENT WILL BE EXPIRED ON ', DATEDIFF(VALID_UNTIL, NOW()),' DAYS') ELSE NULL
						END AS STATUS_DOCUMENT, ID as EMAIL_VENDOR
						FROM ( SELECT ID_VENDOR,NO_DOC,CATEGORY,FILE_URL,VALID_SINCE, VALID_UNTIL
									FROM m_vendor_legal_other
									UNION ALL
									SELECT ID_VENDOR, NO_DOC,'CERTIFICATION' AS CATEGORY, FILE_URL,VALID_SINCE, VALID_UNTIL
									FROM m_vendor_certification )
						document
						JOIN m_document ON m_document.document_type = document.CATEGORY
						LEFT JOIN ( SELECT vv.ID as IDV, ww.create_date as last_sent_email, ww.doc_type
									FROM i_notification ww
									JOIN m_vendor vv ON ww.recipient=vv.ID_VENDOR
									WHERE vv.ID='".$id."' ORDER BY ww.create_date DESC LIMIT 1 ) as w ON w.IDV=document.ID_VENDOR AND document.CATEGORY LIKE CONCAT('%',w.doc_type, '%')
						WHERE document.ID_VENDOR = '".$id."') document
						WHERE STATUS_DOCUMENT <> ''";
		return $ci->db->query($sql);
	}

    public function getITPSessionAccepted()
	{
		$ci =& get_instance();
		$idVendor = $ci->session->userdata('ID');

		$sql = "select id_itp from t_itp where id_vendor='$idVendor' and COALESCE(is_vendor_acc,0)=1";
		return $ci->db->query($sql);
	}

    public function get_confirmed_status($status = null) {
    	$data = array(
    		0 => 'Unresponsed',
    		1 => 'Confirmed',
    		2 => 'Decline',
    		3 => 'Widthdraw'
    	);
    	if (!is_null($status)) {
    		return $data[$status];
    	} else {
    		return $data;
    	}
    }

    public function getToBeCompletedByVendor($params = array())
    {
        $ci =& get_instance();
        $ci->load->model("procurement/M_purchase_order");

        if (!isset($params['resource'])) {
            $params['resource'] = true;
        }

        return $ci->M_purchase_order->getToBeCompletedByVendor($ci->session->userdata('ID'), $params);
    }

    public function get_negotiation($status = null) {
    	$ci = &get_instance();
    	if (!is_null($status)) {
    		if ($status == 'open') {
    			$ci->db->where('t_nego.status', 0);
    			$ci->db->where('t_nego.closed', 0);
    		}
    	}
    	return $ci->db->select('t_nego.*, t_bl.bled_no, t_eq_data.subject, m_company.DESCRIPTION as company')
    	->join('t_msr', 't_msr.msr_no = t_nego.msr_no')
    	->join('t_bl', 't_bl.msr_no = t_msr.msr_no')
        ->join('t_eq_data', 't_eq_data.msr_no = t_msr.msr_no')
        ->join('m_msrtype', 'm_msrtype.ID_MSR = t_msr.id_msr_type')
        ->join('m_company', 'm_company.ID_COMPANY = t_msr.id_company')
        ->join('m_user', 'm_user.ID_USER = t_msr.create_by')
        ->join('m_departement', 'm_departement.ID_DEPARTMENT = m_user.ID_DEPARTMENT')
        ->join('t_assignment', 't_assignment.msr_no = t_msr.msr_no')
        ->where('t_nego.vendor_id', $ci->session->userdata('ID'))
        ->order_by('t_nego.created_at', 'DESC')
        ->get('t_nego')
        ->result();
    }

    public function find_negotiation($id) {
    	$ci = &get_instance();
    	return $ci->db->select('t_nego.*, t_bl.bled_no, t_eq_data.subject, m_company.DESCRIPTION as company, m_currency.CURRENCY as currency')
    	->join('t_msr', 't_msr.msr_no = t_nego.msr_no')
    	->join('t_bl', 't_bl.msr_no = t_msr.msr_no')
        ->join('t_eq_data', 't_eq_data.msr_no = t_msr.msr_no')
        ->join('m_currency', 'm_currency.ID = t_eq_data.currency')
        ->join('m_msrtype', 'm_msrtype.ID_MSR = t_msr.id_msr_type')
        ->join('m_company', 'm_company.ID_COMPANY = t_msr.id_company')
        ->join('m_user', 'm_user.ID_USER = t_msr.create_by')
        ->join('m_departement', 'm_departement.ID_DEPARTMENT = m_user.ID_DEPARTMENT')
        ->join('t_assignment', 't_assignment.msr_no = t_msr.msr_no')
        ->where('t_nego.vendor_id', $ci->session->userdata('ID'))
        ->where('t_nego.id', $id)
        ->get('t_nego')
        ->row();
    }

    public function get_negotiation_items($id) {
    	$ci = &get_instance();
    	return $ci->db->select('t_sop.*, t_nego_detail.id_currency, t_nego_detail.id_currency_base, t_nego_detail.latest_price, t_nego_detail.negotiated_price, t_nego_detail.negotiated_price_base, t_nego_detail.nego, t_msr_item.priceunit, m_itemtype.ITEMTYPE_DESC as item_type, t_sop_bid.unit_price as bid_price')
    	->join('t_sop', 't_sop.id = t_nego_detail.sop_id')
    	->join('t_sop_bid', 't_sop_bid.sop_id = t_nego_detail.sop_id AND t_sop_bid.vendor_id = t_nego_detail.vendor_id')
    	->join('t_msr_item', 't_msr_item.line_item = t_sop.msr_item_id AND t_msr_item.msr_no = t_sop.msr_no')
        ->join('m_itemtype', 'm_itemtype.ID_ITEMTYPE = t_msr_item.id_itemtype')
        ->where('t_nego_detail.nego_id', $id)
    	->where('t_nego_detail.vendor_id', $ci->session->userdata('ID'))
    	->get('t_nego_detail');
    }
    public function acceptanceAmendment($value='')
    {
    	$ci =& get_instance();
    	$id = $ci->session->userdata('ID');

    	$sql = "SELECT t_purchase_order.*
		FROM t_purchase_order
		LEFT JOIN t_arf on t_arf.po_no = t_purchase_order.po_no
		LEFT JOIN t_arf_response on t_arf_response.doc_no = t_arf.doc_no
		WHERE t_arf_response.id in (SELECT t_approval_arf_recom.id_ref from t_approval_arf_recom WHERE t_approval_arf_recom.sequence = 8 and t_approval_arf_recom.status = 1) and t_purchase_order.id_vendor = $id";
		$q = $ci->db->query($sql);
		return $q;
    }
}
