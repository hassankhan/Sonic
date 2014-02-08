<?php

namespace Zepto\FileLoader;

/**
 * PluginLoader
 *
 * @package    Zepto
 * @subpackage FileLoader
 * @author     Hassan Khan <contact@hassankhan.me>
 * @link       http://https://github.com/hassankhan/Zepto
 * @license    http://opensource.org/licenses/MIT
 * @since      0.2
 */
class PluginLoader extends \Zepto\FileLoader {

    /**
     * Loads in a single plugin or all plugins in a directory, depending on
     * whether a file or a directory is provided.
     *
     * @param  string $file_path
     * @return array
     */
    public function load($file_path)
    {
        // Create full path
        $full_path = $this->base_path . $file_path;

        // Create array to store loaded plugins
        $loaded_plugins = array();

        // Throw exception if $file_path is neither a file nor a directory
        if (!is_file($full_path) && !is_dir($full_path)) {
            throw new \UnexpectedValueException('There was an error trying to load ' . $full_path);
        }

        // Throw exception if plugin isn't named correctly
        if (preg_match_all('/^([A-Z]+\w+)Plugin.php$/', $file_path, $matches) === 0) {
            throw new \InvalidArgumentException("You didn't name the fucking plugin correctly. Should be MyPluginNamePlugin.php");
        }

        // Include plugin
        // @todo How to error handle here? Check for false and throw exception?
        include_once($full_path);

        // Get the plugin name
        $plugin_name = $matches[1][0] . 'Plugin';

        // Check class exists with that name
        if (class_exists($plugin_name) === FALSE) {
            throw new \RuntimeException('No such class exists');
        }

        // Get list of interfaces implemented by plugin
        $interfaces = class_implements($plugin_name);

        // Check if ``Zepto\PluginInterface`` is implemented, if not,
        // then throw an exception
        if (
            $interfaces === FALSE
            || isset($interfaces['Zepto\PluginInterface']) === FALSE
        ) {
            throw new \UnexpectedValueException('Plugin does not implement Zepto\PluginInterface');
        }

        return array($plugin_name => new $plugin_name);

    }

    /**
     * Loads a directory of plugins
     *
     * @param  string $dir_path
     * @return \Zepto\PluginInterface[]
     * @throws \UnexpectedValueException If a valid directory is not provided
     */
    public function load_dir($dir_path)
    {
        // Get full path
        $full_path = $this->base_path . $dir_path;

        // Create array to hold loaded plugins
        $loaded_plugins = array();

        // Check for valid directory
        if (!is_dir($full_path)) {
            throw new \UnexpectedValueException('There was an error trying to load ' . $full_path);
        }

        // Remove rubbish filenames
        $plugins = array_diff(
            scandir($full_path),
            array('.', '..', '.DS_Store', 'Thumbs.db')
        );

        // Call $this->load() for all plugins
        foreach ($plugins as $plugin) {
            try {
                $loaded_plugins = array_merge($loaded_plugins, $this->load($plugin));
            }
            catch (\Exception $e) {

            }
        }

        return $loaded_plugins;
    }

}
