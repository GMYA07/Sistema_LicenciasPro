<?php
require_once __DIR__ . '/../models/AreasModel.php';
require_once __DIR__ . '/../models/EquipoModel.php';
require_once __DIR__ . '/../models/LicienciasModel.php';
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
        $modeloComputora = new EquipoModel();

        $computadoras = $modeloComputora->obtenerEquiposPorArea($idArea);

        /*Traer las licencias no instaladas para poder instalar*/
        $modeloLicencias = new LicenciasModel();
        $licencias = $modeloLicencias->obtenerLicenciasPorEstado("NoInstalada");

        include '../app/views/equipos/equipos_area.php';

    }

    public function mostrarCrearEquipo(){

        $idArea = $_GET['idArea'] ?? null;

        if (!$idArea) {
            // Si alguien entra sin ID, lo mandamos a la página principal
            header('Location:'.BASE_URL.'/equipos');
            exit;
        }

        $modeloArea = new AreasModel();
        $infoArea = $modeloArea->obtenerArea($idArea);

        include '../app/views/equipos/equipos_crear.php';

    }

    public function mostrarEditarEquipo(){

        $idEquipo = $_GET['idEquipo'] ?? null;

        if (!$idEquipo) {
            // Si alguien entra sin ID, lo mandamos a la página principal
            $_SESSION['mensaje_error'] = "Error al redireccionar: Posiblemente falta una id para la redireccion.";
            header('Location:'.BASE_URL.'/equipos');
            exit;
        }

        $modeloArea = new AreasModel();
        $modeloEquipo = new EquipoModel();

        $areas = $modeloArea->obtenerAreas();
        $computadora = $modeloEquipo->obtenerEquipoById($idEquipo);

        include '../app/views/equipos/equipos_editar.php';
    }

    public function guardarEquipo(){

        $marca = trim($_POST['Marca'] ?? '');
        $modelo = trim($_POST['Modelo'] ?? '');
        $serial = trim($_POST['Serial'] ?? '');
        $idArea = trim($_POST['idAreaComputadora'] ?? '');
        $estado = trim($_POST['estadoComputadora'] ?? '');

        if($marca === '' || $modelo === '' || $serial === '' || $idArea === '' || $estado === '') {

            $_SESSION['mensaje_error'] = "Todos los campos del equipo son obligatorios.";
            // Lo regresamos a la vista donde estaba
            header('Location: ' . BASE_URL . '/equipos');
            exit;
        }

        $modeloArea = new AreasModel();
        $area  = $modeloArea->obtenerArea($idArea);

        if($area['totalComputadoras'] >= $area['numEquipos']){
            $_SESSION['mensaje_error'] = "El area llego al maximo de equipos para ingresar.";

            header('Location: ' . BASE_URL . '/equipos');
            exit;
        }

        $data = [
            'Marca' => $marca,
            'Modelo' => $modelo,
            'Serial' => $serial,
            'idAreaComputadora' => $idArea,
            'estadoComputadora' => $estado
        ];

        $modeloEquipo = new EquipoModel();

        if($modeloEquipo->guardarEquipo($data)){

            $_SESSION['mensaje_exito'] = "¡El equipo se guardó correctamente!";
            header('Location:'.BASE_URL.'/equipos/area?idArea='.$idArea);
            exit;
        }else {
            // ERROR EN BD: Le avisamos al usuario que algo falló en el guardado
            $_SESSION['mensaje_error'] = "Error al guardar: Posiblemente el serial ya está registrado.";
            header('Location: ' . BASE_URL . '/equipos');
            exit;
        }

    }

    public function actualizarEquipo(){

        $idComputadora = trim($_POST['idComputadora'] ?? '');
        $marca = trim($_POST['Marca'] ?? '');
        $modelo = trim($_POST['Modelo'] ?? '');
        $serial = trim($_POST['Serial'] ?? '');
        $idArea = trim($_POST['idAreaComputadora'] ?? '');
        $estado = trim($_POST['estadoComputadora'] ?? '');

        if($marca === '' || $modelo === '' || $serial === '' || $idArea === '' || $estado === '' || $idComputadora === '') {

            $_SESSION['mensaje_error'] = "Todos los campos del equipo son obligatorios.";
            // Lo regresamos a la vista donde estaba
            header('Location: ' . BASE_URL . '/equipos');
            exit;
        }

        $data = [
            'idComputadora' => $idComputadora,
            'Marca' => $marca,
            'Modelo' => $modelo,
            'Serial' => $serial,
            'idAreaComputadora' => $idArea,
            'estadoComputadora' => $estado
        ];

        $modeloEquipo = new EquipoModel();

        if($modeloEquipo->editarEquipo($data)){

            $_SESSION['mensaje_exito'] = "¡El equipo se actualizo correctamente!";
            header('Location:'.BASE_URL.'/equipos/area?idArea='.$idArea);
            exit;

        }else {
            // ERROR EN BD: Le avisamos al usuario que algo falló en el guardado
            $_SESSION['mensaje_error'] = "Error al actualizar el equipo.";
            header('Location: ' . BASE_URL . '/equipos');
            exit;
        }

    }

    public function eliminarEquipo(){

        $idEquipo = $_POST['idComputadora'] ?? null;
        $idArea = $_POST['idArea'] ?? null;

        if(!$idEquipo || !$idArea) {
            $_SESSION['mensaje_error'] = "El equipo no puedo ser eliminado por problemas con el id que esta vacio o el area.";
            header('Location: ' . BASE_URL . '/equipos');
            exit;
        }

        $modeloEquipo = new EquipoModel();

        if($modeloEquipo->eliminarEquipo($idEquipo)){
            $_SESSION['mensaje_exito'] = "¡El equipo se eliminó correctamente!";
        } else {
            $_SESSION['mensaje_error'] = "Error al eliminar el equipo.";
        }

        header('Location: ' . BASE_URL . '/equipos/area?idArea=' . $idArea);
        exit;

    }

    //FUNCIONES PARA EL TEMA DE VINCULO Y DESVINCULO DE LICENCIA
    public function obtenerLicenciasVinculadas(){
        $idComputadora = $_GET['idComputadora'] ?? null;

        if (!$idComputadora) {
            // Si no hay ID, devolvemos un arreglo vacío
            header('Content-Type: application/json');
            echo json_encode([]);
            exit;
        }
        //Instancaimos el modelo
        $modeloLicencias = new LicenciasModel();

        $licencias = $modeloLicencias->obtenerLicenciasEquipoVinculado($idComputadora);
        header('Content-Type: application/json'); //Le decimos al navegador "Ojo, lo que te voy a mandar no es HTML, es un JSON"
        echo json_encode($licencias);
        exit; //con esto evitamos q quiera rendrizar algo mas

    }

    public function asignarLicencia(){
        //Recepcion de los datos
        $idEquipo = trim($_POST['idComputadora'] ?? '');
        $idArea = trim($_POST['idArea'] ?? '');
        $idLicencia = trim($_POST['idLicencia'] ?? '');

        //creacion de los modelos
        $modeloLicencia = new LicenciasModel();
        $modeloEquipo = new EquipoModel();

        //vericamos que la licencia exista
        if(!$modeloLicencia->obtenerLicenciasPorId($idLicencia)){
            $_SESSION['mensaje_error'] = "Error al asignar licencia, La licencia no se encuentra registrada.";
            header('Location: ' . BASE_URL . '/equipos/area?idArea=' . $idArea);
            exit;
        }

        if(!$modeloEquipo->obtenerEquipoById($idEquipo)){
            $_SESSION['mensaje_error'] = "Error al asignar licencia, el equipo no se encuentra registrada.";
            header('Location: ' . BASE_URL . '/equipos/area?idArea=' . $idArea);
            exit;
        }

        //Asignaremos la licencia al equipo
        $data = [
            'idEquipo' => $idEquipo,
            'idLicencia' => $idLicencia
        ];

        //Proceso de asignacion de licencia
        $exitoVinculo = $modeloLicencia->asignarLicenciaEquipo($data);

        if(!$exitoVinculo){
            $_SESSION['mensaje_error'] = "Error al asignar licencia, No se pudo asignar la licencia a el equipo.";
            header('Location: ' . BASE_URL . '/equipos/area?idArea=' . $idArea);
            exit;
        }
        
        //Si se pasaron todas las validaciones pues se asigno esa licencia a ese equipo

        $_SESSION['mensaje_exito'] = "¡La licencia se asigno correctamente!";
        header('Location: ' . BASE_URL . '/equipos/area?idArea=' . $idArea);
        exit;


    }

    public function desvincularLicencia(){
        //Recibimos los datos del form falso
        $idLicencia = $_POST['idLicencia'] ?? null;
        $idComputadora = $_POST['idComputadora'] ?? null;

        if (!$idLicencia || !$idComputadora) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Faltan datos obligatorios']);
            exit;
        }

        $data = [
            'idLicencia' => $idLicencia,
            'idComputadora' => $idComputadora
        ];
        //instancio el modelo
        $modeloLicencia = new LicenciasModel();
        $exito = $modeloLicencia->eliminarRelacionLicenciaEquipo($data);

        header('Content-Type: application/json');

        if ($exito) {
            // Respondemos un arreglo que JS pueda leer fácilmente
            echo json_encode([
                'status' => 'success',
                'message' => 'La licencia se retiró del equipo correctamente.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'No se pudo eliminar la licencia de la base de datos.'
            ]);
        }

        exit; //ayuda a no mandar html y solo json
    }


}
