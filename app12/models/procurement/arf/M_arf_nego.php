<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_arf_nego extends CI_Model {

	protected $table = 't_arf_nego';
	protected $table_detail = 't_arf_nego_detail';

	public function __construct() {
        parent::__construct();
    }
    public function get()
    {
    	return $this->db->get($this->table);
    }
    public function get_detail()
    {
    	return $this->db->get($this->table_detail);
    }
    public function with_vendor($id = 0, $is_vendor= 1)
    {
    	$sql = "select b.*,t_arf.po_no,t_purchase_order.title, m_company.ABBREVIATION as company, m_departement.DEPARTMENT_DESC as department,u.NAME as ps, t_arf_notification.response_date as close_date, a.id as nego_id,t_arf_notification.dated as notification_date,t_purchase_order.id_vendor,a.company_letter_no, a.tanggal nego_date, a.supporting_document, a.note note_nego,m_currency.CURRENCY as currency, a.bid_letter_no, a.id_local_content_type, a.local_content, a.note_vendor, a.vendor_response_date
    	from t_arf_nego a 
    	left join t_arf_response b on a.arf_response_id = b.id 
    	left join t_arf on t_arf.doc_no = b.doc_no 
    	left join t_purchase_order on t_purchase_order.po_no = t_arf.po_no
    	left join t_msr on t_msr.msr_no = t_purchase_order.msr_no
    	left join m_company on m_company.ID_COMPANY = t_msr.id_company
    	left join m_user on m_user.ID_USER = t_msr.create_by
    	left join m_departement on m_departement.ID_DEPARTMENT = m_user.ID_DEPARTMENT
    	left join t_arf_assignment on t_arf_assignment.doc_id = t_arf.id
    	left join m_user u on u.ID_USER = t_arf_assignment.user_id
		left join t_arf_notification on t_arf_notification.doc_no = b.doc_no
		left join m_currency on m_currency.ID = t_arf.currency_id
    	where a.status in (1,0) and ";
        
        $not_in_approval = $this->not_in_approval('a.arf_response_id');
        $sql .= $not_in_approval;

    	if($is_vendor == 1)
    	{
    		 $sql .= " and t_purchase_order.id_vendor = ".$this->session->userdata('ID');
    	}
    	if($id > 0)
    	{
    		$sql .= " and a.id = $id";
    	}
    	return $this->db->query($sql);
    }
    public function detail($arf_nego_id='')
    {
    	// return $this->db->select('t_arf_sop.*,t_arf_response_detail.unit_price,t_arf_nego_detail.id nego_detail_id,t_arf_nego_detail.is_nego')
    	// ->join('t_arf_sop','t_arf_sop.id = t_arf_nego_detail.arf_sop_id','left')
    	// ->join('t_arf_response','t_arf_response.id = t_arf_sop.arf_response_id')
    	// ->join('t_arf_response_detail','t_arf_response_detail.doc_no = t_arf_response.doc_no')
    	// ->where(['arf_response_id'=>$arf_response_id])->get($this->table_detail);
    	return $this->db->query("select c.*, b.unit_price,d.is_nego,d.id nego_detail_id, d.unit_price new_price 
        from t_arf_response a 
        left join t_arf_response_detail b on a.doc_no = b.doc_no
        left join t_arf_sop c on b.detail_id = c.id
        left join t_arf_nego_detail d on d.arf_sop_id = c.id where arf_nego_id = $arf_nego_id ");
    }
    public function response_vendor()
    {
    	$this->db->trans_begin();
    	$post = $this->input->post();
    	$arf_nego_id = $post['arf_nego_id'];
    	$new_price = $post['new_price'];
    	// $id_local_content_type = $post['id_local_content_type'];
    	$bid_letter_no = $post['bid_letter_no'];
    	// $local_content = $post['local_content'];
    	$note = $post['note'];

        // $updateField = ['status'=>1, 'bid_letter_no'=>$bid_letter_no, 'id_local_content_type'=>$id_local_content_type, 'local_content'=>$local_content, 'note_vendor'=>$note ];
    	$updateField = ['status'=>1, 'bid_letter_no'=>$bid_letter_no, 'note_vendor'=>$note, 'vendor_response_date' =>date("Y-m-d") ];
    	
    	$config['upload_path']  = './upload/arf_nego/';
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'],0755,TRUE);
        }
        $config['allowed_types']= '*';
        
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('local_content_file'))
        {
            $display_errors =  $this->upload->display_errors('', '');
            echo json_encode(['status'=>false,'msg'=>$display_errors]);
            exit;
        }else
        {
            $data = $this->upload->data();
            $updateField['local_content_file'] = $data['file_name'];
        }

    	$this->db->where(['id'=>$arf_nego_id]);
    	$this->db->update('t_arf_nego', $updateField);

    	foreach ($new_price as $key => $value) {

    		$fieldDetail = ['unit_price'=>str_replace(',','',$value)];
    		$this->db->where(['id'=>$key]);
    		$this->db->update('t_arf_nego_detail',$fieldDetail);

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
    public function not_in_approval($column='')
    {
        $sql = "$column not in (select id_ref from t_approval_arf_recom group by id_ref)";
        // $sql = "1=1";
        return $sql;
    }
}