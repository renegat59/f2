<?php

namespace FTwo\core\exceptions;

/**
 * Description of HttpException
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class HttpException extends F2Exception
{
    public function __construct($statusCode, $message)
    {
        parent::__construct($message, $statusCode);
    }
}
