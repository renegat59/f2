<?php

namespace FTwo\controllers;

use FTwo\core\BaseController;
use FTwo\http\HttpMethod;
use FTwo\http\Request;
use FTwo\http\Response;
use FTwo\http\StatusCode;

/**
 * Description of WebconfController
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class WebconfController extends BaseController
{

    protected function init()
    {
        $this->addRoute(HttpMethod::GET, '/manifest.json', 'getManifest');
    }

    protected function getManifest(Request $request, Response $response)
    {
        $manifestContent = '{"name": "F2"}';
        $response->setStatus(StatusCode::HTTP_OK)
            ->send($manifestContent, 'application/json');
    }
}
