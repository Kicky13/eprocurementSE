<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Arf extends CI_Controller {

    protected $menu;
    protected $procurement_head_id = '23';
    protected $procurement_specialist_id = '28';
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
        $this->load->model('procurement/arf/m_arf_po');
        $this->load->model('procurement/arf/m_arf_po_detail');
        $this->load->model('procurement/arf/m_arf');
        $this->load->model('procurement/arf/m_arf_detail');
        $this->load->model('procurement/arf/m_arf_detail_reason');
        $this->load->model('procurement/arf/m_arf_detail_revision');
        $this->load->model('procurement/arf/m_arf_budget');
        $this->load->model('procurement/arf/m_arf_attachment');
        $this->load->model('procurement/arf/m_arf_assignment');

        $this->load->model('M_base_approval');
        $this->load->model('procurement/arf/m_arf_approval');

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

    public function index() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('m_datatable');
            if (strpos($this->session->userdata('ROLES'), ','.$this->procurement_head_id.',') === FALSE && strpos($this->session->userdata('ROLES'), ','.$this->procurement_specialist_id.',') === FALSE) {
                $this->m_datatable->scope('auth');
            }
            return $this->m_datatable->resource($this->m_arf)
            ->view('arf')
            ->filter(function($model) {
                if ($status = $this->input->get('status')) {
                    if ($status == 'draft') {
                        $model->where('t_arf.status', 'draft');
                    } elseif ($status == 'rejected') {
                        // $model->where('approval.sequence', 1);
                        $model->where('`t_arf`.`id` in (select `id_ref` from `t_approval_arf` where status = 2)', null, false);
                    } elseif ($status == 'submitted') {
                        $model->where('t_arf.status', 'submitted');
                    } elseif ($status == 'verified') {
                        $model->where('t_arf.status', 'submitted')
                        ->where('approval_arf.description', null);
                    } else {

                    }
                }
                if($user_id = $this->input->get('user_id'))
                {
                    $model->where("t_arf.id in (select doc_id from t_arf_assignment where user_id = '$user_id')");
                }
            })
            ->edit_column('doc_no', function($model) {
                return substr($model->doc_no, -5);
            })
            ->edit_column('status', function($model) {
                if ($model->status == 'draft') {
                    return $this->m_arf->enum('status', $model->status);
                } else {
                    if ($model->sequence == 1) {
                        return 'Rejected';
                    } elseif ($model->sequence == $this->m_arf_approval->last_sequence($model->id)->sequence) {
                        return 'Completed';
                    } else {
                        if ($model->approval_status) {
                            return $model->approval_status;
                        } else {
                            return 'Verified';
                        }
                    }
                }
            })
            ->edit_column('po_type', function($model) {
                return $this->m_arf_po->enum('type', $model->po_type);
            })
            ->order_by('doc_date', 'DESC')
            ->generate();
        }
        $data['menu'] = $this->menu;
        $data['url_data'] = base_url('procurement/arf?status='.$this->input->get('status'));
        if($user_id = $this->input->get('user_id'))
        {
            $data['url_data'] = base_url('procurement/arf?status='.$this->input->get('status').'&user_id='.$user_id);
        }
        $this->template->display('procurement/V_arf', $data);
    }

    public function approval() {
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
            ->order_by('doc_date', 'DESC')
            ->generate();
        }
        $data['menu'] = $this->menu;
        $this->template->display('procurement/V_arf_approval', $data);
    }

    public function verification() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('m_datatable');
            return $this->m_datatable->resource($this->m_arf)
            ->view('approval')
            ->scope('verification')
            ->edit_column('po_type', function($model) {
                return $this->m_arf_po->enum('type', $model->po_type);
            })
            ->generate();
        }

        $marf = $this->m_arf->view('approval')->scope('verification')->get();
        // echo "<pre>";
            // print_r($marf);
            // echo count($marf);
            // exit();
        $data['menu'] = $this->menu;
        $data['marf'] = $marf;
        $this->template->display('procurement/V_arf_verification', $data);
    }

    public function assignment() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('m_datatable');
            $user_roles = $this->session->userdata('ROLES');
            $user_roles = trim($user_roles, ',');
            $user_roles = explode(',', $user_roles);
            return $this->m_datatable->resource($this->m_arf)
            ->view('arf')
            ->scope('assignment')
            ->edit_column('po_type', function($model) {
                return $this->m_arf_po->enum('type', $model->po_type);
            })
            ->generate();
        }
        $data['menu'] = $this->menu;
        $this->template->display('procurement/V_arf_assignment', $data);
    }

    public function view($id) {
        $arf = $this->m_arf->view('arf_status')->find($id);
        $arf->item = $this->m_arf_detail->where('doc_id', $arf->id)->get();
        foreach ($this->m_arf_detail_revision->where('doc_id', $arf->id)->get() as $revision) {
            $arf->revision[$revision->type] = $revision;
        }
        foreach ($this->m_arf_detail_reason->where('doc_id', $arf->id)->get() as $reason) {
            $arf->reason[$reason->reason_id] = $reason;
        }
        $arf->attachment = $this->m_arf_attachment->select('t_arf_attachment.*, m_user.NAME as creator')
        ->join('m_user', 'm_user.ID_USER = t_arf_attachment.created_by')
        ->where('doc_id', $arf->id)
        ->get();
        $po = $this->m_arf_po->view('po_without_join_prev_arf')
        ->join('(
            SELECT po_no, SUM(estimated_value) as prev_value, (SELECT MAX(value) FROM t_arf_detail_revision WHERE type=\'time\' AND doc_id = t_arf.id) as prev_date FROM t_arf
            WHERE t_arf.status = \'submitted\'
            AND t_arf.id <> \''.$arf->id.'\'
            GROUP BY po_no, t_arf.id
        ) prev_arf', 'prev_arf.po_no = t_purchase_order.po_no', 'left')
        ->where('t_purchase_order.po_no', $arf->po_no)
        ->first();
        $po->po_type = $this->m_arf_po->enum('type', $po->po_type);
        $po->item = $this->m_arf_po_detail->view('po_detail')
        ->where('t_purchase_order_detail.po_id', $po->id)
        ->get();
        /*$rs_budget = $this->db->select('arf_budget.*, m_currency.CURRENCY as currency, m_budget.id_currency as id_currency_budget, currency_budget.CURRENCY as currency_budget, costcenter_budget.amount as costcenter_amount, m_budget.amount')
        ->from('(
            SELECT id_currency,id_costcenter, costcenter, id_account_subsidiary, account_subsidiary, SUM(unit_price*qty) AS total FROM t_arf_detail
            WHERE t_arf_detail.doc_id = \''.$id.'\'
            GROUP BY id_currency, id_costcenter, costcenter, id_account_subsidiary, account_subsidiary
        ) arf_budget')
        ->join('m_currency', 'm_currency.ID = arf_budget.id_currency', 'left')
        ->join('m_budget', 'm_budget.id_costcenter = arf_budget.id_costcenter AND m_budget.id_accsub = arf_budget.id_account_subsidiary', 'left')
        ->join('m_budget costcenter_budget', 'costcenter_budget.id_costcenter = m_budget.id_costcenter AND costcenter_budget.id_accsub = \'\'', 'left')
        ->join('m_currency currency_budget', 'currency_budget.ID = m_budget.id_currency', 'left')
        ->get()
        ->result();*/
        $budget = $this->m_arf_budget->view('budget')
        ->where('doc_id', $id)
        ->get();
        $allowed_approve = $this->m_arf_approval->find($id);
        $approval = $this->m_arf_approval->get($arf->id);
        $data['menu'] = $this->menu;
        $data['arf'] = $arf;
        $data['po'] = $po;
        $data['budget'] = $budget;
        $data['allowed_approve'] = $allowed_approve;
        $data['approval'] = $approval;
        $data['document_path'] = $this->document_path;
        $data['notif_flag'] = array($this->input->post('notif_flag'), $id);
        $data['procurement_head_id'] = $this->procurement_head_id;
        $this->template->display('procurement/V_arf_view', $data);
    }

    public function po($id) {
        $result = $this->m_arf_po->view('po')->find($id);
        $result->po_type = $this->m_arf_po->enum('type', $result->po_type);
        $result->item = $this->m_arf_po_detail->view('po_detail')
        ->where('t_purchase_order_detail.po_id', $id)
        ->get();
        $response = array(
            'data' => $result
        );
        echo json_encode($response);
    }

    public function create() {
        $rs_item_type_category = $this->m_procurement->get_item_type_category();
        $item_type_categories = array();
        foreach ($rs_item_type_category as $r_item_type_category) {
            $item_type_categories[$r_item_type_category->itemtype][] = $r_item_type_category;
        }
        $data['item_type_categories'] = $item_type_categories;
        $data['document_path'] = $this->document_path;
        $data['menu'] = $this->menu;
        $this->template->display('procurement/V_arf_create', $data);
    }

    public function store() {
        $this->db->trans_start();
            $post = $this->input->post();
            $this->load->library('form_validation');
            if ($this->input->post('submit') == 1) {
                $this->form_validation->set_rules('po_id', 'PO', 'required');
                if (isset($post['value'])) {
                    $this->form_validation->set_rules('value_value', 'Value', 'required');
                    $this->form_validation->set_rules('item[]', 'Amendment Item', 'required');
                }
                if (isset($post['time'])) {
                    $this->form_validation->set_rules('time_value', 'Time', 'required');
                }
                if (isset($post['scope'])) {
                    $this->form_validation->set_rules('scope_value', 'Scope', 'required');
                }
                if (isset($post['other'])) {
                    $this->form_validation->set_rules('other_value', 'Other', 'required');
                }

                if (!$this->form_validation->run()) {
                    $response = array(
                        'success' => false,
                        'message' => validation_errors('<div>', '</div>')
                    );
                    echo json_encode($response);
                    exit;
                }

                if (!isset($post['value']) && !isset($post['time']) && !isset($post['scope']) && !isset($post['other'])) {
                    $response = array(
                        'success' => false,
                        'message' => 'You have to select at least 1 revision'
                    );
                    echo json_encode($response);
                    exit;
                }

                if (count($post['reason']) == 0) {
                    $response = array(
                        'success' => false,
                        'message' => 'You have to select at least 1 reason'
                    );
                    echo json_encode($response);
                    exit;
                }
            } else {
                $this->form_validation->set_rules('po_id', 'PO', 'required');
                if (!$this->form_validation->run()) {
                    $response = array(
                        'success' => false,
                        'message' => validation_errors('<div>', '</div>')
                    );
                    echo json_encode($response);
                    exit;
                }
            }

            $po = $this->m_arf_po->view('po')->find($post['po_id']);
            $estimated_value = isset($post['value_value']) ? $post['value_value'] : 0;
            if($po->master_list == 1)
            {
                $tax = 0;
            }
            else
            {
                $tax = (10/100) * $estimated_value;
            }
            $total = $estimated_value + $tax;

            $arf = $this->m_arf->insert(array(
                'po_no' => $po->po_no,
                'po_title' => $po->title,
                'po_date' => $po->po_date,
                'company_id' => $po->id_company,
                'company' => $po->company,
                'department_id' => $po->id_department,
                'department' => $po->department,
                'estimated_value' => $estimated_value,
                'estimated_value_base' => exchange_rate_by_id($po->id_currency, $po->id_currency_base, $estimated_value),
                'expected_commencement_date' => ($post['expected_commencement_date']) ? $post['expected_commencement_date'] : null,
                'currency_id' => $po->id_currency,
                'currency' => $po->currency,
                'currency_base_id' => $po->id_currency_base,
                'currency_base' => $po->currency_base,
                'tax' => $tax,
                'tax_base' => exchange_rate_by_id($po->id_currency, $po->id_currency_base, $tax),
                'total' => $total,
                'total_base' => exchange_rate_by_id($po->id_currency, $po->id_currency_base, $total),
                'status' => 'draft'
            ));

            if (isset($post['value'])) {
                $this->m_arf_detail_revision->insert(array(
                    'doc_id' => $arf->id,
                    'type' => 'value',
                    'value' => $post['value_value'],
                    'remark' => $post['value_remark']
                ));
                if (isset($post['item'])) {
                    $record_item = array();
                    if($po->master_list == 1)
                    {
                        $tax = 0;
                    }
                    else
                    {
                        $tax = (10/100);
                    }
                    foreach ($post['item'] as $item) {
                        $item['doc_id'] = $arf->id;
                        $item['id_currency'] = $po->id_currency;
                        $item['id_currency_base'] = $po->id_currency_base;
                        $item['unit_price_base'] = exchange_rate_by_id($po->id_currency, $po->id_currency_base, $item['unit_price']);
                        $item['is_tax'] = $tax > 0 ? 1 : 0;
                        $item['tax'] = $tax * $item['unit_price'];
                        $item['tax_base'] = exchange_rate_by_id($po->id_currency, $po->id_currency_base, $item['tax']);
                        $item['total_price'] = $item['unit_price'] + $item['tax'];
                        $item['total_price_base'] = exchange_rate_by_id($po->id_currency, $po->id_currency_base, $item['total_price']);
                        $record_item[] = $item;
                    }
                    $this->m_arf_detail->insert_batch($record_item);
                }
            }

            if (isset($post['time'])) {
                $this->m_arf_detail_revision->insert(array(
                    'doc_id' => $arf->id,
                    'type' => 'time',
                    'value' => date('Y-m-d', strtotime($post['time_value'])),
                    'remark' => $post['time_remark']
                ));
            }

            if (isset($post['scope'])) {
                $this->m_arf_detail_revision->insert(array(
                    'doc_id' => $arf->id,
                    'type' => 'scope',
                    'value' => $post['scope_value'],
                    'remark' => $post['scope_remark']
                ));
            }

            if (isset($post['other'])) {
                $this->m_arf_detail_revision->insert(array(
                    'doc_id' => $arf->id,
                    'type' => 'other',
                    'value' => $post['other_value'],
                    'remark' => $post['other_remark']
                ));
            }

            if (isset($post['reason'])) {
                $record_reason = array();
                foreach ($post['reason'] as $reason_id => $reason) {
                    if (isset($reason['id'])) {
                        $record_reason[] = array(
                            'doc_id' => $arf->id,
                            'reason_id' => $reason['id'],
                            'description' => isset($reason['reason']) ? $reason['reason'] : ''
                        );
                    }
                }
                if ($record_reason) {
                    $this->m_arf_detail_reason->insert_batch($record_reason);
                }
            }

            if (isset($post['attachment'])) {
                $record_attachment = array();
                foreach ($post['attachment'] as $attachment) {
                    $record_attachment[] = array(
                        'doc_id' => $arf->id,
                        'type' => $attachment['type'],
                        'file_name' => $attachment['file_name'],
                        'file' => $attachment['file']
                    );
                }
                $this->m_arf_attachment->insert_batch($record_attachment);
            }

            if ($this->input->post('submit') == 1) {
                $estimated_new_value = $estimated_value + $po->total_amount;
                $this->m_arf->update($arf->id, array(
                    'doc_no' => $this->m_arf->generate_no($po->po_no),
                    'doc_date' => date('Y-m-d'),
                    'amount_po' => $po->total_amount,
                    'amount_po_base' => exchange_rate_by_id($po->id_currency, $po->id_currency_base, $po->total_amount),
                    'amount_po_arf' => $po->latest_value,
                    'amount_po_arf_base' => exchange_rate_by_id($po->id_currency, $po->id_currency_base, $po->latest_value),
                    'amount_spending' => $po->spending_value,
                    'amount_spending_base' => exchange_rate_by_id($po->id_currency, $po->id_currency_base, $po->spending_value),
                    'amount_remaining' => $po->remaining_value,
                    'amount_remaining_base' => exchange_rate_by_id($po->id_currency, $po->id_currency_base, $po->remaining_value),
                    'delivery_date_po' => $po->delivery_date,
                    'amended_date' => $po->prev_date,
                    'estimated_new_value' => $estimated_new_value,
                    'estimated_new_value_base' => exchange_rate_by_id($po->id_currency, $po->id_currency_base, $estimated_new_value),
                    'status' => 'submitted'
                ));
                $this->m_arf_budget->where('doc_id', $arf->id)
                ->delete();
                if (isset($post['budget']) && is_array($post['budget'])) {
                    foreach ($post['budget'] as $id_costcenter => $account_subsidiary) {
                        foreach ($account_subsidiary as $id_account_subsidiary => $row) {
                            $this->m_arf_budget->insert(array(
                                'doc_id' => $arf->id,
                                'id_costcenter' => $row['id_costcenter'],
                                'costcenter' => $row['costcenter'],
                                'id_account_subsidiary' => $row['id_account_subsidiary'],
                                'account_subsidiary' => $row['account_subsidiary'],
                                'id_currency' => $row['id_currency'],
                                'booking_amount' => $row['booking_amount'],
                                'costcenter_value' => $row['costcenter_amount'],
                                'account_subsidiary_value' => $row['id_account_subsidiary'] ? $row['amount'] : null,
                                'budget_value' => $row['amount']
                            ));
                        }
                    }
                }
                $arf = $this->m_arf->find($arf->id);
                $this->m_arf_approval->start($arf->id);
            }
        if ($this->db->trans_status()) {
            if ($this->input->post('submit') == 1) {
                $this->session->set_flashdata('message', array(
                    'message' => __('success_submit_with_number', array('no' => $arf->doc_no)),
                    'type' => 'success'
                ));
                /*$response = array(
                    'success' => true,
                    'message' => 'Data is successfully submitted with No. '.$arf->doc_no
                );*/
            }
            $response = array('success' => true, 'data' => $arf);
            $this->db->trans_commit();
        } else {
            if ($this->input->post('submit') == 1) {
                $response = array(
                    'success' => false,
                    'message' => 'Failed to submit ARF'
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Failed to save ARF'
                );
            }
            $this->db->trans_rollback();
        }
        echo json_encode($response);
    }

    public function edit($id) {
        $arf = $this->m_arf->find($id);
        if ($arf->status == 'submitted') {
            $allowed_approve = $this->m_arf_approval->find($arf->id);
            if (!$allowed_approve) {
                $this->redirect->back();
            }
            if ($allowed_approve->sequence <> 1 && $allowed_approve->edit_content == 0) {
                $this->redirect->back();
            }
            $approval = $this->m_arf_approval->get($arf->id);
            $data['allowed_approve'] = $allowed_approve;
            $data['approval'] = $approval;

        }
        $rs_item_type_category = $this->m_procurement->get_item_type_category();
        $item_type_categories = array();
        foreach ($rs_item_type_category as $r_item_type_category) {
            $item_type_categories[$r_item_type_category->itemtype][] = $r_item_type_category;
        }
        $data['arf'] = $arf;
        $data['item_type_categories'] = $item_type_categories;
        $data['document_path'] = $this->document_path;
        $data['menu'] = $this->menu;
        $data['arf_detail'] = $this->m_arf_detail->getDetails2($id);
        $data['is_edit'] = 1;
        $this->template->display('procurement/V_arf_edit', $data);
    }

    public function update($id) {
        $this->db->trans_begin();
            $post = $this->input->post();
            $this->load->library('form_validation');
            if ($this->input->post('submit') == 1) {
                $this->form_validation->set_rules('po_id', 'PO', 'required');
                if (isset($post['value'])) {
                    $this->form_validation->set_rules('value_value', 'Value', 'required');
                    $this->form_validation->set_rules('item[]', 'Amendment Item', 'required');
                }
                if (isset($post['time'])) {
                    $this->form_validation->set_rules('time_value', 'Time', 'required');
                }
                if (isset($post['scope'])) {
                    $this->form_validation->set_rules('scope_value', 'Scope', 'required');
                }
                if (isset($post['other'])) {
                    $this->form_validation->set_rules('other_value', 'Other', 'required');
                }

                if (!$this->form_validation->run()) {
                    $response = array(
                        'success' => false,
                        'message' => validation_errors('<div>', '</div>')
                    );
                    echo json_encode($response);
                    exit;
                }

                if (!isset($post['value']) && !isset($post['time']) && !isset($post['scope']) && !isset($post['other'])) {
                    $response = array(
                        'success' => false,
                        'message' => 'You have to select at least 1 revision'
                    );
                    echo json_encode($response);
                    exit;
                }

                if (count($post['reason']) == 0) {
                    $response = array(
                        'success' => false,
                        'message' => 'You have to select at least 1 reason'
                    );
                    echo json_encode($response);
                    exit;
                }
            } else {
                $this->form_validation->set_rules('po_id', 'PO', 'required');
                if (!$this->form_validation->run()) {
                    $response = array(
                        'success' => false,
                        'message' => validation_errors('<div>', '</div>')
                    );
                    echo json_encode($response);
                    exit;
                }
            }

            $arf = $this->m_arf->find($id);
            if ($arf->status == 'submitted') {
                $allowed_approve = $this->m_arf_approval->find($arf->id);
                if ($allowed_approve->sequence <> 1 && $allowed_approve->edit_content == 0) {
                    $response = array(
                        'success' => false,
                        'message' => 'You dont have permission to edit content'
                    );
                    echo json_encode($response);
                    exit;
                }
            }
            $po = $this->m_arf_po->view('po_edit')->where('t_purchase_order.po_no', $arf->po_no)->first();

            $estimated_value = isset($post['value_value']) ? $post['value_value'] : 0;
            if($po->master_list == 1)
            {
                $percent_tax = 0;
            }
            else
            {
                $percent_tax = (10/100);
            }
            $tax = $percent_tax * $estimated_value;
            $total = $estimated_value + $tax;

            $this->m_arf_detail->where('doc_id', $id)
            ->delete();
            $this->m_arf_detail_revision->where('doc_id', $id)
            ->delete();
            $this->m_arf_detail_reason->where('doc_id', $id)
            ->delete();
            $this->m_arf_attachment->where('doc_id', $id)
            ->delete();

            $this->m_arf->update($id, array(
                'estimated_value' => $estimated_value,
                'estimated_value_base' => exchange_rate_by_id($po->id_currency, $po->id_currency_base, $estimated_value),
                'expected_commencement_date' => ($post['expected_commencement_date']) ? $post['expected_commencement_date'] : null,
                'tax' => $tax,
                'tax_base' => exchange_rate_by_id($po->id_currency, $po->id_currency_base, $tax),
                'total' => $total,
                'total_base' => exchange_rate_by_id($po->id_currency, $po->id_currency_base, $total),
            ));

            if (isset($post['value'])) {
                $this->m_arf_detail_revision->insert(array(
                    'doc_id' => $arf->id,
                    'type' => 'value',
                    'value' => $post['value_value'],
                    'remark' => $post['value_remark']
                ));
                if (isset($post['item'])) {
                    $record_item = array();
                    if($po->master_list == 1)
                    {
                        $tax = 0;
                    }
                    else
                    {
                        $tax = (10/100);
                    }
                    foreach ($post['item'] as $item) {
                        $item['doc_id'] = $arf->id;
                        $item['id_currency'] = $po->id_currency;
                        $item['id_currency_base'] = $po->id_currency_base;
                        $item['unit_price_base'] = exchange_rate_by_id($po->id_currency, $po->id_currency_base, $item['unit_price']);
                        $item['is_tax'] = $tax > 0 ? 1 : 0;
                        $item['tax'] = $tax * $item['unit_price'];
                        $item['tax_base'] = exchange_rate_by_id($po->id_currency, $po->id_currency_base, $item['tax']);
                        $item['total_price'] = $item['unit_price'] + $item['tax'];
                        $item['total_price_base'] = exchange_rate_by_id($po->id_currency, $po->id_currency_base, $item['total_price']);
                        $xItem = array_map('trim', $item);
                        $this->m_arf_detail->insert($xItem);

                    }

                    // $this->m_arf_detail->insert_batch($record_item);
                }
            }

            if (isset($post['time'])) {
                $this->m_arf_detail_revision->insert(array(
                    'doc_id' => $arf->id,
                    'type' => 'time',
                    'value' => date('Y-m-d', strtotime($post['time_value'])),
                    'remark' => $post['time_remark']
                ));
            }

            if (isset($post['scope'])) {
                $this->m_arf_detail_revision->insert(array(
                    'doc_id' => $arf->id,
                    'type' => 'scope',
                    'value' => $post['scope_value'],
                    'remark' => $post['scope_remark']
                ));
            }

            if (isset($post['other'])) {
                $this->m_arf_detail_revision->insert(array(
                    'doc_id' => $arf->id,
                    'type' => 'other',
                    'value' => $post['other_value'],
                    'remark' => $post['other_remark']
                ));
            }

            if (isset($post['reason'])) {
                $record_reason = array();
                foreach ($post['reason'] as $reason_id => $reason) {
                    if (isset($reason['id'])) {
                        $record_reason[] = array(
                            'doc_id' => $arf->id,
                            'reason_id' => $reason['id'],
                            'description' => isset($reason['reason']) ? $reason['reason'] : ''
                        );
                    }
                }
                if ($record_reason) {
                    $this->m_arf_detail_reason->insert_batch($record_reason);
                }
            }

            if (isset($post['attachment'])) {
                $record_attachment = array();
                foreach ($post['attachment'] as $attachment) {
                    $record_attachment[] = array(
                        'doc_id' => $arf->id,
                        'type' => $attachment['type'],
                        'file' => $attachment['file'],
                        'file_name' => $attachment['file_name']
                    );
                }
                $this->m_arf_attachment->insert_batch($record_attachment);
            }

            if ($arf->status == 'submitted') {
                $this->db->where(['id_ref'=>$arf->id,'status'=>2])->update('t_approval_arf',['status'=>0]);
                $review_bod = null;
                if ($allowed_approve->id_user_role == $this->m_arf_approval->bsd_staf_id) {
                    $review_bod = isset($post['review_bod']) ? $post['review_bod'] : 0;
                }
                $estimated_new_value = $estimated_value + $po->total_amount;
                $this->m_arf->update($arf->id, array(
                    'amount_po' => $po->total_amount,
                    'amount_po_base' => exchange_rate_by_id($po->id_currency, $po->id_currency_base, $po->total_amount),
                    'amount_po_arf' => $po->latest_value,
                    'amount_po_arf_base' => exchange_rate_by_id($po->id_currency, $po->id_currency_base, $po->latest_value),
                    'amount_spending' => $po->spending_value,
                    'amount_spending_base' => exchange_rate_by_id($po->id_currency, $po->id_currency_base, $po->spending_value),
                    'amount_remaining' => $po->remaining_value,
                    'amount_remaining_base' => exchange_rate_by_id($po->id_currency, $po->id_currency_base, $po->remaining_value),
                    'delivery_date_po' => $po->delivery_date,
                    'amended_date' => $po->prev_date,
                    'estimated_new_value' => $estimated_new_value,
                    'estimated_new_value_base' => exchange_rate_by_id($po->id_currency, $po->id_currency_base, $estimated_new_value),
                    'review_bod' => $review_bod
                ));
                $this->m_arf_approval->approve($allowed_approve->id, 1, $post['submit_note']);
                $this->session->set_flashdata('message', array(
                    'message' => __('success_submit'),
                    'type' => 'success'
                ));
            } else {
                if ($this->input->post('submit') == 1) {
                    $estimated_new_value = $estimated_value + $po->total_amount;
                    $this->m_arf->update($arf->id, array(
                        'doc_no' => $this->m_arf->generate_no($po->po_no),
                        'doc_date' => date('Y-m-d'),
                        'amount_po' => $po->total_amount,
                        'amount_po_base' => exchange_rate_by_id($po->id_currency, $po->id_currency_base, $po->total_amount),
                        'amount_po_arf' => $po->latest_value,
                        'amount_po_arf_base' => exchange_rate_by_id($po->id_currency, $po->id_currency_base, $po->latest_value),
                        'amount_spending' => $po->spending_value,
                        'amount_spending_base' => exchange_rate_by_id($po->id_currency, $po->id_currency_base, $po->spending_value),
                        'amount_remaining' => $po->remaining_value,
                        'amount_remaining_base' => exchange_rate_by_id($po->id_currency, $po->id_currency_base, $po->remaining_value),
                        'delivery_date_po' => $po->delivery_date,
                        'amended_date' => $po->prev_date,
                        'estimated_new_value' => $estimated_new_value,
                        'estimated_new_value_base' => exchange_rate_by_id($po->id_currency, $po->id_currency_base, $estimated_new_value),
                        'status' => 'submitted'
                    ));
                    $this->m_arf_budget->where('doc_id', $arf->id)
                    ->delete();
                    if (isset($post['budget'])) {
                        foreach ($post['budget'] as $id_costcenter => $account_subsidiary) {
                            foreach ($account_subsidiary as $id_account_subsidiary => $row) {
                                $this->m_arf_budget->insert(array(
                                    'doc_id' => $arf->id,
                                    'id_costcenter' => $row['id_costcenter'],
                                    'costcenter' => $row['costcenter'],
                                    'id_account_subsidiary' => $row['id_account_subsidiary'],
                                    'account_subsidiary' => $row['account_subsidiary'],
                                    'id_currency' => $row['id_currency'],
                                    'booking_amount' => $row['booking_amount'],
                                    'costcenter_value' => $row['costcenter_amount'],
                                    'account_subsidiary_value' => $row['id_account_subsidiary'] ? $row['amount'] : null,
                                    'budget_value' => $row['amount']
                                ));
                            }
                        }
                    }
                    $arf = $this->m_arf->find($arf->id);
                    $this->m_arf_approval->start($arf->id);
                    /*if($review_bod)
                    {
                        $this->prepare_mail_send($arf->id);
                    }*/
                    $this->session->set_flashdata('message', array(
                        'message' => __('success_submit_with_number', array('no' => $arf->doc_no)),
                        'type' => 'success'
                    ));
                }
            }
        if ($this->db->trans_status()) {
            $response = array(
                'success' => true,
                'message' => 'Data is successfully submitted'
            );
            $this->db->trans_commit();
        } else {
            $response = array(
                'success' => true,
                'message' => 'Data is failed to submit'
            );
            $this->db->trans_rollback();
        }
        echo json_encode($response);
    }

    public function calculate_budget() {
        $id_currency = $this->input->post('id_currency');
        $budget_item = $this->input->post('budget_item');
        $result = array();
        $total = 0;
        if ($budget_item) {
            foreach ($budget_item as $id_costcenter => $budget_costcenter) {
                foreach ($budget_costcenter as $id_account_subsidiary => $row) {
                    if ($id_account_subsidiary) {
                        $this->db->where('m_budget.id_accsub', $id_account_subsidiary);
                    } else {
                        $this->db->where('m_budget.id_accsub', '');
                    }
                    $r_budget = $this->db->select('m_budget.*, costcenter_budget.amount as costcenter_amount, m_currency.CURRENCY as currency')
                    ->join('m_budget costcenter_budget', 'costcenter_budget.id_costcenter = m_budget.id_costcenter', 'left')
                    ->join('m_currency', 'm_currency.ID = m_budget.id_currency')
                    ->where('m_budget.id_costcenter', $id_costcenter)
                    ->get('m_budget')
                    ->row();
                    if ($r_budget) {
                        $booking_amount = exchange_rate_by_id($id_currency, $r_budget->id_currency, $row['booking_amount']);
                        $booking_amount += (10/100 * $booking_amount);
                        $budget = array(
                            'id_currency' => $r_budget->id_currency,
                            'currency' => $r_budget->currency,
                            'booking_amount' => $booking_amount,
                            'costcenter_amount' => $r_budget->costcenter_amount,
                            'amount' => $r_budget->amount
                        );
                    } else {
                        $booking_amount = exchange_rate_by_id($id_currency, base_currency(), $row['booking_amount']);
                        $booking_amount += (10/100 * $booking_amount);
                        $budget = array(
                            'id_currency' => base_currency(),
                            'currency' => base_currency_code(),
                            'booking_amount' => $booking_amount,
                            'costcenter_amount' => 0,
                            'amount' => 0
                        );
                    }
                    $budget_item[$id_costcenter][$id_account_subsidiary]['id_currency'] = $budget['id_currency'];
                    $budget_item[$id_costcenter][$id_account_subsidiary]['currency'] = $budget['currency'];
                    $budget_item[$id_costcenter][$id_account_subsidiary]['booking_amount'] = $budget['booking_amount'];
                    $budget_item[$id_costcenter][$id_account_subsidiary]['costcenter_amount'] = $budget['costcenter_amount'];
                    $budget_item[$id_costcenter][$id_account_subsidiary]['amount'] = $budget['amount'];
                    $total += $booking_amount;
                }
            }
        }
        if ($id_currency <> base_currency()) {
            $r_exchange_rate = get_exchange_rate_by_currency_id($id_currency, base_currency());
            if ($r_exchange_rate) {
                $exchange_rate = $r_exchange_rate->amount_from;
            } else {
                $exchange_rate = 0;
            }
        } else {
            $exchange_rate = 1;
        }
        $response = array(
            'data' => array(
                'id_currency_base' => base_currency(),
                'currency' => base_currency_code(),
                'exchange_rate' => $exchange_rate,
                'budget_item' => $budget_item,
                'total' => $total
            )
        );
        echo json_encode($response);
    }

    public function attachment_upload() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('file_name', 'File Name', 'required');
        $this->form_validation->set_rules('type', 'Type', 'required');
        if (!$this->form_validation->run()) {
            $response = array(
                'success' => false,
                'message' => validation_errors('<div>', '</div>')
            );
            echo json_encode($response);
            exit;
        }
        $config['upload_path'] = $this->document_path;
        $config['allowed_types'] = $this->document_allowed_types;
        $config['max_size'] = $this->document_max_size;
        $config['encrypt_name'] = true;
        $this->load->library('upload', $config);
        $response = array();
        if ($this->upload->do_upload('file')) {
            $response = array(
                'success' => true,
                'message' => 'Successfully uploded document',
                'data' => $this->upload->data()
            );
        } else {
            $response = array(
                'success' => false,
                'message' => $this->upload->display_errors()
            );
        }
        echo json_encode($response);
    }

    public function approve($id) {
        $approval_id = $this->input->post('id');
        $budget = $this->input->post('budget');
        $status = $this->input->post('status');
        $description = $this->input->post('description');
        $review_bod = $this->input->post('review_bod');
        $bod_review_meeting = $this->input->post('bod_review_meeting');

        if (!is_null($budget)) {
            foreach ($budget as $id_budget => $row) {
                $this->m_arf_budget->where('id', $id_budget)
                ->update(array('status' => $row));
            }
        }

        $detail = array();
        if (!is_null($bod_review_meeting) && $bod_review_meeting !== '') {
            $detail['bod_review_meeting'] = $bod_review_meeting;
			$approvalArf = $this->db->where('id', $id)->get('t_approval_arf')->row();
            $this->prepare_mail_send($approvalArf->id_ref);
        }
        if (!is_null($review_bod)) {
            $this->m_arf->update($id, array(
                'review_bod' => $review_bod
            ));
        }
        $approve = $this->m_arf_approval->approve($approval_id, $status, $description, $detail);
        if ($approve) {
            if ($status == 1) {
                $this->session->set_flashdata('message', array(
                    'message' => __('success_approve'),
                    'type' => 'success'
                ));
            } else {
                $this->session->set_flashdata('message', array(
                    'message' => __('success_reject'),
                    'type' => 'danger'
                ));
            }
            $response = array('success' => true);
        } else {
            $response = array(
                'success' => false,
                'message' => 'You dont have permission to approve this ARF'
            );
        }
        echo json_encode($response);
    }

    public function approval_save($id) {
        $approval_id = $this->input->post('id');
        $bod_review_meeting = $this->input->post('bod_review_meeting');
        $bod_review_meeting_desc = $this->input->post('bod_review_meeting_desc');
        $detail = array('bod_review_meeting' => $bod_review_meeting);
        $approve = $this->m_arf_approval->approve($approval_id, 0, '', $detail);

        $this->db->where('id',$approval_id)->update('t_approval_arf', ['note'=>$bod_review_meeting_desc]);
        
        if ($approve) {
            $response = array(
                'success' => true,
                'message' => 'ARF save successfully'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to save ARF'
            );
        }
        echo json_encode($response);
    }

    public function assign($id) {
        if (strpos($this->session->userdata('ROLES'), ','.$this->procurement_head_id.',') === FALSE) {
            $response = array(
                'success' => false,
                'message' => 'You dont have permission to assign ARF'
            );
            echo json_encode($response);
            exit;
        }
        if (!$user_id = $this->input->post('user_id')) {
            $response = array(
                'success' => false,
                'message' => 'You have to select procurement specialist'
            );
            echo json_encode($response);
            exit;
        }
        $arf = $this->m_arf->find($id);
        $result = $this->m_arf_assignment->insert(array(
            'doc_id' => $id,
            'po_no' => $arf->po_no,
            'user_id' => $user_id
        ));
        if ($result) {
            $response = array('success' => true);
            $this->session->set_flashdata('message', array(
                'message' => __('success_submit'),
                'type' => 'success'
            ));
        } else {
            $response = array(
                'success' => false,
                'message' => __('failed_submit')
            );
        }
        echo json_encode($response);
    }

    public function find_json($id) {
        $arf = $this->m_arf->find($id);
        $arf->item = $this->m_arf_detail->view('item')->where('doc_id', $arf->id)->get();
        $arf->revision = $this->m_arf_detail_revision->where('doc_id', $arf->id)->get();
        $arf->reason = $this->m_arf_detail_reason->where('doc_id', $arf->id)->get();
        $arf->attachment = $this->m_arf_attachment->select('t_arf_attachment.*, m_user.NAME as creator')
        ->join('m_user', 'm_user.ID_USER = t_arf_attachment.created_by')
        ->where('doc_id', $arf->id)
        ->get();

        $po = $this->m_arf_po->view('po_without_join_prev_arf')
        ->join('(
            SELECT po_no, SUM(estimated_value) as prev_value, (SELECT MAX(value) FROM t_arf_detail_revision WHERE type=\'time\' AND doc_id = t_arf.id) as prev_date FROM t_arf
            WHERE t_arf.status = \'submitted\'
            AND t_arf.id <> \''.$arf->id.'\'
            GROUP BY po_no, t_arf.id
        ) prev_arf', 'prev_arf.po_no = t_purchase_order.po_no', 'left')
        ->where('t_purchase_order.po_no', $arf->po_no)
        ->first();
        $po->po_type = $this->m_arf_po->enum('type', $po->po_type);
        $po->item = $this->m_arf_po_detail->view('po_detail')
        ->where('t_purchase_order_detail.po_id', $po->id)
        ->get();

        $data['arf'] = $arf;
        $data['po'] = $po;
        $response = array(
            'data' => $data
        );
        echo json_encode($response);
    }
    public function generate_approval($arfId='')
    {
        $data = $this->m_arf_approval->start($arfId);
        if($this->input->get('debug'))
        {
            $data['arf'] = $this->db->where('id',$arfId)->get('t_arf')->row();
            $data['detail_revision'] = $this->db->where('doc_id',$arfId)->get('t_arf_detail_revision')->result();
            echo "<pre>";
            print_r($data);
            echo "</pre>";
        }
    }
    public function prepare_mail_send($arfId='')
    {
        ini_set('max_execution_time', 300);
        $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
        $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";

        $query = $this->db->query("SELECT distinct u.email as recipient,n.TITLE,n.OPEN_VALUE,n.CLOSE_VALUE 
            FROM t_arf t
            join t_approval_arf on t_approval_arf.id_ref = t.id
            join m_user u on u.ID_USER = t_approval_arf.id_user
            join m_notic n on n.ID=81
            where t.id=$arfId and t_approval_arf.sequence in (1,2)");
        if ($query->num_rows() > 0) {
          $data_role = $query->result();
          $count = 1;
        } else {
          $count = 0;
        }
        if ($count === 1) {
            $query = $this->db->query("select t_arf.*, m_user.NAME nama_user 
                from t_arf 
                left join m_user on m_user.id_user = t_arf.created_by
                where id = $arfId");

            $data_replace = $query->result();

            $res = $data_role;
            $str = $data_role[0]->OPEN_VALUE;
            $str = str_replace('_var1_',$data_replace[0]->doc_no,$str);
            $str = str_replace('_var2_',$data_replace[0]->nama_user,$str);

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
    public function test_arf_send_mail($arfId='')
    {
        $this->prepare_mail_send($arfId);
    }
    public function cancel_arf($arf_no='')
    {
        $this->db->trans_begin();
        $arf = $this->db->where('doc_no',$arf_no)->get('t_arf')->row();
        $id = $arf->id;

        $sql = "insert into t_arf_trash select *,'null' as attachment from t_arf where t_arf.id = $id";
        $this->db->query($sql);

        $this->db->where('id', $id);
        $this->db->delete('t_arf');

        $this->db->where('doc_id', $id);
        $this->db->delete('t_arf_assignment');

        $this->db->where('id_ref', $id);
        $this->db->delete('t_approval_arf');

        $this->db->where('doc_no', $arf_no);
        $this->db->delete('t_arf_notification');

        $this->db->where('doc_id', $id);
        $this->db->delete('t_arf_attachment');

        $this->db->where('doc_id', $id);
        $this->db->delete('t_arf_budget');

        $this->db->where('doc_id', $id);
        $this->db->delete('t_arf_detail');

        $this->db->where('doc_id', $id);
        $this->db->delete('t_arf_detail_reason');

        $this->db->where('doc_id', $id);
        $this->db->delete('t_arf_detail_revision');

        $config['upload_path']  = './upload/cancel_arf/';
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'],0755,TRUE);
        }
        $config['allowed_types']= '*';
        
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('file_cancel_arf'))
        {
            echo $this->upload->display_errors('', '');exit;
        }else{
            $data = $this->upload->data();
            $field['attachment'] = $data['file_name'];
            $this->db->where('id',$id)->update('t_arf_trash', $field);
        }

        if($this->db->trans_status() === TRUE)
        {
            $this->db->trans_commit();
            echo json_encode(['msg'=>'Success']);
        }
        else
        {
            $this->db->trans_rollback();
            echo json_encode(['msg'=>'Fail, Please Try Again']);
        }
    }
    public function cancel_arf_list()
    {
      $data['menu'] = $this->menu;
      $data['lists'] = $this->db->get('t_arf_trash')->result();
      $data['titleApp'] = 'ARF Cancel Lists';
      $this->template->display('procurement/V_arf_trash', $data);
    }
}
