<?php

namespace Zepto;

/**
 * FileLoader
 *
 * @package    Zepto
 * @subpackage FileLoader
 * @author     Hassan Khan <contact@hassankhan.me>
 * @link       http://https://github.com/hassankhan/Zepto
 * @license    MIT
 * @since      0.2
 */
class FileLoader {

    /**
     * The base path, ending in a trailing forward-slash
     *
     * @var string
     */
    protected $base_path;

    /**
     * Initialises object and sets base path
     *
     * @param string $base_path
     * @throws \UnexpectedValueException If path given is not a valid path
     */
    public function __construct($base_path)
    {
        $base_path = rtrim($base_path, '/') . '/';

        if (!is_dir($base_path)) {
            throw new \UnexpectedValueException($base_path . ' is not a valid directory');
        }

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
     * Returns the base path
     *
     * @return string
     */
    public function base_path()
    {
        return $this->base_path;
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
