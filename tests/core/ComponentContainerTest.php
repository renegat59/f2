<?php

namespace FTwo\tests\core;

use FTwo\core\Component;
use FTwo\core\ComponentContainer;
use FTwo\core\exceptions\F2Exception;
use PHPUnit\Framework\TestCase;

/**
 * Description of ComponentContainerTest
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class ComponentContainerTest extends TestCase
{
    private $container;

    public function setUp()
    {
        parent::setUp();
        $this->container = new ComponentContainer();
    }

    public function testInitAndExists()
    {
        $this->assertFalse($this->container->exists('test'));
        $this->container->init('test', new class extends Component {
        });
        $this->assertTrue($this->container->exists('test'));
    }

    public function testGet()
    {
        $this->assertFalse($this->container->exists('test'));
        $this->expectException(F2Exception::class);
        $this->assertFalse($this->container->get('test'));
        $component = new class extends Component {
            public $testValue = 'yes';
        };
        $this->container->init('test', $component);
        $got = $this->container->get('test');
        $this->assertNotNull($component);
        $this->assertSame($component, $got);
    }
}
