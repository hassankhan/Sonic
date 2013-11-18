<?php

/**
 * Zepto
 *
 * @author Hassan Khan
 * @link http://https://github.com/hassankhan/Zepto
 * @license http://opensource.org/licenses/MIT
 * @version 0.4
 */

class ExamplePlugin implements \Zepto\PluginInterface {

    public function after_config_load(&$settings)
    {
        echo __CLASS__ . '::after_config_load';
    }

    public function after_plugins_load()
    {
        echo __CLASS__ . '::after_plugins_load';
    }

    public function request_url(&$url)
    {
        echo __CLASS__ . '::request_url';
    }

    public function before_file_load(&$content_dir)
    {
        echo __CLASS__ . '::before_file_load';
    }

    public function after_file_load(&$content)
    {
        echo __CLASS__ . '::after_file_load';
    }

}

?>
