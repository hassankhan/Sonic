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
        $this->date_list = array();

        // Create empty variable
        $this->oldest_date = '';

        // Iterate through files and get dates
        foreach ($contents as $file) {
            if (
                isset($file['extension']) === TRUE
                && $file['extension'] === 'md'
            ) {
                $file_contents = $this->filesystem->parse($file['path']);
                $date = new \DateTime($file_contents['meta']['date']);
                $this->date_list[$file['path']] = $date;
            }
        }

        // Sort the files by date
        uasort($this->date_list, function ($a, $b) {
            if ($a === $b) {
                return 0;
            }
            return ($a > $b) ? -1 : 1;
        });

        return $this->date_list;
    }

}
