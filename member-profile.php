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
        'name'          => __('Profiles', 'textdomain'),
        'singular_name' => __('Profile', 'textdomain')
    );

    $args = array(
        'labels'       => $labels,
        'public'       => true,
        'has_archive'  => true,
        'supports'     => array('title', 'editor', 'thumbnail'),
        'rewrite'      => array('slug' => 'profiles')
    );

    register_post_type('profile', $args);
}
add_action('init', 'mp_register_profiles_post_type');

// Enqueue styles and scripts
function mp_enqueue_assets()
{
    wp_enqueue_style('mp-styles', plugin_dir_url(__FILE__) . 'css/style.css');
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css', array(), '6.0.0-beta3');
}
add_action('wp_enqueue_scripts', 'mp_enqueue_assets');

// Load templates from plugin
function mp_template_redirect($template)
{
    if (is_post_type_archive('profile') || is_singular('profile')) {
        $file_name = is_post_type_archive('profile') ? 'index-profile' : 'single-profile';
        $plugin_template = plugin_dir_path(__FILE__) . "templates/{$file_name}.php";
        if (file_exists($plugin_template)) {
            return $plugin_template;
        }
    }

    return $template;
}
add_filter('template_include', 'mp_template_redirect');

// Add meta boxes for profiles
function mp_add_meta_boxes()
{
    add_meta_box('profile_meta_box', __('Profile Settings', 'textdomain'), 'mp_display_meta_box', 'profile', 'side', 'high');
}
add_action('add_meta_boxes', 'mp_add_meta_boxes');

function mp_display_meta_box($post)
{
    $is_featured = get_post_meta($post->ID, 'is_featured', true);
    $sub_heading = get_post_meta($post->ID, 'sub_heading', true);

    wp_nonce_field(basename(__FILE__), 'profile_nonce');
?>
    <p>
        <label for="is_featured"><?php _e('Is Featured:', 'textdomain'); ?></label>
        <select name="is_featured" id="is_featured">
            <option value="1" <?php selected($is_featured, '1'); ?>><?php _e('Yes', 'textdomain'); ?></option>
            <option value="0" <?php selected($is_featured, '0'); ?>><?php _e('No', 'textdomain'); ?></option>
        </select>
    </p>
    <p>
        <label for="sub_heading"><?php _e('Sub Heading', 'textdomain'); ?></label>
        <input type="text" name="sub_heading" id="sub_heading" value="<?php echo esc_attr($sub_heading); ?>">
    </p>
<?php
}

function mp_save_meta_box_data($post_id)
{
    if (!isset($_POST['profile_nonce']) || !wp_verify_nonce($_POST['profile_nonce'], basename(__FILE__)) || wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) {
        return $post_id;
    }

    $new_is_featured_value = (isset($_POST['is_featured']) ? sanitize_text_field($_POST['is_featured']) : '');
    update_post_meta($post_id, 'is_featured', $new_is_featured_value);
    $new_sub_heading_value = (isset($_POST['sub_heading']) ? sanitize_text_field($_POST['sub_heading']) : '');
    update_post_meta($post_id, 'sub_heading', $new_sub_heading_value);
}
add_action('save_post', 'mp_save_meta_box_data');

// Shortcode to display profiles
function mp_profiles_shortcode($atts)
{
    ob_start();

    $args = array(
        'post_type'      => 'profile',
        'posts_per_page' => 10,
        'meta_query'     => array(
            array(
                'key'     => 'is_featured',
                'value'   => '1',
                'compare' => '!='
            )
        )
    );

    $query = new WP_Query($args);
    if ($query->have_posts()) {
        echo '<div class="profile-list">';
        while ($query->have_posts()) : $query->the_post();
            echo '<div class="profile-card">';
            echo '<div class="card-header"></div>';
            echo '<div class="fas-circle">';
            if (has_post_thumbnail()) {
                $featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                echo '<img  class="profile-img" src="' . esc_url($featured_img_url) . '" alt="' . esc_attr(get_the_title()) . '">';
            } else {
                echo '<img class="profile-img" src="' . plugins_url('images/default.png', __FILE__) . '">';
            }
            echo '</div>';
            echo '<div class="profile-info">';
            echo '<h3 class="profile-name">' . get_the_title() . '</h3>';
            echo '<p class="profile-role">' . esc_html(get_post_meta(get_the_ID(), 'sub_heading', true)) . '</p>';
            echo '</div>';
            echo '<a href="' . get_permalink() . '" class="view-profile-btn">PROFILE</a>';
            echo '</div>';
        endwhile;
        echo '</div>';
    } else {
        echo '<p>No profiles found.</p>';
    }

    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode('mp_profiles', 'mp_profiles_shortcode');
