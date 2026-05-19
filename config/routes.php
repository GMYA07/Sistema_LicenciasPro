<?php
//Login
$router->get('/', 'AuthController', 'index');


$router->get('/home', 'HomeController', 'index');