<?php

namespace FTwo\cache;

use FTwo\core\Component;

/**
 * Cache interface defining functions for cache object
 *
 * @author Mateusz P <bananq@gmail.com>
 */
abstract class Cache extends Component
{
    protected $keyPrefix = 'f2_';

    public function init($config)
    {
        parent::init();
        $this->keyPrefix = $config['keyPrefix'];
    }

    abstract public function addString(string $key, string $value): bool;

    abstract public function addObject(string $key, mixed $value): bool;

    abstract public function delete(string $key): bool;

    abstract public function purge(): bool;

    abstract public function get(string $key): mixed;

    public function cacheAndGet(string $key, callable $creator)
    {
        $value = $this->get($key);
        if (FALSE === $value) {
            $value = $creator();
            $this->addString($key, $value);
        }
    }

    protected function
}
