<?php

namespace Zepto;

use Pimple;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use Michelf\MarkdownExtra;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Zepto
 *
 * @package    Zepto
 * @subpackage Zepto
 * @author     Hassan Khan <contact@hassankhan.me>
 * @link       https://github.com/hassankhan/Zepto
 * @license    MIT
 * @since      0.2
 */
class Zepto
{
    /**
     * Current application version
     */
    const VERSION = '0.7';

    /**
     * Container object to store all dependencies
     *
     * @var \Pimple
     */
    public $app;

    /**
     * A singleton instance of this class, provided as a static property
     *
     * @var \Zepto\Zepto
     * @static
     */
    protected static $instance;

    /**
     * Zepto constructor
     *
     * @param array $settings
     */
    public function __construct(array $settings = array())
    {
        $this->app = new Pimple();

        // Get local reference to container
        $app = $this->app;

        // Set ROOT_DIR in here, rather than as a constant
        $app['ROOT_DIR'] = realpath(getcwd()) . '/';

        $app['request'] = function () {
            return Request::createFromGlobals();
        };

        $app['response'] = function () {
            return new Response(
                'Content',
                Response::HTTP_OK,
                array('content-type' => 'text/html; charset=utf-8')
            );
        };

        $app['router'] = function ($app) {
            return new Router($app['request'], $app['response']);
        };

        $app['content_plugin'] = function () {
            $plugin = new Flysystem\Plugin\Markdown();
            $plugin->setParser(new \Michelf\MarkdownExtra);
            return $plugin;
        };

        $app['plugin_plugin'] = function ($app) {
            return new Flysystem\Plugin\Plugin();
        };

        $app['tag_parser_plugin'] = function ($app) {
            return new Flysystem\Plugin\TagParser();
        };

        $app['date_parser_plugin'] = function ($app) {
            return new Flysystem\Plugin\DateParser();
        };

        $app['filesystem'] = function ($app) {
            $filesystem = new \League\Flysystem\Filesystem(
                new \League\Flysystem\Adapter\Local($app['ROOT_DIR'])
            );
            $filesystem->addPlugin($app['content_plugin']);
            $filesystem->addPlugin($app['plugin_plugin']);
            $filesystem->addPlugin($app['tag_parser_plugin']);
            $filesystem->addPlugin($app['date_parser_plugin']);
            return $filesystem;
        };

        $app['helper'] = function ($app) {
            return new Helper($app);
        };

        $app['twig'] = function ($app) {
            $twig = new \Twig_Environment(
                new \Twig_Loader_Filesystem($app['ROOT_DIR'] . 'templates'),
                $app['settings']['twig']
            );
            $twig->addExtension(new Extension\Twig);
            return $twig;
        };

        // If settings array is empty, then get a default one and validate it
        $settings = array_merge($this->app['helper']->default_config(), $settings);
        $this->app['helper']->validate_config($settings);

        // Set this particular setting now
        $this->app['settings'] = $settings;
        // If plugins ARE indeed enabled, initialise the plugin loader
        // and load the fuckers
        if ($this->app['settings']['zepto.plugins_enabled'] === TRUE) {
            $this->load_plugins();
            $this->run_hooks('after_plugins_load');
        }

        // Run application hooks and reload application settings
        $this->run_hooks('before_config_load', array(&$settings));
        $app['settings'] = $settings;
        $app['tags']     = $this->app['filesystem']->tags('content');

        // Add basic routes to router and run application hooks
        $this->run_hooks('before_router_setup');
        $this->setup_router();
        $this->run_hooks('after_router_setup');

        // Set default instance to this one
        if (is_null(static::instance())) {
            static::$instance = $this;
        }
    }

    /**
     * Executes router and returns true for a successful route,
     *
     * @return bool|null
     */
    public function run()
    {
        $this->run_hooks('before_response_send');
        return $this->app['router']->run();
        // $this->run_hooks('after_response_send');
    }

    /**
     * Runs all hooks registered to the specified hook name
     *
     * @param  string  $hook_id
     * @param  string  $args
     * @return boolean
     */
    public function run_hooks($hook_id, $args = array())
    {
        // If plugins are disabled, do not run
        if ($this->app['settings']['zepto.plugins_enabled'] === FALSE) {
            return FALSE;
        }

        // Send app reference to hooks
        $args = array_merge(array($this->app), $args);

        // Run hooks associated with that event
        foreach ($this->app['plugins'] as $plugin_id => $plugin) {
            if (is_callable(array($plugin, $hook_id))) {
                call_user_func_array(array($plugin, $hook_id), $args);
            }
        }
        return TRUE;
    }

    /**
     * Loads all plugins from the 'plugins' directory
     *
     * @return
     */
    protected function load_plugins()
    {
        if ($this->app['settings']['zepto.plugins_enabled'] === TRUE) {

            // Load plugins from 'plugins' folder
            $file_list    = $this->app['filesystem']->listContents($this->app['settings']['zepto.plugins_dir']);

            $plugin_files = array_filter($file_list, function ($file) {
                return preg_match('#^([A-Z]+\w+)Plugin.php$#', $file['basename']) === 1
                    ? TRUE
                    : FALSE;
            });

            foreach ($plugin_files as $plugin_file) {
                $plugins[$plugin_file['filename']] = $this->app['filesystem']->include($plugin_file['path']);
            }

            $this->app['plugins'] = $plugins;
        }
    }

    /**
     * Does the initial setup for the router. This entails creating the routes
     * for the application, mainly
     *
     * @return
     */
    protected function setup_router()
    {
        // Only because you can't use $this->app in the callback
        $app       = $this->app;
        $file_list = $app['filesystem']->listContents($app['settings']['zepto.content_dir'], true);

        $files     = array_filter($file_list, function ($file) {
            return isset($file['extension']) && $file['extension'] === 'md'
                ? TRUE
                : FALSE;
        });

        // Add each as a route
        foreach ($files as $file) {

            // Get filename without extension
            $file_path = str_replace(
                $app['settings']['zepto.content_dir'],
                '',
                $file['dirname'] . '/' . $file['filename']
            );

            $route = '/' . trim(str_replace('/index', '/', $file_path), '/');

            $this->app['router']->route(new Route\DefaultRoute($route));
        }
        $this->app['router']->route(new Route\TagRoute('/tags/<:tag_name>'));
    }

    /**
     * Retrieves current instance, if one exists, otherwise returns null
     *
     * @return \Zepto\Zepto|null
     * @static
     */
    public static function instance()
    {
        if (isset(static::$instance) === FALSE) {
            Zepto::kill();
            return null;
        }

        return static::$instance;
    }

    /**
     * Annoying method to help with tests. It probably would kill the app too
     *
     * @return
     */
    public static function kill()
    {
        static::$instance = NULL;
    }

}
