<?php
require_once __DIR__ . '/../vendor/autoload.php';
//Configuracion que se usa para poder usar las variables .env
// 2. Inicializar y cargar el archivo .env desde la raíz del proyecto
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

require_once '../config/app.php';
require_once '../core/Router.php';

$router = new Router();

require_once '../config/routes.php'; // aquí defines las rutas

$router->dispatch(); // aquí ejecuta todo