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
abstract class ListRouteAbstract extends \Sonic\Route
{

    abstract public function posts();

    protected $sonic;

    /**
     * Initializes the route by creating a regex pattern from the provided URL,
     * and assigns the callable function for this route
     *
     * @param string $url
     * @codeCoverageIgnore
     */
    public function __construct($url = '')
    {
        // Get reference to Sonic application
        $this->sonic = \Sonic\Sonic::instance();
        parent::__construct($url, array($this, 'build_route'));
    }

    /**
     * Builds and returns the rendered HTML
     *
     * @return string
     */
    public function build_route($param = '')
    {
        // Get filenames of content and create array to hold posts
        $posts = $this->posts($param);

        // Load in any extra stuffs
        $this->sonic->app['extra'] = isset($this->sonic->app['extra']) === TRUE ? $this->sonic->app['extra'] : array();

        // Render template with Twig
        return $this->sonic->app['twig']->render($this->sonic->app['settings']['zepto.default_list_template'], array('contents' => $posts));
    }

    /**
     * Gets file excerpts from all files
     *
     * @param  array $files
     * @return array
     */
    public function excerpts($files)
    {
        // Create array to hold posts
        $posts = array();

        // Iterate through files and get excerpts for all of them
        foreach ($files as $file) {
            $file_contents = $this->sonic->app['filesystem']->parse($file);

            if (
                $file_contents['meta']['title'] !== 'Quote'
                &&
                $this->sonic->app['settings']['site.excerpt_newline_limit'] !== 0
            ) {
                $contents  = $this->sonic->app['helper']->get_excerpt(
                    $file_contents['contents'],
                    $this->sonic->app['settings']['site.excerpt_newline_limit']
                );

                $file_contents['contents'] = $contents;
            }
            $posts[str_replace('content/', '', $file)] = $file_contents;
        }

        return $posts;
    }

}
