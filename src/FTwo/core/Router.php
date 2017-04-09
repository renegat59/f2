<?php

namespace FTwo\core;

/**
 * Router class of the F2. Decides where to go after a request.
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class Router extends Component
{
    private $routes;
    private $defaultRoutes = [
        '/' => 'main/index'
    ];

    public function __construct($config)
    {
        $this->routes = array_merge($this->defaultRoutes, $config['routes'] ?? []);
    }

    public function route(string $path)
    {
        list($controllerName, $function) = $this->splitRoute($path);
        if (!class_exists($controllerName) ||
            !method_exists($controllerName, $function)) {
            http_response_code(404);
            (new \FTwo\controllers\Error())->error(404, 'Not Found');
        }
        (new $controllerName())->$function();
    }

    /**
     * Transforms path to array containing Controller class and function to call
     * @param string $path
     * @return array Array with the first element containing name of the class to use and function to call
     */
    private function splitRoute(string $path): array
    {
        $realPath = $this->routes[$path] ?? $path;
        list($controllerName, $function) = explode('/', ltrim($realPath, '/'));
        return array(
            '\\FTwo\\controllers\\'.ucfirst($controllerName),
            $function
        );
    }
}
