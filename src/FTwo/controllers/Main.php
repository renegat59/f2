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
        $this->addRoute(
            HttpMethod::GET,
            '',
            'index'
        );
    }

    public function index(Request $request, Response $response)
    {
        echo 'Hello from F2';
    }
}
