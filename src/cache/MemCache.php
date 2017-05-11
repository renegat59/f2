<?php

namespace FTwo\cache;

use FTwo\core\Component;

/**
 * Memcache implementation of Cache
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class MemCache extends Component implements Cache
{

    //put your code here
    public function addObject(string $key, mixed $value): bool
    {
    }

    public function addString(string $key, string $value): bool
    {
    }

    public function delete(string $key): bool
    {
    }

    public function get(string $key)
    {
    }

    public function purge(): bool
    {
    }
}
