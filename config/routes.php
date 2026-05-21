<?php
//Login
$router->get('/', 'AuthController', 'index');
$router->post('/login', 'AuthController', 'procesarLogin');
$router->get('/logout', 'AuthController', 'cerrarSesion','auth');


$router->get('/home', 'HomeController', 'index', 'auth');

$router->get('/equipos', 'EquiposController', 'index', 'auth');
$router->get('/equipos/area', 'EquiposController', 'mostrarEquiposArea', 'auth');

$router->get('/licencias','LicenciasController','index','auth');

// Rutas para guardar licencias y tipos (formularios/modales)
$router->post('/licencias/guardar', 'LicenciasController', 'guardar', 'auth');
$router->post('/licencias/guardarTipo', 'LicenciasController', 'guardarTipo', 'auth');
// Eliminar tipo
$router->post('/licencias/eliminarTipo', 'LicenciasController', 'eliminarTipo', 'auth');