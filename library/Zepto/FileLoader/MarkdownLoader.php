<?php

namespace Zepto\FileLoader;

/**
 * MarkdownLoader
 *
 * @package    Zepto
 * @subpackage FileLoader
 * @author     Hassan Khan <contact@hassankhan.me>
 * @link       https://github.com/hassankhan/Zepto
 * @license    MIT
 * @since      0.2
 * @deprecated Use \Zepto\FileLoader\PageLoader instead
 */
class MarkdownLoader extends \Zepto\FileLoader
{
    /**
     * An object which parses Markdown to HTML
     *
     * @var \Michelf\MarkdownInterface
     */
    protected $parser;

    /**
     * Class constructor. Sets the base path, but also the Markdown parser
     *
     * @param string                       $base_path
     * @param \League\Flysystem\Filesystem $filesystem
     * @param \Michelf\MarkdownInterface   $parser
     */
    public function __construct(
        $base_path,
        \League\Flysystem\Filesystem $filesystem,
        \Michelf\MarkdownInterface $parser
    ) {
        parent::__construct($filesystem, $base_path);
        $this->parser = $parser;
    }

    /**
     * Basically does the same job as the superclass, except this time we run
     * it through a post_process() method to work some magic on it
     *
     * @param  string $file_path
     * @return array
     */
    public function load($file_path)
    {
        return $this->post_process(parent::load($file_path));
    }

    /**
     * Returns the parser object
     *
     * @return \Michelf\MarkdownInterface
     */
    public function parser()
    {
        return $this->parser;
    }

    /**
     * Where the magic happens, ladies and gentlemen. An array with the keys set to the name of
     * the file and the values set to the processed Markdown text
     *
     * @return array
     * @codeCoverageIgnore
     */
    protected function post_process($content)
    {
        // Create array to store processed files
        $processed_files = array();

        // Loop through files and process each one, adding them to the array
        foreach ($content as $file_name => $file) {
            $processed_files[$file_name] = array(
                'meta'    => $this->parse_meta($file),
                'content' => $this->parse_content($file)
            );
        }

        return $processed_files;
    }

    /**
     * Parses Markdown file headers for metadata
     *
     * @param  string $file The loaded Markdown file as a string
     * @return array        An array containing file metadata
     * @codeCoverageIgnore
     */
    protected function parse_meta($file)
    {
        // Grab meta section between '/* ... */' in the content file
        preg_match_all('#/\*(.*?)\*/#s', $file, $meta);

        // Retrieve individual meta fields
        preg_match_all('/^[\t\/*#@]*(.*):(.*)$/mi', $meta[1][0], $match);

        for ($i=0; $i < count($match[1]); $i++) {
            $result[strtolower($match[1][$i])] = trim(htmlentities($match[2][$i]));
        }

        return $result;
    }

    /**
     * Parses Markdown file for content
     *
     * @param  string $file The loaded Markdown file as a string
     * @return string       The parsed string as HTML
     * @codeCoverageIgnore
     */
    protected function parse_content($file)
    {
        $content = preg_replace('#/\*.+?\*/#s', '', $file);
        return $this->parser->defaultTransform($content);
    }

}
