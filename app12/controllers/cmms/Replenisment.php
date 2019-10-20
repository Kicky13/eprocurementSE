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
      'RPUNCS' =>    'Unit Cost',
      'RPUORG' => 'Recommended Order Qty',
      'RPDOCO' => 'WO Number',
      'RPTRQT' => 'WO Reservation Qty',
      'RPDPL' => 'Plan Start Date',
      'RPDRQJ' => 'Request Finish Date',
      'RPEV01' => 'Status',
    ];
    $data['thead'] = $head;
    return $data[$value];
  }
  public function index($param='') {
    $this->load->library('cart');
    $this->cart->destroy();

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
      $itemNumber = trim($rows->RPLITM);
      $itemClear = str_replace('.', '', trim($rows->RPLITM));
      $row[] = "<a href='#' onclick=\"addItemNumber('$rows->RPLITM','$itemClear')\" id='tag$itemClear' class='btn btn-sm btn-primary'>Add</a>";
      
      foreach ($this->settings('thead') as $key => $value) {
        if($key == 'RPLITM')
        {
          $link = "<a href='#' onclick=\"detailReplenisment('$rows->RPLITM')\">$rows->RPLITM</a>";
          $row[] = $link;
        }
        elseif($key == 'RPUNCS')
        {
          $row[] = "<span style='float:right'>".numIndo($rows->$key)."</span>";
        }
        else
        {
          $row[] = $rows->$key;
        }
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
  public function show($no='')
  {
    $data = ['data'=>$this->mod->detail($no)];
    $this->load->view($this->view.'/detail', $data);
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
  public function add_to_cart()
  {
    $item_number = $this->input->post('item_number');
    $find = $this->mod->find($item_number);

    $this->load->library('cart');
    $data = array(
      'id'      => uniqid(),
      'qty'     => $find->RPUORG,
      'price'   => $find->RPUNCS,
      'name'    => str_replace('.', '-', $item_number),
      'options' => array('qty_onhand_value' => $find->RPPQOH)
    );
    $this->cart->insert($data);   
    if($this->cart->total() > 0) 
    {
      echo 1;
    }
    else
    {
      echo 0;
    }
  }
  public function remove_to_cart()
  {
    $item_number = $this->input->post('item_number');
    $this->load->library('cart');
    foreach ($this->cart->contents() as $items) {
      $rowid = $items['rowid'];
      if($items['name'] == str_replace('.', '-', $item_number))
      {
        $data = array(
          'rowid' => $rowid,
          'qty'   => 0
        );
        $this->cart->update($data);
      }
    }
    if($this->cart->total() > 0) 
    {
      echo 1;
    }
    else
    {
      echo 0;
    }
  }
  public function check_cart()
  {
    $this->load->library('cart');
    print_r($this->cart->contents());
  }
  public function save_draft_msr()
  {
    $this->load->library('cart');
    $this->load->model('material/M_group', 'material_group');

    $user = user();
    $department = $this->db->where('ID_DEPARTMENT',$user->ID_DEPARTMENT)->get('m_departement')->row();
    $t_msr_draft['id_currency'] = 3;
    $t_msr_draft['id_currency_base'] = 3;
    $t_msr_draft['id_costcenter'] = '101032210';
    $t_msr_draft['costcenter_desc'] = 'Maintenance';
    $t_msr_draft['id_msr_type'] = 'MSR01';
    $t_msr_draft['msr_type_desc'] = 'Goods';
    $t_msr_draft['create_by'] = $this->session->userdata('ID_USER');
    $t_msr_draft['create_on'] = date("Y-m-d H:i:s");
    $t_msr_draft['id_department'] = $user->ID_DEPARTMENT;
    $t_msr_draft['department_desc'] = $department->DEPARTMENT_DESC;
    
    $this->db->insert('t_msr_draft', $t_msr_draft);
    $insert_id = $this->db->insert_id();

    $contents = $this->cart->contents();
    foreach ($contents as $r) {
      $options = $r['options'];
      $price = ($r['price']/10000);
      $amount = $price * $r['qty'];
      $semic_no = str_replace('-', '.', $r['name']);
      $sql = "select * from m_material where trim(MATERIAL_CODE) = '".trim($semic_no)."'";
      $material = $this->db->query($sql)->row();
      // echo $this->db->last_query();
      // exit();
      $uom = $material->UOM;
      $uom_id = @$this->db->where('MATERIAL_UOM',$uom)->get('m_material_uom')->row()->ID;
      $t_msr_item_draft['t_msr_draft_id'] = $insert_id;
      $t_msr_item_draft['id_itemtype'] = 'GOODS';
      $t_msr_item_draft['id_itemtype_category'] = 'SEMIC';
      $t_msr_item_draft['material_id'] = $material->MATERIAL;
      $t_msr_item_draft['semic_no'] = $semic_no;
      $t_msr_item_draft['description'] = $material->MATERIAL_NAME;
      /*procurement/msr/findItemAttributes?material_id=10000002&type=GOODS&itemtype_category=SEMIC*/
      /*{"type":"GOODS","group_name":"DRILLING AND PRODUCTION (KLASIFKASI)","group_code":"A","subgroup_name":"CASING, TUBING AND ACCESSORIES","subgroup_code":"4","uom_description":"Meters","uom_name":"MT","uom_id":"85","qty_onhand":"","qty_ordered":""}*/
      $material_id = $material->MATERIAL;
      $type = 'GOODS';
      if ($material_id && $type) {
          if ($result = $this->material_group->findByMaterialAndType($material_id, $type)) {
              $result = $result[0];
              $t_msr_item_draft['groupcat'] = $result->group_code;
              $t_msr_item_draft['groupcat_desc'] = $result->group_name;
              $t_msr_item_draft['sub_groupcat'] = $result->subgroup_code;
              $t_msr_item_draft['sub_groupcat_desc'] = $result->subgroup_name;
          }
      }
      $t_msr_item_draft['qty'] = $r['qty'];
      $t_msr_item_draft['qty_onhand_value'] = $options['qty_onhand_value'];
      $t_msr_item_draft['uom_id'] = $uom_id;
      $t_msr_item_draft['uom'] = $uom;
      $t_msr_item_draft['priceunit'] = $price;
      $t_msr_item_draft['priceunit_base'] = $price;
      $t_msr_item_draft['id_importation'] = 'L';
      $t_msr_item_draft['importation_desc'] = 'Local';
      $t_msr_item_draft['id_dpoint'] = '10101';
      $t_msr_item_draft['dpoint_desc'] = 'Muara Laboh';
      $t_msr_item_draft['id_bplant'] = '10101';
      $t_msr_item_draft['id_costcenter'] = '101032210';
      $t_msr_item_draft['costcenter_desc'] = 'Maintenance';
      $t_msr_item_draft['amount'] = $amount;
      $t_msr_item_draft['amount_base'] = $amount;
      $t_msr_item_draft['inv_type'] = 1;
      $this->db->insert('t_msr_item_draft', $t_msr_item_draft);
      $this->mod->update($semic_no);
    }
    echo $insert_id;
  }
}