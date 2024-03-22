<?php

namespace Controllers;

use Model\Servicio;
use MVC\Router;

class servicioController {

    public static function index(Router $router) {

        isAdmin();

        $nombre = $_SESSION['nombre'];

        $servicios = Servicio::all();

        $router->render('servicios/index', [
            'nombre' => $nombre,
            'servicios' => $servicios
        ]);
    }

    public static function crear(Router $router) {

        isAdmin();

        $servicio = new Servicio;
        $nombre = $_SESSION['nombre'];
        $alertas = [];
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);

            $alertas = $servicio->validar();

            if(empty($alertas)) {
                $servicio->guardar();
                header('Location: /servicios');
            }
        }

        $router->render('servicios/crear', [
            'nombre' => $nombre,
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function actualizar(Router $router) {

        isAdmin();

        $nombre = $_SESSION['nombre'];

        if(!is_numeric($_GET['id'])) return;

        $servicio = Servicio::find($_GET['id']);
        $alertas = [];
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);

            $alertas = $servicio->validar();

            if(isset($alertas)) {
                $servicio->guardar();
                header('Location: /servicios');
            }
        }

        $router->render('servicios/actualizar', [
            'nombre' => $nombre,
            'alertas' => $alertas,
            'servicio' => $servicio
        ]);
    }

    public static function eliminar() {

        isAdmin();
        
        $id = $_POST['id'];
        $servicio = Servicio::find($id);
        $servicio->eliminar();
        header('Location: /servicios');
    }
}