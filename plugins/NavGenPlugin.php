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
class NavGenPlugin implements \Zepto\PluginInterface {

    public function after_plugins_load(\Pimple $app)
    {
    }

    public function before_config_load(\Pimple $app, &$settings)
    {
    }

    public function before_router_setup(\Pimple $app)
    {
    }

    public function after_router_setup(\Pimple $app)
    {
        // Use this one
        $app = func_get_arg(0);
        $html = $this->generate_html($app);
        $app['nav'] = array('nav' => $html);
    }

    public function before_response_send(\Pimple $app)
    {
    }

    public function after_response_send(\Pimple $app)
    {
    }

    public function generate_html($app)
    {
        $settings        = $app['settings'];
        $content_loader  = $app['content_loader'];

        // Opening ``<ul>`` tag and adding class name
        $nav_html = sprintf('<ul class="%s">' . PHP_EOL, $settings['site']['nav']['class']);
        $files    = $content_loader->get_folder_contents();

        foreach ($files as $file) {
            $exploded_file_name = explode('/', $file);

            // Top-level links
            if (count($exploded_file_name) === 1) {
                $nav_html .= '<li>' . $app['helper']->link_for($file) . '</li>' . PHP_EOL;
                continue;
            }
        }

        $nav_html .= '</ul>' . PHP_EOL;
        return $nav_html;
    }

}
