<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_arf_response extends M_base {

    protected $table = 't_arf_response';
    protected $fillable = array('doc_no', 'currency_id', 'currency_base_id', 'subtotal', 'subtotal_base', 'confirm', 'note', 'responsed_at');

    public function view_arf_response() {
        $this->db->select('
            t_arf_response.*,
            t_arf.id as doc_id,
            t_arf.po_no,
            t_arf.amount_po_arf,
            t_arf.amended_date,
            t_arf.currency_id,
            t_arf.currency_base_id,
            t_arf.amount_po,
            t_arf.amount_po_base,
            t_arf.estimated_value,
            t_arf.estimated_value_base,
            t_arf.estimated_new_value,
            t_arf.estimated_new_value_base,
            t_arf.review_bod,
            t_arf_assignment.created_at as assignment_date,
            u.NAME as ps,
            t_arf_notification.id as notification_id,
            t_arf_notification.dated as notification_date,
            t_arf_notification.response_date as close_date,
            t_arf_notification.estimated_value_new,
            t_purchase_order.title, t_purchase_order.po_type,
            t_msr.create_by AS id_requestor,
            m_user.NAME AS requestor,
            t_msr.id_company,
            m_company.DESCRIPTION as company,
            m_company.ABBREVIATION as abbr,
            u.NAME as ps,
            m_user.ID_DEPARTMENT as id_department,
            m_departement.DEPARTMENT_DESC as department,m_vendor.NAMA as vendor,
            currency.CURRENCY as currency,
            currency_base.CURRENCY as currency_base,
            t_arf_recommendation_preparation.new_date_1, t_arf_recommendation_preparation.new_date_2,
            t_arf_recommendation_preparation.bod_approval,t_arf_recommendation_preparation.aa,
            t_arf_recommendation_preparation.extend1, t_arf_recommendation_preparation.extend2,
            t_arf_recommendation_preparation.remarks_1, t_arf_recommendation_preparation.remarks_2')
        ->join('t_arf_notification', 't_arf_notification.doc_no = t_arf_response.doc_no')
        ->join('t_arf', 't_arf.doc_no = t_arf_response.doc_no')
        ->join('t_arf_assignment', 't_arf_assignment.doc_id = t_arf.id')
        ->join('t_purchase_order', 't_purchase_order.po_no = t_arf.po_no')
        ->join('t_msr', 't_msr.msr_no = t_purchase_order.msr_no')
        ->join('m_company', 'm_company.ID_COMPANY = t_msr.id_company')
        ->join('m_user', 'm_user.ID_USER = t_msr.create_by')
        ->join('m_user u', 'u.ID_USER = t_arf_assignment.user_id', 'left')
        ->join('m_departement', 'm_departement.ID_DEPARTMENT = m_user.ID_DEPARTMENT')
        ->join('m_vendor', 'm_vendor.ID = t_purchase_order.id_vendor')
        ->join('m_currency currency', 'currency.ID = t_arf.currency_id')
        ->join('m_currency currency_base', 'currency_base.ID = t_arf.currency_base_id')
		->join('t_arf_recommendation_preparation', 't_arf_recommendation_preparation.arf_response_id = t_arf_response.id','left');
    }
    
    public function scope_procurement_specialist() {
        $this->db->where('t_arf_assignment.user_id', $this->session->userdata('ID_USER'));
    }

    public function scope_recommendation_preparation() {
        $this->db->where('NOT EXISTS (
            SELECT doc_no FROM t_arf_recommendation_preparation
            WHERE doc_no = t_arf_response.doc_no
        )');
    }

    public function enum_confirm() {
        return array(
            1 => 'Confirm',
            2 => 'Confirm With Note',
            3 => 'Quotation refer to schedule of price and attachment'
        );
    }
    public function arf_nego($id='')
    {
        $sql = "select c.*, b.unit_price 
        from t_arf_response a 
        left join t_arf_response_detail b on a.doc_no = b.doc_no
        left join t_arf_sop c on b.detail_id = c.id
        where a.id = $id";
        $query = $this->db->query($sql)->result();
        return $query;
    }
    public function arf_nego_store($value='')
    {
        $this->db->trans_begin();
        
        $id = $this->input->post('arf_response_id');
        $fieldArfNego =  [
            'company_letter_no'=>$this->input->post('company_letter_no'),
            'tanggal'=>$this->input->post('tanggal'),
            'note'=>$this->input->post('note'),
            'arf_response_id'=>$id,
            'created_at' => date("Y-m-d H:i:s")
        ];
        $config['upload_path']  = './upload/arf_nego/';
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'],0755,TRUE);
        }
        $config['allowed_types']= '*';
        
        $this->load->library('upload', $config);
        if($_FILES['supporting_document']['tmp_name'])
        {
            if ( ! $this->upload->do_upload('supporting_document'))
            {
                $display_errors =  $this->upload->display_errors('', '');
                echo json_encode(['status'=>false,'msg'=>$display_errors]);
                exit;
            }else
            {
                $data = $this->upload->data();
                $fieldArfNego['supporting_document'] = $data['file_name'];
            }
        }

        $this->db->insert('t_arf_nego', $fieldArfNego);
        $arf_nego_id = $this->db->insert_id();
        $nego = $this->input->post('nego');

        $arf_nego = $this->arf_nego($id);
        foreach ($arf_nego as $key => $value) {
            $field = ['arf_nego_id'=>$arf_nego_id, 'arf_sop_id'=>$value->id, 'arf_response_id'=>$id, 'unit_price'=>$value->unit_price];
            if(in_array($value->id, $nego))
            {
                $field['is_nego'] = 1;
            }
            else
            {
                $field['is_nego'] = 0;
            }
            $this->db->insert('t_arf_nego_detail', $field);
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
    public function scope_amd_issued() {
        $this->db->where('`t_arf_response`.`id` in (select `id_ref` from `t_approval_arf_recom` where status = 1 and sequence = 8)', null, false);
    }
    public function scope_reject() {
        $this->db->where('`t_arf_response`.`id` in (select `id_ref` from `t_approval_arf_recom` where status = 2)', null, false);
    }
    public function latest_nego($arf_response_id='')
    {
        $arfNego = $this->db->where(['arf_response_id'=>$arf_response_id])->order_by('id','desc')->get('t_arf_nego')->row();
        $arfNegoDetail = $this->db->where(['arf_response_id'=>$arf_response_id])->order_by('id','desc')->get('t_arf_nego_detail')->result();
        return ['arfNego'=>$arfNego, 'arfNegoDetail' => $arfNegoDetail];
    }
    public function scope_not_amd() {
        // $this->db->where("`t_arf_response`.`id` not in (select `arf_response_id` from t_arf_recommendation_preparation where arf_response_id not in (select id_ref as arf_response_id from t_approval_arf_recom WHERE description = 'Award Recommendation Issuance') )", null, false);
        $this->db->where("`t_arf_response`.`id` not in (select id_ref as arf_response_id from t_approval_arf_recom WHERE (description = 'Award Recommendation Issuance' and status=1) or status = 0 group by id_ref)", null, false);
    }
}