<?php

/**
 * Zepto
 *
 * @author Hassan Khan
 * @link http://https://github.com/hassankhan/Zepto
 * @license http://opensource.org/licenses/MIT
 * @version 0.4
 */

use Whoops\Handler\PrettyPageHandler;
use Whoops\Handler\JsonResponseHandler;
use Whoops\Run;

class WhoopsPlugin implements \Zepto\PluginInterface {

    public function after_plugins_load()
    {
        $container = func_get_arg(0);

        // Add Whoops handlers
        $container['whoopsPrettyPageHandler'] = $container->share(
            function() {
                return new PrettyPageHandler();
            }
        );
        $container['whoopsJsonResponseHandler'] = $container->share(
            function() {
                $handler = new JsonResponseHandler();
                $handler->onlyForAjaxRequests(true);
                return $handler;
            }
        );

        $container["whoopsSlimInfoHandler"] = $container->protect(
            function() use ($container) {

                // Check to see if there is a current route, otherwise
                // ignore because router isn't set up yet
                try{
                    $current_route = $container['router']->current_route();
                }
                catch (\Exception $e) {
                    return;
                }

                $route_details = array();

                $container['whoopsPrettyPageHandler']->setPageTitle('Shit hit the fan!');
                $container['whoopsPrettyPageHandler']->setEditor('sublime');

                if ($current_route !== null) {
                    $route_details = array(
                        'Route URL'     => $current_route->url(),
                        'Route Pattern' => $current_route->pattern()
                    );
                }

                $container["whoopsPrettyPageHandler"]->addDataTable(
                    'Zepto Application',
                    array_merge(array(
                        'Charset' => $container['request']->headers->get("Accept-Charset"),
                        'Locale'  => $container['request']->getCharsets()
                    ), $route_details)
                );

                $container["whoopsPrettyPageHandler"]->addDataTable(
                    'Request Information',
                    array(
                        'URI'          => $container['request']->getUri(),
                        'Request URI'  => $container['request']->getRequestUri(),
                        'Path'         => $container['request']->getPathInfo(),
                        'Query String' => $container['request']->getQueryString(),
                        'HTTP Method'  => $container['request']->getMethod(),
                        'Script Name'  => $container['request']->getScriptName(),
                        'Base URL'     => $container['request']->getBaseUrl(),
                        'Scheme'       => $container['request']->getScheme(),
                        'Port'         => $container['request']->getPort(),
                        'Host'         => $container['request']->getHost()
                    )
                );
            }
        );

        $container['whoops'] = $container->share(
            function($container) {
                $run = new Run();
                $run->pushHandler($container['whoopsPrettyPageHandler']);
                $run->pushHandler($container['whoopsJsonResponseHandler']);
                $run->pushHandler($container['whoopsSlimInfoHandler']);
                return $run;
            }
        );

        // Try to register Whoops handler, and set the callback function
        try {
            $container['whoops']->register();
            $container['router']->error(array($container['whoops'], Run::EXCEPTION_HANDLER));
        } catch (\Exception $e) {
            return;
        }
    }

    public function before_config_load(&$settings)
    {
        // echo __CLASS__ . '::before_config_load';
    }

    public function before_file_load(&$content_dir)
    {
        // echo __CLASS__ . '::before_file_load';
    }

    public function after_file_load(&$content)
    {
        // $this->container['router']->error(array($container['whoops'], Run::EXCEPTION_HANDLER));
        // echo __CLASS__ . '::after_file_load';
    }

    public function request_url(&$url)
    {
        // echo __CLASS__ . '::request_url';
    }

}

?>
