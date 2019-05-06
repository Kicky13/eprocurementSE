<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Material_req_list extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('material/M_material_req_list')->model('vendor/M_vendor')->model('material/M_material_req');
        $this->load->helper('global_helper');
    }

    public function index() {
      $data['material'] = $this->M_material_req->show_material();
      $data['req_no'] = $this->M_material_req->mreq_number();
      $data['company'] = $this->M_material_req->show_company($this->session->DEPARTMENT);
      $data['bp'] = $this->M_material_req->show_bp();
      $data['mr_type'] = $this->M_material_req->show_mr_type();
      $data['dept'] = $this->M_material_req->show_dept();
      $data['currency'] = $this->M_material_req->show_curency();
      $data['bplant'] = $this->M_material_req->show_bplant();
      $data['to_comp'] = $this->M_material_req->company();
      $data['wo_reason'] = $this->M_material_req->show_wo_reason();
      $data['asset_type'] = $this->M_material_req->show_asset_type();
      $data['disposal_method'] = $this->M_material_req->show_disposal_method();
      $data['costcenter'] = $this->M_material_req->show_costcenter();

      $get_menu = $this->M_vendor->menu();
      $dt = array();
      foreach ($get_menu as $k => $v) {
          $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
          $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
          $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
          $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
      }
      $data['menu'] = $dt;
      $this->template->display('material/V_material_req_list', $data);
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    // --------------------------------------- sendmail  --------------------------------------------
    protected function sendMail($content) {
        $mail = get_mail();
        $config = array();
        $config['protocol'] = $mail['protocol'];
        $config['smtp_crypto'] = $mail['crypto'];
        if($mail['protocol'] == 'smtp'){
            $config['smtp_pass'] = $mail['password'];
        }

        //$config['protocol'] = 'mail';
        //$config['smtp_crypto'] = '';

        $config['crlf'] = "\r\n";
        $config['mailtype'] = 'html';
        $config['smtp_host'] = $mail['smtp'];
        $config['smtp_port'] = $mail['port'];
        $config['smtp_user'] = $mail['email'];
        $config['charset'] = "utf-8";
        $config['newline'] = "\r\n";

        if (count($content['dest']) != 0 && !isset($content['email'])) {
            foreach ($content['dest'] as $k => $v) {
                $this->load->library('email', $config);
                $this->email->initialize($config);
                $this->email->from($mail['email'], '[SYSTEM] EPROC SUPREME ENERGY');
                $this->email->subject($content['title']);
                $this->email->message(' <p>' . $content['img1'] . '<p>
                        <br>' . $content['open'] . '
                        <br>
                        ' . $content['close'] . '
                        <br>

                        ');
                $ctn = ' <p>' . $content['img1'] . '<p>
                        <br>' . $content['open'] . '
                        <br>
                        ' . $content['close'] . '
                        <br>';

                $this->email->to($v);


                $data_email['recipient'] = $v;
        $data_email['subject'] = $content['title'];
        $data_email['content'] = $ctn;
        $data_email['ismailed'] = 0;

                if ($this->db->insert('i_notification',$data_email)) {
                    $flag = 1;
                } else {
                    $flag = 0;
                  }

            }
        }
        else
        {
            $this->load->library('email', $config);
                $this->email->initialize($config);
                $this->email->from($mail['email'], '[SYSTEM] EPROC SUPREME ENERGY');
                $this->email->subject($content['title']);
                $this->email->message(' <p>' . $content['img1'] . '<p>
                        <br>' . $content['open'] . '
                        <br>
                        ' . $content['close'] . '
                        <br>

                        ');

                $ctn = ' <p>' . $content['img1'] . '<p>
                        <br>' . $content['open'] . '
                        <br>
                        ' . $content['close'] . '
                        <br>';

                $this->email->to($content['email']);
                $data_email['recipient'] = $content['email'];
                $data_email['subject'] = $content['title'];
                $data_email['content'] = $ctn;
                $data_email['ismailed'] = 0;
                if ($this->db->insert('i_notification',$data_email)) {
                     return true;
                } else {
                    return false;
                }
        }
        if ($flag == 1)
            return true;
        else
            return false;
    }
    // -----------------------------------------------------------------------------------

    public function datatable_mr(){
      $data = $this->M_material_req_list->datatable_mr();
      $result = array();
      $no = 1;
      foreach ($data as $arr) {
        if (strpos($arr['description'], "DATA DITOLAK") === FALSE) {
          $class = 'success';
          $disabled = '';
        } else {
          $class = 'danger';
          $disabled = '';
        }
        $aksi = '<button data-id="'.$arr['request_no'].'" data-status="'.$arr['description'].'" id="approve" data-toggle="modal" data-target="#modal_approval" class="btn btn-sm btn-info" title="Detail" '.$disabled.'>Detail';
        // $no++;
        if ($arr['status_jde'] == 1) { $status_jde = 'close'; } else { $status_jde = 'open'; }

        $result[] = array(
          0 => $no++,
          1 => $arr['request_no'],
          2 => dateToIndo($arr['request_date']),
          3 => $arr['mr_type_desc'],
          4 => $arr['purpose_of_request'],
          5 => $arr['semic_no'],
          6 => $arr['item_desc'],
          7 => $arr['uom'],
          8 => $arr['qty'],
          9 => $arr['qty_act'],
          10 => $arr['branch_plant'],
          11 => $arr['to_branch_plant'],
          12 => $arr['description'],
          13 => $status_jde,
          14 => $aksi,
        );
      }
      echo json_encode($result);
    }

    public function get_material_req(){
      $idnya = $this->input->post("idnya");
      $data = $this->M_material_req_list->get_material_req($idnya);
      $data_loc = $this->M_material_req->get_location();
      // $obj_dt = $data;
      // $data->material_request->get_location = $data_loc->result_array();

      echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function save_note(){
      $notes = $this->input->post("notes");
      $mr_no = $this->input->post("mr_no");
      $data_insert = array(
        'module_kode' => 'mrnote',
        'data_id' => $mr_no,
        'description' => $notes,
        'created_at' => date("Y-m-d H:i:s"),
        'created_by' => $this->session->userdata['ID_USER'],
        'author_type' => 'm_user',
      );
      $save = $this->M_material_req_list->save_note($data_insert);
      if ($save == true) {
        $result['success'] = true;
      } else {
        $result['success'] = false;
      }
      echo json_encode($result);
    }
    //
    public function get_note(){
      $mr_no = $this->input->post("mr_no");
      $data = $this->M_material_req_list->get_note($mr_no);
      foreach ($data->result_array() as $key => $value) {
        echo '<div class="media-list">
              <div id="headingCollapse1" class="card-header p-0">
                <a data-toggle="collapse" href="#collapse1" aria-expanded="false" aria-controls="collapse1"
                class="collapsed email-app-sender media border-0 bg-blue-grey bg-lighten-5">
                  <div class="media-left pr-1">
                    <span class="avatar avatar-md">
                      <img class="media-object rounded-circle" src="'.base_url('ast11/img/iconuser.png').'"
                      alt="Generic placeholder image">
                    </span>
                  </div>
                  <div class="media-body w-100">
                    <h6 class="list-group-item-heading"><b>'.$value['NAME'].'</b></h6>
                    <p class="list-group-item-text">'.$value['description'].'
                      <span class="float-right text muted">'.$value['created_at'].'</span>
                    </p>
                  </div>
                </a>
              </div>
            </div>
            <br>';
      }
    }


    public function get_log(){
      $mr_no = $this->input->post("mr_no");
      $data = $this->M_material_req_list->get_log($mr_no);
      $no = 1;
      foreach ($data->result_array() as $key => $value) {
        echo '
        <tr>
          <td>'.$no++.'</td>
          <td>'.$value['title'].'</td>
          <td>'.strtoupper($value['NAME']).'</td>
          <td>'.$value['description'].'</td>
          <td>'.dateToIndo($value['created_at'],false,true).'</td>
        </tr>
        ';
      }
    }

}
