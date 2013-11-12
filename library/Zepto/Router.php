<?php

/**
 * Router
 *
 * This is the Zepto URL Router, the layer of a web application between the
 * URL and the function executed to perform a request. The router determines
 * which function to execute for a given URL.
 *
 * @package    Zepto
 * @subpackage Router
 * @author     Brandon Wamboldt <brandon.wamboldt@gmail.com>
 * @author     Hassan Khan <contact@hassankhan.me>
 * @license    MIT
 */

/**
 * Zepto Router Class
 *
 * This is the Zepto URL Router, the layer of a web application between the
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

class Router
{
    /**
     * Contains the callback function to execute, retrieved during run()
     *
     * @var string|array
     */
    protected $callback = null;

    /**
     * Contains the callback function to execute if none of the given routes can
     * be matched to the current URL.
     *
     * @var Callable
     */
    protected $error_404 = null;

    /**
     * Contains the last route executed, used when chaining methods calls in
     * the route() function (Such as for put(), post(), and delete()).
     *
     * @var pointer
     */
    protected $last_route = null;

    /**
     * An array containing the parameters to pass to the callback function,
     * retrieved during run()
     *
     * @var array
     */
    protected $params = array();

    /**
     * An array containing the list of routing rules and their callback
     * functions, as well as their request method and any additional paramters.
     *
     * @var array
     */
    protected $routes = array();

    /**
     * An array containing the list of routing rules before they are parsed
     * into their regex equivalents, used for debugging and test cases
     *
     * @var array
     */
    protected $routes_original = array();

    /**
     * Whether or not to display errors for things like malformed routes or
     * conflicting routes.
     *
     * @var boolean
     */
    protected $show_errors = true;

    /**
     * A sanitized version of the URL, excluding the domain and base component
     *
     * @var string
     */
    protected $url_clean = '';

    /**
     * The dirty URL, direct from $_SERVER['REQUEST_URI']
     *
     * @var string
     */
    protected $url_dirty = '';

    /**
     * Initializes the router by getting the URL and cleaning it.
     *
     * @param string $url
     * @codeCoverageIgnore
     */
    public function __construct($url = null)
    {
        if ($url == null) {
            // Get the current URL, differents depending on platform/server software
            if (!empty($_SERVER['REQUEST_URL'])) {
                $url = $_SERVER['REQUEST_URL'];
            } else {
                $url = $_SERVER['REQUEST_URI'];
            }
        }

        // Store the dirty version of the URL
        $this->url_dirty = $url;

        // Clean the URL, removing the protocol, domain, and base directory if there is one
        $this->url_clean = $this->__get_clean_url($this->url_dirty);
    }

    /**
     * Tries to match one of the URL routes to the current URL, otherwise
     * execute the default function and return false.
     *
     * @return boolean
     */
    public function run()
    {
        // Whether or not we have matched the URL to a route
        $matched_route = false;

        // Sort the array by request_method
        ksort($this->routes);

        // Loop through each request_method level
        foreach ($this->routes as $request_method => $routes) {
            if ($_SERVER['REQUEST_METHOD'] === $request_method) {
                // Loop through each route for this request_method level
                foreach ($routes as $route => $callback) {
                    // Does the routing rule match the current URL?
                    if (preg_match($route, $this->url_clean, $matches)) {
                        // A routing rule was matched
                        $matched_route = true;

                        // Parameters to pass to the callback function
                        $params = array($this->url_clean);

                        // Get any named parameters from the route
                        foreach ($matches as $key => $match) {
                            if (is_string($key)) {
                                $params[] = $match;
                            }
                        }

                        // Store the parameters and callback function to execute later
                        $this->params   = $params;
                        $this->callback = $callback;

                        // Return the callback and params, useful for unit testing
                        return array('callback' => $callback, 'params' => $params, 'route' => $route, 'original_route' => $this->routes_original[$request_method][$route]);
                    }
                }
            }
        }

        // Was a match found or should we execute the default callback?
        if (!$matched_route && $this->error_404 !== null) {
            // call_user_func($this->error_404);
            return array('params' => $this->url_clean, 'callback' => $this->error_404, 'route' => false, 'original_route' => false);
        }
    }

    /**
     * Calls the appropriate callback function and passes the given parameters
     * given by Router::run()
     *
     * @return boolean     Returns true on a successful match, otherwise false
     */
    public function dispatch()
    {
        if ($this->callback == null || $this->params == null) {
            call_user_func($this->error_404);
            return false;
        }

        call_user_func_array($this->callback, $this->params);
        return true;
    }

    /**
     * Runs the router matching engine and then calls the dispatcher
     *
     * @uses Router::run()
     * @uses Router::dispatch()
     */
    public function execute()
    {
        $this->error_404 = $this->routes['GET']['#^/404/$#'];
        $this->run();
        $this->dispatch();
    }

    /**
     * Convenience method for HTTP GET routes
     *
     * @param  string $route
     * @param  Callable $callback
     * @return boolean
     */
    public function get($route, $callback)
    {
        return $this->route($route, $callback, 'GET');
    }

    /**
     * Convenience method for HTTP POST routes
     *
     * @param  string $route
     * @param  Callable $callback
     * @return boolean
     */
    public function post($route, $callback)
    {
        return $this->route($route, $callback, 'POST');
    }

    /**
     * Adds a new URL routing rule to the routing table, after converting any of
     * our special tokens into proper regular expressions.
     *
     * @param  string   $route
     * @param  Callable $callback
     * @param  integer  $request_method
     * @return boolean
     */
    public function route($route, $callback, $request_method = 'GET')
    {
        // Keep the original routing rule for debugging/unit tests
        $original_route = $route;

        // Make sure the route ends in a / since all of the URLs will
        $route = rtrim($route, '/') . '/';

        // Custom capture, format: <:var_name|regex>
        $route = preg_replace('/\<\:(.*?)\|(.*?)\>/', '(?P<\1>\2)', $route);

        // Alphanumeric capture (0-9A-Za-z-_), format: <:var_name>
        $route = preg_replace('/\<\:(.*?)\>/', '(?P<\1>[A-Za-z0-9\-\_]+)', $route);

        // Numeric capture (0-9), format: <#var_name>
        $route = preg_replace('/\<\#(.*?)\>/', '(?P<\1>[0-9]+)', $route);

        // Wildcard capture (Anything INCLUDING directory separators), format: <*var_name>
        $route = preg_replace('/\<\*(.*?)\>/', '(?P<\1>.+)', $route);

        // Wildcard capture (Anything EXCLUDING directory separators), format: <!var_name>
        $route = preg_replace('/\<\!(.*?)\>/', '(?P<\1>[^\/]+)', $route);

        // Add the regular expression syntax to make sure we do a full match or no match
        $route = '#^' . $route . '$#';

        // Does this URL routing rule already exist in the routing table?
        if (isset($this->routes[$request_method][$route])) {
            // Trigger a new error and exception if errors are on
            throw new \Exception('The URI "' . htmlspecialchars($route) . '" already exists in the routing table');
        }

        // Add the route to our routing array
        $this->routes[$request_method][$route]          = $callback;
        $this->routes_original[$request_method][$route] = $original_route;

        return true;
    }

    /**
     * Returns all routes mapped on the routing table.
     *
     * @return array
     * @todo   Fix this shitty implementation and make it return one
     *         single array with all routes
     */
    public function get_routes()
    {
        return $this->routes;
    }

    /**
     * Retrieves the part of the URL after the base (Calculated from the location
     * of the main application file, such as index.php), excluding the query
     * string. Adds a trailing slash.
     *
     * <code>
     * http://localhost/projects/test/users///view/1 would return the following,
     * assuming that /test/ was the base directory
     *
     * /users/view/1/
     * </code>
     *
     * @param  string $url
     * @return string
     * @codeCoverageIgnore
     */
    protected function __get_clean_url($url)
    {
        // The request url might be /project/index.php, this will remove the /project part
        $url = str_replace(dirname($_SERVER['SCRIPT_NAME']), '', $url);

        // Remove the query string if there is one
        $query_string = strpos($url, '?');

        if ($query_string !== false) {
            $url = substr($url, 0, $query_string);
        }

        // If the URL looks like http://localhost/index.php/path/to/folder remove /index.php
        if (substr($url, 1, strlen(basename($_SERVER['SCRIPT_NAME']))) == basename($_SERVER['SCRIPT_NAME'])) {
            $url = substr($url, strlen(basename($_SERVER['SCRIPT_NAME'])) + 1);
        }

        // Make sure the URI ends in a /
        $url = rtrim($url, '/') . '/';

        // Replace multiple slashes in a url, such as /my//dir/url
        $url = preg_replace('/\/+/', '/', $url);

        return $url;
    }
}
