<?php

namespace Sonic\Route;

/**
 * ListRoute
 *
 * This route displays a list of posts
 *
 * @package    Sonic
 * @subpackage Route
 * @author     Hassan Khan <contact@hassankhan.me>
 * @link       https://github.com/hassankhan/Sonic
 * @license    MIT
 * @since      0.7
 */
class ListRoute extends \Sonic\Route\ListRouteAbstract
{

    /**
     * Initializes the route by creating a regex pattern from the provided URL,
     * and assigns the callable function for this route
     *
     * @param string $url
     * @codeCoverageIgnore
     */
    public function __construct($url = '')
    {
        parent::__construct($url, array($this, 'build_route'));
    }

    /**
     * Method required by abstract class. Returns an array of posts
     * that match whatever requirements for this route.
     *
     * @return array
     */
    public function posts()
    {
        // Get dates from all content
        $dates = $this->dates('content');

        return $this->excerpts(array_keys($dates));
    }

    /**
     * Plugin handler
     *
     * @param  string $path
     * @return array
     */
    public function dates($path = '')
    {
        // Get all files in path
        $contents = $this->sonic->app['filesystem']->listContents($path, TRUE);
        // Create array
        $date_list = array();

        // Iterate through files and get dates
        foreach ($contents as $file) {
            if (
                isset($file['extension']) === TRUE
                && $file['extension'] === 'md'
            ) {
                $date_list[$file['path']] = $this->date($file);
            }
        }

        // Sort the files by date
        arsort($date_list);

        return $date_list;
    }

    /**
     * Gets a date from a file
     *
     * @param  string $file
     * @return \DateTime|NULL
     */
    protected function date($file)
    {
        $file_contents = $this->sonic->app['filesystem']->parse($file['path']);
        if (isset($file_contents['meta']['date']) === FALSE) {
            return NULL;
        }
        return new \DateTime($file_contents['meta']['date']);
    }

}
