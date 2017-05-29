<?php

namespace FTwo\core;

use FTwo\http\Request;
use FTwo\http\Response;
use FTwo\middleware\Middleware;

/**
 * Class running the middleware on every request
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class MiddlewareStack extends Component
{
    private $middlewarePath;
    private $stack = array();

    public function __construct()
    {
        $this->middlewarePath = F2::getPath('middleware');
    }

    public function runBefore(Request $request, Response $response): Response
    {
        $count = count($this->stack);
        for ($ii = 0; $ii < $count; $ii++) {
            $response = $this->stack[$ii]->before($request, $response);
            if($response === FALSE){
                exit();
            }
        }
        return $response;
    }

    public function runAfter(Request $request, Response $response): Response
    {
        $count = count($this->stack);
        for ($ii = $count - 1; $ii >= 0; $ii--) {
            $response = $this->stack[$ii]->after($request, $response);
        }
        return $response;
    }

    public function prependMiddleware(Middleware $middleware): MiddlewareStack
    {
        $middleware->stack = $this;
        array_unshift($this->stack, $middleware);
        return $this;
    }

    public function appendMiddleware($middleware): MiddlewareStack
    {
        $this->stack[] = $middleware;
        return $this;
    }

    public function addMiddleware($middleware, int $position = -1): MiddlewareStack
    {
        if ($position > 0) {
            array_splice($this->stack, $position, 0, $middleware);
        } else {
        }
        return $this;
    }
}
