<?php
class Database {
    private $conexion;

    public function __construct(){
        //cargamos las variables de entorno
        $host = $_ENV['DB_HOST'];
        $user = $_ENV['DB_USER'];
        $pass = $_ENV['DB_PASS'] ?? '';
        $name = $_ENV['DB_NAME'];

        $dsn = "mysql:host={$host}";
    }
}