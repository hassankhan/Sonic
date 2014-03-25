<?php

namespace Zepto\Route;

/**
 * TagRoute
 *
 * This route is executed when a ``/tag | /tags`` URL is matched
 *
 * @package    Zepto
 * @subpackage Route
 * @author     Hassan Khan <contact@hassankhan.me>
 * @link       https://github.com/hassankhan/Zepto
 * @license    MIT
 * @since      0.7
 */
class TagRoute extends \Zepto\Route implements \Zepto\RouteInterface
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
        // Get reference to Zepto
        $zepto = \Zepto\Zepto::instance();

        // Get parameters from URL
        list($tag_name) = func_get_args();
        // Load file
        $tagged_files   = $zepto->app['tags'][$tag_name];
        // Create array to hold posts
        $posts          = array();

        // Iterate through files and get excerpts for all of them
        foreach ($tagged_files as $file) {
            $file_contents = $zepto->app['filesystem']->parse($file);

            if ($file_contents['meta']['title'] !== 'Quote') {
                $file_contents['contents'] = $zepto->app['helper']->get_excerpt($file_contents['contents']);
            }
            $posts[str_replace('content/', '', $file)] = $file_contents;
        }

        // Load in any extra stuffs
        $zepto->app['extra'] = isset($zepto->app['extra']) === TRUE ? $zepto->app['extra'] : array();

        // Merge Twig options and content into one array
        $options             = array_merge($posts, $zepto->app['extra']);

        // Render template with Twig
        return $zepto->app['twig']->render('post-list.twig', array('contents' => $posts));
    }

}
