<?php

namespace FTwo\cache;

use FTwo\core\Component;

/**
 * WebCache caches the rendered pages
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class WebCache extends Component
{
    public function init()
    {
        parent::init();
    }

    public function getPath(string $path): string
    {

    }

    public function cachePath(string $path, string $content)
    {
        
    }
}
