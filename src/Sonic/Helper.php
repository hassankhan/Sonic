<?php

namespace Sonic;

/**
 * Helper class to hold all helper-y functions
 *
 *
 * @package    Sonic
 * @author     Hassan Khan <contact@hassankhan.me>
 * @link       https://github.com/hassankhan/Sonic
 * @license    MIT
 * @since      0.6
 */
class Helper
{
    /**
     * Instance of Sonic's container
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

        // Convert errors to exceptions
        set_error_handler(array($this, 'handle_errors'));
    }

    /**
     * Returns Sonic configuration option
     *
     * @return array
     */
    public function config($option)
    {
        return isset($this->app['settings'][$option]) === TRUE
            ? $this->app['settings'][$option]
            : NULL;
    }

    /**
     * Returns the site root
     *
     * @return string
     */
    public function site_url()
    {
        return $this->app['settings']['site.site_root'];
    }

    /**
     * Returns the site title
     *
     * @return string
     */
    public function site_title()
    {
        return $this->app['settings']['site.site_title'];
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

            // Try to read file, if none exists then return null
            $this->app['filesystem']->read($this->app['settings']['sonic.content_dir'] . '/' . $file_name);

            // Create URL and return
            $clean_file_name = str_replace(
                array_merge(array('index'), $this->dot_extensions()),
                '',
                $file_name
            );

            return trim($this->app['settings']['site.site_root'] . $clean_file_name, '/') . '/';
        }
        catch (\Exception $e) {
            $this->app['router']->error($e);
        }
        return null;
    }

    /**
     * Returns a HTML <a> for a given filename in the 'content' directory
     *
     * @param  string      $file_name
     * @return string|null
     */
    public function link_for($file_name)
    {
        try {
            // Check if file exists
            $content = $this->app['filesystem']->parse($this->app['settings']['sonic.content_dir'] . '/' . $file_name);

            // Get file title and URL and return
            $title   = $content['meta']['title'];
            $url     = $this->url_for($file_name);
            return sprintf('<a href="%s"> ' . $title . ' </a>', $url);
        }
        catch (\Exception $e) {
            $this->app['router']->error($e);
        }
        return null;
    }

    /**
     * Returns a standard configuration for Sonic
     *
     * @return array
     * @static
     */
    public static function default_config()
    {
        return array(
            'sonic.environment'           => 'dev',
            'sonic.content_dir'           => 'content',
            'sonic.plugins_dir'           => 'plugins',
            'sonic.templates_dir'         => 'templates',
            'sonic.default_template'      => 'base.twig',
            'sonic.default_list_template' => 'list.twig',
            'sonic.content_ext'           => array('md', 'markdown'),
            'sonic.plugins_enabled'       => false,
            'site.site_root'              => 'http://localhost:8888/zepto/',
            'site.site_title'             => 'Sonic',
            'site.author'                 => '',
            'site.author_email'           => '',
            'site.date_format'            => 'jS M Y',
            'site.excerpt_newline_limit'  => '5',
            'twig'                        => array(
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
     * @throws InvalidArgumentException If a setting is invalid
     * @static
     */
    public static function validate_config($config)
    {
        $message = '';

        while ($message === '') {
            if (!is_dir($config['sonic.content_dir'])) {
                $message = 'Content directory does not exist';
                break;
            }

            if (!is_dir($config['sonic.plugins_dir'])) {
                $message = 'Plugins directory does not exist';
                break;
            }

            if (!is_dir($config['sonic.templates_dir'])) {
                $message = 'Templates directory does not exist';
                break;
            }

            if (
                !is_file("{$config['sonic.templates_dir']}/{$config['sonic.default_template']}")
            ) {
                $message = 'No default template exists';
            break;
            }

            if ($config['sonic.environment'] !== 'dev') {
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
     * Returns an excerpt of a string by breaking at new lines
     *
     * @param  array  $text
     * @param  int    $br_limit
     * @return string
     */
    public static function get_excerpt($text, $br_limit = 3)
    {
        if (substr_count($text, PHP_EOL) > $br_limit) {
            $excerpt = explode(PHP_EOL, $text, ++$br_limit);
            array_pop($excerpt);
            return implode(' ', $excerpt);
        }
        return $text;
    }

    /**
     * Convert errors into ErrorException objects
     *
     * @param  int            $err_no
     * @param  string         $err_str
     * @param  string         $err_file
     * @param  int            $err_line
     * @return bool
     * @throws \ErrorException
     */
    public static function handle_errors($err_no, $err_str = '', $err_file = '', $err_line = '')
    {
        if (!($err_no & error_reporting())) {
            return;
        }
        throw new \ErrorException($err_str, $err_no, 0, $err_file, $err_line);
    }

    /**
     * Adds a '.' to each extension given
     *
     * @return array
     */
    private function dot_extensions()
    {
        $extensions = $this->app['settings']['sonic.content_ext'];

        foreach ($extensions as $extension) {
            $dotted_extensions[] = '.' . $extension;
        }

        return $dotted_extensions;
    }

}
