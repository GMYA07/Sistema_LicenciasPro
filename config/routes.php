<?php
//Login
$router->get('/', 'AuthController', 'index');
$router->post('/login', 'AuthController', 'procesarLogin');
$router->get('/logout', 'AuthController', 'cerrarSesion','auth');


$router->get('/home', 'HomeController', 'index', 'auth');

$router->get('/equipos', 'EquiposController', 'index', 'auth');
$router->get('/equipos/area', 'EquiposController', 'mostrarEquiposArea', 'auth');
$router->get('/equipos/area/create','EquiposController','mostrarCrearEquipo','auth');
$router->post('/equipos/area/create','EquiposController','guardarEquipo','auth');
$router->get('/equipos/area/edit','EquiposController','mostrarEditarEquipo','auth');
$router->post('/equipos/area/edit','EquiposController','actualizarEquipo','auth');
$router->post('/equipos/area/delete','EquiposController','eliminarEquipo','auth');
$router->post('/equipos/area/asignar','EquiposController','asignarLicencia','auth');
$router->post('/equipos/area/desvincular_licencia','EquiposController','desvincularLicencia','auth');
$router->get('/equipos/area/obtener_licencias','EquiposController','obtenerLicenciasVinculadas','auth');

// Rutas para licencias
$router->get('/licencias','LicenciasController','index','auth');

// Endpoint para estadísticas de licencias (cartas)
$router->get('/licencias/obtenerEstadisticas','LicenciasController','obtenerEstadisticas','auth');

// Rutas para guardar licencias y tipos (formularios/modales)
$router->post('/licencias/guardar', 'LicenciasController', 'guardar', 'auth');
$router->post('/licencias/guardarTipo', 'LicenciasController', 'guardarTipo', 'auth');
// Eliminar tipo
$router->post('/licencias/eliminarTipo', 'LicenciasController', 'eliminarTipo', 'auth');

// Rutas para áreas
$router->get('/areas', 'AreasController', 'index', 'auth');
$router->post('/areas/guardar', 'AreasController', 'guardar', 'auth');

// Ruta para eliminar un área
$router->post('/areas/delete', 'AreasController', 'delete', 'auth');
