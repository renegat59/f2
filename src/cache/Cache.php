<?php

namespace FTwo\cache;

/**
 * Cache interface defining functions for cache object
 *
 * @author Mateusz P <bananq@gmail.com>
 */
interface Cache
{

    abstract public function addString(string $key, string $value): bool;

    abstract public function addObject(string $key, mixed $value): bool;

    abstract public function delete(string $key): bool;

    abstract public function purge(): bool;

    abstract public function get(string $key): mixed;
}
