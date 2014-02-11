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
    public function getName()
    {
        return 'Zepto\TwigExtension';
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('url_for', array($this, 'url_for'))
        );
    }

    public function url_for($file_name)
    {
        $zepto = Zepto::instance();
        return $zepto->url_for($file_name);
    }

}
