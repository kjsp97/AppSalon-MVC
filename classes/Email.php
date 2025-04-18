<?php
namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{
    public $nombre;
    public $email;
    public $token;

    public function __construct($nombre, $email, $token)
    {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->token = $token;
    }

    public function send(){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
        $mail->SMTPSecure = 'tls';
        $mail->Port = $_ENV['EMAIL_PORT'];

        $mail->setFrom('AppSalon@appsalon.com');
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = 'Confirma tu cuenta';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = '<h1><strong>Hola! ' . $this->nombre . ', bienvenido(a) a la familia de APPSalon</strong></h1><p>Por favor confirma tu usuario abriendo el siguiente enlace: </p><p><a href="' . $_ENV['APP_URL'] . '/confirmar-cuenta?token=' . $this->token . '">Confimar Cuenta</a></p><p>Si no reconoces este registro, por favor ignora este correo.</p>';

        $mail->Body = $contenido;
        $mail->AltBody = 'Alt. texto';
        
        $mail->send();
    }

    public function recover(){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
        $mail->SMTPSecure = 'tls';
        $mail->Port = $_ENV['EMAIL_PORT'];

        $mail->setFrom('AppSalon@appsalon.com');
        $mail->addAddress('usuario@ejemplo.com', 'AppSalon');
        $mail->Subject = 'Confirma tu cuenta';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = '<h1><strong>Hola! ' . $this->nombre . '.</strong></h1><p>Restablece tu contraseña abriendo el siguiente enlace: </p><p><a href="' . $_ENV['APP_URL'] . '/recuperar?token=' . $this->token . '">Restablecer Contraseña</a></p><p>Si no fuiste tu, por favor ignora este correo.</p>';

        $mail->Body = $contenido;
        $mail->AltBody = 'Alt. texto';
        
        $mail->send();
    }

}