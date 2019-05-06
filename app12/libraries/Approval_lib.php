<?php 

class Approval_lib 
{
	
	function __construct()
	{
		$ci =& get_instance();
		$sesi = $ci->session->userdata();
	}
	public function penHeader($msr_no='')
	{
		$ci =& get_instance();
    $ci->load->model('approval/M_bl');
   	return $ci->M_bl->tbld($msr_no);
	}
	public function penIsi($msr_no='')
	{
		$ci =& get_instance();
    $ci->load->model('approval/M_bl');
   	return $ci->M_bl->tbld_isi($msr_no);
	}
	public function msrItem($msr_no='')
	{
		$ci =& get_instance();
    	$ci->load->model('approval/M_bl');
   		return $ci->M_bl->tbmi($msr_no);
	}
	public function priceVendorByItem($line_item, $vendor_id, $bled_no)
	{
		$ci =& get_instance();
    	$ci->load->model('approval/M_bl');
   		return $ci->M_bl->priceVendorByItem($line_item, $vendor_id, $bled_no);
	}
	public function getVendorPass($msr_no)
	{
		$ci =& get_instance();
	    $ci->load->model('approval/M_bl');
	   	return $ci->M_bl->getVendorPass($msr_no);
	}
	public function log($data = array())
	{
		$ci =& get_instance();
		$ci->load->model('approval/M_log');
	   	return $ci->M_log->store($data);
	}
	public function log_lists($data = array())
	{
		$ci =& get_instance();
		$ci->load->model('approval/M_log');
	   	return $ci->M_log->daftar($data);
	}
	public function log_list_view($data = array())
	{
		$ci =& get_instance();
		$ci->load->model('approval/M_log');
		$data['log_lists'] = $this->log_lists($data);
	   	return $ci->load->view('approval/log_list_view', $data);
	}
	public function getBidderPass($msr_no='')
	{
		$ci =& get_instance();
	    $ci->load->model('approval/M_bl');
	   	return $ci->M_bl->getBidderPass($msr_no);
	}
	public function bidDetailByBled($bled_no='')
	{
		$ci =& get_instance();
	    $ci->load->model('approval/M_bl');
	   	return $ci->M_bl->bidDetailByBled($bled_no);
	}
	public function getRejectByMsr($msr_no='')
	{
		$ci =& get_instance();
	    $ci->load->model('approval/M_approval');
	   	return $ci->M_approval->getRejectByMsr($msr_no);
	}
	public function getLog($data='')
	{
		$ci =& get_instance();
		$ci->load->model('approval/M_log');
		return $ci->M_log->daftar($data);
	}
	public function getLogView($data='')
	{
		# code...
	}
	public function getApprovalList($data_id,$module='msr')
	{
		$ci =& get_instance();
		$ci->load->model('approval/M_approval');
		return $ci->M_approval->getApprovalList($data_id,$module);
	}
	public function getApprovalUserManager($data_id)
	{
		$ci =& get_instance();
		$ci->load->model('approval/M_approval');
		return $ci->M_approval->getApprovalUserManager($data_id);
	}
	public function listApprovalEd($msr_no='')
	{
		$ci =& get_instance();
		$ci->load->model('approval/M_approval');
		return $ci->M_approval->listApprovalEd($msr_no);
	}
	public function listApprovalAward($msr_no='')
	{
		$ci =& get_instance();
		$ci->load->model('approval/M_approval');
		return $ci->M_approval->listApprovalAward($msr_no);
	}
	public function getAssignmentAgreement($id_user='')
	{
		$ci =& get_instance();
		$ci->load->model('approval/M_bl');
		return $ci->M_bl->getAssignmentAgreement($id_user);
	}
	public function getMsrAssignment($id_user='')
	{
		$ci =& get_instance();
		$ci->load->model('approval/M_bl');
		return $ci->M_bl->getMsrAssignment($id_user);
	}
	public function getMsr($msr_no='')
	{
		$ci =& get_instance();
		$ci->load->model('approval/M_bl');
		return $ci->M_bl->getTbmsr($msr_no);
	}
	public function getEd($msr_no='')
	{
		$ci =& get_instance();
		$ci->load->model('approval/M_bl');
		return $ci->M_bl->getEdFromMsr($msr_no);
	}
	public function contract_review($msr_no='')
	{
		$ci =& get_instance();
		$ci->load->model('approval/M_approval');
		return $ci->M_approval->contract_review($msr_no);
	}
	public function msrSpaInMsr($msr='')
	{
		$ci =& get_instance();
		$ci->load->model('approval/M_approval');
		return $ci->M_approval->view_approval()
			->where(['data_id'=>$msr->msr_no])
			->where_in('m_approval_id',[7,8])
			->order_by('t_approval.urutan','asc')
			->get('t_approval');
	}
}