<?php
namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController{
    public static function index(Router $router){
        $fecha = $_GET['fecha']?? date('Y-m-d');
        $f = explode('-', $fecha);

        if (!checkdate($f[1], $f[2], $f[0])) {
            header('location: /admin');
        }


        $consulta = "SELECT citas.id, citas.hora, CONCAT(usuarios.nombre, ' ', usuarios.apellido) AS cliente, ";
        $consulta .= "usuarios.email, usuarios.movil, servicios.nombre AS servicio, servicios.precio FROM citas ";
        $consulta .= "LEFT OUTER JOIN usuarios ON citas.usuarioId=usuarios.id ";
        $consulta .= "LEFT OUTER JOIN citasServicios ON citasServicios.citaId = citas.id ";
        $consulta .= "LEFT OUTER JOIN servicios ON servicios.id=citasServicios.servicioId ";
        $consulta .= "WHERE fecha = '{$fecha}'";

        $citas = AdminCita::SQL($consulta);

        $router->render('admin/index', [
            'citas' => $citas,
            'fecha' => $fecha
        ]);
    }
}