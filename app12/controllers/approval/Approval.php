<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Approval extends CI_Controller
{
    /* Part 1
    * ed administration & technical
    * administrative : 0 default & reject; 1: evaluation adm; 3: approval eva adm; 4: ackevaadm
    * technical : 0 default & reject; 1: evaluation tech; 3: approval eva tech; 4: ackevatech
    */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('string', 'text'));
        $this->load->model('approval/M_approval');
        $this->load->model('vendor/M_send_invitation')->model('vendor/M_vendor');
        $this->load->model('setting/M_master_department');
        $this->load->model('procurement/M_msr', 'msr');
        $this->load->model('approval/M_bl');
        $this->load->model('approval/T_upload');
        $this->load->model('procurement/M_msr_item', 'msr_item');
        $this->load->model('procurement/M_msr_attachment', 'msr_attachment');
        $this->load->model('user/M_view_user');
        $this->load->helper('exchange_rate_helper')->helper(array('form', 'array', 'url', 'exchange_rate'));
        $this->load->model('vn/info/M_vn', 'mvn');
        $this->load->model('m_base');
        $this->load->model('procurement/arf/m_arf_assignment');
        $get_menu = $this->M_vendor->menu();
        $this->dt = array();
        foreach ($get_menu as $k => $v) {
            $this->dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $this->dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $this->dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $this->dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        /*$data['menu'] = $dt;*/
    }

    public function greetings($value = '')
    {
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;

        $greetings = $this->M_approval->greetings_msr();
        $data['greetings'] = $greetings;
        $this->template->display('approval/greetings', $data);
    }

    public function list($moduleKode = '', $dataId = '')
    {
        $rows = $this->M_approval->list($moduleKode, $dataId);
        $data['rows'] = $rows;
        $userId = $this->session->userdata('ID_USER');
        $cek = $this->db->where('ID_USER', $userId)->get('m_user')->row();
        $roles = explode(",", $cek->ROLES);
        $data['roles'] = array_values(array_filter($roles));
        $data['data_id'] = $dataId;

        $this->load->view('approval/list', $data);
    }

    public function approve()
    {
        $result = $this->M_approval->approve();
        if ($result) {
            $data = $this->input->post();

            $module_kode = $data['module_kode'];

            if ($module_kode == 'msr') {
                $msg = 'MSR';
            } elseif ($module_kode == 'award') {
                $msg = 'AWARD';
            } else {
                $msg = 'ED';
            }

            // $msg = $data['module_kode'] == 'msr' ? 'MSR':'ED';
            $getApprovalList = $this->approval_lib->getApprovalList($data['data_id'], 'msr');
            if ($msg == 'ED') {
                $getApprovalList = $this->approval_lib->getApprovalList($data['data_id'], 'ed');
            }
            if ($msg == 'AWARD') {
                $getApprovalList = $this->approval_lib->getApprovalList($data['data_id'], 'award');
            }

            if ($getApprovalList->num_rows() > 0) {
                $msg = $this->input->get('issued') ? $msg . ' Issued' : $msg . ' Approved';
                if ($module_kode == 'award') {
                    $process_award = $this->M_approval->process_award(true);
                    if ($process_award['status'] == 'Issued Award Notification') {
                        // $msg = $process_award['status'];
                        $msg = 'Approved';
                    }
                }
                echo json_encode(['msg' => $msg, 'status' => true]);
            } else {
                /**/
                $desc = $this->input->get('issued') ? $msg . ' Issued' : $msg . ' Approved';
                $t_approval = $this->db->where(['id' => $this->input->post('id')])->get('t_approval')->row();
                if ($this->input->post('module_kode') == 'msr_spa' and $t_approval->m_approval_id == 7) {
                    $desc = $data['status'] == 1 ? "MSR Verified" : "Reject";
                }
                if ($module_kode == 'award') {
                    $process_award = $this->M_approval->process_award(true);
                    if ($process_award['status'] == 'Issued Award Notification') {
                        $desc = 'Approved';
                        // $desc = $process_award['status'];
                    }
                }
                echo json_encode(['msg' => $desc]);
            }

            $rs = $this->db->select('t_approval.*,m_approval.module_kode')
                ->where(['t_approval.id' => $data['id'], 't_approval.status' => "1"])
                ->join('m_approval', 'm_approval.id = t_approval.m_approval_id')
                ->get('t_approval')->row();
            @$module_kode = $rs->module_kode;
            @$urutan1 = $rs->urutan;
            if ($module_kode == 'msr') {
                $q = "select max(urutan) urutan from t_approval WHERE data_id = '" . $data['data_id'] . "'";
                $rs = $this->db->query($q)->row();
                $urutan2 = $rs->urutan;

                $checkAllMsrApprove = $this->M_approval->checkAllMsrApprove($data['data_id']);

                // if($urutan1 == $urutan2)
                if ($checkAllMsrApprove->num_rows() == 0) {
                    $this->generate_msr_spa($data['data_id']);

                    // Send Email ke PS Untuk Verify MSR
                    ini_set('max_execution_time', 300);
                    $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
                    $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";


                    $query = $this->db->query("SELECT us.EMAIL AS recipient, us.NAME, ntf.TITLE, ntf.OPEN_VALUE, ntf.CLOSE_VALUE FROM t_approval ta
                    JOIN m_approval ma ON ma.id = ta.m_approval_id AND ma.urutan = 1
                    JOIN m_user us ON us.ID_USER = ta.created_by
                    JOIN m_notic ntf ON ntf.ID = 36
                    WHERE ma.module_kode = 'msr_spa' AND ta.data_id = '" . $data["data_id"] . "'");

                    if ($query->num_rows() > 0) {
                        $data_role = $query->result();
                        $count = 1;
                    } else {
                        $count = 0;
                    }

                    if ($count === 1) {

                        $query = $this->db->query("SELECT distinct t.title,u.NAME,d.DEPARTMENT_DESC from t_msr t
                        join m_user u on u.id_user=t.create_by
                        join m_departement d on d.ID_DEPARTMENT=u.ID_DEPARTMENT
                        where msr_no='" . $data["data_id"] . "' ");

                        $data_replace = $query->result();

                        $str = $data_role[0]->OPEN_VALUE;
                        $str = str_replace('_var1_', $data_replace[0]->title, $str);
                        $str = str_replace('_var2_', $data_replace[0]->NAME, $str);
                        $str = str_replace('_var3_', $data_replace[0]->DEPARTMENT_DESC, $str);
                        $str = str_replace('_var4_', $data["data_id"], $str);

                        $data = array(
                            'img1' => $img1,
                            'img2' => $img2,
                            'title' => $data_role[0]->TITLE,
                            'open' => $str,
                            'close' => $data_role[0]->CLOSE_VALUE
                        );

                        foreach ($data_role as $k => $v) {
                            $data['dest'][] = $v->recipient;
                        }
                        $flag = $this->sendMail($data);

                    }

                    //End Send Email

                } else {
                    $rs = $this->db->where(['t_approval.id' => $data['id'], 't_approval.status' => "1"])
                        ->get('t_approval')->row();
                    $urutannext = $rs->urutan + 1;

                    //Send Email
                    ini_set('max_execution_time', 300);
                    $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
                    $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";


                    $query = $this->db->query("SELECT distinct u.email as recipient,n.TITLE,n.OPEN_VALUE,n.CLOSE_VALUE FROM t_approval t
                        join m_approval m on m.id=t.m_approval_id and m.module_kode='msr'
                        join m_user u on u.id_user = t.created_by
                        join m_notic n on n.ID=35
                        where t.data_id='" . $data["data_id"] . "' and t.urutan=" . $urutannext);
                    if ($query->num_rows() > 0) {
                        $data_role = $query->result();
                        $count = 1;
                    } else {
                        $count = 0;
                    }

                    if ($count === 1) {

                        $query = $this->db->query("SELECT distinct t.title,u.NAME,d.DEPARTMENT_DESC from t_msr t
                        join m_user u on u.id_user=t.create_by
                        join m_departement d on d.ID_DEPARTMENT=u.ID_DEPARTMENT
                        where msr_no='" . $data["data_id"] . "' ");

                        $data_replace = $query->result();

                        $res = $data_role;
                        $str = $data_role[0]->OPEN_VALUE;
                        $str = str_replace('_var1_', $data_replace[0]->title, $str);
                        $str = str_replace('_var2_', $data_replace[0]->NAME, $str);
                        $str = str_replace('_var3_', $data_replace[0]->DEPARTMENT_DESC, $str);
                        $str = str_replace('_var4_', $data["data_id"], $str);

                        $data = array(
                            'img1' => $img1,
                            'img2' => $img2,
                            'title' => $data_role[0]->TITLE,
                            'open' => $str,
                            'close' => $data_role[0]->CLOSE_VALUE
                        );

                        foreach ($data_role as $k => $v) {
                            $data['dest'][] = $v->recipient;
                        }
                        $flag = $this->sendMail($data);

                    }

                    //End Send Email

                }
            } else if ($module_kode == 'msr_spa') {

                $rs = $this->db->where(['t_approval.id' => $data['id']])
                    ->get('t_approval')->row();
                $urutan = $rs->urutan;
                $urutannext = $rs->urutan + 1;
                $listApproval = $this->M_approval->listApprovalED($data["data_id"])->num_rows();
                $approved = $this->M_approval->listApprovedED($data["data_id"])->num_rows();

                //Send Email
                ini_set('max_execution_time', 300);
                $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
                $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";
                if ($approved < $listApproval) {
                    if ($urutannext == 2) {
                        $query = $this->db->query("SELECT distinct u.email as recipient,n.TITLE,n.OPEN_VALUE,n.CLOSE_VALUE FROM t_approval t
                        join m_approval m on m.id=t.m_approval_id and m.module_kode='msr_spa'
                        join m_user u on t.created_by = u.ID_USER
                        join m_notic n on n.ID=50
                        where t.data_id='" . $data["data_id"] . "' and t.urutan=" . $urutannext);
                    } else {
                        $roleApp = $this->db->query("SELECT * FROM t_approval JOIN m_approval ON m_approval.id = t_approval.m_approval_id WHERE t_approval.m_approval_id in (8,9,10,11,12) AND t_approval.urutan = " . $urutan)->row();
                        $nextrole = $this->db->query("SELECT * FROM t_approval JOIN m_approval ON m_approval.id = t_approval.m_approval_id WHERE m_approval_id in (8,9,10,11,12) AND t_approval.urutan = " . $urutannext)->row();
                        if ($roleApp->role_id != 27) {
                            $query = $this->db->query("SELECT u.email as recipient,n.TITLE,n.OPEN_VALUE,n.CLOSE_VALUE FROM t_approval t
                            JOIN m_approval m on m.id=t.m_approval_id and m.module_kode='msr_spa'
                            JOIN m_user u on u.ID_USER = t.created_by
                            JOIN m_notic n on n.ID = 52
                            WHERE t.data_id='" . $data["data_id"] . "' and t.urutan=" . $urutannext);
                            if ($nextrole->role_id = 27) {
                                $query = $this->db->query("SELECT t_approval.*, t_msr.title as msr_title, (SELECT m_departement.DEPARTMENT_DESC FROM m_user JOIN m_departement ON m_user.ID_DEPARTMENT = m_departement.ID_DEPARTMENT WHERE m_user.ID_USER = t_msr.create_by ) AS departement, (SELECT m_user.NAME FROM m_user WHERE m_user.ID_USER = t_msr.create_by ) AS requestor, m_user_roles.DESCRIPTION role_name, m_user.NAME user_nama, m_user.EMAIL as recipient, m_notic.TITLE, m_notic.OPEN_VALUE, m_notic.CLOSE_VALUE
                                FROM t_approval
                                LEFT JOIN m_approval on m_approval.id = t_approval.m_approval_id
                                LEFT JOIN m_user_roles on m_approval.role_id = m_user_roles.ID_USER_ROLES
                                LEFT JOIN m_user on m_user.ID_USER = t_approval.created_by
                                LEFT JOIN m_notic ON m_notic.ID = 52
                                LEFT JOIN t_msr ON t_msr.msr_no = t_approval.data_id
                                WHERE data_id = '" . $data['data_id'] . "' AND m_approval_id in (8,9,10,11,12) AND m_approval.urutan >= 5");
                            }
                        }
                    }

                    if (isset($query)){
                        if ($query->num_rows() > 0) {
                            $data_role = $query->result();
                            $count = 1;
                        } else {
                            $count = 0;
                        }

                        if ($count === 1) {

                            $query = $this->db->query("SELECT distinct t.title , u.NAME, d.DEPARTMENT_DESC from t_msr t
                            join m_user u on u.id_user=t.create_by
                            join m_departement d on d.ID_DEPARTMENT=u.ID_DEPARTMENT
                            where t.msr_no='" . $data["data_id"] . "'");

                            $data_replace = $query->result();
                            $edno = str_replace('R', 'Q', $data['data_id']);

                            $str = $data_role[0]->OPEN_VALUE;
                            $str = str_replace('_var1_', $data_replace[0]->title, $str);
                            $str = str_replace('_var2_', $data_replace[0]->NAME, $str);
                            $str = str_replace('_var3_', $data_replace[0]->DEPARTMENT_DESC, $str);
                            $str = str_replace('_var4_', $edno, $str);

                            $data = array(
                                'img1' => $img1,
                                'img2' => $img2,
                                'title' => $data_role[0]->TITLE,
                                'open' => $str,
                                'close' => $data_role[0]->CLOSE_VALUE
                            );

                            foreach ($data_role as $k => $v) {
                                $data['dest'][] = $v->recipient;
                            }
                            $flag = $this->sendMail($data);
                        }
                    }
                } else if ($approved = $listApproval) {
                    //Confirmation For Bidder List Ready for Issuance
                    $query1 = $this->db->query("SELECT m_user.EMAIL AS recipient, t_eq_data.msr_no, m_notic.TITLE, m_notic.OPEN_VALUE, m_notic.CLOSE_VALUE FROM t_eq_data
                    JOIN m_user ON m_user.ID_USER = t_eq_data.created_by
                    LEFT JOIN m_notic ON m_notic.ID = 37
                    WHERE msr_no = '" . $data['data_id'] . "'");

                    if (isset($query1)) {
                        $data_role = $query1->result();

                        $data_replace1 = $this->db->query("SELECT distinct e.subject as title,u.NAME,d.DEPARTMENT_DESC from t_msr t
                        join m_user u on u.id_user=t.create_by
                        join t_eq_data e on e.msr_no = t.msr_no
                        join m_departement d on d.ID_DEPARTMENT=u.ID_DEPARTMENT
                        where t.msr_no='" . $data["data_id"] . "'")->result();

                        $edno = str_replace('R', 'Q', $data["data_id"]);
                        $xh = $data_role[0]->OPEN_VALUE;
                        $xh = str_replace('_var1_', $data_replace1[0]->title, $xh);
                        $xh = str_replace('_var2_', $data_replace1[0]->NAME, $xh);
                        $xh = str_replace('_var3_', $data_replace1[0]->DEPARTMENT_DESC, $xh);
                        $xh = str_replace('_var4_', $edno, $xh);

                        $data1 = array(
                            'img1' => $img1,
                            'img2' => $img2,
                            'title' => $data_role[0]->TITLE,
                            'open' => $xh,
                            'close' => $data_role[0]->CLOSE_VALUE
                        );

                        foreach ($data_role as $k => $v) {
                            $data1['dest'][] = $v->recipient;
                        }
                        $flag1 = $this->sendMail($data1);
                    }
                } else {
                    //Notification For Bid Supplier
                    $query = $this->db->query("SELECT DISTINCT notif.OPEN_VALUE, notif.CLOSE_VALUE, notif.TITLE, msr.company_desc, ed.subject AS titlemsr, ed.msr_no, vnd.ID_VENDOR AS recipient FROM t_bl_detail bl
                    JOIN t_eq_data ed ON bl.msr_no = ed.msr_no
                    JOIN t_msr msr ON msr.msr_no = ed.msr_no
                    JOIN m_user us ON us.ID_USER = ed.created_by
                    JOIN m_vendor vnd ON vnd.ID = bl.vendor_id
                    JOIN m_notic notif ON notif.ID = 38
                    WHERE ed.msr_no = '" . $data["data_id"] . "'");

                    $data_replace = $query->result();

                    $str = $data_replace[0]->OPEN_VALUE;
                    $str = str_replace('_var1_', $data_replace[0]->company_desc, $str);
                    $str = str_replace('_var2_', $data_replace[0]->titlemsr, $str);
                    $str = str_replace('_var3_', str_replace('R', 'Q', $data_replace[0]->msr_no), $str);

                    $data = array(
                        'img1' => $img1,
                        'img2' => $img2,
                        'title' => $data_replace[0]->TITLE,
                        'open' => $str,
                        'close' => $data_replace[0]->CLOSE_VALUE
                    );

                    foreach ($data_replace as $k => $v) {
                        $data['dest'][] = $v->recipient;
                    }
                    $flag = $this->sendMail($data);
                }
            } else if ($module_kode == 'award') {
                $rs = $this->db->where(['t_approval.id' => $data['id']])
                    ->get('t_approval')->row();
                $listApproval = $this->M_approval->listApprovalAward($data['data_id'])->num_rows();
                $listApproved = $this->M_approval->listApprovedAward($data['data_id'])->num_rows();
                $urutan = $rs->urutan;
                $urutannext = $rs->urutan + 1;
                if ($listApproved < $listApproval) {
                    if ($urutan != $urutannext) {
                        $query = $this->db->query("SELECT ed.msr_no, ed.subject, us.EMAIL as recipient, us.NAME, n.TITLE AS title, n.OPEN_VALUE AS open, n.CLOSE_VALUE AS close FROM t_approval ap
                        JOIN m_approval mp ON ap.m_approval_id = mp.id
                        JOIN t_eq_data ed ON ap.data_id = ed.msr_no
                        JOIN m_user us ON us.ID_USER = ap.created_by
                        JOIN m_notic n ON n.ID = 68
                        WHERE ap.data_id = '" . $data['data_id'] . "' AND mp.module_kode = 'award' AND mp.urutan = " . $urutannext);
                        $data_replace = $query->result();
                        $img1 = '';
                        $img2 = '';

                        $str = $data_replace[0]->open;
                        $str = str_replace('_var1_', str_replace('R', 'Q', $data_replace[0]->msr_no), $str);
                        $str = str_replace('_var2_', $data_replace[0]->subject, $str);

                        $data = array(
                            'img1' => $img1,
                            'img2' => $img2,
                            'title' => $data_replace[0]->title,
                            'open' => $str,
                            'close' => $data_replace[0]->close
                        );

                        foreach ($data_replace as $v) {
                            $data['dest'][] = $v->recipient;
                        }
                        $flag = $this->sendMail($data);
                    }
                }
            }
            $this->session->set_flashdata('message', array(
                'message' => __('success_approve'),
                'type' => 'success'
            ));
        } else {
            echo json_encode(['msg' => 'Something Wrong, Please Try Again']);
        }
    }

    public function reject()
    {
        $result = $this->M_approval->reject();
        if ($result) {
            $this->session->set_flashdata('message', array(
                'message' => __('success_reject'),
                'type' => 'success'
            ));
            $img1 = '';
            $img2 = '';
            $query = $this->db->query('SELECT msr.msr_no, u.EMAIL, n.TITLE, n.OPEN_VALUE, n.CLOSE_VALUE FROM t_msr msr
            JOIN m_user u ON u.ID_USER = msr.create_by
            JOIN m_notic n ON n.ID = 86
            WHERE msr.msr_no = "' . $this->input->post('data_id') . '"');
            $data_replace = $query->result();
            $str = $data_replace[0]->OPEN_VALUE;
            $str = str_replace('no_msr', $data_replace[0]->msr_no, $str);

            $data = array(
                'img1' => $img1,
                'img2' => $img2,
                'title' => $data_replace[0]->TITLE,
                'open' => $str,
                'close' => $data_replace[0]->CLOSE_VALUE
            );
            $data['dest'][] = $data_replace[0]->EMAIL;
            $this->sendMail($data);
            echo json_encode(['msg' => 'MSR Successfully Rejected']);
        } else {
            echo json_encode(['msg' => 'Something Wrong, Please Try Again']);
        }
    }

    public function index($moduleKode = '', $dataId = '')
    {
        $rows = $this->M_approval->list($moduleKode, $dataId);
        $data['rows'] = $rows;
        $userId = $this->session->userdata('ID_USER');
        $cek = $this->db->where('ID_USER', $userId)->get('m_user')->row();
        $roles = explode(",", $cek->ROLES);
        $data['roles'] = array_values(array_filter($roles));
        $data['data_id'] = $dataId;

        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $data['module_kode'] = $moduleKode;
        $data['msr'] = $this->db->where('msr_no', $dataId)->get('t_msr')->row();
        $this->template->display('approval/list', $data);
    }

    public function check_cost_center($msr_kode = '')
    {
        $check_cost_center = $this->M_approval->check_cost_center($msr_kode);
        if ($check_cost_center['msr_item_costcenter']->num_rows() > 0) {
            /*ada yang other cost center*/

        } else {
            /*tanpa other cost center
            *kalau tanpa other cost center langsung insert table approval status = 3 di level selanjutnya
            */
        }
    }

    public function mylist($value = '')
    {
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;

        $greetings = $this->M_approval->greetings_msr();
        $data['greetings'] = $greetings;
        $this->template->display('approval/mylist', $data);
    }

    public function generate_msr_approval($msr_no = '')
    {
        $this->db->trans_begin();
        $m_approval = $this->db->where(['module_kode' => 'msr', 'aktif' => 1])->order_by('urutan', 'asc')->get('m_approval');
        $i = 1;
        $msr = $this->db->where(['msr_no' => $msr_no])->get('t_msr')->row();

        // $user = user();
        $user = $this->db->where(['ID_USER' => $msr->create_by])->get('m_user')->row();
        foreach ($m_approval->result() as $r) {
            /*MSR01 MATERIAL = MSR02 SERVICE*/
            if ($r->opsi == 'bh' or $r->opsi == 'ic') {
                if ($r->opsi == 'bh') {
                    /*cek ada cost center selain yang dia punya gak*/
                    $msrItems = $this->db->select('id_costcenter')->where(['msr_no' => $msr->msr_no])->where('id_costcenter !=', $user->COST_CENTER)->group_by('id_costcenter')->get('t_msr_item');
                    /*kalo ada insert untuk approval*/
                    if ($msrItems->num_rows() > 0) {
                        /*approval sebanyak yang punya budget holder*/
                        foreach ($msrItems->result() as $msrItem) {
                            // id_costcenter
                            $m_user = $this->db->where(['cost_center' => $msrItem->id_costcenter])->get('m_budget_holder')->row();
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
                if ($r->opsi == 'ic') {
                    $sql = "select * from m_user where ROLES like '%19%'";
                    $a = $this->db->query($sql)->row();
                    $ic = $a->ID_USER;

                    if ($msr->id_msr_type == 'MSR01') {
                        $data['m_approval_id'] = $r->id;
                        $data['data_id'] = $msr->msr_no;
                        $data['created_by'] = $ic;
                        // $data['deskripsi'] = 'ic MSR01';
                        $data['urutan'] = $i++;
                        $this->db->insert('t_approval', $data);
                    } elseif ($msr->id_msr_type == 'MSR02') {
                        /*cek awalau msr service kalo ada material, maka harus lewat IC*/
                        $msrItems = $this->db->where(['msr_no' => $msr->msr_no])->where_in('id_itemtype', ['GOODS', 'BLANKET'])->get('t_msr_item');
                        if ($msrItems->num_rows() > 0) {
                            $data['m_approval_id'] = $r->id;
                            $data['data_id'] = $msr->msr_no;
                            $data['created_by'] = $ic;
                            // $data['deskripsi'] = 'ic MSR02';
                            $data['urutan'] = $i++;
                            $this->db->insert('t_approval', $data);
                        }
                    }
                }
            } else {
                if ($r->opsi == 'user_manager') {
                    /*t_jabatan*/
                    $t_jabatan = $this->db->where(['user_id' => $msr->create_by])->get('t_jabatan')->row();
                    $s = $this->db->where(['id' => $t_jabatan->parent_id])->get('t_jabatan')->row();
                    /*cek di m_user*/
                    $msr_company = trim($msr->id_company);
                    $q = "select * from m_user where ID_USER  = $s->user_id and COMPANY like '%$msr_company%'";
                    if ($this->db->query($q)->num_rows() > 0) {

                    } else {
                        $s = $this->db->where(['first' => 1])->get('t_jabatan')->row();
                    }
                    /*parent_id/atasannya untuk user yang approve*/
                    $data['m_approval_id'] = $r->id;
                    $data['data_id'] = $msr->msr_no;
                    $data['created_by'] = $s->user_id;
                    $data['urutan'] = $i++;
                    $this->db->insert('t_approval', $data);
                }
                if ($r->opsi == 'aas') {
                    $total_amount = $msr->total_amount_base;
                    /*if($msr->id_currency == 1)
                    {
                        $total_amount = $msr->total_amount/10000;
                    }*/
                    $aas = $this->firstAas($total_amount, $msr->create_by);
                    /*cek di m_user*/
                    $msr_company = trim($msr->id_company);
                    $q = "select * from m_user where ID_USER  = $aas->user_id and COMPANY like '%$msr_company%'";
                    if ($this->db->query($q)->num_rows() > 0) {

                    } else {
                        $aas = $this->db->where(['first' => 1])->get('t_jabatan')->row();
                    }
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
                if ($r->opsi == 'bsd_staff') {
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
                if ($r->opsi == 'vip_bsd') {
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
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }

    public function generate_msr_spa($msr_no = '')
    {

        $ceking = "select * from t_approval where data_id = '$msr_no' and m_approval_id in (7,8,9,10,11,12,13)";
        $cek = $this->db->query($ceking);
        if ($cek->num_rows() > 0) {
            return true;
            exit();
        }
        $this->db->trans_begin();
        $m_approval = $this->db->where(['module_kode' => 'msr_spa', 'aktif' => 1])->order_by('urutan', 'asc')->get('m_approval');
        $user = user();
        $i = 1;
        $msr = $this->db->where(['msr_no' => $msr_no])->get('t_msr')->row();
        $total_amount = $msr->total_amount_base;
        /*$total_amount = $msr->total_amount;
        if($msr->id_currency == 1)
        {
            @$total_amount = $total_amount/10000;
        }*/
        // $sos = $query->jml > 500000 ? true : false;

        foreach ($m_approval->result() as $r) {
            if ($r->role_id == 25) {
                if ($total_amount >= 500000) {
                    /**/
                    $q = "SELECT * FROM `m_user` WHERE ROLES like '%25%'";
                    $a = $this->db->query($q)->row();
                    $data['m_approval_id'] = $r->id;
                    $data['data_id'] = $msr_no;
                    $data['created_by'] = $a->ID_USER;
                    $data['urutan'] = $i++;
                    $this->db->insert('t_approval', $data);
                }
            } elseif ($r->role_id == proc_committe) {
                // pcApprove 1 chairman 4 member
                $tbmsr = $this->M_bl->getTbmsr($msr_no)->row();
                $in = false;
                if ($tbmsr->total_amount_base <= 10000) {
                    $in = true;
                }
                foreach (pcApprove($in) as $pcApproveUserId) {
                    $data['m_approval_id'] = $r->id;
                    $data['data_id'] = $msr_no;
                    $data['created_by'] = $pcApproveUserId;
                    $data['urutan'] = $i++;
                    $this->db->insert('t_approval', $data);
                }
            } elseif ($r->role_id == user_representative) {
                /*user_representative get creator msr*/
                $tbmsr = $this->M_bl->getTbmsr($msr_no)->row();
                $data['m_approval_id'] = $r->id;
                $data['data_id'] = $msr_no;
                $data['created_by'] = $tbmsr->create_by;
                $data['urutan'] = $i++;
                $this->db->insert('t_approval', $data);
            } elseif ($r->role_id == user_manager) {
                /*user_manager get user manager dari t_approval msr*/
                $approvalUserManager = $this->approval_lib->getApprovalUserManager($msr_no)->row();
                $data['m_approval_id'] = $r->id;
                $data['data_id'] = $msr_no;
                $data['created_by'] = $approvalUserManager->created_by;
                $data['urutan'] = $i++;
                $this->db->insert('t_approval', $data);
            } else {
                if ($r->role_id == 9) {
                    $m_user = $this->db->query("select * from m_user where roles like '%,9,%'")->row();
                } else {
                    $m_user = $this->db->query("select * from m_user where roles like '%$r->role_id%'")->row();
                }
                $user_id = $m_user ? $m_user->ID_USER : $user->id;

                $data['m_approval_id'] = $r->id;
                $data['data_id'] = $msr_no;
                $data['created_by'] = $user_id;
                $data['urutan'] = $i++;
                $this->db->insert('t_approval', $data);
            }
        }
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }

    public function assignment($value = '')
    {
        $data = $this->input->post();
        $user = user();

        $datax['status'] = 4;
        $datax['deskripsi'] = $data['deskripsi'];

        $this->db->where('id', $data['t_approval_id']);
        $result = $this->db->update('t_approval', $datax);

        $this->approval_lib->log([
            'module_kode' => 'msr',
            'data_id' => $data['msr_no'],
            'description' => 'MSR Assigned',
            'keterangan' => $data['deskripsi'],
            'created_by' => $this->session->userdata('ID_USER')
        ]);

        $assign['user_id'] = $data['user_id'];
        $assign['msr_no'] = $data['msr_no'];
        $assign['msr_type'] = $data['msr_type'];
        $assign['proc_method'] = $data['proc_method'];
        $assign['deskripsi'] = $data['deskripsi'];
        $assign['updated_by'] = $this->session->userdata('ID_USER');
        $this->db->insert('t_assignment', $assign);
        /*update t_msr*/

        $m_msrtype = $this->db->where(['ID_MSR' => $data['msr_type']])->get('m_msrtype')->row();
        $msr_type_desc = $m_msrtype->MSR_DESC;

        $m_pmethod = $this->db->where(['ID_PMETHOD' => $data['proc_method']])->get('m_pmethod')->row();
        $pmethod_desc = $m_pmethod->PMETHOD_DESC;

        //$this->db->where(['msr_no'=>$data['msr_no']]);
        /*$this->db->update('t_msr', [
            'id_msr_type'   => $data['msr_type'],
            'msr_type_desc' => $msr_type_desc,
            'id_pmethod'    => $data['proc_method'],
            'pmethod_desc'  => $pmethod_desc]
        );*/

        if ($result) {
            echo json_encode(['msg' => 'MSR Assigned']);
            //Send Email
            ini_set('max_execution_time', 300);
            $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
            $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";

            /*get MSR*/
            $msr = $this->db->select('title')->where('msr_no', $data['msr_no'])->get('t_msr')->row();

            $query = $this->db->query("SELECT distinct u.NAME,d.DEPARTMENT_DESC,u.email as recipient,n.TITLE,n.OPEN_VALUE,n.CLOSE_VALUE FROM m_user u
                        join m_notic n on n.ID=51
                        join m_departement d on d.ID_DEPARTMENT=u.ID_DEPARTMENT
                        where  u.id_user='" . $data['user_id'] . "' ");
            if ($query->num_rows() > 0) {
                $data_role = $query->result();
                $count = 1;
            } else {
                $count = 0;
            }

            if ($count === 1) {
                $q = $this->db->query("SELECT distinct t.title,u.NAME,d.DEPARTMENT_DESC from t_msr t
                        join m_user u on u.id_user=t.create_by
                        join m_departement d on d.ID_DEPARTMENT=u.ID_DEPARTMENT
                        where msr_no='" . $data['msr_no'] . "' ");
                $rs = $q->row();

                $res = $data_role;
                $str = $data_role[0]->OPEN_VALUE;
                $str = str_replace('_var1_', $msr->title, $str);
                $str = str_replace('_var2_', $rs->NAME, $str);
                $str = str_replace('_var3_', $rs->DEPARTMENT_DESC, $str);
                $str = str_replace('_var4_', $data['msr_no'], $str);

                $data = array(
                    'img1' => $img1,
                    'img2' => $img2,
                    'title' => $data_role[0]->TITLE,
                    'open' => $str,
                    'close' => $data_role[0]->CLOSE_VALUE
                );

                foreach ($data_role as $k => $v) {
                    $data['dest'][] = $v->recipient;
                }
                $flag = $this->sendMail($data);

            }

            //End Send Email
            $this->session->set_flashdata('message', array(
                'message' => __('success_submit'),
                'type' => 'success'
            ));

        } else {
            echo json_encode(['msg' => 'Something Wrong, Please Try Again']);
        }
    }

    public function addbl($value = '')
    {
        $data = $this->input->post();
        $msr_no = $data['bl_msr_no'];

        $user = user();
        $xdata['vendor_id'] = $data['bl_vendor'];
        $xdata['msr_no'] = $data['bl_msr_no'];
        $xdata['created_by'] = $user->ID_USER;
        $this->db->insert('t_bl_detail', $xdata);

        $this->dtBlSession($xdata['msr_no']);
    }

    public function removebl($id = '')
    {
        $this->db->where('id', $id);
        $this->db->delete('t_bl_detail');

        $this->dtBlSession($xdata);
    }

    public function dtBlSession($msr_no = '', $delete = 1)
    {
        $no = 1;
        $tb = '';

        foreach ($this->db->where('msr_no', $msr_no)->get('t_bl_detail')->result() as $key => $value) {
            $vendor = $this->db->where('ID', $value->vendor_id)->get('m_vendor')->row();
            $address = $this->db->where(['BRANCH_TYPE' => 'KANTOR PUSAT', 'ID_VENDOR' => $value->vendor_id])->get('m_vendor_address')->row();
            $alamatKantor = @$address->ADDRESS;
            $contact = $this->db->where(['KEYS' => 1, 'ID_VENDOR' => $value->vendor_id])->get('m_vendor_contact')->row();
            $contactName = @$contact->NAMA;
            $contactMobile = @$contact->TELP;
            $contactEmail = @$contact->EMAIL;
            if ($vendor) {
                $tb .= "<tr><td>" . $no++ . "</td>
                <td>$vendor->NAMA</td>
                <td>$vendor->NO_SLKA</td>
                <td>$alamatKantor</td>
                <td>$contactName</td><td>$contactMobile</td><td>$contactEmail</td>";
                if ($delete) {
                    $tb .= "<td class='text-center'><a href='javascript:void()' onclick='hapusBlClick($value->id)' class='btn btn-sm btn-danger'>Delete</a></td>";
                }
                $tb .= "</tr>";
            }
        }
        echo $tb;
    }

    public function savebl($value = '')
    {
        $data = $this->input->post();
        $this->db->trans_begin();
        if ($this->session->userdata('bl')) {
            $blData['title'] = $data['title'];
            $blData['msr_no'] = $data['msr_no'];
            $blData['created_by'] = $this->session->userdata('ID_USER');
            $this->db->insert('t_bl', $blData);
            foreach (json_decode($this->session->userdata('bl'), true) as $key => $value) {
                $blDetail['vendor_id'] = $value;
                $blDetail['msr_no'] = $data['msr_no'];
                $blDetail['created_by'] = $this->session->userdata('ID_USER');
                $this->db->insert('t_bl_detail', $blDetail);
            }
        }
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }

    public function selection($msr_no = '', $approval_id = '')
    {
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;

        if (!($msr = $this->msr->find($msr_no))) {
            show_error('Document not found');
        }

        $creator = user($msr->create_by);
        $creator_dept = $this->M_master_department->findByDeptAndCompany($creator->ID_DEPARTMENT, $msr->id_company);
        $_POST['create_by'] = @$msr->create_by;
        $_POST['create_by_name'] = @$creator->NAME;
        $_POST['create_on'] = $msr->create_on;
        $_POST['creator_department_name'] = @$creator_dept->DEPARTMENT_DESC;

        $greetings = $this->M_approval->greetings_msr();
        /*$_POST['id_currency'] = $msr->id_currency;
        $_POST['currency_desc'] = @$this->currency->find($msr->id_currency)->CURRENCY;*/
        $data['id_currency'] = $msr->id_currency;
        $data['currency_desc'] = @$this->db->where('id', $msr->id_currency)->get('m_currency')->row()->CURRENCY;
        $data['greetings'] = $greetings;
        $data['idnya'] = $approval_id;
        $data['msr_no'] = $msr_no;
        $data['msr'] = $this->db->select('t_msr.*,m_company.DESCRIPTION company_name,m_msrtype.MSR_DESC msr_name, m_plocation.PGroup_Desc proc_location_name, t_msr.costcenter_desc cost_center_name, m_pmethod.PMETHOD_DESC proc_method_name, m_currency.CURRENCY currency')
            ->join('m_company', 'm_company.ID_COMPANY=t_msr.id_company')
            ->join('m_msrtype', 'm_msrtype.ID_MSR=t_msr.id_msr_type')
            ->join('m_plocation', 'm_plocation.ID_Pgroup=t_msr.id_ploc')
            ->join('m_user', 'm_user.ID_USER=t_msr.create_by')
            ->join('m_costcenter', 'm_costcenter.ID_COSTCENTER=m_user.COST_CENTER')
            ->join('m_pmethod', 'm_pmethod.ID_PMETHOD=t_msr.id_pmethod')
            ->join('m_currency', 'm_currency.ID=t_msr.id_currency')
            ->where('msr_no', $msr_no)->get('t_msr')->row();
        $data['approval'] = $this->db->select('t_approval.*,m_approval.role_id')
            ->join('m_approval', 'm_approval.id=t_approval.m_approval_id')
            ->where('t_approval.id', $approval_id)
            ->get('t_approval')->row();
        $data['readyIssude'] = $this->M_approval->readyIssude($msr_no);
        $data['msr_items'] = $this->M_bl->tbmi2($msr_no);
        $data['items'] = $this->msr_item->getByMsrNo($msr_no);
        $msr_attachment = $this->msr_attachment->getByMsrNo($msr_no);
        $data['attachments'] = $msr_attachment;
        $data['opt_msr_attachment_type'] = $this->msr_attachment->getTypes();
        // echo $this->db->last_query();
        // exit();
        $sq = "select * from t_approval where id = $approval_id";
        $a = $this->db->query($sq)->row();
        if ($a->m_approval_id == 9 or $a->m_approval_id == 23) {
            $data['note'] = false;
        } else {
            $data['note'] = true;
        }
        $data['js'] = $this->load->view('approval/devbledjs', array(), true);
        $this->template->display('approval/selection1', $data);
    }

    public function get_item_costcenter()
    {
        $id = $this->input->post('id');
        $cc = $this->M_approval->get_item_costcenter($id);
        print_r(json_encode($cc[0]));
    }

    public function devbled($msr_no = '', $approval_id = '')
    {
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        $this->load->model('vendor/M_registered_supplier', 'mrs')
            ->model('procurement/M_msr', 'msr')
            ->model('setting/M_itemtype', 'mit')
            ->model('setting/M_itemtype_category', 'mic')
            ->model('setting/M_master_acc_sub', 'mmas')
            ->model('setting/M_master_costcenter', 'mcc');
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;

        $greetings = $this->M_approval->greetings_msr();
        $data['greetings'] = $greetings;
        $data['idnya'] = $approval_id;
        $data['msr_no'] = $msr_no;
        $data['msr'] = $this->db->select('t_msr.*,m_company.DESCRIPTION company_name,m_msrtype.MSR_DESC msr_name, m_plocation.PGroup_Desc proc_location_name, t_msr.costcenter_desc cost_center_name, m_pmethod.PMETHOD_DESC proc_method_name, m_currency.CURRENCY currency')
            ->join('m_company', 'm_company.ID_COMPANY=t_msr.id_company')
            ->join('m_msrtype', 'm_msrtype.ID_MSR=t_msr.id_msr_type')
            ->join('m_plocation', 'm_plocation.ID_Pgroup=t_msr.id_ploc')
            ->join('m_user', 'm_user.ID_USER=t_msr.create_by')
            ->join('m_costcenter', 'm_costcenter.ID_COSTCENTER=m_user.COST_CENTER')
            ->join('m_pmethod', 'm_pmethod.ID_PMETHOD=t_msr.id_pmethod')
            ->join('m_currency', 'm_currency.ID=t_msr.id_currency')
            ->where('msr_no', $msr_no)->get('t_msr')->row();
        $data['approval'] = $this->db->select('t_approval.*,m_approval.role_id')
            ->join('m_approval', 'm_approval.id=t_approval.m_approval_id')
            ->where('t_approval.id', $approval_id)
            ->get('t_approval')->row();
        $data['method'] = $this->db->get('m_pmethod')->result();
        $data['doc'] = $this->db->where(['module_kode' => 'bled', 'data_id' => $msr_no])->get('t_upload')->result();
        $data['t_bl'] = $this->db->where(['msr_no' => $msr_no])->get('t_bl')->row();
        $data['ed'] = $this->db->where(['msr_no' => $msr_no])->get('t_eq_data')->row();
        $data['tbmi2'] = $this->M_bl->tbmi2($msr_no);
        $data['opt_itemtype'] = array_pluck($this->mit->allActive(), 'ITEMTYPE_DESC', 'ID_ITEMTYPE');
        $data['opt_accountsub'] = array_pluck($this->mmas->allActive(), 'ACCSUB_DESC', 'ID_ACCSUB');
        $data['opt_invtype'] = array_pluck($this->msr->m_msr_inventory_type(), 'description', 'id');
        $data['opt_itemtype'] = array('' => 'Please Select') + @$data['opt_itemtype'];
        $data['opt_accountsub'] = array('' => 'Please Select') + @$data['opt_accountsub'];
        $data['opt_invtype'] = array('' => 'Please Select') + @$data['opt_invtype'];

        $data['opt_costcenter'] = array('' => 'Please Select');
        $cc = $this->mcc->find_by_company($data['msr']->id_company);
        if ($cc) {
            foreach ($cc as $key => $value) {
                $data['opt_costcenter'][$value->ID_COSTCENTER] = $value->ID_COSTCENTER . ' - ' . $value->COSTCENTER_DESC;
            }
        }

        $itemtype_category = $this->mic->byParentCategory();
        $data['opt_itemtype_category_by_parent'] = array_map(function ($category) {
            return array_pluck($category, 'description', 'id');
        }, $itemtype_category);
        $data['opt_itemtype_category'] = array_pluck($this->mic->allActive(), 'description', 'id');

        /*print_r($data['ed']);
        exit();*/
        $this->session->set_userdata('referred_from', current_url());
        $data['checkBlEd'] = $this->checkBlEd($msr_no);
        // $data['vendor']  = $this->mrs->show2();
        $data['js'] = $this->load->view('approval/devbledjs', array(), true);
        $this->template->display('approval/devbled', $data);
    }

    public function bledupload($value = '')
    {
        $config['upload_path'] = './userfiles/temp/';
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, TRUE);
        }
        $config['allowed_types'] = '*';
        // $config['max_size']      = '3000';

        // print_r($_FILES['upload']);
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('file_path')) {
            echo $this->upload->display_errors('', '');
            exit;
        } else {
            $user = user();
            $data = $this->upload->data();
            $field = $this->input->post();
            if (!trim($field['file_name'])) {
                $field['file_name'] = biduploadtype($field['tipe'], true);
            }
            $field['file_path'] = $data['file_name'];
            $field['created_by'] = $user->ID_USER;
            $this->db->insert('t_upload', $field);
        }

        $doc = $this->db->where(['module_kode' => 'bled', 'data_id' => $this->input->post('data_id')])->get('t_upload')->result();

        foreach ($doc as $key => $value) {
            echo "<tr>
              <td>" . biduploadtype($value->tipe, true) . "</td>
              <td><a href='" . base_url('userfiles/temp/' . $value->file_path) . "' target='_blank'>" . $value->file_name . "</a></td>
              <td>" . $value->created_at . "</td>
              <td>" . user($value->created_by)->NAME . "</td>
              <td class='text-center'>
                <a href='#' class='btn btn-sm btn-danger' onclick='hapusFile($value->id)'>Delete</a>
              </td>
            </tr>";
        }
        // $referred_from = $this->session->userdata('referred_from');
        // redirect(str_replace('/index.php', '', $referred_from), 'refresh');
    }

    public function hapusattachmentbled($value = '')
    {
        $this->db->where('id', $value);
        $upload = $this->db->get('t_upload')->row();
        $data_id = $upload->data_id;
        @unlink('userfiles/temp/' . $upload->file_path);

        $this->db->where('id', $value);
        $this->db->delete('t_upload');

        $doc = $this->db->where(['module_kode' => 'bled', 'data_id' => $data_id])->get('t_upload')->result();

        foreach ($doc as $key => $value) {
            echo "<tr>
              <td>" . biduploadtype($value->tipe, true) . "</td>
              <td><a href='" . base_url('userfiles/temp/' . $value->file_path) . "' target='_blank'>" . $value->file_name . "</a></td>
              <td>" . $value->created_at . "</td>
              <td>" . user($value->created_by)->NAME . "</td>
              <td class='text-center'>
                <a href='#' class='btn btn-sm btn-danger' onclick='hapusFile($value->id)'>Delete</a>
              </td>
            </tr>";
        }

        /*$referred_from = $this->session->userdata('referred_from');
        redirect(str_replace('index.php', '', $referred_from), 'refresh');*/
    }

    public function savedraftbl($value = '')
    {
        $user = user();
        $data = $this->input->post();
        $msr_no = $data['bl_msr_no'];

        /*check*/
        /*DA, Hanya 1 Bidder*/
        /*DS, 2 Bidder*/
        /*TN, MIN 3 Bidder*/
        $getBl = $this->vendor_lib->getBl(['msr_no' => $msr_no]);
        if ($data['bl_pm'] == 'DA') {
            if ($getBl->num_rows() > 1) {
                echo "DA, Bidder = 1";
                return false;
            }
        }
        if ($data['bl_pm'] == 'DS') {
            if ($getBl->num_rows() != 2) {
                echo "DS, Bidder = 2";
                return false;
            }
        }
        if ($data['bl_pm'] == 'TN') {
            if ($getBl->num_rows() >= 3) {

            } else {
                echo "TN, Minimum Bidder = 3";
                return false;
            }
        }

        $xdata['title'] = $data['bl_title'];
        $xdata['msr_no'] = $data['bl_msr_no'];
        $xdata['pmethod'] = $data['bl_pm'];
        $xdata['created_by'] = $user->ID_USER;
        $xdata['status'] = 0;
        $xdata['bled_no'] = str_replace('OR', 'OQ', $msr_no);
        $bl = $this->db->where('msr_no', $data['bl_msr_no'])->get('t_bl');

        if ($bl->num_rows() > 0) {
            $this->db->where('id', $bl->row()->id);
            $this->db->update('t_bl', $xdata);
            /*update enquiry data*/
            $ed = $this->db->where('msr_no', $data['bl_msr_no'])->get('t_eq_data');
            if ($ed->num_rows() > 0) {
                $this->db->where('id', $ed->row()->id);
                $this->db->update('t_eq_data', ['subject' => $xdata['title']]);
            }
        } else {
            $this->db->insert('t_bl', $xdata);
        }
        if ($value) {
            return true;
        } else {
            echo "Bidder List Success, Save as draft";
        }
        return false;
    }

    public function savedrafted($value = '')
    {
        $user = user();
        $data = $this->input->post();
        $data['created_by'] = $user->ID_USER;
        $data['status'] = 0;
        $bl = $this->db->where('msr_no', $data['msr_no'])->get('t_eq_data');
        if ($bl->num_rows() > 0) {
            $this->db->where('id', $bl->row()->id);
            $this->db->update('t_eq_data', $data);

            /*update BL*/
            $edbl = $this->db->where('msr_no', $data['msr_no'])->get('t_bl');
            if ($edbl->num_rows() > 0) {
                $this->db->where('id', $edbl->row()->id);
                $this->db->update('t_bl', ['title' => $data['subject']]);
            }
        } else {
            $this->db->insert('t_eq_data', $data);
        }
        if ($value) {
            return true;
        } else {
            echo "Success, Enquiry Document Save as draft";
        }
        return false;
    }

    public function checkBlEd($msr_no = '')
    {
        /*attachment*/
        // $sql = "select count(id) jml from t_upload where module_kode='bled' and data_id = '$msr_no' group by tipe";
        $sql = "select count(id) jml from t_upload where module_kode='bled' and data_id = '$msr_no' and tipe = 0";
        $query = $this->db->query($sql)->row();
        $attachment0 = $query->jml;

        $sql = "select count(id) jml from t_upload where module_kode='bled' and data_id = '$msr_no' and tipe = 2";
        $query = $this->db->query($sql)->row();
        $attachment2 = $query->jml;

        $sql = "select count(id) jml from t_upload where module_kode='bled' and data_id = '$msr_no' and tipe between 3 and 12";
        $query = $this->db->query($sql)->row();
        $attachmentE = $query->jml;
        /*SOP*/
        $query = $this->M_bl->getSopValidation($msr_no)->num_rows();
        $sop = $query;

        /*eq data*/
        $eq = $this->db->where('msr_no', $msr_no)->get('t_eq_data')->num_rows();
        /*bl data*/
        $bl = $this->db->where('msr_no', $msr_no)->get('t_bl')->num_rows();
        /*bl detail data*/
        $bld = $this->db->where('msr_no', $msr_no)->get('t_bl_detail')->num_rows();

        if ($this->input->get('debug') == 1) {
            echo "
                attachment0 = $attachment0 <br>
                attachment2 = $attachment2 <br>
                attachmentE = $attachmentE <br>
                eq = $eq <br>
                bl = $bl <br>
                bld = $bld <br>
                sop = $sop <br>
            ";
        }
        if ($attachment0 > 0 and $attachment2 > 0 and $attachmentE > 0 and $eq > 0 and $bl > 0 and $bld > 0 and $sop > 0)
            return true;

        return false;
    }

    public function submitbled($msr_no = '', $t_approval_id = 0)
    {
        $this->db->trans_begin();
        if ($this->savedrafted(1)) {

        } else {
            echo "Fail, Enquiry Document Fail";
            return false;
        }
        if ($this->savedraftbl(1)) {

        } else {
            echo "Fail, Enquiry Document Fail";
            return false;
        }
        $data['status'] = 1;

        $this->db->where('msr_no', $msr_no);
        $this->db->update('t_eq_data', $data);

        $this->db->where('msr_no', $msr_no);
        $this->db->update('t_bl', $data);

        $t_bl = $this->db->where(['msr_no' => $msr_no])->get('t_bl')->row();
        $title = $t_bl->title;
        $pmethod = $t_bl->pmethod;

        /*pmethod*/
        $m_pmethod = $this->db->where(['ID_PMETHOD' => $pmethod])->get('m_pmethod')->row();
        $pmethod_desc = $m_pmethod->PMETHOD_DESC;

        /*update t_msr*/
        // $this->db->where(['msr_no'=>$msr_no]);
        /*$this->db->update('t_msr', [
            'title'         => $title,
            'id_pmethod'    => $pmethod,
            'pmethod_desc'  => $pmethod_desc]
        );*/

        $this->approval_lib->log([
            'module_kode' => 'msr',
            'data_id' => $msr_no,
            'description' => 'Submitted BLED',
            'created_by' => $this->session->userdata('ID_USER')
        ]);
        if ($this->M_approval->checkReject($msr_no)->num_rows() > 0) {
            $checkReject = $this->M_approval->checkReject($msr_no)->row();
            if ($checkReject->m_approval_id == 8) {
                $d['status'] = 4;
            } else {
                $d['status'] = 0;
            }
            $this->db->where('id', $checkReject->approval_id);
            $this->db->update('t_approval', $d);
        } else {
            $this->db->where('id', $t_approval_id);
            $this->db->update('t_approval', ['status' => 5]);
        }

        $this->db->where('msr_no', $msr_no);
        $t_bl = $this->db->get('t_bl')->row();

        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            echo "Bidder List & Enquiry Document No. $t_bl->bled_no created";
        } else {
            $this->db->trans_rollback();
            echo "Fail, Try Again";
        }
    }

    public function msrtobeverify($value = '')
    {
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $data['titleApp'] = 'MSR Verification';
        $greetings = $this->M_approval->greetings_msr_verify();
        $data['greetings'] = $greetings;
        $this->template->display('approval/msrtobeverify', $data);
    }

    public function msrtobeassign($value = '')
    {
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $data['titleApp'] = 'MSR Assignment';
        $greetings = $this->M_approval->greetings_msr_verify();
        $data['greetings'] = $greetings;
        $this->template->display('approval/msrtobeassign', $data);
    }

    public function msrreceived($value = '')
    {
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;

        $greetings = $this->M_approval->greetings_msr_verify();
        $data['greetings'] = $greetings;
        $data['titleApp'] = 'MSR Received';
        $this->template->display('approval/msrreceived', $data);
    }

    public function edapproved($value = '')
    {
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;

        $data['greetings'] = $this->M_approval->ed_approved();
        $this->template->display('approval/edapproved', $data);
    }

    public function viewbled($msr_no = '', $approval_id = '')
    {
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;

        $greetings = $this->M_approval->greetings_msr();
        $data['greetings'] = $greetings;
        $data['idnya'] = $approval_id;
        $data['msr_no'] = $msr_no;
        $data['msr'] = $this->db->select('t_msr.*,m_company.DESCRIPTION company_name,m_msrtype.MSR_DESC msr_name, m_plocation.PGroup_Desc proc_location_name, t_msr.costcenter_desc cost_center_name, m_pmethod.PMETHOD_DESC proc_method_name, m_currency.CURRENCY currency')
            ->join('m_company', 'm_company.ID_COMPANY=t_msr.id_company')
            ->join('m_msrtype', 'm_msrtype.ID_MSR=t_msr.id_msr_type')
            ->join('m_plocation', 'm_plocation.ID_Pgroup=t_msr.id_ploc')
            ->join('m_user', 'm_user.ID_USER=t_msr.create_by')
            ->join('m_costcenter', 'm_costcenter.ID_COSTCENTER=m_user.COST_CENTER')
            ->join('m_pmethod', 'm_pmethod.ID_PMETHOD=t_msr.id_pmethod')
            ->join('m_currency', 'm_currency.ID=t_msr.id_currency')
            ->where('msr_no', $msr_no)->get('t_msr')->row();
        $data['approval'] = $this->db->select('t_approval.*,m_approval.role_id')
            ->join('m_approval', 'm_approval.id=t_approval.m_approval_id')
            ->where('t_approval.id', $approval_id)
            ->get('t_approval')->row();
        // echo $this->db->last_query();
        $data['method'] = $this->db->get('m_pmethod')->result();
        $data['doc'] = $this->db->where(['module_kode' => 'bled', 'data_id' => $msr_no])->get('t_upload')->result();
        $data['t_bl'] = $this->db->where(['msr_no' => $msr_no])->get('t_bl')->row();
        $data['ed'] = $this->M_bl->getEdFromMsr($msr_no)->row();

        $this->session->set_userdata('referred_from', current_url());
        $data['checkBlEd'] = $this->checkBlEd($msr_no);
        // $data['edapproved']  = $this->M_approval->edapproved($approval_id);
        $data['js'] = $this->load->view('approval/devbledjs', array(), true);
        $data['readyIssude'] = $this->M_approval->readyIssude($msr_no);
        $data['viewaja'] = $approval_id > 0 ? true : false;
        $data['tbmi2'] = $this->M_bl->tbmi2($msr_no);
        /*print_r($data['ed']);
        exit();*/
        $this->template->display('approval/viewbled', $data);
    }

    public function reject2()
    {
        $result = $this->M_approval->reject2();
        if ($result) {
            echo json_encode(['msg' => 'Rejected']);
        } else {
            echo json_encode(['msg' => 'Something Wrong, Please Try Again']);
        }
    }

    public function revisionbled($value = '')
    {
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;

        $greetings = $this->M_approval->greetings_msr_verify();
        $data['greetings'] = $greetings;
        $this->template->display('approval/revisionbled', $data);
    }

    public function tobeissued($value = '')
    {
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;

        $greetings = $this->M_approval->greetings_msr_verify();
        $data['greetings'] = $greetings;
        $this->template->display('approval/tobeissued', $data);
    }

    public function bidopening($value = '')
    {
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;

        $greetings = $this->M_approval->greetings_msr_verify();
        $data['greetings'] = $greetings;
        $data['titleApp'] = 'Bid Openning';
        $this->template->display('approval/bidopening', $data);
    }

    public function tobeopening($msr_no = '')
    {
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;

        $greetings = $this->M_approval->greetings_msr();
        $data['greetings'] = $greetings;
        $data['msr_no'] = $msr_no;
        $data['msr'] = $this->db->select('t_msr.*,m_company.DESCRIPTION company_name,m_msrtype.MSR_DESC msr_name, m_plocation.PGroup_Desc proc_location_name, t_msr.costcenter_desc cost_center_name, m_pmethod.PMETHOD_DESC proc_method_name, m_currency.CURRENCY currency')
            ->join('m_company', 'm_company.ID_COMPANY=t_msr.id_company')
            ->join('m_msrtype', 'm_msrtype.ID_MSR=t_msr.id_msr_type')
            ->join('m_plocation', 'm_plocation.ID_Pgroup=t_msr.id_ploc')
            ->join('m_user', 'm_user.ID_USER=t_msr.create_by')
            ->join('m_costcenter', 'm_costcenter.ID_COSTCENTER=m_user.COST_CENTER')
            ->join('m_pmethod', 'm_pmethod.ID_PMETHOD=t_msr.id_pmethod')
            ->join('m_currency', 'm_currency.ID=t_msr.id_currency')
            ->where('msr_no', $msr_no)->get('t_msr')->row();
        $data['approval'] = $this->db->select('t_approval.*,m_approval.role_id')
            ->join('m_approval', 'm_approval.id=t_approval.m_approval_id')
            ->get('t_approval')->row();
        $data['method'] = $this->db->get('m_pmethod')->result();
        $data['doc'] = $this->db->where(['module_kode' => 'bled', 'data_id' => $msr_no])->get('t_upload')->result();
        $data['t_bl'] = $this->db->where(['msr_no' => $msr_no])->get('t_bl')->row();
        $data['blDetails'] = $this->vendor_lib->blDetail($msr_no);
        // echo $this->db->last_query();
        $data['ed'] = $this->db->select('*,(CASE WHEN now() >= closing_date THEN 1 ELSE 0 END) noting, m_deliveryterm.DELIVERYTERM_DESC, m_deliverypoint.DPOINT_DESC')
            ->join('m_deliveryterm', 'm_deliveryterm.ID_DELIVERYTERM = t_eq_data.incoterm', 'left')
            ->join('m_deliverypoint', 'm_deliverypoint.ID_DPOINT = t_eq_data.delivery_point', 'left')
            ->where(['msr_no' => $msr_no])
            ->get('t_eq_data')
            ->row();
        /*print_r($data['ed']);
        exit();*/
        $this->session->set_userdata('referred_from', current_url());
        $data['checkBlEd'] = $this->checkBlEd($msr_no);
        // $data['vendor']  = $this->mrs->show2();
        $data['js'] = $this->load->view('approval/devbledjs', array(), true);
        $this->template->display('approval/tobeopening', $data);
    }

    public function savebidopening()
    {
        $edid = $this->input->post('ed_id');
        $this->M_approval->updateBidOpening();

        ini_set('max_execution_time', 300);
        $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
        $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";

        $query = $this->db->query("SELECT u.NAME, c.TITLE, c.OPEN_VALUE, c.CLOSE_VALUE, t.company_desc, q.subject AS titlemsr, t.msr_no, u.email AS email FROM t_eq_data q
            JOIN t_msr t ON t.msr_no=q.msr_no
            JOIN m_user u ON u.ID_USER = t.create_by
            JOIN m_notic c ON c.ID = 39
            WHERE q.id = " . $edid ."
            UNION 
            SELECT u.NAME, c.TITLE, c.OPEN_VALUE, c.CLOSE_VALUE, t.company_desc, q.subject AS titlemsr, t.msr_no, u.email AS email FROM t_eq_data q
            JOIN t_msr t ON t.msr_no=q.msr_no
            JOIN t_approval ap ON ap.data_id = q.msr_no
            JOIN m_approval mp ON mp.id = ap.m_approval_id
            JOIN m_user u ON u.ID_USER = ap.created_by
            JOIN m_notic c ON c.ID = 39
            WHERE q.id = " . $edid . " AND mp.id = 1");

        $data_replace = $query->result();

        $edno = str_replace('R', 'Q', $data_replace[0]->msr_no);
        $str = $data_replace[0]->OPEN_VALUE;
        $str = str_replace('_var1_', $data_replace[0]->titlemsr, $str);
        $str = str_replace('_var2_', $edno, $str);
        $data = array(
            'img1' => $img1,
            'img2' => $img2,
            'title' => $data_replace[0]->TITLE,
            'open' => $str,
            'close' => $data_replace[0]->CLOSE_VALUE
        );
        foreach ($data_replace as $v){
            $data['dest'][] = $v->email;
        }
        $flag = $this->sendMail($data);

        $referred_from = $this->session->userdata('referred_from');
        $this->session->set_flashdata('message', array(
            'message' => __('success_bid_opening'),
            'type' => 'success'
        ));
        redirect(base_url('home'));
    }

    public function adminevaluation($value = '')
    {
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;

        $greetings = $this->M_approval->greetings_msr_verify();
        $data['greetings'] = $greetings;
        $data['titleApp'] = 'Administration Evaluation';
        $this->template->display('approval/bidopening', $data);
    }

    public function tobeadmin($msr_no = '')
    {
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;

        $userId = $this->session->userdata('ID_USER');
        $cek = $this->db->where('ID_USER', $userId)->get('m_user')->row();
        $roles = explode(",", $cek->ROLES);
        $data['roles'] = array_values(array_filter($roles));
        // $roles              = array_values(array_filter($roles));

        $greetings = $this->M_approval->greetings_msr();
        $data['greetings'] = $greetings;
        $data['msr_no'] = $msr_no;
        $data['msr'] = $this->db->select('t_msr.*,m_company.DESCRIPTION company_name,m_msrtype.MSR_DESC msr_name, m_plocation.PGroup_Desc proc_location_name, t_msr.costcenter_desc cost_center_name, m_pmethod.PMETHOD_DESC proc_method_name, m_currency.CURRENCY currency')
            ->join('m_company', 'm_company.ID_COMPANY=t_msr.id_company')
            ->join('m_msrtype', 'm_msrtype.ID_MSR=t_msr.id_msr_type')
            ->join('m_plocation', 'm_plocation.ID_Pgroup=t_msr.id_ploc')
            ->join('m_user', 'm_user.ID_USER=t_msr.create_by')
            ->join('m_costcenter', 'm_costcenter.ID_COSTCENTER=m_user.COST_CENTER')
            ->join('m_pmethod', 'm_pmethod.ID_PMETHOD=t_msr.id_pmethod')
            ->join('m_currency', 'm_currency.ID=t_msr.id_currency')
            ->where('msr_no', $msr_no)->get('t_msr')->row();
        $data['approval'] = $this->db->select('t_approval.*,m_approval.role_id')
            ->join('m_approval', 'm_approval.id=t_approval.m_approval_id')
            ->get('t_approval')->row();
        $data['method'] = $this->db->get('m_pmethod')->result();
        $data['doc'] = $this->db->where(['module_kode' => 'bled', 'data_id' => $msr_no])->get('t_upload')->result();
        $data['t_bl'] = $this->db->where(['msr_no' => $msr_no])->get('t_bl')->row();
        $data['bled_no'] = $data['t_bl']->bled_no;
        $data['blDetails'] = $this->vendor_lib->blDetail($msr_no);
        $data['ed'] = $this->db->select('*,(CASE WHEN now() >= closing_date THEN 1 ELSE 0 END) noting')->where(['msr_no' => $msr_no])->get('t_eq_data')->row();

        if ($data['ed']->administrative == 1 or $data['ed']->administrative == 3 or $data['ed']->administrative == 4) {
            if (in_array(assign_sp, $data['roles'])) {
                $this->db->where(['msr_no' => $msr_no]);
                $data['approved_administration'] = $this->M_approval->evaluationToBeApproved('administrative', [1, 3, 4])->row();
                $data['adminAttachment'] = $this->M_approval->seeAttachment('eva-administrative', $msr_no)->row();
            }
        }
        if ($data['ed']->technical == 1 or $data['ed']->technical == 3 or $data['ed']->technical == 4) {
            if (in_array(user_manager, $data['roles'])) {
                $this->db->where(['msr_no' => $msr_no]);
                $data['approved_technical'] = $this->M_approval->evaluationToBeApproved('technical', [1, 3, 4])->row();
                $data['technicalAttachment'] = $this->M_approval->seeAttachment('eva-technical', $msr_no)->row();
            }
        }
        if ($data['ed']->commercial == 1 or $data['ed']->commercial == 3 or $data['ed']->commercial == 4) {
            if (in_array(assign_sp, $data['roles'])) {
                $this->db->where(['msr_no' => $msr_no]);
                $data['approved_commercial'] = $this->M_approval->evaluationToBeApproved('commercial', [1, 3, 4])->row();
                $data['commercialAttachment'] = $this->M_approval->seeAttachment('eva-commercial', $msr_no)->row();
            }
        }

        /*print_r($data['ed']);
        exit();*/
        $this->session->set_userdata('referred_from', current_url());
        $data['checkBlEd'] = $this->checkBlEd($msr_no);
        // $data['vendor']  = $this->mrs->show2();
        $data['js'] = $this->load->view('approval/devbledjs', array(), true);
        $data['msrItem'] = $this->vendor_lib->msrItemTobeAdmin($msr_no);
        /*echo $this->db->last_query();
        exit();*/
        $commercialNum = $this->M_approval->commercial(['t_eq_data.msr_no' => $msr_no])->num_rows();

        if ($commercialNum > 0) {
            $data['commercial'] = 1;
        }

        $this->template->display('approval/tobeadmin', $data);
    }

    public function administrative($value = '')
    {
        $return = $this->M_approval->administrative();
        if ($return) {
            $msg = $this->input->post('administrative') == 1 ? "Pass" : "Fail";
            $remark = $this->input->post('desc_administrative') ? $this->input->post('desc_administrative') : "";
            if ($this->input->post('technical')) {
                $msg = $this->input->post('technical') == 1 ? "Pass" : "Fail";
                $remark = $this->input->post('desc_technical') ? $this->input->post('desc_technical') : "";
            }
            if ($this->input->post('commercial')) {
                $msg = $this->input->post('commercial') == 1 ? "Pass" : "Fail";
                $remark = $this->input->post('desc_commercial') ? $this->input->post('desc_commercial') : "";
            }
            echo json_encode(['msg' => $msg, 'remark' => $remark]);
        } else {
            echo "Update error, try again";
        }
    }

    public function evaluationupload($type = '')
    {
        /*$type = administrative & evaluation*/
        /*print_r($_FILES);
        exit();*/
        if ($_FILES['upload']['tmp_name']) {
            $this->db->trans_begin();
            $user = user();
            $field['module_kode'] = 'eva-' . $type;
            $field['data_id'] = $this->input->post('data_id');
            $field['file_path'] = $this->doUpload('upload');
            $field['created_by'] = $user->ID_USER;
            $this->db->insert('t_upload', $field);


            if ($this->db->trans_status() === true) {
                $this->db->trans_commit();
                echo json_encode(['status' => true, 'msg' => 'Uploaded', 'filename' => $field['file_path']]);
            } else {
                $this->db->trans_rollback();
                echo json_encode(['status' => true, 'msg' => 'Fail, Try Again']);
            }
        } else {
            echo json_encode(['status' => true, 'msg' => 'Fail, Try Again']);
        }
    }

    public function doUpload($file_path = '')
    {
        $config['upload_path'] = './upload/evaluation/';
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, TRUE);
        }
        $config['allowed_types'] = 'pdf|jpg|jpeg|doc|docx|xls|xlsx';
        $config['encrypt_name'] = true;
        // $config['max_size']      = '3000';

        // print_r($_FILES['upload']);
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($file_path)) {
            echo $this->upload->display_errors('', '');
            return false;
            exit;
        } else {
            $user = user();
            $data = $this->upload->data();
            // $field = $this->input->post();
            // $field['file_path'] = $data['file_name'];
            return $data['file_name'];
        }
    }

    public function administrationevaluation($value = '')
    {
        $referred_from = $this->session->userdata('referred_from');
        $administrationevaluation = $this->M_approval->administrationevaluation();
        if ($this->input->post('description') !== 'Acknowledge Administration Evaluation') {
            // $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
            // $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";
            $img1 = "";
            $img2 = "";

            $edid = $this->input->post('ed_id');

            $query = $this->db->query('SELECT ed.subject AS edtitle, approval.data_id as msr_no, user.NAME as name, user.EMAIL as email, notif.TITLE as title, notif.OPEN_VALUE as open, notif.CLOSE_VALUE as close FROM t_eq_data ed
            JOIN t_approval approval ON ed.msr_no = approval.data_id
            JOIN m_approval main ON approval.m_approval_id = main.id
            JOIN m_user_roles roles ON main.role_id = roles.ID_USER_ROLES
            JOIN m_user user ON approval.created_by = user.ID_USER
            JOIN m_notic notif ON notif.ID = 63
            WHERE ed.id = "' . $edid . '"
            AND roles.ID_USER_ROLES = 23');

            $data_replace = $query->result();
            $edno = str_replace('R', 'Q', $data_replace[0]->msr_no);

            $str = $data_replace[0]->open;
            $str = str_replace('_var1_', $data_replace[0]->edtitle, $str);
            $str = str_replace('_var2_', $edno, $str);
            $data = array(
                'img1' => $img1,
                'img2' => $img2,
                'title' => $data_replace[0]->title,
                'open' => $str,
                'close' => $data_replace[0]->close
            );
            $data['dest'][] = $data_replace[0]->email;
            $flag = $this->sendMail($data);
        }
        $this->session->set_flashdata('message', array(
            'message' => __('success_submit'),
            'type' => 'success'
        ));
        redirect(base_url('home'));
    }

    public function technicalevaluation($value = '')
    {
        $this->session->set_userdata('evaluation_step', 'technicalevaluation');
        if ($this->input->post('ed_id')) {
            $edid = $this->input->post('ed_id');
            $referred_from = $this->session->userdata('referred_from');
            $technicalevaluation = $this->M_approval->technicalevaluation();
            if ($this->input->post('description') !== 'Acknowledge Technical Evaluation') {
                // $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
                // $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";
                $img1 = "";
                $img2 = "";

                $query = $this->db->query('SELECT ed.msr_no, ed.subject, us.NAME as nama, us.EMAIL as email, notif.TITLE as title, notif.OPEN_VALUE as open, notif.CLOSE_VALUE as close FROM t_eq_data ed
            JOIN t_approval tp ON ed.msr_no = tp.data_id
            JOIN m_user us ON tp.created_by = us.ID_USER
            JOIN m_notic notif ON notif.ID = 65
            WHERE tp.m_approval_id = 1 AND ed.id = ' . $this->input->post('ed_id'));;

                $data_replace = $query->result();

                $str = $data_replace[0]->open;
                $edno = str_replace('R', 'Q', $data_replace[0]->msr_no);
                $str = str_replace('_var2_', $edno, $str);
                $str = str_replace('_var1_', $data_replace[0]->subject, $str);
                $data = array(
                    'img1' => $img1,
                    'img2' => $img2,
                    'title' => $data_replace[0]->title,
                    'open' => $str,
                    'close' => $data_replace[0]->close
                );
                foreach ($data_replace as $val) {
                    $data['dest'][] = $val->email;
                }
                $flag = $this->sendMail($data);
            }
            redirect(base_url('home'));
        } else {
            $get_menu = $this->M_vendor->menu();
            $dt = array();
            foreach ($get_menu as $k => $v) {
                $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
                $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
                $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
                $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
            }
            $data['menu'] = $dt;

            $greetings = $this->M_approval->greetings_msr_verify();
            $data['greetings'] = $greetings;
            $data['titleApp'] = 'Technical Evaluation';
            $this->template->display('approval/bidopening', $data);
        }
    }

    public function evaluationtobeapproved($value = '')
    {
        $this->session->set_userdata('evaluation_step', 'evaluationtobeapproved');
        if ($this->input->post('ed_id')) {
            $referred_from = $this->session->userdata('referred_from');
            $technicalevaluation = $this->M_approval->technicalevaluation();
            // echo $this->db->last_query();
            redirect(str_replace('/index.php', '', $referred_from), 'refresh');
        } else {
            $get_menu = $this->M_vendor->menu();
            $dt = array();
            foreach ($get_menu as $k => $v) {
                $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
                $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
                $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
                $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
            }
            $data['menu'] = $dt;

            $greetings = $this->M_approval->greetings_msr_verify();
            $data['greetings'] = $greetings;
            $data['titleApp'] = 'Administration Evaluation Approval';
            $this->template->display('approval/bidopening', $data);
        }
    }

    public function techtobeapproved($value = '')
    {
        $this->session->set_userdata('evaluation_step', 'technicalapproval');
        if ($this->input->post('ed_id')) {
            $referred_from = $this->session->userdata('referred_from');
            $technicalevaluation = $this->M_approval->technicalevaluation();
            // echo $this->db->last_query();
            redirect(str_replace('/index.php', '', $referred_from), 'refresh');
        } else {
            $get_menu = $this->M_vendor->menu();
            $dt = array();
            foreach ($get_menu as $k => $v) {
                $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
                $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
                $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
                $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
            }
            $data['menu'] = $dt;

            $greetings = $this->M_approval->greetings_msr_verify();
            $data['greetings'] = $greetings;
            $data['titleApp'] = 'Technical Evaluation';
            $this->template->display('approval/bidopening', $data);
        }
    }

    public function admack($value = '')
    {
        $this->session->set_userdata('evaluation_step', 'admack');
        $data['titleApp'] = 'Administration Evaluation Acknowledgement';
        if ($this->input->post('ed_id')) {
            $referred_from = $this->session->userdata('referred_from');
            $technicalevaluation = $this->M_approval->technicalevaluation();
            // echo $this->db->last_query();
            redirect(str_replace('/index.php', '', $referred_from), 'refresh');
        } else {
            $get_menu = $this->M_vendor->menu();
            $dt = array();
            foreach ($get_menu as $k => $v) {
                $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
                $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
                $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
                $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
            }
            $data['menu'] = $dt;

            $greetings = $this->M_approval->greetings_msr_verify();
            $data['greetings'] = $greetings;
            $this->template->display('approval/bidopening', $data);
        }
    }

    public function techack($value = '')
    {
        $this->session->set_userdata('evaluation_step', 'techack');
        $data['titleApp'] = 'Technical Evaluation Acknowledgement';
        if ($this->input->post('ed_id')) {
            $referred_from = $this->session->userdata('referred_from');
            $technicalevaluation = $this->M_approval->technicalevaluation();
            // echo $this->db->last_query();
            redirect(str_replace('/index.php', '', $referred_from), 'refresh');
        } else {
            $get_menu = $this->M_vendor->menu();
            $dt = array();
            foreach ($get_menu as $k => $v) {
                $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
                $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
                $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
                $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
            }
            $data['menu'] = $dt;

            $greetings = $this->M_approval->greetings_msr_verify();
            $data['greetings'] = $greetings;
            $this->template->display('approval/bidopening', $data);
        }
    }

    public function approvalevaluation($value = '')
    {
        if ($this->input->post('ed_id')) {
            // $referred_from = $this->session->userdata('referred_from');
            // print_r($_POST);
            // exit();
            if ($this->input->post('approval_ed')) {
                $this->M_approval->approvalEdEvaluationLog();
            } else {
                $this->M_approval->approvalEdEvaluation();
            }

            if ($this->input->post('approval_ed') == 'administrative') {
                if ($this->input->post('administrative') == 3) {
                    $query = $this->db->query('SELECT ed.subject, ed.msr_no as msr_no, user.EMAIL as email, notif.TITLE as title, notif.OPEN_VALUE as open, notif.CLOSE_VALUE as close FROM t_eq_data ed
                    JOIN t_msr msr ON msr.msr_no = ed.msr_no
                    JOIN m_user user ON msr.create_by = user.ID_USER
                    JOIN m_notic notif ON notif.ID = 83
                    WHERE ed.id = ' . $this->input->post('ed_id') . '
                    UNION
                    SELECT ed.subject, ed.msr_no as msr_no, user.EMAIL as email, notif.TITLE as title, notif.OPEN_VALUE as open, notif.CLOSE_VALUE as close FROM t_eq_data ed
                    JOIN t_approval ap ON ap.data_id = ed.msr_no
                    JOIN m_user user ON ap.created_by = user.ID_USER
                    JOIN m_notic notif ON notif.ID = 83
                    WHERE ed.id = ' . $this->input->post('ed_id') . ' AND ap.m_approval_id = 1');

                    $data_replace = $query->result();
                    $str = $data_replace[0]->open;
                    $edno = str_replace('R', 'Q', $data_replace[0]->msr_no);
                    $str = str_replace('_var1_', $data_replace[0]->subject, $str);
                    $str = str_replace('_var2_', $edno, $str);
                }
            } else if ($this->input->post('approval_ed') == 'technical') {
                if ($this->input->post('technical') == 3) {
                    $query = $this->db->query('SELECT ed.subject, ed.msr_no, us.EMAIL as email, us.ID_USER as id, us.NAME as nama, notif.TITLE as title, notif.OPEN_VALUE as open, notif.CLOSE_VALUE as close FROM t_eq_data ed
                    JOIN t_approval tp ON tp.data_id = ed.msr_no
                    JOIN m_approval mp ON mp.id = tp.m_approval_id
                    JOIN m_user us ON us.ID_USER = tp.created_by
                    JOIN m_notic notif ON notif.ID = 65
                    WHERE mp.module_kode = "msr" AND tp.m_approval_id = 1 AND ed.id = ' . $this->input->post('ed_id'));
                    $data_replace = $query->result();

                    if ($this->session->userdata('ID_USER') == $data_replace[0]->id) {
                        $query = $this->db->query('SELECT ed.subject, ed.msr_no, us.EMAIL as email, us.NAME as nama, us.ID_USER as id, notif.TITLE as title, notif.OPEN_VALUE as open, notif.CLOSE_VALUE as close FROM t_eq_data ed
                        JOIN m_user us ON us.ID_USER = ed.created_by
                        JOIN m_notic notif ON notif.ID = 89
                        WHERE ed.id = ' . $this->input->post('ed_id') . '
                        UNION
                        SELECT ed.subject, ed.msr_no, us.EMAIL as email, us.NAME as nama, us.ID_USER as id, notif.TITLE as title, notif.OPEN_VALUE as open, notif.CLOSE_VALUE as close FROM t_eq_data ed
                        JOIN t_approval ap ON ap.data_id = ed.msr_no
                        JOIN m_user us ON us.ID_USER = ap.created_by
                        JOIN m_notic notif ON notif.ID = 89
                        WHERE ap.m_approval_id = 8 AND ed.id = ' . $this->input->post('ed_id'));
                        $data_replace = $query->result();
                    }
                    $str = $data_replace[0]->open;
                    $edno = str_replace('R', 'Q', $data_replace[0]->msr_no);
                    $str = str_replace('_var1_', $data_replace[0]->subject, $str);
                    $str = str_replace('_var2_', $edno, $str);
                } else {
                    $query = $this->db->query('SELECT ed.subject, ed.msr_no as msr_no, user.EMAIL as email, notif.TITLE as title, notif.OPEN_VALUE as open, notif.CLOSE_VALUE as close FROM t_eq_data ed
                    JOIN t_msr msr ON msr.msr_no = ed.msr_no
                    JOIN m_user user ON msr.create_by = user.ID_USER
                    JOIN m_notic notif ON notif.ID = 66
                    WHERE ed.id = ' . $this->input->post('ed_id'));

                    $data_replace = $query->result();
                    $str = $data_replace[0]->open;
                    $edno = str_replace('R', 'Q', $data_replace[0]->msr_no);
                    $str = str_replace('no_ed', $edno, $str);
                }
            }

            // $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
            // $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";
            $img1 = "";
            $img2 = "";

            $data = array(
                'img1' => $img1,
                'img2' => $img2,
                'title' => $data_replace[0]->title,
                'open' => $str,
                'close' => $data_replace[0]->close
            );
            foreach ($data_replace as $val) {
                $data['dest'][] = $val->email;
            }
            $flag = $this->sendMail($data);
            $this->session->set_flashdata('message', array(
                'message' => __('success_submit'),
                'type' => 'success'
            ));
            redirect(base_url('home'));
        }
    }

    public function commercial($value = '')
    {
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $data['titleApp'] = 'Commercial Evaluation';

        $greetings = $this->M_approval->greetings_msr_verify();
        $data['greetings'] = $greetings;
        $data['commercial'] = 1;
        $this->template->display('approval/bidopening', $data);
    }

    public function performnegotiation($value = '')
    {
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $data['titleApp'] = 'Perform Negotiation';

        $greetings = $this->M_approval->greetings_msr_verify();
        $data['greetings'] = $greetings;
        $this->template->display('approval/bidopening', $data);
    }

    public function comtobeapproved($value = '')
    {
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $data['titleApp'] = 'Commercial to be Approved';
        $greetings = $this->M_approval->greetings_msr_verify();
        $data['greetings'] = $greetings;
        $this->template->display('approval/bidopening', $data);
    }

    public function comack($value = '')
    {
        if ($this->input->post('ed_id')) {
            $referred_from = $this->session->userdata('referred_from');
            $technicalevaluation = $this->M_approval->technicalevaluation();
            // echo $this->db->last_query();
            redirect(str_replace('/index.php', '', $referred_from), 'refresh');
        } else {
            $get_menu = $this->M_vendor->menu();
            $dt = array();
            foreach ($get_menu as $k => $v) {
                $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
                $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
                $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
                $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
            }
            $data['menu'] = $dt;

            $greetings = $this->M_approval->greetings_msr_verify();
            $data['greetings'] = $greetings;
            $this->template->display('approval/bidopening', $data);
        }
    }

    public function vendor_items_nego()
    {
        $this->load->model('approval/M_bl');
        $data = $this->input->post();
        $data['items'] = $this->M_bl->getItemByMsr($data['msr_no']);
        $this->load->view('approval/vendor_items_nego', $data);
    }

    public function issued_nego($value = '')
    {
        $this->load->model('approval/M_bl');
        $data = $this->input->post();
        /*print_r($data);
        exit();*/
        $this->db->trans_begin();

        $data['nego'] = 0;
        $this->M_bl->issued_nego($data);

        foreach ($data['chk'] as $key => $value) {
            $d['nego'] = 1;
            $d['nego_date'] = date("Y-m-d");
            $this->db->where([
                'vendor_id' => $data['vendor_id'],
                'sop_id' => $key,
            ]);
            $this->db->update('t_sop_bid', $d);

            $t_sop = $this->db->where(['id' => $key])->get('t_sop')->row();
            /**/
            // foreach ($t_sop->result() as $sop) {
            $x['nego'] = 1;
            $x['msr_detail_id'] = $t_sop->msr_item_id;
            $x['vendor_id'] = $data['vendor_id'];
            $this->M_bl->issued_nego($x);
            // }
        }
        /*foreach ($data['chk'] as $key => $value) {
            $data['nego'] = 1;
            $data['msr_detail_id'] = $key;
            $data['nego_date'] = date("Y-m-d");
            $this->M_bl->issued_nego($data);
        }*/
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            echo 'Success Submited';
        } else {
            $this->db->trans_rollback();
            echo 'Fail, Try Again';
        }
    }

    public function no_nego($value = '')
    {
        $this->load->model('approval/M_bl');

        $data = $this->input->post();

        $this->db->trans_begin();

        $t_bl = $this->db->where(['msr_no' => $data['msr_no']])->get('t_bl')->row();

        $bled_no = $t_bl->bled_no;
        $vendor_id = $data['vendor_id'];


        $this->db->where(['bled_no' => $bled_no, 'created_by' => $vendor_id]);
        $this->db->update('t_bid_detail', ['nego' => 2, 'nego_date' => date("Y-m-d")]);

        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            echo 'Success Submited';
        } else {
            $this->db->trans_rollback();
            echo 'Fail, Try Again';
        }
    }

    public function issuednego($value = '')
    {
        $data = $this->input->post();
        $msr_no = $data['msr_no'];
        $this->load->model('approval/M_bl');
        $this->M_bl->issuednego($data);
    }

    protected function sendMail($content)
    {
        $mail = get_mail();
        $config = array();
        $config['protocol'] = $mail['protocol'];
        $config['smtp_crypto'] = $mail['crypto'];
        if ($mail['protocol'] == 'smtp') {
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

                if ($this->db->insert('i_notification', $data_email)) {
                    $flag = 1;
                } else {
                    $flag = 0;
                }
            }
        } else {
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

    public function devbled_submit()
    {
        $data = $this->input->post();
        $checkBlEd = $this->checkBlEd($data['msr_no']);
        if ($checkBlEd) {
            echo json_encode(['status' => true]);
        } else {
            echo json_encode(['status' => false]);
        }
    }

    public function checkbl()
    {
        $data = $this->input->post();
        $getBl = $this->vendor_lib->getBl(['msr_no' => $data['bl_msr_no']]);
        $getBlVendor = $this->vendor_lib->getBl(['msr_no' => $data['bl_msr_no'], 'vendor_id' => $data['bl_vendor']]);
        if ($getBlVendor->num_rows() > 0) {
            echo json_encode(['status' => false, 'msg' => 'Duplicate Vendor']);
            return false;
        }
        if ($data['bl_pm'] == 'DA') {
            if ($getBl->num_rows() + 1 > 1) {
                echo json_encode(['status' => false, 'msg' => 'DA, Bidder = 1']);
                return false;
            }
        }
        if ($data['bl_pm'] == 'DS') {
            if ($getBl->num_rows() + 1 == 3) {
                echo json_encode(['status' => false, 'msg' => 'DS, Bidder = 2']);
                return false;

            } else {
                echo json_encode(['status' => true]);
                return true;
            }
        }
        /*if($data['bl_pm'] == 'TN')
        {
            if($getBl->num_rows()+1 <= 3)
            {
                echo json_encode(['status'=>false, 'msg'=>'Tender Minimum Bidder is 3']);
                return false;
            }
        }*/
        echo json_encode(['status' => true]);
        return true;
    }

    public function firstAas($nominal = 10000, $created_by = '', $msr_company = '')
    {
        // echo numIndo($nominal);
        $rs = '';
        $sqlId = "select * from t_jabatan where user_id = $created_by";
        $n = $this->db->query($sqlId)->row();
        $id = $n->id;
        if ($nominal > 5000000) {
            $sql = "SELECT * FROM t_jabatan WHERE id = 1";
            $result = $this->db->query($sql);
            $row = $result->row();
            $rs = $row;
        } else {
            for ($i = 0; $i < 4; $i++) {
                $sql = "SELECT * FROM t_jabatan WHERE id = (SELECT parent_id FROM t_jabatan WHERE id = $id)";
                $result = $this->db->query($sql);
                $row = $result->row();
                if ($nominal <= $row->nominal) {
                    $rs = $row;
                    break;
                } else {
                    $id = $row->id;
                }
            }
        }
        /*cek di m_user*/
        $msr_company = trim($msr_company);
        $q = "select * from m_user where ID_USER  = $rs->user_id and COMPANY like '%$msr_company%'";
        if ($this->db->query($q)->num_rows() > 0) {

        } else {
            $rs = $this->db->where(['first' => 1])->get('t_jabatan')->row();
        }
        if ($this->input->get('debug') == 1) {
            echo "<pre>";
            print_r($rs);
            echo "</pre>";
        }
        return $rs;
    }

    public function firstum($msr_no = '')
    {
        $msr = $this->db->where(['msr_no' => $msr_no])->get('t_msr')->row();
        $t_jabatan = $this->db->where(['user_id' => $msr->create_by])->get('t_jabatan')->row();
        $s = $this->db->where(['id' => $t_jabatan->parent_id])->get('t_jabatan')->row();
        echo $s->user_id;
    }

    public function get_reject_by_msr($msr_no = '')
    {
        $this->approval_lib->getRejectByMsr($msr_no);
    }

    public function resubmit($value = '')
    {
        $msr_no = $this->input->post('msr_no');
        if ($this->input->get('debug')) {
            $_POST['msr_no'] = $value;
        }
        $result = $this->M_approval->resubmit();
        if ($result) {
            $this->session->set_flashdata('message', array(
                'message' => __('success_resubmit'),
                'type' => 'success'
            ));

            $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
            $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";


//                    $query = $this->db->query("SELECT distinct u.email as recipient,n.TITLE,n.OPEN_VALUE,n.CLOSE_VALUE FROM t_approval t
//                        join m_approval m on m.id=t.m_approval_id and m.module_kode='msr'
//                        join m_user u on u.roles like CONCAT('%', m.role_id ,'%')
//                        join m_notic n on n.ID=35
//                        where t.data_id='".$msr_no."' and t.urutan=1");
            $query = $this->db->query("SELECT t.data_id AS msr_no, u.EMAIL AS email, u.NAME AS name, n.TITLE AS title, n.OPEN_VALUE AS open, n.CLOSE_VALUE AS close FROM t_approval t
                    LEFT JOIN m_approval m ON t.m_approval_id = m.id
                    LEFT JOIN m_user_roles ur ON m.role_id = ur.ID_USER_ROLES
                    LEFT JOIN m_user u ON u.ID_USER = t.created_by
                    JOIN m_notic n ON n.ID = 35
                    WHERE t.data_id = '" . $msr_no . "' AND m.module_kode = 'msr' AND t.urutan = 1");
            if ($query->num_rows() > 0) {
                $data_role = $query->result();
                $count = 1;
            } else {
                $count = 0;
            }

            if ($count === 1) {

                $query = $this->db->query("SELECT distinct t.title,u.NAME,d.DEPARTMENT_DESC from t_msr t
                        join m_user u on u.ID_USER=t.create_by
                        join m_departement d on d.ID_DEPARTMENT=u.ID_DEPARTMENT
                        where msr_no='".$msr_no."' ");

                $data_replace = $query->result();

                $str = $data_role[0]->open;
                $str = str_replace('_var1_',$data_replace[0]->title,$str);
                $str = str_replace('_var2_',$data_replace[0]->NAME,$str);
                $str = str_replace('_var3_',$data_replace[0]->DEPARTMENT_DESC,$str);
                $str = str_replace('_var4_', $msr_no, $str);

                $data = array(
                    'img1' => $img1,
                    'img2' => $img2,
                    'title' => $data_role[0]->title,
                    'open' => $str,
                    'close' => $data_role[0]->close
                );

                foreach ($data_role as $k => $v) {
                    $data['dest'][] = $v->email;
                }
                $flag = $this->sendMail($data);

            }
            echo json_encode(['msg' => 'Succcess']);
        } else {
            $this->session->set_flashdata('message', array(
                'message' => __('failed_resubmit'),
                'type' => 'success'
            ));
            echo json_decode(['msg' => 'Fail, Please Try Again']);
        }
    }

    public function sop_store($value = '')
    {
        /*print_r($_POST);
        exit();*/
        $this->M_bl->sop_store();
    }

    public function sop_grid($value = '')
    {
        $msr_no = $this->input->post('msr_no');
        $type = $this->input->post('type');
        $sop_grid = $this->M_bl->sop_get(['t_sop.msr_no' => $msr_no]);
        $ed = $this->M_bl->getEd($msr_no);
        if ($ed->num_rows() > 0) {
            $ed = $ed->row();
            $currency = $this->M_bl->getMc($ed->currency)->row();
            $cur = $currency->CURRENCY;
        } else {
            $cur = '';
        }
        $bgGrey = "style='background:none'";
        if ($sop_grid->num_rows() > 0) {
            $sop_grid = $sop_grid->result();
            if ($sop_grid[0]->sop_type == 2) {
                $qty1 = 'Qty 1';
                $uom1 = 'UoM 1';
            } else {
                $qty1 = 'Qty';
                $uom1 = 'UoM';
            }
            $tb = "<thead><tr $bgGrey><th>No</th><th>MSR Item</th><th>Item</th><th class='text-center'>$qty1</th><th class='text-center'>$uom1</th>";
            if ($sop_grid[0]->sop_type == 2) {
                $tb .= "<th class='text-center'>Qty 2</th><th class='text-center'>UoM 2</th>";
            }
            /*for view mode*/
            if ($type == 'view') {
                $tb .= "<th class='text-center'>Currency</th><th class='text-right'>Unit Price</th><th class='text-right'>Total Value</th><th>Cost Center</th><th>Account Subsidiary</th><th>Inv Type</th><th>Item Modification</th></tr></thead>";
            } else {
                $tb .= "<th class='text-center'>Currency</th><th class='text-right'>Unit Price</th><th class='text-right'>Total Value</th><th>Cost Center</th><th>Account Subsidiary</th><th>Inv Type</th><th class='text-center'>Item Modification</th><th class='text-center'>Action</th></tr></thead>";
            }
            $tb .= "<tbody>";
            $no = 1;
            foreach ($sop_grid as $r) {
                $uom1 = $r->uom1;
                $m_material_uom = $this->db->where(['MATERIAL_UOM' => $uom1])->get('m_material_uom')->row();
                $uom1 .= " - $m_material_uom->DESCRIPTION";
                $tb .= "<tr><td $bgGrey>$no</td><td>$r->description</td><td>$r->item</td><td class='text-center'>$r->qty1</td><td class='text-center'>$uom1</td>";
                if ($r->sop_type == 2) {
                    $m_material_uom = $this->db->where(['MATERIAL_UOM' => $r->uom2])->get('m_material_uom')->row();
                    $qty2 = $r->qty2 > 0 ? $r->qty2 : '-';
                    $uom2 = $r->qty2 > 0 ? $r->uom2 . " - $m_material_uom->DESCRIPTION" : '-';
                    $tb .= "<td class='text-center'>$qty2</td><td class='text-center'>$uom2</td>";
                }
                $tax = $r->tax == 1 ? "Yes" : "No";
                $edit = "<a href='#' class='btn btn-sm btn-warning' onclick='editSopClick($r->id)'>Edit</a>";
                $delete = "<a href='#' class='btn btn-sm btn-danger' onclick='deleteSopClick($r->id)'>Delete</a>";
                /*for view mode*/
                if ($type == 'view') {
                    $is_modif = $r->item_modification == 1 ? 'Yes' : 'No';
                    $tb .= "<td $bgGrey align='center'></td><td $bgGrey></td><td $bgGrey></td>
                    <td>$r->costcenter_desc</td>
                    <td>$r->accsub_desc</td>
                    <td>$r->inv_desc</td>
                    <td class='text-center'>$is_modif</td>
                    </tr>";
                } else {
                    $is_modif = $r->item_modification == 1 ? 'Yes' : 'No';
                    $tb .= "<td $bgGrey align='center'></td><td $bgGrey></td><td $bgGrey></td>
                    <td>$r->costcenter_desc</td>
                    <td>$r->accsub_desc</td>
                    <td>$r->inv_desc</td>
                    <td class='text-center'>$is_modif</td>
                    <td class='text-center'>$edit $delete</td>
                    </tr>";
                }
                $no++;
            }
            $tb .= "</tbody>";
            echo $tb;
        } else {
            echo "<center>No Data</center>";
        }
    }

    public function edit_sop()
    {
        $id = $this->input->post('id');
        $result = $this->M_bl->sop_get(['t_sop.id' => $id])->row_array();
        echo json_encode($result);
    }

    public function sop_delete($value = '')
    {
        $id = $this->input->post('id');
        $this->M_bl->sop_delete($id);
    }

    public function log_view()
    {
        $this->load->view('approval/log_view');
    }

    public function get_ajax_list_approval($dataId = '')
    {
        $moduleKode = 'msr';
        if (!$dataId)
            $dataId = $this->input->post('data_id');

        $rows = $this->M_approval->list($moduleKode, $dataId);
        $data['rows'] = $rows;
        $userId = $this->session->userdata('ID_USER');
        $cek = $this->db->where('ID_USER', $userId)->get('m_user')->row();
        $roles = explode(",", $cek->ROLES);
        $data['roles'] = array_values(array_filter($roles));
        $data['data_id'] = $dataId;
        $this->load->view('approval/approval_list_ajax', $data);
    }

    public function sop_copy($value = '')
    {
        $this->M_bl->sop_copy();
    }

    public function can_perform_n_submit_admin_evaluation($msr_no = '')
    {
        $ed = $this->db->where(['msr_no' => $msr_no])->get('t_eq_data')->row();
        $can_perform_n_submit_admin_evaluation = can_perform_n_submit_admin_evaluation($ed);
        if ($can_perform_n_submit_admin_evaluation == true) {
            echo 1;
        } else {
            echo 2;
        }
    }

    /*public function can($msr_no='', $param='')
    {
        $ed = $this->db->where(['msr_no'=>$msr_no])->get('t_eq_data')->row();
        $can = can($ed,$param);
        if($can == true)
        {
            echo 1;
        }
        else
        {
            echo 2;
        }
    }*/
    public function sop_doc_validation($msr_no = '')
    {
        $sql = "select count(id) jml from t_upload where module_kode='bled' and data_id = '$msr_no' and tipe = 0";
        $query = $this->db->query($sql)->row();
        $attachment0 = $query->jml;

        $sql = "select count(id) jml from t_upload where module_kode='bled' and data_id = '$msr_no' and tipe = 2";
        $query = $this->db->query($sql)->row();
        $attachment2 = $query->jml;

        $sql = "select count(id) jml from t_upload where module_kode='bled' and data_id = '$msr_no' and tipe between 3 and 12";
        $query = $this->db->query($sql)->row();
        $attachmentE = $query->jml;
        /*SOP*/
        $query = $this->M_bl->getSopValidation($msr_no)->num_rows();
        $sop = $query;

        /*msr_item*/
        $t_msr_item = $this->db->where('msr_no', $msr_no)->get('t_msr_item')->num_rows();

        $validEd = [
            'subject' => 'Subject',
            'prebid_loc' => 'Pre Bid Location',
            'prebid_address' => 'Pre Bid Address',
            'closing_date' => 'Closing Date',
            'bid_validity' => 'Bid Validty',
        ];
        $d = $this->input->post();

        if ($attachment0 > 0 and $attachment2 > 0 and $attachmentE > 0 and $sop == $t_msr_item and $d['subject'] and $d['prebid_loc'] and $d['prebid_address'] and $d['closing_date'] and $d['bid_validity']) {
            $status = false;
        } else {
            $status = true;
        }

        $data['html'] = $this->load->view('approval/sop_doc_validation', [
            'msr_no' => $msr_no,
            'validEd' => $validEd,
            'attachment0' => $attachment0,
            'attachment2' => $attachment2,
            'attachmentE' => $attachmentE,
            'sop' => $sop,
            't_msr_item' => $t_msr_item,
            'p' => $d,
        ], true);
        $data['status'] = $status;
        echo json_encode($data);
    }

    public function ed_approved($value = '')
    {
        $ed_approved = $this->M_approval->ed_approved();
        return $ed_approved;
        /*echo "<pre>";
        print_r($ed_approved);*/
    }

    public function scoring($value = '')
    {
        $d = $this->input->post();
        $this->db->where(['id' => $d['bl_detail_id']]);
        $this->db->update('t_bl_detail', ['scoring' => $d['n']]);
        echo $d['n'];
        // echo json_encode(['value']);
    }

    public function reject_award()
    {
        $result = $this->M_approval->reject_award();
        if ($result) {
            echo json_encode(['msg' => 'Rejected']);
        } else {
            echo json_encode(['msg' => 'Something Wrong, Please Try Again']);
        }
    }

    public function addendum_bled_list()
    {
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;

        $data['addendum'] = $this->db->select('t_eq_data.*, t_bl.bled_no, m_msrtype.MSR_DESC as msr_type, m_company.DESCRIPTION as company, m_departement.DEPARTMENT_DESC as department, m_user.NAME as creator, t_eq_data.closing_date, specialist.NAME as specialist')
            ->join('t_approval', 't_approval.data_id = t_msr.msr_no AND t_approval.status = 1 AND t_approval.m_approval_id=13')
            ->join('t_bl', 't_bl.msr_no = t_msr.msr_no')
            ->join('t_eq_data', 't_eq_data.msr_no = t_msr.msr_no')
            ->join('m_msrtype', 'm_msrtype.ID_MSR = t_msr.id_msr_type')
            ->join('m_company', 'm_company.ID_COMPANY = t_msr.id_company')
            ->join('m_user', 'm_user.ID_USER = t_msr.create_by')
            ->join('m_departement', 'm_departement.ID_DEPARTMENT = m_user.ID_DEPARTMENT')
            ->join('t_assignment', 't_assignment.msr_no = t_msr.msr_no')
            ->join('m_user specialist', 'specialist.ID_USER = t_assignment.user_id')
            ->where('t_eq_data.bid_opening', 0)
            ->where('t_assignment.user_id', $this->session->userdata('ID_USER'))
            ->get('t_msr')
            ->result();
        $this->template->display('approval/addendum_bled_list', $data);
    }

    public function addendum_bled($msr_no = '', $approval_id = '')
    {
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        $this->load->model('vendor/M_registered_supplier', 'mrs')
            ->model('procurement/M_msr', 'msr')
            ->model('setting/M_itemtype', 'mit')
            ->model('setting/M_itemtype_category', 'mic')
            ->model('setting/M_master_acc_sub', 'mmas')
            ->model('setting/M_master_costcenter', 'mcc');
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;

        $greetings = $this->M_approval->greetings_msr();
        $data['greetings'] = $greetings;
        $data['idnya'] = $approval_id;
        $data['msr_no'] = $msr_no;
        $data['msr'] = $this->db->select('t_msr.*,m_company.DESCRIPTION company_name,m_msrtype.MSR_DESC msr_name, m_plocation.PGroup_Desc proc_location_name, t_msr.costcenter_desc cost_center_name, m_pmethod.PMETHOD_DESC proc_method_name, m_currency.CURRENCY currency')
            ->join('m_company', 'm_company.ID_COMPANY=t_msr.id_company')
            ->join('m_msrtype', 'm_msrtype.ID_MSR=t_msr.id_msr_type')
            ->join('m_plocation', 'm_plocation.ID_Pgroup=t_msr.id_ploc')
            ->join('m_user', 'm_user.ID_USER=t_msr.create_by')
            ->join('m_costcenter', 'm_costcenter.ID_COSTCENTER=m_user.COST_CENTER')
            ->join('m_pmethod', 'm_pmethod.ID_PMETHOD=t_msr.id_pmethod')
            ->join('m_currency', 'm_currency.ID=t_msr.id_currency')
            ->where('msr_no', $msr_no)->get('t_msr')->row();
        $data['approval'] = $this->db->select('t_approval.*,m_approval.role_id')
            ->join('m_approval', 'm_approval.id=t_approval.m_approval_id')
            ->where('t_approval.id', $approval_id)
            ->get('t_approval')->row();
        $data['method'] = $this->db->get('m_pmethod')->result();
        $data['doc'] = $this->db->where(['module_kode' => 'bled', 'data_id' => $msr_no])->get('t_upload')->result();
        $data['t_bl'] = $this->db->where(['msr_no' => $msr_no])->get('t_bl')->row();
        $data['ed'] = $this->db->where(['msr_no' => $msr_no])->get('t_eq_data')->row();
        $data['tbmi2'] = $this->M_bl->tbmi2($msr_no);
        $data['opt_itemtype'] = array_pluck($this->mit->allActive(), 'ITEMTYPE_DESC', 'ID_ITEMTYPE');
        $data['opt_accountsub'] = array_pluck($this->mmas->allActive(), 'ACCSUB_DESC', 'ID_ACCSUB');
        $data['opt_invtype'] = array_pluck($this->msr->m_msr_inventory_type(), 'description', 'id');
        $data['opt_itemtype'] = array('' => 'Please Select') + @$data['opt_itemtype'];
        $data['opt_accountsub'] = array('' => 'Please Select') + @$data['opt_accountsub'];
        $data['opt_invtype'] = array('' => 'Please Select') + @$data['opt_invtype'];

        $data['opt_costcenter'] = array('' => 'Please Select');
        $cc = $this->mcc->find_by_company($data['msr']->id_company);
        if ($cc) {
            foreach ($cc as $key => $value) {
                $data['opt_costcenter'][$value->ID_COSTCENTER] = $value->ID_COSTCENTER . ' - ' . $value->COSTCENTER_DESC;
            }
        }

        $itemtype_category = $this->mic->byParentCategory();
        $data['opt_itemtype_category_by_parent'] = array_map(function ($category) {
            return array_pluck($category, 'description', 'id');
        }, $itemtype_category);
        $data['opt_itemtype_category'] = array_pluck($this->mic->allActive(), 'description', 'id');
        $this->session->set_userdata('referred_from', current_url());
        $data['checkBlEd'] = $this->checkBlEd($msr_no);
        $data['js'] = $this->load->view('approval/devbledjs', array(), true);
        $data['addendum'] = $this->db->select('t_addendum.*, m_user.NAME as creator')
            ->join('m_user', 'm_user.ID_USER = t_addendum.created_by')
            ->where('module', 'bled')
            ->where('id_ref', $msr_no)
            ->order_by('created_at', 'desc')
            ->get('t_addendum')
            ->result();
        $this->template->display('approval/addendum_bled', $data);
    }

    public function unlock_sop($msr_no)
    {
        $bled_no = str_replace('OR', 'QR', $msr_no);
        $this->db->where('bled_no', $bled_no)->delete('t_bid_head');
        $this->db->where('bled_no', $bled_no)->delete('t_bid_detail');
        $this->db->where('bled_no', $bled_no)->delete('t_bid_bond');
        echo json_encode(array(
            'success' => true
        ));
    }

    public function negotiation()
    {
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        $this->load->model('vendor/M_registered_supplier', 'mrs');
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $data['rs_ed'] = $this->db->select('t_eq_data.*, t_msr.title, m_msrtype.MSR_DESC as msr_type, m_company.DESCRIPTION as company, m_departement.DEPARTMENT_DESC as department, m_user.NAME as requestor')
            ->join('t_msr', 't_msr.msr_no = t_eq_data.msr_no')
            ->join('m_msrtype', 'm_msrtype.ID_MSR = t_msr.id_msr_type')
            ->join('m_company', 'm_company.ID_COMPANY = t_msr.id_company')
            ->join('m_user', 'm_user.ID_USER = t_msr.create_by')
            ->join('m_departement', 'm_departement.ID_DEPARTMENT = m_user.ID_DEPARTMENT')
            ->join('t_assignment', 't_assignment.msr_no = t_msr.msr_no')
            ->where('t_eq_data.administrative <=', 5)
            ->where('t_eq_data.technical <=', 5)
            ->where('t_eq_data.commercial', 0)
            ->where('t_eq_data.award', 0)
            ->where('t_eq_data.bid_opening', 1)
            ->where('t_assignment.user_id', $this->session->userdata('ID_USER'))
            ->get('t_eq_data')
            ->result();
        $this->template->display('approval/negotiation', $data);
    }

    public function negotiation_detail($msr_no)
    {
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;

        $data['ed'] = $this->db->select('t_eq_data.*, t_bl.bled_no, t_msr.title, t_msr.total_amount, m_msrtype.MSR_DESC as msr_type, m_company.DESCRIPTION as company, m_departement.DEPARTMENT_DESC as department, m_user.NAME as requestor, m_currency.CURRENCY as currency')
            ->join('t_bl', 't_bl.msr_no = t_eq_data.msr_no')
            ->join('t_msr', 't_msr.msr_no = t_eq_data.msr_no')
            ->join('m_currency', 'm_currency.ID = t_eq_data.currency')
            ->join('m_msrtype', 'm_msrtype.ID_MSR = t_msr.id_msr_type')
            ->join('m_company', 'm_company.ID_COMPANY = t_msr.id_company')
            ->join('m_user', 'm_user.ID_USER = t_msr.create_by')
            ->join('m_departement', 'm_departement.ID_DEPARTMENT = m_user.ID_DEPARTMENT')
            ->join('t_assignment', 't_assignment.msr_no = t_msr.msr_no')
            ->where('t_eq_data.msr_no', $msr_no)
            ->get('t_eq_data')
            ->row();
        $data['rs_bl'] = $this->db->select('m_vendor.*')
            ->join('m_vendor', 'm_vendor.ID = t_bl_detail.vendor_id')
            ->where('t_bl_detail.msr_no', $msr_no)
            ->get('t_bl_detail')
            ->result();
        $data['rs_item'] = $this->db->where('t_sop.msr_no', $msr_no)
            ->get('t_sop')
            ->result();
        $rs_sop_bid = $this->db->select('
            t_sop_bid.*,
            CASE
                WHEN (SELECT COUNT(1)
                    FROM t_nego_detail
                    JOIN t_nego on t_nego.id = t_nego_detail.nego_id
                    WHERE t_nego_detail.sop_id = t_sop_bid.sop_id
                    AND t_nego_detail.vendor_id = t_sop_bid.vendor_id
                    AND (t_nego.status = 0 AND t_nego.closed = 0)
                ) > 0 THEN \'0\'
                ELSE \'1\'
            END as status
        ')
            ->where('t_sop_bid.msr_no', $msr_no)
            ->get('t_sop_bid')
            ->result();
        $data['sop_bid'] = array();
        foreach ($rs_sop_bid as $r_sop_bid) {
            $data['sop_bid'][$r_sop_bid->vendor_id][$r_sop_bid->sop_id] = $r_sop_bid;
        }
        $this->template->display('approval/negotiation_detail', $data);
    }

    public function negotiation_request($msr_no)
    {
        $post = $this->input->post();
        $response = array();
        if ($_FILES['supporting_document']['tmp_name']) {
            $config['upload_path'] = './upload/NEGOTIATION';
            $config['allowed_types'] = 'pdf|jpg|jpeg|doc|docx';
            $config['max_size'] = '2048';
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('supporting_document')) {
                $response = array(
                    'success' => false,
                    'message' => $this->upload->display_errors()
                );
                echo json_encode($response);
                return false;
            }
            $uploaded = $this->upload->data();
        }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('company_letter_no', 'Document Letter No', 'required|is_unique[t_nego.company_letter_no]');
        $this->form_validation->set_rules('closing_date', 'Closing Date', 'required');
        $this->form_validation->set_rules('nego[][]', 'Negotiation', 'required');
        if (!$this->form_validation->run()) {
            $response = array(
                'success' => false,
                'message' => validation_errors('<div>', '</div>')
            );
            echo json_encode($response);
            return false;
        }
        if (isset($post['nego'])) {
            $created_at = date('Y-m-d H:i:S');
            foreach ($post['nego'] as $vendor_id => $nego) {
                $this->db->insert('t_nego', array(
                    'msr_no' => $msr_no,
                    'vendor_id' => $vendor_id,
                    'company_letter_no' => $post['company_letter_no'],
                    'closing_date' => date('Y-m-d H:i', strtotime($post['closing_date'])),
                    'supporting_document' => @$uploaded['file_name'],
                    'note' => $post['note'],
                    'created_by' => $this->session->userdata('ID_USER'),
                    'created_at' => $created_at
                ));
                $nego_id = $this->db->insert_id();
                foreach ($post['sop_bid'][$vendor_id] as $sop_id => $sop_bid) {
                    if ($sop_bid['nego_price'] > 0) {
                        $negotiated_price = $sop_bid['nego_price'];
                        $negotiated_price_base = $sop_bid['nego_price_base'];
                    } else {
                        $negotiated_price = $sop_bid['unit_price'];
                        $negotiated_price_base = $sop_bid['unit_price_base'];
                    }
                    $this->db->insert('t_nego_detail', array(
                        'nego_id' => $nego_id,
                        'msr_no' => $msr_no,
                        'vendor_id' => $vendor_id,
                        'sop_id' => $sop_id,
                        'id_currency' => $sop_bid['id_currency'],
                        'id_currency_base' => $sop_bid['id_currency_base'],
                        'latest_price' => $negotiated_price,
                        'latest_price_base' => $negotiated_price_base,
                        'negotiated_price' => (@$nego[$sop_id]) ? null : $negotiated_price,
                        'negotiated_price_base' => (@$nego[$sop_id]) ? null : $negotiated_price_base,
                        'nego' => (@$nego[$sop_id]) ? 1 : 0,
                    ));
                }
            }
            $img1 = '';
            $img2 = '';

            $query = $this->db->query('SELECT ed.msr_no, ed.subject as ed_title, n.TITLE AS title, n.OPEN_VALUE AS open, n.CLOSE_VALUE AS close FROM t_eq_data ed
            JOIN m_notic n ON n.ID = 82
            WHERE ed.msr_no = "' . $msr_no . '"');

            $data_replace = $query->result();

            $str = $data_replace[0]->open;
            $str = str_replace('_var1_', $data_replace[0]->ed_title, $str);
            $str = str_replace('_var2_', str_replace('R', 'Q', $data_replace[0]->msr_no), $str);

            $data = array(
                'img1' => $img1,
                'img2' => $img2,
                'title' => $data_replace[0]->title,
                'open' => $str,
                'close' => $data_replace[0]->close
            );

            foreach ($post['nego'] as $vendID => $item) {
                $data_vnd = $this->db->query('SELECT * FROM m_vendor WHERE ID = ' . $vendID)->row();
                $data['dest'][] = $data_vnd->ID_VENDOR;
            }
            $flag = $this->sendMail($data);
        }
        $response = array(
            'success' => true,
            'message' => 'Success request negotiation',
            'sendmail' => $flag
        );
        echo json_encode($response);
    }

    public function evaluation($msr_no = '')
    {
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;

        $userId = $this->session->userdata('ID_USER');
        $cek = $this->db->where('ID_USER', $userId)->get('m_user')->row();
        $roles = explode(",", $cek->ROLES);
        $data['roles'] = array_values(array_filter($roles));
        // $roles              = array_values(array_filter($roles));

        $greetings = $this->M_approval->greetings_msr();
        $data['greetings'] = $greetings;
        $data['msr_no'] = $msr_no;
        $data['msr'] = $this->db->select('t_msr.*,m_company.DESCRIPTION company_name,m_msrtype.MSR_DESC msr_name, m_plocation.PGroup_Desc proc_location_name, t_msr.costcenter_desc cost_center_name, m_pmethod.PMETHOD_DESC proc_method_name, m_currency.CURRENCY currency')
            ->join('m_company', 'm_company.ID_COMPANY=t_msr.id_company')
            ->join('m_msrtype', 'm_msrtype.ID_MSR=t_msr.id_msr_type')
            ->join('m_plocation', 'm_plocation.ID_Pgroup=t_msr.id_ploc')
            ->join('m_user', 'm_user.ID_USER=t_msr.create_by')
            ->join('m_costcenter', 'm_costcenter.ID_COSTCENTER=m_user.COST_CENTER')
            ->join('m_pmethod', 'm_pmethod.ID_PMETHOD=t_msr.id_pmethod')
            ->join('m_currency', 'm_currency.ID=t_msr.id_currency')
            ->where('msr_no', $msr_no)->get('t_msr')->row();
        $data['approval'] = $this->db->select('t_approval.*,m_approval.role_id')
            ->join('m_approval', 'm_approval.id=t_approval.m_approval_id')
            ->get('t_approval')->row();
        $data['listApprovalAward'] = $this->M_approval->listApprovalAward($msr_no)->result();
        $data['method'] = $this->db->get('m_pmethod')->result();
        $data['doc'] = $this->db->where(['module_kode' => 'bled', 'data_id' => $msr_no])->get('t_upload')->result();
        $data['t_bl'] = $this->db->where(['msr_no' => $msr_no])->get('t_bl')->row();
        $data['bled_no'] = $data['t_bl']->bled_no;
        $data['blDetails'] = $this->vendor_lib->blDetail($msr_no);
        $data['ed'] = $this->db->select('*,(CASE WHEN now() >= closing_date THEN 1 ELSE 0 END) noting')->where(['msr_no' => $msr_no])->get('t_eq_data')->row();

        if ($data['ed']->administrative == 1 or $data['ed']->administrative == 3 or $data['ed']->administrative == 4) {
            if (in_array(assign_sp, $data['roles'])) {
                $this->db->where(['msr_no' => $msr_no]);
                $data['approved_administration'] = $this->M_approval->evaluationToBeApproved('administrative', [1, 3, 4])->row();
                $data['adminAttachment'] = $this->M_approval->seeAttachment('eva-administrative', $msr_no)->row();
            }
        }
        if ($data['ed']->technical == 1 or $data['ed']->technical == 3 or $data['ed']->technical == 4) {
            if (in_array(user_manager, $data['roles'])) {
                $this->db->where(['msr_no' => $msr_no]);
                $data['approved_technical'] = $this->M_approval->evaluationToBeApproved('technical', [1, 3, 4])->row();
                $data['technicalAttachment'] = $this->M_approval->seeAttachment('eva-technical', $msr_no)->row();
            }
        }
        if ($data['ed']->commercial == 1 or $data['ed']->commercial == 3 or $data['ed']->commercial == 4) {
            if (in_array(assign_sp, $data['roles'])) {
                $this->db->where(['msr_no' => $msr_no]);
                $data['approved_commercial'] = $this->M_approval->evaluationToBeApproved('commercial', [1, 3, 4])->row();
                $data['commercialAttachment'] = $this->M_approval->seeAttachment('eva-commercial', $msr_no)->row();
            }
        }

        /*print_r($data['ed']);
        exit();*/
        $this->session->set_userdata('referred_from', current_url());
        $data['checkBlEd'] = $this->checkBlEd($msr_no);
        // $data['vendor']  = $this->mrs->show2();
        $data['js'] = $this->load->view('approval/devbledjs', array(), true);
        $data['msrItem'] = $this->vendor_lib->msrItemTobeAdmin($msr_no);
        /*echo $this->db->last_query();
        exit();*/
        if ($this->M_approval->commercial()->num_rows() > 0) {
            $data['commercial'] = 1;
        }

        $this->template->display('approval/evaluation', $data);
    }

    public function evaluation_checker($value = '')
    {
        $post = $this->input->post();
        $field = $post['field'];
        $msr_no = $post['msr_no'];
        $blDetail = $this->db->where(['msr_no' => $msr_no, $field => 0, 'confirmed' => 1])->get('t_bl_detail');
        if ($blDetail->num_rows() > 0)
            echo json_encode(['msg' => 'Fail, Please Evaluation First', 'status' => false]);
        else
            echo json_encode(['status' => true]);
    }

    public function sumawardtotalvalue($msr_no = '')
    {
        $sumawardtotalvalue = $this->M_approval->sumawardtotalvalue($msr_no);
        echo $sumawardtotalvalue;
    }

    public function pc_approve($value = '')
    {
        echo "<pre>";
        print_r(pcApprove(false));
    }

    public function assign_reject()
    {
        $assignReject = $this->M_approval->assign_reject();
        if ($assignReject) {
            $this->session->set_flashdata('message', array(
                'message' => __('success_reject'),
                'type' => 'success'
            ));
            echo json_encode(['status' => true, 'msg' => 'Success, Assignment Rejected']);
        } else {
            echo json_encode(['status' => false]);
        }
    }

    public function will_cancel($msr_no = '')
    {
        $data['menu'] = $this->dt;
        $user = user();
        $roles = explode(",", $user->ROLES);
        $roles = array_values(array_filter($roles));
        $myroles = implode(',', $roles);

        if ($msr_no) {
            $data['msr'] = $this->db->where(['msr_no' => $msr_no])->get('t_msr')->row();
            $data['ed'] = $this->db->where(['msr_no' => $msr_no])->get('t_eq_data')->row();
            $data['currency'] = $this->db->where(['ID' => $data['msr']->id_currency])->get('m_currency')->row();
            $data['supplier'] = $this->M_bl->tbld($msr_no);
            $data['doc'] = $this->db->where(['module_kode' => 'msr-reject', 'data_id' => $msr_no])->get('t_upload')->result();
            $data['approval_list'] = $this->M_approval->approval_list_cancel_msr($msr_no);

            if (in_array(assign_sp, $roles)) {
                $data['approval_list'] = $this->M_approval->cancel_msr_list_approver($msr_no);
                $data['head'] = true;
            }
        } else {
            $data['msr'] = $this->db->query("select t_msr.* from t_msr where status != ? and msr_no not in (select msr_no from t_eq_data where award = ?)", [2, 9]);

            if (in_array(assign_sp, $roles)) {
                $data['msr'] = $this->db->where(['status' => 1])->get('t_msr');
                $data['head'] = true;

            }

        }
        $this->template->display('approval/will_cancel_list', $data);
    }

    public function cancel_msr_doc($value = '')
    {
        if ($this->input->get('delete')) {
            $data_id = $this->T_upload->hapus($value);
            $doc = $this->T_upload->getByKey(['module_kode' => 'msr-reject', 'data_id' => $data_id])->result();
        } elseif ($this->input->get('submit-cancel-msr')) {
            $this->M_approval->cancel_msr($value);
            exit();
        } elseif ($this->input->get('release')) {
            $this->M_approval->release_msr($value);
            exit();
        } elseif ($this->input->get('approve')) {
            $this->M_approval->approval_cancel_msr($value);
            exit();
        } else {
            $config['upload_path'] = './upload/cancel_msr/';
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0755, TRUE);
            }
            $config['allowed_types'] = '*';

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('file_path')) {
                echo $this->upload->display_errors('', '');
                exit;
            } else {
                $user = user();
                $data = $this->upload->data();
                $field = $this->input->post();
                $field['file_path'] = $data['file_name'];
                $field['created_by'] = $user->ID_USER;
                $this->db->insert('t_upload', $field);
            }
            // echo "<pre>";
            $doc = $this->T_upload->getByKey(['module_kode' => 'msr-reject', 'data_id' => $this->input->post('data_id')])->result();
            // echo $this->db->last_query();
            // print_r($doc);
        }
        foreach ($doc as $key => $value) {
            echo "<tr>
              <td>" . $value->tipe . "</td>
              <td>" . $value->file_path . "</td>
              <td>" . $value->created_at . "</td>
              <td>" . user($value->created_by)->NAME . "</td>
              <td>
                <a href='" . base_url('upload/cancel_msr/' . $value->file_path) . "' target='_blank' class='btn btn-sm btn-primary'>Download</a>
                <a href='#' class='btn btn-sm btn-danger' onclick='hapusFile($value->id)'>Hapus</a>
              </td>
            </tr>";
        }
    }
}