<?php

namespace Zepto;

/**
 * TwigExtension
 *
 *
 * @package    Zepto
 * @subpackage ZeptoTwigExtension
 * @author     Hassan Khan <contact@hassankhan.me>
 * @link       http://https://github.com/hassankhan/Zepto
 * @license    MIT
 * @since      0.6
 */
class ZeptoTwigExtension extends \Twig_Extension
{
    /**
     * I don't even know why this is here, but it is, so deal with it
     *
     * @return string
     */
    public function getName()
    {
        return 'ZeptoTwigExtension';
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
            new \Twig_SimpleFunction('url_for',  array($this, 'url_for')),
            new \Twig_SimpleFunction('link_for', array($this, 'link_for'), array('is_safe' => array('html')))
        );
    }

    /**
     * Returns a fully-qualified URL for a given filename in the 'content' directory
     *
     * @see    Zepto\Helper::url_for()
     * @param  string $file_name
     * @return string|null
     */
    public function url_for($file_name)
    {
        $zepto = Zepto::instance();
        return $zepto->app['helper']->url_for($file_name);
    }

    /**
     * Returns a HTML <a> for a given filename in the 'content' directory
     *
     * @see    Zepto\Helper::link_for()
     * @param  string $file_name
     * @return string|null
     */
    public function link_for($file_name)
    {
        $zepto = Zepto::instance();
        return $zepto->app['helper']->link_for($file_name);
    }

}
