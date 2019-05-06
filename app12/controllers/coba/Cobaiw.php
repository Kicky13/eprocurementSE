<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cobaiw extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library(array('Pdf', 'encryption', 'email'));
    }

    public function index() {
        $this->encryption->initialize(
                array(
                    'cipher' => 'aes-256',
                    'mode' => 'ctr',
                    'key' => '<a 32-character random string>'
                )
        );
        $plain_text = 'This is a plain-text message!';
        $ciphertext = $this->encryption->encrypt($plain_text);

        // Outputs: This is a plain-text message!
        echo $ciphertext . " - " . $this->encryption->decrypt($ciphertext);
    }

    public function mail() {
        $config['protocol'] = "smtp";
        $config['smtp_host'] = 'smtp.gmail.com';
        $config['smtp_port'] = '465';
        $config['smtp_user'] = 'satu3885@gmail.com';
        $config['smtp_pass'] = 'satudua12';
        $config['smtp_timeout'] = "5";
        $config['smtp_crypto'] = 'ssl';
        $config['mailtype'] = "html";
        $config['charset'] = "utf-8";
        $config['newline'] = "\r\n";

        $this->email->initialize($config);

        $this->email->clear();
        $this->email->from('your@gmail.com', '[SYSTEM] EPROC SUPREME ENERGY');
        $this->email->to('iwan.purwanto@sisi.id');
        $this->email->cc('miwan.purwanto@gmail.com');

        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');

    
    }

    public function mail2() {
        $config['protocol'] = "smtp";
        $config['smtp_host'] = "10.15.3.12";
        $config['smtp_port'] = "25";
        $config['smtp_user'] = "";
        $config['smtp_pass'] = "";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = true;
        $config['crlf'] = "\r\n";
        $this->email->initialize($config);
        // print_r($detail); 
        $leadOfUnit = array("miwan.purwanto@gmail.com");
        $this->email->from('your@gmail.com', '[SYSTEM] EPROC SUPREME ENERGY');
        $this->email->to($leadOfUnit);
        $this->email->subject("Kondisi Stok Kantong Pada :{'PP /gudang' }");
        $this->email->message("Dengan Hormat,<br /><br />
        
        Mohon untuk ditinjaklanjuti terkait stok kantong yang ada pada:<br />
        Gudang / Plant 	: 123132<br />
        Nama Material   : 123213<br />
        Stok Kantong 	: 22222 <br />
		Safety Stok 	: 12323 <br />
		Kondisi 		: Sesuai Dashboard. <br />
		<br />
        Demikian informasi yang kami sampaikan.<br /> 
        <br />
        Sekian, terima kasih.");
        
    }
    
    public function hash(){
        $us = 'iwan@gmail.com';
        $ps = 'anu';
        echo sha1($ps);
    }

}
