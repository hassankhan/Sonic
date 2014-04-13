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
class TagRoute extends \Zepto\Route\ListRoute
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
     * Method required by abstract class. Returns an array of posts
     * that match whatever requirements for this route.
     *
     * @return array
     */
    public function posts()
    {
        // Get tag name
        $params = func_get_args();
        $tag_name = $params[0];

        // Get tagged files
        $tags           = $this->zepto->app['filesystem']->tags('content');
        $tagged_files   = $tags[$tag_name];

        return $this->excerpts($tagged_files);
    }

}
