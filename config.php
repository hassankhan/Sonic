<?php

$config = array(
    'zepto.environment'           => 'dev',
    'zepto.content_dir'           => 'content',
    'zepto.plugins_dir'           => 'plugins',
    'zepto.templates_dir'         => 'templates',
    'zepto.default_template'      => 'base.twig',
    'zepto.default_list_template' => 'list.twig',
    'zepto.content_ext'           => array('md', 'markdown'),
    'zepto.plugins_enabled'       => true,
    'site.site_root'              => 'http://localhost:8888/zepto/',
    'site.site_title'             => 'Zepto',
    'site.date_format'            => 'jS M Y',
    'site.excerpt_newline_limit'  => '5',
    'site.nav.class'              => 'nav',
    'site.nav.dropdown_li_class'  => 'dropdown',
    'site.nav.dropdown_ul_class'  => 'dropdown-menu',
    'site.nav.dropdown_li_markup' => '<li class="%s"><a href="%s" class="dropdown-toggle" data-toggle="dropdown"> %s <b class="caret"></b></a><ul class="%s">',
    'twig'                       => array(
        'charset'           => 'utf-8',
        'cache'             => 'cache',
        'strict_variables'  => false,
        'autoescape'        => false,
        'auto_reload'       => true
    )
);

return $config;
