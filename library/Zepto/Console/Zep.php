<?php

namespace Zepto\Console;

/**
 * Zep Console class
 *
 * Adds Zepto-specific methods and functionality, rather than having it all in
 * the executable file
 *
 *
 * <code>
 * use Zepto\Console\Zep as Console;
 *
 * $zep = new Console($argv);
 * </code>
 *
 * @package    Zepto
 * @subpackage Console
 * @author     Hassan Khan <contact@hassankhan.me>
 * @link       https://github.com/hassankhan/Zepto
 * @license    MIT
 * @since      0.7
 */
class Zep extends \Zepto\Console
{
    public function init()
    {
        // Use Flysystem
    }

    public function new_plugin()
    {
        // New Plugin
    }

    public function new_content()
    {
        // New content
    }

    /**
     * [check_current_directory description]
     * @param  [type] $path [description]
     * @return [type]       [description]
     */
    public function check_current_directory($path)
    {
        if (is_dir($path . "/plugins") && is_dir($path . "/content")) {
            return TRUE;
        }
        else {
            throw new \Exception("No content or plugins directory found, please run zep init");
        }
    }

}
