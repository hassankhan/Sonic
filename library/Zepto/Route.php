<?php

/**
 * Route
 *
 * This is the Zepto URL Route, which contains the logic to respond to a request.
 * The router determines if the matched URL is for this route and executes its callback.
 *
 * @package    Zepto
 * @subpackage Route
 * @author     Hassan Khan <contact@hassankhan.me>
 * @license    MIT
 */

/**
 * Zepto Route Class
 *
 * This is the Zepto URL Route, which contains the logic to respond to a request.
 * The router determines if the matched URL is for this route and executes its callback.
 *
 * @since 0.6
 */

namespace Zepto;

class Route
{

    /**
     * The raw route URL as specified when creating the route
     * @var string
     */
    protected $url;

    /**
     * The route URL regex pattern, including any parameters,
     * like "/post/<:id|[0-9]>")
     * @var string
     */
    protected $pattern;

    /**
     * Contains the callback function to execute, retrieved on ``Zepto\Router::run()``
     *
     * @var Closure
     */
    protected $callback = null;

    /**
     * Initializes the route by creating a regex pattern from the provided URL,
     * and assigns the callable function for this route
     *
     * @param string $url
     * @codeCoverageIgnore
     */
    public function __construct($pattern, \Closure $callback)
    {
        // Keep the original route pattern
        $url = $pattern;

        // Make sure the route ends in a / since all of the URLs will
        $pattern = rtrim($pattern, '/') . '/';

        // Custom capture, format: <:var_name|regex>
        $pattern = preg_replace('#\<\:(.*?)\|(.*?)\>#', '(?P<\1>\2)', $pattern);

        // Alphanumeric capture (0-9A-Za-z-_), format: <:var_name>
        $pattern = preg_replace('#\<\:(.*?)\>#', '(?P<\1>[A-Za-z0-9\-\_]+)', $pattern);

        // Numeric capture (0-9), format: <#var_name>
        $pattern = preg_replace('#\<\#(.*?)\>#', '(?P<\1>[0-9]+)', $pattern);

        // Wildcard capture (Anything INCLUDING directory separators), format: <*var_name>
        $pattern = preg_replace('#\<\*(.*?)\>#', '(?P<\1>.+)', $pattern);

        // Wildcard capture (Anything EXCLUDING directory separators), format: <!var_name>
        $pattern = preg_replace('#\<\!(.*?)\>#', '(?P<\1>[^\/]+)', $pattern);

        // Add the regular expression syntax to make sure we do a full match or no match
        $pattern = '#^' . $pattern . '$#';

        $this->url      = $url;
        $this->pattern  = $pattern;
        $this->callback = $callback;
    }

    /**
     * ACCESSORS
     */

    /**
     * Returns this route's raw URL as specified in the constructor
     *
     * @return string
     */
    public function url()
    {
        return $this->url;
    }

    /**
     * Returns the route's pattern
     *
     * @return string
     */
    public function pattern()
    {
        return $this->pattern;
    }

    /**
     * Returns the callable function to be invoked for this route
     *
     * @return Closure
     */
    public function callback()
    {
        return $this->callback;
    }

}
