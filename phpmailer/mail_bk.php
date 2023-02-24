<?php
// ! this code can use the functions for received variable and send email Completely.

// TODO see what the fatal PHP error
ini_set('display_errors', 0);


// * Include packages and files for PHPMailer and SMTP protocol:
use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

require('phpmailer/Exception.php');
require('phpmailer/PHPMailer.php');
require('phpmailer/SMTP.php');

// * Initialize PHP Mailer and set SMTP as mailing protocol:
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Mailer = "smtp";

// * Set required parameters for making an SMTP connection like server, port and account credentials. SSL and TLS are both cryptographic protocols that provide authentication and data encryption between servers, machines and applications operating over a network. SSL is the predecessor to TLS.
$mail->SMTPDebug  = 2;
$mail->SMTPAuth   = TRUE;
$mail->SMTPSecure = "SSL";
$mail->Port       = 587;
$mail->Host       = "smtp.gmail.com";
$mail->Username   = "tom.umnarj.soth@gmail.com";
$mail->Password   = "jcdsgwpyepqlxwgc";

function SendEmail($mail_parameter)
{
  global $mail;
  // * Set the required parameters for email header and body:
  $mail->CharSet = "utf-8";
  $mail->IsHTML(true);
  $mail->AddAddress($mail_parameter["receiver_address"], $mail_parameter["receiver_name"]);
  $mail->SetFrom($mail_parameter["from_address"], $mail_parameter["from_name"]);
  $mail->AddReplyTo($mail_parameter["reply_address"], $mail_parameter["reply_name"]);
  // ? If you have CC email
  if ($mail_parameter["cc_address"]) {
    $mail->AddCC($mail_parameter["cc_address"], $mail_parameter["cc_name"]);
  }
  for ($i = 1; $i <= 4; $i++) {
    if ($mail_parameter["cc_address" . $i]) {
      $mail->AddCC($mail_parameter["cc_address" . $i], $mail_parameter["cc_name" . $i]);
    }
  }

  $mail->Subject = $mail_parameter["subject"];
  $content = $mail_parameter["content"];

  // ? Create a body content from HTML variable
  $mail->MsgHTML($content);

  // * Read an HTML message body from an external file, convert referenced images to embedded,
  // ? convert HTML into a basic plain-text alternative body
  // $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
  //Replace the plain text body with one created manually
  $mail->AltBody = 'This is a plain-text message body';
  // ? Attach an image file
  // $mail->addAttachment('images/phpmailer_mini.png');

  // * Send the email and catch required exceptions:
  if (!$mail->Send()) {
    echo "<br>!! Error while sending Email.<hr style=margin-bottom: 1em;>";
    var_dump($mail);
    die();
  } else {
    echo "<br>Email sent successfully<hr style=margin-bottom: 1em;>";
  }
}

// * on progress
session_start();
if ($_SESSION["data"]) {
  if ($_GET["type"] == "json") {
    $data = json_decode($_SESSION["data_json"], true, JSON_UNESCAPED_UNICODE);
    // die("<hr>break for json.");
  } else if ($_GET["type"] == "session") {
    $data = $_SESSION["data"];
  } else {
    die("!! No data type.");
  }

  // echo "data is<br>";
  // print_r($data);
  // echo '<hr style=margin-bottom: 1em;>';

  // ! call function to sending email
  SendEmail($data);
  // * clear session variable
  $_SESSION["data"] = "";
  $_SESSION["data_json"] = "";
  // session_destroy();

  // todo next page condition
  // if ($_GET["next"]) {
  //   if ($_GET["next"] == "true") {
  //     // echo "next url: " . $data["next_url"];
  //     echo '<meta http-equiv="refresh" content="0;url=' . $data["next_url"] . '">';
  //   } else if ($_GET["next"] == "close") {
  //     echo '<script>this.close();</script>';
  //   } else {
  //     // echo '<meta http-equiv="refresh" content="0;url=' . $_GET["next"] . '">';
  //     echo '<hr><a href="' . $data["next_url"] . '">NEXT</a>';
  //   }
  // }
} else {
  header("location:../poc/");
  echo "no data";
}
