<?php
namespace FTwo\core;

/**
 * Base Component for F2 application
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class Component
{
    private $enabled;

    public function init()
    {
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled)
    {
        $this->enabled = $enabled;
    }
}
