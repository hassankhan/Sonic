<?php

/**
 * Zepto
 *
 * @author Hassan Khan
 * @link http://https://github.com/hassankhan/Zepto
 * @license http://opensource.org/licenses/MIT
 * @version 0.2
 */

namespace Zepto;

interface PluginInterface {

    public function after_plugins_load();

    public function before_config_load(&$settings);

    public function before_file_load(&$content_dir);

    public function after_file_load(&$content);

    public function before_router_setup();

    public function after_router_setup();

    public function before_response_send();

    public function after_response_send();

}
