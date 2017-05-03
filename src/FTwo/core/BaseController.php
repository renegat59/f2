<?php

namespace FTwo\core;

use FTwo\core\exceptions\F2Exception;
use FTwo\core\exceptions\HttpException;
use FTwo\http\Request;
use FTwo\http\Response;
use FTwo\http\StatusCode;

/**
 * Base F2 Controller. All Controllers have to extend this class.
 *
 * @author Mateusz P <bananq@gmail.com>
 */
abstract class BaseController
{
    protected $actionMap = array();

    public function __construct()
    {
        $this->init();
    }

    /**
     * This function is needed, so when we override it in subclasses it will be called in the constructor
     */
    protected function init()
    {
    }

    /**
     * @param string $action
     * @param Request $request
     * @param Response $response
     * @return type
     * @throws F2Exception
     */
    public function call(string $action, Request $request, Response $response)
    {
        $httpMethod = $request->method();
        $method = $this->getMethodToCall($httpMethod, $action);
        if (false === $method) {
            throw new HttpException(StatusCode::HTTP_NOT_FOUND, 'Requested action not found');
        }
        
        $this->$method($request, $response);
    }

    protected function addRoute(string $httpMethod, string $action, string $method)
    {
        if (!method_exists(get_class($this), $method)) {
            throw new F2Exception("Method <$method> configuration wrong");
        }
        $actionList = &$this->getMethodActions($httpMethod);
        $actionList[$action] = $method;
        
        return $this;
    }

    /**
     * Gets the method that should be called
     * @param string $method Name of the HTTP method (GET, POST etc)
     * @param string $action Name of action that should be called
     * @return string|boolean name of the method if mapping exists. false otherwise.
     */
    private function getMethodToCall(string $method, string $action)
    {
        $actionList = &$this->getMethodActions($method);
        return $actionList[$action] ?? false;
    }

    private function &getMethodActions(string $method): array
    {
        if (!isset($this->actionMap[$method])) {
            $this->actionMap[$method] = [];
        }
        return $this->actionMap[$method];
    }
}
