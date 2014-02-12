<?php

/**
 * NavGen plugin
 *
 * Creates a lovely formatted version of the
 *
 * @author Hassan Khan
 * @link http://https://github.com/hassankhan/Zepto
 * @license http://opensource.org/licenses/MIT
 * @version 0.6
 */

class NavGenPlugin implements \Zepto\PluginInterface {

    public function after_plugins_load()
    {
    }

    public function before_config_load(&$settings)
    {
    }

    public function before_router_setup()
    {
    }

    public function after_router_setup()
    {
        // Use this one
        $args = func_get_args();
        $html = $this->generate_html($arg[0]);
        $app['nav'] = $html;
    }

    public function before_response_send()
    {
    }

    public function after_response_send()
    {
    }

    public function generate_html($app)
    {
        $settings        = $app['settings'];
        $content_loader  = $app['content_loader'];

        // Opening ``<ul>`` tag and adding class name
        $nav_html     = sprintf('<ul class="%s">' . PHP_EOL, $settings['site']['nav']['class']);

        $structure    = $content_loader->get_folder_contents($settings['zepto']['content_dir']);

        // Remove 'index' along with any file extensions from URL
        // $filth = array_merge(array('index'), $settings['zepto']['content_ext']);

        foreach ($structure as $value) {

            // Check if ``$value`` is an array
            if (is_array($value)) {

                // Generate HTML for dropdown menu
                $dropdown_html = '<li class="%s">' . PHP_EOL
                   . '<a href="%s" class="dropdown-toggle" data-toggle="dropdown"> %s <b class="caret"></b></a>' . PHP_EOL
                   . '<ul class="%s">' . PHP_EOL;
                $nav_html .= sprintf($dropdown_html,
                    $settings['site']['nav']['dropdown_li_class'],
                    reset($value), // Reset to get first value from array
                    ucfirst($key), // Capitalise first letter of folder name
                    $settings['site']['nav']['dropdown_ul_class']
                );

                foreach ($value as $file_name) {

                    // Add folder name to file name
                    $full_file_name = $key . '/' . $file_name;

                    // Get title of content file
                    $title = $app['content'][$full_file_name]['meta']['title'];

                    // Create URL
                    $url = $settings['site']['site_root'] . str_replace($filth, '', $key . '/' . $file_name);

                    // Run ``ucfirst()`` on ``$key`` to make it look nice
                    $nav_html  .= sprintf('<li><a href="%s"> %s </a></li>' . PHP_EOL, $url, $title);
                }

                // Close dropdown menu HTML tags
                $nav_html .= '</ul></li>' . PHP_EOL;
            }
            // If not then add to ``$nav_items``
            else {
                if (preg_match('#^[4|5]0\d\.md$#i', $value) === 0) {

                    // Get title of content file
                    $title = $app['content'][$value]['meta']['title'];

                    // Create URL
                    $url = $settings['site']['site_root'] . str_replace($filth, '', $value);
                    $url = rtrim($url, '/') . '/';

                    $nav_html .= sprintf('<li><a href="%s"> %s </a></li>' . PHP_EOL, $url, $title);
                }
            }
        }

        // Close ``<ul>`` tag
        $nav_html .= '</ul>' . PHP_EOL;
        return $nav_html;
    }

}

?>
