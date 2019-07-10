<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_approval extends CI_Model {
    protected $table = 'm_approval';
    protected $transaction_table = 't_approval';

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
        $this->tbeq = 't_eq_data';
        $this->muser = 'm_user';
        $user = user();
        if (isset($user->ROLES)) {
            $roles = explode(",", $user->ROLES);
        } else {
            $roles = array();
        }
        $this->roles      = array_values(array_filter($roles));
    }
    public function list($moduleKode='', $dataId='')
    {
        $query = "select '1' as _order, m_approval.id approval_id, m_user_roles.DESCRIPTION role_name,
            t_approval.urutan, t_approval.status, t_approval.deskripsi, m_approval.role_id,
            t_approval.id t_approval_id, t_approval.created_at, t_approval.created_by
        from t_approval
        left join m_approval on t_approval.m_approval_id = m_approval.id
        LEFT JOIN m_user_roles on m_approval.role_id = m_user_roles.ID_USER_ROLES
        where t_approval.data_id = '$dataId' and m_approval.module_kode = '$moduleKode'";

        if ($moduleKode == 'msr') {
            $subModuleKode = 'msr_spa';
            /*$query .= " UNION ALL
            SELECT '2' as _order, m_approval_2.id approval_id, m_user_roles_2.DESCRIPTION role_name,
                t_approval_2.urutan, t_approval_2.status, t_approval_2.deskripsi, m_approval_2.role_id,
                t_approval_2.id t_approval_2_id, t_approval_2.created_at, t_approval_2.created_by
            FROM t_approval t_approval_2
            LEFT JOIN m_approval m_approval_2 on t_approval_2.m_approval_id = m_approval_2.id
            LEFT JOIN m_user_roles m_user_roles_2 on m_approval_2.role_id = m_user_roles_2.ID_USER_ROLES
            WHERE t_approval_2.data_id = '$dataId' and m_approval_2.module_kode = '$subModuleKode'
                AND t_approval_2.urutan = 1
                AND t_approval_2.status = 2
            ";*/
        }
        $query .= " ORDER BY _order, urutan asc";
        $rr = $this->db->query($query);
        return $rr;
    }
    public function approve()
    {
    	/*data_id, status, m_approval_id, desc*/
    	$this->db->trans_begin();
        $user = user();
    	$data = $this->input->post();
        $module_kode = $this->input->post('module_kode');

        unset($data['module_kode'],$data['status_str']);
        $this->db->where(['id'=>$data['id']]);
        unset($data['id']);
    	$this->db->update('t_approval', $data);

        $process_award = ['status'=>false];
        if($module_kode == 'award' and $data['status'] == 1)
        {
            $process_award = $this->process_award();
        }
        // print_r($process_award);
        // exit();

        $get = $this->input->get();
        /*when issued*/
        if($this->input->get('issued'))
        {
            unset($get['issued']);
            $get['issued_date'] = date("Y-m-d H:i:s");
            $this->db->where(['msr_no'=> $data['data_id']]);
            $get['bid_bond'] = number_value($get['bid_bond']);

            $this->db->update('t_eq_data',$get);
        }

    	if($this->db->trans_status() === true)
    	{
            @$deskripsi = isset($data['deskripsi']) ? $data['deskripsi'] : '';
    		$this->db->trans_commit();
            $desc = $data['status'] == 1 ? "Approved" : "Rejected";

            $t_approval = $this->db->where(['id'=>$this->input->post('id')])->get('t_approval')->row();
            if($t_approval->m_approval_id == 13 and $data['status'] == 1)
            {
                $desc = "Issued";
            }
            if($this->input->post('module_kode') == 'msr_spa' and $t_approval->m_approval_id  == 7){
                $module_kode = 'msr';
                $desc = $data['status'] == 1 ? "MSR Verified" : "Rejected";
            }
            if($process_award['status'] == 'Issued Award Notification')
            {
                // $desc = 'Issued Award Notification';
                $desc = 'Approved';
            }
            $this->approval_lib->log([
                'module_kode'=> $module_kode,
                'data_id'=>$data['data_id'],
                'description'=> $desc,
                'keterangan'=>$deskripsi,
                'created_by'=>$user->ID_USER
            ]);
    		return true;
    	}
    	else
    	{
    		$this->db->trans_rollback();
            /*echo $this->db->last_query();
            exit();*/
    		return false;
    	}
    }
    public function reject($value='')
    {
    	$data = $this->input->post();
        $moduleKode = $data['module_kode'];
        unset($data['module_kode']);
        $user = user();
    	$this->db->trans_begin();
		$data['status'] = 2;
		unset($data['status_str']);
		//var_dump ($data);exit;
        $q = "select module_kode from m_approval
        left join t_approval on t_approval.m_approval_id = m_approval.id
        where t_approval.id = '$data[id]'";
        $module_kode = $this->db->query($q)->row();
        $q = "select t_approval.id from t_approval
        left join m_approval on t_approval.m_approval_id = m_approval.id
        where data_id = '$data[data_id]' and m_approval.module_kode = '$module_kode->module_kode'
        and t_approval.urutan < (select urutan from t_approval where id = $data[id])";
        $rs = $this->db->query($q);

    	if($rs->num_rows() > 0)
    	{
			$this->db->where(['id'=>$data['id']]);
			$this->db->update('t_approval', $data);
    	}
        else
        {	
            $this->db->where(['id'=>$data['id']]);
            $this->db->update('t_approval', $data);
        }
        /*new*/
    	if($this->db->trans_status() === true)
    	{
    		$this->db->trans_commit();
            $desc = $data['status'] == 1 ? "Approve" : "Reject";
            $this->approval_lib->log([
                'module_kode'=>$this->input->post('module_kode'),
                'data_id'=>$data['data_id'],
                'description'=>$desc,
                'keterangan'=>$data['deskripsi'],
                'created_by'=>$user->ID_USER
            ]);
    		return true;
    	}
    	else
    	{
    		$this->db->trans_rollback();
    		return false;
    	}
    }
    public function check_cost_center($msr_kode='')
    {
        /*msr*/
        $this->db->where(['msr_no'=>$msr_kode]);
        $msr = $this->db->get('t_msr')->row();
        $data['msr'] = $msr;
        /*msr_item*/
        $this->db->where(['msr_no'=>$msr_kode]);
        $msr_item = $this->db->get('t_msr_item')->result();
        $data['msr_item'] = $msr;
        /*get cost center original from createor msr_item*/
        $this->db->where('ID_USER',$msr->create_by);
        $user = $this->db->get('m_user')->row();
        /*departmenid as costcenterid*/
        $id_costcenter = $user->ID_DEPARTMENT;

        /*msr_item_costcenter*/
        $this->db->where(['msr_no'=>$msr_kode]);
        $this->db->where('id_costcenter !=',$id_costcenter);
        $msr_item_costcenter = $this->db->get('t_msr_item');
        $data['msr_item_costcenter'] = $msr_item_costcenter;

        return $data;
    }
    public function get_item_costcenter($id) {
        $res = $this->db->select('id_costcenter, costcenter_desc')
                        ->from('t_msr_item')
                        ->where('line_item', $id)
                        ->get();
        return $res->result_array();
    }
    public function greetings_msr($value='')
    {
        $idUser = $this->session->userdata('ID_USER');
        $cek = $this->db->where(['ID_USER'=>$idUser])->get('m_user')->row();
        $roles = explode(",", $cek->ROLES);
        $data['roles'] = array_values(array_filter($roles));
        $myroles = implode(',', $data['roles']);
        /*msr*/
        $sql = "SELECT a.*,b.jml from
        (SELECT t_approval.*,m_approval.module_kode FROM `t_approval`
        left join m_approval on t_approval.m_approval_id = m_approval.id
        WHERE created_by = $idUser and t_approval.status = 0 and m_approval.module_kode = 'msr') a
        LEFT join
        (SELECT t_approval.data_id, COUNT(t_approval.id) jml
        FROM `t_approval`
        left join m_approval on t_approval.m_approval_id = m_approval.id
        LEFT JOIN (SELECT DISTINCT(t_approval.data_id), min(t_approval.urutan) urutan FROM `t_approval` left join m_approval on t_approval.m_approval_id = m_approval.id WHERE created_by = $idUser and t_approval.status = 0 and m_approval.module_kode = 'msr' GROUP by t_approval.data_id) t on t_approval.data_id = t.data_id
        WHERE t_approval.status = 1 and m_approval.module_kode = 'msr' and t_approval.urutan < t.urutan
        GROUP by t_approval.data_id) b on a.data_id = b.data_id
        WHERE
        case a.urutan
            when 1
            then a.urutan = 1
            else b.jml+1 = a.urutan
        end
        ORDER BY a.data_id DESC";
        if($this->input->get('reject'))
        {
            /*$sql = "SELECT t_approval.data_id
                        FROM t_msr
                        LEFT JOIN `t_approval` on t_msr.msr_no = t_approval.data_id
                        left join m_approval on m_approval.id = t_approval.m_approval_id
                        WHERE t_msr.create_by = $idUser and status = '2' and m_approval.module_kode = 'msr' group by t_approval.data_id";*/
            $sql = "SELECT t_msr.msr_no as data_id
                        FROM t_msr
                        WHERE ".$this->msrActive(1)." and t_msr.create_by = $idUser and msr_no in (select data_id from t_approval WHERE status = 2 and m_approval_id in (1,2,3,4,5,6,7) group by data_id) or msr_no in (select data_id from t_approval WHERE status = 3 and m_approval_id = 8 group by data_id) order by t_msr.msr_no desc";
                        // exit();
            // $sql = "$sql union all $q";
        }
        /*echo $sql;
        exit();*/
        return $this->db->query($sql);
    }
    public function generate_msr_approval($msr_no='')
    {
        $this->db->trans_begin();
        $m_approval = $this->db->where(['module_kode'=>'msr','aktif'=>1])->order_by('urutan','asc')->get('m_approval');
        $i=1;
        $msr = $this->db->where(['msr_no'=>$msr_no])->get('t_msr')->row();
        // $user = user();
        $user = $this->db->where(['ID_USER'=>$msr->create_by])->get('m_user')->row();
        foreach ($m_approval->result() as $r) {
            /*MSR01 MATERIAL = MSR02 SERVICE*/
            if($r->opsi == 'bh' or $r->opsi == 'ic')
            {
                if($r->opsi == 'bh')
                {
                    /*cek ada cost center selain yang dia punya gak*/
                    $msrItems = $this->db->select('id_costcenter')->where(['msr_no'=>$msr->msr_no])->where('id_costcenter !=',$user->COST_CENTER)->group_by('id_costcenter')->get('t_msr_item');
                    /*kalo ada insert untuk approval*/
                    if($msrItems->num_rows() > 0)
                    {
                        /*approval sebanyak yang punya budget holder*/
                        foreach ($msrItems->result() as $msrItem) {
                            // id_costcenter
                            $m_user = $this->db->where(['cost_center'=>$msrItem->id_costcenter])->get('m_budget_holder')->row();
                            // echo $this->db->last_query();
                            // exit();
                            $data['m_approval_id'] = $r->id;
                            $data['data_id'] = $msr->msr_no;
                            $data['created_by'] = $m_user->id_user;
                            // $data['deskripsi'] = 'BH';
                            $data['urutan'] = $i++;
                            $this->db->insert('t_approval', $data);
                        }
                    }

                }
                if($r->opsi == 'ic')
                {
                    $sql = "select * from m_user where ROLES like '%19%'";
                    $a = $this->db->query($sql)->row();
                    $ic = $a->ID_USER;

                    if($msr->id_msr_type == 'MSR01')
                    {
                        $data['m_approval_id'] = $r->id;
                        $data['data_id'] = $msr->msr_no;
                        $data['created_by'] = $ic;
                        // $data['deskripsi'] = 'ic MSR01';
                        $data['urutan'] = $i++;
                        $this->db->insert('t_approval', $data);
                    }
                    elseif($msr->id_msr_type == 'MSR02')
                    {
                        /*cek awalau msr service kalo ada material, maka harus lewat IC*/
                        $msrItems = $this->db->where(['msr_no'=>$msr->msr_no])->where_in('id_itemtype',['GOODS','BLANKET'])->get('t_msr_item');
                        if($msrItems->num_rows() > 0)
                        {
                            $data['m_approval_id'] = $r->id;
                            $data['data_id'] = $msr->msr_no;
                            $data['created_by'] = $ic;
                            // $data['deskripsi'] = 'ic MSR02';
                            $data['urutan'] = $i++;
                            $this->db->insert('t_approval', $data);
                        }
                    }
                }
            }
            else
            {
                if($r->opsi == 'user_manager')
                {
                    /*t_jabatan*/
                    $t_jabatan = $this->db->where(['user_id'=>$msr->create_by])->get('t_jabatan')->row();
                    $s = $this->db->where(['id'=>$t_jabatan->parent_id])->get('t_jabatan')->row();
                    /*cek di m_user*/
                    $msr_company = trim($msr->id_company);
                    $q = "select * from m_user where ID_USER  = $s->user_id and COMPANY like '%$msr_company%'";
                    if($this->db->query($q)->num_rows() > 0)
                    {

                    }
                    else
                    {
                       $s = $this->db->where(['first'=>1])->get('t_jabatan')->row();
                    }
                    /*parent_id/atasannya untuk user yang approve*/
                    $data['m_approval_id'] = $r->id;
                    $data['data_id'] = $msr->msr_no;
                    $data['created_by'] = $s->user_id;
                    $data['urutan'] = $i++;
                    $this->db->insert('t_approval', $data);
                }
                if($r->opsi == 'aas')
                {
                    $total_amount = $msr->total_amount_base;
                    $aas = $this->firstAas($total_amount,$msr->create_by, $msr->id_company);
                    /*First AAS*/
                    $data['m_approval_id'] = $r->id;
                    $data['data_id'] = $msr->msr_no;
                    $data['created_by'] = $aas->user_id;
                    // $data['deskripsi'] = 'AAS1';
                    $data['urutan'] = $i++;
                    $this->db->insert('t_approval', $data);
                    /*if($total_amount <= 5000000)
                    {*/
                        /*Second AAS*/
                        $data['m_approval_id'] = $r->id;
                        $data['data_id'] = $msr->msr_no;
                        // $data['deskripsi'] = 'AAS2';
                        $data['created_by'] = $this->input->get_post('user_id');
                        $data['urutan'] = $i++;
                        $this->db->insert('t_approval', $data);
                    // }
                }
                if($r->opsi == 'bsd_staff')
                {
                    $sql = "select * from m_user where ROLES like '%20%'";
                    $a = $this->db->query($sql)->row();
                    $bsdStaff = $a->ID_USER;

                    $data['m_approval_id'] = $r->id;
                    $data['data_id'] = $msr->msr_no;
                    $data['created_by'] = $bsdStaff;
                    // $data['deskripsi'] = 'bsd staff';
                    $data['urutan'] = $i++;
                    $this->db->insert('t_approval', $data);
                }
                if($r->opsi == 'vip_bsd')
                {
                    $sql = "select * from m_user where ROLES like '%21%'";
                    $a = $this->db->query($sql)->row();
                    $vipBsd = $a->ID_USER;

                    $data['m_approval_id'] = $r->id;
                    $data['data_id'] = $msr->msr_no;
                    $data['created_by'] = $vipBsd;
                    // $data['deskripsi'] = 'vip bsd';
                    $data['urutan'] = $i++;
                    $this->db->insert('t_approval', $data);
                }
            }
        }
        if($this->db->trans_status() === true)
        {
            $this->db->trans_commit();
            return true;
        }
        else
        {
            $this->db->trans_rollback();
            return false;
        }
    }

    public function deleteApproval($module_kode, $data_id)
    {
        $m_approval_id = $this->db->select('id')
            ->where('module_kode', $module_kode)
            ->get($this->table)->result();

        $m_approval_id = array_pluck($m_approval_id, 'id');

        return $this->db->from($this->transaction_table)
            ->where('data_id', $data_id)
            ->where_in('m_approval_id', $m_approval_id)
            ->delete();
    }

    public function resetApproval($module_kode, $data_id)
    {
        $this->db->trans_begin();

        $this->deleteApproval($module_kode, $data_id);

        $this->generate_msr_approval($data_id);

        $this->db->trans_complete();
    }

    /**
     *  @param $user_id integer
     *  @param $amount float  must be converted to same currency at t_jabatan
     */
    public function getSecondAas($user_id, $amount, $company_id)
    {
        /*
         *  Ambil dari t_jabatan yang
         *  - user_role = 1   ===> approver
         *  - company
         *  - id-nya != parent_id user
         */

        $result = array();
        $user_jabatan = @$this->db->where('user_id', $user_id)->get('t_jabatan')->result()[0];

        if (!$user_jabatan) {
            return $result;
        }

        $res = $this->db->select('t_jabatan.*')
            ->select(['m_user.ID_USER', 'm_user.NAME'])
            ->from('t_jabatan')
            ->join('m_user', 'm_user.id_user = t_jabatan.user_id')
            ->where('id !=', $user_jabatan->parent_id)
            ->where('user_role', 1)
            ->where('nominal > ', 0)
            ->group_start()
                ->where('nominal >=', $amount)
                ->or_where("if (user_role = 1 and parent_id in (0,1),
                    nominal <= {$amount}, false)")
            ->group_end()
            ->like('company', $company_id)
            ->order_by('nominal', 'ASC')
            ->order_by('golongan', 'DESC')
            ->get();

        return $res->result();
    }

    public function findParentJabatan($jabatan)
    {
        static $result;

        $parent_jabatan = @$this->db->where('id', $jabatan->parent_id)->get('t_jabatan')->result()[0];

        if ($parent_jabatan->parent_id && $parent_jabatan->parent_id != 0) {
            $this->findParentJabatan($parent_jabatan);
        }

        $result[] = $parent_jabatan;
        return $result;
    }

    public function greetings_msr_verify($value='')
    {
        $user = user();
        $roles              = explode(",", $user->ROLES);
        $roles      = array_values(array_filter($roles));
        $myroles = implode(',', $roles);

        $data = false;
        /*cek msr semua harus approve*/
        $cek = "select a.data_id FROM (select data_id, count(*) jml from t_approval left join m_approval on m_approval.id = t_approval.m_approval_id where status = 1 and m_approval.module_kode = 'msr' group by data_id) a join (select data_id, count(*) jml from t_approval left join m_approval on m_approval.id = t_approval.m_approval_id where m_approval.module_kode = 'msr' group by data_id) b on a.data_id = b.data_id WHERE a.jml = b.jml";
        $q = "SELECT t_approval.data_id
                        FROM t_msr
                        LEFT JOIN `t_approval` on t_msr.msr_no = t_approval.data_id
                        left join m_approval on m_approval.id = t_approval.m_approval_id
                        WHERE t_msr.create_by = $user->ID_USER and status = '2' and m_approval.module_kode = 'msr'  and data_id in ($cek) group by t_approval.data_id";
        $q .= " union all SELECT t_approval.data_id
            FROM t_msr
            LEFT JOIN `t_approval` on t_msr.msr_no = t_approval.data_id
            left join m_approval on m_approval.id = t_approval.m_approval_id
            WHERE t_msr.create_by = $user->ID_USER and status = '2' and t_approval.urutan = 1 and m_approval.module_kode = 'msr_spa' and data_id in ($cek) group by t_approval.data_id";

        $sql = "SELECT t_msr.* FROM t_msr where msr_no in ($q)";
        $sql = "SELECT * from t_msr WHERE ".$this->msrActive(1)." and create_by = '$user->ID_USER' and msr_no in (select data_id from t_approval WHERE status = 2 and m_approval_id in (1,2,3,4,5,6,7) group by data_id) or msr_no in (select data_id from t_approval WHERE status = 3 and m_approval_id = 8 group by data_id)";
        $q = $this->db->query($sql)->num_rows();
        // if($q > 0)
        if(in_array(user_primary,$roles))
        {
            $data['reject'] = $q;
        }
        /*first Step*/
        if(in_array(9,$roles))
        {
            $data['msrtobeverify'] = $this->msrtobeverify();
        }
        /*msr to be assign*/
        if(in_array(assign_sp,$roles))
        {
            $sql = "select t_approval.*,m_approval.*,t_approval.id approval_id
            from t_approval
            left join m_approval on m_approval.id = t_approval.m_approval_id
            left join
            (select t_approval.* from t_approval left join m_approval on m_approval.id = t_approval.m_approval_id where m_approval.module_kode = 'msr_spa' and t_approval.urutan = 1 and m_approval.opsi = '1st' and t_approval.status = 1) a
            on t_approval.data_id = a.data_id
            left join t_msr on t_msr.msr_no = t_approval.data_id
            where m_approval.module_kode = 'msr_spa' and t_approval.urutan = 2 and m_approval.opsi = 'assign_sp' and t_approval.status = 0 and a.status = 1 and t_approval.data_id not in (select msr_no from t_eq_data) and ".$this->msrActive(1)." order by t_approval.data_id desc";
            $query = $this->db->query($sql);
            $data['msrtobeassign'] = $query;
            /*ed to be approved*/
            $data['edapproved'] = $this->ed_approved();

            $data['evaluationToBeApproved'] = $this->evaluationToBeApproved('administrative');


            $data['comtobeapproved'] = $this->evaluationToBeApproved('commercial');

            $this->msrActive();
            $techack = $this->db->select('t_eq_data.*,t_bl.msr_no as data_id')
            ->join('t_bl','t_bl.msr_no=t_eq_data.msr_no')
            ->join('t_assignment','t_assignment.msr_no = t_eq_data.msr_no','left')
            ->join('t_approval','t_approval.data_id = t_eq_data.msr_no','left')
            ->join('t_msr','t_msr.msr_no = t_eq_data.msr_no','left')
            ->where([
                't_approval.m_approval_id' => 8,
                't_approval.created_by' => $this->session->userdata('ID_USER'),
                't_approval.status' => 1,
                't_eq_data.bid_opening' => 1
                ])
            ->where_in('technical', [4])
            ->order_by('t_eq_data.msr_no','desc')
            ->get('t_eq_data');
            $data['techack'] = $techack;

            $data['awardapproval'] = $this->greeting_award_approval();
        }
        /*msr received*/
        if(in_array(bled,$roles))
        {
            $sql ="select t_approval.*,m_approval.*,t_approval.id approval_id
            from t_approval
            left join m_approval on m_approval.id = t_approval.m_approval_id
            left join
            (select t_approval.* from t_approval left join m_approval on m_approval.id = t_approval.m_approval_id where m_approval.module_kode = 'msr_spa' and m_approval.opsi = 'assign_sp' and t_approval.status = 4) a
            on t_approval.data_id = a.data_id
            left join t_assignment on t_assignment.msr_no = t_approval.data_id
            left join t_msr on t_assignment.msr_no = t_msr.msr_no
            where m_approval.module_kode = 'msr_spa' and m_approval.opsi = 'bl-ed' and t_approval.status = 0 and a.status = 4 and t_assignment.user_id = $user->ID_USER and t_approval.data_id not in (select msr_no from t_eq_data)
            and ".$this->msrActive(1)."
            order by t_approval.data_id DESC";
            $query = $this->db->query($sql);
            $data['msrreceived'] = $query;

            $data['revisionbled'] = $this->revisionbled();

            $data['tobeIssued'] = $this->tobeIssued();

            $data['bidOpening'] = $this->bidOpening();

            $data['adminEvaluation'] = $this->adminEvaluation();

            $this->msrActive();
            $techack = $this->db->select('t_eq_data.*,t_bl.msr_no as data_id')
            ->join('t_bl','t_bl.msr_no=t_eq_data.msr_no')
            ->join('t_assignment','t_assignment.msr_no = t_eq_data.msr_no','left')
            ->join('t_msr','t_msr.msr_no = t_eq_data.msr_no','left')
            ->where(['t_assignment.user_id'=>$this->session->userdata('ID_USER')])
            ->where_in('technical', [3])
            ->order_by('t_eq_data.msr_no','desc')
            ->get('t_eq_data');
            $data['techack'] = $techack;

            $data['commercial'] = $this->commercial();

            $data['ee'] = $this->getBledNoNego();

            // $data['par'] = $this->getPar();
            /*award tobe issued*/
            $data['awardtobeissued'] = $this->awardtobeissued_data();
            /*end award tobe issued*/
            $data['clarification'] = $this->vendor_lib->isRead();

            $data['ed_draft'] = $this->ed_draft();
        }
        if(in_array(user_representative, $roles))
        {
            $data['technicalEvaluation'] = $this->technicalEvaluation();

            $id_user = $this->session->userdata('ID_USER');
            $admack_query_adm = "select t_eq_data.*,t_bl.msr_no as data_id
            from t_eq_data
            left join t_bl on t_bl.msr_no=t_eq_data.msr_no
            left join t_msr on t_msr.msr_no = t_eq_data.msr_no
            where administrative = 3 and t_msr.create_by = '$id_user' and ".$this->msrActive(1);
            $administrative = $this->db->query($admack_query_adm);
            $data['admack'] = $administrative;
            $data['comack'] = $this->evaluationToBeApproved('commercial',array(3));
            $data['ackawardrec'] = $this->ackAwardRecomendation();

            $data['edapproved'] = $this->ed_approved();
            $data['awardapproval'] = $this->greeting_award_approval();
        }
        if(in_array(user_manager, $roles))
        {
            $this->msrActive();
            $technical = $this->db->select('t_eq_data.*,t_bl.msr_no as data_id')
            ->join('t_bl','t_bl.msr_no=t_eq_data.msr_no')
            ->join('t_msr','t_msr.msr_no = t_eq_data.msr_no','left')
            ->join('t_approval','t_approval.data_id = t_eq_data.msr_no','left')
            ->where([
                't_approval.m_approval_id' => 1,
                't_approval.created_by' => $this->session->userdata('ID_USER'),
                't_approval.status' => 1
                ])
            ->where_in('technical', [1,2])
            ->order_by('t_msr.msr_no','desc')
            ->get('t_eq_data');
            $data['techToBeApproved'] = $technical;

            $id_user = $this->session->userdata('ID_USER');
            $admack_query2 = "select t_eq_data.*,t_bl.msr_no as data_id
            from t_eq_data
            left join t_bl on t_bl.msr_no=t_eq_data.msr_no
            left join t_msr on t_msr.msr_no = t_eq_data.msr_no
            left join t_approval on t_approval.data_id = t_eq_data.msr_no
            where administrative = 4 and t_approval.m_approval_id = 1 and t_approval.created_by = '$id_user'
            and t_approval.status = 1 and ".$this->msrActive(1);
            #$admack_query = "";
            if(isset($data['admack']))
            {
                $admack_query = " $admack_query_adm union $admack_query2 ";
            }else{
                $admack_query = $admack_query2 ;
            }
            $admack = $this->db->query($admack_query);

            $data['admack'] = $admack;
            $data['comack'] = $this->evaluationToBeApproved('commercial',array(4));
            $data['ackawradapproval'] = $this->ackAwardRecomendationApproval();
            $data['edapproved'] = $this->ed_approved();
            $data['awardapproval'] = $this->greeting_award_approval();
        }
        if(in_array(proc_committe, $roles))
        {
            $data['receiveawardrecev'] = $this->receiveawardrecev();
            $data['awardapproval'] = $this->greeting_award_approval();
            $data['edapproved'] = $this->add_on_pc_approval_list_ed($this->ed_approved());
        }
        if(in_array(vps, $roles))
        {
            $data['edapproved'] = $this->ed_approved();
        }
        if(in_array(45, $roles))
        {
            $data['awardapproval_bod'] = $this->bod_award_approval();
        }
        if(in_array(46, $roles))
        {
            $data['awardapproval_bod'] = $this->bod_award_approval();
        }
        if(in_array(47, $roles))
        {
            $data['awardapproval_bod'] = $this->bod_award_approval();
        }

        return $data;
    }
    public function msrtobeverify($status=0)
    {
        $cek = "select a.data_id FROM (select data_id, count(*) jml from t_approval left join m_approval on m_approval.id = t_approval.m_approval_id where status = 1 and m_approval.module_kode = 'msr' group by data_id) a join (select data_id, count(*) jml from t_approval left join m_approval on m_approval.id = t_approval.m_approval_id where m_approval.module_kode = 'msr' group by data_id) b on a.data_id = b.data_id WHERE a.jml = b.jml";

        $sql = "select *,t_approval.id approval_id from
        t_approval
        left join m_approval on m_approval.id = t_approval.m_approval_id
        left join t_msr on t_msr.msr_no = t_approval.data_id
        where m_approval.module_kode = 'msr_spa' and t_approval.urutan = 1 and m_approval.opsi = '1st' and t_approval.status = $status and t_approval.data_id in ($cek) and ".$this->msrActive(1)." ORDER BY t_approval.data_id DESC";
        return $this->db->query($sql);
    }
    public function edapproved()
    {
        $sql = $this->sql_ed_approved();
        $sql = "select data_id from ($sql) a where a.data_id in (select msr_no from t_msr where ".$this->msrActive(1).") group by data_id";
        return $this->db->query($sql);
    }
    public function edapproved2()
    {
        $sql = $this->sql_ed_approved();
        return $this->db->query($sql);
    }
    public function revisionbled()
    {
        $sql = "select *,t_approval.id approval_id
        from t_approval
        left join m_approval on m_approval.id = t_approval.m_approval_id
        left join t_msr on t_msr.msr_no = t_approval.data_id
        where ".$this->msrActive(1)." and m_approval.module_kode = 'msr_spa' and m_approval.role_id in (8,25,18,23,27,26) and t_approval.status = 2";
            return $this->db->query($sql);
    }
    public function reject2()
    {
        /*data_id, status, m_approval_id, desc*/
        $this->db->trans_begin();
        $data = $this->input->post();
        $id = $data['id'];
        unset($data['id'],$data['module_kode']);

        $this->db->where(['id'=>$id]);
        $this->db->update('t_approval', $data);

        $bl['status'] = 0;

        $this->db->where(['msr_no'=>$data['data_id']]);
        $this->db->update('t_bl', $bl);

        $user = user();
        if($this->db->trans_status() === true)
        {
            $this->db->trans_commit();
            $this->approval_lib->log([
                'module_kode'=>$this->input->post('module_kode'),
                'data_id'=>$data['data_id'],
                'description'=> 'Rejected',
                'keterangan' => @$data['deskripsi'],
                'created_by'=>$user->ID_USER
            ]);
            return true;
        }
        else
        {
            $this->db->trans_rollback();
            return false;
        }
    }
    public function checkReject($data_id='')
    {
        $sql = "select *,t_approval.id approval_id from t_approval left join m_approval on m_approval.id = t_approval.m_approval_id where m_approval.module_kode = 'msr_spa' and t_approval.data_id = '$data_id' and t_approval.status = 2";
        return $this->db->query($sql);
    }
    public function tobeIssued($value='')
    {
        $sql = "select data_id
        from t_approval
        WHERE m_approval_id = 12 and STATUS = 0
        GROUP BY data_id ";
        $sql = "select t_approval.*,t_approval.id approval_id
        from t_approval
        left join t_assignment on t_approval.data_id = t_assignment.msr_no
        left join t_msr on t_approval.data_id = t_msr.msr_no
        where m_approval_id = 13 and t_approval.status = 5 and data_id not in ($sql) and t_assignment.user_id = ".$this->session->userdata('ID_USER')." and ".$this->msrActive(1)."
        ORDER by t_approval.data_id DESC";

        return $this->db->query($sql);
    }
    public function readyIssude($msr_no='')
    {
        $sql = "select * from (
            select t_approval.data_id, count(t_approval.data_id) jml, a.jml jml2
            from t_approval
            left join m_approval on t_approval.m_approval_id = m_approval.id
            left join (
                select data_id, count(data_id) jml from t_approval
                left join m_approval on t_approval.m_approval_id = m_approval.id
                where t_approval.status = 1
                and m_approval.module_kode = 'msr_spa'
                and m_approval_id not in (13)
                group by data_id
            ) a on a.data_id = t_approval.data_id
            where m_approval.module_kode = 'msr_spa'
            and t_approval.m_approval_id not in (13)
            group by t_approval.data_id, a.jml
        ) a where jml2 is not null and jml = jml2 and data_id = '$msr_no'";
        return $this->db->query($sql);
    }
    public function getVendor($value='')
    {
        return $this->db->get('m_vendor');
    }
    public function bidOpening()
    {
        $this->msrActive();
        return $this->db->select('*,t_approval.id approval_id')
        ->join('m_approval','m_approval.id=t_approval.m_approval_id')
        ->join('t_eq_data','t_eq_data.msr_no=t_approval.data_id')
        ->join('t_assignment','t_assignment.msr_no=t_eq_data.msr_no')
        ->join('t_msr','t_msr.msr_no=t_eq_data.msr_no')
        ->where(['m_approval.module_kode' => 'msr_spa', 'm_approval.opsi' => 'bl-ed', 't_approval.status'=>1, 't_eq_data.bid_opening'=> 0, 't_assignment.user_id'=>$this->session->userdata('ID_USER')])
        ->order_by('t_approval.data_id', 'DESC')
        ->get('t_approval');

    }
    public function updateBidOpening()
    {
        $this->db->trans_begin();
        $id = $this->input->post('ed_id');
        $eq = $this->db->where(['id'=>$id])->get($this->tbeq)->row();
        $msr_no = $eq->msr_no;
        $this->db->where(['id'=>$id]);
        $this->db->update('t_eq_data',['bid_opening'=>1, 'bid_opening_date'=>date("Y-m-d H:i:s")]);
        $this->approval_lib->log([
            'module_kode'=>'bid opening',
            'data_id'=> $msr_no,
            'description'=> 'Bid Opening',
            'keterangan' => null,
            'created_by'=>$this->session->userdata('ID_USER')
        ]);
        if($this->db->trans_status() === true)
        {
            $this->db->trans_commit();
            return true;
        }
        else
        {
            $this->db->trans_rollback();
            return false;
        }
    }
    public function adminEvaluation($value='')
    {
        $user = user();
        $this->msrActive();
        return $this->db->select('*,t_bl.msr_no as data_id')
        ->join('t_bl','t_bl.msr_no=t_eq_data.msr_no')
        ->join('t_assignment','t_assignment.msr_no=t_eq_data.msr_no')
        ->join('t_msr','t_msr.msr_no=t_eq_data.msr_no')
        ->where(['bid_opening'=>1,'administrative'=>0,'t_assignment.user_id'=>$user->ID_USER])
        ->order_by('t_eq_data.msr_no', 'DESC')
        ->get('t_eq_data');
    }
    public function administrative()
    {
        $this->db->trans_begin();
        $data = $this->input->post();
        $this->db->where(['id'=>$data['id']]);
        unset($data['id']);
        $this->db->update('t_bl_detail',$data);
        if($this->db->trans_status() === true)
        {
            $this->db->trans_commit();
            return true;
        }
        else
        {
            $this->db->trans_rollback();
            return false;
        }
    }
    public function administrationevaluation($value='')
    {
        $data = $this->input->post();
        /*print_r($data);
        exit();*/
        $deskripsi = $data['deskripsi'];
        $description = $data['description'];
        $this->db->trans_begin();
        $eq = $this->db->where(['id'=>$data['ed_id']])->get($this->tbeq)->row();
        $msr_no = $eq->msr_no;
        $this->db->where(['id'=>$data['ed_id']]);
        unset($data['ed_id'],$data['deskripsi'],$data['description']);
        $this->db->update($this->tbeq, $data);
        $this->approval_lib->log([
            'module_kode'=>'admin evaluation',
            'data_id'=> $msr_no,
            'description'=> $description ? $description : 'Administration evaluation',
            'keterangan' => $deskripsi,
            'created_by'=>$this->session->userdata('ID_USER')
        ]);

        if($this->db->trans_status() === true)
        {
            $this->db->trans_commit();
            return true;
        }
        else
        {
            $this->db->trans_rollback();
            return false;
        }
    }
    public function technicalEvaluation($value='')
    {
        if($this->input->post('ed_id'))
        {
            $data = $this->input->post();
            /*print_r($data);
            exit()*/;
            $deskripsi = $data['deskripsi'];
            $description = $data['description'];
            $this->db->trans_begin();
            $eq = $this->db->where(['id'=>$data['ed_id']])->get($this->tbeq)->row();
            $msr_no = $eq->msr_no;
            $this->db->where(['id'=>$data['ed_id']]);
            unset($data['ed_id'],$data['deskripsi'],$data['description']);
            $this->db->update($this->tbeq, $data);
            // echo $this->db->last_query();
            $this->approval_lib->log([
                'module_kode'=>'technical evaluation',
                'data_id'=> $msr_no,
                'description'=> $description,
                'keterangan' => $deskripsi,
                'created_by'=>$this->session->userdata('ID_USER')
            ]);
            if($this->db->trans_status() === true)
            {
                $this->db->trans_commit();
                return true;
            }
            else
            {
                $this->db->trans_rollback();
                return false;
            }
        }
        $this->msrActive();
        return $this->db->select('t_bl.*,t_eq_data.*,t_bl.msr_no as data_id')
        ->join('t_bl','t_bl.msr_no=t_eq_data.msr_no')
        ->join('t_msr','t_msr.msr_no=t_eq_data.msr_no','left')
        ->where(['bid_opening'=>1, 't_msr.create_by'=>$this->session->userdata('ID_USER')])
        ->where_in('technical',[0,2])
        ->order_by('t_eq_data.msr_no', 'DESC')
        ->get('t_eq_data');
    }
    public function approvalEdEvaluation()
    {
        if($this->input->post('ed_id'))
        {
            $this->db->trans_begin();
            $data = $this->input->post();
            $pemenang = $this->session->userdata('pemenang');
            /*echo "<pre>";
            print_r($data);
            print_r($pemenang);
            exit();*/
            $msr_no = $data['msr_no'];

            if(@$_FILES['contract_review_file']['tmp_name'])
            {
                $config['upload_path']  = './upload/contract_review/';
                if (!is_dir($config['upload_path'])) {
                    mkdir($config['upload_path'],0755,TRUE);
                }
                $config['allowed_types']= '*';
                $config['encrypt_name']= true;
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload('contract_review_file'))
                {
                    echo $this->upload->display_errors('', '');exit;
                }else
                {
                    $user = user();
                    $upload = $this->upload->data();
                    $field['module_kode'] = 'contract review';
                    $field['data_id'] = $msr_no;
                    $field['file_path'] = $upload['file_name'];
                    $field['file_name'] = $data['contract_review_name'];
                    $field['created_by'] = $user->ID_USER;
                    $this->db->insert('t_upload',$field);
                }
            }
            unset($data['contract_review_file'],$data['contract_review_name']);

            $this->db->where(['id'=>$data['ed_id']]);
            unset($data['ed_id'],$data['msr_no']);
            $this->db->update($this->tbeq, $data);
            if(isset($data['commercial']))
            {
                $vendor_id = [];

                $this->db->where(['msr_no'=>$msr_no]);
                $this->db->update('t_sop_bid',['award'=>0]);
                // echo $this->db->last_query();
                foreach ($pemenang as $key => $value) {
                    #$key = sop_id, $value = vendor_id
                    $this->db->where(['sop_id'=>$key,'vendor_id'=>$value]);
                    $this->db->update('t_sop_bid',['award'=>1]);
                    $vendor_id[$value] = $value;
                }

                $this->db->where(['msr_no'=>$msr_no]);
                $this->db->update('t_bl_detail', ['awarder'=>0, 'awarder_date'=>null]);

                $this->db->where(['msr_no'=>$msr_no]);
                $this->db->where_in('vendor_id', $vendor_id);
                $this->db->update('t_bl_detail', ['awarder'=>1, 'awarder_date'=>date('Y-m-d')]);

                $t_approval = $this->db->where(['data_id'=>$msr_no])->where_in('m_approval_id',[20,21,22,23,24,25])->get('t_approval');

                if($t_approval->num_rows() == 0)
                {
                    $this->generate_award_approval($msr_no);
                }
            }

            if($this->db->trans_status() === true)
            {
                $this->db->trans_commit();
                return true;
            }
            else
            {
                $this->db->trans_rollback();
                return false;
            }
        }
    }
    public function approvalEdEvaluationLog()
    {
        $this->db->trans_begin();
        $data = $this->input->post();
        /*print_r($data);
        exit();*/
        $deskripsi = $data['deskripsi'];
        $description = $data['description'] ? $data['description'] : 'Approval Administration Evaluation';

        $description = $data[$data['approval_ed']] == 0 ? str_replace('Approval', 'Reject', $description) : $description;

        $module_kode = $data['module_kode'];
        $eq = $this->db->where(['id'=>$data['ed_id']])->get($this->tbeq)->row();
        $msr_no = $eq->msr_no;
        $this->db->where(['id'=>$data['ed_id']]);
        $this->db->update($this->tbeq, [
            $data['approval_ed'] => $data[$data['approval_ed']]
        ]);
        $this->approval_lib->log([
            'module_kode'=> $module_kode ? $module_kode : 'admin evaluation',
            'data_id'=> $msr_no,
            'description'=> $description,
            'keterangan' => $deskripsi,
            'created_by'=>$this->session->userdata('ID_USER')
        ]);
        if($this->db->trans_status() === true)
        {
            $this->db->trans_commit();
            return true;
        }
        else
        {
            $this->db->trans_rollback();
            return false;
        }
    }
    public function evaluationToBeApproved($field='administrative', $where_in = [1,2])
    {
        $this->msrActive();
        return $this->db->select('*,t_bl.msr_no as data_id')
        ->join('t_bl','t_bl.msr_no=t_eq_data.msr_no')
        ->join('t_msr','t_msr.msr_no=t_eq_data.msr_no')
        ->where_in($field, $where_in)
        ->where('t_eq_data.bid_opening',1)
        ->order_by('t_eq_data.msr_no', 'desc')
        ->get('t_eq_data');
    }
    public function seeAttachment($module_kode='eva-administrative', $msr_no='')
    {
        return $this->db->select('*')->where(['module_kode' => $module_kode, 'data_id' => $msr_no])->order_by('id','desc')->get('t_upload');
    }
    public function performNegotiation($value='')
    {
        return $this->db->select('t_eq_data.*,t_eq_data.msr_no data_id')
        ->join('t_assignment','t_assignment.msr_no = t_eq_data.msr_no','left')
        ->where(['t_assignment.user_id'=>$this->session->userdata('ID_USER')])
        ->where(['administrative'=>5,'technical'=>5,'commercial'=>1])->get($this->tbeq);
    }
    public function commercial($where='')
    {
        if(is_array($where))
        {
            $this->db->where($where);
        }
        $this->msrActive();
        $res = $this->db->select('*,t_eq_data.msr_no as data_id')
            ->join('t_assignment','t_assignment.msr_no = t_eq_data.msr_no','left')
            ->join('t_msr','t_msr.msr_no = t_eq_data.msr_no','left')
            ->where(['t_assignment.user_id'=>$this->session->userdata('ID_USER')])
            ->where(['administrative'=>5,'technical'=>5,'commercial'=>0])
            ->get($this->tbeq);
        return $res;
    }
    public function getBledNoNego()
    {
        $this->msrActive();
        return $this->db->select('t_bid_head.*')
        ->join('t_bl','t_bl.bled_no=t_bid_head.bled_no')
        ->join('t_eq_data','t_eq_data.msr_no=t_bl.msr_no')
        ->join('t_assignment','t_assignment.msr_no = t_eq_data.msr_no','left')
        ->join('t_msr','t_msr.msr_no = t_eq_data.msr_no','left')
        ->where(['t_assignment.user_id'=>$this->session->userdata('ID_USER')])
        ->where(['issued_nego'=>1,'t_eq_data.award'=>0])->get('t_bid_head')->result_array();
    }
    public function getPar($value='')
    {
        return $this->db->select('t_eq_data.*')
        ->join('t_assignment','t_assignment.msr_no = t_eq_data.msr_no','left')
        ->where(['t_assignment.user_id'=>$this->session->userdata('ID_USER')])->where(['award'=>1])->get('t_eq_data');
    }
    public function awardApproval($value='')
    {
        return $this->db->where(['award'=>1])->get('t_eq_data');
    }

    /**
     * Get approval flow from master
     */
    public function getFlow($module_kode)
    {
        return @$this->db->where('module_kode', $module_kode)
            ->order_by('urutan', 'ASC')
            ->get($this->table)
            ->result();
    }

    /**
     * Create document workflow with no any custom condition
     * Just copy from m_approval and paste to t_approval
     */
    public function generateDocumentflow($module_kode, $data_id)
    {
        $default_flow = $this->getFlow($module_kode);
        $user = $this->session->userdata();

        if (!$default_flow) {
            log_message('error', sprintf("No workflow exists for module %s", $module_kode));

            throw new RuntimeException(sprintf("No workflow exists for module %s", $module_kode));
            return false;
        }

        if ($this->getDocumentFlow($module_kode, $data_id)) {
            log_message('error', sprintf('Approval workflow for document %s #%s has been existed', $module_kode, $data_id));

            throw new RuntimeException(sprintf('Approval workflow for document %s #%s has been existed', $module_kode, $data_id));
            return false;
        }

        $this->db->trans_start();

        $urutan = 1;
        foreach($default_flow as $step) {
            $data = array();
            $data['m_approval_id'] = $step->id;
            $data['status'] = '0';
            $data['data_id'] = $data_id;
            $data['deskripsi'] = '';
            $data['urutan'] = $urutan++;
            $data['created_by'] = $user['ID_USER'];
            $data['created_at'] = today_sql();

            // then
            $this->addDocumentFlowStep($data);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            log_message('error', sprintf('Failed creating approval workflow for document %s #%s', $module_kode, $data_id));

            throw new RuntimeException(sprintf('Failed creating approval workflow for document %s #%s', $module_kode, $data_id));
            return false;
        }

        return true;
    }

    public function getDocumentFlow($module_kode, $data_id)
    {
        return $this->db->select($this->transaction_table.'.*')
            ->join($this->table, $this->table.".id = ".$this->transaction_table.".m_approval_id")
            ->where($this->table.'.module_kode', $module_kode)
            ->where($this->transaction_table.'.data_id', $data_id)
            ->get($this->transaction_table)
            ->result();
    }

    public function addDocumentFlowStep($data)
    {
        return $this->db->insert($this->transaction_table, $data);
    }

    public function ackAwardRecomendation($value='')
    {
        $this->msrActive();
        return $this->db->select('t_eq_data.*')
        ->join('t_msr','t_msr.msr_no = t_eq_data.msr_no','left')
        ->where(['t_msr.create_by'=>$this->session->userdata('ID_USER')])
        ->where(['award'=>4])->get('t_eq_data');
    }
    public function ackAwardRecomendationApproval($value='')
    {
        return $this->db->where(['award'=>6])->get('t_eq_data');
    }
    public function receiveawardrecev($value='')
    {
        return $this->db->where(['award'=>7])->get('t_eq_data');
    }
    public function awardtobeissued($value='')
    {
        $sql = "select t_approval.data_id,t_approval.status
        from t_approval
        left join m_approval on m_approval.id = t_approval.m_approval_id
        left join t_msr on t_msr.msr_no = t_approval.data_id
        where m_approval.module_kode = 'award' and data_id not in (select msr_no from t_eq_data where award = 9) and ".$this->msrActive(1);
        $query = $this->db->query($sql);
        return $query;
    }
    public function firstAas($nominal = 10000, $created_by = '',$msr_company='')
    {
        // echo numIndo($nominal);
        $rs = '';
        $sqlId = "select * from t_jabatan where user_id = $created_by";
        $n = $this->db->query($sqlId)->row();
        $id = @$n->id;
        if($nominal > 5000000)
        {
            $sql = "SELECT * FROM t_jabatan WHERE id = 1";
            $result = $this->db->query($sql);
            $row = $result->row();
            $rs = $row;
        }
        else
        {
            for ($i=0; $i < 4; $i++) {
                $sql = "SELECT * FROM t_jabatan WHERE id = (SELECT parent_id FROM t_jabatan WHERE id = '$id')";
                $result = $this->db->query($sql);
                $row = $result->row();
                if($nominal <= @$row->nominal)
                {
                    $rs = $row;
                    break;
                }
                else
                {
                    $id = @$row->id;
                }
            }
        }
        /*cek di m_user*/
        $msr_company = trim($msr_company);
        $q = "select * from m_user where ID_USER  = $rs->user_id and COMPANY like '%$msr_company%'";
        if($this->db->query($q)->num_rows() > 0)
        {

        }
        else
        {
            $rs = $this->db->where(['first'=>1])->get('t_jabatan')->row();
        }
        return $rs;
    }
    public function getRejectByMsr($msr_no='')
    {
        $q = "SELECT * FROM `t_approval` left join m_approval on m_approval.id = t_approval.m_approval_id WHERE data_id = '$msr_no' and status = '2' and m_approval.module_kode = 'msr'";
        $query = $this->db->query($q);
        if($query->num_rows() == 0)
        {
            $q = "SELECT * FROM `t_approval` left join m_approval on m_approval.id = t_approval.m_approval_id WHERE data_id = '$msr_no' and ((status = '2' and t_approval.urutan = 1) or (status = '3' and t_approval.urutan = 2)) and m_approval.module_kode = 'msr_spa'";
            $query = $this->db->query($q);
        }
        if($this->input->get('debug'))
        {
            echo $this->db->last_query();
            echo "<pre>";
            print_r($query->result());
            exit();
        }
        if($query->num_rows() > 0)
            return true;
        return false;
    }
    public function resubmit($value='')
    {
        $this->db->trans_begin();
        $msr_no = $this->input->post('msr_no');

        $q = "SELECT t_approval.id FROM `t_approval` left join m_approval on m_approval.id = t_approval.m_approval_id WHERE data_id = '$msr_no' and status in (1,2,3) and m_approval.module_kode in ('msr','msr_spa')";
        $query = $this->db->query($q)->result();
        if($this->input->get('debug'))
        {
            echo $this->db->last_query();
        }
        $id = [];
        foreach ($query as $key => $value) {
            $id[] = $value->id;
        }
        if($this->input->get('debug'))
        {
            echo "<pre>";
            print_r($id);
        }

        $data['status'] = 0;
        if(count($id) > 0)
        {
            $this->db->where_in('id',$id);
            $this->db->update('t_approval', $data);
        }

        $q = "update t_approval set status = 0 where data_id = '$msr_no' and m_approval_id = 7";
        $this->db->query($q);
        if($this->input->get('debug'))
        {
            echo $this->db->last_query();
            exit();
        }

        if($this->db->trans_status() === true)
        {
            $this->db->trans_complete();
            return true;
        }
        else
        {
            $this->db->trans_rollback();
            return false;
        }
    }
    public function proc_committe_ed_approval()
    {
        $sql = "select data_id from t_approval where m_approval_id = 12 and status = 2";

        $idUser = $this->session->userdata('ID_USER');
        /*$sql = "select t_approval.*,role_id,opsi, t_approval.id approval_id,m_user_roles.DESCRIPTION role_name*/
        $q = "SELECT t_approval.*,role_id,opsi,t_approval.id as approval_id,m_user_roles.DESCRIPTION role_name
            FROM `t_approval`
            LEFT JOIN m_approval on  t_approval.m_approval_id = m_approval.id
            left join m_user_roles on m_approval.role_id = m_user_roles.ID_USER_ROLES
            WHERE m_approval_id = 12
            and t_approval.status = 0
            and created_by = $idUser
            and m_approval.module_kode = 'msr_spa'
            and t_approval.data_id IN
            (SELECT t.data_id FROM t_approval t
            join  (SELECT id,data_id,min(urutan) as urutan FROM `t_approval` WHERE m_approval_id = 12 GROUP BY id,data_id) a on a.data_id=t.data_id and t.urutan=(a.urutan)-1
            join m_approval m on m.id=t.m_approval_id and m.module_kode='msr_spa'
            where t.status=1 and t.data_id not in ($sql)) ";
        return $q;
    }
    public function proc_committe_ed_approval_2($value='')
    {
        $sql = "select data_id from t_approval where m_approval_id = 12 and status = 2";
        $idUser = $this->session->userdata('ID_USER');
        $q = "SELECT a.*
            from
            (SELECT t_approval.*,role_id,opsi,t_approval.id as approval_id,m_user_roles.DESCRIPTION role_name FROM `t_approval`
            left join m_approval on t_approval.m_approval_id = m_approval.id
            left join m_user_roles on m_approval.role_id = m_user_roles.ID_USER_ROLES
            WHERE created_by = $idUser and t_approval.status = 0 and m_approval.module_kode = 'msr_spa') a
            LEFT join
            (SELECT t_approval.data_id, COUNT(t_approval.id) jml
            FROM `t_approval`
            left join m_approval on t_approval.m_approval_id = m_approval.id
            LEFT JOIN (SELECT DISTINCT(t_approval.data_id), min(t_approval.urutan) urutan FROM `t_approval` left join m_approval on t_approval.m_approval_id = m_approval.id WHERE created_by = $idUser and t_approval.status = 0 and m_approval.module_kode = 'msr_spa' GROUP by t_approval.data_id) t on t_approval.data_id = t.data_id
            WHERE t_approval.status = 1 and m_approval.module_kode = 'msr_spa' and t_approval.urutan < t.urutan
            GROUP by t_approval.data_id) b on a.data_id = b.data_id
            WHERE
            b.jml+1 = a.urutan and a.data_id IN
            (SELECT t.data_id FROM t_approval t
            join  (SELECT id,data_id,min(urutan) as urutan FROM `t_approval` WHERE m_approval_id = 12 GROUP BY id,data_id) a on a.data_id=t.data_id and t.urutan=(a.urutan)-1
            join m_approval m on m.id=t.m_approval_id and m.module_kode='msr_spa'
            where t.status=1 and t.data_id not in ($sql)) and a.m_approval_id = 12";
            // exit();
            return $q;
    }
    public function adendumSql()
    {
        $q = "select * from t_approval where m_approval_id = 13 and status = 1";
        $sql = "select * from t_eq_data where bid_opening = 0 and msr_no in ($q)";
        return $this->db->query($sql);
    }

    public function getApprovalList($data_id,$module='msr')
    {
        $idUser = $this->session->userdata('ID_USER');
        if($module == 'msr')
        {
            $in = [1,2,3,4,5,6];
        }
        if($module == 'ed')
        {
            $in = [8,9,10,11,12];
        }
        if($module == 'award')
        {
            $in = [20,21,22,23,24,25];
        }
        $q = $this->db->where_in('m_approval_id',$in)->where(['created_by'=>$idUser,'status'=>0, 'data_id'=>$data_id])->get('t_approval');
        // echo $this->db->last_query();
        return $q;
    }
    public function getApprovalUserManager($msr_no='')
    {
        $this->db->where(['data_id'=>$msr_no, 'm_approval_id'=>1]);
        return $this->db->get('t_approval');
    }
    public function checkAllMsrApprove($msr_no='')
    {
        return $this->db->join('m_approval','m_approval.id = t_approval.m_approval_id','left')
        ->where(['data_id'=>$msr_no, 'status'=>0, 'module_kode'=>'msr'])
        ->get('t_approval');
    }
    public function muser($where = '')
    {
        if(is_array($where))
        {
            $this->db->where($where);
        }
        return $this->db->get('m_user');
    }
    public function teqdata($where='')
    {
        if(is_array($where))
        {
            $this->db->where($where);
        }
        return $this->db->get('t_eq_data');
    }
    public function listApprovalEd($msr_no='')
    {
        $sql = "select t_approval.*,m_user_roles.DESCRIPTION role_name, m_user.NAME user_nama
        from t_approval
        left join m_approval on m_approval.id = t_approval.m_approval_id
        LEFT JOIN m_user_roles on m_approval.role_id = m_user_roles.ID_USER_ROLES
        LEFT JOIN m_user on m_user.ID_USER = t_approval.created_by
        where data_id = '$msr_no' and m_approval_id in (8,9,10,11,12)";
        return $this->db->query($sql);
    }
    public function ed_draft($value='')
    {
        $user = user();
        $this->msrActive();
        $q = $this->db->select('t_eq_data.*')
            ->join('t_assignment','t_eq_data.msr_no = t_assignment.msr_no')
            ->join('t_approval','t_approval.data_id = t_assignment.msr_no')
            ->join('t_msr','t_msr.msr_no = t_assignment.msr_no')
            ->where([
                't_eq_data.status'=>0,
                't_assignment.user_id'=>$user->ID_USER,
                't_approval.status'=>4,
                't_approval.m_approval_id'=>8
            ])
            ->order_by('t_eq_data.msr_no', 'DESC')
            ->get('t_eq_data');
        return $q;
    }
    public function sql_ed_approved($value='')
    {
        $idUser = $this->session->userdata('ID_USER');
        $cek = $this->db->where(['ID_USER'=>$idUser])->get('m_user')->row();
        $roles = explode(",", $cek->ROLES);
        $data['roles'] = array_values(array_filter($roles));
        $myroles = implode(',', $data['roles']);

        $q = "SELECT t_approval.data_id, COUNT(t_approval.id) jml
            FROM `t_approval`
            left join m_approval on t_approval.m_approval_id = m_approval.id
            LEFT JOIN (SELECT DISTINCT(t_approval.data_id), min(t_approval.urutan) urutan FROM `t_approval` left join m_approval on t_approval.m_approval_id = m_approval.id WHERE created_by = $idUser and t_approval.status = 0 and m_approval.module_kode = 'msr_spa' GROUP by t_approval.data_id) t on t_approval.data_id = t.data_id
            WHERE t_approval.status = 1 and m_approval.module_kode = 'msr_spa' and t_approval.urutan < t.urutan
            GROUP by t_approval.data_id";
        $sql = "select t_approval.*,role_id,opsi, t_approval.id approval_id,m_user_roles.DESCRIPTION role_name
                from t_approval
                left join m_approval on t_approval.m_approval_id = m_approval.id
                left join m_user_roles on m_approval.role_id = m_user_roles.ID_USER_ROLES
                left join t_bl on t_approval.data_id = t_bl.msr_no
                left join ($q) b on t_approval.data_id = b.data_id
                where t_approval.created_by = $idUser
                and module_kode = 'msr_spa'
                and t_approval.urutan > 1 and m_approval.opsi <> 'bl-ed' and (case WHEN m_approval_id = 8 THEN t_approval.status = 4 ELSE t_approval.status=0 END)
                and t_bl.status = 1
                order by t_approval.data_id,t_approval.urutan asc";
                // echo $sql;
        $uni = $this->proc_committe_ed_approval_2();
        // exit();
        return "($sql) union ($uni)";
    }
    public function ed_approved($value='')
    {
        $idUser = $this->session->userdata('ID_USER');
        $sql = "SELECT t_approval.*, t_assignment.user_id as id_procurement_specialist, procurement_specialist.NAME as procurement_specialist, t_eq_data.closing_date
            from t_approval
            join t_assignment on t_assignment.msr_no = t_approval.data_id
            join m_user procurement_specialist on procurement_specialist.ID_USER = t_assignment.user_id
            join t_eq_data on t_eq_data.msr_no = t_approval.data_id
            left join m_approval on m_approval.id = t_approval.m_approval_id
            left join t_bl on t_approval.data_id = t_bl.msr_no
            WHERE m_approval.module_kode = 'msr_spa' AND t_approval.urutan > 1  and m_approval.opsi <> 'bl-ed' and (case WHEN m_approval_id = 8 THEN t_approval.status = 4 ELSE t_approval.status=0 END) and t_approval.created_by = $idUser and t_bl.status = 1 ORDER BY data_id DESC";
            // exit();
        $rs = $this->db->query($sql);
        $x = [];
        foreach ($rs->result() as $r) {
            $urutan = $r->urutan;
            $q = "SELECT t_approval.*
            from t_approval
            left join m_approval on m_approval.id = t_approval.m_approval_id
            left join t_bl on t_approval.data_id = t_bl.msr_no
            WHERE m_approval.module_kode = 'msr_spa' AND t_approval.urutan > 1  and m_approval.opsi <> 'bl-ed' and t_bl.status = 1 and t_approval.status = 1 and t_approval.data_id = '$r->data_id' and t_approval.urutan < $urutan";

            $a = $this->db->query($q);
            if($r->m_approval_id == 8 and $r->status == 4)
            {
                $x[] = $r;
            }
            else
            {
                /*if($a->num_rows() > 0)
                {
                    $x[] = $r;
                }*/
                if($a->num_rows()+2 == $r->urutan)
                {
                    $x[] = $r;
                }
            }
        }
        if(in_array(proc_committe, $this->roles))
        {
            $x = $this->add_on_pc_approval_list_ed($x);
        }
        return $x;
    }
    public function generate_award_approval($msr_no='')
    {
        //$this->db->trans_begin();
        $sum_award_total_value = $this->sumawardtotalvalue($msr_no);
        $t_eq_data = $this->db->where(['msr_no'=>$msr_no])->get('t_eq_data')->row();

        // $sum_award_total_value = exchange_rate_by_id($t_eq_data->currency, 3, $sum_award_total_value);

        $m_approval = $this->db->where(['module_kode'=>'award','aktif'=>1])->order_by('urutan','asc')->get('m_approval');
        $urutan = 1;
        if($this->input->get('debug'))
        {
            echo "sum_award_total_value = $sum_award_total_value";
        }
        foreach ($m_approval->result() as $r) {
            $data['m_approval_id']  = $r->id;
            $data['data_id']        = $msr_no;

            if($r->opsi == 'procurement_head')
            {
                $t_approval = $this->db->where(['data_id'=>$msr_no, 'm_approval_id'=>8])->get('t_approval')->row();
                $data['created_by'] = $t_approval->created_by;
                $data['urutan']         = $urutan++;
                if($this->input->get('debug'))
                {
                    $debug[] = $data;
                }
                else
                {
                    $this->db->insert('t_approval', $data);
                }
            }
            if($r->opsi == 'user_representative')
            {
                $t_msr = $this->db->where(['msr_no'=>$msr_no])->get('t_msr')->row();
                $data['created_by'] = $t_msr->create_by;
                $data['urutan']         = $urutan++;
                if($this->input->get('debug'))
                {
                    $debug[] = $data;
                }
                else
                {
                    $this->db->insert('t_approval', $data);
                }
            }
            if($r->opsi == 'user_manager')
            {
                $t_approval = $this->db->where(['data_id'=>$msr_no, 'm_approval_id'=>1])->get('t_approval')->row();
                $data['created_by'] = $t_approval->created_by;
                $data['urutan']         = $urutan++;
                if($this->input->get('debug'))
                {
                    $debug[] = $data;
                }
                else
                {
                    $this->db->insert('t_approval', $data);
                }
            }
            if($r->opsi == 'proc_committe')
            {
                $in = false;
                if($sum_award_total_value <= 10000)
                {
                    $in = true;
                }
                foreach (pcApprove($in) as $pcApproveUserId) {
                    $data['created_by'] = $pcApproveUserId;
                    $data['urutan'] = $urutan++;
                    if($this->input->get('debug'))
                    {
                        $debug[] = $data;
                    }
                    else
                    {
                        $this->db->insert('t_approval', $data);
                    }
                }
            }
            if($r->opsi == 'coo' and $sum_award_total_value >= 100000)
            {
                /*get coo*/
                $sql = "select * from m_user where roles like '%$r->role_id%'";
                $coo = $this->db->query($sql);
                if($coo->num_rows() > 0)
                {
                    $coo = $coo->row();
                    $data['m_approval_id']  = $r->id;
                    $data['created_by']     = $coo->ID_USER;
                    $data['urutan']         = $urutan++;
                    if($this->input->get('debug'))
                    {
                        $debug[] = $data;
                    }
                    else
                    {
                        $this->db->insert('t_approval', $data);
                    }
                }
                
            }
            if($r->opsi == 'ceo' and $sum_award_total_value >= 100000)
            {
                $sql = "select * from m_user where roles like '%$r->role_id%'";
                $ceo = $this->db->query($sql);
                if($ceo->num_rows() > 0)
                {
                    $ceo = $ceo->row();
                    $data['m_approval_id']  = $r->id;
                    $data['created_by']     = $ceo->ID_USER;
                    $data['urutan']         = $urutan++;
                    if($this->input->get('debug'))
                    {
                        $debug[] = $data;
                    }
                    else
                    {
                        $this->db->insert('t_approval', $data);
                    }
                }
                
            }
            if($r->opsi == 'cfo' and $sum_award_total_value >= 100000)
            {
                $t_msr = $this->db->where(['msr_no'=>$msr_no])->get('t_msr')->row();

                if($t_msr->id_company == 10103)
                {
                    $sql = "select * from m_user where roles like '%$r->role_id%' and company like '%10103%'";
                }
                else
                {
                    $sql = "select * from m_user where roles like '%$r->role_id%' and company not like '%10103%'";
                }
                $cfo = $this->db->query($sql);
                if($cfo->num_rows() > 0)
                {
                    $cfo = $cfo->row();
                    $data['m_approval_id']  = $r->id;
                    $data['created_by']     = $cfo->ID_USER;
                    $data['urutan']         = $urutan++;
                    if($this->input->get('debug'))
                    {
                        $debug[] = $data;
                    }
                    else
                    {
                        $this->db->insert('t_approval', $data);
                    }
                }
            }
        }
        if($this->input->get('debug'))
        {
            echo "<pre>";
            print_r($debug);
        }
    }
    public function sumawardtotalvalue($msr_no='')
    {
        //$sql = "SELECT (case when nego_price_base > 0 THEN sum(nego_price_base*qty) else sum(unit_price_base*qty) end) nilai from t_sop_bid WHERE msr_no = '$msr_no' and award = 1 group by nego_price_base";
        $sql = "SELECT (case when nego_price_base > 0 THEN sum(nego_price_base*(case when t_sop.qty2 > 0 then (t_sop.qty1 * t_sop.qty2) else t_sop.qty1 end)) else sum(unit_price_base*(case when t_sop.qty2 > 0 then (t_sop.qty1 * t_sop.qty2) else t_sop.qty1 end)) end) nilai from t_sop_bid join t_sop on t_sop.id = t_sop_bid.sop_id WHERE t_sop.msr_no = '$msr_no' and award = 1 group by nego_price_base";
        $rs = $this->db->query($sql)->result();
        $total = 0;
        foreach ($rs as $r) {
            $total += $r->nilai;
        }
        return $total;
    }
    public function listApprovalAward($msr_no='')
    {
        $sql = "select t_approval.*,m_user_roles.DESCRIPTION role_name, m_user.NAME user_nama
        from t_approval
        left join m_approval on m_approval.id = t_approval.m_approval_id
        LEFT JOIN m_user_roles on m_approval.role_id = m_user_roles.ID_USER_ROLES
        LEFT JOIN m_user on m_user.ID_USER = t_approval.created_by
        where data_id = '$msr_no' and m_approval.module_kode = 'award'";
        return $this->db->query($sql);
    }
    public function greeting_award_approval()
    {
        $userLogin = user();
        $idUser = $userLogin->ID_USER;
        $sql = "select t_approval.*,m_user_roles.DESCRIPTION role_name, m_user.NAME user_nama
            from t_approval
            left join m_approval on m_approval.id = t_approval.m_approval_id
            LEFT JOIN m_user_roles on m_approval.role_id = m_user_roles.ID_USER_ROLES
            LEFT JOIN m_user on m_user.ID_USER = t_approval.created_by
            LEFT JOIN t_msr on t_msr.msr_no = t_approval.data_id
            where m_approval.id in (20,21,22,23) and t_approval.created_by = $idUser and (t_approval.status = 0 or t_approval.status = 2) and ".$this->msrActive(1);
        $award_approval = $this->db->query($sql);
        $rs_award_approval = [];
        foreach ($award_approval->result() as $r) {
            if($r->urutan == 1)
            {
                $rs_award_approval[] = $r;
            }
            else
            {
                if($r->m_approval_id == 23)
                {
                    $sql = "select t_approval.*
                    from t_approval
                    left join m_approval on m_approval.id = t_approval.m_approval_id
                    where data_id = '$r->data_id' and module_kode = 'award' and t_approval.status = 0 and t_approval.urutan in (1,2,3) order by t_approval.id asc";
                }
                elseif($r->m_approval_id == 24 or $r->m_approval_id == 25 or $r->m_approval_id == 26)
                {
                    $sql = "select t_approval.*
                    from t_approval
                    left join m_approval on m_approval.id = t_approval.m_approval_id
                    where data_id = '$r->data_id' and module_kode = 'award' and t_approval.status = 0 and m_approval_id between 20 and 23 order by t_approval.id asc";
                }
                else
                {
                    $sql = "select t_approval.*
                    from t_approval
                    left join m_approval on m_approval.id = t_approval.m_approval_id
                    where data_id = '$r->data_id' and module_kode = 'award' and t_approval.status = 0 and t_approval.urutan < $r->urutan order by t_approval.id asc";
                }
                /*echo $r->m_approval_id;
                exit();*/
                // echo $sql;

                $rs = $this->db->query($sql);
                if($rs->num_rows() > 0)
                {

                }
                else
                {
                    $rs_award_approval[] = $r;
                }
            }
        }
        return $rs_award_approval;
    }
    public function bod_award_approval()
    {
        $userLogin = user();
        $idUser = $userLogin->ID_USER;
        $sql = "select t_approval.*,m_user_roles.DESCRIPTION role_name, m_user.NAME user_nama
            from t_approval
            left join m_approval on m_approval.id = t_approval.m_approval_id
            LEFT JOIN m_user_roles on m_approval.role_id = m_user_roles.ID_USER_ROLES
            LEFT JOIN m_user on m_user.ID_USER = t_approval.created_by
            LEFT JOIN t_msr on t_msr.msr_no = t_approval.data_id
            where m_approval.module_kode = 'award' and t_approval.created_by = $idUser and (t_approval.status = 0 or t_approval.status = 2) and m_approval_id in (24,25,26) and t_approval.data_id not in (select data_id from t_approval where m_approval_id in (20,21,22,23) and status = 0 ) ";
            // exit();
        return $this->db->query($sql)->num_rows();
    }
    public function reject_award($value='')
    {
        $data = $this->input->post();
        $moduleKode = $data['module_kode'];
        unset($data['module_kode']);
        $user = user();
        $this->db->trans_begin();
        /*reset all*/
        $this->db->where(['data_id'=>$data['data_id']])->where_in('m_approval_id', [20,21,22,23,24,25]);
        $this->db->update('t_approval', ['status'=>0]);
        /*reject one*/
        $this->db->where(['id'=>$data['id']]);
        $this->db->update('t_approval', ['status'=>2, 'deskripsi'=>$data['deskripsi']]);
        /*reset award sop bid*/
        $this->db->where(['msr_no'=>$data['data_id']]);
        $this->db->update('t_sop_bid',['award'=>0]);
        /*reset award bidder*/
        $this->db->where(['msr_no'=>$data['data_id']]);
        $this->db->update('t_bl_detail',['awarder'=>0]);
        /*reset bled_no bid detail*/
        $this->db->where(['bled_no'=>str_replace('OR', "OQ", $data['data_id'])]);
        $this->db->update('t_bid_detail',['award'=>0]);
        /*reset t_eq_data*/
        $this->db->where(['msr_no'=> $data['data_id'] ]);
        $this->db->update('t_eq_data',['award'=>0, 'commercial'=>0]);

        if($this->db->trans_status() === true)
        {
            $this->db->trans_commit();
            $desc = $data['status'] == 1 ? "Approve" : "Reject";
            $this->approval_lib->log([
                'module_kode'=>$this->input->post('module_kode'),
                'data_id'=>$data['data_id'],
                'description'=>$desc,
                'keterangan'=>$data['deskripsi'],
                'created_by'=>$user->ID_USER
            ]);
            return true;
        }
        else
        {
            $this->db->trans_rollback();
            return false;
        }
    }
    public function awardtobeissued_data()
    {
        $awardtobeissued = $this->awardtobeissued()->result();
        $data_id = []; #save data_id = 0
        foreach ($awardtobeissued as $row) {
            if($row->status == 0)
            {
                $data_id[$row->data_id] = $row->status;
            }
        }
        $array_keys_data_id = array_keys($data_id);
        $data_id_true = []; #save data_id not in $data_id
        foreach ($awardtobeissued as $row) {
            if(!in_array($row->data_id, $array_keys_data_id))
            {
                $data_id_true[$row->data_id] = $row->data_id;
            }
        }
        $array_keys_data_id = array_keys($data_id_true);
        return $array_keys_data_id;
    }
    public function process_award($first=false)
    {
        $module_kode = $this->input->post('module_kode');
        $msr_no = $this->input->post('data_id');
        $t_approval = $this->db->select('t_approval.*')
        ->join('m_approval','t_approval.m_approval_id = m_approval.id', 'left')
        ->where(['m_approval.module_kode'=>$module_kode,'t_approval.data_id'=>$msr_no])
        ->where_in('t_approval.status',[0,2])
        ->get('t_approval');

        if($t_approval->num_rows() > 0)
        {
            return ['status'=>'Approve'];
        }
        else
        {
            $sum_award_total_value = $this->sumawardtotalvalue($msr_no);
            $t_eq_data = $this->db->where(['msr_no'=>$msr_no])->get('t_eq_data')->row();
            // $sum_award_total_value = exchange_rate_by_id($t_eq_data->currency, 3, $sum_award_total_value);
            // echo $sum_award_total_value;
            if($sum_award_total_value >= 5000000)
            {
                return ['status'=>'Approve'];
            }
            else
            {
                if($first)
                {

                }
                else
                {
                    $this->db->where(['msr_no'=>$msr_no]);
                    $this->db->update('t_eq_data', ['award' => 9]);
                }
                return ['status'=>'Issued Award Notification'];
            }
        }
    }
    public function findMsrByMsrNo($msr_no='')
    {
        $msr = $this->db->select('t_msr.*,m_company.DESCRIPTION company_name,m_msrtype.MSR_DESC msr_name, m_plocation.PGroup_Desc proc_location_name, m_costcenter.COSTCENTER_DESC cost_center_name, m_pmethod.PMETHOD_DESC proc_method_name, m_currency.CURRENCY currency')
        ->join('m_company','m_company.ID_COMPANY=t_msr.id_company')
        ->join('m_msrtype','m_msrtype.ID_MSR=t_msr.id_msr_type')
        ->join('m_plocation','m_plocation.ID_Pgroup=t_msr.id_ploc')
        ->join('m_user','m_user.ID_USER=t_msr.create_by')
        ->join('m_costcenter','m_costcenter.ID_COSTCENTER=m_user.COST_CENTER')
        ->join('m_pmethod','m_pmethod.ID_PMETHOD=t_msr.id_pmethod')
        ->join('m_currency','m_currency.ID=t_msr.id_currency')
        ->where('msr_no',$msr_no)->get('t_msr')->row();
        return $msr;
    }
    public function contract_review($msr_no='')
    {
        $s =$this->db->where(['module_kode'=>'contract review', 'data_id'=> $msr_no])->order_by('id','desc')->limit(1)->get('t_upload');
        return $s;
    }
    public function assign_reject()
    {
        $p = $this->input->post();
        $user = user();
        $this->db->trans_begin();

        $this->db->where(['id'=>$p['t_approval_id']]);
        $this->db->update('t_approval', [
            'status' => 3,
            'data_id' => $p['data_id'],
            'deskripsi' => $p['description'],
        ]);
        // echo $this->db->last_query();
        $this->approval_lib->log([
            'module_kode' => 'msr_spa',
            'data_id' => $p['data_id'],
            'description' => "Rejected",
            'keterangan' => $p['description'],
            'created_by' => $user->ID_USER
        ]);

        if($this->db->trans_status() === true)
        {
            $this->db->trans_commit();
            return true;
        }
        else
        {
            $this->db->trans_rollback();
            return false;
        }
    }
    public function view_approval($value='')
    {
        return $this->db->select('t_approval.*,m_user.NAME user_name,m_user_roles.DESCRIPTION role_name,')
        ->join('m_approval','m_approval.id=t_approval.m_approval_id','left')
        ->join('m_user_roles','m_approval.role_id = m_user_roles.ID_USER_ROLES','left')
        ->join('m_user','t_approval.created_by=m_user.ID_USER','left');
    }
    public function approval_list($value='m_approval.*,m_user_roles.*,m_approval.id m_approval_id')
    {
        return $this->db->select($value)
        ->from($this->table)
        ->join('m_user_roles','m_user_roles.ID_USER_ROLES=m_approval.role_id','left');
    }
    public function cancel_msr($value='')
    {
        $this->db->trans_begin();
        $this->db->where(['msr_no'=>$value]);
        $this->db->update('t_msr',['status'=>1]);

        $approval_list = $this->M_approval->approval_list()->where(['m_approval.module_kode'=>'msr-reject'])->order_by('urutan','asc')->get();
        foreach ($approval_list->result() as $r) {
            $user = $this->M_view_user->getByRole($r->role_id)[0];
            $this->db->insert('t_approval',[
                'created_at' => date("Y-m-d H:i:s"),
                'created_by' => $user->ID_USER,
                'data_id' => $value,
                'urutan' => $r->urutan,
                'm_approval_id' => $r->m_approval_id
            ]);
        }
        if($this->db->trans_status() === true)
        {
            $this->db->trans_commit();
            echo json_encode(['status'=>true, 'msg'=>'Success, MSR Canceled']);
        }
        else
        {
            $this->db->trans_rollback();
            echo json_encode(['status'=>false]);
        }
    }
    public function release_msr($value='')
    {
        $this->db->trans_begin();
        $this->db->where(['msr_no'=>$value]);
        $this->db->update('t_msr',['status'=>0]);

        $approval_list = $this->M_approval->approval_list()->where(['m_approval.module_kode'=>'msr-reject'])->order_by('urutan','asc')->get();
        $m_approval_id = [];
        foreach ($approval_list->result() as $r) {
            $m_approval_id = $r->m_approval_id;
        }
        $this->db->where(['data_id'=>$value])->where_in('m_approval_id', $m_approval_id);
        $this->db->delete('t_approval');

        if($this->db->trans_status() === true)
        {
            $this->db->trans_commit();
            echo json_encode(['status'=>true, 'msg'=>'Success, MSR Released']);
        }
        else
        {
            $this->db->trans_rollback();
            echo json_encode(['status'=>false]);
        }
    }
    public function approval_cancel_msr($value='')
    {
        $p = $this->input->post();
        $status = $p['status'] == 1 ? 2:3;
        $desc = $p['status'] == 1 ? "Approve" : "Reject";
        $this->db->trans_begin();
        $this->db->where(['msr_no'=>$value]);
        $this->db->update('t_msr',['status'=>$status]);

        $this->db->where(['id'=>$p['t_approval_id']]);
        $this->db->update('t_approval',[
            'created_at' => date("Y-m-d H:i:s"),
            'status' => $p['status'],
            'deskripsi'=> $p['desc'],
        ]);
        if($this->db->trans_status() === true)
        {
            $this->db->trans_commit();
            echo json_encode(['status'=>true, 'msg'=>'Success, MSR Canceled']);
        }
        else
        {
            $this->db->trans_rollback();
            echo json_encode(['status'=>false]);
        }
    }
    public function msrActive($value='')
    {
        if($value)
            return " t_msr.status = 0";
        return $this->db->where(['t_msr.status'=>0]);
    }

    public function approval_list_cancel_msr($msr_no='')
    {
        $approval_list = $this->approval_list()->where(['m_approval.module_kode'=>'msr-reject'])->order_by('urutan','asc')->get();
        $cancel_msr_list_approver = $this->cancel_msr_list_approver($msr_no);
        if($cancel_msr_list_approver->num_rows() > 0)
        {
            $approval_list = $cancel_msr_list_approver;
        }
        return $approval_list;
    }
    public function cancel_msr_list_approver($msr_no='')
    {
        $approval_list = $this->approval_list('m_approval.*,m_user_roles.*,m_approval.id m_approval_id,t_approval.id t_approval_id, t_approval.status, t_approval.created_at, t_approval.deskripsi')
            ->join('t_approval','t_approval.m_approval_id=m_approval.id')
            ->where(['t_approval.data_id'=>$msr_no,'module_kode'=>'msr-reject'])->order_by('t_approval.urutan','asc')->get();
        return $approval_list;
    }
    public function add_on_pc_approval_list_ed($edapproved)
    {
        $result = $edapproved;
        $msr_no_array = [];
        foreach ($edapproved as $r) {
            $msr_no_array[] = $r->data_id;
        }
        // echo "<pre>";
        // print_r($data['edapproved']);
        // echo $this->db->last_query();
        $sql = "select data_id from t_approval WHERE m_approval_id = 13 and status = 5";
        $q = $this->db->where(['status'=>0])->where('msr_no in','('.$sql.')', false)->get('t_msr')->result();
        $t_approval_id = [];
        foreach ($q as $r) {
            $eq = $this->db->where(['status'=>1, 'msr_no'=>$r->msr_no, 'award'=>0])->get('t_eq_data')->row();
            if($eq)
            {
                $reject = $this->db->where(['status'=>2,'data_id'=>$eq->msr_no,'m_approval_id'=>12])->get('t_approval');
                if($reject->num_rows() > 0)
                {

                }
                else
                {
                    $sql = "select * from t_approval where data_id = '$eq->msr_no' and m_approval_id between 7 and 11 and status = 0";

                    $t_approval  = $this->db->query($sql);
                    if($t_approval->num_rows() > 0)
                    {
                        /*kalo ada yang 0*/
                    }
                    else
                    {
                        $pc = $this->db->where([
                            'created_by'=>$this->session->userdata('ID_USER'),
                            'm_approval_id'=>12,
                            'status'=>0,
                            'data_id'=>$eq->msr_no
                        ]);
                        if(count($msr_no_array) > 0)
                        {
                            $pc = $pc->where_not_in('data_id',$msr_no_array);
                        }
                        $pc = $pc->get('t_approval')->row();

                        if($pc)
                        {
                            $t_approval_id[] = $pc->id;
                            // echo "'".$pc->data_id."'";
                            // echo ",";
                        }
                    }
                }
            }
        }

        if(count($t_approval_id) > 0)
        {
            $edProcCommitte = $this->db->select("t_approval.*, t_assignment.user_id as id_procurement_specialist, procurement_specialist.NAME as procurement_specialist, t_eq_data.closing_date")
            ->join('t_assignment','t_assignment.msr_no = t_approval.data_id')
            ->join('m_user procurement_specialist','procurement_specialist.ID_USER = t_assignment.user_id')
            ->join('t_eq_data','t_eq_data.msr_no = t_approval.data_id')
            ->where_in('t_approval.id',$t_approval_id)
            ->get('t_approval')->result();
            /*echo $this->db->last_query();
            exit();*/
            // print_r($edProcCommitte);
            foreach ($t_approval_id as $key => $value) {

            }
            $newEd = array_merge($edProcCommitte,$edapproved);
            // print_r($newEd);
            $newEd_1 = [];
            foreach ($newEd as $key => $value) {
                $newEd_1[$value->data_id] = $value;
            }
            krsort($newEd_1);
            // print_r($newEd_1);
            $result = $newEd_1;
        }
        return $result;
    }
}