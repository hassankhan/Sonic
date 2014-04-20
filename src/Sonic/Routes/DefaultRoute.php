<?php

namespace Sonic\Routes;

/**
 * DefaultRoute
 *
 * The default route to execute for Sonic content
 *
 * @package    Sonic
 * @subpackage Route
 * @author     Hassan Khan <contact@hassankhan.me>
 * @link       https://github.com/hassankhan/Sonic
 * @license    MIT
 * @since      0.7
 */
class DefaultRoute extends \Sonic\Routing\Route
{

    /**
     * Initializes the route by creating a regex pattern from the provided URL,
     * and assigns the callable function for this route
     *
     * @param string $url
     * @codeCoverageIgnore
     */
    public function __construct($url = '')
    {
        parent::__construct($url, array($this, 'build_route'));
    }

    /**
     * Builds and returns the rendered HTML
     *
     * @return string
     */
    public function build_route()
    {
        // Get reference to Sonic
        $sonic = \Sonic\Sonic::instance();

        // Get resource URL
        $resource_url = $sonic->app['router']->request()->getPathInfo();

        // Get file path
        $path = rtrim($sonic->app['settings']['sonic.content_dir'] . $resource_url, '/');

        // Check if file(s) exist
        $contents = $sonic->app['filesystem']->listContents($path);

        // Load file
        $loaded_file = empty($contents) === TRUE
            ? $sonic->app['filesystem']->parse($path . '.md')
            : $sonic->app['filesystem']->parse(rtrim($path, '/') . '/' . 'index.md');

        // Load in any extra stuffs
        $sonic->app['extra'] = isset($sonic->app['extra']) === TRUE ? $sonic->app['extra'] : array();

        // Merge Twig options and content into one array
        $options = array_merge($loaded_file, $sonic->app['extra']);

        // Get template name from file, if not set, then use default
        $template_name = array_key_exists('template', $loaded_file['meta']) === true
            ? $loaded_file['meta']['template']
            : $sonic->app['settings']['sonic.default_template'];

        // Render template with Twig
        try {
            return $sonic->app['twig']->render($template_name, $options);
        }
        catch (\Exception $e) {
            return $sonic->app['router']->error($e);
        }
    }

}
