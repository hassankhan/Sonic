<?php

namespace Zepto\Route;

/**
 * ListRoute
 *
 * This route displays a list of posts
 *
 * @package    Zepto
 * @subpackage Route
 * @author     Hassan Khan <contact@hassankhan.me>
 * @link       https://github.com/hassankhan/hassankhan-me
 * @license    MIT
 * @since      0.7
 */
class ListRoute extends \Zepto\Route
{

    /**
     * Initializes the route by creating a regex pattern from the provided URL,
     * and assigns the callable function for this route
     *
     * @param string $url
     * @codeCoverageIgnore
     */
    public function __construct(
        $url = '',
        \League\Flysystem\FilesystemInterface $filesystem,
        \Twig_Environment $twig
    ) {
        $this->filesystem = $filesystem;
        $this->twig       = $twig;
        parent::__construct($url, array($this, 'build_route'));
    }

    /**
     * The route callback
     *
     * @return string
     */
    public function build_route()
    {
        // Get dates from all content
        $dates = $this->filesystem->dates('content');
        // Get filenames of content
        $files = array_keys($dates);
        // Create array to hold posts
        $posts = array();

        // Iterate through files and get excerpts for all of them
        foreach ($files as $file) {
            $file_contents = $this->filesystem->parse($file);
            $file_contents['contents'] = $this->get_file_excerpt($file_contents);
            $posts[str_replace('content/', '', $file)] = $file_contents;
        }

        return $this->twig->render('post-list.twig', array('contents' => $posts));
    }

    /**
     * Returns an excerpt of text from a file
     *
     * @param  array  $file_contents
     * @param  int    $br_limit
     * @return string
     */
    public function get_file_excerpt($file_contents, $br_limit = 3)
    {
        if (
            substr_count($file_contents['contents'], "\n") > $br_limit
            &&
            $file_contents['meta']['title'] !== 'Quote'
        ) {
            $excerpt = explode(PHP_EOL . PHP_EOL, $file_contents['contents'], $br_limit);
            array_pop($excerpt);
            return implode(' ', $excerpt);
        }
        return $file_contents['contents'];
    }

}
