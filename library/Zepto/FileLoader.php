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

class FileLoader extends \Pimple {

    /**
     * Initialises file cache object
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        $this['file_cache'] = array();
    }

    /**
     * Loads in a single file, or all files in a directory and subdirectories under it
     * @param  string $file_path     File path
     * @param  array $file_extension File extensions
     * @return array                 Loaded files
     */
    public function load($file_path, $file_extension)
    {
        // Create array to store loaded files
        $loaded_files = array();

        if (!is_file($file_path) && !is_dir($file_path)) {
            throw new \Exception('There was an error trying to load ' . $file_path);
        }
        // Load files
        else {

            // For a single file
            if (is_file($file_path)) {
                // Get rid of extraneous path details
                $clean_file_name                = str_replace(ROOT_DIR, '', $file_path);
                $clean_file_name                = str_replace('content/', '', $clean_file_name);
                $loaded_files[$clean_file_name] = file_get_contents($file_path);
            }

            // For a directory
            if (is_dir($file_path)) {

                $iterator = new \RecursiveDirectoryIterator($file_path);
                foreach(new \RecursiveIteratorIterator($iterator) as $file) {

                    // To stop PHP error
                    $exploded_file = explode('.', $file);
                    if (in_array(strtolower(array_pop($exploded_file)), str_replace('.', '', $file_extension))) {
                        // Get rid of extraneous path details
                        $clean_file_name                = str_replace(ROOT_DIR, '', $file);
                        $clean_file_name                = str_replace('content/', '', $clean_file_name);
                        $loaded_files[$clean_file_name] = file_get_contents($file);
                    }
                }
            }

            // Cache loaded files for easy access
            $this['file_cache'] = $loaded_files;

            return $loaded_files;
        }
    }

    /**
     * Returns structure of folder as a multidimensional array. Used for
     * creating navigation links
     * @param  string $file_path Path to map
     * @return array
     */
    public function get_directory_map($file_path)
    {
        foreach (scandir($file_path) as $node) {
            if ($node == '.' || $node == '..') continue;
            if (is_dir($file_path . '/' . $node)) {
                $contents[$node] = $this->get_directory_map($file_path . '/' . $node);
            } else {
                if (preg_match('#^\.(\w+)#', $node) === 0) {
                    $contents[] = $node;
                }
            }
        }

        // Cache it somewhere?
        $this['folder_structure'] = $contents;

        return $contents;
    }

}
