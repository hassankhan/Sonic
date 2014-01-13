<?php

/**
 * FileWriter
 *
 * @author Hassan Khan
 * @link http://https://github.com/hassankhan/Zepto
 * @license http://opensource.org/licenses/MIT
 * @version 0.5
 */

namespace Zepto;

class FileWriter {

    // Seems to work, meh
    public function write($file_path, $file_data)
    {
        $handle = fopen($file_path, 'w');
        if ($handle === false) {
            throw new Exception(
                'Failed to create file ' . $file_name
                . 'at ' . $file_path
            );
        }

        if (fwrite($handle, $file_data) === false) {
            throw new Exception(
                'Failed to create file ' . $file_name
                . 'at ' . $file_path
            );
        }

        return true;
    }

}
