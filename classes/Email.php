<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

 class Email {

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion() {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];



        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'appsalon.com');
        $mail->Subject = 'Confirma tu cuenta de app salon';

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Creaste una cuenta en App Salon, confirma presionando el siguiente enlace </p >";
        $contenido .= "<p>Presiona aqui: <a href='". $_ENV['APP_URL'] ."/confirmar-cuenta?token=" . $this->token . "'>Confirma Cuenta</a></p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, desestima este mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        $mail->send();
    }

    public function enviarInstrucciones() {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'appsalon.com');
        $mail->Subject = 'Reestablecer tu contraseña';

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Restablece tu cuenta de appsalon </p >";
        $contenido .= "<p>Presiona aqui: <a href='". $_ENV['APP_URL'] ."/recuperar?token=" . $this->token . "'>Restablecer</a></p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, desestima este mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        $mail->send();
    }
 }