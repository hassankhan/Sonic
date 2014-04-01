<?php

namespace Zepto\Route;

/**
 * AtomRoute
 *
 * This route is executed when an Atom feed is requested
 *
 * @package    Zepto
 * @subpackage Route
 * @author     Hassan Khan <contact@hassankhan.me>
 * @link       https://github.com/hassankhan/Zepto
 * @license    MIT
 * @since      0.7
 */
class AtomRoute extends \Zepto\Route\ListRoute implements \Zepto\RouteInterface
{

    /**
     * Initializes the route by creating a regex pattern from the provided URL,
     * and assigns the callable function for this route
     *
     * @param string $url
     * @param string $title
     * @param string $body
     * @codeCoverageIgnore
     */
    public function __construct($url = '')
    {
        parent::__construct($url, array($this, 'build_route'));
    }

    /**
     * Builds and returns the rendered HTML
     *
     * @return string
     */
    public function build_route()
    {
        // Get reference to Zepto
        $zepto = \Zepto\Zepto::instance();
        // Get dates from all content
        $dates = $zepto->app['filesystem']->dates('content');
        // Get filenames of content and create array to hold posts
        $posts = $this->get_excerpts(array_keys($dates));
        // Get today's date as a DateTime object
        $todays_date = new \DateTime();

        foreach ($posts as $path => $post) {

            // Try and get post date, otherwise use Unix Epoch date
            $post_date = isset($post['meta']['date']) === TRUE
                ? new \DateTime($post['meta']['date'])
                : new \DateTime('01-01-1970');

            $timestamp = $zepto->app['filesystem']->getTimestamp(
                $zepto->app['settings']['zepto.content_dir'] .'/' . $path
            );

            // Create additional fields for Atom stuff
            $posts[$path]['id']             = $this->make_id($zepto->app['helper']->url_for($path));
            $posts[$path]['published_date'] = $post_date->format(\DateTime::ATOM);
            $posts[$path]['modified_date']  = date('Y-m-d\TH:i:sP', $timestamp);
        }

        // Set response content-type
        $zepto->app['router']->response()->headers->set('Content-type', 'application/xml');

        // Render template with Twig
        return $zepto->app['twig']->render(
            'feed.twig',
            array(
                'date' => $todays_date->format(\DateTime::ATOM),
                'entries' => $posts
            )
        );
    }

    /**
     * Creates a ``tag:`` URI as per @diveintomark's article
     * @link   http://web.archive.org/web/20110514113830/http://diveintomark.org/archives/2004/05/28/howto-atom-id#tag
     * @param  string $url
     * @return string
     */
    public function make_id($url)
    {
        $tag             = str_replace(array('http://', 'https://'), '', $url);
        $tag             = str_replace('#', '/', $tag);
        $exploded_tag    = explode('/', $tag);
        $exploded_tag[0] = $exploded_tag[0] . ',' . date('Y-m-d') . ':';
        return implode('/', $exploded_tag);
    }

}
