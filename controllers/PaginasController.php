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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $mensaje = null;

            $respuestas = $_POST['contacto'];

            //Crear instacia de PHP Mailer
            $mail = new PHPMailer();

            //Configurar SMTP
            $mail->isSMTP();
            $mail->Host = $_ENV['EMAIL_HOST'];
            $mail->SMTPAuth = true;
            $mail->Username =  $_ENV['EMAIL_USER'];
            $mail->Password = $_ENV['EMAIL_PASS'];
            $mail->SMTPSecure = 'tls';
            $mail->Port =  $_ENV['EMAIL_PORT'];


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
            $contenido .= '<p>Nombre: ' . $respuestas['nombre'] . '</p>';
            $contenido .= '<p>Mensaje: ' . $respuestas['mensaje'] . '</p>';
            $contenido .= '<p>Vende o compra: ' . $respuestas['tipo'] . '</p>';
            $contenido .= '<p>Presupuesto: $' . $respuestas['precio'] . '</p>';
            //Enviar de forma condicional segun los campos E-mail o telefono
            if ($respuestas['contacto'] === 'telefono') {
                $contenido .= '<p> Eligio ser contactado por Teléfono </p>';
                $contenido .= '<p>Teléfono: ' . $respuestas['telefono'] . '</p>';
                $contenido .= '<p>Fecha contaco: ' . $respuestas['fecha'] . '</p>';
                $contenido .= '<p>Hora: ' . $respuestas['hora'] . '</p>';
            } else {
                //Agregar el campo de Email
                $contenido .= '<p> Eligio ser contactado por E-Mail </p>';
                $contenido .= '<p>Email: ' . $respuestas['email'] . '</p>';
            }



            $contenido .= '</html>';


            $mail->Body = $contenido;
            $mail->AltBody = "Texto alternativo sin HTML";

            //Enviar el E-Mail
            if ($mail->send()) {
                $mensaje = 'Mensaje enviado correctamente';
            } else {
                $mensaje = 'El mensaje no se pudo enviar';
            }
        }
        $router->render('paginas/contacto', [
            'mensaje' => $mensaje
        ]);
    }
}
