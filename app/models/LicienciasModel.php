<?php

require_once __DIR__ . '/../../core/Database.php';

class LicenciasModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function guardarLicencia($data)
    {

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

        if ($this->existeCodigoLicencia($data['codigoLicencia'], null)) {
            throw new Exception("El código de licencia ya existe para otra licencia.");
        }

        $stmt->execute([
            'idTipoLicencia' => $data['idTipoLicencia'],
            'codigoLicencia' => $data['codigoLicencia'],
            'fechaAdquisision' => $data['fechaAdquisision'],
            'fechaCaducacion' => $data['fechaCaducacion'],
            'estadoLicencia' => $data['estadoLicencia']
        ]);

        return $this->db->getConnection()->lastInsertId();
    }


public function actualizarLicencia($idLicencia, array $data)
{
    // VALIDAR SI EXISTE
    $validar = $this->db->getConnection()->prepare("
        SELECT idLicencia
        FROM licencias
        WHERE idLicencia = :idLicencia
    ");

    $validar->execute([
        'idLicencia' => $idLicencia
    ]);

    if ($validar->rowCount() === 0) {
        throw new Exception("La licencia con ID $idLicencia no existe.");
    }

    // VALIDAR CÓDIGO DUPLICADO
    if ($this->existeCodigoLicencia($data['codigoLicencia'], $idLicencia)) {
        throw new Exception("El código de licencia ya existe para otra licencia.");
    }

    // ACTUALIZAR
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
        'idTipoLicencia' => $data['idTipoLicencia'],
        'codigoLicencia' => $data['codigoLicencia'],
        'fechaAdquisision' => $data['fechaAdquisision'],
        'fechaCaducacion' => $data['fechaCaducacion'],
        'estadoLicencia' => $data['estadoLicencia']
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

            CASE
                WHEN s.fechaCaducacion IS NOT NULL
                    AND s.fechaCaducacion < CURDATE()
                THEN 'Expirada'

                ELSE s.estadoLicencia
            END AS estadoLicencia,

            s.fechaAdquisision,
            s.fechaCaducacion,

            c.idComputadora,

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

        LEFT JOIN computadoras c
            ON c.idComputadora = ld.id_computadora

        ORDER BY FIELD(
            estadoLicencia,
            'Instalada',
            'NoInstalada',
            'Expirada'
        ) ASC

        LIMIT 0, 25;  
        ";


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

    public function obtenerLicenciasPorId($id){

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
         WHERE l.idLicencia = :idLicencia
        ");

        $stmt->execute(['idLicencia' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

    public function asignarLicenciaEquipo($data){
        $stmt = $this->db->getConnection()->prepare("INSERT INTO licencias_detalles (id_computadora, id_licencia) VALUES (:idComputadora, :idLicencia)");
        $stmt->bindParam(':idComputadora', $data['idEquipo']);
        $stmt->bindParam(':idLicencia', $data['idLicencia']);

        return $stmt->execute();
    }

    public function obtenerLicenciasEquipoVinculado($idEquipo){

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
         INNER JOIN licencias_detalles as ld ON  ld.id_licencia = l.idLicencia
         WHERE ld.id_computadora = :idComputadora
        ");

        $stmt->execute(['idComputadora' => $idEquipo]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function eliminarRelacionLicenciaEquipo($data){
        try {
            $stmt = $this->db->getConnection()->prepare("DELETE FROM licencias_detalles WHERE id_computadora = :idComputadora AND id_licencia = :idLicencia");
            $stmt->bindParam(':idComputadora', $data['idComputadora']);
            $stmt->bindParam(':idLicencia', $data['idLicencia']);
            return $stmt->execute();
        }catch (exception $e){
            echo $e->getMessage();
            return false;
        }
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


    // funciona pra validar si codigo de licencia ya existe
    public function existeCodigoLicencia($codigo, $idLicencia = null)
    {
        $sql = "SELECT COUNT(*) FROM Licencias WHERE codigoLicencia = :codigo";
        $params = ['codigo' => $codigo];

        if ($idLicencia) {
            $sql .= " AND idLicencia != :idLicencia";
            $params['idLicencia'] = $idLicencia;
        }

        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

}
