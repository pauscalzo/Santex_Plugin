<?php
/*
Plugin Name: Gutenberg Client Block
Description: A Gutenberg block to display a list of clients.
Version: 1.0
Author: Paula Scalzo
*/


if (!defined('ABSPATH')) {
    exit;
}

// includes files
require_once plugin_dir_path(__FILE__) . 'includes/custom-post-type.php';
require_once plugin_dir_path(__FILE__) . 'includes/meta-boxes.php';
require_once plugin_dir_path(__FILE__) . 'includes/rest-api.php';

// Enqueue scripts for Gutenberg block
function gcb_enqueue_block_editor_assets() {
    wp_enqueue_script(
        'gcb-block',
        plugins_url('assets/block.js', __FILE__),
        array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-api-fetch'),
        filemtime(plugin_dir_path(__FILE__) . 'assets/block.js')
    );

    wp_enqueue_style(
        'gcb-block-editor',
        plugins_url('assets/editor.css', __FILE__),
        array('wp-edit-blocks'),
        filemtime(plugin_dir_path(__FILE__) . 'assets/editor.css')
    );
}
add_action('enqueue_block_editor_assets', 'gcb_enqueue_block_editor_assets');

// Enqueue admin styles
function gcb_enqueue_admin_styles() {
    wp_enqueue_style(
        'gcb-admin-styles',
        plugins_url('assets/admin-styles.css', __FILE__),
        array(),
        filemtime(plugin_dir_path(__FILE__) . 'assets/admin-styles.css')
    );
}
add_action('admin_enqueue_scripts', 'gcb_enqueue_admin_styles');

// Enqueue frontend styles
function gcb_enqueue_frontend_styles() {
    wp_enqueue_style(
        'gcb-frontend-styles',
        plugins_url('assets/style.css', __FILE__),
        array(),
        filemtime(plugin_dir_path(__FILE__) . 'assets/style.css')
    );
}
add_action('wp_enqueue_scripts', 'gcb_enqueue_frontend_styles');

// template
function gcb_include_template_function($template_path) {
    if (get_post_type() == 'client') {
        if (is_single()) {
            if ($theme_file = locate_template(array('single-client.php'))) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path(__FILE__) . 'templates/single-client.php';
            }
        }
    }
    return $template_path;
}
add_filter('template_include', 'gcb_include_template_function', 1);


