<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "vendor/autoload.php";

if (isset($_POST['email'])) {

 if (
        !isset($_POST['name']) ||
        !isset($_POST['email']) ||
        !isset($_POST['message'])
    ) {
        problem('We are sorry, but there appears to be a problem with the form you submitted.');
    }


	$name = $_POST['name']; // required
    $email = $_POST['email']; // required
    $message = $_POST['message']; // required

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

    if (!preg_match($email_exp, $email)) {
        $error_message .= 'The Email address you entered does not appear to be valid.<br>';
    }

    $string_exp = "/^[A-Za-z .'-]+$/";

    if (!preg_match($string_exp, $name)) {
        $error_message .= 'The Name you entered does not appear to be valid.<br>';
    }

    if (strlen($message) < 2) {
        $error_message .= 'The Message you entered do not appear to be valid.<br>';
    }

    if (strlen($error_message) > 0) {
        problem($error_message);
    }


$email_message = "Form details below.\n\n<br>";
    $email_message .= "Name: " . clean_string($name) . "\n<br>";
    $email_message .= "Email: " . clean_string($email) . "\n<br>";
    $email_message .= "Message: " . clean_string($message) . "\n<br>";


	 
//PHPMailer Object
$mail = new PHPMailer(true); //Argument true in constructor enables exceptions

//From email address and name
$mail->From = "hashankaduwela@gmail.com";
$mail->FromName = "Hashan Alwis";

//To address and name
//$mail->addAddress("recepient1@example.com", "Recepient Name");
$mail->addAddress("ahealwis@gmail.com"); //Recipient name is optional

//Address to which recipient will reply
//$mail->addReplyTo("reply@yourdomain.com", "Reply");

//CC and BCC
//$mail->addCC("cc@example.com");
//$mail->addBCC("bcc@example.com");

//Send HTML or Plain Text email
$mail->isHTML(true);
$messageBody = getMessage($email_message);
$mail->Subject = "XXXXXX.com Website Contact Message";
$mail->Body = $messageBody;
//$mail->AltBody = "This is the plain text version of the email content";
$mail->AltBody = $email_message;
 

try {
    $mail->send();
    echo "Message has been sent successfully";
} catch (Exception $e) {
    echo "Mailer Error: " . $mail->ErrorInfo;
}




}






function getMessage($email_message){
	
    $message  = file_get_contents('template.html');	
    $message = str_replace('{massage_body}', $email_message, $message );

    return $message;
}
    function problem($error)
    {
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br><br>";
        echo $error . "<br><br>";
        echo "Please go back and fix these errors.<br><br>";
        die();
    }

  function clean_string($string)
    {
        $bad = array("content-type", "bcc:", "to:", "cc:", "href");
        return str_replace($bad, "", $string);
    }





?>