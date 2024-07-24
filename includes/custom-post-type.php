<?php

// Clients Custom Post Type 
function gcb_register_custom_post_type() {
    $labels = array(
        'name'               => 'Clients',
        'singular_name'      => 'Client',
        'menu_name'          => 'Clients',
        'name_admin_bar'     => 'Client',
        'add_new'            => 'Add new',
        'add_new_item'       => 'Add new Client',
        'new_item'           => 'New Client',
        'edit_item'          => 'Edit Client',
        'view_item'          => 'View Client',
        'all_items'          => 'All Clients',
        'search_items'       => 'Search Clients',
        'not_found'          => 'There are not Clients',
        'not_found_in_trash' => 'There are not Clients in trash'
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'clients'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title', 'editor', 'custom-fields'),
    );

    register_post_type('client', $args);
}
add_action('init', 'gcb_register_custom_post_type');
