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
class ListRoute extends \Zepto\Route\ListRouteAbstract
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

    public function posts()
    {
        // Get dates from all content
        $dates = $this->zepto->app['filesystem']->dates('content');

        return $this->excerpts(array_keys($dates));
    }

}
