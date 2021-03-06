<?php

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
            if (false !== $this->cachedContent) {
                $response->setStatus(StatusCode::HTTP_OK)
                    ->send($this->cachedContent)
                    ->done();
            }
            $this->startCaching();
        }
        return $response;
    }

    public function after(Request $request, Response $response): Response
    {
        if ($this->shouldCache($request) && false === $this->cachedContent) {
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
        $env = F2::getEnvironment();
        return $request->method() === \FTwo\http\HttpMethod::GET &&
            $env->isProd();
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
