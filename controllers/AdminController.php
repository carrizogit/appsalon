<?php

namespace Controllers;

use Model\ActiveRecord;
use Model\AdminCita;
use MVC\Router;

class AdminController extends ActiveRecord {

    public static function index(Router $router) {
        // session_start();

        isAdmin();


        //tomaos la fecha del get
        $fecha = $_GET['fecha'] ?? date('Y-m-d');
        //separamos la fecha con el - medio ej 2024-12-12 a '2024', '12'
        $fechas = explode('-', $fecha);

        //revisamos que sea una fecha valida con el checkdate
        if(!checkdate($fechas[1], $fechas[2], $fechas[0])) {
            header('Location: /404');
        }


        //consultar BD
        $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuarioId=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citasServicios ";
        $consulta .= " ON citasServicios.citaId=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citasServicios.servicioId ";
        //$consulta .= " WHERE fecha =  $fecha ";
        $consulta .= " WHERE fecha =  '{$fecha}' ";

        $citas =  AdminCita::SQL($consulta);

        $router->render('admin/index', [
            'nombre' => $_SESSION['nombre'],
            'citas' => $citas,
            'fecha' => $fecha
        ]);
    }
}