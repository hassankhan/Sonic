<?php

namespace Zepto\Adapter;

/**
 * Markdown
 *
 * @package    Zepto
 * @subpackage Adapter
 * @author     Hassan Khan <contact@hassankhan.me>
 * @link       https://github.com/hassankhan/Zepto
 * @license    MIT
 * @since      0.7
 */
class Markdown extends \League\Flysystem\Adapter\Local
{
    /**
     * Sets base path and parser object
     *
     * @param string                     $base_path
     * @param \Michelf\MarkdownInterface $parser
     */
    public function __construct($base_path, \Michelf\MarkdownInterface $parser)
    {
        parent::__construct($base_path);
        $this->parser = $parser;
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
     * Reads a file
     *
     * @param  string $path
     * @return array
     * @throws ErrorException If an invalid path is specified
     */
    public function read($path)
    {
        return $this->post_process(parent::read($path));
    }

    /**
     * Where the magic happens, ladies and gentlemen. An array with the keys set to the name of
     * the file and the values set to the processed Markdown text
     *
     * @return array
     */
    protected function post_process($file)
    {
        return array(
            'meta'     => $this->parse_meta($file['contents']),
            'contents' => $this->parse_content($file['contents']),
            'path'     => $file['path']
        );
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
