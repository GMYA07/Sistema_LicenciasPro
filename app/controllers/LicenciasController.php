<?php

require_once __DIR__ . '/../models/LicienciasModel.php';
require_once __DIR__ . '/../models/TipoLicenciasModel.php';

class LicenciasController
{
    private $licenciasModel;
    private $tipoLicenciasModel;

    public function __construct()
    {
        $this->licenciasModel = new LicenciasModel();
        $this->tipoLicenciasModel = new TipoLicenciasModel();
    }

    // 1. MUESTRA LA PÁGINA PRINCIPAL
    public function index()
    {
        $licencias = $this->licenciasModel->getAll();
        $tipodeLicencias = $this->tipoLicenciasModel->getAllTipoLicencias();

        include '../app/views/licencias/licencias.php';
    }

    public function guardar()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $idTipoLicencia = $_POST['idTipoLicencia'] ?? null;
            $codigoLicencia = $_POST['codigoLicencia'] ?? null;
            $estadoLicencia = $_POST['estadoLicencia'] ?? 'NoInstalada';
            $fechaAdquisision = $_POST['fechaAdquisision'] ?? null;
            $fechaCaducacion = $_POST['fechaCaducacion'] ?? null;
            $idLicencia = $_POST['idLicencia'] ?? null;

            // ACTUALIZAR
            if (!empty($idLicencia) && is_numeric($idLicencia)) {

                $resultado = $this->licenciasModel->actualizarLicencia(
                    $idLicencia,
                    $idTipoLicencia,
                    $codigoLicencia,
                    $fechaAdquisision,
                    $fechaCaducacion,
                    $estadoLicencia
                );

            }
            // CREAR
            else {

                $resultado = $this->licenciasModel->guardarLicencia(
                    $idTipoLicencia,
                    $codigoLicencia,
                    $fechaAdquisision,
                    $fechaCaducacion,
                    $estadoLicencia
                );
            }

            if ($resultado) {

                header('Location: ' . BASE_URL . '/licencias');
                exit;

            } else {

                echo "Error al guardar la licencia.";

            }
        }
    }
    // 3. RECIBE LOS DATOS DEL MINI-FORMULARIO DE TIPOS (MODAL 2)
    public function guardarTipo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombreTipoLicencia'] ?? null;
            $id = $_POST['idTipoLicencia'] ?? null;

            // Si llega un id, actualizamos; si no, creamos uno nuevo
            if (!empty($id) && is_numeric($id)) {
                $resultado = $this->tipoLicenciasModel->editarTipoLicencia($id, $nombre);
            } else {
                $resultado = $this->tipoLicenciasModel->guardarTipoLicencia($nombre);
            }

            // Si la petición viene desde fetch con ?ajax=1, devolvemos JSON útil para depuración
            if (isset($_GET['ajax'])) {
                header('Content-Type: application/json');
                echo json_encode([
                    'post' => $_POST,
                    'action' => (!empty($id) && is_numeric($id)) ? 'update' : 'insert',
                    'result' => $resultado
                ]);
                exit;
            }

            if ($resultado) {
                // Redirecciona de vuelta para recargar la página y que aparezca en el select
                header('Location: ' . BASE_URL . '/licencias');
                exit;
            } else {
                http_response_code(500);
                echo "Error al guardar o actualizar el tipo de licencia.";
            }
        }
    }

    public function eliminarTipo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['idTipoLicencia'] ?? null;

            $resultado = $this->tipoLicenciasModel->eliminarTipoLicencia($id);

            if ($resultado) {
                echo "OK";
            } else {
                http_response_code(500);
                echo "Error al eliminar.";
            }
        }
    }

    // Resivie datos para la carta de estadisticas de la vista de licencias
    public function obtenerEstadisticas()
    {
        $estadisticas = $this->licenciasModel->contarLicenciasPorEstado();
        header('Content-Type: application/json');
        echo json_encode($estadisticas);
        exit;
    }

}