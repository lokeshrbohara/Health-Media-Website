<?php
$mail->isSMTP();
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = true;
$mail->Username = "email_id";
$mail->Password = 'password';
$mail->Port = 465; //587
$mail->SMTPSecure = "ssl"; //tls
?>