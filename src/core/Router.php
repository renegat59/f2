<?php

namespace FTwo\core;

use FTwo\controllers\ErrorController;
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
        $this->request = new Request();
        $this->response = new Response();
        
        try{
            $this->routeInternal();
        }
        catch(HttpException $httpException) {
            $errorController = new ErrorController();
            $this->response->exception = $httpException;
            $errorController->serveHttpError($this->request, $this->response);
        }
        catch (\Exception $exception) {
            $errorController = new ErrorController();
            $this->response->exception = $exception;
            $errorController->serveOtherError($this->request, $this->response);
        }
    }

    private function routeInternal(){
        $path = filter_input(INPUT_SERVER, 'PATH_INFO') ?? '/';
        $controllerName = $this->routes[$path] ?? null;
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

    public function getAbsoluteUrl($path){
        return $this->hostname.$path;
    }

}
