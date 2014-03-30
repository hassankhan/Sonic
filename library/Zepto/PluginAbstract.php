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
abstract class PluginAbstract {

    protected $zepto;

    public function set_app(Zepto $zepto) {
        $this->zepto = $zepto;
    }

    abstract public function after_plugins_load();

    abstract public function before_config_load(&$settings);

    abstract public function before_router_setup();

    abstract public function after_router_setup();

    abstract public function before_response_send();

    abstract public function after_response_send();

}
