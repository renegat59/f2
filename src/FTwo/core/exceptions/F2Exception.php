<?php

namespace FTwo\core\exceptions;

/**
 * General Exceptin raised by F2 app
 *
 * @author mateusz
 */
class F2Exception extends \Exception
{

    public function __construct(string $message = '', int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
