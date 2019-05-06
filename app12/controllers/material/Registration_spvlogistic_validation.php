<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Registration_spvlogistic_validation extends CI_Controller {

  public $itemNumber = "";

    public function __construct() {
        parent::__construct();
        $this->load->model('material/M_registration')->model('vendor/M_vendor');
        $this->load->helper(array('string', 'text'));
        $this->load->helper('helperx_helper');
    }


    public function index(){
      $tamp = $this->M_registration->show();
      $get_menu = $this->M_vendor->menu();
      $get_uom = $this->M_registration->material_uom();
      $get_mgroup = $this->M_registration->material_group();
      $get_mindicator = $this->M_registration->material_indicator();
      $get_mstockclass = $this->M_registration->m_material_stock_class();
      $get_mavailable = $this->M_registration->m_material_availability();
      $get_mcritical = $this->M_registration->m_material_cricatility();

      $data['total'] = count($tamp);
      $dt = array();
      $res_uom = array();
      $res_mgroup = array();
      $res_mindicator = array();
      $res_mstockclass = array();
      $res_mavailable = array();
      $res_mcritical = array();

      foreach ($get_mcritical as $arr) {
        $res_mcritical[] = array(
          'id' => $arr['ID'],
          'desc_in' => $arr['DESCRIPTION_IND'],
          'desc_en' => $arr['DESCRIPTION_ENG'],
        );
      }
      foreach ($get_mavailable as $arr) {
        $res_mavailable[] = array(
          'id' => $arr['ID'],
          'desc_in' => $arr['DESCRIPTION_IND'],
          'desc_en' => $arr['DESCRIPTION_ENG'],
        );
      }

      foreach ($get_mstockclass as $arr) {
        $res_mstockclass[] = array(
          'id' => $arr['ID'],
          'desc_in' => $arr['DESCRIPTION_IND'],
          'desc_en' => $arr['DESCRIPTION_ENG'],
        );
      }

      foreach ($get_mindicator as $arr) {
        $res_mindicator[] = array(
          'id' => $arr['ID'],
          'desc_in' => $arr['DESCRIPTION_IND'],
          'desc_en' => $arr['DESCRIPTION_ENG'],
        );
      }

      foreach ($get_mgroup as $arr) {
        $res_mgroup[] = array(
          'id' => $arr['ID'],
          'material_group' => $arr['MATERIAL_GROUP'],
          'type' => $arr['TYPE'],
        );
      }

      foreach ($get_uom as $arr) {
        $res_uom[] = array(
          'id' => $arr['ID'],
          'material_uom' => $arr['MATERIAL_UOM'],
        );
      }

      foreach ($get_menu as $k => $v) {
          $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
          $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
          $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
          $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
      }

      $data['material_criticaly'] = $res_mcritical;
      $data['material_avalable'] = $res_mavailable;
      $data['material_stackclass'] = $res_mstockclass;
      $data['material_uom'] = $res_uom;
      $data['material_group'] = $res_mgroup;
      $data['material_indicator'] = $res_mindicator;
      $data['menu'] = $dt;
      $this->template->display('material/V_registration_spvlogistic_validation', $data);
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
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

    public function datatable_persetujuan_material() {
      $data = $this->M_registration->datatable_persetujuan_material();
      $result = array();
      $no = 1;

      foreach ($data as $arr) {
        if ($arr['STATUS'] == '3') {
          $str = '<center><button data-id="'.$arr['MATERIAL'].'" id="prosesreq" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-primary" title="Update"><i class=""> Proses</i></button> <button data-id="'.$arr['MATERIAL'].'" id="prosesreq" data-toggle="modal" data-target="#modal_rej" class="btn btn-sm btn-danger" title="Update"><i class=""> Reject</i></button></center>';
          $class = 'success';
        } elseif ($arr['STATUS'] == '4') {
          $class = 'primary';
          $str = '<center> - </center>';
        } else {
          $str = '<center> - </center>';
          $class = 'danger';
        }

        $result[] = array(
          0 => '<center>'.$no.'</center>',
          1 => '<center>'.$arr['REQUEST_NO'].'</center>',
          2 => '<center>'.$arr['MATERIAL_NAME'].'</center>',
          3 => '<center>'.$arr['UOM1'].'</center>',
          4 => '<center><span class="badge badge badge-pill badge-'.$class.'">'.$arr['DESCRIPTION_IND'].'</span></center>',
          5 => $str
        );
        $no++;
      }
      echo json_encode($result);
    }

    public function material_code(){
      $idnya = (!empty($_GET['idnya'])?$_GET['idnya']:"");
      $respon = array();
      $data = $this->M_registration->material_code($idnya);
      $maxid = $this->M_registration->select_max_material();

      foreach ($data as $arr) {
        $respon = array(
          'group' => $arr['EQPMENT_ID'],
          'sub_group' => $arr['MANUFACTURER'],
          'subsub_group' => $arr['MATERIAL_TYPE'],
          'sequence_group' => $arr['SEQUENCE_GROUP'],
          'indicator_group' => $arr['INDICATOR'],
          'max_id' => $maxid
        );
      }
      // $respon['data'] = $data[0]['EQPMENT_ID'];
      echo json_encode($respon, JSON_PRETTY_PRINT);
    }

    public function approve_request_material(){
      $idnya = (!empty($_POST['idnya'])?$_POST['idnya']:"");
      $note = (!empty($_POST['note'])?$_POST['note']:"");
      $kodematerial = (!empty($_POST['kodematerial'])?$_POST['kodematerial']:"");

      $save_data = array(
        'idnya' => $idnya,
        'note' => $note,
        'user' => $this->session->userdata['ID_USER'],
        'kodematerial' => $kodematerial
      );

      $data_jde = array(
                    'MATERIAL_NAME' => stripslashes($_POST['MATERIAL_NAME']),
                    'DESCRIPTION' => stripslashes($_POST['DESCRIPTION']),
                    'MATERIAL_CODE' => stripslashes($kodematerial), //id angka
                    'ID' => stripslashes($_POST['ID']),
                    'UOM' => stripslashes($_POST['UOM'])
                );

     $toJDE = $this->change_jde($data_jde); //upload_JDE
     $resultExec = true;
     if($toJDE){

       if ($note != "") {
         $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
         $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";

         $content = $this->M_registration->get_email_dest(13);
         $content[0]->ROLES = explode(",", $content[0]->ROLES);
         $res = $this->M_registration->get_user($content[0]->ROLES, count($content[0]->ROLES));
         $str = '<br>'.$note;

         $data = array(
             'img1' => $img1,
             'img2' => $img2,
             'title' => $content[0]->TITLE,
             'open' => str_replace("deskripsinya", $str, $content[0]->OPEN_VALUE),
             'close' => $content[0]->CLOSE_VALUE
         );
         foreach ($res as $k => $v) {
             $data['dest'][] = $v->EMAIL;
         }
         $flag = $this->sendMail($data);
       }

       $result = $this->M_registration->approve_request_material($save_data);
       $resultExec = true;
      // $query = $this->db->query("SELECT MATERIAL_CODE FROM m_material WHERE MATERIAL = '".$idnya."' LIMIT 1");
      // $save_data['kodematerial'] = $query->row()->MATERIAL_CODE;
     }else{
       $resultExec = false;
     }

      echo json_encode($resultExec);
    }

  public function change_jde($data) {
    /**$this->load->library('nusoap-0.9.5/lib/Nusoap_lib');
    //require_once('nusoap.php');
    $proxyhost = '';
    $proxyport = '';
    $proxyusername = 'SCM';
    $proxypassword = 'password';
    $useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
    $client = new nusoap_client('https://10.1.1.94:91/PD910/InventoryManager?wsdl', true,
                $proxyhost, $proxyport, $proxyusername, $proxypassword);

    $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:orac="http://oracle.e1.bssv.JP410000/">
              <soapenv:Header>
                  <wsse:Security
                      xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
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
                  <orac:processInventoryItem>
                   <!--Optional:-->
                   <daysShelfLife>25</daysShelfLife>
                   <!--Optional:-->
                   <description1>' . $data['MATERIAL_NAME'] . '</description1>
                   <!--Optional:-->
                   <description2>' . $data['MATERIAL_NAME'] . '</description2>
                   <!--Optional:-->
                   <glClassCode>IN50</glClassCode>
                   <!--Optional:-->
                   <item>
                    <!--Optional:-->
                    <itemCatalog>' . $data['MATERIAL_CODE'] . '</itemCatalog>
                    <!--Optional:-->
                    <!--<itemFreeForm>?</itemFreeForm>-->
                    <!--Optional:-->
                    <itemId>' . $data['ID'] . '</itemId>
                    <!--Optional:-->
                    <!--<itemProduct>?</itemProduct>-->
                    <!--Optional:-->
                    <!--<itemSupplier>?</itemSupplier>-->>
                   </item>
                   <!--Optional:-->
                   <itemDimensions>
                    <!--Optional:-->
                    <unitOfMeasureCodePrimary>' . $data['UOM'] . '</unitOfMeasureCodePrimary>
                    <!--Optional:-->
                    <unitOfMeasureCodeVolume>' . $data['UOM'] . '</unitOfMeasureCodeVolume>
                    <!--Optional:-->
                    <unitOfMeasureCodeWeight>' . $data['UOM'] . '</unitOfMeasureCodeWeight>
                   </itemDimensions>
                   <!--Optional:-->
                   <lineTypeCode>S</lineTypeCode>
                   <!--Optional:-->
                   <!--<lotProcessCode>?</lotProcessCode>-->
                   <!--Optional:-->
                   <!--<lotStatusCode>?</lotStatusCode>-->
                   <!--Optional:-->
                   <processing>
                    <!--Optional:-->
                    <actionTypeCode>A</actionTypeCode>
                    <!--Optional:-->
                    <version>ZJDE001</version>
                   </processing>
                   <searchText>' . $data['MATERIAL_NAME'] . '</searchText>
                   <searchTextCompressed>' . $data['MATERIAL_NAME'] . '</searchTextCompressed>
                   <!--Optional:-->
                   <serialNumberFlag>N</serialNumberFlag>
                   <!--Optional:-->
                   <stockingTypeCode>S</stockingTypeCode>
                  </orac:processInventoryItem>
                 </soapenv:Body>
              </soapenv:Envelope>';




    //$err = $client->getError();
    //if ($err) {
      //echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
    //  return false;
    //}
    $client->setUseCurl($useCURL);
    $result = $client->send($xml_post_string, '');
    if ($client->fault) {
      return false;
      //echo '<h2>Fault</h2><pre>';
      //print_r($result);
      //echo '</pre>';
    } else {
      //$err = $client->getError();
      //if ($err) {
        //echo '<h2>Error</h2><pre>' . $err . '</pre>';
      //  return false;
      //} else {
        //echo '<h2>Result</h2><pre>';
        //print_r($result);
        //echo '</pre>';
        //$itemNumber = $result['itemId'];
        return true;
      //}
    }
    //echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
    //echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';


        echopre($result);**/
        // exit;

        $ch = curl_init('https://10.1.1.94:91/PD910/InventoryManager');
        $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:orac="http://oracle.e1.bssv.JP410000/">
              <soapenv:Header>
                  <wsse:Security
                      xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
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
                  <orac:processInventoryItem>
                   <!--Optional:-->
                   <daysShelfLife>25</daysShelfLife>
                   <!--Optional:-->
                   <description1>' . $data['MATERIAL_NAME'] . '</description1>
                   <!--Optional:-->
                   <description2>' . $data['MATERIAL_NAME'] . '</description2>
                   <!--Optional:-->
                   <glClassCode>IN50</glClassCode>
                   <!--Optional:-->
                   <item>
                    <!--Optional:-->
                    <itemCatalog>' . $data['MATERIAL_CODE'] . '</itemCatalog>
                    <!--Optional:-->
                    <!--<itemFreeForm>?</itemFreeForm>-->
                    <!--Optional:-->
                    <itemId>' . $data['ID'] . '</itemId>
                    <!--Optional:-->
                    <!--<itemProduct>?</itemProduct>-->
                    <!--Optional:-->
                    <!--<itemSupplier>?</itemSupplier>-->>
                   </item>
                   <!--Optional:-->
                   <itemDimensions>
                    <!--Optional:-->
                    <unitOfMeasureCodePrimary>' . $data['UOM'] . '</unitOfMeasureCodePrimary>
                    <!--Optional:-->
                    <unitOfMeasureCodeVolume>' . $data['UOM'] . '</unitOfMeasureCodeVolume>
                    <!--Optional:-->
                    <unitOfMeasureCodeWeight>' . $data['UOM'] . '</unitOfMeasureCodeWeight>
                   </itemDimensions>
                   <!--Optional:-->
                   <lineTypeCode>S</lineTypeCode>
                   <!--Optional:-->
                   <!--<lotProcessCode>?</lotProcessCode>-->
                   <!--Optional:-->
                   <!--<lotStatusCode>?</lotStatusCode>-->
                   <!--Optional:-->
                   <processing>
                    <!--Optional:-->
                    <actionTypeCode>A</actionTypeCode>
                    <!--Optional:-->
                    <version>ZJDE001</version>
                   </processing>
                   <searchText>' . $data['MATERIAL_NAME'] . '</searchText>
                   <searchTextCompressed>' . $data['MATERIAL_NAME'] . '</searchTextCompressed>
                   <!--Optional:-->
                   <serialNumberFlag>N</serialNumberFlag>
                   <!--Optional:-->
                   <stockingTypeCode>S</stockingTypeCode>
                  </orac:processInventoryItem>
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

        $data_curl = curl_exec($ch);
        curl_close($ch);

    if (strpos($data_curl, 'HTTP/1.1 200 OK') !== false) {
      $itemNumber = substr($data_curl,strpos($data_curl,'<itemId>')+8,((strpos($data_curl,'</itemId>'))-(strpos($data_curl,'<itemId>')+8)));

        $text = strip_tags($data['DESCRIPTION']);

        $str = '';
        $str2 = ' ';
        if(strlen($text)>500){
        $text = substr($text,0,500);
        $arr =  explode(" ", $text);

        //print all the value which are in the array
        foreach($arr as $v){
          if(strlen($str)<225){
          $str = $str .' '. $v;
          }else{
          $str2 = $str2 .' '. $v;
          }
        }

        }else{
        $str = $text;
        }

        // Insert Long description
        $ch = curl_init('https://10.1.1.94:91/PD910/F554101AddManager');
        $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:orac="http://oracle.e1.bssv.JP554101/">
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
      <orac:AddF554101>
         <NODETEXT>'.$str.'</NODETEXT>
         <NOTES>'.$str2.'</NOTES>
         <identifierShortItem>
            <value>'.$itemNumber.'</value>
         </identifierShortItem>
      </orac:AddF554101>
   </soapenv:Body>
</soapenv:Envelope>
';
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

        $data_curl = curl_exec($ch);
        curl_close($ch);

        if (strpos($data_curl, 'HTTP/1.1 200 OK') !== false) {
          return true;
        }else{
          return false;
        }
    }else{
      return false;
    }
    }

}
