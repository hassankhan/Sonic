<?php

namespace Sonic\Flysystem\Plugin;

/**
 * Plugin
 *
 * @package    Sonic
 * @subpackage Flysystem
 * @author     Hassan Khan <contact@hassankhan.me>
 * @link       https://github.com/hassankhan/Sonic
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
     * @return \Sonic\PluginInterface
     */
    public function handle($path = '')
    {
        // Try and read the file
        $file = \League\Flysystem\Util::pathinfo($path);

        // Include plugin file
        include_once(getcwd() . '/' . $file['path']);

        // Check class implements correct interface
        $parents = class_parents($file['filename']);
        if (isset($parents['Sonic\PluginAbstract']) === FALSE) {
            throw new \UnexpectedValueException('Plugin does not implement Sonic\PluginAbstract');
        }

        return new $file['filename'];
    }

}
