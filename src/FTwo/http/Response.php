<?php

namespace FTwo\http;

/**
 * Class containing HTTP Response information
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class Response
{
    

    public function __construct()
    {
        
    }

    public function setStatus(int $statusCode): Response
    {
        http_response_code($statusCode);
        return $this;
    }

    public function getStatus(): int
    {
        return http_response_code();
    }

    public function render(string $view, array $params): Response
    {
        echo $this->getStatus();
        return $this;
    }
}
