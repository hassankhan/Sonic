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

    const VERSION = '0.4';

    public $container;

    /**
     * Zepto constructor
     *
     * <code>
     * $config = array(
     *     'zepto' => array(
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
     *         'excerpt_length'    => '50'
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
     * @param array $settings An array of options - see above
     */
    public function __construct(array $settings = array())
    {
        $this->container = new Pimple();

        // Get local reference to container
        $container                  = $this->container;

        // Create application hooks
        $container['hooks']         = array(
            'after_config_load'   => array(),
            'after_plugins_load'  => array(),
            'request_url'         => array(),
            'before_file_load'    => array(),
            'after_file_load'     => array()
        );

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

        $container['plugin_loader'] = $container->share(
            function ($container) {
                return new FileLoader\PluginLoader();
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


        // Set application settings
        $container['settings'] = $settings;

        // Load plugins
        $this->load_plugins();

        // Load content from files
        $this->load_content();

        // Create navigation object
        $this->create_nav_links();

        // Add basic routes to router
        $this->setup_router();
    }

    /**
     * Executes router and returns result of callback function for specified route
     *
     * @return mixed
     */
    public function run()
    {
        $router = $this->container['router'];
        return $router->execute();
    }

    /**
     * Runs all hooks registered to the specified hook name
     *
     * @param  string  $hook
     * @return boolean Returns true on successful execution of all hooks, false if plugins are disabled
     */
    public function run_hooks($hook_id, $args = array())
    {
        $container = $this->container;
        $settings  = $container['settings']['zepto'];
        $hooks     = $container['hooks'];

        // If plugins are disabled, do not run
        if ($settings['plugins_enabled'] === false) {
            return false;
        }

        $plugins   = $container['plugins'];

        // Check if event name exists
        if (array_key_exists($hook_id, $hooks) === false) {
            throw new \Exception('No such hook exists');
        }

        // Send app reference to hooks
        $args = array_merge($args, array($this));

        // Run hooks associated with that event
        foreach ($plugins as $plugin_id => $plugin) {
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
        $container     = $this->container;
        $settings      = $container['settings']['zepto'];

        if ($settings['plugins_enabled'] === true) {
            $plugin_loader = $container['plugin_loader'];

            // Load plugins from 'plugins' folder
            $container['plugins'] = $plugin_loader->load(
                $settings['plugins_dir'],
                array('.php')
            );
        }
        $this->run_hooks('after_plugins_load');
    }

    /**
     * Loads files from the ``content`` folder
     *
     * @return
     */
    protected function load_content()
    {
        // Get local reference to file loader
        $container   = $this->container;
        $file_loader = $container['file_loader'];
        $settings    = $container['settings']['zepto'];

        $content_dir = $settings['content_dir'];
        $this->run_hooks('before_file_load', array(&$content_dir));

        $content = $file_loader->load(
            $content_dir,
            $settings['content_ext']
        );

        // Could add a hook here maybe?
        $container['folder_structure'] = $file_loader->get_directory_map($content_dir);

        $this->run_hooks('after_file_load', array(&$content));
        $container['content'] = $content;
    }

    /**
     * Does the initial setup for the router. This entails getting the list of
     * loaded files as returned by Zepto\FileLoader and turning that into
     * routes.
     *
     * @return void
     */
    protected function setup_router()
    {
        // Get local references
        $container = $this->container;
        $router    = $container['router'];
        $nav       = $container['nav'];

        // Get loaded files array keys
        $files  = array_keys($container['content']);

        // Remove 'content' and file extensions from path
        $clean_files = str_replace(
            $container['settings']['zepto']['content_ext'],
            '',
            $files
        );

        // Add each as a route
        foreach ($clean_files as $file) {

            $route = preg_match('/index$/', $file) === 1
                ? '/' . str_replace('index', '', $file)
                : '/' . $file;

            $router->route($route, function() use ($container, $file, $nav) {

                // Get local references to Twig and content
                $twig    = $container['twig'];
                $content = $container['content'][$file . '.md'];

                // Set Twig options
                $twig_options = array(
                    'config'     => $container['settings'],
                    'base_url'   => $container['settings']['site']['site_root'],
                    'site_title' => $container['settings']['site']['site_title']
                );

                // Merge Twig options and content into one array
                $options = array_merge($twig_options, $content, $nav);

                // Get template name from file, if not set, then use default
                $template_name = array_key_exists('template', $content['meta']) === true
                    ? $content['meta']['template']
                    : $container['settings']['zepto']['default_template'];

                if ($file === '404') {
                    header("HTTP/1.0 404 Not Found");
                }

                // Render template with Twig
                echo $twig->render($template_name, $options);
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
        $content      = $container['content'];

        // Calls protected function which returns formatted array
        $nav_html    = $this->generate_nav_html();

        // Add to ``$container``
        $this->container['nav'] = array('nav' => $nav_html);
    }

    protected function generate_nav_html()
    {

        $container    = $this->container;
        $settings     = $container['settings'];
        $file_loader  = $container['file_loader'];

        $nav_html     = '';
        // Could add a hook here maybe?
        $structure    = $file_loader->get_directory_map($settings['zepto']['content_dir']);

        // Remove 'index' along with any file extensions from URL
        $filth = array_merge(array('index'), $settings['zepto']['content_ext']);

        foreach ($structure as $key => $value) {

            // Check if ``$value`` is an array
            if (is_array($value)) {

                $dropdown_html = '<li class="dropdown">' . PHP_EOL
                   . '<a href="%s" class="dropdown-toggle" data-toggle="dropdown"> %s <b class="caret"></b></a>' . PHP_EOL
                   . '<ul class="dropdown-menu">' . PHP_EOL;
                $nav_html .= sprintf($dropdown_html, reset($value), ucfirst($key));

                foreach ($value as $file_name) {

                    // Add folder name to file name
                    $full_file_name = $key . '/' . $file_name;

                    // Get title of content file
                    $title = $container['content'][$full_file_name]['meta']['title'];

                    // Create URL
                    $url = $settings['site']['site_root'] . '/' . str_replace($filth, '', $key . '/' . $file_name);

                    // Run ``ucfirst()`` on ``$key`` to make it look nice
                    $nav_html  .= sprintf('<li><a href="%s"> %s </a></li>' . PHP_EOL, $url, $title);
                }

                $nav_html .= '</ul></li>' . PHP_EOL;
            }
            // If not then add to ``$nav_items``
            else {
                if (preg_match('#^[4|5]0\d\.md$#i', $value) === 0) {

                    // Get title of content file
                    $title = $container['content'][$value]['meta']['title'];

                    // Create URL
                    $url = $settings['site']['site_root'] . '/' . str_replace($filth, '', $value);

                    $nav_html .= sprintf('<li><a href="%s"> %s </a></li>' . PHP_EOL, $url, $title);
                }
            }
        }

        return $nav_html;
    }

    // This should be moved into a plugin
    private function _configure_error_handler()
    {
        // Get local reference to error handler
        $error_handler = $this->container['error_handler'];

        // Configure the PrettyPageHandler:
        $errorPage     = new Whoops\Handler\PrettyPageHandler();

        $errorPage->setPageTitle('Shit hit the fan!');
        $errorPage->setEditor('sublime');
        $error_handler->pushHandler($errorPage);
        $error_handler->register();
    }

}
