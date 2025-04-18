<?php

namespace Model;

class Usuario extends ActiveRecord{
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'movil', 'admin', 'confirmado', 'token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $movil;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = []){
        $this->id = $args['id']?? null;
        $this->nombre = $args['nombre']?? '';
        $this->apellido = $args['apellido']?? '';
        $this->email = $args['email']?? '';
        $this->password = $args['password']?? '';
        $this->movil = $args['movil']?? '';
        $this->admin = $args['id']?? 0;
        $this->confirmado = $args['confirmado']?? 0;
        $this->token = $args['token']?? '';
    }

    public function validar(){
        if (!$this->nombre) {
            self::$alertas['error'][] = 'Nombre Obligatorio';
        }
        if (!$this->apellido) {
            self::$alertas['error'][] = 'Apellido Obligatorio';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'Email Obligatorio';
        }
        if (!$this->password) {
            self::$alertas['error'][] = 'Contraseña Obligatoria';
        }
        if (strlen($this->password) < 8 && $this->password) {
            self::$alertas['error'][] = 'Crear contraseña de mínimo 8 caracteres';
        }
        if (!$this->movil) {
            self::$alertas['error'][] = 'Movil Obligatorio';
        }
        return static::$alertas;
    }

    public function checkUser(){
        if (!$this->email) {
            self::$alertas['error'][] = 'Email Obligatorio';
        }
        if (!$this->password) {
            self::$alertas['error'][] = 'Contraseña Obligatoria';
        }
        return static::$alertas;
    }

    public function checkEmail(){
        if (!$this->email) {
            self::$alertas['error'][] = 'Email Obligatorio';
        }
        return static::$alertas;
    }

    public function checkPasswordRecover(){
        if (!$this->password) {
            self::$alertas['error'][] = 'Introduce la nueva contraseña';
        }
        if (strlen($this->password) < 8 && $this->password) {
            self::$alertas['error'][] = 'Crear contraseña de mínimo 8 caracteres';
        }
        if ($this->password !== $_POST['password2']) {
            self::$alertas['error'][] = 'Las contraseñas deben coincidir';
        }


        return static::$alertas;
    }

    public function userExists(){
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '{$this->email}' LIMIT 1";
        $resultado = self::$db->query($query);
        
        if ($resultado->num_rows) {
            self::$alertas['error'][] = 'Usuario actualmente ya registrado';
        }
        return $resultado;
    }

    public function hashed(){
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }

    public function getToken(){
        $this->token = uniqid();
    }

    public function checkPassword($usuario){
        $hashedPassword = $usuario->password;
        $checkpassword = password_verify($this->password, $hashedPassword);
        return $checkpassword;
    }

}