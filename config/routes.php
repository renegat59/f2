<?php

use FTwo\controllers\Main;
use FTwo\controllers\Posts;
return [
    /**
    * Routes are optional. The system will automatically get controller name and then mapped route
    */
    '/'=> Main::class,
    '/allposts' => Posts::class,
    '/post' => Posts::class,
];