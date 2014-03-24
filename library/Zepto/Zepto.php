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

        $app['filesystem'] = function ($app) {
            $filesystem = new \League\Flysystem\Filesystem(
                new \League\Flysystem\Adapter\Local($app['ROOT_DIR'])
            );
            $filesystem->addPlugin($app['content_plugin']);
            $filesystem->addPlugin($app['plugin_plugin']);
            $filesystem->addPlugin($app['tag_parser_plugin']);
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
            $file_name = str_replace(
                $app['settings']['zepto.content_dir'],
                '',
                $file['dirname'] . '/' . $file['filename']
            );

            $route = '/' . trim(str_replace('/index', '/', $file_name), '/');

            $this->app['router']->get($route, array($this, 'create_route'));
        }
        $this->app['router']->get('/tag/<:tag_name>', array($this, 'create_tag_route'));
    }

    /**
     * The default route callback for any files in the 'content' folder
     *
     * @return string
     */
    public function create_route()
    {
        // Get resource URL
        $resource_url = $this->app['router']->request()->getPathInfo();

        // Get file path
        $path = rtrim($this->app['settings']['zepto.content_dir'] . $resource_url, '/');

        // Check if file(s) exist
        $contents = $this->app['filesystem']->listContents($path);

        // Load file
        $loaded_file = empty($contents) === TRUE
            ? $loaded_file = $this->app['filesystem']->parse($path . '.md')
            : $loaded_file = $this->app['filesystem']->parse(rtrim($path, '/') . '/' . 'index.md');

        $this->app['extra'] = isset($this->app['extra']) === TRUE ? $this->app['extra'] : array();

        // Merge Twig options and content into one array
        $options = array_merge($loaded_file, $this->app['extra']);

        // Get template name from file, if not set, then use default
        $template_name = array_key_exists('template', $loaded_file['meta']) === true
            ? $loaded_file['meta']['template']
            : $this->app['settings']['zepto.default_template'];

        // Render template with Twig
        return $this->app['twig']->render($template_name, $options);
    }

    /**
     * The default route callback for the '/tag/<tag_name>' route
     *
     * @return string
     */
    public function create_tag_route($tag_name)
    {
        $loaded_file = $this->app['tags'][$tag_name];
        $loaded_file['contents'] = implode(' ', $loaded_file);

        // Set Twig options
        $twig_vars = array(
            'config'     => $this->app['settings'],
            'base_url'   => $this->app['settings']['site.site_root'],
            'site_title' => $this->app['settings']['site.site_title']
        );

        $this->app['extra'] = isset($this->app['extra']) === TRUE ? $this->app['extra'] : array();

        // Merge Twig options and content into one array
        $options = array_merge($twig_vars, $loaded_file, $this->app['extra']);

        // Render template with Twig
        return $this->app['twig']->render($this->app['settings']['zepto.default_template'], $options);
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
