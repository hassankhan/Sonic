<?php

namespace Sonic\Extension;

/**
 * Twig
 *
 * @package    Sonic
 * @subpackage Extension
 * @author     Hassan Khan <contact@hassankhan.me>
 * @link       https://github.com/hassankhan/Sonic
 * @license    MIT
 * @since      0.6
 */
class Twig extends \Twig_Extension
{
    /**
     * I don't even know why this is here, but it is, so deal with it
     *
     * @return string
     */
    public function getName()
    {
        return 'Twig';
    }

    /**
     * So apparently you have to explicitly return the functions you want
     * to be available
     *
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('config',     array($this, 'config')),
            new \Twig_SimpleFunction('site_url',   array($this, 'site_url')),
            new \Twig_SimpleFunction('site_title', array($this, 'site_title')),
            new \Twig_SimpleFunction('url_for',    array($this, 'url_for')),
            new \Twig_SimpleFunction('link_for',   array($this, 'link_for'), array('is_safe' => array('html')))
        );
    }

    /**
     * Returns Sonic configuration
     *
     * @return array
     * @codeCoverageIgnore
     */
    public function config($option)
    {
        $zepto = \Sonic\Sonic::instance();
        return $zepto->app['settings'][$option];
    }

    /**
     * Returns the site root
     *
     * @return string
     * @codeCoverageIgnore
     */
    public function site_url()
    {
        $zepto = \Sonic\Sonic::instance();
        return $zepto->app['settings']['site.site_root'];
    }

    /**
     * Returns the site title
     *
     * @return string
     * @codeCoverageIgnore
     */
    public function site_title()
    {
        $zepto = \Sonic\Sonic::instance();
        return $zepto->app['settings']['site.site_title'];
    }

    /**
     * Returns a fully-qualified URL for a given filename in the 'content' directory
     *
     * @see    \Sonic\Helper::url_for()
     * @param  string $file_name
     * @return string|null
     * @codeCoverageIgnore
     */
    public function url_for($file_name)
    {
        $zepto = \Sonic\Sonic::instance();
        return $zepto->app['helper']->url_for($file_name);
    }

    /**
     * Returns a HTML <a> for a given filename in the 'content' directory
     *
     * @see    \Sonic\Helper::link_for()
     * @param  string $file_name
     * @return string|null
     * @codeCoverageIgnore
     */
    public function link_for($file_name)
    {
        $zepto = \Sonic\Sonic::instance();
        return $zepto->app['helper']->link_for($file_name);
    }

}
