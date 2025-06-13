<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'vendor/autoload.php';  // Carga automática de clases de Composer
require_once 'config_mail.php';      // Carga configuración SMTP personalizada

class CorreoController
{
    public function enviarBienvenida($correo, $nombre, $contrasena)
    {
        // Obtener configuración SMTP
        $config = require 'config_mail.php';  // No es necesario "require_once" porque no se trata de definir clases o funciones múltiples veces

        $mail = new PHPMailer(true);
        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = $config['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $config['username'];
            $mail->Password = $config['password'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $config['port'];

            // Dirección del remitente y del destinatario
            $mail->setFrom($config['from_email'], $config['from_name']);
            $mail->addAddress($correo, $nombre);

            // Contenido del mensaje
            $mail->isHTML(true);
            $mail->Subject = 'Registro exitoso en TexFashion';
            $mail->Body = "
                <div style='font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ddd; border-radius: 10px;'>
                    <h2 style='color: #2C3E50;'>¡Hola, $nombre!</h2>
                    <p>Gracias por registrarte en <strong>TexFashion</strong>.</p>
                    <p>A continuación te compartimos tu contraseña generada:</p>
                    <p style='font-size: 18px; color: #27AE60;'><strong>$contrasena</strong></p>
                    <p>Te recomendamos cambiarla una vez inicies sesión.</p>
                    <hr>
                    <small>Este correo fue enviado automáticamente. No respondas a este mensaje.</small>
                </div>
            ";

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Error al enviar correo: " . $mail->ErrorInfo);
            return false;
        }
    }
}

