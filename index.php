<?php
/**
 * loads the framework and runs the application
 */
require(__DIR__.'/vendor/autoload.php');
$config = require('config/main.php');

$f2 = new \FTwo\core\F2($config);
$f2->start();
