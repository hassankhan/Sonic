<?php

namespace Sonic;

/**
 * PluginInterface
 *
 * @package    Sonic
 * @author     Hassan Khan <contact@hassankhan.me>
 * @link       https://github.com/hassankhan/Sonic
 * @license    MIT
 * @since      0.2
 */
abstract class PluginAbstract {

    protected $zepto;

    public function set_app(Sonic $zepto) {
        $this->zepto = $zepto;
    }

    abstract public function after_plugins_load();

    abstract public function before_config_load(&$settings);

    abstract public function before_router_setup();

    abstract public function after_router_setup();

    abstract public function before_response_send();

    abstract public function after_response_send();

}
