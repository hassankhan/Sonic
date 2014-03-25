<?php

namespace Zepto\Flysystem\Plugin;

/**
 * DateParser
 *
 * @package    Zepto
 * @subpackage Flysystem
 * @author     Hassan Khan <contact@hassankhan.me>
 * @link       https://github.com/hassankhan/Zepto
 * @license    MIT
 * @since      0.7
 */
class DateParser implements \League\Flysystem\PluginInterface
{

    /**
     * Filesystem object
     *
     * @var \League\Flysystem\FilesystemInterface
     */
    protected $filesystem;

    /**
     * Array of content paths as keys and their dates as values
     *
     * @var array
     */
    protected $date_list;

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
        return 'dates';
    }

    /**
     * Plugin handler
     *
     * @param  string $path
     * @return array
     */
    public function handle($path = '')
    {
        // Get all files in path
        $contents = $this->filesystem->listContents($path, TRUE);
        // Create array
        $this->date_list = array();

        // Iterate through files and get dates
        foreach ($contents as $file) {
            if (
                isset($file['extension']) === TRUE
                && $file['extension'] === 'md'
            ) {
                $this->date_list[$file['path']] = $this->get_date($file);
            }
        }

        // Sort the files by date
        arsort($this->date_list);

        return $this->date_list;
    }

    public function get_date($file)
    {
        $file_contents = $this->filesystem->parse($file['path']);
        if (isset($file_contents['meta']['date']) === FALSE) {
            return NULL;
        }
        return new \DateTime($file_contents['meta']['date']);
    }

}
