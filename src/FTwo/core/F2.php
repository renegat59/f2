<?php

namespace FTwo\core;

use FTwo\db\DbConnection as DbConnection;
use FTwo\http\HttpRequest as HttpRequest;

/**
 * This is the main F2 class that will start the blog engine
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class F2
{
    private static $config;
    private static $components;
    private static $request;
    private static $middleware;

    public function __construct(array $config)
    {
        self::$config     = $config;
        self::$request    = new HttpRequest();
        self::$components = new ComponentContainer();
        self::$components->init('db', new DbConnection(self::$config['db']));
        self::$components->init('router', new Router(self::$config['router']));
//        self::$middleware = new MiddlewareStack();
    }

    public function start()
    {
        $router = self::$components->get('router');
        $path   = self::$request->server('PATH_INFO') ?? '/';
        $router->route($path);
//        self::$middleware->runBefore();
//        self::$middleware->runAfter();
    }

    public static function db(): DbConnection
    {
        return self::$components->get('db');
    }

    public static function getHttpRequest(): \FTwo\http\HttpRequest
    {
        return self::$request;
    }

    public static function cookies(): \FTwo\http\Cookies
    {
        return self::getHttpRequest()->getCookies();
    }
}
