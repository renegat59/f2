<?php

namespace FTwo\middleware;

/**
 * Middleware Abstrat class
 *
 * @author Mateusz P <bananq@gmail.com>
 */
abstract class Middleware
{

    protected $params;
    
    public function __construct(array $params = [])
    {
        $this->params = $params;
    }

    /**
     * Function run before every request
     */
    abstract public function before(\FTwo\http\Request $request, \FTwo\http\Response $response): \FTwo\http\Response;

    /**
     * Function run after every request
     */
    abstract public function after(\FTwo\http\Request $request, \FTwo\http\Response $response): \FTwo\http\Response;
}
