<?php

/**
 * Purchase Order
 *
 * @class Purchase_order
 *
 */
class Purchase_order extends CI_Controller
{
    protected $uploadConfig;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('approval/M_bl')
            ->model('procurement/M_purchase_order')
            ->model('procurement/M_service_order')
            ->model('procurement/M_purchase_order_type')
            ->model('procurement/M_purchase_order_detail')
            ->model('procurement/M_purchase_order_document')
            ->model('procurement/M_purchase_order_required_doc')
            ->model('procurement/M_purchase_order_attachment')
            ->model('setting/M_tkdn_type')
            ->model('approval/M_approval')
            ->model('user/M_view_user')
            ->model('setting/M_master_department')
            ->model('procurement/M_msr')
            ->model('other_master/M_currency')
            ->model('setting/M_material_uom')
            ->model('setting/M_multi_uom_mapping')
            ->model('setting/M_delivery_point')
            ->model('setting/M_delivery_term')
            ->model('setting/M_importation')
            ->model('setting/M_itemtype')
            ->model('setting/M_msr_inventory_type')
            ->model('setting/M_jabatan')
            ->model('setting/M_master_company')
            ->model('vendor/M_show_vendor')
            ->model('procurement/M_regret_letter')
            ->model('procurement/M_loi')
            ->model('M_base')
            ->model('procurement/arf/M_arf')
            ->helper(['array', 'form', 'exchange_rate', 'material', 'permission'])
            ->library(['upload', 'DocNumber']);

        $this->config->load('file_upload', true);

        $this->uploadConfig = $this->config->item('purchase_order', 'file_upload');
    }

    public function index()
    {
    }

    public function create($bl_detail_id)
    {
        $this->load->helper(['form'])
            ->model('setting/M_master_company')
            ->model('approval/M_bl')
            ->model('procurement/M_loi')
            ->model('vendor/M_show_vendor')
            ->model('setting/M_delivery_point')
            ->model('setting/M_importation')
            ->model('other_master/M_currency')
            ->model('setting/M_itemtype')
            ->helper(['array'])
            ->library('form_validation');

        $message = ['type' => '', 'message' => null];

        /* if (!$this->M_purchase_order->canCreateFromBlDetail($bl_detail_id)) {
            show_error('Disallow to create PO document or document already created');
        } 

        if ($this->M_purchase_order->findByBlDetailId($bl_detail_id)) {
            show_error('PO document is already created or under development');
        } */

        $menu = get_main_menu();

        $bl = $this->M_bl->getBlByBlDetailId($bl_detail_id);
        $anyPo = $this->db->where('bl_detail_id', $bl_detail_id)->get('t_purchase_order');
        $frompo = false;
        if($anyPo->num_rows() > 0)
        {
            $frompo = $anyPo->row();
            $bl->title = $frompo->title;
            $bl->blanket = $frompo->blanket;
            $bl->incoterm = $frompo->shipping_term;
            $bl->id_dpoint = $frompo->id_dpoint;
            $bl->tkdn_type = $frompo->tkdn_type;
            $bl->tkdn_value_goods = $frompo->tkdn_value_goods;
            $bl->tkdn_value_service = $frompo->tkdn_value_service;
            $bl->tkdn_value_combination = $frompo->tkdn_value_combination;
            $bl->master_list = $frompo->master_list;
        } 
        if (!$bl) {
            show_error("Document not found", 404);
        }

        $awarder = $this->M_bl->getAwarderById($bl_detail_id);

        if (!$awarder) {
            show_error("This is not the awarder");
        }

        if ($this->input->post() && $this->validatePOCreate()) {
            $hit_db = true;

            if (!$this->input->post('bl_detail_id')) {
                show_error("Invalid document", 404);
            }
			
			if (false === ($attachment_files = $this->handleUploadAttachment([
                'draft_of_po',
            ]))) {
                $hit_db = false;

                $message['message'] = $this->upload->display_errors();
                $message['type'] = 'danger';
                log_message('error', $message['message']);
            }
 
            $po = $this->makePOFromPost();
            $po_items = $this->makePODetailsFromBlDetail($this->input->post('bl_detail_id'), null);

            $total_po_amount = $this->getTotalAmountFromDetail($po_items);
            $value_award = $this->M_purchase_order->value_award($bl->msr_no, $bl->vendor_id);
            $po['total_amount'] = $value_award->amount;
            $po['total_amount_base'] = $value_award->amount_base;

            $required_docs = $this->makePORequiredDocsFromPost(null);
			$attachments = $this->makePOAttachmentsFromPost(
                null,
                $attachment_files,
                [
                    'draft_of_po' => $this->M_purchase_order_attachment::TYPE_DRAFT_PO,
                ],
                $this->M_purchase_order::module_kode
            );

            if ($hit_db) {

                $this->db->trans_start();
                /*get if any by bl_detail_id*/
                $anyPo = $this->db->where('bl_detail_id', $bl_detail_id)->get('t_purchase_order');
                if($anyPo->num_rows() > 0)
                {
                    $anyPo = $anyPo->row();
                    $po_id = $anyPo->id;
                    unset($po['id']);
                    $this->M_purchase_order->update($po_id, $po);

                    $this->db->where(['data_id'=>$po_id])->where_in('m_approval_id', [17,18,19])->delete('t_approval');
                    $this->db->where(['po_id'=>$po_id])->delete('t_purchase_order_required_doc');
                    $this->db->where(['module_kode'=>'po', 'data_id'=>$po_id])->delete('t_upload');
                    $this->db->where(['po_id'=>$po_id])->delete('t_purchase_order_detail');
                }
                else
                {
                    $this->M_purchase_order->add($po);
                    $po_id = $this->db->insert_id();
                }
                $po_no = $po['po_no'];

                // Details
                if ($po_items) {
                    foreach($po_items as &$detail) {
                        $detail['id'] = NULL;
                        $detail['po_id'] = $po_id;
                        $detail = $this->makePODetail($detail);
                        $this->M_purchase_order_detail->add($detail);
                    }
                }

                // Required Docs
                if ($required_docs) {
                    foreach($required_docs as $doc) {
                        $doc['po_id'] = $po_id;
                        $this->M_purchase_order_required_doc->add($doc);
                    }
                }

                // Attachment
                if ($attachments) {
                    foreach($attachments as $att) {
                        $att['data_id'] = $po_id;
                        $att['module_kode'] = $this->M_purchase_order::module_kode;

                        $this->M_purchase_order_attachment->add($att);
                    }
                }

                $this->db->trans_complete();


                if ($this->db->trans_status() !== FALSE) {
                    // generate approval flow!!!
                    try {
                        $this->M_approval->generateDocumentFlow($this->M_purchase_order::module_kode, $po_id);
                        log_message('info', 'Document approval #'.$po_no.' flow has already generated');
                    } catch (RuntimeException $e) {
                       log_message('error', $e->getMessage());
                    }

                    log_history($this->M_purchase_order::module_kode, $po_no, 'Created');
                    $this->session->set_flashdata('message', array(
                        'message' => __('success_submit_with_number', array('no' => $po_no)),
                        'type' => 'success'
                    ));

                    // Send Email Notification for lose supplier
                    $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
                    $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";

                    $query = $this->db->query("SELECT t.title as TITLEMSR,b.msr_no,u.EMAIL as EMAIL,n.TITLE,n.OPEN_VALUE,n.CLOSE_VALUE from t_purchase_order b
                        join t_approval a on a.data_id=b.id and a.urutan=1
                        join m_approval m on m.id=a.m_approval_id
                        join m_user u on u.roles like CONCAT('%', m.role_id ,'%')
                        join m_notic n on n.id=42
                        join t_msr t on t.msr_no=b.msr_no
                        where b.id=".$po_id);
                    $data_role = $query->result();
					
                    $res = $data_role;

                    $data2 = array(
                        'img1' => $img1,
                        'img2' => $img2,
                        'title' => $data_role[0]->TITLE,
                        'open' => str_replace("_var1_", $data_role[0]->TITLEMSR, $data_role[0]->OPEN_VALUE),
                        // 'open2' =>,
                        'close' => $data_role[0]->CLOSE_VALUE
                    );

                    foreach ($res as $k => $v) {
                        $data2['dest'][] = $v->EMAIL;
                    }

                    $flag = $this->sendMail($data2);
                    // End Email

					//var_dump($po_id);exit;
					//delete po reject

					/*$this->db->where('id <', $po_id);
					$this->db->where('msr_no', $data_role[0]->msr_no);
					$this->db->delete('t_purchase_order');*/


					/*$dtOld = $this->db->where('id <', $po_id)->where('msr_no', $data_role[0]->msr_no)->get('t_purchase_order')->row();
					//var_dump($dtOld);exit;
					$this->db->where('id <', $po_id);
					$this->db->where('msr_no', $data_role[0]->msr_no);
					$this->db->delete('t_purchase_order');
					
					
					$this->db->where('id', $po_id);
					$this->db->update('t_purchase_order',['po_no'=>$dtOld->po_no]);
					//var_dump($this->db->last_query());exit;*/
					
										
                    return redirect(base_url('home'));
                }

                $message['type'] = 'error';
                $message['message'] = sprintf('Failed save Agreement document');
                log_message($message['type'], $message['message']);
            }
        }


        $po_attachment_type = $this->M_purchase_order_attachment->getTypes();
        $m_purchase_order_attachment = $this->M_purchase_order_attachment;
        // $company = $this->M_master_company->find($bl->id_company);
        $vendor = $this->M_show_vendor->find($awarder->vendor_id);
        //$msr = $this->M_msr->find($bl->msr_no);
        $requestor = $this->M_view_user->show_user($bl->create_by);
        $requestor_dept = $this->M_master_department->find($requestor->ID_DEPARTMENT);

        $vendor_bank_account = @$this->M_show_vendor->show_vendor_bank_account($awarder->vendor_id);
        $opt_vendor_bank_account = [];
        foreach($vendor_bank_account as $account) {
            $key = $account->ID_VENDOR.'-'.$account->KEYS;
            $opt_vendor_bank_account[$key] = $account->BANK_NAME . ' - ' . $account->NAME;
        }

        $opt_uom = array_pluck($this->M_material_uom->all(), 'MATERIAL_UOM', 'ID');
        $po_items = $this->makePODetailsFromBlDetail($bl_detail_id, null);
        
        $value_award = $this->M_purchase_order->value_award($bl->msr_no, $bl->vendor_id);
        $total_po_amount = $this->getTotalAmountFromDetail($po_items);
        $bl->total_amount = $value_award->amount;
        $bl->est_total_amount = $total_po_amount['est_total_price'];

        foreach($po_items as $item) {
            if (empty($item['id_uom'])) {
                $message['message'][] = 'Material UoM '. $item['uom'] . ' not defined yet';
            }
        }

        if (!empty($message['message'])) {
            $message['type'] = 'danger';
        }

        $opt_currency = array_pluck($this->M_currency->all(), 'CURRENCY', 'ID');
        $opt_dpoint = array_pluck($this->M_delivery_point->all(), 'DPOINT_DESC', 'ID_DPOINT');
        $opt_importation = array_pluck($this->M_importation->all(), 'IMPORTATION_DESC', 'ID_IMPORTATION');
        $opt_delivery_term = array_pluck($this->M_delivery_term->allActive(), 'DELIVERYTERM_DESC', 'ID_DELIVERYTERM');


        $opt_tkdn_type = array_pluck($this->M_tkdn_type->all(), 'name', 'id');
        $opt_item_type = array_pluck($this->M_itemtype->all(), "ITEMTYPE_DESC", "ID_ITEMTYPE");
        $opt_msr_inventory_type = array_pluck($this->M_msr_inventory_type->all(), "description", "id");

        if ($bl->delivery_satuan) {
            $delivery_date = date('Y-m-d', strtotime(
                sprintf('%d %s', @$bl->delivery_nilai ?: 0, @$bl->delivery_satuan)
            ));
        } else {
            $delivery_date = '';
        }

        $po_type = $this->M_purchase_order_type->getFromMsrType($bl->id_msr_type ?: '');
        $po_no = '';
        $loi = $this->M_loi->findByBlDetailId($bl_detail_id);
        if ($loi && !empty($loi->po_no)) {
 			/*$isMSRHasPO = $this->M_purchase_order->isMSRHasPO2($loi->msr_no);
			$po_no = $isMSRHasPO->po_no;
			$bl->title = $isMSRHasPO->title;*/
			$po_no = $loi->po_no;
        }

        $this->template->display('procurement/V_po_create', compact(
            'menu', 'bl_detail_id', 'bl', 'awarder', 'message', 'po_attachment_type', 'po_no',
            'm_purchase_order_attachment', 'vendor', 'opt_currency','opt_dpoint',
            'opt_importation', 'requestor', 'requestor_dept', 'opt_tkdn_type', 'po_items',
            'opt_item_type', 'vendor_bank_account', 'delivery_date', 'po_type', 'opt_vendor_bank_account', 'opt_msr_inventory_type',
            'opt_delivery_term','frompo'
        ));
    }

    public function show($id)
    {
        $this->load->model('setting/M_master_company')
            ->model('vendor/M_show_vendor');

        $message = array();
        $menu = get_main_menu();

        if (!$id) {
            show_error("Invalid request", 400);
        }

        $po = $this->M_purchase_order->find($id);

        if (!$po) {
            show_404('The Agreement document is not found');
        }

        $po_attachment_type = $this->M_purchase_order_attachment->getTypes();

        $po = $this->M_purchase_order->find($id);
        $msr = $this->M_msr->find($po->msr_no);
        $po_items = $this->M_purchase_order_detail->findByPOId($po->id);
        $po_attachments = $this->M_purchase_order_attachment->getByDocument($po->id, [
            $this->M_purchase_order_attachment::TYPE_DRAFT_PO,
            $this->M_purchase_order_attachment::TYPE_SIGNED_PO,
            $this->M_purchase_order_attachment::TYPE_COUNTER_SIGNED_PO
        ]);
        $po_required_doc = [];
        foreach($this->M_purchase_order_required_doc->getByPOId($po->id) as $reqdoc) {
            $po_required_doc[$reqdoc->doc_type] = $reqdoc;
        }
        $opt_po_required_doc = array_pluck($po_required_doc, 'doc_type');
        $company = $this->M_master_company->find($msr->id_company);
        $vendor = $this->M_show_vendor->find($po->id_vendor);
        $approval_list = $this->M_approval->list($this->M_purchase_order::module_kode, $po->id)->result();
        $roles = array_filter(explode(',', $this->session->userdata('ROLES')));

        $requestor = $this->M_view_user->show_user($msr->create_by);
        $requestor_dept = $this->M_master_department->find($msr->id_department);

        $opt_currency = array_pluck($this->M_currency->all(), 'CURRENCY', 'ID');
        $opt_dpoint = array_pluck($this->M_delivery_point->all(), 'DPOINT_DESC', 'ID_DPOINT');
        $opt_importation = array_pluck($this->M_importation->all(), 'IMPORTATION_DESC', 'ID_IMPORTATION');
        $opt_tkdn_type = array_pluck($this->M_tkdn_type->all(), 'name', 'id');
        $opt_item_type = array_pluck($this->M_itemtype->all(), "ITEMTYPE_DESC", "ID_ITEMTYPE");
        $opt_msr_inventory_type = array_pluck($this->M_msr_inventory_type->all(), "description", "id");
        $opt_delivery_term = array_pluck($this->M_delivery_term->allActive(), 'DELIVERYTERM_DESC', 'ID_DELIVERYTERM');

        // $po->tkdn_value_average = tkdn_average($po->tkdn_type, $po->tkdn_value_goods, $po->tkdn_value_service);

        foreach($po as $prop => $val) {
            $_POST[$prop] = $val;
        }

        $this->template->display('procurement/V_po_show', compact(
            'menu', 'po', 'po_items', 'message', 'company', 'vendor', 'po_attachments', 'po_attachment_type',
            'approval_list', 'po_required_doc', 'opt_po_required_doc', 'roles',
            'msr', 'opt_currency', 'opt_dpoint', 'opt_importation', 'opt_tkdn_type',
            'opt_item_type', 'requestor', 'requestor_dept', 'opt_msr_inventory_type', 'opt_delivery_term'
        ));
    }

    public function approvalList()
    {
        $this->load->model('setting/M_master_company')
            ->model('vendor/M_show_vendor')
            ->model('procurement/M_msr')
            ->model('approval/M_approval');

        $message = array();
        $menu = get_main_menu();

        $pos = $this->M_purchase_order->toApprove();

        if (!$pos) {
            $message['type'] = 'info';
            $message['message'] = 'There is no document to be approved yet';
        }

        $this->template->display('procurement/V_po_to_approve_list', compact('menu', 'pos', 'message'));
    }

    public function toApprove($id)
    {
        $this->load->model('setting/M_master_company')
            ->model('vendor/M_show_vendor')
            ->model('approval/M_approval')
            ->model('setting/M_delivery_point')
            ->model('setting/M_importation')
            ->model('other_master/M_currency')
            ->model('setting/M_itemtype');

        $message = array();
        $menu = get_main_menu();

        if (!$id) {
            show_404();
        }

        $po = $this->M_purchase_order->find($id);

        // Check whether document has been issued ?
        // if ($document_issued) {
        //     show_error('The document has been issued');
        // }

        if (!$po) {
            show_error('The Agreement document is not found', 404);
        }

        if ($this->input->post()) {
            $post = $this->input->post();
            $action = $post['status']; // 1: approve; 2: reject

            $po = $this->M_purchase_order->find($post['id']);

            if ($action == 1) {
                $this->M_purchase_order->approve($post['id'], $post['data_id'], $post['deskripsi']);
                log_history($this->M_purchase_order::module_kode, $po->po_no, 'Approved', $post['deskripsi']);
            } elseif ($action == 2) {
                $this->M_purchase_order->reject($post['id'], $post['data_id'], $post['deskripsi']);
                log_history($this->M_purchase_order::module_kode, $po->po_no, 'Rejected', $post['deskripsi']);
            } else {
                show_error('Unknown action', 400);
            }

            return redirect('procurement/purchase_order/approvalList');
        }

        $po_attachment_type = $this->M_purchase_order_attachment->getTypes();

        $po = $this->M_purchase_order->find($id);
        $msr = $this->M_msr->find($po->msr_no);
        $po_items = $this->M_purchase_order_detail->findByPOId($po->id);

        $po_attachments = $this->M_purchase_order_attachment->getByDocument($po->id, [
            $this->M_purchase_order_attachment::TYPE_DRAFT_PO,
            $this->M_purchase_order_attachment::TYPE_SIGNED_PO
        ]);
        $po_required_doc = [];
        foreach($this->M_purchase_order_required_doc->getByPOId($po->id) as $rdoc) {
            $po_required_doc[$rdoc->doc_type] = $rdoc;
        }

        $opt_po_required_doc = array_pluck($po_required_doc, 'doc_type');
        $company = $this->M_master_company->find($msr->id_company);
        $vendor = $this->M_show_vendor->find($po->id_vendor);
        $approval_list = $this->M_approval->list($this->M_purchase_order::module_kode, $po->id)->result();
        $roles = array_filter(explode(',', $this->session->userdata('ROLES')));

        $requestor = $this->M_view_user->show_user($msr->create_by);
        $requestor_dept = $this->M_master_department->find($msr->id_department);

        $opt_currency = array_pluck($this->M_currency->all(), 'CURRENCY', 'ID');
        $opt_dpoint = array_pluck($this->M_delivery_point->all(), 'DPOINT_DESC', 'ID_DPOINT');
        $opt_importation = array_pluck($this->M_importation->all(), 'IMPORTATION_DESC', 'ID_IMPORTATION');
        $opt_tkdn_type = array_pluck($this->M_tkdn_type->all(), 'name', 'id');
        $opt_item_type = array_pluck($this->M_itemtype->all(), "ITEMTYPE_DESC", "ID_ITEMTYPE");
        $opt_msr_inventory_type = array_pluck($this->M_msr_inventory_type->all(), "description", "id");
        $opt_delivery_term = array_pluck($this->M_delivery_term->allActive(), 'DELIVERYTERM_DESC', 'ID_DELIVERYTERM');

        $this->template->display('procurement/V_po_to_approve', compact(
            'menu', 'po', 'po_items', 'message', 'company', 'vendor', 'po_attachments', 'po_attachment_type',
            'approval_list', 'po_required_doc', 'opt_po_required_doc', 'roles',
            'msr', 'opt_currency', 'opt_dpoint', 'opt_importation', 'opt_tkdn_type',
            'opt_item_type', 'requestor', 'requestor_dept', 'opt_msr_inventory_type',
            'opt_delivery_term'
        ));
    }

    public function approve()
    {
        $post = $this->input->post();
        $action = $post['status']; // 1: approve; 2: reject
        $hit_db = true;

        // TODO: input validation

        $po = $this->M_purchase_order->find($post['data_id']);
        if (!$po) {
            $type = 'error';
            $message = 'Agreement document not found';

            $hit_db = false;
        }

        if ($hit_db) {
            /* $data = $this->makePOUpdateFromPostBy(); */
            /* $this->M_purchase_order->update($po->id, $data); */

            if ($action == 1) {
                if ($this->M_purchase_order->approve($post['id'], $post['data_id'], $post['deskripsi'])) {
                    $type = 'success';
                    $message = 'Agreement Approved';

                    $rs = $this->db->select('t_approval.*,m_approval.module_kode')->where(['t_approval.id'=>$post['id']])
                    ->join('m_approval','m_approval.id = t_approval.m_approval_id')
                    ->get('t_approval')->row();
                    @$module_kode = $rs->module_kode;
                    @$urutan1 = $rs->urutan;

                    $q = "select max(urutan) urutan from t_approval WHERE data_id = '".$post['data_id']."'";
                    $rs = $this->db->query($q)->row();
                    $urutan2 = $rs->urutan;


                    if($urutan1 == $urutan2)
                        {


                            // Send Email ke PS Untuk Verify MSR
                            ini_set('max_execution_time', 500);
                            $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
                            $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";


                            $query = $this->db->query("SELECT distinct u.email as recipient,n.TITLE,n.OPEN_VALUE,n.CLOSE_VALUE FROM t_approval t
                                join m_approval m on m.id=t.m_approval_id and m.module_kode='po' and m.urutan=1
                                join m_user u on u.roles like CONCAT('%', m.role_id ,'%')
                                join m_notic n on n.ID=42
                                where t.data_id='".$post["data_id"]."'");
                            if ($query->num_rows() > 0) {
                              $data_role = $query->result();
                              $count = 1;
                            } else {
                              $count = 0;
                            }

                            if ($count === 1) {

                              $query = $this->db->query("SELECT distinct t.title,u.NAME,d.DEPARTMENT_DESC from t_msr t
                                join t_purchase_order o on o.id='".$post['data_id']."' and o.msr_no=t.msr_no
                                join m_user u on u.ID_USER=t.create_by
                                join m_departement d on d.ID_DEPARTMENT=u.ID_DEPARTMENT");

                              $data_replace = $query->result();

                              $res = $data_role;
                              $str = $data_role[0]->OPEN_VALUE;
                              $str = str_replace('_var1_',$data_replace[0]->title,$str);

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
                              //$flag = $this->sendMail($data);

                            }

                            //End Send Email

                        }else{
                            $rs = $this->db->where(['t_approval.id'=>$post['id']])
                            ->get('t_approval')->row();
                            $urutannext = $rs->urutan+1;

                            //Send Email
                            ini_set('max_execution_time', 500);
                            $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
                            $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";


                            $query = $this->db->query("SELECT distinct u.email as recipient,n.TITLE,n.OPEN_VALUE,n.CLOSE_VALUE FROM t_approval t
                                join m_approval m on m.id=t.m_approval_id and m.module_kode='po'
                                join m_user u on u.roles like CONCAT('%', m.role_id ,'%')
                                join m_notic n on n.ID=42
                                where t.data_id='".$post["data_id"]."' and t.urutan=".$urutannext);
                            if ($query->num_rows() > 0) {
                              $data_role = $query->result();
                              $count = 1;
                            } else {
                              $count = 0;
                            }

                            if ($count === 1) {

                             $query = $this->db->query("SELECT distinct t.title,u.NAME,d.DEPARTMENT_DESC from t_msr t
                                join t_purchase_order o on o.id='".$post['data_id']."' and o.msr_no=t.msr_no
                                join m_user u on u.ID_USER=t.create_by
                                join m_departement d on d.ID_DEPARTMENT=u.ID_DEPARTMENT");


                              $data_replace = $query->result();

                              $res = $data_role;
                              $str = $data_role[0]->OPEN_VALUE;
                              $str = str_replace('_var1_',$data_replace[0]->title,$str);

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
                        $this->session->set_flashdata('message', array(
                            'message' => __('success_approve'),
                            'type' => 'success'
                        ));

                } else {
                    $type = 'error';
                    $message = 'Something went wrong. Please try again';
                }
            } elseif ($action == 2) {
                if ($this->M_purchase_order->reject($post['id'], $post['data_id'], $post['deskripsi'])) {
                    $type = 'success';
                    $message = 'Agreement Approved';
                } else {
                    $type = 'error';
                    $message = 'Something went wrong. Please try again';
                }
                $this->session->set_flashdata('message', array(
                    'message' => __('success_reject'),
                    'type' => 'success'
                ));
            } else {
                $type = 'error';
                $message = 'Unknown action';
                //show_error('Unknown action', 400);
            }
        }

        $response['type'] = $type;
        $response['message'] = $message;

        return $this->output->set_content_type('application/json')
            ->set_output(@json_encode($response));
    }

    public function issueList()
    {
        $this->load->model('setting/M_master_company')
            ->model('vendor/M_show_vendor')
            ->model('procurement/M_msr')
            ->model('approval/M_approval');

        $message = array();
        $menu = get_main_menu();

        $pos = $this->M_purchase_order->toIssue();

        $this->template->display('procurement/V_po_to_issue_list', compact('menu', 'pos', 'message'));
    }

    public function toIssue($id)
    {
        $this->load->model('setting/M_master_company')
            ->model('vendor/M_show_vendor')
            ->model('approval/M_approval')
            ->model('procurement/M_msr')
            ->model('setting/M_delivery_point')
            ->model('setting/M_importation')
            ->model('other_master/M_currency')
            ->model('M_sendmail')
            ->model('setting/M_itemtype');

        $message = array();
        $menu = get_main_menu();

        if (!$id) {
            show_404();
        }

        $po = $this->M_purchase_order->find($id);

        if (!$po) {
            show_404('The document is not found');
        }

        if ($po->issued == 1) {
            show_error("The document already issued");
        }

        // Check whether all approval has been done?
        if (!$this->M_purchase_order->isApprovalCompleted($po->id)) {
            show_error('The document approval is not complete yet');
        }

        if ($this->input->post()) {
            $hit_db = true;

            if (false === ($attachment_files = $this->handleUploadAttachment([
                'signed_po'
            ]))) {
                $hit_db = false;

                $message['message'] = $this->upload->display_errors();
                $message['type'] = 'danger';
                log_message('error', $message['message']);
            }

            if ($hit_db) {
                $attachments = $this->makePOAttachmentsFromPost($po->id, $attachment_files, [
                        'signed_po' => $this->M_purchase_order_attachment::TYPE_SIGNED_PO,
                    ], $this->M_purchase_order::module_kode);

                // Update editable field on PO header
                $po_data = $this->makePOIssueFromPost();
                unset($po_data['id']);
                $this->M_purchase_order->update($po->id, $po_data);

                if ($this->M_purchase_order->issue($po->id)) {
                    log_history($this->M_purchase_order::module_kode, $po->po_no, 'Issued');

                    foreach($attachments as $att) {
                        $att['data_id'] = $po->id;
                        $att['module_kode'] = $this->M_purchase_order::module_kode;

                        $this->M_purchase_order_attachment->add($att);

                    }

                    $this->M_purchase_order->addToISync($po->id);

                    $this->sendTheRestRegretLetter($po->bl_detail_id);

                    $img1 = "";
                    $img2 = "";
                    $query = $this->db->query('SELECT po.po_no AS po, po.msr_no AS msr_no, po.company_desc AS company, po.po_date AS po_date, po.delivery_date AS delivery_date, vend.ID_VENDOR AS email, vend.NAMA AS vendor, notif.TITLE AS title, notif.OPEN_VALUE AS open, notif.CLOSE_VALUE AS close FROM t_purchase_order po
                    JOIN t_bl_detail bl ON po.bl_detail_id = bl.id
                    JOIN m_vendor vend ON bl.vendor_id = vend.ID
                    JOIN m_notic notif ON notif.ID = 85
                    WHERE po.id = ' . $id);

                    $data_succes = $query->result();

                    $query2 = $this->db->query('SELECT bl.bled_no AS doc_no, bl.title AS doc_title, bl.msr_no AS msr_no, msr.dpoint_desc AS company, vnd.ID_VENDOR AS email, vnd.NAMA AS vendor, notif.TITLE AS title, notif.OPEN_VALUE AS open, notif.CLOSE_VALUE AS close FROM t_bl bl
                    JOIN t_bl_detail bld ON bl.msr_no = bld.msr_no
                    JOIN t_msr msr ON bl.msr_no = msr.msr_no
                    JOIN m_vendor vnd ON bld.vendor_id = vnd.ID
                    JOIN m_notic notif ON notif.ID = 41
                    WHERE bl.msr_no = "' . $data_succes[0]->msr_no . '"
                    AND bld.awarder = 0');

                    $data_unsuccess = $query2->result();

                    $str = $data_succes[0]->open;

                    $success = array(
                        'img1' => $img1,
                        'img2' => $img2,
                        'title' => $data_succes[0]->title,
                        'open' => $str,
                        'close' => $data_succes[0]->close
                    );

                    foreach ($data_succes as $value) {
                        $success['dest'][] = $value->email;
                    }

                    if (count($data_unsuccess) > 0) {
                        $rep = $data_unsuccess[0]->open;
                        $rep = str_replace('[_var1_]', $data_unsuccess[0]->company, $rep);
                        $rep = str_replace('[title]', $data_unsuccess[0]->doc_title, $rep);
                        $rep = str_replace('[no]', $data_unsuccess[0]->doc_no, $rep);

                        $unsuccess = array(
                            'img1' => $img1,
                            'img2' => $img2,
                            'title' => $data_unsuccess[0]->title,
                            'open' => $rep,
                            'close' => $data_unsuccess[0]->close
                        );

                        foreach ($data_unsuccess as $item) {
                            $unsuccess['dest'][] = $item->email;
                        }

                        $unsuccessmail = $this->M_sendmail->sendMail($unsuccess);
                    }

                    $successmail = $this->M_sendmail->sendMail($success);

                    $this->session->set_flashdata('message', array(
                        'message' => __('success_submit'),
                        'type' => 'success'
                    ));

                    return redirect('home');
                }

            }
        }

        $m_purchase_order_attachment = $this->M_purchase_order_attachment;
        $po_attachment_type = $m_purchase_order_attachment->getTypes();

        $po = $this->M_purchase_order->find($id);
        $msr = $this->M_msr->find($po->msr_no);
        $po_items = $this->M_purchase_order_detail->findByPOId($po->id);
        $po_attachments = $this->M_purchase_order_attachment->getByDocument($po->id, [
            $this->M_purchase_order_attachment::TYPE_DRAFT_PO,
            $this->M_purchase_order_attachment::TYPE_SIGNED_PO
        ]);
        $po_required_doc = [];
        foreach($this->M_purchase_order_required_doc->getByPOId($po->id) as $rdoc) {
            $po_required_doc[$rdoc->doc_type] = $rdoc;
        }

        $opt_po_required_doc = array_pluck($po_required_doc, 'doc_type');
        $company = $this->M_master_company->find($msr->id_company);
        $vendor = $this->M_show_vendor->find($po->id_vendor);
        $approval_list = $this->M_approval->list($this->M_purchase_order::module_kode, $po->id)->result();
        $roles = array_filter(explode(',', $this->session->userdata('ROLES')));

        $requestor = $this->M_view_user->show_user($msr->create_by);
        $requestor_dept = $this->M_master_department->find($requestor->ID_DEPARTMENT);

        $opt_currency = array_pluck($this->M_currency->all(), 'CURRENCY', 'ID');
        $opt_dpoint = array_pluck($this->M_delivery_point->all(), 'DPOINT_DESC', 'ID_DPOINT');
        $opt_importation = array_pluck($this->M_importation->all(), 'IMPORTATION_DESC', 'ID_IMPORTATION');
        $opt_tkdn_type = array_pluck($this->M_tkdn_type->all(), 'name', 'id');
        $opt_item_type = array_pluck($this->M_itemtype->all(), "ITEMTYPE_DESC", "ID_ITEMTYPE");
        $opt_msr_inventory_type = array_pluck($this->M_msr_inventory_type->all(), "description", "id");
        $opt_delivery_term = array_pluck($this->M_delivery_term->allActive(), 'DELIVERYTERM_DESC', 'ID_DELIVERYTERM');


        $this->template->display('procurement/V_po_to_issue', compact(
            'menu', 'po', 'po_items', 'message', 'company', 'vendor', 'po_attachments', 'po_attachment_type',
            'approval_list', 'po_required_doc', 'opt_po_required_doc', 'roles',
            'msr', 'opt_currency', 'opt_dpoint', 'opt_importation', 'opt_tkdn_type',
            'opt_item_type', 'm_purchase_order_attachment', 'requestor', 'requestor_dept',
            'opt_msr_inventory_type', 'opt_delivery_term'
        ));
    }

    public function inquiry()
    {
        $params = [];
        $menu = get_main_menu();

        $pos = $this->M_purchase_order->inquiry($params);
        $pos_status_stmt = $this->M_purchase_order->approvalStatuses(null, ['resource' => true]);

        $pos_status = [];
        while($row = $pos_status_stmt->unbuffered_row()) {

            if ($row->accept_completed == 1) {
                $row->status_code = 'ACTIVED';
            }
            elseif ($row->completed == 1) {
                $row->status_code = 'ACCEPTED';
            }
            elseif ($row->issued == 1) {
                $row->status_code = 'ISSUED';
            }

            switch ($row->status_code) {
                case 'COMPLETE':
                    $row->action_to_role_description = 'Completed';
                    break;
                case 'ISSUED':
                    $row->action_to_role_description = 'Agreement Issued';
                    break;
                case 'ACCEPTED':
                    $row->action_to_role_description = 'Accepted';
                    break;
				case 'REJECT':
                    $row->action_to_role_description = 'Rejected';
                    break;
                case 'ACTIVED':
                    $row->action_to_role_description = 'Active Agreement';
                    break;
            }

            $pos_status[$row->id] = $row;
        }
        array_walk($pos, function($po) use ($pos_status) {
            $po_status = @$pos_status[$po->id];

            $po->status_code = @$po_status->status_code ?: 'UNKNOWN';
            $po->action_to_role_description = @$po_status->action_to_role_description ?: '';
        });
        $arf_issued = $this->M_arf->arf_issued()->result();
        $po_issued = [];
        $arf_list = [];
        foreach ($arf_issued as $key => $value) {
            $po_issued[$value->po_no] = $value;
            $arf_list[$value->id] = $value->doc_no;
        }
        $this->template->display('procurement/V_po_inquiry', compact(
            'menu', 'pos', 'arf_issued', 'po_issued','arf_list'
        ));
    }

    public function completed($id = null)
    {
        $params = [];
        $menu = get_main_menu();

        if ($id) {
            return $this->showCompleted($id);
        }

        $pos = $this->M_purchase_order->toBeAcceptCompleted($id, $params);

        $this->template->display('procurement/V_po_inquiry_accepted', compact(
            'menu', 'pos'
        ));
    }

    public function showCompleted($id)
    {
        if (!$id) {
            show_error("Invalid request", 400);
        }

        $po = $this->M_purchase_order->find($id);

        if (!$po) {
            show_404('The Agreement document is not found');
        }

        if ($po->completed != 1) {
            show_error('Invalid document state (not supplier accepted)');
        }

        $message = array();
        $menu = get_main_menu();

        if ($post = $this->input->post()) {
            $hit_db = true;

            if (false === ($attachment_files = $this->handleUploadAttachment([
                'attachment_'.$this->M_purchase_order_attachment::TYPE_COUNTER_SIGNED_PO
            ]))) {
                $hit_db = false;

                $message['message'] = $this->upload->display_errors();
                $message['type'] = 'danger';
                log_message('error', $message['message']);
            }

            if ($hit_db) {
                $this->db->trans_start();

                foreach($attachment_files as $upload_file) {
                    $attachment = $this->makeAttachment(
                        $po->id,
                        $this->M_purchase_order_attachment::TYPE_COUNTER_SIGNED_PO,
                        $upload_file,
                        $this->M_purchase_order::module_kode
                    );

                    $this->M_purchase_order_attachment->add($attachment);
                }

                $this->M_purchase_order->acceptCompleteness($po->id);

                $this->db->trans_complete();

                if ($this->db->trans_status() !== false) {
                    $this->session->set_flashdata('message', array(
                        'message' => 'Agreement #'.$po->po_no.' saved',
                        'type' => 'success'
                    ));

                    return redirect('/procurement/purchase_order/completed');
                }
            }

        }

        $po_attachment_type = $this->M_purchase_order_attachment->getTypes();

        $msr = $this->M_msr->find($po->msr_no);
        $po_items = $this->M_purchase_order_detail->findByPOId($po->id);
        $po_attachments = $this->M_purchase_order_attachment->getByDocument($po->id, [
            $this->M_purchase_order_attachment::TYPE_DRAFT_PO,
            $this->M_purchase_order_attachment::TYPE_SIGNED_PO,
            $this->M_purchase_order_attachment::TYPE_COUNTER_SIGNED_PO
        ]);
        $po_required_doc = [];
        foreach($this->M_purchase_order_required_doc->getByPOId($po->id) as $reqdoc) {
            $po_required_doc[$reqdoc->doc_type] = $reqdoc;
        }
        $opt_po_required_doc = array_pluck($po_required_doc, 'doc_type');
        $company = $this->M_master_company->find($msr->id_company);
        $vendor = $this->M_show_vendor->find($po->id_vendor);
        $approval_list = $this->M_approval->list($this->M_purchase_order::module_kode, $po->id)->result();
        $roles = array_filter(explode(',', $this->session->userdata('ROLES')));

        $requestor = $this->M_view_user->show_user($msr->create_by);
        $requestor_dept = $this->M_master_department->find($msr->id_department);

        $opt_currency = array_pluck($this->M_currency->all(), 'CURRENCY', 'ID');
        $opt_dpoint = array_pluck($this->M_delivery_point->all(), 'DPOINT_DESC', 'ID_DPOINT');
        $opt_importation = array_pluck($this->M_importation->all(), 'IMPORTATION_DESC', 'ID_IMPORTATION');
        $opt_tkdn_type = array_pluck($this->M_tkdn_type->all(), 'name', 'id');
        $opt_item_type = array_pluck($this->M_itemtype->all(), "ITEMTYPE_DESC", "ID_ITEMTYPE");
        $opt_msr_inventory_type = array_pluck($this->M_msr_inventory_type->all(), "description", "id");
        $opt_delivery_term = array_pluck($this->M_delivery_term->allActive(), 'DELIVERYTERM_DESC', 'ID_DELIVERYTERM');

        foreach($po as $prop => $val) {
            $_POST[$prop] = $val;
        }

        $this->template->display('procurement/V_po_accepted_submit', compact(
            'menu', 'po', 'po_items', 'message', 'company', 'vendor', 'po_attachments', 'po_attachment_type',
            'approval_list', 'po_required_doc', 'opt_po_required_doc', 'roles',
            'msr', 'opt_currency', 'opt_dpoint', 'opt_importation', 'opt_tkdn_type',
            'opt_item_type', 'requestor', 'requestor_dept', 'opt_msr_inventory_type', 'opt_delivery_term'
        ));
    }

    public function active($id = null)
    {
        $params = [];
        $menu = get_main_menu();

        if ($id) {
            $po = $this->M_purchase_order->find($id);

            if ($po->accept_completed != 1) {
                show_error('The document did not active yet');
            }

            return $this->show($id);
        }

        $pos = $this->M_purchase_order->acceptCompleted($id, $params);

        $action_buttons = [
            [
                'href' => base_url('/procurement/purchase_order/active/'),
                'class' => 'btn btn-sm btn-success',
                'text' => 'Show'
            ]
        ];

        $this->template->display('procurement/V_po_inquiry_accepted', compact(
            'menu', 'pos', 'action_buttons'
        ));
    }

    public function logHistory($id)
    {
        $response= [];

        $po = $this->M_purchase_order->find($id);

        if ($po) {
            $log = $this->approval_lib->getLog([
                'data_id' => $id,
                'module_kode'=> $this->M_purchase_order::module_kode,
            ])->result();

            if ($po->issued == 1) {
                array_unshift($log, (object) [
                    'id' => '',
                    'module_kode' => $this->M_purchase_order::module_kode,
                    'data_id' => $po->id,
                    'description' => 'Issued',
                    'keterangan' => '',
                    'created_at' => $po->issued_date,
                    'created_by' => $po->issued_by
                ]);
            }

            if ($po->completed == 1) {
                array_unshift($log, (object) [
                    'id' => '',
                    'module_kode' => $this->M_purchase_order::module_kode,
                    'data_id' => $po->id,
                    'description' => 'Accepted',
                    'keterangan' => '',
                    'created_at' => $po->completed_date,
                    'created_by' => $po->completed_by
                ]);
            }

            foreach($log as &$l) {
                if($l->description == 'Accepted')
                {
                    $creator = supplier($l->created_by);
                    $creator_name = @$creator->NAMA;
                }
                else
                {
                    $creator = user($l->created_by);
                    $creator_name = @$creator->NAME;
                }
                $comment  = $l->keterangan;

                $l->created_by_name = $creator_name;
                $l->activity_string = $l->description;
                $l->activity = $l->description. ' by ' . $l->created_by_name;
                $l->comment = $comment;
            }

            $response['data'] = $log;
        }

        return $this->output->set_content_type('application/json')
            ->set_output(@json_encode($response));
    }

    public function agreementList()
    {
        $this->load->model('setting/M_master_company')
            ->model('vendor/M_show_vendor')
            ->model('procurement/M_msr')
            ->model('approval/M_approval');

        $message = array();
        $menu = get_main_vendor_menu();

        $pos = $this->M_purchase_order->getIssuedByVendor($this->session->userdata('ID'));

        if (! $pos) {
            $message['type'] = 'info';
            $message['message'] = 'There is no document to be issued yet';
        }

        $this->template->display_vendor('procurement/V_po_to_agreement_list', compact(
            'menu', 'pos', 'message'
        ));
    }

    /**
     * @param $id int  PO ID
     */
    public function createAgreement($id)
    {
        $this->load->model('setting/M_master_company')
            ->model('vendor/M_show_vendor')
            ->model('approval/M_approval')
            ->model('procurement/M_msr')
            ->model('setting/M_delivery_point')
            ->model('setting/M_importation')
            ->model('other_master/M_currency')
            ->model('user/M_view_user')
            ->model('setting/M_master_department')
            ->model('setting/M_itemtype');

        $message = array();
        $menu = get_main_vendor_menu();

        if (!$id) {
            show_404();
        }

        $po = $this->M_purchase_order->find($id);

        if (!$po) {
            show_error('The Agreement document is not found', 404);
        }

        if ($po->id_vendor != $this->session->userdata('ID')) {
            show_error('Not authorized');
        }

        if ($po->issued != 1) {
            show_error("The document is not ready yet");
        }

        if ($this->input->post()) {
            $post = $this->input->post();
            $hitdb = true;
            $attachment_files = [];

            if (isset($_FILES)) {
                if (false === ($attachment_files = $this->handleUploadAttachment([
                    'attachment_'.$this->M_purchase_order_attachment::TYPE_COUNTER_SIGNED_PO
                ]))) {
                    $hit_db = false;

                    $message['message'] = $this->upload->display_errors();
                    $message['type'] = 'danger';
                    log_message('error', $message['message']);
                }
            }

            /*
            $po_documents = $this->makePODocumentAgreementFromPost();

            if ($po_documents) {
                $this->db->trans_start();

                foreach($po_documents as $i => &$doc) {
                    if (isset($po_document_attachments[$i])) {
                        $attachment = $this->makeAttachment(
                            $po->id,
                            $this->M_purchase_order::module_kode,
                            $po_document_attachments[$i],
                            $this->M_purchase_order_document::TYPE_COMPLETENESS_PO
                            );


                        $this->M_purchase_order_attachment->add($attachment);
                        $doc['upload_id'] = $this->db->insert_id();
                    }

                    $this->M_purchase_order_document->add($doc);
                    $id = $this->db->insert_id();

                }

                $this->db->trans_complete();

                if ($this->db->trans_status() !== false) {
                    $this->session->set_flashdata('message', array(
                        'message' => 'Agreement #'.$po->po_no.' saved',
                        'type' => 'success'
                    ));

                    return redirect('procurement/purchase_order/agreementList');
                }

                $this->db->trans_rollback();
            }
            */

            if ($hitdb) {
                // check required document
                $po_docs = array_pluck($this->M_purchase_order_document->findByPOId($po->id), 'doc_type');
                $po_required_doc = $this->M_purchase_order_required_doc->getByPOId($po->id);

                $no_po_docs_found = array_filter($po_required_doc, function ($doc) use ($po_docs) {
                   return !in_array($doc->doc_type, $po_docs);
                });

                if (count($no_po_docs_found) > 0) {
                    $hit_db = false;

                    $message['message'] = 'Please upload required document';
                    $message['type'] = 'danger';
                    log_message('error', $message['message']);
                }
            }

            if ($hitdb) {
                $this->db->trans_start();

                foreach($attachment_files as $upload_file) {
                    $attachment = $this->makeAttachment(
                        $po->id,
                        $this->M_purchase_order_attachment::TYPE_COUNTER_SIGNED_PO,
                        $upload_file,
                        $this->M_purchase_order::module_kode
                    );

                    $this->M_purchase_order_attachment->add($attachment);
                }

                $this->M_purchase_order->complete($po->id);

                $this->db->trans_complete();

                if ($this->db->trans_status() !== false) {
                    $this->session->set_flashdata('message', array(
                        'message' => 'Agreement #'.$po->po_no.' saved',
                        'type' => 'success'
                    ));

                    return redirect('procurement/purchase_order/agreementList');
                }

                $this->db->trans_rollback();
            }
        }

        $po_attachment_type = $this->M_purchase_order_attachment->getTypes();
        $po_document_type = $this->M_purchase_order_document->getTypes();

        $po = $this->M_purchase_order->find($id);
        $msr = $this->M_msr->find($po->msr_no);
        $po_items = $this->M_purchase_order_detail->findByPOId($po->id);
        $po_attachments = $this->M_purchase_order_attachment->getByDocument(
            $po->id,
            $this->M_purchase_order_attachment::TYPE_SIGNED_PO
        );
        $po_required_doc = [];
        foreach($this->M_purchase_order_required_doc->getByPOId($po->id) as $reqdoc) {
            $po_required_doc[$reqdoc->doc_type] = $reqdoc;
        }
        $opt_po_required_doc = array_pluck($po_required_doc, 'doc_type');

        $opt_currency = array_pluck($this->M_currency->all(), 'CURRENCY', 'ID');
        $opt_dpoint = array_pluck($this->M_delivery_point->all(), 'DPOINT_DESC', 'ID_DPOINT');
        $opt_importation = array_pluck($this->M_importation->all(), 'IMPORTATION_DESC', 'ID_IMPORTATION');
        $opt_tkdn_type = array_pluck($this->M_tkdn_type->all(), 'name', 'id');
        $opt_item_type = array_pluck($this->M_itemtype->all(), "ITEMTYPE_DESC", "ID_ITEMTYPE");
        $opt_delivery_term = array_pluck($this->M_delivery_term->allActive(), 'DELIVERYTERM_DESC', 'ID_DELIVERYTERM');

        $this->template->display_vendor('procurement/V_po_create_agreement', compact(
            'menu', 'po', 'po_items', 'message', 'po_attachments', 'po_attachment_type',
            'po_required_doc', 'opt_po_required_doc', 'msr', 'opt_currency', 'opt_dpoint',
            'opt_importation', 'opt_tkdn_type', 'opt_item_type', 'po_document_type',
            'po_documents', 'po_document_attachment', 'opt_delivery_term'
        ));
    }

    public function getPODocumentAgreement($po_id, $doc_type)
    {
        $this->load->model('other_master/M_currency');

        $po_document_attachment = $this->M_purchase_order_attachment->getByDocument(
            $po_id,
            $this->M_purchase_order_attachment::TYPE_COMPLETENESS_PO
        );

        $po = $this->M_purchase_order->find($po_id);

        $can_edit_po_document = can_edit_po_document($po);

        $attachment = [];
        foreach($po_document_attachment as $att) {
            $attachment[$att->id] = $att;
        }

        $po_documents = $this->M_purchase_order_document->findByPOId($po_id, $doc_type);

        foreach($po_documents as &$doc) {
            $att = @$attachment[$doc->upload_id];
            $doc->file_url = base_url(@$att->file_path.@$att->file_name);
            $doc->file_name = @$att->file_name ? $att->file_name : '';

            // add aliases
            $doc->doc_id = $doc->id;
            $doc->currency_id = $doc->id_currency;
            $doc->currency_name = @$this->M_currency->find($doc->id_currency)->CURRENCY;

            $doc->action_btn = "";
            if ($can_edit_po_document) {
                $doc->action_btn = "<a href=\"#\" role=\"button\" "
                    ."data-toggle=\"modal\" data-target=\"#po_document_modal\" "
                    ."data-id=\"{$doc->doc_id}\" "
                    ."class=\"po-document-update-btn btn btn-sm btn-primary\" "
                    .">Update</a>";
            }
        }

        $response['data'] = $po_documents;

        return $this->output->set_content_type('application/json')
            ->set_output(@json_encode($response));
    }

    public function getPODocumentAgreementItem($item_id)
    {
        $doc = $this->M_purchase_order_document->find($item_id);
        $po = $this->M_purchase_order->find($doc->po_id);

        $po_document_attachment = $this->M_purchase_order_attachment->find($doc->upload_id);

        $attachment[$po_document_attachment->id] = $po_document_attachment;

        $att = @$attachment[$doc->upload_id];
        $doc->file_url = base_url(@$att->file_path.@$att->file_name);
        $doc->file_name = @$att->file_name ?: '';

        // add aliases
        $doc->doc_id = $doc->id;
        $doc->currency_id = $doc->id_currency;
        $doc->currency_name = @$this->M_currency->find($doc->id_currency)->CURRENCY;
        $doc->action_btn = "";

        $can_edit_po_document = can_edit_po_document($po);

        if ($can_edit_po_document) {
            $doc->action_btn = "<a href=\"#\" role=\"button\" "
                ."data-toggle=\"modal\" data-target=\"#po_document_modal\" "
                ."data-id=\"{$doc->doc_id}\" "
                ."class=\"po-document-update-btn btn btn-sm btn-primary\" "
                .">Update</a>";
        }

        $response['data'] = $doc;

        return $this->output->set_content_type('application/json')
            ->set_output(@json_encode($response));

    }

    public function uploadPODocumentAgreement()
    {
        $post = $this->input->post();
        $response = ['data' => '', 'type' => '', 'message' => ''];
        $this->upload->initialize($this->uploadConfig);
        $upload_file = [];

        if ($post) {
            $hitdb = true;
            if (!($po = $this->M_purchase_order->find($post['po_id']))) {
                $response['type'] = 'error';
                $response['message'] = 'Invalid Agreement';

                $hitdb = false;
            }

            if ($hitdb) {
                // mandatory on new only
                if (!@$post['id'] || isset($_FILES['attachment'])) {
                    $this->upload->do_upload('attachment');
                    $upload_file = $this->upload->data();

                    if ($this->upload->display_errors()) {
                        $response['type']  = 'error';
                        $response['message'] = $this->upload->display_errors();
                        $hitdb = false;
                    }
                }
                // elseif (isset($_FILES['attachment'])) {
                //     $this->upload->do_upload('attachment');
                //     $upload_file = $this->upload->data();

                //     if ($this->upload->display_errors()) {
                //         $response['type']  = 'error';
                //         $response['message'] = $this->upload->display_errors();
                //         $hitdb = false;
                //     }
                // }
            }

            if ($hitdb) {
                if ($upload_file) {
                    $attachment = $this->makeAttachment(
                        $po->id,
                        $this->M_purchase_order_attachment::TYPE_COMPLETENESS_PO,
                        $upload_file,
                        $this->M_purchase_order::module_kode
                    );

                    $this->M_purchase_order_attachment->add($attachment);
                    $post['upload_id'] = $this->db->insert_id();
                }
                // No attachment update, use existing
                elseif (@$post['id']) {
                    $po_document = $this->M_purchase_order_document->find($post['id']);
                    $post['upload_id'] = $po_document->upload_id;
                    $attachment = (array) $this->M_purchase_order_attachment->find($post['upload_id']);
                }

                $data = $this->makePODocumentAgreement($po->id, $post['doc_type'], $post);

                // update existing data
                if (@$post['id']) {
                    $this->M_purchase_order_document->update($post['id'], $data);
                }
                // insert new one
                else {
                    $this->M_purchase_order_document->add($data);
                }


                $data['file_url'] = base_url($attachment['file_path'].$attachment['file_name']);
                $data['file_name'] = $attachment['file_name'];
                $response['type'] = 'success';
                $response['message'] = 'Success';
                $response['data'] = $data;
            }
        }

        return $this->output->set_content_type('application/json')
            ->set_output(@json_encode($response));
    }

    protected function makePODocumentAgreementFromPost()
    {
        $data = array();

        $po_id = $this->input->post('id');
        $po_documents = $this->input->post('po_document');
        $po_req_doc = $this->M_purchase_order_required_doc->getByPOId($po_id);

        // only get already defined required document
        foreach($po_req_doc as $doc) {
            foreach($po_documents as $po_doc) {
                if (isset($po_doc['doc_type']) && $po_doc['doc_type'] == $doc->doc_type) {
                    $data[$po_doc['doc_id']] = $this->makePODocumentAgreement($po_id, $doc->doc_type, $po_doc);
                }
            }
        }

        return $data;
    }

    protected function makePODocumentAgreement($po_id, $doc_type, $item)
    {
        return [
            "id"            => @$item['id'] ?: NULL,
            "po_id"         => $po_id,
            "doc_type"      => $doc_type,
            "doc_no"        => @$item['doc_no'],
            "issuer"        => @$item['issuer'],
            "issued_date"   => @$item['issued_date'],
            "value"         => @$item['value'],
            "id_currency"   => @$item['currency_id'],
            "effective_date" => @$item['effective_date'],
            "expired_date"  => @$item['expired_date'],
            "status"        => @$item['status'],
            "description"   => @$item['description'],
            "upload_id"   => @$item['upload_id']
        ];
    }

    protected function makePODocumentAttachmentFromPost($po_id, $files, $attachments_type, $module_kode)
    {
        /* $attachments = array(); */

        /* $attachments[] = $this->makeAttachment($po_id, $type, $files[$name], $module_kode); */

        /* return $attachments; */
    }

    protected function validatePOCreate()
    {
        //$this->form_validation->set_message('required', 'This field is required.');

        $config = array(
            array('field'   => 'title',
                'label'     => 'Title',
                'rules'     => 'trim|required',
                'errors'    => 'Title is required'),
            array('field'   => 'po_date_submit',
                'label'     => 'PO Date',
                'rules'     => 'trim|required|date',
                'errors'    => 'PO date is required'),
             array('field'  => 'delivery_date_submit',
                 'label'    => 'Delivery Date',
                 'rules'    => 'trim|required|date',
                 'errors'   => 'Delivery date is required'),
             array('field'  => 'payment_term',
                'label'     => 'Payment Term',
                'rules'     => 'trim|required',
                'errors'    => 'Payment Term is required'),
             array('field'  => 'id_currency',
                'label'     => 'Currency',
                'rules'     => 'trim|required',
                'errors'    => 'Currency is required'),
             array('field'  => 'account_name',
                'label'     => 'Account Name',
                'rules'     => 'trim|required',
                'errors'    => 'Account Name is required'),
             array('field'  => 'bank_name',
                'label'     => 'Bank Name',
                'rules'     => 'trim|required',
                'errors'    => 'Bank Name is required'),
             //array('field'    => 'tkdn_type',
                 //'rules'  => 'trim|required',
                 //'errors'     => 'TKDN Type is required'),
            //array('field'     => 'statement_of_authenticity',
                //'rules'   => 'required',
                //'errors'  => 'Statement authenticity file is required'),
        );

        if ($this->input->post('po_type') == $this->M_purchase_order_type::TYPE_GOODS) {
            /*$config[] = array(
                'field'     => 'id_importation',
                'label'     => 'Importation',
                'rules'     => 'trim|required',
                'errors'    => 'Importation is required'
                );*/
            $config[] = array(
                'field'     => 'shipping_term',
                'label'     => 'shipping term',
                'rules'     => 'trim|required',
                'errors'    => 'shipping term is required'
                );
            $config[] = array(
                'field'     => 'id_dpoint',
                'label'     => 'Delivery Point',
                'rules'     => 'trim|required',
                'errors'    => 'Delivery Point is required'
            );
        }

        // TODO check sum of TKDN value must be 100%

        $this->form_validation->set_rules($config);
        return $this->form_validation->run();
    }

    protected function makePOFromPost()
    {
        $post = $this->input->post();

        $bl_detail_id = $this->input->post('bl_detail_id');
        $bl = $this->M_bl->getBlByBlDetailId($bl_detail_id);
        $awarder = $this->M_bl->getAwarderById($bl_detail_id);
        $id_currency_base = base_currency();

        $po_type = $this->M_purchase_order_type->getFromMsrType($bl->id_msr_type ?: '');

        if ($po_type == $this->M_purchase_order_type::TYPE_GOODS) {
            $module_kode = $this->M_purchase_order::module_kode;
            // $shipping_term = $bl->incoterm;
            $shipping_term = isset($post['shipping_term']) ? $post['shipping_term'] : $bl->incoterm;
            $master_list = isset($post['master_list']) ? 1 : 0;
        }
        else {
            $module_kode = $this->M_service_order::module_kode;
            $shipping_term = '';
            $master_list = 0;
        }

        $tkdn_value_service = $tkdn_value_goods = 0;
        if (in_array($post['tkdn_type'], array(2, 3))) {
            $tkdn_value_service = $post['tkdn_value_service'];
        }

        if (in_array($post['tkdn_type'], array(1, 3))) {
            $tkdn_value_goods = $post['tkdn_value_goods'];
        }

        $loi = $this->M_loi->findByBlDetailId($bl_detail_id);

        if ($loi && !empty($loi->po_no)) {
            $po_no = $loi->po_no;
            // $po_no = DocNumber::generate($module_kode, $bl->id_company);
        }
        elseif (!$this->M_purchase_order->isMSRHasPO($bl->msr_no)) {
            #cek berapa pemenang
            #lebih dari 1 pemenang pakai code baru, kalo 1 pemenang pakai code lama
            #cek di po dan loi msr tersebut ada gak, kalo ada cari angka maksimalnya 190 atau 191 atau 192
            $bidder = $this->db->where(['awarder'=>1, 'msr_no'=>$bl->msr_no])->get('t_bl_detail');
            if($bidder->num_rows() > 1)
            {
                $po  = $this->db->where('msr_no', $bl->msr_no)->get('t_purchase_order')->result();
                $loi = $this->db->where('msr_no', $bl->msr_no)->get('t_letter_of_intent')->result();
                $arrPoNo = [];
                foreach ($po as $v) {
                    $arrPoNo[] = $v->po_no;
                }
                foreach ($loi as $v) {
                    $arrPoNo[] = $v->po_no;
                }
                if(count($arrPoNo) > 0)
                {
                    $sorting = arsort($arrPoNo);
                    $last = $arrPoNo[0];
                    $msrNo = $last; //po_no not msrNo
                    $substr = substr($msrNo, 2, 1);
                    $seq = $substr+1;
                    $substr = substr($msrNo,0,2);
                    $substrLast = substr($msrNo,3,14);
                    $newNumber = $substr.$seq.$substrLast;
                    $po_no = $newNumber;
                }
                else
                {
                    // $msrNo = '19143002-OR-10103';
                    $msrNo = $bl->msr_no;
                    // echo "msrNo = $msrNo <br>";
                    $substr = substr($msrNo, 2, 1);
                    // echo "substr = $substr <br>";
                    $seq = $substr+1;
                    // echo "seq = $seq <br>";
                    $substr = substr($msrNo,0,2);
                    $substrLast = substr($msrNo,3,14);
                    $newNumber = $substr.$seq.$substrLast;
                    // echo "substr = $substr <br>";
                    // echo "substrLast = $substrLast <br>";
                    // echo "new number = $newNumber <br>";
                    $po_code = $po_type == $this->M_purchase_order_type::TYPE_GOODS ? $this->M_purchase_order::module_kode : $this->M_service_order::module_kode;
                    $doc_no = new DocNumber();
                    $po_code = $doc_no->getDocTypeCode($po_code);
                    $po_no = str_replace('OR', $po_code, $newNumber).'sasd';
                }
            }
            else
            {
                #oldCode
                $po_no = DocNumber::createFrom($bl->msr_no,
                    $po_type == $this->M_purchase_order_type::TYPE_GOODS ?
                        $this->M_purchase_order::module_kode :
                        $this->M_service_order::module_kode
                );
            }
        }
        else {
            $bidder = $this->db->where(['awarder'=>1, 'msr_no'=>$bl->msr_no])->get('t_bl_detail');
            $poFindByDetailId = $this->M_purchase_order->findByBlDetailId($bl_detail_id);
            if($poFindByDetailId)
            {
                $po_no = $poFindByDetailId->po_no;
            }
            else
            {
                if($bidder->num_rows() > 1)
                {
                    $po  = $this->db->where('msr_no', $bl->msr_no)->get('t_purchase_order')->result();
                    $loi = $this->db->where('msr_no', $bl->msr_no)->get('t_letter_of_intent')->result();
                    $arrPoNo = [];
                    foreach ($po as $v) {
                        $arrPoNo[] = $v->po_no;
                    }
                    foreach ($loi as $v) {
                        $arrPoNo[] = $v->po_no;
                    }
                    if(count($arrPoNo) > 0)
                    {
                        $sorting = arsort($arrPoNo);
                        $last = $arrPoNo[0];
                        $msrNo = $last; //po_no not msrNo
                        $substr = substr($msrNo, 2, 1);
                        $seq = $substr+1;
                        $substr = substr($msrNo,0,2);
                        $substrLast = substr($msrNo,3,14);
                        $newNumber = $substr.$seq.$substrLast;
                        $po_no = $newNumber;
                    }
                    else
                    {
                        // $msrNo = '19143002-OR-10103';
                        $msrNo = $bl->msr_no;
                        // echo "msrNo = $msrNo <br>";
                        $substr = substr($msrNo, 2, 1);
                        // echo "substr = $substr <br>";
                        $seq = $substr+1;
                        // echo "seq = $seq <br>";
                        $substr = substr($msrNo,0,2);
                        $substrLast = substr($msrNo,3,14);
                        $newNumber = $substr.$seq.$substrLast;
                        // echo "substr = $substr <br>";
                        // echo "substrLast = $substrLast <br>";
                        // echo "new number = $newNumber <br>";
                        $po_code = $po_type == $this->M_purchase_order_type::TYPE_GOODS ? $this->M_purchase_order::module_kode : $this->M_service_order::module_kode;
                        $doc_no = new DocNumber();
                        $po_code = $doc_no->getDocTypeCode($po_code);
                        $po_no = str_replace('OR', $po_code, $newNumber);
                    }
                }
                else
                {
                    #oldCode
                    $po_no = DocNumber::generate($module_kode, $bl->id_company);
                }
            }
        }


        $bank_account = $this->input->post('bank_account');
        list($bank_account_id_vendor, $bank_account_key) = @explode('-', $bank_account);

        return [
            'id' => null,
            'bl_detail_id' => $bl_detail_id,
        //  'id_company' => $bl->id_company,
            'id_vendor' => $awarder->vendor_id,
            'po_no' => $po_no,
            'po_type' => @$po_type,
            'msr_no' => $bl->msr_no,
            'id_company' => @$bl->id_company,
            'company_desc' => @$bl->company_desc,
            'title' => trim($post['title']),
            'po_date' => @$post['po_date_submit'],
            'delivery_date' => @$post['delivery_date_submit'],
            'blanket' => @$post['blanket'],
            'payment_term' => @$post['payment_term'],
            'shipping_term' => $shipping_term,
            'id_dpoint' => @$post['id_dpoint'],
            'id_importation' => @$post['id_importation'],
            'id_currency' => @$post['id_currency'],
            'id_currency_base' => $id_currency_base,
            'vendor_bank_account_key' => @$bank_account_key,
            'account_name' => @$post['account_name'],
            'bank_name' => @$post['bank_name'],
            'master_list' => @$master_list,
            'tkdn_type' => @$post['tkdn_type'],
            'tkdn_value_goods' => $tkdn_value_goods,
            'tkdn_value_service' => $tkdn_value_service,
            'total_amount' => @$post['total_amount'] ?: 0,
            'total_amount_base' => @$post['total_amount_base'],
            'create_by' => $this->session->userdata('ID_USER'),
            'create_on' => today_sql(),
        ];
    }

    protected function makePODetailsFromBlDetail($bl_detail_id, $po_id = NULL)
    {
        $post = $this->input->post();
        $po_items = $this->M_purchase_order_detail->getFromED($bl_detail_id);
        $currency_lookup = array_pluck($this->M_currency->all(), 'CURRENCY', 'ID');
        $uom_lookup = array_pluck($this->M_material_uom->allActive(), 'MATERIAL_UOM', 'ID');
        $uom_desc_lookup = array_pluck($this->M_material_uom->allActive(), 'DESCRIPTION', 'ID');
        $line_no = 0;

        foreach($po_items as $i => &$item) { // function(&$item) use ($currency_lookup, $uom_lookup, $post){
            $id_currency = @$currency_lookup[$item->id_currency];
            $id_currency_base = @$currency_lookup[$item->id_currency_base];

            $uom1 = $this->M_material_uom->findByMaterialUom($item->uom1);
            if (!empty($item->uom2)) {
                $uom2 = $this->M_material_uom->findByMaterialUom($item->uom2);

                $map_uom = $this->M_multi_uom_mapping->findMap(@$uom1->ID, @$uom2->ID);
                $id_uom = @$map_uom->uom;
                $uom_desc = @$uom_lookup[@$map_uom->uom];
                $uom_description = @$uom_desc_lookup[@$map_uom->uom];

                $qty = join_qty('*', $item->qty1, $item->qty2);
            } else {
                $id_uom = @$uom1->ID;
                $uom_desc = @$uom1->MATERIAL_UOM;
                $uom_description = @$uom1->DESCRIPTION;
                $qty = $item->qty1;
            }

            $item->line_no = ++$line_no;
            $item->qty = $qty;
            $item->id_uom = $id_uom;
            $item->uom_desc = $uom_desc;
            $item->uom = $uom_desc;
            $item->uom_description = $uom_description; // alias

            $item->is_modification = @$item->is_modification;
            $item->id_msr_inv_type = @$item->id_msr_inv_type;
            $item->id_costcenter = @$item->id_costcenter;
            $item->costcenter_desc  = @$item->costcenter_desc;
            $item->id_accsub= @$item->id_accsub;
            $item->accsub_desc = @$item->accsub_desc;

            $item->est_unitprice_base = exchange_rate($id_currency, $id_currency_base, $item->est_unitprice);
            $item->unitprice_base = exchange_rate($id_currency, $id_currency_base, $item->unitprice);
            $item->nego_price_base = exchange_rate($id_currency, $id_currency_base, $item->nego_price);

            $item->total_price = $item->qty * $item->unitprice;
            $item->total_price_base = $item->qty * $item->unitprice_base;
            $item->est_total_price = $item->qty * $item->est_unitprice;
            $item->est_total_price_base = $item->qty * $item->est_unitprice_base;

            $item = (array) $item;
        // });
        }

        return $po_items;
    }

    protected function makePODetail($data)
    {
        return array(
            'id'                => @$data['id'] ?: NULL,
            'po_id'             => @$data['po_id'] ?: NULL,
            'msr_item_id'       => @$data['msr_item_id'],
            'line_no'           => @$data['line_no'],
            'sop_bid_id'        => @$data['sop_bid_id'],
            'id_itemtype'       => @$data['id_itemtype'],
            'material_id'       => @$data['material_id'],
            'semic_no'          => @$data['semic_no'],
            'material_desc'     => @$data['item_desc'],
            'qty'               => @$data['qty'],
            'id_uom'            => @$data['id_uom'],
            'uom_desc'          => @$data['uom_desc'],
            'is_modification'   => @$data['is_modification'],
            'id_msr_inv_type'   => @$data['id_msr_inv_type'],
            'id_accsub'         => @$data['id_accsub'],
            'accsub_desc'       => @$data['accsub_desc'],
            'id_costcenter'     => @$data['id_costcenter'],
            'costcenter_desc'   => @$data['costcenter_desc'],
            'groupcat'          => @$data['groupcat'],
            'groupcat_desc'     => @$data['groupcat_desc'],
            'sub_groupcat'      => @$data['sub_groupcat'],
            'sub_groupcat_desc' => @$data['sub_groupcat_desc'],
            'est_unitprice'     => @$data['est_unitprice'],
            'est_unitprice_base'     => @$data['est_unitprice_base'],
            'est_total_price'   => @$data['est_total_price'],
            'est_total_price_base'   => @$data['est_total_price_base'],
            'unitprice'         => @$data['unitprice'],
            'unitprice_base'         => @$data['unitprice_base'],
            'total_price'       => @$data['total_price'],
            'total_price_base'       => @$data['total_price_base'],
        );
    }

    protected function makePORequiredDocsFromPost($po_id)
    {
        $required = array();

        foreach($this->M_purchase_order_document->getTypes() as $type => $description)
        {
            if (isset($_POST['po_document'.$type])) {
                $required[] = array(
                    'po_id' => $po_id,
                    'doc_type' => $type,
                    'description' => $this->input->post('po_document'.$type.'_text') ?: ''
                );
            }
        }

        return $required;
    }

    protected function makePOIssueFromPost()
    {
        $post = $this->input->post();

        return [
            'id' => @$post['po_id'],
            'po_date' => @$post['po_date_submit'],
            'delivery_date' => @$post['delivery_date_submit'],
        ];
    }

    protected function makePOAttachmentsFromPost($po_id, $files, $attachments_type, $module_kode)
    {
        $attachments = array();

        foreach($attachments_type as $name => $type) {
            if (isset($files[$name])) {
                $attachments[] = $this->makeAttachment($po_id, $type, $files[$name], $module_kode);
            }
        }

        return $attachments;
    }

    protected function makeAttachment($data_id, $tipe, $file, $module_kode)
    {
        return array(
            'module_kode'   => $module_kode,
            'data_id'       => $data_id,
            'file_path'     => $this->uploadConfig['upload_path'],
            'file_name'     => $file['file_name'],
            'tipe'          => $tipe,
            'creator_type'  => $this->session->userdata('ID_USER') ? null : 'vendor',
            'created_by'    => $this->session->userdata('ID_USER') ?: $this->session->userdata('ID'),
            'created_at'    => today_sql()
        );
    }

    protected function getTotalAmountFromDetail($items)
    {
        $total_price = [
            'total_price' => 0,
            'total_price_base' => 0,
            'est_total_price' => 0,
            'est_total_price_base' => 0,
        ];

        foreach($items as $item) {
            $total_price['total_price'] += ($item['total_price'] ?: ($item['qty'] * $item['unitprice']));
            $total_price['total_price_base'] += ($item['total_price_base'] ?: ($item['qty'] * $item['unitprice_base']));
            $total_price['est_total_price'] += ($item['est_total_price'] ?: ($item['qty'] * $item['est_unitprice']));
            $total_price['est_total_price_base'] += ($item['est_total_price_base'] ?: ($item['qty'] * $item['est_unitprice_base']));
        }

        return $total_price;
    }

    protected function handleUploadAttachment($names)
    {
        if (!isset($_FILES) || !$_FILES) {
            return true;
        }

        $data = array();

        $this->upload->initialize($this->uploadConfig);

        foreach($names as $name) {
            if (false === $this->upload->do_upload($name)) {
                return false;
            }

            $data[$name] = $this->upload->data();
        }

        return $data;
    }

    // --------------------------------------- sendmail  --------------------------------------------
    protected function sendMail($content) {
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

                $data_email['recipient'] = $v;
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
                if ($this->db->insert('i_notification',$data_email)) {
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




      public function requestJDE_insertPO() {
        ini_set('max_execution_time', 300);
        //error_reporting(0);
        //ini_set('display_errors', 0);
        $req_no = "";
        $result = true;
        $query_check_out = $this->db->query("select doc_no from i_sync where doc_type='po' and isclosed=0 limit 1");
        if($query_check_out->num_rows()>0){
            $result_check = $query_check_out->result();
            $req_no = $result_check[0]->doc_no;
            //$req_no = "11";
            echo "Processing PO ID : ".$req_no.PHP_EOL;

            $query_select_mat = $this->db->query("select
                RIGHT(CONCAT('            ' ,w.id_warehouse) ,12) as branchplant
                , u.USERNAME as buyerentityId
                /* , c.CURRENCY as currencyCodeTo /*  base currency */
                , cfrom.CURRENCY as currencyCodeTo /* transaction currency */
                , o.po_date as dateOrdered
                , o.delivery_date as datePromisedDelivery
                , CURRENT_DATE as dateRequested
                , o.title as description1
                , d.unitprice costUnitPurchasing
                , d.id_costcenter
                , LEFT(d.id_accsub ,4) as objectAccount
                , RIGHT(d.id_accsub ,4) as subsidiary
                , b.code as glClassCode
                , COALESCE(h.code, IF(d.is_modification = 1, 'I','J')) as lineTypeCode
                , d.qty as quantityOrdered
                , d.uom_desc
                , m.id_company
                , o.id_dpoint
                , o.po_no
                , o.id_vendor
                , v.ID_EXTERNAL
                , d.semic_no
                , d.material_desc
                , d.is_modification
                , d.id_itemtype
                , d.id_msr_inv_type
                , mit.code as msr_inv_type_code
                , o.po_type
                , u_msr.username subledger
                , i.id_dpoint item_id_dpoint
                , o.master_list
                , b.vat
                , d.line_no
				, u_msr.username as orderedBy
                from t_purchase_order o
                join t_purchase_order_detail d on d.po_id=o.id
                join t_msr m on m.msr_no=o.msr_no
                join m_warehouse w on w.id_company=m.id_company
                join m_user u on u.ID_USER=o.create_by
                join m_user u_msr on u_msr.ID_USER=m.create_by
                join m_currency cfrom on cfrom.ID=o.id_currency
                join m_currency c on c.ID=COALESCE(o.id_currency_base,1)
                join m_vendor v on v.ID=o.id_vendor
                left join t_msr_item i on i.line_item = d.msr_item_id and i.msr_no = o.msr_no
                left join m_material a on a.MATERIAL_CODE=d.semic_no
                left JOIN m_gl_class b on b.id=a.GL_CLASS
                left join m_line_type h on h.id=a.LINE_TYPE
                left join m_msr_inventory_type mit on mit.id = d.id_msr_inv_type
                where o.id='".$req_no."' ");
            $res = $query_select_mat->result();

            if ($query_select_mat->num_rows() == 0) {
                echo "Error. No data found . May be due to incomplete data. Please recheck your data".PHP_EOL;
                return false;
            }

            $ch = curl_init('https://10.1.1.94:89/PY910/ProcurementManager?WSDL');
            $detailxml = "";

            for ($i=0; $i < $query_select_mat->num_rows(); $i++) {
                // $semic_noo = "";
                // $glacc = "";
                // if (strlen($res[$i]->semic_no)>6) {
                //     $semic_noo = $res[$i]->semic_no;
                // }

                $id_costcenter = $objectAccount = $subsidiary = $glClassCode = '';
                $material_desc = $semic_no = $line_type_code = $subledger = $subledgerTypeCode = '';
                $costUnitPurchasing = $quantityOrdered = $costExtended = 0;
                $uom_desc = '';

                // GOODS
                if ($res[$i]->id_itemtype == 'GOODS' && strlen($res[$i]->semic_no) > 6) {
                    // Inventory
                    if ($res[$i]->msr_inv_type_code == 'INV') {
                        $id_costcenter = '';
                        $objectAccount = '';
                        $subsidiary = '';
                        $glClassCode = '';
                        $material_desc = '';
                        $semic_no = $res[$i]->semic_no;
                        $line_type_code = 'S';
                    }
                    // Asset
                    elseif ($res[$i]->msr_inv_type_code == 'AST') {
                        $id_costcenter = $res[$i]->id_costcenter;
                        $objectAccount = $res[$i]->objectAccount;
                        $subsidiary = $res[$i]->subsidiary;
                        $glClassCode = 'NS40';
                        $material_desc = '';
                        $semic_no = $res[$i]->semic_no;
                        $line_type_code = 'J';
                        $subledger = $res[$i]->subledger;
                        $subledgerTypeCode = 'A';
                    }
                    // Consignment
                    elseif ($res[$i]->msr_inv_type_code == 'CON') {
                        $id_costcenter = $res[$i]->id_costcenter;
                        $objectAccount = $res[$i]->objectAccount;
                        $subsidiary = $res[$i]->subsidiary;
                        $glClassCode = 'NS40';
                        $material_desc = '';
                        $semic_no = $res[$i]->semic_no;
                        $line_type_code = 'J';
                        $subledger = $res[$i]->subledger;
                        $subledgerTypeCode = 'A';
                    }
                    $costUnitPurchasing = $res[$i]->costUnitPurchasing;
                    $quantityOrdered =  $res[$i]->quantityOrdered;
                    $costExtended =  '';
                    $uom_desc = substr($res[$i]->uom_desc,0,2);
                }
                // Service
                elseif ($res[$i]->id_itemtype == 'SERVICE') {
                    // Modification
                    if ($res[$i]->is_modification == '1') {
                        $id_costcenter = $res[$i]->id_costcenter;
                        $objectAccount = $res[$i]->objectAccount;
                        $subsidiary = $res[$i]->subsidiary;
                        $glClassCode = 'NS40';
                        $material_desc = $res[$i]->material_desc;
                        $semic_no = '';
                        $line_type_code = 'I';
                    }
                    // General
                    else {
                        $id_costcenter = $res[$i]->id_costcenter;
                        $objectAccount = $res[$i]->objectAccount;
                        $subsidiary = $res[$i]->subsidiary;
                        $glClassCode = 'NS40';
                        $material_desc = $res[$i]->material_desc;
                        $semic_no = '';
                        $line_type_code = 'J';
                    }
                    $costUnitPurchasing =  $res[$i]->costUnitPurchasing;
                    //$quantityOrdered = $res[$i]->quantityOrdered;
                    //Request pak Herry 20181113 utk tidak ngirim qty ke JDE jika service
                    $quantityOrdered = '';
                    $uom_desc = '';
                    $costExtended = '';
                    $subledger = $res[$i]->subledger;
                    $subledgerTypeCode = 'A';
                }

                $landedCostRuleCode = 'VAT';
                if ($res[$i]->id_itemtype == 'GOODS') {
                    $landedCostRuleCode = $res[$i]->master_list == 1 ?
                        '' :
                        $landedCostRuleCode = $res[$i]->vat;
                }

                $glacc = '<glAccount>
            <businessUnit>'.$id_costcenter.'</businessUnit>
            <objectAccount>'.$objectAccount.'</objectAccount>
            <subsidiary>'.$subsidiary.'</subsidiary>
        </glAccount>
        <glClassCode>'. $glClassCode .'</glClassCode>';

                if ($res[$i]->id_itemtype == 'SERVICE' || (
                $res[$i]->id_itemtype == 'GOODS' && in_array($res[$i]->msr_inv_type_code, ['AST', 'CON'])
                )) {
                    $glacc .= '
                    <subledger>' . $subledger . '</subledger>
                    <subledgerTypeCode>'. $subledgerTypeCode .'</subledgerTypeCode>';
                }

                if(strlen($material_desc) > 30){
                    $material_desc = substr($material_desc, 0, 29);
                }

                $detailxml = $detailxml.
'<detail>
    <actionType>1</actionType>
    <buyer>
        <!--Optional:-->
        <entityId>'.$res[$i]->buyerentityId.'</entityId>
    </buyer>

    <datesDetail>
        <dateAccounting>'.substr($res[$i]->dateRequested,0,4).'-'.substr($res[$i]->dateRequested,5,2).'-'.substr($res[$i]->dateRequested,8,2).'T00:00:00-06:00</dateAccounting>
        <dateCancel></dateCancel>
        <dateEffectiveLot></dateEffectiveLot>
        <datePromisedDelivery>'.substr($res[$i]->datePromisedDelivery,0,4).'-'.substr($res[$i]->datePromisedDelivery,5,2).'-'.substr($res[$i]->datePromisedDelivery,8,2).'T00:00:00-06:00</datePromisedDelivery>
        <dateRequested>'.substr($res[$i]->dateRequested,0,4).'-'.substr($res[$i]->dateRequested,5,2).'-'.substr($res[$i]->dateRequested,8,2).'T00:00:00-06:00</dateRequested>
    </datesDetail>

    <costUnitPurchasing>'.$costUnitPurchasing.'</costUnitPurchasing>

    <deliveryDetail>
        <!--Optional:-->
        <landedCostRuleCode>'. $landedCostRuleCode .'</landedCostRuleCode>
    </deliveryDetail>

    <financialDetail>
        '.$glacc.'
    </financialDetail>

    <product>
        <!--Jika Jasa diisi:!-->
        <description1>' . $material_desc . '</description1>
        <!--Optional:-->
        <description2></description2>
        <!--Optional:-->
        <item>
            <!--Optional:-->
            <itemCatalog>'.$semic_no.'</itemCatalog>
        </item>

        <!--Optional:-->
        <lineTypeCode>'.$line_type_code.'</lineTypeCode>
    </product>

    <purchaseOrderLineKey>
        <!--Optional:-->
        <documentLineNumber>'. $res[$i]->line_no.'</documentLineNumber>
    </purchaseOrderLineKey>

    <!--Optional:-->
    <quantityOrdered>'.$quantityOrdered.'</quantityOrdered>

    <costExtended>'. $costExtended .'</costExtended>

    <!--Keterangan:-->
    <reference>'.$res[0]->po_no.'</reference>
    <!--Keterangan2:-->
    <!-- <reference1>?</reference1> -->
    <!-- <relievePOBlanketOrder>?</relievePOBlanketOrder> -->

    <shipTo>
        <!--Addressbook:-->
        <entityId>'.(   ($res[$i]->item_id_dpoint) ? $res[$i]->item_id_dpoint : '10001').'</entityId>
    </shipTo>

    <!--Last Status : 220:-->
    <statusCodeLast>220</statusCodeLast>
    <!--Next Status : 400-->
    <statusCodeNext>400</statusCodeNext>

    <!--User : SCM-->
    <transactionOriginator>SCM</transactionOriginator>
    <!--UOM Primary-->
    <unitOfMeasureCodePurchasing>'.$uom_desc.'</unitOfMeasureCodePurchasing>
    <unitOfMeasureCodeTransaction>'.$uom_desc.'</unitOfMeasureCodeTransaction>
</detail>

            ';

            }


            $desc = $res[0]->description1;
            $desc2 = '';
            if(strlen($res[0]->description1)>30){
                $desc = substr($res[0]->description1,0,29);
                $desc2 = substr($res[0]->description1,30,59);
            }


        $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:orac="http://oracle.e1.bssv.JP430000/">
<soapenv:Header>
<wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
    xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
    xmlns:env="http://schemas.xmlsoap.org/soap/envelope/"
    soapenv:mustUnderstand="1">
        <wsse:UsernameToken xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
        xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
            <wsse:Username>SCM</wsse:Username>
                <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">abpberjaya</wsse:Password>
        </wsse:UsernameToken>
    </wsse:Security>
</soapenv:Header>
   <soapenv:Body>
      <orac:processPurchaseOrderV2>
         <!--Optional:-->
         <header>
            <!--Branch/Plant:-->
            <businessUnit>'.$res[0]->branchplant.'</businessUnit>
            <!--Nomor Pegawai:-->
            <buyer>
               <entityId>'.$res[0]->buyerentityId.'</entityId>
            </buyer>
            <currencyCodeTo>'.$res[0]->currencyCodeTo.'</currencyCodeTo>

            <dates>
                <dateOrdered>'.substr($res[0]->dateOrdered,0,4).'-'.substr($res[0]->dateOrdered,5,2).'-'.substr($res[0]->dateOrdered,8,2).'T00:00:00-06:00</dateOrdered>
                <datePromisedDelivery>'.substr($res[0]->datePromisedDelivery,0,4).'-'.substr($res[0]->datePromisedDelivery,5,2).'-'.substr($res[0]->datePromisedDelivery,8,2).'T00:00:00-06:00</datePromisedDelivery>
            <dateRequested>'.substr($res[0]->dateRequested,0,4).'-'.substr($res[0]->dateRequested,5,2).'-'.substr($res[0]->dateRequested,8,2).'T00:00:00-06:00</dateRequested>
            </dates>

            <!--PO Description:-->
            <description1>'.$desc.'</description1>

            '.$detailxml.'


            <orderedBy>'.$res[0]->orderedBy.'</orderedBy>
            <!--Optional:-->
<!--            <paymentTermsCode>?</paymentTermsCode> -->
            <!--Optional:-->
            <processing>
               <!--Optional:-->
               <actionType>1</actionType>
               <!--ZJDE0001-->
               <processingVersion>ZJDE0001</processingVersion>
            </processing>
            <!--Optional:-->
            <purchaseOrderKey>
               <!--Optional:-->
               <documentCompany>'.$res[0]->id_company.'</documentCompany>
               <!--Optional:-->
               <documentNumber>'.substr($res[0]->po_no,0,8).'</documentNumber>
               <!--OP-->
               <documentTypeCode>'.substr($res[0]->po_no,9,2).'</documentTypeCode>
               <!-- <documentTypeCode>OP</documentTypeCode> -->
            </purchaseOrderKey>
            <!--TAG BARU BUAT TAMBAHAN 30 KARAKTERNYA-->
            <remark>'.$desc2.'</remark>
            <!--Optional:-->
            <shipToAddress>
               <shipTo>
                  <!--Optional:-->
                  <entityId>'.$res[0]->id_dpoint.'</entityId>
                  <!--Optional:-->
               </shipTo>
            </shipToAddress>

            <supplierAddress>
               <supplier>
                  <!--Optional:-->
                  <entityId>'.$res[0]->ID_EXTERNAL.'</entityId>
               </supplier>
            </supplierAddress>
         </header>
      </orac:processPurchaseOrderV2>
   </soapenv:Body>
</soapenv:Envelope>';

            $headers = array(
                #"Content-type: application/soap+xml;charset=\"utf-8\"",
                "Content-Type: text/xml",
                "charset:utf-8",
                "Accept: application/xml",
                "Cache-Control: no-cache",
                "Pragma: no-cache",
                "Content-length: " . strlen($xml_post_string),
            );

            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSLVERSION, 'all');

            curl_setopt($ch, CURLOPT_VERBOSE, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,300);
            curl_setopt($ch, CURLOPT_TIMEOUT,360);
			$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

//            echo $xml_post_string;
            $data_curl = curl_exec($ch);
			$error_msg = curl_error($ch);
			$curl_errno= curl_errno($ch);
            curl_close($ch);

            if (strpos($data_curl, 'HTTP/1.1 200 OK') !== false) {
              echo "Execution Berhasil - insert PO ".$req_no." at ".date("Y-m-d H:i:s");
              $query_update = $this->db->query("update i_sync set isclosed=1,updatedate=now() where doc_type='po' and doc_no='".$req_no."' and isclosed=0");
            }else{
              echo "Execution Gagal - insert PO at ".date("Y-m-d H:i:s").'-'.$error_msg.'-'.$curl_errno.'-'.$http_status;
            }
    }
        $data_log['script_type'] = 'po';
        $this->db->insert('i_sync_log',$data_log);
        $this->db->close();
    }

    protected function sendTheRestRegretLetter($bl_detail_id)
    {
        $bl = $this->M_regret_letter->openListByBlDetail($bl_detail_id);
        $m_regret_letter = $this->M_regret_letter;

        array_walk($bl, function($letter) use ($m_regret_letter){
            $m_regret_letter->send($letter->bl_detail_id);
        });

        return true;
    }
    public function replace_agreement_document()
    {
        $config['upload_path']  = './upload/po/';
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'],0755,TRUE);
        }
        $config['allowed_types']= '*';
        // $config['max_size']      = '3000';

        // print_r($_FILES['upload']);
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ( ! $this->upload->do_upload('file_agreement_document'))
        {
            echo $this->upload->display_errors('', '');exit;
        }else
        {
            $user = user();
            $data = $this->upload->data();
            // $field = $this->input->post();
            $field['file_path'] = $config['upload_path'];
            $field['file_name'] = $data['file_name'];
            $field['created_by'] = $user->ID_USER;
            $field['creator_type'] = null;
            $this->db->where('id', $this->input->post('id_agreement_document'))->update('t_upload',$field);
        }
        $doc = $this->db->where('id', $this->input->post('id_agreement_document'))->get('t_upload')->row();
        if($doc)
        {
            echo json_encode([
              'success'=>true,
              'filename' => $doc->file_name,
              'upload_time' => $doc->created_at,
              'uploader' => $user->NAME,
              'href' => base_url($doc->file_path.''.$doc->file_name),
            ]);
        }
    }
}

/* vim: set fen foldmethod=indent ts=4 sw=4 tw=79 et autoindent :*/
