<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Browse extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('m_base');
        $this->load->model('procurement/arf/m_arf_sop');

    }

    public function po() {
        $this->load->model('procurement/arf/m_arf_po');
        if ($this->input->get('datatable') == 1) {
            $this->load->library('m_datatable');
            return $this->m_datatable->resource($this->m_arf_po)
            ->view('po')
            ->filter(function($model) {
                if ($issued = $this->input->get('issued')) {
                    $model->where('t_purchase_order.issued', $issued);
                }
                if ($creator = $this->input->get('creator')) {
                    $model->where('t_msr.create_by', $creator);
                }
            })
            ->edit_column('po_type', function($model) {
                return $this->m_arf_po->enum('type', $model->po_type);
            })
            ->generate();
        }
        $this->load->view('procurement/browse/po');
    }
    public function spending_value()
    {
        $po_no = $this->input->post('po_no');
        $e = explode('-', $po_no);

        $sql = "select PDLNID,PDLITM,
        PDDSC1,PDDSC2,
        PDUORG,PDUOM,
        CASE WHEN PDCRCD='USD' THEN PDPRRC ELSE PDFRRC END as UNITCOST, 
        CASE WHEN PDCRCD='USD' THEN PDAEXP ELSE PDFEA END as AMTTOTAL,
        CASE WHEN PDCRCD='USD' THEN PDAOPN ELSE PDFAP END as AMTOPEN,
        CASE WHEN PDCRCD='USD' THEN PDAREC ELSE PDFREC END as AMTSPENDING,
        PDCRCD,PDANI 
        FROM F4311 WHERE TRIM(PDDOCO)=$e[0] AND TRIM(PDDCTO)='$e[1]' AND TRIM(PDKCOO)='$e[2]'
        AND PDNXTR||PDLTTR not in ('999980')";
        $db = $this->load->database('oracle', TRUE);
        $rs = $db->query($sql);
        
        if($rs->num_rows() > 0)
        {
            $r = $db->query($sql)->row();
            echo json_encode(['status'=>true, 'spending_value'=>$r->AMTSPENDING]);
        }
        else
        {
            echo json_encode(['status'=>false]);
        }
    }
    public function get_amd()
    {
        $po_no = $this->input->post('po_no');
        $this->db->get('t_arf_recommendation_preparation');

        $sql = "SELECT t_arf.id arf_id, t_arf_recommendation_preparation.doc_no doc_no_amd, t_arf.doc_no doc_no_arf, 
        t_arf.amount_po, t_arf_recommendation_preparation.po_no po_no_amd,t_arf.po_no po_no_arf 
        from t_arf_recommendation_preparation 
        left join t_arf on t_arf.po_no = t_arf_recommendation_preparation.po_no 
        left JOIN t_arf_detail_revision on t_arf_detail_revision.doc_id = t_arf.id 
        where t_arf_recommendation_preparation.po_no = '$po_no' and t_arf_detail_revision.type = 'value' and `t_arf_detail_revision`.`value` > 0 order by t_arf.id desc";
        $q = $this->db->query($sql);
        $num = $q->num_rows();
        if($num > 0)
        {
          $allTotal = 0;
          $arf = $q->row();
          $findAllResult = $this->db->where(['po_no'=>$arf->po_no_amd])->get('t_arf_notification')->result();
          $dt = '';
          foreach ($findAllResult as $r) {
            $data = $this->m_arf_sop->view('response')
            ->select('arf_nego.unit_price new_price')
            ->join("(select t_arf_nego_detail.unit_price, arf_nego.arf_response_id, t_arf_nego_detail.arf_sop_id from 
            (select * from t_arf_nego where status = 2 order by id desc limit 1) arf_nego
            left join t_arf_nego_detail on arf_nego.id = t_arf_nego_detail.arf_nego_id
            WHERE t_arf_nego_detail.is_nego = 1) arf_nego", "t_arf_sop.id = arf_nego.arf_sop_id", "left")
            // ->join('t_arf_nego_detail', 't_arf_sop.id = t_arf_nego_detail.arf_sop_id', 'left')
            //->join('(select * from t_arf_nego where status = 2 order by id desc limit 1) t_arf_nego','t_arf_nego.id = t_arf_nego_detail.arf_nego_id', 'left')
            ->where('t_arf_sop.doc_id', $r->id)->get();
            $dt .= "<tr bgcolor='#cceee'><td colspan='10'><b>$r->doc_no</b></td></tr>";
            $total = 0;
            foreach ($data as $item) {
              $qty = $item->qty2 > 0 ? $item->qty1*$item->qty2 : $item->qty1;
              $response_qty = $item->response_qty1 > 0 ? $item->response_qty1*$item->response_qty2 : $item->response_qty1;
              $uom = $item->uom2 ? $item->uom1.'/'.$item->uom2 : $item->uom1;
              $price = $item->new_price > 0 ? $item->new_price : $item->response_unit_price;
              $subTotalPrice = $price*$qty;      
              $total += $subTotalPrice;
              $item_modification = ($item->item_modification) ? '<i class="fa fa-check-square text-success"></i>' : '<i class=" fa fa-times text-danger"></i>';
              $cc = $item->id_costcenter ."-". $item->costcenter_desc;
              $accSub = $item->id_accsub ."-". $item->accsub_desc;
              $numPrice = numIndo($price);
              $numSubTotalPrice = numIndo($subTotalPrice);
              $dt .= "<tr>
              <td>$item->item_type</td>
              <td>$item->item</td>
              <td class='text-center'>$qty</td>
              <td class='text-center'>$uom</td>
              <td class='text-center'>$item_modification</td>
              <td class='text-center'>$item->inventory_type</td>
              <td class='text-center'>$cc</td>
              <td class='text-center'>$accSub</td>
              <td class='text-right'>$numPrice</td>
              <td class='text-right'>$numSubTotalPrice</td></tr>";
              $allTotal += $total;
            }
            $strTotal = numIndo($total);
            $dt .= "<tr><td colspan='9' class='text-right' style='border-top:1px solid #ccc !important'>Total</td><td class='text-right'>$strTotal</td></tr>";    
          }
          
          echo json_encode(['status'=>true, 'dt'=>$dt, 'total'=>$allTotal + $arf->amount_po]);
        }
        else
        {
        echo json_encode(['status'=>false]);

        }
    }
    public function last_amd($po_no='')
    {
        $amd = $this->db->where('po_no', $po_no)->get('t_arf_recommendation_preparation')->result();
        $data['amd'] = $amd;

        $response = [];
            $response_detail = [];
        foreach ($amd as $key => $value) {
            $res = $this->db->where(['id'=>$value->arf_response_id])->get('t_arf_response')->result();
            $response[] = $res;
            foreach ($res as $r) {
                $res_detail = $this->db->where(['doc_no'=>$r->doc_no])->get('t_arf_response_detail')->result();
                $response_detail[] = $res_detail;
            }

            $nego = $this->db->where(['status'=>2, 'arf_response_id'=>$value->arf_response_id])->order_by('id','desc')->get('t_arf_nego');
            if($nego->num_rows() > 0)
            {
                $nego = $nego->row();
                $nego_details = $this->db->where(['is_nego'=>1, 'arf_nego_id'=>$nego->id])->order_by('id','asc')->get('t_arf_nego_detail');
                if($nego_details->num_rows() > 0)
                {
                    $nego_details_array[] = $nego_details->result();
                }
            }
        }

        $latest_price = [];
        foreach ($response_detail as $response_details) {
            $new_data_array = [];
            foreach ($response_details as $val) {
                // echo $val->detail_id;
                $new_data['unit_price'] = $val->unit_price;
                foreach ($nego_details_array as $nego_detail) {
                    foreach ($nego_detail as $nego_val) {
                        if($nego_val->arf_sop_id == $val->detail_id)
                        {
                            $new_data['unit_price'] = $nego_val->unit_price;
                        }
                    }    
                }
                $new_data_array[] = $new_data;
            }
            
            $latest_price[] = $new_data_array;
            # code...
        }
        $data['response'] = $response;
        $data['response_detail'] = $response_detail;
        $data['nego_details_array'] = $nego_details_array;
        $data['latest_price'] = $latest_price;

        echo "<pre>";
        print_r($data);
    }
}