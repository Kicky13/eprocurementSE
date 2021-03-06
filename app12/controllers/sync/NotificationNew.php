<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class NotificationNew extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    
    public function sendMail() {
        ini_set('max_execution_time', 300);
        $query_check_out = $this->db->query("select id,recipient,subject,content from i_notification where ismailed=0 limit 1");
        if($query_check_out->num_rows()>=0){
            $result_check = $query_check_out->result();
            $mail = get_mail();
			foreach ($result_check as $row){ 
				//$dadi = str_replace("<p><img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>", '', $row->content);
				//$dadi = strstr($dadi, '<p>Greetings,');
				//$row->content = ltrim($dadi);

				$dadi = str_replace("https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg", '', $row->content);
				$row->content = $dadi;
				
				require_once "Mail.php";
				require_once "Mail/mime.php";
				$crlf = "\r\n";
				$to = $row->recipient;
				$cc = "scm-portal@supreme-energy.com";
				$from = "SCM Portal <scm-portal@supreme-energy.com>";
				$subject = $row->subject;
				$body = $row->content;
				$host = $mail['smtp'];
				$port = $mail['port'];
				$username = $mail['email'];
				$password = $mail['password'];

				$recipients = $to.", ".$cc;

				$headers = array ('From' => $from,
				  'To' => $to,
				  'Cc' => $cc,
				  'Subject' => $subject);

				$smtp = Mail::factory('smtp',
				  array ('host' => $host,
					'port' => $port,
					'auth' => false,
					'username' => $username,
					'password' => $password));
					
					
					
				// Creating the Mime message
				$mime = new Mail_mime($crlf);

				// Setting the body of the email
				$mime->setHTMLBody($body);

				$body = $mime->get();
				$headers = $mime->headers($headers);

				$mail = $smtp->send($recipients, $headers, $body);

				if (PEAR::isError($mail)) {
				  echo 'Failed sending email '.$row->id.' at '.date("Y-m-d H:i:s");
				  echo("<p>" . $mail->getMessage() . "</p>\n");
                    $query_update = $this->db->query("update i_notification set ismailed=3,update_date=now() where id='".$row->id."' and ismailed=0");
				 } else {
				   echo 'Success sending email '.$row->id.' at '.date("Y-m-d H:i:s");
                    $query_update = $this->db->query("update i_notification set ismailed=1,update_date=now() where id='".$row->id."' and ismailed=0");
				 }

            }
            $this->db->close();
        }


    }

    

}
