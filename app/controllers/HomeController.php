<?php
// Asegúrate de requerir el archivo de tu modelo aquí si no tienes un autoloader
require_once __DIR__ . '/../models/DashboardModel.php'; 

class HomeController {
    
    public function index() {
        $model = new DashboardModel();

        $totalComputadoras = $model->TotalComputadorasRegistradas();
        $licenciasActivas   = $model->LicienciasActivas();
        $proximasExpirar    = $model->PróximasExpirar();
        $totalAreas         = $model->totalAreas();

        // 3. Extraemos los datos para las gráficas
        $datosPastel = $model->graficaPastel();
        $datosBarras = $model->graficaBarras();

        // 4. Extraemos el arreglo de datos para armar las filas de la tabla
        $detalleTabla = $model->DetalleOperativo();

        // 5. Finalmente incluimos la vista (que ya tendrá acceso a todas estas variables)
        include '../app/views/home.php';
    }
}