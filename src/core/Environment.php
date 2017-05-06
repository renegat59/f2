<?php

namespace FTwo\core;

/**
 * Description of Environment
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class Environment
{
    const DEV = 'DEV';
    const PROD = 'PROD';

    private $env = self::PROD;

    public function __construct(string $env)
    {
        $this->env = $env;
    }

    public function isProd(): bool
    {
        return self::DEV === $this->env;
    }

    public function isDev(): bool
    {
        return self::DEV === $this->env;
    }

}
