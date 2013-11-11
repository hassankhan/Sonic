<?php

/**
 * Zepto
 *
 * @author Hassan Khan
 * @link http://https://github.com/hassankhan/Zepto
 * @license http://opensource.org/licenses/MIT
 * @version 0.2
 */

namespace Zepto;

// Define constant for root directory
defined('ROOT_DIR')
    || define('ROOT_DIR', str_replace('library/Zepto', '', realpath(dirname(__FILE__))));

use Pimple;
use Whoops;

class Zepto {

    const VERSION = '0.2';

    public $container;

    protected $hooks = array();

    /**
     * Zepto constructor
     *
     * <code>
     * $config = array(
     *     'zepto' => array(
     *         'cache_dir'     => ROOT_DIR . 'cache',
     *         'content_dir'   => ROOT_DIR . 'content',
     *         'plugin_dir'    => ROOT_DIR . 'plugins',
     *         'templates_dir' => ROOT_DIR . 'templates',
     *         'content_ext'   => array('md', 'markdown')
     *     ),
     *     'site' => array(
     *         'site_root'      => 'Site root URL goes here',
     *         'site_title'     => 'Zepto',
     *         'theme'          => 'default',
     *         'date_format'    => 'jS M Y',
     *         'page_order'     => 'asc',
     *         'page_order_by'  => 'date|a-z',
     *         'excerpt_length' => '50'
     *     ),
     *     'twig' => array(
     *         'cache'      => false,
     *         'autoescape' => false,
     *         'debug'      => false
     *     )
     * );
     * </code>
     * @param array $settings An array of options - see above
     */
    public function __construct(array $settings = array())
    {
        $this->container = new Pimple();

        // Get local reference to container
        $container                  = $this->container;
        // Set application settings
        $container['settings']      = $settings;

        // Configure error handler
        $container['error_handler'] = $container->share(
            function ($container) {
                return new Whoops\Run();
            }
        );
        $whoops = $this->_configure_error_handler();

        $container['router'] = $container->share(
            function ($container) {
                return new Router;
            }
        );

        $container['file_loader'] = $container->share(
            function ($container) {
                return new FileLoader\MarkdownLoader();
            }
        );

        $container['twig'] = $container->share(
            function ($container) {
                return new \Twig_Environment(
                    new \Twig_Loader_Filesystem(ROOT_DIR . 'templates')
                );
            }
        );

        // Load content from files
        $this->load_files();

        // Add basic routes to router
        $this->setup_router();

    }

    public function run()
    {
        $router = $this->container['router'];
        $router->execute();
    }

    protected function load_files()
    {
        // Get local reference to file loader
        $container   = $this->container;
        $file_loader = $container['file_loader'];
        $settings    = $container['settings']['zepto'];

        $container['content'] = $file_loader->load(
            $settings['content_dir'],
            $settings['content_ext']
        );
    }

    /**
     * Does the initial setup for the router. This entails getting the list of
     * loaded files as returned by Zepto\FileLoader and turning that into
     * routes.
     * @todo Add Twig render function
     * @todo Map 'index' pages to '/'
     * @return void
     */
    protected function setup_router()
    {
        // Get local references
        $container = $this->container;
        $router    = $container['router'];

        // Get loaded files array keys
        $files  = array_keys($container['content']);

        // Remove 'content' and file extensions from path
        $clean_files = str_replace(
            array('.md', '.markdown'),
            '',
            $files
        );

        // Add each as a route
        foreach ($clean_files as $file) {

            $route = preg_match('/index$/', $file) === 1
                ? '/' . str_replace('index', '', $file)
                : '/' . $file;

            $router->route($route, function() use ($container, $file) {

                // Get local references to Twig and content
                $twig    = $container['twig'];
                $content = $container['content'][$file . '.md'];

                // Set Twig options
                $twig_options = array(
                    'config'     => $container['settings']['twig'],
                    'base_dir'   => '/zepto',
                    'base_url'   => $container['settings']['site']['site_root'],
                    'site_title' => $container['settings']['site']['site_title']
                );

                // Retrieve template name, if none given, use base template
                $template_name = $content['meta']['template'] === ''
                    ? 'base.twig'
                    : $content['meta']['template'];

                // Merge Twig options and content into one array
                $options = array_merge($twig_options, $content);
                // Render template with Twig
                echo $twig->render($template_name, $options);
            });
        }
    }

    // This should be moved into a plugin
    private function _configure_error_handler()
    {
        // Get local reference to error handler
        $error_handler = $this->container['error_handler'];

        // Configure the PrettyPageHandler:
        $errorPage = new Whoops\Handler\PrettyPageHandler();

        $errorPage->setPageTitle("Shit hit the fan!");
        $errorPage->setEditor("sublime");
        $error_handler->pushHandler($errorPage);
        $error_handler->register();
    }

}
