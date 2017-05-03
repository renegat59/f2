<?php

namespace FTwo\controllers;

use FTwo\core\BaseController;
use FTwo\http\HttpMethod;
use FTwo\http\Request;
use FTwo\http\Response;

/**
 * Description of Main
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class Main extends BaseController
{

    protected function init()
    {
        $this->addRoute(HttpMethod::GET, 'index', 'getIndex');
    }

    public function getIndex(Request $request, Response $response)
    {
        echo 'Hello from F2!';
        $router = \FTwo\core\F2::getRouter();
        $address = $router->getUrl('/posts/all');
        echo "All posts address is $address";
    }
}
