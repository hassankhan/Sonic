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

    public function after_config_load(&$settings);

    public function request_url(&$url);

    public function before_file_load(&$file);

    public function after_file_load(&$content);

    // Move all these methods into their own classes
    // public function before_file_meta_parsed(&$headers);

    // public function after_file_meta_parsed(&$meta);

    // public function before_content_parsed(&$content);

    // public function after_content_parsed(&$content);

    // public function before_render(&$twig_vars, &$twig, &$template);

    // public function after_render(&$output);

}
