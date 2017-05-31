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
    private $cacheTime;
    private $cachePath;

    public function __construct($config)
    {
        $this->cacheTime = $config['cacheTime'] ?? 86400;
        $this->cachePath = $config['cachePath'] ?? $this->defaultCachePath();
        $this->setEnabled($config['enabled'] ?? true);
    }

    private function defaultCachePath(): string
    {
        $scriptName = filter_input(INPUT_SERVER, 'SCRIPT_FILENAME');
        return dirname($scriptName).DIRECTORY_SEPARATOR.'cache';
    }

    public function init()
    {
        parent::init();
    }

    /**
     * Gets path from web cache
     * @param string $path Path to be cached url notated (ie: /posts/all)
     */
    public function getPath(string $path)
    {
        $cacheFilePath = $this->buildPath($path);
        if (file_exists($cacheFilePath)) {
            if (filemtime($cacheFilePath) > time()) {
                return file_get_contents($cacheFilePath);
            }
            unlink($cacheFilePath);
        }
        return false;
    }

    public function cachePath(string $path, string $content)
    {
        $cacheFilePath = $this->buildPath($path);
        if (file_exists($cacheFilePath)) {
            unlink($cacheFilePath);
        }
        $fileDirectory = dirname($cacheFilePath);
        if (!file_exists($fileDirectory)) {
            mkdir($fileDirectory, 0755, true);
        }
        file_put_contents($cacheFilePath, $content);
        touch($cacheFilePath, time() + $this->cacheTime);
    }

    public function purge()
    {
        $this->cleanCache($this->cachePath);
    }

    private function cleanCache($directory)
    {
        if (empty($directory)) {
            return true;
        }

        if (!file_exists($directory)) {
            return true;
        }

        if (!is_dir($directory)) {
            return unlink($directory);
        }

        foreach (glob($directory.DIRECTORY_SEPARATOR.'*') as $item) {
            if (!$this->cleanCache($item)) {
                return false;
            }
        }
        if ($directory === $this->cachePath) {
            //do not delete the cache directory itself
            return true;
        }
        return rmdir($directory);
    }

    private function buildPath($path)
    {
        return $this->cachePath.str_replace('/', DIRECTORY_SEPARATOR, $path).'.html';
    }
}
