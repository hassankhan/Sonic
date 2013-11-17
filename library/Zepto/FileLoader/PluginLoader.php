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

    /**
     * Loads in a single file or all files in a directory if $file_path is a folder
     * @return array Loaded plugins
     */
    public function load($file_path, $file_extension)
    {
        // Create array to store loaded plugins
        $loaded_files = array();

        if (!is_file($file_path) && !is_dir($file_path)) {
            throw new \Exception('There was an error trying to load ' . $file_path);
        }
        // Load files
        else {

            // For a single file
            if (is_file($file_path)) {
                // Include plugin file
                include_once($file_path);
            }

            // For a directory
            if (is_dir($file_path)) {

                $iterator = new \RecursiveDirectoryIterator($file_path);
                foreach(new \RecursiveIteratorIterator($iterator) as $file) {
                    // Include plugin file
                    include_once($file);
                }
            }

            // Cache loaded files for easy access
            // $this['file_cache'] = $loaded_files;

            return;
        }
    }

}
