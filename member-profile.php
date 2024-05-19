<?php
/*
Plugin Name: Member Profiles
Description: A plugin to manage and display member profiles.
Version: 1.0
Author: Alejandro Martinez
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Register custom post type 'profile'
function mp_register_profiles_post_type()
{
    $labels = array(
        'name' => __('Profiles', 'textdomain'),
        'singular_name' => __('Profile', 'textdomain'),
        // Add other labels as needed.
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'rewrite' => array('slug' => 'profiles'),
    );

    register_post_type('profile', $args);
}
add_action('init', 'mp_register_profiles_post_type');

// Enqueue styles
function mp_enqueue_styles()
{
    wp_enqueue_style('mp-styles', plugin_dir_url(__FILE__) . 'css/style.css');
}
add_action('wp_enqueue_scripts', 'mp_enqueue_styles');

// Load templates from plugin
function mp_template_redirect($template)
{
    if (is_post_type_archive('profile')) {
        $plugin_template = plugin_dir_path(__FILE__) . 'templates/index-profile.php';
        if (file_exists($plugin_template)) {
            return $plugin_template;
        }
    }

    if (is_singular('profile')) {
        $plugin_template = plugin_dir_path(__FILE__) . 'templates/single-profile.php';
        if (file_exists($plugin_template)) {
            return $plugin_template;
        }
    }

    return $template;
}
add_filter('template_include', 'mp_template_redirect');


function mp_add_meta_boxes() {
    add_meta_box('profile_meta_box', __('Profile Settings', 'textdomain'), 'mp_display_meta_box', 'profile', 'side', 'high');
}
add_action('add_meta_boxes', 'mp_add_meta_boxes');

// Display the meta box
function mp_display_meta_box($post) {
    $is_enabled = get_post_meta($post->ID, 'is_enabled', true);
    wp_nonce_field(basename(__FILE__), 'profile_nonce');
    ?>
    <p>
        <label for="is_enabled"><?php _e('Is Enabled:', 'textdomain'); ?></label>
        <select name="is_enabled" id="is_enabled">
            <option value="1" <?php selected($is_enabled, '1'); ?>><?php _e('Yes', 'textdomain'); ?></option>
            <option value="0" <?php selected($is_enabled, '0'); ?>><?php _e('No', 'textdomain'); ?></option>
        </select>
    </p>
    <?php
}

// Save the meta box data
function mp_save_meta_box_data($post_id) {
    if (!isset($_POST['profile_nonce']) || !wp_verify_nonce($_POST['profile_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    $new_is_enabled_value = (isset($_POST['is_enabled']) ? sanitize_text_field($_POST['is_enabled']) : '');
    update_post_meta($post_id, 'is_enabled', $new_is_enabled_value);
}
add_action('save_post', 'mp_save_meta_box_data');
