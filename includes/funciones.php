<?php

define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
define('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'] . '/imagenes/');
// require 'app.php';

function incluirTemplate(string $nombre, bool $inicio = false)
{
   include  TEMPLATES_URL . "/${nombre}.php";
}

function estaAutenticado()
{
   session_start();

   if (!$_SESSION['login']) {
      header('Location:/');
   }
}

function debug($var)
{
   echo "<pre>";
   var_dump($var);
   echo "</pre>";
   exit;
}

// Escape /sanitizar HTML

function s($html): string
{
   $s = htmlspecialchars($html);
   return $s;
}

//Validar Tipo de contenido
function validarContenido($tipo)
{
   $tipos = ['vendedor', 'propiedad'];

   return in_array($tipo, $tipos);
}

//Mostrar mensajes
function mostrarNotificacion($codigo)
{
   $mensaje = '';

   switch ($codigo) {
      case 1:
         $mensaje = 'Creado Correctamente';
         break;
      case 2:
         $mensaje = 'Actializada Correctamente';
         break;
      case 3:
         $mensaje = 'Eliminado Correctamente';
         break;
      default:
         $mensaje = false;
         break;
   }
   return ($mensaje);
}


function validarORedireccionar(string $url)
{
   // Validar que sea un id
   $id = $_GET['id'];
   $id = filter_var($id, FILTER_VALIDATE_INT);

   if (!$id) {
      header("Location: ${url}");
   }

   return $id;
}
