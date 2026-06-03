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
            numPermitVinculados,
            fechaAdquisision,
            fechaCaducacion,
            estadoLicencia
        ) 
        VALUES 
        (
            :idTipoLicencia,
            :codigoLicencia,
            :numPermitVinculados,
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
            'numPermitVinculados' => $data['numPermitVinculados'] ?? 1,
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
            numPermitVinculados = :numPermitVinculados,
            fechaAdquisision = :fechaAdquisision,
            fechaCaducacion = :fechaCaducacion,
            estadoLicencia = :estadoLicencia
        WHERE idLicencia = :idLicencia
    ");

    return $stmt->execute([
        'idLicencia' => $idLicencia,
        'idTipoLicencia' => $data['idTipoLicencia'],
        'codigoLicencia' => $data['codigoLicencia'],
        'numPermitVinculados' => $data['numPermitVinculados'] ?? 1,
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
            s.numPermitVinculados,

            CASE
                WHEN s.fechaCaducacion IS NOT NULL
                    AND s.fechaCaducacion < CURDATE()
                THEN 'Expirada'

                ELSE s.estadoLicencia
            END AS estadoLicencia,

            s.fechaAdquisision,
            s.fechaCaducacion,

            COUNT(ld.id_computadora) as totalAsignados,
            GROUP_CONCAT(CONCAT(c.Marca, ' ', c.Modelo, ' (', c.Serial, ')') SEPARATOR '||') AS computadorasAsignadas

        FROM licencias s

        INNER JOIN tipolicencias t 
            ON t.idTipoLicencia = s.idTipoLicencia

        LEFT JOIN licencias_detalles ld
            ON ld.id_licencia = s.idLicencia

        LEFT JOIN computadoras c
            ON c.idComputadora = ld.id_computadora

        GROUP BY s.idLicencia, s.idTipoLicencia, t.nombreTipoLicencia, s.codigoLicencia, s.numPermitVinculados, s.estadoLicencia, s.fechaAdquisision, s.fechaCaducacion

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
             l.idTipoLicencia,
             t.nombreTipoLicencia,
             l.codigoLicencia,
             l.numPermitVinculados,
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

    // Helper to count active links for a license
    public function contarComputadorasVinculadas($idLicencia) {
        $stmt = $this->db->getConnection()->prepare("SELECT COUNT(*) FROM licencias_detalles WHERE id_licencia = :idLicencia");
        $stmt->execute(['idLicencia' => $idLicencia]);
        return (int) $stmt->fetchColumn();
    }

    // Helper to check if a computer is already linked to a specific license
    public function esEquipoVinculadoALicencia($idEquipo, $idLicencia) {
        $stmt = $this->db->getConnection()->prepare("SELECT COUNT(*) FROM licencias_detalles WHERE id_computadora = :idEquipo AND id_licencia = :idLicencia");
        $stmt->execute(['idEquipo' => $idEquipo, 'idLicencia' => $idLicencia]);
        return (int) $stmt->fetchColumn() > 0;
    }

    // Fetch licenses that are not expired and still have activation slots left
    public function obtenerLicenciasDisponiblesInstalacion() {
        $sql = "
        SELECT 
            l.idLicencia,
            t.nombreTipoLicencia,
            l.codigoLicencia,
            l.numPermitVinculados,
            l.fechaAdquisision,
            l.fechaCaducacion,
            l.estadoLicencia,
            (SELECT COUNT(*) FROM licencias_detalles WHERE id_licencia = l.idLicencia) as totalAsignados
        FROM licencias l
        INNER JOIN tipolicencias t ON t.idTipoLicencia = l.idTipoLicencia
        WHERE (l.fechaCaducacion IS NULL OR l.fechaCaducacion >= CURDATE())
          AND l.estadoLicencia != 'Expirada'
        HAVING totalAsignados < COALESCE(l.numPermitVinculados, 1)
        ORDER BY t.nombreTipoLicencia ASC
        ";
        $resultado = $this->db->getConnection()->query($sql);
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    // Automatically update the state of the license based on current active links
    public function actualizarEstadoAutomatico($idLicencia) {
        $lic = $this->obtenerLicenciasPorId($idLicencia);
        if (!$lic) return;

        // 1. Check if expired
        if (!empty($lic['fechaCaducacion']) && $lic['fechaCaducacion'] !== '0000-00-00') {
            if (strtotime($lic['fechaCaducacion']) < time()) {
                $stmt = $this->db->getConnection()->prepare("UPDATE licencias SET estadoLicencia = 'Expirada' WHERE idLicencia = :id");
                $stmt->execute(['id' => $idLicencia]);
                return;
            }
        }

        // 2. Count active links and update status
        $links = $this->contarComputadorasVinculadas($idLicencia);
        $nuevoEstado = ($links > 0) ? 'Instalada' : 'NoInstalada';

        $stmt = $this->db->getConnection()->prepare("UPDATE licencias SET estadoLicencia = :estado WHERE idLicencia = :id");
        $stmt->execute(['estado' => $nuevoEstado, 'id' => $idLicencia]);
    }

    public function asignarLicenciaEquipo($data){
        try {
            $conexion = $this->db->getConnection();

            //Iniciamos la transacción
            $conexion->beginTransaction();

            //Hacemos el INSERT
            $stmt = $conexion->prepare("INSERT INTO licencias_detalles (id_computadora, id_licencia) VALUES (:idComputadora, :idLicencia)");
            $stmt->bindParam(':idComputadora', $data['idEquipo']);
            $stmt->bindParam(':idLicencia', $data['idLicencia']);
            $stmt->execute();

            //Hacemos el UPDATE
            $stmt2 = $conexion->prepare("UPDATE licencias SET estadoLicencia = 'Instalada' WHERE idLicencia = :idLicencia");
            $stmt2->execute(['idLicencia' => $data['idLicencia']]);

            //guardamos todo de forma permanente
            $conexion->commit();

            return true;

        }catch (PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }

    public function eliminarRelacionLicenciaEquipo($data){
        try {
            $conexion = $this->db->getConnection();

            //Iniciamos la transacción
            $conexion->beginTransaction();

            $stmt = $conexion->prepare("DELETE FROM licencias_detalles WHERE id_computadora = :idComputadora AND id_licencia = :idLicencia");
            $stmt->bindParam(':idComputadora', $data['idComputadora']);
            $stmt->bindParam(':idLicencia', $data['idLicencia']);
            $stmt->execute();

            $stmt2 = $conexion->prepare("
                UPDATE licencias 
                SET estadoLicencia = 'NoInstalada' 
                WHERE idLicencia = :idLicencia1 
                AND (SELECT COUNT(*) FROM licencias_detalles WHERE id_licencia = :idLicencia2) = 0
            ");

            $stmt2->execute([
                'idLicencia1' => $data['idLicencia'],
                'idLicencia2' => $data['idLicencia']
            ]);

            $conexion->commit();

            return true;

        }catch (exception $e){
            echo $e->getMessage();
            return false;
        }
    }

    public function validarReglasAsignacion($idLicencia,$idComputadora) {
        $conexion = $this->db->getConnection();

        //Validacion para ver si ya tiene exactamente esa licencia ya asignada
        $stmt1 = $conexion->prepare("SELECT COUNT(*) FROM licencias_detalles WHERE id_licencia = ? AND id_computadora = ?");
        $stmt1->execute([$idLicencia, $idComputadora]);

        if ($stmt1->fetchColumn() > 0) {
            return "El equipo ya tiene esta licencia específica vinculada.";
        }

        //2da validacion para ver que categorias de licencias son y si cumplen para asignarle
        $stmt2 = $conexion->prepare("
            SELECT t.categoriaLicencia, t.nombreTipoLicencia 
            FROM licencias l 
            INNER JOIN tipolicencias t ON l.idTipoLicencia = t.idTipoLicencia 
            WHERE l.idLicencia = ?
        ");
        $stmt2->execute([$idLicencia]);
        $infoLicencia = $stmt2->fetch(PDO::FETCH_ASSOC);

        $categoriaNueva = $infoLicencia['categoriaLicencia']; //Extrae la categoria de esa licencia

        //Este arreglo nos ayuda a guardar las categorias exclusivas q solo se permiten 1 vez
        $categoriasExclusivas = ['SO', 'Antivirus', 'Office'];

        if (in_array($categoriaNueva, $categoriasExclusivas)) {
            $stmt3 = $conexion->prepare("
                SELECT COUNT(*) 
                FROM licencias_detalles ld
                INNER JOIN licencias l ON ld.id_licencia = l.idLicencia
                INNER JOIN tipolicencias t ON l.idTipoLicencia = t.idTipoLicencia
                WHERE ld.id_computadora = ? AND t.categoriaLicencia = ?
            ");
            $stmt3->execute([$idComputadora, $categoriaNueva]);

            if ($stmt3->fetchColumn() > 0) {
                return "Bloqueado: La máquina ya tiene un {$categoriaNueva} instalado. Debes desvincularlo primero.";
            }
        }

        return true; // Si pasa todas las validaciones, se le da un true

    }

}
