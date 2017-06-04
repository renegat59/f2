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
    private $pathGetParams = [];

    public function __construct()
    {
        $this->cookies   = new Cookies();
    }

    /**
     * Adds variables parsed from the path
     * @param array $variables
     */
    public function addGetVariables(array $variables): Request
    {
        $filteredParams  = filter_var_array($variables, FILTER_SANITIZE_STRING) ?? [];
        $this->pathGetParams = array_merge($this->pathGetParams, $filteredParams);
        return $this;
    }

    /**
     * Returns the param from $_SERVER array or null if not present
     * @param string $param
     * @return string|null
     */
    public function server(string $param)
    {
        return filter_input(INPUT_SERVER, $param, FILTER_SANITIZE_STRING);
    }

    /**
     * Returns the param from $_GET array or null if not present
     * @param string $param
     * @return string|null
     */
    public function get(string $param)
    {
        $getParam = filter_input(INPUT_GET, $param, FILTER_SANITIZE_STRING);
        if (null === $getParam) {
            return $this->pathGetParams[$param] ?? null;
        }
        return $getParam;
    }

    /**
     * Returns the param from $_POST array or null if not present
     * @param string $param
     * @return string|null
     */
    public function post(string $param)
    {
        return filter_input(INPUT_POST, $param, FILTER_SANITIZE_STRING);
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
