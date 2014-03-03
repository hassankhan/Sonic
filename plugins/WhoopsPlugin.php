<?php

use Whoops\Handler\PrettyPageHandler;
use Whoops\Handler\JsonResponseHandler;
use Whoops\Run;

/**
 * WhoopsPlugin
 *
 * @author     Hassan Khan <contact@hassankhan.me>
 * @link       https://github.com/hassankhan/Zepto
 * @license    MIT
 * @since      0.4
 */
class WhoopsPlugin implements \Zepto\PluginInterface {

    public function after_plugins_load(\Pimple $app)
    {
        // Add Whoops handlers
        $app['whoopsPrettyPageHandler'] = $app->factory(
            function () {
                return new PrettyPageHandler();
            }
        );
        $app['whoopsJsonResponseHandler'] = function () {
            $handler = new JsonResponseHandler();
            $handler->onlyForAjaxRequests(true);
            return $handler;
        };
        $app["whoopsZeptoInfoHandler"] = function () use ($app) {

            $handler       = $app['whoopsPrettyPageHandler'];
            $route_details = array();

            $handler->setPageTitle('Shit hit the fan!');
            $handler->setEditor('sublime');

            if ($app['router']->current_route() !== null) {
                $route_details = array(
                    'Route URL'     => $app['router']->current_route()->url(),
                    'Route Pattern' => $app['router']->current_route()->pattern()
                );
            }

            $handler->addDataTable(
                'Zepto Application',
                array_merge(array(
                    'Version' => \Zepto\Zepto::VERSION,
                    'Charset' => $app['request']->headers->get('Accept-Charset'),
                    'Locale'  => $app['request']->getPreferredLanguage()
                ), $route_details)
            );

            $handler->addDataTable(
                'Request Information',
                array(
                    'URI'          => $app['request']->getUri(),
                    'Request URI'  => $app['request']->getRequestUri(),
                    'Path'         => $app['request']->getPathInfo(),
                    'Query String' => $app['request']->getQueryString(),
                    'HTTP Method'  => $app['request']->getMethod(),
                    'Script Name'  => $app['request']->getScriptName(),
                    'Base URL'     => $app['request']->getBaseUrl(),
                    'Scheme'       => $app['request']->getScheme(),
                    'Port'         => $app['request']->getPort(),
                    'Host'         => $app['request']->getHost()
                )
            );

            return $handler;
        };

        // Add actual Whoops\Run object
        $app['whoops'] = function ($app) {
            $run = new Run();
            $run->pushHandler($app['whoopsPrettyPageHandler']);
            $run->pushHandler($app['whoopsJsonResponseHandler']);
            $run->pushHandler($app['whoopsZeptoInfoHandler']);
            return $run;
        };
    }

    public function before_config_load(\Pimple $app, &$settings)
    {
        // If we're not on dev, then don't load up
        if ($settings['zepto.environment'] !== 'dev') {
            return;
        }

        // Try to register Whoops, and set the callback function
        try {
            $app['whoops']->register();
            $app['router']->error(array($app['whoops'], Run::EXCEPTION_HANDLER));
        }
        catch (\Exception $e) {
            return;
        }
    }

    public function before_router_setup(\Pimple $app)
    {
    }

    public function after_router_setup(\Pimple $app)
    {
    }

    public function before_response_send(\Pimple $app)
    {
    }

    public function after_response_send(\Pimple $app)
    {
    }

}
