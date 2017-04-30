<?php

namespace FTwo\middleware;

/**
 * Sets the proper Locale for the website.
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class LocaleMiddleware extends Middleware
{

    public function before(\FTwo\http\Request $request, \FTwo\http\Response $response): \FTwo\http\Response
    {
        $language = $request->get('lang');
        $response->addVariableToView('language', $language ?? 'en');
        return $response;
    }

    public function after(\FTwo\http\Request $request, \FTwo\http\Response $response): \FTwo\http\Response
    {
        return $response;
    }
}
