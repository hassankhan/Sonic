<?php

namespace Zepto;

/**
 * Helper
 *
 *
 * @package    Zepto
 * @subpackage Helper
 * @author     Hassan Khan <contact@hassankhan.me>
 * @link       http://https://github.com/hassankhan/Zepto
 * @license    MIT
 * @since      0.6
 */
class Helper
{
    public function __construct(\Pimple $app)
    {
        // Get app container
        $this->app = $app;
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
        } catch (\Exception $e) {
            $this->app['router']->error($e);
        }

        // If it doesn't then return null
        if (empty($content)) {
            return null;
        }

        // Create URL and return
        $clean_file_name = str_replace(
            $this->app['settings']['zepto']['content_ext'],
            '',
            $file_name
        );
        return $this->app['settings']['site']['site_root'] . $clean_file_name;
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
        } catch (\Exception $e) {
            $this->app['router']->error($e);
        }

        // If it doesn't then return null
        if (empty($content)) {
            return null;
        }

        // Get file title and URL and return
        $link = $content[$file_name]['meta']['title'];
        $url  = $this->url_for($file_name);
        return sprintf('<a href="%s">' . $link . "</a>", $url);
    }

}
