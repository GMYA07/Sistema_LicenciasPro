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
}
?>