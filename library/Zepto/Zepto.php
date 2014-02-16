<?php

namespace Zepto;

use Pimple;
use Whoops;
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
class Zepto {

    /**
     * Current application version
     */
    const VERSION = '0.6';

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
     * <code>
     * $config = array(
     *     'zepto' => array(
     *         'environment'       => 'dev',
     *         'content_dir'       => 'content',
     *         'plugins_dir'       => 'plugins',
     *         'templates_dir'     => 'templates',
     *         'default_template'  => 'base.twig',
     *         'content_ext'       => array('.md', '.markdown'),
     *         'plugins_enabled'   => true
     *     ),
     *     'site' => array(
     *         'site_root'         => 'Site root URL goes here',
     *         'site_title'        => 'Zepto',
     *         'date_format'       => 'jS M Y',
     *         'excerpt_length'    => '50',
     *         'nav'               => array(
     *             'class'             => 'nav',
     *             'dropdown_li_class' => 'dropdown',
     *             'dropdown_ul_class' => 'dropdown-menu'
     *         )
     *     ),
     *     'twig' => array(
     *         'charset'           => 'utf-8',
     *         'cache'             => 'cache',
     *         'strict_variables'  => false,
     *         'autoescape'        => false,
     *         'auto_reload'       => true
     *     )
     * );
     * </code>
     * @param array $settings
     */
    public function __construct(array $settings = array())
    {
        $this->app = new Pimple();

        // Get local reference to container
        $app = $this->app;

        // Set ROOT_DIR in here, rather than as a constant
        $app['ROOT_DIR'] = realpath(getcwd()) . '/';

        $app['request'] = $app->share(
            function() {
                return Request::createFromGlobals();
            }
        );

        $app['response'] = $app->share(
            function() {
                return new Response(
                    'Content',
                    Response::HTTP_OK,
                    array('content-type' => 'text/html; charset=utf-8')
                );
            }
        );

        $app['router'] = $app->share(
            function ($app) {
                return new Router($app['request'], $app['response']);
            }
        );

        $app['content_loader'] = $app->share(
            function ($app) {
                return new FileLoader\MarkdownLoader(
                    $app['ROOT_DIR'] . $app['settings']['zepto']['content_dir'],
                    new \Michelf\MarkdownExtra
                );
            }
        );

        $app['helper'] = $app->share(
            function ($app) {
                return new Helper($app);
            }
        );

        $app['twig'] = $app->share(
            function($app) {
                $twig = new \Twig_Environment(
                    new \Twig_Loader_Filesystem($app['ROOT_DIR'] . 'templates')
                );
                $twig->addExtension(new Extension\Twig);
                return $twig;
            }
        );

        // If settings array is empty, then get a default one
        if (empty($settings) === TRUE) {
            $settings = $this->app['helper']->default_config();
        }
        else {
            // @todo Wrap in try-catch
            $this->app['helper']->validate_config($settings);
        }

        // Set this particular setting now
        $app['plugins_enabled'] = $settings['zepto']['plugins_enabled'];

        // So if plugins ARE indeed enabled, initialise the plugin loader
        // and load the fuckers
        if ($app['plugins_enabled'] === true) {
            $app['plugin_loader'] = $app->share(
                function($c) use ($settings) {
                    return new FileLoader\PluginLoader(
                        $c['ROOT_DIR'] . $settings['zepto']['plugins_dir']
                    );
                }
            );

            $this->load_plugins();
            $this->run_hooks('after_plugins_load');
        }

        // Run application hooks and set application settings
        $this->run_hooks('before_config_load', array(&$settings));
        $app['settings'] = $settings;

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
     * Executes router and returns result of callback function for specified route
     *
     * @return
     */
    public function run()
    {
        $this->run_hooks('before_response_send');
        try {
            return $this->app['router']->run();
        } catch (\Exception $e) {
            $this->app['router']->error($e);
        }
        $this->run_hooks('after_response_send');
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
        if ($this->app['plugins_enabled'] === false) {
            return false;
        }

        // Send app reference to hooks
        $args = array_merge(array($this->app), $args);

        // Run hooks associated with that event
        foreach ($this->app['plugins'] as $plugin_id => $plugin) {
            if (is_callable(array($plugin, $hook_id))) {
                call_user_func_array(array($plugin, $hook_id), $args);
            }
        }
        return true;
    }

    /**
     * Loads all plugins from the 'plugins' directory
     *
     * @return
     */
    protected function load_plugins()
    {
        if ($this->app['plugins_enabled'] === true) {
            // Load plugins from 'plugins' folder
            $this->app['plugins'] = $this->app['plugin_loader']->load_dir();
        }
    }

    /**
     * Does the initial setup for the router. This entails getting the list of
     * loaded files as returned by Zepto\FileLoader and turning that into
     * routes.
     *
     * @return
     */
    protected function setup_router()
    {
        // Get local references
        $app       = $this->app;
        $router    = $app['router'];

        $file_list = $app['content_loader']->get_folder_contents();

        // Add each as a route
        foreach ($file_list as $file) {

            // Get filename without extension
            $exploded_file_name = explode('.', $file);
            $file_name          = $exploded_file_name[0];

            $route = preg_match('/index$/', $file_name) === 1
                ? '/' . str_replace('index', '', $file_name)
                : '/' . $file_name;

            $router->get($route, function() use ($app, $file) {

                // Load content now
                // @todo This is temporary until some sort of Page-based abstraction
                // is implemented. Its horrible, but fuck you
                $content_array = $app['content_loader']->load($file);
                $content       = $content_array[$file];

                // Set Twig options
                $twig_vars = array(
                    'config'     => $app['settings'],
                    'base_url'   => $app['settings']['site']['site_root'],
                    'site_title' => $app['settings']['site']['site_title']
                );

                $app['nav'] = isset($app['nav']) === TRUE ? $app['nav'] : array();

                // Merge Twig options and content into one array
                // @todo Change $app['nav'], and make a better way to inject content into Twig
                $options = array_merge($twig_vars, $content, $app['nav']);

                // Get template name from file, if not set, then use default
                $template_name = array_key_exists('template', $content['meta']) === true
                    ? $content['meta']['template']
                    : $app['settings']['zepto']['default_template'];

                // Render template with Twig
                return $app['twig']->render($template_name, $options);
            });
        }
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
            return null;
        }

        return static::$instance;
    }

}
