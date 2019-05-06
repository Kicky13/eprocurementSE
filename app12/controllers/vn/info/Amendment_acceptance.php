<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Amendment_acceptance extends CI_Controller {

    protected $document_path = 'upload/ARF';
    protected $document_allowed_types = 'jpg|jpeg|pdf|doc|docx';
    protected $document_max_size = '2048';

    public function __construct() {
        parent::__construct();

        $this->load->model('vn/info/M_all_vendor');
        $this->M_all_vendor->cek_session();

        $this->load->library('url_generator');
        $this->load->library('redirect');
        $this->load->library('form');
        $this->load->model('m_base');
        $this->load->model('procurement/m_procurement');
        $this->load->model('procurement/arf/m_arf');
        $this->load->model('procurement/arf/m_arf_detail');
        $this->load->model('procurement/arf/m_arf_detail_revision');
        $this->load->model('procurement/arf/m_arf_po');
        $this->load->model('procurement/arf/m_arf_po_detail');
        $this->load->model('procurement/arf/m_arf_po_document');
        $this->load->model('procurement/arf/m_arf_sop');
        $this->load->model('procurement/arf/m_arf_recommendation_preparation');
        $this->load->model('procurement/arf/m_arf_acceptance');
        $this->load->model('procurement/arf/m_arf_acceptance_document');
        $this->load->model('procurement/arf/T_approval_arf_recom');

        $this->load->helper('exchange_rate_helper');
    }

    public function index() {
        $data['model'] = $this->T_approval_arf_recom->arf_response_done(1)->result();
        $this->template->display_vendor('vn/info/Amendment_acceptance', $data);
    }

    public function create($id) {
        $arf = $this->m_arf_recommendation_preparation->view('amendment_recommendation')
        ->scope('unresponse')
        ->find($id);
        if (!$arf) {
            $this->redirect->to(base_url('vn/info/amendment_acceptance/view/'.$id));
        }
        $arf->item = $this->m_arf_sop->view('response')->where('t_arf_sop.doc_id', $arf->notification_doc_id)->get();
        $arf->document = $this->db->where('module_kode', 'arf-issued')
        ->where('data_id', $arf->doc_no)
        ->get('t_upload')
        ->result();
        $po = $this->m_arf_po->view('po_without_join_prev_arf')
        ->join('(
            SELECT po_no, SUM(estimated_value) as prev_value, MAX(doc_date) as prev_date FROM t_arf
            WHERE t_arf.status = \'submitted\'
            AND t_arf.id <> \''.$arf->doc_id.'\'
            GROUP BY po_no
        ) prev_arf', 'prev_arf.po_no = t_purchase_order.po_no', 'left')
        ->where('t_purchase_order.po_no', $arf->po_no)
        ->first();
        $po->item = $this->m_arf_po_detail->view('po_detail')
        ->where('t_purchase_order_detail.po_id', $po->id)
        ->get();
        $po->doc_performance_bond = $this->m_arf_po_document->view('document')->scope('performance_bond')
        ->where('po_id', $po->id)
        ->get();
        $po->doc_issurance = $this->m_arf_po_document->view('document')->scope('issurance')
        ->where('po_id', $po->id)
        ->get();
        $po->doc_other = $this->m_arf_po_document->view('document')->scope('other')
        ->where('po_id', $po->id)
        ->get();
        foreach ($this->m_arf_detail_revision->where('doc_id', $arf->doc_id)->get() as $revision) {
            $arf->revision[$revision->type] = $revision;
        }
        $t_arf_notification = $this->db->where(['doc_no'=>$arf->doc_no])->get('t_arf_notification')->row();
        
        $findAll = $this->db->where(['po_no'=>$t_arf_notification->po_no])->get('t_arf_notification');
        
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
        $data['arf'] = $arf;
        $data['po'] = $po;
        $data['document_path'] = $this->document_path;
        $data['findAllResult'] = $findAllResult;
        $this->template->display_vendor('vn/info/Amendment_acceptance_create', $data);
    }

    public function view($id) {
        $arf = $this->m_arf_recommendation_preparation->view('amendment_recommendation')
        ->scope('responsed')
        ->find($id);
        if (!$arf) {
            $this->redirect->to(base_url('vn/info/amendment_acceptance/create/'.$id));
        }
        // $arf->item = $this->m_arf_detail->view('response_item')->where('doc_id', $arf->doc_id)->get();
        $arf->item = $this->m_arf_sop->view('response')->where('t_arf_sop.doc_id', $arf->notification_doc_id)->get();
        /*echo "<pre>";
        print_r($arf->item);
        exit();*/
        foreach ($this->m_arf_detail_revision->where('doc_id', $arf->doc_id)->get() as $revision) {
            $arf->revision[$revision->type] = $revision;
        }
        $arf->performance_bond = $this->m_arf_acceptance_document->view('document')
        ->scope('performance_bond')
        ->where('doc_no', $arf->doc_no)
        ->get();
        $arf->insurance = $this->m_arf_acceptance_document->view('document')
        ->scope('insurance')
        ->where('doc_no', $arf->doc_no)
        ->get();
        $arf->doc_other = $this->m_arf_acceptance_document->view('document')
        ->scope('other')
        ->where('doc_no', $arf->doc_no)
        ->get();
        $arf->document = $this->db->where('module_kode', 'arf-issued')
        ->where('data_id', $arf->doc_no)
        ->get('t_upload')
        ->result();
        $po = $this->m_arf_po->view('po_without_join_prev_arf')
        ->join('(
            SELECT po_no, SUM(estimated_value) as prev_value, MAX(doc_date) as prev_date FROM t_arf
            WHERE t_arf.status = \'submitted\'
            AND t_arf.id <> \''.$arf->doc_id.'\'
            GROUP BY po_no
        ) prev_arf', 'prev_arf.po_no = t_purchase_order.po_no', 'left')
        ->where('t_purchase_order.po_no', $arf->po_no)
        ->first();
        $po->item = $this->m_arf_po_detail->view('po_detail')
        ->where('t_purchase_order_detail.po_id', $po->id)
        ->get();
        $po->doc_performance_bond = $this->m_arf_po_document->view('document')->scope('performance_bond')
        ->where('po_id', $po->id)
        ->get();
        $po->doc_issurance = $this->m_arf_po_document->view('document')->scope('issurance')
        ->where('po_id', $po->id)
        ->get();
        $po->doc_other = $this->m_arf_po_document->view('document')->scope('other')
        ->where('po_id', $po->id)
        ->get();
        $data['arf'] = $arf;
        $data['po'] = $po;
        $data['document_path'] = $this->document_path;
        $this->template->display_vendor('vn/info/Amendment_acceptance_view', $data);
    }

    public function store($id) {
        $post = $this->input->post();
        $arf = $this->m_arf_recommendation_preparation->view('amendment_recommendation')
        ->find($id);
        if ($arf->extend1) {
            if (!isset($post['document'][1])) {
                $response = array(
                    'success' => false,
                    'message' => 'You have to update performance bond document'
                );
                echo json_encode($response);
                exit;
            }
        }

        if ($arf->extend2) {
            if (!isset($post['document'][1])) {
                $response = array(
                    'success' => false,
                    'message' => 'You have to update insurance document'
                );
                echo json_encode($response);
                exit;
            }
        }

        $this->m_arf_acceptance->insert(array(
            'doc_no' => $arf->doc_no,
            'accepted_at' => date('Y-m-d H:i:s')
        ));
        if (isset($post['document'])) {
            foreach ($post['document'] as $type => $document_type) {
                foreach ($document_type as $document) {
                    $document['type'] = $type;
                    $document['doc_no'] = $arf->doc_no;
                    $document['currency_id'] = $arf->currency_id;
                    $document['currency_base_id'] = $arf->currency_base_id;
                    $document['value_base'] = exchange_rate_by_id($arf->currency_id, $arf->currency_base_id, number_value($document['value']));
                    $this->m_arf_acceptance_document->insert($document);
                }
            }
        }

        $response = array(
            'success' => true,
            'message' => 'Amendment Successfully accepted'
        );
        echo json_encode($response);
    }

    public function document_upload() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('no', 'Document No', 'required');
        $this->form_validation->set_rules('issuer', 'Issuer', 'required');
        $this->form_validation->set_rules('issued_date', 'Issued Date', 'required');
        $this->form_validation->set_rules('value', 'Value', 'required');
        $this->form_validation->set_rules('effective_date', 'Effective Date', 'required');
        $this->form_validation->set_rules('expired_date', 'Expired Date', 'required');
        if (!$this->form_validation->run()) {
            $response = array(
                'success' => false,
                'message' => validation_errors('<div>','</div>')
            );
            echo json_encode($response);
            exit;
        }
        $config['upload_path'] = $this->document_path;
        $config['allowed_types'] = $this->document_allowed_types;
        $config['max_size'] = $this->document_max_size;
        $this->load->library('upload', $config);
        $response = array();
        if ($this->upload->do_upload('file')) {
            $data = $this->input->post();
            $data['file'] = $this->upload->data();
            $response = array(
                'success' => true,
                'message' => 'Successfully uploded document',
                'data' => $data
            );
        } else {
            $response = array(
                'success' => false,
                'message' => $this->upload->display_errors()
            );
        }
        echo json_encode($response);
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
            $data = $this->upload->data();
            $field = $this->input->post();
            $field['file_path'] = $data['file_name'];
            $field['created_by'] = $this->session->userdata('ID');
            $this->db->insert('t_upload',$field);
        }
        $this->dt_attachment();
    }
    public function hapus_attachment($value='')
    {
        $this->db->where('id',$value);
        $upload = $this->db->get('t_upload')->row();
        $data_id = $upload->data_id;
        $module_kode = $upload->module_kode;
        @unlink('upload/ARFRECOMPREP/'.$upload->file_path);

        $this->db->where('id',$value);
        $this->db->delete('t_upload');
        $this->dt_attachment($data_id);
    }
    public function dt_attachment($data_id = '')
    {
      $dataId = $data_id ? $data_id : $this->input->post('data_id');
      $doc = $this->db->where(['module_kode'=>'arf-issued','data_id'=>$dataId])->get('t_upload')->result();

        foreach ($doc as $key => $value) {
            $docType = arfIssuedDoc($value->tipe);
            $delBtn = '';
            if($value->tipe == 2)
            {
              $delBtn = "<a href='#' class='btn btn-sm btn-danger' onclick='hapusFile($value->id)'>Hapus</a>";
              $userName = $this->db->where(['ID'=>$value->created_by])->get('m_vendor')->row();
              $userName = $userName->NAMA;
            }
            else
            {
              $userName = user($value->created_by)->NAME;
            }
            echo "<tr>
              <td>".$docType."</td>
              <td>".$value->file_path."</td>
              <td>".$value->created_at."</td>
              <td>$userName</td>
              <td>
                <a href='".base_url('upload/ARFRECOMPREP/'.$value->file_path)."' target='_blank' class='btn btn-sm btn-primary'>Download</a>
                $delBtn
              </td>
            </tr>";
        }
    }
}