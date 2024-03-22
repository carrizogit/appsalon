<?php

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController {
    
    public static function index() {
        $servicio = Servicio::all();

        //convertir de arreglo a json
        echo json_encode($servicio);
    }

    public static function guardar() {
         
        //almacena la cita y devuelve el id
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();

        $id = $resultado['id'];

        //almacena la cita y el servicio
        //explode separa una cadena de texto el primer parametro seria el separador y desp el striing
        $idServicios = explode(",", $_POST['servicios'] );
        foreach( $idServicios as $idServicio) {
            $args = [
                'citaId' => $id,
                'servicioId' => $idServicio
            ];

            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }
         
        echo json_encode(['resultado' => $resultado]);
    }

    public static function eliminar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];

            $cita = Cita::find($id);
            $cita->eliminar();
            //redirecciona a la misma pagina de donde estabamso
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }
}