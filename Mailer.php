<?php
require('vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable("../laravel/");
$dotenv->load();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    public function enviarEmail(
        $email,
        $subject = "Asunto",
        $body = 'Hola, este es un correo de prueba enviado desde <h4 style="color: blue">Servidor</h4>',
        $AltBody = 'Este es un mensaje para los clientes que no soportan HTML.')
    {
        // Al pasar true habilitamos las excepciones
        $mail = new PHPMailer(true);

        try {
            // Ajustes del Servidor
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER; // Comenta esto antes de producción
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['MAIL_USERNAME'];
            $mail->Password = $_ENV['MAIL_PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Destinatario
            $mail->setFrom($_ENV['MAIL_FROM_ADDRESS'], $_ENV['APP_NAME']);
            $mail->addAddress($email);

            // Mensaje
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->AltBody = $AltBody;

            $mail->send();
            //echo 'Se envio el mensaje';
        } catch (Exception $e) {
            //echo "Algo salio mal al intentar enviar: {$mail->ErrorInfo}";
            //$data['error'] = true;
            //$data['message'] = "Algo salio mal al intentar enviar.";
        }
    }
}