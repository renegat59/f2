<?php

namespace FTwo\core;

use FTwo\db\DbConnection;
use FTwo\cache\WebCache;

/**
 * This is the main F2 class that will start the blog engine
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class F2
{
    private static $config;
    /**
     * Container holding all the F2 components.
     * @var ComponentContainer
     */
    private static $components;
    /**
     * Environment definitions.
     * @var Environment
     */
    private static $environment;

    public function __construct(array $config)
    {
        self::$config = $config;
        self::$environment = new Environment($config['env'] ?? Environment::PROD);
        self::$components = new ComponentContainer();
        self::$components->init('db', new DbConnection(self::$config['db']));
        self::$components->init('router', new Router(self::$config['router']));
        if(isset(self::$config['webcache'])) {
            self::$components->init('webcache', new WebCache(self::$config['webcache']));
        }
        self::$components->init('middleware', $this->generateMiddleware(self::$config['middleware']));
        
    }

    public function start()
    {
        $router = self::$components->get('router');
        $router->route();
    }

    /**
     * Gets the current DB Connection
     * @return DbConnection current db connection
     */
    public static function getDb(): DbConnection
    {
        return self::getComponent('db');
    }

    public static function getComponent(string $componentName): Component
    {
        return self::$components->get($componentName);
    }

    public static function hasComponent(string $componentName): bool
    {
        return self::$components->exists($componentName);
    }

    public static function getPath($folder)
    {
        $currentPath = getcwd();
        return $currentPath.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.$folder;
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
            for ($ii = 1; $ii < $keyLength; $ii++) {
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

    private function generateMiddleware(array $middlewareConfig): MiddlewareStack
    {
        $stack = new MiddlewareStack();
        if (self::hasComponent('webcache')) {
            $stack->appendMiddleware(new \FTwo\middleware\WebCacheMiddleware());
        }
        $stack->appendMiddleware(new \FTwo\middleware\LocaleMiddleware());
        foreach ($middlewareConfig as $middlewareClass=>$params) {
            $middleware = new $middlewareClass($params);
            $stack->appendMiddleware($middleware);
        }
        return $stack;
    }

    /**
     * @return Router
     */
    public static function getRouter(): Router
    {
        return self::getComponent('router');
    }

    public static function getEnvironment()
    {
        return self::$environment;
    }
}
