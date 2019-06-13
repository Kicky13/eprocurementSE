<?php
require_once "Mail.php";
//$to = "eko-hardiananto@supreme-energy.com";
//$to = "xo_aids@yahoo.com";
$to = "machrus.alifuddin21@gmail.com";
//$to = "Machrus Alifudin <machrus.alifudin@sisi.id>";
//$to = "agungudik@gmail.com";
//$cc = "agung-udiyono@supreme-energy.com,machrus.alifudin@sisi.id";
$cc = "machrus.alifudin@sisi.id";
//$from = "Agung Ud <agung-udiyono@supreme-energy.com>";
$from = "SCM Portal <scm-portal@supreme-energy.com>";
$subject = "Test EPROC-DEV 20190509@14.57";
$body = "Ini adalah test menggunakan script yang saya bikin dgn PHP menggunakan PEAR Mail Package dari server EPROC-DEVELOPMENT";
$host = "mail.supreme-energy.com";
$port = "25";
$username = "supreme-energy\scm-portal";
$password = "jkt@2019";

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

$mail = $smtp->send($recipients, $headers, $body);

if (PEAR::isError($mail)) {
  echo("<p>" . $mail->getMessage() . "</p>\n");
 } else {
  echo("<p>Message successfully sent!</p>\n");
 }
?>