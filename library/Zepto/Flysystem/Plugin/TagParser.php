<?php

namespace Zepto\Flysystem\Plugin;

/**
 * TagParser
 *
 * @package    Zepto
 * @subpackage Flysystem
 * @author     Hassan Khan <contact@hassankhan.me>
 * @link       https://github.com/hassankhan/Zepto
 * @license    MIT
 * @since      0.7
 */
class TagParser implements \League\Flysystem\PluginInterface
{

    /**
     * Filesystem object
     *
     * @var \League\Flysystem\FilesystemInterface
     */
    protected $filesystem;

    /**
     * Array of tags pointing to the tagged posts
     *
     * @var array
     */
    protected $tag_list;

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
     * Returns plugin's method name
     *
     * @return string
     */
    public function getMethod()
    {
        return 'tags';
    }

    /**
     * Plugin handler
     *
     * @param  string $path
     * @return \Zepto\PluginInterface
     */
    public function handle($path = '')
    {
        // Get all files in path
        $contents = $this->filesystem->listContents($path, TRUE);
        // var_dump($contents);die();
        $this->tag_list = array();

        foreach ($contents as $file) {
            if (
                isset($file['extension']) === TRUE
                && $file['extension'] === 'md'
            ) {

                $file_contents = $this->filesystem->read($file['path']);

                // Grab meta section between '/* ... */' in the content file
                preg_match_all('#/\*(.*?)\*/#s', $file_contents, $meta);

                // Retrieve individual meta fields
                preg_match_all('#^[\t*\#@]*(Tags):(.*)$#m', $meta[1][0], $matches);

                $tags = isset($matches[2][0]) === TRUE ? trim($matches[2][0], ' ') : NULL;
                // @todo Make this work for ',' or ', '
                $tags = explode(',', $tags);


                // Add tags to tag list
                foreach ($tags as $tag) {
                    $this->add_tag($tag, $file['path']);
                }
            }
        }
        return $this->tag_list;
    }

    /**
     * Adds a tag to the tag list
     *
     * @param string $tag
     * @param string $filename
     */
    public function add_tag($tag, $filename)
    {
        // If tag is empty, return without doing anything
        if (empty($tag)) {
            return FALSE;
        }

        // If this is a new tag, then add it to the tag list
        if (isset($this->tag_list[$tag]) === FALSE) {
            $this->tag_list[$tag] = array($filename);
            return TRUE;
        }

        // Otherwise add to existing tag list
        array_push($this->tag_list[$tag], $filename);
        return TRUE;
    }

}
