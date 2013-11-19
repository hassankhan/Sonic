<?php

/**
 * PluginLoader
 *
 * @author Hassan Khan
 * @link http://https://github.com/hassankhan/Zepto
 * @license http://opensource.org/licenses/MIT
 * @version 0.2
 */

namespace Zepto\FileLoader;

class PluginLoader extends \Zepto\FileLoader {

    // public function __construct($plugin_dir)
    // {
        // parent::__construct();
        // $this->plugin_dir = $plugin_dir;
    // }

    /**
     * Loads in a single file or all files in a directory if $file_path is a folder
     *
     * @return array Loaded plugins
     */
    public function load($file_path, $file_extension)
    {
        // Create array to store loaded plugins
        $loaded_plugins = array();

        if (!is_file($file_path) && !is_dir($file_path)) {
            throw new \Exception('There was an error trying to load ' . $file_path);
        }
        // Load files
        else {

            // For a single file
            if (is_file($file_path)) {
                // Include plugin file
                include_once($file_path);

                // Strip extraneous path details
                $file = str_replace(ROOT_DIR, '', $file_path);

                if (preg_match_all('/^plugins\/([A-Z]+\w+)Plugin.php$/', $file, $matches) === false) {
                    throw new Exception('You didn\'t name the fucking plugin correctly. Should be MyPluginNamePlugin.php');
                }

                $plugin_name = $matches[1][0] . 'Plugin';

                if (class_exists($plugin_name)) {
                    $plugin                       = new $plugin_name;
                    $loaded_plugins[$plugin_name] = $plugin;
                }
            }

            // For a directory
            if (is_dir($file_path)) {

                if ($handle = opendir(ROOT_DIR . 'plugins')) {
                    while (false !== ($entry = readdir($handle))) {

                        if (preg_match_all('/^([A-Z]+\w+)Plugin.php$/', $entry, $matches)) {

                            include_once(ROOT_DIR . 'plugins/' . $entry);

                            $plugin_name = $matches[1][0] . 'Plugin';
                            if (class_exists($plugin_name)) {
                                $plugin                       = new $plugin_name;
                                $loaded_plugins[$plugin_name] = $plugin;
                            }
                        }
                    }
                    closedir($handle);
                }
            }

            // Cache loaded files for easy access
            $this['file_cache'] = $loaded_plugins;

            return $loaded_plugins;
        }
    }

}