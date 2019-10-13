<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Replenisment extends CI_Controller {

  protected $view = 'cmms/replenisment';
  protected $menu;

  public function __construct() {
    parent::__construct();
    $this->load->model('vendor/M_vendor');
    $this->load->model('vendor/M_all_intern', 'mai');
    $this->load->model('cmms/M_replenisment','mod');

    $this->mai->cek_session();
    $get_menu = $this->M_vendor->menu();
    $this->menu = array();
    foreach ($get_menu as $k => $v) {
      $this->menu[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
      $this->menu[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
      $this->menu[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
      $this->menu[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
    }
  }

  public function settings($value='')
  {
    $head = [
      'RPLITM' => 'Item Number',
      'RPMCU' =>    'Ware House',
      'RPEV01' => 'Status',
    ];
    $data['thead'] = $head;
    return $data[$value];
  }
  public function index($param='') {
    $data['menu'] = $this->menu;
	$data['thead'] = $this->settings('thead');
	
	$title = 'Replenisment';
	
    $data['param'] = $param;
	$data['title'] = $title;
    
    $this->template->display($this->view .'/index', $data);
  }
  public function detail($id='')
  {
    $data['menu'] = $this->menu;
    $data['title'] = 'Equipment Information';
    $data['view'] = $this->view;
    $data['basic_info_form'] = $this->mod->find($id);
    $data['pm1'] = $this->mod->pm1($id);
    $data['pm2'] = $this->mod->pm1($id);
    $data['eq_picture'] = $this->picture->findByEquipment($id);
    $data['spec'] = $this->mod->spec($id);
    $data['wo'] = $this->mod->wo($id);
    $data['equipment_id'] = $id;
    $this->template->display($this->view .'/detail', $data);
  }
  public function ajax_list()
  {
    $list = $this->mod->dt_get_datatables();
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $rows) {
      $no++;
      $row = array();
      $row[] = $no;
      
      foreach ($this->settings('thead') as $key => $value) {
        $row[] = $rows->$key;
      }
      $row[] = $rows->RPEV01 == 1 ? 'New Request' : '';
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
  public function store_image()
  {
    if($_FILES['image']['tmp_name'])
    {
      $config['upload_path']  = './upload/cmms/equipment_picture/';
      if (!is_dir($config['upload_path'])) {
          mkdir($config['upload_path'],0755,TRUE);
      }
      $config['allowed_types']= 'jpg|png|jpeg|JPG|PNG|JPEG';
      $config['max_size']      = '512';
      
      $this->load->library('upload', $config);
      if ( ! $this->upload->do_upload('image'))
      {
          echo $this->upload->display_errors('', '');exit;
      }else
      {
          $data = $this->upload->data();
          $data_doc['picture'] = $data['file_name'];;
      }
    }
    $data_doc['equipment_id'] = $this->input->post('equipment_id');
    $data_doc['created_at'] = date("Y-m-d H:i:s");
    
    $this->db->insert('cmms_equipment_picture', $data_doc);
    $this->dt_image($data_doc['equipment_id']);
  }
  public function delete_image($id='')
  {
    $cmms_image = $this->db->where('id',$id)->get('cmms_equipment_picture')->row();
    $equipment_id = $cmms_image->equipment_id;
    @unlink('upload/cmms/equipment_picture/'.$cmms_image->picture);
    $this->db->where('id',$id)->delete('cmms_equipment_picture');
    $this->dt_image($equipment_id);
  }
  public function dt_image($equipment_id='')
  {
    $ps = $this->picture->findByEquipment($equipment_id);
    $no =1;
    foreach ($ps as $key => $value) {
      $btnDownload = "<a href='".base_url('upload/cmms/equipment_picture/'.$value->picture)."' target='_blank' class='btn btn-sm btn-info'>View</a>";
      $btnDelete = "<a href='#' onclick='deleteImageClick($value->id)' class='btn btn-sm btn-danger'>Delete</a>";
      echo "<tr><td>$no</td><td>".dateToIndo($value->created_at)."</td><td>$btnDownload</td><td>$btnDelete</td><tr>";
      $no++;
    }
  }
  public function wo_detail($wo_no='')
  {
    $data['wo_detail'] = $this->mod->wo_detail($wo_no);
    $data['parent_wo'] = $this->mod->get_parent_wo($wo_no);
    $data['po_no'] = $this->mod->get_po_no($wo_no);
    /*echo "<pre>";
    print_r($data);
    exit();*/
    $data['task_instruction'] = $this->mod->task_instruction($data['wo_detail']->TASKINSTRUCTION);
    $data['part_list'] = $this->mod->new_part_list($wo_no);
    $data['labor_list'] = $this->mod->labor_detail($wo_no);
    $data['attachment'] = $this->mod->attachment_jde($wo_no);
    $data['attachment_other'] = $this->mod->attachment_jde_other($wo_no);
    $this->load->view($this->view.'/wo_detail', $data);
  }
  public function get_task_instruction_from_pm($value='')
  {
    $data['results'] = $this->mod->task_instruction($this->input->post('task_instruction'));
    $this->load->view($this->view.'/task_instruction_pm',$data);
  }
  public function search_for_wr($value='')
  {
    $q = $this->input->post('q');
    
    // $results = $this->mod->search_for_wr($q);
    $a = [];
    for ($i=1; $i < 10; $i++) { 
      $a[] = ['EQ_NO'=>'1900000'.$i, 'EQ_DESC'=>'Desc of Eq 1900000'.$i, 'EQ_CLASS'=>'EQ Clas Of 1900000'.$i, 'EQ_TYPE'=>'EQ TYPE Of 1900000'.$i];
    }
    $data['results'] = $a;
    $this->load->view($this->view.'/search_for_wr',$data);
  }
  public function optCriticality($name_id='')
  {
    $crt = $this->mod->criticality();
    $opt = "<select name='$name_id' class='form-control' id='$name_id'>";
    // $opt .= "<option value=''>--ALL CRITICALLY--</option>";
    foreach ($crt as $key => $value) {
      if($value->CRITICALLY == ' - .')
      {
        $opt .= "<option value=''>ALL CRITICALLY</option>";
      }
      else
      {
        $opt .= "<option value='$value->CRITICALLY'>$value->CRITICALLY</option>";
      }
    }
    $opt .= "</select>";
    return $opt;
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
  public function filejde($file='')
  {
	  $file = $this->input->get('xlink');
	  $file = str_replace('/','\\',$file);
	  $file = '\\\jktds01\E910\mediaobj\htmlupload\FILE-10-1-1-57-9189934920311359-1570436079629.pdf';
	  echo $file;
	  // exit();
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
  }
}