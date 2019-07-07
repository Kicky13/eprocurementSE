<?php
require_once "Mail.php";
$to = "eko-hardiananto@supreme-energy.com";
$to = "agungudik@gmail.com";
$to = "donna.sianturi@sisi.id";
$to = "machrus.alifuddin21@gmail.com";
$to = "machrus.alifudin@sisi.id";
$to = "alfhanz@gmail.com";
$to = "agus.purnomo@sisi.id";
$to = "ilhambagaskars@gmail.com";

$cc = "scm-portal@supreme-energy.com,developersisi1@gmail.com";
$from = "SCM Portal <scm-portal@supreme-energy.com>";
$subject = "Test EPROC-DEV_PROD ".date("Y-m-d H:i:s");
$body = "Ini MACHRUS SISI MENCOBA MELAKUKAN test menggunakan script yang saya bikin dgn PHP menggunakan PEAR Mail Package dari server EPROC-DEVELOPMENT";
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

