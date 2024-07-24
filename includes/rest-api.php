<?php

add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/client/', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'get_clients',
        'permission_callback' => function () {
            return true;
        }
    ));
});

function get_clients(WP_REST_Request $request) {
    $clients = [];
    $query = new WP_Query(array('post_type' => 'client', 'posts_per_page' => -1));
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $clients[] = array(
                'name' => get_post_meta(get_the_ID(), '_gcb_name', true),
                'lastName' => get_post_meta(get_the_ID(), '_gcb_lastName', true),
                'provincia' => get_post_meta(get_the_ID(), '_gcb_provincia', true),
                'url' => get_permalink()
            );
        }
    }
    wp_reset_postdata();
    return new WP_REST_Response($clients, 200);
}

