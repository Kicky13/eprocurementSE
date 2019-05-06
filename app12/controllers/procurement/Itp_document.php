<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Itp_document extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('procurement/M_itp_document')->model('vendor/M_vendor');
        $this->load->model('m_base');
        $this->load->model('procurement/m_service_receipt_itp');
        $this->load->helper(array('string', 'text'));
        $this->load->helper('helperx_helper');
        $this->load->helper('global_helper');
    }

    public function index() {
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $this->template->display('procurement/V_itp_document', $data);
    }

    public function datatable_po_remaining(){
      $data = $this->M_itp_document->show_po_remaining();
      $result = array();
      $no = 1;
      foreach ($data as $arr) {
        $aksi = '<center> <button data-id="'.$arr['po_no'].'" id="approve" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-info" title="Update"><i class=""> Process</i></button></center>';
        $result[] = array(
          0 => $no,
          1 => $arr['po_no'],
          2 => $arr['title'],
          3 => $arr['vendor'],
          4 => $arr['CURRENCY'],
          5 => dateToIndo($arr['po_date'], false, false),
          6 => dateToIndo($arr['delivery_date'], false, false),
          7 => $aksi,
        );
        $no++;
      }
      echo json_encode($result);
    }

    public function datatable_list_itp_on_progress(){
      $data = $this->M_itp_document->show_po_remaining();
      $result = array();
      $no = 1;
      foreach ($data as $arr) {
        $aksi = '<center> <button data-id="'.$arr['po_no'].'" id="approve" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-info" title="Update"><i class=""> Process</i></button></center>';
        $result[] = array(
          0 => $no,
          1 => $arr['po_no'],
          2 => $arr['title'],
          3 => $arr['vendor'],
          4 => $arr['CURRENCY'],
          5 => dateToIndo($arr['po_date'], false, false),
          6 => dateToIndo($arr['delivery_date'], false, false),
          7 => $aksi,
        );
        $no++;
      }
      echo json_encode($result);
    }

    public function get_item_selection(){
      $idnya = $this->input->post("idnya");
      $item = $this->M_itp_document->get_item_selection($idnya);
      $get_comp = $this->M_itp_document->get_comp($idnya);

      foreach($item as $key => $val){
        $item[$key]['dt_comp'] = $get_comp;
      }
      $data['receipt'] = $total_receipt = $this->m_service_receipt_itp->view('total_receipt_po')
      ->where('t_itp.no_po', $idnya)
      ->first();
      $data['item'] = $item;
      echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function create_itp_document(){
      $no_po = $this->input->post("po_no");
      $item_type = $this->input->post("item_type");
      $note = $this->input->post("note");
      $item_qty = $this->input->post("item_qty");
      $item_ammount = $this->input->post("item_ammount");
      $material_id = $this->input->post("material_id");
      $total_spending = $this->input->post("total_spending");
      $price_unit = $this->input->post("price_unit");
      $id_vendor = $this->input->post("id_vendor");
      $remark = $this->input->post("remark");
      (!empty($_POST['date_itp']) ? $date_itp = date("Y-m-d", strtotime($_POST['date_itp'])) : $date_itp = date("Y:m:d") );
      // $file_attch = ($_FILES["file_attch"] != "" ? $_FILES["file_attch"] : "");

      $data = array(
        'msr_no' => "",
        'no_po' => $no_po,
        'note' => $note,
        'type' => 'ITP',
        'material_id'	=> $material_id,
        'qty'	=> $item_qty,
        'priceunit'	=> $price_unit,
        'total' => $item_ammount,
        'total_spending' => $total_spending,
        'id_vendor' => $id_vendor,
        'filename' => $_FILES["file_attch"],
        'remark' => $remark,
        'dated' => $date_itp,
      );

      if (!empty($item_qty) AND !empty($item_ammount) AND !empty($material_id) AND !empty($total_spending) AND !empty($price_unit)) {
        $handle = 1;
        // foreach ($total_spending as $key => $value) {
        //   if ($value < 0) {
        //     $handle = 0;
        //     break;
        //   } else {
        //     $handle = 1;
        //   }
        // }

        if ($handle === 1) {
          $ressult = true;
          $data['number_of'] = $this->M_itp_document->number_of_itp($no_po);
          $data['res_success'] = $this->M_itp_document->create_itp_document($data);
        } else {
          $ressult = false;
        }
      } else {
        $ressult = false;
      }

      $data['handle'] = $handle;
      $data['success'] = $ressult;
      echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function show_data_itp(){
      $msr_no = $this->input->post("msr_no");
      $data = $this->M_itp_document->show_data_itp($msr_no);
      if (!empty(array_filter($data))) {
        foreach ($data['itp_detail'] as $key => $value) {
          $str = '<tr>'.
                      '<td><input type="hidden" name="material_id[]" value="'.$value['data_itp_detail']['material_id'].'" readonly />'.$value['data_itp_detail']['material_id'].'</td>'.
                      '<td><input type="hidden" name="item_type[]" value="'.$value['data_itp_detail']['id_itemtype'].'" readonly />'.$value['data_itp_detail']['id_itemtype'].'</td>'.
                      '<td>'.$value['data_itp_detail']['MATERIAL_NAME'].'</td>'.
                      '<td><input id="qty2'.$value['data_itp_detail']['material_id'].'" type="text" name="item_qty[]" onKeyup="change('.$value['data_itp_detail']['material_id'].', '.$value['data_itp_detail']['priceunit'].', '.$value['data_itp_detail']['total'].')" value="'.$value['data_itp_detail']['qty'].'" required /></td>'.
                      '<td>'.$value['data_itp_detail']['uom'].'</td>'.
                      '<td><input id="spending2'.$value['data_itp_detail']['material_id'].'" type="text" name="item_ammount[]" onChange="change('.$value['data_itp_detail']['material_id'].', '.$value['data_itp_detail']['total'].')" value="'.$value['data_itp_detail']['total'].'" readonly required /></td>'.
                      '<td><button type="button" data-id="'.$value['data_itp_detail']['material_id'].'" id="remove_item" class="btn btn-sm btn-danger">Remove</button></td>'.
                    '</tr>';
        echo $str;
        }
      }

      // echo json_encode($data, JSON_PRETTY_PRINT);
    }

}
