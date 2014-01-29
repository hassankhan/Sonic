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
     * Request object
     *
     * @var Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * Currently matched route, if one has been set
     *
     * @var Zepto\Route
     */
    protected $current_route;

    /**
     * An array containing the list of routing rules and their callback
     * functions, as well as their request method and any additional paramters.
     *
     * @var array
     */
    protected $routes = array();

    /**
     * Callback function to execute when no matching URL is found
     *
     * @var Closure
     */
    protected $not_found_handler;

    /**
     * Callback function to execute on any other error
     *
     * @var Closure
     */
    protected $error_handler;

    /**
     * Initializes the router by getting the URL and cleaning it.
     *
     * @param string $url
     * @codeCoverageIgnore
     */
    public function __construct(\Symfony\Component\HttpFoundation\Request $request)
    {
        $this->request = $request;
    }

    /**
     * Add HTTP GET routes
     *
     * @see    Zepto\Router::route()
     * @param  string  $route
     * @param  Closure $callback
     * @return boolean
     */
    public function get($route, \Closure $callback)
    {
        $this->route(new Route($route, $callback));
        // return $this->route($route, $callback, 'GET');
    }

    /**
     * Add HTTP POST routes
     *
     * @see    Zepto\Router::route()
     * @param  string  $route
     * @param  Closure $callback
     * @return boolean
     */
    public function post($route, \Closure $callback)
    {
        $this->route(new Route($route, $callback), 'POST');
    }

    /**
     * Returns a Route object if matching URL is found
     *
     * @param  string $http_method
     * @param  string $url
     * @return Zepto\Route|null
     */
    public function match($http_method = 'GET', $url)
    {
        // Make sure there is a trailing slash
        $url = rtrim($url, '/') . '/';

        foreach ($this->routes[$http_method] as $route) {
            if (preg_match($route->get_pattern(), $url)) {
                return $route;
            }
        }
        return null;
    }

    /**
     * Tries to match one of the URL routes to the current URL, otherwise
     * execute the default function and return false.
     *
     * @return array
     */
    public function run()
    {
        // If no routes have been added, then throw an exception
        if (empty($this->routes)) {
            throw new \Exception('No routes exist in the routing table. Add some');
        }

        $route = $this->match($this->request->getMethod(), $this->request->getPathInfo());

        // Call not found handler if no match was found
        if ($route === null) {
            $this->not_found();
        }
        else {
            $this->current_route = $route;
            $params = array();
            call_user_func_array($route->get_callback(), $params);
        }
    }

    /**
     * Runs the router matching engine and then calls the matching route's callback.
     * If no matching route is found, then returns false
     *
     * @uses Router::run()
     * @return mixed
     */
    public function execute()
    {
        try{
            $this->run();
        }
        catch (Exception $e) {
            echo $e->getMessage();
            // Add logging stuff here - maybe?
            // Maybe make it do a HTTP 500 error?
        }
    }

    /**
     * Returns all routes mapped on the routing table.
     *
     * @return array[Zepto\Route]
     */
    public function get_routes()
    {
        return $this->routes;
    }

    /**
     * Returns the currently matched route.
     *
     * @return Zepto\Route
     */
    public function get_current_route()
    {
        return $this->current_route;
    }

    public function not_found($callback = null)
    {
        if (is_callable($callback)) {
            $this->not_found_handler = $callback;
        }
        else {
            if (is_callable($this->not_found_handler)) {
                call_user_func(array($this, 'not_found_handler'));
            }
            else {
                call_user_func(array($this, 'default_not_found_handler'));
            }
        }
    }

    /**
     * Adds a new URL routing rule to the routing table, after converting any of
     * our special tokens into proper regular expressions.
     *
     * @param  Route  $route
     * @param  string $request_method
     * @return boolean
     * @throws Exception If the route already exists in the routing table
     */
    protected function route(Route $route, $http_method = 'GET')
    {
        // Does this URL already exist in the routing table?
        if (isset($this->routes[$http_method][$route->get_pattern()])) {
            // Trigger a new error and exception if errors are on
            throw new \Exception('The URI {htmlspecialchars($route->get_url())} already exists in the routing table');
        }

        // Add the route to the routing array
        $this->routes[$http_method][$route->get_pattern()] = $route;

        return true;
    }

    protected function default_not_found_handler()
    {
        // Use Twig to do something nice
        // Generate a response
        echo 'Didn\'t find anything';
    }

    protected function default_error_handler($error = '')
    {
        echo 'Server error';
    }

}
