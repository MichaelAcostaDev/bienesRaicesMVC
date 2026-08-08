<?php

namespace MVC;

class Router
{
    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url, $fn){
        $this->rutasGET[$url] = $fn;
    }

    public function post($url, $fn){
        $this->rutasPOST[$url] = $fn;
    }

    public function comprobarRutas(){
        session_start();

        $auth = $_SESSION['login'] ?? null;

        //Array rutas protected...
        $rutas_protegistas = [
            '/admin',
            '/propiedades/actualizar',
            '/propiedades/crear',
            '/propiedades/eliminar',
            '/vendedores/crear',
            '/vendedores/actualizar',
            '/vendedores/eliminar'
        ];

        $urlActual = $_SERVER['PATH_INFO'] ?? $_SERVER['REQUEST_URI'] ?? '/';
        $urlActual = strtok($urlActual, '?');
        $urlActual = str_replace('/index.php', '', $urlActual);
        $urlActual = $urlActual ?: '/';

        $metodo = $_SERVER['REQUEST_METHOD'];

        if ($metodo === 'GET') {
            $fn = $this->rutasGET[$urlActual] ?? NULL;
        } else {
            $fn = $this->rutasPOST[$urlActual] ?? NULL;
        }

        //Proteger las rutas
        if (in_array($urlActual, $rutas_protegistas) && !$auth) {
            header('Location: /');
        }



        if ($fn) {
            //La url existe y hay una funcion asociada
            call_user_func($fn, $this);
        } else {
            header('Location: 404');
            // echo 'pagina no encontrada';
        }
    }

    //Mostrar vista
    public function render($view, $datos = [])
    {

        foreach ($datos as $key => $value) {
            $$key = $value;
        }

        ob_start(); //Almacena en memoria por un momento

        include __DIR__ . "/views/$view.php";

        $contenido = ob_get_clean(); //Limpia el buffer

        include __DIR__ . '/views/layaut.php';
    }
}
