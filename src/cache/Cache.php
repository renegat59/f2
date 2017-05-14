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

    public function getOrCache(string $key, callable $creator)
    {
        $value = $this->get($key);
        if (FALSE === $value) {
            $value = $creator();
            $this->addString($key, $this->serialize($value));
        }
        return $value;
    }

    /**
     * We wrap serialize with our function, so we can add something in future if needed
     * @param mixed $value
     * @return string serialized object
     */
    protected function serialize($value): string
    {
        return serialize($value);
    }

    /**
     * We wrap unserialize with our function, so we can add something in future if needed
     * @param string $value
     * @return mixed
     */
    protected function unserialize(string $value)
    {
        return unserialize($value);
    }
}
