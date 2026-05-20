<?php
//Login
$router->get('/', 'AuthController', 'index');
$router->post('/login', 'AuthController', 'procesarLogin');
$router->get('/logout', 'AuthController', 'cerrarSesion','auth');


$router->get('/home', 'HomeController', 'index', 'auth');

$router->get('/equipos', 'EquiposController', 'index', 'auth');
$router->get('/equipos/area', 'EquiposController', 'mostrarEquiposArea', 'auth');