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
    private $requestedPath;
    private $cachedContent;

    public function before(Request $request, Response $response): Response
    {
        $webcache = F2::getComponent('webcache');
        $this->requestedPath = $request->server('PATH_INFO');
        $this->cachedContent = $webcache->getPath($this->requestedPath);
        if (FALSE !== $this->cachedContent) {
            $response->setStatus(StatusCode::HTTP_OK)
                ->send($this->cachedContent);
            exit();
        } else {
            //start caching
            ob_start();
        }
        return $response;
    }

    public function after(Request $request, Response $response): Response
    {
        if (FALSE === $this->cachedContent) {
            $output = ob_get_clean();
            $webcache = F2::getComponent('webcache');
            $webcache->cachePath($this->requestedPath, $output);
            return $response->send($output);
        }
        return $response;
    }
}
