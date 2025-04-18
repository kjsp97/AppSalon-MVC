<?php
namespace Controllers;

use MVC\Router;

class CitaController{
    public static function crear(Router $router) {
        $router->render('citas/index');
    }
}