<?php
namespace Zepto;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2014-01-30 at 20:18:22.
 */
class RouteTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Route
     */
    protected $route;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->route = new Route('/get/<:id|[0-9]>', function() {
            echo 'Test callback';
        });
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Zepto\Route::url
     */
    public function testUrl()
    {
        $this->assertEquals('/get/<:id|[0-9]>', $this->route->url());
    }

    /**
     * @covers Zepto\Route::pattern
     */
    public function testPattern()
    {
        $this->assertEquals('#^/get/(?P<id>[0-9])/$#', $this->route->pattern());
    }

    /**
     * @covers Zepto\Route::callback
     */
    public function testCallback()
    {
        $this->assertInstanceOf('Closure', $this->route->callback());
    }
}