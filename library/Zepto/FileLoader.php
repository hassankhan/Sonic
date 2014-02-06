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

class FileLoader {

    /**
     * The base path, used to trim from file paths when added to result array
     *
     * @var string
     */
    protected $base_path;

    /**
     * Initialises file cache object and sets base path
     *
     * @codeCoverageIgnore
     */
    public function __construct($base_path)
    {
        $this->base_path = $base_path;
    }

    /**
     * Loads in a single file
     *
     * @param  string $file_path
     * @return array
     * @throws RuntimeException         If there is a problem with the file
     * @throws UnexpectedValueException If path is a directory
     */
    public function load($file_path)
    {
        // Create full path
        $full_path = $this->base_path . $file_path;

        // Throw exception if path is a directory
        if (is_dir($full_path)) {
            throw new \UnexpectedValueException($full_path . 'is a directory not a file');
        }

        // Throw exception if file doesn't exist
        if (!is_file($full_path)) {
            throw new \RuntimeException('There was an error trying to load ' . $full_path);
        }

        // Get file contents and return
        return array($file_path => file_get_contents($full_path));
    }

    /**
     * Returns structure of folder as a multidimensional array. Used for
     * creating navigation links
     *
     * @deprecated May be subject to removal, after navigation revamp
     * @param  string $file_path
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

        return $contents;
    }

}
