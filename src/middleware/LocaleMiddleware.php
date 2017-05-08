<?php

namespace FTwo\middleware;

use FTwo\http\Request;
use FTwo\http\Response;

/**
 * Sets the proper Locale for the website.
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class LocaleMiddleware extends Middleware
{

    public function before(Request $request, Response $response): Response
    {
        $language = $request->get('lang');
        $response->addVariable('language', $language ?? 'en');
        return $response;
    }

    public function after(Request $request, Response $response): Response
    {
        return $response;
    }
}
