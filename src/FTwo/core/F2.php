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
        self::$config = $config;
        self::$components = new ComponentContainer();
        self::$components->init('db', new DbConnection(self::$config['db']));
        self::$components->init('router', new Router(self::$config['router']));
        self::$components->init('middleware', new MiddlewareStack());
    }

    public function start()
    {
        $router = self::$components->get('router');
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

    public static function getPath($folder)
    {
        $currentPath = getcwd();
        return $currentPath.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'FTwo'.DIRECTORY_SEPARATOR.$folder;
    }

    /**
     * Returns full config or desired config value. To get value that is deeper in the config array use keys like:
     * params.template
     * If there is no correct value, an exception is thrown
     * @param string $key
     * @return array|string
     * @throws exceptions\F2Exception
     */
    public static function getConfig(string $key = null)
    {
        if ($key !== null) {
            $keys = explode('.', $key);
            $value = self::$config[$keys[0]];
            $keyLength = count($keys);
            for ($ii=1; $ii < $keyLength; $ii++) {
                if (isset($value[$keys[$ii]])) {
                    $value = $value[$keys[$ii]];
                } else {
                    throw new exceptions\F2Exception("Config key <$keys[$ii]> incorrect");
                }
            }
            return $value;
        }
        return self::$config;
    }
}
