<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('vendor/M_vendor');
        $this->load->model('vendor/M_menu_task');
        $this->load->model('vendor/M_all_intern','mai');
        $this->load->model('approval/M_approval')
            ->model('approval/M_bl')
            ->model('procurement/M_itp_approval')
            ->model('procurement/M_loi')
            ->model('procurement/M_purchase_order')
            ->model('procurement/M_msr')
            ->model('procurement/M_msr_draft')
            ->model('procurement/M_arf_notif_preparation')
            ->model('material/M_material_req_approval')
            ->model('material/M_material_revision_approval')
            ->model('material/M_mregist_approval')
            ->model('procurement/M_arf_notif_approval')
            ->model('procurement/M_cpm_approval')
            ->model('procurement/M_cor_approval')
            ->model('m_base')
            ->model('m_clarification')
            ->model('procurement/arf/T_approval_arf_recom')
            ->model('procurement/arf/m_arf')
            ->model('procurement/arf/m_arf_response')
            ->model('procurement/arf/m_arf_acceptance')
            ->model('procurement/arf/m_arf_nego')
            ->model('setting/M_jabatan')
            ->model('vendor/M_approval_verification')
            ->model('cmms/M_wo_jde','wo')
            ->model('cmms/M_work_request','wr')
            ->helper(['permission', 'form']);
    }

    public function index() {
        $user = user();
        $roles              = explode(",", $user->ROLES);
        $roles      = array_values(array_filter($roles));

        $get_menu = $this->M_vendor->menu();
        $notif=$this->mai->get_notification($this->session->userdata['ID_USER']);
        if($notif)
            $data['notif']=$notif;
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $rs_menu_task = $this->M_menu_task->get();
        $greetings = $this->M_approval->greetings_msr();
        $msrVerify = $this->M_approval->greetings_msr_verify();
        $awarder_acceptance = $this->M_bl->awarders(null, array('resource' => true));
        // $loi_to_approve = $this->M_loi->toApprove(array('resource' => true));
        // $loi_to_issue = $this->M_loi->toIssue(array('resource' => true));
        $po_to_approve = $this->M_purchase_order->toApprove(array('resource' => true));
        $po_to_issue = $this->M_purchase_order->toIssue(array('resource' => true));
        $msr_draft = $this->M_msr_draft->getPrimarySecondaryByUserId($this->session->userdata['ID_USER'], array('resource' => true));
        $cpm_approval = $this->M_cpm_approval->get_list_home(0);
        $cpm_issuance = $this->M_cpm_approval->get_list_home(1);
        $cpm_scoredraft = $this->M_cpm_approval->get_list_home(2);
        $cor_approval = $this->M_cor_approval->get_list_home(0);
        $cor_perform = $this->M_cor_approval->get_list_home(1);
        $cor_confirm = $this->M_cor_approval->get_list_home(2);

        $itp_approval = $this->M_itp_approval->list_itp_onprogress();
        $sr_approval = $this->db
            ->from(
                '(SELECT id_ref, MIN(sequence) AS sequence FROM t_approval_service_receipt WHERE status = 0 OR status = 2 GROUP BY id_ref) approval'
            )
            ->join('t_approval_service_receipt', 't_approval_service_receipt.id_ref = approval.id_ref AND t_approval_service_receipt.sequence = approval.sequence')
            ->join('t_service_receipt', 't_service_receipt.id = t_approval_service_receipt.id_ref')
            ->join('t_itp', 't_itp.id_itp = t_service_receipt.id_itp')
            ->join('t_purchase_order', 't_purchase_order.po_no = t_itp.no_po')
            ->join('t_bl_detail', 't_bl_detail.id = t_purchase_order.bl_detail_id')
            ->join('m_vendor', 'm_vendor.ID = t_itp.id_vendor')
            ->join('m_user', 'm_user.ID_USER = t_service_receipt.created_by')
            ->where('approval.sequence > ', 1)
            ->where_in('t_approval_service_receipt.id_user_role', $roles)
            ->where($this->session->userdata('ID_USER') .' LIKE t_approval_service_receipt.id_user')
            ->where('t_service_receipt.cancel', 0)
            ->count_all_results();

        $msrVerify['msr_approval'] = $greetings;
        $msrVerify['msr_draft'] = $msr_draft;
        if (can_edit_msr_budget_status()) {
            $msrVerify['insufficient_msr'] = $this->M_msr->getInsufficients(['resource' => true]);
        }
        $msrVerify['itp_approval'] = $itp_approval;
        $msrVerify['sr_approval'] = $sr_approval;
        $msrVerify['awarder_acceptance'] = $awarder_acceptance;
        //$msrVerify['loi_to_approve'] = $loi_to_approve;
        //$msrVerify['loi_to_issue'] = $loi_to_issue;
        $this->db->where(['is_show'=>0]);
        $msrVerify['loi_accepted'] = $this->M_loi->accepted(null, array('resource' => true));
        $msrVerify['arf_notif_preparation'] = $this->M_arf_notif_preparation->get_list_prepare();
        $msrVerify['arf_notif_approval'] = $this->M_arf_notif_approval->get_list();
        $msrVerify['po_to_approve'] = $po_to_approve;
        $msrVerify['po_to_issue'] = $po_to_issue;
        $msrVerify['cpm_approval'] = $cpm_approval;
        $msrVerify['cpm_scoredraft'] = $cpm_scoredraft;
        $msrVerify['cpm_issuance'] = $cpm_issuance;
        $msrVerify['cor_approval'] = $cor_approval;
        $msrVerify['cor_perform'] = $cor_perform;
        $msrVerify['cor_confirm'] = $cor_confirm;
        //$msrVerify['po_to_issue'] = $po_to_issue;
        $msrVerify['accepted_po'] = $this->M_purchase_order->toBeAcceptCompleted(null, [ 'resource' => true ]);
        $msrVerify['mr_app'] = $this->M_material_req_approval->datatable_mr();
        $msrVerify['cnr_app'] = $this->M_mregist_approval->get_list();
        $msrVerify['cnrr_app'] = $this->M_material_revision_approval->get_list();
        $msrVerify['supp_verif'] = $this->M_approval_verification->show();

        $datas = $this->db->query(
            "SELECT b.module,r.description as jabatan, a.id, a.supplier_id, b.user_roles, b.status_approve, b.sequence,
            CASE WHEN count(j.id) > 0
                THEN CONCAT(b.description, ' (DATA DITOLAK)')
                ELSE b.description
            END as description, b.reject_step, v.nama, v.ID_VENDOR, v.CREATE_TIME, v.FILE
            FROM (
                SELECT MIN(id) as id, supplier_id, MIN(sequence) as sequence from t_approval_supplier
                WHERE (status_approve = 0 or status_approve = 2) and extra_case = 0
                GROUP BY supplier_id
            ) a
            JOIN t_approval_supplier b on b.supplier_id = a.supplier_id and b.id = a.id
            JOIN m_vendor v on v.id = b.supplier_id
            JOIN m_user_roles r on r.ID_USER_ROLES=b.user_roles
            LEFT JOIN t_approval_supplier j on j.supplier_id = b.supplier_id and j.status_approve = 2
            WHERE b.user_roles in (".substr($_SESSION['ROLES'],1,-1).") AND v.STATUS != '0' AND b.sequence <= 3 and b.module=1
            GROUP BY b.module,r.description, a.id, a.supplier_id, b.user_roles, b.status_approve, b.sequence, b.description, b.reject_step, v.nama, v.ID_VENDOR, v.CREATE_TIME");

        $msrVerify['supp_app'] = $datas->result_array();

        if(in_array(bled,$roles))
        {
            $msrVerify['ed_clarification'] = $this->m_clarification->scope('unread_ed')->get();
            $msrVerify['bid_proposal_clarification'] = $this->m_clarification->scope('unread_bid_proposal')->get();
            $msrVerify['arf_recom_issued'] = $this->T_approval_arf_recom->time_issued()->num_rows();
        }
        if(in_array(assign_sp, $roles))
        {
            $msrVerify['arf_recom_approval'] = $this->T_approval_arf_recom->greetings();
        }
        if(in_array(proc_committe, $roles))
        {
            $msrVerify['arf_recom_approval'] = $this->T_approval_arf_recom->greetings();
            /*print_r($msrVerify['arf_recom_issued']);
            exit();*/
        }
        if(in_array(user_representative, $roles))
        {
            $msrVerify['arf_recom_approval'] = $this->T_approval_arf_recom->greetings();
            // $msrVerify['arf_reject'] = $this->m_arf->view('arf')->scope(['reject','auth'])->count_all_results();
        }
        if(in_array(user_manager, $roles))
        {
            $msrVerify['arf_recom_approval'] = $this->T_approval_arf_recom->greetings();
        }
        if(in_array(bled, $roles))
        {
            /*Negotiation Amendment Response*/
            $msrVerify['arf_nego_response'] = count($this->m_arf_response->view('arf_response')
                ->join('t_arf_nego','t_arf_nego.arf_response_id = t_arf_response.id','left')
                ->where('t_arf_nego.status',1)
                ->get());
            $msrVerify['arf_nego'] = count($this->m_arf_response->view('arf_response')->scope(['not_amd'])->get());
            $msrVerify['amd_reject'] = count($this->m_arf_response->view('arf_response')->scope(array('procurement_specialist','reject'))->get());
        }
        $jabatanUser = $this->M_jabatan->findByUser($this->session->userdata('ID_USER'));
        if(@$jabatanUser->user_role == t_jabatan_user_secondary)
        {
            $msrVerify['arf_draft'] = $this->m_arf->scope(array('roleeditsecondary','draft'))->count_all_results();
            $msrVerify['arf_reject'] = $this->m_arf->view('arf')->scope(['reject','roleeditsecondary','submitted'])->count_all_results();
            // echo $this->db->last_query();
        }
        elseif(@$jabatanUser->user_role == t_jabatan_user_primary)
        {
            $msrVerify['arf_draft'] = $this->m_arf->scope(array('roleeditprimary','draft'))->count_all_results();
            $msrVerify['arf_reject'] = $this->m_arf->view('arf')->scope(['reject','roleeditprimary','submitted'])->count_all_results();
            // echo $this->db->last_query();
        }
        // exit();
        // echo $this->db->last_query();
        $msrVerify['arf_approval'] = $this->m_arf->view('approval')->scope('approval')->count_all_results();
        $msrVerify['arf_verification'] = $this->m_arf->view('approval')->scope('verification')->count_all_results();
        $msrVerify['arf_assignment'] = $this->m_arf->scope('assignment')->count_all_results();
        $msrVerify['amendment_recommendation_preparation'] = $this->m_arf_response->view('arf_response')->scope(array('recommendation_preparation', 'procurement_specialist'))->count_all_results();
        $msrVerify['amendment_acceptance'] = $this->db->select('t_arf_acceptance.doc_no,t_arf.po_title title, t_arf.department department_desc,t_arf_notification.response_date,t_arf_response.responsed_at,m_user.NAME,t_arf_response.id')
            ->join('t_arf','t_arf.doc_no = t_arf_acceptance.doc_no', 'left')
            ->join('t_arf_assignment','t_arf_assignment.doc_id = t_arf.id', 'left')
            ->join('t_arf_response','t_arf_response.doc_no = t_arf.doc_no', 'left')
            ->join('t_arf_notification','t_arf_notification.doc_no = t_arf.doc_no', 'left')
            ->join('m_user','m_user.ID_USER = t_arf_assignment.user_id', 'left')
            ->where(['t_arf_acceptance.accepted_user_at'=>null])
            ->get('t_arf_acceptance')->num_rows();
        $msrVerify['amendment_reject'] = $this->m_arf->scope(array('auth', 'on_creator'))->count_all_results();
        //$msrVerify['out'] = 'out';

        $msrVerify['out_nego'] = $this->db->select('t_eq_data.*, t_msr.title, m_msrtype.MSR_DESC as msr_type, m_company.DESCRIPTION as company, m_departement.DEPARTMENT_DESC as department, m_user.NAME as requestor')
            ->join('t_msr', 't_msr.msr_no = t_eq_data.msr_no')
            ->join('m_msrtype', 'm_msrtype.ID_MSR = t_msr.id_msr_type')
            ->join('m_company', 'm_company.ID_COMPANY = t_msr.id_company')
            ->join('m_user', 'm_user.ID_USER = t_msr.create_by')
            ->join('m_departement', 'm_departement.ID_DEPARTMENT = m_user.ID_DEPARTMENT')
            ->join('t_assignment', 't_assignment.msr_no = t_msr.msr_no')
            ->join('t_nego', 't_nego.msr_no = t_msr.msr_no')
            ->where('t_nego.status', 1)
            ->where('t_nego.is_read', 0)
            ->where('t_assignment.user_id', $this->session->userdata('ID_USER'))
            ->get('t_eq_data')
            ->result();
        $msrVerify['out_nego'] = count($msrVerify['out_nego']);
//      $msrVerify['out_nego'] = '10000000';

        $msrVerify['po_reject'] = $this->M_purchase_order->reject_list()->where('create_by', $this->session->userdata('ID_USER'))->get()->num_rows();
        $get_task = $this->M_vendor->task();
        $get_task_baru = array();
        foreach($get_task as $row){
            array_push($get_task_baru,$row->id);
        }
        /*cmms tasks start*/
        $msrVerify['outstanding_wo_report'] = $this->wo->outstanding_wo_report()->num_rows();
        if(in_array(supervior_cmms, $roles))
        {
            $msrVerify['suprevisor_task'] = $this->wr->suprevisor_task()->num_rows();
        }
        /*cmms tasks end*/
        $menu_task = array();
        foreach ($this->db->where('parent', 0)->order_by('sort', 'asc')->get('m_menu_task')->result() as $r_group_menu_task) {
            if (in_array($r_group_menu_task->id, $get_task_baru)) {
                $menu_task[$r_group_menu_task->id] = array(
                    'key' => $r_group_menu_task->key,
                    'icon' => $r_group_menu_task->icon,
                    'desc_ind' => $r_group_menu_task->desc_ind,
                    'desc_eng' => $r_group_menu_task->desc_eng,
                    'count' => 0,
                    'open_on_zero' => $r_group_menu_task->open_on_zero,
                    'menu_keys' => array(),
                    'menus' => array()
                );
                foreach ($this->db->where('parent', $r_group_menu_task->id)->order_by('sort', 'asc')->get('m_menu_task')->result() as $r_sub_group_menu_task) {
                    if (in_array($r_sub_group_menu_task->id, $get_task_baru)) {

                        $menu_task[$r_group_menu_task->id]['menus'][$r_sub_group_menu_task->id] = array(
                            'key' => $r_sub_group_menu_task->key,
                            'icon' => $r_sub_group_menu_task->icon,
                            'desc_ind' => $r_sub_group_menu_task->desc_ind,
                            'desc_eng' => $r_sub_group_menu_task->desc_eng,
                            'count' => 0,
                            'open_on_zero' => $r_sub_group_menu_task->open_on_zero,
                            'menu_keys' => array(),
                            'menus' => array()
                        );

                        foreach ($this->db->where('parent', $r_sub_group_menu_task->id)->order_by('sort', 'asc')->get('m_menu_task')->result() as $r_menu_task) {
                            if (in_array($r_menu_task->id, $get_task_baru)) {

                                if ($r_menu_task->key) {
                                    if (isset($msrVerify[$r_menu_task->key])) {
                                        if ($r_menu_task->key == 'msr_draft') {
                                            if (can_edit_msr_draft()) {
                                                $menu_task[$r_group_menu_task->id]['menus'][$r_sub_group_menu_task->id]['count'] += $msrVerify[$r_menu_task->key]->num_rows();
                                            }
                                        } elseif ($r_menu_task->key == 'reject') {
                                            $menu_task[$r_group_menu_task->id]['menus'][$r_sub_group_menu_task->id]['count'] += $msrVerify[$r_menu_task->key];
                                        } else {
                                            if (is_array($msrVerify[$r_menu_task->key])) {
                                                $msrVerify[$r_menu_task->key] = count($msrVerify[$r_menu_task->key]);
                                            } elseif(is_numeric($msrVerify[$r_menu_task->key])) {
                                                $msrVerify[$r_menu_task->key] = $msrVerify[$r_menu_task->key];
                                            } else {
                                                $msrVerify[$r_menu_task->key] = $msrVerify[$r_menu_task->key]->num_rows();
                                            }
                                            $menu_task[$r_group_menu_task->id]['menus'][$r_sub_group_menu_task->id]['count'] += $msrVerify[$r_menu_task->key];
                                            $menu_task[$r_group_menu_task->id]['count'] += $msrVerify[$r_menu_task->key];
                                        }
                                        $menu_task[$r_group_menu_task->id]['menus'][$r_sub_group_menu_task->id]['menus'][] = $r_menu_task;
                                    }else{
                                        $menu_task[$r_group_menu_task->id]['menus'][$r_sub_group_menu_task->id]['menus'][] = $r_menu_task;
                                    }
                                } else {
                                    $menu_task[$r_group_menu_task->id]['menus'][$r_sub_group_menu_task->id]['menus'][] = $r_menu_task;
                                }


                            }
                        }
                    }
                }
            }
        }
        /*foreach ($rs_menu_task as $row) {
            if ($row->parent == 0) {
                $menu_task[$row->id] = array(
                    'key' => $row->key,
                    'desc_ind' => $row->desc_ind,
                    'desc_eng' => $row->desc_eng,
                    'count' => 0,
                    'open_on_zero' => $row->open_on_zero,
                    'menu_keys' => array(),
                    'menus' => array()
                );
            } else {
                if ($row->key) {
                    if (isset($msrVerify[$row->key])) {
                        if ($row->key == 'msr_draft') {
                            if (can_edit_msr_draft()) {
                                $menu_task[$row->parent]['count'] += $msrVerify[$row->key]->num_rows();
                            }
                        } elseif ($row->key == 'reject') {
                            $menu_task[$row->parent]['count'] += $msrVerify[$row->key];
                        } else {
                            if (is_array($msrVerify[$row->key])) {
                                $msrVerify[$row->key] = count($msrVerify[$row->key]);
                            } elseif(is_numeric($msrVerify[$row->key])) {
                                $msrVerify[$row->key] = $msrVerify[$row->key];
                            } else {
                                $msrVerify[$row->key] = $msrVerify[$row->key]->num_rows();
                            }
                            $menu_task[$row->parent]['count'] += $msrVerify[$row->key];
                        }
                        $menu_task[$row->parent]['menus'][] = $row;
                    }
                } else {
                    $menu_task[$row->parent]['menus'][] = $row;
                }
            }
        }*/
        $data['msr_verify'] = $msrVerify;
        $data['menu_task'] = $menu_task;

        $this->template->display('vendor/V_home', $data);
    }
}
