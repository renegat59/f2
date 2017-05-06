<?php

use FTwo\core\Environment;
return [
    'env'=> Environment::DEV,
    'db' => [
        'host' => '127.0.0.1',
        'port' => '3307',
        'user' => 'ftwo',
        'password' => 'ftwo_pass',
        'schema' => 'ftwo',
        'encoding' => 'utf8'
    ],
    'router' => [
        'hostname'=>'http://localhost:8888',
        'routes'=> require('routes.php')
    ],
    'params' => [
        'template'=>'default',
    ],
    'middleware' => [
        
    ]
];
