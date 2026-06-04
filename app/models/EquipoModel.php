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

    public function obtenerEquiposConLicenciasPorArea($idArea){
        $conexion = $this->db->getConnection();

        //Conseguimos la info de las maquinas
        $stmtEquipos = $conexion->prepare("SELECT * FROM computadoras WHERE idAreaComputadora = :idArea");
        $stmtEquipos->execute(['idArea' => $idArea]);
        $equipos = $stmtEquipos->fetchAll(PDO::FETCH_ASSOC);

        //Ahora optenemos las licencias de las maquinas
        $stmtLicencias = $conexion->prepare("
            SELECT 
                t.nombreTipoLicencia, 
                l.codigoLicencia, 
                l.estadoLicencia
            FROM licencias_detalles ld
            INNER JOIN licencias l ON ld.id_licencia = l.idLicencia
            INNER JOIN tipolicencias t ON l.idTipoLicencia = t.idTipoLicencia
            WHERE ld.id_computadora = :idComputadora
        ");

        //Creamos la vinculacion del arreglo de las licencias con la maquina
        foreach ($equipos as $key => $equipo) {

            // Ejecutamos la consulta pasándole el ID de la computadora actual en el ciclo
            $stmtLicencias->execute(['idComputadora' => $equipo['idComputadora']]);

            // Traemos todas sus licencias en un arreglo
            $licenciasDeEstaCompu = $stmtLicencias->fetchAll(PDO::FETCH_ASSOC);

            // Creamos la llave 'licencias' adentro de este equipo
            $equipos[$key]['licencias'] = $licenciasDeEstaCompu;
        }

        return $equipos;

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

    public function eliminarEquipo($idEquipo)
    {
        //Eliminaremos las relaciones q tenga con licencias los equipos

        $stmt = $this->db->getConnection()->prepare("DELETE FROM computadoras WHERE idComputadora = :id");
        return $stmt->execute(['id' => $idEquipo]);

    }

    public function editarEquipo($data){

        $stmt = $this->db->getConnection()->prepare("UPDATE computadoras SET idAreaComputadora = :area, Marca = :marca, Modelo = :modelo, Serial = :serial, estadoComputadora = :estado WHERE idComputadora = :id");
        $stmt->bindParam(":id", $data['idComputadora']);
        $stmt->bindParam(":area", $data['idAreaComputadora']);
        $stmt->bindParam(":marca", $data['Marca']);
        $stmt->bindParam(":modelo", $data['Modelo']);
        $stmt->bindParam(":serial", $data['Serial']);
        $stmt->bindParam(":estado", $data['estadoComputadora']);
        // retornamos el resultado de la ejecución
        return $stmt->execute();
    }



}