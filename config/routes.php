<?php

use FTwo\controllers\MainController;
use FTwo\controllers\PostController;
return [
    /**
    * Routes are optional. The system will automatically get controller name and then mapped route
    */
    '/'=> MainController::class,
    '/allposts' => PostController::class,
    '/post' => PostController::class,
];