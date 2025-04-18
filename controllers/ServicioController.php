<?php
namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServicioController{
    public static function index(Router $router) {
        $servicios = Servicio::all();
        $id = $_GET['id']?? null;
        if ($id === '1') {
            Servicio::setAlerta('correcto', 'Actualizado correctamente');
        }
        if($id === '2') {
            Servicio::setAlerta('error', 'Eliminado correctamente');
        }
        // debug($servicios);
        $alertas = Servicio::getAlertas();
        $router->render('servicios/index', [
            'servicios' => $servicios,
            'alertas' => $alertas
        ]);
    }

    public static function crear(Router $router) {
        $servicio = new Servicio;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();

            if (empty($alertas)) {
                $resultado = $servicio->guardar();
                if ($resultado) {
                    header('location: /servicios');
                }
            }
        }

        $alertas = Servicio::getAlertas();

        $router->render('servicios/crear', [
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function actualizar(Router $router) {
        if (!is_numeric($_GET['id']) || empty($_GET['id'])) {
            header('location: /servicios');
        }
        $servicio = Servicio::find($_GET['id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();
            if (empty($alertas)) {
                $resultado = $servicio->guardar();
                if ($resultado) {
                    header('location: /servicios?id=1');
                }
            }
        }

        $alertas = Servicio::getAlertas();
        $router->render('servicios/actualizar', [
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function eliminar(Router $router) {
        $servicio = Servicio::find($_POST['id']);
        $resultado = $servicio->eliminar();
        if ($resultado) {
            header('location: /servicios?id=2');
        }
        $router->render('servicios/eliminar');
    }


}