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
    $thead = cmms_settings('wr_list')->get()->result();
    $data['menu'] = $this->menu;
    $data['thead'] = $thead;
    $data['title'] = 'Work Request Tracking - CMMS16';
    $this->template->display($this->view .'/index', $data);
  }

  public function ajax_list()
  {
    $list = $this->wr->dt_get_datatables();
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $rows) {
      $no++;
      $row = array();
      $row[] = $no;
      foreach (cmms_settings('wr_list')->get()->result() as $key => $value) {
        $field = $value->desc1;
        if($field == 'req_finish_date')
        {
          $txt = dateToIndo($rows->$field);
        }
        else
        {
          $txt = $rows->$field;
        }
        if($field == 'wr_no')
        {
          $txt = "<a href='".base_url('cmms/wr/show/'.$rows->wr_no)."' class='btn btn-info btn-sm'>$txt</a>";
        }
        $row[] = $txt;
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

  public function create($FAAAID='')
  {
    if(!can_create_msr())
    {
      $this->session->set_flashdata('message', array(
          'message' => "You dont have permission to create this WR",
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
        $store = $this->wr->store($data);

        if($store)
        {
          $send_wsdl = $this->send_wsdl($data);
          if($send_wsdl)
          {
            echo json_encode(['status'=>true,'msg'=>'WR Has Been Created & Send to JDE is Success']);
          }
          else
          {
            echo json_encode(['status'=>true,'msg'=>'WR Has Been Created & Send JDE is Failed, you can try in another moment']);
          }
        }
        else
        {
          echo json_encode(['status'=>fail,'msg'=>'Fail, Please Tyr Again']);
        }
      }
    }
    else
    {
        echo json_encode(['status'=>false,'msg'=>'Image is Required']);
    }
  }
  public function update_and_approve($value='')
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
    $update = $this->wr->update_and_approve($data);
    if($update)
    {
      echo json_encode(['status'=>true,'msg'=>'WR Has Been Created']);
    }
    else
    {
      echo json_encode(['status'=>false,'msg'=>'Fail, Please Tyr Again']);
    }
  }
  public function optWoType($wo_type_selected = '')
  {
    $wotype = $this->wo_type->all();
    $s = "<select name='wo_type_id' id='wo_type_id' class='form-control'>";
    foreach ($wotype as $r) {
      $selected = $wo_type_selected == $r->id ? "selected=''":"";
      $s .= "<option $selected value='$r->id'>$r->code_alpha - $r->notation</option>";
    }
    $s .= "</select>";
    return $s;
  }
  public function optPriority($row=0)
  {
    $list = 
    [
      1 => 'Uregent Immediate',
      2 => 'Within 24 Hours',
      3 => 'Within 3 - 7 Days',
      4 => 'Requirment Shutdown Work',
      5 => 'Preventive Maintenance',
      6 => 'Outage Work',
    ];
    $s = "<select name='priority' id='priority' class='form-control'>";
    foreach ($list as $key => $value) {
      $selected = $row == $key ? "selected=''":"";
      $s .= "<option $selected value='$key'>$value</option>";
    }
    $s .= "</select>";
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
      $btnAdd = "<button type='button' href='#' $tampung class='btn btn-sm btn-primary' id='$rows->FANUMB' onclick=\"getSelectedData($rows->FANUMB)\">Select</button>";
      foreach ($this->settings('thead') as $key => $value) {
        $row[] = trim($rows->$key);
      }
      $row[] = "$btnAdd";
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
        $opt .= "<option value=''>ALL TYPE</option>";
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
  public function send_wsdl($data='')
  {
    $id = $this->session->userdata('ID_USER');
    $r = $this->db->where('ID_USER',$id)->get('m_user')->row();
    $e = explode(',',$r->COMPANY);

    $wh = $this->db->from('m_warehouse')->select('id_warehouse')->where('id_company', $e[0])->get()->row();
    $id_warehouse = $wh->id_warehouse;

    $data['id_warehouse'] = $id_warehouse;
    $xml = $this->load->view('cmms/wr/wsdl', $data, true);
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
        // echo "Failed Exec JDE ARF -  Doc No ".$arf->doc_no." at ".date("Y-m-d H:i:s");
      return true;
    } else {
        // echo "Successfully Exec JDE ARF -  Doc No ".$arf->doc_no." at ".date("Y-m-d H:i:s");
      return false;
    }
  }
}