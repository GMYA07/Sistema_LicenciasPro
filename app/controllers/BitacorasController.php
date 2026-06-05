<?php
require_once __DIR__ . '/../models/AreasModel.php';
require_once __DIR__ . '/../models/BitacorasModel.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class BitacorasController{

    public function index() {
        $bitacorasModel = new BitacorasModel();

        $bitacoras = $bitacorasModel->obtenerBitacoras();

        include '../app/views/bitacoras/bitacoras.php';
    }

    public function mostrarCrearBitacora() {
        $areasModel = new AreasModel();

        $areas = $areasModel->obtenerAreas();

        include '../app/views/bitacoras/bitacoras_crear.php';
    }

    public function obtenerEstadisticasAJAX()
    {
        $idArea = $_GET['idArea'] ?? null;

        $bitacorasModel = new BitacorasModel();


        if ($idArea) {
            $estadisticas = $bitacorasModel->obtenerEstadisticasParaBitacora($idArea);
            header('Content-Type: application/json');
            echo json_encode($estadisticas);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'ID de área no proporcionado']);
        }
        exit;
    }

    public function guardarBitacora() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idUsuario = $_POST['idUsuario'] ?? null;
            $idArea = $_POST['idArea'] ?? null;
            $totalEquipos = (int)($_POST['totalEquipos'] ?? 0);
            $equiposConLicencia = (int)($_POST['equiposConLicencia'] ?? 0);
            $equiposSinLicencia = (int)($_POST['equiposSinLicencia'] ?? 0);
            $observaciones = $_POST['observaciones'] ?? null;

            $modeloArea = new AreasModel();
            $modeloBitacora = new BitacorasModel();

            if(empty($modeloArea->obtenerArea($idArea))){
                $_SESSION['mensaje_error'] = "El área seleccionada no existe.";
                header('Location: ' . BASE_URL . '/bitacoras');
                exit;
            }

            $data = [
                'idUsuario' => $idUsuario,
                'idArea' => $idArea,
                'fechaRevision' => date('Y-m-d H:i:s'),
                'totalEquipos' => $totalEquipos,
                'equiposConLicencia' => $equiposConLicencia,
                'equiposSinLicencia' => $equiposSinLicencia,
                'observaciones' => $observaciones,
            ];

            if($modeloBitacora->guardarBitacora($data)) {
                $_SESSION['mensaje_exito'] = "Bitácora guardada exitosamente.";
            } else {
                $_SESSION['mensaje_error'] = "Error al guardar la bitácora.";
            }

            header('Location: ' . BASE_URL . '/bitacoras');
            exit;
        }
    }

    public function imprimirBitacora() {

        $idBitacora = $_GET['idBitacora'] ?? null;

        if(!$idBitacora){
            die("ID de Bitacora no válido");
        }

        //Modelos para pedir la información necesaria
        $modeloBitacora = new BitacorasModel();
        $bitacora = $modeloBitacora->obtenerBitacoraPorId($idBitacora);

        //Con esto se inicia la generacion del pdf
        ob_start();

        include '../app/views/bitacoras/plantilla_bitacora.php';

        $htmlGenerado = ob_get_clean();

        //Configuracion de Dompdf
        $opciones = new Options();
        $opciones->set('isHtml5ParserEnabled', true);
        $opciones->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($opciones);

        $dompdf->loadHtml($htmlGenerado);
        $dompdf->setPaper('A4', 'portrait'); // Tamaño A4 en formato Vertical
        $dompdf->render();

        $nombreArchivo = "Bitacora_" . str_replace(' ', '_', $idBitacora) . ".pdf";
        $dompdf->stream($nombreArchivo, ["Attachment" => false]);
        exit;

    }

}