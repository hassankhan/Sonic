<?php
namespace Sonic\Flysystem\Plugin;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2014-02-24 at 21:04:47.
 */
class PluginTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Plugin
     */
    protected $plugin;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->plugin = new Plugin();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Sonic\Flysystem\Plugin\Plugin::getMethod()
     */
    public function testGetMethod()
    {
        $this->assertEquals('include', $this->plugin->getMethod());
    }

    /**
     * @covers Sonic\Flysystem\Plugin\Plugin::handle()
     */
    public function testHandle()
    {
        $actual = $this->plugin->handle('tests/mocks/SimplePlugin.php');
        $this->assertInstanceOf('Sonic\PluginAbstract', $actual);
    }

    /**
     * @covers Sonic\Flysystem\Plugin\Plugin::handle()
     * @expectedException UnexpectedValueException
     */
    public function testHandlePluginWithNoInterface()
    {
        $this->plugin->handle('tests/mocks/NoInterfacePlugin.php');
    }
}
