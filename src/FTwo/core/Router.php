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

    public function route()
    {
        $path     = filter_input(INPUT_SERVER, 'PATH_INFO') ?? '/';
        list($controllerName, $function, $params) = $this->splitRoute($path);
        $request  = new \FTwo\http\Request($params);
        $response = new \FTwo\http\Response();
        if (!class_exists($controllerName) ||
            !method_exists($controllerName, $function)) {
            $response
                ->setStatus(\FTwo\http\StatusCode::HTTP_NOT_FOUND)
                ->render('errors/error', ['code' => \FTwo\http\StatusCode::HTTP_NOT_FOUND]);
        } else {
            $middleware = F2::getComponent('middleware');
            $middleware->runBefore($request, $response);
            (new $controllerName())->$function($request, $response);
            $middleware->runAfter($request, $response);
        }
    }

    /**
     * Transforms path to array containing Controller class and function to call.
     * @param string $path
     * @return array Array with the first element containing name of the class to use and function to call
     */
    private function splitRoute(string $path): array
    {
        $realPath       = $this->routes[$path] ?? $path;
        list($controllerName, $function, $params) = explode('/', ltrim($realPath, '/'), 3);
        $getParams      = [];
        $explodedParams = explode('/', $params);
        $len            = count($explodedParams);
        for ($key = 0; $key < $len; $key += 2) {
            if (!empty($explodedParams[$key])) {
                $getParams[$explodedParams[$key]] = $explodedParams[$key + 1] ?? '';
            }
        }

        return array(
            '\\FTwo\\controllers\\'.ucfirst($controllerName),
            $function,
            $getParams
        );
    }
}
