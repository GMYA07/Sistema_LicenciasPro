<?php

require_once __DIR__ . '/../../core/Database.php';

class LicenciasModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function guardarLicencia(
        $idTipoLicencia,
        $codigoLicencia,
        $fechaAdquisision,
        $fechaCaducacion,
        $estadoLicencia
    ) {

        $stmt = $this->db->getConnection()->prepare("
        INSERT INTO licencias 
        (
            idTipoLicencia,
            codigoLicencia,
            fechaAdquisision,
            fechaCaducacion,
            estadoLicencia
        ) 
        VALUES 
        (
            :idTipoLicencia,
            :codigoLicencia,
            :fechaAdquisision,
            :fechaCaducacion,
            :estadoLicencia
        )
    ");

        $stmt->execute([
            'idTipoLicencia' => $idTipoLicencia,
            'codigoLicencia' => $codigoLicencia,
            'fechaAdquisision' => $fechaAdquisision,
            'fechaCaducacion' => $fechaCaducacion,
            'estadoLicencia' => $estadoLicencia
        ]);

        return $this->db->getConnection()->lastInsertId();
    }


    public function actualizarLicencia(
        $idLicencia,
        $idTipoLicencia,
        $codigoLicencia,
        $fechaAdquisision,
        $fechaCaducacion,
        $estadoLicencia
    ) {

        $stmt = $this->db->getConnection()->prepare("
        UPDATE licencias
        SET idTipoLicencia = :idTipoLicencia,
            codigoLicencia = :codigoLicencia,
            fechaAdquisision = :fechaAdquisision,
            fechaCaducacion = :fechaCaducacion,
            estadoLicencia = :estadoLicencia
        WHERE idLicencia = :idLicencia
    ");

        return $stmt->execute([
            'idLicencia' => $idLicencia,
            'idTipoLicencia' => $idTipoLicencia,
            'codigoLicencia' => $codigoLicencia,
            'fechaAdquisision' => $fechaAdquisision,
            'fechaCaducacion' => $fechaCaducacion,
            'estadoLicencia' => $estadoLicencia
        ]);
    }

    public function getAll()
    {
        $sql = "
        SELECT 
            s.idLicencia,
            s.idTipoLicencia,
            t.nombreTipoLicencia,
            s.codigoLicencia,
            s.estadoLicencia,
            s.fechaAdquisision,
            s.fechaCaducacion,

            CASE 
                WHEN ld.id_licencia IS NOT NULL 
                THEN 1
                ELSE 0
            END AS equipoAsignado

        FROM licencias s

        INNER JOIN tipolicencias t 
            ON t.idTipoLicencia = s.idTipoLicencia

        LEFT JOIN licencias_detalles ld
            ON ld.id_licencia = s.idLicencia

        ORDER BY FIELD(
            s.estadoLicencia,
            'Instalada',
            'NoInstalada',
            'Expirada'
        ) ASC";

        $resultado = $this->db->getConnection()->query($sql);

        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    // consultas para cartas de estadistias de la vista de licencias
    public function contarLicenciasPorEstado()
    {
        $sql = "SELECT estadoLicencia, COUNT(*) AS cantidad FROM Licencias GROUP BY estadoLicencia";
        $resultado = $this->db->getConnection()->query($sql);
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerLicenciasPorEstado($estado)
    {

        $stmt = $this->db->getConnection()->prepare("
        SELECT
             l.idLicencia,
             t.nombreTipoLicencia,
             l.codigoLicencia,
             l.fechaAdquisision,
             l.fechaCaducacion,
             l.estadoLicencia 
         FROM Licencias as l
         INNER JOIN tipoLicencias as t ON t.idTipoLicencia = l.idTipoLicencia
         WHERE l.estadoLicencia = :estado
        ");

        $stmt->execute(['estado' => $estado]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //funcoin para traer los enum 
    public function obtenerEstadosLicencia()
    {
        $sql = "SHOW COLUMNS FROM Licencias LIKE 'estadoLicencia'";
        $resultado = $this->db->getConnection()->query($sql);
        $columna = $resultado->fetch(PDO::FETCH_ASSOC);

        preg_match("/^enum\('(.*)'\)$/", $columna['Type'], $matches);
        if (isset($matches[1])) {
            return explode("','", $matches[1]);
        }

        return [];
    }

}

