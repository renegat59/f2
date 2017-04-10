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

    public function __construct()
    {
        $this->cookies = new Cookies();
        $this->getParams = filter_input_array(INPUT_GET);
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

    public function getCookies()
    {
        return $this->cookies;
    }
}
