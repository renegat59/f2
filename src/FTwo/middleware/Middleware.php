<?php

namespace FTwo\middleware;

/**
 * Middleware Abstrat class
 *
 * @author Mateusz P <bananq@gmail.com>
 */
abstract class Middleware
{

    /**
     * Function run before every request
     */
    public abstract function before(\FTwo\http\Request $request, \FTwo\http\Response $response): \FTwo\http\Response;

    /**
     * Function run after every request
     */
    public abstract function after(\FTwo\http\Request $request, \FTwo\http\Response $response): \FTwo\http\Response;
}
