<?php

namespace Model;

class AdminCita extends ActiveRecord{
    protected static $tabla = 'citasServicios';
    protected static $columnasDB = ['id', 'hora', 'cliente', 'email', 'movil','servicio', 'precio'];

    public $id;
    public $hora;
    public $cliente;
    public $email;
    public $movil;
    public $servicio;
    public $precio;

    public function __construct($args=[]){
        $this->id = $args['id']?? null;
        $this->hora = $args['hora']?? '';
        $this->cliente = $args['cliente']?? '';
        $this->email = $args['email']?? '';
        $this->movil = $args['movil']?? '';
        $this->servicio = $args['servicio']?? '';
        $this->precio = $args['precio']?? '';
    }

}