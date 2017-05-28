<?php

namespace FTwo\core;

/**
 * Class containing all the components
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class ComponentContainer
{
    private static $components = array();

    /**
     * Adds a component to the components lists
     * @param string $containerName
     * @param type $object
     */
    public function init(string $containerName, $object)
    {
        $object->init();
        self::$components[$containerName] = $object;
    }

    /**
     * Gets the component from the container.
     * @param string $componentName
     * @return \FTwo\core\Component
     */
    public function get(string $componentName): Component
    {
        if ($this->exists($componentName)) {
            return self::$components[$componentName];
        }
        throw new exceptions\F2Exception("Component $componentName is not available");
    }

    public function exists(string $componentName): bool
    {
        return isset(self::$components[$componentName]);
    }
}
