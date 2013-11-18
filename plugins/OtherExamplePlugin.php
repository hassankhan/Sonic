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
        echo '2';
    }

    public function after_config_load(&$settings)
    {
        echo '2';
    }

    public function request_url(&$url)
    {
        echo '2';
    }

    public function before_file_load(&$file)
    {
        echo '2';
    }

    public function after_file_load(&$content)
    {
        echo '2';
    }

}

?>
