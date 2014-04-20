<?php

namespace Sonic\Route;

/**
 * ErrorRoute
 *
 * This route is executed on any application error.
 *
 * @package    Sonic
 * @subpackage Route
 * @author     Hassan Khan <contact@hassankhan.me>
 * @link       https://github.com/hassankhan/Sonic
 * @license    MIT
 * @since      0.7
 */
class ErrorRoute extends \Sonic\Route
{

    /**
     * Error message title
     *
     * @var string
     */
    protected $title;

    /**
     * Error message body
     *
     * @var string
     */
    protected $body;

    /**
     * Initializes the route by creating a regex pattern from the provided URL,
     * and assigns the callable function for this route
     *
     * @param string $url
     * @param string $title
     * @param string $body
     * @codeCoverageIgnore
     */
    public function __construct($url = '', $title, $body)
    {
        $this->title = $title;
        $this->body  = $body;
        parent::__construct($url, array($this, 'build_route'));
    }

    /**
     * Builds and returns the rendered HTML
     *
     * @return string
     */
    public function build_route()
    {
        return sprintf('<html><head><title>%s</title><style>body{margin:0;padding:30px;font:12px/1.5 Helvetica,Arial,Verdana,sans-serif;}h1{margin:0;font-size:48px;font-weight:normal;line-height:48px;}strong{display:inline-block;width:65px;}</style></head><body><h1>%s</h1><p>%s</p></body></html>', $this->title, $this->title, $this->body);
    }

}
