<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Amendment_acceptance extends CI_Controller {

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
        $this->load->model('procurement/m_procurement');
        $this->load->model('procurement/arf/m_arf_response');
        $this->load->model('procurement/arf/m_arf_response_attachment');
        $this->load->model('procurement/arf/m_arf_po');
        $this->load->model('procurement/arf/m_arf_po_detail');
        $this->load->model('procurement/arf/m_arf_detail');
        $this->load->model('procurement/arf/m_arf_detail_revision');

        $this->load->model('procurement/arf/m_arf');
        $this->load->model('procurement/arf/m_arf_notification');
        $this->load->model('procurement/arf/m_arf_notification_detail_revision');
        $this->load->model('procurement/arf/m_arf_sop');

        $this->load->model('procurement/arf/T_approval_arf_recom');
        $this->load->model('procurement/arf/m_arf_po_document');
        $this->load->model('procurement/arf/m_arf_acceptance');
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

    public function index() {
        $data['menu'] = $this->menu;
        $data['lists'] = $this->dt();
        $this->template->display('procurement/V_amendment_acceptance', $data);
    }
    public function dt($value='')
    {
        /*left join t_arf_assignment on t_arf_assignment.doc_id = t_arf.id*/
        $tarf = $this->db->select('t_arf_acceptance.doc_no,t_arf.po_title title, t_arf.department department_desc,t_arf_notification.response_date,t_arf_response.responsed_at,m_user.NAME,t_arf_response.id')
                ->join('t_arf','t_arf.doc_no = t_arf_acceptance.doc_no', 'left')
                ->join('t_arf_assignment','t_arf_assignment.doc_id = t_arf.id', 'left')
                ->join('t_arf_response','t_arf_response.doc_no = t_arf.doc_no', 'left')
                ->join('t_arf_notification','t_arf_notification.doc_no = t_arf.doc_no', 'left')
                ->join('m_user','m_user.ID_USER = t_arf_assignment.user_id', 'left')
                ->where(['t_arf_acceptance.accepted_user_at'=>null])
                ->get('t_arf_acceptance');
        return $tarf;
    }
    public function view($doc_no='')
    {

        $this->db->where(['t_arf.doc_no'=>$doc_no]);
        $row = $this->dt()->row();

        $id = $row->id;

        $arf = $this->m_arf_response->view('arf_response')->find_or_fail($id);
        
        // $arf->item = $this->m_arf_sop->view('response')->where('t_arf_sop.doc_id', $arf->notification_id)->get();

        $arf->item = $this->m_arf_sop->view('response')->select('t_arf_nego_detail.unit_price new_price')
        ->join('t_arf_nego_detail', 't_arf_sop.id = t_arf_nego_detail.arf_sop_id', 'left')
        ->join('(select * from t_arf_nego where status = 2 order by id desc limit 1) t_arf_nego','t_arf_nego.id = t_arf_nego_detail.arf_nego_id', 'left')->where('t_arf_sop.doc_id', $arf->notification_id)->get();
		
        /*foreach ($this->m_arf_detail_revision->where('doc_id', $arf->doc_id)->get() as $revision) {
            $arf->revision[$revision->type] = $revision;
        }*/
        $markingType = [1=>'value', 2=>'time', 3=>'scope', 4=>'other'];
        foreach ($this->db->where('doc_id', $arf->notification_id)->get('t_arf_notification_detail_revision')->result() as $revision) {
            $arf->revision[$markingType[$revision->type]] = $revision;
        }

        $arf->response_attachment = $this->m_arf_response_attachment->where('t_arf_response_attachment.doc_id', $arf->id)
        ->get();
        $po = $this->m_arf_po->where('t_purchase_order.po_no', $arf->po_no)
        ->first();
        $po->po_type = $this->m_arf_po->enum('type', $po->po_type);
        $po->item = $this->m_arf_po_detail->view('po_detail')
        ->where('t_purchase_order_detail.po_id', $po->id)
        ->get();
        $po->doc_performance_bond = $this->m_arf_po_document->view('document')->scope('performance_bond')
        ->where('po_id', $po->id)
        ->get();
        $po->doc_issurance = $this->m_arf_po_document->view('document')->scope('issurance')
        ->where('po_id', $po->id)
        ->get();
        $arf->acceptance = $this->db->where(['doc_no'=>$doc_no])->get('t_arf_acceptance')->row();

        $findAll = $this->db->where(['po_no'=>$arf->po_no])->get('t_arf_notification');
        
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

        $data['findAllResult'] = $findAllResult;
        $data['arf'] = $arf;
        $data['po'] = $po;
        $data['document_path'] = $this->document_path;
        $data['menu'] = $this->menu;
        $data['doc']       = $this->db->where(['module_kode'=>'arf-issued','data_id'=>$doc_no])->get('t_upload')->result();

        $data['doc_counter_sign'] = 0;
        foreach ($data['doc'] as $doc) {
          if($doc->tipe == 2 or $doc->tipe == 3)
          {
            $data['doc_counter_sign'] = 1;
          }
        }
        // print_r($data['doc_counter_sign']);
        // exit();
        $data['acceptance_docs'] = $this->db->select('t_arf_acceptance_document.*,m_currency.CURRENCY currency')
        ->join('m_currency','m_currency.ID = t_arf_acceptance_document.currency_id', 'left')
        ->where(['doc_no'=>$doc_no])->get('t_arf_acceptance_document')->result();
        $this->template->display('procurement/V_amendment_acceptance_view', $data);
    }
    public function completness($value='')
    {
        $p = $this->input->post();
        $id = $p['id'];
        $data['row'] = $this->M_arf_acceptance_document->find($id);
        $this->load->view('procurement/V_completness_form', $data);
    }
    public function completness_store($value='')
    {
        $p = $this->input->post();
        $currency = $this->db->where(['CURRENCY_BASE'=>1])->get('m_currency')->row();
        $currency_base_id = $currency->ID;
        $value_base = exchange_rate_by_id($p['currency_id'], $currency->ID, number_value($p['nilai']));

        $r = $this->M_arf_acceptance_document->find($p['id']);

        if($_FILES['file']['tmp_name'])
        {
            $config['upload_path']  = './upload/ARF/';
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'],0755,TRUE);
            }
            $config['allowed_types']= '*';

            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('file'))
            {
                $msg =  $this->upload->display_errors('', '');
                echo json_encode(['status'=>false,'msg'=>$msg]);
                exit;
            }
            else
            {
                $data = $this->upload->data();

                $this->db->where(['id'=>$p['id']]);
                $this->db->update('t_arf_acceptance_document',[
                    'no' => $p['no'],
                    'issuer' => $p['issuer'],
                    'issued_date' => $p['issued_date'],
                    'currency_id' => $p['currency_id'],
                    'value' => $p['nilai'],
                    'currency_base_id' => $currency_base_id,
                    'value_base' => $value_base,
                    'effective_date' => $p['effective_date'],
                    'expired_date' => $p['expired_date'],
                    'description' => $p['description'],
                    'file' => $data['file_name'],
                ]);

                $completness_dt = $this->completness_dt($r->doc_no,$r->type);
                echo json_encode(['status'=>true,'msg'=>'Success','html'=>$completness_dt]);
            }
        }
        else
        {
            $this->db->where(['id'=>$p['id']]);
            $this->db->update('t_arf_acceptance_document',[
                'no' => $p['no'],
                'issuer' => $p['issuer'],
                'issued_date' => $p['issued_date'],
                'currency_id' => $p['currency_id'],
                'value' => $p['nilai'],
                'currency_base_id' => $currency_base_id,
                'value_base' => $value_base,
                'effective_date' => $p['effective_date'],
                'expired_date' => $p['expired_date'],
                'description' => $p['description']
            ]);
            $completness_dt = $this->completness_dt($r->doc_no,$r->type);
            echo json_encode(['status'=>true,'msg'=>'Success','html'=>$completness_dt]);
        }
    }
    public function completness_dt($doc_no,$type=1)
    {
        $acceptance_docs = $this->db->select('t_arf_acceptance_document.*,m_currency.CURRENCY currency')
        ->join('m_currency','m_currency.ID = t_arf_acceptance_document.currency_id', 'left')
        ->where(['doc_no'=>$doc_no,'type'=>$type])->get('t_arf_acceptance_document')->result();

        $no = 1;
        $str = '';
        foreach ($acceptance_docs as $doc) {
            $str .= "<tr>
                    <td>$no</td>
                    <td>$doc->no</td>
                    <td class='text-center'>$doc->issuer</td>
                    <td class='text-center'>".dateToIndo($doc->issued_date)."</td>
                    <td class='text-center'>".numIndo($doc->value)."</td>
                    <td class='text-center'>$doc->currency</td>
                    <td class='text-center'>".dateToIndo($doc->effective_date)."</td>
                    <td class='text-center'>".dateToIndo($doc->expired_date)."</td>
                    <td>$doc->description</td>
                    <td class='text-right'>
                        <a href='#' onclick=\"completnessClick('$doc->id')\" class=\"btn btn-info btn-sm btn-block\">Show/Edit</a>
                    </td>
                </tr>";
            $no++;
        }
        return $str;
    }
    public function store()
    {
        $acceptance = $this->m_arf_acceptance->find($this->input->post('id'));
        $notification = $this->m_arf_notification->where('doc_no', $acceptance->doc_no)
        ->first();
        $counter = $this->db->query('SELECT MAX(line_no) as i FROM (
            SELECT line_no FROM t_purchase_order_detail
                JOIN t_purchase_order ON t_purchase_order.id = t_purchase_order_detail.po_id
                WHERE t_purchase_order.po_no = \''.$notification->po_no.'\'
            UNION ALL
            SELECT line_no FROM t_arf_sop
                JOIN t_arf_notification ON t_arf_notification.id = t_arf_sop.doc_id
                WHERE t_arf_notification.po_no = \''.$notification->po_no.'\'
        ) counter')->row();
        $rs_sop = $this->m_arf_sop->where('doc_id', $notification->id)
        ->get();
        $i = $counter->i;
        foreach ($rs_sop as $sop) {
            $i++;
            $this->m_arf_sop->where('id', $sop->id)
            ->update(array('line_no' => $i));
        }
        $this->db->where(['id'=>$this->input->post('id')]);
        $this->db->update('t_arf_acceptance',[
            'accepted_user_at' => date("Y-m-d H:i:s")
        ]);
        $this->db->insert('i_sync', array(
            'doc_no' => $this->input->post('id'),
            'doc_type'  => 'amendment',
            'isclosed' => 0
        ));
        echo json_encode(['status'=>true,'msg'=>'Amendment Completed']);
    }

    public function jde_store() {
        $sync = $this->db->where('doc_type', 'amendment')
        ->where('isclosed', 0)
        ->order_by('id', 'asc')
        ->limit(1)
        ->get('i_sync')
        ->row();
        if ($sync) {
            $acceptance = $this->m_arf_acceptance->find($sync->doc_no);
            $notification = $this->m_arf_notification->view('arf_responsed')->where('t_arf_notification.doc_no', $acceptance->doc_no)->first();
            $notification_revision_value = $this->m_arf_notification_detail_revision->where('doc_id', $notification->id)
            ->where('type', 1)
            ->first();
            $notification_revision_time = $this->m_arf_notification_detail_revision->where('doc_id', $notification->id)
            ->where('type', 2)
            ->first();
            $arf = $this->m_arf->view('arf')
            ->where('t_arf.doc_no', $acceptance->doc_no)
            ->first();
            $po = $this->m_arf_po->view('po')
            ->where('t_purchase_order.po_no', $arf->po_no)
            ->first();
            /*$amended_date = $this->m_arf->select_max('amended_date')
            ->join('t_arf_acceptance', 't_arf_acceptance.doc_no = t_arf.doc_no')
            ->where('t_arf_acceptance.accepted_user_at IS NOT NULL')
            ->first();
            if ($amended_date) {
                if (strtotime($arf->amended_date) > strtotime($amended_date->amended_date)) {
                    $date_promised_delivery = $arf->amended_date;
                } else {
                    $date_promised_delivery = $amended_date->amended_date;
                }
            } else {
                $date_promised_delivery = $po->delivery_date;
            }*/
            // getLastTimeAmd($amdNumber='', $po_date='', $equal = '<')
            $date_promised_delivery = getLastTimeAmd($acceptance->doc_no, $po->delivery_date,"<=");
            if($notification_revision_time and !$notification_revision_value)
            {
              $documentTypeCode = substr($po->po_no, 9, 2);
              $documentNumber = substr($po->po_no, 0, 8);
              $tQueryJde = "SELECT PDLNID FROM F4311 WHERE PDKCOO = $po->id_company AND PDDCTO = '$documentTypeCode' AND PDDOCO = $documentNumber AND PDNXTR NOT IN (999,980)";
              $rJde = $this->db->query($q);
              if($rJde->num_rows() > 0)
              {
                $results = $rJde->result();
                $xml = $this->load->view('procurement/jde/Amendment_time_store', array(
                    'po' => $po,
                    'arf' => $arf,
                    'notification' => $notification,
                    'acceptance' => $acceptance,
                    'date_promised_delivery' => $date_promised_delivery,
                    'results' => $results
                ), TRUE);

                $headers = array(
                    #"Content-type: application/soap+xml;charset=\"utf-8\"",
                    "Content-Type: text/xml",
                    "charset:utf-8",
                    "Accept: application/xml",
                    "Cache-Control: no-cache",
                    "Pragma: no-cache",
                    "Content-length: " . strlen($xml),
                );
                if ($this->input->get('action') == 'get_xml_code') {
                    $this->output->set_content_type('xml')->set_output($xml);
                } else {
                    $ch = curl_init('https://10.1.1.94:89/PY910/ProcurementManager?WSDL');
                    curl_setopt($ch, CURLOPT_HEADER, true);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt($ch, CURLOPT_SSLVERSION, 'all');

                    curl_setopt($ch, CURLOPT_VERBOSE, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,300);
                    curl_setopt($ch, CURLOPT_TIMEOUT,360);
                    $data_curl = curl_exec($ch);
                    curl_close($ch);
          
                    if (strpos($data_curl, 'HTTP/1.1 200 OK') === false) {
                        echo "<pre>".$data_curl."</pre>";
                    } else {
                        $this->db->where('id', $sync->id)->update('i_sync', array('isclosed' => 1));
                        echo "Successfully Exec JDE ARF -  Doc No ".$arf->doc_no." at ".date("Y-m-d H:i:s");
                    }
                }
              }
              else
              {
                echo "Nothing Item";
              }
            }
            elseif ($notification_revision_value) {
                $rs_sop = $this->m_arf_sop->view('response')
                ->where('t_arf_sop.doc_id', $notification->id)
                ->get();
                foreach ($rs_sop as $i => $r_sop) {
                    $id_costcenter = '';
                    $id_account = '';
                    $id_subsidiary = '';
                    $gl_class_code = '';
                    $semic_no = '';
                    $material_desc = '';
                    $line_type_code = '';
                    $subledger = '';
                    $subledger_type_code = '';
                    $cost_unit = '';
                    $qty = '';
                    $uom = '';
                    $cost_extended = '';
                    $landed_cost_rule_code = '';

                    if ($r_sop->id_itemtype == 'GOODS') {
                        $cost_unit = $r_sop->response_unit_price;
                        $qty = $r_sop->response_qty1;
                        if ($r_sop->response_qty2) {
                            $qty *= $r_sop->response_qty2;
                        }
                        $landed_cost_rule_code = $r_sop->vat;
                        switch ($r_sop->inventory_type_code) {
                           case 'INV':
                                $semic_no = $r_sop->item_semic_no_value;
                                $line_type_code = 'S';
                                break;
                            case 'AST':
                                $semic_no = $r_sop->item_semic_no_value;
                                $id_costcenter = $r_sop->id_costcenter;
                                $id_account = substr($r_sop->id_accsub, 0, 4);
                                $id_subsidiary = substr($r_sop->id_accsub, -4);
                                $gl_class_code = 'NS40';
                                $line_type_code = 'J';
                                $subledger = $arf->username_requestor;
                                $subledger_type_code = 'A';
                                break;
                            case 'CON':
                                $semic_no = $r_sop->item_semic_no_value;
                                $id_costcenter = $r_sop->id_costcenter;
                                $id_account = substr($r_sop->id_accsub, 0, 4);
                                $id_subsidiary = substr($r_sop->id_accsub, -4);
                                $gl_class_code = 'NS40';
                                $line_type_code = 'J';
                                $subledger = $arf->username_requestor;
                                $subledger_type_code = 'A';
                                break;
                            default:

                                break;
                        }
                        $cost_unit = $r_sop->response_unit_price;
                        $qty = $r_sop->response_qty1;
                        if ($r_sop->response_qty2) {
                            $qty *= $r_sop->response_qty2;
                        }
                        $uom = $r_sop->uom1;
                    } else {
                        if ($r_sop->item_modification) {
                            $material_desc = $r_sop->item;
                            $id_costcenter = $r_sop->id_costcenter;
                            $id_account = substr($r_sop->id_accsub, 0, 4);
                            $id_subsidiary = substr($r_sop->id_accsub, -4);
                            $gl_class_code = 'NS40';
                            $line_type_code = 'I';
                        } else {
                            $material_desc = $r_sop->item;
                            $id_costcenter = $r_sop->id_costcenter;
                            $id_account = substr($r_sop->id_accsub, 0, 4);
                            $id_subsidiary = substr($r_sop->id_accsub, -4);
                            $gl_class_code = 'NS40';
                            $line_type_code = 'J';
                        }
                        $cost_unit = $r_sop->response_unit_price * $r_sop->response_qty1;
                        if ($r_sop->response_qty2) {
                            $cost_unit *= $r_sop->response_qty2;
                        }
                        $subledger = $arf->username_requestor;
                        $subledger_type_code = 'A';
                    }
                    $acceptance->items[] = array(
                        'id_itemtype' => $r_sop->id_itemtype,
                        'inventory_type_code' => $r_sop->inventory_type_code,
                        'id_costcenter' => $id_costcenter,
                        'id_account' => $id_account,
                        'id_subsidiary' => $id_subsidiary,
                        'gl_class_code' => $gl_class_code,
                        'semic_no' => $semic_no,
                        'material_desc' => $material_desc,
                        'line_type_code' => $line_type_code,
                        'subledger' => $subledger,
                        'subledger_type_code' => $subledger_type_code,
                        'cost_unit' => $cost_unit,
                        'qty' => $qty,
                        'uom' => $uom,
                        'cost_extended' => $cost_extended,
                        'landed_cost_rule_code' => $landed_cost_rule_code,
                        'line_no' => $r_sop->line_no
                    );
                }
                $xml = $this->load->view('procurement/jde/Amendment_store', array(
                    'po' => $po,
                    'arf' => $arf,
                    'notification' => $notification,
                    'acceptance' => $acceptance,
                    'date_promised_delivery' => $date_promised_delivery
                ), TRUE);

                $headers = array(
                    #"Content-type: application/soap+xml;charset=\"utf-8\"",
                    "Content-Type: text/xml",
                    "charset:utf-8",
                    "Accept: application/xml",
                    "Cache-Control: no-cache",
                    "Pragma: no-cache",
                    "Content-length: " . strlen($xml),
                );
                if ($this->input->get('action') == 'get_xml_code') {
                    $this->output->set_content_type('xml')->set_output($xml);
                } else {
                    $ch = curl_init('https://10.1.1.94:89/PY910/ProcurementManager?WSDL');
                    curl_setopt($ch, CURLOPT_HEADER, true);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt($ch, CURLOPT_SSLVERSION, 'all');

                    curl_setopt($ch, CURLOPT_VERBOSE, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,300);
                    curl_setopt($ch, CURLOPT_TIMEOUT,360);
                    $data_curl = curl_exec($ch);
                    curl_close($ch);
					
                    if (strpos($data_curl, 'HTTP/1.1 200 OK') === false) {
                        echo "<pre>".$data_curl."</pre>";
                        // echo "Failed Exec JDE ARF -  Doc No ".$arf->doc_no." at ".date("Y-m-d H:i:s");
                    } else {
                        $this->db->where('id', $sync->id)
                        ->update('i_sync', array(
                            'isclosed' => 1
                        ));
                        echo "Successfully Exec JDE ARF -  Doc No ".$arf->doc_no." at ".date("Y-m-d H:i:s");
                    }
                }
            }
        } else {
            echo 'Data not found';
        }
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
          $field['file_path'] = $config['upload_path'].$data['file_name'];
          $field['file_name'] = $data['file_name'];
          $field['created_by'] = $this->session->userdata('ID_USER');
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
        if($value->creator_type == 'vendor')
        {
          $userName = $this->db->where(['ID'=>$value->created_by])->get('m_vendor')->row();
          $userName = $userName->NAMA;
        }
        else
        {
          $userName = user($value->created_by)->NAME;
        }
        $delBtn = "<a href='#' class='btn btn-sm btn-danger' onclick='hapusFile($value->id)'>Hapus</a>";
        echo "<tr>
          <td>".$docType."</td>
          <td>".$value->file_name."</td>
          <td>".$value->created_at."</td>
          <td>$userName</td>
          <td>
            <a href='".base_url($value->file_path)."' target='_blank' class='btn btn-sm btn-primary'>Download</a>
            $delBtn
          </td>
        </tr>";
    }
  }
  public function check_counter_sign()
  {
    $p = $this->input->post();
    $data['doc'] = $this->db->where(['module_kode'=>'arf-issued','data_id'=>$p['doc_no']])->get('t_upload')->result();
    $doc_counter_sign = 0;
    foreach ($data['doc'] as $doc) {
      if($doc->tipe == 2 or $doc->tipe == 3)
      {
        $doc_counter_sign = 1;
      }
    }
    if($doc_counter_sign == 1)
    {
      echo json_encode(['status'=>true]);
    }
    else
    {
      echo json_encode(['status'=>false]);
    }
  }
}