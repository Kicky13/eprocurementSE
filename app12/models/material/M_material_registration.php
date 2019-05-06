<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_material_registration extends CI_Model {

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
        $query1 = $this->db->select("ID_DEPARTMENT")->from("m_user")->where("ID_USER", $this->session->userdata['ID_USER'])->get();
        $row1 = $query1->row();
        $query = $this->db->query("SELECT COUNT(1)+1 as total FROM m_material WHERE REQUEST_NO LIKE '%".date("Y")."%'");
        $row2 = $query->row();
        $lenidmax = strlen($row2->total);
        $increment = str_repeat('0',6-$lenidmax).$row2->total;
        $data['REQUEST_NO'] = $row1->ID_DEPARTMENT."/".date("Y")."/".date("m")."/M/".$increment;

        $state = $this->db->insert('m_material', $data);
        if ($state == false) {
            return $state;
        } else {
            $log = "CATALOUG NUMBER REQUEST PROPOSED BY ".$_SESSION['NAME'];
            $ins_id = $this->db->insert_id();
            $data_log = array(
                'ID_MATERIAL' => $ins_id,
                'STATUS' => '1',
                'NOTE' => $log,
                "CREATE_BY" => $_SESSION['ID_USER'],
                "CREATE_TIME" => date("Y-m-d H:i:s"),
            );
            $this->db->insert("log_material", $data_log);
            return $ins_id;
        }
    }

    public function add_approval($mat, $user) {
        $parent = $this->db->select('parent_id')->from('t_jabatan')->where('user_id', $user)->get()->result_array();
        if ($parent == false || strcmp($parent[0]['parent_id'], '') == 0)
            $parent = 0;
        else
            $parent = $parent[0]['parent_id'];

        if ($parent == 0) {
            $parent = $user;
        } else {
            $parent = $this->db->select('user_id')->from('t_jabatan')->where('id', $parent)->get()->result_array();
            if ($parent == false || strcmp($parent[0]['user_id'], '') == 0)
                $parent = 0;
            else
                $parent = $parent[0]['user_id'];
        }

        $res = $this->db->query("
            INSERT INTO t_approval_material (
                SELECT NULL as id, $mat as material_id,
                (CASE
                    WHEN user_roles = 41 THEN $user
                    WHEN user_roles = 18 THEN $parent
                    ELSE '%'
                END) as id_user, user_roles, sequence,
                (CASE
                    WHEN user_roles = 41 THEN 1
                    ELSE 0
                END) as status_approve, description, reject_step, email_approve, email_reject, edit_content, extra_case,
                CASE WHEN user_roles = 41 THEN 'CREATED' ELSE NULL END as note,
                CASE WHEN user_roles = 41 THEN '".$this->session->userdata('ID_USER')."' ELSE NULL END as approve_by,
                now() as updatedate, now() as createdate
                FROM m_approval_rule
                WHERE module = 4
                ORDER BY sequence
            )");
        return $res;
    }

    public function update($id, $data) {
        return $this->db->where('ID', $id)->update('m_material', $data);
    }

    public function update_cond($cond, $data) {
        $state = $this->db->where($cond)->update('m_material', $data);
        $this->db->query("update t_approval_material SET status_approve='0' WHERE material_id = '".$cond['MATERIAL']."' AND sequence = '2' ");
        $this->db->query("update t_approval_material SET status_approve='1' WHERE material_id = '".$cond['MATERIAL']."' AND sequence = '1' ");
        if ($state !== false) {
            $log = "CATALOUG NUMBER REQUEST UPDATED BY ".$_SESSION['NAME'];
            $ins_id = $cond['MATERIAL'];
            $data_log = array(
                'ID_MATERIAL' => $ins_id,
                'STATUS' => '1',
                'NOTE' => $log,
                "CREATE_BY" => $_SESSION['ID_USER'],
                "CREATE_TIME" => date("Y-m-d H:i:s"),
            );
            $this->db->insert("log_material", $data_log);
        }
        return $state;
    }

    public function get_email_dest($material) {
        $qry = $this->db->query(
            "SELECT b.id_user as recipients, b.user_roles as rec_role, b.reject_step, b.email_approve, b.email_reject, n.OPEN_VALUE, n.CLOSE_VALUE, n.TITLE
            FROM (
                SELECT material_id, min(sequence) as sequence
                FROM t_approval_material
                WHERE material_id = " . $material . " AND status_approve = 0 AND extra_case = 0
                GROUP BY material_id
            ) a
            JOIN t_approval_material b ON b.sequence = a.sequence AND b.material_id = a.material_id
            JOIN m_notic n ON n.ID = b.email_approve");
        return $qry->result_array();
    }

    public function get_email_rec($rec, $role) {
        if ($rec == '%') {
            $qry = $this->db->select('email')
                            ->from('m_user')
                            ->where('status', '1')
                            ->like('ROLES', ',' . $role . ',')
                            ->get();
        } else {
            $qry = $this->db->select('email')
                            ->from('m_user')
                            ->where('status = 1')
                            ->where('ID_USER', $rec)
                            ->get();
        }
        if ($qry->num_rows() != 0)
            return $qry->result();
        else
            return false;
    }

    public function material_uom(){
      $q = $this->db->select("*")->from("m_material_uom")->where("STATUS", "1");
      $result = $this->db->get();
      return $result->result_array();
    }

    public function datatable_registrasi_m() {
      $split = explode(",", substr($this->session->userdata['ROLES'], 1, -1));

      if (in_array('15', $split)) {
        $where = "1=1";
      } else {
        $where = "m.CREATE_BY = '".$this->session->userdata['ID_USER']."' ";
      }
        $query = $this->db->query("
            SELECT b.id, b.id_user, b.user_roles, b.material_id, m.REQUEST_NO as request_no, r.description as role, m.UOM as user_uom, m.UOM1 as spec_uom,
                CASE
                    WHEN COUNT(j.id) > 0 THEN CONCAT(b.description, ' (DATA DITOLAK)')
                    ELSE b.description
                    END as description,
                CASE
                    WHEN CHAR_LENGTH(m.MATERIAL_NAME) > 1 AND m.MATERIAL_NAME IS NOT NULL THEN m.MATERIAL_NAME
                    WHEN CHAR_LENGTH(m.DESCRIPTION1) > 1 AND m.DESCRIPTION1 IS NOT NULL THEN m.DESCRIPTION1
                    ELSE m.DESCRIPTION
                END as material_name
            FROM (
                SELECT material_id, MIN(sequence) as sequence
                FROM t_approval_material
                WHERE (status_approve = 0 OR status_approve = 2) AND extra_case = 0
                GROUP BY material_id
            ) a
            JOIN t_approval_material b ON b.material_id = a.material_id AND b.sequence = a.sequence
            JOIN m_material m ON m.MATERIAL = b.material_id AND COALESCE(m.status, 99) <> 0
            JOIN m_user_roles r ON r.ID_USER_ROLES = b.user_roles
            LEFT JOIN t_approval_material j ON j.material_id = b.material_id AND j.status_approve = 2
            WHERE ".$where."
            GROUP BY b.id, b.id_user, b.user_roles, b.material_id, request_no, role, m.UOM, m.UOM1, b.description, m.MATERIAL_NAME, m.DESCRIPTION1, m.DESCRIPTION");
        return $query->result_array();
        // return echopre($this->db->last_query());
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
        'NOTE' => 'MATERIAL DELETED BY '.$this->session->userdata['NAME'],
        "CREATE_BY" => $this->session->userdata['ID_USER'],
        "CREATE_TIME" => date("Y-m-d H:i:s"),
      );

      $this->db->insert("log_material", $data_res2);
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
              ->from('m_material')
              ->where('MATERIAL', $id)
              ->order_by('MATERIAL DESC');
      $result = $this->db->get();
      // $this->db->last_query();
      return $result->result_array();
    }

    public function check_semic($id){
      $query = $this->db
              ->select('*')
              ->from('m_material')
              ->where('MATERIAL_CODE', $id);
      $result = $this->db->get();
      // $this->db->last_query();
      return $result->result_array();
    }

  }
?>
