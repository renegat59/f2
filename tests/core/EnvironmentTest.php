<?php

use FTwo\core\Environment;
use PHPUnit\Framework\TestCase;

/**
 * Description of EnvironmentTest
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class EnvironmentTest extends TestCase
{
    /**
     * @covers Environment::isDev()
     */
    public function testIsDev()
    {
        $environment = new Environment(Environment::PROD);
        $this->assertFalse($environment->isDev());
        $environment = new Environment(Environment::DEV);
        $this->assertTrue($environment->isDev());
    }

    /**
     * @covers Environment::isProd()
     */
    public function testIsProd()
    {
        $environment = new Environment(Environment::DEV);
        $this->assertFalse($environment->isProd());
        $environment = new Environment(Environment::PROD);
        $this->assertTrue($environment->isProd());
    }

}

