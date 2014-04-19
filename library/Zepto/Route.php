<?php

namespace Zepto;

/**
 * Route
 *
 * This is the Sonic URL Route, which contains the logic to respond to a request.
 * The router determines if the matched URL is for this route and executes its callback.
 *
 * @package    Sonic
 * @author     Hassan Khan <contact@hassankhan.me>
 * @link       https://github.com/hassankhan/Sonic
 * @license    MIT
 * @since      0.6
 */
class Route
{

    /**
     * The raw route URL as specified when creating the route
     *
     * @var string
     */
    protected $url;

    /**
     * The route URL regex pattern, including any parameters,
     * like "/post/<:id|[0-9]>")
     *
     * @var string
     */
    protected $pattern;

    /**
     * Contains the callable function to execute, retrieved on ``Zepto\Router::run()``
     *
     * @var array|\Closure
     */
    protected $callback = null;

    /**
     * The HTTP response status code for this route
     *
     * @var int
     */
    protected $status_code;

    /**
     * Initializes the route by creating a regex pattern from the provided URL,
     * and assigns the callable function for this route
     *
     * @param  string                $pattern
     * @param  array|\Closure|string $callback
     * @codeCoverageIgnore
     */
    public function __construct($pattern, $callback)
    {
        if (is_callable($callback) === FALSE && is_array($callback) === FALSE) {
            throw new \Exception('Callback is not a valid callable function');
        }

        // Keep the original route pattern
        $url     = $pattern;

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
        // $this->status   = $status;
    }

    /**
     * Executes a route's callback and returns the result. Simple as that.
     *
     * @param  array  $params
     * @return string
     */
    public function execute($params = array())
    {
        return call_user_func_array($this->callback, $params);
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
     * @return array|\Closure|string
     */
    public function callback()
    {
        return $this->callback;
    }

}
