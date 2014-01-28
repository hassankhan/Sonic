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

    public function after_plugins_load($container)
    {
        $container["whoopsPrettyPageHandler"] = $container->share(
            function() {
                return new PrettyPageHandler();
            }
        );

        $container["whoopsJsonResponseHandler"] = $container->share(
            function() {
                $handler = new JsonResponseHandler();
                $handler->onlyForAjaxRequests(true);
                return $handler;
            }
        );

        $container["whoopsSlimInfoHandler"] = $container->protect(
            function($container) {
                // Do a test to see if page failed

                $current_url_clean = $container['router']->get_current_route();
                $current_url_dirty = $container['router']->get_current_route(false);

                $headers = apache_request_headers();

                $content_type = $headers["CONTENT_TYPE"];

                $route_details = array();

                if ($current_route !== null) {
                    $route_details = array(
                        "Route URL"     => $current_route,
                        "Route Pattern" => ''
                    );
                }

                $container["whoopsPrettyPageHandler"]->addDataTable(
                    'Zepto Application',
                    array_merge(array(
                        "Charset"           => $headers["ACCEPT_CHARSET"],
                        "Locale"            => $content_type['charset']
                    ), $route_details)
                );

                $container["whoopsPrettyPageHandler"]->addDataTable(
                    'Request Information',
                    array_merge(array(
                        "URI"         => $current_url_dirty,
                        "Request URI" => $current_url_clean

                    ), $route_details)
                );

                // $whoops_editor = get from config
                $container["whoops"] = $container->share(
                    function() {
                        $run = new Run();
                        $run->pushHandler($container["whoopsPrettyPageHandler"]);
                        $run->pushHandler($container["whoopsJsonResponseHandler"]);
                        $run->pushHandler($container["whoopsSlimInfoHandler"]);

                        return $run;
                    }
                );
            }
        );
        // echo __CLASS__ . '::after_plugins_load';
    }

    public function before_config_load(&$settings)
    {
        echo __CLASS__ . '::before_config_load';
    }

    public function before_file_load(&$content_dir)
    {
        echo __CLASS__ . '::before_file_load';
    }

    public function after_file_load(&$content)
    {
        echo __CLASS__ . '::after_file_load';
    }

    public function request_url(&$url)
    {
        echo __CLASS__ . '::request_url';
    }

}

?>
