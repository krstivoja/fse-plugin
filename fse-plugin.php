<?php
/*
Plugin Name: FSE Plugin
Description: Adds custom colors to your FSE theme.
Version: 1.0
Author: Your Name
*/

function get_existing_colors()
{
    // Assuming theme.json is stored in the theme's root directory
    $file_path = get_template_directory() . '/theme.json';

    if (!file_exists($file_path)) {
        return [];
    }

    $theme_json = json_decode(file_get_contents($file_path), true);

    // Return existing palette colors
    return $theme_json['settings']['color']['palette'] ?? [];
}

function combine_theme_json_colors($theme_json)
{
    $new_colors = array(
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
        array(
            'slug'  => 'red',
            'color' => 'red',
            'name'  => __('Red', 'theme-domain'),
        ),
        array(
            'slug'  => 'olive',
            'color' => 'olive',
            'name'  => __('Olive', 'theme-domain'),
        ),
    );

    // Get existing colors
    $existing_colors = get_existing_colors();

    // Combine both arrays, ensuring no duplicate slugs
    $combined_colors = array_merge($existing_colors, array_filter($new_colors, function ($new_color) use ($existing_colors) {
        return !in_array($new_color['slug'], array_column($existing_colors, 'slug'));
    }));

    $new_data = array(
        'version'  => 2,
        'settings' => array(
            'color' => array(
                'palette' => $combined_colors,
            ),
        ),
    );

    return $theme_json->update_with($new_data);
}

add_filter('wp_theme_json_data_theme', 'combine_theme_json_colors');
