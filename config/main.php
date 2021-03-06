<?php

use FTwo\cache\MemCache;
use FTwo\core\Environment;

return [
    'env' => Environment::PROD,
    'db' => [
        'host' => '127.0.0.1',
        'port' => '3307',
        'user' => 'ftwo',
        'password' => 'ftwo_pass',
        'schema' => 'ftwo',
        'encoding' => 'utf8'
    ],
    'cache' => [
        'class' => MemCache::class,
        'keyPrefix' => 'f2_',
        'params' => [
            'host' => 'localhost',
            'port' => 11211
        ]
    ],
    'webcache' => [
        'cacheTime' => 172800,
        'enabled' => false
    ],
    'router' => [
        'hostname' => 'http://localhost:8888',
        'routes' => require('routes.php')
    ],
    'params' => [
        'template' => 'default',
    ],
    'middleware' => require('middleware.php')
];
