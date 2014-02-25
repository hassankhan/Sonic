<?php

namespace Zepto\Adapter;

/**
 * Plugin
 *
 * @package    Zepto
 * @subpackage Adapter
 * @author     Hassan Khan <contact@hassankhan.me>
 * @link       https://github.com/hassankhan/Zepto
 * @license    MIT
 * @since      0.7
 */
class Plugin extends \League\Flysystem\Adapter\Local
{
    /**
     * Sets base path and parser object
     *
     * @param string $base_path
     * @codeCoverageIgnore
     */
    public function __construct($base_path)
    {
        parent::__construct($base_path);
    }

    /**
     * Reads a file
     *
     * @param  string $path
     * @return Zepto\PluginInterface
     * @throws ErrorException           If an invalid path is specified
     * @throws UnexpectedValueException If plugin does not implement Zepto\PluginInterface
     */
    public function read($path)
    {
        // Try and read file
        parent::read($path);

        // Include plugin file
        include_once($this->prefix($path));

        // Get plugin name without extension
        $plugin_name = str_replace('.php', '', $path);

        // Check class implements correct interface
        $interfaces = class_implements($plugin_name);
        if (isset($interfaces['Zepto\PluginInterface']) === FALSE) {
            throw new \UnexpectedValueException('Plugin does not implement Zepto\PluginInterface');
        }

        return new $plugin_name;
    }

}
