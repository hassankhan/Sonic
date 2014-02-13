<?php

namespace Zepto;

/**
 * PluginInterface
 *
 * @package    Zepto
 * @subpackage PluginInterface
 * @author     Hassan Khan <contact@hassankhan.me>
 * @link       https://github.com/hassankhan/Zepto
 * @license    MIT
 * @since      0.2
 */
interface PluginInterface {

    public function after_plugins_load(\Pimple $app);

    public function before_config_load(\Pimple $app, &$settings);

    public function before_router_setup(\Pimple $app);

    public function after_router_setup(\Pimple $app);

    public function before_response_send(\Pimple $app);

    public function after_response_send(\Pimple $app);

}
