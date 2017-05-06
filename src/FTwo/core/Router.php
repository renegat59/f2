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

    private $hostname;

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
        $this->routes = $config['routes'];
        $this->hostname = $config['hostname'];
    }

    public function route()
    {
        $path = filter_input(INPUT_SERVER, 'PATH_INFO') ?? '/';
        $controllerName = $this->routes[$path] ?? null;
        $this->request = new Request();
        $this->response = new Response();
        $middleware = F2::getComponent('middleware');
        $this->response = $middleware->runBefore($this->request, $this->response);
        if (!class_exists($controllerName)) {
            throw new HttpException(StatusCode::HTTP_NOT_FOUND, "$controllerName Not found");
        }
        (new $controllerName())
            ->call(
                $path,
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

    public function getUrl($path) {
        return $this->hostname.array_search($path, $this->routes);
    }

}
