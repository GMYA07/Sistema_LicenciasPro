<?php

require_once __DIR__ . '/../../core/Database.php';

class TipoLicenciasModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }


    public function getAllTipoLicencias() {
        $sql = "SELECT idTipoLicencia, nombreTipoLicencia, estadoTipoLicencia FROM TipoLicencias";
        $resultado = $this->db->getConnection()->query($sql);
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }


    public function obtenerTipoLicencia($id) {
        if (empty($id) || !is_numeric($id)) {
            return false; 
        }

        $stmt = $this->db->getConnection()->prepare("SELECT idTipoLicencia, nombreTipoLicencia, estadoTipoLicencia FROM TipoLicencias WHERE idTipoLicencia = :id");
        $stmt->execute(['id' => $id]);
        
        // Si lo encuentra, devuelve un array. Si no existe, devuelve false.
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function guardarTipoLicencia($nombre) {
        if (empty(trim($nombre))) {
            return false; 
        }

        $stmt = $this->db->getConnection()->prepare("
            INSERT INTO TipoLicencias (nombreTipoLicencia, estadoTipoLicencia) 
            VALUES (:nombre, :estado)
        ");
        
        $ejecucionExitosa = $stmt->execute([
            'nombre' => trim($nombre), 
            'estado' => 1
        ]);

        if ($ejecucionExitosa) {
            return $this->db->getConnection()->lastInsertId(); // Devuelve el ID generado (ej: 5)
        } else {
            return false; // Algo falló en el servidor de base de datos
        }
    }

    public function editarTipoLicencia($id, $nombre) {
        // VALIDACIÓN: Asegurarnos que el ID sea un número válido y el nombre no esté vacío
        if (empty($id) || !is_numeric($id) || empty(trim($nombre))) {
            return false;
        }

        $stmt = $this->db->getConnection()->prepare("
            UPDATE TipoLicencias 
            SET nombreTipoLicencia = :nombre 
            WHERE idTipoLicencia = :id
        ");

        // Retorna directamente true o false según el éxito de la consulta
        return $stmt->execute([
            'nombre' => trim($nombre), 
            'id' => $id
        ]);
    }

    public function eliminarTipoLicencia($id) {
        // VALIDACIÓN: Asegurarnos que el ID sea un número válido
        if (empty($id) || !is_numeric($id)) {
            return false;
        }

        $stmt = $this->db->getConnection()->prepare("
            UPDATE TipoLicencias 
            SET estadoTipoLicencia = 0 
            WHERE idTipoLicencia = :id
        ");

        // Retorna directamente true o false según el éxito de la consulta
        return $stmt->execute(['id' => $id]);
    }
}
?>