<?php

require_once __DIR__ . '/../models/AreasModel.php';


class AreasController {

    private $areasModel;

    public function __construct() {
        $this->areasModel = new AreasModel();
    }


    public function index() {
        $areas = $this->areasModel->obtenerAreas();

        include '../app/views/areas/areas.php';
    }

    // Metodo para editar o crear un area
    public function guardar() {
        // Verificamos que se haya enviado el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idArea = $_POST['idArea'] ?? null; // Puede ser null para nuevas áreas

            $datos = [
                'nombreArea' => $_POST['nombreArea'],
                'edificio' => $_POST['edificio'],
                'numEquipos' => $_POST['numEquipos'],
                'estadoCentroComputo' => $_POST['estadoCentroComputo'] ?? 0 // Valor por defecto si no se envía
            ];

            if ($idArea) {
                // Actualizar área existente
                $resultado = $this->areasModel->actualizarArea((int)$idArea, $datos);
            } else {
                // Agregar nueva área
                $resultado = $this->areasModel->agregarArea($datos);
            }

            if ($resultado) {
                $_SESSION['mensaje_exito'] = $idArea ? 'Área actualizada correctamente.' : 'Área agregada correctamente.';
            } else {
                $_SESSION['mensaje_error'] = 'No se pudo guardar el área.';
            }
        }

        // Redirigimos de vuelta a la lista de áreas después de guardar
        header('Location: ' . BASE_URL . '/areas');
        exit();
    }

    // Método para eliminar un área (acepta POST con 'idArea' o GET con 'id')
    public function delete() {
        $id = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['idArea'] ?? null;
        } else {
            $id = $_GET['id'] ?? null;
        }

        if ($id) {
            $resultado = $this->areasModel->eliminarArea((int)$id);
            if ($resultado) {
                $_SESSION['mensaje_exito'] = 'Área eliminada correctamente.';
            } else {
                $_SESSION['mensaje_error'] = 'No se pudo eliminar el área.';
            }
        } else {
            $_SESSION['mensaje_error'] = 'ID de área inválido.';
        }

        header('Location: ' . BASE_URL . '/areas');
        exit();
    }
}
