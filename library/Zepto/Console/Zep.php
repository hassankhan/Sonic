<?php

namespace Zepto\Console;

use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;

/**
 * Zep Console class
 *
 * Adds Zepto-specific methods and functionality, rather than having it all in
 * the executable file
 *
 *
 * <code>
 * use Zepto\Console\Zep as Console;
 *
 * $zep = new Console($argv);
 * </code>
 *
 * @package    Zepto
 * @subpackage Console
 * @author     Hassan Khan <contact@hassankhan.me>
 * @link       https://github.com/hassankhan/Zepto
 * @license    MIT
 * @since      0.7
 */
class Zep extends \Zepto\Console
{
    /**
     * Instance of Flysystem
     *
     * @var \League\Flysystem\FilesystemInterface
     */
    protected $filesystem;

    /**
     * Constructs the Zep console object
     *
     * @param string $inputs
     * @param string $path
     * @codeCoverageIgnore
     */
    public function __construct($inputs, $path)
    {
        $this->filesystem   = new \League\Flysystem\Filesystem(new \League\Flysystem\Adapter\Local($path));
        $this->is_zepto_dir = $this->check_current_directory();
        set_error_handler(array('\Zepto\Helper', 'handleErrors'));
        parent::__construct($inputs);
    }

    /**
     * Handles the ``init`` option
     *
     * @return
     */
    public function init()
    {
        $this->out("Creating folders in current directory...");

        $this->filesystem->createDir('plugins');
        $this->filesystem->createDir('content');
        $this->filesystem->createDir('templates');

        // $lib_path = realpath(__DIR__ . "/..");
        // file_put_contents($cwd . "/index.php",  file_get_contents($lib_path . "/index.php"));
        // file_put_contents($cwd . "/.htaccess",  file_get_contents($lib_path . "/.htaccess"));
        // file_put_contents($cwd . "/config.php", file_get_contents($lib_path . "/config.php"));

        $this->out("All done, enjoy" . PHP_EOL);
    }

    /**
     * Handles the ``new -p`` option
     *
     * @param  string $name
     * @return
     */
    public function new_plugin($name)
    {
        $template_plugin = <<<PLUGIN
<?php

class %sPlugin implements \Zepto\PluginInterface {

    public function after_plugins_load(\Pimple \$app)
    {

    }

    public function before_config_load(\Pimple \$app, &\$settings)
    {

    }

    public function before_router_setup(\Pimple \$app)
    {

    }

    public function after_router_setup(\Pimple \$app)
    {

    }

    public function before_response_send(\Pimple \$app)
    {

    }

    public function after_response_send(\Pimple \$app)
    {

    }

}

PLUGIN;

        // Ask for name, format it so only the first character is uppercase
        // and add it to the plugin template
        $fixed_name = ucfirst(strtolower($name));
        $path       = 'plugins/' . $name . 'Plugin.php';
        $plugin     = sprintf($template_plugin, $fixed_name);

        // Write plugin to folder
        @$this->filesystem->write($path, $plugin);
        $this->out("File created as " . $path);
    }

    /**
     * Handles the ``new -c`` option
     *
     * @param  string $name
     * @return
     */
    public function new_content($name, $title = '', $desc = '', $date = '')
    {
        $content_template = <<<MARKDOWN
/*
Title: %s
Description: %s
Date: %s
*/

## Add your content here

MARKDOWN;

        // Ask for name and add it to the content template
        $fixed_name = strtolower($name);
        $path       = 'content/' . $fixed_name . '.md';
        $title      = ucfirst($title);
        $date       = (empty($date)) === TRUE
            ? date("d m Y")
            : $date;

        $content    = sprintf($content_template, $title, $desc, $date);

        $this->filesystem->write($path, $content);
        $this->out("File created as " . $path);

    }

    /**
     * Checks to see if current directory has a plugins and content folder
     *
     * @return bool
     */
    public function check_current_directory()
    {
        if (
            $this->filesystem->has('plugins')
            &&
            $this->filesystem->has('content')
        ){
            return TRUE;
        }
        return FALSE;
    }

}
