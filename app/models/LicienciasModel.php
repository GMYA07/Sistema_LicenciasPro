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

    public function getAll() {
        $sql = "SELECT l.idLicencia, l.codigoLicencia, l.estadoLicencia, t.nombreTipoLicencia 
                FROM Licencias l
                JOIN TipoLicencias t ON l.idTipoLicencia = t.idTipoLicencia";
        $resultado = $this->db->getConnection()->query($sql);
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>