<?php

namespace Zepto\Flysystem\Plugin;

/**
 * Plugin
 *
 * @package    Zepto
 * @subpackage Flysystem
 * @author     Hassan Khan <contact@hassankhan.me>
 * @link       https://github.com/hassankhan/Zepto
 * @license    MIT
 * @since      0.7
 */
class Plugin implements \League\Flysystem\PluginInterface
{

    /**
     * Filesystem object
     *
     * @var \League\Flysystem\FilesystemInterface
     */
    protected $filesystem;

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
        return 'include';
    }

    /**
     * Plugin handler
     *
     * @param  string $path
     * @return \Zepto\PluginInterface
     */
    public function handle($path = '')
    {
        // Try and read the file
        $file = \League\Flysystem\Util::pathinfo($path);

        // Include plugin file
        include_once(getcwd() . '/' . $file['path']);

        // Check class implements correct interface
        $interfaces = class_implements($file['filename']);
        if (isset($interfaces['Zepto\PluginInterface']) === FALSE) {
            throw new \UnexpectedValueException('Plugin does not implement Zepto\PluginInterface');
        }

        return new $file['filename'];
    }

}
