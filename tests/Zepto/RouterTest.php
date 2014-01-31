<?php
namespace Zepto;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2014-01-30 at 20:40:01.
 */
class RouterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Router
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
        $_SERVER['SCRIPT_NAME']     = '/zepto/index.php';
        $_SERVER['REQUEST_URL']     = '/zepto/index.php/bar/xyz';
        $_SERVER['REQUEST_URI']     = '/zepto/index.php/bar/xyz';
        $_SERVER['PATH_INFO']       = '/bar/xyz';
        $_SERVER['REQUEST_METHOD']  = 'GET';
        $_SERVER['QUERY_STRING']    = 'one=1&two=2&three=3';
        $_SERVER['HTTPS']           = '';
        $_SERVER['REMOTE_ADDR']     = '127.0.0.1';
        unset($_SERVER['CONTENT_TYPE'], $_SERVER['CONTENT_LENGTH']);

        $this->mock_request = $this->getMock(
            'Symfony\Component\HttpFoundation\Request',
            array('getPathInfo', 'getMethod')
        );

        $mock_response = $this->getMock(
            'Symfony\Component\HttpFoundation\Response',
            array('setContent', 'setStatusCode', 'send')
        );

        // Set up mock request
        $this->mock_request->expects($this->any())
            ->method('getMethod')
            ->will($this->returnValue('GET'));

        // Initialise router
        $this->router = new Router($this->mock_request, $mock_response);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Zepto\Router::get
     */
    public function testGet()
    {
        $this->router->get('/get', function() {
            return 'This is a get route';
        });

        $routes = $this->router->routes();

        $this->assertArrayHasKey('GET', $routes);
        $this->assertArrayHasKey('#^/get/$#', $routes['GET']);
        $this->assertInstanceOf('Zepto\Route', $routes['GET']['#^/get/$#']);
    }

    /**
     * @covers Zepto\Router::post
     */
    public function testPost()
    {
        $this->router->post('/post', function() {
            return 'This is a post route';
        });

        $routes = $this->router->routes();

        $this->assertArrayHasKey('POST', $routes);
        $this->assertArrayHasKey('#^/post/$#', $routes['POST']);
        $this->assertInstanceOf('Zepto\Route', $routes['POST']['#^/post/$#']);
    }

    /**
     * @covers Zepto\Router::get
     * @expectedException Exception
     */
    public function testAddingSameRouteTwice()
    {
        $this->router->get('/get', function() {
            return 'This is a get route';
        });

        $this->router->get('/get', function() {
            return 'This is a get route';
        });
    }

    /**
     * @covers Zepto\Router::match
     * @todo   Implement testMatch().
     */
    public function testMatch()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Zepto\Router::run
     * @covers Zepto\Router::parse_parameters
     * @covers Zepto\Router::current_route
     * @covers Zepto\Router::current_http_status
     */
    public function testRun()
    {
        $_SERVER['REQUEST_URL'] = '/zepto/index.php/get';
        $_SERVER['REQUEST_URI'] = '/zepto/index.php/get';

        $this->mock_request->expects($this->any())
            ->method('getPathInfo')
            ->will($this->returnValue('/get/'));

        $this->router->get('/get', function() {
            return 'This is a get route';
        });

        $this->router->run();

        $this->assertEquals('/get', $this->router->current_route()->url());
        $this->assertEquals('#^/get/$#', $this->router->current_route()->pattern());
        $this->assertEquals(200, $this->router->current_http_status());
    }

    /**
     * @covers Zepto\Router::run
     * @covers Zepto\Router::parse_parameters
     * @covers Zepto\Router::current_route
     * @covers Zepto\Router::current_http_status
     */
    public function testRunWithParameters()
    {
        $_SERVER['REQUEST_URL']     = '/zepto/index.php/get/666';
        $_SERVER['REQUEST_URI']     = '/zepto/index.php/get/666';

        $this->mock_request->expects($this->any())
            ->method('getPathInfo')
            ->will($this->returnValue('/get/666'));

        $this->router->get('/get/<:id|[6]{3}>', function($id) {
            return 'This is ' . $id;
        });
        $this->router->run();

        $this->assertEquals('/get/<:id|[6]{3}>', $this->router->current_route()->url());
        $this->assertEquals('#^/get/(?P<id>[6]{3})/$#', $this->router->current_route()->pattern());
        $this->assertEquals(200, $this->router->current_http_status());
    }

    /**
     * @covers Zepto\Router::run
     * @expectedException Exception
     */
    public function testRunBeforeAddingRoutes()
    {
        $this->router->run();
    }

    /**
     * @covers Zepto\Router::run
     * @covers Zepto\Router::not_found
     */
    public function testRunWithNotFoundError()
    {
        $_SERVER['REQUEST_URL']     = '/zepto/notfound';
        $_SERVER['REQUEST_URI']     = '/zepto/notfound';

        $this->mock_request->expects($this->any())
            ->method('getPathInfo')
            ->will($this->returnValue('/notfound'));

        $this->router->get('/get', function() {
            return 'This is a get route';
        });

        $this->router->run();

        $this->assertEquals(404, $this->router->current_http_status());
    }

    /**
     * @covers Zepto\Router::run
     * @covers Zepto\Router::error
     */
    public function testRunWithError()
    {
        $_SERVER['REQUEST_URL']     = '/zepto/failure';
        $_SERVER['REQUEST_URI']     = '/zepto/failure';

        $this->mock_request->expects($this->any())
            ->method('getPathInfo')
            ->will($this->returnValue('/failure'));

        $this->router->get('/failure', function() {
            throw new \Exception('Proving another point');
        });

        $this->router->run();

        $this->assertEquals(500, $this->router->current_http_status());
    }

    /**
     * @covers Zepto\Router::routes
     */
    public function testRoutes()
    {
        $this->router->get('/get', function() {
            return 'This is a get route';
        });

        $this->router->post('/post', function() {
            return 'This is a post route';
        });

        $routes = $this->router->routes();

        $this->assertArrayHasKey('GET', $routes);
        $this->assertArrayHasKey('#^/get/$#', $routes['GET']);
        $this->assertInstanceOf('Zepto\Route', $routes['GET']['#^/get/$#']);

        $this->assertArrayHasKey('POST', $routes);
        $this->assertArrayHasKey('#^/post/$#', $routes['POST']);
        $this->assertInstanceOf('Zepto\Route', $routes['POST']['#^/post/$#']);
    }

    /**
     * @covers Zepto\Router::error
     * @todo   Implement testError().
     */
    public function testError()
    {
        // Try adding custom callback
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Zepto\Router::not_found
     * @todo   Implement testNot_found().
     */
    public function testNotFound()
    {
        // Try adding custom callback
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }
}
