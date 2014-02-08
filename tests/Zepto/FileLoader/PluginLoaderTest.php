<?php
namespace Zepto\FileLoader;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-11-03 at 13:49:12.
 */
class PluginLoaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PluginLoader
     */
    protected $loader;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->loader   = new PluginLoader(ROOT_DIR . 'plugins');

        // include_once(ROOT_DIR . 'plugins/ExamplePlugin.php');
        // include_once(ROOT_DIR . 'plugins/OtherExamplePlugin.php');
        // include_once(ROOT_DIR . 'plugins/WhoopsPlugin.php');

        // $plugin_1_name = 'ExamplePlugin';
        // $plugin_2_name = 'OtherExamplePlugin';
        // $plugin_3_name = 'WhoopsPlugin';

        // $plugin_1      = new $plugin_1_name;
        // $plugin_2      = new $plugin_2_name;
        // $plugin_3      = new $plugin_3_name;

        // $this->plugins = array(
        //     $plugin_1_name => $plugin_1,
        //     $plugin_2_name => $plugin_2,
        //     $plugin_3_name => $plugin_3
        // );
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        $this->loader = null;
    }

    /**
     * @covers Zepto\FileLoader\PluginLoader::load
     */
    public function testLoadSingleFile()
    {
        $plugin_name = 'ExamplePlugin';

        $actual = $this->loader->load($plugin_name . '.php');

        $this->assertArrayHasKey($plugin_name, $actual);
        $this->assertInstanceOf('Zepto\PluginInterface', $actual[$plugin_name]);
    }

    /**
     * @covers Zepto\FileLoader\PluginLoader::load
     * @expectedException InvalidArgumentException
     */
    public function testLoadInvalidPluginName()
    {
        $this->loader   = new PluginLoader(ROOT_DIR . 'tests/');
        $actual = $this->loader->load('invalid_Plugin.php');
    }

    /**
     * @covers Zepto\FileLoader\PluginLoader::load()
     * @expectedException RuntimeException
     */
    public function testLoadWithPluginThatDoesNotHaveSameClassName()
    {
        $this->loader   = new PluginLoader(ROOT_DIR . 'tests/');
        $actual = $this->loader->load('WrongNamePlugin.php');
    }

    /**
     * @covers Zepto\FileLoader\PluginLoader::load()
     * @expectedException UnexpectedValueException
     */
    public function testLoadWithPluginThatDoesNotImplementInterface()
    {
        $this->loader   = new PluginLoader(ROOT_DIR . 'tests/');
        $actual = $this->loader->load('NoImplementInterfacePlugin.php');
    }

    /**
     * @covers Zepto\FileLoader\PluginLoader::load()
     * @expectedException UnexpectedValueException
     */
    public function testLoadInvalidFilePath()
    {
        $this->loader->load('@£@');
    }

    /**
     * @covers Zepto\FileLoader\PluginLoader::load_dir()
     */
    public function testLoadDirectory()
    {
        $actual = $this->loader->load_dir('');

        $this->assertArrayHasKey('ExamplePlugin',      $actual);
        $this->assertArrayHasKey('OtherExamplePlugin', $actual);
        $this->assertArrayHasKey('WhoopsPlugin',       $actual);

        $this->assertInstanceOf('Zepto\PluginInterface', $actual['ExamplePlugin']);
        $this->assertInstanceOf('Zepto\PluginInterface', $actual['OtherExamplePlugin']);
        $this->assertInstanceOf('Zepto\PluginInterface', $actual['WhoopsPlugin']);
    }

    /**
     * @covers Zepto\FileLoader\PluginLoader::load_dir()
     * @expectedException UnexpectedValueException
     */
    public function testLoadInvalidDirectory()
    {
        $actual = $this->loader->load_dir('!@£');
    }

}
