<?php

/**
 * Zepto
 *
 * @author Hassan Khan
 * @link http://https://github.com/hassankhan/Zepto
 * @license http://opensource.org/licenses/MIT
 * @version 0.4
 */

class OtherExamplePlugin implements \Zepto\PluginInterface {

    public function after_plugins_load()
    {
        // echo __CLASS__ . '::after_plugins_load';
    }

    public function before_config_load(&$settings)
    {
        // echo __CLASS__ . '::before_config_load';
    }

    public function before_router_setup()
    {
    }

    public function after_router_setup()
    {
    }

    public function before_response_send()
    {
    }

    public function after_response_send()
    {
    }

}
