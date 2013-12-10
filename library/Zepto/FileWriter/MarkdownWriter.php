<?php

/**
 * MarkdownWriter
 *
 * @author Hassan Khan
 * @link http://https://github.com/hassankhan/Zepto
 * @license http://opensource.org/licenses/MIT
 * @version 0.5
 */

namespace Zepto\FileWriter;

class MarkdownWriter extends \Zepto\FileWriter {

    public function __construct()
    {
        $this->file_template = <<<MARKDOWN
/*
Title: %s
Description: %s
Date: %s

%s
*/
MARKDOWN;
    }

    // Seems to work, meh
    public function write($file_path, $file_data)
    {
        list($title, $desc, $date, $content) = $file_data;

        $clean_title   = htmlentities($title,   ENT_HTML5, 'UTF-8');
        $clean_desc    = htmlentities($desc,    ENT_HTML5, 'UTF-8');
        $clean_date    = htmlentities($date,    ENT_HTML5, 'UTF-8');
        $clean_content = htmlentities($content, ENT_HTML5, 'UTF-8');

        $data          = array(
            $clean_title,
            $clean_desc,
            $clean_date,
            $clean_content
        );

        // Put text in Markdown template
        $file_data     = vsprintf($this->file_template, $data);

        // Call parent method to do write
        return parent::write($file_path, $file_data);
    }

}
