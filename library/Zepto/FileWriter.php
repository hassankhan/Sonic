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

    /**
     * Writes a file to the specified path with the given data
     * @param  string $file_path Path to write new file to
     * @param  string $file_data Content to write to file
     * @return
     */
    public function write($file_path, $file_data)
    {
        // Check if path is specified
        if (empty($file_path)) {
            throw new \Exception('No file path specified');
        }

        // Converts errors to exceptions
        set_error_handler(
            function($error, $message = '', $file = '', $line = 0) use ($file_path) {
                throw new \Exception(
                    'Failed to write to file at ' . $file_path
                    . ': ' . $message
                );
            }, E_WARNING
        );

        // Try to write contents to specified path
        try {
            file_put_contents($file_path, $file_data . PHP_EOL, LOCK_EX);
        }
        catch (\Exception $e) {
            restore_error_handler();
            throw $e;
        }

        // Restore previous error handler
        restore_error_handler();
    }

}
