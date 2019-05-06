<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Revision_material extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('material/M_material_registration')
            ->model('material/M_mregist_approval')
            ->model('vendor/M_vendor')
            ->model('material/M_material_revision');
        $this->load->model('material/M_show_material');
        $this->load->helper(array('string', 'text', 'form', 'permission'));
        $this->load->helper('helperx_helper');
    }

    public function index() {
      $tamp = $this->M_material_revision->show();
      $get_menu = $this->M_vendor->menu();
      $get_uom = $this->M_mregist_approval->material_uom();
      $get_mgroup = $this->M_mregist_approval->material_group();
      $get_mindicator = $this->M_mregist_approval->material_indicator();
      $get_mstockclass = $this->M_mregist_approval->m_material_stock_class();
      $get_mavailable = $this->M_mregist_approval->m_material_availability();
      $get_mcritical = $this->M_mregist_approval->m_material_cricatility();
      $get_hazardous = $this->M_mregist_approval->m_hazardous();
      $get_gl_class = $this->M_mregist_approval->m_gl_class();
      $get_project_phase = $this->M_mregist_approval->m_project_phase();
      $get_line_type = $this->M_mregist_approval->m_line_type();
      $get_stocking_type = $this->M_mregist_approval->m_stocking_type();
      $get_stock_class = $this->M_mregist_approval->m_stock_class();
      $get_inventory_type = $this->M_mregist_approval->m_inventory_type();

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
          'description' => $arr['DESCRIPTION'],
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
      $data['hazardous'] = $get_hazardous;
      $data['gl_class'] = $get_gl_class;
      $data['project_phase'] = $get_project_phase;
      $data['line_type'] = $get_line_type;
      $data['stocking_type'] = $get_stocking_type;
      $data['stock_class'] = $get_stock_class;
      $data['inventory_type'] = $get_inventory_type;
      $data['menu'] = $dt;
      $this->template->display('material/V_revision_material', $data);
    }

    public function create($material)
    {
        if (!can_create_material_revision()) {
          show_error('Unauthorized', 401);
        }

        $uneditable = $this->M_material_revision->getUnEditableMaterial($material);
        if ($uneditable) {
          show_error('Another catalogue number revision request exists. Only one request allowed at once.');
        }

        $menu = get_main_menu();

        // TODO: to check whether any prior revision request


        $material = @$this->M_show_material->show($material)[0];
        $material['id'] = ''; // "id" here come from t_approval_material

        if (!$material) {
            show_404();
        }


        $get_menu = $this->M_vendor->menu();
        $get_uom = $this->M_mregist_approval->material_uom();
        $get_mgroup = $this->M_mregist_approval->material_group();
        $get_mindicator = $this->M_mregist_approval->material_indicator();
        $get_mstockclass = $this->M_mregist_approval->m_material_stock_class();
        $get_mavailable = $this->M_mregist_approval->m_material_availability();
        $get_mcritical = $this->M_mregist_approval->m_material_cricatility();
        $get_hazardous = $this->M_mregist_approval->m_hazardous();
        $get_gl_class = $this->M_mregist_approval->m_gl_class();
        $get_project_phase = $this->M_mregist_approval->m_project_phase();
        $get_line_type = $this->M_mregist_approval->m_line_type();
        $get_stocking_type = $this->M_mregist_approval->m_stocking_type();
        $get_stock_class = $this->M_mregist_approval->m_stock_class();
        $get_inventory_type = $this->M_mregist_approval->m_inventory_type();

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
          'description' => $arr['DESCRIPTION'],
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
        $data['hazardous'] = $get_hazardous;
        $data['gl_class'] = $get_gl_class;
        $data['project_phase'] = $get_project_phase;
        $data['line_type'] = $get_line_type;
        $data['stocking_type'] = $get_stocking_type;
        $data['stock_class'] = $get_stock_class;
        $data['inventory_type'] = $get_inventory_type;
        $data['menu'] = $dt;
        $data['material'] = $material;

        return $this->template->display('material/V_revision_material_create', $data);
    }

    public function createForm()
    {
      return $this->load->view('material/V_revision_material_form_modal');
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }


    // --------------------------------------- sendmail  --------------------------------------------
    protected function send_mail($content) {
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

                $data_email['recipient'] = $v->email;
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
                if ($this->db->insert('i_notification', $data_email)) {
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

    public function get_data_requestor(){
      $idnya = (!empty($_POST["idnya"])?$_POST["idnya"]:"");
      $data = $this->M_material_registration->get_data_requestor($idnya);
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

    public function show() {
        $data = $this->M_material_revision->show();
        $dt = array();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->DESCRIPTION);
            $dt[$k][2] = stripslashes(word_limiter($v->LONG_DESCRIPTION, 2));
            $dt[$k][3] = stripslashes($v->MATERIAL_GROUP);
            $dt[$k][4] = stripslashes($v->MATERIAL_TYPE);
            $dt[$k][5] = stripslashes($v->MATERIAL_UOM);
            if ($v->STATUS == 1) {
                $dt[$k][6] = "Active";
            } else {
                $dt[$k][6] = "Nonactive";
            }
            $dt[$k][7] = "<a class='btn btn-info btn-sm' title='Update' href='javascript:void(0)' onclick='update(" . $v->ID . ")'><i class='fa fa-edit'></i></a>";
        }
        echo json_encode($dt);
    }

    public function get($id) {
        echo json_encode($this->M_material_registration->show(array("ID" => $id)));
    }

    public function change() {
//        strtoupper($string)
        $data = array(
            'MATERIAL' => strtoupper(stripslashes($_POST['mat_material'])),
            'DESCRIPTION' => stripslashes($_POST['desc']),
            'LONG_DESCRIPTION' => stripslashes(($_POST['open_edit'])),
            'MATERAIL_GROUP' => stripslashes($_POST['group_material']),
            'MATERAIL_TYPE' => strtoupper(stripslashes($_POST['material_type'])),
            'MATERAIL_UOM' => stripslashes($_POST['material_uom']),
            'STATUS' => $_POST['status'],
            'UPDATE_BY' => 1,
            'UPDATE_TIME' => date('Y-m-d H:i:s')
        );
        if ($_POST['id'] == null) {//add data
            $data['CREATE_BY'] = $this->session->userdata('ID_USER');
            $cek = $this->M_material_revision->show(array("MATERIAL" => strtoupper(stripslashes($_POST['mat_material']))));
            if (count($cek) == 0) {//cek ketersediaan data
                $q = $this->M_material_revision->add($data);
            } else {
                echo "Tipe Material Telah Digunakan";
                exit;
            }
        } else {//update data
            $q = $this->M_material_revision->update($_POST['id'], $data);
        }

        //CEK QUERY BERHASIL DIJALANKAN
        if ($q == 1) {
            echo "sukses";
        } else {
            echo "Gagal Menambah Data!";
        }
    }

    public function save() {
        $path_ori = "upload/MATERIAL/img/ori/";
        $path_sml = "upload/MATERIAL/img/small/";
        $path_file = "upload/MATERIAL/files/";
        $img1 = $_FILES["material_image"];
        $img2 = $_FILES["material_drawing"];
        $img3 = $_FILES["material_other"];
        $img1_res = '';
        $img2_res = '';
        $img3_res = '';
        $result = false;
        $material = '';

        // get original material
        $original_material = $this->M_show_material->find($this->input->post('material'));

        if ($img1['error'] != 4 && $img1['tmp_name'] !== '') {
            $img1_res = image_upload($img1["tmp_name"], $img1["name"], $img1["type"], $img1["size"], $path_ori, $path_sml);
        } elseif($img1['tmp_name'] === '') {
            $img1_res = @$original_material->IMG1_URL;
        }

        if ($img2['error'] != 4 && $img2['tmp_name'] !== '') {
            $img2_res = image_upload($img2["tmp_name"], $img2["name"], $img2["type"], $img2["size"], $path_ori, $path_sml);
        } elseif($img2['tmp_name'] === '') {
            $img2_res = @$original_material->IMG2_URL;
        }

        if ($img3['error'] != 4 && $img3['tmp_name'] !== '') {
            $img3_res = file_uploads($img3["tmp_name"], $img3["name"], $img3["type"], $img3["size"], $path_file);
        } elseif($img3['tmp_name'] === '') {
            $img3_res = @$original_material->IMG3_URL;
        }

        $array_data = array(
            'MATERIAL' => (!empty($_POST['material']) ? $_POST['material'] : ""),
            'SEARCH_TEXT' => (!empty($_POST['search_text']) ? $_POST['search_text'] : ""),
            'MATERIAL_NAME'=> (!empty($_POST['m_name']) ? $_POST['m_name'] : ""),
            'MATERIAL_CODE' => (!empty($_POST['semic_no']) ? $_POST['semic_no'] : ""),
            'SEMIC_MAIN_GROUP' => (!empty($_POST['semic_group']) ? $_POST['semic_group'] : ""),
            "SHORTDESC" => (!empty($_POST['m_short_desc']) ? $_POST['m_short_desc'] : ""),
            "DESCRIPTION" => (!empty($_POST['m_desc']) ? $_POST['m_desc']:""),
            "UOM" => (!empty($_POST['m_uom']) ? $_POST['m_uom'] : ""),
            'DESCRIPTION1'=> (!empty($_POST['m_desc']) ? $_POST['m_desc']:""),
            'UOM1'=> (!empty($_POST['m_uom']) ? $_POST['m_uom'] : ""),
            "IMG1_URL" => $img1_res,
            "IMG2_URL" => $img2_res,
            "FILE_URL" => $img3_res,
            'IMG3_URL'=> $img1_res,
            'IMG4_URL'=> $img2_res,
            'FILE_URL2'=> $img3_res,
            'EQPMENT_NO'=> (!empty($_POST['equipment_no'])?$_POST['equipment_no']:""),
            'EQPMENT_ID'=> (!empty($_POST['equipment_id'])?$_POST['equipment_id']:""),
            'MANUFACTURER'=> (!empty($_POST['no_manufacturer'])?$_POST['no_manufacturer']:""),
            'MANUFACTURER_DESCRIPTION'=> (!empty($_POST['name_manufacturer'])?$_POST['name_manufacturer']:""),
            'MATERIAL_TYPE'=> (!empty($_POST['model_type_no'])?$_POST['model_type_no']:""),
            'MATERIAL_TYPE_DESCRIPTION'=> (!empty($_POST['model_type_name'])?$_POST['model_type_name']:""),
            // 'SEQUENCE_ID'=> (!empty($_POST['sequence_id'])?$_POST['sequence_id']:""),
            // 'SEQUENCE_GROUP'=> (!empty($_POST['squence_group_no'])?$_POST['squence_group_no']:""),
            // 'SEQUENCE_GROUP_DESCRIPTION'=> (!empty($_POST['squence_group_name'])?$_POST['squence_group_name']:""),
            // 'INDICATOR'=> (!empty($_POST['material_indicator']) ? $_POST['material_indicator'] : ""),
            // 'INDICATOR_DESCRIPTION'=> (!empty($_POST['material_indicator_desc']) ? $_POST['material_indicator_desc'] : ""),
            'STOCK_CLASS'=> (!empty($_POST['stock_class']) ? $_POST['stock_class'] : ""),
            'AVAILABILITY'=> (!empty($_POST['available']) ? $_POST['available'] : ""),
            'CRITICALITY'=> (!empty($_POST['critical']) ? $_POST['critical'] : ""),
            'PART_NO'=> (!empty($_POST['part_no'])?$_POST['part_no']:""),
            'CREATE_BY'=> $this->session->userdata['ID_USER'],
            'CREATE_TIME'=> date("Y-m-d H:i:s"),
            // 'EDIT_CONTENT'=> (!empty($_POST['edit_content']) ? $_POST['edit_content'] : ""),
            'COLLUQUIALS' => (!empty($_POST['colluquials']) ? $_POST['colluquials'] : ""),
            'TYPE' => (!empty($_POST['m_type']) ? $_POST['m_type'] : "0"),
            'SERIAL_NUMBER' => (!empty($_POST['serial_number']) ? $_POST['serial_number'] : "0"),
            'GL_CLASS' => (!empty($_POST['gl_class']) ? $_POST['gl_class'] : "0"),
            'LINE_TYPE' => (!empty($_POST['line_type']) ? $_POST['line_type'] : "0"),
            'STOCKING_TYPE' => (!empty($_POST['stocking_type']) ? $_POST['stocking_type'] : "0"),
            'STOCK_CLASS2' => (!empty($_POST['stock_class2']) ? $_POST['stock_class2'] : "0"),
            'PROJECT_PHASE' => (!empty($_POST['project_phase']) ? $_POST['project_phase'] : "0"),
            'INVENTORY_TYPE' => (!empty($_POST['inventory_type']) ? $_POST['inventory_type'] : "0"),
            'MONTHLY_USAGE' => (!empty($_POST['monthly_usage']) ? $_POST['monthly_usage'] : "0"),
            'ANNUAL_USAGE' => (!empty($_POST['annual_usage']) ? $_POST['annual_usage'] : "0"),
            'INITIAL_ORDER_QTY' => (!empty($_POST['initial_order_qty']) ? $_POST['initial_order_qty'] : "0"),
            'EXPL_ELEMENT' => (!empty($_POST['expl_element']) ? $_POST['expl_element'] : ""),
            'UNIT_OF_ISSUE' => (!empty($_POST['unit_of_issue']) ? $_POST['unit_of_issue'] : ""),
            'ESTIMATE_VALUE' => (!empty($_POST['estimate_value']) ? $_POST['estimate_value'] : "0"),
            'SHELF_LIFE' => (!empty($_POST['shelf_life']) ? $_POST['shelf_life'] : ""),
            'CROSS_RERERENCE' => (!empty($_POST['cross_rererence']) ? $_POST['cross_rererence'] : "0"),
            'HAZARDOUS' => (!empty($_POST['hazardous']) ? $_POST['hazardous'] : "0"),
            'LEAD_TIME' => (!empty($_POST['lead_time']) ? $_POST['lead_time'] : "0"),
            'UNIT_PRICE' => (!empty($_POST['unit_price']) ? $_POST['unit_price'] : "0"),
            'MIN' => (!empty($_POST['min']) ? $_POST['min'] : "0"),
            'GROUP_CLASS' => (!empty($_POST['group_class']) ? $_POST['group_class'] : ""),
            'INSPECTION_CODE' => (!empty($_POST['inspection_code']) ? $_POST['inspection_code'] : ""),
            'FREIGHT_CODE' => (!empty($_POST['freight_code']) ? $_POST['freight_code'] : ""),
            'FPA' => (!empty($_POST['fpa']) ? $_POST['fpa'] : ""),
            'SUPPLIER_NUMBER' => (!empty($_POST['supplier_number']) ? $_POST['supplier_number'] : ""),
            'STD_PACK' => (!empty($_POST['std_pack']) ? $_POST['std_pack'] : ""),
            'TARIFF_CODE' => (!empty($_POST['tariff_code']) ? $_POST['tariff_code'] : ""),
            'CONV_FACT' => (!empty($_POST['conv_fact']) ? $_POST['conv_fact'] : ""),
        );

        if (!empty($_POST['id'])) {
            $material = $_POST['material_id'];
            $result = $this->M_material_revision->update_cond(array('id' => $_POST['id']), $array_data);
        } else {
            $result = $this->M_material_revision->add($array_data);
            if ($result !== false) {
                $material = $result;
                $result = $this->M_material_revision->add_approval($material, $_SESSION['ID_USER']);
            }
        }

        $this->session->set_flashdata('message', array(
            'message' => __('success_submit'),
            'type' => 'success'
        ));

        // $result = $this->M_material_registration->save_material_requestor($simpan_data);

        if ($result !== false) {
            $dest = $this->M_material_revision->get_email_dest($material);
            if ($dest !== false) {
                $rec = $dest[0]['recipients'];
                $rec_role = $dest[0]['rec_role'];
                $user = $this->M_material_revision->get_email_rec($rec, $rec_role);
                $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
                $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";
                $str = '
                    Nama Material : '.$_POST['m_name'].'<br>
                    UOM : '.$_POST['m_uom'].'<br>
                    Deskripsi : '.$_POST['m_desc'].'<br>
                    Create By : '.$_SESSION['NAME'].'<br>
                ';
                $data = array(
                    'dest' => $user,
                    'img1' => $img1,
                    'img2' => $img2,
                    'title' => $dest[0]['TITLE'],
                    'open' => str_replace("deskripsinya", $str, $dest[0]['OPEN_VALUE']),
                    'close' => $dest[0]['CLOSE_VALUE']
                );
                $email = $this->send_mail($data);
                if ($email == false)
                    $this->output(array('status' => 'Error', 'msg' => 'Oops,Terjadi Kesalahan'));
            }
            $this->output(array("status" => "success", "msg" => "Data berhasil disimpan"));
        } else {
            $this->output(array("status" => "error", "msg" => "Oops,Terjadi Kesalahan"));
        }
    }

    public function inquiry()
    {
        $docs = $this->M_material_revision->all();
        // $this->template->display('material/V_revision_material_inquiry');
    }

    public function datatable_registrasi_material() {
      $data = $this->M_material_revision->datatable_registrasi_m();
      $result = array();
      $no = 1;

      foreach ($data as $arr) {

        if (strpos($arr['description'], "DATA DITOLAK") === FALSE) {
          $str = "";
          $disabled = "";
          $class = 'success';
        } else {
          $disabled = "disabled";
          $class = 'danger';
          $str = '<button onclick="update('.$arr['material_id'].')" class="btn btn-warning btn-sm" title="Update">Edit</button> <button type="button" class="btn btn-danger btn-sm" data-id="'.$arr['material_id'].'" id="delete" title="Delete">Delete</button>';
        }

        $result[] = array(
          0 => $no,
          1 => $arr['request_no'],
          2 => $arr['material_name'],
          3 => (strcmp($arr['spec_uom'], '') == 0 ? $arr['user_uom'] : $arr['spec_uom']),
          4 => $arr['role'],
          5 => $arr['description'],
          6 => $str,
        );
        $no++;
      }

      echo json_encode($result);
    }

    public function delete_material(){
      $idnya = $this->input->post('idnya');
      $this->M_material_registration->delete_material($idnya);

      echo json_encode($idnya);
    }

    public function get_tapproval_material(){
      $data = $this->M_material_registration->datatable_registrasi_m();
      echo json_encode($data);
    }

    public function check_semic(){
      $semic_id = $this->input->post('semic_id');
      $data = $this->M_material_registration->check_semic($semic_id);
      $result = array(
        'data' => $data,
        'count' => count($data),
      );
      echo json_encode($result);
    }

    public function check_semic_group(){
      $parent = $this->input->post('parent');
      $mgroup = $this->input->post('mgroup');
      $data = $this->db->query("select ID FROM m_material_group WHERE PARENT = '".$parent."' AND MATERIAL_GROUP = '".$mgroup."' ");
      $result = array(
        'data' => $data->row(),
        'count' => $data->num_rows(),
      );
      echo json_encode($result);
    }

}
