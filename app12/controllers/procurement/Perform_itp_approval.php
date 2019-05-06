<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Perform_itp_approval extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('procurement/M_perform_itp_approval')->model('vendor/M_vendor');
        $this->load->helper(array('string', 'text'));
        $this->load->helper('helperx_helper');
        $this->load->helper('global_helper');
        $this->load->helper('exchange_rate_helper');
    }

    public function index() {
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $this->template->display('procurement/V_perform_itp_approval', $data);
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
    // -----------------------------------------------------------------------------------

    public function datatable_msr_remaining(){
      $data = $this->M_perform_itp_approval->show_msr_remaining();
      $result = array();
      $no = 1;
      foreach ($data as $arr) {
        $aksi = '<center> <button data-id="'.$arr['msr_no'].'" id="approve" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-primary" title="Update"><i class=""> Proses</i></button></center>';
        // $no++;
        $result[] = array(
          0 => $no++,
          1 => $arr['msr_no'],
          2 => $arr['msr_type_desc'],
          3 => $arr['scope_of_work'],
          4 => $arr['title'],
          5 => $arr['id_currency'],
          6 => $arr['create_on'],
          7 => $arr['req_date'],
          8 => $aksi,
        );
      }
      echo json_encode($result);
    }

    public function datatable_list_itp_on_progress(){
      $data = $this->M_perform_itp_approval->list_itp_onprogress();
      $result = array();
      $no = 1;

      $class = 'success';
      foreach ($data as $arr) {

        if (strpos($arr['description'], "DATA DITOLAK") === FALSE) {
          $aksi = '<center> <button data-id="'.$arr['id_itp_vendor'].'" data-code="'.$arr['id'].'|'.$arr['id_itp'].'|'.$arr['user_roles'].'|'.$arr['email_approve'].'|'.$arr['extra_case'].'|'.$arr['email_reject'].'|'.$arr['sequence'].'|'.$arr['status_approve'].'|'.$arr['reject_step'].'" id="approve" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-primary" title="Update"><i class=""> Detail</i></button></center>';
          $class = 'success';
        } else {
          $aksi = '<center> <button data-id="'.$arr['id_itp_vendor'].'" data-code="'.$arr['id'].'|'.$arr['id_itp'].'|'.$arr['user_roles'].'|'.$arr['email_approve'].'|'.$arr['extra_case'].'|'.$arr['email_reject'].'|'.$arr['sequence'].'|'.$arr['status_approve'].'|'.$arr['reject_step'].'" id="approve" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-info" title="Detail"><i class=""> Detail</i></button></center>';
          $class = 'danger';
        }

        $result[] = array(
          0 => $no++,
          1 => $arr['itp_no'],
          2 => $arr['title'],
          3 => $arr['created_date'],
          4 => '<center><span class="badge badge badge-pill badge-'.$class.'">'.$arr['description'].'</span></center>',
          5 => $aksi,
        );
      }
      echo json_encode($result);
    }

    public function get_item_selection(){
      $idnya = $this->input->post("idnya");
      $data = $this->M_perform_itp_approval->get_item_selection($idnya);
      $get_comp = $this->M_perform_itp_approval->get_comp($idnya);

      foreach($data as $key => $val){
        $data[$key]['dt_comp'] = $get_comp;
      }
      echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function create_itp_document(){
      $id_itp = $this->input->post("id_itp");
      $item_type = $this->input->post("item_type");
      $note = $this->input->post("note");
      $item_qty = $this->input->post("item_qty");
      $item_ammount = $this->input->post("item_ammount");
      $material_id = $this->input->post("material_id");
      $total_spending = $this->input->post("total_spending");
      $price_unit = $this->input->post("price_unit");
      // $file_attch = ($_FILES["file_attch"] != "" ? $_FILES["file_attch"] : "");

      $data = array(
        'id_itp' => $id_itp,
        'no_po' => "",
        'note' => $note,
        'type' => 'ITP',
        'material_id' => $material_id,
        'qty' => $item_qty,
        'priceunit' => $price_unit,
        'total' => $item_ammount,
        'filename' => $_FILES["file_attch"],
      );

      $this->M_perform_itp_approval->create_itp_document($data);
      echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function show_data_itp(){
      $msr_no = $this->input->post("msr_no");
      $data = $this->M_perform_itp_approval->show_data_itp($msr_no);
      echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function itp_doc_approval(){
      $idx = $this->input->post("idx");
      $id_itp = $this->input->post("id_itp");
      $sequence = $this->input->post("sequence");
      $user_roles = $this->input->post("user_roles");
      $email_approve = $this->input->post("email_approve");
      $edit_content = $this->input->post("edit_content");
      $id_vendor = $this->input->post("id_vendor");
      $vendor_name = $this->input->post("vendor_name");
      $po_number = $this->input->post("po_number");

      $id_itp = $this->input->post("id_itp");
      $item_type = $this->input->post("item_type");
      $note = $this->input->post("note");
      $item_qty = $this->input->post("item_qty");
      $item_ammount = $this->input->post("item_ammount");
      $material_id = $this->input->post("material_id");
      $total_spending = $this->input->post("total_spending");
      $price_unit = $this->input->post("price_unit");
      $rm_file = $this->input->post("rm_file");
      // $file_attch = ($_FILES["file_attch"] != "" ? $_FILES["file_attch"] : "");

      $data_itp = array();

      if ($edit_content == 1) {

        $data_itp = array(
          'id_itp' => $id_itp,
          'no_po' => "",
          'note' => $note,
          'type' => 'ITP',
          'material_id' => $material_id,
          'qty' => $item_qty,
          'priceunit' => $price_unit,
          'total' => $item_ammount,
          'filename' => $_FILES["file_attch"],
          'rm_file' => $rm_file
        );

        $send_data_upd = $this->M_perform_itp_approval->itp_doc_approval_upd($data_itp);
      }


      $data = array(
        'idx' => $idx,
        'sequence' => $sequence,
        'user_roles' => $user_roles,
        'id_itp' => $id_itp,
        'data_itp' => $data_itp,
      );

      $send_data = $this->M_perform_itp_approval->itp_doc_approval($data);

      if ($send_data) {
        ini_set('max_execution_time', 500);
        $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
        $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";


        $query = $this->db->query("select u.*,u.roles,b.user_roles as recipient,email_approve,n.open_value from t_approval_itp_vendor m
        join m_notic n on n.id=m.email_approve
        join ( select id_itp,user_roles from t_approval_itp_vendor where sequence=".$sequence."+1) b on b.id_itp=m.id_itp
        join m_user u on u.roles like CONCAT('%', b.user_roles ,'%')
        where m.sequence=".$sequence." and m.id_itp = ".$id_itp."");
        if ($query->num_rows() > 0) {
          $data_role = $query->result();
          $count = 1;
        } else {
          $query2 = $this->db->query("select u.*,u.roles,b.user_roles as recipient,email_approve,n.open_value from t_approval_itp_vendor m
          join m_notic n on n.id=m.email_approve
          join ( select id_itp,user_roles from t_approval_itp_vendor where sequence=".$sequence.") b on b.id_itp=m.id_itp
          join m_user u on u.roles like CONCAT('%', b.user_roles ,'%')
          where m.sequence=".$sequence." and m.id_itp = ".$id_itp."");
          $data_role = $query2->result();
          $count = 0;
        }

        if ($count = 1) {
          $content = $this->M_perform_itp_approval->get_email_dest($email_approve);
          $res = $data_role;
          $qq = $this->db->query("SELECT title FROM t_purchase_order WHERE po_no = '".$po_number."'");
          $str = ' (NAMA VENDOR) '.$vendor_name.' untuk tender (PO) '.$po_number.' - '.$qq->row()->title;

          $data = array(
            'img1' => $img1,
            'img2' => $img2,
            'title' => $content[0]->TITLE,
            'open' => str_replace("_var1_", $str, $content[0]->OPEN_VALUE),
            'close' => $content[0]->CLOSE_VALUE
          );

          foreach ($data_role as $k => $v) {
            $data['dest'][] = $v->EMAIL;
          }
          $flag = $this->sendMail($data);
        }

        if ($count = 0) {
          // Sinkron JDE
          $datas['doc_no'] = $id_itp;
          $datas['doc_type'] = 'srv_rcp';
          $datas['isclosed'] = 0;
          $this->db->insert('i_sync',$datas);
        }
      }

      echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function reject_itp_doc(){
      $note = (!empty($_POST['note'])?$_POST['note']:"");
      $id_rej = (!empty($_POST['id_rej'])?$_POST['id_rej']:"0");
      $id_itp_rej = (!empty($_POST['id_itp_rej'])?$_POST['id_itp_rej']:"0");
      $user_roles_rej = (!empty($_POST['user_roles_rej'])?$_POST['user_roles_rej']:"0");
      $email_approve_rej = (!empty($_POST['email_approve_rej'])?$_POST['email_approve_rej']:"0");
      $edit_content_rej = (!empty($_POST['edit_content_rej'])?$_POST['edit_content_rej']:"0");
      $email_reject_rej = (!empty($_POST['email_reject_rej'])?$_POST['email_reject_rej']:"0");
      $sequence_rej = (!empty($_POST['sequence_rej'])?$_POST['sequence_rej']:"0");
      $status_approve_rej = (!empty($_POST['status_approve_rej'])?$_POST['status_approve_rej']:"0");
      $reject_step_rej = (!empty($_POST['reject_step_rej'])?$_POST['reject_step_rej']:"0");


      $save_data = array(
        'note' => $note,
        'id_rej' => $id_rej,
        'id_itp_rej' => $id_itp_rej,
        'user_roles_rej' => $user_roles_rej,
        'email_approve_rej' => $email_approve_rej,
        'edit_content_rej' => $edit_content_rej,
        'email_reject_rej' => $email_reject_rej,
        'sequence_rej' => $sequence_rej,
        'status_approve_rej' => $status_approve_rej,
        'reject_step_rej' => $reject_step_rej,
      );

      // $result = true;
      if ($note != "") {
        $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
        $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";

        $query = $this->db->query("select u.*,u.roles,b.user_roles as recipient,email_approve,n.open_value from t_approval_itp_vendor m
        join m_notic n on n.id=m.email_approve
        join ( select id_itp,user_roles from t_approval_itp_vendor where sequence=".$sequence_rej." - ".$reject_step_rej.") b on b.id_itp=m.id_itp
        join m_user u on u.roles like CONCAT('%', b.user_roles ,'%')
        where m.sequence=".$sequence_rej." and m.id_itp = ".$id_itp_rej."");
        if ($query->num_rows() > 0) {
          $data_role = $query->result();
          $count = 0;
        } else {
          $query2 = $this->db->query("select u.*,u.roles,b.user_roles as recipient,email_approve,n.open_value from t_approval_itp_vendor m
          join m_notic n on n.id=m.email_approve
          join ( select id_itp,user_roles from t_approval_itp_vendor where sequence=".$sequence_rej.") b on b.id_itp=m.id_itp
          join m_user u on u.roles like CONCAT('%', b.user_roles ,'%')
          where m.sequence=".$sequence_rej." and m.id_itp = ".$id_itp_rej."");
          $data_role = $query2->result();
          $count = 0;
        }

        $content = $this->M_perform_itp_approval->get_email_dest($email_reject_rej);
        $res = $data_role;
        $str = ' '.$note.'<br>';

        $data = array(
            'img1' => $img1,
            'img2' => $img2,
            'title' => $content[0]->TITLE,
            'open' => str_replace("_var1_", $str, $content[0]->OPEN_VALUE),
            'close' => $content[0]->CLOSE_VALUE
        );

        foreach ($res as $k => $v) {
            $data['dest'][] = $v->EMAIL;
        }

        $flag = $this->sendMail($data);
        $respon = true;
      } else {
        $respon = false;
      }

      $send = $this->M_perform_itp_approval->reject_itp_doc($save_data);
      echo json_encode($send);
    }

    public function requestJDEInsertITP(){
      error_reporting(0);
      ini_set('display_errors', 0);
      $baseCurrency = base_currency();

      $result = true;

      $query_check_out = $this->db->query("select doc_no from i_sync where doc_type='srv_rcp' and isclosed=0 limit 1");
      if($query_check_out->num_rows()>0){
        $result_check = $query_check_out->result();
        $req_no = $result_check[0]->doc_no;
        $query = $this->db->query("SELECT
          v.id as ediDocumentNumber,
          v.receipt_date actualShipDate,
          m.id_company addressNumber,
          m.ID_COSTCENTER costCenter,
          v.id description,
          p.po_no as documentOrderInvoiceE,
          i.note nameRemark,
          i.itp_no reference2Vendor,
          w.id_warehouse,
          CASE WHEN p.po_type = 10 THEN 'OP'
          ELSE 'OS'
          END orderType,
          u.USERNAME as transactionOriginator
        FROM t_service_receipt v
          join t_itp i on i.id_itp=v.id_itp
          join t_purchase_order p on p.po_no=i.no_po and p.po_type = 20
          join t_msr m on m.msr_no=p.msr_no
          join m_costcenter c on c.ID_COSTCENTER=m.id_costcenter and c.ID_COMPANY=m.id_company
          join m_warehouse w on w.id_company = m.id_company
          join m_user u on u.ID_USER = p.create_by
        where v.id='".$req_no."'");
        $res = $query->result();
        $ediDocumentNumber = '1'.substr(str_repeat('0', 7).$res[0]->ediDocumentNumber, -7);
        $costCenter = substr(str_repeat(' ', 12).$res[0]->id_warehouse, -12);
        $parseDocumentOrderInvoiceE = explode('-', $res[0]->documentOrderInvoiceE);
        $ch_header = curl_init('https://10.1.1.94:91/PD910/F47071InManager?WSDL');
        $xml_post_string_header = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:orac="http://oracle.e1.bssv.JP57R71/">
          <soapenv:Header>
           <wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
             xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
             xmlns:env="http://schemas.xmlsoap.org/soap/envelope/"
             soapenv:mustUnderstand="1">
             <wsse:UsernameToken xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
               xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
               <wsse:Username>SCM</wsse:Username>
               <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">password</wsse:Password>
             </wsse:UsernameToken>
           </wsse:Security>
          </soapenv:Header>
          <soapenv:Body>
            <orac:F47071InManager>
              <!--isi tanggal penerimaan:-->
              <actualShipDate>'.$res[0]->actualShipDate.'T00:00:00-06:00</actualShipDate>
              <!--masukan address book 10101-->
              <addressNumber>
                <!--Optional:-->
                <value>'.$res[0]->addressNumber.'</value>
              </addressNumber>
              <!--Edit  Company:-->
              <companyKeyEdiOrder>'.$res[0]->addressNumber.'</companyKeyEdiOrder>
              <!--Company untuk PO service:-->
              <companyKeyOrderNo>'.$res[0]->addressNumber.'</companyKeyOrderNo>
              <!--Cost center PO service-->
              <costCenter>'.$costCenter.'</costCenter>
              <!--Tanggal trasaksi-->
              <dateTransactionJulian>'.$res[0]->actualShipDate.'T00:00:00-06:00</dateTransactionJulian>
              <!--deskripsi, isi no ITP -->
              <description>'.$res[0]->reference2Vendor.'</description>
              <!-- masukan no PO-->
              <documentOrderInvoiceE>
                <value>'.$parseDocumentOrderInvoiceE[0].'</value>
              </documentOrderInvoiceE>
              <!-- Nomor EDI (isi unik number sama dengan detail nya )-->
              <ediDocumentNumber>
                <value>'.$ediDocumentNumber.'</value>
              </ediDocumentNumber>
              <!--Tipe EDI (isi OV ):-->
              <ediDocumentType>OS</ediDocumentType>
              <!--isi R-->
              <ediSendRcvIndicator>R</ediSendRcvIndicator>
              <!--isi 861-->
              <ediTransactionSet>861</ediTransactionSet>
              <!--isi keterangan -->
              <nameRemark></nameRemark>
              <!-- isi 000-->
              <orderSuffix>000</orderSuffix>
              <!-- isi OP -->
              <orderType>'.$res[0]->orderType.'</orderType>
              <!--isi R-->
              <receivingAdviceType>R</receivingAdviceType>
              <!--isi keterangan 2-->
              <reference1></reference1>
              <!--isi Nomor ITP-->
              <reference2Vendor>'.$res[0]->reference2Vendor.'</reference2Vendor>
              <!--isi ADDRESSBOOK pembuat PO-->
              <transactionOriginator>'.$res[0]->transactionOriginator.'</transactionOriginator>
              <!--isi 02-->
              <transactionSetPurpose>02</transactionSetPurpose>
            </orac:F47071InManager>
          </soapenv:Body>
        </soapenv:Envelope>';

        $m_mat_item = $this->db->query("select c.CURRENCY,
          cb.CURRENCY_BASE,
          x.total_price_base,
          x.total_price,
          o.id_currency,
          o.id_currency_base,
          x.uom_desc as unitOfMeasureAsInput,
          x.line_no,
          m.service_receipt_no,
          d.id,
          d.id_material,
          d.qty,
          d.price,
          d.price_base,
          d.total,
          d.total_base,
          d.note
          from t_service_receipt m
            join t_service_receipt_detail d on d.id_service_receipt=m.id
            join t_itp i on i.id_itp=m.id_itp
            join t_purchase_order o on o.po_no=i.no_po
            join t_purchase_order_detail x on x.po_id=o.id and x.sop_bid_id = d.id_material
            join m_currency c on c.ID=o.id_currency
            join m_currency cb on cb.ID=o.id_currency_base
          where m.id='".$req_no."'");

        if($m_mat_item->num_rows()>0){
          $res_item = $m_mat_item->result();
          $counter_item = 1;
          foreach ($res_item as $k => $v) {
      $ch[$counter_item] = curl_init('https://10.1.1.94:91/PD910/F47072InManager?WSDL');
            $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:orac="http://oracle.e1.bssv.JP57R072/">
              <soapenv:Header>
                <wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
                  xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
                  xmlns:env="http://schemas.xmlsoap.org/soap/envelope/"
                  soapenv:mustUnderstand="1">
                  <wsse:UsernameToken xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
                    xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
                    <wsse:Username>SCM</wsse:Username>
                    <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">password</wsse:Password>
                  </wsse:UsernameToken>
                </wsse:Security>
              </soapenv:Header>
              <soapenv:Body>
                <orac:F47072InManager>
                  <!-- isi tanggal pengiriman -->
                  <actualShipDate>'.$res[0]->actualShipDate.'T00:00:00-06:00</actualShipDate>
                  <!-- USD yang di bayarkan -->
                  <amountExtendedCost>0</amountExtendedCost>
                  <!--USD yang di bayarkan -->
                  <amountExtendedPrice>0</amountExtendedPrice>
                  <!--IDR yang di bayarkan -->
                  <amountForeignExtCost>0</amountForeignExtCost>
                  <!--IDR yang di bayarkan -->
                  <amountForeignExtPrice>0</amountForeignExtPrice>
                  <!--USD yang di bayarkan -->
                  <amountReceived>'.(($v->id_currency == $baseCurrency) ? $v->total : 0).'</amountReceived>
                  <!--IDR yang di bayarkan -->
                  <amountReceivedForeign>'.(($v->id_currency == $baseCurrency) ? 0 : $v->total).'</amountReceivedForeign>
                  <!--ABAD-->
                  <century>
                    <value>'.ceil(intval(substr($res[0]->actualShipDate,0,4))/100).'</value>
                  </century>
                  <!--Company:-->
                  <company>'.$res[0]->addressNumber.'</company>
                  <!--CompanyEdi-->
                  <companyKeyEdiOrder>'.$res[0]->addressNumber.'</companyKeyEdiOrder>
                  <!--Company Key PO Service-->
                  <companyKeyOrderNo>'.$res[0]->addressNumber.'</companyKeyOrderNo>
                  <!--CostCenter PO Service-->
                  <costCenter>'.$costCenter.'</costCenter>
                  <!--Mata Uang-->
                  <currencyCodeFrom>'.$v->CURRENCY.'</currencyCodeFrom>
                  <!--Kurs Rupiah-->
                  <currencyConverRateOv>0</currencyConverRateOv>
                  <!--Tanggal Transaksi -->
                  <dateTransactionJulian>'.$res[0]->actualShipDate.'T00:00:00-06:00</dateTransactionJulian>
                  <!--Deskripsi ( masukan nomor ITP )-->
                  <descriptionLine1>'.$res[0]->reference2Vendor.'</descriptionLine1>
                  <!--Deskripsi 2 -->
                  <descriptionLine2>'.$v->note.'</descriptionLine2>
                  <!-- Nomor PO service -->
                  <documentOrderInvoiceE>
                    <value>'.$parseDocumentOrderInvoiceE[0].'</value>
                  </documentOrderInvoiceE>
                  <!-- Nomor EDI (isi unik number sama dengan header nya )-->
                  <ediDocumentNumber>
                    <value>'.$ediDocumentNumber.'</value>
                  </ediDocumentNumber>
                  <!-- Tipe EDI (isi OV )-->
                  <ediDocumentType>OS</ediDocumentType>
                  <!-- isi line number (inkrement 1 , 2, 3 ,... ) -->
                  <ediLineNumber>'.$counter_item.'</ediLineNumber>
                  <!-- isi R -->
                  <ediSendRcvIndicator>R</ediSendRcvIndicator>
                  <!-- isi 861 -->
                  <ediTransactionSet>861</ediTransactionSet>
                  <!-- isi Tahun -->
                  <fiscalYear1>
                    <value>'.substr($res[0]->actualShipDate,2,2).'</value>
                  </fiscalYear1>
                  <!--isi NS40-->
                  <glClass>NS40</glClass>
                  <!-- isi AA klo Dollar, isi CA klo IDR -->
                  <ledgerType>AA</ledgerType>
                  <!--Optional:-->
                  <lineItemStatusCode>1</lineItemStatusCode>
                  <!-- isi nomor baris detail PO Service -->
                  <lineNumber>'.$v->line_no.'</lineNumber>
                  <!-- isi J -->
                  <lineType></lineType>
                  <!-- isi 000-->
                  <orderSuffix>000</orderSuffix>
                  <!-- isi OP -->
                  <orderType>'.$res[0]->orderType.'</orderType>
                  <!-- isi data keterangan -->
                  <reference1>'.$v->service_receipt_no.'</reference1>
                  <!--isi Nomor ITP-->
                  <reference2Vendor>'.$res[0]->reference2Vendor.'</reference2Vendor>
                  <!--isi EA-->
                  <unitOfMeasureAsInput>'.$v->unitOfMeasureAsInput.'</unitOfMeasureAsInput>
                  <!--isi EA-->
                  <unitOfMeasurePurchas>'.$v->unitOfMeasureAsInput.'</unitOfMeasurePurchas>
                  <unitsLineItemQtyRe>
                    <!--isi quantity recive klo ada qty nya -->
                    <value>'.$v->qty.'</value>
                  </unitsLineItemQtyRe>
                </orac:F47072InManager>
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

            curl_setopt($ch[$counter_item], CURLOPT_HEADER, true);
            curl_setopt($ch[$counter_item], CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch[$counter_item], CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch[$counter_item], CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch[$counter_item], CURLOPT_SSLVERSION, 'all');
            curl_setopt($ch[$counter_item], CURLOPT_VERBOSE, true);
            curl_setopt($ch[$counter_item], CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch[$counter_item], CURLOPT_POSTFIELDS, $xml_post_string);
            curl_setopt($ch[$counter_item], CURLOPT_CONNECTTIMEOUT,300);
            curl_setopt($ch[$counter_item], CURLOPT_TIMEOUT,360);

            if ($this->input->get('action') <> 'get_xml_code') {
              $data_curl2 = curl_exec($ch[$counter_item]);
              curl_close($ch[$counter_item]);
              if (strpos($data_curl2, 'HTTP/1.1 200 OK') !== false) {
                echo "Berhasil Exec JDE Item ".$counter_item." -  Doc No ".$req_no." at ".date("Y-m-d H:i:s");
              }else{
                echo "Gagal Exec JDE MR Item ".$counter_item." -  Doc No ".$req_no." at ".date("Y-m-d H:i:s");
              }
            } else {
              echo $xml_post_string;
              echo '<!--Line Item '.$counter_item.'--!>';
            }
            $counter_item++;
          }

          $headers = array(
            #"Content-type: application/soap+xml;charset=\"utf-8\"",
            "Content-Type: text/xml",
            "charset:utf-8",
            "Accept: application/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "Content-length: " . strlen($xml_post_string_header),
          );

          curl_setopt($ch_header, CURLOPT_HEADER, true);
          curl_setopt($ch_header, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch_header, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($ch_header, CURLOPT_SSL_VERIFYHOST, false);
          curl_setopt($ch_header, CURLOPT_SSLVERSION, 'all');
          curl_setopt($ch_header, CURLOPT_VERBOSE, true);
          curl_setopt($ch_header, CURLOPT_HTTPHEADER, $headers);
          curl_setopt($ch_header, CURLOPT_POSTFIELDS, $xml_post_string_header);
          if ($this->input->get('action') <> 'get_xml_code') {
            $data_curl = curl_exec($ch_header);
            curl_close($ch);
            if (strpos($data_curl, 'HTTP/1.1 200 OK') === false) {
              echo "Gagal Exec JDE MR Header -  Doc No ".$req_no." at ".date("Y-m-d H:i:s");
            } else {
              $query_update = $this->db->query("update i_sync set isclosed=1,updatedate=now() where doc_type='srv_rcp' and doc_no='".$req_no."' and isclosed=0");
            }
          } else {
            echo $xml_post_string_header;
            echo '<!--Header-->';
          }
        }
      } else{
        echo "Execute MR Status Service Receipt at ".date("Y-m-d H:i:s");
      }
      $data_log['script_type'] = 'srv_rcp';
      $this->db->insert('i_sync_log',$data_log);
      $this->db->close();
    }

    public function requestJDEcheckSR(){
      ini_set('max_execution_time', 300);
      error_reporting(0);
      ini_set('display_errors', 0);

      $rs_sr = $this->db->where('id_external', null)
      ->get('t_service_receipt')
      ->result();
      $SYEDOCS = array();
      foreach ($rs_sr as $sr) {
        $SYEDOCS[] = (int) ('1'.substr('0000000'.$sr->id, -7));
      }

      if (count($SYEDOCS)) {
        $jde = $this->load->database('oracle', TRUE);
        $F47071 = $jde->select('DISTINCT F0911.GLDOC, F0911.GLDCT, F0911.GLKCO, F47071.SYEDOC, F47071.SYEDBT', false)
        ->join('F0911', 'F0911.GLICU = CAST(F47071.SYEDBT AS NUMBER)')
        ->where_in('F47071.SYEDOC', $SYEDOCS)
        ->where('TRIM(F47071.SYEDBT)IS NOT NULL')
        ->get('F47071')
        ->result();

        foreach ($F47071 as $row) {
          $sr_id = $row->SYEDOC - 10000000;
          $id_external = $row->GLDOC.'-'.$row->GLDCT.'-'.$row->GLKCO;
          $this->db->where('id', $sr_id)->update('t_service_receipt', array('id_external' => $id_external));
        }
      }

      $query_check_lastexec = $this->db->query(" select DATE_FORMAT(CAST(max(DATE_ADD(COALESCE(execute_time,now()), INTERVAL 5 MINUTE)) as DATE),'%Y-%m-%d') as exectime from i_sync_log where script_type='stat_srv_rcp' ");
      $extime = $query_check_lastexec->result();

      //.$extime[0]->exectime.

      if($query_check_lastexec->num_rows()>0){
        $ch = curl_init('https://10.1.1.94:91/PD910/F47072SelManager?WSDL');
        $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:orac="http://oracle.e1.bssv.JP57R72Q/">
<soapenv:Header>
   <wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
     xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
     xmlns:env="http://schemas.xmlsoap.org/soap/envelope/"
     soapenv:mustUnderstand="1">
     <wsse:UsernameToken xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
       xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
       <wsse:Username>SCM</wsse:Username>
       <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">password</wsse:Password>
     </wsse:UsernameToken>
   </wsse:Security>
 </soapenv:Header>
   <soapenv:Body>
      <orac:F47072SelManager>

         <!--Optional:-->
         <company>10101</company>

         <!--Optional:-->
          <dateTransactionJulian>'.$extime[0]->exectime.'T00:00:00+07:00</dateTransactionJulian>

          <!--Optional:-->

      </orac:F47072SelManager>
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

        $data_curl = curl_exec($ch);
        curl_close($ch);

        if (strpos($data_curl, 'HTTP/1.1 200 OK') !== false) {
          echo "Execute MR Status at ".date("Y-m-d H:i:s")." get data date ".$extime[0]->exectime;
          $a=$data_curl;

          $lastpos = 0;$lastposclose = 0;
          $content = '';
          for($i=0;$i<100;$i++){
            if ((strpos($a, '<queryResults xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="ns0:f47072_Select">') !== false)) {
              $lastpos = strpos($a, '<queryResults xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="ns0:f47072_Select">');
              $lastposclose = strpos($a, '</queryResults>');
              $content = substr($a,$lastpos,($lastposclose-$lastpos));

              $doc_no = "0";

              $actualqtypos = (strpos($content,'<ediSuccessfullyProcess>Y</ediSuccessfullyProcess>'));
              if($actualqtypos !== false){
                  $actualqtypos = (strpos($content,'<ediDocumentNumber>'));
                  $actualqtyposclose = (strpos($content,'</ediDocumentNumber>'));
                  if($actualqtypos !== false){
                      $actqtystr = substr($content,$actualqtypos,($actualqtyposclose-$actualqtypos));

                      $actqtypos = (strpos($actqtystr,'<value>'));
                      $actqtyposclose = (strpos($actqtystr,'</value>'));

                      $doc_no = substr($actqtystr,($actqtypos+strlen('<value>')),($actqtyposclose-($actqtypos+strlen('<value>'))));
                        //echo $actqty.'<br><br>';
                      $this->db->query("update t_service_receipt set status=1,updated_at=now() where status=0 and id='".$doc_no."' ");

                  }
              }

              $a = substr($a,$lastposclose+strlen('</queryResults>'),strlen($a));
              //echo $content.'<br><br>';
            }
          }
        }else{
          echo "Execute MR Status Failed at ".date("Y-m-d H:i:s");
        }
      }


      echo "Execute Status SR at ".date("Y-m-d H:i:s");
      $data_log['script_type'] = 'stat_srv_rcp';
      $this->db->insert('i_sync_log',$data_log);
      $this->db->close();
    }

    public function requestJDEcheckSRRJ(){
      ini_set('max_execution_time', 300);
      error_reporting(0);
      ini_set('display_errors', 0);

      $query_check_lastexec = $this->db->query(" select DATE_FORMAT(CAST(max(DATE_ADD(COALESCE(execute_time,now()), INTERVAL 5 MINUTE)) as DATE),'%Y-%m-%d') as exectime from i_sync_log where script_type='stat_srv_rcp' ");
      $extime = $query_check_lastexec->result();

      //

      if($query_check_lastexec->num_rows()>0){
        $ch = curl_init('https://10.1.1.94:91/PD910/F47072SelManager?WSDL');
        $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:orac="http://oracle.e1.bssv.JP57R72Q/">
<soapenv:Header>
   <wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
     xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
     xmlns:env="http://schemas.xmlsoap.org/soap/envelope/"
     soapenv:mustUnderstand="1">
     <wsse:UsernameToken xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
       xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
       <wsse:Username>SCM</wsse:Username>
       <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">password</wsse:Password>
     </wsse:UsernameToken>
   </wsse:Security>
 </soapenv:Header>
   <soapenv:Body>
      <orac:F47072SelManager>

         <!--Optional:-->
         <company>10102</company>

         <!--Optional:-->
          <dateTransactionJulian>'.$extime[0]->exectime.'T00:00:00+07:00</dateTransactionJulian>

          <!--Optional:-->

      </orac:F47072SelManager>
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

        $data_curl = curl_exec($ch);
        curl_close($ch);


        if (strpos($data_curl, 'HTTP/1.1 200 OK') !== false) {
          echo "Execute MR Status at ".date("Y-m-d H:i:s")." get data date ".$extime[0]->exectime;
          $a=$data_curl;

          $lastpos = 0;$lastposclose = 0;
          $content = '';
          for($i=0;$i<100;$i++){
            if ((strpos($a, '<queryResults xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="ns0:f47072_Select">') !== false)) {
              $lastpos = strpos($a, '<queryResults xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="ns0:f47072_Select">');
              $lastposclose = strpos($a, '</queryResults>');
              $content = substr($a,$lastpos,($lastposclose-$lastpos));

              $doc_no = "0";

              $actualqtypos = (strpos($content,'<ediSuccessfullyProcess>Y</ediSuccessfullyProcess>'));
              if($actualqtypos !== false){
                  $actualqtypos = (strpos($content,'<ediDocumentNumber>'));
                  $actualqtyposclose = (strpos($content,'</ediDocumentNumber>'));
                  if($actualqtypos !== false){
                      $actqtystr = substr($content,$actualqtypos,($actualqtyposclose-$actualqtypos));

                      $actqtypos = (strpos($actqtystr,'<value>'));
                      $actqtyposclose = (strpos($actqtystr,'</value>'));

                      $doc_no = substr($actqtystr,($actqtypos+strlen('<value>')),($actqtyposclose-($actqtypos+strlen('<value>'))));
                        //echo $actqty.'<br><br>';
                      $this->db->query("update t_service_receipt set status=1,updated_at=now() where status=0 and id='".$doc_no."' ");

                  }
              }

              $a = substr($a,$lastposclose+strlen('</queryResults>'),strlen($a));
              //echo $content.'<br><br>';
            }
          }
        }else{
          echo "Execute MR Status Failed at ".date("Y-m-d H:i:s");
        }
      }


      echo "Execute Status SR at ".date("Y-m-d H:i:s");
      $data_log['script_type'] = 'stat_srv_rcp';
      $this->db->insert('i_sync_log',$data_log);
      $this->db->close();
    }

    public function requestJDEcheckSRRD(){
      ini_set('max_execution_time', 300);
      error_reporting(0);
      ini_set('display_errors', 0);

      $query_check_lastexec = $this->db->query(" select DATE_FORMAT(CAST(max(DATE_ADD(COALESCE(execute_time,now()), INTERVAL 5 MINUTE)) as DATE),'%Y-%m-%d') as exectime from i_sync_log where script_type='stat_srv_rcp' ");
      $extime = $query_check_lastexec->result();

      //

      if($query_check_lastexec->num_rows()>0){
        $ch = curl_init('https://10.1.1.94:91/PD910/F47072SelManager?WSDL');
        $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:orac="http://oracle.e1.bssv.JP57R72Q/">
<soapenv:Header>
   <wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
     xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
     xmlns:env="http://schemas.xmlsoap.org/soap/envelope/"
     soapenv:mustUnderstand="1">
     <wsse:UsernameToken xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
       xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
       <wsse:Username>SCM</wsse:Username>
       <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">password</wsse:Password>
     </wsse:UsernameToken>
   </wsse:Security>
 </soapenv:Header>
   <soapenv:Body>
      <orac:F47072SelManager>

         <!--Optional:-->
         <company>10103</company>

         <!--Optional:-->
          <dateTransactionJulian>'.$extime[0]->exectime.'T00:00:00+07:00</dateTransactionJulian>

          <!--Optional:-->

      </orac:F47072SelManager>
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

        $data_curl = curl_exec($ch);
        curl_close($ch);


        if (strpos($data_curl, 'HTTP/1.1 200 OK') !== false) {
          echo "Execute MR Status at ".date("Y-m-d H:i:s")." get data date ".$extime[0]->exectime;
          $a=$data_curl;

          $lastpos = 0;$lastposclose = 0;
          $content = '';
          for($i=0;$i<100;$i++){
            if ((strpos($a, '<queryResults xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="ns0:f47072_Select">') !== false)) {
              $lastpos = strpos($a, '<queryResults xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="ns0:f47072_Select">');
              $lastposclose = strpos($a, '</queryResults>');
              $content = substr($a,$lastpos,($lastposclose-$lastpos));

              $doc_no = "0";

              $actualqtypos = (strpos($content,'<ediSuccessfullyProcess>Y</ediSuccessfullyProcess>'));
              if($actualqtypos !== false){
                  $actualqtypos = (strpos($content,'<ediDocumentNumber>'));
                  $actualqtyposclose = (strpos($content,'</ediDocumentNumber>'));
                  if($actualqtypos !== false){
                      $actqtystr = substr($content,$actualqtypos,($actualqtyposclose-$actualqtypos));

                      $actqtypos = (strpos($actqtystr,'<value>'));
                      $actqtyposclose = (strpos($actqtystr,'</value>'));

                      $doc_no = substr($actqtystr,($actqtypos+strlen('<value>')),($actqtyposclose-($actqtypos+strlen('<value>'))));
                        //echo $actqty.'<br><br>';
                      $this->db->query("update t_service_receipt set status=1,updated_at=now() where status=0 and id='".$doc_no."' ");

                  }
              }

              $a = substr($a,$lastposclose+strlen('</queryResults>'),strlen($a));
              //echo $content.'<br><br>';
            }
          }
        }else{
          echo "Execute MR Status Failed at ".date("Y-m-d H:i:s");
        }
      }


      echo "Execute Status SR at ".date("Y-m-d H:i:s");
      $data_log['script_type'] = 'stat_srv_rcp';
      $this->db->insert('i_sync_log',$data_log);
      $this->db->close();
    }

}
