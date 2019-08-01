<<<<<<< HEAD
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ed extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('string', 'text'));
        $this->load->model('approval/M_approval');
        $this->load->model('vendor/M_send_invitation')->model('vendor/M_vendor');
        $this->load->model('setting/M_master_department');
        $this->load->model('procurement/M_msr', 'msr');
        $this->load->model('approval/M_bl')->model('approval/M_ed');
        $this->load->model('procurement/M_msr_item', 'msr_item');
        $this->load->model('procurement/M_msr_attachment', 'msr_attachment');
        $this->load->model('M_sendmail', 'sendmailTo');
        $this->load->helper('exchange_rate_helper')->helper(array('form', 'array', 'url', 'exchange_rate'));
    }
    public function index($value='')
    {
    	$get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $data['eds'] = $this->getEdList();
//        echo $data['eds'];
//        die();
        //konfigurasi pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url('approval/ed/index'); //site url
        $config['total_rows'] = $data['eds']->num_rows(); //total row
        $config['per_page'] = 10;  //show record per halaman
        $config["uri_segment"] = 4;  // uri parameter
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);

        // Membuat Style pagination untuk BootStrap v4
      	$config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['next_link']        = 'Next';
        $config['prev_link']        = 'Prev';
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';

        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        $data['data'] = $this->getEdListLimit($config["per_page"], $data['page']);

        $data['pagination'] = $this->pagination->create_links();

        $this->template->display('approval/ed_list', $data);
    }
    public function getEdList()
    {
    	$eds = $this->db->select("t_eq_data.*,replace(t_eq_data.msr_no,'OR','OQ') ed_no")->where(['status'=>1])->order_by('msr_no','desc')->get('t_eq_data');
//    	$lastquery = $this->db->last_query();
    	return $eds;
    }
    public function getEdListLimit($limit,$start)
    {
        $user = user();
        $roles              = explode(",", $user->ROLES);
        $roles      = array_values(array_filter($roles));

        if($user->ID_USER == 164 or $user->ID_USER == 165 or $user->ID_USER == 166 or  $user->ID_USER == 167 or in_array(bled, $roles) or in_array(proc_committe, $roles))
        {
            if($this->input->get('user'))
            {
                $this->db->where('t_assignment.user_id = '.$this->input->get('user'));
                // echo "<pre>";
                $getAssignmentAgreement = $this->getAssignmentAgreement($this->input->get('user'));
                // echo count($getAssignmentAgreement);
                // echo "<br>";
                /*exit();*/
                if(is_array($getAssignmentAgreement))
                {
                    $this->db->where_in('t_msr.msr_no',$getAssignmentAgreement);
                }

            }
        }
        else
        {
            $eds =$this->db->where('t_msr.ID_DEPARTMENT = '.$user->ID_DEPARTMENT);
        }
    	$eds = $this->db->select("t_eq_data.*, t_msr.id_currency, t_msr.status as msr_stts, t_msr.total_amount, m_currency.CURRENCY,replace(t_eq_data.msr_no,'OR','OQ') ed_no, m_departement.DEPARTMENT_DESC as department, specialist.NAME as specialist, (CASE WHEN approval.approval_posisition IS NULL THEN 'Completed' ELSE approval.approval_posisition END) as approval_posisition")
        ->join('t_msr', 't_msr.msr_no = t_eq_data.msr_no', 'left')
        ->join('m_user', 'm_user.ID_USER = t_msr.create_by', 'left')
        ->join('m_departement', 'm_departement.ID_DEPARTMENT = t_msr.ID_DEPARTMENT', 'left')
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
        ->join('m_currency', 'm_currency.ID = t_msr.id_currency')
        ->where_in('t_msr.status', [0,1])
        ->order_by('msr_no','desc')->get('(select * from t_eq_data where status = 1) t_eq_data');
        if($this->input->get('debug'))
        {
            echo "<pre>";
            echo "num : ".$eds->num_rows();
            echo "<br> : ".$this->db->last_query();
            exit();
        }
    	return $eds;
    }
    public function draft($value='')
    {
        $rs = $this->M_approval->ed_draft();
        $data['rs'] = $rs;
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $data['titleApp'] = 'ED Draft';
        $this->template->display('approval/eddraft', $data);
    }
    public function draft_view($msr_no='')
    {
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        $this->load->model('vendor/M_registered_supplier', 'mrs');
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;

        $greetings = $this->M_approval->greetings_msr();
        $data['greetings'] = $greetings;
        $t_approval = $this->db->where(['data_id'=>$msr_no, 'm_approval_id'=>13])->get('t_approval')->row();
        $data['idnya'] = $t_approval->id;
        $data['msr_no'] = $msr_no;
        $data['msr'] = $this->db->select('t_msr.*,m_company.DESCRIPTION company_name,m_msrtype.MSR_DESC msr_name, m_plocation.PGroup_Desc proc_location_name, m_costcenter.COSTCENTER_DESC cost_center_name, m_pmethod.PMETHOD_DESC proc_method_name, m_currency.CURRENCY currency')
        ->join('m_company','m_company.ID_COMPANY=t_msr.id_company')
        ->join('m_msrtype','m_msrtype.ID_MSR=t_msr.id_msr_type')
        ->join('m_plocation','m_plocation.ID_Pgroup=t_msr.id_ploc')
        ->join('m_user','m_user.ID_USER=t_msr.create_by')
        ->join('m_costcenter','m_costcenter.ID_COSTCENTER=m_user.COST_CENTER')
        ->join('m_pmethod','m_pmethod.ID_PMETHOD=t_msr.id_pmethod')
        ->join('m_currency','m_currency.ID=t_msr.id_currency')
        ->where('msr_no',$msr_no)->get('t_msr')->row();
        /*$data['approval'] = $this->db->select('t_approval.*,m_approval.role_id')
        ->join('m_approval','m_approval.id=t_approval.m_approval_id')
        ->where('t_approval.id',$approval_id)
        ->get('t_approval')->row();*/
        $data['method']       = $this->db->get('m_pmethod')->result();
        $data['doc']       = $this->db->where(['module_kode'=>'bled','data_id'=>$msr_no])->get('t_upload')->result();
        $data['t_bl']       = $this->db->where(['msr_no'=>$msr_no])->get('t_bl')->row();
        $data['ed']       = $this->db->where(['msr_no'=>$msr_no])->get('t_eq_data')->row();
        $data['tbmi2']       = $this->M_bl->tbmi2($msr_no);
        /*print_r($data['ed']);
        exit();*/
        $this->session->set_userdata('referred_from', current_url());
        $data['checkBlEd']  = $this->checkBlEd($msr_no);
        // $data['vendor']  = $this->mrs->show2();
        $data['js']         = $this->load->view('approval/devbledjs', array(), true);
        $this->template->display('approval/draft_view', $data);
    }
    public function checkBlEd($msr_no='')
    {
        /*attachment*/
        // $sql = "select count(id) jml from t_upload where module_kode='bled' and data_id = '$msr_no' group by tipe";
        $sql = "select count(id) jml from t_upload where module_kode='bled' and data_id = '$msr_no' and tipe = 0";
        $query = $this->db->query($sql)->row();
        $attachment0 = $query->jml;

        $sql = "select count(id) jml from t_upload where module_kode='bled' and data_id = '$msr_no' and tipe = 2";
        $query = $this->db->query($sql)->row();
        $attachment2 = $query->jml;

        $sql = "select count(id) jml from t_upload where module_kode='bled' and data_id = '$msr_no' and tipe between 3 and 12";
        $query = $this->db->query($sql)->row();
        $attachmentE = $query->jml;
        /*SOP*/
        $query = $this->M_bl->getSopValidation($msr_no)->num_rows();
        $sop = $query;

        /*eq data*/
        $eq = $this->db->where('msr_no',$msr_no)->get('t_eq_data')->num_rows();
        /*bl data*/
        $bl = $this->db->where('msr_no',$msr_no)->get('t_bl')->num_rows();
        /*bl detail data*/
        $bld = $this->db->where('msr_no',$msr_no)->get('t_bl_detail')->num_rows();

        if($this->input->get('debug') == 1)
        {
            echo "
                attachment0 = $attachment0 <br>
                attachment2 = $attachment2 <br>
                attachmentE = $attachmentE <br>
                eq = $eq <br>
                bl = $bl <br>
                bld = $bld <br>
                sop = $sop <br>
            ";
        }
        if($attachment0 > 0 and $attachment2 > 0 and $attachmentE > 0 and $eq > 0 and $bl > 0 and $bld > 0 and $sop > 0)
            return true;

        return false;
    }
    public function list_approval($data_id='')
    {
        $q = "select t_approval.*,m_user.NAME nama,m_user_roles.DESCRIPTION role_name
        from t_approval
        left join m_user on m_user.ID_USER = t_approval.creted_by
        left join m_approval on m_approval.id = t_approval.m_approval_id
        LEFT JOIN m_user_roles on m_approval.role_id = m_user_roles.ID_USER_ROLES
        where data_id = '$data_id' and m_approval_id IN (8,9,10,11,12)";
        $r = $this->db->query($q);
        $data['r'] = $r;
        $data['data_id'] = $data_id;
        $this->load->view('approval/ed_approval_list', $r);
        // return $this->db->query($q);
    }
    public function approve($value='')
    {
        $result = $this->M_approval->edapprove();
        $data = $this->input->post();
        $getApprovalList = $this->approval_lib->getApprovalListEd($data['data_id']);
        if($getApprovalList->num_rows() > 0){
            echo json_encode(['msg'=>$msg.' Approve','status'=>true]);
        }
        else
        {
            /**/
            $desc = $msg.' Approve';
            $t_approval = $this->db->where(['id'=>$this->input->post('id')])->get('t_approval')->row();
            if($this->input->post('module_kode') == 'msr_spa' and $t_approval->m_approval_id  == 7){
                $desc = $data['status'] == 1 ? "MSR Verified" : "Reject";
            }
            echo json_encode(['msg'=>$desc]);
        }
    }
    public function reject($value='')
    {
        $result = $this->M_approval->edreject();
    }
    public function savedraft($submit=0, $t_approval_id=0)
    {
        $data = $this->input->post();
        /*
          msr_no            :bl_msr_no,
          subject           :subject,
          prebiddate        :prebiddate,
          prebid_address    :prebid_address,
          closing_date      :closing_date,
          commercial_data   :commercial_data,
          currency          :currency,
          bid_validity      :bid_validity,
          bid_bond_type     :bid_bond_type,
          bid_bond          :bid_bond,
          bid_bond_validity :bid_bond_validity,
          prebid_loc        :prebid_loc,
          packet            :packet,
          envelope_system   :envelope_system,
          incoterm          :incoterm,
          delivery_point    :delivery_point,
          bl_pm             :bl_pm
        */
        $this->db->trans_begin();
        /*ed*/
        $user = user();
        $ed_data['msr_no']              = $data['msr_no'];
        $ed_data['subject']             = $data['subject'];
        $ed_data['prebiddate']          = $data['prebiddate'];
        $ed_data['prebid_address']      = $data['prebid_address'];
        $ed_data['closing_date']        = $data['closing_date'];
        $ed_data['currency']            = $data['currency'];
        $ed_data['bid_validity']        = $data['bid_validity'];
        $ed_data['bid_bond_type']       = $data['bid_bond_type'];
        $ed_data['bid_bond']            = $data['bid_bond'];
        $ed_data['bid_bond_validity']   = $data['bid_bond_validity'];
        $ed_data['prebid_loc']          = $data['prebid_loc'];
        $ed_data['packet']              = $data['packet'];
        $ed_data['envelope_system']     = $data['envelope_system'];
        $ed_data['incoterm']            = $data['incoterm'];
        $ed_data['delivery_point']      = $data['delivery_point'];
        $ed_data['commercial_data']     = $data['commercial_data'];
        $ed_data['created_by']          = $user->ID_USER;
        $ed_data['status']              = $submit == 1 ? 1 : 0;
        $ed = $this->db->where('msr_no',$data['msr_no'])->get('t_eq_data');
        if($ed->num_rows() > 0)
        {
            $this->db->where('id',$ed->row()->id);
            $this->db->update('t_eq_data',$ed_data);
        }
        else
        {
            $this->db->insert('t_eq_data',$ed_data);
        }
        /*bl*/
        $xdata['title']         = $data['subject'];
        $xdata['msr_no']        = $data['msr_no'];
        $xdata['pmethod']       = $data['bl_pm'];
        $xdata['created_by']    = $user->ID_USER;
        $xdata['status']        = $submit == 1 ? 1 : 0;
        $xdata['bled_no']       = str_replace('OR', 'OQ', $data['msr_no']);
        $bl = $this->db->where('msr_no',$data['msr_no'])->get('t_bl');

        if($bl->num_rows() > 0)
        {
            $this->db->where('id',$bl->row()->id);
            $this->db->update('t_bl',$xdata);
        }
        else
        {
            $this->db->insert('t_bl',$xdata);
        }
        $msg = 'Success, Save Draft';
        if($submit > 0)
        {
            $this->approval_lib->log([
                'module_kode'=> 'msr',
                'data_id'=> $data['msr_no'],
                'description'=> 'Submitted BLED',
                'created_by'=> $this->session->userdata('ID_USER')
            ]);
            if($this->M_approval->checkReject($data['msr_no'])->num_rows() > 0)
            {
                $checkReject = $this->M_approval->checkReject($data['msr_no'])->row();
                if($checkReject->m_approval_id == 8)
                {
                    $d['status'] = 4;
                }
                else
                {
                    $d['status'] = 0;
                }
                $this->db->where('id',$checkReject->approval_id);
                $this->db->update('t_approval', $d);
            }
            else
            {
                $this->db->where('id',$t_approval_id);
                $this->db->update('t_approval', ['status'=>5]);
            }

            $this->db->where('msr_no',$data['msr_no']);
            $t_bl = $this->db->get('t_bl')->row();
            $msg =  "Bidder List & Enquiry Document No. $t_bl->bled_no created";
        }

        if($this->db->trans_status() === true)
        {
            $this->db->trans_commit();
            echo json_encode(['msg'=>$msg]);
        }
        else
        {
            $this->db->trans_rollback();
            echo json_encode(['msg'=>'Fail, Please Try Again']);
        }
    }
    public function submitbled($msr_no='', $t_approval_id=0)
    {
        $d = $this->input->post();
        /*bidder list*/
        $pm             = $d['bl_pm'];
        $getBl = $this->vendor_lib->getBl(['msr_no'=>$d['bl_msr_no']]);
        $num = $getBl->num_rows();

        $pmValidation = true;
        $dataPm = [''=>'v'];
        if($pm == 'DA')
        {
            if($num > 1)
            {
                $dataPm = ['DA'=>'DA Must 1 Supplier'];
                $pmValidation = false;
            }
        }
        if($pm == 'DS')
        {
            if($num != 2)
            {
                $dataPm = ['DS'=>'DS Must 2 Supplier'];
                $pmValidation = false;
            }
        }
        if($pm == 'TN')
        {
            if($num >= 3)
            {

            }
            else
            {
                $dataPm = ['TN'=>'TN Minimum 3 Supplier'];
                $pmValidation = false;
            }
        }

        /*check*/
        $sql = "select count(id) jml from t_upload where module_kode='bled' and data_id = '$msr_no' and tipe = 0";
        $query = $this->db->query($sql)->row();
        $attachment0 = $query->jml;

        $sql = "select count(id) jml from t_upload where module_kode='bled' and data_id = '$msr_no' and tipe = 2";
        $query = $this->db->query($sql)->row();
        $attachment2 = $query->jml;

        $sql = "select count(id) jml from t_upload where module_kode='bled' and data_id = '$msr_no' and tipe between 3 and 12";
        $query = $this->db->query($sql)->row();
        $attachmentE = $query->jml;
        /*SOP*/
        $query = $this->M_bl->getSopValidation($msr_no)->num_rows();
        $sop = $query;

        /*msr_item*/
        $t_msr_item = $this->db->where('msr_no',$msr_no)->get('t_msr_item')->num_rows();

        $validEd = [
            'subject'             => 'Subject',
            'closing_date'        => 'Closing Date',
            'bid_validity'        => 'Bid Validty',
        ];
        $d = $this->input->post();
        $prebid = true;
        $d['prebid'] = true;
        if($d['prebid_loc'] > 0)
        {
            if($d['prebiddate'] and $d['prebid_address'])
            {

            }
            else
            {
                $d['prebid'] = false;
                $prebid = false;
            }
        }
        $bidbond = true;
        $d['bidbond'] = true;
        if($d['bid_bond_type'] == 1 or $d['bid_bond_type'] == 3)
        {
            if($d['bid_bond_validity'] and $d['bid_bond'])
            {

            }
            else
            {
                $d['bidbond'] = false;
                $bidbond = false;
            }
        }

        if($attachment0 > 0 and $attachment2 > 0 and $attachmentE > 0 and $sop == $t_msr_item and $d['subject'] and $prebid and $d['closing_date'] and $d['bid_validity'] and $pmValidation)
        {
            $status = false;
        }
        else
        {
            $status = true;
        }

        $data['html'] = $this->load->view('approval/sop_doc_validation',[
            'msr_no'      => $msr_no,
            'validEd'     => $validEd,
            'attachment0' => $attachment0,
            'attachment2' => $attachment2,
            'attachmentE' => $attachmentE,
            'sop'         => $sop,
            't_msr_item'  => $t_msr_item,
            'p'           => $d,
            'dataPm'      => $dataPm,
            ], true);
        $data['status'] = $status;
        $ed_no = str_replace('OR', 'OQ', $msr_no);
        if($status === true)
        {
            $this->session->set_flashdata('message', array(
                'message' => __('success_submit_with_number', array('no' => $ed_no)),
                'type' => 'success'
            ));
            echo json_encode($data);
        }
        else
        {
            $_POST['msr_no'] = $_POST['bl_msr_no'];
            $this->savedraft(1, $t_approval_id);
        }
    }
    public function approval_ajax($msr_no='')
    {
        $data['msr_no'] = $msr_no;
        $this->load->view('approval/ed_approval_ajax', $data);
    }

    public function save_addendum($submit=0, $t_approval_id=0) {
        $this->db->trans_begin();
        $user = user();
        $data = $this->input->post();
        $response = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('no_addendum', 'Addendum No', 'required');
        $this->form_validation->set_rules('resume', 'Resume', 'required');
        if (!$this->form_validation->run()) {
            $response = array(
                'success' => false,
                'message' => validation_errors('<div>', '</div>')
            );
            echo json_encode($response);
            return false;
        }
        $result = $this->db->insert('t_addendum', array(
            'no_addendum' => $data['no_addendum'],
            'module' => 'bled',
            'id_ref' => $data['msr_no'],
            'resume' => htmlspecialchars($data['resume']),
            'created_by' => $this->session->userdata('ID_USER'),
            'created_at' => date('Y-m-d H:i:s')
        ));
        $ed_data['msr_no']              = $data['msr_no'];
        $ed_data['subject']             = $data['subject'];
        $ed_data['prebiddate']          = $data['prebiddate'];
        $ed_data['prebid_address']      = $data['prebid_address'];
        $ed_data['closing_date']        = $data['closing_date'];
        $ed_data['currency']            = $data['currency'];
        $ed_data['bid_validity']        = $data['bid_validity'];
        $ed_data['bid_bond_type']       = $data['bid_bond_type'];
        $ed_data['bid_bond']            = $data['bid_bond'];
        $ed_data['bid_bond_validity']   = $data['bid_bond_validity'];
        $ed_data['prebid_loc']          = $data['prebid_loc'];
        $ed_data['packet']              = $data['packet'];
        $ed_data['envelope_system']     = $data['envelope_system'];
        $ed_data['incoterm']            = $data['incoterm'];
        $ed_data['delivery_point']      = $data['delivery_point'];
        $ed_data['commercial_data']     = $data['commercial_data'];
        $ed_data['created_by']          = $user->ID_USER;
        $ed = $this->db->where('msr_no',$data['msr_no'])->get('t_eq_data');
        if($ed->num_rows() > 0)
        {
            $this->db->where('id',$ed->row()->id);
            $this->db->update('t_eq_data',$ed_data);
        }
        else
        {
            $this->db->insert('t_eq_data',$ed_data);
        }
        $t_bl_detail = $this->db->where('msr_no', $data['msr_no'])
        ->get('t_bl_detail')
        ->result();
        foreach ($t_bl_detail as $bl_detail) {
            $this->db->insert('t_note', array(
                'module_kode' => 'addendum_bled',
                'data_id' => $data['msr_no'],
                'description' => $data['resume'],
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('ID_USER'),
                'author_type' => 'm_user',
                'vendor_id' => $bl_detail->vendor_id
            ));
        }
        if($this->db->trans_status() === true)
        {
            $this->db->trans_commit();
            $template = $this->db->where('ID', 65)->get('m_notic')->result();
            $img1 = '';
            $img2 = '';
            $emailData = array(
                'img1' => $img1,
                'img2' => $img2,
                'title' => $template[0]->TITLE,
                'open' => $template[0]->OPEN_VALUE,
                'close' => $template[0]->CLOSE_VALUE
            );
            foreach($this->db->where('msr_no',$data['msr_no'])->get('t_bl_detail')->result() as $key => $value){
                $vendor = $this->db->where('ID',$value->vendor_id)->get('m_vendor')->row();
                $lastquery = $this->db->last_query();
                $emailData['dest'][] = $vendor->ID_VENDOR;
            }
            $call = $this->db->where('msr_no',$data['msr_no'])->get('t_bl_detail')->result();
            $flag = $this->sendmailTo->sendMail($emailData);
            $response = array(
                'query' => $flag,
                'success' => true,
                'message' => 'Successfully save Enquiry Document Adendum'
            );
        }
        else
        {
            $this->db->trans_rollback();
            $response = array(
                'success' => false,
                'message' => 'Failed save Enquiry Document Adendum'
            );
        }
        echo json_encode($response);
    }

    public function bod_contract_review($msr_no='')
    {
        $bod_contract_review_list = $this->M_ed->bod_contract_review_list();
        if($this->input->get('debug'))
        {
            echo "<pre>";
            print_r($bod_contract_review_list);
        }
        else
        {
            $get_menu = $this->M_vendor->menu();
            $dt = array();
            foreach ($get_menu as $k => $v) {
                $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
                $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
                $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
                $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
            }
            $data['menu'] = $dt;
            $data['titleApp'] = lang('BOD Contract Review', 'BOD Contract Review');
            if($msr_no)
            {
                $data['msr'] = $this->db->where(['msr_no'=>$msr_no])->get('t_msr')->row();
                $data['ed'] = $this->db->where(['msr_no'=>$msr_no])->get('t_eq_data')->row();
                $data['cur'] = $this->db->where(['ID'=>$data['msr']->id_currency])->get('m_currency')->row();
                $this->template->display('approval/bod_contract_review_form', $data);
            }
            else
            {
                $data['lists'] = $bod_contract_review_list;
                $this->template->display('approval/bod_contract_review_list', $data);
            }
        }
    }
    public function bod_contract_review_store()
    {
        $data = $this->input->post();
        if(@$_FILES['contract_review_file']['tmp_name'])
        {
            $config['upload_path']  = './upload/contract_review/';
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'],0755,TRUE);
            }
            $config['allowed_types']= '*';
            $config['encrypt_name']= true;
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('contract_review_file'))
            {
                $err =  $this->upload->display_errors('', '');
                echo "<script>alert($err)</script>";
                echo "<script>window.open('".base_url('approval/ed/bod_contract_review/'.$data['msr_no'])."','_self')</script>";
                exit;
            }
            else
            {
                $user = user();
                $upload = $this->upload->data();
                $field['module_kode'] = 'contract review';
                $field['data_id'] = $data['msr_no'];
                $field['file_path'] = $upload['file_name'];
                $field['file_name'] = $data['contract_review_name'];
                $field['created_by'] = $user->ID_USER;
                $this->db->insert('t_upload',$field);
                echo "<script>alert('Success, Uploaded')</script>";
                echo "<script>window.open('".base_url('approval/ed/bod_contract_review')."','_self')</script>";
            }
        }
    }
    public function bod_contract_review_delete($id='')
    {
        $this->db->where(['id'=>$id]);
        $t_upload = $this->db->get('t_upload')->row();

        @unlink('upload/contract_review/'.$t_upload->file_path);

        $this->db->where(['id'=>$id]);
        $this->db->delete('t_upload');

        $base_url = base_url('approval/ed/bod_contract_review/'.$t_upload->data_id);

        echo "<script>alert('Success, Deleted')</script>";
        echo "<script>window.open('$base_url','_self')</script>";
    }
    public function getAssignmentAgreement($id_user='')
    {
        $this->db->select('t_assignment.*');
        $this->db->where(['t_assignment.user_id'=>$id_user]);
        $t_assignment = $this->db->get('t_assignment');
        $msr_no = [];
        foreach ($t_assignment->result() as $key => $value) {
          $msr_no[] = $value->msr_no;
        }
        $t_purchase_order = 0;

        if(count($msr_no) > 0)
        {
            $t_purchase_order = $this->db->where_in('msr_no',$msr_no)->where(['issued'=>1])->get('t_purchase_order');
            $msrArray = [];
            foreach ($t_purchase_order->result() as $key => $value) {
                $msrArray[] = $value->msr_no;
            }
            $newMsr = [];
            foreach ($msr_no as $key => $value) {
                if(!in_array($value, $msrArray))
                {
                    $newMsr[] = $value;
                }
            }
            // echo count($newMsr);
            // echo "<pre>";
            // print_r($newMsr);
            // exit();
          return $newMsr;
        }
        else
        {
            return false;
        }
    }
=======
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ed extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('string', 'text'));
        $this->load->model('approval/M_approval');
        $this->load->model('vendor/M_send_invitation')->model('vendor/M_vendor');
        $this->load->model('setting/M_master_department');
        $this->load->model('procurement/M_msr', 'msr');
        $this->load->model('approval/M_bl')->model('approval/M_ed');
        $this->load->model('procurement/M_msr_item', 'msr_item');
        $this->load->model('procurement/M_msr_attachment', 'msr_attachment');
        $this->load->model('M_sendmail', 'sendmailTo');
        $this->load->helper('exchange_rate_helper')->helper(array('form', 'array', 'url', 'exchange_rate'));
    }
    public function index($value='')
    {
    	$get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $data['eds'] = $this->getEdList();

        //konfigurasi pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url('approval/ed/index'); //site url
        $config['total_rows'] = $data['eds']->num_rows(); //total row
        $config['per_page'] = 10;  //show record per halaman
        $config["uri_segment"] = 4;  // uri parameter
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);

        // Membuat Style pagination untuk BootStrap v4
      	$config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['next_link']        = 'Next';
        $config['prev_link']        = 'Prev';
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';

        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        $data['data'] = $this->getEdListLimit($config["per_page"], $data['page']);

        $data['pagination'] = $this->pagination->create_links();

        $this->template->display('approval/ed_list', $data);
    }
    public function getEdList()
    {
    	$eds = $this->db->select("t_eq_data.*,replace(t_eq_data.msr_no,'OR','OQ') ed_no")->where(['status'=>1])->order_by('msr_no','desc')->get('t_eq_data');
    	return $eds;
    }
    public function getEdListLimit($limit,$start)
    {
        $user = user();
        $roles      = explode(",", $user->ROLES);
        $roles      = array_values(array_filter($roles));

        if($user->ID_USER == 164 or $user->ID_USER == 165 or $user->ID_USER == 166 or  $user->ID_USER == 167 or in_array(bled, $roles) or in_array(proc_committe, $roles))
        {
            if($this->input->get('user'))
            {
                $this->db->where('t_assignment.user_id = '.$this->input->get('user'));
                // echo "<pre>";
                $getAssignmentAgreement = $this->getAssignmentAgreement($this->input->get('user'));
                // echo count($getAssignmentAgreement);
                // echo "<br>";
                /*exit();*/
                if(is_array($getAssignmentAgreement))
                {
                    $this->db->where_in('t_msr.msr_no',$getAssignmentAgreement);
                }

            }
        }
        else
        {
            $eds =$this->db->where('t_msr.ID_DEPARTMENT = '.$user->ID_DEPARTMENT);
        }
    	$eds = $this->db->select("t_eq_data.*, t_msr.id_currency, t_msr.status as msr_stts, t_msr.total_amount, m_currency.CURRENCY,replace(t_eq_data.msr_no,'OR','OQ') ed_no, m_departement.DEPARTMENT_DESC as department, specialist.NAME as specialist, (CASE WHEN approval.approval_posisition IS NULL THEN 'Completed' ELSE approval.approval_posisition END) as approval_posisition")
        ->join('t_msr', 't_msr.msr_no = t_eq_data.msr_no', 'left')
        ->join('m_user', 'm_user.ID_USER = t_msr.create_by', 'left')
        ->join('m_departement', 'm_departement.ID_DEPARTMENT = t_msr.ID_DEPARTMENT', 'left')
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
        ->join('m_currency', 'm_currency.ID = t_msr.id_currency')
        ->where_in('t_msr.status', [0,1])
        ->order_by('msr_no','desc')->get('(select * from t_eq_data where status = 1) t_eq_data');
        if($this->input->get('debug'))
        {
            echo "<pre>";
            echo "num : ".$eds->num_rows();
            echo "<br> : ".$this->db->last_query();
            exit();
        }
    	return $eds;
    }
    public function draft($value='')
    {
        $rs = $this->M_approval->ed_draft();
        $data['rs'] = $rs;
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $data['titleApp'] = 'ED Draft';
        $this->template->display('approval/eddraft', $data);
    }
    public function draft_view($msr_no='')
    {
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        $this->load->model('vendor/M_registered_supplier', 'mrs');
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;

        $greetings = $this->M_approval->greetings_msr();
        $data['greetings'] = $greetings;
        $t_approval = $this->db->where(['data_id'=>$msr_no, 'm_approval_id'=>13])->get('t_approval')->row();
        $data['idnya'] = $t_approval->id;
        $data['msr_no'] = $msr_no;
        $data['msr'] = $this->db->select('t_msr.*,m_company.DESCRIPTION company_name,m_msrtype.MSR_DESC msr_name, m_plocation.PGroup_Desc proc_location_name, m_costcenter.COSTCENTER_DESC cost_center_name, m_pmethod.PMETHOD_DESC proc_method_name, m_currency.CURRENCY currency')
        ->join('m_company','m_company.ID_COMPANY=t_msr.id_company')
        ->join('m_msrtype','m_msrtype.ID_MSR=t_msr.id_msr_type')
        ->join('m_plocation','m_plocation.ID_Pgroup=t_msr.id_ploc')
        ->join('m_user','m_user.ID_USER=t_msr.create_by')
        ->join('m_costcenter','m_costcenter.ID_COSTCENTER=m_user.COST_CENTER')
        ->join('m_pmethod','m_pmethod.ID_PMETHOD=t_msr.id_pmethod')
        ->join('m_currency','m_currency.ID=t_msr.id_currency')
        ->where('msr_no',$msr_no)->get('t_msr')->row();
        /*$data['approval'] = $this->db->select('t_approval.*,m_approval.role_id')
        ->join('m_approval','m_approval.id=t_approval.m_approval_id')
        ->where('t_approval.id',$approval_id)
        ->get('t_approval')->row();*/
        $data['method']       = $this->db->get('m_pmethod')->result();
        $data['doc']       = $this->db->where(['module_kode'=>'bled','data_id'=>$msr_no])->get('t_upload')->result();
        $data['t_bl']       = $this->db->where(['msr_no'=>$msr_no])->get('t_bl')->row();
        $data['ed']       = $this->db->where(['msr_no'=>$msr_no])->get('t_eq_data')->row();
        $data['tbmi2']       = $this->M_bl->tbmi2($msr_no);
        /*print_r($data['ed']);
        exit();*/
        $this->session->set_userdata('referred_from', current_url());
        $data['checkBlEd']  = $this->checkBlEd($msr_no);
        // $data['vendor']  = $this->mrs->show2();
        $data['js']         = $this->load->view('approval/devbledjs', array(), true);
        $this->template->display('approval/draft_view', $data);
    }
    public function checkBlEd($msr_no='')
    {
        /*attachment*/
        // $sql = "select count(id) jml from t_upload where module_kode='bled' and data_id = '$msr_no' group by tipe";
        $sql = "select count(id) jml from t_upload where module_kode='bled' and data_id = '$msr_no' and tipe = 0";
        $query = $this->db->query($sql)->row();
        $attachment0 = $query->jml;

        $sql = "select count(id) jml from t_upload where module_kode='bled' and data_id = '$msr_no' and tipe = 2";
        $query = $this->db->query($sql)->row();
        $attachment2 = $query->jml;

        $sql = "select count(id) jml from t_upload where module_kode='bled' and data_id = '$msr_no' and tipe between 3 and 12";
        $query = $this->db->query($sql)->row();
        $attachmentE = $query->jml;
        /*SOP*/
        $query = $this->M_bl->getSopValidation($msr_no)->num_rows();
        $sop = $query;

        /*eq data*/
        $eq = $this->db->where('msr_no',$msr_no)->get('t_eq_data')->num_rows();
        /*bl data*/
        $bl = $this->db->where('msr_no',$msr_no)->get('t_bl')->num_rows();
        /*bl detail data*/
        $bld = $this->db->where('msr_no',$msr_no)->get('t_bl_detail')->num_rows();

        if($this->input->get('debug') == 1)
        {
            echo "
                attachment0 = $attachment0 <br>
                attachment2 = $attachment2 <br>
                attachmentE = $attachmentE <br>
                eq = $eq <br>
                bl = $bl <br>
                bld = $bld <br>
                sop = $sop <br>
            ";
        }
        if($attachment0 > 0 and $attachment2 > 0 and $attachmentE > 0 and $eq > 0 and $bl > 0 and $bld > 0 and $sop > 0)
            return true;

        return false;
    }
    public function list_approval($data_id='')
    {
        $q = "select t_approval.*,m_user.NAME nama,m_user_roles.DESCRIPTION role_name
        from t_approval
        left join m_user on m_user.ID_USER = t_approval.creted_by
        left join m_approval on m_approval.id = t_approval.m_approval_id
        LEFT JOIN m_user_roles on m_approval.role_id = m_user_roles.ID_USER_ROLES
        where data_id = '$data_id' and m_approval_id IN (8,9,10,11,12)";
        $r = $this->db->query($q);
        $data['r'] = $r;
        $data['data_id'] = $data_id;
        $this->load->view('approval/ed_approval_list', $r);
        // return $this->db->query($q);
    }
    public function approve($value='')
    {
        $result = $this->M_approval->edapprove();
        $data = $this->input->post();
        $getApprovalList = $this->approval_lib->getApprovalListEd($data['data_id']);
        if($getApprovalList->num_rows() > 0){
            echo json_encode(['msg'=>$msg.' Approve','status'=>true]);
        }
        else
        {
            /**/
            $desc = $msg.' Approve';
            $t_approval = $this->db->where(['id'=>$this->input->post('id')])->get('t_approval')->row();
            if($this->input->post('module_kode') == 'msr_spa' and $t_approval->m_approval_id  == 7){
                $desc = $data['status'] == 1 ? "MSR Verified" : "Reject";
            }
            echo json_encode(['msg'=>$desc]);
        }
    }
    public function reject($value='')
    {
        $result = $this->M_approval->edreject();
    }
    public function savedraft($submit=0, $t_approval_id=0)
    {
        $data = $this->input->post();
        /*
          msr_no            :bl_msr_no,
          subject           :subject,
          prebiddate        :prebiddate,
          prebid_address    :prebid_address,
          closing_date      :closing_date,
          commercial_data   :commercial_data,
          currency          :currency,
          bid_validity      :bid_validity,
          bid_bond_type     :bid_bond_type,
          bid_bond          :bid_bond,
          bid_bond_validity :bid_bond_validity,
          prebid_loc        :prebid_loc,
          packet            :packet,
          envelope_system   :envelope_system,
          incoterm          :incoterm,
          delivery_point    :delivery_point,
          bl_pm             :bl_pm
        */
        $this->db->trans_begin();
        /*ed*/
        $user = user();
        $ed_data['msr_no']              = $data['msr_no'];
        $ed_data['subject']             = $data['subject'];
        $ed_data['prebiddate']          = $data['prebiddate'];
        $ed_data['prebid_address']      = $data['prebid_address'];
        $ed_data['closing_date']        = $data['closing_date'];
        $ed_data['currency']            = $data['currency'];
        $ed_data['bid_validity']        = $data['bid_validity'];
        $ed_data['bid_bond_type']       = $data['bid_bond_type'];
        $ed_data['bid_bond']            = $data['bid_bond'];
        $ed_data['bid_bond_validity']   = $data['bid_bond_validity'];
        $ed_data['prebid_loc']          = $data['prebid_loc'];
        $ed_data['packet']              = $data['packet'];
        $ed_data['envelope_system']     = $data['envelope_system'];
        $ed_data['incoterm']            = $data['incoterm'];
        $ed_data['delivery_point']      = $data['delivery_point'];
        $ed_data['commercial_data']     = $data['commercial_data'];
        $ed_data['created_by']          = $user->ID_USER;
        $ed_data['status']              = $submit == 1 ? 1 : 0;
        $ed = $this->db->where('msr_no',$data['msr_no'])->get('t_eq_data');
        if($ed->num_rows() > 0)
        {
            $this->db->where('id',$ed->row()->id);
            $this->db->update('t_eq_data',$ed_data);
        }
        else
        {
            $this->db->insert('t_eq_data',$ed_data);
        }
        /*bl*/
        $xdata['title']         = $data['subject'];
        $xdata['msr_no']        = $data['msr_no'];
        $xdata['pmethod']       = $data['bl_pm'];
        $xdata['created_by']    = $user->ID_USER;
        $xdata['status']        = $submit == 1 ? 1 : 0;
        $xdata['bled_no']       = str_replace('OR', 'OQ', $data['msr_no']);
        $bl = $this->db->where('msr_no',$data['msr_no'])->get('t_bl');

        if($bl->num_rows() > 0)
        {
            $this->db->where('id',$bl->row()->id);
            $this->db->update('t_bl',$xdata);
        }
        else
        {
            $this->db->insert('t_bl',$xdata);
        }
        $msg = 'Success, Save Draft';
        if($submit > 0)
        {
            $this->approval_lib->log([
                'module_kode'=> 'msr',
                'data_id'=> $data['msr_no'],
                'description'=> 'Submitted BLED',
                'created_by'=> $this->session->userdata('ID_USER')
            ]);
            if($this->M_approval->checkReject($data['msr_no'])->num_rows() > 0)
            {
                $checkReject = $this->M_approval->checkReject($data['msr_no'])->row();
                if($checkReject->m_approval_id == 8)
                {
                    $d['status'] = 4;
                }
                else
                {
                    $d['status'] = 0;
                }
                $this->db->where('id',$checkReject->approval_id);
                $this->db->update('t_approval', $d);
            }
            else
            {
                $this->db->where('id',$t_approval_id);
                $this->db->update('t_approval', ['status'=>5]);
            }

            $this->db->where('msr_no',$data['msr_no']);
            $t_bl = $this->db->get('t_bl')->row();
            $msg =  "Bidder List & Enquiry Document No. $t_bl->bled_no created";
        }

        if($this->db->trans_status() === true)
        {
            $this->db->trans_commit();
            echo json_encode(['msg'=>$msg]);
        }
        else
        {
            $this->db->trans_rollback();
            echo json_encode(['msg'=>'Fail, Please Try Again']);
        }
    }
    public function submitbled($msr_no='', $t_approval_id=0)
    {
        $d = $this->input->post();
        /*bidder list*/
        $pm             = $d['bl_pm'];
        $getBl = $this->vendor_lib->getBl(['msr_no'=>$d['bl_msr_no']]);
        $num = $getBl->num_rows();

        $pmValidation = true;
        $dataPm = [''=>'v'];
        if($pm == 'DA')
        {
            if($num > 1)
            {
                $dataPm = ['DA'=>'DA Must 1 Supplier'];
                $pmValidation = false;
            }
        }
        if($pm == 'DS')
        {
            if($num != 2)
            {
                $dataPm = ['DS'=>'DS Must 2 Supplier'];
                $pmValidation = false;
            }
        }
        if($pm == 'TN')
        {
            if($num >= 3)
            {

            }
            else
            {
                $dataPm = ['TN'=>'TN Minimum 3 Supplier'];
                $pmValidation = false;
            }
        }

        /*check*/
        $sql = "select count(id) jml from t_upload where module_kode='bled' and data_id = '$msr_no' and tipe = 0";
        $query = $this->db->query($sql)->row();
        $attachment0 = $query->jml;

        $sql = "select count(id) jml from t_upload where module_kode='bled' and data_id = '$msr_no' and tipe = 2";
        $query = $this->db->query($sql)->row();
        $attachment2 = $query->jml;

        $sql = "select count(id) jml from t_upload where module_kode='bled' and data_id = '$msr_no' and tipe between 3 and 12";
        $query = $this->db->query($sql)->row();
        $attachmentE = $query->jml;
        /*SOP*/
        $query = $this->M_bl->getSopValidation($msr_no)->num_rows();
        $sop = $query;

        /*msr_item*/
        $t_msr_item = $this->db->where('msr_no',$msr_no)->get('t_msr_item')->num_rows();

        $validEd = [
            'subject'             => 'Subject',
            'closing_date'        => 'Closing Date',
            'bid_validity'        => 'Bid Validty',
        ];
        $d = $this->input->post();
        $prebid = true;
        $d['prebid'] = true;
        if($d['prebid_loc'] > 0)
        {
            if($d['prebiddate'] and $d['prebid_address'])
            {

            }
            else
            {
                $d['prebid'] = false;
                $prebid = false;
            }
        }
        $bidbond = true;
        $d['bidbond'] = true;
        if($d['bid_bond_type'] == 1 or $d['bid_bond_type'] == 3)
        {
            if($d['bid_bond_validity'] and $d['bid_bond'])
            {

            }
            else
            {
                $d['bidbond'] = false;
                $bidbond = false;
            }
        }

        if($attachment0 > 0 and $attachment2 > 0 and $attachmentE > 0 and $sop == $t_msr_item and $d['subject'] and $prebid and $d['closing_date'] and $d['bid_validity'] and $pmValidation)
        {
            $status = false;
        }
        else
        {
            $status = true;
        }

        $data['html'] = $this->load->view('approval/sop_doc_validation',[
            'msr_no'      => $msr_no,
            'validEd'     => $validEd,
            'attachment0' => $attachment0,
            'attachment2' => $attachment2,
            'attachmentE' => $attachmentE,
            'sop'         => $sop,
            't_msr_item'  => $t_msr_item,
            'p'           => $d,
            'dataPm'      => $dataPm,
            ], true);
        $data['status'] = $status;
        $ed_no = str_replace('OR', 'OQ', $msr_no);
        if($status === true)
        {
            $this->session->set_flashdata('message', array(
                'message' => __('success_submit_with_number', array('no' => $ed_no)),
                'type' => 'success'
            ));
            echo json_encode($data);
        }
        else
        {
            $_POST['msr_no'] = $_POST['bl_msr_no'];
            $this->savedraft(1, $t_approval_id);
        }
    }
    public function approval_ajax($msr_no='')
    {
        $data['msr_no'] = $msr_no;
        $this->load->view('approval/ed_approval_ajax', $data);
    }

    public function save_addendum($submit=0, $t_approval_id=0) {
        $this->db->trans_begin();
        $user = user();
        $data = $this->input->post();
        $response = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('no_addendum', 'Addendum No', 'required');
        $this->form_validation->set_rules('resume', 'Resume', 'required');
        if (!$this->form_validation->run()) {
            $response = array(
                'success' => false,
                'message' => validation_errors('<div>', '</div>')
            );
            echo json_encode($response);
            return false;
        }
        $result = $this->db->insert('t_addendum', array(
            'no_addendum' => $data['no_addendum'],
            'module' => 'bled',
            'id_ref' => $data['msr_no'],
            'resume' => htmlspecialchars($data['resume']),
            'created_by' => $this->session->userdata('ID_USER'),
            'created_at' => date('Y-m-d H:i:s')
        ));
        $ed_data['msr_no']              = $data['msr_no'];
        $ed_data['subject']             = $data['subject'];
        $ed_data['prebiddate']          = $data['prebiddate'];
        $ed_data['prebid_address']      = $data['prebid_address'];
        $ed_data['closing_date']        = $data['closing_date'];
        $ed_data['currency']            = $data['currency'];
        $ed_data['bid_validity']        = $data['bid_validity'];
        $ed_data['bid_bond_type']       = $data['bid_bond_type'];
        $ed_data['bid_bond']            = $data['bid_bond'];
        $ed_data['bid_bond_validity']   = $data['bid_bond_validity'];
        $ed_data['prebid_loc']          = $data['prebid_loc'];
        $ed_data['packet']              = $data['packet'];
        $ed_data['envelope_system']     = $data['envelope_system'];
        $ed_data['incoterm']            = $data['incoterm'];
        $ed_data['delivery_point']      = $data['delivery_point'];
        $ed_data['commercial_data']     = $data['commercial_data'];
        $ed_data['created_by']          = $user->ID_USER;
        $ed = $this->db->where('msr_no',$data['msr_no'])->get('t_eq_data');
        if($ed->num_rows() > 0)
        {
            $this->db->where('id',$ed->row()->id);
            $this->db->update('t_eq_data',$ed_data);
        }
        else
        {
            $this->db->insert('t_eq_data',$ed_data);
        }
        $t_bl_detail = $this->db->where('msr_no', $data['msr_no'])
        ->get('t_bl_detail')
        ->result();
        foreach ($t_bl_detail as $bl_detail) {
            $this->db->insert('t_note', array(
                'module_kode' => 'addendum_bled',
                'data_id' => $data['msr_no'],
                'description' => $data['resume'],
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('ID_USER'),
                'author_type' => 'm_user',
                'vendor_id' => $bl_detail->vendor_id
            ));
        }
        if($this->db->trans_status() === true)
        {
            $this->db->trans_commit();
            $template = $this->db->where('ID', 65)->get('m_notic')->result();
            $img1 = '';
            $img2 = '';
            $emailData = array(
                'img1' => $img1,
                'img2' => $img2,
                'title' => $template[0]->TITLE,
                'open' => $template[0]->OPEN_VALUE,
                'close' => $template[0]->CLOSE_VALUE
            );
            foreach($this->db->where('msr_no',$data['msr_no'])->get('t_bl_detail')->result() as $key => $value){
                $vendor = $this->db->where('ID',$value->vendor_id)->get('m_vendor')->row();
                $lastquery = $this->db->last_query();
                $emailData['dest'][] = $vendor->ID_VENDOR;
            }
            $call = $this->db->where('msr_no',$data['msr_no'])->get('t_bl_detail')->result();
            $flag = $this->sendmailTo->sendMail($emailData);
            $response = array(
                'query' => $flag,
                'success' => true,
                'message' => 'Successfully save Enquiry Document Adendum'
            );
        }
        else
        {
            $this->db->trans_rollback();
            $response = array(
                'success' => false,
                'message' => 'Failed save Enquiry Document Adendum'
            );
        }
        echo json_encode($response);
    }

    public function bod_contract_review($msr_no='')
    {
        $bod_contract_review_list = $this->M_ed->bod_contract_review_list();
        if($this->input->get('debug'))
        {
            echo "<pre>";
            print_r($bod_contract_review_list);
        }
        else
        {
            $get_menu = $this->M_vendor->menu();
            $dt = array();
            foreach ($get_menu as $k => $v) {
                $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
                $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
                $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
                $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
            }
            $data['menu'] = $dt;
            $data['titleApp'] = lang('BOD Contract Review', 'BOD Contract Review');
            if($msr_no)
            {
                $data['msr'] = $this->db->where(['msr_no'=>$msr_no])->get('t_msr')->row();
                $data['ed'] = $this->db->where(['msr_no'=>$msr_no])->get('t_eq_data')->row();
                $data['cur'] = $this->db->where(['ID'=>$data['msr']->id_currency])->get('m_currency')->row();
                $this->template->display('approval/bod_contract_review_form', $data);
            }
            else
            {
                $data['lists'] = $bod_contract_review_list;
                $this->template->display('approval/bod_contract_review_list', $data);
            }
        }
    }
    public function bod_contract_review_store()
    {
        $data = $this->input->post();
        if(@$_FILES['contract_review_file']['tmp_name'])
        {
            $config['upload_path']  = './upload/contract_review/';
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'],0755,TRUE);
            }
            $config['allowed_types']= '*';
            $config['encrypt_name']= true;
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('contract_review_file'))
            {
                $err =  $this->upload->display_errors('', '');
                echo "<script>alert($err)</script>";
                echo "<script>window.open('".base_url('approval/ed/bod_contract_review/'.$data['msr_no'])."','_self')</script>";
                exit;
            }
            else
            {
                $user = user();
                $upload = $this->upload->data();
                $field['module_kode'] = 'contract review';
                $field['data_id'] = $data['msr_no'];
                $field['file_path'] = $upload['file_name'];
                $field['file_name'] = $data['contract_review_name'];
                $field['created_by'] = $user->ID_USER;
                $this->db->insert('t_upload',$field);
                echo "<script>alert('Success, Uploaded')</script>";
                echo "<script>window.open('".base_url('approval/ed/bod_contract_review')."','_self')</script>";
            }
        }
    }
    public function bod_contract_review_delete($id='')
    {
        $this->db->where(['id'=>$id]);
        $t_upload = $this->db->get('t_upload')->row();

        @unlink('upload/contract_review/'.$t_upload->file_path);

        $this->db->where(['id'=>$id]);
        $this->db->delete('t_upload');

        $base_url = base_url('approval/ed/bod_contract_review/'.$t_upload->data_id);

        echo "<script>alert('Success, Deleted')</script>";
        echo "<script>window.open('$base_url','_self')</script>";
    }
    public function getAssignmentAgreement($id_user='')
    {
        $this->db->select('t_assignment.*');
        $this->db->where(['t_assignment.user_id'=>$id_user]);
        $t_assignment = $this->db->get('t_assignment');
        $msr_no = [];
        foreach ($t_assignment->result() as $key => $value) {
          $msr_no[] = $value->msr_no;
        }
        $t_purchase_order = 0;

        if(count($msr_no) > 0)
        {
            $t_purchase_order = $this->db->where_in('msr_no',$msr_no)->where(['issued'=>1])->get('t_purchase_order');
            $msrArray = [];
            foreach ($t_purchase_order->result() as $key => $value) {
                $msrArray[] = $value->msr_no;
            }
            $newMsr = [];
            foreach ($msr_no as $key => $value) {
                if(!in_array($value, $msrArray))
                {
                    $newMsr[] = $value;
                }
            }
            // echo count($newMsr);
            // echo "<pre>";
            // print_r($newMsr);
            // exit();
          return $newMsr;
        }
        else
        {
            return false;
        }
    }
>>>>>>> 292f1d6fbebeb9e4cf8cfedb6e3314cfb3198315
}