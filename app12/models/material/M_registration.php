<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_registration extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function show($where = null) {
        if ($where != null) {
            $this->db->where($where);
        }
        $data = $this->db->from('m_material')->order_by('CREATE_TIME DESC')->get();
        return $data->result();
    }

    public function add($data) {
        $data = $this->db->insert('m_material', $data);
//        echo $this->db->last_query();exit;
        return $data;
    }

    public function update($id, $data) {
        return $this->db->where('ID', $id)->update('m_material', $data);
    }

    public function data_search($data, $col) {
        $count = 0;
        if (count($data) > 0) {
            foreach ($data as $k => $v) {
                if ($count == 0) {
                    $this->db->like($col, $v);
                    $count++;
                } else
                    $this->db->or_like($col, $v);
            }
        }
    }

    public function filter_data($data) {
        $desc = array();
        $type = array();
        $matr = array();
        $long = array();
        $uom = array();
        $group = array();
        $count = 0;
        $limit = $data['limit'];
        $status = null;
        foreach ($data as $k => $v) {
            if (strpos($k, 'desc') !== false)
                array_push($desc, $v);
            if (strpos($k, 'type') !== false)
                array_push($type, $v);
            if (strpos($k, 'matr') !== false)
                array_push($matr, $v);
            if (strpos($k, 'long') !== false)
                array_push($long, $v);
            if (strpos($k, 'uom') !== false)
                array_push($uom, $v);
            if (strpos($k, 'group') !== false)
                array_push($group, $v);
        }
        $this->db->select("ID,MATERIAL,DESCRIPTION,LONG_DESCRIPTION,MATERIAL_GROUP,MATERIAL_TYPE,MATERIAL_UOM,STATUS")
                ->from("m_material");

        $this->db->group_start();
        $this->data_search($matr, "MATERIAL");
        $this->data_search($desc, "DESCRIPTION");
        $this->data_search($long, "LONG_DESCRIPTION");
        $this->data_search($uom, "MATERIAL_UOM");
        $this->data_search($type, "MATERIAL_TYPE");
        $this->data_search($group, "MATERIAL_GROUP");
        $this->db->group_end();

        if ($data['status1'] != "none" && $data['status2'] == "none")
            $this->db->where("STATUS=", 1);
        else if ($data['status2'] != "none" && $data['status1'] == "none")
            $this->db->where("STATUS=", 0);

        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result();
    }

    public function material_uom(){
      $q = $this->db->select("*")->from("m_material_uom")->where("STATUS", "1");
      $result = $this->db->get();
      return $result->result_array();
    }

    public function save_material_requestor($data){
        if ($data['IMG1_URL'] !== '') {
          $img1 = image_upload(
                 $data["IMG1_URL"]["tmp_name"],
                 $data["IMG1_URL"]["name"],
                 $data["IMG1_URL"]["type"],
                 $data["IMG1_URL"]["size"],
                 "upload/MATERIAL/img/ori/",
                 "upload/MATERIAL/img/small/");
        } else {
          $img1 = "";
        }

        if ($data['IMG2_URL'] !== '') {
          $img2 = image_upload(
                 $data["IMG2_URL"]["tmp_name"],
                 $data["IMG2_URL"]["name"],
                 $data["IMG2_URL"]["type"],
                 $data["IMG2_URL"]["size"],
                 "upload/MATERIAL/img/ori/",
                 "upload/MATERIAL/img/small/");
        } else {
          $img2 = "";
        }


       if ($data['FILE_URL'] !== '') {
         $img3 = file_uploads(
                $data["FILE_URL"]["tmp_name"],
                $data["FILE_URL"]["name"],
                $data["FILE_URL"]["type"],
                $data["FILE_URL"]["size"],
                "upload/MATERIAL/files/");
       } else {
         $img3 = "";
       }


        if ($data["MATERIAL"] !== "") {
          $data_res = array(
            "DESCRIPTION" => $data['DESCRIPTION'],
            "UOM" => $data['UOM'],
            "CREATE_BY" => $data['CREATE_BY'],
            "CREATE_TIME" => $data['CREATE_TIME'],
            "STATUS" => '1',
          );

          if ($img1 !== "") {
            $data_res['IMG1_URL'] = $img1;
          }

          if ($img2 !== "") {
            $data_res['IMG2_URL'] = $img2;
          }

          if ($img3 !== "") {
            $data_res['FILE_URL'] = $img3;
          }

          $this->db->where('MATERIAL', $data["MATERIAL"]);
          $this->db->update('m_material', $data_res);
          $log = "MATERIAL PROPOSED";
        } else {

          $query1 = $this->db->select("ID_DEPARTMENT")->from("m_user")->where("ID_USER", $this->session->userdata['ID_USER'])->get();
          $row1 = $query1->row();
          $query = $this->db->query("SELECT COUNT(1)+1 as total FROM m_material WHERE REQUEST_NO LIKE '%".date("Y")."%'");
          $row2 = $query->row();
          $lenidmax = strlen($row2->total);
        	$increment = str_repeat('0',6-$lenidmax).$row2->total;
          $kode = $row1->ID_DEPARTMENT."/".date("Y")."/".date("m")."/M/".$increment;

          $data_res = array(
            "DESCRIPTION" => $data['DESCRIPTION'],
            "DESCRIPTION1" => $data['DESCRIPTION'],
            "UOM" => $data['UOM'],
            "UOM1" => $data['UOM'],
            "IMG1_URL" => $img1,
            "IMG3_URL" => $img1,
            "IMG2_URL" => $img2,
            "IMG4_URL" => $img2,
            "FILE_URL" => $img3,
            "FILE_URL2" => $img3,
            "CREATE_BY" => $data['CREATE_BY'],
            "CREATE_TIME" => $data['CREATE_TIME'],
            "STATUS" => '1',
            "REQUEST_NO" => $kode,
          );

          $q = $this->db->insert("m_material", $data_res);
          $log = "MATERIAL PROPOSED";
        }


        if ($data['MATERIAL'] !== "") {
          $insertid = $data['MATERIAL'];
        } else {
          $insertid = $this->db->insert_id();
        }

        $data_res2 = array(
          'ID_MATERIAL' => $insertid,
          'STATUS' => '1',
          'NOTE' => $log,
          "CREATE_BY" => $data['CREATE_BY'],
          "CREATE_TIME" => date("Y-m-d H:i:s"),
        );
        $q2 = $this->db->insert("log_material", $data_res2);

        return true;

    }

    public function datatable_regsitrasi_m(){
      $query = $this->db
              ->select('*')
              ->from('m_material A')
              ->join('m_status_material B', 'A.STATUS = B.STATUS')
              ->where('A.STATUS !=', '0')
              ->where('A.STATUS', '1')
              ->order_by('A.MATERIAL DESC');
      $result = $this->db->get();
      return $result->result_array();
    }

    public function datatable_regsitrasi__deleted(){
      $query = $this->db
              ->select('*')
              ->from('m_material A')
              ->join('m_status_material B', 'A.STATUS = B.STATUS')
              ->where('A.STATUS', '0')
              ->or_where('A.STATUS', '11')
              ->order_by('A.MATERIAL DESC');
      $result = $this->db->get();
      return $result->result_array();
    }

    public function datatable_logistic_specialist(){
      $query = $this->db
              ->select('*')
              ->from('m_material A')
              ->join('m_status_material B', 'A.STATUS = B.STATUS')
              ->where('A.STATUS !=', '0')
              ->where('A.STATUS', '1')
              ->or_where('A.STATUS', '12')
              ->order_by('A.MATERIAL DESC');
      $result = $this->db->get();
      return $result->result_array();
    }

    public function get_data_requestor($id){
      $query = $this->db
              ->select('*')
              ->from('m_material A')
              ->join('m_status_material B', 'A.STATUS = B.STATUS')
              ->join('m_user u', 'u.ID_USER = A.CREATE_BY')
              ->join('m_departement d', 'd.ID_DEPARTMENT = u.ID_DEPARTMENT')
              ->where('A.MATERIAL', $id)
              ->order_by('A.MATERIAL DESC');
      $result = $this->db->get();
      $this->db->last_query();
      return $result->result_array();
    }


    public function material_indicator(){
      $query = $this->db
              ->select('*')
              ->from('m_material_indicator');
      $result = $this->db->get();
      return $result->result_array();
    }

    public function material_group(){
      $query = $this->db
      ->select('*')
      ->from('m_material_group')
      ->where('STATUS', '1')
      ->where('TYPE', 'GOODS')
      ->where('CATEGORY', 'CLASIFICATION')
      ->order_by('MATERIAL_GROUP ASC');
      $result = $this->db->get();
      return $result->result_array();
    }

    public function material_equipment_group($id){
      $query = $this->db
      ->select('*')
      ->from('m_material_group')
      ->where('STATUS', '1')
      ->where('TYPE', 'GOODS')
      ->where('PARENT', $id)
      ->order_by('MATERIAL_GROUP ASC');
      $result = $this->db->get();
      return $result->result_array();
    }

    public function material_clasification_group($id){
      $query = $this->db
      ->select('*')
      ->from('m_material_group')
      ->where('STATUS', '1')
      ->where('TYPE', 'GOODS')
      ->where('ID', $id)
      ->order_by('MATERIAL_GROUP ASC');
      $result = $this->db->get();
      return $result->result_array();
    }

    public function material_group_manufacturer($id){
      $query = $this->db
      ->select('MANUFACTURER, MANUFACTURER_DESCRIPTION')
      ->from('m_material')
      ->where('STATUS', '1')
      ->like('MANUFACTURER', $id)
      ->order_by('MANUFACTURER ASC');
      $result = $this->db->get();
      return $result->result_array();
    }

    public function material_group_modeltype($id){
      $query = $this->db
      ->select('MATERIAL_TYPE, MATERIAL_TYPE_DESCRIPTION')
      ->from('m_material')
      ->where('STATUS', '1')
      ->like('MATERIAL_TYPE', $id)
      ->order_by('MATERIAL_TYPE ASC');
      $result = $this->db->get();
      return $result->result_array();
    }

    public function material_sequence($id){
      $query = $this->db
      ->select('SEQUENCE_GROUP, SEQUENCE_GROUP_DESCRIPTION')
      ->from('m_material')
      ->where('STATUS', '1')
      ->like('SEQUENCE_GROUP', $id)
      ->order_by('MATERIAL_TYPE ASC');
      $result = $this->db->get();
      return $result->result_array();
    }

    public function m_material_stock_class(){
      $query = $this->db
      ->select('*')
      ->from('m_material_stock_class')
      ->order_by('ID ASC');
      $result = $this->db->get();
      return $result->result_array();
    }

    public function m_material_availability(){
      $query = $this->db
      ->select('*')
      ->from('m_material_availability')
      ->order_by('ID ASC');
      $result = $this->db->get();
      return $result->result_array();
    }

    public function m_material_cricatility(){
      $query = $this->db
      ->select('*')
      ->from('m_material_cricatility')
      ->order_by('ID ASC');
      $result = $this->db->get();
      return $result->result_array();
    }

    public function save_registrasi_catalog($data){

        if ($data['IMG3_URL']['name'] !== '' AND $data['IMG4_URL']['name'] !== '' ) {
          $img1 = image_upload(
                 $data["IMG3_URL"]["tmp_name"],
                 $data["IMG3_URL"]["name"],
                 $data["IMG3_URL"]["type"],
                 $data["IMG3_URL"]["size"],
                 "upload/MATERIAL/img/ori/",
                 "upload/MATERIAL/img/small/");
          $img2 = image_upload(
                 $data["IMG4_URL"]["tmp_name"],
                 $data["IMG4_URL"]["name"],
                 $data["IMG4_URL"]["type"],
                 $data["IMG4_URL"]["size"],
                 "upload/MATERIAL/img/ori/",
                 "upload/MATERIAL/img/small/");
         if ($data['FILE_URL2'] !== '') {
         $img3 = file_uploads(
                $data["FILE_URL2"]["tmp_name"],
                $data["FILE_URL2"]["name"],
                $data["FILE_URL2"]["type"],
                $data["FILE_URL2"]["size"],
                "upload/MATERIAL/files/");
         } else {
           $img3 = "-";
         }
         $data_res = array(
           'MATERIAL_NAME'=> $data['MATERIAL_NAME'],
           'DESCRIPTION1'=> $data['DESCRIPTION1'],
           'IMG3_URL'=> $img1,
           'IMG4_URL'=> $img2,
           'FILE_URL2'=> $img3,
           'UOM1'=> $data['UOM1'],
           'EQPMENT_NO' => $data['EQPMENT_NO'],
           'EQPMENT_ID' => $data['EQPMENT_ID'],
           'MANUFACTURER'=> $data['MANUFACTURER'],
           'MANUFACTURER_DESCRIPTION'=> $data['MANUFACTURER_DESCRIPTION'],
           'MATERIAL_TYPE'=> $data['MATERIAL_TYPE'],
           'MATERIAL_TYPE_DESCRIPTION'=> $data['MATERIAL_TYPE_DESCRIPTION'],
           'SEQUENCE_GROUP'=> $data['SEQUENCE_GROUP'],
           'SEQUENCE_GROUP_DESCRIPTION'=> $data['SEQUENCE_GROUP_DESCRIPTION'],
           'INDICATOR'=> $data['INDICATOR'],
           'INDICATOR_DESCRIPTION'=> $data['INDICATOR_DESCRIPTION'],
           'STOCK_CLASS'=> $data['STOCK_CLASS'],
           'AVAILABILITY'=> $data['AVAILABILITY'],
           'CRITICALITY'=> $data['CRITICALITY'],
           'PART_NO'=> $data['PART_NO'],
           'STATUS'=> $data['STATUS'],
           'CREATE_BY'=> $data['CREATE_BY'],
           'CREATE_TIME'=>$data['CREATE_TIME'],
         );

          $idx = $data['MATERIAL'];
          $this->db->where("MATERIAL", $idx);
          $this->db->update("m_material", $data_res);

          $data_res2 = array(
            'ID_MATERIAL' => $idx,
            'STATUS' => '2',
            'NOTE' => $data['DESCRIPTION1'],
            "CREATE_BY" => $data['CREATE_BY'],
            "CREATE_TIME" => date("Y-m-d H:i:s"),
          );
          $q2 = $this->db->insert("log_material", $data_res2);

          return true;
        } else {
          unset($data["IMG1_URL"]);
          unset($data["IMG2_URL"]);
          unset($data["FILE_URL"]);
          return false;
        }
    }

    public function save_registrasi_catalog_ditolak($data){
      $data_res = array(
        'MATERIAL_NAME'=> $data['MATERIAL_NAME'],
        'DESCRIPTION1'=> $data['DESCRIPTION1'],
        'UOM1'=> $data['UOM1'],
        'EQPMENT_NO' => $data['EQPMENT_NO'],
        'EQPMENT_ID' => $data['EQPMENT_ID'],
        'MANUFACTURER'=> $data['MANUFACTURER'],
        'MANUFACTURER_DESCRIPTION'=> $data['MANUFACTURER_DESCRIPTION'],
        'MATERIAL_TYPE'=> $data['MATERIAL_TYPE'],
        'MATERIAL_TYPE_DESCRIPTION'=> $data['MATERIAL_TYPE_DESCRIPTION'],
        'SEQUENCE_GROUP'=> $data['SEQUENCE_GROUP'],
        'SEQUENCE_GROUP_DESCRIPTION'=> $data['SEQUENCE_GROUP_DESCRIPTION'],
        'INDICATOR'=> $data['INDICATOR'],
        'INDICATOR_DESCRIPTION'=> $data['INDICATOR_DESCRIPTION'],
        'STOCK_CLASS'=> $data['STOCK_CLASS'],
        'AVAILABILITY'=> $data['AVAILABILITY'],
        'CRITICALITY'=> $data['CRITICALITY'],
        'PART_NO'=> $data['PART_NO'],
        'STATUS'=> $data['STATUS'],
        'CREATE_BY'=> $data['CREATE_BY'],
        'CREATE_TIME'=>$data['CREATE_TIME'],
      );

        if ($data['IMG3_URL'] !== '') {
          $img1 = image_upload(
                 $data["IMG3_URL"]["tmp_name"],
                 $data["IMG3_URL"]["name"],
                 $data["IMG3_URL"]["type"],
                 $data["IMG3_URL"]["size"],
                 "upload/MATERIAL/img/ori/",
                 "upload/MATERIAL/img/small/");
          $data_res['IMG3_URL'] = $img1;
         } elseif ($data['IMG4_URL'] !== '') {
           $img2 = image_upload(
                  $data["IMG4_URL"]["tmp_name"],
                  $data["IMG4_URL"]["name"],
                  $data["IMG4_URL"]["type"],
                  $data["IMG4_URL"]["size"],
                  "upload/MATERIAL/img/ori/",
                  "upload/MATERIAL/img/small/");
          $data_res['IMG4_URL'] = $img2;
         }
         if ($data['FILE_URL2'] !== '') {
         $img3 = file_uploads(
                $data["FILE_URL2"]["tmp_name"],
                $data["FILE_URL2"]["name"],
                $data["FILE_URL2"]["type"],
                $data["FILE_URL2"]["size"],
                "upload/MATERIAL/files/");
        $data_res['FILE_URL2'] = $img3;
         } else {
           $img3 = "-";
         }

          $idx = $data['MATERIAL'];
          $this->db->where("MATERIAL", $idx);
          $this->db->update("m_material", $data_res);

          $data_res2 = array(
            'ID_MATERIAL' => $idx,
            'STATUS' => '2',
            'NOTE' => $data['DESCRIPTION1'],
            "CREATE_BY" => $data['CREATE_BY'],
            "CREATE_TIME" => date("Y-m-d H:i:s"),
          );
          $q2 = $this->db->insert("log_material", $data_res2);

          return true;

    }

    public function datatable_persetujuan_katalog(){
      $query = $this->db
              ->select('*')
              ->from('m_material A')
              ->join('m_status_material B', 'A.STATUS = B.STATUS')
              ->where('A.STATUS !=', '0')
              ->where('A.STATUS', '2')
              ->order_by('A.MATERIAL DESC');
      $result = $this->db->get();
      return $result->result_array();
    }

    public function reject_request_material($data){
      $data_res2 = array(
        'ID_MATERIAL' => $data['idnya'],
        'STATUS' => '11',
        'NOTE' => $data['note'],
        "CREATE_BY" => $data['user'],
        "CREATE_TIME" => date("Y-m-d H:i:s"),
      );

      $update = array(
        'STATUS' => '11',
      );

      $this->db->insert("log_material", $data_res2);

      $this->db->where("MATERIAL", $data['idnya']);
      $this->db->update("m_material", $update);

      $log = "Registration Rejected";
      $data_insertlog = array(
        'ID_MATERIAL' => $data['idnya'],
        'STATUS' => '11',
        'NOTE' => $log,
        "CREATE_BY" => $this->session->userdata['ID_USER'],
        "CREATE_TIME" => date("Y-m-d H:i:s"),
      );

      $q2 = $this->db->insert("log_material", $data_insertlog);
    }

    public function get_data_requestor_user($id){
      $query = $this->db
              ->select('u.NAME,dp.DEPARTMENT_DESC,A.*, B.*, C.ID as EQP_ID, C.MATERIAL_GROUP, C.DESCRIPTION as EQPMENT_DESC, C.TYPE, C.CATEGORY, D.ID as INDI_ID, D.DESCRIPTION_ENG as INDI_DESC')
              ->from('m_material A')
              ->join('m_status_material B', 'A.STATUS = B.STATUS')
              ->join('m_material_group C', 'C.ID = A.EQPMENT_ID')
              ->join('m_material_indicator D', 'D.ID = A.INDICATOR')
              ->join('m_user u', 'u.ID_USER = A.CREATE_BY')
              ->join('m_departement dp', 'dp.ID_DEPARTMENT = u.ID_DEPARTMENT')
              ->where('A.MATERIAL', $id)
              ->where('A.STATUS !=', '0')
              ->order_by('A.MATERIAL DESC');
      $result = $this->db->get();
      return $result->result_array();
    }

    public function reject_request_catalog($data){
      $data_res2 = array(
        'ID_MATERIAL' => $data['idnya'],
        'STATUS' => '12',
        'NOTE' => $data['note'],
        "CREATE_BY" => $data['user'],
        "CREATE_TIME" => date("Y-m-d H:i:s"),
      );

      $update = array(
        'STATUS' => '12',
      );

      $this->db->insert("log_material", $data_res2);

      $this->db->where("MATERIAL", $data['idnya']);
      $this->db->update("m_material", $update);

      $log = "Cataloging Rejected";
      $data_insertlog = array(
        'ID_MATERIAL' => $data['idnya'],
        'STATUS' => '12',
        'NOTE' => $log,
        "CREATE_BY" => $this->session->userdata['ID_USER'],
        "CREATE_TIME" => date("Y-m-d H:i:s"),
      );

      $q2 = $this->db->insert("log_material", $data_insertlog);
    }

    public function approve_request_catalog($data){
      $data_res2 = array(
        'ID_MATERIAL' => $data['idnya'],
        'STATUS' => '3',
        'NOTE' => $data['note'],
        "CREATE_BY" => $data['user'],
        "CREATE_TIME" => date("Y-m-d H:i:s"),
      );

      $update = array(
        'STATUS' => '3',
      );

      $this->db->insert("log_material", $data_res2);

      $this->db->where("MATERIAL", $data['idnya']);
      $this->db->update("m_material", $update);

      $log = "Cataloging Approved";
      $data_insertlog = array(
        'ID_MATERIAL' => $data['idnya'],
        'STATUS' => '3',
        'NOTE' => $log,
        "CREATE_BY" => $this->session->userdata['ID_USER'],
        "CREATE_TIME" => date("Y-m-d H:i:s"),
      );

      $q2 = $this->db->insert("log_material", $data_insertlog);
    }

    public function datatable_persetujuan_material(){
      $query = $this->db
              ->select('*')
              ->from('m_material A')
              ->join('m_status_material B', 'A.STATUS = B.STATUS')
              ->where('A.STATUS !=', '0')
              ->where('A.STATUS', '3')
              ->order_by('A.MATERIAL DESC');
      $result = $this->db->get();
      return $result->result_array();
    }

    public function approve_request_material($data){
      $query = $this->db->query("SELECT COUNT(1)+1 as total FROM m_material WHERE STATUS = '4'");
      $data_res2 = array(
        'ID_MATERIAL' => $data['idnya'],
        'STATUS' => '4',
        'NOTE' => $data['note'],
        "CREATE_BY" => $data['user'],
        "CREATE_TIME" => date("Y-m-d H:i:s"),
      );

      $update = array(
        'MATERIAL_CODE' => $data['kodematerial'],
        'STATUS' => '4',
      );

      $this->db->insert("log_material", $data_res2);

      $this->db->where("MATERIAL", $data['idnya']);
      $this->db->update("m_material", $update);
    }

    public function material_code($id){
      $query = $this->db
              ->select('MATERIAL, EQPMENT_ID, MANUFACTURER, MATERIAL_TYPE, SEQUENCE_GROUP, INDICATOR')
              ->from('m_material')
              ->where('MATERIAL', $id);
      $result = $this->db->get();
      return $result->result_array();
    }

    public function select_max_material(){
      // $this->db->select('*')->from('m_material')->where("STATUS", "4");
      $query = $this->db->query("SELECT COUNT(1)+1 as total FROM m_material WHERE STATUS = '4'");
      // $result = $this->db->get();
      // return $result->num_rows();
      return $query->row();
    }

    public function get_email_dest($id) {
        $qry=$this->db->select("TITLE,OPEN_VALUE,CLOSE_VALUE,CATEGORY,ROLES")
                ->from("m_notic")
                ->where("ID=",$id)
                ->get();
        if ($qry->num_rows() != 0)
            return $qry->result();
        else
            return false;
    }

    public function get_user($dt,$cnt=0) {
        $this->db->select("EMAIL")
                ->from("m_user ")
                ->group_start();
        if ($cnt != 0) {
            foreach ($dt as $k => $v) {
                if ($k == 0)
                    $this->db->like("ROLES", ',' . $v . ',');
                else
                    $this->db->or_like("ROLES", ',' . $v . ',');
            }
        } else
            $this->db->like("ROLES", $dt);
        $qry = $this->db->group_end()
                ->where("STATUS=", "1")
                ->get();
        if ($qry->num_rows() != 0)
            return $qry->result();
        else
            return false;
    }

    public function delete_material($id){
      $data = array(
        'STATUS' => 0
      );
      $this->db->where('MATERIAL', $id);
      $this->db->update('m_material', $data);

      $data_res2 = array(
        'ID_MATERIAL' => $id,
        'STATUS' => '0',
        'NOTE' => 'MATERIAL DELETED',
        "CREATE_BY" => $this->session->userdata['ID_USER'],
        "CREATE_TIME" => date("Y-m-d H:i:s"),
      );

      $this->db->insert("log_material", $data_res2);
    }

    public function restore_material($id){
      $data = array(
        'STATUS' => 1
      );
      $this->db->where('MATERIAL', $id);
      $this->db->update('m_material', $data);

      $data_res2 = array(
        'ID_MATERIAL' => $id,
        'STATUS' => '1',
        'NOTE' => 'MATERIAL RESTORED',
        "CREATE_BY" => $this->session->userdata['ID_USER'],
        "CREATE_TIME" => date("Y-m-d H:i:s"),
      );

      $this->db->insert("log_material", $data_res2);
    }

    public function show_history($idnya){
      $query_mat = $this->db->query("SELECT * FROM m_material a JOIN m_status_material b ON b.STATUS=a.STATUS JOIN m_user c ON c.ID_USER=a.CREATE_BY WHERE a.MATERIAL = '".$idnya."'");
      $data_mat = array();
      foreach ($query_mat->result_array() as $key => $value) {
        $query_log = $this->db->query("SELECT * FROM log_material WHERE ID_MATERIAL = '".$idnya."'");
        $data_mat = array(
          'material' => $value,
          'log_material' => $query_log->result_array()
        );
      }
      return $data_mat;
    }
}

?>
