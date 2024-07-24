<?php

// Remove the default custom fields meta box
function gcb_remove_custom_fields_meta_box() {
    remove_meta_box('postcustom', 'client', 'normal');
}
add_action('admin_menu', 'gcb_remove_custom_fields_meta_box');

// Add Meta Boxes
function gcb_add_custom_meta_boxes() {
    add_meta_box(
        'gcb_client_meta_box',
        'Client Info',
        'gcb_render_client_meta_box',
        'client',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'gcb_add_custom_meta_boxes');

// Render Meta Boxes
function gcb_render_client_meta_box($post) {
    wp_nonce_field(basename(__FILE__), 'gcb_client_nonce');
    $name = get_post_meta($post->ID, '_gcb_name', true);
    $lastName = get_post_meta($post->ID, '_gcb_lastName', true);
    $provincia = get_post_meta($post->ID, '_gcb_provincia', true);

    echo '<div id="meta-box-client-info">';
    
    echo '<div>';
    echo '<label for="gcb_name">Name</label>';
    echo '<input type="text" id="gcb_name" name="gcb_name" value="' . esc_attr($name) . '" />';
    echo '</div>';
    
    echo '<div>';
    echo '<label for="gcb_lastName">Last Name</label>';
    echo '<input type="text" id="gcb_lastName" name="gcb_lastName" value="' . esc_attr($lastName) . '" />';
    echo '</div>';
    
    echo '<div>';
    echo '<label for="gcb_provincia">Provincia</label>';
    echo '<select id="gcb_provincia" name="gcb_provincia">';
    $provincias = gcb_get_provincias();
    foreach ($provincias as $prov) {
        echo '<option value="' . esc_attr($prov->nombre) . '" ' . selected($prov->nombre, $provincia, false) . '>' . esc_html($prov->nombre) . '</option>';
    }
    echo '</select>';
    echo '</div>';
    
    echo '</div>';
}



// Save Meta Boxes
function gcb_save_client_meta($post_id) {
    if (!isset($_POST['gcb_client_nonce']) || !wp_verify_nonce($_POST['gcb_client_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    $name = sanitize_text_field($_POST['gcb_name']);
    $lastName = sanitize_text_field($_POST['gcb_lastName']);
    $provincia = sanitize_text_field($_POST['gcb_provincia']);

    update_post_meta($post_id, '_gcb_name', $name);
    update_post_meta($post_id, '_gcb_lastName', $lastName);
    update_post_meta($post_id, '_gcb_provincia', $provincia);
}
add_action('save_post', 'gcb_save_client_meta');

// Provincias from the API
function gcb_get_provincias() {
    $response = wp_remote_get('https://apis.datos.gob.ar/georef/api/provincias');
    if (is_wp_error($response)) {
        return [];
    }
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body);
    return isset($data->provincias) ? $data->provincias : [];
}
