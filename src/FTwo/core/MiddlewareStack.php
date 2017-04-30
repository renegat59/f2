<?php

namespace FTwo\core;

/**
 * Class running the middleware on every request
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class MiddlewareStack extends Component
{
    private $stack = array();

    public function __construct()
    {
        $middlewarePath = F2::getPath('middleware');
        
    }

    public function runBefore(\FTwo\http\Request $request, \FTwo\http\Response $response): \FTwo\http\Response
    {
        $count = count($this->stack);
        for ($ii = 0; $ii < $count; $ii++) {
            $response = $this->stack[$ii]->before($request, $response);
        }
        return $response;
    }

    public function runAfter(\FTwo\http\Request $request, \FTwo\http\Response $response): \FTwo\http\Response
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
