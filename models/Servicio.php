<?php

namespace Model;

class Servicio extends ActiveRecord{
    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id', 'nombre', 'precio'];

    public $id;
    public $nombre;
    public $precio;

    public function __construct($args = []){
        $this->id = $args['id']?? null;
        $this->nombre = $args['nombre']?? '';
        $this->precio = $args['precio']?? '';
    }

    public function validar(){
        if (!$this->nombre) {
            self::$alertas['error'][] = 'Nombre de Servicio Obligatorio';
        }
        if (!$this->precio) {
            self::$alertas['error'][] = 'Precio Obligatorio';
        }
        if ($this->precio > 999) {
            self::$alertas['error'][] = 'Precio debe ser menos de 1000';
        }

        return static::$alertas;
    }
}