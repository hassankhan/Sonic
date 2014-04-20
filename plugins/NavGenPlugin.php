<?php

/**
 * NavGen plugin
 *
 * Creates a lovely formatted nav object
 *
 * @author     Hassan Khan <contact@hassankhan.me>
 * @link       https://github.com/hassankhan/Zepto
 * @license    MIT
 * @since      0.6
 */
class NavGenPlugin extends \Sonic\PluginAbstract {

    public function after_plugins_load()
    {
    }

    public function before_config_load(&$settings)
    {
        $nav_settings = array(
            'site.nav.class'              => 'nav',
            'site.nav.dropdown_li_class'  => 'dropdown',
            'site.nav.dropdown_ul_class'  => 'dropdown-menu',
            'site.nav.dropdown_li_markup' => '<li class="%s"><a href="%s" class="dropdown-toggle" data-toggle="dropdown"> %s <b class="caret"></b></a><ul class="%s">'
        );
        $old_settings = $settings;
        $settings = array_merge($nav_settings, $old_settings);

    }

    public function before_router_setup()
    {
    }

    public function after_router_setup()
    {
        // Use this one
        $html         = $this->generate_html($this->zepto->app);

        if (isset($this->zepto->app['extra']) === TRUE) {
            $this->zepto->app['extra']['nav'] = $html;
        }
        else {
            $this->zepto->app['extra'] = array('nav' => $html);
        }
    }

    public function before_response_send()
    {
    }

    public function after_response_send()
    {
    }

    public function generate_html()
    {
        $settings   = $this->zepto->app['settings'];
        $filesystem = $this->zepto->app['filesystem'];

        // Opening ``<ul>`` tag and adding class name
        $nav_html   = sprintf('<ul class="%s">' . PHP_EOL, $settings['site.nav.class']);
        $files      = $filesystem->listContents($settings['zepto.content_dir'], true);

        $content_files = array_filter($files, function ($file) use ($settings) {
            return isset($file['extension']) === TRUE
                && in_array($file['extension'], $settings['zepto.content_ext']) === TRUE
                ? TRUE
                : FALSE;
        });

        foreach ($content_files as $file) {
            if ($file['dirname'] === 'content') {
                $nav_html .= '<li>' . $this->zepto->app['helper']->link_for($file['basename']) . '</li>' . PHP_EOL;
                continue;
            }
        }

        // Add subfolders here

        $nav_html .= '</ul>' . PHP_EOL;
        return $nav_html;
    }

}
