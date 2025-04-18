<?php 
require __DIR__ . '/../vendor/autoload.php';
use Model\ActiveRecord;
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

require 'funciones.php';
require 'database.php';

// Conectarnos a la base de datos
$db = conectarDB();
ActiveRecord::setDB($db);
