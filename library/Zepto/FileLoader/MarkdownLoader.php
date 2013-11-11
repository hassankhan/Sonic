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

use Parsedown;

class MarkdownLoader extends \Zepto\FileLoader {

    /**
     * Basically does the same job as the superclass, except this time we run
     * it through a post_process() method to work some magic on it
     * @param  string $file_path      File path
     * @param  string $file_extension File extension
     * @return array                  Loaded files
     */
    public function load($file_path, $file_extension)
    {
        $files = parent::load($file_path, $file_extension);
        return $this->post_process();
    }

    /**
     * Where the magic happens, ladies and gentlemen
     * @codeCoverageIgnore
     * @param  Parsedown $processor Instance of Parsedown
     * @return array                An array with the keys set to the name of
     *                              the file and the values set to the processed
     *                              Markdown text
     */
    private function post_process()
    {
        // Create array to store processed files
        $processed_files = array();

        // Loop through files and process each one, adding them to the array
        foreach ($this['file_cache'] as $file_name => $file) {
            $processed_files[$file_name] = array(
                'meta'    => $this->parse_meta($file),
                'content' => $this->parse_content($file)
            );
        }

        // Update local cache
        $this['file_cache'] = $processed_files;

        return $processed_files;
    }

    /**
     * Parses Markdown file headers for metadata
     * @codeCoverageIgnore
     * @param  string $file The loaded Markdown file as a string
     * @return array        An array containing file metadata
     */
    private function parse_meta($file)
    {
        // Define metadata
        $meta = array(
            'title'         => 'Title',
            'description'   => 'Description',
            'author'        => 'Author',
            'date'          => 'Date',
            'robots'        => 'Robots',
            'template'      => 'Template'
        );

        // Grab meta fields between '/* ... */' in the content file
        foreach ($meta as $field => $regex) {
            if (
                preg_match(
                    '/^[ \t\/*#@]*' . preg_quote($regex, '/') . ':(.*)$/mi',
                    $file,
                    $match
                ) && $match[1]
            ) {
                $meta[$field] = trim(preg_replace("/\s*(?:\*\/|\?>).*/", '', $match[1]));
            }
            else {
                $meta[$field] = '';
            }
        }

        return $meta;
    }

    /**
     * Parses Markdown file for content
     * @codeCoverageIgnore
     * @param  string $file The loaded Markdown file as a string
     * @return string       The parsed string as HTML
     */
    private function parse_content($file)
    {
        $content = preg_replace('#/\*.+?\*/#s', '', $file);
        return Parsedown::instance()->parse($content);
    }

}
