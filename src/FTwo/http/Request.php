<?php

namespace FTwo\http;

/**
 * Class containing HTTP Request information
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class Request
{
    private $cookies;
    private $getParams = [];

    public function __construct($pathParams = [])
    {
        $this->cookies   = new Cookies();
        $getParams       = filter_input_array(INPUT_GET) ?? [];
        $fitleredParams  = filter_var_array($pathParams, FILTER_SANITIZE_STRING) ?? [];
        $this->getParams = array_merge($getParams, $fitleredParams);
    }

    /**
     * Returns the param from $_SERVER array or null if not present
     * @param string $param
     * @return string|null
     */
    public function server(string $param)
    {
        return filter_input(INPUT_SERVER, $param);
    }

    /**
     * Returns the param from $_GET array or null if not present
     * @param string $param
     * @return string|null
     */
    public function get(string $param)
    {
        return filter_input(INPUT_GET, $param);
    }

    /**
     * Returns the param from $_POST array or null if not present
     * @param string $param
     * @return string|null
     */
    public function post(string $param)
    {
        return filter_input(INPUT_POST, $param);
    }

    /**
     * Returns the request HTTP method
     * @return string
     */
    public function method(): string
    {
        return $this->server('REQUEST_METHOD');
    }

    public function getCookies()
    {
        return $this->cookies;
    }
}
