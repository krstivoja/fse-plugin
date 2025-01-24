<?php
/*
Plugin Name: FSE Colors Marko
Description: Adds custom colors to your FSE theme.
Version: 1.0
Author: Your Name
*/

function filter_theme_json_theme($theme_json)
{
    $new_data = array(
        'version'  => 2,
        'settings' => array(
            'color' => array(
                'text'       => false,
                'palette'    => array( /* New palette */
                    array(
                        'slug'  => 'base',
                        'color' => 'white',
                        'name'  => __('Base', 'theme-domain'),
                    ),
                    array(
                        'slug'  => 'contrast',
                        'color' => 'black',
                        'name'  => __('Contrast', 'theme-domain'),
                    ),
                ),
            ),
        ),
    );

    return $theme_json->update_with($new_data);
}
add_filter('wp_theme_json_data_theme', 'filter_theme_json_theme');
