<?php

require_once __DIR__ . '/../../core/Database.php';

class LicenciasModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function guardarLicencia($idTipoLicencia, $codigoLicencia, $estadoLicencia) {
        // Ajustado a las columnas reales: idTipoLicencia, codigoLicencia, estadoLicencia
        $stmt = $this->db->getConnection()->prepare("
            INSERT INTO Licencias (idTipoLicencia, codigoLicencia, estadoLicencia) 
            VALUES (:idTipoLicencia, :codigoLicencia, :estadoLicencia)
        ");
        
        $stmt->execute([
            'idTipoLicencia' => $idTipoLicencia,
            'codigoLicencia' => $codigoLicencia,
            'estadoLicencia' => $estadoLicencia // Recuerda que es un ENUM: 'Vigente', 'Expirada', 'No instalada'
        ]);
        
        return $this->db->getConnection()->lastInsertId();
    }

    public function actualizarLicencia($idLicencia, $idTipoLicencia, $codigoLicencia, $estadoLicencia) {
        $stmt = $this->db->getConnection()->prepare("
            UPDATE Licencias
            SET idTipoLicencia = :idTipoLicencia,
                codigoLicencia = :codigoLicencia,
                estadoLicencia = :estadoLicencia
            WHERE idLicencia = :idLicencia
        ");

        return $stmt->execute([
            'idLicencia' => $idLicencia,
            'idTipoLicencia' => $idTipoLicencia,
            'codigoLicencia' => $codigoLicencia,
            'estadoLicencia' => $estadoLicencia,
        ]);
    }

    public function getAll() {
        $sql = "SELECT 
            s.idLicencia, 
            s.idTipoLicencia, 
            t.nombreTipoLicencia, 
            s.codigoLicencia, 
            s.estadoLicencia 
        FROM Licencias s
        INNER JOIN TipoLicencias t ON t.idTipoLicencia = s.idTipoLicencia
        ORDER BY FIELD(s.estadoLicencia, 'Vigente', 'No Instalada', 'Expirada') ASC";
            
        $resultado = $this->db->getConnection()->query($sql);
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    // consultas para cartas de estadistias de la vista de licencias
    public function contarLicenciasPorEstado() {
        $sql = "SELECT estadoLicencia, COUNT(*) AS cantidad FROM Licencias GROUP BY estadoLicencia";
        $resultado = $this->db->getConnection()->query($sql);
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>