<?php
namespace Zepto;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-11-20 at 00:37:02.
 */
class ZeptoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Zepto
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $_SERVER['DOCUMENT_ROOT']   = '/var/www';
        $_SERVER['SCRIPT_FILENAME'] = '/var/www/zepto/index.php';
        $_SERVER['SERVER_NAME']     = 'zepto';
        $_SERVER['SERVER_PORT']     = '80';
        $_SERVER['SCRIPT_NAME']     = '/zepto/';
        $_SERVER['REQUEST_URL']     = '/zepto/';
        $_SERVER['REQUEST_URI']     = '/zepto/';
        $_SERVER['PATH_INFO']       = '/bar/xyz';
        $_SERVER['REQUEST_METHOD']  = 'GET';
        $_SERVER['QUERY_STRING']    = 'one=1&two=2&three=3';
        $_SERVER['HTTPS']           = '';
        $_SERVER['REMOTE_ADDR']     = '127.0.0.1';
        unset($_SERVER['CONTENT_TYPE'], $_SERVER['CONTENT_LENGTH']);

        include ROOT_DIR . 'config.php';
        $this->object = new Zepto($config);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * CONSTRUCTOR TESTS
     */

    /**
     * @covers Zepto\Zepto::__construct()
     * @covers Zepto\Zepto::load_plugins()
     * @covers Zepto\Zepto::load_content()
     * @covers Zepto\Zepto::create_nav_links()
     * @covers Zepto\Zepto::setup_router()
     */
    public function testRouterAdded()
    {
        $zepto = $this->object;
        $this->assertArrayHasKey('router', $zepto->container);
        $this->assertInstanceOf(
            'Zepto\Router',
            $zepto->container['router']
        );
    }

    /**
     * @covers Zepto\Zepto::__construct()
     */
    public function testPluginLoaderAdded()
    {
        $zepto = $this->object;
        $this->assertArrayHasKey('plugin_loader', $zepto->container);
        $this->assertInstanceOf(
            'Zepto\FileLoader\PluginLoader',
            $zepto->container['plugin_loader']
        );
    }

    /**
     * @covers Zepto\Zepto::__construct()
     */
    public function testFileLoaderAdded()
    {
        $zepto = $this->object;
        $this->assertArrayHasKey('file_loader', $zepto->container);
        $this->assertInstanceOf(
            'Zepto\FileLoader\MarkdownLoader',
            $zepto->container['file_loader']
        );
    }

    /**
     * @covers Zepto\Zepto::__construct()
     */
    public function testTwigAdded()
    {
        $zepto = $this->object;
        $this->assertArrayHasKey('twig', $zepto->container);
        $this->assertInstanceOf(
            '\Twig_Environment',
            $zepto->container['twig']
        );
    }

    /**
     * @covers Zepto\Zepto::run
     * @todo   Implement testRun().
     */
    public function testRun()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Zepto\Zepto::run_hooks
     * @todo   Implement testRun_hooks().
     */
    public function testRun_hooks()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }
}
