<?php
class Router {

    private $routes = [];

    // Registrar ruta GET
    public function get($url, $controller, $method, $middleware = null) {
        $this->routes['GET'][$url] = [
            'controller' => $controller,
            'method'     => $method,
            'middleware' => $middleware
        ];
    }

    // Registrar ruta POST
    public function post($url, $controller, $method, $middleware = null) {
        $this->routes['POST'][$url] = [
            'controller' => $controller,
            'method'     => $method,
            'middleware' => $middleware
        ];
    }

    // Despachar — esto se llama en index.php
    public function dispatch() {
        // Captura la URL actual
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $url = str_replace(BASE_PATH, '', $url);
        $url = $url ?: '/';
        $method = $_SERVER['REQUEST_METHOD'];

        // Existe esa ruta
        if (isset($this->routes[$method][$url])) {
            $route = $this->routes[$method][$url];
            //Aplicaremos el middelware para poder hacer q acceda si solo tiene autenticacion
            //Primero veremos si quiere q apliquemos el middleware
            if($route['middleware'] === 'auth') {
                //aqui nos aseguramos que la sesion este iniciada
                if(session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                // Si no existe la sesion lo madarremos al login
                if(!isset($_SESSION['usuario_nombre'])) {
                    header('Location: ' . BASE_URL . '/');
                    exit; // Detiene la ejecución aquí mismo
                }
            }

            $controllerName = $this->routes[$method][$url]['controller'];
            $methodName     = $this->routes[$method][$url]['method'];

            // Cargar el archivo del controller
            require_once '../app/controllers/' . $controllerName . '.php';

            // Crear instancia y llamar el método
            $controller = new $controllerName();
            $controller->$methodName();

        } else {
            // Ruta no encontrada
            http_response_code(404);
            echo "Página no encontrada";
        }
    }
}