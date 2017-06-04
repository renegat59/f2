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

        try {
            $this->routeInternal();
        } catch (HttpException $httpException) {
            $errorController = new ErrorController();
            $this->response->exception = $httpException;
            $errorController->serveHttpError($this->request, $this->response);
        } catch (\Exception $exception) {
            $errorController = new ErrorController();
            $this->response->exception = $exception;
            $errorController->serveOtherError($this->request, $this->response);
        }
    }

    private function routeInternal()
    {
        $middleware = F2::getComponent('middleware');
        $this->response = $middleware->runBefore($this->request, $this->response);

        $path = $this->request->server('PATH_INFO') ?? '/';
        $route = $this->findRoute($path);
        if (null === $route) {
            throw new HttpException(StatusCode::HTTP_NOT_FOUND, "$path not found");
        }

        $controllerName = $this->routes[$route] ?? null;
        
        if (!class_exists($controllerName)) {
            throw new HttpException(StatusCode::HTTP_NOT_FOUND, "$path not found");
        }
        (new $controllerName())->call($route, $this->request, $this->response);

        $this->response = $middleware->runAfter($this->request, $this->response);
        $this->response->done();
    }

    private function findRoute(string $path)
    {
        if (isset($this->routes[$path])) {
            return $this->routes[$path];
        }
        $cleanPath = rtrim($path, '/');
        //if no exact match found, we try to match variables
        $slashCount = substr_count($cleanPath, '/');
        $filteredRoutes = array_filter(
            $this->routes,
            function ($key) use ($cleanPath, $slashCount) {
                $sameNumberOfSlashes = ($slashCount === substr_count($key, '/'));
                $prefix = strtok($key, ':');
                $startsCorrectly = (0 === strpos($cleanPath, $prefix));
                //explicitly exclude '/' path
                return $sameNumberOfSlashes && $startsCorrectly && $key !== '/';
            },
            ARRAY_FILTER_USE_KEY
        );

        reset($filteredRoutes);
        $route = key($filteredRoutes);
        if($route !== null) {
            $this->extractVariables($route, $path);
        }
        return $route;
    }

    private function extractVariables(string $route, string $path)
    {
        $varNames = explode('/', $route);
        $varValues = explode('/', $path);
        $variables = array_combine($varNames, $varValues);
        $filteredVariables = array_filter(
            $variables,
            function ($key) {
                return 0 === strpos($key, ':');
            },
            ARRAY_FILTER_USE_KEY
        );
        $this->request->addGetVariables($filteredVariables);
    }

    public function getResponse(): Response
    {
        return $this->response;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getAbsoluteUrl($path)
    {
        return $this->hostname.$path;
    }
}
