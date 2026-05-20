<?php
require_once __DIR__ . '/../models/AreasModel.php';
class EquiposController {

    public function index() {
        //Instanciamos el objeto
        $modeloArea = new AreasModel();
        //traemos la info
        $areas = $modeloArea->obtenerAreas();

        include '../app/views/equipos/equipos.php';
    }

    public function mostrarEquiposArea(){

        // Capturamos el ID que viene por la URL
        $idArea = $_GET['idArea'] ?? null;

        if (!$idArea) {
            // Si alguien entra sin ID, lo mandamos a la página principal
            header('Location:'.BASE_URL.'/equipos');
            exit;
        }

        $modeloArea = new AreasModel();
        $infoArea = $modeloArea->obtenerArea($idArea);

        /*
         * AQUI TENGO Q PONER LA LOGICA PARA TRAER LOS EQUIPOS*/

        include '../app/views/equipos/equipos_area.php';

    }
}
