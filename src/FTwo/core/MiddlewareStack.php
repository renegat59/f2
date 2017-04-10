<?php

namespace FTwo\core;

/**
 * Class running the middleware on every request
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class MiddlewareStack extends Component
{

    public function runBefore(\FTwo\http\Request $request)
    {

    }

    public function runAfter(\FTwo\http\Response $response)
    {
        
    }
}
