<?php
require_once __DIR__ . '/../../core/Database.php';

class BitacorasModel {

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function guardarBitacora($data){

        try {
            $conexion = $this->db->getConnection();

            $stmt = $conexion->prepare("INSERT INTO bitacoras (idUsuario, idArea, fechaRevision, totalEquipos, equiposConLicencia, equiposSinLicencia, observaciones) 
            VALUES (:idUsuario, :idArea, :fechaRevision, :totalEquipos, :equiposConLicencia, :equiposSinLicencia,:observaciones)");
            $stmt->bindParam(':idUsuario', $data['idUsuario']);
            $stmt->bindParam(':idArea', $data['idArea']);
            $stmt->bindParam(':fechaRevision', $data['fechaRevision']);
            $stmt->bindParam(':totalEquipos', $data['totalEquipos']);
            $stmt->bindParam(':equiposConLicencia', $data['equiposConLicencia']);
            $stmt->bindParam(':equiposSinLicencia', $data['equiposSinLicencia']);
            $stmt->bindParam(':observaciones', $data['observaciones']);
            $stmt->execute();

            return true;

        }catch (Exception $e) {
            // Manejo de errores
            error_log("Error al guardar bitácora: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerBitacoraPorId($idBitacora){
        $conexion = $this->db->getConnection();

        try {
            $stmt = $conexion->prepare("
                SELECT 
                    b.idBitacora, 
                    b.idUsuario, 
                    b.idArea, 
                    b.fechaRevision, 
                    b.totalEquipos, 
                    b.equiposConLicencia, 
                    b.equiposSinLicencia, 
                    b.observaciones, 
                    a.nombreArea, 
                    u.usuario 
                FROM bitacoras as b 
                INNER JOIN usuarios as u ON b.idUsuario = u.idUsuario 
                INNER JOIN areas as a ON b.idArea = a.idArea
                WHERE b.idBitacora = :idBitacora
                ORDER BY b.fechaRevision DESC
            ");
            $stmt->bindParam(':idBitacora', $idBitacora);

            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);

        }catch (Exception $e) {
            // Manejo de errores
            error_log("Error al obtener bitácora: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerBitacoras(){
        $conexion = $this->db->getConnection();

        try {
            $stmt = $conexion->prepare("
                SELECT 
                    b.idBitacora, 
                    b.idUsuario, 
                    b.idArea, 
                    b.fechaRevision, 
                    b.totalEquipos, 
                    b.equiposConLicencia, 
                    b.equiposSinLicencia, 
                    b.observaciones, 
                    a.nombreArea, 
                    u.usuario 
                FROM bitacoras as b 
                INNER JOIN usuarios as u ON b.idUsuario = u.idUsuario 
                INNER JOIN areas as a ON b.idArea = a.idArea
                ORDER BY b.fechaRevision DESC
            ");

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }catch (Exception $e) {
            // Manejo de errores
            error_log("Error al obtener bitácoras: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerEstadisticasParaBitacora($idArea)
    {
        // Usamos LEFT JOIN para traer TODAS las compus del área,
        // y cruzamos con la tabla pivote de licencias para ver cuáles tienen software
        $sql = "SELECT 
                COUNT(DISTINCT c.idComputadora) AS totalEquipos,
                COUNT(DISTINCT pivote.id_computadora) AS equiposConLicencia
            FROM computadoras c
            LEFT JOIN licencias_detalles pivote ON c.idComputadora = pivote.id_computadora
            WHERE c.idAreaComputadora = :idArea";

        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':idArea', $idArea, PDO::PARAM_INT);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si no hay equipos, la BD devuelve null, así que aseguramos que sean ceros
        $totalEquipos = $resultado['totalEquipos'] ?? 0;
        $equiposConLicencia = $resultado['equiposConLicencia'] ?? 0;

        // Calculamos los que no tienen licencia con una resta simple
        $equiposSinLicencia = $totalEquipos - $equiposConLicencia;

        return [
            'totalEquipos' => $totalEquipos,
            'equiposConLicencia' => $equiposConLicencia,
            'equiposSinLicencia' => $equiposSinLicencia
        ];
    }

}