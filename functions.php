<?php

function theme_register_scripts()
{
    wp_enqueue_style('pure-css', 'https://unpkg.com/purecss@1.0.0/build/pure-min.css');
    wp_enqueue_style('pure-grid', 'https://unpkg.com/purecss@1.0.0/build/grids-responsive-min.css',['pure-css']);
    wp_enqueue_style('wordcamp-theme-css', get_stylesheet_uri(), ['pure-grid']);

    wp_enqueue_script('vuejs', 'https://unpkg.com/vue/dist/vue.js');
    wp_enqueue_script('vuejs-loader', 'https://unpkg.com/http-vue-loader', ['vuejs']);
    wp_enqueue_script('vuejs-resource', 'https://cdn.jsdelivr.net/npm/vue-resource@1.5.1', ['vuejs']);
    wp_enqueue_script('vuejs-router', 'https://unpkg.com/vue-router/dist/vue-router.js', ['vuejs-resource']);

    wp_enqueue_script('wordcamp-theme-js', esc_url(trailingslashit(get_template_directory_uri()) . 'js/app.js'), ['vuejs-router'], '1.0', true);

    wp_localize_script('wordcamp-theme-js', 'wpRoutes',
        [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce("wp_nonce"),
            'api' => site_url('wp-json/wp/v2/'),
            'themeUri' => get_template_directory_uri(),
        ]
    );
}
add_action('wp_enqueue_scripts', 'theme_register_scripts', 1);

function register_custom_fields()
{
    $fields = array(
        ['name' => 'location', 'callback' => 'show_fields'],
        ['name' => 'time', 'callback' => 'show_fields'],
        ['name' => 'categories_extension', 'callback' => 'show_categories'],
        ['name' => 'featured_image', 'callback' => 'get_custom_thumbnail'],
    );

    foreach ($fields as $field) {
        if (function_exists($field['callback'])) {
            //post_type - field_name - callback_func
            register_rest_field('post', "{$field['name']}", ['get_callback' => "{$field['callback']}"]);
        }
    }
}

add_action('rest_api_init', 'register_custom_fields', 1, 1);

function show_categories($object, $field_name, $request)
{
    return get_the_category($object['id']);
}

function show_fields($object, $field_name, $request)
{
    return get_field($field_name, $object['id']);
}

function get_custom_thumbnail($object, $field_name, $request)
{
    $thumbnail_id = get_post_thumbnail_id($object['id']);
    return wp_get_attachment_image_src($thumbnail_id, 'full')[0];
}

/* Add post image support */
add_theme_support( 'post-thumbnails' );

/* Add menu support */
if (function_exists('add_theme_support')) {
    add_theme_support('menus');
}
