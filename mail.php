<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

function sendMail($to, $subject, $body){

    $mail = new PHPMailer(true);

    try{

        $mail->isSMTP();

        $mail->Host = 'smtp.gmail.com';

        $mail->SMTPAuth = true;

        $mail->Username = 'yourgmail@gmail.com';

        $mail->Password = 'your-app-password';

        $mail->SMTPSecure = 'tls';

        $mail->Port = 587;

        $mail->setFrom('yourgmail@gmail.com', 'CampuRecover');

        $mail->addAddress($to);

        $mail->isHTML(true);

        $mail->Subject = $subject;

        $mail->Body = $body;

        $mail->send();

        return true;

    }catch(Exception $e){

        return false;
    }
}
?>