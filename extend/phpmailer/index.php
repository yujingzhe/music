<?php
include 'src/PHPMailer.php';
// include 'src/Exception.php';
// include 'src/OAuth.php';
include 'src/SMTP.php';
include 'src/POP3.php';
$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.qq.com';  // Specify main and backup SMTP servers
       // var_dump($mail->Host);die;
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = '2211349512@qq.com';                 // SMTP username
    $mail->Password = 'pazgdrobycqddiac';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('2211349512@qq.com', '瞎写的');
    $mail->addAddress('974118065@qq.com', 'Joe User');     // Add a recipient
   
    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}