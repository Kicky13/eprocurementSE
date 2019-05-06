<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_material_revision extends MY_Model
{
    protected $table = 't_material_revision';
    protected $materialTable = 'm_material';

    const module_kode = 'm_rev_mat';
    const module_kode_long = 'm_rev_mat_long';
    const module_kode_cat = 'm_rev_mat_cat';

    public function __construct() {
        parent::__construct();
        $this->load->model('material/M_show_material')
            ->model('material/M_material_revision_approval');
    }

    public function show($where = null) {
        if ($where != null) {
            $this->db->where($where);
        }
        $data = $this->db->from($this->table)->order_by('CREATE_TIME DESC')->get();
        return $data->result();
    }

    public function add($data) {
        $row1 = user();
        $query = $this->db->query("SELECT COUNT(1)+1 as total FROM {$this->table} WHERE REQUEST_NO LIKE '%".date("Y")."%'");
        $row2 = $query->row();
        $lenidmax = strlen($row2->total);
        $increment = str_repeat('0',6-$lenidmax).$row2->total;
        $data['REQUEST_NO'] = $row1->ID_DEPARTMENT."/".date("Y")."/".date("m")."/M/".$increment;

        $state = $this->db->insert($this->table, $data);
        if ($state == false) {
            return $state;
        } else {
            $log = "CATALOGUE REVISION NUMBER REQUEST PROPOSED BY ".$_SESSION['NAME'];
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
            INSERT INTO t_approval_material_revision (
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
                WHERE module = 17
                ORDER BY sequence
            )");
        return $res;
    }

    public function update($id, $data) {
        parent::update($id, $data);
    }

    public function update_cond($cond, $data) {
        $state = $this->db->where($cond)->update($this->table, $data);
        if ($state !== false) {
            $log = "CATALOGUE REVISION NUMBER REQUEST UPDATED BY ".$_SESSION['NAME'];
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
                SELECT doc_id, min(sequence) as sequence
                FROM t_approval_material_revision
                WHERE doc_id = " . $material . " AND status_approve = 0 AND extra_case = 0
                GROUP BY doc_id
            ) a
            JOIN t_approval_material_revision b ON b.sequence = a.sequence AND b.doc_id = a.doc_id
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
            SELECT m.material as material_id, b.id, b.id_user, b.user_roles, b.doc_id, m.REQUEST_NO as request_no, r.description as role, m.UOM as user_uom, m.UOM1 as spec_uom,
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
                SELECT doc_id, MIN(sequence) as sequence
                FROM t_approval_material_revision
                WHERE (status_approve = 0 OR status_approve = 2) AND extra_case = 0
                GROUP BY doc_id
            ) a
            JOIN t_approval_material_revision b ON b.doc_id = a.doc_id AND b.sequence = a.sequence
            JOIN t_material_revision m ON m.id = b.doc_id AND COALESCE(m.status, 99) <> 0
            JOIN m_user_roles r ON r.ID_USER_ROLES = b.user_roles
            LEFT JOIN t_approval_material_revision j ON j.doc_id = b.doc_id AND j.status_approve = 2
            WHERE ".$where."
            GROUP BY b.id, b.id_user, b.user_roles, b.doc_id, request_no, role, m.UOM, m.UOM1, b.description, m.MATERIAL_NAME, m.DESCRIPTION1, m.DESCRIPTION");
        return $query->result_array();
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

    public function mergeToMaster($id)
    {
        $data = (array) $this->find($id);
        $data['update_by'] = @$this->session->userdata('ID_USER');

        $material_data = [
            'MATERIAL' => @$data['material'],
            'MATERIAL_CODE' =>  @$data['material_code'],
            'MATERIAL_NAME' =>  @$data['material_name'],
            'SEARCH_TEXT' =>  @$data['search_text'],
            'DESCRIPTION' =>  @$data['description'],
            'DESCRIPTION1' =>  @$data['description1'],
            'IMG1_URL' =>  @$data['img1_url'],
            'IMG2_URL' =>  @$data['img2_url'],
            'IMG3_URL' =>  @$data['img3_url'],
            'IMG4_URL' =>  @$data['img4_url'],
            'FILE_URL' =>  @$data['file_url'],
            'FILE_URL2' =>  @$data['file_url2'],
            'UOM' =>  @$data['uom'],
            'UOM1' =>  @$data['uom1'],
            'EQPMENT_NO' =>  @$data['eqpment_no'],
            'EQPMENT_ID' =>  @$data['eqpment_id'],
            'MANUFACTURER' =>  @$data['manufacturer'],
            'MANUFACTURER_DESCRIPTION' =>  @$data['manufacturer_description'],
            'MATERIAL_TYPE' =>  @$data['material_type'],
            'MATERIAL_TYPE_DESCRIPTION' =>  @$data['material_type_description'],
            'SEQUENCE_GROUP' =>  @$data['sequence_group'],
            'SEQUENCE_GROUP_DESCRIPTION' =>  @$data['sequence_group_description'],
            'INDICATOR' =>  @$data['indicator'],
            'INDICATOR_DESCRIPTION' =>  @$data['indicator_description'],
            'PART_NO' =>  @$data['part_no'],
            'STOCK_CLASS' =>  @$data['stock_class'],
            'AVAILABILITY' =>  @$data['availability'],
            'CRITICALITY' =>  @$data['criticality'],
            'COLLUQUIALS' =>  @$data['colluquials'],
            'TYPE' =>  @$data['type'],
            'SERIAL_NUMBER' =>  @$data['serial_number'],
            'GL_CLASS' =>  @$data['gl_class'],
            'LINE_TYPE' =>  @$data['line_type'],
            'STOCKING_TYPE' =>  @$data['stocking_type'],
            'STOCK_CLASS2' =>  @$data['stock_class2'],
            'PROJECT_PHASE' =>  @$data['project_phase'],
            'INVENTORY_TYPE' =>  @$data['inventory_type'],
            'MONTHLY_USAGE' =>  @$data['monthly_usage'],
            'ANNUAL_USAGE' =>  @$data['annual_usage'],
            'INITIAL_ORDER_QTY' =>  @$data['initial_order_qty'],
            'EXPL_ELEMENT' =>  @$data['expl_element'],
            'UNIT_OF_ISSUE' =>  @$data['unit_of_issue'],
            'ESTIMATE_VALUE' =>  @$data['estimate_value'],
            'SHELF_LIFE' =>  @$data['shelf_life'],
            'CROSS_RERERENCE' =>  @$data['cross_rererence'],
            'HAZARDOUS' =>  @$data['hazardous'],
            'STATUS' =>  @$data['status'],
            'GROUP_CLASS' =>  @$data['group_class'],
            'INSPECTION_CODE' =>  @$data['inspection_code'],
            'LEAD_TIME' =>  @$data['lead_time'],
            'FREIGHT_CODE' =>  @$data['freight_code'],
            'FPA' =>  @$data['fpa'],
            'UNIT_PRICE' =>  @$data['unit_price'],
            'SUPPLIER_NUMBER' =>  @$data['supplier_number'],
            'STD_PACK' =>  @$data['std_pack'],
            'TARIFF_CODE' =>  @$data['tariff_code'],
            'CONV_FACT' =>  @$data['conv_fact'],
            'ORIGIN_CODE' =>  @$data['origin_code'],
            'UNIT_OF_ISSUE2' =>  @$data['unit_of_issue2'],
            'MIN' =>  @$data['min'],
            'UNIT_OF_PURCHASE' =>  @$data['unit_of_purchase'],
            'ROQ' =>  @$data['roq'],
            'STATISTIC_CODE' =>  @$data['statistic_code'],
            'ROP' =>  @$data['rop'],
            'ITEM_OWNERSHIP' =>  @$data['item_ownership'],
            'STOCK_TYPE' =>  @$data['stock_type'],
            'PART_STATUS' =>  @$data['part_status'],
            'STOCK_CODE_NO' =>  @$data['stock_code_no'],
            'PART_NUMBER' =>  @$data['part_number'],
            'ITEM_NAME' =>  @$data['item_name'],
            'PREFERENCE' =>  @$data['preference'],
            'ITEM_NAME_CODE' =>  @$data['item_name_code'],
            'MNEMONIC' =>  @$data['mnemonic'],
            'SEMIC_MAIN_GROUP' =>  @$data['semic_main_group'],
            'SHORTDESC' =>  @$data['shortdesc'],
            'UPDATE_TIME' => today_sql(),
            'UPDATE_BY' =>  @$data['update_by'],
        ];

        return $this->M_show_material->update($data['material'], $material_data);
    }

    public function merge($id)
    {
        return $this->db->from($this->table)
            ->set('merged_status', 1)
            ->where('id', $id)
            ->update();
    }

    public function getUnEditableMaterial($material = null)
    {
        $m_material_revision_approval = $this->M_material_revision_approval->getTable();

        if ($material) {
            $this->db->where('material', $material);
        }

        return $this->db->distinct()
            ->select("{$this->table}.material")
            ->from($this->table)
            ->join($m_material_revision_approval, "{$m_material_revision_approval}.doc_id = {$this->table}.id")
            ->where("$m_material_revision_approval.status_approve", 0)
            ->where("{$this->table}.merged_status", 0)
            ->get()->result();
    }
  }
?>
