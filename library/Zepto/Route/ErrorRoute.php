<?php

namespace Zepto\Route;

/**
 * ErrorRoute
 *
 * This route is executed on any application error.
 *
 * @package    Zepto
 * @subpackage Route
 * @author     Hassan Khan <contact@hassankhan.me>
 * @link       https://github.com/hassankhan/Zepto
 * @license    MIT
 * @since      0.7
 */
class ErrorRoute extends \Zepto\Route
{

    /**
     * Initializes the route by creating a regex pattern from the provided URL,
     * and assigns the callable function for this route
     *
     * @param string $url
     * @codeCoverageIgnore
     */
    public function __construct($url = '', $title, $body)
    {
        $callback = function() use ($title, $body) {
            return sprintf('<html><head><title>%s</title><style>body{margin:0;padding:30px;font:12px/1.5 Helvetica,Arial,Verdana,sans-serif;}h1{margin:0;font-size:48px;font-weight:normal;line-height:48px;}strong{display:inline-block;width:65px;}</style></head><body><h1>%s</h1><p>%s</p></body></html>', $title, $title, $body);
        };
        parent::__construct($url, $callback);
    }

}
