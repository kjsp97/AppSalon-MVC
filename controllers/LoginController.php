<?php
namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController{

    public static function login(Router $router) {
        if ($_GET['id']?? null === '1'){
            Usuario::setAlerta('correcto', 'Contraseña actualizada correctamente');
        }   
        // $_SESSION = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->checkUser();

            if (empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);

                if (!$usuario || !$usuario->confirmado) {
                    Usuario::setAlerta('error', 'Usuario no existe');
                }elseif($usuario){
                    $ContraseñaCorrecta = $auth->checkPassword($usuario);

                    if (!$ContraseñaCorrecta) {
                        Usuario::setAlerta('error', 'Contraseña incorrecta');
                    }else{
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . ' ' . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;
                        if ($usuario->admin === '1') {
                            $_SESSION['admin'] = $usuario->admin?? null;
                            header('location: /admin');
                        }else {
                            header('location: /citas');
                        }
                    }
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/login', [
            'alertas' => $alertas
        ]);
    }

    public static function logout() {
        $_SESSION = [];
        header('location: /');
    }

    public static function olvidado(Router $router) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $validar = $auth->checkEmail();
            if (empty($validar)) {
                $usuario = Usuario::where('email', $auth->email);
                if (empty($usuario) || $usuario->confirmado === '0') {
                    Usuario::setAlerta('error', 'Usuario no existe');
                }else{
                    $usuario->getToken();
                    $usuario->guardar();

                    $mail = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $mail->recover();
                    Usuario::setAlerta('correcto', 'Email de recuperacion enviado');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/olvidado', [
            'alertas' => $alertas
        ]);
    }

    public static function recuperar(Router $router) {
        $token = s($_GET['token']?? '');
        $usuario = Usuario::where('token', $token);
        $error = false;
        if (empty($usuario)) {
            $error = true;
            Usuario::setAlerta('error', 'Pagina no encontrada');  
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $args = new Usuario($_POST);
            $alertas = $args->checkPasswordRecover();
            
            if (empty($alertas)) {
                $usuario->password = $args->password;
                $usuario->hashed();
                $usuario->token = null;
                $usuario->guardar();
                header('location: /?id=1');
            }
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar-cuenta', [
            'alertas' => $alertas,
            'error' => $error
        ]);
    }

    public static function crear(Router $router) {
        $usuario = new Usuario;
        $alertas = Usuario::getAlertas();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validar();

            if (empty($alertas)) {

                $resultado = $usuario->userExists();

                if (!$resultado) {
                    $alertas = Usuario::getAlertas();
                }else{
                    $usuario->hashed();
                    $usuario->getToken();

                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->send();

                    $resultado = $usuario->guardar();
                    if ($resultado) {
                        header('location: /mensaje');
                    }
                }
            }
        }
        $router->render('auth/crear-usuario', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router) {
        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router) {
        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            Usuario::setAlerta('error', 'Pagina no encontrada');
        }else{
            $usuario->confirmado = '1';
            $usuario->token = '';
            $usuario->guardar();
            Usuario::setAlerta('correcto', 'Correo confirmado correctamente');
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);
    }
}