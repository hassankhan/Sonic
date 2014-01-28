<?php

/**
 * Route
 *
 * This is the Zepto URL Route, the layer of a web application between the
 * URL and the function executed to perform a request. The router determines
 * which function to execute for a given URL.
 *
 * @package    Zepto
 * @subpackage Route
 * @author     Hassan Khan <contact@hassankhan.me>
 * @license    MIT
 */

/**
 * Zepto Route Class
 *
 * This is the Zepto URL Route, the layer of a web application between the
 * URL and the function executed to perform a request. The router determines
 * which function to execute for a given URL.
 *
 * <code>
 * $router = new Zepto\Router;
 *
 * // Adding a basic route
 * $router->route( '/login', 'login_function' );
 *
 * // Adding a route with a named alphanumeric capture, using the <:var_name> syntax
 * $router->route( '/user/view/<:username>', 'view_username' );
 *
 * // Adding a route with a named numeric capture, using the <#var_name> syntax
 * $router->route( '/user/view/<#user_id>', array( 'UserClass', 'view_user' ) );
 *
 * // Adding a route with a wildcard capture (Including directory separtors), using
 * // the <*var_name> syntax
 * $router->route( '/browse/<*categories>', 'category_browse' );
 *
 * // Adding a wildcard capture (Excludes directory separators), using the
 * // <!var_name> syntax
 * $router->route( '/browse/<!category>', 'browse_category' );
 *
 * // Adding a custom regex capture using the <:var_name|regex> syntax
 * $router->route( '/lookup/zipcode/<:zipcode|[0-9]{5}>', 'zipcode_func' );
 *
 * // Specifying priorities
 * $router->route( '/users/all', 'view_users', 1 ); // Executes first
 * $router->route( '/users/<:status>', 'view_users_by_status', 100 ); // Executes after
 *
 * // Specifying a default callback function if no other route is matched
 * $router->error_404( 'page_404' );
 *
 * // Run the router
 * $router->execute();
 * </code>
 *
 * @since 2.0.0
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
     * An array containing the parameters to pass to the callback function, as
     * parsed from $pattern
     *
     * @var array
     */
    protected $params = array();

    /**
     * Initializes the route by creating a regex pattern from the provided URL,
     * and assigns the callable function for this route
     *
     * @param string $url
     * @codeCoverageIgnore
     */
    public function __construct($pattern, $callback)
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

    public function get_url()
    {
        return $this->url;
    }

    public function get_pattern()
    {
        return $this->pattern;
    }

    public function get_callback()
    {
        return $this->callback;
    }

}
