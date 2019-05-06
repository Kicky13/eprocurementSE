<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('coba/M_home');
    }

    public function index() {
        $get_menu = $this->M_home->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $this->template->display('coba/V_home', $data);
    }

    public function show() {
        $data = $this->M_home->show();
        $dt = array();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->ID_SUPPLIER);
            $dt[$k][2] = stripslashes($v->NAME_SUPPLIER);
            $dt[$k][3] = stripslashes($v->EMAIL_SUPPLIER);
            $dt[$k][4] = stripslashes($v->ADDRESS_1);
            $dt[$k][5] = stripslashes($v->NPWP);
            $dt[$k][6] = 'AKTIVE';
            $dt[$k][7] = 'AKTIVE';
            $dt[$k][8] = "<a class='btn btn-info btn-sm' title='Update' href='javascript:void(0)' onclick='edit_undangan(" . $v->ID_SUPPLIER . ")'><i class='fa fa-edit'></i></a>";
        }
        echo json_encode($dt);
    }

    public function add_supplier() {    
       $data = array(
            'ID_SUPPLIER' => strtoupper(stripslashes($_POST['id_suplier'])),
            'NAME_SUPPLIER' => stripslashes($_POST['nama_suplier']),
            'EMAIL_SUPPLIER' => stripslashes(($_POST['email_suplier'])),
            'NPWP' => stripslashes($_POST['npwp_suplier']),
            'PHONE' => $_POST['phone'],
            'ADDRESS_1' => stripcslashes($_POST['addresline1']),
            'ADDRESS_2' => stripcslashes($_POST['addresline2']),
            'CITY' => stripcslashes($_POST['kota']),
            'COUNTRY' => stripcslashes($_POST['kode_negara']),
            'CREATE_TIME' => date('Y-m-d H:i:s'),
            'CREATED_BY'=> $this->session->ID
        );
       $res=$this->M_home->add($data);
       echo $res;
}

    public function to_xml($post) {
        $ch = curl_init('https://10.1.1.94:91/PD910/AddressBookManager?WSDL');
        $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:orac="http://oracle.e1.bssv.JP010000/">
            <soapenv:Header> 
                <wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" xmlns:env="http://schemas.xmlsoap.org/soap/envelope/" soapenv:mustUnderstand="1">
                    <wsse:UsernameToken xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
                        <wsse:Username>SCM</wsse:Username>   
                        <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">password</wsse:Password>  
                    </wsse:UsernameToken>
                </wsse:Security>
            </soapenv:Header>
            <soapenv:Body>
                <orac:processAddressBook>
                <!--Optional:-->
                <addressBook>
                    <!--Optional:-->
                    <address>
                        <!--Optional:-->
                        <addressLine1>'.$_POST['alamat'].'</addressLine1>
                        <!--Optional:-->
                        <addressLine2>Bojonegoro</addressLine2>
                        <!--Optional:-->
                        <city>JAKARTA</city>
                        <!--Optional:-->
                        <countryCode>ID</countryCode>
                    </address>
                    <!--Optional:-->
                    <businessUnit>'.$_POST['id_vendor'].'</businessUnit>
                    <!--Optional:-->
                    <electronicAddresses>
                        <!--Optional:-->
                        <actionType>1</actionType>
                        <!--Optional:-->
                        <contactId>0</contactId>
                        <!--Optional:-->
                        <electronicAddress>'.$_POST['email'].'</electronicAddress>
                        <!--Optional:-->
                        <electronicAddressTypeCode>E</electronicAddressTypeCode>
                    </electronicAddresses>
 
                    <entity>
                        <!--Optional:-->
                        <entityId>1300013</entityId>
                        <!--Optional:-->
                        <entityLongId>1300013</entityLongId>
                        <!--Optional:-->
                        <entityTaxId>234313123213456788</entityTaxId>
                    </entity>
                    <!--Optional:-->
                    <entityName>'.$_POST['nama'].'</entityName>
                    <!--Optional:-->
                    <entityTaxIdAdditional>1231</entityTaxIdAdditional>
                    <!--Optional:-->
                    <entityTypeCode>V</entityTypeCode>
                    <!--Optional:-->
 
                    <isEntityTypePayables>1</isEntityTypePayables>
                    <!--Optional:-->
                    <isEntityTypeReceivables>1</isEntityTypeReceivables>
                    <!--Optional:-->
                    <phoneNumbers>
                        <!--Optional:-->
                        <actionType>1</actionType>
                        <!--Optional:-->
                        <contactId>0</contactId>
                        <phoneNumber>'.$_POST['kontak'].'</phoneNumber>
                        <!--Optional:-->
                        <phoneTypeCode>FAX</phoneTypeCode>
                    </phoneNumbers>
                    <!--Optional:-->
                    <processing>
                        <!--Optional:-->
                        <actionType>1</actionType>
                        <!--Optional:-->
                        <processingVersion>ZJDE0001</processingVersion>
                    </processing>
                </addressBook>
            </orac:processAddressBook>
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
//        $verbose = fopen('testing.log', 'w+');
        curl_setopt($ch, CURLOPT_STDERR, false);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);

        $data = curl_exec($ch);
        echo curl_error($ch);
        curl_close($ch);

//        $data = substr($data, 148);
//        echo $data;
//        exit;

//        echo "<pre>";
//        print_r($data->xpath('//addressBookResult'));
//        echo "</pre>";
    }

}
