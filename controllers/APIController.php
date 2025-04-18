<?php

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController{
    public static function index() {
        $servicio = Servicio::all();
        echo json_encode($servicio);
    }

    public static function guardar(){
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();
        $serviciosId = explode(',',$_POST['servicio']);
        foreach ($serviciosId as $servicioId) {
            $args = [
                'servicioId' => $servicioId,
                'citaId' => $resultado['id']
            ];
            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }

        echo json_encode($resultado);
    }

    public static function eliminar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cita = Cita::find($_POST['id']);
            $cita->eliminar();
            header('location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
}