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
     * @param string                   $base_path
     */
    public function __construct($base_path)
    {
        parent::__construct($base_path);
    }

    /**
     * Reads a file
     * @param  string     $path
     * @return array|bool
     */
    public function read($path)
    {
        $file = parent::read($path);
        if ($file !== FALSE) {
            include_once($this->prefix($path));
        }
    }

}
