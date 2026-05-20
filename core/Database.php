<?php
class Database {
    private $conexion;

    public function __construct(){
        //cargamos las variables de entorno
        $host = $_ENV['DB_HOST'];
        $user = $_ENV['DB_USER'];
        $pass = $_ENV['DB_PASS'] ?? '';
        $name = $_ENV['DB_NAME'];

        $dsn = "mysql:host={$host};dbname={$name};charset=utf8mb4";

        $opciones = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, //Nos devuelve objetos
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try{
            $this->conexion = new PDO($dsn, $user, $pass, $opciones);
        }catch (PDOException $e){
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public function getConnection(){
        return $this->conexion;
    }

}