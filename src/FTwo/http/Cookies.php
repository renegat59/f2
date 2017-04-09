<?php

namespace FTwo\http;

/**
 * Description of Cookies
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class Cookies
{
    public function get(string $name): string
    {
        return filter_input(INPUT_COOKIE, $name);
    }

    public function set(string $name, string $value)
    {
        //TODO: Implement setting cookie when needed
    }
}
