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
    || define('ROOT_DIR', realpath(getcwd()) . '/');

use Pimple;
use Whoops;
use Michelf\MarkdownExtra;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


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
    public $container;

    /**
     * A singleton instance of this class, provided as a static property
     *
     * @var \Zepto\Zepto
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
        $this->container = new Pimple();

        // Get local reference to container
        $container = $this->container;

        // Set ROOT_DIR in here, rather than as a constant
        $container['ROOT_DIR'] = realpath(getcwd()) . '/';

        $container['request'] = $container->share(
            function() {
                return Request::createFromGlobals();
            }
        );

        $container['response'] = $container->share(
            function() {
                return new Response(
                    'Content',
                    Response::HTTP_OK,
                    array('content-type' => 'text/html; charset=utf-8')
                );
            }
        );

        $container['router'] = $container->share(
            function($c) {
                return new Router($c['request'], $c['response']);
            }
        );

        $container['content_loader'] = $container->share(
            function($c) {
                return new FileLoader\MarkdownLoader(
                    $c['ROOT_DIR'] . $c['settings']['zepto']['content_dir'],
                    new \Michelf\MarkdownExtra
                );
            }
        );

        $container['twig'] = $container->share(
            function($c) {
                return new \Twig_Environment(
                    new \Twig_Loader_Filesystem($c['ROOT_DIR'] . 'templates')
                );
            }
        );

        // If settings array is empty, then get a default one
        if (empty($settings) === TRUE) {
            $settings = $this->default_config();
        }
        else {
            // @todo Wrap in try-catch
            $this->validate_config($settings);
        }

        // Set this particular setting now
        $container['plugins_enabled'] = $settings['zepto']['plugins_enabled'];

        // So if plugins ARE indeed enabled, initialise the plugin loader
        // and load the fuckers
        if ($container['plugins_enabled'] === true) {
            $container['plugin_loader'] = $container->share(
                function($c) use ($settings) {
                    return new FileLoader\PluginLoader(
                        $c['ROOT_DIR'] . $settings['zepto']['plugins_dir']
                    );
                }
            );

            $this->load_plugins();
        }

        // Run application hooks and set application settings
        $this->run_hooks('before_config_load', array(&$settings));
        $container['settings'] = $settings;

        // Create navigation object
        $this->create_nav_links();

        // Add basic routes to router
        $this->setup_router();

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
            return $this->container['router']->run();
        } catch (\Exception $e) {
            $this->container['router']->error($e);
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
        $container = $this->container;

        // echo $container['plugins_enabled'] === true ? 'true' : 'false';

        // If plugins are disabled, do not run
        if ($container['plugins_enabled'] === false) {
            return false;
        }

        // Send app reference to hooks
        $args = array_merge($args, array($this->container));

        // Run hooks associated with that event
        foreach ($container['plugins'] as $plugin_id => $plugin) {
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
        if ($this->container['plugins_enabled'] === true) {
            $plugin_loader = $this->container['plugin_loader'];

            // Load plugins from 'plugins' folder
            try {
                $this->container['plugins'] = $plugin_loader->load_dir();
            }
            catch (\Exception $e) {
                $this->container['router']->error($e);
            }
        }
        $this->run_hooks('after_plugins_load');
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
        $container = $this->container;
        $router    = $container['router'];
        $nav       = $container['nav'];

        $file_list = $container['content_loader']->get_folder_contents();

        // Add each as a route
        foreach ($file_list as $file) {

            // Get filename without extension
            $exploded_file_name = explode('.', $file);
            $file_name          = $exploded_file_name[0];

            $route = preg_match('/index$/', $file_name) === 1
                ? '/' . str_replace('index', '', $file_name)
                : '/' . $file_name;

            $router->get($route, function() use ($container, $file) {

                // Load content now
                $content_array = $container['content_loader']->load($file);
                $content       = $content_array[$file];

                // Set Twig options
                $twig_vars = array(
                    'config'     => $container['settings'],
                    'base_url'   => $container['settings']['site']['site_root'],
                    'site_title' => $container['settings']['site']['site_title']
                );

                // Merge Twig options and content into one array
                $options = array_merge($twig_vars, $content, $container['nav']);

                // Get template name from file, if not set, then use default
                $template_name = array_key_exists('template', $content['meta']) === true
                    ? $content['meta']['template']
                    : $container['settings']['zepto']['default_template'];

                // Render template with Twig
                return $container['twig']->render($template_name, $options);
            });
        }
    }

    /**
     * Helper function to create navigation links
     *
     * @return
     */
    protected function create_nav_links()
    {
        $container    = $this->container;
        // $content      = $container['content'];

        // Calls protected function which returns formatted array
        // $nav_html    = $this->generate_nav_html();

        // Add to ``$container``
        // $this->container['nav'] = array('nav' => $nav_html);
        $this->container['nav'] = array();
    }

    protected function generate_nav_html()
    {
        $container       = $this->container;
        $settings        = $container['settings'];
        $content_loader  = $container['content_loader'];

        // Opening ``<ul>`` tag and adding class name
        $nav_html     = sprintf('<ul class="%s">' . PHP_EOL, $settings['site']['nav']['class']);

        // Could add a hook here maybe?
        $structure    = $content_loader->get_directory_map($settings['zepto']['content_dir']);

        // Remove 'index' along with any file extensions from URL
        $filth = array_merge(array('index'), $settings['zepto']['content_ext']);

        foreach ($structure as $key => $value) {

            // Check if ``$value`` is an array
            if (is_array($value)) {

                // Generate HTML for dropdown menu
                $dropdown_html = '<li class="%s">' . PHP_EOL
                   . '<a href="%s" class="dropdown-toggle" data-toggle="dropdown"> %s <b class="caret"></b></a>' . PHP_EOL
                   . '<ul class="%s">' . PHP_EOL;
                $nav_html .= sprintf($dropdown_html,
                    $settings['site']['nav']['dropdown_li_class'],
                    reset($value), // Reset to get first value from array
                    ucfirst($key), // Capitalise first letter of folder name
                    $settings['site']['nav']['dropdown_ul_class']
                );

                foreach ($value as $file_name) {

                    // Add folder name to file name
                    $full_file_name = $key . '/' . $file_name;

                    // Get title of content file
                    $title = $container['content'][$full_file_name]['meta']['title'];

                    // Create URL
                    $url = $settings['site']['site_root'] . str_replace($filth, '', $key . '/' . $file_name);

                    // Run ``ucfirst()`` on ``$key`` to make it look nice
                    $nav_html  .= sprintf('<li><a href="%s"> %s </a></li>' . PHP_EOL, $url, $title);
                }

                // Close dropdown menu HTML tags
                $nav_html .= '</ul></li>' . PHP_EOL;
            }
            // If not then add to ``$nav_items``
            else {
                if (preg_match('#^[4|5]0\d\.md$#i', $value) === 0) {

                    // Get title of content file
                    $title = $container['content'][$value]['meta']['title'];

                    // Create URL
                    $url = $settings['site']['site_root'] . str_replace($filth, '', $value);
                    $url = rtrim($url, '/') . '/';

                    $nav_html .= sprintf('<li><a href="%s"> %s </a></li>' . PHP_EOL, $url, $title);
                }
            }
        }

        // Close ``<ul>`` tag
        $nav_html .= '</ul>' . PHP_EOL;
        return $nav_html;
    }

    /**
     * Retrieves current instance, if one exists, otherwise returns null
     *
     * @return \Zepto\Zepto|null
     */
    public static function instance()
    {
        if (isset(static::$instance) === FALSE) {
            return null;
        }

        return static::$instance;
    }

    /**
     * Returns a standard configuration for Zepto
     *
     * @return array
     */
    public static function default_config()
    {
        return array(
            'zepto' => array(
                'environment'       => 'dev',
                'content_dir'       => 'content',
                'plugins_dir'       => 'plugins',
                'templates_dir'     => 'templates',
                'default_template'  => 'base.twig',
                'content_ext'       => array('.md', '.markdown'),
                'plugins_enabled'   => true
            ),
            'site' => array(
                'site_root'         => 'http://localhost:8888/zepto/',
                'site_title'        => 'Zepto',
                'date_format'       => 'jS M Y',
                'excerpt_length'    => '50',
                'nav'               => array(
                    'class'             => 'nav',
                    'dropdown_li_class' => 'dropdown',
                    'dropdown_ul_class' => 'dropdown-menu'
                )
            ),
            'twig' => array(
                'charset'           => 'utf-8',
                'cache'             => 'cache',
                'strict_variables'  => false,
                'autoescape'        => false,
                'auto_reload'       => true
            )
        );
    }

    /**
     * Validates a configuration array
     *
     * @param  array   $config
     * @return boolean
     */
    public static function validate_config($config)
    {
        $message = '';

        while ($message === '') {
            if (!is_dir($config['zepto']['content_dir'])) {
                $message = 'Content directory does not exist';
                break;
            }

            if (!is_dir($config['zepto']['plugins_dir'])) {
                $message = 'Plugins directory does not exist';
                break;
            }

            if (!is_dir($config['zepto']['templates_dir'])) {
                $message = 'Templates directory does not exist';
                break;
            }

            if (
                !is_file("{$config['zepto']['templates_dir']}/{$config['zepto']['default_template']}")
            ) {
                $message = 'No default template exists';
            break;
            }

            if ($config['zepto']['environment'] === 'dev') {
                preg_match('#^(https?://)?(localhost)(\.[a-z\.]{2,6})?(\:[0-9]{1,5})?([/\w \.-]*)*/+$#', $config['site']['site_root']) === 0
                    ? $message = "Something's up with your site root, man"
                    : $message = '';
            }
            else {
                preg_match('#^(https?://)?([\da-z\.-]+)\.([a-z\.]{2,6})([/\w \.-]*)*/+$#', $config['site']['site_root']) === 0
                    ? $message = 'Site root is invalid. Should be like http://www.example.com/'
                    : $message = '';
            }
            break;
        }

        if ($message === '') {
            return TRUE;
        }
        else {
            throw new \InvalidArgumentException($message);
        }

    }

}
