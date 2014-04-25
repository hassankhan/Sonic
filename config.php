<?php

$config = array(
    'sonic.environment'           => 'dev',
    'sonic.content_dir'           => 'content',
    'sonic.plugins_dir'           => 'plugins',
    'sonic.templates_dir'         => 'templates',
    'sonic.default_template'      => 'base.twig',
    'sonic.default_list_template' => 'list.twig',
    'sonic.content_ext'           => array('md', 'markdown'),
    'sonic.plugins_enabled'       => true,
    'site.site_root'              => 'http://sonic.dev/',
    'site.site_title'             => 'Sonic',
    'site.author'                 => 'Hassan Khan',
    'site.author_email'           => 'contact@hassankhan.me',
    'site.date_format'            => 'jS M Y',
    'site.excerpt_newline_limit'  => '5',
    'site.nav.class'              => 'nav',
    'site.nav.dropdown_li_class'  => 'dropdown',
    'site.nav.dropdown_ul_class'  => 'dropdown-menu',
    'site.nav.dropdown_li_markup' => '<li class="%s"><a href="%s" class="dropdown-toggle" data-toggle="dropdown"> %s <b class="caret"></b></a><ul class="%s">',
    'twig'                       => array(
        'charset'           => 'utf-8',
        'cache'             => 'cache/twig',
        'strict_variables'  => false,
        'autoescape'        => false,
        'auto_reload'       => true
    )
);

return $config;
