<?php
require_once '../config/app.php';
require_once '../core/Router.php';

$router = new Router();

require_once '../config/routes.php'; // aquí defines las rutas

$router->dispatch(); // aquí ejecuta todo