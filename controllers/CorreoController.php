<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'vendor/autoload.php'; // Carga automática del compositor para PHPMailer

class CorreoController
{
    public function enviarBienvenida($correo, $nombre, $contrasena)
    {
        $mail = new PHPMailer(true);
        try {
            // Configuración SMTP de Mailtrap
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = '98e6f0e213e171'; // Usuario de Mailtrap
            $mail->Password = '095580fb623569'; // Contraseña de Mailtrap
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Remitente y destinatario
            $mail->setFrom('no-responder@tusitio.com', 'TexFashion');
            $mail->addAddress($correo, $nombre);

            // Contenido del correo
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
