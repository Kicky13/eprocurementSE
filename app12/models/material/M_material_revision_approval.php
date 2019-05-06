<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_material_revision_approval extends CI_Model {

    protected $table = 't_approval_material_revision';

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function getTable() {
        return $this->table;
    }

    public function show($where = null) {
        if ($where != null) {
            $this->db->where($where);
        }
        $data = $this->db->from('m_material')->order_by('CREATE_TIME DESC')->get();
        return $data->result();
    }

    public function m_inventory_type(){
      $q = $this->db->select("*")->from("m_inventory_type")->where("status", "1");
      $result = $this->db->get();
      return $result->result_array();
    }

    public function m_stock_class(){
      $q = $this->db->select("*")->from("m_stock_class")->where("status", "1");
      $result = $this->db->get();
      return $result->result_array();
    }

    public function m_hazardous(){
      $q = $this->db->select("*")->from("m_hazardous")->where("status", "1");
      $result = $this->db->get();
      return $result->result_array();
    }

    public function m_gl_class(){
      $q = $this->db->select("*")->from("m_gl_class")->where("status", "1");
      $result = $this->db->get();
      return $result->result_array();
    }

    public function m_project_phase(){
      $q = $this->db->select("*")->from("m_project_phase")->where("status", "1");
      $result = $this->db->get();
      return $result->result_array();
    }

    public function m_line_type(){
      $q = $this->db->select("*")->from("m_line_type")->where("status", "1");
      $result = $this->db->get();
      return $result->result_array();
    }

    public function m_stocking_type(){
      $q = $this->db->select("*")->from("m_stocking_type")->where("status", "1");
      $result = $this->db->get();
      return $result->result_array();
    }

    public function material_uom(){
      $q = $this->db->select("*")->from("m_material_uom")->where("STATUS", "1");
      $result = $this->db->get();
      return $result->result_array();
    }

    public function get_log($id) {
        $res = $this->db->select('b.NAME, a.CREATE_TIME, a.NOTE')
                        ->from('log_material_revision a')
                        ->join('m_user b', 'b.ID_USER=a.CREATE_BY')
                        ->where('a.DOC_ID', $id)
                        ->get();
        return $res->result_array();
    }

    
  public function save_note($data){
    return $this->db->insert("t_note", $data);
  }

  public function get_note($id){
    $this->load->model('material/M_material_revision'); 

    $module_kode = $this->M_material_revision::module_kode;

    return $this->db->from('t_note a')
        ->join('m_user b', 'b.ID_USER = a.created_by')
        ->where('module_kode', $module_kode)
        ->where('a.data_id', $id)
        ->get();

    // return $this->db->query("SELECT * FROM t_note a JOIN m_user b ON b.ID_USER=a.created_by WHERE a.data_id = '".$id."'");
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

    public function material_indicator(){
      $query = $this->db
              ->select('*')
              ->from('m_material_indicator');
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

    public function get_list() {
        $query = $this->db->query("
            SELECT b.id, b.id_user, b.user_roles, b.doc_id, m.REQUEST_NO as request_no, r.description as role, m.UOM as user_uom, m.UOM1 as spec_uom,
                CASE
                    WHEN count(j.id) > 0 THEN CONCAT(b.description,' (DATA DITOLAK)')
                    ELSE b.description
                END as description,
                CASE
                    WHEN length(m.MATERIAL_NAME) > 1 AND m.MATERIAL_NAME IS NOT NULL THEN m.MATERIAL_NAME
                    WHEN length(m.DESCRIPTION1) > 1 AND m.DESCRIPTION1 IS NOT NULL THEN m.DESCRIPTION1
                    ELSE m.DESCRIPTION
                END as material_name
            FROM (
                SELECT doc_id, min(sequence) as sequence
                FROM t_approval_material_revision
                WHERE (status_approve = 0 OR status_approve = 2) AND extra_case = 0
                GROUP BY doc_id
            ) a
            JOIN t_approval_material_revision b ON b.doc_id = a.doc_id AND b.sequence = a.sequence AND b.sequence<>1
            JOIN t_material_revision m ON m.id = b.doc_id AND COALESCE(m.status,99) <> 0
            JOIN m_user_roles r ON r.ID_USER_ROLES = b.user_roles
            LEFT JOIN t_approval_material_revision j ON j.doc_id = b.doc_id AND j.status_approve = 2
            WHERE (b.id_user = '".$this->session->userdata['ID_USER']."') OR (b.user_roles IN (".substr($this->session->userdata['ROLES'], 1, -1).") AND b.id_user = '%')
            GROUP BY b.id, b.id_user, b.user_roles, b.doc_id, request_no, role, m.UOM, m.UOM1, b.description, m.MATERIAL_NAME, m.DESCRIPTION1, m.DESCRIPTION");

        return $query->result_array();
    }

    public function datatable_logistic_specialist($where = null) {
        if ($where != null) {
            $strwhere = "(status_approve = 1 OR status_approve = 0) AND id = ".$where;
            $strwhere2 = "1=1";
        } else {
            $strwhere = "(status_approve = 0 OR status_approve = 2)";
            $strwhere2 = "(b.user_roles in (".substr($this->session->userdata['ROLES'], 1, -1).") AND '".$this->session->userdata['ID_USER']."' = b.id_user) OR (b.user_roles in (".substr($this->session->userdata['ROLES'], 1, -1).") AND b.id_user = '%')";
        }
        // $query = $this->db->query("
        //   SELECT v.REQUEST_NO as request_no, r.description as jabatan, a.id, a.material_id, b.user_roles, b.edit_content, b.email_approve, b.email_reject, b.sequence, b.status_approve, b.reject_step,
        //       CASE
        //           WHEN count(j.id) > 0 THEN CONCAT(b.description,' (DATA DITOLAK)')
        //           ELSE b.description
        //       END as description,
        //       CASE
        //           WHEN length(v.MATERIAL_NAME) > 1 AND v.MATERIAL_NAME IS NOT NULL THEN v.MATERIAL_NAME
        //           WHEN length(v.DESCRIPTION1) > 1 THEN v.DESCRIPTION1
        //           ELSE v.DESCRIPTION
        //       END as material_name
        //   FROM (
        //       SELECT min(id) as id,material_id,min(sequence) as sequence
        //       FROM t_approval_material
        //       WHERE ".$strwhere."
        //       GROUP BY material_id
        //   ) a
        //   JOIN t_approval_material b on b.material_id=a.material_id and b.id=a.id
        //   JOIN m_material v on v.MATERIAL=b.material_id and COALESCE(v.status,99)<>0
        //   JOIN m_user_roles r on r.ID_USER_ROLES=b.user_roles
        //   LEFT JOIN t_approval_material j on j.material_id=b.material_id and j.status_approve=2
        //   WHERE ".$strwhere2."
        //   GROUP BY request_no, r.description, a.id, a.material_id, b.user_roles, b.edit_content, b.email_approve, b.email_reject, b.sequence, b.status_approve, b.reject_step, b.description, v.MATERIAL_NAME, v.DESCRIPTION1, v.DESCRIPTION");
        $query = $this->db->query("SELECT * FROM t_approval_material_revision WHERE id='".$where."'");
        return $query->result_array();
        // echopre($this->db->last_query());
    }


    public function material_equipment_group($id) {
        $query = $this->db->select('*')
                          ->from('m_material_group')
                          ->where(array('STATUS' => '1', 'TYPE' => 'GOODS', 'PARENT' => $id, 'DESCRIPTION != ' => ''))
                          ->order_by('(MATERIAL_GROUP * 1) ASC');
        $result = $this->db->get();
        return $result->result_array();
    }

    public function material_semic_main_group($id) {
        $query = $this->db->select('*')
                          ->from('m_material_group')
                          ->where(array('STATUS' => '1', 'TYPE' => 'GOODS', 'ID' => $id, 'DESCRIPTION != ' => ''))
                          ->order_by('(MATERIAL_GROUP * 1) ASC');
        $result = $this->db->get();
        return $result->result_array();
    }


    public function material_classification_group($id){
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


    public function get_data_requestor($id){
      // $query = $this->db
      //         ->select('*')
      //         ->from('m_material A')
      //         ->join('m_status_material B', 'COALESCE(A.STATUS,1) = B.STATUS')
      //         ->join('m_user u', 'u.ID_USER = A.CREATE_BY')
      //         ->join('m_departement d', 'd.ID_DEPARTMENT = u.ID_DEPARTMENT')
      //         ->where('A.MATERIAL', $id)
      //         ->order_by('A.MATERIAL DESC');
      $query = $this->db
              ->select('*')
              ->from('t_material_revision')
              ->where('id', $id)
              ->order_by('material DESC');
      $result = $this->db->get();
      // $this->db->last_query();
      return $result->result_array();
    }

    public function get_cur_seq($id) {
        $res = $this->db->query("
                SELECT id_user, user_roles, edit_content, b.sequence
                FROM (
                    SELECT min(sequence) as sequence, doc_id
                    FROM t_approval_material_revision
                    WHERE doc_id = '".$id."' AND status_approve = 0
                    GROUP BY  doc_id
                ) a
                JOIN t_approval_material_revision b ON b.doc_id = a.doc_id AND b.sequence = a.sequence
            ");
        return $res->result_array();
    }

    public function get_cur_seq_list($id) {
        $res = $this->db->query("
                SELECT id_user, user_roles, edit_content, b.sequence
                FROM (
                    SELECT min(sequence) as sequence, doc_id
                    FROM t_approval_material_revision
                    WHERE doc_id = '".$id."' AND status_approve = 1
                    GROUP BY doc_id
                ) a
                JOIN t_approval_material_revision b ON b.doc_id = a.doc_id AND b.sequence = a.sequence
            ");
        return $res->result_array();
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

    public function update_material($cond, $data) {
        $state = $this->db->where($cond)->update('m_material', $data);
        if ($state !== false) {
            $log = "CATALOUG NUMBER REQUEST UPDATED BY ".$_SESSION['NAME'];
            $ins_id = $cond['MATERIAL'];
            $data_log = array(
                'DOC_ID' => $ins_id,
                'STATUS' => '1',
                'NOTE' => $log,
                "CREATE_BY" => $_SESSION['ID_USER'],
                "CREATE_TIME" => date("Y-m-d H:i:s"),
            );
            $this->db->insert("log_material_revision", $data_log);
        }
        return $state;
    }

    public function save_registrasi_catalog($data) {
/*
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
            'NOTE' => 'CATALOG NUMBER REQUEST APPROVED BY '.$this->session->userdata['NAME'],
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
 */
    }


    public function save_registrasi_cataloguing($data, $idmat, $fedit, $seq) {
        // handel ganti edit content 0/1
        if ($fedit == '1') {
            $this->db->where("id", $idmat);
            $this->db->update("t_material_revision", $data);

            if ($data['MATERIAL_CODE'] != "") {
                $update_code = array(
                  'MATERIAL_CODE' => $data['MATERIAL_CODE'],
                );
                $this->db->where("id", $idmat);
                $this->db->update("t_material_revision", $update_code);
            }
        }

        $data_squence = array(
            'updatedate' => date("Y-m-d H:i:s"),
            'status_approve' => '1',
            'note' => 'Approved',
            'approve_by' => $this->session->userdata('ID_USER')
        );

        $status_reject = array(
            'status_approve' => '0',
        );

        $this->db->where("doc_id", $idmat);
        $this->db->where("status_approve", "2");
        $this->db->update("t_approval_material_revision", $status_reject);

        $this->db->where("doc_id", $idmat);
        $this->db->where("sequence", $seq);
        $this->db->update("t_approval_material_revision", $data_squence);

        $data_res2 = array(
            'DOC_ID' => $idmat,
            'STATUS' => '2',
            'NOTE' => 'CATALOG NUMBER REVISION REQUEST APPROVED BY '.$this->session->userdata['NAME'],
            "CREATE_BY" => $this->session->userdata('ID_USER'),
            "CREATE_TIME" => date("Y-m-d H:i:s"),
        );
        $q2 = $this->db->insert("log_material_revision", $data_res2);

        return true;
    }

    public function reject_request_material($data){
      $data_res2 = array(
        'ID_MATERIAL' => $data['idnya'],
        'STATUS' => '11',
        'NOTE' => $data['note'],
        "CREATE_BY" => $data['user'],
        "CREATE_TIME" => date("Y-m-d H:i:s"),
      );

      $sequence_status = $data['sequence_id_rej'] - $data['reject_step_rej'];

      $upd_status_reject = array(
        'status_approve' => '2',
        'note' => 'Rejected - '.$data['note'],
        'approve_by' => $this->session->userdata('ID_USER')
      );

      $upd_status_0 = array(
        'status_approve' => '0',
      );

      $this->db->where("sequence >=", $sequence_status);
      $this->db->where("doc_id", $data['idnya']);
      $this->db->update("t_approval_material_revision", $upd_status_0);

      $this->db->where("id", $data['m_approval_id']);
      $this->db->update("t_approval_material_revision", $upd_status_reject);

      $data_res2 = array(
        'DOC_ID' => $data['idnya'],
        'NOTE' => 'CATALOG NUMBER REVISION REQUEST REJECTED BY '.$this->session->userdata['NAME'],
        "CREATE_BY" => $data['user'],
        "CREATE_TIME" => date("Y-m-d H:i:s"),
      );

      $this->db->insert("log_material_revision", $data_res2);
    }

    // approve
    public function approve_request_material($data){
      $query = $this->db->query("SELECT COUNT(1)+1 as total FROM m_material WHERE STATUS = '4'");
      $data_res2 = array(
        'DOC_ID' => $data['idnya'],
        'NOTE' => 'CATALOG NUMBER REVISION REQUEST APPROVED BY '.$this->session->userdata['NAME'],
        "CREATE_BY" => $data['user'],
        "CREATE_TIME" => date("Y-m-d H:i:s"),
      );

      $update = array(
        'MATERIAL_CODE' => $data['kodematerial'],
        'STATUS' => '4',
      );

      $this->db->insert("log_material_material", $data_res2);

      $this->db->where("MATERIAL", $data['idnya']);
      $this->db->update("m_material", $update);
    }

    public function approve_request_catalog($data){
      $data_res2 = array(
        'DOC_ID' => $data['idnya'],
        'STATUS' => '3',
        'NOTE' => 'CATALOG NUMBER REQUEST APPROVED BY '.$this->session->userdata['NAME'],
        "CREATE_BY" => $data['user'],
        "CREATE_TIME" => date("Y-m-d H:i:s"),
      );

      // $update = array(
      //   'STATUS' => '3',
      // );

      $this->db->insert("log_material_revision", $data_res2);

      $this->db->where("MATERIAL", $data['idnya']);
      // $this->db->update("m_material", $update);
    }
    // .--approve--. //

    // rollback t_approval_material & m_material
    public function rollback_apprvl($material){
      // $update = array(
      //   'MATERIAL_CODE' => '',
      // );
      $update2 = array(
        'status_approve' => '0',
      );

      // $this->db->where("id", $material);
      // $this->db->update("t_material_revision", $update);

      $sel_apprv = $this->db->query("SELECT MAX(sequence) as sequence, id FROM t_approval_material_revision WHERE doc_id ='".$material."'");
      $this->db->where("doc_id", $material);
      $this->db->where("sequence", $sel_apprv->row()->sequence);
      $this->db->update("t_approval_material_revision", $update2);

      // $this->db->query("UPDATE m_material SET MATERIAL_CODE = '' WHERE MATERIAL = '".$material."'");
      // $this->db->query("UPDATE t_approval_material SET status_approve = '0' WHERE material_id = '".$material."' AND sequence = '".$sel_apprv->row()->sequence."'");
    }

}

?>

