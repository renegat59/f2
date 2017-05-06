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
        self::$components[$containerName] = $object;
    }

    /**
     * Gets the component from the container.
     * @param string $componentName
     * @return \FTwo\core\Component
     */
    public function get(string $componentName): Component
    {
        if (isset(self::$components[$componentName])) {
            return self::$components[$componentName];
        }
        throw new exceptions\F2Exception("Component $componentName is not available");
    }
}
