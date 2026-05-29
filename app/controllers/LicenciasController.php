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

            try {

                $idLicencia = $_POST['idLicencia'] ?? null;

                $data = [
                    'idTipoLicencia' => trim($_POST['idTipoLicencia'] ?? ''),
                    'codigoLicencia' => trim($_POST['codigoLicencia'] ?? ''),
                    'fechaAdquisision' => trim($_POST['fechaAdquisision'] ?? ''),
                    'fechaCaducacion' => trim($_POST['fechaCaducacion'] ?? ''),
                    'estadoLicencia' => trim($_POST['estadoLicencia'] ?? '')
                ];

                // VALIDACIONES
                if (empty($data['idTipoLicencia'])) {
                    throw new Exception("Debe seleccionar un tipo de licencia.");
                }

                if (empty($data['codigoLicencia'])) {
                    throw new Exception("El código de licencia es obligatorio.");
                }

                if (empty($data['fechaAdquisision'])) {
                    throw new Exception("La fecha de adquisición es obligatoria.");
                }

                if (empty($data['fechaCaducacion'])) {
                    throw new Exception("La fecha de caducación es obligatoria.");
                }

                if (strtotime($data['fechaCaducacion']) < strtotime($data['fechaAdquisision'])) {
                    throw new Exception("La fecha de caducación no puede ser menor a la fecha de adquisición.");
                }

                // ACTUALIZAR
                if (!empty($idLicencia)) {

                    $resultado = $this->licenciasModel->actualizarLicencia($idLicencia, $data);

                    if (!$resultado) {
                        throw new Exception("No se pudo actualizar la licencia.");
                    }

                    $_SESSION['mensaje_exito'] = 'Licencia actualizada correctamente.';
                }

                // CREAR
                else {

                    $resultado = $this->licenciasModel->guardarLicencia($data);

                    if (!$resultado) {
                        throw new Exception("No se pudo crear la licencia.");
                    }

                    $_SESSION['mensaje_exito'] = 'Licencia creada correctamente.';
                }

            } catch (Exception $e) {
        
                $_SESSION['mensaje_error'] = 'Error al guardar la licencia: ' . $e->getMessage()    ;
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