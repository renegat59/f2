<?php

namespace FTwo\core;

use FTwo\core\exceptions\HttpException;
use FTwo\http\Request;
use FTwo\http\Response;
use FTwo\http\StatusCode;

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

    /**
     * @var Response
     */
    private $response;

    /**
     * @var Request
     */
    private $request;

    public function __construct($config)
    {
        $this->routes = array_merge($this->defaultRoutes, $config['routes'] ?? []);
    }

    public function route()
    {
        $path = filter_input(INPUT_SERVER, 'PATH_INFO') ?? '/';
        list($controllerName, $action) = $this->splitRoute($path);
        $this->request = new Request();
        $this->response = new Response();
        $middleware = F2::getComponent('middleware');
        $this->response = $middleware->runBefore($this->request, $this->response);
        
        if (!class_exists($controllerName)) {
            throw new HttpException(StatusCode::HTTP_NOT_FOUND, "$controllerName Not found");
        }
        (new $controllerName())
            ->call(
                $action,
                $this->request,
                $this->response
            );
        
        $this->response = $middleware->runAfter($this->request, $this->response);
    }

    public function getResponse(): Response
    {
        return $this->response;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * Transforms path to array containing Controller class and function to call.
     * @param string $path
     * @return array Array with the first element containing name of the class to use and function to call
     */
    private function splitRoute(string $path): array
    {
        $realPath = $this->routes[$path] ?? $path;
        list($controllerName, $action) = explode('/', ltrim($realPath, '/'), 3);
//        $getParams = [];
//        $explodedParams = explode('/', $params);
//        $len = count($explodedParams);
//        for ($key = 0; $key < $len; $key += 2) {
//            if (!empty($explodedParams[$key])) {
//                $getParams[$explodedParams[$key]] = $explodedParams[$key + 1] ?? '';
//            }
//        }

        return [
            '\\FTwo\\controllers\\'.ucfirst($controllerName),
            $action
        ];
    }
}
