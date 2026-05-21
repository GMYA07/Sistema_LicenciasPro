<?php
require_once __DIR__ . '/../../core/Database.php';

class EquipoModel{

    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function obtenerEquipoById($idEquipo){
        $stmt = $this->db->getConnection()->prepare('SELECT idComputadora, idAreaComputadora, Marca, Modelo, Serial, estadoComputadora FROM computadoras WHERE idComputadora = :id');
        $stmt->execute(['id' => $idEquipo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function obtenerEquiposPorArea($idArea){

        $stmt = $this->db->getConnection()->prepare("SELECT idComputadora, idAreaComputadora, Marca, Modelo, Serial, estadoComputadora FROM computadoras WHERE idAreaComputadora = :idArea");
        $stmt->execute(['idArea' => $idArea]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function eliminarEquipo($idEquipo)
    {
        $stmt = $this->db->getConnection()->prepare("DELETE FROM computadoras WHERE idComputadora = :id");
        return $stmt->execute(['id' => $idEquipo]);

    }

    public function guardarEquipo($data){

        $stmt = $this->db->getConnection()->prepare("INSERT INTO computadoras (idAreaComputadora, Marca, Modelo, Serial, estadoComputadora) VALUES (:idArea, :marca, :modelo, :serial, :estado)");
        $stmt->bindParam(":idArea", $data['idAreaComputadora']);
        $stmt->bindParam(":marca", $data['Marca']);
        $stmt->bindParam(":modelo", $data['Modelo']);
        $stmt->bindParam(":serial", $data['Serial']);
        $stmt->bindParam(":estado", $data['estadoComputadora']);
        // retornamos el resultado de la ejecución
        return $stmt->execute();

    }

    public function editarEquipo($data){

        $stmt = $this->db->getConnection()->prepare("UPDATE computadoras SET Marca = :marca, Modelo = :modelo, Serial = :serial, estadoComputadora = :estado WHERE idComputadora = :id");
        $stmt->bindParam(":id", $data['idComputadora']);
        $stmt->bindParam(":marca", $data['Marca']);
        $stmt->bindParam(":modelo", $data['Modelo']);
        $stmt->bindParam(":serial", $data['Serial']);
        $stmt->bindParam(":estado", $data['estadoComputadora']);
        // retornamos el resultado de la ejecución
        return $stmt->execute();
    }

}