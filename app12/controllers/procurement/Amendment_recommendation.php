<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Amendment_recommendation extends CI_Controller {

    protected $menu;
    protected $document_path = 'upload/ARF';
    protected $document_allowed_types = 'jpg|jpeg|pdf|doc|docx';
    protected $document_max_size = '2048';

    public function __construct() {
        parent::__construct();
        $this->load->library('url_generator');
        $this->load->library('redirect');

        $this->load->model('vendor/M_vendor');
        $this->load->model('vendor/M_all_intern', 'mai');

        $this->load->model('m_base');
        $this->load->model('procurement/m_procurement');
        $this->load->model('procurement/arf/m_arf_sop');
        $this->load->model('procurement/arf/m_arf_response');
        $this->load->model('procurement/arf/m_arf_response_attachment');
        $this->load->model('procurement/arf/m_arf_po');
        $this->load->model('procurement/arf/m_arf_po_detail');
        $this->load->model('procurement/arf/m_arf_detail');
        $this->load->model('procurement/arf/m_arf_detail_revision');
        $this->load->model('procurement/arf/T_approval_arf_recom');
        $this->load->model('procurement/arf/T_arf_recommendation_preparation');
        $this->load->model('procurement/arf/m_arf_acceptance_document');
        $this->load->model('M_sendmail');

        $this->load->library('form');
        $this->load->helper('data_builder_helper');
        $this->load->helper('exchange_rate_helper');

        $this->mai->cek_session();
        $get_menu = $this->M_vendor->menu();
        $this->menu = array();
        foreach ($get_menu as $k => $v) {
            $this->menu[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $this->menu[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $this->menu[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $this->menu[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
    }

    public function arf_response() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('m_datatable');
            // $this->db->where('`t_arf_response`.`id` not in',"(select arf_response_id from t_arf_recommendation_preparation)", false);
            return $this->m_datatable->resource($this->m_arf_response)
            ->view('arf_response')->scope(array('recommendation_preparation', 'procurement_specialist'))
            ->add_column('status', function($model) {
                if (strtotime($model->close_date) > strtotime(date('Y-m-d'))) {
                    return 'Open';
                } else {
                    return 'Closed';
                }
            })
            ->generate();
        }
        $data['menu'] = $this->menu;
        $data['lists'] = $this->m_arf_response->view('arf_response')->scope(array('recommendation_preparation', 'procurement_specialist'))->get();
        $this->session->set_userdata('arf_recom_title','Amendment Recommendation Preparation');
        $this->template->display('procurement/V_amendment_recommendation_arf_response', $data);
    }

    public function create($id) {
        $arf = $this->m_arf_response->view('arf_response')->find_or_fail($id);
        $t_arf_notification = $this->db->where(['doc_no'=>$arf->doc_no])->get('t_arf_notification')->row();
        // $arf->item = $this->m_arf_detail->view('response_item')->where('doc_id', $arf->doc_id)->get();
        $arf->item = $this->m_arf_sop->view('response')->select('arf_nego.unit_price new_price')
        ->join("(select t_arf_nego_detail.unit_price, arf_nego.arf_response_id, t_arf_nego_detail.arf_sop_id from 
            (select * from t_arf_nego where status = 2 order by id desc limit 1) arf_nego
            left join t_arf_nego_detail on arf_nego.id = t_arf_nego_detail.arf_nego_id
            WHERE t_arf_nego_detail.is_nego = 1) arf_nego", "t_arf_sop.id = arf_nego.arf_sop_id", "left")
        ->where('t_arf_sop.doc_id', $t_arf_notification->id)->get();

        $findAll = $this->db->where(['po_no'=>$t_arf_notification->po_no, 'id < '=> $t_arf_notification->id])->get('t_arf_notification');
        
        $findAllResult = [];
        if($findAll->num_rows() > 0)
        {
            foreach ($findAll->result() as $r) {
                $findAllResult[$r->doc_no] = $this->m_arf_sop->view('response')
                ->select('arf_nego.unit_price new_price')
                ->join("(select t_arf_nego_detail.unit_price, arf_nego.arf_response_id, t_arf_nego_detail.arf_sop_id from 
                    (select * from t_arf_nego where status = 2 order by id desc limit 1) arf_nego
                    left join t_arf_nego_detail on arf_nego.id = t_arf_nego_detail.arf_nego_id
                    WHERE t_arf_nego_detail.is_nego = 1) arf_nego", "t_arf_sop.id = arf_nego.arf_sop_id", "left")
                ->where('t_arf_sop.doc_id', $r->id)->get();
            }
        }

        /*foreach ($this->m_arf_detail_revision->where('doc_id', $arf->doc_id)->get() as $revision) {
            $arf->revision[$revision->type] = $revision;
        }*/
        $markingType = [1=>'value', 2=>'time', 3=>'scope', 4=>'other'];
        foreach ($this->db->where('doc_id', $t_arf_notification->id)->get('t_arf_notification_detail_revision')->result() as $revision) {
            $arf->revision[$markingType[$revision->type]] = $revision;
        }
        $arf->response_attachment = $this->m_arf_response_attachment->where('t_arf_response_attachment.doc_id', $arf->doc_id)
        ->get();
        $po = $this->m_arf_po->where('t_purchase_order.po_no', $arf->po_no)
        ->first();
        $po->po_type = $this->m_arf_po->enum('type', $po->po_type);
        $po->item = $this->m_arf_po_detail->view('po_detail')
        ->where('t_purchase_order_detail.po_id', $po->id)
        ->get();
        $data = $this->T_arf_recommendation_preparation->view($id);
        $data['arf'] = $arf;
        $data['po'] = $po;
        $data['document_path'] = $this->document_path;
        $data['menu'] = $this->menu;
        $data['doc'] = $this->db->where(['module_kode'=>'arf-recom-prep','data_id'=>$arf->doc_no])->get('t_upload')->result();
        $data['view'] = false;
        $data['approval_view'] = false;
        $data['newAgreementPeriodTo'] = $this->newAgreementPeriodTo($arf);
        $data['title'] = $this->session->userdata('arf_recom_title') ? $this->session->userdata('arf_recom_title') : 'Amendment Recommendation Preparation';
        if($this->input->get('debug'))
        {
            echo $this->db->last_query();
        }
        $data['addTime'] = $this->addTime($arf,$po);
        if($this->input->get('debug'))
        {
            exit();
        }
        $data['approval_list'] = $this->approval_list($id);
        $data['findAllResult'] = $findAllResult;

        $findAll = $this->db->where(['po_no'=>$t_arf_notification->po_no, 'id <= '=> $t_arf_notification->id])->get('t_arf_notification');
        
        $findAllResult = [];
        if($findAll->num_rows() > 0)
        {
            foreach ($findAll->result() as $r) {
                $findAllResult[$r->doc_no] = $this->m_arf_sop->view('response')
                ->select('t_arf_nego_detail.unit_price new_price')
                ->join('t_arf_nego_detail', 't_arf_sop.id = t_arf_nego_detail.arf_sop_id', 'left')
                ->join('(select * from t_arf_nego where status = 2 order by id desc limit 1) t_arf_nego','t_arf_nego.id = t_arf_nego_detail.arf_nego_id', 'left')->where('t_arf_sop.doc_id', $r->id)->get();
            }
        }

        $data['findAllResult2'] = $findAllResult;
        
        $this->template->display('procurement/V_amendment_recommendation_create', $data);
    }
    public function attachment_upload($value='')
    {
        $config['upload_path']  = './upload/ARFRECOMPREP/';
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'],0755,TRUE);
        }
        $config['allowed_types']= '*';
        
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('file_path'))
        {
            echo $this->upload->display_errors('', '');exit;
        }else
        {
            $user = user();
            $data = $this->upload->data();
            $field = $this->input->post();
            $field['file_path'] = $config['upload_path'].$data['file_name'];
            $field['file_name'] = $data['file_name'];
            $field['created_by'] = $user->ID_USER;
            $this->db->insert('t_upload',$field);
        }
        $this->dt_attachment($this->input->post('module_kode'));
    }
    public function hapus_attachment($value='')
    {
        $this->db->where('id',$value);
        $upload = $this->db->get('t_upload')->row();
        $data_id = $upload->data_id;
        $_POST['data_id'] = $data_id;
        $module_kode = $upload->module_kode;
        @unlink($upload->file_path);

        $this->db->where('id',$value);
        $this->db->delete('t_upload');
        $this->dt_attachment($module_kode);
    }
    public function dt_attachment($module_kode='arf-recom-prep')
    {
        $doc = $this->db->where(['module_kode'=>$module_kode,'data_id'=>$this->input->post('data_id')])->get('t_upload')->result();
        $t_arf_response = $this->db->get('t_arf_response')->row();
        $time_issued = $this->T_approval_arf_recom->time_issued($t_arf_response->id)->num_rows();
        if($time_issued > 0)
        {
            $doc= $this->db->where(['data_id'=>$this->input->post('data_id')])->where_in('module_kode', ['arf-recom-prep', 'arf-issued'])->get('t_upload')->result();
        }
        foreach ($doc as $key => $value) {
            if($value->module_kode == 'arf-issued')
            {
                $type = arfIssuedDoc($value->tipe);
            }
            else
            {
                $type = arfRecomPrepType($value->tipe, true);
            }
            echo "<tr>
              <td>".$type."</td>
              <td>".$value->file_name."</td>
              <td>".$value->created_at."</td>
              <td>".user($value->created_by)->NAME."</td>
              <td>
                <a href='".base_url($value->file_path)."' target='_blank' class='btn btn-sm btn-primary'>Download</a>
                <a href='#' class='btn btn-sm btn-danger' onclick='hapusFile($value->id)'>Hapus</a>
              </td>
            </tr>";
        }
    }
    public function store($value='')
    {
        $this->db->trans_begin();
        $user = user();
        $data = $this->input->post();
        $t_arf_recommendation_preparation = $this->db->where(['arf_response_id'=>$data['arf_response_id']])->get('t_arf_recommendation_preparation')->row();
        $field = [
            'arf_response_id'   => $data['arf_response_id'],
            'doc_no'            => $data['doc_no'],
            'po_no'             => $data['po_no'],
            'analysis'          => $data['analysis'],
            'nego'              => $data['nego'],
            'nego_str'          => $data['nego_str'],
            'budget_analysis'   => $data['budget_analysis'],
            'bod_approval'      => $data['bod_approval'],
            'aa'                => $data['aa'],
            'extend1'           => @$data['extend1'] ? $data['extend1'] : 0,
            'extend2'           => @$data['extend2'] ? $data['extend2'] : 0,
            'new_date_1'        => @$data['new_date_1'] ? $data['new_date_1'] : null,
            'new_date_2'        => @$data['new_date_2'] ? $data['new_date_2'] : null,
            'remarks_1'         => @$data['remarks_1'] ? $data['remarks_1'] : null,
            'remarks_2'         => @$data['remarks_2'] ? $data['remarks_2'] : null,
            'status'            => 0,
            'created_at'        => date("Y-m-d H:i:s"),
            'created_by'        => $user->ID_USER,
        ];
        if($t_arf_recommendation_preparation)
        {
            $this->db->where(['id'=>$t_arf_recommendation_preparation->id]);
            $this->db->update('t_arf_recommendation_preparation', $field);
            $this->approval_update($data['doc_no'], $data['arf_response_id']);
        }
        else
        {
            $this->db->insert('t_arf_recommendation_preparation', $field);
            /*generate approval*/
            $this->approval($data['doc_no'], $data['arf_response_id']);
        }

        if($this->db->trans_status() === true)
        {
            $this->db->trans_commit();
            $img1 = '';
            $img2 = '';

            $query = $this->db->query("SELECT rec.description, arf.po_title, arf.doc_no, usr.NAME AS name, usr.EMAIL AS email, n.TITLE AS title, n.OPEN_VALUE AS open, n.CLOSE_VALUE AS close FROM t_approval_arf_recom rec
            JOIN t_arf_response resp ON rec.id_ref = resp.id
            JOIN t_arf arf ON resp.doc_no = arf.doc_no
            JOIN m_user usr ON usr.ID_USER = rec.id_user
            JOIN m_notic n ON n.ID = 93
            WHERE rec.sequence = 2 AND rec.id_ref = " . $data['arf_response_id']);
            if ($query->num_rows() > 0) {
                $data_replace = $query->result();
                $str = $data_replace[0]->open;
                $str = str_replace('title_agreement', $data_replace[0]->po_title, $str);
                $str = str_replace('no_arf', $data_replace[0]->doc_no, $str);

                $data = array(
                    'img1' => $img1,
                    'img2' => $img2,
                    'title' => $data_replace[0]->title,
                    'open' => $str,
                    'close' => $data_replace[0]->close
                );

                foreach ($data_replace as $item) {
                    $data['dest'][] = $item->email;
                }
                $flag = $this->M_sendmail->sendMail($data);
            }
            echo json_encode(['status'=>true,'msg'=>'Amendment Submitted']);
        }
        else
        {
            $this->db->trans_rollback();
            echo json_encode(['status'=>false,'msg'=>'Fail, Try Again']);
        }
    }
    public function approval($doc_no='', $arf_response_id='')
    {
        $rs = $this->db->where(['module'=>16,'status'=>1])->order_by('sequence', 'asc')->get('m_approval_rule')->result();
        $data = array();
        $arf = $this->db->where(['doc_no'=>$doc_no])->get('t_arf')->row();
        foreach ($rs as $r) {
            // $this->db->like('ROLES','')
            if($r->user_roles == 28)
            {
                $ps = $this->db->select('t_arf_assignment.*')
                ->join('t_arf','t_arf.po_no = t_arf_assignment.po_no')
                ->where(['doc_id'=>$arf->id])->get('t_arf_assignment')->row();
                $user = $ps->user_id;
            }
            if($r->user_roles == 23)
            {
                $m_user = $this->db->like('ROLES',$r->user_roles)->get('m_user')->row();
                $user = $m_user->ID_USER;
            }
            if($r->user_roles == 41)
            {
                $arf = $this->db->where(['doc_no'=>$doc_no])->get('t_arf')->row();
                $user = $arf->created_by;
            }
            if($r->user_roles == 18)
            {
                $id_user = $this->firstAas($arf->created_by)->user_id;
                $user = $id_user;
            }
            if($r->user_roles == 27)
            {
                /*PROCUREMENT COMMITEE*/ /*PROCUREMENT COMMITEE - CHAIRMAN*/
                $user = array();
                $myUser = $this->db->like('ROLES','27')->or_like('ROLES','100004')->where(['STATUS'=>1])->get('m_user')->result();
                foreach ($myUser as $u) {
                    $user[] = $u->ID_USER;
                }
            }
            if(is_array($user))
            {   
                foreach ($user as $u => $ser) {
                    $data[] = [
                        'id_ref' => $arf_response_id,
                        'id_user_role' => $r->user_roles,
                        'id_user' => $ser,
                        'sequence' => $r->sequence,
                        'description' => $r->description,
                        'note' => null,
                        'reject_step' => $r->reject_step,
                        'email_approve' => $r->email_approve,
                        'email_reject' => $r->email_reject,
                        'edit_content' => $r->edit_content,
                        'status' => 0,
                        'approved_by' => 0,
                        'approved_at' => null
                    ];
                }
            }
            else
            {
                $data[] = [
                    'id_ref' => $arf_response_id,
                    'id_user_role' => $r->user_roles,
                    'id_user' => $user,
                    'sequence' => $r->sequence,
                    'description' => $r->description,
                    'note' => null,
                    'reject_step' => $r->reject_step,
                    'email_approve' => $r->email_approve,
                    'email_reject' => $r->email_reject,
                    'edit_content' => $r->edit_content,
                    'status' => $r->sequence == 1 ? 1 : 0,
                    'approved_by' => 0,
                    'approved_at' => null
                ];
            }
        }
        if($this->input->get('debug'))
        {
            echo "<pre>";
            print_r($data);
        }
        else
        {
            $this->db->insert_batch('t_approval_arf_recom', $data);
        }
    }
    public function approval_view($value='')
    {
        if ($this->input->is_ajax_request()) {
            $this->load->library('m_datatable');
            return $this->m_datatable->resource($this->m_arf)
            ->view('approval')
            ->scope('approval')
            ->edit_column('po_type', function($model) {
                return $this->m_arf_po->enum('type', $model->po_type);
            })
            ->edit_column('status', function($model) {
                return $this->m_arf->enum('status', $model->status);
            })
            ->generate();
        }
        $data['menu'] = $this->menu;
        $data['lists'] = $this->T_approval_arf_recom->time_approval();
        $this->session->set_userdata('arf_recom_title','Amendment Recommendation Approval');
        $this->template->display('procurement/V_arf_recom_approval', $data);
    }
    public function view($id='')
    {
        $arf = $this->m_arf_response->view('arf_response')->find_or_fail($id);
        $t_arf_notification = $this->db->where(['doc_no'=>$arf->doc_no])->get('t_arf_notification')->row();
        $arf->item = $this->m_arf_sop->view('response')->select('t_arf_nego_detail.unit_price new_price')
        ->join('t_arf_nego_detail', 't_arf_sop.id = t_arf_nego_detail.arf_sop_id', 'left')
        ->join('(select * from t_arf_nego where status = 2 order by id desc limit 1) t_arf_nego','t_arf_nego.id = t_arf_nego_detail.arf_nego_id', 'left')->where('t_arf_sop.doc_id', $t_arf_notification->id)->get();

        $findAll = $this->db->where(['po_no'=>$t_arf_notification->po_no, 'id < '=> $t_arf_notification->id])->get('t_arf_notification');
        
        $findAllResult = [];
        if($findAll->num_rows() > 0)
        {
            foreach ($findAll->result() as $r) {
                $findAllResult[$r->doc_no] = $this->m_arf_sop->view('response')
                ->select('t_arf_nego_detail.unit_price new_price')
                ->join('t_arf_nego_detail', 't_arf_sop.id = t_arf_nego_detail.arf_sop_id', 'left')
                ->join('(select * from t_arf_nego where status = 2 order by id desc limit 1) t_arf_nego','t_arf_nego.id = t_arf_nego_detail.arf_nego_id', 'left')->where('t_arf_sop.doc_id', $r->id)->get();
            }
        }
        
        /*foreach ($this->m_arf_detail_revision->where('doc_id', $arf->doc_id)->get() as $revision) {
            $arf->revision[$revision->type] = $revision;
        }*/
        $markingType = [1=>'value', 2=>'time', 3=>'scope', 4=>'other'];
        foreach ($this->db->where('doc_id', $t_arf_notification->id)->get('t_arf_notification_detail_revision')->result() as $revision) {
            $arf->revision[$markingType[$revision->type]] = $revision;
        }
        $arf->response_attachment = $this->m_arf_response_attachment->where('t_arf_response_attachment.doc_id', $arf->doc_id)
        ->get();
        $po = $this->m_arf_po->where('t_purchase_order.po_no', $arf->po_no)
        ->first();
        $po->po_type = $this->m_arf_po->enum('type', $po->po_type);
        $po->item = $this->m_arf_po_detail->view('po_detail')
        ->where('t_purchase_order_detail.po_id', $po->id)
        ->get();
        $data = $this->T_arf_recommendation_preparation->view($id);
        $data['arf'] = $arf;
        $data['po'] = $po;
        $data['document_path'] = $this->document_path;
        $data['menu'] = $this->menu;
        $data['doc'] = $this->db->where(['module_kode'=>'arf-recom-prep','data_id'=>$arf->doc_no])->get('t_upload')->result();
        $data['view'] = true;
        $data['approval_list'] = $this->approval_list($id);
        $data['approval_count'] = $this->approval_list($id)->num_rows() > 0 ? "":"hidden";
        $data['newAgreementPeriodTo'] = $this->newAgreementPeriodTo($arf);
        $data['addTime'] = $this->addTime($arf,$po);
        $data['approval_view'] = true;

        $data['title'] = $this->session->userdata('arf_recom_title') ? $this->session->userdata('arf_recom_title') : 'Amendment Recommendation Preparation';

        $time_issued = $this->T_approval_arf_recom->time_issued($id)->num_rows();
        if($time_issued > 0)
        {
            if($this->input->get('amd_view'))
            {

            }
            else
            {
                $data['issued'] = $time_issued;
                $data['title'] = 'Amendment Issuance';
                $data['doc'] = $this->db->where(['data_id'=>$arf->doc_no])->where_in('module_kode', ['arf-recom-prep', 'arf-issued'])->get('t_upload')->result();
            }
        }
        $data['is_reject'] = $this->T_approval_arf_recom->is_reject($id);
        $data['findAllResult'] = $findAllResult;

        $findAll = $this->db->where(['po_no'=>$t_arf_notification->po_no, 'id <= '=> $t_arf_notification->id])->get('t_arf_notification');
        
        $findAllResult = [];
        if($findAll->num_rows() > 0)
        {
            foreach ($findAll->result() as $r) {
                $findAllResult[$r->doc_no] = $this->m_arf_sop->view('response')
                ->select('t_arf_nego_detail.unit_price new_price')
                ->join('t_arf_nego_detail', 't_arf_sop.id = t_arf_nego_detail.arf_sop_id', 'left')
                ->join('(select * from t_arf_nego where status = 2 order by id desc limit 1) t_arf_nego','t_arf_nego.id = t_arf_nego_detail.arf_nego_id', 'left')->where('t_arf_sop.doc_id', $r->id)->get();
            }
        }

        $data['findAllResult2'] = $findAllResult;
        // print_r($data['findAllResult2']);
        // exit();
        
        $this->template->display('procurement/V_amendment_recommendation_view', $data);
    }
    public function approve($value='')
    {
        $app_id = $this->input->post('approval_id');
        $app_next = $app_id + 1;
        $recom = $this->db->query('SELECT * FROM t_approval_arf_recom WHERE id = ' . $app_id)->row();
        $total_approver = $this->db->query('SELECT * FROM t_approval_arf_recom WHERE id_ref = ' . $recom->id_ref)->num_rows();
        $approved = $this->db->query('SELECT * FROM t_approval_arf_recom WHERE id = ' . $app_id . ' AND status = 1')->num_rows();
        $nextrecom = $this->db->query('SELECT * FROM t_approval_arf_recom WHERE id = ' . $app_next)->row();
        if ($approved < ($total_approver - 1)) {
            if ($recom->id_user_role != 27) {
              $query = $this->db->query("SELECT rec.description, arf.doc_no, arf.po_title usr.NAME AS name, usr.EMAIL AS email, n.TITLE AS title, n.OPEN_VALUE AS open, n.CLOSE_VALUE AS close FROM t_approval_arf_recom rec
              JOIN t_arf_response resp ON rec.id_ref = resp.id
              JOIN t_arf arf ON resp.doc_no = arf.doc_no
              JOIN m_user usr ON usr.ID_USER = rec.id_user
              JOIN m_notic n ON n.ID = 93
              WHERE rec.id_ref = " . $recom->id_ref . " AND rec.id_user_role = " . $nextrecom->id_user_role);

                if ($query->num_rows() > 0) {
                    $data_replace = $query->result();
                    $str = $data_replace[0]->open;
                    $str = str_replace('title_agreement', $data_replace[0]->doc_no, $str);
                    $str = str_replace('no_arf', $data_replace[0]->po_title, $str);
                    $img1 = '';
                    $img2 = '';

                    $data = array(
                        'img1' => $img1,
                        'img2' => $img2,
                        'title' => $data_replace[0]->title,
                        'open' => $str,
                        'close' => $data_replace[0]->close
                    );

                    foreach ($data_replace as $item) {
                        $data['dest'][] = $item->email;
                    }
                    $flag = $this->M_sendmail->sendMail($data);
                }
            }
        }
        if (isset($nextrecom->id_user_role)) {
            if ($recom->id_user_role != 5){

            }
        }
        if ($recom->sequence <= 4) {
            if ($recom->sequence == 4) {
                $query = $this->db->query("SELECT rec.description, usr.NAME AS name, usr.EMAIL AS email, n.TITLE AS title, n.OPEN_VALUE AS open, n.CLOSE_VALUE AS close FROM t_approval_arf_recom rec
            JOIN m_user usr ON usr.ID_USER = rec.id_user
            JOIN m_notic n ON n.ID = 93
            WHERE rec.sequence > 4 AND rec.id_ref = " . $recom->id_ref);
            } else {
                $seq = $recom->sequence + 1;
                $query = $this->db->query("SELECT rec.description, usr.NAME AS name, usr.EMAIL AS email, n.TITLE AS title, n.OPEN_VALUE AS open, n.CLOSE_VALUE AS close FROM t_approval_arf_recom rec
            JOIN m_user usr ON usr.ID_USER = rec.id_user
            JOIN m_notic n ON n.ID = 93
            WHERE rec.sequence = " . $seq . " AND rec.id_ref = " . $recom->id_ref);
            }
        }
        $this->T_approval_arf_recom->approve();
    }
    public function issued($value='')
    {
        $this->T_approval_arf_recom->issued();
        $img1 = '';
        $img2 = '';

        $query = $this->db->query('SELECT arf.doc_no, arf.po_title AS po_title, po.company_desc AS company, vnd.NAMA AS vendor, vnd.ID_VENDOR AS email, n.TITLE AS title, n.OPEN_VALUE AS open, n.CLOSE_VALUE AS close FROM t_purchase_order po
        LEFT JOIN t_arf arf ON arf.po_no = po.po_no
        JOIN m_vendor vnd ON vnd.ID = po.id_vendor
        LEFT JOIN m_notic n ON n.ID = 92
        WHERE po.po_no = "' . $this->input->post('po_no') . '"');

        if ($query->num_rows() > 0) {
            $data_replace = $query->result();

            $str = $data_replace[0]->open;
            $str = str_replace('_var1_', $data_replace[0]->company, $str);
            $str = str_replace('title_agreement', $data_replace[0]->po_title, $str);
            $str = str_replace('no_arf', $data_replace[0]->doc_no, $str);

            $data = array(
                'img1' => $img1,
                'img2' => $img2,
                'title' => $data_replace[0]->title,
                'open' => $str,
                'close' => $data_replace[0]->close
            );

            foreach ($data_replace as $item) {
                $data['dest'][] = $item->email;
            }
            $flag = $this->M_sendmail->sendMail($data);
        }
        echo json_encode(['status'=>true, 'msg'=>"Issued"]);
    }
    public function newAgreementPeriodTo($arf='')
    {
        /*$doc_date = $this->db->where(['po_no'=>$arf->po_no])->order_by('doc_date','desc')->get('t_arf')->row();
        $doc_date = $arf->amended_date;

        $detail_revision = $this->m_arf_detail_revision->detail_revision($arf);
        if($this->input->get('debug'))
        {
            echo $this->db->last_query();
        }
        $myDate = $doc_date;*/

        /*if($detail_revision->num_rows() > 0)
        {
          $detail_revision = $detail_revision->row();
          $dariArf = date('Y-m-d', strtotime($doc_date));
          $dariDetail = date('Y-m-d', strtotime($detail_revision->value));
          $myDate = $dariArf > $dariDetail ? $doc_date :$detail_revision->value;
        }*/
        $myDate = getLastTimeAmd($arf->doc_no, $arf->amended_date,"<=");
        return $myDate;
    }
    public function addTime($arf='',$po='')
    {
        $ref = $this->db->where(['doc_id'=>$arf->doc_id])->order_by('id','desc')->get('t_arf_detail_revision');
        if($ref->num_rows() > 0)
        {
          $ref = $ref->row();
          $addTime = $ref->value;
        }
        else
        {
          $addTime = $po->amended_date;
        }
        return $addTime;
    }
    public function approval_list($id='')
    {
      return $this->db->select('t_approval_arf_recom.*,m_user_roles.DESCRIPTION role_name,m_user.NAME user_name')
        ->join('m_user_roles','m_user_roles.ID_USER_ROLES = t_approval_arf_recom.id_user_role','left')
        ->join('m_user','m_user.ID_USER = t_approval_arf_recom.id_user','left')
        ->where(['id_ref'=>$id, 'sequence < '=> 7])->order_by('sequence','asc')->get('t_approval_arf_recom');
    }
    public function arf_recom_issued($value='')
    {
        $data['title'] = 'Amendment Issuance';
        $data['menu'] = $this->menu;
        $data['lists'] = $this->T_approval_arf_recom->time_issued();
        $this->template->display('procurement/V_arf_recom_approval', $data);
    }
    public function reject_list()
    {
        $data['menu'] = $this->menu;
        $reject_list = $this->T_approval_arf_recom->reject_list();

        /*if($reject_list)
        {
            if($reject_list->num_rows() > 0)
            {
                $data['lists'] = $reject_list;
            }
        }*/
        $data['title'] = 'Arf Recommendation Reject List';
        $data['lists'] = $reject_list;
        $data['create'] = true;
        $this->template->display('procurement/V_arf_recom_approval', $data);
    }
    public function approval_update($doc_no='', $arf_response_id='')
    {
        $t_approval_arf_recom = $this->db->where(['id_ref'=>$arf_response_id])->get('t_approval_arf_recom');
        if($t_approval_arf_recom->num_rows() > 0)
        {
            $this->db->where(['id_ref'=>$arf_response_id]);
            $this->db->where_not_in('sequence',[1]);
            $this->db->update('t_approval_arf_recom',['status'=>0]);
        }
    }
    public function firstAas($created_by = '')
    {
        $sqlId = "select * from t_jabatan where user_id = $created_by";
        $n = $this->db->query($sqlId)->row();
        $id = @$n->id;
        $sql = "SELECT * FROM t_jabatan WHERE id = (SELECT parent_id FROM t_jabatan WHERE id = '$id')";
        $result = $this->db->query($sql);
        $row = $result->row();
        return $row;
    }
    public function getMsr($arfId='')
    {
        //t_arf.doc_no,t_arf.po_no,t_purchase_order.po_no, t_purchase_order.msr_no 
        $sql = "SELECT t_msr.*
        FROM `t_arf` 
        LEFT JOIN t_purchase_order on t_arf.po_no = t_purchase_order.po_no
        LEFT JOIN t_msr on t_msr.msr_no = t_purchase_order.msr_no
        WHERE t_arf.id = '$arfId'";
        $q = $this->db->query($sql);
        return $q->row();
    }
    public function send_mail()
    {
        $config = array(
            'protocol' => 'imap',
            'smtp_host' => 'mail.supreme-energy.com',
            'smtp_port' => 25,
            'smtp_user' => 'scm-portal',
            'smtp_pass' => 'jkt@2018',
            'mailtype'  => 'html', 
            'charset'   => 'iso-8859-1'
        );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");

        $this->email->initialize($config);

        $this->email->from('scm-portal@supreme-energy.com', 'SCM Portal');
        $this->email->to('reza@abpersada.com'); 

        $this->email->subject('Email Test');
        $this->email->message('Ini Terbaru');  

        $this->email->send();

        echo $this->email->print_debugger();
    }
    public function get_spending($value='')
    {
        $sql = "select PDLNID,PDLITM,
        PDDSC1,PDDSC2,
        PDUORG,PDUOM,
        CASE WHEN PDCRCD='USD' THEN PDPRRC ELSE PDFRRC END as UNITCOST, 
        CASE WHEN PDCRCD='USD' THEN PDAEXP ELSE PDFEA END as AMTTOTAL,
        CASE WHEN PDCRCD='USD' THEN PDAOPN ELSE PDFAP END as AMTOPEN,
        CASE WHEN PDCRCD='USD' THEN PDAREC ELSE PDFREC END as AMTSPENDING,
        PDCRCD,PDANI 
        FROM F4311 WHERE TRIM(PDDOCO)=19000001 AND TRIM(PDDCTO)='OP' AND TRIM(PDKCOO)='10101'
        AND PDNXTR||PDLTTR not in ('999980')";
        $db = $this->load->database('oracle', TRUE);
        $rs = $db->query($sql)->row();
        echo "<pre>";
        print_r($rs);
    }
    public function amd_lists()
    {
        $data['menu'] = $this->menu;
        $data['lists'] = $this->m_arf_response->view('arf_response')->scope(array('amd_issued'))->get();
        $data['edit'] = 0;
        if($this->input->get('reject'))
        {
            $data['lists'] = $this->m_arf_response->view('arf_response')->scope(array('reject'))->get();
            $data['edit'] = 1;
        }
        $this->template->display('procurement/V_amd_list', $data);
    }
    public function amd_view($id='')
    {
        $arf = $this->m_arf_response->view('arf_response')->find_or_fail($id);

        $t_arf_notification = $this->db->where(['doc_no'=>$arf->doc_no])->get('t_arf_notification')->row();
        $arf->item = $this->m_arf_sop->view('response')->select('t_arf_nego_detail.unit_price new_price')
        ->join('t_arf_nego_detail', 't_arf_sop.id = t_arf_nego_detail.arf_sop_id', 'left')
        ->join('(select * from t_arf_nego where status = 2 order by id desc limit 1) t_arf_nego','t_arf_nego.id = t_arf_nego_detail.arf_nego_id', 'left')->where('t_arf_sop.doc_id', $t_arf_notification->id)->get();
        
        if($this->input->get('amd'))
        {
            $findAll = $this->db->where(['po_no'=>$t_arf_notification->po_no, 'id < '=> $t_arf_notification->id])->get('t_arf_notification');
        }
        else
        {
          // $findAll = $this->db->where(['po_no'=>$t_arf_notification->po_no])->get('t_arf_notification');
            $findAll = $this->db->where(['po_no'=>$t_arf_notification->po_no, 'id <= '=> $t_arf_notification->id])->get('t_arf_notification');
        }
        $findAllResult = [];
        if($findAll->num_rows() > 0)
        {
            foreach ($findAll->result() as $r) {
                $findAllResult[$r->doc_no] = $this->m_arf_sop->view('response')
                ->select('t_arf_nego_detail.unit_price new_price')
                ->join('t_arf_nego_detail', 't_arf_sop.id = t_arf_nego_detail.arf_sop_id', 'left')
                ->join('(select * from t_arf_nego where status = 2 order by id desc limit 1) t_arf_nego','t_arf_nego.id = t_arf_nego_detail.arf_nego_id', 'left')->where('t_arf_sop.doc_id', $r->id)->get();
            }
        }

        /*foreach ($this->m_arf_detail_revision->where('doc_id', $arf->doc_id)->get() as $revision) {
            $arf->revision[$revision->type] = $revision;
        }*/
        $markingType = [1=>'value', 2=>'time', 3=>'scope', 4=>'other'];
        foreach ($this->db->where('doc_id', $t_arf_notification->id)->get('t_arf_notification_detail_revision')->result() as $revision) {
            $arf->revision[$markingType[$revision->type]] = $revision;
        }
        $arf->response_attachment = $this->m_arf_response_attachment->where('t_arf_response_attachment.doc_id', $arf->doc_id)->get();
        $arf->performance_bond = $this->m_arf_acceptance_document->view('document')->scope('performance_bond')->where('doc_no', $arf->doc_no)->get();
        $arf->insurance = $this->m_arf_acceptance_document->view('document')->scope('insurance')->where('doc_no', $arf->doc_no)->get();
        $arf->other = $this->m_arf_acceptance_document->view('document')->scope('other')->where('doc_no', $arf->doc_no)->get();
        $po = $this->m_arf_po->where('t_purchase_order.po_no', $arf->po_no)->first();
        $po->po_type = $this->m_arf_po->enum('type', $po->po_type);
        $po->item = $this->m_arf_po_detail->view('po_detail')
        ->where('t_purchase_order_detail.po_id', $po->id)
        ->get();
        $data = $this->T_arf_recommendation_preparation->view($id);
        $data['arf'] = $arf;
        $data['po'] = $po;
        $data['document_path'] = $this->document_path;
        $data['menu'] = $this->menu;
        $data['doc'] = $this->db->where(['module_kode'=>'arf-recom-prep','data_id'=>$arf->doc_no])->get('t_upload')->result();
        $data['view'] = true;
        $data['approval_list'] = $this->approval_list($id);
        $data['approval_count'] = $this->approval_list($id)->num_rows() > 0 ? "":"hidden";
        $data['newAgreementPeriodTo'] = $this->newAgreementPeriodTo($arf);
        $data['addTime'] = $this->addTime($arf,$po);
        $data['approval_view'] = true;

        $data['title'] = $this->session->userdata('arf_recom_title') ? $this->session->userdata('arf_recom_title') : 'Amendment Details';

        $time_issued = $this->T_approval_arf_recom->time_issued($id)->num_rows();
        if($time_issued > 0)
        {
            $data['issued'] = $time_issued;
            $data['title'] = 'Amendment Details';
            $data['doc'] = $this->db->where(['data_id'=>$arf->doc_no])->where_in('module_kode', ['arf-recom-prep', 'arf-issued'])->get('t_upload')->result();
        }
        $data['is_reject'] = $this->T_approval_arf_recom->is_reject($id);
        $data['findAllResult'] = $findAllResult;
        if($this->input->get('amd'))
        {
          $data['document_path'] = $this->document_path;
          $data['issued'] = 1;
          $data['doc'] = $this->db->where(['data_id'=>$arf->doc_no])->where_in('module_kode', ['arf-recom-prep', 'arf-issued'])->get('t_upload')->result();
          $data['acceptance_docs'] = $this->db->select('t_arf_acceptance_document.*,m_currency.CURRENCY currency')
          ->join('m_currency','m_currency.ID = t_arf_acceptance_document.currency_id', 'left')
          ->where(['doc_no'=>$arf->doc_no])->get('t_arf_acceptance_document')->result();
          $this->template->display('procurement/V_amendment_recommendation_create', $data);
        }
        else
        {
            $this->template->display('procurement/amd_view', $data);
        }
    }
    public function edit($id) {
        $amd = $this->T_arf_recommendation_preparation->find($id);
        $id = $amd->arf_response_id;
        $arf = $this->m_arf_response->view('arf_response')->find_or_fail($id);
        $t_arf_notification = $this->db->where(['doc_no'=>$arf->doc_no])->get('t_arf_notification')->row();
        // $arf->item = $this->m_arf_detail->view('response_item')->where('doc_id', $arf->doc_id)->get();
        $arf->item = $this->m_arf_sop->view('response')->select('t_arf_nego_detail.unit_price new_price')
        ->join('t_arf_nego_detail', 't_arf_sop.id = t_arf_nego_detail.arf_sop_id', 'left')
        ->join('(select * from t_arf_nego where status = 2 order by id desc limit 1) t_arf_nego','t_arf_nego.id = t_arf_nego_detail.arf_nego_id', 'left')->where('t_arf_sop.doc_id', $t_arf_notification->id)->where('t_arf_nego.id = t_arf_nego_detail.arf_nego_id')->get();

        $findAll = $this->db->where(['po_no'=>$t_arf_notification->po_no, 'id < '=> $t_arf_notification->id])->get('t_arf_notification');
        
        $findAllResult = [];
        if($findAll->num_rows() > 0)
        {
            foreach ($findAll->result() as $r) {
                $findAllResult[$r->doc_no] = $this->m_arf_sop->view('response')
                ->select('t_arf_nego_detail.unit_price new_price')
                ->join('t_arf_nego_detail', 't_arf_sop.id = t_arf_nego_detail.arf_sop_id', 'left')
                ->join('(select * from t_arf_nego where status = 2 order by id desc limit 1) t_arf_nego','t_arf_nego.id = t_arf_nego_detail.arf_nego_id', 'left')->where('t_arf_sop.doc_id', $r->id)->where('t_arf_nego.id = t_arf_nego_detail.arf_nego_id')->get();
            }
        }

        /*foreach ($this->m_arf_detail_revision->where('doc_id', $arf->doc_id)->get() as $revision) {
            $arf->revision[$revision->type] = $revision;
        }*/
        $markingType = [1=>'value', 2=>'time', 3=>'scope', 4=>'other'];
        foreach ($this->db->where('doc_id', $t_arf_notification->id)->get('t_arf_notification_detail_revision')->result() as $revision) {
            $arf->revision[$markingType[$revision->type]] = $revision;
        }
        $arf->response_attachment = $this->m_arf_response_attachment->where('t_arf_response_attachment.doc_id', $arf->doc_id)
        ->get();
        $po = $this->m_arf_po->where('t_purchase_order.po_no', $arf->po_no)->first();
        $po->po_type = $this->m_arf_po->enum('type', $po->po_type);
        $po->item = $this->m_arf_po_detail->view('po_detail')->where('t_purchase_order_detail.po_id', $po->id)->get();
        $data = $this->T_arf_recommendation_preparation->view($id);
        $data['arf'] = $arf;
        $data['po'] = $po;
        $data['document_path'] = $this->document_path;
        $data['menu'] = $this->menu;
        $data['doc'] = $this->db->where(['module_kode'=>'arf-recom-prep','data_id'=>$arf->doc_no])->get('t_upload')->result();
        $data['view'] = false;
        $data['approval_view'] = false;
        $data['newAgreementPeriodTo'] = $this->newAgreementPeriodTo($arf);
        $data['title'] = $this->session->userdata('arf_recom_title') ? $this->session->userdata('arf_recom_title') : 'Amendment Recommendation Preparation';
        $data['addTime'] = $this->addTime($arf,$po);
        $data['amd'] = $amd;
        if($this->input->get('debug'))
        {
            echo "<pre>";
            print_r($data);
            exit();
        }
        $data['approval_list'] = $this->approval_list($id);
        $data['findAllResult'] = $findAllResult;

        $findAll = $this->db->where(['po_no'=>$t_arf_notification->po_no, 'id <= '=> $t_arf_notification->id])->get('t_arf_notification');
        
        $findAllResult = [];
        if($findAll->num_rows() > 0)
        {
            foreach ($findAll->result() as $r) {
                $findAllResult[$r->doc_no] = $this->m_arf_sop->view('response')
                ->select('t_arf_nego_detail.unit_price new_price')
                ->join('t_arf_nego_detail', 't_arf_sop.id = t_arf_nego_detail.arf_sop_id', 'left')
                ->join('(select * from t_arf_nego where status = 2 order by id desc limit 1) t_arf_nego','t_arf_nego.id = t_arf_nego_detail.arf_nego_id', 'left')->where('t_arf_sop.doc_id', $r->id)->where('t_arf_nego.id = t_arf_nego_detail.arf_nego_id')->get();
            }
        }

        $data['findAllResult2'] = $findAllResult;
        
        $this->template->display('procurement/V_amendment_recommendation_edit', $data);
    }
    public function update($id='')
    {
        $this->db->trans_begin();
        $user = user();
        $data = $this->input->post();
        $t_arf_recommendation_preparation = $this->db->where(['arf_response_id'=>$data['arf_response_id']])->get('t_arf_recommendation_preparation')->row();
        $field = [
            'arf_response_id'   => $data['arf_response_id'],
            'doc_no'            => $data['doc_no'],
            'po_no'             => $data['po_no'],
            'analysis'          => $data['analysis'],
            'nego'              => $data['nego'],
            'nego_str'          => $data['nego_str'],
            'budget_analysis'   => $data['budget_analysis'],
            'bod_approval'      => $data['bod_approval'],
            'aa'                => $data['aa'],
            'extend1'           => @$data['extend1'] ? $data['extend1'] : 0,
            'extend2'           => @$data['extend2'] ? $data['extend2'] : 0,
            'new_date_1'        => @$data['new_date_1'] ? $data['new_date_1'] : null,
            'new_date_2'        => @$data['new_date_2'] ? $data['new_date_2'] : null,
            'remarks_1'         => @$data['remarks_1'] ? $data['remarks_1'] : null,
            'remarks_2'         => @$data['remarks_2'] ? $data['remarks_2'] : null,
            'status'            => 0,
            'created_at'        => date("Y-m-d H:i:s"),
            'created_by'        => $user->ID_USER,
        ];
        if($t_arf_recommendation_preparation)
        {
            $this->db->where(['id'=>$t_arf_recommendation_preparation->id]);
            $this->db->update('t_arf_recommendation_preparation', $field);
            $this->approval_update($data['doc_no'], $data['arf_response_id']);
        }
        else
        {
            $this->db->insert('t_arf_recommendation_preparation', $field);
            /*generate approval*/
            $this->approval($data['doc_no'], $data['arf_response_id']);
        }

        if($this->db->trans_status() === true)
        {
            $this->db->trans_commit();
            echo json_encode(['status'=>true,'msg'=>'Amendment Submitted']);
        }
        else
        {
            $this->db->trans_rollback();
            echo json_encode(['status'=>false,'msg'=>'Fail, Try Again']);
        }
    }
}