<?php

namespace Zepto\Flysystem\Plugin;

use Michelf\MarkdownExtra;

/**
 * Markdown
 *
 * @package    Zepto
 * @subpackage Flysystem
 * @author     Hassan Khan <contact@hassankhan.me>
 * @link       https://github.com/hassankhan/Zepto
 * @license    MIT
 * @since      0.7
 */
class Markdown implements \League\Flysystem\PluginInterface
{
    /**
     * Filesystem object
     *
     * @var \League\Flysystem\FilesystemInterface
     */
    protected $filesystem;

    /**
     * Markdown parser
     * @var \Michelf\MarkdownInterface
     */
    protected $parser;

    /**
     * Sets the filesystem for this plugin
     *
     * @param LeagueFlysystemFilesystemInterface $filesystem
     * @codeCoverageIgnore
     */
    public function setFilesystem(\League\Flysystem\FilesystemInterface $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Sets the Markdown parser
     *
     * @param \Michelf\MarkdownInterface $parser
     * @codeCoverageIgnore
     */
    public function setParser(\Michelf\MarkdownInterface $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Returns plugin's method name
     *
     * @return string
     */
    public function getMethod()
    {
        return 'parse';
    }

    /**
     * Plugin handler
     *
     * @param  string $path
     * @return array
     */
    public function handle($path = '')
    {
        $file = $this->filesystem->getAdapter()->read($path);
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
        preg_match_all('#^[\t*\#@]*(.*):(.*)$#mi', $meta[1][0], $match);

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
        return MarkdownExtra::defaultTransform($content);
    }

}
