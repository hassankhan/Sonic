<?php

namespace Sonic\Route;

/**
 * TagRoute
 *
 * This route is executed when a ``/tag | /tags`` URL is matched
 *
 * @package    Sonic
 * @subpackage Route
 * @author     Hassan Khan <contact@hassankhan.me>
 * @link       https://github.com/hassankhan/Sonic
 * @license    MIT
 * @since      0.7
 */
class TagRoute extends \Sonic\Route\ListRoute
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
        // Get tag name
        $params   = func_get_args();
        $tag_name = $params[0];

        // Get all files in path
        $contents = $this->sonic->app['filesystem']->listContents('content', TRUE);

        // Create array to hold tagged files
        $tagged_files = array();

        // Get tagged files
        foreach ($contents as $file) {
            if (
                isset($file['extension']) === TRUE
                && $file['extension'] === 'md'
            ) {

                $file_contents = $this->sonic->app['filesystem']->read($file['path']);

                // Grab meta section between '/* ... */' in the content file
                preg_match_all('#/\*(.*?)\*/#s', $file_contents, $meta);

                // Find tag field
                preg_match_all('#^[\t*\#@]*(Tags):(.*)$#m', $meta[1][0], $matches);

                // Retrieve tags
                $tags = isset($matches[2][0]) === TRUE ? trim($matches[2][0], ' ') : NULL;

                // Replace ', ' with ',' and then explode
                $tags = explode(',', str_replace(', ', ',', $tags));

                if (in_array($tag_name, $tags)) {
                    $tagged_files[] = $file['path'];
                }
            }
        }

        return $this->excerpts($tagged_files);
    }

}
