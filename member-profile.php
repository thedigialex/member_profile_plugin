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

add_action('init', 'mp_register_profiles_post_type');
add_action('wp_enqueue_scripts', 'mp_enqueue_assets');
add_action('add_meta_boxes', 'mp_add_meta_boxes');
add_action('save_post', 'mp_save_meta_box_data');
add_action('save_post', 'mp_save_gallery_meta_box_data');
add_shortcode('mp_profiles', 'mp_profiles_shortcode');
add_filter('template_include', 'mp_template_redirect');

function mp_register_profiles_post_type() {
    $labels = [
        'name'          => __('Profiles', 'textdomain'),
        'singular_name' => __('Profile', 'textdomain')
    ];

    $args = [
        'labels'       => $labels,
        'public'       => true,
        'has_archive'  => true,
        'supports'     => ['title', 'editor', 'thumbnail'],
        'rewrite'      => ['slug' => 'profiles']
    ];

    register_post_type('profile', $args);
}

function mp_enqueue_assets() {
    wp_enqueue_style('mp-styles', plugin_dir_url(__FILE__) . 'css/style.css');
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css', [], '6.0.0-beta3');
}

function mp_template_redirect($template) {
    if (is_post_type_archive('profile') || is_singular('profile')) {
        $plugin_template = plugin_dir_path(__FILE__) . "templates/single-profile.php";
        if (file_exists($plugin_template)) {
            return $plugin_template;
        }
    }
    return $template;
}

function mp_add_meta_boxes() {
    add_meta_box('profile_meta_box', __('Profile Settings', 'textdomain'), 'mp_display_meta_box', 'profile', 'side', 'high');
    add_meta_box('profile_gallery_meta_box', __('Profile Gallery', 'textdomain'), 'mp_display_gallery_meta_box', 'profile', 'normal', 'high');
}

function mp_display_meta_box($post) {
    $is_featured = get_post_meta($post->ID, 'is_featured', true);
    $sub_heading = get_post_meta($post->ID, 'sub_heading', true);
    wp_nonce_field(basename(__FILE__), 'profile_nonce');
    include 'templates/meta-box-profile-settings.php';  // Externalize HTML to a template file for clarity
}

function mp_save_meta_box_data($post_id) {
    if (!isset($_POST['profile_nonce']) || !wp_verify_nonce($_POST['profile_nonce'], basename(__FILE__)) || wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) {
        return $post_id;
    }

    update_post_meta($post_id, 'is_featured', sanitize_text_field($_POST['is_featured'] ?? ''));
    update_post_meta($post_id, 'sub_heading', sanitize_text_field($_POST['sub_heading'] ?? ''));
}

function mp_display_gallery_meta_box($post) {
    wp_enqueue_media();
    $gallery = get_post_meta($post->ID, 'profile_gallery', true);
    include 'templates/meta-box-profile-gallery.php'; 
}

function mp_save_gallery_meta_box_data($post_id) {
    if (!isset($_POST['profile_nonce']) || !wp_verify_nonce($_POST['profile_nonce'], basename(__FILE__))) {
        return;
    }
    update_post_meta($post_id, 'profile_gallery', array_filter(explode(',', sanitize_text_field($_POST['profile_gallery'] ?? ''))));
}

function mp_profiles_shortcode($atts) {
    ob_start();
    include 'templates/profiles-display.php';
    return ob_get_clean();
}
