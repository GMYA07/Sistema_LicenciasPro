<?php

require_once __DIR__ . '/../../core/Database.php';
class AreasModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function obtenerArea($idArea) {

        $stmt = $this->db->getConnection()->prepare("SELECT idArea, nombreArea, edificio, numEquipos, estadoCentroComputo FROM areas WHERE idArea = :id");

        // Ejecutamos pasando el parámetro
        $stmt->execute(['id' => $idArea]);

        // Le pedimos explícitamente un arreglo asociativo limpio
        $area = $stmt->fetch(PDO::FETCH_ASSOC);

        // Retornará el arreglo con los datos, o false si no encontró nada
        return $area;
    }
    public function obtenerAreas(){

        $sql = "SELECT idArea, nombreArea, edificio, numEquipos, estadoCentroComputo FROM areas";
        $resultado = $this->db->getConnection()->query($sql);

        //retornamos un arreglo de datos
        return $resultado->fetchAll(PDO::FETCH_ASSOC);

    }

}