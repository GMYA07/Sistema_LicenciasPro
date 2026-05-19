<?php
class Router {

    private $routes = [];

    // Registrar ruta GET
    public function get($url, $controller, $method) {
        $this->routes['GET'][$url] = [
            'controller' => $controller,
            'method'     => $method
        ];
    }

    // Registrar ruta POST
    public function post($url, $controller, $method) {
        $this->routes['POST'][$url] = [
            'controller' => $controller,
            'method'     => $method
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