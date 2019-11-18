<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wr extends CI_Controller {
  /*Note : Rule Work Order Approval Status:
  Status 01 WO Created by User
  Status 05 WO approval by supervisor
  Status 10, 20, 30, 40, 50, 60, review by Maintenance Planner
  Status 70, 80, update by PIC
  Status 90 review by supervisor
  */
  protected $view = 'cmms/wr';
  protected $menu;

  public function __construct() {
    parent::__construct();
    $this->load->model('vendor/M_vendor');
    $this->load->model('vendor/M_all_intern', 'mai');
    $this->load->model('cmms/M_work_request', 'wr');
    $this->load->model('cmms/M_wo_jde', 'wo');
    $this->load->model('cmms/M_wo_type', 'wo_type');
    $this->load->model('cmms/M_failure_description', 'failure');
    $this->load->model('cmms/M_equipment','mod');
    $this->load->model('cmms/M_equipment_picture','picture');
    $this->load->helper(array('permission'));
    $this->mai->cek_session();
    $get_menu = $this->M_vendor->menu();
    $this->menu = array();
    foreach ($get_menu as $k => $v) {
      $this->menu[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
      $this->menu[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
      $this->menu[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
      $this->menu[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
    }
    $user = user();
    $this->user = $user;
    if (isset($user->ROLES)) {
        $roles = explode(",", $user->ROLES);
    } else {
        $roles = array();
    }
    $this->roles      = array_values(array_filter($roles));
  }

  

  public function index()
  {
    $thead = cmms_settings('wr_list')->order_by('seq','asc')->get()->result();
    $filter = cmms_settings('wr_list')->where('desc2',1)->get()->result();
    $data['menu'] = $this->menu;
    $data['thead'] = $thead;
    $data['title'] = 'Work Request Tracking - CMMS16';
    $data['filter'] = $filter;
    $data['optWoType'] = $this->optWoType('','filter_wr_type',true);
    $data['optWoStatus'] = $this->optWoStatus('','filter_status',true);
    $data['all'] = $this->input->get('all') ? 1 : 0;
    $this->template->display($this->view .'/index', $data);
  }

  public function ajax_list()
  {
    $list = $this->wo->dt_get_datatables();
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $rows) {
      $no++;
      $row = array();
      $row[] = $no;
      $woNo = $rows->WADOCO;
    $woDesc = $rows->WADL01;
    $woType = $rows->WOTYPE;
    $wotype = $cmms_wo_type = $this->db->where('id', $rows->WOTYPE)->get('cmms_wo_type')->row();
    @$woType = $wotype->notation;
    $woStatus = $rows->STATUS;
    $woDate = $rows->WO_DATE;
    $woFailureDesc = $rows->FAILURE_DESC;
    $woOriginator = $rows->ORIGINATOR;
    $link = "<a href='#' onclick=\"openModalWoDetail('$woNo')\">$woNo</a>";
    $row[] = $link;
    $row[] = $woDesc;
    $row[] = $woType;
    $row[] = $woStatus;
    $row[] = $woDate;
    $row[] = $woFailureDesc;
    $row[] = $woOriginator;
      $data[] = $row;
    }
    // print_r($data);
    $output = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->wo->dt_count_all(),
            'recordsFiltered' => $this->wo->dt_count_filtered(),
            'data' => $data,
        );
    echo json_encode($output);
  }

  public function ajax_list_portal()
  {
    $list = $this->wr->dt_get_datatables();
    $data = array();
    $no = $_POST['start'];
    $all = $this->input->post('all') ? "?all=1" : "";
    foreach ($list as $rows) {
      $no++;
      $row = array();
      $row[] = $no;
      foreach ($this->db->where('module','wr_list')->get('cmms_settings')->result() as $key => $value) {
        $v = $value->desc1;
        $x = $rows->$v;
        if($value->desc1 == 'req_finish_date' or $value->desc1 == 'created_at')
        {
          $x = dateToIndo($x);
        }
        if($value->desc1 == 'wr_no')
        {
          $x = "<a target='_blank' href='".base_url('cmms/wr/show/'.$rows->wr_no)."$all'>$x</a>";
        }
        if($value->desc1 == 'status')
        {
          //$x = "<a href='#' onclick=\"getCmmsLogHistory('".$rows->wr_no."')\">$x</a>";
          $x = @$rows->status;
        }
        $row[] = $x;
      }
      $data[] = $row;
    }
    // print_r($data);
    $output = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->wr->dt_count_all(),
            'recordsFiltered' => $this->wr->dt_count_filtered(),
            'data' => $data,
        );
    echo json_encode($output);
  }

  public function create($FAASID='')
  {
    if(!company_cmms())
    {
      $this->session->set_flashdata('message', array(
          'message' => "Please setup company first",
          'type' => 'danger'
      ));
      redirect(base_url('home'));
    }
    $data['menu'] = $this->menu;
    $data['title'] = 'Work Request Create/Edit Form - CMMS10';
    $data['view'] = $this->view;
    $data['optWoType'] = $this->optWoType();
    $data['optPriority'] = $this->optPriority();
    $data['optEqType'] = $this->optEqType('filter_EQTYPE');
    $data['filter_FAASID'] = $FAASID;
    $this->template->display($this->view .'/create', $data);
  }
  public function show($wr_no='')
  {
    $can_approve = $this->can_approve($wr_no);
    /*print_r($can_approve);
    exit();*/
    $wr = $this->wr->findByWrNo($wr_no);

    $data['menu'] = $this->menu;
    $data['title'] = 'Work Request Approval- CMMS12';
    $data['view'] = $this->view;
    $data['approval'] = $can_approve;
    $data['row'] = $wr;
    $data['optWoType'] = $this->optWoType($wr->wo_type_id);
    $data['optPriority'] = $this->optPriority($wr->priority);
    if(in_array(operator_cmms, $this->roles) or in_array(department_cmms, $this->roles))
    {
      $data['user_creator'] = true;
    }
    $this->template->display($this->view .'/edit', $data);
  }
  public function store()
  {
    // print_r($this->input->post());
    if($_FILES['photo']['tmp_name'])
    {
      $config['upload_path']  = './upload/wr/';
      if (!is_dir($config['upload_path'])) {
          mkdir($config['upload_path'],0755,TRUE);
      }
      $config['allowed_types'] = 'jpg|jpeg|png|JPEG|PNG|JPG';
      $config['encrypt_name']= true;
      $config['max_size']      = '2000';

      $this->load->library('upload', $config);
      if ( ! $this->upload->do_upload('photo'))
      {
        $msg = $this->upload->display_errors('', '');
        $status = false;
        echo json_encode(['status'=>$status, 'msg'=>$msg]);
        exit;
      }
      else
      {
        $data_foto = $this->upload->data();
        $file_name =  $data_foto['file_name'];

        $data = $this->input->post();
        $data['photo'] = $file_name;
		    $data['wr_no'] = $this->mod->wr_no_jde();
        //$data['parent_id'] = isset($data['parent_id']) ? 0 : $data['parent_id'];
        // $store = $this->wr->store($data);
        $send_wsdl = $this->send_wsdl($data, true);

        if($send_wsdl)
        {
          // $send_wsdl = $this->send_wsdl($data);
        	$store = $this->wr->store($data);
          $msg = '';
          if($store)
          {
            /*insert long desc*/
            $insert_long_desc_jde = $this->wr->insert_long_desc_jde($data);
            if($insert_long_desc_jde)
            {
              $msg = 'WR '.$data['wr_no'].'  Has Been Created & Send to JDE is Success';
              echo json_encode(['status'=>true,'msg'=>$msg]);
            }
            else
            {
              $msg = 'WR '.$data['wr_no'].'  Has Been Created & Send to JDE is Success, Long Description Is Failed to JDE';
              echo json_encode(['status'=>true,'msg'=>$msg, 'sql'=>$this->db->last_query()]);
            }
          }
          else
          {
            $msg = 'WR '.$data['wr_no'].' Has Been Created & Send JDE is Success, but PORTAL is down';
            echo json_encode(['status'=>true,'msg'=>$msg]);
          }
          /*$module_kode, $data_id, $description, $keterangan = ''*/
          // cmms_log_history('wr',$data['wr_no'],'create',$msg);
        }
        else
        {
          echo json_encode(['status'=>'fail','msg'=>'JDE Failed']);
        }
      }
    }
    else
    {
      $data = $this->input->post();
      // $data['photo'] = $file_name;
      $data['wr_no'] = $this->mod->wr_no_jde();
      // $store = $this->wr->store($data);
        $send_wsdl = $this->send_wsdl($data);

      if($send_wsdl)
      {
        // $send_wsdl = $this->send_wsdl($data);
      	$store = $this->wr->store($data);
        $msg = '';
        if($store)
        {
          /*insert long desc*/
          $insert_long_desc_jde = $this->wr->insert_long_desc_jde($data);
          if($insert_long_desc_jde)
          {
            $msg = 'WR '.$data['wr_no'].'  Has Been Created & Send to JDE is Success';
            echo json_encode(['status'=>true,'msg'=>$msg]);
          }
          else
          {
            $msg = 'WR '.$data['wr_no'].'  Has Been Created & Send to JDE is Success, Long Description Is Failed to JDE';
            echo json_encode(['status'=>true,'msg'=>$msg, 'sql'=>$this->db->last_query()]);
          }
        }
        else
        {
          $msg = 'WR '.$data['wr_no'].' Has Been Created & Send JDE is Success, but PORTAL is down';
          echo json_encode(['status'=>true,'msg'=>$msg]);
        }
        /*$module_kode, $data_id, $description, $keterangan = ''*/
        // cmms_log_history('wr',$data['wr_no'],'create',$msg);
      }
      else
      {
        echo json_encode(['status'=>'fail','msg'=>'JDE Failed']);
      }
    }
  }
  public function update($value='')
  {
    $data = $this->input->post();
    /*echo "<pre>";
    print_r($data);
    exit();*/
    if($_FILES['photo']['tmp_name'])
    {
      $config['upload_path']  = './upload/wr/';
      if (!is_dir($config['upload_path'])) {
          mkdir($config['upload_path'],0755,TRUE);
      }
      $config['allowed_types'] = 'jpg|jpeg|png|JPEG|PNG|JPG';
      $config['encrypt_name']= true;
      $config['max_size']      = '2000';

      $this->load->library('upload', $config);
      if ( ! $this->upload->do_upload('photo'))
      {
        $msg = $this->upload->display_errors('', '');
        $status = false;
        echo json_encode(['status'=>$status, 'msg'=>$msg]);
        exit;
      }
      else
      {
        $data_foto = $this->upload->data();
        $file_name =  $data_foto['file_name'];
        $data['photo'] = $file_name;
      }
    }
    $data['status'] = '05';
    if(isset($data['parent_id']))
    {
      unset($data['parent_id']);
    }
    // $update = $this->wr->update_and_approve($data);
    $send_wsdl = $this->send_wsdl_update($data);
    if($send_wsdl)
    {
      $msg = '';
    	$update = $this->wr->update_and_approve($data);
      // $send_wsdl = $this->send_wsdl_update($data);
      if($update)
      {
        /*update long desc*/
        $update_long_desc_jde = $this->wr->update_long_desc_jde($data);
        if($update_long_desc_jde)
        {
          $msg = 'WR '.$data['wr_no'].' Has Been Update & Send JDE';
          echo json_encode(['status'=>true,'msg'=>$msg]);
        }
        else
        {
          $msg = 'WR '.$data['wr_no'].' Has Been Update & Send JDE, Long Description Is Failed to JDE';
          echo json_encode(['status'=>true,'msg'=>$msg, 'sql'=>$this->db->last_query()]);
        }
      }
      else
      {
        $msg = 'WR '.$data['wr_no'].' Has Been Update & Send JDE is Success, but PORTAL is down';
        echo json_encode(['status'=>true,'msg'=>$msg]);
      }
      // cmms_log_history('wr',$data['wr_no'],'update-approve',$msg);
    }
    else
    {
      echo json_encode(['status'=>false,'msg'=>'JDE Failed']);
    }
  }
  public function optWoType($wo_type_selected = '', $name='wo_type_id', $search=false)
  {
    $wotype = $this->db->where('status',1)->get('cmms_wo_type')->result();
    $s = "<select name='$name' id='$name' class='form-control'>";
    if($search)
      $s .= "<option value=''>--All--</option>";

    foreach ($wotype as $r) {
      $selected = $wo_type_selected == $r->id ? "selected=''":"";
      $s .= "<option $selected value='$r->id'>$r->code_alpha - $r->notation</option>";
    }
    $s .= "</select>";
    return $s;
  }
  public function optWoStatus($wo_type_selected = '', $name='status', $search=false)
  {
    $wotype = $this->db->get('cmms_wo_status')->result();
    $s = "<select name='$name' id='$name' class='form-control'>";
    if($search)
      $s .= "<option value=''>--All--</option>";

    foreach ($wotype as $r) {
      $selected = $wo_type_selected == $r->wo_status ? "selected=''":"";
      $s .= "<option $selected value='$r->wo_status'>$r->wo_status - $r->wo_status_desc</option>";
    }
    $s .= "</select>";
    return $s;
  }
  public function optPriority($row=0)
  {
    $s = optPriority('priority', $row);
    return $s;
  }
  public function settings($value='')
  {
    $head = [
      'FAASID' => 'Equipment Number',
      'FADL01' => 'Equipment Description',
      'EQCLAS' => 'Equipment Class',
      'EQTYPE' => 'Equipment Type',
    ];
    $data['thead'] = $head;

    $detail = [
	'FAAAID' => 'PARENT EQUIPMENT ID',
      'FANUMB' => 'EQUIPMENT ID',
      'FAASID' => 'Equipment Number',
      'FADL01' => 'Equipment Description',
      'LOCT' => 'Location',
      'CIT' => 'Criticality',
      'PARENTS' => 'Parent EQ Number',
      'DSPARENTS' => 'Parent Description',
      'EQCLAS' => 'Equipment Class',
      'EQTYPE' => 'Equipment Type',
    ];
    $data['detail'] = $detail;

    return $data[$value];
  }
  public function ajax_list_equipment()
  {
    $list = $this->mod->dt_get_datatables();
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $rows) {
      $no++;
      $row = array();
      // $jsondata = json_encode($rows);
      $tampung = '';
      foreach ($this->settings('detail') as $key => $value) {
        $tampung .= " $key = '".trim($rows->$key)."'";
      }
      $btnAdd = "<a href='#' $tampung id='$rows->FANUMB' onclick=\"getSelectedData($rows->FANUMB)\">$rows->FAASID</a>";
      foreach ($this->settings('thead') as $key => $value) {
      	if($key == 'FAASID')
      	{
      		$row[] = $btnAdd;
      	}
      	else
      	{
	        $row[] = trim($rows->$key);
      	}
      }
      // $row[] = "$btnAdd";
      $data[] = $row;
    }
 
    $output = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->mod->dt_count_all(),
            'recordsFiltered' => $this->mod->dt_count_filtered(),
            'data' => $data,
        );
    echo json_encode($output);
  }
  /*public function search_for_wr($value='')
  {
    $q = $this->input->post('q');
    
    $a = [];
    for ($i=1; $i < 10; $i++) { 
      $a[] = ['EQ_NO'=>'1900000'.$i, 'EQ_DESC'=>'Desc of Eq 1900000'.$i, 'EQ_CLASS'=>'EQ Clas Of 1900000'.$i, 'EQ_TYPE'=>'EQ TYPE Of 1900000'.$i, 'EQ_LOCATION'=>'Location Of 1900000'.$i];
    }
    $data['results'] = $a;
    $this->load->view('cmms/equipment/search_for_wr',$data);
  }*/
  public function opt_ajax_failure_desc()
  {
    $p = $this->input->post();
	$eqclas = $p['eqclas'];
	$eqclas = explode('-', $eqclas);
	$eqclas = trim($eqclas[0]);
    $s = "";
    $failures = $this->mod->failure_wr($eqclas);
    foreach ($failures as $failure) {
      $selected = '';
      /* if(isset($p['failure_desc']))
      {
        $selected = $failure->id == $p['failure_desc'] ? "selected='selected'":"";
      } */
      $s .= "<option $selected value='$failure->KNKBTNM'>$failure->KNDS40</option>";
    }
    echo $s;
  }
  public function generate_approval($wr_no='')
  {
    $generate_approval = $this->wr->generate_approval($wr_no);
  }
  public function can_approve($wr_no='')
  {
    $result = false;
    if(in_array(user_manager, $this->roles))
    {
      $can_approve = $this->wr->can_approve_user_manager($wr_no)->row();
      if($can_approve)
      {
        $result = $can_approve;
      }
    }
    return $result;
 
  }
  public function optEqType($name_id='')
  {
    $crt = $this->mod->eq_type();
    $opt = "<select name='$name_id' class='form-control' id='$name_id'>";
    // $opt .= "<option value=''>--ALL TYPE--</option>";
    foreach ($crt as $key => $value) {
      if($value->EQ_TYPE == ' - .')
      {
        $opt .= "<option value=''>TYPE</option>";
      }
      else
      {
        $opt .= "<option value='$value->EQ_TYPE'>$value->EQ_TYPE</option>";
      }
    }
    $opt .= "</select>";
    return $opt;
  }
  public function wo_search()
  {
	  $data = $this->mod->wo_search();
	  echo json_encode($data);
  }
  public function send_wsdl($data='', $manual= false)
  {
    $id = $this->session->userdata('ID_USER');
    $r = $this->db->where('ID_USER',$id)->get('m_user')->row();
    $e = explode(',',$r->COMPANY);

    $wh = $this->db->from('m_warehouse')->select('id_warehouse')->where('id_company', $e[0])->get()->row();
    $id_warehouse = $wh->id_warehouse;

    $data['id_warehouse'] = $id_warehouse;
    $data['originator'] = $r->USERNAME;
    $xml = $this->load->view('cmms/wr/wsdl-v2', $data, true);
    $headers = array(
      "Content-Type: text/xml",
      "charset:utf-8",
      "Accept: application/xml",
      "Cache-Control: no-cache",
      "Pragma: no-cache",
      "Content-length: " . strlen($xml),
    );
    $ch = curl_init('https://10.1.1.94:89/PY910/EquipmentWorkOrderManager?WSDL');
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSLVERSION, 'all');

    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,300);
    curl_setopt($ch, CURLOPT_TIMEOUT,360);
    $data_curl = curl_exec($ch);
    curl_close($ch);
    // echo $data_curl;
    if (strpos($data_curl, 'HTTP/1.1 200 OK') === false) {
      if($manual == true)
      {
        echo "Failed Exec JDE at ".date("Y-m-d H:i:s");
        echo $xml;
      }
    //echo $data_curl;
      return false;
    } else {
        // echo "Successfully Exec JDE ARF -  Doc No ".$arf->doc_no." at ".date("Y-m-d H:i:s");
      return true;
    }
  }
  public function send_wsdl_manual($wr_no='')
  {
    $wr  = $this->db->where('wr_no', $wr_no)->get('cmms_wr')->row_array();
    $this->send_wsdl($wr, true);
  }
  public function send_wsdl_update($data='', $manual= false)
  {
    //$wr = $this->wr->findByWrNo($data['wr_no']);
	$data = $this->db->where('wr_no',$data['wr_no'])->get('cmms_wr')->row_array();
    $id = $data['created_by'];
    $r = $this->db->where('ID_USER',$id)->get('m_user')->row();
	
    $data['originator'] = $r->USERNAME;
    $xml = $this->load->view('cmms/wr/wsdl-update', $data, true);
    $headers = array(
      "Content-Type: text/xml",
      "charset:utf-8",
      "Accept: application/xml",
      "Cache-Control: no-cache",
      "Pragma: no-cache",
      "Content-length: " . strlen($xml),
    );
    $ch = curl_init('https://10.1.1.94:89/PY910/EquipmentWorkOrderManager?WSDL');
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSLVERSION, 'all');

    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,300);
    curl_setopt($ch, CURLOPT_TIMEOUT,360);
    $data_curl = curl_exec($ch);
    curl_close($ch);
    // echo $data_curl;
    if (strpos($data_curl, 'HTTP/1.1 200 OK') === false) {
      if($manual == true)
      {
        echo "Failed Exec JDE at ".date("Y-m-d H:i:s");
        echo $xml;
      }
      return false;
    } else {
        // echo "Successfully Exec JDE ARF -  Doc No ".$arf->doc_no." at ".date("Y-m-d H:i:s");
      return true;
    }
  }
  public function reject($wr_no='')
  {
    $data = $this->input->post();
    if($_FILES['photo']['tmp_name'])
    {
      $config['upload_path']  = './upload/wr/';
      if (!is_dir($config['upload_path'])) {
          mkdir($config['upload_path'],0755,TRUE);
      }
      $config['allowed_types'] = 'jpg|jpeg|png|JPEG|PNG|JPG';
      $config['encrypt_name']= true;
      $config['max_size']      = '2000';

      $this->load->library('upload', $config);
      if ( ! $this->upload->do_upload('photo'))
      {
        $msg = $this->upload->display_errors('', '');
        $status = false;
        echo json_encode(['status'=>$status, 'msg'=>$msg]);
        exit;
      }
      else
      {
        $data_foto = $this->upload->data();
        $file_name =  $data_foto['file_name'];
        $data['photo'] = $file_name;
      }
    }
    $data['status'] = '91';
    if(isset($data['parent_id']))
    {
      unset($data['parent_id']);
    }
    unset($data['photo_old']);
    // $update = $this->wr->reject($data);
    $send_wsdl = $this->send_wsdl_reject($data);
    if($send_wsdl)
    {
      $msg = '';
      // $send_wsdl = $this->send_wsdl_reject($data);
      unset($data['parent_id_old']);
    	$update = $this->wr->reject($data);
      if($update)
      {
        /*update long desc*/
        $update_long_desc_jde = $this->wr->update_long_desc_jde($data);
        if($update_long_desc_jde)
        {
          $msg = 'WR '.$data['wr_no'].'  Has Been Rejected & Send to JDE is Success';
          echo json_encode(['status'=>true,'msg'=>$msg]);
        }
        else
        {
          $msg = 'WR '.$data['wr_no'].' Has Been Rejected & Send JDE, Long Description Is Failed to JDE';
          echo json_encode(['status'=>true,'msg'=>$msg, 'sql'=>$this->db->last_query()]);
        }
      }
      else
      {
        $msg = 'WR '.$data['wr_no'].' Has Been Rejected & Send JDE is Success, but PORTAL is down';
        echo json_encode(['status'=>true,'msg'=>$msg]);
      }
    }
    else
    {
      echo json_encode(['status'=>false,'msg'=>'JDE Failed']);
    }
    /*old*/
    /*$data['wr_no'] = $wr_no;
    $data['comment_supervisor'] = $this->input->post('comment_supervisor');
    $data['status'] = '91'; #reject status

    $store  = $this->wr->reject($data);
    if($store)
    {
      $msg = '';
      $send_wsdl = $this->send_wsdl_reject($data);
      if($send_wsdl)
      {
        $msg = 'WR '.$data['wr_no'].'  Has Been Rejected & Send to JDE is Success';
        echo json_encode(['status'=>true,'msg'=>$msg]);
      }
      else
      {
        $msg = 'WR '.$data['wr_no'].' Has Been Rejected & Send JDE is Failed, you can try in another moment';
        echo json_encode(['status'=>true,'msg'=>$msg]);
      }
      // cmms_log_history('wr',$data['wr_no'],'reject',$msg);
    }
    else
    {
      echo json_encode(['status'=>fail,'msg'=>'Fail, Please Tyr Again']);
    }*/
  }
  public function send_wsdl_reject($data='', $manual= false)
  {
    $wr = $this->wr->findByWrNo($data['wr_no']);
    $id = $wr->created_by;
    $r = $this->db->where('ID_USER',$id)->get('m_user')->row();

    $data['originator'] = $r->USERNAME;
    $data['fanumb'] = $wr->fanumb;
    $data['wr_description'] = $wr->wr_description;
    $data['failure_desc'] = $wr->failure_desc;
    $data['req_finish_date'] = $wr->req_finish_date;
    $data['priority'] = $wr->priority;
    $data['hazard'] = $wr->hazard;
    $data['wo_type_id'] = $wr->wo_type_id;
    $xml = $this->load->view('cmms/wr/wsdl-reject', $data, true);
    $headers = array(
      "Content-Type: text/xml",
      "charset:utf-8",
      "Accept: application/xml",
      "Cache-Control: no-cache",
      "Pragma: no-cache",
      "Content-length: " . strlen($xml),
    );
    // echo $xml;
    $ch = curl_init('https://10.1.1.94:89/PY910/EquipmentWorkOrderManager?WSDL');
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSLVERSION, 'all');

    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,300);
    curl_setopt($ch, CURLOPT_TIMEOUT,360);
    $data_curl = curl_exec($ch);
    curl_close($ch);
    // echo $data_curl;
    if (strpos($data_curl, 'HTTP/1.1 200 OK') === false) {
      if($manual == true)
      {
        echo "Failed Exec JDE at ".date("Y-m-d H:i:s");
        echo $xml;
      }
      return false;
    } else {
        // echo "Successfully Exec JDE ARF -  Doc No ".$arf->doc_no." at ".date("Y-m-d H:i:s");
      return true;
    }
  }
}