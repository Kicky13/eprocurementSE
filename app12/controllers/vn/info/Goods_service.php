<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Goods_service extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('vn/info/M_goods_service', 'mgs');
        $this->load->model('vn/info/M_vn', 'mvn');
        $this->load->model('vn/info/M_all_vendor', 'mav');
        $this->load->database();
    }

    public function index() {
        $id = $this->session->ID_VENDOR;
        $cek = $this->mav->cek_session();
        $get_menu = $this->mvn->menu();
        $res = $this->mgs->get_data();
        foreach ($res as $k => $v) {
            $data[$v->TYPE][] = [
                "MATERIAL_GROUP" => $v->MATERIAL_GROUP.'. '.$v->DESCRIPTION,
                "ID" => $v->ID,
            ];
        }
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['DESKRIPSI_IND'] = $v->DESCRIPTION_IND;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['DESKRIPSI_ENG'] = $v->DESCRIPTION_ENG;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['ICON'] = $v->ICON;
        }
        $data['menu'] = $dt;
        $this->template->display_vendor('vn/info/V_goods_service', $data);
    }

    /* ===========================================-------- API START------- ====================================== */

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    /* ================================================    Cek Data    ========================================= */

    public function check_response($res,$ext) {
        if ($res == false)
            $this->output(array('msg' => "Upload file failed", 'status' => 'Error'));
        else if ($res == "failed")
            $this->output(array('msg' => "Only ".$ext." format allowed", 'status' => 'Error'));
        else if ($res == "size")
            $this->output(array('msg' => "Maximum file 2MB", 'status' => 'Error'));
    }

    /* ================================================    Add Data     ======================================== */

    public function add_service() {
        $id = $this->session->ID;
        $data = array(
            'GROUP' => $this->input->post('grup_jasa')[0],
            'SUB_GROUP' => $this->input->post('subgrup_jasa')[0],
            'NAME' => stripslashes($this->input->post('nama_jasa')),
            'CERT_NO' => stripslashes($this->input->post('nomor_cert')),
            'DESCRIPTION' => stripslashes($this->input->post('deskripsi')),
            'TYPE' => "SERVICE",
            'ID_VENDOR' => $id,
            'STATUS' => "1"
        );
        $res = false;
        if ($this->input->post('KEY') == "0")
            $res = $this->mgs->add_service($data);
        else {
            $data['KEY'] = $this->input->post('KEY');
            $res = $this->mgs->update_service($data);
        }
        if ($res != false)
            $this->output($res);
        else
            $this->output(false);
    }

    public function add_consul() {
        $id = $this->session->ID;
        $data = array(
            'GROUP' => $this->input->post('grup_consul')[0],
            'SUB_GROUP' => $this->input->post('subgrup_consul')[0],
            'NAME' => stripslashes($this->input->post('nama_consul')),
            'CERT_NO' => stripslashes($this->input->post('nomor_consul')),
            'DESCRIPTION' => stripslashes($this->input->post('deskripsi_consul')),
            'TYPE' => "CONSULTATION",
            'ID_VENDOR' => $id,
            'STATUS' => "1"
        );
        $res = false;
        if ($this->input->post('KEY') == "0")
            $res = $this->mgs->add_consul($data);
        else {
            $data['KEY'] = $this->input->post('KEY');
            $res = $this->mgs->update_consul($data);
        }
        if ($res != false)
            $this->output($res);
        else
            $this->output(false);
    }

    public function add_goods_pilih() {
        $id = $this->session->ID;
        $data = array(
            'GROUP' => stripslashes($this->input->post('group_goods')),
            'SUB_GROUP' => stripslashes($this->input->post('sub_group_goods')[0]),
            'NAME' => stripslashes($this->input->post('pilih')),
            'DESCRIPTION' => "PILIH",
            'TYPE' => "GOODS",
            'ID_VENDOR' => $id,
            'STATUS' => "1"
        );
        if ($this->input->post('keys') == "0")
            $res = $this->mgs->add_goods_pilih($data);
        else {
            $data['KEY'] = $this->input->post('keys');
            $res = $this->mgs->update_goods_pilih($data);
        }
        if ($res != false)
            $this->output(true);
        else
            $this->output(false);
    }

    public function add_goods() {
        $res = true;
        $flag = 0;
        $key = 0;
        if (isset($_POST['update_keys1']))
            $key = $_POST['update_keys1'];

        if ($key == 0 || ($key != 0 && $_FILES['goods_file']['name'] != '')) {
            $res = $this->uploads($this->session->ID, "upload/GOODS", "goods_file", "FILE_URL", ".pdf",".jpg",".png");
            $this->check_response($res,"jpg,jpeg,png,pdf");
            $flag = 1;
        }

        $data = array
            (
            'ID_VENDOR' => $this->session->ID,
            'GROUP' => stripslashes($_POST['goods_group']),
            'SUB_GROUP' => stripslashes($_POST['goods_sub_group']),
            'NAME' => stripslashes($_POST['goods_name']),
            'MERK' => stripslashes($_POST['goods_merk']),
            'AGEN_STATUS' => strtoupper(stripslashes($_POST['goods_status'])),
            'CERT_NO' => stripslashes($_POST['number_cert']),
            'TYPE' => "GOODS",
            'STATUS' => "1"
        );

        if ($key == 0) {
            $dt_cek = array("GOODS_NAME" => strtoupper(stripslashes($_POST['goods_name'])));
            $cek = $this->mgs->check_data($dt_cek);
            if ($cek == false) {
                $data = array_merge($data, $res);
                $data['CREATE_BY'] = $this->session->ID;
                $data['DESCRIPTION'] = "TAMBAH";
                $res = $this->mgs->add_goods($data);
            } else {
                if ($flag == 1)
                    $this->remove_doc("upload/GOODS/",$res['FILE_URL']);
                $this->output(array("msg" => "Nama Barang sudah ada", "status" => "failed"));
            }
        }
        else {
            $data['KEY'] = $key;
            $data['UPDATE_BY'] = $this->session->ID;
            $data['UPDATE_TIME'] = date('Y-m-d H:i:s');
            if ($flag == 1) {
                $data = array_merge($data, $res);
                $cek = $this->mgs->get_doc($this->session->ID, $key, 'FILE_URL', 'm_vendor_goods_service');
                if ($cek != false)
                    $this->remove_doc("upload/GOODS/", $cek[0]->FILE_URL);
            }
            $res = $this->mgs->update_goods($data);
        }
        if ($res == false)
            $this->output(array("msg" => "Oops, Terjadi Kesalahan", "status" => "failed"));
        else
            $this->output(array("msg" => "Data sudah tersimpan", "status" => "success"));
    }

    public function add_cert() {
        $flag = 0;
        $open= date("Y-m-d", strtotime(stripslashes($this->input->post('valid_since'))));
        $close= date("Y-m-d", strtotime(stripslashes($this->input->post('valid_until'))));
        $chk=$this->mav->check_date($open,$close);
        if($chk['status'] == "Error")
            $this->output($chk);

        $id = $this->session->ID_VENDOR;
        if ($_POST["KEY"] == 0 || ($_POST["KEY"] != 0 && $_FILES['file_sert']['name'] != '')) {
            $res = $this->uploads($this->session->ID, "upload/CERTIFICATION", "file_sert", "FILE_URL", ".pdf");
            $this->check_response($res,"pdf");
            $flag = 1;
        }
        $data = array(
            'ID_VENDOR' => $this->session->ID,
            'NO_DOC' => stripslashes($this->input->post('no_doc')),
            'ISSUED_BY' => stripslashes($this->input->post('issued_by')),
            'CREATE_BY' => $this->session->ID,
            'VALID_SINCE' => $open,
            'VALID_UNTIL' => $close,
            'DESCRIPTION' => stripslashes($this->input->post('kualifikasi')),
            'STATUS' => "1"
        );
        $result = false;
        if ($_POST["KEY"] == 0) {
            $data = array_merge($data, $res);
            $result = $this->mgs->add_cert($data);
        } else {
            $data['KEY'] = stripslashes($this->input->post('KEY'));
            $data['UPDATE_BY'] = $id;
            if ($flag == 1) {
                $data = array_merge($data, $res);
                $cek = $this->mgs->get_doc($id, $_POST['KEY'], 'FILE_URL', 'm_vendor_certification');
                if ($cek != false)
                    $this->remove_doc("upload/CERTIFICATION/", $cek[0]->FILE_URL);
            }
            $result = $this->mgs->update_cert($data);
        }
        $this->output(true);
    }

    public function uploads($id, $Destination, $data_file, $db_name, $ext,$ext2=null,$ext3=null) {
        $NewImageName = '';
        $data = $_FILES;
        $ret = array();
        $counter = 0;
        $fl=0;
        foreach ($data as $k => $v) {
            $ImageExt = strtolower(substr($v['name'], strrpos($v['name'], '.')));
            if ($ImageExt != $ext) {
                if($ext2 != null && $ImageExt != $ext2)
                {
                    if($ext3 != null && $ImageExt != $ext3)
                        $fl=1;
                }
                if($fl==1)
                    return "failed";
            }
            if ($_FILES[$k]['size'] > 2000000)
                return "size";
            if ($k == $data_file) {
                $NewImageName = $id . '_' . Date("Ymd_His") . $ImageExt;
                $ret[$db_name] = $NewImageName;
            }
            if (move_uploaded_file($_FILES[$k]['tmp_name'], "$Destination/$NewImageName"))
                $counter++;
        }
        if ($counter == 1)
            return $ret;
        else
            return false;
    }

    /* ================================================    Get Data     ======================================== */
    public function get_sub()
    {
        if($this->input->post('API'))
        {
            $type=stripslashes($this->input->post('TYPE'));
            $id=stripslashes($this->input->post('ID'));
            $res=$this->mgs->get_group($id);
            $sub=$this->mgs->get_sub($type,$res[0]->MATERIAL_GROUP);
            foreach ($sub as $k => $v) {
                echo '<option value=' . $v->ID . '>' .$v->MATERIAL_GROUP.'. '.$v->DESCRIPTION . '</option>';
            }
            exit;
        }
        else
            $this->output(array("msg"=>"Oops,something wrong","status"=>"false"));
    }

    public function get_cert() {
        $data = $this->mgs->get_cert($this->session->ID);
        if ($data == null)
            $this->output();
        $dt = array();
        $base = base_url();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = $v->ISSUED_BY;
            $dt[$k][2] = $v->NO_DOC;
            $dt[$k][3] = date("d-m-Y", strtotime($v->VALID_SINCE));
            $dt[$k][4] = date("d-m-Y", strtotime($v->VALID_UNTIL));
            $dt[$k][5] = $v->DESCRIPTION;
            $dt[$k][6] = "<button class='btn btn-success btn-sm' onclick=review_file('" . $base . 'upload/CERTIFICATION/' . $v->FILE_URL . "')><i class='fa fa-file-o'></i></button>";
            $dt[$k][7] = '<button class="btn btn-sm btn-primary update"id=' . $v->KEY . '><span class="fa fa-edit"></span></button>'
                    . '&nbsp<button class="btn btn-danger btn-sm delete" onclick=delete_cert(' . $v->ID . ')><span class="fa fa-trash-o">'
                    . '</span></button>';
        }
        $this->output($dt);
    }

    public function get_goods() {
        // $group = $this->mgs->get_all_group("GOODS");
        $data = $this->mgs->get_goods($this->session->ID_VENDOR);

        $dt = array();

        if ($data == false || $data == null)
            $this->output();

        // $grp=$this->convert_group($group,"CLASIFICATION");
        // $sub=$this->convert_group($group,"GROUP");


        $base = base_url();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = $v->GROUP;
            $dt[$k][2] = $v->SUB_GROUP;
            $dt[$k][3] = $v->NAME;
            $dt[$k][4] = $v->MERK;
            $dt[$k][5] = $v->CERT_NO;
            $dt[$k][6] = $v->AGEN_STATUS;
            if($v->DESCRIPTION == "PILIH")
                $dt[$k][7] = "";
            else
                $dt[$k][7] = "<button class='btn btn-sm btn-success' onclick=review_file('" . $base . 'upload/GOODS/' . $v->FILE_URL . "')><i class='fa fa-file-o'></i></button>";
            $dt[$k][8] = '<button class="btn btn-sm btn-primary update-goods" value="' . $v->DESCRIPTION . '" id=' . $v->KEY . '><span class="fa fa-edit"></span></button>'
                    . '&nbsp<button class="btn btn-danger btn-sm delete" onclick=delete_goods(' . $v->KEY . ')><span class="fa fa-trash-o">'
                    . '</span></button>';
        }
        $this->output($dt);
    }
    public function conv_data()
    {

        $data=array(
          "TYPE"=>  stripslashes($this->input->post('TYPE')),
          "DATA"=>  stripslashes($this->input->post('DATA'))
        );
        if($this->input->post('GROUP')=='GROUP')
            $data['CATEGORY']='CLASIFICATION';
        else
            $data['CATEGORY']='GROUP';
        $res=$this->mgs->conv_data($data);
        $this->output($res);
    }

    public function convert_group($grp,$cat)
    {
        $stat=array();
        foreach ($grp as $k => $v)
        {
            if(strpos($v->CATEGORY,$cat) !== false)
             $stat[$v->ID]=$v->DESCRIPTION;
        }
        return $stat;
    }

    public function get_service() {
        $group = $this->mgs->get_all_group("SERVICE");
        $data = $this->mgs->get_service($this->session->ID);

        if ($data == false || $data == null)
            $this->output();
        if ($group != null){
            $grp=$this->convert_group($group,"CLASIFICATION");
            $sub=$this->convert_group($group,"GROUP");
            //echopre($grp);

            $dt = array();
            foreach ($data as $k => $v) {
              //echopre($v);
                $dt[$k][0] = $k + 1;
                $dt[$k][1] = $grp[$v->GROUP];
                $dt[$k][2] = $sub[$v->SUB_GROUP];
                $dt[$k][3] = $v->NAME;
                $dt[$k][4] = $v->DESCRIPTION;
                $dt[$k][5] = $v->CERT_NO;
                $dt[$k][6] = '<button class="btn btn-sm btn-primary update"id=' . $v->KEY . '><span class="fa fa-edit"></span></button>'
                        . '&nbsp<button class="btn btn-danger btn-sm delete" onclick=delete_service(' . $v->KEY . ',"' . $v->ID_VENDOR . '")><span class="fa fa-trash-o">'
                        . '</span></button>';
            }
            $this->output($dt);
        }
        else {
            $dt = array();
            foreach ($data as $k => $v) {
                $dt[$k][0] = $k + 1;
                $dt[$k][1] = $v->GROUP;
                $dt[$k][2] = $v->SUB_GROUP;
                $dt[$k][3] = $v->NAME;
                $dt[$k][4] = $v->DESCRIPTION;
                $dt[$k][5] = $v->CERT_NO;
                $dt[$k][6] = '<button class="btn btn-sm btn-primary update"id=' . $v->KEY . '><span class="fa fa-edit"></span></button>'
                        . '&nbsp<button class="btn btn-danger btn-sm delete" onclick=delete_service(' . $v->KEY . ',"' . $v->ID_VENDOR . '")><span class="fa fa-trash-o">'
                        . '</span></button>';
            }
            $this->output($dt);
        }
    }

    public function get_consul($idx = null) {
      if ($idx == null) {
        $sup_id = $this->session->ID;
      } else {
        // $qq = $this->db->query("SELECT ID_VENDOR from m_vendor WHERE ID = '".$idx."'");
        $sup_id = $idx;
      }
        $group = $this->mgs->get_all_group("CONSULTATION");
        $data = $this->mgs->get_consul($sup_id);
        if ($data == false || $data == null){
            $this->output();
        }
        //echopre($group);
        if($group != null){
            $grp=$this->convert_group($group,"CLASIFICATION");
            $sub=$this->convert_group($group,"GROUP");
            $dt = array();
            foreach ($data as $k => $v) {
              //echopre($v);

                $dt[$k][0] = $k + 1;
                $dt[$k][1] = @$grp[$v->GROUP];
                $dt[$k][2] = @$sub[$v->SUB_GROUP];
                $dt[$k][3] = $v->NAME;
                $dt[$k][4] = $v->DESCRIPTION;
                $dt[$k][5] = $v->CERT_NO;
                $dt[$k][6] = '<button class="btn btn-sm btn-primary update"id=' . $v->KEY . '><span class="fa fa-edit"></span></button>'
                        . '&nbsp<button class="btn btn-danger btn-sm delete" onclick=delete_service(' . $v->KEY . ',"' . $v->ID_VENDOR . '")><span class="fa fa-trash-o">'
                        . '</span></button>';
            }
            $this->output($dt);
        } else {
            $dt = array();
            foreach ($data as $k => $v) {
                $dt[$k][0] = $k + 1;
                $dt[$k][1] = $v->GROUP;
                $dt[$k][2] = $v->SUB_GROUP;
                $dt[$k][3] = $v->NAME;
                $dt[$k][4] = $v->DESCRIPTION;
                $dt[$k][5] = $v->CERT_NO;
                $dt[$k][6] = '<button class="btn btn-sm btn-primary update"id=' . $v->KEY . '><span class="fa fa-edit"></span></button>'
                        . '&nbsp<button class="btn btn-danger btn-sm delete" onclick=delete_service(' . $v->KEY . ',"' . $v->ID_VENDOR . '")><span class="fa fa-trash-o">'
                        . '</span></button>';
            }
            $this->output($dt);
        }

    }

    public function delete_cert() {
        if ($_POST["API"] == "delete") {
            $id = $this->session->ID;
            $cek = $this->mgs->get_doc($_POST['ID'], null, 'FILE_URL', 'm_vendor_certification');

            $res = $this->mgs->delete_cert($_POST['ID'], $id);
            if ($res == true) {
                $this->output(true);
            } else {
                $this->output(false);
            }
        }
        $this->output(false);
    }

    /* ================================================    Delete Data     ======================================== */

    public function remove_doc($dest, $data) {
        $count = 0;
        unlink($dest . $data);
    }

    public function delete_service() {
        if ($_POST["API"] == "delete") {
            $this->mgs->delete_service($_POST['KEY'], $_POST['ID_VENDOR']);
            $this->output(true);
        }
        $this->output(false);
    }

    public function delete_goods() {
        if ($_POST["API"] == "delete") {
            $this->mgs->delete_goods($_POST['KEY']);
            $this->output(true);
        }
        $this->output(false);
    }

    public function get_produk() {
        $data = array(
            "group" => $this->input->post('sub')
        );
        $res = $this->mgs->get_produk($data);
        if ($res != false) {
            for ($i = 0; $i < count($res); $i++) {
                echo'
        <div class="col-xl-3 col-md-6 col-sm-12">
              <div class="card">
                <div class="card-content">
                  <div class="card-body">
                    <div class="i-checks text-center">
                        <div class="i-checks">
                            <label><input type="checkbox" value="'.$res[$i]->MATERIAL_NAME.'" id="pilih" name="pilih"></label>
                        </div>
                    </div>
                  </div>
                  <img src='.base_url().'upload/MATERIAL/img/small/small_'.$res[$i]->IMG1_URL.' class="img-fluid" alt="Image '.$res[$i]->MATERIAL_NAME.'" style="max-height:88px">
                  <div class="card-body">
                     <a class = "product-name" style="font-size:14px">'.$res[$i]->MATERIAL_NAME.'</a>
                      <small class = "text-muted">'.$res[$i]->DESCRIPTION.'</small>
                    <a class = "card-link primary " onclick = "info()">Info <i class = "fa fa-long-arrow-right"></i> </a>
                  </div>
                </div>
              </div>
            </div>
        ';
            }
        }
        exit;
    }

    public function material_vendor(){
      $data = $this->mgs->material_vendor($this->session->ID_VENDOR);
      $result = array();
      foreach($data as $arr){
        $result['data'] = $arr;
      }
      echo json_encode($result);
    }

    public function material_vendor_by_id(){
      $data = $this->mgs->material_vendor($this->input->get('id_vendor'));
      echo $this->input->get('id_vendor');
      $result = array();
      foreach($data as $arr){
        $result['data'] = $arr;
      }
      echo json_encode($result);
    }

}
