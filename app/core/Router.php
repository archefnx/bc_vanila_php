<?php
namespace App\Core;

class Router {
    protected $routes = [];

    public function register($route, $action) {
        $this->routes[$route] = $action;
    }

    public function resolve($requestUri) {
        foreach ($this->routes as $route => $action) {
//            echo $requestUri . '</br>';
            if ($requestUri === $route) {
                [$class, $method] = explode('@', $action);
                $controller = new $class();
                return $controller->$method();
            }
        }
        http_response_code(404);
        return '404 Not Found';
    }
}
