<?php

namespace Sonic\Routing;

/**
 * This is the Sonic URL Router, the layer of a web application between the URL
 * and the route executed to perform a request.
 *
 * The router controls the boring, base-framework-y stuff. This includes
 * handling the request and response objects, adding routes, and figuring
 * out which route to execute for a given request.
 *
 * It supports adding routes to different HTTP methods (GET, POST and friends)
 * ```php
 * $router = new Sonic\Router;
 *
 * // Adding a basic HTTP GET route
 * $router->get( '/get', 'get_page' );
 *
 * // Adding a basic HTTP POST route
 * $router->post( '/post', 'post_page' );
 *
 * // Adding a route with a named alphanumeric capture, using the <:var_name> syntax
 * $router->get( '/user/view/<:username>', 'view_username' );
 *
 * // Adding a route with a named numeric capture, using the <#var_name> syntax
 * $router->get( '/user/view/<#user_id>', array( 'UserClass', 'view_user' ) );
 *
 * // Adding a route with a wildcard capture (Including directory separtors), using
 * // the <*var_name> syntax
 * $router->get( '/browse/<*categories>', 'category_browse' );
 *
 * // Adding a wildcard capture (Excludes directory separators), using the
 * // <!var_name> syntax
 * $router->get( '/browse/<!category>', 'browse_category' );
 *
 * // Adding a custom regex capture using the <:var_name|regex> syntax
 * $router->get( '/lookup/zipcode/<:zipcode|[0-9]{5}>', 'zipcode_func' );
 *
 * // Specifying priorities
 * $router->get( '/users/all', 'view_users', 1 ); // Executes first
 * $router->get( '/users/<:status>', 'view_users_by_status', 100 ); // Executes after
 *
 * // Specifying a callback function if no other route is matched
 * $router->not_found( 'page_404' );
 * $router->not_found(array('SomeClass', 'page_404_method'));
 *
 * // Specifying a callback function if any errors occur
 * $router->error( 'page_500' );
 * $router->not_found(array('SomeClass', 'page_500_method'));
 *
 * // Run the router
 * $router->run();
 * ```
 * @package    Sonic
 * @author     Brandon Wamboldt <brandon.wamboldt@gmail.com>
 * @author     Hassan Khan <contact@hassankhan.me>
 * @link       https://github.com/hassankhan/Sonic
 * @license    MIT
 * @since      0.2
 */
class Router
{

    /**
     * Supported HTTP Methods (might not be strictly accurate yet - I've only tested GET and POST')
     */
    const METHOD_HEAD    = 'HEAD';
    const METHOD_GET     = 'GET';
    const METHOD_POST    = 'POST';
    const METHOD_PUT     = 'PUT';
    const METHOD_PATCH   = 'PATCH';
    const METHOD_DELETE  = 'DELETE';
    const METHOD_OPTIONS = 'OPTIONS';

    /**
     * Request object
     *
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * Response object
     * @var \Symfony\Component\HttpFoundation\Response
     */
    protected $response;

    /**
     * Currently matched route, if one has been set
     *
     * @var Route
     */
    protected $current_route;

    /**
     * Current route's status code. Is either 200, 404 or 500
     *
     * @var integer
     */
    protected $current_http_status;

    /**
     * An array containing the list of routing rules and their callback
     * functions, as well as their request method and any additional paramters.
     *
     * @var Route[]
     */
    protected $routes;

    /**
     * Callback function to execute when no matching URL is found
     *
     * @var \Closure
     */
    protected $not_found_handler;

    /**
     * Callback function to execute on any other error
     *
     * @var \Closure
     */
    protected $error_handler;

    /**
     * Initializes the router, and handles the request and response objects
     *
     * @param \Symfony\Component\HttpFoundation\Request  $request
     * @link  http://api.symfony.com/2.4/Symfony/Component/HttpFoundation/Request.html Documentation for Request object
     * @param \Symfony\Component\HttpFoundation\Response $response
     * @link  http://api.symfony.com/2.4/Symfony/Component/HttpFoundation/Response.html Documentation for Response object
     */
    public function __construct(
        \Symfony\Component\HttpFoundation\Request  $request,
        \Symfony\Component\HttpFoundation\Response $response
    ) {
        $this->request  = $request;
        $this->response = $response;
    }

    /**
     * ROUTING
     */

    /**
     * Add HTTP GET route
     *
     * @see    Router::route()
     * @param  string                $route
     * @param  array|\Closure|string $callback
     */
    public function get($route, $callback)
    {
        $this->route(new Route($route, $callback));
    }

    /**
     * Add HTTP POST route
     *
     * @see    Router::route()
     * @param  string                $route
     * @param  array|\Closure|string $callback
     */
    public function post($route, $callback)
    {
        $this->route(new Route($route, $callback), self::METHOD_POST);
    }

    /**
     * Adds a new URL routing rule to the routing table, after converting any of
     * our special tokens into proper regular expressions.
     *
     * @param  Route  $route
     * @param  string $http_method
     * @throws \InvalidArgumentException If an invalid HTTP method is specified
     * @throws \LogicException           If the route already exists in the routing table
     */
    public function route(Route $route, $http_method = self::METHOD_GET)
    {
        // Is this a valid HTTP method?
        if (!in_array($http_method, array(
            self::METHOD_HEAD,
            self::METHOD_GET,
            self::METHOD_POST,
            self::METHOD_PUT,
            self::METHOD_PATCH,
            self::METHOD_DELETE
        ))) {
            throw new \InvalidArgumentException("The method {$http_method} is invalid");
        }

        // Does this URL already exist in the routing table?
        if (isset($this->routes[$http_method][$route->pattern()])) {
            // Trigger a new error and exception if errors are on
            throw new \LogicException("The URI {$route->url()} already exists in the routing table");
        }

        // Add the route to the routing table
        $this->routes[$http_method][$route->pattern()] = $route;
    }

    /**
     * Returns a Route object if matching URL is found
     *
     * @param  string $url
     * @param  string $http_method
     * @return Route|null
     */
    public function match($url, $http_method = self::METHOD_GET)
    {
        // Make sure there is a trailing slash
        $url = rtrim($url, '/') . '/';

        foreach ($this->routes[$http_method] as $route) {
            if (preg_match($route->pattern(), $url)) {
                return $route;
            }
        }
        return null;
    }

    /**
     * ROUTE EXECUTION
     */

    /**
     * Runs the router matching engine and then calls the matching route's
     * callback. otherwise execute the not found handler
     *
     * @return bool
     * @throws \RuntimeException If no routes exist in the routing table
     */
    public function run()
    {
        // If no routes have been added, then throw an exception
        try {
            if (empty($this->routes)) {
                throw new \RuntimeException('No routes exist in the routing table. Add some');
            }
        }
        catch (\Exception $e) {
            $this->error($e);
            return FALSE;
        }

        // Try and get a matching route for the current URL
        $route = $this->match(
            $this->request->getPathInfo(),
            $this->request->getMethod()
        );

        // Call not found handler if no match was found
        if ($route === null) {
            $this->not_found();
            return FALSE;
        }

        // Set current route
        $this->current_route = $route;

        // Get parameters from request
        $params = $this->parse_parameters($route);
        // Try to execute callback for route, if it fails, catch the exception and generate a HTTP 500 error
        try {
            $this->current_http_status = \Symfony\Component\HttpFoundation\Response::HTTP_OK;

            // Set response content
            $this->response->setContent($route->execute($params));

            // Send response
            $this->response->send();
            return TRUE;
        }
        catch (\Exception $e) {
            $this->error($e);
            return FALSE;
        }
    }

    /**
     * Redirects to another URL
     *
     * @param  string $url
     * @return bool
     */
    public function redirect($url)
    {
        // If no URL is given, throw exception
        try {
            if (empty($url)) {
                throw new \InvalidArgumentException('No URL given');
            }
        }
        catch (\Exception $e) {
            $this->error($e);
            return FALSE;
        }

        // Set redirect status codes and location
        $this->current_http_status = \Symfony\Component\HttpFoundation\Response::HTTP_FOUND;
        $this->response->setStatusCode($this->current_http_status);
        $this->response->headers->set('Location', $url);
        return TRUE;
    }

    /**
     * ACCESSORS
     */

    /**
     * Returns request object
     *
     * @return \Symfony\Component\HttpFoundation\Request
     */
    public function request()
    {
        return $this->request;
    }

    /**
     * Returns response object
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response()
    {
        return $this->response;
    }

    /**
     * Returns all routes mapped on the routing table.
     *
     * @return Route[]
     */
    public function routes()
    {
        return $this->routes;
    }

    /**
     * Returns the currently matched route.
     *
     * @return Route
     */
    public function current_route()
    {
        return $this->current_route;
    }

    /**
     * Returns the HTTP status code of the currently matched route
     *
     * @return integer
     */
    public function current_http_status()
    {
        return $this->current_http_status;
    }

    /**
     * ERROR HANDLING
     */

    /**
     * This method can either set the callback to execute on a 'Server error' (50x)
     * error, or it invokes the callback
     * To set the callback, provide a function to the method
     * To invoke the callback, call the method with a string detailing the error
     * as a parameter
     *
     * @param  \Closure|\Exception $arg
     * @return
     */
    public function error($arg = null)
    {
        if (is_callable($arg)) {
            // Set provided callback function as error handler
            $this->error_handler = $arg;
        }
        else {
            // Set HTTP status on router
            $this->current_http_status = \Symfony\Component\HttpFoundation\Response::HTTP_INTERNAL_SERVER_ERROR;

            // Execute error handler and set result as response content
            $result = is_callable($this->error_handler) === TRUE
                ? call_user_func($this->error_handler, $arg)
                : $this->default_error_handler($arg)->execute();

            $this->response->setContent($result);

            // Set response's status code
            $this->response->setStatusCode($this->current_http_status);

            // Send response
            $this->response->send();
        }
    }

    /**
     * This method can either set the callback to execute on a 'Page not found' (404)
     * error, or it invokes the callback
     * To set the callback, provide a function to the method
     * To invoke the callback, call the method without any parameters
     *
     * @param  \Closure $callback
     * @return
     */
    public function not_found($callback = null)
    {
        if (is_callable($callback)) {
            // Set provided callback function as not found handler
            $this->not_found_handler = $callback;
        }
        else {
            // Set HTTP status on router
            $this->current_http_status = \Symfony\Component\HttpFoundation\Response::HTTP_NOT_FOUND;

            // Execute not found handler and set result as response content
            $result = is_callable($this->not_found_handler) === TRUE
                ? call_user_func($this->not_found_handler)
                : $this->default_not_found_handler()->execute();

            $this->response->setContent($result);

            // Set response's status code
            $this->response->setStatusCode($this->current_http_status);

            // Send response
            $this->response->send();
        }
    }

    /**
     * HELPERS
     */

    /**
     * Default callback for any 404 errors
     *
     * @return string
     * @codeCoverageIgnore
     */
    protected function default_not_found_handler()
    {
        return new Route\ErrorRoute('/404', 'Page Not Found', "Couldn't find your, like, page, dude");
    }

    /**
     * Default callback for any 500 errors. If $error is provided
     * as a parameter, then the message is added to the HTML output
     *
     * @param  \Exception $error
     * @return string
     * @codeCoverageIgnore
     */
    protected function default_error_handler(\Exception $error)
    {
        return new Route\ErrorRoute('/500', 'Server Error', $error->getMessage());
    }

    /**
     * Parses parameters from URI as per the given route's pattern
     *
     * @param  Route  $route
     * @return array
     */
    protected function parse_parameters(Route $route)
    {
        // Get all parameter matches from URL for this route
        $request_url = rtrim($this->request->getPathInfo(), '/') . '/';
        preg_match($route->pattern(), "{$request_url}", $matches);

        $params = array();

        // Retrieve any matches
        foreach ($matches as $key => $value) {
            if (is_string($key)) {
                $params[] = $value;
            }
        }

        return $params;
    }

}
