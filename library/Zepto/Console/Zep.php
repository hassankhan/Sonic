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

    protected $is_zepto_dir;

    public function __construct($inputs, $path)
    {
        $this->filesystem   = new \League\Flysystem\Filesystem(new \League\Flysystem\Adapter\Local($path));
        $this->is_zepto_dir = $this->check_current_directory();
        set_error_handler(array('\Zepto\Helper', 'handleErrors'));
        parent::__construct($inputs);
    }

    public function init()
    {
        // Use Flysystem
        if ($this->is_zepto_dir === TRUE) {
            throw new Exception("You seem to have already run zep init. Stop wasting my time.");
        }

        if ($this->confirm("Are you sure you want to continue with folder creation?") === TRUE) {
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
    }

    public function new_plugin($name)
    {
        if ($this->is_zepto_dir === FALSE) {
            throw new \Exception("No plugins directory found, run zep init");
        }

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

    public function new_content($name)
    {
        if ($this->is_zepto_dir === FALSE) {
            throw new \Exception("No content directory found, run zep init");
        }

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
        $title      = ucfirst($this->prompt("Title:"));
        $desc       = $this->prompt("Description: (Optional)");
        $date       = (!$this->prompt("Date: (Leave empty for today's date)"))
            ? date("d m Y")
            : $date;

        $content    = sprintf($content_template, $title, $desc, $date);

        $this->filesystem->write($path, $content);
        $this->out("File created as " . $path);

    }

    /**
     * [check_current_directory description]
     * @return [type]       [description]
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
