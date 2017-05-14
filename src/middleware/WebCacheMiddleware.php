<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace FTwo\middleware;

use FTwo\core\F2;
use FTwo\http\Request;
use FTwo\http\Response;
use FTwo\http\StatusCode;

/**
 * Middleware for WebCache
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class WebCacheMiddleware extends Middleware
{

    public function before(Request $request, Response $response): Response
    {
        $requestedPath = $request->server('PATH_INFO');
        $webcache = F2::getComponent('webcache');
        $cachedContent = $webcache->getPath($$requestedPath);
        if (FALSE !== $cachedContent) {
            $response->setStatus(StatusCode::HTTP_OK)
                ->send($cachedContent);
        }
    }

    public function after(Request $request, Response $response): Response
    {
        //todo: cache
    }
}
