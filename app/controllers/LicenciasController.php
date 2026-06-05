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
                $numPermit = trim($_POST['numPermitVinculados'] ?? '');
                $numPermitVinculados = ($numPermit === '') ? 1 : (int) $numPermit;

                $data = [
                    'idTipoLicencia' => trim($_POST['idTipoLicencia'] ?? ''),
                    'codigoLicencia' => trim($_POST['codigoLicencia'] ?? ''),
                    'numPermitVinculados' => $numPermitVinculados,
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

                if ($numPermitVinculados < 1) {
                    throw new Exception("La capacidad de equipos vinculados debe ser mayor o igual a 1.");
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

                //validar que si la fecha de caducacion es menor a la fecha actual, el estado de la licencia sea "Expirada" o "Vencida"
                if (strtotime($data['fechaCaducacion']) < time() && $data['estadoLicencia'] !== 'Expirada') {
                    throw new Exception("Si la fecha de caducación es menor a la fecha actual, el estado de la licencia debe ser 'Expirada'.");
                }

                // ACTUALIZAR
                if (!empty($idLicencia)) {
                    // Validar que no se reduzca la capacidad por debajo de lo asignado actualmente
                    $equiposAsignadosCount = $this->licenciasModel->contarComputadorasVinculadas($idLicencia);
                    if ($numPermitVinculados < $equiposAsignadosCount) {
                        throw new Exception("La capacidad mínima no puede ser menor al número de equipos actualmente asignados ($equiposAsignadosCount).");
                    }

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

                $_SESSION['mensaje_error'] = 'Error al guardar la licencia: ' . $e->getMessage();
            }
        }
    }

    public function guardarTipo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $idTipoLicencia = $_POST['idTipoLicencia'] ?? null;
                $nombreTipoLicencia = trim($_POST['nombreTipoLicencia'] ?? '');
                $categoriaLicencia = trim($_POST['categoriaLicencia'] ?? '');

                if (empty($nombreTipoLicencia)) {
                    throw new Exception("El nombre del tipo de licencia es obligatorio.");
                }

                if (empty($categoriaLicencia)) {
                    throw new Exception("La categoría del tipo de licencia es obligatoria.");
                }

                $categoriasValidas = ['SO', 'Office', 'Antivirus', 'Otros'];
                if (!in_array($categoriaLicencia, $categoriasValidas)) {
                    throw new Exception("Categoría de licencia inválida.");
                }

                if (!empty($idTipoLicencia)) {
                    $resultado = $this->tipoLicenciasModel->editarTipoLicencia($idTipoLicencia, $nombreTipoLicencia, $categoriaLicencia);
                    if (!$resultado) {
                        throw new Exception("No se pudo actualizar el tipo de licencia.");
                    }
                    $_SESSION['mensaje_exito'] = 'Tipo de licencia actualizado correctamente.';
                    echo "OK";
                } else {
                    $resultado = $this->tipoLicenciasModel->guardarTipoLicencia($nombreTipoLicencia, $categoriaLicencia);
                    if (!$resultado) {
                        throw new Exception("No se pudo crear el tipo de licencia.");
                    }
                    $_SESSION['mensaje_exito'] = 'Tipo de licencia creado correctamente.';
                    echo "OK";
                }
            } catch (Exception $e) {
                http_response_code(400);
                echo $e->getMessage();
            }
            exit;
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

    
    public function obtenerEstadisticas()
    {
        $estadisticas = $this->licenciasModel->contarLicenciasPorEstado();
        header('Content-Type: application/json');
        echo json_encode($estadisticas);
        exit;
    }

}