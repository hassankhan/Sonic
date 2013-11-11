<?php

/**
 * Zepto
 *
 * @author Hassan Khan
 * @link http://https://github.com/hassankhan/Zepto
 * @license http://opensource.org/licenses/MIT
 * @version 0.2
 */

namespace Zepto\FileLoader;

class JsonLoader extends \Zepto\FileLoader {

    /**
     * Loads in a single file or all files in a directory if $file_path is a folder
     * @return array Loaded files
     */
    public function load()
    {
        $files = parent::load();
        return $this->post_process($files);
    }

    public function post_process()
    {

    }

}
