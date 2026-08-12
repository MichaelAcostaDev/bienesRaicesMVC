<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController
{
    public static function index(Router $router)
    {

        $inicio = true;
        $propiedades = Propiedad::get(3);

        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio

        ]);
    }

    public static function nosotros(Router $router)
    {
        $router->render('paginas/nosotros');
    }

    public static function propiedades(Router $router)
    {

        $propiedades = Propiedad::all();
        // Muestra un mensaje condicional

        $router->render('paginas/propiedades', [
            'propiedades' => $propiedades,
        ]);
    }
    public static function propiedad(Router $router)
    {

        $id = validarORedireccionar('/propiedades');

        $propiedad = Propiedad::find($id);

        $router->render('paginas/propiedad', [
            'propiedad' => $propiedad
        ]);
    }
    public static function blog(Router $router)
    {
        $router->render('paginas/blog');
    }
    public static function entrada(Router $router)
    {
        $router->render('paginas/entrada');
    }
    public static function contacto(Router $router)
    {
        $mensaje = null;
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $respuestas = $_POST['contacto'];

            // Validar que las variables de EMAIL estén configuradas
            $email_host = $_ENV['EMAIL_HOST'] ?? getenv('EMAIL_HOST');
            $email_user = $_ENV['EMAIL_USER'] ?? getenv('EMAIL_USER');
            $email_pass = $_ENV['EMAIL_PASS'] ?? getenv('EMAIL_PASS');
            $email_port = $_ENV['EMAIL_PORT'] ?? getenv('EMAIL_PORT');

            if (empty($email_host) || empty($email_user) || empty($email_pass) || empty($email_port)) {
                $error = 'El servicio de correo no está configurado en este momento. Por favor, intente más tarde.';
                error_log('Email configuration missing: HOST=' . (!empty($email_host) ? 'OK' : 'MISSING') . 
                          ', USER=' . (!empty($email_user) ? 'OK' : 'MISSING') . 
                          ', PASS=' . (!empty($email_pass) ? 'OK' : 'MISSING') . 
                          ', PORT=' . (!empty($email_port) ? 'OK' : 'MISSING'));
            } else {
                try {
                    //Crear instancia de PHP Mailer
                    $mail = new PHPMailer();

                    //Configurar SMTP
                    $mail->isSMTP();
                    $mail->Host = $email_host;
                    $mail->SMTPAuth = true;
                    $mail->Username = $email_user;
                    $mail->Password = $email_pass;
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = (int)$email_port;

                    //Configurar contenido del E-Mail
                    $mail->setFrom('admin@bienesraices.com');
                    $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com');
                    $mail->Subject = 'Tienes un nuevo mensaje';

                    //Habilitar HTML
                    $mail->isHTML(true);
                    $mail->CharSet = 'UTF-8';

                    //Definir el contenido
                    $contenido = '<html>';
                    $contenido .= '<p>Tienes un nuevo mensaje</p>';
                    $contenido .= '<p>Nombre: ' . htmlspecialchars($respuestas['nombre'] ?? '') . '</p>';
                    $contenido .= '<p>Mensaje: ' . htmlspecialchars($respuestas['mensaje'] ?? '') . '</p>';
                    $contenido .= '<p>Vende o compra: ' . htmlspecialchars($respuestas['tipo'] ?? '') . '</p>';
                    $contenido .= '<p>Presupuesto: $' . htmlspecialchars($respuestas['precio'] ?? '') . '</p>';
                    
                    //Enviar de forma condicional segun los campos E-mail o telefono
                    if (($respuestas['contacto'] ?? null) === 'telefono') {
                        $contenido .= '<p>Eligio ser contactado por Teléfono</p>';
                        $contenido .= '<p>Teléfono: ' . htmlspecialchars($respuestas['telefono'] ?? '') . '</p>';
                        $contenido .= '<p>Fecha contacto: ' . htmlspecialchars($respuestas['fecha'] ?? '') . '</p>';
                        $contenido .= '<p>Hora: ' . htmlspecialchars($respuestas['hora'] ?? '') . '</p>';
                    } else {
                        //Agregar el campo de Email
                        $contenido .= '<p>Eligio ser contactado por E-Mail</p>';
                        $contenido .= '<p>Email: ' . htmlspecialchars($respuestas['email'] ?? '') . '</p>';
                    }

                    $contenido .= '</html>';

                    $mail->Body = $contenido;
                    $mail->AltBody = "Tienes un nuevo mensaje en tu sitio de bienes raices";

                    //Enviar el E-Mail
                    if ($mail->send()) {
                        $mensaje = 'Mensaje enviado correctamente';
                    } else {
                        $error = 'El mensaje no se pudo enviar. Por favor, intente de nuevo.';
                        error_log('PHPMailer Error: ' . $mail->ErrorInfo);
                    }
                } catch (Exception $e) {
                    $error = 'Error al enviar el mensaje. Por favor, intente de nuevo.';
                    error_log('Email Exception: ' . $e->getMessage());
                }
            }
        }

        $router->render('paginas/contacto', [
            'mensaje' => $mensaje,
            'error' => $error
        ]);
    }
}
