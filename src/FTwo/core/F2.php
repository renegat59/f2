<?php

namespace FTwo\core;

use FTwo\db\DbConnection as DbConnection;
use FTwo\http\Request as Request;
use FTwo\http\Response as Response;

/**
 * This is the main F2 class that will start the blog engine
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class F2
{
    private static $config;
    private static $components;

    public function __construct(array $config)
    {
        self::$config     = $config;
        self::$components = new ComponentContainer();
        self::$components->init('db', new DbConnection(self::$config['db']));
        self::$components->init('router', new Router(self::$config['router']));
        self::$components->init('middleware', new MiddlewareStack());
    }

    public function start()
    {
        $router  = self::$components->get('router');
        $router->route();
    }

    public static function db(): DbConnection
    {
        return self::$components->get('db');
    }

    public static function getComponent($componentName): Component
    {
        return self::$components->get($componentName);
    }

}
