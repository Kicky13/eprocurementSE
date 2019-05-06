<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Registration_catalog extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('material/M_registration')->model('vendor/M_vendor');
        $this->load->helper(array('string', 'text'));
        $this->load->helper('helperx_helper');
    }


    public function index(){
      $tamp = $this->M_registration->show();
      $get_menu = $this->M_vendor->menu();
      $get_uom = $this->M_registration->material_uom();
      $get_mgroup = $this->M_registration->material_group();
      $get_mindicator = $this->M_registration->material_indicator();
      $get_mstockclass = $this->M_registration->m_material_stock_class();
      $get_mavailable = $this->M_registration->m_material_availability();
      $get_mcritical = $this->M_registration->m_material_cricatility();

      $data['total'] = count($tamp);
      $dt = array();
      $res_uom = array();
      $res_mgroup = array();
      $res_mindicator = array();
      $res_mstockclass = array();
      $res_mavailable = array();
      $res_mcritical = array();

      foreach ($get_mcritical as $arr) {
        $res_mcritical[] = array(
          'id' => $arr['ID'],
          'desc_in' => $arr['DESCRIPTION_IND'],
          'desc_en' => $arr['DESCRIPTION_ENG'],
        );
      }
      foreach ($get_mavailable as $arr) {
        $res_mavailable[] = array(
          'id' => $arr['ID'],
          'desc_in' => $arr['DESCRIPTION_IND'],
          'desc_en' => $arr['DESCRIPTION_ENG'],
        );
      }

      foreach ($get_mstockclass as $arr) {
        $res_mstockclass[] = array(
          'id' => $arr['ID'],
          'desc_in' => $arr['DESCRIPTION_IND'],
          'desc_en' => $arr['DESCRIPTION_ENG'],
        );
      }

      foreach ($get_mindicator as $arr) {
        $res_mindicator[] = array(
          'id' => $arr['ID'],
          'desc_in' => $arr['DESCRIPTION_IND'],
          'desc_en' => $arr['DESCRIPTION_ENG'],
        );
      }

      foreach ($get_mgroup as $arr) {
        $res_mgroup[] = array(
          'id' => $arr['ID'],
          'material_group' => $arr['MATERIAL_GROUP'],
          'material_desc' => $arr['DESCRIPTION'],
          'type' => $arr['TYPE'],
        );
      }

      foreach ($get_uom as $arr) {
        $res_uom[] = array(
          'id' => $arr['ID'],
          'material_uom' => $arr['MATERIAL_UOM'],
        );
      }

      foreach ($get_menu as $k => $v) {
          $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
          $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
          $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
          $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
      }

      $data['material_criticaly'] = $res_mcritical;
      $data['material_avalable'] = $res_mavailable;
      $data['material_stackclass'] = $res_mstockclass;
      $data['material_uom'] = $res_uom;
      $data['material_group'] = $res_mgroup;
      $data['material_indicator'] = $res_mindicator;
      $data['menu'] = $dt;
      $this->template->display('material/V_registration_catalog', $data);
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function datatable_logistic_specialist() {
      $data = $this->M_registration->datatable_logistic_specialist();
      $result = array();
      $no = 1;

      foreach ($data as $arr) {
        if ($arr['STATUS'] == '1') {
          $str = '<center><button data-id="'.$arr['MATERIAL'].'" id="prosesreq" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-primary" title="Update"><i class=""> Proses</i></button>
          <button data-id="'.$arr['MATERIAL'].'" id="history" data-toggle="modal" data-target="#modal_history" class="btn btn-sm btn-info" title="history"><i class=""> History</i></button>
          <button data-id="'.$arr['MATERIAL'].'" id="prosesreq" data-toggle="modal" data-target="#modal_rej" class="btn btn-sm btn-danger" title="Update"><i class=""> Reject</i></button>
          </center>';
          $class = 'success';
        } else {
          $str = '<center><button data-id="'.$arr['MATERIAL'].'" id="prosesreq" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-primary" title="Update"><i class=""> Proses</i></button>
          <button data-id="'.$arr['MATERIAL'].'" id="history" data-toggle="modal" data-target="#modal_history" class="btn btn-sm btn-info" title="history"><i class=""> History</i></button>
          <button data-id="'.$arr['MATERIAL'].'" id="prosesreq" data-toggle="modal" data-target="#modal_rej" class="btn btn-sm btn-danger" title="Update"><i class=""> Reject</i></button>
          </center>';
          $class = 'danger';
        }

        $result[] = array(
          0 => '<center>'.$no.'</center>',
          1 => '<center>'.$arr['REQUEST_NO'].'</center>',
          2 => '<center>'.$arr['DESCRIPTION'].'</center>',
          3 => '<center>'.$arr['UOM'].'</center>',
          4 => '<center><span class="badge badge badge-pill badge-'.$class.'">'.$arr['DESCRIPTION_IND'].'</span></center>',
          5 => $str
        );
        $no++;
      }
      echo json_encode($result);
    }

    public function material_equipment_group(){
      $idx = (!empty($_GET['idx'])?$_GET['idx']:"");
      $data = $this->M_registration->material_equipment_group($idx);
      if ($idx != "") {
        foreach ($data as $arr) {
          echo '<option value="'.$arr['ID'].'">'.$arr['DESCRIPTION'].'</option>';
        }
      } else {
          echo '<option value="">No Data Found</option>';
      }
    }

    public function material_clasification_group(){
      $idx = (!empty($_GET['idx'])?$_GET['idx']:"");
      $data = $this->M_registration->material_clasification_group($idx);
      $result = array();
      if ($idx != "") {
        foreach ($data as $arr) {
          $result['mgroup'] = $arr;
        }
      } else {
          $result['mgroup'] = false;
      }
      echo json_encode($result);
    }

    public function get_data_requestor(){
      $idnya = (!empty($_POST["idnya"])?$_POST["idnya"]:"");
      $data = $this->M_registration->get_data_requestor($idnya);
      $respon = array();
      foreach ($data as $arr) {
        $respon[] = array(
          'material' => $arr['MATERIAL'],
          'description' => $arr['DESCRIPTION'],
          'img1_url' => $arr['IMG1_URL'],
          'img2_url' => $arr['IMG2_URL'],
          'file_url' => $arr['FILE_URL'],
          'uom' => $arr['UOM'],
          'material_name' => $arr['MATERIAL_NAME'],
          'description1' => $arr['DESCRIPTION1'],
          'img3_url' => $arr['IMG3_URL'],
          'img4_url' => $arr['IMG4_URL'],
          'file_url2' => $arr['FILE_URL2'],
          'uom1' => $arr['UOM1'],
          'equipment_no' => $arr['EQPMENT_NO'],
          'manufacturer' => $arr['MANUFACTURER'],
          'manufacturer_desc' => $arr['MANUFACTURER_DESCRIPTION'],
          'material_type' => $arr['MATERIAL_TYPE'],
          'material_type_desc' => $arr['MATERIAL_TYPE_DESCRIPTION'],
          'sequence_group' => $arr['SEQUENCE_GROUP'],
          'sequence_group_desc' => $arr['SEQUENCE_GROUP_DESCRIPTION'],
          'indicator' => $arr['INDICATOR'],
          'stock_class' => $arr['STOCK_CLASS'],
          'availability' => $arr['AVAILABILITY'],
          'criticality' => $arr['CRITICALITY'],
          'data2' => $arr
        );
      }
      echo json_encode($respon, JSON_PRETTY_PRINT);
    }

    public function minta_manufacturer(){
      $term = (!empty($_GET['term'])?$_GET['term']:"");
      $respon = array();
      $result = $this->M_registration->material_group_manufacturer($term);
      foreach ($result as $arr) {
        $respon[] = array(
          'value' => $arr['MANUFACTURER'],
          'label' => $arr['MANUFACTURER'].", ".$arr['MANUFACTURER_DESCRIPTION'],
          'material_group' => $arr['MANUFACTURER_DESCRIPTION']
        );
      }
      echo json_encode($respon, JSON_PRETTY_PRINT);
    }

    public function minta_material_modeltype(){
      $term = (!empty($_GET['term'])?$_GET['term']:"");
      $respon = array();
      $result = $this->M_registration->material_group_modeltype($term);
      foreach ($result as $arr) {
        $respon[] = array(
          'value' => $arr['MATERIAL_TYPE'],
          'label' => $arr['MATERIAL_TYPE'].", ".$arr['MATERIAL_TYPE_DESCRIPTION'],
          'material_type' => $arr['MATERIAL_TYPE_DESCRIPTION']
        );
      }
      echo json_encode($respon, JSON_PRETTY_PRINT);
    }

    public function minta_material_sequence(){
      $term = (!empty($_GET['term'])?$_GET['term']:"");
      $respon = array();
      $result = $this->M_registration->material_sequence($term);
      foreach ($result as $arr) {
        $respon[] = array(
          'value' => $arr['SEQUENCE_GROUP'],
          'label' => $arr['SEQUENCE_GROUP'].", ".$arr['SEQUENCE_GROUP_DESCRIPTION'],
          'material_type' => $arr['SEQUENCE_GROUP_DESCRIPTION']
        );
      }
      echo json_encode($respon, JSON_PRETTY_PRINT);
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
                $ctn = ' <p>' . $content['img1'] . '<p>
                        <br>' . $content['open'] . '
                        <br>
                        ' . $content['close'] . '
                        <br>

                        ';
                //$this->email->message();
                //$this->email->to($v);

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
                $ctn = ' <p>' . $content['img1'] . '<p>
                        <br>' . $content['open'] . '
                        <br>
                        ' . $content['close'] . '
                        <br>

                        ';
                //$this->email->message();
                //$this->email->to($content['email']);

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

    public function save_registrasi_catalog(){
      $material = (!empty($_POST['material'])?$_POST['material']:"");
      $m_name = (!empty($_POST['m_name'])?$_POST['m_name']:"");
      $m_desc_cataloguing = (!empty($_POST['m_desc_cataloguing'])?$_POST['m_desc_cataloguing']:"");
      $optmaterial_uom2 = (!empty($_POST['optmaterial_uom2'])?$_POST['optmaterial_uom2']:"");
      $equipment_id = (!empty($_POST['equipment_id'])?$_POST['equipment_id']:"");
      $equipment_no = (!empty($_POST['equipment_no'])?$_POST['equipment_no']:"");
      $no_manufacturer = (!empty($_POST['no_manufacturer'])?$_POST['no_manufacturer']:"");
      $name_manufacturer = (!empty($_POST['name_manufacturer'])?$_POST['name_manufacturer']:"");
      $part_no = (!empty($_POST['part_no'])?$_POST['part_no']:"");
      $model_type_no = (!empty($_POST['model_type_no'])?$_POST['model_type_no']:"");
      $model_type_name = (!empty($_POST['model_type_name'])?$_POST['model_type_name']:"");
      $squence_group_no = (!empty($_POST['squence_group_no'])?$_POST['squence_group_no']:"");
      $squence_group_name = (!empty($_POST['squence_group_name'])?$_POST['squence_group_name']:"");
      $material_indicator = (!empty($_POST['material_indicator'])?$_POST['material_indicator']:"");
      // $material_indicator_desc = (!empty($_POST['material_indicator_desc'])?$_POST['material_indicator_desc']:"");
      $stockclass = (!empty($_POST['stockclass'])?$_POST['stockclass']:"");
      $available = (!empty($_POST['available'])?$_POST['available']:"");
      $critical = (!empty($_POST['critical'])?$_POST['critical']:"");

      $material_image2 = ($_FILES["material_image2"]["name"] != "" ? $_FILES["material_image2"] : "");
      $material_drawing2 = ($_FILES["material_drawing2"]["name"] != "" ? $_FILES["material_drawing2"] : "");
      $material_other2 = ($_FILES["material_other2"]["name"] != "" ? $_FILES["material_other2"] : "");

      if (!empty($available)) { $im_available = implode("|", $available); } else { $im_available = ""; }
      if (!empty($critical)) { $im_critical = implode("|", $critical); } else { $im_critical = ""; }
      if (!empty($stockclass)) { $im_stockclass = implode("|", $stockclass); } else { $im_stockclass = ""; }

      $respon = array();
      $simpan_data = array(
          'MATERIAL' => $material,
          'MATERIAL_NAME'=> $m_name,
          'DESCRIPTION1'=> $m_desc_cataloguing,
          'IMG3_URL'=> $material_image2,
          'IMG4_URL'=> $material_drawing2,
          'FILE_URL2'=> $material_other2,
          'UOM1'=> $optmaterial_uom2,
          'EQPMENT_NO'=> $equipment_no,
          'EQPMENT_ID'=> $equipment_id,
          'MANUFACTURER'=> $no_manufacturer,
          'MANUFACTURER_DESCRIPTION'=> $name_manufacturer,
          'MATERIAL_TYPE'=> $model_type_no,
          'MATERIAL_TYPE_DESCRIPTION'=> $model_type_name,
          'SEQUENCE_GROUP'=> $squence_group_no,
          'SEQUENCE_GROUP_DESCRIPTION'=> $squence_group_name,
          'INDICATOR'=> $material_indicator,
          'INDICATOR_DESCRIPTION'=> '',
          'STOCK_CLASS'=> $im_stockclass,
          'AVAILABILITY'=> $im_available,
          'CRITICALITY'=> $im_critical,
          'PART_NO'=> $part_no,
          'STATUS'=> '2',
          'CREATE_BY'=> $this->session->userdata['ID_USER'],
          'CREATE_TIME'=> date("Y-m-d H:i:s"),
      );

      if ($material_image2 != "" AND $material_drawing2 != "" AND $material_other2 != "") {
        $result = $this->M_registration->save_registrasi_catalog($simpan_data);
      } else {
        $result = $this->M_registration->save_registrasi_catalog_ditolak($simpan_data);
      }
      // $result = true;
      if ($result == true) {
        $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
        $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";

        $content = $this->M_registration->get_email_dest(18);
        $content[0]->ROLES = explode(",", $content[0]->ROLES);
        $res = $this->M_registration->get_user($content[0]->ROLES, count($content[0]->ROLES));
        $str = '
                Nama Material: '.$m_name.'<br>
                UOM: '.$optmaterial_uom2.'<br>
                Tipe Material: '.$model_type_name.'<br>
                Sequence:'.$squence_group_name.'<br>
                Manufacturer:'.$name_manufacturer.'<br>
                Deskripsi: '.$m_desc_cataloguing.'<br>
                ';

        $data = array(
            'img1' => $img1,
            'img2' => $img2,
            'title' => $content[0]->TITLE,
            'open' => str_replace("deskripsinya", $str, $content[0]->OPEN_VALUE),
            'close' => $content[0]->CLOSE_VALUE
        );
        foreach ($res as $k => $v) {
            $data['dest'][] = $v->EMAIL;
        }
        $flag = $this->sendMail($data);

        $respon = array(
          'success' => true,
          'data' => $simpan_data
        );
      } else {
        $respon['success'] = false;
      }

      echo json_encode($respon, JSON_PRETTY_PRINT);
    }

    public function reject_request_material(){
      $idnya = (!empty($_POST['idnya'])?$_POST['idnya']:"");
      $note = (!empty($_POST['note'])?$_POST['note']:"");
      $save_data = array(
        'idnya' => $idnya,
        'note' => $note,
        'user' => $this->session->userdata['ID_USER'],
      );

      $result = $this->M_registration->reject_request_material($save_data);
      // $result = true;
      if ($note != "") {
        $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
        $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";

        $content = $this->M_registration->get_email_dest(19);
        $content[0]->ROLES = explode(",", $content[0]->ROLES);
        $res = $this->M_registration->get_user($content[0]->ROLES, count($content[0]->ROLES));
        $str = 'Catatan: '.$note.'<br>';

        $data = array(
            'img1' => $img1,
            'img2' => $img2,
            'title' => $content[0]->TITLE,
            'open' => str_replace("deskripsinya", $str, $content[0]->OPEN_VALUE),
            'close' => $content[0]->CLOSE_VALUE
        );

        foreach ($res as $k => $v) {
            $data['dest'][] = $v->EMAIL;
        }
        $flag = $this->sendMail($data);
        $respon = true;
      } else {
        $respon = false;
      }
      echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function show_history(){
      $idnya = $this->input->post("id");
      $result = $this->M_registration->show_history($idnya);
      $no = 1;
      $str = "";

      if (!empty($result['log_material'])) {
        foreach ($result['log_material'] as $key => $val) {
          $str .= '<tr>
                    <td>'.$no.'</td>
                    <td>'.$result['material']['DESCRIPTION_ENG'].'</td>
                    <td>'.$val['NOTE'].'</td>
                    <td>'.$result['material']['USERNAME'].'</td>
                    <td>'.$val['CREATE_TIME'].'</td>
                  </tr>';
          $no++;
        }
      } else {
        $str .= '<tr>
                  <td></td>
                  <td></td>
                  <td>Belum Ada Histori</td>
                  <td></td>
                  <td></td>
                </tr>';
      }

      echo $str;
      // echo json_encode($result);
    }

  }
