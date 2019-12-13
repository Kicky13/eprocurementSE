<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notification extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    
    public function sendMail() {
        ini_set('max_execution_time', 300);
        $query_check_out = $this->db->query("select id,recipient,subject,content from i_notification where ismailed=0");
        if($query_check_out->num_rows()>=0){
            $result_check = $query_check_out->result();
            //$req_no = "11";

            $mail = get_mail();
           /*  $config = array();
            $config['protocol'] = $mail['protocol'];
            $config['smtp_crypto'] = $mail['crypto'];
            if($mail['protocol'] == 'smtp'){
                $config['smtp_pass'] = $mail['password'];
            } */
            
            //$config['protocol'] = 'mail';
            //$config['smtp_crypto'] = '';
            
           /*  $config['crlf'] = "\r\n";
            $config['mailtype'] = 'html';
            $config['smtp_host'] = $mail['smtp'];
            $config['smtp_port'] = $mail['port'];
            $config['smtp_user'] = $mail['email'];
            $config['charset'] = "utf-8";
            $config['newline'] = "\r\n"; */
			
			$config = array(
				'protocol' => $mail['protocol'],
				'smtp_host' => $mail['smtp'],
				'smtp_port' => $mail['port'],
				'smtp_user' => $mail['email'],
				'smtp_pass' => $mail['password'],
				'mailtype'  => 'html', 
				'charset'   => 'iso-8859-1'
			);

            $this->load->library('email', $config);
            $this->email->initialize($config);
            
            foreach ($result_check as $row) {

                $this->email->from($mail['email'], '[SYSTEM] SUPREME ENERGY');
				$this->email->to($row->recipient);
                // $this->email->to('reza@abpersada.com');
                $this->email->subject($row->subject);
                //$this->email->isHTML(true);
                $this->email->message($row->content); 
                if ($this->email->send()) {
                    echo 'Success sending email '.$row->id.' at '.date("Y-m-d H:i:s");
                    $query_update = $this->db->query("update i_notification set ismailed=1,update_date=now() where id='".$row->id."' and ismailed=0");
                } else {
                    echo 'Failed sending email '.$row->id.' at '.date("Y-m-d H:i:s");
                }

            }
            $this->db->close();
        }


    }

    

}
