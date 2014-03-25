<?php

namespace Zepto\Route;

/**
 * ListRoute
 *
 * This route displays a list of posts
 *
 * @package    Zepto
 * @subpackage Route
 * @author     Hassan Khan <contact@hassankhan.me>
 * @link       https://github.com/hassankhan/hassankhan-me
 * @license    MIT
 * @since      0.7
 */
class ListRoute extends \Zepto\Route implements \Zepto\RouteInterface
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

        // Get dates from all content
        $dates = $zepto->app['filesystem']->dates('content');
        // Get filenames of content
        $files = array_keys($dates);
        // Create array to hold posts
        $posts = array();

        // Iterate through files and get excerpts for all of them
        foreach ($files as $file) {
            $file_contents = $zepto->app['filesystem']->parse($file);

            if ($file_contents['meta']['title'] !== 'Quote') {
                $file_contents['contents'] = $zepto->app['helper']->get_excerpt($file_contents['contents']);
            }
            $posts[str_replace('content/', '', $file)] = $file_contents;
        }

        // Render template with Twig
        return $zepto->app['twig']->render('post-list.twig', array('contents' => $posts));
    }

}
