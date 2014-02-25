<?php
namespace Zepto;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-11-20 at 00:37:02.
 */
class ZeptoTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        // Set superglobals to define application state
        $_SERVER['DOCUMENT_ROOT']   = '/var/www';
        $_SERVER['SCRIPT_FILENAME'] = '/var/www/zepto/index.php';
        $_SERVER['SERVER_NAME']     = 'zepto';
        $_SERVER['SERVER_PORT']     = '80';
        $_SERVER['SCRIPT_NAME']     = '/zepto/';
        $_SERVER['REQUEST_URL']     = '';
        $_SERVER['REQUEST_URI']     = '';
        $_SERVER['REQUEST_METHOD']  = 'GET';
        $_SERVER['QUERY_STRING']    = '';
        $_SERVER['HTTPS']           = '';
        $_SERVER['REMOTE_ADDR']     = '127.0.0.1';
        unset($_SERVER['CONTENT_TYPE'], $_SERVER['CONTENT_LENGTH']);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        Zepto::kill();
    }

    /**
     * CONSTRUCTOR TESTS
     */

    /**
     * @covers Zepto\Zepto::__construct()
     */
    public function testConstructWithSettings()
    {
        $config = array(
            'zepto.environment'           => 'dev',
            'zepto.content_dir'           => 'content',
            'zepto.plugins_dir'           => 'plugins',
            'zepto.templates_dir'         => 'templates',
            'zepto.default_template'      => 'base.twig',
            'zepto.content_ext'           => array('.md', '.markdown'),
            'zepto.plugins_enabled'       => true,
            'site.site_root'              => 'http://localhost:8888/zepto/',
            'site.site_title'             => 'Zepto',
            'site.date_format'            => 'jS M Y',
            'site.excerpt_length'         => '50',
            'site.nav.class'              => 'nav',
            'site.nav.dropdown_li_class'  => 'dropdown',
            'site.nav.dropdown_ul_class'  => 'dropdown-menu',
            'site.nav.dropdown_li_markup' => '<li class="%s"><a href="%s" class="dropdown-toggle" data-toggle="dropdown"> %s <b class="caret"></b></a><ul class="%s">',
            'twig'                       => array(
                'charset'           => 'utf-8',
                'cache'             => 'cache',
                'strict_variables'  => false,
                'autoescape'        => false,
                'auto_reload'       => true
            )
        );
        $zepto = new Zepto($config);
        $this->assertEquals($config, $zepto->app['settings']);
    }

    /**
     * @covers Zepto\Zepto::__construct()
     */
    public function testRouterAdded()
    {
        $zepto = new Zepto();
        $this->assertArrayHasKey('router', $zepto->app);
        $this->assertInstanceOf(
            'Zepto\Router',
            $zepto->app['router']
        );
    }

    /**
     * @covers Zepto\Zepto::__construct()
     * @dataProvider providerConfigWithPluginsEnabled
     */
    public function testPluginLoaderAdded($config)
    {
        $zepto = new Zepto($config);
        $this->assertArrayHasKey('plugin_loader', $zepto->app);
        $this->assertInstanceOf(
            'League\Flysystem\Filesystem',
            $zepto->app['plugin_loader']
        );
        $this->assertInstanceOf(
            'Zepto\Adapter\Plugin',
            $zepto->app['plugin_loader']->getAdapter()
        );
    }

    /**
     * @covers Zepto\Zepto::__construct()
     */
    public function testContentLoaderAdded()
    {
        $zepto = new Zepto();
        $this->assertArrayHasKey('content_loader', $zepto->app);
        $this->assertInstanceOf(
            'League\Flysystem\Filesystem',
            $zepto->app['content_loader']
        );
        $this->assertInstanceOf(
            'Zepto\Adapter\Markdown',
            $zepto->app['content_loader']->getAdapter()
        );
    }

    /**
     * @covers Zepto\Zepto::__construct()
     */
    public function testTwigAdded()
    {
        $zepto = new Zepto();
        $this->assertArrayHasKey('twig', $zepto->app);
        $this->assertInstanceOf(
            '\Twig_Environment',
            $zepto->app['twig']
        );
    }

    /**
     * INITIALIZATION TESTS
     */

    /**
     * @covers Zepto\Zepto::load_plugins()
     * @dataProvider providerConfigWithPluginsEnabled
     */
    public function testLoadPluginsWhenEnabled($config)
    {
        $config['zepto.plugins_enabled'] = TRUE;
        // Add assertion to check if plugins_enabled is true or not
        $zepto = new Zepto($config);
        $this->assertArrayHasKey('plugins', $zepto->app);
        $plugins = $zepto->app['plugins'];
        $this->assertArrayHasKey('WhoopsPlugin', $zepto->app['plugins']);
        $this->assertArrayHasKey('NavGenPlugin', $zepto->app['plugins']);
    }

    /**
     * @covers       Zepto\Zepto::load_plugins()
     * @dataProvider providerConfigWithPluginsEnabled
     */
    public function testLoadPluginsWhenDisabled()
    {
        // Add assertion to check if plugins_enabled is true or not
        $zepto = new Zepto();
        $this->assertArrayNotHasKey('plugins', $zepto->app);
    }

    /**
     * @covers Zepto\Zepto::setup_router()
     */
    public function testSetupRouter()
    {
        $zepto = new Zepto();
        $routes = $zepto->app['router']->routes();

        // Check that routes were added as HTTP GET requests
        $this->assertArrayHasKey('GET', $routes);

        // Check to see only expected routes
        $expected = array('#^/404/$#', '#^/$#', '#^/sub/$#', '#^/sub/page/$#');

        // Check that all routes have a callback function
        $this->assertContainsOnly('Zepto\Route', $routes['GET']);

        foreach ($expected as $route_regex) {
            $this->assertArrayHasKey($route_regex, $routes['GET']);
        }
    }

    /**
     * @covers Zepto\Zepto::run()
     */
    public function testRun()
    {
        ob_start();
        $zepto = new Zepto();
        $this->assertTrue($zepto->run());
        ob_end_clean();
    }

    /**
     * @covers Zepto\Zepto::run()
     */
    public function testRunError()
    {
        $_SERVER['REQUEST_URL']     = '/non-existent';
        $_SERVER['REQUEST_URI']     = '/non-existent';
        ob_start();
        $zepto = new Zepto();
        $this->assertFalse($zepto->run());
        ob_end_clean();
    }

    /**
     * @covers Zepto\Zepto::run_hooks()
     * @dataProvider providerConfigWithPluginsEnabled
     */
    public function testRunHooks($config)
    {
        $zepto = new Zepto($config);
        $this->assertTrue($zepto->run_hooks('before_response_send'));
    }

    /**
     * @covers       Zepto\Zepto::run_hooks()
     * @dataProvider providerConfigWithPluginsEnabled
     */
    public function testRunHooksReturnsFalseWhenPluginsAreDisabled()
    {
        $zepto = new Zepto();
        $this->assertFalse($zepto->run_hooks('before_response_send'));
    }

    /**
     * INSTANTIATION TESTS
     */

    /**
     * @covers Zepto\Zepto::instance()
     */
    public function testInstanceBeforeInitialization()
    {
        $this->assertNull(Zepto::instance());
    }

    /**
     * @covers Zepto\Zepto::instance()
     */
    public function testInstanceAfterInitialization()
    {
        $zepto = new Zepto();
        $this->assertInstanceOf('Zepto\Zepto', Zepto::instance());
    }

    /**
     * @covers Zepto\Zepto::kill()
     */
    public function testKill()
    {
        $zepto = new Zepto();
        $this->assertInstanceOf('Zepto\Zepto', Zepto::instance());
        Zepto::kill();
        $this->assertNull(Zepto::instance());
    }

    public function providerConfigWithPluginsEnabled()
    {
        return array(
            array(
                array(
                    'zepto.environment'           => 'dev',
                    'zepto.content_dir'           => 'content',
                    'zepto.plugins_dir'           => 'plugins',
                    'zepto.templates_dir'         => 'templates',
                    'zepto.default_template'      => 'base.twig',
                    'zepto.content_ext'           => array('.md', '.markdown'),
                    'zepto.plugins_enabled'       => true,
                    'site.site_root'              => 'http://localhost:8888/zepto/',
                    'site.site_title'             => 'Zepto',
                    'site.date_format'            => 'jS M Y',
                    'site.excerpt_length'         => '50',
                    'twig'                       => array(
                        'charset'           => 'utf-8',
                        'cache'             => 'cache',
                        'strict_variables'  => false,
                        'autoescape'        => false,
                        'auto_reload'       => true
                    )
                )
            )
        );
    }

}
