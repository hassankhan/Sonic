<?php

$config = array(
    'zepto' => array(
        'environment'       => 'dev',
        'content_dir'       => 'content',
        'plugins_dir'       => 'plugins',
        'templates_dir'     => 'templates',
        'default_template'  => 'base.twig',
        'content_ext'       => array('.md', '.markdown'),
        'plugins_enabled'   => true
    ),
    'site' => array(
        'site_root'         => 'Site root URL goes here',
        'site_title'        => 'Zepto',
        'date_format'       => 'jS M Y',
        'excerpt_length'    => '50',
        'nav'               => array(
            'class'             => 'nav',
            'dropdown_li_class' => 'dropdown',
            'dropdown_ul_class' => 'dropdown-menu',
            'dropdown_li_markup' => '<li class="%s"><a href="%s" class="dropdown-toggle" data-toggle="dropdown"> %s <b class="caret"></b></a><ul class="%s">'
        )
    ),
    'twig' => array(
        'charset'           => 'utf-8',
        'cache'             => 'cache',
        'strict_variables'  => false,
        'autoescape'        => false,
        'auto_reload'       => true
    )
);

return $config;
