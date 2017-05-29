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
        if ($this->shouldCache($request)) {
            $webcache = F2::getComponent('webcache');
            $this->requestedPath = $request->server('PATH_INFO') ?? '/index';
            $this->cachedContent = $webcache->getPath($this->requestedPath);
            if (FALSE !== $this->cachedContent) {
                $response->setStatus(StatusCode::HTTP_OK)
                    ->send($this->cachedContent)
                    ->done();
            } else {
                $this->startCaching();
            }
        }
        return $response;
    }

    public function after(Request $request, Response $response): Response
    {
        if ($this->shouldCache($request) && FALSE === $this->cachedContent) {
            //end caching:
            $output = $this->endCaching();
            $webcache = F2::getComponent('webcache');
            $webcache->cachePath($this->requestedPath, $output);
            return $response->send($output);
        }
        return $response;
    }

    private function shouldCache(Request $request)
    {
        //at the moment we only suport caching for GET requests.
        return $request->method() === \FTwo\http\HttpMethod::GET;
    }

    private function startCaching()
    {
        ob_start();
    }

    private function endCaching(): string
    {
        $cached = ob_get_clean();
        return $cached;
    }
}
