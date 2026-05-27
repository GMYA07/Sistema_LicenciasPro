<?php

require_once __DIR__ . '/../../core/Database.php';
class AreasModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function obtenerArea($idArea) {

        $stmt = $this->db->getConnection()->prepare("SELECT idArea, nombreArea, edificio, numEquipos, estadoCentroComputo, (SELECT COUNT(*) FROM computadoras WHERE idAreaComputadora = areas.idArea) AS totalComputadoras FROM areas WHERE idArea = :id");

        // Ejecutamos pasando el parámetro
        $stmt->execute(['id' => $idArea]);

        // Le pedimos explícitamente un arreglo asociativo limpio
        $area = $stmt->fetch(PDO::FETCH_ASSOC);

        // Retornará el arreglo con los datos, o false si no encontró nada
        return $area;
    }
    public function obtenerAreas(){

        $sql = "SELECT 
                idArea, 
                nombreArea, 
                edificio, 
                numEquipos, 
                estadoCentroComputo,
                (SELECT COUNT(*) FROM computadoras WHERE idAreaComputadora = areas.idArea) AS totalComputadoras
            FROM areas";
        $resultado = $this->db->getConnection()->query($sql);

        //retornamos un arreglo de datos
        return $resultado->fetchAll(PDO::FETCH_ASSOC);

    }

    // Método para agregar un área
    public function agregarArea(array $datos) {
        if (!$this->validarNombreAreaUnico($datos['edificio'])) {
            return false; // El nombre del área no es único
        }

        $stmt = $this->db->getConnection()->prepare("
            INSERT INTO areas (nombreArea, edificio, numEquipos, estadoCentroComputo) 
            VALUES (:nombreArea, :edificio, :numEquipos, :estadoCentroComputo)
        ");

        return $stmt->execute([
            'nombreArea'          => $datos['nombreArea'],
            'edificio'            => $datos['edificio'],
            'numEquipos'          => (int) $datos['numEquipos'],
            // Usamos un operador null coalescing para dar robustez y valores por defecto
            'estadoCentroComputo' => (bool) ($datos['estadoCentroComputo'] ?? 0)
        ]);
    }

    // Método para actualizar un área
    public function actualizarArea(int $idArea, array $datos) {

    if (!$this->validarNombreAreaUnico($datos['edificio'], $idArea)) {
        return false; // El nombre del área no es único
    }

        $stmt = $this->db->getConnection()->prepare("
            UPDATE areas 
            SET nombreArea = :nombreArea, edificio = :edificio, numEquipos = :numEquipos, estadoCentroComputo = :estadoCentroComputo
            WHERE idArea = :idArea
        ");
    
        return $stmt->execute([
            'idArea'              => $idArea,
            'nombreArea'          => $datos['nombreArea'],
            'edificio'            => $datos['edificio'],
            'numEquipos'          => (int) $datos['numEquipos'],
            // Usamos un operador null coalescing para dar robustez y valores por defecto
            'estadoCentroComputo' => (bool) ($datos['estadoCentroComputo'] ?? false)
        ]);
    }

    // Método para eliminar un área
    public function eliminarArea(int $idArea) {
        $stmt = $this->db->getConnection()->prepare(
            "UPDATE areas SET estadoCentroComputo = 0 WHERE idArea = :id"
        );

        return $stmt->execute(['id' => $idArea]);
    }


    // metodo de validacion para el formulario de areas de nombre de area unico
    public function validarNombreAreaUnico(string $edificio, ?int $idArea = null): bool {
        $sql = "SELECT COUNT(*) FROM areas WHERE edificio = :edificio AND estadoCentroComputo = 1";
        $params = ['edificio' => $edificio];

        if ($idArea) {
            $sql .= " AND idArea != :idArea";
            $params['idArea'] = $idArea;
        }

        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute($params);
        $count = $stmt->fetchColumn();

        return $count == 0; // Retorna true si el nombre es único
    }

}