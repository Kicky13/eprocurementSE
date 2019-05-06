<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Perform_itp extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('procurement/M_perform_itp')->model('vendor/M_vendor');
        $this->load->helper(array('string', 'text'));
        $this->load->helper('helperx_helper');
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
        $this->template->display('procurement/V_perform_itp', $data);
    }

    public function datatable_itpuser_remaining(){
      $data = $this->M_perform_itp->show_itpuser_remaining();
      $result = array();
      $no = 1;
      foreach ($data as $arr) {
        $aksi = '<center> <button data-id="'.$arr['id_itp'].'" id="approve" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-success" title="Update"><i class=""> PERFORM ITP</i></button></center>';
        $result[] = array(
          0 => $no,
          1 => $arr['msr_no'],
          2 => $arr['no_po'],
          3 => $arr['note'],
          4 => $arr['created_date'],
          5 => $aksi,
        );
        $no++;
      }
      echo json_encode($result);
    }

    public function datatable_list_itp_on_progress(){
      $data = $this->M_perform_itp->list_itp_onprogress();
      $result = array();
      $no = 1;

      $class = 'success';
      foreach ($data as $arr) {
        $aksi = '<center> <button data-id="'.$arr['msr_no'].'" id="approve" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-success" title="Update"><i class=""> PERFORM ITP</i></button>
        <button data-id="'.$arr['msr_no'].'" id="reject" data-toggle="modal" data-target="#modal_rej" class="btn btn-sm btn-danger" title="Update"><i class=""> Reject</i></button></center>';

        $result[] = array(
          0 => $no,
          1 => $arr['msr_no'],
          2 => $arr['note'],
          3 => $arr['jabatan'],
          4 => '<center><span class="badge badge badge-pill badge-'.$class.'">'.$arr['description'].'</span></center>',
          5 => $aksi,
        );
        $no++;
      }
      echo json_encode($result);
    }

    public function get_item_selection(){
      $idnya = $this->input->post("idnya");
      $data = $this->M_perform_itp->get_item_selection($idnya);
      echo json_encode($data);
    }

    public function create_itp_document(){
      $msr_number = $this->input->post("msr_number");
      $item_type = $this->input->post("item_type");
      $note = $this->input->post("note");
      $item_qty = $this->input->post("item_qty");
      $item_ammount = $this->input->post("item_ammount");
      $material_id = $this->input->post("material_id");
      $total_spending = $this->input->post("total_spending");
      $price_unit = $this->input->post("price_unit");
      // $file_attch = ($_FILES["file_attch"] != "" ? $_FILES["file_attch"] : "");

      $data = array(
        'msr_no' => $msr_number,
        'no_po' => "",
        'note' => $note,
        'type' => 'ITP',
        'material_id'	=> $material_id,
        'qty'	=> $item_qty,
        'priceunit'	=> $price_unit,
        'total' => $item_ammount,
        'filename' => $_FILES["file_attch"],
      );

      if (!empty($note) OR !empty($item_qty) OR !empty($item_ammount) OR !empty($material_id) OR !empty($total_spending) OR !empty($price_unit)) {
        $ressult = true;
        $this->M_perform_itp->create_itp_document($data);
      } else {
        $ressult = false;
      }
      echo json_encode($ressult, JSON_PRETTY_PRINT);
    }

    public function show_data_itp(){
      $msr_no = $this->input->post("msr_no");
      $data = $this->M_perform_itp->show_data_itp($msr_no);
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
