<!-- profiles-display.php -->
<div class="profile-list">
    <?php 
	$args = array(
    'post_type'      => 'profile',
    'posts_per_page' => 10  // Customize as needed
);

$query = new WP_Query($args);
    $query = new WP_Query($args);
    if ($query->have_posts()) {
        while ($query->have_posts()) : $query->the_post();
            echo '<div class="profile-card">';
            echo '<div class="card-header" style="background-color: var(--ast-global-color-0, ' . esc_attr($default_color) . ');"></div>';
            echo '<div class="fas-circle">';
            if (has_post_thumbnail()) {
                $featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                echo '<img  class="profile-img" src="' . esc_url($featured_img_url) . '" alt="' . esc_attr(get_the_title()) . '">';
            } else {
                echo '<img class="profile-img" src="' . plugins_url( 'images/default.png', __FILE__ ) . '">';
            }
            echo '</div>';
            echo '<div class="profile-info">';
            echo '<h3 class="profile-name">' . get_the_title() . '</h3>';
            echo '<p class="profile-role">' . esc_html(get_post_meta(get_the_ID(), 'sub_heading', true)) . '</p>';
            echo '</div>';
            echo '<a href="' . get_permalink() . '" class="view-profile-btn" style="background-color: var(--ast-global-color-0, ' . esc_attr($default_color) . ');">PROFILE</a>';
            echo '</div>';
        endwhile;
        echo '</div>';
    } else {
        echo '<p>No profiles found.</p>';
    }
    wp_reset_postdata();
    ?>
</div>
