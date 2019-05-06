<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Upload_procurement extends CI_Controller {

    protected $menu;
    protected $document_path = 'upload/procurement';
    protected $document_allowed_types = 'xls|xlsx';
    protected $document_max_size = '2048';

    public function __construct() {
        parent::__construct();
        $this->load->library('url_generator');
        $this->load->library('redirect');

        $this->load->model('vendor/M_vendor');
        $this->load->model('vendor/M_all_intern', 'mai');

        $this->load->model('m_base');
        $this->load->model('procurement/m_procurement');
        $this->load->model('procurement/arf/m_arf_response');
        $this->load->model('procurement/arf/m_arf_response_attachment');
        $this->load->model('procurement/arf/m_arf_po');
        $this->load->model('procurement/arf/m_arf_po_detail');
        $this->load->model('procurement/arf/m_arf_detail');
        $this->load->model('procurement/arf/m_arf_detail_revision');
        $this->load->model('procurement/arf/T_approval_arf_recom');
        $this->load->model('procurement/arf/m_arf_po_document');
        $this->load->model('procurement/arf/M_arf_acceptance_document');

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
    public function index()
    {
        $data['menu'] = $this->menu;
        $this->template->display('procurement/V_upload_procurement', $data);
    }
    public function store()
    {
        $t_msr_field = $this->db->list_fields('t_msr');
        $t_msr_detail_field = $this->db->list_fields('t_msr_item');
        $t_approval_field = $this->db->list_fields('t_approval');
        $t_assignment_field = $this->db->list_fields('t_assignment');
        $t_eq_data_field = $this->db->list_fields('t_eq_data');
        $t_bl_field = $this->db->list_fields('t_bl');
        $t_bl_detail_field = $this->db->list_fields('t_bl_detail');
        $t_sop_field = $this->db->list_fields('t_sop');
        $t_bid_head_field = $this->db->list_fields('t_bid_head');
        $t_sop_bid_field = $this->db->list_fields('t_sop_bid');
        $t_purchase_order_field = $this->db->list_fields('t_purchase_order');
        $t_purchase_order_detail_field = $this->db->list_fields('t_purchase_order_detail');
        $t_itp_field = $this->db->list_fields('t_itp');
        $t_itp_detail_field = $this->db->list_fields('t_itp_detail');
        $t_service_receipt_field = $this->db->list_fields('t_service_receipt');
        $t_service_receipt_detail_field = $this->db->list_fields('t_service_receipt_detail');
        
        $this->load->library('excel');
        $config['upload_path']  = $this->document_path;
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'],0755,TRUE);
        }
        $config['allowed_types']= $this->document_allowed_types;
        $config['max_size']     = $this->document_max_size;
        
        $inputFileType = PHPExcel_IOFactory::identify($_FILES['upload']['tmp_name']);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $excel = $objReader->load($_FILES['upload']['tmp_name']);
        // echo "<pre>";
        
        $this->db->trans_begin();

        $MSR_HEADER = $this->get_excel_range($excel, 'MSR_HEADER', 'F', 'AP');
        $msr = [];
        $msr_no = [];
        $rd = [];
        $field_msr_excel = $MSR_HEADER[1];
        /*print_r($MSR_HEADER);
        exit();*/
        foreach ($MSR_HEADER as $key => $value) {
            $a = trim($value['A']);
            if ($a == '') {
                break;
            }
            elseif($key > 1)
            {
                if($a)
                {
                    $msr_field = [];
                    foreach ($field_msr_excel as $k => $v) {
                        foreach ($t_msr_field as $r=>$s) {
                            if($s == $v)
                            {
                                $msr_field[$s] = trim($value[$k]);
                                if($s == 'msr_no')
                                {
                                    $msr_no[] = trim($value[$k]);
                                }
                                if($s == 'req_date')
                                {
                                    if(is_numeric(trim($value[$k])))
                                    {
                                        $msr_field[$s] = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP(trim($value[$k])));
                                    }
                                    else
                                    {
                                        $rd[] = trim($value[$k]);
                                    }
                                }
                                if($s == 'create_on')
                                {
                                    if(is_numeric(trim($value[$k])))
                                    {
                                        $msr_field[$s] = date("Y-m-d H:i:s", PHPExcel_Shared_Date::ExcelToPHP(trim($value[$k])));
                                    }
                                    else
                                    {
                                        $rd[] = trim($value[$k]);
                                    }
                                }
                            }
                        }
                    }
                    $msr[] = $msr_field;
                }
            }
        }
        
        $cek_msr_no = $this->db->where_in('msr_no',$msr_no)->get('t_msr');
        
        $msr_error_msg = [];
        if(count($rd) > 0)
        {
            $msr_error_msg[] = 'Wrong Date Format';
        }
        if($cek_msr_no->num_rows() > 0)
        {
            $msr_error_msg[] = 'Duplicate Entry';
        }
        
        if(count($msr_error_msg) > 0)
        {
            echo json_encode(['status'=>true,'sheet'=>'MSR_HEADER','msg'=>implode(', ', $msr_error_msg)]);
            return false;
        }
        //$msr_result = $this->db->insert_batch('t_msr',$msr);

        $msr_error_msg = [];
        $MSR_DETAIL = $this->get_excel_range($excel, 'MSR_DETAIL', 'F', 'AE');
        $msr_detail = [];
        $max_msr_item = $this->maxId('t_msr_item','line_item');
        $field_msr_detail_excel = $MSR_DETAIL[1];
        foreach ($MSR_DETAIL as $key => $value) {
            $a = trim($value['A']);
            if ($a == '') {
                break;
            }
            elseif($key > 1)
            {
                if($a)
                {
                    $msr_detail_field = [];
                    foreach ($field_msr_detail_excel as $k => $v) {
                        foreach ($t_msr_detail_field as $r=>$s) {
                            if($s == $v)
                            {
                                $msr_detail_field[$s] = trim($value[$k]);
                                /*if($s == 'line_item')
                                {
                                    unset($msr_detail_field[$s]);
                                }*/
                            }
                        }
                    }
                    $msr_detail[] = $msr_detail_field;
                }
            }
        }

        foreach ($msr_detail as $key => $value) {
            if(!in_array($value['msr_no'], $msr_no))
            {
                $msr_error_msg[] = 'MSR Number Not In MSR_HEADER Sheet';
                break;
            }
            if($value['line_item'] <= $max_msr_item)
            {
                $msr_error_msg[] = 'Duplicate Line Item, Last Line Item Is '.$max_msr_item;
                break;
            }
        }
        $line_item = [];
        foreach ($msr_detail as $key => $value) {
            $line_item[] = $value['line_item'];
        }
        if(count($msr_error_msg) > 0)
        {
            echo json_encode(['status'=>true,'sheet'=>'MSR_DETAIL','msg'=>implode(', ', $msr_error_msg)]);
            $this->db->trans_rollback();
            return false;
        }
        // $this->db->insert_batch('t_msr_item',$msr_detail);

        $MSR_APPROVAL = $excel->getSheetByName('MSR_APPROVAL')->toArray(null,true,true,true);
        $t_approval = [];
        $msr_error_msg = [];
        $rd = [];
        $field_msr_approval_excel = $MSR_APPROVAL[1];
        foreach ($MSR_APPROVAL as $key => $value) {
            $a = trim($value['A']);
            if ($a == '') {
                break;
            }
            elseif($key > 1)
            {
                if($a)
                {
                    $msr_approval_field = [];
                    foreach ($field_msr_approval_excel as $k => $v) {
                        foreach ($t_approval_field as $r=>$s) {
                            if($s == $v)
                            {
                                $msr_approval_field[$s] = trim($value[$k]);
                                if($s == 'created_at')
                                {
                                    $created_at = strtotime($msr_approval_field[$s]);
                                    if(is_numeric($created_at))
                                    {
                                        $msr_approval_field[$s] = date("Y-m-d H:i:s", $created_at);
                                    }
                                    else
                                    {
                                        $rd[] = trim($value[$k]);
                                    }
                                }
                                if($s == 'm_approval_id' or $s == 'status')
                                {
                                    $msr_approval_field[$s] = 1;
                                }
                                if($s == 'id')
                                {
                                    unset($msr_approval_field[$s]);
                                }
                            }
                        }
                    }
                    $t_approval[] = $msr_approval_field;
                }
            }
        }
        if(count($rd) > 0)
        {
            $msr_error_msg[] = 'Wrong Date Format MSR_APPROVAL ';
        }
        foreach ($t_approval as $key => $value) {
            if(!in_array($value['data_id'], $msr_no))
            {
                $msr_error_msg[] = 'DATA ID Not In MSR_HEADER Sheet';
                break;
            }
        }
        if(count($msr_error_msg) > 0)
        {
            echo json_encode(['status'=>true,'sheet'=>'MSR_APPROVAL','msg'=>implode(', ', $msr_error_msg)]);
            $this->db->trans_rollback();
            return false;
        }
        //$this->db->insert_batch('t_approval',$t_approval);

        $MSR_ASSIGNMENT = $this->get_excel_range($excel, 'MSR_ASSIGNMENT', 'G', 'J');
        $t_assignment = [];
        $msr_error_msg = [];
        $field_assignment_excel = $MSR_ASSIGNMENT[1];
        foreach ($MSR_ASSIGNMENT as $key => $value) {
            $a = trim($value['A']);
            if ($a == '') {
                break;
            }
            elseif($key > 1)
            {
                if($a)
                {
                    $msr_assignment_field = [];
                    foreach ($field_assignment_excel as $k => $v) {
                        foreach ($t_assignment_field as $r=>$s) {
                            if($s == $v)
                            {
                                $msr_assignment_field[$s] = trim($value[$k]);
                                if($s == 'id')
                                {
                                    unset($msr_assignment_field[$s]);
                                }
                            }
                        }
                    }
                    $t_assignment[] = $msr_assignment_field;
                }
            }
        }
        foreach ($t_assignment as $key => $value) {
            if(!in_array($value['msr_no'], $msr_no))
            {
                $msr_error_msg[] = 'DATA ID Not In MSR_HEADER Sheet';
                break;
            }
        }
        if(count($msr_error_msg) > 0)
        {
            echo json_encode(['status'=>true,'sheet'=>'MSR_ASSIGNMENT','msg'=>implode(', ', $msr_error_msg)]);
            $this->db->trans_rollback();
            return false;
        }
        //$this->db->insert_batch('t_assignment',$t_assignment);

        $ED_HEADER = $this->get_excel_range($excel, 'ED_HEADER', 'F', 'AQ');
        $t_eq_data = [];
        $msr_error_msg = [];
        $rd = [];
        $field_ed_excel = $ED_HEADER[1];
        foreach ($ED_HEADER as $key => $value) {
            $a = trim($value['A']);
            if ($a == '') {
                break;
            }
            elseif($key > 1)
            {
                if($a)
                {
                    $ed_header_field = [];
                    foreach ($field_ed_excel as $k => $v) {
                        foreach ($t_eq_data_field as $r=>$s) {
                            if($s == $v)
                            {
                                $ed_header_field[$s] = trim($value[$k]);
                                if($s == 'id')
                                {
                                    unset($ed_header_field[$s]);
                                }
                                if(in_array($s, [
                                    'created_at', 'prebiddate', 'closing_date', 'boc_date', 'bod_date', 'issued_award_note', 
                                    'issued_date', 'bid_opening_date', 
                                    ])
                                ){
                                    if(is_numeric($ed_header_field[$s]))
                                    {
                                        $ed_header_field[$s] = date("Y-m-d H:i:s", PHPExcel_Shared_Date::ExcelToPHP($ed_header_field[$s]));
                                    }
                                    else
                                    {
                                        $rd[] = $ed_header_field[$s];
                                    }
                                }
                                if(in_array($s, ['bid_bond_validity', 'bid_validity'])){
                                    /*echo $ed_header_field[$s];
                                    exit();*/
                                    if(is_numeric($ed_header_field[$s]))
                                    {
                                        $ed_header_field[$s] = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP(trim($ed_header_field[$s])));
                                    }
                                    else
                                    {
                                        $rd[] = $ed_header_field[$s];
                                    }
                                }
                            }
                        }
                    }
                    $t_eq_data[] = $ed_header_field;
                }
            }
        }
        if(count($rd) > 0)
        {
            $msr_error_msg[] = 'Wrong Date Format ED_HEADER ';
        }
        foreach ($t_eq_data as $key => $value) {
            if(!in_array($value['msr_no'], $msr_no))
            {
                $msr_error_msg[] = 'MSR NO Not In MSR_HEADER Sheet';
                break;
            }
        }
        if(count($msr_error_msg) > 0)
        {
            echo json_encode(['status'=>true,'sheet'=>'ED_HEADER','msg'=>implode(', ', $msr_error_msg)]);
            $this->db->trans_rollback();
            return false;
        }
        $this->db->insert_batch('t_eq_data',$t_eq_data);

        $ED_DETAIL = $this->get_excel_range($excel, 'ED_DETAIL', 'F', 'I');
        $t_bl = [];
        $field_bl_excel = $ED_DETAIL[1];
        foreach ($ED_DETAIL as $key => $value) {
            $a = trim($value['B']);
            if ($a == '') {
                break;
            }
            elseif($key > 1)
            {
                if($a)
                {
                    $bl_field = [];
                    foreach ($field_bl_excel as $k => $v) {
                        foreach ($t_bl_field as $r=>$s) {
                            if($s == $v)
                            {
                                $bl_field[$s] = trim($value[$k]);
                                if($s == 'id')
                                {
                                    unset($bl_field[$s]);
                                }
                                if(in_array($s, ['created_at'])){
                                    if(is_numeric($bl_field[$s]))
                                    {
                                        $bl_field[$s] = date("Y-m-d H:i:s", PHPExcel_Shared_Date::ExcelToPHP($bl_field[$s]));
                                    }
                                    else
                                    {
                                        $rd[] = $bl_field[$s];
                                    }
                                }

                            }
                        }
                    }
                    $t_bl[] = $bl_field;
                }
            }
        }
        if(count($rd) > 0)
        {
            $msr_error_msg[] = 'Wrong Date Format ED_DETAIL  ';
        }
        foreach ($t_bl as $key => $value) {
            if(!in_array(str_replace('OQ', 'OR', $value['bled_no']), $msr_no))
            {
                $msr_error_msg[] = 'MSR NO Not In MSR_HEADER Sheet';
                break;
            }
        }
        
        if(count($msr_error_msg) > 0)
        {
            echo json_encode(['status'=>true,'sheet'=>'ED_DETAIL','msg'=>implode(', ', $msr_error_msg)]);
            $this->db->trans_rollback();
            return false;
        }
        $this->db->insert_batch('t_bl',$t_bl);

        $BL_DETAIL = $this->get_excel_range($excel, 'BID_DATA(T_BL_DETAIL)', 'F', 'X');
        $t_bl_detail = [];
        $rd = [];
        $msr_error_msg = [];
        $field_bl_detail_excel = $BL_DETAIL[1];
        foreach ($BL_DETAIL as $key => $value) {
            $a = trim($value['B']);
            if ($a == '') {
                break;
            }
            elseif($key > 1)
            {
                if($a)
                {
                    $bl_detail_field = [];
                    foreach ($field_bl_detail_excel as $k => $v) {
                        foreach ($t_bl_detail_field as $r=>$s) {
                            if($s == $v)
                            {
                                $bl_detail_field[$s] = trim($value[$k]);
                                if($s == 'id')
                                {
                                    // unset($bl_detail_field[$s]);
                                }
                                if(in_array($s, ['created_at'])){
                                    if(is_numeric($bl_detail_field[$s]))
                                    {
                                        $bl_detail_field[$s] = date("Y-m-d H:i:s", PHPExcel_Shared_Date::ExcelToPHP($bl_detail_field[$s]));
                                    }
                                    else
                                    {
                                        $rd[] = $bl_detail_field[$s];
                                    }
                                }
                                if(in_array($s, ['submission_date', 'accept_award_date', 'awarder_date'])){
                                    if(is_numeric($bl_detail_field[$s]))
                                    {
                                        $bl_detail_field[$s] = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($bl_detail_field[$s]));
                                    }
                                    else
                                    {
                                        $rd[] = $bl_detail_field[$s];
                                    }
                                }
                            }
                        }
                    }
                    $t_bl_detail[] = $bl_detail_field;
                }
            }
        }
        if(count($rd) > 0)
        {
            $msr_error_msg[] = 'Wrong Date Format BID_DATA(T_BL_DETAIL)  ';
        }
        $vendor = [];
        $bl_detail = [];
        foreach ($t_bl_detail as $key => $value) {
            $vendor[] = $value['vendor_id'];
            $bl_detail[] = $value['id'];
        }
        foreach ($t_bl_detail as $key => $value) {
            if(!in_array($value['msr_no'], $msr_no))
            {
                $msr_error_msg[] = 'MSR NO Not In MSR_HEADER Sheet';
                break;
            }
        }
        
        if(count($msr_error_msg) > 0)
        {
            echo json_encode(['status'=>true,'sheet'=>'BID_DATA(T_BL_DETAIL)','msg'=>implode(', ', $msr_error_msg)]);
            $this->db->trans_rollback();
            return false;
        }
        $this->db->insert_batch('t_bl_detail',$t_bl_detail);

        $SOP = $this->get_excel_range($excel, 'SOP', 'F', 'AC');
        $t_sop = [];
        $max_sop_id = $this->maxId('t_sop');
        $sop_id = [];
        $field_sop_excel = $SOP[1];
        foreach ($SOP as $key => $value) {
            $a = trim($value['A']);
            if ($a == '') {
                break;
            }
            elseif($key > 1)
            {
                if($a)
                {
                    $sop_field = [];
                    foreach ($field_sop_excel as $k => $v) {
                        foreach ($t_sop_field as $r=>$s) {
                            if($s == $v)
                            {
                                $sop_field[$s] = trim($value[$k]);
                                if($s == 'id')
                                {
                                    $sop_id[] = $sop_field[$s];
                                    // unset($sop_field[$s]);
                                }
                            }
                        }
                    }
                    $t_sop[] = $sop_field;
                }
            }
        }
        foreach ($t_sop as $key => $value) {
            if(!in_array($value['msr_no'], $msr_no))
            {
                $msr_error_msg[] = 'MSR NO Not In MSR_HEADER Sheet';
                break;
            }
            if($value['id'] <= $max_sop_id)
            {
                $msr_error_msg[] = 'Duplicate ID, Last ID is '.$max_sop_id;
                break;
            }
        }
        foreach ($t_sop as $key => $value) {
            if(!in_array($value['msr_item_id'], $line_item))
            {
                $msr_error_msg[] = 'msr_item_id Not In Line Item MSR_DETAIL Sheet';
                break;
            }
        }
        if(count($msr_error_msg) > 0)
        {
            echo json_encode(['status'=>true,'sheet'=>'SOP','msg'=>implode(', ', $msr_error_msg)]);
            $this->db->trans_rollback();
            return false;
        }
        $this->db->insert_batch('t_sop',$t_sop);
        
        $BID_HEADER = $this->get_excel_range($excel, 'BID_HEADER', 'C', 'W');
        $t_bid_head = [];
        $field_bid_head_excel = $BID_HEADER[1];
        foreach ($BID_HEADER as $key => $value) {
            $a = trim($value['A']);
            if ($a == '') {
                break;
            }
            elseif($key > 1)
            {
                if($a)
                {
                    $bid_head_field = [];
                    foreach ($field_bid_head_excel as $k => $v) {
                        foreach ($t_bid_head_field as $r=>$s) {
                            if($s == $v)
                            {
                                $bid_head_field[$s] = trim($value[$k]);
                                if($s == 'id')
                                {
                                    unset($bid_head_field[$s]);
                                }
                                if(in_array($s, ['created_at'])){
                                    if(is_numeric($bid_head_field[$s]))
                                    {
                                        $bid_head_field[$s] = date("Y-m-d H:i:s", PHPExcel_Shared_Date::ExcelToPHP($bid_head_field[$s]));
                                    }
                                    else
                                    {
                                        $rd[] = $bid_head_field[$s];
                                    }
                                }
                            }
                        }
                    }
                    $t_bid_head[] = $bid_head_field;
                }
            }
        }
        if(count($rd) > 0)
        {
            $msr_error_msg[] = 'Wrong Date Format BID_HEADER  ';
        }
        foreach ($t_bid_head as $key => $value) {
            if(!in_array($value['created_by'], $vendor))
            {
                $msr_error_msg[] = 'CREATED BY Not In BID_DATA(T_BL_DETAIL) Sheet (vendor_id)';
                break;
            }
        }
        foreach ($t_bid_head as $key => $value) {
            if(!in_array(str_replace('OQ', 'OR', $value['bled_no']), $msr_no))
            {
                $msr_error_msg[] = 'MSR NO Not In MSR_HEADER Sheet';
                break;
            }
        }
        
        if(count($msr_error_msg) > 0)
        {
            echo json_encode(['status'=>true,'sheet'=>'BID_HEADER','msg'=>implode(', ', $msr_error_msg)]);
            $this->db->trans_rollback();
            return false;
        }
        $this->db->insert_batch('t_bid_head',$t_bid_head);

        $SOP_BID = $this->get_excel_range($excel, 'SOP_BID', 'F', 'AA');
        $t_sop_bid = [];
        $max_sop_bid = $this->maxId('t_sop_bid');
        $field_sop_bid_excel = $SOP_BID[1];
        foreach ($SOP_BID as $key => $value) {
            $a = trim($value['A']);
            if ($a == '') {
                break;
            }
            elseif($key > 1)
            {
                if($a)
                {
                    $sop_bid_field = [];
                    foreach ($field_sop_bid_excel as $k => $v) {
                        foreach ($t_sop_bid_field as $r=>$s) {
                            if($s == $v)
                            {
                                $sop_bid_field[$s] = trim($value[$k]);
                                if($s == 'id')
                                {
                                    // unset($sop_bid_field[$s]);
                                }
                                if(in_array($s, ['nego_date'])){
                                    if(is_numeric($sop_bid_field[$s]))
                                    {
                                        $sop_bid_field[$s] = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($sop_bid_field[$s]));
                                    }
                                    else
                                    {
                                        $rd[] = $sop_bid_field[$s];
                                    }
                                }
                            }
                        }
                    }
                    $t_sop_bid[] = $sop_bid_field;
                }
            }
        }
        if(count($rd) > 0)
        {
            $msr_error_msg[] = 'Wrong Date Format SOP_BID  ';
        }
        $sop_bid_id = [];
        foreach ($t_sop_bid as $key => $value) {
            $sop_bid_id[] = $value['id'];
        }
        foreach ($t_sop_bid as $key => $value) {
            if(!in_array($value['msr_no'], $msr_no))
            {
                $msr_error_msg[] = 'MSR NO Not In MSR_HEADER Sheet';
                break;
            }
            if($value['id'] <= $max_sop_bid)
            {
                $msr_error_msg[] = 'Duplicate ID , Last ID is '.$max_sop_bid;
                break;
            }
        }
        foreach ($t_sop_bid as $key => $value) {
            if(!in_array($value['sop_id'], $sop_id))
            {
                $msr_error_msg[] = 'SOP ID Not In SOP Sheet';
                break;
            }
        }
        
        if(count($msr_error_msg) > 0)
        {
            echo json_encode(['status'=>true,'sheet'=>'SOP_BID','msg'=>implode(', ', $msr_error_msg)]);
            $this->db->trans_rollback();
            return false;
        }
        $this->db->insert_batch('t_sop_bid',$t_sop_bid);

        $PO_HEADER = $this->get_excel_range($excel, 'PO_HEADER', 'I', 'AS');
        $t_purchase_order = [];
        $field_po_excel = $PO_HEADER[1];
        foreach ($PO_HEADER as $key => $value) {
            $a = trim($value['A']);
            if ($a == '') {
                break;
            }
            elseif($key > 1)
            {
                if($a)
                {
                    $po_field = [];
                    foreach ($field_po_excel as $k => $v) {
                        foreach ($t_purchase_order_field as $r=>$s) {
                            if($s == $v)
                            {
                                $po_field[$s] = trim($value[$k]);
                                if(in_array($s, ['create_on', 'issued_date', 'completed_date', 'accept_completed_date'])){
                                    if(is_numeric($po_field[$s]))
                                    {
                                        $po_field[$s] = date("Y-m-d H:i:s", PHPExcel_Shared_Date::ExcelToPHP($po_field[$s]));
                                    }
                                    else
                                    {
                                        $rd[] = $po_field[$s];
                                    }
                                }
                            }
                        }
                    }
                    $t_purchase_order[] = $po_field;
                }
            }
        }
        if(count($rd) > 0)
        {
            $msr_error_msg[] = 'Wrong Date Format PO_HEADER  ';
        }
        $po_id = [];
        $po_no = [];
        $vendor_pemenang = [];
        foreach ($t_purchase_order as $key => $value) {
            $po_id[] = $value['id'];
            $po_no[] = $value['po_no'];
            $vendor_pemenang[] = $value['id_vendor'];
        }
        foreach ($t_purchase_order as $key => $value) {
            if(!in_array($value['msr_no'], $msr_no))
            {
                $msr_error_msg[] = 'MSR NO Not In MSR_HEADER Sheet';
                break;
            }
        }
        foreach ($t_purchase_order as $key => $value) {
            if(!in_array($value['id_vendor'], $vendor))
            {
                $msr_error_msg[] = 'ID VENDOR Not In T_BL_DETAIL Sheet';
                break;
            }
        }
        foreach ($t_purchase_order as $key => $value) {
            if(!in_array($value['bl_detail_id'], $bl_detail))
            {
                $msr_error_msg[] = 'bl_detail_id Not In T_BL_DETAIL Sheet';
                break;
            }
        }
        
        if(count($msr_error_msg) > 0)
        {
            echo json_encode(['status'=>true,'sheet'=>'PO_HEADER','msg'=>implode(', ', $msr_error_msg)]);
            $this->db->trans_rollback();
            return false;
        }
        $this->db->insert_batch('t_purchase_order',$t_purchase_order);
        
        $PO_DETAIL = $this->get_excel_range($excel, 'PO_DETAIL', 'F', 'AE');
        $t_purchase_order_detail = [];
        $field_po_detail_excel = $PO_DETAIL[1];
        foreach ($PO_DETAIL as $key => $value) {
            $a = trim($value['A']);
            if ($a == '') {
                break;
            }
            elseif($key > 1)
            {
                if($a)
                {
                    $po_detail_field = [];
                    foreach ($field_po_detail_excel as $k => $v) {
                        foreach ($t_purchase_order_detail_field as $r=>$s) {
                            if($s == $v)
                            {
                                $po_detail_field[$s] = trim($value[$k]);
                                if($s == 'id')
                                {
                                    unset($po_detail_field[$s]);
                                }
                            }
                        }
                    }
                    $t_purchase_order_detail[] = $po_detail_field;
                }
            }
        }
        foreach ($t_purchase_order_detail as $key => $value) {
            if(!in_array($value['po_id'], $po_id))
            {
                $msr_error_msg[] = 'PO_ID Not In PO_HEADER Sheet';
                break;
            }
        }
        foreach ($t_purchase_order_detail as $key => $value) {
            if(!in_array($value['sop_bid_id'], $sop_bid_id))
            {
                $msr_error_msg[] = 'SOP_BID_ID Not In SOP_BID Sheet';
                break;
            }
        }
        foreach ($t_purchase_order_detail as $key => $value) {
            if(!in_array($value['msr_item_id'], $line_item))
            {
                $msr_error_msg[] = 'msr_item_id Not In Line Item MSR_DETAIL Sheet';
                break;
            }
        }
        
        if(count($msr_error_msg) > 0)
        {
            echo json_encode(['status'=>true,'sheet'=>'PO_DETAIL','msg'=>implode(', ', $msr_error_msg)]);
            $this->db->trans_rollback();
            return false;
        }
        $this->db->insert_batch('t_purchase_order_detail',$t_purchase_order_detail);
        /*
        $ITP_HEADER = $this->get_excel_range($excel, 'ITP_HEADER', 'F', 'N');
        $t_itp = [];
        $max_itp_id = $this->maxId('t_itp','id_itp');
        $field_itp_excel = $ITP_HEADER[1];
        foreach ($ITP_HEADER as $key => $value) {
            $a = trim($value['A']);
            if ($a == '') {
                break;
            }
            elseif($key > 1)
            {
                if($a)
                {
                    $itp_field = [];
                    foreach ($field_itp_excel as $k => $v) {
                        foreach ($t_itp_field as $r=>$s) {
                            if($s == $v)
                            {
                                $itp_field[$s] = trim($value[$k]);
                            }
                        }
                    }
                    $t_itp[] = $itp_field;
                }
            }
        }
        $id_itp = [];
        foreach ($t_itp as $key => $value) {
            $id_itp[] = $value['id_itp'];
        }
        foreach ($t_itp as $key => $value) {
            if(!in_array($value['id_vendor'], $vendor))
            {
                $msr_error_msg[] = 'ID_VENDOR Not In BID_DATA(T_BL_DETAIL) Sheet';
                break;
            }
            if($value['id_itp'] <= $max_itp_id)
            {
                $msr_error_msg[] = 'Duplicate ID, Last ID is, '.$max_itp_id;
                break;
            }
        }
        foreach ($t_itp as $key => $value) {
            if(!in_array($value['no_po'], $po_no))
            {
                $msr_error_msg[] = 'NO_PO Not In PO_HEADER Sheet';
                break;
            }
        }
        foreach ($t_itp as $key => $value) {
            if(!in_array($value['id_vendor'], $vendor_pemenang))
            {
                $msr_error_msg[] = 'id_vendor Not In PO_HEADER Sheet';
                break;
            }
        }
        
        if(count($msr_error_msg) > 0)
        {
            echo json_encode(['status'=>true,'sheet'=>'ITP_HEADER','msg'=>implode(', ', $msr_error_msg)]);
            $this->db->trans_rollback();
            return false;
        }
        $this->db->insert_batch('t_itp',$t_itp);

        $ITP_DETAIL = $excel->getSheetByName('ITP_DETAIL')->toArray(null,true,true,true);
        $t_itp_detail = [];
        $field_itp_detail_excel = $ITP_DETAIL[1];
        foreach ($ITP_DETAIL as $key => $value) {
            $a = trim($value['A']);
            if ($a == '') {
                break;
            }
            elseif($key > 1)
            {
                if($a)
                {
                    $itp_detail_field = [];
                    foreach ($field_itp_detail_excel as $k => $v) {
                        foreach ($t_itp_detail_field as $r=>$s) {
                            if($s == $v)
                            {
                                $itp_detail_field[$s] = trim($value[$k]);
                            }
                            if($v == 'sop_bid_id')
                            {
                                $itp_detail_field['material_id'] = trim($value[$k]);
                            }
                        }
                    }
                    $t_itp_detail[] = $itp_detail_field;
                }
            }
        }
        
        foreach ($t_itp_detail as $key => $value) {
            if(!in_array($value['id_itp'], $id_itp))
            {
                $msr_error_msg[] = 'ID_ITP Not In ITP_HEADER Sheet';
                break;
            }
        }
        foreach ($t_itp_detail as $key => $value) {
            if(!in_array($value['material_id'], $sop_bid_id))
            {
                $msr_error_msg[] = 'SOP_BID_ID Not In SOP_BID Sheet';
                break;
            }
        }
        if(count($msr_error_msg) > 0)
        {
            echo json_encode(['status'=>true,'sheet'=>'ITP_DETAIL','msg'=>implode(', ', $msr_error_msg)]);
            $this->db->trans_rollback();
            return false;
        }
        $this->db->insert_batch('t_itp_detail',$t_itp_detail);

        $SERVICE_RECEIPT_HEADER = $this->get_excel_range($excel, 'SERVICE_RECEIPT_HEADER', 'F', 'S');
        $t_service_receipt = [];
        $max_service = $this->maxId('t_service_receipt');
        $field_service_receipt_excel = $SERVICE_RECEIPT_HEADER[1];
        foreach ($SERVICE_RECEIPT_HEADER as $key => $value) {
            $a = trim($value['A']);
            if ($a == '') {
                break;
            }
            elseif($key > 1)
            {
                if($a)
                {
                    $service_receipt_field = [];
                    foreach ($field_service_receipt_excel as $k => $v) {
                        foreach ($t_service_receipt_field as $r=>$s) {
                            if($s == $v)
                            {
                                $service_receipt_field[$s] = trim($value[$k]);
                                if(in_array($s, ['created_at', 'accepted_at', 'updated_at'])){
                                    if(is_numeric($service_receipt_field[$s]))
                                    {
                                        $service_receipt_field[$s] = date("Y-m-d H:i:s", PHPExcel_Shared_Date::ExcelToPHP($service_receipt_field[$s]));
                                    }
                                    else
                                    {
                                        $rd[] = $service_receipt_field[$s];
                                    }
                                }
                                if(in_array($s, ['receipt_date'])){
                                    if(is_numeric($service_receipt_field[$s]))
                                    {
                                        $service_receipt_field[$s] = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($service_receipt_field[$s]));
                                    }
                                    else
                                    {
                                        $rd[] = $service_receipt_field[$s];
                                    }
                                }
                            }
                        }
                    }
                    $t_service_receipt[] = $service_receipt_field;
                }
            }
        }
        if(count($rd) > 0)
        {
            $msr_error_msg[] = 'Wrong Date Format PO_HEADER  ';
        }
        foreach ($t_service_receipt as $key => $value) {
            if(!in_array($value['id_itp'], $id_itp))
            {
                $msr_error_msg[] = 'ID_ITP Not In ITP_HEADER Sheet';
                break;
            }
            if($value['id'] <= $max_service)
            {
                $msr_error_msg[] = 'Duplicate ID';
                break;
            }
        }
        $service_id = [];
        foreach ($t_service_receipt as $key => $value) {
            $service_id[] = $value['id'];
        }
        if(count($msr_error_msg) > 0)
        {
            echo json_encode(['status'=>true,'sheet'=>'SERVICE_RECEIPT_HEADER','msg'=>implode(', ', $msr_error_msg)]);
            $this->db->trans_rollback();
            return false;
        }
        $this->db->insert_batch('t_service_receipt',$t_service_receipt);

        $SERVICE_RECEIPT_DETAIL = $this->get_excel_range($excel, 'SERVICE_RECEIPT_DETAIL', 'F', 'M');
        $t_service_receipt_detail = [];
        $field_service_receipt_detail_excel = $SERVICE_RECEIPT_DETAIL[1];
        foreach ($SERVICE_RECEIPT_DETAIL as $key => $value) {
            $a = trim($value['A']);
            if ($a == '') {
                break;
            }
            elseif($key > 1)
            {
                if($a)
                {
                    $service_receipt_detail_field = [];
                    foreach ($field_service_receipt_detail_excel as $k => $v) {
                        foreach ($t_service_receipt_detail_field as $r=>$s) {
                            if($s == $v)
                            {
                                $service_receipt_detail_field[$s] = trim($value[$k]);
                                if($s == 'id')
                                {
                                    unset($service_receipt_detail_field[$s]);
                                }
                            }
                            if($v == 'sop_bid_id')
                            {
                                $service_receipt_detail_field['id_material'] = trim($value[$k]);
                            }
                        }
                    }
                    $t_service_receipt_detail[] = $service_receipt_detail_field;
                }
            }
        }
        foreach ($t_service_receipt_detail as $key => $value) {
            if(!in_array($value['id_itp'], $id_itp))
            {
                $msr_error_msg[] = 'ID_ITP Not In ITP_HEADER Sheet';
                break;
            }
        }
        foreach ($t_service_receipt_detail as $key => $value) {
            if(!in_array($value['id_material'], $sop_bid_id))
            {
                $msr_error_msg[] = 'SOP_BID_ID Not In SOP_BID Sheet';
                break;
            }
        }
        foreach ($t_service_receipt_detail as $key => $value) {
            if(!in_array($value['id_service_receipt'], $service_id))
            {
                $msr_error_msg[] = 'ID_SERVICE_RECEIPT Not In SERVICE_RECEIPT_HEADER Sheet';
                break;
            }
        }
        if(count($msr_error_msg) > 0)
        {
            echo json_encode(['status'=>true,'sheet'=>'SERVICE_RECEIPT_DETAIL','msg'=>implode(', ', $msr_error_msg)]);
            $this->db->trans_rollback();
            return false;
        }
        $this->db->insert_batch('t_service_receipt_detail',$t_service_receipt_detail);
        */
        if($this->db->trans_status() === true)
        {
            /*ganti trans_commit()*/
            $this->db->trans_rollback();

            echo json_encode(['status'=>false,'msg'=>'Success, All Sheet Stored']);
            // return true;
        }
        else
        {
            $this->db->trans_rollback();
            echo json_encode(['status'=>true, 'sheet'=>'ALL SHEET', 'msg'=>'Something Went Wrong']);
            // return false;
        }
        // print_r($msr);
    }
    public function get_excel_range($excel='',$sheet_name,$highestRow=null,$highestCol=null)
    {
        $sheet = $excel->getSheetByName($sheet_name);
        $highestRow = $sheet->getHighestRow($highestRow);
        return $sheet->garbageCollect()->rangeToArray("A1:$highestCol$highestRow", null, true, false, true);
    }
    public function valid_process($value='')
    {
        
    }
    public function valid_date($d='')
    {
        $e = explode('-', $d);
        if(count($e) == 3)
        {
            if(is_numeric(strtotime($d)))
            {
                // echo "string";
                return true;
            }
            return false;
        }
        return false;
    }
    public function maxId($table='',$pk='id')
    {
        return $this->db->select("$pk as id")->order_by($pk,'desc')->get($table)->row()->id;
    }
}