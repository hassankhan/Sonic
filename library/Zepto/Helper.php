<?php

namespace Zepto;

/**
 * Helper class to hold all helper-y functions
 *
 *
 * @package    Zepto
 * @subpackage Helper
 * @author     Hassan Khan <contact@hassankhan.me>
 * @link       https://github.com/hassankhan/Zepto
 * @license    MIT
 * @since      0.6
 */
class Helper
{
    /**
     * Instance of Zepto's container
     *
     * @var \Pimple
     */
    protected $app;

    /**
     * Constructor
     *
     * @param \Pimple $app
     * @codeCoverageIgnore
     */
    public function __construct(\Pimple $app)
    {
        // Get app container
        $this->app = $app;
    }


    /**
     * Returns a standard configuration for Zepto
     *
     * @return array
     * @static
     */
    public static function default_config()
    {
        return array(
            'zepto.environment'       => 'dev',
            'zepto.content_dir'       => 'content',
            'zepto.plugins_dir'       => 'plugins',
            'zepto.templates_dir'     => 'templates',
            'zepto.default_template'  => 'base.twig',
            'zepto.content_ext'       => array('.md', '.markdown'),
            'zepto.plugins_enabled'   => false,
            'site.site_root'          => 'http://localhost:8888/zepto/',
            'site.site_title'         => 'Zepto',
            'site.date_format'        => 'jS M Y',
            'site.excerpt_length'     => '50',
            'twig'                    => array(
                'charset'           => 'utf-8',
                'cache'             => 'cache',
                'strict_variables'  => false,
                'autoescape'        => false,
                'auto_reload'       => true
            )
        );
    }

    /**
     * Validates a configuration array
     *
     * @param  array   $config
     * @return boolean
     * @static
     */
    public static function validate_config($config)
    {
        $message = '';

        while ($message === '') {
            if (!is_dir($config['zepto.content_dir'])) {
                $message = 'Content directory does not exist';
                break;
            }

            if (!is_dir($config['zepto.plugins_dir'])) {
                $message = 'Plugins directory does not exist';
                break;
            }

            if (!is_dir($config['zepto.templates_dir'])) {
                $message = 'Templates directory does not exist';
                break;
            }

            if (
                !is_file("{$config['zepto.templates_dir']}/{$config['zepto.default_template']}")
            ) {
                $message = 'No default template exists';
            break;
            }

            if ($config['zepto.environment'] !== 'dev') {
                preg_match('#^(https?://)?([\da-z\.-]+)\.([a-z\.]{2,6})([/\w \.-]*)*/+$#', $config['site.site_root']) === 0
                    ? $message = 'Site root is invalid. Should be like http://www.example.com/'
                    : $message = '';
            }
            break;
        }

        if ($message === '') {
            return TRUE;
        }
        else {
            throw new \InvalidArgumentException($message);
        }

    }

    /**
     * Returns a fully-qualified URL for a given filename in the 'content' directory
     *
     * @param  string $file_name
     * @return string|null
     */
    public function url_for($file_name)
    {
        // Check if file exists
        try {
            $content = $this->app['content_loader']->load($file_name);
            if(is_null($content) === FALSE) {
                // Create URL and return
                $clean_file_name = str_replace(
                    array_merge(array('index'), $this->app['settings']['zepto.content_ext']),
                    '',
                    $file_name
                );
                return trim($this->app['settings']['site.site_root'] . $clean_file_name, '/') . '/';
            }
        }
        catch (\Exception $e) {
            $this->app['router']->error($e);
        }
        return null;
    }

    /**
     * Returns a HTML <a> for a given filename in the 'content' directory
     *
     * @param  string $file_name
     * @return string|null
     */
    public function link_for($file_name)
    {
        // Check if file exists
        try {
            $content = $this->app['content_loader']->load($file_name);

            // Get file title and URL and return
            $link = $content[$file_name]['meta']['title'];
            $url  = $this->url_for($file_name);
            return sprintf('<a href="%s"> ' . $link . ' </a>', $url);
        }
        catch (\Exception $e) {
            $this->app['router']->error($e);
        }
        return null;
    }

}
