<?php

namespace Zepto;

/**
 * This is the Zepto URL Router, the layer of a web application between the URL
 * and the route executed to perform a request.
 *
 * The router controls the boring, base-framework-y stuff. This includes
 * handling the request and response objects, adding routes, and figuring
 * out which route to execute for a given request.
 *
 * It supports adding routes to different HTTP methods (GET, POST and friends)
 * ```php
 * $router = new Zepto\Router;
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
 * @package    Zepto
 * @subpackage Router
 * @author     Brandon Wamboldt <brandon.wamboldt@gmail.com>
 * @author     Hassan Khan <contact@hassankhan.me>
 * @link       https://github.com/hassankhan/Zepto
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
    protected $routes = array();

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
     * @link http://api.symfony.com/2.4/Symfony/Component/HttpFoundation/Request.html Documentation for Request object
     * @param \Symfony\Component\HttpFoundation\Response $response
     * @link http://api.symfony.com/2.4/Symfony/Component/HttpFoundation/Response.html Documentation for Response object
     * @codeCoverageIgnore
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
     * @param  string   $route
     * @param  \Closure $callback
     */
    public function get($route, \Closure $callback)
    {
        $this->route(new Route($route, $callback));
    }

    /**
     * Add HTTP POST route
     *
     * @see    Router::route()
     * @param  string   $route
     * @param  \Closure $callback
     */
    public function post($route, \Closure $callback)
    {
        $this->route(new Route($route, $callback), self::METHOD_POST);
    }

    /**
     * Adds a new URL routing rule to the routing table, after converting any of
     * our special tokens into proper regular expressions.
     * @todo Make the method check to see if the http method exists or not
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
     * @return
     * @throws \RuntimeException If no routes exist in the routing table
     */
    public function run()
    {
        // If no routes have been added, then throw an exception
        if (empty($this->routes)) {
            throw new \RuntimeException('No routes exist in the routing table. Add some');
        }

        // Try and get a matching route for the current URL
        $route = $this->match(
            $this->request->getPathInfo(),
            $this->request->getMethod()
        );

        // Call not found handler if no match was found
        if ($route === null) {
            $this->current_http_status = \Symfony\Component\HttpFoundation\Response::HTTP_NOT_FOUND;
            $this->not_found();
        }
        // If route is a valid Route object, then try and execute its callback
        else {

            // Set current route
            $this->current_route = $route;

            // Get parameters from request
            $params = $this->parse_parameters($route);

            // Try to execute callback for route, if it fails, catch the exception
            // and generate a HTTP 500 error
            try {
                $this->current_http_status = \Symfony\Component\HttpFoundation\Response::HTTP_OK;

                // Set response content
                $this->response->setContent(call_user_func_array($route->callback(), $params));

                // Send response
                $this->response->send();
            }
            catch (\Exception $e) {
                $this->current_http_status = \Symfony\Component\HttpFoundation\Response::HTTP_INTERNAL_SERVER_ERROR;
                $this->error($e);
            }
        }
    }

    /**
     * ACCESSORS
     */

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
            // Execute error handler and set result as response content
            if (is_callable($this->error_handler)) {
                $this->response->setContent(call_user_func($this->error_handler, $arg));
            }
            else {
                $this->response->setContent(call_user_func(array($this, 'default_error_handler'), $arg));
            }

            // Set response's status code
            $this->response->setStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_INTERNAL_SERVER_ERROR);

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
            // Execute not found handler and set result as response content
            if (is_callable($this->not_found_handler)) {
                $this->response->setContent(call_user_func($this->not_found_handler));
            }
            else {
                $this->response->setContent(call_user_func(array($this, 'default_not_found_handler')));
            }
            // Set response's status code
            $this->response->setStatusCode($this->current_http_status);

            // Send response
            $this->response->send();
        }
    }

    /**
     * Default callback for any 404 errors
     *
     * @return string
     * @codeCoverageIgnore
     */
    protected function default_not_found_handler()
    {
        return $this->generate_error_template('Page Not Found', "Couldn't find your, like, page, dude");
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
        return $this->generate_error_template('Server Error', $error->getMessage());
    }

    /**
     * HELPER FUNCTIONS
     */

    /**
     * Parses parameters from URI as per the given route's pattern
     *
     * @param  Route  $route
     * @return array
     */
    protected function parse_parameters(Route $route)
    {
        // Get all parameter matches from URL for this route
        preg_match($route->pattern(), "{$this->request->getPathInfo()}/", $matches);

        $params = array();

        // Retrieve any matches
        foreach ($matches as $key => $value) {
            if (is_string($key)) {
                $params[] = $value;
            }
        }

        return $params;
    }

    /**
     * Returns a standard template for error messages. Thanks, Slim
     *
     * @param  string $title
     * @param  string $body
     * @return string
     * @codeCoverageIgnore
     */
    protected function generate_error_template($title, $body)
    {
        return sprintf('<html><head><title>%s</title><style>body{margin:0;padding:30px;font:12px/1.5 Helvetica,Arial,Verdana,sans-serif;}h1{margin:0;font-size:48px;font-weight:normal;line-height:48px;}strong{display:inline-block;width:65px;}</style></head><body><h1>%s</h1><p>%s</p></body></html>', $title, $title, $body);
    }

}
